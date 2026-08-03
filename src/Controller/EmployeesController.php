<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Mailer\Email;
use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log as CakeLog;
use Exception;
use Psr\Http\Message\UploadedFileInterface;
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
		$this->loadComponent('Paginator');
		// CakePHP 3 does not support $uses; load legacy models explicitly.
		$this->loadModel('LoginHistory');
		$this->loadModel('Employee');
		$this->loadModel('Mailer');
		$this->loadModel('MailerComment');
		$this->loadModel('SpecUsearea');
		$this->loadModel('SpecTemplate');
		$this->loadModel('SpecTemplateItem');
		$this->loadModel('SpecTemplateComment');
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

    // Keep intended URL so login returns to the page the user was on (referer).
    $this->storeEmployeeIntendedUrlFromRequest();
    $this->Session->delete('Employee');
    $this->Session->delete('is_employee');

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
    $filters = $this->_employeeSpecListFilters();
    $query = $this->_employeeSpecListQuery($employee_id, $filters);

    $mailers = $this->paginate($query, [
        'limit' => 20,
    ]);

    // Check if employee has a draft so we can show "Resume Draft" vs "Create New Spec"
    $hasDraft = false;
    if ($this->Mailer->getSchema()->getColumn('save_status')) {
        $draftExists = [
            'Mailer.employee_id' => $employee_id,
            'Mailer.save_status' => 'draft',
            'Mailer.type' => 3,
        ];
        if ($this->Mailer->getSchema()->getColumn('deleted_at')) {
            $draftExists['Mailer.deleted_at IS'] = null;
        }
        $hasDraft = $this->Mailer->exists($draftExists);
    }

    $specSoftDelete = (bool)$this->Mailer->getSchema()->getColumn('deleted_at');

    $this->set(compact('mailers', 'hasDraft', 'filters', 'specSoftDelete'));
}

/**
 * Export all filtered specs (all pages) as CSV or printable HTML.
 * Query: same filters as index + format=csv|print
 */
public function export_specs()
{
    $this->checkEmployeeSession();

    $employee_id = $this->Session->read('Employee.id');
    $this->loadModel('Mailer');

    $filters = $this->_employeeSpecListFilters();
    $format = strtolower(trim((string)$this->request->getQuery('format')));
    if ($format !== 'csv' && $format !== 'print') {
        $format = 'csv';
    }

    $query = $this->_employeeSpecListQuery($employee_id, $filters);
    $mailers = $query->all();

    $rows = [];
    foreach ($mailers as $mailer) {
        if (is_array($mailer) && isset($mailer['Mailer'])) {
            $mailerData = (array)$mailer['Mailer'];
            $employeeData = (array)($mailer['Employee'] ?? []);
        } elseif (is_object($mailer) && method_exists($mailer, 'toArray')) {
            $mailerData = (array)$mailer->toArray();
            $employeeData = [];
            if (!empty($mailer->employee) && method_exists($mailer->employee, 'toArray')) {
                $employeeData = (array)$mailer->employee->toArray();
            } elseif (!empty($mailerData['employee']) && is_array($mailerData['employee'])) {
                $employeeData = $mailerData['employee'];
            }
        } else {
            $mailerData = (array)$mailer;
            $employeeData = [];
        }

        $status = (int)($mailerData['status'] ?? 0);
        $isReview = (int)($mailerData['is_review'] ?? 0);
        if ($isReview === 0) {
            $approveStatus = 'Pending Review';
        } elseif ($isReview === 1 && $status === 0) {
            $approveStatus = 'Reviewed - Awaiting Approval';
        } elseif ($isReview === 1 && $status === 1) {
            $approveStatus = 'Approved';
        } else {
            $approveStatus = 'Unknown';
        }

        $created = $mailerData['created'] ?? null;
        if ($created instanceof \DateTimeInterface) {
            $createdStr = $created->format('d-M-Y h:i a');
        } elseif (!empty($created)) {
            $createdStr = function_exists('format_db_date')
                ? format_db_date('d-M-Y h:i a', (string)$created)
                : (string)$created;
        } else {
            $createdStr = '';
        }

        $specSentAt = $mailerData['spec_email_sent_at'] ?? null;
        $specSentTo = (string)($mailerData['spec_email_sent_to'] ?? '');
        if (!empty($specSentAt)) {
            $at = $specSentAt instanceof \DateTimeInterface
                ? $specSentAt->format('d-M-Y h:i a')
                : (function_exists('format_db_date')
                    ? format_db_date('d-M-Y h:i a', (string)$specSentAt)
                    : (string)$specSentAt);
            $customerEmail = 'Sent ' . $at . ($specSentTo !== '' ? (' to ' . $specSentTo) : '');
        } else {
            $customerEmail = 'Not sent';
        }

        $pdfAttachment = '';
        $pdfUrl = '';
        if (!empty($mailerData['pdf_attachment'])) {
            $pdfRel = ltrim((string)$mailerData['pdf_attachment'], '/');
            $pdfUrl = $this->_employeePdfPublicUrl($pdfRel);
            $pdfAttachment = $pdfUrl;
        } else {
            $pdfAttachment = 'No Attachment';
        }

        $rows[] = [
            'tracknumber' => '#' . (string)($mailerData['tracknumber'] ?? ''),
            'employee_name' => (string)($employeeData['name'] ?? ''),
            'name' => (string)($mailerData['name'] ?? ''),
            'email' => (string)($mailerData['email'] ?? ''),
            'company' => (string)($mailerData['company'] ?? ''),
            'address' => (string)($mailerData['address'] ?? ''),
            'specification' => (string)($mailerData['specification'] ?? ''),
            'date' => (string)($mailerData['date'] ?? ''),
            'pdf_attachment' => $pdfAttachment,
            'pdf_url' => $pdfUrl,
            'approve_status' => $approveStatus,
            'revision' => (string)($mailerData['revision'] ?? '0'),
            'created' => $createdStr,
            'customer_email' => $customerEmail,
        ];
    }

    if ($format === 'csv') {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;

        $filename = 'duroozy-specs-' . date('Y-m-d') . '.csv';
        $this->response = $this->response
            ->withType('csv')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->withHeader('Pragma', 'no-cache')
            ->withHeader('Expires', '0');

        $fh = fopen('php://temp', 'r+');
        fputcsv($fh, [
            'TrackNumber',
            'Employee Name',
            'Name/Attn',
            'Email',
            'Project',
            'Address',
            'Specification',
            'Date',
            'PDF Attachment',
            'Approve Status',
            'Revision',
            'Created',
            'Customer email',
        ]);
        foreach ($rows as $row) {
            fputcsv($fh, [
                $row['tracknumber'],
                $row['employee_name'],
                $row['name'],
                $row['email'],
                $row['company'],
                $row['address'],
                $row['specification'],
                $row['date'],
                $row['pdf_attachment'],
                $row['approve_status'],
                $row['revision'],
                $row['created'],
                $row['customer_email'],
            ]);
        }
        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);

        return $this->response->withStringBody($csv !== false ? $csv : '');
    }

    $this->viewBuilder()->setLayout(false);
    $this->set(compact('rows', 'filters'));
    $this->render('export_specs');
}

public function exportSpecs()
{
    return $this->export_specs();
}

/**
 * @return array{tracknumber:string,name:string,email:string,company:string,specification:string,date_from:string,date_to:string}
 */
protected function _employeeSpecListFilters(): array
{
    return [
        'tracknumber' => trim((string)$this->request->getQuery('tracknumber')),
        'name' => trim((string)$this->request->getQuery('name')),
        'email' => trim((string)$this->request->getQuery('email')),
        'company' => trim((string)$this->request->getQuery('company')),
        'specification' => trim((string)$this->request->getQuery('specification')),
        'date_from' => trim((string)$this->request->getQuery('date_from')),
        'date_to' => trim((string)$this->request->getQuery('date_to')),
    ];
}

/**
 * Same filtered specs query used by index + export (no pagination).
 *
 * @param int|string $employee_id
 * @param array $filters
 * @return \Cake\ORM\Query
 */
protected function _employeeSpecListQuery($employee_id, array $filters)
{
    $query = $this->Mailer->find()
        ->where([
            'Mailer.employee_id' => $employee_id,
            'Mailer.type' => 3,
        ])
        ->contain(['Employee'])
        ->orderDesc('Mailer.id');

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

    $this->_applyMailerNotDeletedToQuery($query);

    if ($this->Mailer->getSchema()->getColumn('save_status')) {
        $query->andWhere([
            'OR' => [
                ['Mailer.save_status' => 'submitted'],
                ['Mailer.save_status IS' => null],
            ],
        ]);
    }

    return $query;
}

/**
 * Public PDF URL (same idea as PdfHelper::url).
 */
protected function _employeePdfPublicUrl(string $relativePath): string
{
    $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');
    $base = defined('SITEURL') ? rtrim((string)SITEURL, '/') . '/' : '/';
    $version = time();
    if ($relativePath !== '') {
        $abs = WWW_ROOT . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
        if (is_file($abs)) {
            $version = (int)filemtime($abs);
        }
    }
    $sep = (strpos($relativePath, '?') === false) ? '?' : '&';
    return $base . $relativePath . $sep . 'v=' . $version;
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
        ]);
    $this->_applyMailerNotDeletedToQuery($mailer);
    $mailer = $mailer->first();
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

/**
 * Hide soft-deleted mailer rows when mailers.deleted_at column exists.
 */
protected function _applyMailerNotDeletedToQuery($query): void
{
    if ($this->Mailer->getSchema()->getColumn('deleted_at')) {
        $query->andWhere(['Mailer.deleted_at IS' => null]);
    }
}

public function employee_send_v3() {
    $this->viewBuilder()->setLayout('employee_layout');
    $this->set('title_for_layout', SITENAME . ' DuroEzy Specification Mailer');
    $redirect = $this->checkEmployeeSession();
    if ($redirect instanceof Response) {
        return $redirect;
    }
    $this->loadModel('Mailer'); // ✅ Required to use Mailer in this controller
    $this->loadModel('MailerComment');
    $this->loadModel('SpecUsearea');



    $employee_id = (int)$this->Session->read('Employee.id');
    if ($employee_id <= 0) {
        $this->Flash->error('Session expired. Please login again.');
        if ($this->request->is('get') || $this->request->is('head')) {
            $this->storeEmployeeIntendedUrlFromRequest();
        }
        return $this->redirect(rtrim(SITEURL, '/') . '/employees/login');
    }
    $mode = (string)$this->request->getQuery('mode');
    $adaptiveMode = $mode === 'adaptive';
    $templateMode = $mode === 'template';
    $cloneMode = $mode === 'clone';
    $claudeMode = $mode === 'claude';
    $cloneFromId = (int)$this->request->getQuery('from_id');

    $hasSaveStatusColumn = $this->Mailer->getSchema()->getColumn('save_status');
    // "Start New Spec (discard this draft)" must delete drafts first; otherwise the next block
    // auto-redirects to ?resume=1 and the user can never leave draft mode.
    if (!$this->request->is('post') && $hasSaveStatusColumn && $this->request->getQuery('discard_draft')) {
        $draftQuery = $this->Mailer->find()
            ->where([
                'Mailer.employee_id' => $employee_id,
                'Mailer.save_status' => 'draft',
                'Mailer.type' => 3,
            ]);
        $this->_applyMailerNotDeletedToQuery($draftQuery);
        $draftIds = $draftQuery->all()
            ->extract('id')
            ->toArray();
        if (!empty($draftIds)) {
            $this->MailerComment->deleteAll(['mailer_id IN' => $draftIds]);
            $this->SpecUsearea->deleteAll(['mailer_id IN' => $draftIds]);
            $this->Mailer->deleteAll(['id IN' => $draftIds]);
        }
        $this->Flash->success('Draft discarded. You can start a new spec.');
        return $this->redirect(['action' => 'employee_send_v3']);
    }

    if (!$this->request->is('post') && !$adaptiveMode && !$templateMode && !$cloneMode && !$claudeMode && !$this->request->getQuery('resume') && $hasSaveStatusColumn) {
        $existingDraft = $this->Mailer->find()
            ->select(['id'])
            ->where([
                'Mailer.employee_id' => $employee_id,
                'Mailer.save_status' => 'draft',
                'Mailer.type' => 3,
            ])
            ->orderDesc('Mailer.id');
        $this->_applyMailerNotDeletedToQuery($existingDraft);
        $existingDraft = $existingDraft->first();
        if ($existingDraft) {
            $this->Flash->set(
                'Draft Found: continuing from Resume Draft to avoid duplicate draft entries.',
                ['element' => 'default', 'params' => ['class' => 'alert alert-warning']]
            );
            return $this->redirect(['action' => 'employee_send_v3', '?' => ['resume' => '1']]);
        }
    }

    if ($this->request->is('post')) {
        $formData = (array)$this->request->getData();
        if (empty($formData) && !empty($this->request->data)) {
            $formData = (array)$this->request->data;
        }

        $isFinalSubmit = !empty($formData['submit_spec']) && $formData['submit_spec'] === '1';
        $draftIdFromForm = isset($formData['draft_id']) ? (int)$formData['draft_id'] : 0;
        $hasSaveStatusColumn = $this->Mailer->getSchema()->getColumn('save_status');

        // Final submit: prefer existing draft (by id, then latest open draft) so track stays reserved.
        if ($isFinalSubmit && $hasSaveStatusColumn) {
            $draftToSubmit = null;
            if ($draftIdFromForm > 0) {
                $existing = $this->Mailer->find()->where(['Mailer.id' => $draftIdFromForm])->first();
                $notDeleted = !$this->Mailer->getSchema()->getColumn('deleted_at')
                    || ($existing && $existing->get('deleted_at') === null);
                if ($existing && $notDeleted && (int)$existing->employee_id === (int)$employee_id && $existing->save_status === 'draft') {
                    $draftToSubmit = $existing;
                }
            }
            if (!$draftToSubmit) {
                $latestDraftQ = $this->Mailer->find()
                    ->where([
                        'Mailer.employee_id' => $employee_id,
                        'Mailer.save_status' => 'draft',
                        'Mailer.type' => 3,
                    ])
                    ->orderDesc('Mailer.id');
                $this->_applyMailerNotDeletedToQuery($latestDraftQ);
                $draftToSubmit = $latestDraftQ->first();
            }
            if ($draftToSubmit) {
                $submitDraftId = (int)$draftToSubmit->id;
                $this->_saveEmployeeSpecAsSubmitted($submitDraftId, $formData, $employee_id);
                $this->_markClaudeDraftAppliedIfRequested($formData, $submitDraftId);
                $this->Flash->success('Spec generated successfully.');
                return $this->redirect(['action' => 'index']);
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


        // Brand-new create only (no open draft): keep form track if present, else allocate next.
        $inserty['Mailer'] = array(
            'employee_id'   => $employee_id,
            'spec_v'        => 0,
            'tracknumber'   => $this->_resolveSpecTrackNumber('', $formData),
            'name'          => $formData['name'] ?? '',
            'email'         => $formData['email'] ?? '',
            'company'       => $formData['company'] ?? '',
            'address'       => $formData['address'] ?? '',
            'specification' => $formData['specification'] ?? '',
            'date'          => $formattedDate,
            'type'          => $formData['type'] ?? 3,
            'subject'       => $formData['subject'] ?? '',
            // use_area: 0 = With Warranty, 1 = Without Warranty (inverse of form spectype).
            'use_area'      => isset($formData['spectype'])
                ? (((int)$formData['spectype'] === 1) ? 0 : 1)
                : (isset($formData['use_area']) ? (int)$formData['use_area'] : 0),
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


            $this->_markClaudeDraftAppliedIfRequested($formData, $lastinsertId);

            // Cleanup leftover drafts only after a true non-draft create succeeded.
            if ($hasSaveStatusColumn) {
                $draftCleanup = $this->Mailer->find()
                    ->where([
                        'Mailer.employee_id' => $employee_id,
                        'Mailer.save_status' => 'draft',
                        'Mailer.type' => 3,
                        'Mailer.id !=' => $lastinsertId,
                    ]);
                $this->_applyMailerNotDeletedToQuery($draftCleanup);
                $draftIds = $draftCleanup->all()
                    ->extract('id')
                    ->toArray();
                if (!empty($draftIds)) {
                    $this->MailerComment->deleteAll(['mailer_id IN' => $draftIds]);
                    $this->SpecUsearea->deleteAll(['mailer_id IN' => $draftIds]);
                    $this->Mailer->deleteAll(['id IN' => $draftIds]);
                }
            }

            $this->Flash->success('Spec generated successfully.');
            return $this->redirect(array('action' => 'index'));
        }
    }

    // Load draft first so reserved track is shown; only preview next if no reserved track.
    $draft = null;
    $draftId = null;
    $refernce = '';
    $resumeDraft = $this->request->getQuery('resume') && $this->Mailer->getSchema()->getColumn('save_status');
    if ($resumeDraft) {
        $draftLoad = $this->Mailer->find()
            ->where(['Mailer.employee_id' => $employee_id, 'Mailer.save_status' => 'draft', 'Mailer.type' => 3])
            ->orderDesc('Mailer.id');
        $this->_applyMailerNotDeletedToQuery($draftLoad);
        $draft = $draftLoad->first();
        if ($draft) {
            $draftId = $draft->id;
            $draftTrack = trim((string)($draft->tracknumber ?? ''));
            // Reserve track immediately on resume so submit keeps the same number (not only on autosave).
            if ($draftTrack === '') {
                $draft->tracknumber = $this->Mailer->getNextSpecTrackNumber();
                $this->Mailer->save($draft);
                $draftTrack = trim((string)$draft->tracknumber);
            }
            if ($draftTrack !== '') {
                $refernce = $draftTrack;
            }
            $draft->comments = $this->MailerComment->find()->where(['mailer_id' => $draftId])->all();
            $draft->spec_useareas = $this->SpecUsearea->find()->where(['mailer_id' => $draftId])->orderAsc('id')->all();
        }
    }
    if ($refernce === '') {
        $refernce = $this->Mailer->getNextSpecTrackNumber();
    }
    $previousSpecs = [];
    $templatePresets = [];
    if ($adaptiveMode) {
        // Own submitted specs + admin-created v3 templates (no employee owner) for Smart Spec.
        // Only current and previous calendar year on `created` (e.g. 2025 + 2026 in 2026).
        $yearNow = (int)date('Y');
        $yearPrev = $yearNow - 1;
        $createdFrom = sprintf('%d-01-01 00:00:00', $yearPrev);
        $createdTo = sprintf('%d-12-31 23:59:59', $yearNow);

        $previousSpecsQuery = $this->Mailer->find()
            ->select(['id', 'tracknumber', 'name', 'company', 'specification', 'date', 'admin_id', 'employee_id', 'created'])
            ->where(['Mailer.type' => 3])
            ->andWhere([
                'Mailer.created >=' => $createdFrom,
                'Mailer.created <=' => $createdTo,
            ])
            ->andWhere([
                'OR' => [
                    ['Mailer.employee_id' => $employee_id],
                    [
                        'Mailer.admin_id >' => 0,
                        'OR' => [
                            ['Mailer.employee_id IS' => null],
                            ['Mailer.employee_id <=' => 0],
                        ],
                    ],
                ],
            ])
            ->orderDesc('Mailer.id')
            ->limit(500);

        $this->_applyMailerNotDeletedToQuery($previousSpecsQuery);

        if ($this->Mailer->getSchema()->getColumn('save_status')) {
            $previousSpecsQuery->andWhere([
                'OR' => [
                    ['Mailer.save_status' => 'submitted'],
                    ['Mailer.save_status IS' => null],
                ],
            ]);
        }

        $previousSpecs = $previousSpecsQuery->all()->toArray();
    }
    if ($templateMode) {
        $templatePresets = $this->SpecTemplate->find()
            ->select(['id', 'template_name', 'created'])
            ->where([
                'SpecTemplate.employee_id' => $employee_id,
                'SpecTemplate.deleted_at IS' => null,
            ])
            ->orderDesc('SpecTemplate.id')
            ->all()
            ->toArray();

        // Fallback: when no saved presets, offer recent submitted specs (Use Area load only in UI).
        if (empty($templatePresets)) {
            $fallbackQuery = $this->Mailer->find()
                ->select(['id', 'tracknumber', 'name', 'company', 'specification', 'date', 'admin_id', 'employee_id', 'created'])
                ->where([
                    'Mailer.type' => 3,
                    'Mailer.employee_id' => $employee_id,
                ])
                ->orderDesc('Mailer.id')
                ->limit(100);
            $this->_applyMailerNotDeletedToQuery($fallbackQuery);
            if ($this->Mailer->getSchema()->getColumn('save_status')) {
                $fallbackQuery->andWhere([
                    'OR' => [
                        ['Mailer.save_status' => 'submitted'],
                        ['Mailer.save_status IS' => null],
                    ],
                ]);
            }
            $previousSpecs = $fallbackQuery->all()->toArray();
        }
    }

    // Clone: validate from_id is own non-draft spec (any year).
    if ($cloneMode) {
        if ($cloneFromId <= 0) {
            $this->Flash->error('Invalid clone source.');
            return $this->redirect(['action' => 'index']);
        }
        $cloneQuery = $this->Mailer->find()
            ->select(['id'])
            ->where([
                'Mailer.id' => $cloneFromId,
                'Mailer.type' => 3,
                'Mailer.employee_id' => $employee_id,
            ]);
        $this->_applyMailerNotDeletedToQuery($cloneQuery);
        if ($this->Mailer->getSchema()->getColumn('save_status')) {
            $cloneQuery->andWhere([
                'OR' => [
                    ['Mailer.save_status' => 'submitted'],
                    ['Mailer.save_status IS' => null],
                ],
            ]);
        }
        if (!$cloneQuery->first()) {
            $this->Flash->error('Spec not found or not available to clone.');
            return $this->redirect(['action' => 'index']);
        }
    }

    $claudePrefill = null;
    $claudeDraftId = (int)$this->request->getQuery('claude_draft_id');
    if ($claudeMode) {
        $sessionPrefill = $this->request->getSession()->read('ClaudeSpec.prefill');
        if (is_array($sessionPrefill)) {
            $claudePrefill = $sessionPrefill;
            if ($claudeDraftId <= 0 && !empty($sessionPrefill['claude_draft_id'])) {
                $claudeDraftId = (int)$sessionPrefill['claude_draft_id'];
            }
        }
    }

    $this->set(compact(
        'refernce',
        'draft',
        'draftId',
        'adaptiveMode',
        'templateMode',
        'cloneMode',
        'cloneFromId',
        'claudeMode',
        'claudePrefill',
        'claudeDraftId',
        'previousSpecs',
        'templatePresets'
    ));
}

/**
 * Return previous submitted spec payload as JSON for adaptive mode.
 */
public function previousSpecData($id = null)
{
    $this->request->allowMethod(['get']);
    $this->viewBuilder()->setLayout(false);
    $this->viewBuilder()->disableAutoLayout();
    $this->viewBuilder()->setClassName('Cake\View\View');
    $this->checkEmployeeSession();

    $employee_id = (int)$this->Session->read('Employee.id');
    $id = (int)$id;
    if ($id <= 0) {
        return $this->_specDraftJsonResponse(['success' => false, 'error' => 'Invalid spec id.']);
    }

    $yearNow = (int)date('Y');
    $yearPrev = $yearNow - 1;
    $createdFrom = sprintf('%d-01-01 00:00:00', $yearPrev);
    $createdTo = sprintf('%d-12-31 23:59:59', $yearNow);

    // Own specs: any year (clone / older jobs). Admin templates: still limited to current+prev year.
    $query = $this->Mailer->find()
        ->where([
            'Mailer.id' => $id,
            'Mailer.type' => 3,
        ])
        ->andWhere([
            'OR' => [
                ['Mailer.employee_id' => $employee_id],
                [
                    'Mailer.admin_id >' => 0,
                    'Mailer.created >=' => $createdFrom,
                    'Mailer.created <=' => $createdTo,
                    'OR' => [
                        ['Mailer.employee_id IS' => null],
                        ['Mailer.employee_id <=' => 0],
                    ],
                ],
            ],
        ]);

    if ($this->Mailer->getSchema()->getColumn('save_status')) {
        $query->andWhere([
            'OR' => [
                ['Mailer.save_status' => 'submitted'],
                ['Mailer.save_status IS' => null],
            ],
        ]);
    }

    $this->_applyMailerNotDeletedToQuery($query);

    $spec = $query->first();
    if (!$spec) {
        return $this->_specDraftJsonResponse(['success' => false, 'error' => 'Spec not found.']);
    }

    $comments = $this->MailerComment->find()
        ->select(['comment'])
        ->where(['mailer_id' => $id])
        ->all()
        ->toArray();

    $useareas = $this->SpecUsearea->find()
        ->where(['mailer_id' => $id])
        ->orderAsc('id')
        ->all()
        ->toArray();

    $bySection = [];
    foreach ($useareas as $row) {
        $tid = (int)($row->types ?? 0);
        if (!isset($bySection[$tid])) {
            $bySection[$tid] = [
                'title' => (string)($row->title ?? ''),
                'rows' => [],
            ];
        }
        $bySection[$tid]['rows'][] = [
            'serial' => (string)($row->serial ?? ''),
            'coverage' => (string)($row->coverage ?? ''),
            'product' => (string)($row->product ?? ''),
            'coverage_by_pack' => (string)($row->coverage_by_pack ?? ''),
            'Warranty' => (string)($row->Warranty ?? ''),
        ];
    }

    return $this->_specDraftJsonResponse([
        'success' => true,
        'data' => [
            'name' => (string)($spec->name ?? ''),
            'company' => (string)($spec->company ?? ''),
            'address' => (string)($spec->address ?? ''),
            'specification' => (string)($spec->specification ?? ''),
            'email' => (string)($spec->email ?? ''),
            'date' => !empty($spec->date) ? format_db_date('d/m/Y', $spec->date) : date('d/m/Y'),
            'type' => (string)($spec->type ?? '3'),
            'subject' => (string)($spec->subject ?? ''),
            'sections' => array_values($bySection),
            'comments' => array_map(function ($c) { return (string)($c->comment ?? ''); }, $comments),
        ],
    ]);
}

/**
 * Backward-compatible alias for legacy underscored route.
 */
public function previous_spec_data($id = null)
{
    return $this->previousSpecData($id);
}

/**
 * Manage employee template presets.
 */
public function template_presets()
{
    $this->viewBuilder()->setLayout('employee_layout');
    $this->set('title_for_layout', SITENAME . ' Template Presets');
    $this->checkEmployeeSession();

    $employee_id = (int)$this->Session->read('Employee.id');
    $templates = $this->SpecTemplate->find()
        ->where([
            'SpecTemplate.employee_id' => $employee_id,
            'SpecTemplate.deleted_at IS' => null,
        ])
        ->orderDesc('SpecTemplate.id')
        ->all();

    $this->set(compact('templates'));
}

/**
 * Save a submitted spec as template preset.
 */
public function saveTemplateFromSpec($id = null)
{
    $this->request->allowMethod(['post']);
    $this->checkEmployeeSession();

    $employee_id = (int)$this->Session->read('Employee.id');
    $id = (int)$id;
    if ($id <= 0) {
        $this->Flash->error('Invalid spec id.');
        return $this->redirect(['action' => 'index']);
    }

    $query = $this->Mailer->find()
        ->where([
            'Mailer.id' => $id,
            'Mailer.employee_id' => $employee_id,
            'Mailer.type' => 3,
        ]);
    if ($this->Mailer->getSchema()->getColumn('save_status')) {
        $query->andWhere([
            'OR' => [
                ['Mailer.save_status' => 'submitted'],
                ['Mailer.save_status IS' => null],
            ],
        ]);
    }
    $this->_applyMailerNotDeletedToQuery($query);
    $spec = $query->first();
    if (!$spec) {
        $this->Flash->error('Submitted spec not found.');
        return $this->redirect(['action' => 'index']);
    }

    $track = (string)($spec->tracknumber ?? ('#' . $spec->id));
    $templateName = 'Template - ' . $track;
    $template = $this->SpecTemplate->newEntity([
        'employee_id' => $employee_id,
        'template_name' => $templateName,
        'type' => (int)($spec->type ?? 3),
        'subject' => (string)($spec->subject ?? ''),
        'specification' => (string)($spec->specification ?? ''),
        'deleted_at' => null,
        'created' => date('Y-m-d H:i:s'),
    ]);
    if (!$this->SpecTemplate->save($template)) {
        $this->Flash->error('Unable to save template.');
        return $this->redirect(['action' => 'index']);
    }

    $templateId = (int)$template->id;
    $comments = $this->MailerComment->find()->where(['mailer_id' => $id])->orderAsc('id')->all();
    foreach ($comments as $idx => $comment) {
        $this->SpecTemplateComment->save($this->SpecTemplateComment->newEntity([
            'template_id' => $templateId,
            'sort_order' => $idx + 1,
            'comment' => (string)($comment->comment ?? ''),
        ]));
    }

    $useareas = $this->SpecUsearea->find()->where(['mailer_id' => $id])->orderAsc('id')->all();
    foreach ($useareas as $row) {
        $this->SpecTemplateItem->save($this->SpecTemplateItem->newEntity([
            'template_id' => $templateId,
            'section_no' => (int)($row->types ?? 0),
            'section_title' => (string)($row->title ?? ''),
            'serial' => (string)($row->serial ?? ''),
            'coverage' => (string)($row->coverage ?? ''),
            'product' => (string)($row->product ?? ''),
            'coverage_by_pack' => (string)($row->coverage_by_pack ?? ''),
            'warranty' => (string)($row->Warranty ?? ''),
        ]));
    }

    $this->Flash->success('Template preset saved successfully.');
    return $this->redirect(['action' => 'template_presets']);
}

/**
 * Rename template preset.
 */
public function editTemplatePreset($id = null)
{
    $this->viewBuilder()->setLayout('employee_layout');
    $this->set('title_for_layout', SITENAME . ' Edit Template Preset');
    $this->checkEmployeeSession();

    $employee_id = (int)$this->Session->read('Employee.id');
    $id = (int)$id;
    if ($id <= 0) {
        $this->Flash->error('Invalid template id.');
        return $this->redirect(['action' => 'template_presets']);
    }

    $template = $this->SpecTemplate->find()
        ->where([
            'SpecTemplate.id' => $id,
            'SpecTemplate.employee_id' => $employee_id,
            'SpecTemplate.deleted_at IS' => null,
        ])
        ->first();
    if (!$template) {
        $this->Flash->error('Template not found.');
        return $this->redirect(['action' => 'template_presets']);
    }

    if ($this->request->is(['post', 'put'])) {
        $name = trim((string)$this->request->getData('template_name'));
        if ($name === '') {
            $this->Flash->error('Template name is required.');
        } else {
            $template->template_name = $name;
            $template->modified = date('Y-m-d H:i:s');
            if ($this->SpecTemplate->save($template)) {
                $this->Flash->success('Template updated successfully.');
                return $this->redirect(['action' => 'template_presets']);
            }
            $this->Flash->error('Unable to update template.');
        }
    }

    $this->set(compact('template'));
}

/**
 * Soft-delete template preset.
 */
public function deleteTemplatePreset($id = null)
{
    $this->request->allowMethod(['post']);
    $this->checkEmployeeSession();
    $employee_id = (int)$this->Session->read('Employee.id');
    $id = (int)$id;

    $template = $this->SpecTemplate->find()
        ->where([
            'SpecTemplate.id' => $id,
            'SpecTemplate.employee_id' => $employee_id,
            'SpecTemplate.deleted_at IS' => null,
        ])
        ->first();
    if (!$template) {
        $this->Flash->error('Template not found.');
        return $this->redirect(['action' => 'template_presets']);
    }

    $template->deleted_at = date('Y-m-d H:i:s');
    $template->modified = date('Y-m-d H:i:s');
    if ($this->SpecTemplate->save($template)) {
        $this->Flash->success('Template removed.');
    } else {
        $this->Flash->error('Unable to remove template.');
    }
    return $this->redirect(['action' => 'template_presets']);
}

/**
 * Return template payload as JSON for create-spec autofill.
 */
public function templatePresetData($id = null)
{
    $this->request->allowMethod(['get']);
    $this->viewBuilder()->setLayout(false);
    $this->viewBuilder()->disableAutoLayout();
    $this->viewBuilder()->setClassName('Cake\View\View');
    $this->checkEmployeeSession();

    $employee_id = (int)$this->Session->read('Employee.id');
    $id = (int)$id;
    if ($id <= 0) {
        return $this->_specDraftJsonResponse(['success' => false, 'error' => 'Invalid template id.']);
    }

    $template = $this->SpecTemplate->find()
        ->where([
            'SpecTemplate.id' => $id,
            'SpecTemplate.employee_id' => $employee_id,
            'SpecTemplate.deleted_at IS' => null,
        ])
        ->first();
    if (!$template) {
        return $this->_specDraftJsonResponse(['success' => false, 'error' => 'Template not found.']);
    }

    $items = $this->SpecTemplateItem->find()
        ->where(['template_id' => $id])
        ->orderAsc('id')
        ->all()
        ->toArray();
    $comments = $this->SpecTemplateComment->find()
        ->where(['template_id' => $id])
        ->orderAsc('sort_order')
        ->all()
        ->toArray();

    $bySection = [];
    foreach ($items as $row) {
        $tid = (int)($row->section_no ?? 0);
        if (!isset($bySection[$tid])) {
            $bySection[$tid] = [
                'title' => (string)($row->section_title ?? ''),
                'rows' => [],
            ];
        }
        $bySection[$tid]['rows'][] = [
            'serial' => (string)($row->serial ?? ''),
            'coverage' => (string)($row->coverage ?? ''),
            'product' => (string)($row->product ?? ''),
            'coverage_by_pack' => (string)($row->coverage_by_pack ?? ''),
            'Warranty' => (string)($row->warranty ?? ''),
        ];
    }

    return $this->_specDraftJsonResponse([
        'success' => true,
        'data' => [
            'type' => (string)($template->type ?? '3'),
            'subject' => (string)($template->subject ?? ''),
            'specification' => (string)($template->specification ?? ''),
            'sections' => array_values($bySection),
            'comments' => array_map(function ($c) {
                return (string)($c->comment ?? '');
            }, $comments),
        ],
    ]);
}

public function template_preset_data($id = null)
{
    return $this->templatePresetData($id);
}

/**
 * CamelCase alias for URL/action compatibility.
 */
public function templatePresets()
{
    return $this->template_presets();
}

/**
 * CamelCase alias for URL/action compatibility.
 */
public function edit_template_preset($id = null)
{
    return $this->editTemplatePreset($id);
}

/**
 * Keep draft/submitted spec on the same track: DB reserved track, else unique allocate
 * (form preview is used only when not already taken — prevents duplicate DTSPEC numbers).
 */
protected function _resolveSpecTrackNumber($mailerOrDbTrack, array $formData, ?int $excludeId = null): string
{
    $dbTrack = '';
    if (is_object($mailerOrDbTrack)) {
        $dbTrack = (string)($mailerOrDbTrack->tracknumber ?? '');
        if ($excludeId === null && !empty($mailerOrDbTrack->id)) {
            $excludeId = (int)$mailerOrDbTrack->id;
        }
    } elseif (is_string($mailerOrDbTrack)) {
        $dbTrack = $mailerOrDbTrack;
    }
    $dbTrack = $this->Mailer->normalizeSpecTrackNumber($dbTrack);
    if ($dbTrack !== '') {
        return $dbTrack;
    }

    $formTrack = $this->Mailer->normalizeSpecTrackNumber((string)($formData['tracknumber'] ?? ''));

    return $this->Mailer->allocateUniqueSpecTrackNumber(
        $formTrack !== '' ? $formTrack : null,
        $excludeId
    );
}

/**
 * Save an existing draft mailer as submitted: set tracknumber, status, comments/spec_useareas, PDF, email.
 */
protected function _saveEmployeeSpecAsSubmitted(int $mailerId, array $formData, $employee_id): void
{
    $mailerQuery = $this->Mailer->find()
        ->where([
            'Mailer.id' => $mailerId,
            'Mailer.employee_id' => $employee_id,
            'Mailer.save_status' => 'draft',
            'Mailer.type' => 3,
        ]);
    $this->_applyMailerNotDeletedToQuery($mailerQuery);
    $mailer = $mailerQuery->first();
    if (!$mailer) {
        return;
    }
    $tracknumber = $this->_resolveSpecTrackNumber($mailer, $formData);

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
    // use_area: 0 = With Warranty, 1 = Without Warranty (inverse of form spectype).
    $mailer->use_area = isset($formData['spectype'])
        ? (((int)$formData['spectype'] === 1) ? 0 : 1)
        : (int)($formData['use_area'] ?? 0);
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
        $email->setFrom(['kal@durotechindustries.com.au' => 'Durotech Industries']);
        $email->setTo('kal@durotechindustries.com.au');
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
    $this->_markClaudeDraftAppliedIfRequested($formData, $mailerId);
}

/**
 * Mark Claude Spec Assistant draft as applied when employee submits DuroEzy form.
 *
 * @param array<string, mixed> $formData
 */
protected function _markClaudeDraftAppliedIfRequested(array $formData, int $mailerId): void
{
    $claudeDraftId = isset($formData['claude_draft_id']) ? (int)$formData['claude_draft_id'] : 0;
    if ($claudeDraftId <= 0) {
        return;
    }
    try {
        $this->loadModel('ClaudeSpecDrafts');
    } catch (\Throwable $e) {
        return;
    }
    $employeeId = (int)$this->request->getSession()->read('Employee.id');
    try {
        $draft = $this->ClaudeSpecDrafts->get($claudeDraftId);
    } catch (\Throwable $e) {
        return;
    }
    if ((int)$draft->employee_id !== $employeeId || $draft->deleted_at !== null) {
        return;
    }
    $draft->status = 'applied';
    $draft->applied_mailer_id = $mailerId;
    $this->ClaudeSpecDrafts->save($draft);
    $this->request->getSession()->delete('ClaudeSpec.prefill');
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

    $redirect = $this->checkEmployeeSession();
    if ($redirect instanceof Response) {
        return $this->_specDraftJsonResponse(['success' => false, 'error' => 'Session expired. Please login again.']);
    }
    $this->loadModel('Mailer');
    $this->loadModel('MailerComment');
    $this->loadModel('SpecUsearea');

    $employee_id = (int)$this->request->getSession()->read('Employee.id');
    if ($employee_id <= 0) {
        return $this->_specDraftJsonResponse(['success' => false, 'error' => 'Session expired. Please login again.']);
    }

    $hasSaveStatusColumn = $this->Mailer->getSchema()->getColumn('save_status');
    if (!$hasSaveStatusColumn) {
        return $this->_specDraftJsonResponse(['success' => false, 'error' => 'Draft not configured.']);
    }

    $data = $this->request->getData();
    $draftIdFromForm = isset($data['draft_id']) ? (int)$data['draft_id'] : 0;

    $mailer = null;
    if ($draftIdFromForm > 0) {
        $draftById = $this->Mailer->find()->where(['Mailer.id' => $draftIdFromForm]);
        $this->_applyMailerNotDeletedToQuery($draftById);
        $mailer = $draftById->first();
        if (!$mailer || (int)$mailer->employee_id !== (int)$employee_id || $mailer->save_status !== 'draft') {
            $mailer = null;
        }
    }
    if (!$mailer) {
        // Reuse latest existing employee draft when draft_id is missing to prevent duplicate draft rows.
        $latestDraft = $this->Mailer->find()
            ->where([
                'Mailer.employee_id' => $employee_id,
                'Mailer.save_status' => 'draft',
                'Mailer.type' => 3,
            ])
            ->orderDesc('Mailer.id');
        $this->_applyMailerNotDeletedToQuery($latestDraft);
        $mailer = $latestDraft->first();
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
    // use_area: 0 = With Warranty, 1 = Without Warranty (inverse of form spectype).
    $use_area = isset($data['spectype'])
        ? (((int)$data['spectype'] === 1) ? 0 : 1)
        : (int)($data['use_area'] ?? 0);

    $reservedTrack = '';
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
        // Legacy drafts with empty track: reserve once (unique) and keep on later autosaves.
        if ($this->Mailer->normalizeSpecTrackNumber((string)($mailer->tracknumber ?? '')) === '') {
            $mailer->tracknumber = $this->Mailer->allocateUniqueSpecTrackNumber(
                (string)($data['tracknumber'] ?? ''),
                (int)$mailer->id
            );
        }
        $this->Mailer->save($mailer);
        $draftId = $mailer->id;
        $reservedTrack = (string)$mailer->tracknumber;
    } else {
        $reservedTrack = $this->Mailer->allocateUniqueSpecTrackNumber(
            (string)($data['tracknumber'] ?? ''),
            null
        );
        $entity = $this->Mailer->newEntity([
            'employee_id' => $employee_id,
            'spec_v' => 0,
            'tracknumber' => $reservedTrack,
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
            $reservedTrack = (string)$entity->tracknumber;
        } else {
            return $this->_specDraftJsonResponse(['success' => false, 'error' => 'Save failed.']);
        }
    }

    // Keep only one active draft per employee/type by removing older duplicate drafts.
    $otherDrafts = $this->Mailer->find()
        ->select(['id'])
        ->where([
            'Mailer.employee_id' => $employee_id,
            'Mailer.save_status' => 'draft',
            'Mailer.type' => 3,
            'Mailer.id !=' => (int)$draftId,
        ]);
    $this->_applyMailerNotDeletedToQuery($otherDrafts);
    $otherDraftIds = $otherDrafts->enableHydration(false)
        ->all()
        ->extract('id')
        ->toArray();
    if (!empty($otherDraftIds)) {
        $this->MailerComment->deleteAll(['mailer_id IN' => $otherDraftIds]);
        $this->SpecUsearea->deleteAll(['mailer_id IN' => $otherDraftIds]);
        $this->Mailer->deleteAll(['id IN' => $otherDraftIds]);
    }

    // Only replace comments/use-areas when posted with real content (empty comment[] must not wipe).
    if (array_key_exists('comment', $data) && is_array($data['comment'])) {
        $incomingComments = [];
        foreach ($data['comment'] as $comment) {
            $text = trim((string)$comment);
            if ($text !== '') {
                $incomingComments[] = $text;
            }
        }
        if (!empty($incomingComments)) {
            $this->MailerComment->deleteAll(['mailer_id' => $draftId]);
            foreach ($incomingComments as $comment) {
                $commentEntity = $this->MailerComment->newEntity([
                    'mailer_id' => $draftId,
                    'use_area' => 1,
                    'comment' => $comment,
                ]);
                $this->MailerComment->save($commentEntity);
            }
        }
    }
    if (array_key_exists('product', $data) && is_array($data['product'])) {
        $hasProductContent = false;
        foreach ($data['product'] as $prodt) {
            if (trim((string)$prodt) !== '') {
                $hasProductContent = true;
                break;
            }
        }
        if (!$hasProductContent && !empty($data['title']) && is_array($data['title'])) {
            foreach ($data['title'] as $titleVal) {
                if (trim((string)$titleVal) !== '') {
                    $hasProductContent = true;
                    break;
                }
            }
        }
        if ($hasProductContent) {
            $this->SpecUsearea->deleteAll(['mailer_id' => $draftId]);
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
    }

    return $this->_specDraftJsonResponse([
        'success' => true,
        'draft_id' => (int)$draftId,
        'tracknumber' => $reservedTrack,
    ]);
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

    $id = (int)$id;
    $mailer = $this->Mailer->find()
        ->where([
            'Mailer.id' => $id,
            'Mailer.employee_id' => $employee_id,
            'Mailer.type' => 3,
        ])
        ->first();
    if (!$mailer) {
        $this->Flash->error('Spec not found or you cannot delete it.');
        return $this->redirect(['action' => 'index']);
    }

    $hasDeletedAt = (bool)$this->Mailer->getSchema()->getColumn('deleted_at');
    if ($hasDeletedAt) {
        if ($mailer->get('deleted_at') !== null) {
            $this->Flash->error('This spec was already removed from your list.');
            return $this->redirect(['action' => 'index']);
        }
        $mailer->deleted_at = date('Y-m-d H:i:s');
        if ($this->Mailer->save($mailer)) {
            $this->logSpecAudit([
                'mailer_id' => $id,
                'tracknumber' => (string)($mailer->tracknumber ?? ''),
                'action' => 'spec_soft_deleted',
                'actor_role' => 'employee',
                'actor_id' => (int)$employee_id,
                'source' => 'employee_panel',
                'message' => 'Employee removed spec from list (soft delete).',
            ]);
            $this->Flash->success('Spec removed from your list. Contact support if you need it restored.');
        } else {
            $this->Flash->error('Could not remove spec. Please try again.');
        }
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
    $id = (int)$id;
    if ($id <= 0) {
        $this->Flash->error('Invalid spec.');
        return $this->redirect(['action' => 'index']);
    }
    $ownedActive = $this->Mailer->find()
        ->where(['Mailer.id' => $id, 'Mailer.employee_id' => $employee_id, 'Mailer.type' => 3]);
    $this->_applyMailerNotDeletedToQuery($ownedActive);
    if (!$ownedActive->first()) {
        $this->Flash->error('Spec not found or no longer available.');
        return $this->redirect(['action' => 'index']);
    }

    $returnPage = max(1, (int)($this->request->getQuery('page') ?? 1));

    if (!empty($this->request->data)) {
        $returnPage = isset($this->request->data['return_page']) ? max(1, (int)$this->request->data['return_page']) : $returnPage;
        $form_type = $this->request->data['form_type'];

        $exp = explode('/', $this->request->data['date']);
        $date = (count($exp) == 3) ? $exp[2] . '-' . $exp[1] . '-' . $exp[0] : $this->request->data['date'];

        $tracknumber = ($form_type == 0) ? $this->request->data['tracknumber'] : '';
        if ($form_type != 0) {
            // New / revised spec: unique DTSPEC DD-MM + global continuous NNN.
            $tracknumber = $this->Mailer->allocateUniqueSpecTrackNumber(null, null);
        } else {
            $tracknumber = $this->Mailer->normalizeSpecTrackNumber((string)$tracknumber);
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
                // use_area: 0 = With Warranty, 1 = Without Warranty (inverse of form spectype).
                'use_area'      => isset($this->request->data['spectype'])
                    ? (((int)$this->request->data['spectype'] === 1) ? 0 : 1)
                    : (isset($this->request->data['use_area']) ? (int)$this->request->data['use_area'] : 0),
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
            $postedComments = $this->request->getData('comment');
            if (!empty($postedComments) && is_array($postedComments)) {
                foreach ($postedComments as $comment) {
                    $commentText = trim((string)$comment);
                    if ($commentText === '') {
                        continue;
                    }
                    $commentEntity = $this->MailerComment->newEntity([
                        'mailer_id' => $lastinsertId,
                        'use_area' => 1,
                        'comment' => $commentText,
                    ]);
                    $this->MailerComment->save($commentEntity);
                }
            }

            // Replace Use Area rows only when the form posted product rows.
            // Never wipe existing rows on empty/partial POST (comment-only edits, max_input_vars truncation).
            $data = (array)$this->request->getData();
            $postedProducts = isset($data['product']) && is_array($data['product']) ? $data['product'] : null;
            $postedSerials = isset($data['serial']) && is_array($data['serial']) ? $data['serial'] : [];
            $postedTypes = isset($data['types']) && is_array($data['types']) ? $data['types'] : [];
            $postedCoverage = isset($data['coverage']) && is_array($data['coverage']) ? $data['coverage'] : [];
            $postedWarranty = isset($data['Warranty']) && is_array($data['Warranty']) ? $data['Warranty'] : [];
            $postedMft = isset($data['coverage_by_pack']) && is_array($data['coverage_by_pack']) ? $data['coverage_by_pack'] : [];
            $postedTitles = isset($data['title']) && is_array($data['title']) ? $data['title'] : [];

            $existingUseAreaCount = (int)$this->SpecUsearea->find()
                ->where(['mailer_id' => $lastinsertId])
                ->count();

            if ($postedProducts !== null) {
                $postedRowCount = max(
                    count($postedProducts),
                    count($postedSerials),
                    count($postedTypes),
                    count($postedCoverage),
                    count($postedWarranty),
                    count($postedMft)
                );

                // Guard: max_input_vars often truncates later field arrays first,
                // so lengths go out of sync. Intentionally fewer sections is OK when arrays match.
                $fieldLengths = [
                    count($postedProducts),
                    count($postedSerials),
                    count($postedTypes),
                    count($postedCoverage),
                    count($postedWarranty),
                    count($postedMft),
                ];
                $looksTruncated = (
                    $existingUseAreaCount > 0
                    && $postedRowCount > 0
                    && (max($fieldLengths) - min($fieldLengths)) >= 3
                );

                if ($postedRowCount === 0 && $existingUseAreaCount > 0) {
                    // Comment/header-only save with no product fields — keep DB use areas.
                    $this->Flash->warning('Use Area rows were not in the submit data; kept the previous Use Area list.');
                } elseif ($looksTruncated) {
                    $this->Flash->warning(
                        'Use Area submit looked incomplete (' . $postedRowCount . ' of ' . $existingUseAreaCount .
                        ' rows). Kept the previous Use Area list so data was not lost. Try saving again or ask IT to raise max_input_vars.'
                    );
                } else {
                    $this->SpecUsearea->deleteAll(['SpecUsearea.mailer_id' => $lastinsertId], false);
                    for ($key = 0; $key < $postedRowCount; $key++) {
                        $typesKey = $postedTypes[$key] ?? null;
                        $title = ($typesKey !== null && isset($postedTitles[$typesKey]))
                            ? (string)$postedTitles[$typesKey]
                            : '';
                        $specEntity = $this->SpecUsearea->newEntity([
                            'mailer_id' => $lastinsertId,
                            'use_area' => 1,
                            'title' => $title,
                            'product' => (string)($postedProducts[$key] ?? ''),
                            'types' => (string)($typesKey ?? ''),
                            'serial' => (string)($postedSerials[$key] ?? ''),
                            'coverage' => (string)($postedCoverage[$key] ?? ''),
                            'Warranty' => (string)($postedWarranty[$key] ?? ''),
                            'coverage_by_pack' => (string)($postedMft[$key] ?? ''),
                        ]);
                        $this->SpecUsearea->save($specEntity);
                    }
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

            $pdfResponse = @file_get_contents($pdf_url, false, stream_context_create([
                'http' => ['timeout' => 60, 'ignore_errors' => true],
                'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
            ]));

            // generatepdf.php returns JSON with sanitized filename/path — must update DB
            // or the list/view keeps linking to the previous PDF.
            $generatedPdfFileName = $pdfname . '.pdf';
            $pdfPath = 'dompdf/' . $generatedPdfFileName;
            if ($pdfResponse !== false && $pdfResponse !== '') {
                $json = json_decode($pdfResponse, true);
                if (is_array($json) && !empty($json['success'])) {
                    if (!empty($json['filename'])) {
                        $generatedPdfFileName = (string)$json['filename'];
                    }
                    if (!empty($json['path'])) {
                        $pdfPath = (string)$json['path'];
                    } else {
                        $pdfPath = 'dompdf/' . $generatedPdfFileName;
                    }
                }
            }

            $oldPdfAttachment = (string)($savedMailer->pdf_attachment ?? '');
            $savedMailer->pdf_attachment = $pdfPath;
            $this->Mailer->save($savedMailer);

            // Remove previous generated PDF if path changed (avoid serving stale file).
            if ($oldPdfAttachment !== '' && $oldPdfAttachment !== $pdfPath) {
                $oldFull = WWW_ROOT . str_replace(['/', '\\'], DS, $oldPdfAttachment);
                if (is_file($oldFull) && strpos(str_replace('\\', '/', $oldPdfAttachment), 'dompdf/') === 0) {
                    @unlink($oldFull);
                }
            }

            $pdfFilePath = WWW_ROOT . str_replace(['/', '\\'], DS, $pdfPath);

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

                // Attach the newly generated PDF
                $email->setAttachments([
                    $generatedPdfFileName => [
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
                    'pdf_attachment' => $pdfPath,
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
        ->where(['Mailer.id' => $id, 'Mailer.employee_id' => $employee_id, 'Mailer.type' => 3])
        ->contain(['MailerComment', 'SpecUsearea']);
    $this->_applyMailerNotDeletedToQuery($MailerArr);
    $MailerArr = $MailerArr->first();
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
            ]);
        $this->_applyMailerNotDeletedToQuery($mailer);
        $mailer = $mailer->first();

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

    /**
     * Regenerate and open a fresh PDF for design review (does not update pdf_attachment).
     */
    public function preview_pdf($id = null)
    {
        $this->autoRender = false;

        $redirect = $this->checkEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $employee_id = (int)$this->Session->read('Employee.id');
        $id = (int)$id;
        if ($id <= 0) {
            $this->Flash->error('Invalid spec.');
            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('Mailer');
        $mailerQuery = $this->Mailer->find()
            ->where([
                'Mailer.id' => $id,
                'Mailer.employee_id' => $employee_id,
                'Mailer.type' => 3,
            ]);
        $this->_applyMailerNotDeletedToQuery($mailerQuery);
        $mailer = $mailerQuery->first();

        if (empty($mailer)) {
            $this->Flash->error('Spec not found or no longer available.');
            return $this->redirect(['action' => 'index']);
        }

        $mailerId = (int)$mailer->id;
        $tracknumber = (string)($mailer->tracknumber ?? '');
        $safeTrack = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $tracknumber);
        $safeTrack = trim((string)preg_replace('/_+/', '_', (string)$safeTrack), '_');
        if ($safeTrack === '') {
            $safeTrack = 'draft';
        }

        // Unique preview filename so official email/download PDF is not overwritten.
        $pdfname = 'preview_' . $mailerId . '_' . $safeTrack;
        $useArea = (int)($mailer->use_area ?? 0);

        $fields = [
            'tracknumber' => $tracknumber,
            'mailer_id' => $mailerId,
            'name' => (string)($mailer->name ?? ''),
            'email' => (string)($mailer->email ?? ''),
            'address' => (string)($mailer->address ?? ''),
            'company' => (string)($mailer->company ?? ''),
            'specification' => (string)($mailer->specification ?? ''),
            'date' => (string)($mailer->date ?? ''),
            'subject' => (string)($mailer->subject ?? ''),
            'type' => (string)($mailer->type ?? '3'),
            'pdfname' => $pdfname,
            'use_area' => $useArea,
        ];
        $fields_string = http_build_query($fields);

        // use_area: 0 = With Warranty column, 1 = Without.
        $url = ($useArea === 0)
            ? SITEURL . 'dompdf/generatepdf.php?' . $fields_string
            : SITEURL . 'dompdf/generatewithoutpdf.php?' . $fields_string;

        $arrContextOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]];
        $pdfResponse = @file_get_contents($url, false, stream_context_create($arrContextOptions));

        $generatedPdfFileName = $pdfname . '.pdf';
        if ($pdfResponse !== false) {
            $json = json_decode($pdfResponse, true);
            if (is_array($json) && !empty($json['filename'])) {
                $generatedPdfFileName = (string)$json['filename'];
            } elseif (is_array($json) && isset($json['success']) && $json['success'] === false) {
                $this->Flash->error('Unable to generate PDF preview.');
                return $this->redirect(['action' => 'index']);
            }
        }

        $pdfFilePath = WWW_ROOT . 'dompdf' . DS . $generatedPdfFileName;
        if (!is_file($pdfFilePath)) {
            $this->Flash->error('PDF preview file was not created.');
            return $this->redirect(['action' => 'index']);
        }

        $previewUrl = rtrim((string)SITEURL, '/') . '/dompdf/' . rawurlencode($generatedPdfFileName) . '?v=' . filemtime($pdfFilePath);
        return $this->redirect($previewUrl);
    }

    /**
     * CakePHP dashed/camelCase alias for preview_pdf().
     */
    public function previewPdf($id = null)
    {
        return $this->preview_pdf($id);
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

        $query = $this->CaseStudy->find();

        $hasCreatedBy = $this->CaseStudy->getSchema()->hasColumn('created_by');
        if ($hasCreatedBy) {
            $query->where(['CaseStudy.created_by' => $employee_id])
                ->contain(['Employee']);
        }

        $schema = $this->CaseStudy->getSchema();
        $filters = [
            'keyword' => trim((string)$this->request->getQuery('keyword')),
            'status' => trim((string)$this->request->getQuery('status')),
            'date_from' => trim((string)$this->request->getQuery('date_from')),
            'date_to' => trim((string)$this->request->getQuery('date_to')),
        ];

        if ($filters['keyword'] !== '') {
            $keywordLike = '%' . $filters['keyword'] . '%';
            $searchFields = [];
            foreach (['title', 'location', 'short_summary', 'challenge', 'solution', 'outcome'] as $field) {
                if ($schema->hasColumn($field)) {
                    $searchFields['CaseStudy.' . $field . ' LIKE'] = $keywordLike;
                }
            }
            if (!empty($searchFields)) {
                $query->andWhere(['OR' => $searchFields]);
            }
        }

        if ($filters['status'] !== '' && $schema->hasColumn('status')) {
            $query->andWhere(['CaseStudy.status' => (int)$filters['status']]);
        }

        if ($filters['date_from'] !== '' && $schema->hasColumn('project_date')) {
            $query->andWhere(['CaseStudy.project_date >=' => $filters['date_from']]);
        }

        if ($filters['date_to'] !== '' && $schema->hasColumn('project_date')) {
            $query->andWhere(['CaseStudy.project_date <=' => $filters['date_to']]);
        }

        // LIFO: newest records first (id is reliable even when created is NULL).
        $order = ['CaseStudy.id' => 'DESC'];
        if ($schema->hasColumn('created')) {
            $order = ['CaseStudy.created' => 'DESC', 'CaseStudy.id' => 'DESC'];
        } elseif ($schema->hasColumn('modified')) {
            $order = ['CaseStudy.modified' => 'DESC', 'CaseStudy.id' => 'DESC'];
        }
        $query->order($order);

        $caseStudies = $this->paginate($query, [
            'limit' => 15,
            'maxLimit' => 100,
            'order' => $order,
        ]);
        $this->set(compact('caseStudies', 'filters'));
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

                $this->_saveCaseStudyProducts($caseId, $this->_extractProductIdsFromRequest());

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

        $products = $this->_activeProductsList();

        $this->set(compact('products'));
   }

    /** CakePHP 3 action alias. */
    public function caseAdd() {
        return $this->case_add();
    }

    /**
     * Active products for case study forms.
     *
     * @return array<int, string>
     */
    protected function _activeProductsList()
    {
        $query = $this->Product->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->orderAsc('Product.title');

        if ($this->Product->getSchema()->hasColumn('status')) {
            $query->where(['Product.status' => 1]);
        }

        return $query->toArray();
    }

    /**
     * Read selected product ids from the request.
     *
     * @return array<int>
     */
    protected function _extractProductIdsFromRequest()
    {
        $data = $this->request->getData();
        $ids = [];

        if (!empty($data['products']['_ids'])) {
            $ids = $data['products']['_ids'];
        } elseif (!empty($data['CaseStudy']['products']['_ids'])) {
            $ids = $data['CaseStudy']['products']['_ids'];
        } elseif (isset($data['products._ids'])) {
            $ids = $data['products._ids'];
        }

        if (!is_array($ids)) {
            $ids = ($ids === '' || $ids === null) ? [] : [$ids];
        }

        return array_values(array_filter(array_map('intval', $ids)));
    }

    /**
     * Save case study product associations.
     *
     * @param int $caseId Case study id
     * @param array<int> $productIds Product ids
     * @return bool
     */
    protected function _saveCaseStudyProducts($caseId, array $productIds)
    {
        $caseId = (int)$caseId;
        if ($caseId <= 0) {
            return false;
        }

        try {
            $entity = $this->CaseStudy->get($caseId);
            $entity = $this->CaseStudy->patchEntity($entity, [
                'products' => ['_ids' => $productIds],
            ], [
                'associated' => ['Products'],
            ]);

            return (bool)$this->CaseStudy->save($entity);
        } catch (\Exception $e) {
            CakeLog::error('Failed to save case study products: ' . $e->getMessage());

            return false;
        }
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

    protected function _getFlatUploadedFile($field)
    {
        if (empty($_FILES[$field]['tmp_name'])) {
            return null;
        }
        $tmp = $_FILES[$field]['tmp_name'];
        if (!is_string($tmp) || !is_uploaded_file($tmp)) {
            return null;
        }

        return [
            'tmp_name' => $tmp,
            'name' => $_FILES[$field]['name'] ?? '',
            'error' => (int)($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE),
            'type' => $_FILES[$field]['type'] ?? '',
            'size' => (int)($_FILES[$field]['size'] ?? 0),
        ];
    }

    protected function _resolveUploadedFile($field)
    {
        $psr7 = $this->request->getUploadedFile($field);
        if ($psr7 instanceof UploadedFileInterface && $psr7->getError() === UPLOAD_ERR_OK) {
            return $psr7;
        }

        $nested = $this->request->getUploadedFile('CaseStudy.' . $field);
        if ($nested instanceof UploadedFileInterface && $nested->getError() === UPLOAD_ERR_OK) {
            return $nested;
        }

        $file = $this->_getUploadedFile('data', 'CaseStudy', $field)
            ?? $this->_getFlatUploadedFile($field);

        if ($file !== null) {
            return $file;
        }

        $data = $this->request->getData();
        $legacy = $this->request->data ?? [];
        $candidates = [
            $data[$field] ?? null,
            $data['CaseStudy'][$field] ?? null,
            $legacy[$field] ?? null,
            $legacy['CaseStudy'][$field] ?? null,
        ];
        foreach ($candidates as $candidate) {
            if ($candidate instanceof UploadedFileInterface && $candidate->getError() === UPLOAD_ERR_OK) {
                return $candidate;
            }
            if (is_array($candidate) && !empty($candidate['tmp_name']) && ($candidate['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                return $candidate;
            }
        }

        return null;
    }

    protected function _moveUploadTo($file, $dest)
    {
        if ($file instanceof UploadedFileInterface) {
            if ($file->getError() !== UPLOAD_ERR_OK) {
                return false;
            }
            try {
                $file->moveTo($dest);

                return true;
            } catch (\Throwable $e) {
                CakeLog::error('Case study upload moveTo failed: ' . $e->getMessage());

                return false;
            }
        }

        if (!is_array($file) || empty($file['tmp_name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return false;
        }

        $tmp = $file['tmp_name'];
        if (is_uploaded_file($tmp)) {
            return move_uploaded_file($tmp, $dest);
        }

        if (is_string($tmp) && file_exists($tmp)) {
            return copy($tmp, $dest);
        }

        return false;
    }

    protected function _uploadClientFilename($file)
    {
        if ($file instanceof UploadedFileInterface) {
            return $file->getClientFilename() ?? '';
        }

        return $file['name'] ?? '';
    }

    protected function _ensureCaseStudyUploadDir($caseId)
    {
        $uploadDir = WWW_ROOT . 'files' . DS . 'case_studies' . DS . $caseId . DS;
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        return $uploadDir;
    }

    protected function _saveDatasheet($caseId, $uploadDir)
    {
        $ds = $this->_resolveUploadedFile('datasheet_file');
        if ($ds === null) {
            return;
        }

        $ext = strtolower(pathinfo($this->_uploadClientFilename($ds), PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            return;
        }

        $datasheetName = 'datasheet_' . time() . '.' . $ext;
        $dest = $uploadDir . $datasheetName;
        if ($this->_moveUploadTo($ds, $dest)) {
            $ent = $this->CaseStudy->get($caseId);
            $this->CaseStudy->patchEntity($ent, ['datasheet' => 'files/case_studies/' . $caseId . '/' . $datasheetName]);
            $this->CaseStudy->save($ent);
        }
    }

    protected function _saveFeaturedImage($caseId, $uploadDir, $replaceExisting)
    {
        $fi = $this->_resolveUploadedFile('featured_image');
        if ($fi === null) {
            return;
        }

        $ext = strtolower(pathinfo($this->_uploadClientFilename($fi), PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            return;
        }

        if ($replaceExisting) {
            $existing = $this->CaseStudy->get($caseId);
            if (!empty($existing->featured_image)) {
                $oldPath = WWW_ROOT . str_replace('/', DS, $existing->featured_image);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
        }

        $featuredName = 'featured_' . time() . '.' . $ext;
        $dest = $uploadDir . $featuredName;
        if ($this->_moveUploadTo($fi, $dest)) {
            $ent = $this->CaseStudy->get($caseId);
            $this->CaseStudy->patchEntity($ent, ['featured_image' => 'files/case_studies/' . $caseId . '/' . $featuredName]);
            $this->CaseStudy->save($ent);
        }
    }

    protected function _saveTypedCaseImage($caseId, $file, $type)
    {
        if (!in_array($type, ['before', 'after'], true) || $file === null) {
            return;
        }

        $this->loadModel('CaseImage');

        $ext = strtolower(pathinfo($this->_uploadClientFilename($file), PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            return;
        }

        $existing = $this->CaseImage->find()
            ->where(['case_study_id' => $caseId, 'type' => $type])
            ->all();

        foreach ($existing as $row) {
            $filePath = WWW_ROOT . str_replace('/', DS, $row->filename);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            $this->CaseImage->delete($row);
        }

        $uploadDir = $this->_ensureCaseStudyUploadDir($caseId);
        $imgDir = $uploadDir . 'images' . DS;
        if (!file_exists($imgDir)) {
            mkdir($imgDir, 0755, true);
        }

        $safeName = $type . '_' . time() . '_' . mt_rand(100, 999) . '.' . $ext;
        $finalPath = $imgDir . $safeName;

        if ($this->_moveUploadTo($file, $finalPath)) {
            $imgEntity = $this->CaseImage->newEntity([
                'case_study_id' => $caseId,
                'filename' => 'files/case_studies/' . $caseId . '/images/' . $safeName,
                'type' => $type,
                'caption' => null,
                'ordering' => $type === 'before' ? 0 : 1,
            ]);
            if (!$this->CaseImage->save($imgEntity)) {
                @unlink($finalPath);
            }
        }
    }

    protected function _handleUploads($caseId)
    {
        $this->loadModel('CaseImage');
        $uploadDir = $this->_ensureCaseStudyUploadDir($caseId);

        $this->_saveDatasheet($caseId, $uploadDir);
        $this->_saveFeaturedImage($caseId, $uploadDir, false);
        $this->_saveTypedCaseImage($caseId, $this->_resolveUploadedFile('before_image'), 'before');
        $this->_saveTypedCaseImage($caseId, $this->_resolveUploadedFile('after_image'), 'after');
        $this->_saveGalleryImages($caseId);
    }

    protected function _collectGalleryUploads()
    {
        $files = [];

        $uploaded = $this->request->getUploadedFiles();
        if (!empty($uploaded['gallery_images'])) {
            foreach ((array)$uploaded['gallery_images'] as $file) {
                if ($file instanceof UploadedFileInterface && $file->getError() === UPLOAD_ERR_OK) {
                    $files[] = $file;
                }
            }
        }

        if (!empty($_FILES['gallery_images']['name'])) {
            $names = $_FILES['gallery_images']['name'];
            if (is_array($names)) {
                foreach ($names as $i => $name) {
                    if ($name === '' || ($_FILES['gallery_images']['error'][$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                        continue;
                    }
                    $tmp = $_FILES['gallery_images']['tmp_name'][$i] ?? '';
                    if (!is_string($tmp) || $tmp === '') {
                        continue;
                    }
                    $files[] = [
                        'tmp_name' => $tmp,
                        'name' => $name,
                        'error' => (int)$_FILES['gallery_images']['error'][$i],
                        'type' => $_FILES['gallery_images']['type'][$i] ?? '',
                        'size' => (int)($_FILES['gallery_images']['size'][$i] ?? 0),
                    ];
                }
            } elseif (is_string($names) && $names !== '' && ($_FILES['gallery_images']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                $files[] = [
                    'tmp_name' => $_FILES['gallery_images']['tmp_name'],
                    'name' => $names,
                    'error' => (int)$_FILES['gallery_images']['error'],
                    'type' => $_FILES['gallery_images']['type'] ?? '',
                    'size' => (int)($_FILES['gallery_images']['size'] ?? 0),
                ];
            }
        }

        if (!empty($_FILES['data']['tmp_name']['CaseStudy']['gallery_images'])) {
            $nested = $_FILES['data'];
            $names = $nested['name']['CaseStudy']['gallery_images'] ?? null;
            if (is_array($names)) {
                foreach ($names as $i => $name) {
                    if ($name === '' || ($nested['error']['CaseStudy']['gallery_images'][$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                        continue;
                    }
                    $files[] = [
                        'tmp_name' => $nested['tmp_name']['CaseStudy']['gallery_images'][$i],
                        'name' => $name,
                        'error' => (int)$nested['error']['CaseStudy']['gallery_images'][$i],
                        'type' => $nested['type']['CaseStudy']['gallery_images'][$i] ?? '',
                        'size' => (int)($nested['size']['CaseStudy']['gallery_images'][$i] ?? 0),
                    ];
                }
            }
        }

        $data = $this->request->getData();
        $legacy = $this->request->data ?? [];
        $dataFiles = $data['gallery_images'] ?? $data['CaseStudy']['gallery_images'] ?? $legacy['gallery_images'] ?? $legacy['CaseStudy']['gallery_images'] ?? null;
        if (is_array($dataFiles)) {
            foreach ($dataFiles as $candidate) {
                if ($candidate instanceof UploadedFileInterface && $candidate->getError() === UPLOAD_ERR_OK) {
                    $files[] = $candidate;
                } elseif (is_array($candidate) && !empty($candidate['tmp_name']) && ($candidate['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                    $files[] = $candidate;
                }
            }
        }

        return $files;
    }

    protected function _saveGalleryImages($caseId)
    {
        $files = $this->_collectGalleryUploads();
        if (empty($files)) {
            return;
        }

        $this->loadModel('CaseImage');
        $uploadDir = $this->_ensureCaseStudyUploadDir($caseId);
        $imgDir = $uploadDir . 'images' . DS;
        if (!file_exists($imgDir)) {
            mkdir($imgDir, 0755, true);
        }

        $ordering = (int)$this->CaseImage->find()
            ->where(['case_study_id' => $caseId, 'type' => 'other'])
            ->count();

        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        foreach ($files as $file) {
            $ext = strtolower(pathinfo($this->_uploadClientFilename($file), PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExts, true)) {
                continue;
            }

            $safeName = 'gallery_' . time() . '_' . mt_rand(100, 999) . '.' . $ext;
            $finalPath = $imgDir . $safeName;
            if ($this->_moveUploadTo($file, $finalPath)) {
                $imgEntity = $this->CaseImage->newEntity([
                    'case_study_id' => $caseId,
                    'filename' => 'files/case_studies/' . $caseId . '/images/' . $safeName,
                    'type' => 'other',
                    'caption' => null,
                    'ordering' => $ordering++,
                ]);
                if (!$this->CaseImage->save($imgEntity)) {
                    @unlink($finalPath);
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

                $this->_saveCaseStudyProducts($id, $this->_extractProductIdsFromRequest());
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
                $case = $this->CaseStudy->get($id, ['contain' => ['CaseImage', 'Products']]);
                $case = $this->CaseStudy->patchEntity($case, $caseData, ['validate' => false]);
                $this->request = $this->request->withData('CaseStudy', array_merge($caseData, ['featured_image' => $featuredImage, 'datasheet_file' => $datasheetFile]));
            }
        } else {
            $case = $this->CaseStudy->get($id, ['contain' => ['CaseImage', 'Products']]);
            $this->request = $this->request->withParsedBody(['CaseStudy' => $case->toArray()]);
        }

        if (!isset($case)) {
            $case = $this->CaseStudy->get($id, ['contain' => ['CaseImage', 'Products']]);
        }
        $products = $this->_activeProductsList();
        $this->set(compact('case', 'products'));
    }

    /** CakePHP 3 action alias. */
    public function caseEdit($id = null) {
        return $this->case_edit($id);
    }

    public function edit_handleUploads($caseId)
    {
        $this->loadModel('CaseImage');

        $uploadDir = $this->_ensureCaseStudyUploadDir($caseId);

        $this->_saveDatasheet($caseId, $uploadDir);
        $this->_saveFeaturedImage($caseId, $uploadDir, true);
        $this->_saveTypedCaseImage($caseId, $this->_resolveUploadedFile('before_image'), 'before');
        $this->_saveTypedCaseImage($caseId, $this->_resolveUploadedFile('after_image'), 'after');
        $this->_saveGalleryImages($caseId);

        /* ------------------------------
        * Update Existing Image Details
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
    public function delete_case_featured($caseId = null)
    {
        return $this->_employeeClearCaseStudyMediaField($caseId, 'featured_image', __('Cover image removed.'));
    }

    public function delete_case_datasheet($caseId = null)
    {
        return $this->_employeeClearCaseStudyMediaField($caseId, 'datasheet', __('Datasheet removed.'));
    }

    /** CakePHP 3 action aliases. */
    public function deleteCaseFeatured($caseId = null)
    {
        return $this->delete_case_featured($caseId);
    }

    public function deleteCaseDatasheet($caseId = null)
    {
        return $this->delete_case_datasheet($caseId);
    }

    /**
     * Remove featured image or datasheet from an employee case study.
     *
     * @param int|null $caseId Case study id
     * @param string $field featured_image|datasheet
     * @param string $successMessage Flash message
     * @return \Cake\Http\Response|null
     */
    protected function _employeeClearCaseStudyMediaField($caseId, $field, $successMessage)
    {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->checkEmployeeSession();

        if (!$caseId || !in_array($field, ['featured_image', 'datasheet'], true)) {
            $this->Flash->error(__('Invalid request.'));
            return $this->redirect(['action' => 'case_studies']);
        }

        $caseId = (int)$caseId;
        try {
            $entity = $this->CaseStudy->get($caseId);
        } catch (\Exception $e) {
            $this->Flash->error(__('Case study not found.'));
            return $this->redirect(['action' => 'case_studies']);
        }

        $path = (string)($entity->get($field) ?? '');
        if ($path !== '') {
            $filePath = WWW_ROOT . str_replace('/', DS, ltrim($path, '/'));
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $entity->set($field, null);
        if ($this->CaseStudy->save($entity)) {
            $this->Flash->success($successMessage);
        } else {
            $this->Flash->error(__('Could not remove file.'));
        }

        return $this->redirect(['action' => 'case_edit', $caseId]);
    }

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
    $this->_applyMailerNotDeletedToQuery($baseQuery);

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