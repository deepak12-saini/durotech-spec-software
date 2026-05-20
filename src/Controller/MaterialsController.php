<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Log\Log;

/**
 * Materials Controller (CakePHP 3.10) – Material types and material order requests
 */
class MaterialsController extends AppController
{
    public function beforeFilter(EventInterface $event): ?Response
    {
        $result = parent::beforeFilter($event);
        if ($result instanceof Response) {
            return $result;
        }
        $this->callConstants();
        return null;
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Materials');
        $this->loadModel('MaterialOrders');
        $this->loadModel('NappUser');
        $this->loadModel('UserPermission');
        $this->loadModel('LoginHistory');
        $this->loadModel('User');
    }

    // ----- CamelCase aliases for CakePHP 3 routing -----
    public function adminIndex() { return $this->admin_index(); }
    public function adminOrder($type = null) { return $this->admin_order($type); }
    public function adminStatus($status = null, $orderid = null, $type = null) { return $this->admin_status($status, $orderid, $type); }
    public function adminAdd() { return $this->admin_add(); }
    public function adminEdit($id = null) { return $this->admin_edit($id); }
    public function adminAutologin($id) { return $this->admin_autologin($id); }

    public function admin_index()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Material ');
        $this->checkAdminSession();
        $materials = $this->Materials->find()
            ->order(['Materials.id' => 'DESC'])
            ->all();
        $this->set('materials', $materials);
    }

    public function admin_order($type = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Material Order Request');
        $this->checkAdminSession();
        $search = '';
        $status = null;
        if (!empty($type) && $type === 'pending') {
            $status = 0;
        } elseif (!empty($type) && $type === 'completed') {
            $status = 2;
        } elseif (!empty($type) && $type === 'accepted') {
            $status = 1;
        }
        $query = $this->MaterialOrders->find()
            ->order(['MaterialOrders.id' => 'DESC'])
            ->limit(25);
        if ($status !== null) {
            $query = $query->where(['MaterialOrders.status' => $status]);
        }
        $MaterialOrder = $query->all();
        $this->set(compact('MaterialOrder', 'search', 'type'));
        $this->set('type', ucfirst((string)$type));
    }

    public function admin_status($status = null, $orderid = null, $type = null)
    {
        $this->request->allowMethod(['get']);
        $this->viewBuilder()->setLayout(false);
        $response = $this->response;
        $this->checkAdminSession();
        $admin_id = $this->request->getSession()->read('User.id');
        $entity = $this->MaterialOrders->get($orderid);
        $entity->admin_id = $admin_id;
        $entity->status = (int)$status;
        $entity->lastmodification = date('Y-m-d H:i:s');
        if ($this->MaterialOrders->save($entity)) {
            $this->Flash->success($status == 1 ? 'Accepted successfully.' : 'Completed successfully.');
            return $this->redirect(['action' => 'admin_order', $type]);
        }
        return $response;
    }

    public function admin_add()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Add New Material Type');
        $this->checkAdminSession();
        $material = $this->Materials->newEntity([]);
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $material = $this->Materials->patchEntity($material, $data);
            if ($this->Materials->save($material)) {
                $this->Flash->success('Material Added successfully');
                return $this->redirect(['action' => 'admin_index']);
            }
        }
        $this->set(compact('material'));
    }

    public function admin_edit($id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Edit Material Type');
        $this->checkAdminSession();
        $material = $this->Materials->get($id);
        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $material = $this->Materials->patchEntity($material, $data);
            if ($this->Materials->save($material)) {
                $this->Flash->success('Material updated successfully');
                return $this->redirect(['action' => 'admin_index']);
            }
        }
        $MaterialArr = ['Material' => $material->toArray()];
        $this->set('MaterialArr', $MaterialArr);
        $this->request = $this->request->withParsedBody($MaterialArr);
    }

    public function readqrcode($qrcode = null)
    {
        $this->viewBuilder()->setLayout('admin_login');
        $this->set('title_for_layout', SITENAME . ' Place order');
        $materialId = (int)($qrcode ?? 0);
        $material = $materialId > 0
            ? $this->Materials->find()->where(['Materials.id' => $materialId])->first()
            : null;
        if (!$material) {
            $this->Flash->error(__('This material link is invalid or no longer exists.'));
            return $this->redirect('/');
        }
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $last = $this->MaterialOrders->find()->orderDesc('MaterialOrders.id')->first();
            $nextId = $last ? (int)$last->id + 1 : 1;
            $orderid = 'POR' . str_pad((string)$nextId, 3, '0', STR_PAD_LEFT);
            $entity = $this->MaterialOrders->newEntity([
                'order_id' => $orderid,
                'material_id' => (int)($data['id'] ?? $material->id),
                'material_type' => $data['material_type'] ?? $material->material_type,
                'weight' => $data['weight'] ?? $material->weight,
                'quantity' => $data['quantity'] ?? $material->quantity,
                'name' => $data['name'] ?? '',
            ]);
            if ($this->MaterialOrders->save($entity)) {
                $teamMails = [
                    'sales@durotechindustries.com.au',
                    'kal@durotechindustries.com.au',
                    'info@durotechindustries.com.au',
                ];
                $subject = SITENAME . ':- New Material Order Request #' . $orderid;
                $template_name = 'martialorder';
                $adminurl = \Cake\Routing\Router::url(['controller' => 'Materials', 'action' => 'admin_autologin', 2], true);
                $variables = [
                    'toname' => 'Team',
                    'orderid' => $orderid,
                    'material_type' => $entity->material_type,
                    'weight' => $entity->weight,
                    'quantity' => $entity->quantity,
                    'requestedname' => $entity->name,
                    'url' => $adminurl,
                ];
                try {
                    $this->sendemail($teamMails, $subject, $template_name, $variables);
                } catch (\Throwable $e) {
                    Log::error('Material order team email failed: ' . $e->getMessage());
                }
                $userper = $this->UserPermission->find('list', ['keyField' => 'id', 'valueField' => 'user_id'])
                    ->where(['UserPermission.meta_val' => 'material'])->toArray();
                $userIds = array_values($userper);
                if (!empty($userIds)) {
                    $napuser = $this->NappUser->find()->where(['NappUser.id IN' => $userIds])->all();
                    foreach ($napuser as $nu) {
                        $userId = base64_encode(base64_encode((string)$nu->id));
                        $staffurl = \Cake\Routing\Router::url(['controller' => 'Materials', 'action' => 'autologin', $userId], true);
                        $variables['toname'] = trim(($nu->name ?? '') . ' ' . ($nu->lname ?? ''));
                        $variables['url'] = $staffurl;
                        $staffMail = trim((string)($nu->email ?? ''));
                        if ($staffMail !== '' && filter_var($staffMail, FILTER_VALIDATE_EMAIL)) {
                            try {
                                $this->sendemail($staffMail, $subject, $template_name, $variables);
                            } catch (\Throwable $e) {
                                Log::error('Material order staff notify failed for ' . $staffMail . ': ' . $e->getMessage());
                            }
                        }
                    }
                }
                return $this->redirect(['action' => 'success']);
            }
            $this->Flash->error(__('Could not save your request. Please check the form and try again.'));
        }
        $MaterialArr = ['Material' => $material->toArray()];
        $this->set('MaterialArr', $MaterialArr);
    }

    public function success()
    {
        $this->viewBuilder()->setLayout('admin_login');
        $this->set('title_for_layout', SITENAME . ' Success Page');
    }

    public function order($type = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Material Order Request');
        $this->checkSatffSession();
        $status = null;
        if (!empty($type) && $type === 'pending') {
            $status = 0;
        } elseif (!empty($type) && $type === 'completed') {
            $status = 2;
        } elseif (!empty($type) && $type === 'accepted') {
            $status = 1;
        }
        $query = $this->MaterialOrders->find()
            ->order(['MaterialOrders.id' => 'DESC'])
            ->limit(25);
        if ($status !== null) {
            $query = $query->where(['MaterialOrders.status' => $status]);
        }
        $MaterialOrder = $query->all();
        $this->set(compact('MaterialOrder', 'type'));
        $this->set('type', ucfirst((string)$type));
    }

    public function status($status = null, $orderid = null, $type = null)
    {
        $this->request->allowMethod(['get']);
        $this->viewBuilder()->setLayout(false);
        $this->checkSatffSession();
        $user_id = $this->request->getSession()->read('Customer.id');
        $entity = $this->MaterialOrders->get($orderid);
        $entity->user_id = $user_id;
        $entity->status = (int)$status;
        $entity->lastmodification = date('Y-m-d H:i:s');
        if ($this->MaterialOrders->save($entity)) {
            $this->Flash->success($status == 1 ? 'Accepted successfully.' : 'Completed successfully.');
            return $this->redirect(['action' => 'order', $type]);
        }
        return $this->redirect(['action' => 'order', $type]);
    }

    public function update($status = null, $orderid = null, $type = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Complete this order');
        $this->checkSatffSession();
        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $dtPo = $data['MaterialOrder']['dt_po_number'] ?? $data['dt_po_number'] ?? null;
            $entity = $this->MaterialOrders->get($orderid);
            $entity->dt_po_number = $dtPo;
            $entity->status = (int)$status;
            $entity->lastmodification = date('Y-m-d H:i:s');
            if ($this->MaterialOrders->save($entity)) {
                $this->Flash->success($status == 1 ? 'Accepted successfully.' : 'Completed successfully.');
                return $this->redirect(['action' => 'order', $type]);
            }
        }
        $this->set(compact('status', 'orderid', 'type'));
    }

    public function index()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Material ');
        $this->checkSatffSession();
        $materials = $this->Materials->find()
            ->order(['Materials.id' => 'DESC'])
            ->all();
        $this->set('materials', $materials);
    }

    public function autologin($id)
    {
        $this->viewBuilder()->setLayout(false);
        $userId = base64_decode(base64_decode($id));
        $user = $this->NappUser->find()->where(['NappUser.id' => $userId])->first();
        if ($user && (int)($user->is_staff_id ?? 0) === 1) {
            $this->LoginHistory->save($this->LoginHistory->newEntity([
                'user_id' => $user->id,
                'role' => 'Staff',
                'logintime' => date('Y-m-d H:i:s'),
            ]));
            $this->request->getSession()->write('Customer', $user->toArray());
            $this->request->getSession()->write('is_staff', 1);
            return $this->redirect(['action' => 'order']);
        }
        $this->Flash->error('Sorry you cannot access this portal');
        return $this->redirect('/login');
    }

    public function admin_autologin($id)
    {
        $this->viewBuilder()->setLayout(false);
        $admin = $this->User->find()->where(['id' => $id])->first();
        if ($admin) {
            $this->LoginHistory->save($this->LoginHistory->newEntity([
                'admin_id' => $admin->id,
                'role' => 'Admin',
                'logintime' => date('Y-m-d H:i:s'),
            ]));
            $this->request->getSession()->write('User', $admin->toArray());
            $this->request->getSession()->write('is_admin', 1);
            return $this->redirect(['action' => 'admin_order', 'pending']);
        }
        $this->Flash->error('Sorry you cannot access this portal');
        return $this->redirect('/admin');
    }

    public function signature()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Material ');
        $this->checkSatffSession();
        $user_id = $this->request->getSession()->read('Customer.id');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $sigimage = $data['sigimage'] ?? '';
            $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'webroot' . DIRECTORY_SEPARATOR . 'signature' . DIRECTORY_SEPARATOR;
            if (!is_dir($path)) {
                $path = WWW_ROOT . 'signature' . DIRECTORY_SEPARATOR;
            }
            $dataStr = str_replace('data:image/png;base64,', '', $sigimage);
            $dataStr = str_replace(' ', '+', $dataStr);
            $decoded = base64_decode($dataStr, true);
            if ($decoded !== false) {
                $imagename = uniqid('', true) . '.png';
                if (!is_dir($path)) {
                    @mkdir($path, 0755, true);
                }
                if (file_put_contents($path . $imagename, $decoded)) {
                    $user = $this->NappUser->get($user_id);
                    $user->sign = $imagename;
                    $this->NappUser->save($user);
                    $this->request->getSession()->write('Customer.sign', $imagename);
                    $this->Flash->success('Signature uploaded successfully.');
                    return $this->redirect(['action' => 'signature']);
                }
            }
        }
    }
}
