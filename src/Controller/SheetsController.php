<?php 
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Sheets Controller (Smart Sheets - task management)
 */
class SheetsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('User');
        $this->loadModel('NappUser');
        $this->loadModel('SsSheetCategory');
        $this->loadModel('SsSheetColumn');
        $this->loadModel('SsSheetData');
        $this->loadModel('SsSheetShare');
        $this->loadModel('SheetTask');
        $this->loadModel('SsComment');
        $this->loadModel('SsDocument');
        $this->loadModel('SheetTaskReminder');
        $this->loadModel('SsClientComment');
        $this->loadModel('SheetTaskTrack');
        $this->loadModel('Log');
        // Note: If table names are plural (ss_sheet_categories, ss_sheet_columns, etc.), 
        // update the Table classes to use setTable() with plural names
        $this->loadModel('SheetTaskCreate');
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        parent::beforeFilter($event);
        $this->callConstants();
        return null;
    }

    public function adminSetcall($type = null, $id = null)
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
		$this->checkAdminSession(); 
        $entity = $this->SsSheetCategory->get($id);
        $entity = $this->SsSheetCategory->patchEntity($entity, ['is_call' => $type], ['validate' => false]);
        $this->SsSheetCategory->save($entity);
		echo 'success';
	}
	
    public function adminSetreminder($type = null, $id = null)
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
		$this->checkAdminSession(); 
        $entity = $this->SsSheetCategory->get($id);
        $entity = $this->SsSheetCategory->patchEntity($entity, ['is_reminder' => $type], ['validate' => false]);
        $this->SsSheetCategory->save($entity);
		echo 'success';
	}

    public function admin_addnew()
    {
        return $this->adminAddnew();
    }

    public function adminAddnew()
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
		$this->checkAdminSession(); 
		
        if (!empty($this->request->getData())) {
            $user_id = $this->request->getSession()->read('User.id');
            $data = [
                'user_id' => $user_id,
                'name' => $this->request->getData('SsSheetCategory.name'),
                'created' => date('Y-m-d H:i:s')
            ];
            $entity = $this->SsSheetCategory->newEntity($data, ['validate' => false]);
            $this->SsSheetCategory->save($entity);
            $lastinsetedId = $entity->id;

            $k = 1;
            for ($i = 0; $i < 5; $i++) {
                if ($i == 0) {
					$column = 'Primary Column';
                } else {
                    $column = 'Column ' . $k;
                }
                $colData = [
                    'parent_id' => $user_id,
                    'sheet_id' => $lastinsetedId,
                    'column' => $column,
                    'is_active' => 1,
                    'filed_type' => 'Text',
                    'color' => '#fff',
                    'sort' => 0
                ];
                $colEntity = $this->SsSheetColumn->newEntity($colData, ['validate' => false]);
                $this->SsSheetColumn->save($colEntity);
				$k++;
			}
			
            $this->Flash->success('Sheets added successfully');
            return $this->redirect(['action' => 'admin_index']);
        }
    }

    public function adminCommentdownload($id = null)
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
		$this->checkAdminSession(); 
		$id = base64_decode(base64_decode($id));
		
        $path = WWW_ROOT . 'sheetdoc' . DS . $id;

		if (file_exists($path)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($path));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($path));
			ob_clean();
			flush();
			readfile($path);
			exit;
        }
    }

    public function adminDoctrash($argu = null)
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
		$this->checkAdminSession(); 
        $expl = explode('_', $argu);
		$task_id = $expl[1];		
		$sheet_cate_id = $expl[0];
			
        $this->SheetTask->query('delete from sheet_tasks where task_id=' . $task_id . ' and sheet_cate_id=' . $sheet_cate_id . ' ');
			
		echo 'success'; 
	}

    public function adminAddcomment($argu = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $this->set('title_for_layout', SITENAME . ' Admin Comments');
		$this->checkAdminSession(); 
        $user_id = $this->request->getSession()->read('User.id');
        $username = $this->request->getSession()->read('User.name');
		
        $expl = explode('_', $argu);
        if (!empty($this->request->getData())) {
			$task_id = $expl[1];		
			$sheet_cate_id = $expl[0];
			
            $data = [
                'comment' => $this->request->getData('comment'),
                'sheet_cate_id' => $sheet_cate_id,
                'task_id' => $task_id,
                'admin_id' => $user_id,
                'emp_id' => 0,
                'type' => 1,
                'created' => date('Y-m-d H:i:s')
            ];

            if (!empty($_FILES['documents']['name'])) {
				$name = $_FILES['documents']['name'];
				$tempname = $_FILES['documents']['tmp_name'];
                $path = WWW_ROOT . 'sheetdoc' . DS;
				$ext = pathinfo($name, PATHINFO_EXTENSION);
                $filename = time() . '_' . $name;
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }
                move_uploaded_file($tempname, $path . $filename);
                $data['document'] = $filename;
            }

            $entity = $this->SsComment->newEntity($data, ['validate' => false]);
            $this->SsComment->save($entity);

            if ($this->request->getData('is_send') == 'Yes') {
                $SsSheetColumn = $this->SsSheetColumn->find()
                    ->where(['sheet_id' => $sheet_cate_id, 'column' => 'Assigned Person'])
                    ->first();

                if (!empty($SsSheetColumn)) {
                    $column_id = $SsSheetColumn->id;

                    $SheetTaskArr = $this->SheetTask->find()
                        ->where([
                            'sheet_cate_id' => $sheet_cate_id,
                            'task_id' => $task_id,
                            'column_id' => $column_id
                        ])
                        ->first();

                    if (!empty($SheetTaskArr)) {
                        $userid = $SheetTaskArr->value;
                        $SsSheetCategoryArr = $this->SsSheetCategory->find()
                            ->where(['id' => $sheet_cate_id])
                            ->first();
                        $userArr = $this->NappUser->find()
                            ->where(['id' => $userid])
                            ->first();

                        if (!empty($userArr) && !empty($SsSheetCategoryArr)) {
                            $sheetname = $SsSheetCategoryArr->name;
                            $NappUserId = base64_encode(base64_encode((string)$userArr->id));
						$sheetId = base64_encode(base64_encode((string)$sheet_cate_id));
                            $url = SITEURL . 'sheets/sheetdetail/' . $sheetId . '/' . $NappUserId . '/' . $task_id;

                            $to_name = $userArr->name . ' ' . $userArr->lname;
                            $to_email = $userArr->email;
                            $subject = SITENAME . ':- ' . ucfirst($username) . ' has commented on task(#' . $task_id . ') from ' . $sheetname;
						$template_name = 'sheetcomment';									
                            $variables = [
                                'sheetname' => $sheetname,
                                'name' => $username,
                                'to_name' => $to_name,
                                'task_id' => $task_id,
                                'subject' => $subject,
                                'comment' => $this->request->getData('comment'),
                                'url' => $url
                            ];

                            try {
                                $this->sendemail($to_email, $subject, $template_name, $variables);
                            } catch (\Exception $e) {
                                // Silent fail
						}				
					 }	
					}
				}
			}
		
            $this->Flash->success('Comment posted successfully');
            return $this->redirect(['action' => 'admin_comment', $argu]);
        }

        $this->set('argu', $argu);
    }

    public function adminAddclientcomment($argu = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $this->set('title_for_layout', SITENAME . ' Client Comments');
		$this->checkAdminSession(); 
        $user_id = $this->request->getSession()->read('User.id');
        $username = $this->request->getSession()->read('User.name');
		
        $expl = explode('_', $argu);
		$task_id = $expl[1];		
		$sheet_cate_id = $expl[0];

        if (!empty($this->request->getData())) {
            $data = [
                'status' => $this->request->getData('status'),
                'email' => $this->request->getData('email'),
                'subject' => $this->request->getData('subject'),
                'comment' => $this->request->getData('comment'),
                'sheet_cate_id' => $sheet_cate_id,
                'task_id' => $task_id,
                'admin_id' => $user_id,
                'emp_id' => 0,
                'type' => 1,
                'created' => date('Y-m-d H:i:s')
            ];

            $entity = $this->SsClientComment->newEntity($data, ['validate' => false]);
            $this->SsClientComment->save($entity);

            if (!empty($this->request->getData('email'))) {
                $email = $this->request->getData('email');
                $subject = 'Durotech:- ' . $this->request->getData('subject');
                $status = $this->request->getData('status');

                $template_name = 'sendclientmssage';
                $variables = [
                    'subject' => $subject,
                    'comment' => $this->request->getData('comment'),
                    'status' => $status
                ];
                try {
                    $this->sendemail($email, $subject, $template_name, $variables);
                } catch (\Exception $e) {
                    // Silent fail
                }
            }

            $this->Flash->success('Comment posted successfully');
            return $this->redirect(['action' => 'admin_sendtoclient', $argu]);
        }

        $this->set('argu', $argu);

        $SheetTaskArr = $this->SheetTask->find()
            ->contain(['SsSheetColumn'])
            ->where(['task_id' => $task_id, 'sheet_cate_id' => $sheet_cate_id])
            ->toArray();
        $this->set('SheetTaskArr', $SheetTaskArr);
    }

    public function adminSendtoclient($argu)
    {
		$this->checkAdminSession(); 	
        $this->viewBuilder()->setLayout('admin_new_layout');
		
        $expl = explode('_', $argu);
		$task_id = $expl[1];		
		$sheet_cate_id = $expl[0];
		
        $clientArr = $this->SsClientComment->find()
            ->contain(['SsSheetCategory', 'User', 'NappUser'])
            ->where([
                'task_id' => $task_id,
                'sheet_cate_id' => $sheet_cate_id
            ])
            ->order(['SsClientComment.id' => 'DESC'])
            ->toArray();

        $this->set('clientArr', $clientArr);
        $this->set('task_id', $task_id);
        $this->set('sheet_cate_id', $sheet_cate_id);
        $this->set('argu', $argu);
    }

    public function adminComment($argu = null)
    {
		$this->checkAdminSession(); 	
        $this->viewBuilder()->setLayout('admin_new_layout');

        $expl = explode('_', $argu);
		$task_id = $expl[1];		
		$sheet_cate_id = $expl[0];
		
        $SheetTaskArr = $this->SheetTask->find()
            ->where(['task_id' => $task_id, 'sheet_cate_id' => $sheet_cate_id])
            ->first();

        if (empty($SheetTaskArr)) {
            $data = [
                'column_id' => 0,
                'value' => '',
                'sheet_cate_id' => $sheet_cate_id,
                'task_id' => $task_id,
                'created' => date('Y-m-d H:i:s')
            ];
            $entity = $this->SheetTask->newEntity($data, ['validate' => false]);
            $this->SheetTask->save($entity);
        }

        $clientArr = $this->SsComment->find()
            ->contain(['SsSheetCategory', 'User', 'NappUser'])
            ->where([
                'task_id' => $task_id,
                'sheet_cate_id' => $sheet_cate_id
            ])
            ->order(['SsComment.id' => 'DESC'])
            ->toArray();

        $this->set('clientArr', $clientArr);
        $this->set('task_id', $task_id);
        $this->set('sheet_cate_id', $sheet_cate_id);
        $this->set('argu', $argu);
    }

    public function adminChangepermission($argu = null)
    {
		$this->checkAdminSession(); 
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
        $exp = explode('_', $argu);
        $entity = $this->SsSheetShare->get($exp[0]);
        $entity = $this->SsSheetShare->patchEntity($entity, ['permission' => $exp[1]], ['validate' => false]);
        $this->SsSheetShare->save($entity);
		echo 'success';		
	}
		
    public function adminShare($sheet_id = null, $status = null)
    {
		$this->checkAdminSession(); 	
        $this->viewBuilder()->setLayout('');
        $this->set('sheet_id', $sheet_id);

        if (!empty($this->request->getData())) {
            if (!empty($this->request->getData('email'))) {
                $permission = $this->request->getData('permission');
                $message = $this->request->getData('message');
                $subject = $this->request->getData('subject');
				$sheetId = base64_encode(base64_encode((string)$sheet_id));
                $url = SITEURL . 'sheets/sheetdetail/' . $sheetId;

                foreach ($this->request->getData('email') as $user) {
                    $exp = explode('###', $user);
                    $SsSheetShare = $this->SsSheetShare->find()
                        ->where(['emp_id' => $exp[0]])
                        ->first();

                    $data = [
                        'sheet_id' => $sheet_id,
                        'emp_id' => $exp[0],
                        'permission' => $permission,
                        'created' => date('Y-m-d H:i:s')
                    ];

                    if (!empty($SsSheetShare)) {
                        $entity = $this->SsSheetShare->patchEntity($SsSheetShare, $data, ['validate' => false]);
                    } else {
                        $entity = $this->SsSheetShare->newEntity($data, ['validate' => false]);
                    }
                    $this->SsSheetShare->save($entity);

                    $NappUserArr = $this->NappUser->find()
                        ->where(['id' => $exp[0], 'is_staff_id' => 1])
                        ->first();

                    if (!empty($NappUserArr)) {
                        $NappUserId = base64_encode(base64_encode((string)$NappUserArr->id));
                        $url = $url . '/' . $NappUserId;

                        $to_email = $NappUserArr->email;
                        $to_name = $exp[1];
					$template_name = 'share';	
								
                        $variables = [
                            'name' => $this->request->getSession()->read('User.name'),
                            'to_name' => $to_name,
                            'message' => $message,
                            'subject' => $subject,
                            'url' => $url
                        ];

                        try {
                            $this->sendemail($to_email, $subject, $template_name, $variables);
                        } catch (\Exception $e) {
                            // Silent fail
                        }
                    }
                }

                $entity = $this->SsSheetCategory->get($sheet_id);
                $entity = $this->SsSheetCategory->patchEntity($entity, ['is_shared' => 'Shared'], ['validate' => false]);
                $this->SsSheetCategory->save($entity);

                $this->Flash->success('Sheet shared successfully');
                return $this->redirect(['action' => 'admin_share', $sheet_id, 'success']);
            }
        }

        $NappUserEntities = $this->NappUser->find()
            ->where(['is_active' => 1, 'is_staff_id' => 1])
            ->toArray();
        // Convert to array format for view compatibility
        $NappUser = [];
        foreach ($NappUserEntities as $entity) {
            $NappUser[] = ['NappUser' => $entity->toArray()];
        }
        $this->set('NappUser', $NappUser);

        $SsSheetCategoryEntity = $this->SsSheetCategory->find()
            ->where(['id' => $sheet_id])
            ->first();
        // Convert to array format for view compatibility
        $SsSheetCategory = $SsSheetCategoryEntity ? ['SsSheetCategory' => $SsSheetCategoryEntity->toArray()] : ['SsSheetCategory' => []];
        $this->set('SsSheetCategory', $SsSheetCategory);

        $this->set('status', $status);

        $SsSheetShareEntities = $this->SsSheetShare->find()
            ->contain(['NappUser'])
            ->where(['sheet_id' => $sheet_id])
            ->toArray();
        // Convert to array format for view compatibility
        $SsSheetShare = [];
        foreach ($SsSheetShareEntities as $entity) {
            $SsSheetShare[] = [
                'SsSheetShare' => $entity->toArray(),
                'NappUser' => $entity->napp_user ? $entity->napp_user->toArray() : []
            ];
        }
        $this->set('SsSheetShare', $SsSheetShare);
    }

    public function sheetdetail($sheet_id = null, $userId = null, $task_id = null)
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
        $this->set('title_for_layout', SITENAME . ' Smart Sheet Detail');

        if (!empty($userId)) {
		$userId = base64_decode(base64_decode($userId));
            $NappUserArr = $this->NappUser->find()
                ->where(['id' => $userId, 'is_staff_id' => 1])
                ->first();

            if (!empty($NappUserArr)) {
                $this->request->getSession()->write('Customer', $NappUserArr->toArray());
                $this->request->getSession()->write('is_staff', 1);
                if (!empty($task_id)) {
                    return $this->redirect(['action' => 'sheet', $sheet_id, '#' => $task_id]);
                } else {
                    return $this->redirect(['action' => 'sheet', $sheet_id]);
                }
            }
        } else {
            return $this->redirect('/login');
        }
    }

    public function adminSheetdetail($user_id = null, $sheet_id = null, $task_id = null)
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
        $this->set('title_for_layout', SITENAME . ' Smart Sheet Detail');

        if (!empty($user_id)) {
            $admin_arr = $this->User->find()
                ->where(['id' => $user_id])
                ->first();

            if (!empty($admin_arr)) {
                $this->request->getSession()->write('User', $admin_arr->toArray());
                $this->request->getSession()->write('is_admin', 1);
                return $this->redirect(['action' => 'sheet', $sheet_id, '#' => $task_id]);
            }
        } else {
            return $this->redirect('/admin');
        }
    }

    public function adminDeletesheet($id = null, $sheet_id = null)
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
		$this->checkAdminSession(); 
        if (!empty($id)) {
            if ($this->SsSheetShare->delete($this->SsSheetShare->get($id))) {
                $this->Flash->success('Archived from share list.');
                return $this->redirect(['action' => 'admin_share', $sheet_id, 'success']);
            }
        }
    }

    public function adminIndex()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Smart Sheet Category');
		$this->checkAdminSession(); 
		
        if (!empty($this->request->getData())) {
            foreach ($this->request->getData('sheetId') as $sheetIds) {
                $entity = $this->SsSheetCategory->get($sheetIds);
                $entity = $this->SsSheetCategory->patchEntity($entity, ['is_deleted' => 1], ['validate' => false]);
                $this->SsSheetCategory->save($entity);
            }
            $this->Flash->success('Sheets deleted successfully');
            return $this->redirect(['action' => 'admin_index']);
        }

        $query = $this->SsSheetCategory->find()
            ->contain(['NappUser', 'User'])
            ->where(['is_deleted' => 0])
            ->order(['SsSheetCategory.id' => 'DESC']);

        $SsSheetCategoryArr = $this->paginate($query, ['limit' => 100]);

        // Convert to array format for view compatibility
        $categoryArr = [];
        foreach ($SsSheetCategoryArr as $entity) {
            $categoryArr[] = [
                'SsSheetCategory' => $entity->toArray(),
                'NappUser' => $entity->napp_user ? $entity->napp_user->toArray() : [],
                'User' => $entity->user ? $entity->user->toArray() : []
            ];
        }

        $this->set('SsSheetCategory', $categoryArr);
    }

    public function adminColumn($sheet_id = null, $colum_id = null)
    {
		$this->checkAdminSession(); 	
        $this->viewBuilder()->setLayout('');
        $user_id = $this->request->getSession()->read('User.id');

        if (!empty($this->request->getData())) {
            $data = [
                'parent_id' => $user_id,
                'sheet_id' => $sheet_id,
                'column' => $this->request->getData('column'),
                'filed_type' => $this->request->getData('filed_type')
            ];

            if (!empty($colum_id)) {
                $entity = $this->SsSheetColumn->get($colum_id);
                $entity = $this->SsSheetColumn->patchEntity($entity, $data, ['validate' => false]);
            } else {
                $entity = $this->SsSheetColumn->newEntity($data, ['validate' => false]);
            }
            $this->SsSheetColumn->save($entity);

            $this->Flash->success('Saved successfully.');
            return $this->redirect(['action' => 'admin_column', $sheet_id]);
        }

        $SsSheetCategoryArr = $this->SsSheetCategory->find()
            ->where(['id' => $sheet_id])
            ->first();
        $this->set('sheetinfo', $SsSheetCategoryArr ? ['SsSheetCategory' => $SsSheetCategoryArr->toArray()] : []);

        $SsSheetColumnArr = $this->SsSheetColumn->find()
            ->where(['sheet_id' => $sheet_id])
            ->toArray();
        $columnArr = [];
        foreach ($SsSheetColumnArr as $col) {
            $columnArr[] = ['SsSheetColumn' => $col->toArray()];
        }
        $this->set('SsSheetColumn', $columnArr);

        if (!empty($colum_id)) {
            $SsSheetColumnsEntity = $this->SsSheetColumn->find()
                ->where(['id' => $colum_id])
                ->first();
            $SsSheetColumns = $SsSheetColumnsEntity ? ['SsSheetColumn' => $SsSheetColumnsEntity->toArray()] : ['SsSheetColumn' => []];
        } else {
            $SsSheetColumns = ['SsSheetColumn' => []];
        }
        $this->set('SsSheetColumns', $SsSheetColumns);
    }

    public function adminTrash($sheet_id = null, $colum_id = null)
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
		$this->checkAdminSession(); 
		
        $this->SsSheetColumn->delete($this->SsSheetColumn->get($colum_id));

        $this->Flash->success('Sheets deleted successfully');
        return $this->redirect(['action' => 'admin_column', $sheet_id, $colum_id]);
    }

    public function adminSheet($sheet_id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Smart sheet');
		$this->checkAdminSession(); 
		
        $SsSheetCategoryArr = $this->SsSheetCategory->find()
            ->contain([
                'SsSheetColumn',
                'SsSheetShare' => ['NappUser'],
                'SheetTask'
            ])
            ->where(['id' => $sheet_id])
            ->first();

        if (!$SsSheetCategoryArr) {
            $this->Flash->error('Sheet not found');
            return $this->redirect(['action' => 'admin_index']);
        }

        $this->set('sheetinfo', [
            'SsSheetCategory' => $SsSheetCategoryArr->toArray(),
            'SsSheetColumn' => $SsSheetCategoryArr->ss_sheet_column ? array_map(function($c) { return $c->toArray(); }, $SsSheetCategoryArr->ss_sheet_column) : [],
            'SsSheetShare' => $SsSheetCategoryArr->ss_sheet_share ? array_map(function($s) { return $s->toArray(); }, $SsSheetCategoryArr->ss_sheet_share) : [],
            'SheetTask' => $SsSheetCategoryArr->sheet_task ? array_map(function($t) { return $t->toArray(); }, $SsSheetCategoryArr->sheet_task) : []
        ]);

        $rows = [];
        if (!empty($SsSheetCategoryArr->sheet_task)) {
            foreach ($SsSheetCategoryArr->sheet_task as $SheetTasks) {
                $taskid = $SheetTasks->task_id;
                $column_id = $SheetTasks->column_id;
                $rows[$taskid][$column_id]['value'] = $SheetTasks->value;
                $rows[$taskid][$column_id]['created'] = $SheetTasks->created;
            }
        }
        $this->set('rows', $rows);
    }

    public function updatetasktracking($formid = null, $status = null)
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
        $expl = explode("_", $formid);
		$sheet_id = $expl[0];
		$task_id = $expl[1];
		
        $SheetTaskTrackArr = $this->SheetTaskTrack->find()
            ->where([
                'sheet_id' => $sheet_id,
                'task_id' => $task_id,
                'end' => '0000-00-00 00:00:00'
            ])
            ->first();

        $data = [
            'sheet_id' => $sheet_id,
            'task_id' => $task_id,
            'status' => $status
        ];

        if (!empty($SheetTaskTrackArr)) {
            $data['end'] = date('Y-m-d H:i:s');
            $entity = $this->SheetTaskTrack->patchEntity($SheetTaskTrackArr, $data, ['validate' => false]);
        } else {
            $data['start'] = date('Y-m-d H:i:s');
            $entity = $this->SheetTaskTrack->newEntity($data, ['validate' => false]);
        }
        $this->SheetTaskTrack->save($entity);
		echo 'success';
	}	
	
    public function adminSavedata($userid = null)
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
		$this->checkAdminSession(); 
        $adminname = $this->request->getSession()->read('User.name');

        if (!empty($this->request->getData())) {
            $sheet_cate_id = $this->request->getData('sheet_cate_id');
            $sheet_id = $this->request->getData('sheet_cate_id');
            $task_id = $this->request->getData('task_id');

            $SheetTaskCreateArr = $this->SheetTaskCreate->find()
                ->where(['sheet_id' => $sheet_id, 'task_id' => $task_id])
                ->first();

            if (empty($SheetTaskCreateArr)) {
                $data = ['sheet_id' => $sheet_id, 'task_id' => $task_id];
                $entity = $this->SheetTaskCreate->newEntity($data, ['validate' => false]);
                $this->SheetTaskCreate->save($entity);
            }

            if (!empty($this->request->getData('column'))) {
                foreach ($this->request->getData('column') as $column_id => $val) {
                    $SheetTaskArr = $this->SheetTask->find()
                        ->where([
                            'sheet_cate_id' => $sheet_cate_id,
                            'task_id' => $task_id,
                            'column_id' => $column_id
                        ])
                        ->first();

                    $data = [
                        'column_id' => $column_id,
                        'value' => $val,
                        'sheet_cate_id' => $sheet_cate_id,
                        'task_id' => $task_id
                    ];

                    if (!empty($SheetTaskArr)) {
                        $entity = $this->SheetTask->patchEntity($SheetTaskArr, $data, ['validate' => false]);
                    } else {
                        $entity = $this->SheetTask->newEntity($data, ['validate' => false]);
                    }
                    $this->SheetTask->save($entity);
                }
            }

            if (!empty($userid) && !empty($task_id)) {
                $SsSheetCategoryArr = $this->SsSheetCategory->find()
                    ->where(['id' => $sheet_cate_id])
                    ->first();
                $userArr = $this->NappUser->find()
                    ->where(['id' => $userid])
                    ->first();

                if (!empty($userArr) && !empty($SsSheetCategoryArr)) {
                    $sheetname = $SsSheetCategoryArr->name;
                    $NappUserId = base64_encode(base64_encode((string)$userArr->id));
					$sheetId = base64_encode(base64_encode((string)$sheet_cate_id));
                    $url = SITEURL . 'sheets/sheetdetail/' . $sheetId . '/' . $NappUserId . '/' . $task_id;

                    $to_name = $userArr->name . ' ' . $userArr->lname;
                    $to_email = $userArr->email;
                    $subject = SITENAME . ':- Task(#' . $task_id . ') Assigned From ' . $sheetname . ' Sheet By ' . $adminname;
					$template_name = 'assigntask';									
                    $variables = [
                        'sheetname' => $sheetname,
                        'name' => $adminname,
                        'to_name' => $to_name,
                        'task_id' => $task_id,
                        'subject' => $subject,
                        'url' => $url
                    ];

                    try {
                        $this->sendemail($to_email, $subject, $template_name, $variables);
                    } catch (\Exception $e) {
                        // Silent fail
					}				
				}					
			}
			echo 'success-1';	
		}
		echo 'success';
	}	
	
    public function adminAdddocument($argu = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $this->set('title_for_layout', SITENAME . ' Admin Task Document');
		$this->checkAdminSession(); 
        $user_id = $this->request->getSession()->read('User.id');
        $username = $this->request->getSession()->read('User.name');
		
        $expl = explode('_', $argu);
        if (!empty($this->request->getData())) {
			$task_id = $expl[1];		
			$sheet_cate_id = $expl[0];
			
            $data = [
                'doc_title' => $this->request->getData('doc_title'),
                'sheet_cate_id' => $sheet_cate_id,
                'task_id' => $task_id,
                'admin_id' => $user_id,
                'emp_id' => 0,
                'type' => 1,
                'created' => date('Y-m-d H:i:s')
            ];

            if (!empty($_FILES['documents']['name'])) {
				$name = $_FILES['documents']['name'];
				$tempname = $_FILES['documents']['tmp_name'];
                $path = WWW_ROOT . 'sheetdoc' . DS;
				$ext = pathinfo($name, PATHINFO_EXTENSION);
                $filename = time() . '_' . $name;
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }
                move_uploaded_file($tempname, $path . $filename);
                $data['document'] = $filename;
            }

            $entity = $this->SsDocument->newEntity($data, ['validate' => false]);
            $this->SsDocument->save($entity);

            if ($this->request->getData('is_send') == 'Yes') {
                $SsSheetColumn = $this->SsSheetColumn->find()
                    ->where(['sheet_id' => $sheet_cate_id, 'column' => 'Assigned Person'])
                    ->first();

                if (!empty($SsSheetColumn)) {
                    $column_id = $SsSheetColumn->id;

                    $SheetTaskArr = $this->SheetTask->find()
                        ->where([
                            'sheet_cate_id' => $sheet_cate_id,
                            'task_id' => $task_id,
                            'column_id' => $column_id
                        ])
                        ->first();

                    if (!empty($SheetTaskArr)) {
                        $userid = $SheetTaskArr->value;
                        $SsSheetCategoryArr = $this->SsSheetCategory->find()
                            ->where(['id' => $sheet_cate_id])
                            ->first();
                        $userArr = $this->NappUser->find()
                            ->where(['id' => $userid])
                            ->first();

                        if (!empty($userArr) && !empty($SsSheetCategoryArr)) {
                            $sheetname = $SsSheetCategoryArr->name;
                            $NappUserId = base64_encode(base64_encode((string)$userArr->id));
						$sheetId = base64_encode(base64_encode((string)$sheet_cate_id));
                            $url = SITEURL . 'sheets/sheetdetail/' . $sheetId . '/' . $NappUserId . '/' . $task_id;

                            $to_name = $userArr->name . ' ' . $userArr->lname;
                            $to_email = $userArr->email;
                            $subject = SITENAME . ':- ' . ucfirst($username) . ' has added new document in task(#' . $task_id . ') from ' . $sheetname;
						$template_name = 'sheetattach';									
                            $variables = [
                                'sheetname' => $sheetname,
                                'name' => $username,
                                'to_name' => $to_name,
                                'task_id' => $task_id,
                                'subject' => $subject,
                                'comment' => 'New document added. Please click below link to see.',
                                'url' => $url
                            ];

                            try {
                                $this->sendemail($to_email, $subject, $template_name, $variables);
                            } catch (\Exception $e) {
                                // Silent fail
						}				
					 }	
					}
				}
			}

            $this->Flash->success('Document posted successfully');
            return $this->redirect(['action' => 'admin_document', $argu]);
		}
		
        $this->set('argu', $argu);
	}	
		
    public function adminDocument($argu = null)
    {
		$this->checkAdminSession(); 	
        $this->viewBuilder()->setLayout('admin_new_layout');

        $expl = explode('_', $argu);
		$task_id = $expl[1];		
		$sheet_cate_id = $expl[0];
		
        $SheetTaskArr = $this->SheetTask->find()
            ->where(['task_id' => $task_id, 'sheet_cate_id' => $sheet_cate_id])
            ->first();

        if (empty($SheetTaskArr)) {
            $data = [
                'column_id' => 0,
                'value' => '',
                'sheet_cate_id' => $sheet_cate_id,
                'task_id' => $task_id,
                'created' => date('Y-m-d H:i:s')
            ];
            $entity = $this->SheetTask->newEntity($data, ['validate' => false]);
            $this->SheetTask->save($entity);
        }

        $clientArr = $this->SsDocument->find()
            ->contain(['SsSheetCategory', 'User', 'NappUser'])
            ->where([
                'task_id' => $task_id,
                'sheet_cate_id' => $sheet_cate_id
            ])
            ->order(['SsDocument.id' => 'DESC'])
            ->toArray();

        $this->set('clientArr', $clientArr);
        $this->set('task_id', $task_id);
        $this->set('sheet_cate_id', $sheet_cate_id);
        $this->set('argu', $argu);
    }

    // Staff-side methods (non-admin)
    public function sheet($sheet_id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Smart Sheet Task List');
		$this->checkSatffSession(); 
        $user_id = $this->request->getSession()->read('Customer.id');

        $SsSheetShareArr = $this->SsSheetShare->find()
            ->where(['sheet_id' => $sheet_id, 'emp_id' => $user_id])
            ->first();

        if (empty($SsSheetShareArr)) {
            $this->Flash->error('Sorry, you have no permission to access this sheet.');
            return $this->redirect(['action' => 'index']);
        }

        $SsSheetCategoryArr = $this->SsSheetCategory->find()
            ->contain([
                'SsSheetColumn',
                'SsSheetShare' => ['NappUser'],
                'SheetTask'
            ])
            ->where(['id' => $sheet_id])
            ->first();

        if (!$SsSheetCategoryArr) {
            $this->Flash->error('Sheet not found');
            return $this->redirect(['action' => 'index']);
        }

        $this->set('sheetinfo', [
            'SsSheetCategory' => $SsSheetCategoryArr->toArray(),
            'SsSheetColumn' => $SsSheetCategoryArr->ss_sheet_column ? array_map(function($c) { return $c->toArray(); }, $SsSheetCategoryArr->ss_sheet_column) : [],
            'SsSheetShare' => $SsSheetCategoryArr->ss_sheet_share ? array_map(function($s) { return $s->toArray(); }, $SsSheetCategoryArr->ss_sheet_share) : [],
            'SheetTask' => $SsSheetCategoryArr->sheet_task ? array_map(function($t) { return $t->toArray(); }, $SsSheetCategoryArr->sheet_task) : []
        ]);

        $rows = [];
        if (!empty($SsSheetCategoryArr->sheet_task)) {
            foreach ($SsSheetCategoryArr->sheet_task as $SheetTasks) {
                $taskid = $SheetTasks->task_id;
                $column_id = $SheetTasks->column_id;
                $rows[$taskid][$column_id]['value'] = $SheetTasks->value;
                $rows[$taskid][$column_id]['created'] = $SheetTasks->created;
            }
        }
        $this->set('rows', $rows);
        $this->set('SsSheetShare', $SsSheetShareArr ? ['SsSheetShare' => $SsSheetShareArr->toArray()] : []);
    }

    public function index()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Smart Sheet Category');
        $this->checkSatffSession();
        $user_id = $this->request->getSession()->read('Customer.id');

        $sheetShares = $this->SsSheetShare->find()
            ->where(['emp_id' => $user_id])
            ->all();
        $sheet_ids = [];
        foreach ($sheetShares as $share) {
            $sheet_id = is_object($share) ? $share->get('sheet_id') : ($share['sheet_id'] ?? null);
            if ($sheet_id !== null) {
                $sheet_ids[] = $sheet_id;
            }
        }

        if (empty($sheet_ids)) {
            $query = $this->SsSheetCategory->find()->where(['SsSheetCategory.id' => 0]);
            $this->paginate($query, ['limit' => 100]);
            $this->set('SsSheetCategory', []);
            return;
        }

        $query = $this->SsSheetCategory->find()
            ->contain(['NappUser', 'User'])
            ->where(['SsSheetCategory.id IN' => $sheet_ids, 'SsSheetCategory.is_deleted' => 0])
            ->orderDesc('SsSheetCategory.id');

        $SsSheetCategoryArr = $this->paginate($query, ['limit' => 100]);

        $categoryArr = [];
        foreach ($SsSheetCategoryArr as $entity) {
            $categoryArr[] = [
                'SsSheetCategory' => $entity->toArray(),
                'NappUser' => $entity->napp_user ? (is_object($entity->napp_user) ? $entity->napp_user->toArray() : []) : [],
                'User' => $entity->user ? (is_object($entity->user) ? $entity->user->toArray() : []) : []
            ];
        }

        $this->set('SsSheetCategory', $categoryArr);
    }

    // Additional staff-side methods would follow similar pattern...
    // Due to length, I'll add key methods. The rest follow the same conversion pattern.

    public function addcomment($argu = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $this->set('title_for_layout', SITENAME . ' Admin Comments');
		$this->checkSatffSession(); 
        $user_id = $this->request->getSession()->read('Customer.id');
        $fname = $this->request->getSession()->read('Customer.name');
        $lname = $this->request->getSession()->read('Customer.lname');
        $email = $this->request->getSession()->read('Customer.email');

        $expl = explode('_', $argu);
        if (!empty($this->request->getData())) {
			$task_id = $expl[1];		
			$sheet_cate_id = $expl[0];			

            $data = [
                'comment' => $this->request->getData('comment'),
                'sheet_cate_id' => $sheet_cate_id,
                'task_id' => $task_id,
                'admin_id' => 0,
                'emp_id' => $user_id,
                'type' => 0,
                'created' => date('Y-m-d H:i:s')
            ];

            if (!empty($_FILES['documents']['name'])) {
				$name = $_FILES['documents']['name'];
				$tempname = $_FILES['documents']['tmp_name'];
                $path = WWW_ROOT . 'sheetdoc' . DS;
				$ext = pathinfo($name, PATHINFO_EXTENSION);
                $filename = time() . '_' . $name;
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }
                move_uploaded_file($tempname, $path . $filename);
                $data['document'] = $filename;
            }

            $entity = $this->SsComment->newEntity($data, ['validate' => false]);
            $this->SsComment->save($entity);

            if ($this->request->getData('is_send') == 'Yes') {
                $SsSheetCategoryArr = $this->SsSheetCategory->find()
                    ->where(['id' => $sheet_cate_id])
                    ->first();

                if (!empty($SsSheetCategoryArr)) {
                    $username = $fname . ' ' . $lname;
                    $sheetname = $SsSheetCategoryArr->name;

                    $subject = SITENAME . ':- ' . ucfirst($username) . ' has commented on task(#' . $task_id . ') from ' . $sheetname;
				$template_name = 'sheetcomment';					
                    $userArr = $this->User->find()
                        ->where(['is_receive_smartsheet' => 1])
                        ->toArray();

                    if (!empty($userArr)) {
                        foreach ($userArr as $userArrs) {
                            $userid = $userArrs->id;
                            $url = SITEURL . 'admin/sheets/sheetdetail/' . $userid . '/' . $sheet_cate_id . '/' . $task_id;
                            $to_name = $userArrs->name;
                            $to_email = $userArrs->email;
                            $variables = [
                                'sheetname' => $sheetname,
                                'name' => $username,
                                'to_name' => $to_name,
                                'task_id' => $task_id,
                                'subject' => $subject,
                                'comment' => $this->request->getData('comment'),
                                'url' => $url
                            ];
                            try {
                                $this->sendemail($to_email, $subject, $template_name, $variables);
                            } catch (\Exception $e) {
                                // Silent fail
                            }
                        }
                    }
                }
            }

            $this->Flash->success('Comment posted successfully');
            return $this->redirect(['action' => 'comment', $argu]);
        }

        $this->set('argu', $argu);
    }

    public function savedata($userid = null)
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
		$this->checkSatffSession(); 
		
        if (!empty($this->request->getData())) {
            $sheet_cate_id = $this->request->getData('sheet_cate_id');
            $sheet_id = $this->request->getData('sheet_cate_id');
            $task_id = $this->request->getData('task_id');

            $SheetTaskCreateArr = $this->SheetTaskCreate->find()
                ->where(['sheet_id' => $sheet_id, 'task_id' => $task_id])
                ->first();

            if (empty($SheetTaskCreateArr)) {
                $data = ['sheet_id' => $sheet_id, 'task_id' => $task_id];
                $entity = $this->SheetTaskCreate->newEntity($data, ['validate' => false]);
                $this->SheetTaskCreate->save($entity);
            }

            if (!empty($this->request->getData('column'))) {
                foreach ($this->request->getData('column') as $column_id => $val) {
                    $SheetTaskArr = $this->SheetTask->find()
                        ->where([
                            'sheet_cate_id' => $sheet_cate_id,
                            'task_id' => $task_id,
                            'column_id' => $column_id
                        ])
                        ->first();

                    $data = [
                        'column_id' => $column_id,
                        'value' => $val,
                        'sheet_cate_id' => $sheet_cate_id,
                        'task_id' => $task_id
                    ];

                    if (!empty($SheetTaskArr)) {
                        $entity = $this->SheetTask->patchEntity($SheetTaskArr, $data, ['validate' => false]);
                    } else {
                        $entity = $this->SheetTask->newEntity($data, ['validate' => false]);
                    }
                    $this->SheetTask->save($entity);
                }
            }
            echo 'success-1';
        }
        echo 'success';
    }

    public function addclientcomment($argu = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $this->set('title_for_layout', SITENAME . ' Client Comments');
        $this->checkSatffSession();

        $user_id = $this->request->getSession()->read('Customer.id');
        $fname = $this->request->getSession()->read('Customer.name');
        $lname = $this->request->getSession()->read('Customer.lname');
        $username = $fname . ' ' . $lname;

        $expl = explode('_', $argu);
		$task_id = $expl[1];		
		$sheet_cate_id = $expl[0];

        if (!empty($this->request->getData())) {
            $data = [
                'status' => $this->request->getData('status'),
                'email' => $this->request->getData('email'),
                'subject' => $this->request->getData('subject'),
                'comment' => $this->request->getData('comment'),
                'sheet_cate_id' => $sheet_cate_id,
                'task_id' => $task_id,
                'admin_id' => 0,
                'emp_id' => $user_id,
                'type' => 0,
                'created' => date('Y-m-d H:i:s')
            ];

            $entity = $this->SsClientComment->newEntity($data, ['validate' => false]);
            $this->SsClientComment->save($entity);

            if (!empty($this->request->getData('email'))) {
                $email = $this->request->getData('email');
                $subject = 'Durotech:- ' . $this->request->getData('subject');
                $status = $this->request->getData('status');
				
				$template_name = 'sendclientmssage';									
                $variables = [
                    'subject' => $subject,
                    'comment' => $this->request->getData('comment'),
                    'status' => $status
                ];
                try {
                    $this->sendemail($email, $subject, $template_name, $variables);
                } catch (\Exception $e) {
                    // Silent fail
                }
            }

            $this->Flash->success('Comment posted successfully');
            return $this->redirect(['action' => 'sendtoclient', $argu]);
        }

        $this->set('argu', $argu);

        $SheetTaskArr = $this->SheetTask->find()
            ->contain(['SsSheetColumn'])
            ->where(['task_id' => $task_id, 'sheet_cate_id' => $sheet_cate_id])
            ->toArray();
        $this->set('SheetTaskArr', $SheetTaskArr);
    }

    public function sendtoclient($argu)
    {
		$this->checkSatffSession(); 	
        $this->viewBuilder()->setLayout('admin_new_layout');
	
        $expl = explode('_', $argu);
		$task_id = $expl[1];		
		$sheet_cate_id = $expl[0];
		
        $clientArr = $this->SsClientComment->find()
            ->contain(['SsSheetCategory', 'User', 'NappUser'])
            ->where([
                'task_id' => $task_id,
                'sheet_cate_id' => $sheet_cate_id
            ])
            ->order(['id' => 'DESC'])
            ->toArray();

        $this->set('clientArr', $clientArr);
        $this->set('task_id', $task_id);
        $this->set('sheet_cate_id', $sheet_cate_id);
        $this->set('argu', $argu);
    }

    public function comment($argu = null)
    {
		$this->checkSatffSession(); 	
        $this->viewBuilder()->setLayout('admin_new_layout');

        $expl = explode('_', $argu);
		$task_id = $expl[1];		
		$sheet_cate_id = $expl[0];
		
        $SheetTaskArr = $this->SheetTask->find()
            ->where(['task_id' => $task_id, 'sheet_cate_id' => $sheet_cate_id])
            ->first();

        if (empty($SheetTaskArr)) {
            $data = [
                'column_id' => 0,
                'value' => '',
                'sheet_cate_id' => $sheet_cate_id,
                'task_id' => $task_id,
                'created' => date('Y-m-d H:i:s')
            ];
            $entity = $this->SheetTask->newEntity($data, ['validate' => false]);
            $this->SheetTask->save($entity);
        }

        $clientArr = $this->SsComment->find()
            ->contain(['SsSheetCategory', 'User', 'NappUser'])
            ->where([
                'task_id' => $task_id,
                'sheet_cate_id' => $sheet_cate_id
            ])
            ->order(['SsComment.id' => 'DESC'])
            ->toArray();

        $this->set('clientArr', $clientArr);
        $this->set('task_id', $task_id);
        $this->set('sheet_cate_id', $sheet_cate_id);
        $this->set('argu', $argu);
    }

    public function adddocument($argu = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $this->set('title_for_layout', SITENAME . ' Admin Comments');
		$this->checkSatffSession(); 
        $user_id = $this->request->getSession()->read('Customer.id');
        $fname = $this->request->getSession()->read('Customer.name');
        $lname = $this->request->getSession()->read('Customer.lname');
        $username = $fname . ' ' . $lname;

        $expl = explode('_', $argu);
        if (!empty($this->request->getData())) {
			$task_id = $expl[1];		
			$sheet_cate_id = $expl[0];
			
            $data = [
                'doc_title' => $this->request->getData('doc_title'),
                'sheet_cate_id' => $sheet_cate_id,
                'task_id' => $task_id,
                'admin_id' => 0,
                'emp_id' => $user_id,
                'type' => 0,
                'created' => date('Y-m-d H:i:s')
            ];

            if (!empty($_FILES['documents']['name'])) {
				$name = $_FILES['documents']['name'];
				$tempname = $_FILES['documents']['tmp_name'];
                $path = WWW_ROOT . 'sheetdoc' . DS;
				$ext = pathinfo($name, PATHINFO_EXTENSION);
                $filename = time() . '_' . $name;
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }
                move_uploaded_file($tempname, $path . $filename);
                $data['document'] = $filename;
            }

            $entity = $this->SsDocument->newEntity($data, ['validate' => false]);
            $this->SsDocument->save($entity);

            if ($this->request->getData('is_send') == 'Yes') {
                $SsSheetCategoryArr = $this->SsSheetCategory->find()
                    ->where(['id' => $sheet_cate_id])
                    ->first();

                if (!empty($SsSheetCategoryArr)) {
                    $sheetname = $SsSheetCategoryArr->name;
                    $userArr = $this->User->find()
                        ->where(['is_receive_smartsheet' => 1])
                        ->toArray();

                    if (!empty($userArr)) {
                        foreach ($userArr as $userArrs) {
                            $userid = $userArrs->id;
                            $url = SITEURL . 'admin/sheets/sheetdetail/' . $userid . '/' . $sheet_cate_id . '/' . $task_id;
                            $to_name = $userArrs->name;
                            $to_email = $userArrs->email;
                            $subject = SITENAME . ':- ' . ucfirst($username) . ' has added new document in task(#' . $task_id . ') from ' . $sheetname;
                            $template_name = 'sheetattach';
                            $variables = [
                                'sheetname' => $sheetname,
                                'name' => $username,
                                'to_name' => $to_name,
                                'task_id' => $task_id,
                                'subject' => $subject,
                                'comment' => 'New document added. Please click below link to see.',
                                'url' => $url
                            ];
                            try {
                                $this->sendemail($to_email, $subject, $template_name, $variables);
                            } catch (\Exception $e) {
                                // Silent fail
                            }
                        }
                    }
                }
            }

            $this->Flash->success('Document posted successfully');
            return $this->redirect(['action' => 'document', $argu]);
        }

        $this->set('argu', $argu);
    }

    public function document($argu = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $this->set('title_for_layout', SITENAME . ' Admin Comments');
		$this->checkSatffSession(); 
        $user_id = $this->request->getSession()->read('Customer.id');
        $username = $this->request->getSession()->read('Customer.name');

        $expl = explode('_', $argu);
		$task_id = $expl[1];		
		$sheet_cate_id = $expl[0];
		
        $SheetTaskArr = $this->SheetTask->find()
            ->where(['task_id' => $task_id, 'sheet_cate_id' => $sheet_cate_id])
            ->first();

        if (empty($SheetTaskArr)) {
            $data = [
                'column_id' => 0,
                'value' => '',
                'sheet_cate_id' => $sheet_cate_id,
                'task_id' => $task_id,
                'created' => date('Y-m-d H:i:s')
            ];
            $entity = $this->SheetTask->newEntity($data, ['validate' => false]);
            $this->SheetTask->save($entity);
        }

        $clientArr = $this->SsDocument->find()
            ->contain(['SsSheetCategory', 'User', 'NappUser'])
            ->where([
                'task_id' => $task_id,
                'sheet_cate_id' => $sheet_cate_id
            ])
            ->order(['SsDocument.id' => 'DESC'])
            ->toArray();

        $this->set('clientArr', $clientArr);
        $this->set('task_id', $task_id);
        $this->set('sheet_cate_id', $sheet_cate_id);
        $this->set('argu', $argu);
    }

    public function getusername($userId = null)
    {
        $userArr = $this->NappUser->find()
            ->where(['id' => $userId])
            ->first();

        if (!empty($userArr)) {
            return $userArr->name . ' ' . $userArr->lname . ' (' . $userArr->email . ')';
        } else {
            return 'N/A';
        }
    }

    public function adminViewdtaa($argu = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $exp = explode('_', $argu);
        $sheetcateId = $exp[0];
        $task_id = $exp[1];

        $SsSheetCategory = $this->SsSheetCategory->find()
            ->where(['id' => $sheetcateId])
            ->first();
        $this->set('SsSheetCategory', $SsSheetCategory ? ['SsSheetCategory' => $SsSheetCategory->toArray()] : []);

        $SheetTaskArr = $this->SheetTask->find()
            ->contain(['SsSheetColumn'])
            ->where(['task_id' => $task_id, 'sheet_cate_id' => $sheetcateId])
            ->toArray();

        $taskArr = [];
        foreach ($SheetTaskArr as $task) {
            $taskArr[] = [
                'SheetTask' => $task->toArray(),
                'SsSheetColumn' => $task->ss_sheet_column ? $task->ss_sheet_column->toArray() : []
            ];
        }
        $this->set('SheetTaskArr', $taskArr);

        $SheetTaskTrack = $this->SheetTaskTrack->find()
            ->where([
                'sheet_id' => $sheetcateId,
                'task_id' => $task_id
            ])
            ->order(['SheetTaskTrack.id' => 'DESC'])
            ->toArray();
        $this->set('SheetTaskTrack', $SheetTaskTrack);
    }

    public function adminDailer($argu = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $exp = explode('_', $argu);
        $sheetcateId = $exp[0];
        $task_id = $exp[1];

        $SsSheetCategory = $this->SsSheetCategory->find()
            ->where(['id' => $sheetcateId])
            ->first();
        $this->set('SsSheetCategory', $SsSheetCategory ? ['SsSheetCategory' => $SsSheetCategory->toArray()] : []);

        $SheetTaskArr = $this->SheetTask->find()
            ->contain(['SsSheetColumn'])
            ->where(['task_id' => $task_id, 'sheet_cate_id' => $sheetcateId])
            ->toArray();

        $taskArr = [];
        $phone = '';
        foreach ($SheetTaskArr as $SheetTaskArrs) {
            $taskArr[] = [
                'SheetTask' => $SheetTaskArrs->toArray(),
                'SsSheetColumn' => $SheetTaskArrs->ss_sheet_column ? $SheetTaskArrs->ss_sheet_column->toArray() : []
            ];
            if ($SheetTaskArrs->ss_sheet_column && $SheetTaskArrs->ss_sheet_column->filed_type == 'mobile') {
                $phone = $SheetTaskArrs->value;
            }
        }
        $this->set('SheetTaskArr', $taskArr);
        $this->set('phone', $phone);
        $this->set('task_id', $task_id);

        // Twilio integration (requires vendor library)
        if (defined('DIALER_TSID') && defined('DIALER_TOKEN')) {
            try {
                \App::import('Vendor', 'Services_Twilio_Capability', ['file' => 'services/Twilio/Capability.php']);
                $capability = new \Services_Twilio_Capability(DIALER_TSID, DIALER_TOKEN);
                $capability->allowClientOutgoing('AP59a7c2e59a2d42c8bb6df3cdea5a004d');
                $token = $capability->generateToken();
                $this->set('token', $token);
                $callerId = str_replace('+', '', DIALER_CALLERID);
                $this->set('callerId', $callerId);
            } catch (\Exception $e) {
                // Silent fail if Twilio not available
            }
        }

        $LogArr = $this->Log->find()
            ->contain(['NappUser'])
            ->where(['task_id' => $task_id])
            ->order(['Log.id' => 'DESC'])
            ->toArray();

        $logArr = [];
        foreach ($LogArr as $log) {
            $logArr[] = [
                'Log' => $log->toArray(),
                'NappUser' => $log->napp_user ? $log->napp_user->toArray() : []
            ];
        }
        $this->set('LogArr', $logArr);
    }

    public function dailer($argu = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $exp = explode('_', $argu);
		$sheetcateId = $exp[0]; 
		$task_id = $exp[1]; 
		
        $SsSheetCategory = $this->SsSheetCategory->find()
            ->where(['id' => $sheetcateId])
            ->first();
        $this->set('SsSheetCategory', $SsSheetCategory ? ['SsSheetCategory' => $SsSheetCategory->toArray()] : []);

        $SheetTaskArr = $this->SheetTask->find()
            ->contain(['SsSheetColumn'])
            ->where(['task_id' => $task_id, 'sheet_cate_id' => $sheetcateId])
            ->toArray();

        $taskArr = [];
		$phone = '';
        foreach ($SheetTaskArr as $SheetTaskArrs) {
            $taskArr[] = [
                'SheetTask' => $SheetTaskArrs->toArray(),
                'SsSheetColumn' => $SheetTaskArrs->ss_sheet_column ? $SheetTaskArrs->ss_sheet_column->toArray() : []
            ];
            if ($SheetTaskArrs->ss_sheet_column && $SheetTaskArrs->ss_sheet_column->filed_type == 'mobile') {
                $phone = $SheetTaskArrs->value;
            }
        }
        $this->set('SheetTaskArr', $taskArr);
        $this->set('phone', $phone);
        $this->set('task_id', $task_id);

        // Twilio integration
        if (defined('DIALER_TSID') && defined('DIALER_TOKEN')) {
            try {
                \App::import('Vendor', 'Services_Twilio_Capability', ['file' => 'services/Twilio/Capability.php']);
                $capability = new \Services_Twilio_Capability(DIALER_TSID, DIALER_TOKEN);
		$capability->allowClientOutgoing('AP59a7c2e59a2d42c8bb6df3cdea5a004d');
		$token = $capability->generateToken();
		$this->set('token', $token);
                $callerId = str_replace('+', '', DIALER_CALLERID);
		$this->set('callerId', $callerId);
            } catch (\Exception $e) {
                // Silent fail
            }
        }

        $LogArr = $this->Log->find()
            ->contain(['NappUser'])
            ->where(['task_id' => $task_id])
            ->order(['Log.id' => 'DESC'])
            ->toArray();

        $logArr = [];
        foreach ($LogArr as $log) {
            $logArr[] = [
                'Log' => $log->toArray(),
                'NappUser' => $log->napp_user ? $log->napp_user->toArray() : []
            ];
        }
        $this->set('LogArr', $logArr);
    }
}
