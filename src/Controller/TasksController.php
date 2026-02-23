<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\Http\Exception\NotFoundException;

/**
 * Tasks Controller (DuroLab - CakePHP 3.10)
 */
class TasksController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('Tasks');
        $this->loadModel('TaskAssigns');
        $this->loadModel('TaskDocuments');
        $this->loadModel('TaskComments');
        $this->loadModel('User');
        $this->loadModel('NappUser');
        $this->loadModel('UserPermission');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event): ?Response
    {
        $result = parent::beforeFilter($event);
        if ($result instanceof Response) {
            return $result;
        }
        $this->callConstants();
        return null;
    }

    /**
     * Staff: DuroLab type selection (product / technical / project_enquiry). Sets session and redirects to index.
     * URL: /tasks/type or /tasks/type/<data>
     */
    public function type($data = null): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' :: DuroLab Access');
        $result = $this->checkSatffSession();
        if ($result instanceof Response) {
            return $result;
        }

        if ($data === 'product') {
            $this->request->getSession()->write('durolab_type', 'product');
            return $this->redirect(['action' => 'index']);
        }
        if ($data === 'technical') {
            $this->request->getSession()->write('durolab_type', 'technical');
            return $this->redirect(['action' => 'index']);
        }
        if ($data === 'project_enquiry') {
            $this->request->getSession()->write('durolab_type', 'project_enquiry');
            return $this->redirect(['action' => 'index']);
        }

        $customerId = (int) $this->request->getSession()->read('Customer.id');
        $userArr = [];
        if ($customerId) {
            $perms = $this->UserPermission->find()
                ->where(['UserPermission.user_id' => $customerId])
                ->all();
            foreach ($perms as $p) {
                $pArr = $p->toArray();
                if (isset($pArr['department_id']) && $pArr['department_id'] !== null && !in_array((int) $pArr['department_id'], $userArr, true)) {
                    $userArr[] = (int) $pArr['department_id'];
                }
            }
            if (empty($userArr)) {
                $userArr = [6, 7];
            }
        }
        $this->set('userArr', $userArr);
        return null;
    }

    /**
     * Staff: Task list. Redirect to admin task list.
     */
    public function index(): ?Response
    {
        return $this->redirect('/admin/tasks');
    }

    /**
     * Admin: DuroLab type selection (product / technical / project_enquiry). Sets session and redirects to index.
     */
    public function admin_type($data = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' :: DuroLab Access');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }

        if ($data === 'product') {
            $this->request->getSession()->write('durolab_type', 'product');
            return $this->redirect(['action' => 'admin_index']);
        }
        if ($data === 'technical') {
            $this->request->getSession()->write('durolab_type', 'technical');
            return $this->redirect(['action' => 'admin_index']);
        }
        if ($data === 'project_enquiry') {
            $this->request->getSession()->write('durolab_type', 'project_enquiry');
            return $this->redirect(['action' => 'admin_index']);
        }

        return null;
    }

    /**
     * Admin: Task list (DuroLab). Requires durolab_type in session; OTP flow for first access.
     */
    public function admin_index(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' :: Task List');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }

        $session = $this->request->getSession();
        $userId = (int)$session->read('User.id');
        // Search uses GET (no CSRF); OTP submit uses POST
        $data = $this->request->getData();
        $keyword = trim((string)($this->request->getQuery('keyowrd') ?? $data['keyowrd'] ?? ''));
        $this->set('is_access', 0);
        $opt = $session->read('opt');
        $pdfaceess = $session->read('pdfaceess');

        if ($keyword !== '') {
            $this->set('is_access', 2);
        }
        if (!empty($data) && $keyword === '' && isset($data['otp'])) {
            $uotp = str_replace(' ', '', (string)($data['otp'] ?? ''));
            $userArr = $this->User->find()
                ->where(['User.otp' => $uotp, 'User.id' => $userId])
                ->first();
            if ($userArr) {
                $this->User->updateAll(['otp' => ''], ['id' => $userId]);
                $session->write('pdfaceess', 1);
                $session->delete('opt');
                $this->Flash->success('Thank for verifying your account.');
                return $this->redirect(['action' => 'admin_index']);
            }
            $this->Flash->error('Wrong otp password. Please try again.');
            return $this->redirect(['action' => 'admin_index']);
        } elseif (!empty($opt)) {
            $this->set('is_access', 1);
        } elseif (!empty($pdfaceess)) {
            $this->set('is_access', 2);
        } elseif (empty($pdfaceess)) {
            $rand = (string)rand(0, 999999);
            $this->User->updateAll(['otp' => $rand], ['id' => $userId]);
            $userArr = $this->User->get($userId);
            $name = $userArr->name ?? '';
            $to = $userArr->username ?? ($userArr->email ?? '');
            $subject = (defined('SITENAME') ? SITENAME : '') . " :: Secure One-Time-Password (OTP) for DuroLab Access. OTP is " . $rand;
            $templateName = 'durolabotp';
            $variables = ['email' => $to, 'name' => $name, 'otp' => $rand];
            try {
                $this->sendemail($to, $subject, $templateName, $variables);
            } catch (\Exception $e) {
                // log if needed
            }
            $session->write('opt', $rand);
            $session->write('name', $name);
            $this->Flash->success('OTP sent at email. Please check your mail and verify.');
            return $this->redirect(['action' => 'admin_index']);
        }

        $durolabType = $session->read('durolab_type');
        if (empty($durolabType)) {
            $this->Flash->warning('Please select DuroLab type first.');
            return $this->redirect(['action' => 'admin_type']);
        }

        $query = $this->Tasks->find()
            ->contain([
                'User' => function ($q) {
                    return $q->select(['name', 'username']);
                },
                'NappUser' => function ($q) {
                    return $q->select(['name', 'lname']);
                },
                'TaskAssigns' => function ($q) {
                    return $q->contain(['NappUser' => function ($q2) {
                        return $q2->select(['name', 'lname']);
                    }]);
                },
            ])
            ->where(['Tasks.task_type' => $durolabType])
            ->orderDesc('Tasks.id');

        if ($keyword !== '') {
            $query->where([
                'OR' => [
                    'Tasks.title LIKE' => '%' . $keyword . '%',
                    'Tasks.task_id LIKE' => '%' . $keyword . '%',
                ],
                'Tasks.task_type' => $durolabType,
            ]);
        }

        $task = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('task', 'keyword'));

        $usernewArr = $this->User->find()->where(['User.id' => $userId])->first();
        $this->set('usernewArr', $usernewArr);

        return null;
    }

    /**
     * CamelCase alias for admin_type
     */
    public function adminType($data = null): ?Response
    {
        return $this->admin_type($data);
    }

    /**
     * CamelCase alias for admin_index
     */
    public function adminIndex(): ?Response
    {
        return $this->admin_index();
    }

    /**
     * Admin: Add Task – form and save (documents, assigns, optional emails).
     */
    public function admin_add(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Add Task');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }

        $session = $this->request->getSession();
        $durolabType = $session->read('durolab_type');
        if (empty($durolabType)) {
            $this->Flash->warning('Please select DuroLab type first.');
            return $this->redirect(['action' => 'admin_type']);
        }

        $userId = (int)$session->read('User.id');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $foldername = trim((string)($data['task_id'] ?? ''));
            if ($foldername === '') {
                $this->Flash->error('Task ID is required.');
                return null;
            }

            $task = $this->Tasks->newEntity([
                'admin_id' => $userId,
                'task_type' => $durolabType,
                'task_id' => $foldername,
                'title' => $data['title'] ?? '',
                'description' => $data['description'] ?? '',
                'alloteddate' => !empty($data['alloteddate']) ? $data['alloteddate'] : date('Y-m-d'),
                'assignedby' => $data['assignedby'] ?? $session->read('User.name'),
                'is_notify' => (int)($data['is_notify'] ?? 1),
                'created' => date('Y-m-d H:i:s'),
                'last_update' => date('Y-m-d H:i:s'),
                'task_status' => 0,
            ]);

            if ($durolabType === 'project_enquiry') {
                $task->is_new_old = (int)($data['is_new_old'] ?? 1);
                $task->client_name = $data['client_name'] ?? '';
                $task->client_company_name = $data['client_company_name'] ?? '';
                $task->projected_sales_figure = $data['projected_sales_figure'] ?? '';
                $task->time_frame = $data['time_frame'] ?? '';
            }

            if ($this->Tasks->save($task)) {
                $taskId = (int)$task->id;
                $path = WWW_ROOT . 'document' . DS . $foldername;
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                $files = $this->request->getUploadedFiles();
                $docFiles = $files['document'] ?? null;
                if ($docFiles !== null) {
                    $docs = is_array($docFiles) ? $docFiles : [$docFiles];
                    foreach ($docs as $file) {
                        if ($file instanceof \Psr\Http\Message\UploadedFileInterface && $file->getError() === UPLOAD_ERR_OK && $file->getClientFilename()) {
                            $filename = time() . '_' . $file->getClientFilename();
                            $file->moveTo($path . DS . $filename);
                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                            $this->TaskDocuments->save($this->TaskDocuments->newEntity([
                                'admin_id' => $userId,
                                'task_id' => $taskId,
                                'document' => $foldername,
                                'filename' => $filename,
                                'ext' => $ext,
                                'created' => date('Y-m-d H:i:s'),
                                'is_upload' => 0,
                            ]));
                        }
                    }
                }

                $employeIds = $data['employe_id'] ?? [];
                if (is_array($employeIds) && count($employeIds) > 0) {
                    $this->TaskAssigns->deleteAll(['task_id' => $taskId]);
                    $taskRow = $this->Tasks->get($taskId, ['fields' => ['task_type', 'title', 'task_id']]);
                    $sendername = $session->read('User.name') ?? 'Admin';
                    foreach ($employeIds as $empId) {
                        $empId = (int)$empId;
                        if ($empId <= 0) {
                            continue;
                        }
                        $this->TaskAssigns->save($this->TaskAssigns->newEntity([
                            'emp_id' => $empId,
                            'task_id' => $taskId,
                        ]));
                        $userArr = $this->NappUser->find()->where(['NappUser.id' => $empId])->select(['id', 'name', 'lname', 'email'])->first();
                        if ($userArr && !empty($userArr->email)) {
                            $receivername = trim(($userArr->name ?? '') . ' ' . ($userArr->lname ?? ''));
                            $url = (defined('SITEURL') ? SITEURL : '') . 'admin/tasks/adminautologin/' . base64_encode((string)$userArr->id) . '/task/' . $taskRow->task_type;
                            $variables = [
                                'sendername' => $sendername,
                                'receivername' => $receivername,
                                'task_type' => $taskRow->task_type,
                                'task_task_id' => $taskRow->task_id,
                                'task_title' => $taskRow->title,
                                'user_id' => $userArr->id,
                                'url' => $url,
                            ];
                            try {
                                $this->sendemail(
                                    $userArr->email,
                                    (defined('SITENAME') ? SITENAME : '') . ' :: New task assigned by ' . $sendername,
                                    'assign_task',
                                    $variables
                                );
                            } catch (\Exception $e) {
                                // log
                            }
                        }
                    }
                }

                $this->Flash->success('The task has been added.');
                return $this->redirect(['action' => 'admin_index']);
            }
            $this->Flash->error('The task could not be saved. Please try again.');
        }

        $lastTask = $this->Tasks->find()->orderDesc('Tasks.id')->first();
        $nextId = $lastTask ? (int)$lastTask->id + 10000 : 10000;
        if ($durolabType === 'project_enquiry') {
            $foldername = 'PE-' . $nextId;
        } elseif ($durolabType === 'product') {
            $foldername = 'TP-' . $nextId;
        } else {
            $foldername = 'TS-' . $nextId;
        }

        $permIds = $durolabType === 'project_enquiry' ? [9] : [6, 7];
        $empIds = $this->UserPermission->find('list', [
            'keyField' => 'user_id',
            'valueField' => 'user_id',
        ])->where(['permssion_id IN' => $permIds])->toArray();
        $empIds = array_values(array_unique($empIds));

        $employeArr = [];
        if (count($empIds) > 0) {
            $employeArr = $this->NappUser->find()
                ->where(['NappUser.is_staff_id' => 1, 'NappUser.id IN' => $empIds])
                ->select(['id', 'name', 'lname'])
                ->toArray();
        }

        $this->set(compact('foldername', 'employeArr'));
        return null;
    }

    /** CamelCase alias for routes/links that use adminAdd */
    public function adminAdd(): ?Response
    {
        return $this->admin_add();
    }

    public function admin_edit($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Edit Task');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }
        $id = (int)$id;
        if (!$id || !$this->Tasks->exists(['id' => $id])) {
            throw new NotFoundException(__('Invalid task'));
        }

        $task = $this->Tasks->get($id);
        $session = $this->request->getSession();
        $durolabType = $session->read('durolab_type') ?: 'technical';
        $this->set('durolab_type', $durolabType);

        if ($this->request->is(['post', 'put'])) {
            $raw = $this->request->getData('Task') ?? $this->request->getData();
            $integerFields = ['admin_id', 'emp_id', 'task_status', 'is_notify', 'is_new_old'];
            $data = [];
            foreach ($raw as $key => $value) {
                if (in_array($key, $integerFields, true)) {
                    $data[$key] = ($value === '' || $value === null) ? null : (int)$value;
                } else {
                    $data[$key] = $value;
                }
            }
            $data['last_update'] = date('Y-m-d H:i:s');
            $task = $this->Tasks->patchEntity($task, $data, ['validate' => false]);
            if ($this->Tasks->save($task)) {
                $this->Flash->success('The task has been updated.');
                return $this->redirect(['action' => 'admin_index']);
            }
            $this->Flash->error('The task could not be saved. Please try again.');
        }

        $this->set('task', $task);
        return null;
    }

    /** CamelCase alias */
    public function adminEdit($id = null): ?Response
    {
        return $this->admin_edit($id);
    }

    public function admin_assign($task_id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Assign Task');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }

        $task_id = $task_id !== null ? (int)$task_id : 0;
        if (!$task_id || !$this->Tasks->exists(['id' => $task_id])) {
            $this->Flash->error('Invalid task.');
            return $this->redirect(['action' => 'admin_index']);
        }

        $session = $this->request->getSession();
        $durolabType = $session->read('durolab_type') ?: 'technical';

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $task = $this->Tasks->get($task_id);
            $task->assigned_date = !empty($data['assigned_date']) ? $data['assigned_date'] : null;
            $task->task_completion_date = !empty($data['task_completion_date']) ? $data['task_completion_date'] : null;
            $task->is_reminder = (int)($data['is_reminder'] ?? 0);
            $task->is_email = $task->is_reminder ? (int)($data['is_email'] ?? 0) : 0;
            $task->is_sms = $task->is_reminder ? (int)($data['is_sms'] ?? 0) : 0;
            $task->is_both = $task->is_reminder ? (int)($data['is_both'] ?? 0) : 0;
            $task->send_to = $task->is_reminder ? (int)($data['send_to'] ?? 0) : 0;
            $task->period = $task->is_reminder ? ($data['period'] ?? '') : '';
            $task->task_status = 1;
            if (empty($task->assigndatetime) || $task->assigndatetime === '0000-00-00 00:00:00') {
                $task->assigndatetime = date('Y-m-d H:i:s');
            }
            // Ensure integer columns are int|null (SafeIntegerType also protects at DB layer)
            $taskIntFields = ['admin_id', 'emp_id', 'is_notify'];
            foreach ($taskIntFields as $field) {
                $v = $task->get($field);
                if ($v !== null && $v !== '') {
                    $task->set($field, (int)$v);
                } elseif ($v === '') {
                    $task->set($field, null);
                }
            }
            if ($this->Tasks->save($task)) {
                $employeIds = $data['employe_id'] ?? [];
                if (is_array($employeIds)) {
                    $this->TaskAssigns->deleteAll(['task_id' => $task_id]);
                    $sendername = $session->read('User.name') ?? 'Admin';
                    $taskRow = $this->Tasks->get($task_id, ['fields' => ['task_type', 'title', 'task_id']]);
                    foreach ($employeIds as $empId) {
                        $empId = (int)$empId;
                        if ($empId <= 0) continue;
                        $this->TaskAssigns->save($this->TaskAssigns->newEntity([
                            'emp_id' => $empId,
                            'task_id' => (int)$task_id,
                        ]));
                        if (!empty($data['is_send'])) {
                            $userArr = $this->NappUser->find()->where(['NappUser.id' => $empId])->select(['id', 'name', 'lname', 'email'])->first();
                            if ($userArr && !empty($userArr->email)) {
                                $url = (defined('SITEURL') ? SITEURL : '') . 'admin/tasks/adminautologin/' . base64_encode((string)$userArr->id) . '/task/' . $taskRow->task_type;
                                try {
                                    $this->sendemail($userArr->email, (defined('SITENAME') ? SITENAME : '') . ' :: New task assigned by ' . $sendername, 'assign_task', [
                                        'sendername' => $sendername, 'receivername' => trim(($userArr->name ?? '') . ' ' . ($userArr->lname ?? '')),
                                        'task_type' => $taskRow->task_type, 'task_task_id' => $taskRow->task_id, 'task_title' => $taskRow->title,
                                        'user_id' => $userArr->id, 'url' => $url,
                                    ]);
                                } catch (\Exception $e) { /* log */ }
                            }
                        }
                    }
                }
                $this->Flash->success('Task assigned successfully.');
                return $this->redirect(['action' => 'admin_index']);
            }
            $this->Flash->error('Could not save. Please try again.');
        }

        $task = $this->Tasks->find()
            ->where(['Tasks.id' => $task_id])
            ->contain(['TaskAssigns'])
            ->first();

        $permIds = $durolabType === 'project_enquiry' ? [9] : [6, 7];
        $empIds = $this->UserPermission->find('list', ['keyField' => 'user_id', 'valueField' => 'user_id'])
            ->where(['permssion_id IN' => $permIds])->toArray();
        $empIds = array_values(array_unique($empIds));
        $employeArr = [];
        if (count($empIds) > 0) {
            $employeArr = $this->NappUser->find()
                ->where(['NappUser.is_staff_id' => 1, 'NappUser.id IN' => $empIds])
                ->select(['id', 'name', 'lname'])
                ->toArray();
        }

        $this->set('TaskAssign', $task);
        $this->set('employeArr', $employeArr);
        return null;
    }

    /** CamelCase alias */
    public function adminAssign($task_id = null): ?Response
    {
        return $this->admin_assign($task_id);
    }

    public function admin_completetask($task_id = null, $status = null): ?Response
    {
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }
        $this->Flash->success('Task completed successfully.');
        return $this->redirect(['action' => 'admin_index']);
    }

    /** CamelCase alias */
    public function adminCompletetask($task_id = null, $status = null): ?Response
    {
        return $this->admin_completetask($task_id, $status);
    }

    public function admin_comment($task_id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' :: Comments');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }

        $task_id = $task_id ? trim((string)$task_id) : '';
        if ($task_id === '') {
            $this->Flash->error('Invalid task.');
            return $this->redirect(['action' => 'admin_index']);
        }

        $task = $this->Tasks->find()
            ->where(['Tasks.task_id' => $task_id])
            ->contain([
                'TaskDocuments' => function ($q) {
                    return $q->contain(['NappUser' => function ($q2) {
                        return $q2->select(['name', 'lname']);
                    }, 'User' => function ($q2) {
                        return $q2->select(['name']);
                    }])->orderDesc('TaskDocuments.id');
                },
                'TaskComments' => function ($q) {
                    return $q->contain(['NappUser' => function ($q2) {
                        return $q2->select(['name', 'lname']);
                    }, 'User' => function ($q2) {
                        return $q2->select(['name']);
                    }])->orderDesc('TaskComments.id');
                },
                'TaskAssigns' => function ($q) {
                    return $q->contain(['NappUser' => function ($q2) {
                        return $q2->select(['id', 'name', 'lname', 'email']);
                    }]);
                },
            ])
            ->first();

        if (!$task) {
            $this->Flash->error('Task not found.');
            return $this->redirect(['action' => 'admin_index']);
        }

        $session = $this->request->getSession();
        $userId = (int)$session->read('User.id');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $commentText = trim((string)($data['comment'] ?? ''));
            $files = $this->request->getUploadedFiles();
            $docFilename = null;
            if (!empty($files['documents']) && $files['documents']->getError() === UPLOAD_ERR_OK && $files['documents']->getClientFilename()) {
                $path = WWW_ROOT . 'document' . DS . $task_id;
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                $docFilename = time() . '_' . $files['documents']->getClientFilename();
                $files['documents']->moveTo($path . DS . $docFilename);
            }
            $this->TaskComments->save($this->TaskComments->newEntity([
                'comment' => $commentText,
                'task_ids' => $task->id,
                'admin_id' => $userId,
                'type' => 1,
                'documents' => $docFilename,
                'created' => date('Y-m-d H:i:s'),
            ]));
            if (!empty($task->is_notify) && !empty($task->task_assigns)) {
                $sendername = $session->read('User.name') ?? 'Admin';
                foreach ($task->task_assigns as $assign) {
                    $napp = $assign->napp_user;
                    if (!$napp) {
                        $napp = $this->NappUser->find()->where(['id' => $assign->emp_id])->select(['id', 'name', 'lname', 'email'])->first();
                    }
                    if ($napp && !empty($napp->email)) {
                        try {
                            $this->sendemail(
                                $napp->email,
                                (defined('SITENAME') ? SITENAME : '') . ' :- ' . $sendername . ' comment on ' . $task_id,
                                'sendnotificaion',
                                [
                                    'task_id' => $task_id,
                                    'name' => $sendername,
                                    'receivername' => trim(($napp->name ?? '') . ' ' . ($napp->lname ?? '')),
                                    'url' => (defined('SITEURL') ? SITEURL : '') . 'admin/tasks/comment/' . $task_id,
                                    'comment' => $commentText,
                                ]
                            );
                        } catch (\Exception $e) {
                            // log
                        }
                    }
                }
            }
            $this->Flash->success('Comment posted successfully.');
            return $this->redirect(['action' => 'admin_comment', $task_id]);
        }

        $this->set('TaskAssign', $task);
        $this->set('task_id', $task_id);
        return null;
    }

    /** CamelCase alias */
    public function adminComment($task_id = null): ?Response
    {
        return $this->admin_comment($task_id);
    }

    public function admin_taskdocument($task_id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' :: Task Documents');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }

        $task_id = $task_id ? trim((string)$task_id) : '';
        if ($task_id === '') {
            $this->Flash->error('Invalid task.');
            return $this->redirect(['action' => 'admin_index']);
        }

        $task = $this->Tasks->find()
            ->where(['Tasks.task_id' => $task_id])
            ->contain([
                'TaskDocuments' => function ($q) {
                    return $q->contain([
                        'NappUser' => function ($q2) {
                            return $q2->select(['name', 'lname']);
                        },
                        'User' => function ($q2) {
                            return $q2->select(['name']);
                        },
                    ])->orderDesc('TaskDocuments.id');
                },
            ])
            ->first();

        if (!$task) {
            $this->Flash->error('Task not found.');
            return $this->redirect(['action' => 'admin_index']);
        }

        $this->set('taskArr', $task);
        $this->set('task_id', $task_id);
        return null;
    }

    /** CamelCase alias */
    public function adminTaskdocument($task_id = null): ?Response
    {
        return $this->admin_taskdocument($task_id);
    }

    public function admin_uploaddoc($task_id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' :: Upload Document');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }

        $task_id = $task_id ? trim((string)$task_id) : '';
        if ($task_id === '') {
            $this->Flash->error('Invalid task.');
            return $this->redirect(['action' => 'admin_index']);
        }

        $task = $this->Tasks->find()->where(['Tasks.task_id' => $task_id])->first();
        if (!$task) {
            $this->Flash->error('Task not found.');
            return $this->redirect(['action' => 'admin_index']);
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $path = WWW_ROOT . 'document' . DS . $task_id;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $files = $this->request->getUploadedFiles();
            $uploaded = false;
            if (!empty($files['document'])) {
                $docs = is_array($files['document']) ? $files['document'] : [$files['document']];
                $userId = (int)$this->request->getSession()->read('User.id');
                foreach ($docs as $file) {
                    if ($file instanceof \Psr\Http\Message\UploadedFileInterface && $file->getError() === UPLOAD_ERR_OK && $file->getClientFilename()) {
                        $filename = time() . '_' . $file->getClientFilename();
                        $file->moveTo($path . DS . $filename);
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        $this->TaskDocuments->save($this->TaskDocuments->newEntity([
                            'title' => $data['title'] ?? '',
                            'admin_id' => $userId,
                            'task_id' => $task->id,
                            'document' => $task_id,
                            'filename' => $filename,
                            'ext' => $ext,
                            'created' => date('Y-m-d H:i:s'),
                            'is_upload' => 0,
                        ]));
                        $uploaded = true;
                    }
                }
            }
            if ($uploaded) {
                $this->Flash->success('Document(s) uploaded.');
            } else {
                $this->Flash->warning('No file was uploaded or upload failed.');
            }
            return $this->redirect(['action' => 'admin_taskdocument', $task_id]);
        }

        $this->set('taskArr', $task);
        $this->set('task_id', $task_id);
        return null;
    }

    /** CamelCase alias */
    public function adminUploaddoc($task_id = null): ?Response
    {
        return $this->admin_uploaddoc($task_id);
    }

    public function admin_download($id = null): ?Response
    {
        $this->autoRender = false;
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }
        $doc = $this->TaskDocuments->get((int)$id);
        $path = WWW_ROOT . 'document' . DS . $doc->document . DS . $doc->filename;
        if (is_file($path)) {
            return $this->response->withFile($path, ['download' => true, 'name' => $doc->filename]);
        }
        $this->Flash->error('File not found.');
        return $this->redirect(['action' => 'admin_index']);
    }

    /** CamelCase alias */
    public function adminDownload($id = null): ?Response
    {
        return $this->admin_download($id);
    }

    public function admin_commentdownload($id = null): ?Response
    {
        $this->autoRender = false;
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }
        $id = base64_decode(base64_decode((string)$id));
        $comment = $this->TaskComments->get($id, ['contain' => ['Tasks']]);
        $path = WWW_ROOT . 'document' . DS . $comment->task->task_id . DS . $comment->documents;
        if (is_file($path)) {
            return $this->response->withFile($path, ['download' => true, 'name' => basename($path)]);
        }
        $this->Flash->error('File not found.');
        return $this->redirect(['action' => 'admin_index']);
    }

    /** CamelCase alias */
    public function adminCommentdownload($id = null): ?Response
    {
        return $this->admin_commentdownload($id);
    }

    public function admin_delete($id = null): ?Response
    {
        $this->autoRender = false;
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }
        $id = (int)$id;
        if (!$id || !$this->Tasks->exists(['id' => $id])) {
            throw new NotFoundException(__('Invalid task'));
        }
        if ($this->Tasks->delete($this->Tasks->get($id))) {
            $this->Flash->success('The task has been deleted.');
        } else {
            $this->Flash->error('The task could not be deleted. Please try again.');
        }
        return $this->redirect(['action' => 'admin_index']);
    }

    /** CamelCase alias */
    public function adminDelete($id = null): ?Response
    {
        return $this->admin_delete($id);
    }

    public function adminautologin($user_id = null, $type = null, $param = null): ?Response
    {
        $this->autoRender = false;
        if (empty($user_id)) {
            $this->Flash->error('Sorry, you have no access.');
            return $this->redirect('/admin');
        }
        $adminArr = $this->User->find()->where(['User.id' => base64_decode($user_id)])->first();
        if (!$adminArr) {
            $this->Flash->error('Sorry, you have no access.');
            return $this->redirect('/admin');
        }
        $this->request->getSession()->write('User', $adminArr->toArray());
        $this->request->getSession()->write('is_admin', 1);
        if ($type === 'task' && $param !== null) {
            $this->request->getSession()->write('durolab_type', $param);
            return $this->redirect('/admin/tasks');
        }
        return $this->redirect('/admin/users/dashboard');
    }
}
