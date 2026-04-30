<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Mailer\Email;
use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log as CakeLog;
use Exception;
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class EmployeesController extends AppController {
/**
 * @var array
 */
	public $uses = array('User','PaymentSetup','Category','Product','Subscriber','Contact','Staff','NappUser','UserAnswer','Question','QuestionOption','QuestionSubmit','LabFile','LabAssign','Coupon','Permission','UserPermission','Department','CpdMailer','Conformance','LoginHistory','EoiMailer','Employee','CaseStudy', 'CaseImage', 'Product');
	public $components = array('Paginator');

	public function initialize(): void
	{
		parent::initialize();
		// CakePHP 3 does not support $uses; load legacy models explicitly.
		$this->loadModel('LoginHistory');
		$this->loadModel('Employee');
		$this->loadModel('Mailer');
		$this->loadModel('MailerComment');
		$this->loadModel('SpecUsearea');
		$this->loadModel('CaseStudy');
		$this->loadModel('CaseImage');
		$this->loadModel('Product');
	}

	public function beforeFilter(EventInterface $event): ?Response
    {
		$result = parent::beforeFilter($event);
		if ($result instanceof Response) {
			return $result;
		}
		// Legacy code uses $this->Session->read()/write().
		$this->Session = $this->request->getSession();
		$this->callConstants();
		return null;
	}

    public function login() 
    {
        $this->viewBuilder()->setLayout('admin_login');
        $this->set('title_for_layout', SITENAME . ' Employee Login');

        if ($this->Session->read('is_employee')) {
            return $this->redirect('/employees/monthly_specs');
        }

        if ($this->request->is('post')) {
            $name = (string)$this->request->getData('Employee.name');
            $password = md5((string)$this->request->getData('Employee.password'));

            $employee = $this->Employee->find()
                ->where([
                    'name' => $name,
                    'password' => $password,
                ])
                ->first();

            if (!empty($employee)) {
                if ((int)$employee->is_active === 0) {
                    $this->Flash->error('Your account is not active');
                } else {
                    $this->Session->write('Employee', $employee->toArray());
                    $this->Session->write('is_employee', 1);

                    $loginHistory = $this->LoginHistory->newEntity([
                        'user_id' => (int)$employee->id,
                        'role' => 'Employee',
                        'logintime' => date('Y-m-d H:i:s'),
                    ]);
                    $this->LoginHistory->save($loginHistory);

                    return $this->redirect($this->getAndClearEmployeeIntendedUrl());
                }
            } else {
                $this->Flash->error('Wrong username/password');
            }
        }
    }

    public function register()
    {
        $this->viewBuilder()->setLayout('admin_login');
        $this->set('title_for_layout', SITENAME . ' Employee Registration');

        if ($this->request->is('post')) {
            $employeeData = (array)$this->request->getData('Employee');
            if (empty($employeeData)) {
                $employeeData = (array)$this->request->getData('data.Employee');
            }
            if (empty($employeeData)) {
                $employeeData = (array)$this->request->getData('data.Employee');
            }
            $employeeData['password'] = md5((string)($employeeData['password'] ?? ''));
            $employeeData['is_active'] = 1;
            $employeeEntity = $this->Employee->newEntity($employeeData);

            if ($this->Employee->save($employeeEntity)) {
                $this->Flash->success('Employee registered successfully.');
                return $this->redirect('/employees/login');
            } else {
                $this->Flash->error('Unable to register employee.');
            }
        }
    }


	public function dashboard() {
		$this->viewBuilder()->setLayout('employee_layout');
		$this->set('title_for_layout',SITENAME.' Employee Dashboard Page');
		$this->checkEmployeeSession(); 
		
	}   

public function logout()
{
    $employeeId = $this->Session->read('Employee.id');

    $loginHistory = $this->LoginHistory->find()
        ->where([
            'logouttime' => '0000-00-00 00:00:00',
            'user_id' => $employeeId,
            'role' => 'Employee',
        ])
        ->orderDesc('id')
        ->first();

    if ($loginHistory) {
        $loginHistory = $this->LoginHistory->patchEntity($loginHistory, [
            'logouttime' => date('Y-m-d H:i:s'),
        ]);
        $this->LoginHistory->save($loginHistory);
    }

    $this->Session->destroy();
    return $this->redirect('/employees/login');
}

public function send_forgot_password()
{
    

    if ($this->request->is('post')) {
        $email = (string)$this->request->getData('Employee.email');
        $employee = $this->Employee->find()->where(['email' => $email])->first();

        if (!empty($employee)) {
            $employeeId = $employee->id;
            $encodedId = base64_encode(base64_encode(base64_encode($employeeId)));
            $url = SITEURL . 'employees/forgot_password/' . $encodedId;

            $to = (string)$employee->email;
            $subject = SITENAME . " :: Reset your password";

            $template_name = 'setpassword'; // Make sure this email template exists
            $variables = array(
                'url' => $url,
                'name' => (string)$employee->name,
                'email' => $email
            );

            try {
                $this->sendemail($to, $subject, $template_name, $variables);
            } catch (Exception $e) {
                // Optionally log the error
            }

            $this->Flash->success('Please check your email to set your new password.');
        } else {
            $this->Flash->error('The email entered is not found in employee records.');
        }

        return $this->redirect('/employees/login');
    }
}

public function forgot_password($usersId = null)
{
    $this->viewBuilder()->setLayout('employee_layout');

    $userId = base64_decode(base64_decode(base64_decode($usersId)));
    $employeeArr = $this->Employee->find()->where(['id' => $userId])->first();

    if (empty($employeeArr)) {
        $this->Flash->error('This employee does not exist. Please try again!');
        return $this->redirect('/employees/login');
    }

    if ($this->request->is('post')) {
        $password = (string)$this->request->getData('Employee.password');

        if (!empty($employeeArr)) {
            $employeeArr = $this->Employee->patchEntity($employeeArr, ['password' => md5($password)]);
            $this->Employee->save($employeeArr);

            $to = (string)$employeeArr->email;
            $subject = SITENAME . " :: Your password changed successfully.";

            $template_name = 'message'; // Make sure this template handles 'forgot' type properly
            $variables = array(
                'password' => $password,
                'name' => (string)$employeeArr->name,
                'email' => (string)$employeeArr->email,
                'type' => 'forgot'
            );

            try {
                $this->sendemail($to, $subject, $template_name, $variables);
            } catch (Exception $e) {
                // Optional: log the error
            }

            $this->Flash->success('Password reset successfully.');
        } else {
            $this->Flash->error('The email entered is not found. Please, try again.');
        }

        return $this->redirect('/employees/login');
    }

    // Pass data to view if needed
    $this->set('employee', $employeeArr);
}

public function change_password()
{
    // debug($this->request->data);

    $this->viewBuilder()->setLayout('employee_layout');
    $this->set('title_for_layout', SITENAME . ' Change Password Page');
    $this->checkEmployeeSession();

    if ($this->request->is('post')) {
        $employee_id = $this->Session->read('Employee.id');
        $employee = $this->Employee->find()->where(['id' => $employee_id])->first();

        if (!empty($employee)) {
            $currentPassword = md5((string)$this->request->getData('Employee.current_password'));
            $newPassword = (string)$this->request->getData('Employee.new_password');
            $confirmPassword = (string)$this->request->getData('Employee.confirm_password');

            if ($newPassword === $confirmPassword) {
                if ((string)$employee->password === $currentPassword) {
                    $employee = $this->Employee->patchEntity($employee, ['password' => md5($newPassword)]);
                    $this->Employee->save($employee);
                    $this->Flash->success('Your password has been changed successfully.');
                } else {
                    $this->Flash->error('Current password is incorrect. Please try again.');
                }
            } else {
                $this->Flash->error('New password and confirm password do not match. Please try again.');
            }
        } else {
            $this->Flash->error('Employee record not found. Please try again.');
        }
    }
}

/** CamelCase alias for URL employees/change_password -> changePassword() */
public function changePassword()
{
    return $this->change_password();
}

public function profile()
{
    $this->viewBuilder()->setLayout('employee_layout');
    $this->set('title_for_layout', SITENAME . ' Profile Page');
    $this->checkEmployeeSession();

    $employee_id = $this->Session->read('Employee.id');
    $employee = $this->Employee->find()->where(['id' => $employee_id])->first();
    if ($this->request->is(['post', 'put'])) {
        if (!empty($employee)) {
            $updated = $this->Employee->patchEntity($employee, (array)$this->request->getData('Employee'));
            if ($this->Employee->save($updated)) {
                $this->Flash->success('Your profile has been updated');
                return $this->redirect(['action' => 'profile']);
            } else {
                $this->Flash->error('Your profile has not been updated');
            }
        }
    }

    $this->set('employee', $employee);
}

public function index()
{
    $this->viewBuilder()->setLayout('employee_layout');
    $this->set('title_for_layout', SITENAME . ' DuroEzy Specification Employee');

    $this->checkEmployeeSession();

    $employee_id = $this->Session->read('Employee.id');

    $this->loadModel('Mailer');
    $query = $this->Mailer->find()
        ->where([
            // 'Mailer.spec_v' => 0,
            'Mailer.employee_id' => $employee_id,
            // Specs only
            'Mailer.type' => 3,
        ])
        ->contain(['Employee'])
        ->orderDesc('Mailer.id');

    $filters = [
        'tracknumber' => trim((string)$this->request->getQuery('tracknumber')),
        'name' => trim((string)$this->request->getQuery('name')),
        'email' => trim((string)$this->request->getQuery('email')),
        'company' => trim((string)$this->request->getQuery('company')),
        'specification' => trim((string)$this->request->getQuery('specification')),
        'date_from' => trim((string)$this->request->getQuery('date_from')),
        'date_to' => trim((string)$this->request->getQuery('date_to')),
    ];

    if ($filters['tracknumber'] !== '') {
        $query->andWhere(['Mailer.tracknumber LIKE' => '%' . $filters['tracknumber'] . '%']);
    }
    if ($filters['name'] !== '') {
        $query->andWhere(['Mailer.name LIKE' => '%' . $filters['name'] . '%']);
    }
    if ($filters['email'] !== '') {
        $query->andWhere(['Mailer.email LIKE' => '%' . $filters['email'] . '%']);
    }
    if ($filters['company'] !== '') {
        $query->andWhere(['Mailer.company LIKE' => '%' . $filters['company'] . '%']);
    }
    if ($filters['specification'] !== '') {
        $query->andWhere(['Mailer.specification LIKE' => '%' . $filters['specification'] . '%']);
    }
    if ($filters['date_from'] !== '') {
        $query->andWhere(['Mailer.date >=' => $filters['date_from']]);
    }
    if ($filters['date_to'] !== '') {
        $query->andWhere(['Mailer.date <=' => $filters['date_to']]);
    }

    // Exclude drafts from list so only submitted specs show (no duplicate-looking rows)
    if ($this->Mailer->getSchema()->getColumn('save_status')) {
        $query->andWhere([
            'OR' => [
                ['Mailer.save_status' => 'submitted'],
                ['Mailer.save_status IS' => null],
            ],
        ]);
    }

    $mailers = $this->paginate($query, [
        'limit' => 20,
    ]);

    // Check if employee has a draft so we can show "Resume Draft" vs "Create New Spec"
    $hasDraft = false;
    if ($this->Mailer->getSchema()->getColumn('save_status')) {
        $hasDraft = $this->Mailer->exists([
            'Mailer.employee_id' => $employee_id,
            'Mailer.save_status' => 'draft',
            'Mailer.type' => 3,
        ]);
    }

    $this->set(compact('mailers', 'hasDraft', 'filters'));
}

public function audit_log($id = null)
{
    $this->viewBuilder()->setLayout('employee_layout');
    $this->set('title_for_layout', SITENAME . ' Spec Audit Trail');
    $this->checkEmployeeSession();

    $employee_id = (int)$this->Session->read('Employee.id');
    $id = (int)$id;
    if ($id <= 0) {
        $this->Flash->error('Invalid spec id.');
        return $this->redirect(['action' => 'index']);
    }

    $this->loadModel('Mailer');
    $mailer = $this->Mailer->find()
        ->where([
            'Mailer.id' => $id,
            'Mailer.employee_id' => $employee_id,
            'Mailer.type' => 3,
        ])
        ->first();
    if (!$mailer) {
        $this->Flash->error('Spec not found.');
        return $this->redirect(['action' => 'index']);
    }

    $this->loadModel('SpecAuditLogs');
    $rows = $this->SpecAuditLogs->find()
        ->where(['mailer_id' => $id])
        ->orderDesc('id')
        ->all()
        ->toArray();

    $this->set(compact('mailer', 'rows'));
}

public function auditLog($id = null)
{
    return $this->audit_log($id);
}





public function employee_send_v3() {
    $this->viewBuilder()->setLayout('employee_layout');
    $this->set('title_for_layout', SITENAME . ' DuroEzy Specification Mailer');
    $this->checkEmployeeSession(); 
    $this->loadModel('Mailer'); // ✅ Required to use Mailer in this controller
    $this->loadModel('MailerComment');
    $this->loadModel('SpecUsearea');



    $employee_id = $this->Session->read('Employee.id');

    if ($this->request->is('post')) {
        $formData = (array)$this->request->getData();
        if (empty($formData) && !empty($this->request->data)) {
            $formData = (array)$this->request->data;
        }

        $isFinalSubmit = !empty($formData['submit_spec']) && $formData['submit_spec'] === '1';
        $draftIdFromForm = isset($formData['draft_id']) ? (int)$formData['draft_id'] : 0;
        $hasSaveStatusColumn = $this->Mailer->getSchema()->getColumn('save_status');

        // If final submit with valid draft: update that record to submitted (no duplicate)
        if ($isFinalSubmit && $draftIdFromForm > 0 && $hasSaveStatusColumn) {
            $existing = $this->Mailer->get($draftIdFromForm);
            if ($existing && (int)$existing->employee_id === (int)$employee_id && $existing->save_status === 'draft') {
                $this->_saveEmployeeSpecAsSubmitted($draftIdFromForm, $formData, $employee_id);
                $this->Flash->success('Spec generated successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }

        // When creating a new submitted spec, remove any leftover draft for this employee so we don't get two entries
        if ($hasSaveStatusColumn && $isFinalSubmit) {
            $draftIds = $this->Mailer->find()
                ->where([
                    'Mailer.employee_id' => $employee_id,
                    'Mailer.save_status' => 'draft',
                    'Mailer.type' => 3,
                ])
                ->all()
                ->extract('id')
                ->toArray();
            if (!empty($draftIds)) {
                $this->MailerComment->deleteAll(['mailer_id IN' => $draftIds]);
                $this->SpecUsearea->deleteAll(['mailer_id IN' => $draftIds]);
                $this->Mailer->deleteAll(['id IN' => $draftIds]);
            }
        }

        $uploadPath = WWW_ROOT . 'uploads' . DS . 'datasheets' . DS;
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $file = (array)$this->request->getData('datasheet_pdf');
        if (!empty($file['tmp_name'])) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file['name']);
            $fullPath = $uploadPath . $filename;
            move_uploaded_file($file['tmp_name'], $fullPath);
            $inserty['Mailer']['pdf_attachment'] = 'uploads/datasheets/' . $filename;
        }

            $dateInput = (string)($formData['date'] ?? date('d/m/Y'));
            $dateParts = explode('/', $dateInput);
            if (count($dateParts) === 3) {
                list($day, $month, $year) = $dateParts;
            } else {
                $day = date('d');
                $month = date('m');
                $year = date('Y');
            }
            $formattedDate = "$year-$month-$day";


        // Collect form fields (new spec) – assign next track at submit (drafts excluded)
        $inserty['Mailer'] = array(
            'employee_id'   => $employee_id,
            'spec_v'        => 0,
            'tracknumber'   => $this->Mailer->getNextSpecTrackNumber(),
            'name'          => $formData['name'] ?? '',
            'email'         => $formData['email'] ?? '',
            'company'       => $formData['company'] ?? '',
            'address'       => $formData['address'] ?? '',
            'specification' => $formData['specification'] ?? '',
            'date'          => $formattedDate,
            'type'          => $formData['type'] ?? 3,
            'subject'       => $formData['subject'] ?? '',
            'use_area'      => isset($formData['use_area']) ? $formData['use_area'] : 1,
            'created'       => date('Y-m-d H:i:s'),
        );
        if ($hasSaveStatusColumn) {
            $inserty['Mailer']['save_status'] = 'submitted';
        }

        $mailerPayload = $inserty['Mailer'];
        $mailerEntity = $this->Mailer->newEntity($mailerPayload);
        if ($savedMailer = $this->Mailer->save($mailerEntity)) {
            $lastinsertId = (int)$savedMailer->id;

            if (!empty($formData['comment'])) {
                foreach ((array)$formData['comment'] as $comment) {
                    $MailerCommentinsert = array(
                        'mailer_id' => $lastinsertId,
                        'use_area'  => 1,
                        'comment'   => $comment
                    );
                    $commentEntity = $this->MailerComment->newEntity($MailerCommentinsert);
                    $this->MailerComment->save($commentEntity);
                }
            }

            if (!empty($formData['product'])) {
                foreach ((array)$formData['product'] as $key => $prodt) {
                    $title = isset($formData['title'][$formData['types'][$key]]) 
                        ? $formData['title'][$formData['types'][$key]] 
                        : '';
                    $insert = array(
                        'mailer_id'        => $lastinsertId,
                        'use_area'         => 1,
                        'title'            => $title,
                        'product'          => $prodt,
                        'types'            => $formData['types'][$key] ?? '',
                        'serial'           => $formData['serial'][$key] ?? '',
                        'coverage'         => $formData['coverage'][$key] ?? '',
                        'Warranty'         => $formData['Warranty'][$key] ?? '',
                        'coverage_by_pack' => $formData['coverage_by_pack'][$key] ?? '',
                    );
                    $specEntity = $this->SpecUsearea->newEntity($insert);
                    $this->SpecUsearea->save($specEntity);
                }
            }

            $pdfname = $lastinsertId . '-' . $inserty['Mailer']['tracknumber'];

              $fields = [
                'tracknumber'   => $inserty['Mailer']['tracknumber'],
                'mailer_id'     => $lastinsertId,
                'name'          => $inserty['Mailer']['name'],
                'email'         => $inserty['Mailer']['email'],
                'address'       => $inserty['Mailer']['address'],
                'company'       => $inserty['Mailer']['company'],
                'specification' => $inserty['Mailer']['specification'],
                'date'          => $formData['date'] ?? '',
                'subject'       => $inserty['Mailer']['subject'],
                'type'          => $inserty['Mailer']['type'],
                'pdfname'       => $pdfname,
                'use_area'      => $inserty['Mailer']['use_area']
            ];

           
            $fields_string = http_build_query($fields);

            $url = (($formData['spectype'] ?? 1) == 1)
                ? SITEURL . 'dompdf/generatepdf.php?' . $fields_string
                : SITEURL . 'dompdf/generatewithoutpdf.php?' . $fields_string;

            $arrContextOptions = array("ssl" => array("verify_peer" => false, "verify_peer_name" => false));
            $pdfResponse = @file_get_contents($url, false, stream_context_create($arrContextOptions));

            // generatepdf.php returns JSON with sanitized filename/path.
            $generatedPdfFileName = $pdfname . '.pdf';
            if ($pdfResponse !== false) {
                $json = json_decode($pdfResponse, true);
                if (is_array($json) && !empty($json['filename'])) {
                    $generatedPdfFileName = (string)$json['filename'];
                }
            }
            $pdfPath = 'dompdf/' . $generatedPdfFileName;
            $savedMailer->pdf_attachment = $pdfPath;
            $this->Mailer->save($savedMailer);
            $this->logSpecAudit([
                'mailer_id' => $lastinsertId,
                'tracknumber' => (string)$savedMailer->tracknumber,
                'action' => 'spec_created',
                'actor_role' => 'employee',
                'actor_id' => (int)$employee_id,
                'source' => 'employee_panel',
                'message' => 'Employee created new spec.',
                'meta' => [
                    'specification' => (string)($inserty['Mailer']['specification'] ?? ''),
                    'company' => (string)($inserty['Mailer']['company'] ?? ''),
                ],
            ]);


            // ===== SEND EMAIL WITH SPEC PDF ATTACHED (non-blocking: spec/PDF already saved) =====

            $pdfFilePath = WWW_ROOT . 'dompdf' . DS . $generatedPdfFileName;

            if (file_exists($pdfFilePath)) {
                try {
                    $email = new Email('default');

                    $emailConfig = (array)Configure::read('SpecEmail');
                    $email->setFrom((array)($emailConfig['from'] ?? ['no-reply@durotechindustries.com.au' => 'Durotech Industries']));
					$email->setTo((array)($emailConfig['to'] ?? ['kal@durotechindustries.com.au']))
							->setCc((array)($emailConfig['cc'] ?? ['info@durotechindustries.com.au']))
							->setBcc((array)($emailConfig['bcc'] ?? ['sales@durotechindustries.com.au']));

                    $email->setSubject(
                        'New Spec Created – ' . $inserty['Mailer']['tracknumber']
                    );

                    $email->setEmailFormat('html');

                    $email->setAttachments([
                        $generatedPdfFileName => [
                            'file' => $pdfFilePath,
                            'mimetype' => 'application/pdf'
                        ]
                    ]);
                    // Use a branded HTML template instead of plain inline HTML.
                    $email->viewBuilder()
                        ->setClassName('App\View\AppView')
                        ->setTemplate('new_sendeasyspec');

                    $createdBy = trim(
                        (string)$this->request->getSession()->read('Employee.name') . ' ' .
                        (string)$this->request->getSession()->read('Employee.lname')
                    );

                    $email->setViewVars([
                        'name' => (string)($inserty['Mailer']['name'] ?? ''),
                        'address' => (string)($inserty['Mailer']['address'] ?? ''),
                        'company' => (string)($inserty['Mailer']['company'] ?? ''),
                        'specification' => (string)($inserty['Mailer']['specification'] ?? ''),
                        'tracknumber' => (string)($inserty['Mailer']['tracknumber'] ?? ''),
                        'date' => (string)($formData['date'] ?? ''),
                        'revision' => '',
                        'created_by' => $createdBy,
                        'pdf_attachment' => 'dompdf/' . (string)$generatedPdfFileName,
                    ]);

                    $email->send();
                } catch (\Exception $e) {
                    // SMTP timeout/connection errors must not block submission; spec and PDF are already saved.
                    CakeLog::error('Employee spec email failed (track: ' . ($inserty['Mailer']['tracknumber'] ?? '') . '): ' . $e->getMessage());
                }
            }


            $this->Flash->success('Spec generated successfully.');
            return $this->redirect(array('action' => 'index'));
        }
    }

    // Next track number (only submitted specs – drafts excluded; autosave/resume don't break sequence)
    $refernce = $this->Mailer->getNextSpecTrackNumber();

    // Load draft when user chose "Resume Draft" (?resume=1)
    $draft = null;
    $draftId = null;
    $resumeDraft = $this->request->getQuery('resume') && $this->Mailer->getSchema()->getColumn('save_status');
    if ($resumeDraft) {
        $draft = $this->Mailer->find()
            ->where(['Mailer.employee_id' => $employee_id, 'Mailer.save_status' => 'draft', 'Mailer.type' => 3])
            ->orderDesc('Mailer.id')
            ->first();
        if ($draft) {
            $draftId = $draft->id;
            $draft->comments = $this->MailerComment->find()->where(['mailer_id' => $draftId])->all();
            $draft->spec_useareas = $this->SpecUsearea->find()->where(['mailer_id' => $draftId])->orderAsc('id')->all();
        }
    }
    $this->set(compact('refernce', 'draft', 'draftId'));
}

/**
 * Save an existing draft mailer as submitted: set tracknumber, status, comments/spec_useareas, PDF, email.
 */
protected function _saveEmployeeSpecAsSubmitted(int $mailerId, array $formData, $employee_id): void
{
    $mailer = $this->Mailer->get($mailerId);
    $tracknumber = $this->Mailer->getNextSpecTrackNumber();

    $dateInput = (string)($formData['date'] ?? date('d/m/Y'));
    $dateParts = explode('/', $dateInput);
    $formattedDate = count($dateParts) === 3
        ? $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0]
        : date('Y-m-d');

    $mailer->tracknumber = $tracknumber;
    $mailer->spec_v = 0;
    $mailer->name = $formData['name'] ?? '';
    $mailer->email = $formData['email'] ?? '';
    $mailer->company = $formData['company'] ?? '';
    $mailer->address = $formData['address'] ?? '';
    $mailer->specification = $formData['specification'] ?? '';
    $mailer->date = $formattedDate;
    $mailer->type = $formData['type'] ?? 3;
    $mailer->subject = $formData['subject'] ?? '';
    $mailer->use_area = $formData['use_area'] ?? 1;
    $mailer->save_status = 'submitted';

    if (!empty($formData['datasheet_pdf']['tmp_name'])) {
        $uploadPath = WWW_ROOT . 'uploads' . DS . 'datasheets' . DS;
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        $file = (array)$formData['datasheet_pdf'];
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file['name']);
        $fullPath = $uploadPath . $filename;
        move_uploaded_file($file['tmp_name'], $fullPath);
        $mailer->pdf_attachment = 'uploads/datasheets/' . $filename;
    }
    $this->Mailer->save($mailer);

    $this->MailerComment->deleteAll(['mailer_id' => $mailerId]);
    $this->SpecUsearea->deleteAll(['mailer_id' => $mailerId]);

    if (!empty($formData['comment']) && is_array($formData['comment'])) {
        foreach ($formData['comment'] as $comment) {
            $commentEntity = $this->MailerComment->newEntity([
                'mailer_id' => $mailerId,
                'use_area' => 1,
                'comment' => $comment,
            ]);
            $this->MailerComment->save($commentEntity);
        }
    }
    if (!empty($formData['product']) && is_array($formData['product'])) {
        foreach ($formData['product'] as $key => $prodt) {
            $title = isset($formData['title'][$formData['types'][$key]]) ? $formData['title'][$formData['types'][$key]] : '';
            $specEntity = $this->SpecUsearea->newEntity([
                'mailer_id' => $mailerId,
                'use_area' => 1,
                'title' => $title,
                'product' => $prodt,
                'types' => $formData['types'][$key] ?? '',
                'serial' => $formData['serial'][$key] ?? '',
                'coverage' => $formData['coverage'][$key] ?? '',
                'Warranty' => $formData['Warranty'][$key] ?? '',
                'coverage_by_pack' => $formData['coverage_by_pack'][$key] ?? '',
            ]);
            $this->SpecUsearea->save($specEntity);
        }
    }

    $pdfname = $mailerId . '-' . $tracknumber;
    $fields = [
        'tracknumber' => $tracknumber,
        'mailer_id' => $mailerId,
        'name' => $mailer->name,
        'email' => $mailer->email,
        'address' => $mailer->address,
        'company' => $mailer->company,
        'specification' => $mailer->specification,
        'date' => $formData['date'] ?? '',
        'subject' => $mailer->subject,
        'type' => $mailer->type,
        'pdfname' => $pdfname,
        'use_area' => $mailer->use_area,
    ];
    $fields_string = http_build_query($fields);
    $url = ((int)($formData['spectype'] ?? 1) === 1)
        ? SITEURL . 'dompdf/generatepdf.php?' . $fields_string
        : SITEURL . 'dompdf/generatewithoutpdf.php?' . $fields_string;
    $arrContextOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]];
    $pdfResponse = @file_get_contents($url, false, stream_context_create($arrContextOptions));

    $generatedPdfFileName = $pdfname . '.pdf';
    if ($pdfResponse !== false) {
        $json = json_decode($pdfResponse, true);
        if (is_array($json) && !empty($json['filename'])) {
            $generatedPdfFileName = (string)$json['filename'];
        }
    }
    $pdfFilePath = WWW_ROOT . 'dompdf' . DS . $generatedPdfFileName;
    if (file_exists($pdfFilePath)) {
        $email = new Email('default');
        $email->setFrom(['deepaksaini10036@gmail.com' => 'Durotech Industries']);
        $email->setTo('deepaksaini10036@gmail.com');
        $email->setSubject('New Spec Created – ' . $tracknumber);
        $email->setEmailFormat('html');
        $email->setAttachments([
            $generatedPdfFileName => ['file' => $pdfFilePath, 'mimetype' => 'application/pdf'],
        ]);
        // Use the branded HTML template (logo + UI).
        $email->viewBuilder()
            ->setClassName('App\View\AppView')
            ->setTemplate('new_sendeasyspec');

        $email->setViewVars([
            'name' => (string)($mailer->name ?? ''),
            'address' => (string)($mailer->address ?? ''),
            'company' => (string)($mailer->company ?? ''),
            'specification' => (string)($mailer->specification ?? ''),
            'tracknumber' => (string)$tracknumber,
            'date' => (string)($formData['date'] ?? ($mailer->date ?? '')),
            'revision' => '',
            'pdf_attachment' => 'dompdf/' . (string)$generatedPdfFileName,
        ]);

        $email->send();
    }
    $this->logSpecAudit([
        'mailer_id' => $mailerId,
        'tracknumber' => (string)$tracknumber,
        'action' => 'draft_submitted',
        'actor_role' => 'employee',
        'actor_id' => (int)$employee_id,
        'source' => 'employee_panel',
        'message' => 'Employee resumed and submitted draft spec.',
    ]);
}

/**
 * AJAX: Auto-save spec form as draft. Creates or updates one draft (no duplicate).
 * Expects POST with form fields and optional draft_id.
 */
public function specDraftAutosave()
{
    $this->request->allowMethod(['post']);
    $this->viewBuilder()->setLayout(false);
    $this->viewBuilder()->disableAutoLayout();
    $this->viewBuilder()->setClassName('Cake\View\View');

    $this->checkEmployeeSession();
    $this->loadModel('Mailer');
    $this->loadModel('MailerComment');
    $this->loadModel('SpecUsearea');

    $employee_id = $this->request->getSession()->read('Employee.id');

    $hasSaveStatusColumn = $this->Mailer->getSchema()->getColumn('save_status');
    if (!$hasSaveStatusColumn) {
        return $this->_specDraftJsonResponse(['success' => false, 'error' => 'Draft not configured.']);
    }

    $data = $this->request->getData();
    $draftIdFromForm = isset($data['draft_id']) ? (int)$data['draft_id'] : 0;

    $mailer = null;
    if ($draftIdFromForm > 0) {
        $mailer = $this->Mailer->get($draftIdFromForm);
        if (!$mailer || (int)$mailer->employee_id !== (int)$employee_id || $mailer->save_status !== 'draft') {
            $mailer = null;
        }
    }

    $dateInput = (string)($data['date'] ?? date('d/m/Y'));
    $dateParts = explode('/', $dateInput);
    $formattedDate = count($dateParts) === 3
        ? $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0]
        : date('Y-m-d');

    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $company = $data['company'] ?? '';
    $address = $data['address'] ?? '';
    $specification = $data['specification'] ?? '';
    $type = $data['type'] ?? 3;
    $subject = $data['subject'] ?? '';
    $use_area = $data['use_area'] ?? 1;

    if ($mailer) {
        $mailer->name = $name;
        $mailer->email = $email;
        $mailer->company = $company;
        $mailer->address = $address;
        $mailer->specification = $specification;
        $mailer->date = $formattedDate;
        $mailer->type = $type;
        $mailer->subject = $subject;
        $mailer->use_area = $use_area;
        $this->Mailer->save($mailer);
        $draftId = $mailer->id;
    } else {
        $entity = $this->Mailer->newEntity([
            'employee_id' => $employee_id,
            'spec_v' => 0,
            'tracknumber' => '',
            'name' => $name,
            'email' => $email,
            'company' => $company,
            'address' => $address,
            'specification' => $specification,
            'date' => $formattedDate,
            'type' => $type,
            'subject' => $subject,
            'use_area' => $use_area,
            'save_status' => 'draft',
            'created' => date('Y-m-d H:i:s'),
        ]);
        if ($this->Mailer->save($entity)) {
            $draftId = $entity->id;
        } else {
            return $this->_specDraftJsonResponse(['success' => false, 'error' => 'Save failed.']);
        }
    }

    $this->MailerComment->deleteAll(['mailer_id' => $draftId]);
    $this->SpecUsearea->deleteAll(['mailer_id' => $draftId]);

    if (!empty($data['comment']) && is_array($data['comment'])) {
        foreach ($data['comment'] as $comment) {
            $commentEntity = $this->MailerComment->newEntity([
                'mailer_id' => $draftId,
                'use_area' => 1,
                'comment' => $comment,
            ]);
            $this->MailerComment->save($commentEntity);
        }
    }
    if (!empty($data['product']) && is_array($data['product'])) {
        foreach ($data['product'] as $key => $prodt) {
            $typesKey = $data['types'][$key] ?? null;
            $title = isset($data['title'][$typesKey]) ? $data['title'][$typesKey] : '';
            $specEntity = $this->SpecUsearea->newEntity([
                'mailer_id' => $draftId,
                'use_area' => 1,
                'title' => $title,
                'product' => $prodt,
                'types' => $data['types'][$key] ?? '',
                'serial' => $data['serial'][$key] ?? '',
                'coverage' => $data['coverage'][$key] ?? '',
                'Warranty' => $data['Warranty'][$key] ?? '',
                'coverage_by_pack' => $data['coverage_by_pack'][$key] ?? '',
            ]);
            $this->SpecUsearea->save($specEntity);
        }
    }

    return $this->_specDraftJsonResponse(['success' => true, 'draft_id' => (int)$draftId]);
}

/**
 * Return JSON response for spec draft autosave (no template needed).
 */
protected function _specDraftJsonResponse(array $data)
{
    $this->response = $this->response->withType('application/json')
        ->withStringBody(json_encode($data));
    return $this->response;
}

/**
 * CakePHP 3 action name compatibility for legacy employee_send_v3().
 */
public function employeeSendV3() {
    return $this->employee_send_v3();
}

/**
 * Delete a spec. Employee can only delete their own spec.
 */
public function deleteSpec($id = null)
{
    $this->request->allowMethod(['post', 'delete']);
    $this->checkEmployeeSession();

    $employee_id = $this->Session->read('Employee.id');
    $this->loadModel('Mailer');
    $this->loadModel('MailerComment');
    $this->loadModel('SpecUsearea');

    $mailer = $this->Mailer->get($id);
    if (!$mailer || (int)$mailer->employee_id !== (int)$employee_id) {
        $this->Flash->error('Spec not found or you cannot delete it.');
        return $this->redirect(['action' => 'index']);
    }

    $this->MailerComment->deleteAll(['mailer_id' => $id]);
    $this->SpecUsearea->deleteAll(['mailer_id' => $id]);
    $this->Mailer->delete($mailer);
    $this->logSpecAudit([
        'mailer_id' => (int)$id,
        'tracknumber' => (string)($mailer->tracknumber ?? ''),
        'action' => 'spec_deleted',
        'actor_role' => 'employee',
        'actor_id' => (int)$employee_id,
        'source' => 'employee_panel',
        'message' => 'Employee deleted spec.',
    ]);

    $this->Flash->success('Spec deleted.');
    return $this->redirect(['action' => 'index']);
}

public function editsend_v3($id = null) {
   
    $this->viewBuilder()->setLayout('employee_layout');
    $this->set('title_for_layout', SITENAME . ' DuroEzy Specification Mailer');
    $this->checkEmployeeSession(); 

    $this->loadModel('Mailer');
    $this->loadModel('MailerComment');
    $this->loadModel('SpecUsearea');

    $employee_id = $this->Session->read('Employee.id');
    $returnPage = max(1, (int)($this->request->getQuery('page') ?? 1));

    if (!empty($this->request->data)) {
        $returnPage = isset($this->request->data['return_page']) ? max(1, (int)$this->request->data['return_page']) : $returnPage;
        $form_type = $this->request->data['form_type'];

        $exp = explode('/', $this->request->data['date']);
        $date = (count($exp) == 3) ? $exp[2] . '-' . $exp[1] . '-' . $exp[0] : $this->request->data['date'];

        $tracknumber = ($form_type == 0) ? $this->request->data['tracknumber'] : '';
        if ($form_type != 0) {
            $mailerid = $this->Mailer->find()
                ->where(['type' => 3])
                ->count();
            $newid = $mailerid + 1;
            $yr = date('y');
            $mm = date('m');
            $code = str_pad($newid, 3, '0', STR_PAD_LEFT);
            $tracknumber = 'DTSPEC ' . $yr . '-' . $mm . '-' . $code;
        }
        // Revision column is optional in some migrated databases.
        $hasRevisionColumn = $this->Mailer->getSchema()->hasColumn('revision');
        $revision = 1;
        if ($hasRevisionColumn && $form_type == 0 && $id != null) {
            $old = $this->Mailer->find()
                ->select(['revision'])
                ->where(['id' => (int)$id])
                ->enableHydration(false)
                ->first();
            if (!empty($old['revision'])) {
                $revision = (int)$old['revision'] + 1; // increment revision
            }
        }

        $inserty = [
            'Mailer' => [
                'id'            => $form_type == 0 ? $id : null,
                'employee_id'   => $employee_id,
                'name'          => $this->request->data['name'],
                'tracknumber'   => $tracknumber,
                'address'       => $this->request->data['address'],
                'specification' => $this->request->data['specification'],
                'date'          => $date,
                'email'         => $this->request->data['email'],
                'company'       => $this->request->data['company'],
                'type'          => $this->request->data['type'],
                'subject'       => $this->request->data['subject'],
                'use_area'      => isset($this->request->data['use_area']) ? $this->request->data['use_area'] : 0,
                'created'       => date('Y-m-d H:i:s'),

            ]
        ];
        if ($hasRevisionColumn) {
            $inserty['Mailer']['revision'] = $revision;
        }

        // Handle file upload
        $uploadPath = WWW_ROOT . 'uploads' . DS . 'datasheets' . DS;
        if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);

        if (!empty($this->request->data['Mailer']['datasheet_pdf']['tmp_name'])) {
            $file = $this->request->data['Mailer']['datasheet_pdf'];

            $existing = $this->Mailer->find()
                ->select(['pdf_attachment'])
                ->where(['id' => (int)$id])
                ->enableHydration(false)
                ->first();
            if (!empty($existing['pdf_attachment'])) {
                $oldFile = WWW_ROOT . str_replace('/', DS, $existing['pdf_attachment']);
                if (file_exists($oldFile)) unlink($oldFile);
            }

            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file['name']);
            $fullPath = $uploadPath . $filename;

            if (move_uploaded_file($file['tmp_name'], $fullPath)) {
                $inserty['Mailer']['pdf_attachment'] = 'uploads/datasheets/' . $filename;
            } else {
                $this->Flash->error('Failed to upload file.');
                return $this->redirect(['action' => 'index_v3']);
            }
        }

        $mailerPayload = $inserty['Mailer'];
        if (!empty($mailerPayload['id'])) {
            $mailerEntity = $this->Mailer->get((int)$mailerPayload['id']);
            $mailerEntity = $this->Mailer->patchEntity($mailerEntity, $mailerPayload);
        } else {
            $mailerEntity = $this->Mailer->newEntity($mailerPayload);
        }

        if ($savedMailer = $this->Mailer->save($mailerEntity)) {
            $lastinsertId = (int)$savedMailer->id;

            // Delete old comments
            $this->MailerComment->deleteAll(['MailerComment.mailer_id' => $lastinsertId], false);
            if (!empty($this->request->data['comment'])) {
                foreach ($this->request->data['comment'] as $comment) {
                    $commentEntity = $this->MailerComment->newEntity([
                        'mailer_id' => $lastinsertId,
                        'use_area' => 1,
                        'comment' => $comment
                    ]);
                    $this->MailerComment->save($commentEntity);
                }
            }

            // Delete old product sections
            $this->SpecUsearea->deleteAll(['SpecUsearea.mailer_id' => $lastinsertId], false);
            if (!empty($this->request->data['product'])) {
                foreach ($this->request->data['product'] as $key => $prodt) {
                    $title = isset($this->request->data['title'][$this->request->data['types'][$key]]) ? $this->request->data['title'][$this->request->data['types'][$key]] : '';
                    $specEntity = $this->SpecUsearea->newEntity([
                        'mailer_id' => $lastinsertId,
                        'title' => $title,
                        'product' => $prodt,
                        'types' => $this->request->data['types'][$key],
                        'serial' => $this->request->data['serial'][$key],
                        'coverage' => $this->request->data['coverage'][$key],
                        'Warranty' => $this->request->data['Warranty'][$key],
                        'coverage_by_pack' => $this->request->data['coverage_by_pack'][$key]
                    ]);
                    $this->SpecUsearea->save($specEntity);
                }
            }

            // Generate PDF
            $pdfname = $lastinsertId . '-' . $tracknumber;

            $fields = [
                'tracknumber'   => $tracknumber,
                'mailer_id'     => $lastinsertId,
                'name'          => $inserty['Mailer']['name'],
                'email'         => $inserty['Mailer']['email'],
                'address'       => $inserty['Mailer']['address'],
                'company'       => $inserty['Mailer']['company'],
                'specification' => $inserty['Mailer']['specification'],
                'date'          => $this->request->data['date'],
                'subject'       => $inserty['Mailer']['subject'],
                'type'          => $inserty['Mailer']['type'],
                'pdfname'       => $pdfname,
                'use_area'      => $inserty['Mailer']['use_area'],

            ];
            if ($hasRevisionColumn) {
                $fields['revision'] = $revision;
            }

            $fields_string = http_build_query($fields);
            $pdf_url = ($this->request->data['spectype'] == 1) 
                ? SITEURL . 'dompdf/generatepdf.php?' . $fields_string 
                : SITEURL . 'dompdf/generatewithoutpdf.php?' . $fields_string;

            file_get_contents($pdf_url, false, stream_context_create(["ssl" => ["verify_peer" => false, "verify_peer_name" => false]]));

            // --- After generating PDF ---
            $pdfFilePath = WWW_ROOT . 'dompdf' . DS . $pdfname . '.pdf';

            // Check if PDF exists
            if (file_exists($pdfFilePath)) {
                $email = new Email('default');

                $emailConfig = (array)Configure::read('SpecEmail');
                $email->setFrom((array)($emailConfig['from'] ?? ['no-reply@durotechindustries.com.au' => 'Durotech Industries']));
                $email->setTo((array)($emailConfig['to'] ?? ['kal@durotechindustries.com.au']))
							->setCc((array)($emailConfig['cc'] ?? ['info@durotechindustries.com.au']))
							->setBcc((array)($emailConfig['bcc'] ?? ['sales@durotechindustries.com.au']));

                $email->setSubject('Specification Edited – ' . $inserty['Mailer']['tracknumber']);
                $email->setEmailFormat('html');

                // Attach the PDF
                $email->setAttachments([
                    $pdfname . '.pdf' => [
                        'file' => $pdfFilePath,
                        'mimetype' => 'application/pdf'
                    ]
                ]);
                // Use the branded HTML template (logo + UI).
                $email->viewBuilder()
                    ->setClassName('App\View\AppView')
                    ->setTemplate('new_sendeasyspec');

                $createdBy = trim(
                    (string)$this->request->getSession()->read('Employee.name') . ' ' .
                    (string)$this->request->getSession()->read('Employee.lname')
                );

                $email->setViewVars([
                    'name' => (string)($inserty['Mailer']['name'] ?? ''),
                    'address' => (string)($inserty['Mailer']['address'] ?? ''),
                    'company' => (string)($inserty['Mailer']['company'] ?? ''),
                    'specification' => (string)($inserty['Mailer']['specification'] ?? ''),
                    'tracknumber' => (string)($inserty['Mailer']['tracknumber'] ?? ''),
                    'date' => (string)($this->request->data['date'] ?? ''),
                    'revision' => $revision,
                    'created_by' => $createdBy,
                    'pdf_attachment' => 'dompdf/' . (string)$pdfname . '.pdf',
                ]);

                $email->send();
            }
            $this->logSpecAudit([
                'mailer_id' => $lastinsertId,
                'tracknumber' => (string)$tracknumber,
                'action' => 'spec_updated',
                'actor_role' => 'employee',
                'actor_id' => (int)$employee_id,
                'source' => 'employee_panel',
                'message' => ($form_type == 0) ? 'Employee edited existing spec.' : 'Employee created revised/new spec from edit screen.',
                'meta' => [
                    'form_type' => (int)$form_type,
                    'revision' => (int)$revision,
                ],
            ]);


            $this->Flash->success('PDF file updated successfully.');
            return $this->redirect(['action' => 'index', '?' => ['page' => max(1, $returnPage)]]);
        }
    }

    $MailerArr = $this->Mailer->find()
        ->where(['Mailer.id' => $id])
        ->contain(['MailerComment', 'SpecUsearea'])
        ->first();
    $product = [];
    if ($MailerArr) {
        $mailerData = method_exists($MailerArr, 'toArray') ? $MailerArr->toArray() : (array)$MailerArr;
        $specRows = $mailerData['spec_usearea'] ?? $mailerData['SpecUsearea'] ?? [];
        $commentRows = $mailerData['mailer_comment'] ?? $mailerData['MailerComment'] ?? [];
        foreach ((array)$specRows as $SpecUseareas) {
            $types = $SpecUseareas['types'] ?? '';
            $product[$types][] = $SpecUseareas;
        }
        // Keep CakePHP 2 style keys for legacy template compatibility.
        $MailerArr = [
            'Mailer' => $mailerData,
            'MailerComment' => (array)$commentRows,
            'SpecUsearea' => (array)$specRows,
        ];
    } else {
        $MailerArr = ['Mailer' => [], 'MailerComment' => [], 'SpecUsearea' => []];
    }

    $this->set('product', $product);
    $this->set('refernce', $MailerArr['Mailer']['tracknumber'] ?? '');
    $this->set('MailerArr', $MailerArr);
    $this->set('returnPage', max(1, $returnPage));
}

/**
 * CakePHP 3 action name compatibility for legacy editsend_v3().
 */
public function editsendV3($id = null) {
    return $this->editsend_v3($id);
}

    public function emp_sendemail($id = null) {
        $this->autoRender = false;

        $redirect = $this->checkEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $employee_id = (int)$this->Session->read('Employee.id');
        $id = (int)$id;

        $this->loadModel('Mailer');

        $mailer = $this->Mailer->find()
            ->where([
                'Mailer.id' => $id,
                'Mailer.employee_id' => $employee_id,
                'Mailer.type' => 3,
            ])
            ->first();

        if (empty($mailer)) {
            $this->Flash->error('Record not found.');
            return $this->redirect(['action' => 'index']);
        }

        $mailerId = (int)$mailer->id;
        $trackNo = (string)($mailer->tracknumber ?? '');
        $email = isset($mailer->email) ? trim((string)$mailer->email) : '';
        $subject = (string)($mailer->subject ?? 'Specification');
        $pdfname = base64_encode(base64_encode($mailerId . '-' . $trackNo . '.pdf'));

        $template_name = 'new_sendeasyspec';

        $variables = [
            'subject' => $subject,
            'pdf_attachment' => (string)($mailer->pdf_attachment ?? ''),
            'pdfname' => $pdfname,
            'name' => (string)($mailer->name ?? ''),
            'address' => (string)($mailer->address ?? ''),
            'company' => (string)($mailer->company ?? ''),
            'specification' => (string)($mailer->specification ?? ''),
            'email' => $email,
            'date' => (string)($mailer->date ?? ''),
        ];

        if ($email === '') {
            $this->Flash->error('Recipient email is missing for this record.');
            return $this->redirect(['action' => 'index']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->Flash->error('Invalid recipient email address for this record.');
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->sendemail($email, $subject, $template_name, $variables);
        } catch (Exception $e) {
            $this->Flash->error('Unable to send email right now.');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Mailer->getSchema()->getColumn('spec_email_sent_at')) {
            $mailer->spec_email_sent_at = date('Y-m-d H:i:s');
            if ($this->Mailer->getSchema()->getColumn('spec_email_sent_to')) {
                $mailer->spec_email_sent_to = $email;
            }
            $this->Mailer->save($mailer);
        }

        $this->logSpecAudit([
            'mailer_id' => $mailerId,
            'tracknumber' => $trackNo,
            'action' => 'spec_email_sent',
            'actor_role' => 'employee',
            'actor_id' => $employee_id,
            'source' => 'employee_panel',
            'message' => 'Employee sent spec email to customer.',
            'meta' => ['to' => $email],
        ]);

        $this->Flash->success('Email sent successfully');
        return $this->redirect(['action' => 'index']);
    }

    /**
     * CakePHP 3 action name compatibility for legacy emp_sendemail().
     */
    public function empSendemail($id = null) {
        return $this->emp_sendemail($id);
    }

    function download($id){
		
		$this->autoRender = false ;

		$id = base64_decode(base64_decode($id));		
		$url = SITEURL.'dompdf/'.$id;
		$this->redirect($url);
		/* $path = WWW_ROOT.'dompdf/'.$id;
		if (file_exists($path)) {
			header("Content-Disposition: attachment; filename=" . urlencode($path));  
			header('Content-Description: File Transfer');
			 header("Content-type: application/pdf");
			header('Content-Disposition: attachment; filename='.basename($path));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');	
			header('Content-Length: ' . filesize($path));
			ob_clean();
			flush();
			readfile($path);
			exit;
		}else{

		}	 */
	}


    /**
     * Case Studies list for logged-in employee (CakePHP 3).
     */
    public function case_studies() {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME . ' - ' : '') . 'Case Studies');
        $this->checkEmployeeSession();

        $employee_id = $this->Session->read('Employee.id');

        $query = $this->CaseStudy->find()
            ->orderDesc('CaseStudy.id');

        $hasCreatedBy = $this->CaseStudy->getSchema()->hasColumn('created_by');
        if ($hasCreatedBy) {
            $query->where(['CaseStudy.created_by' => $employee_id])
                ->contain(['Employee']);
        }

        $caseStudies = $this->paginate($query, ['limit' => 10]);
        $this->set(compact('caseStudies'));
    }

    /**
     * CakePHP 3 action name compatibility for case_studies().
     */
    public function caseStudies() {
        return $this->case_studies();
    }


    public function case_add() {
       
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', SITENAME . 'Case Detail Page');
        $this->checkEmployeeSession();
         $employeeId = $this->Session->read('Employee.id');


        if ($this->request->is('post')) {
            $data = (array)$this->request->getData('CaseStudy');
            if (empty($data)) {
                $data = (array)$this->request->getData();
            }
            if (empty($data) && $this->request->getData('data.CaseStudy')) {
                $data = (array)$this->request->getData('data.CaseStudy');
            }
            if ($this->CaseStudy->getSchema()->hasColumn('created_by')) {
                $data['created_by'] = $employeeId;
            }

            $featuredImage = $data['featured_image'] ?? $this->request->getData('CaseStudy.featured_image') ?? null;
            $datasheetFile = $data['datasheet_file'] ?? $this->request->getData('CaseStudy.datasheet_file') ?? null;
            unset($data['featured_image'], $data['datasheet_file']);

            // Checkbox: unchecked = not in POST, set default
            if (!array_key_exists('status', $data)) {
                $data['status'] = 0;
            } else {
                $data['status'] = !empty($data['status']) ? 1 : 0;
            }

            // Only pass columns that exist in the table to avoid SQL errors
            $schema = $this->CaseStudy->getSchema();
            $columns = $schema->columns();
            $data = array_intersect_key($data, array_flip($columns));

            $entity = $this->CaseStudy->newEntity($data);

            $saveException = null;
            try {
                $saved = $this->CaseStudy->save($entity);
            } catch (\Exception $e) {
                $saveException = $e;
                $saved = false;
            }

            if ($saved) {
                $caseId = (int)$saved->id;

                $this->request->data = ['CaseStudy' => array_merge($data, ['featured_image' => $featuredImage, 'datasheet_file' => $datasheetFile])];

                // ✅ Handle file uploads
                $this->_handleUploads($caseId);

                $caseData = $this->CaseStudy->find()
                    ->where(['CaseStudy.id' => $caseId])
                    ->enableHydration(false)
                    ->first();

                $this->_sendApprovalNotification(['CaseStudy' => $caseData ?: []]);

                $this->Flash->success('Case study saved');
                return $this->redirect(['action' => 'case_studies']);
            }

            if ($saveException) {
                $this->Flash->error('Save failed: ' . (Configure::read('debug') ? $saveException->getMessage() : 'Please check your data and try again.'));
            } else {
                $errors = $entity->getErrors();
                if (!empty($errors)) {
                    $messages = [];
                    foreach ($errors as $field => $fieldErrors) {
                        foreach ((array)$fieldErrors as $rule => $msg) {
                            $messages[] = is_string($msg) ? $msg : (is_array($msg) ? implode(', ', $msg) : (string)$msg);
                        }
                    }
                    $this->Flash->error('Save failed: ' . implode(' ', $messages));
                } else {
                    $this->Flash->error('Save failed. Please check required fields and try again.');
                }
            }
            $this->set('caseStudy', $entity);
        }

        $products = $this->Product->find('list', [
            'keyField' => 'id',
            'valueField' => 'title'
        ]);

        $this->set(compact('products'));
   }

    /** CakePHP 3 action alias. */
    public function caseAdd() {
        return $this->case_add();
    }

    /**
     * Get file array from $_FILES for nested name like data[CaseStudy][datasheet_file].
     * PHP puts these under $_FILES['data']['tmp_name']['CaseStudy']['datasheet_file'] etc.
     */
    protected function _getUploadedFile($base, $key1, $key2)
    {
        if (empty($_FILES[$base]['tmp_name'][$key1][$key2])) {
            return null;
        }
        $tmp = $_FILES[$base]['tmp_name'][$key1][$key2];
        if (!is_string($tmp) || !is_uploaded_file($tmp)) {
            return null;
        }
        return [
            'tmp_name' => $tmp,
            'name' => $_FILES[$base]['name'][$key1][$key2] ?? '',
            'error' => (int)($_FILES[$base]['error'][$key1][$key2] ?? UPLOAD_ERR_NO_FILE),
            'type' => $_FILES[$base]['type'][$key1][$key2] ?? '',
            'size' => (int)($_FILES[$base]['size'][$key1][$key2] ?? 0),
        ];
    }

    protected function _handleUploads($caseId) 
    {
        // Base upload directory
        $uploadDir = WWW_ROOT . 'files' . DS . 'case_studies' . DS . $caseId . DS;
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $caseData = $this->request->getData('CaseStudy') ?: $this->request->data['CaseStudy'] ?? [];
        if (empty($caseData) && !empty($this->request->data['CaseStudy'])) {
            $caseData = $this->request->data['CaseStudy'];
        }

        /* ------------------------------
        * 1. Handle Datasheet (PDF) - use $_FILES directly (nested file inputs may not be in getData)
        * ------------------------------ */
        $ds = $this->_getUploadedFile('data', 'CaseStudy', 'datasheet_file');
        if (!$ds && is_array($caseData['datasheet_file'] ?? null) && !empty(($caseData['datasheet_file']['tmp_name'] ?? ''))) {
            $ds = $caseData['datasheet_file'];
        }
        if (!$ds) {
            $ds = $this->request->data['CaseStudy']['datasheet_file'] ?? null;
        }
        if ($ds && is_array($ds) && !empty($ds['tmp_name']) && ($ds['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($ds['name'] ?? '', PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                $datasheetName = 'datasheet_' . time() . '.' . $ext;
                $dest = $uploadDir . $datasheetName;
                if (move_uploaded_file($ds['tmp_name'], $dest)) {
                    $ent = $this->CaseStudy->get($caseId);
                    $this->CaseStudy->patchEntity($ent, ['datasheet' => 'files/case_studies/' . $caseId . '/' . $datasheetName]);
                    $this->CaseStudy->save($ent);
                }
            }
        }

        /* ------------------------------
        * 2. Handle Featured Image - use $_FILES directly
        * ------------------------------ */
        $fi = $this->_getUploadedFile('data', 'CaseStudy', 'featured_image');
        if (!$fi && is_array($caseData['featured_image'] ?? null) && !empty(($caseData['featured_image']['tmp_name'] ?? ''))) {
            $fi = $caseData['featured_image'];
        }
        if (!$fi) {
            $fi = $this->request->data['CaseStudy']['featured_image'] ?? null;
        }
        if ($fi && is_array($fi) && !empty($fi['tmp_name']) && ($fi['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($fi['name'] ?? '', PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $featuredName = 'featured_' . time() . '.' . $ext;
                $dest = $uploadDir . $featuredName;
                if (move_uploaded_file($fi['tmp_name'], $dest)) {
                    $ent = $this->CaseStudy->get($caseId);
                    $this->CaseStudy->patchEntity($ent, ['featured_image' => 'files/case_studies/' . $caseId . '/' . $featuredName]);
                    $this->CaseStudy->save($ent);
                }
            }
        }

        /* ------------------------------
        * 3. Handle Multiple Images
        * ------------------------------ */
        if (!empty($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $imgDestDir = $uploadDir . 'images' . DS;

            if (!file_exists($imgDestDir)) {
                mkdir($imgDestDir, 0755, true);
            }

            $total = count($_FILES['images']['name']);
            for ($i = 0; $i < $total; $i++) {
                if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) continue;

                $tmp = $_FILES['images']['tmp_name'][$i];
                $originalName = $_FILES['images']['name'][$i];
                $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                // Allow only image file types
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) continue;

                $safeName = 'caseimg_' . time() . '_' . mt_rand(100, 999) . '.' . $ext;
                $fullPath = $imgDestDir . $safeName;

                if (move_uploaded_file($tmp, $fullPath)) {
                    $imgEntity = $this->CaseImage->newEntity([
                        'case_study_id' => $caseId,
                        'filename' => 'files/case_studies/' . $caseId . '/images/' . $safeName,
                        'type' => isset($this->request->data['CaseImage']['type'][$i]) ? $this->request->data['CaseImage']['type'][$i] : 'other',
                        'caption' => isset($this->request->data['CaseImage']['caption'][$i]) ? $this->request->data['CaseImage']['caption'][$i] : null,
                        'ordering' => 0
                    ]);
                    $this->CaseImage->save($imgEntity);
                }
            }
        }
    }


protected function _sendApprovalNotification($caseData) {
    try {
        $email = new Email('default');

        // ✅ From Durotech info email
        $email->setFrom(['info@durotechindustries.com.au' => 'Durotech Employee Portal'])
              ->setTo('kal@durotechindustries.com.au')
            //   ->setTo('deepaksaini10036@gmail.com')
              ->setSubject('New Case Study Submitted for Approval')
              ->setEmailFormat('html');

        $case = $caseData['CaseStudy'];

        // ✅ Email message content
       $message = "
        <html>
        <body style='margin:0; padding:0; background:#f7f7f7; font-family: Arial, sans-serif; color:#333;'>

            <table align='center' cellpadding='0' cellspacing='0' border='0' width='600' style='margin:auto; background:#ffffff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); overflow:hidden;'>
                
                <!-- Header with logos -->
                <tr style='background:#ffffff; text-align:center;'>
                    <td style='padding:20px 10px;'>
                        <table width='100%' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td align='left' width='33%'>
                                    <img src='" . SITEURL . "app/webroot/project_document/1977_logo%20(2).png' alt='Durotech Logo' width='100' style='max-width:100px;'>
                                </td>
                                <td align='center' width='34%'>
                                    <img src='" . SITEURL . "app/webroot/project_document/1977_logo%20(3).png' alt='Center Logo' width='100' style='max-width:100px;'>
                                </td>
                                <td align='right' width='33%'>
                                    <img src='" . SITEURL . "app/webroot/project_document/1977_logo%20(1).png' alt='Right Logo' width='100' style='max-width:100px;'>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Title -->
                <tr>
                    <td style='padding:25px 30px 10px 30px; text-align:center;'>
                        <h2 style='color:#007bff; margin:0;'>New Case Study Submitted for Approval</h2>
                    </td>
                </tr>

                <!-- Case Study Details -->
                <tr>
                    <td style='padding:15px 30px 20px 30px;'>
                        <p><strong>Title:</strong> " . h($case['title']) . "</p>
                        <p><strong>Location:</strong> " . h($case['location']) . "</p>
                        <p><strong>Project Date:</strong> " . h($case['project_date']) . "</p>
                        <p><strong>Short Summary:</strong><br>" . nl2br(h($case['short_summary'])) . "</p>

                        <p style='margin-top:25px;'>Please review and approve it in the admin panel:</p>

                        <p style='text-align:center;'>
                            <a href='" . SITEURL . "admin/case_studies' 
                            style='background:#007bff; color:#fff; padding:12px 24px; text-decoration:none; border-radius:5px; display:inline-block;'>
                                Open in Admin Panel
                            </a>
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style='background:#f0f0f0; padding:20px 30px; text-align:center; font-size:14px; color:#666;'>
                        <p style='margin:0;'>Regards,<br><strong>Durotech Employee Portal</strong></p>
                        <p style='margin-top:10px;'>
                            <a href='" . SITEURL . "' style='color:#007bff; text-decoration:none;'>Visit Website</a>
                        </p>
                    </td>
                </tr>

            </table>

        </body>
        </html>
        ";

        // ✅ Send and log status
        if ($email->send($message)) {
            CakeLog::write('info', '[Email] Case study approval email sent to Kal for ID: ' . $case['id']);
        } else {
            CakeLog::write('info', '[Email] Case study email failed for ID: ' . $case['id']);
        }

    } catch (Exception $e) {
        CakeLog::write('error', '[Email] Case study notification error: ' . $e->getMessage());
    }
}


public function test_email() {
    $email = new Email('default');
    $email->setTo('kal@durotechindustries.com.au');
    $email->setSubject('Test Email from Durotech');
    $email->send('This is a test email from Durotech server.');
    echo "Email sent!";
    die;
}

public function case_delete($id = null)
{
    $this->viewBuilder()->setLayout('employee_layout');
    $this->set('title_for_layout', SITENAME . ' | Delete Case Study');

    if (!$id || !$this->CaseStudy->exists(['id' => $id])) {
        throw new NotFoundException(__('Invalid Case Study'));
    }

    $this->loadModel('CaseImage');
    $this->CaseImage->deleteAll(['case_study_id' => $id], false);

    $dirPath = WWW_ROOT . 'files' . DS . 'case_studies' . DS . $id . DS;
    if (is_dir($dirPath)) {
        $this->_deleteDirectory($dirPath);
    }

    $entity = $this->CaseStudy->get($id);
    if ($this->CaseStudy->delete($entity)) {
        $this->Flash->success(__('Case study deleted successfully.'));
    } else {
        $this->Flash->error(__('Failed to delete case study.'));
    }

    return $this->redirect(['action' => 'case_studies']);
}

/** CakePHP 3 action alias. */
public function caseDelete($id = null) {
    return $this->case_delete($id);
}

protected function _deleteDirectory($dir)
{
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (is_dir($dir . DS . $item)) {
            $this->_deleteDirectory($dir . DS . $item);
        } else {
            unlink($dir . DS . $item);
        }
    }

    return rmdir($dir);
}

    public function case_edit($id = null) 
    {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', SITENAME . 'Case Detail Page');
        $this->response = $this->response
            ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->withHeader('Pragma', 'no-cache')
            ->withHeader('Expires', '0');

        if (!$id) {
            throw new NotFoundException();
        }
        $id = (int)$id;

        if ($this->request->is(array('post', 'put'))) {
            $data = $this->request->getData();
            // Support both nested (CaseStudy[title]) and flat (title) form field names
            $raw = null;
            if (isset($data['CaseStudy']) && is_array($data['CaseStudy'])) {
                $raw = $data['CaseStudy'];
            } elseif (is_array($data) && (isset($data['title']) || isset($data['slug']) || isset($data['project_date']))) {
                $raw = $data;
            }
            if (!is_array($raw)) {
                $raw = [];
            }
            $caseData = (array)$raw;

            $featuredImage = $caseData['featured_image'] ?? null;
            $datasheetFile = $caseData['datasheet_file'] ?? null;
            unset($caseData['featured_image'], $caseData['datasheet_file']);

            if (!array_key_exists('status', $caseData)) {
                $caseData['status'] = 0;
            } else {
                $caseData['status'] = !empty($caseData['status']) ? 1 : 0;
            }

            $allowedFields = [
                'title', 'slug', 'project_date', 'location', 'short_summary',
                'challenge', 'solution', 'outcome', 'status', 'datasheet'
            ];
            $schema = $this->CaseStudy->getSchema();
            $existingColumns = $schema->columns();
            $allowedFields = array_intersect($allowedFields, $existingColumns);
            $toSave = array_intersect_key($caseData, array_flip($allowedFields));

            if (isset($toSave['project_date']) && is_array($toSave['project_date'])) {
                $d = $toSave['project_date'];
                $toSave['project_date'] = sprintf('%04d-%02d-%02d',
                    (int)($d['year'] ?? date('Y')),
                    (int)($d['month'] ?? 1),
                    (int)($d['day'] ?? 1)
                );
            }
            $toSave = array_filter($toSave, function ($v) {
                return is_scalar($v) || $v === null;
            });

            $entity = $this->CaseStudy->get($id);
            $entity = $this->CaseStudy->patchEntity($entity, $toSave, [
                'validate' => true,
            ]);

            $saved = false;
            try {
                $saved = (bool)$this->CaseStudy->save($entity, ['checkExisting' => false]);
            } catch (\Exception $e) {
                if (Configure::read('debug')) {
                    $this->Flash->error('Save failed: ' . $e->getMessage());
                } else {
                    $this->Flash->error('Save failed. Please check the form.');
                }
            }

            if ($saved) {
                $this->request = $this->request->withData('CaseStudy', array_merge($caseData, ['featured_image' => $featuredImage, 'datasheet_file' => $datasheetFile]));

                $this->edit_handleUploads($id);

                $this->Flash->success('Case study updated successfully.');
                return $this->redirect([
                    'action' => 'case_edit',
                    $id,
                    '?' => ['_' => (string)time()]
                ]);
            } else {
                if (empty($entity->getErrors())) {
                    $this->Flash->error('Save failed. Please check the form.');
                } else {
                    $errors = $entity->getErrors();
                    $messages = [];
                    foreach ($errors as $field => $fieldErrors) {
                        foreach ((array)$fieldErrors as $rule => $msg) {
                            $messages[] = (is_string($msg) ? $msg : (is_array($msg) ? implode(', ', $msg) : (string)$msg));
                        }
                    }
                    $this->Flash->error('Save failed: ' . implode(' ', $messages));
                }
                $case = $this->CaseStudy->get($id, ['contain' => ['CaseImage']]);
                $case = $this->CaseStudy->patchEntity($case, $caseData, ['validate' => false]);
                $this->request = $this->request->withData('CaseStudy', array_merge($caseData, ['featured_image' => $featuredImage, 'datasheet_file' => $datasheetFile]));
            }
        } else {
            $case = $this->CaseStudy->get($id, ['contain' => ['CaseImage']]);
            $this->request = $this->request->withParsedBody(['CaseStudy' => $case->toArray()]);
        }

        if (!isset($case)) {
            $case = $this->CaseStudy->get($id, ['contain' => ['CaseImage']]);
        }
        $products = $this->Product->find('list', ['keyField' => 'id', 'valueField' => 'title']);
        $this->set(compact('case', 'products'));
    }

    /** CakePHP 3 action alias. */
    public function caseEdit($id = null) {
        return $this->case_edit($id);
    }

    public function edit_handleUploads($caseId)
    {
        $this->loadModel('CaseImage');

        $uploadDir = WWW_ROOT . 'files' . DS . 'case_studies' . DS . $caseId . DS;
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $caseData = $this->request->getData('CaseStudy') ?: [];

        /* ------------------------------
        * 1. Handle Datasheet (PDF) - use $_FILES directly for nested file inputs
        * ------------------------------ */
        $ds = $this->_getUploadedFile('data', 'CaseStudy', 'datasheet_file');
        if (!$ds && is_array($caseData['datasheet_file'] ?? null) && !empty(($caseData['datasheet_file']['tmp_name'] ?? ''))) {
            $ds = $caseData['datasheet_file'];
        }
        if (!$ds) {
            $ds = $this->request->getData('CaseStudy.datasheet_file');
        }
        if ($ds && is_array($ds) && !empty($ds['tmp_name']) && ($ds['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($ds['name'] ?? '', PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                $datasheetName = 'datasheet_' . time() . '.' . $ext;
                $dest = $uploadDir . $datasheetName;
                if (move_uploaded_file($ds['tmp_name'], $dest)) {
                    $ent = $this->CaseStudy->get($caseId);
                    $this->CaseStudy->patchEntity($ent, ['datasheet' => 'files/case_studies/' . $caseId . '/' . $datasheetName]);
                    $this->CaseStudy->save($ent);
                }
            }
        }

        /* ------------------------------
        * 2. Handle Featured Image - use $_FILES directly
        * ------------------------------ */
        $fi = $this->_getUploadedFile('data', 'CaseStudy', 'featured_image');
        if (!$fi && is_array($caseData['featured_image'] ?? null) && !empty(($caseData['featured_image']['tmp_name'] ?? ''))) {
            $fi = $caseData['featured_image'];
        }
        if (!$fi) {
            $fi = $this->request->getData('CaseStudy.featured_image');
        }
        if ($fi && is_array($fi) && !empty($fi['tmp_name']) && ($fi['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($fi['name'] ?? '', PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $existing = $this->CaseStudy->find()
                    ->select(['featured_image'])
                    ->where(['CaseStudy.id' => $caseId])
                    ->enableHydration(false)
                    ->first();
                if (!empty($existing['featured_image'])) {
                    $oldPath = WWW_ROOT . str_replace('/', DS, $existing['featured_image']);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }
                $featuredName = 'featured_' . time() . '.' . $ext;
                $dest = $uploadDir . $featuredName;
                if (move_uploaded_file($fi['tmp_name'], $dest)) {
                    $ent = $this->CaseStudy->get($caseId);
                    $this->CaseStudy->patchEntity($ent, ['featured_image' => 'files/case_studies/' . $caseId . '/' . $featuredName]);
                    $this->CaseStudy->save($ent);
                }
            }
        }

        /* ------------------------------
        * 3. Handle Images
        * ------------------------------ */
        $caseImages = $this->request->getData('CaseStudy.images');
        if (!empty($caseImages)) {
            $imgDir = $uploadDir . 'images' . DS;
            if (!file_exists($imgDir)) {
                mkdir($imgDir, 0755, true);
            }

            $allowedExts = array('jpg', 'jpeg', 'png', 'gif', 'webp');
            $caseImageMeta = $this->request->getData('CaseImage') ?: [];

            foreach ($caseImages as $i => $file) {
                if (empty($file['tmp_name']) || ($file['error'] ?? 0) !== UPLOAD_ERR_OK) continue;

                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowedExts)) continue;

                $safeName = 'caseimg_' . uniqid() . '.' . $ext;
                $finalPath = $imgDir . $safeName;

                if (move_uploaded_file($file['tmp_name'], $finalPath)) {
                    $imgEntity = $this->CaseImage->newEntity([
                        'case_study_id' => $caseId,
                        'filename' => 'files/case_studies/' . $caseId . '/images/' . $safeName,
                        'type' => $caseImageMeta['type'][$i] ?? 'other',
                        'caption' => $caseImageMeta['caption'][$i] ?? null,
                        'ordering' => 0
                    ]);
                    $this->CaseImage->save($imgEntity);
                }
            }
        }

        /* ------------------------------
        * 3. Update Existing Image Details
        * ------------------------------ */
        $existingImageData = $this->request->getData('ExistingImage');
        if (!empty($existingImageData)) {
            foreach ($existingImageData as $imgId => $imgData) {
                if ($this->CaseImage->exists(['id' => $imgId])) {
                    $imgEnt = $this->CaseImage->get($imgId);
                    $this->CaseImage->patchEntity($imgEnt, [
                        'caption' => isset($imgData['caption']) ? $imgData['caption'] : null,
                        'type'    => isset($imgData['type']) ? $imgData['type'] : 'other'
                    ]);
                    $this->CaseImage->save($imgEnt);
                }
            }
        }
    }

    /**
     * Delete a single case image. Redirects back to case edit.
     */
    public function delete_case_image($caseId = null, $imageId = null)
    {
        $this->viewBuilder()->setLayout('employee_layout');
        if (!$caseId || !$imageId) {
            $this->Flash->error(__('Invalid request.'));
            return $this->redirect(['action' => 'case_studies']);
        }
        $caseId = (int)$caseId;
        $imageId = (int)$imageId;
        $this->loadModel('CaseImage');
        $img = $this->CaseImage->find()
            ->where(['CaseImage.id' => $imageId, 'CaseImage.case_study_id' => $caseId])
            ->first();
        if (!$img) {
            $this->Flash->error(__('Image not found or does not belong to this case.'));
            return $this->redirect(['action' => 'case_edit', $caseId]);
        }
        $filename = $img->filename;
        if ($this->CaseImage->delete($img)) {
            $filePath = WWW_ROOT . str_replace('/', DS, $filename);
            if ($filename && file_exists($filePath)) {
                @unlink($filePath);
            }
            $this->Flash->success(__('Image removed.'));
        } else {
            $this->Flash->error(__('Could not remove image.'));
        }
        return $this->redirect(['action' => 'case_edit', $caseId]);
    }

    /** CakePHP 3 action alias. */
    public function deleteCaseImage($caseId = null, $imageId = null)
    {
        return $this->delete_case_image($caseId, $imageId);
    }

public function monthlySpecs() {

    $this->viewBuilder()->setLayout('employee_layout');
    $this->checkEmployeeSession();

    $this->loadModel('Mailer');

    $employeeId = (int)$this->Session->read('Employee.id');
    $employeeFirstName = trim((string)$this->request->getSession()->read('Employee.name'));
    $employeeLastName = trim((string)$this->request->getSession()->read('Employee.lname'));
    $employeeDisplayName = trim($employeeFirstName . ' ' . $employeeLastName);
    if ($employeeDisplayName === '') {
        $employeeDisplayName = 'Employee';
    }
    $currentYear = (int)date('Y');
    $selectedYear = (int)($this->request->getQuery('year') ?? $currentYear);
    if ($selectedYear < 2015 || $selectedYear > $currentYear) {
        $selectedYear = $currentYear;
    }
    $availableYears = range($currentYear, 2015);

    // Get filter from URL or default to 'month'
    $filter = (string)($this->request->getQuery('filter') ?? 'month');


    // Month labels
    $months = [
        '01' => 'JAN', '02' => 'FEB', '03' => 'MAR', '04' => 'APR',
        '05' => 'MAY', '06' => 'JUN', '07' => 'JUL', '08' => 'AUG',
        '09' => 'SEP', '10' => 'OCT', '11' => 'NOV', '12' => 'DEC'
    ];

    $monthlySpecs = [];
    $hasSaveStatusColumn = (bool)$this->Mailer->getSchema()->getColumn('save_status');

    // IMPORTANT: Keep conditions aligned with EmployeesController::index() listing.
    $baseQuery = $this->Mailer->find()
        ->distinct(['Mailer.id'])
        ->where([
            'Mailer.employee_id' => $employeeId,
            'Mailer.type' => 3,
        ]);
    if ($hasSaveStatusColumn) {
        $baseQuery->andWhere([
            'OR' => [
                ['Mailer.save_status' => 'submitted'],
                ['Mailer.save_status IS' => null],
            ],
        ]);
    }

    if ($filter === 'today') {
        // Count specs using the same date field as EmployeesController::index()
        $count = (clone $baseQuery)
            ->andWhere(['Mailer.date' => date('Y-m-d')])
            ->count();
        $monthlySpecs[date('d M')] = $count;

    } elseif ($filter === 'month') {
        // Count specs for each month of the current year
        foreach ($months as $monthNum => $monthName) {
            $startDate = $selectedYear . '-' . $monthNum . '-01';
            $endDate = $selectedYear . '-' . $monthNum . '-' . cal_days_in_month(CAL_GREGORIAN, (int)$monthNum, (int)$selectedYear);
            $count = (clone $baseQuery)
                ->andWhere([
                    'Mailer.date >=' => $startDate,
                    'Mailer.date <=' => $endDate,
                ])
                ->count();

               
            $monthlySpecs[$monthName] = $count;
        }

    } elseif ($filter === 'year') {
        // Count specs per year (could just sum for this year)
        $count = (clone $baseQuery)
            ->andWhere([
                'Mailer.date >=' => $selectedYear . '-01-01',
                'Mailer.date <=' => $selectedYear . '-12-31',
            ])
            ->count();
        $monthlySpecs[$selectedYear] = $count;
    }

   

    $this->set(compact('monthlySpecs', 'selectedYear', 'filter', 'availableYears', 'employeeDisplayName'));
}

/**
 * Backward-compatible alias for legacy CakePHP 2 style URLs/actions.
 */
public function monthly_specs() {
    return $this->monthlySpecs();
}











}