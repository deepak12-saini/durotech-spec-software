<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Clients Controller (CakePHP 3.10) – client/customer list, categories, comments, assign
 */
class ClientsController extends AppController
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
        $this->loadComponent('Paginator');
        $this->loadModel('Clients');
        $this->loadModel('ClientTypes');
        $this->loadModel('StaffClients');
        $this->loadModel('ClientComments');
        $this->loadModel('NappUser');
        $this->loadModel('UserPermission');
        $this->loadModel('User');
        $this->loadModel('DialerNumbers');
    }

    // CamelCase aliases for CakePHP 3 routing
    public function adminCommentdownload($id) { return $this->admin_commentdownload($id); }
    public function adminAddcomment($client_id = null) { return $this->admin_addcomment($client_id); }
    public function adminComment($client_id = null) { return $this->admin_comment($client_id); }
    public function adminAssign() { return $this->admin_assign(); }
    public function adminIndex($id = null) { return $this->admin_index($id); }
    public function adminImport() { return $this->admin_import(); }
    public function adminAdd() { return $this->admin_add(); }
    public function adminEdit($id = null) { return $this->admin_edit($id); }
    public function adminClienttypeAdd() { return $this->admin_clienttype_add(); }
    public function adminClienttypeEdit($id) { return $this->admin_clienttype_edit($id); }
    public function adminClienttype() { return $this->admin_clienttype(); }

    public function admin_commentdownload($id)
    {
        $this->viewBuilder()->setLayout(false);
        $this->request->allowMethod(['get']);
        $this->checkAdminSession();
        $path = WWW_ROOT . 'clientdoc' . DIRECTORY_SEPARATOR . base64_decode(base64_decode($id));
        if (file_exists($path)) {
            return $this->response->withFile($path, ['download' => true, 'name' => basename($path)]);
        }
        return $this->redirect($this->referer());
    }

    public function admin_addcomment($client_id = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $this->set('title_for_layout', SITENAME . ' Employee Comments');
        $this->checkAdminSession();
        $user_id = $this->request->getSession()->read('User.id');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $documents = '';
            if (!empty($_FILES['documents']['name'])) {
                $name = $_FILES['documents']['name'];
                $tempname = $_FILES['documents']['tmp_name'];
                $path = WWW_ROOT . 'clientdoc' . DIRECTORY_SEPARATOR;
                $filename = time() . '_' . $name;
                if (is_dir($path) && move_uploaded_file($tempname, $path . $filename)) {
                    $documents = $filename;
                }
            }
            $entity = $this->ClientComments->newEntity([
                'comment' => $data['comment'] ?? '',
                'client_id' => (int)$client_id,
                'admin_id' => (int)$user_id,
                'type' => 1,
                'documents' => $documents,
            ]);
            if ($this->ClientComments->save($entity)) {
                $this->Flash->success('Comment posted successfully');
                return $this->redirect(['action' => 'admin_comment', $client_id]);
            }
        }
        $this->set('client_id', $client_id);
    }

    public function admin_comment($client_id = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $this->set('title_for_layout', SITENAME . ' Employee Comments');
        $this->checkAdminSession();
        $clientArr = $this->ClientComments->find('all')
            ->where(['ClientComments.client_id' => $client_id])
            ->contain(['Clients' => ['fields' => ['fname', 'lname']], 'User' => ['fields' => ['name']], 'NappUser' => ['fields' => ['name', 'lname']]])
            ->orderDesc('ClientComments.id')
            ->all();
        $this->set(compact('clientArr', 'client_id'));
    }

    public function admin_assign()
    {
        $this->viewBuilder()->setLayout(false);
        $this->checkAdminSession();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $staff_id = $data['client_id'] ?? null;
            $selectids = $data['selectids'] ?? [];
            if ($staff_id && !empty($selectids)) {
                foreach ($selectids as $client_id) {
                    $exists = $this->StaffClients->find()->where(['StaffClients.client_id' => $client_id, 'StaffClients.staff_id' => $staff_id])->first();
                    if (!$exists) {
                        $this->StaffClients->save($this->StaffClients->newEntity(['staff_id' => $staff_id, 'client_id' => $client_id]));
                    }
                }
            }
            return $this->redirect(['action' => 'admin_index']);
        }
        return $this->redirect(['action' => 'admin_index']);
    }

    public function admin_index($id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' customer list');
        $this->checkAdminSession();
        $session = $this->request->getSession();
        $StaffClientArr = [];
        $clientId = $session->read('client.id');
        if ($id === 'clear') {
            $session->delete('client');
            return $this->redirect(['action' => 'admin_index']);
        }
        if (!empty($id) && $id !== 'clear') {
            $session->write('client.id', $id);
            $clientId = $id;
            $StaffClientArr = $this->StaffClients->find('list', ['valueField' => 'client_id'])->where(['StaffClients.staff_id' => $id])->toArray();
            $StaffClientArr = array_values($StaffClientArr);
        } elseif (!empty($clientId)) {
            $StaffClientArr = $this->StaffClients->find('list', ['valueField' => 'client_id'])->where(['StaffClients.staff_id' => $clientId])->toArray();
            $StaffClientArr = array_values($StaffClientArr);
        }
        $this->set(compact('clientId', 'StaffClientArr'));

        $data = $this->request->getData();
        $clientArr = $session->read('client');
        $category_id = $clientArr['category_id'] ?? ($data['category_id'] ?? '');
        $search = $clientArr['search'] ?? ($data['search'] ?? '');
        $client_id = $clientArr['client_id'] ?? ($data['client_id'] ?? '');

        $searchclient = [];
        if ($this->request->is('post')) {
            if (!empty($client_id)) {
                $session->write('client.client_id', $client_id);
                $searchclient = $this->StaffClients->find('list', ['valueField' => 'client_id'])->where(['StaffClients.staff_id' => $client_id])->toArray();
                $searchclient = array_values($searchclient);
            } else {
                $session->delete('client.client_id');
            }
            if (!empty($category_id)) {
                $session->write('client.category_id', $category_id);
            } else {
                $session->delete('client.category_id');
            }
            if (!empty($search)) {
                $session->write('client.search', $search);
            } else {
                $session->delete('client.search');
            }
        } elseif (!empty($clientArr)) {
            $client_id = $session->read('client.client_id');
            if (!empty($client_id)) {
                $searchclient = $this->StaffClients->find('list', ['valueField' => 'client_id'])->where(['StaffClients.staff_id' => $client_id])->toArray();
                $searchclient = array_values($searchclient);
            }
            $category_id = $session->read('client.category_id');
            $search = $session->read('client.search');
        } else {
            $searchclient = $StaffClientArr;
        }

        $conditions = [];
        if (!empty($searchclient)) {
            $conditions['Clients.id IN'] = $searchclient;
        } elseif (!empty($clientId)) {
            $conditions['Clients.id'] = 0;
        }
        if (!empty($category_id)) {
            $conditions['Clients.category_id'] = $category_id;
        }
        if (!empty($search)) {
            $conditions['OR'] = [
                'Clients.mobile LIKE' => '%' . $search . '%',
                'Clients.fname LIKE' => '%' . $search . '%',
                'Clients.email LIKE' => '%' . $search . '%',
            ];
        }

        $this->paginate = ['limit' => 300, 'order' => ['Clients.fname' => 'asc']];
        $query = $this->Clients->find()->contain(['ClientTypes', 'StaffClients' => ['NappUser' => ['fields' => ['name', 'lname']]]])->where($conditions);
        $clientArr = $this->paginate($query);
        $ClientTypeArr = $this->ClientTypes->find('all')->all();
        $userper = $this->UserPermission->find('list', ['valueField' => 'user_id'])->where(['UserPermission.meta_val' => 'sr'])->toArray();
        $userIds = array_values($userper);
        $cuserQuery = $this->NappUser->find('all', ['fields' => ['id', 'name', 'lname']])
            ->where(['NappUser.is_staff_id' => 1, 'NappUser.id IN' => $userIds]);
        $cuser = $userIds ? $cuserQuery->all() : [];
        $this->set(compact('clientArr', 'ClientTypeArr', 'category_id', 'search', 'client_id', 'cuser'));
    }

    public function admin_import()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Import Customer');
        $this->checkAdminSession();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (!empty($_FILES['file']['name'])) {
                $name = $_FILES['file']['name'];
                $tmp_name = $_FILES['file']['tmp_name'];
                $path = WWW_ROOT . 'files' . DIRECTORY_SEPARATOR . $name;
                if (move_uploaded_file($tmp_name, $path) && ($openfile = fopen($path, 'r')) !== false) {
                    $i = 0;
                    $category_id = (int)($data['Client']['category_id'] ?? 0);
                    while (($getdata = fgetcsv($openfile, 1000, ',')) !== false) {
                        if ($i > 0) {
                            $exists = $this->Clients->find()->where(['Clients.mobile' => $getdata[2] ?? '', 'Clients.email' => $getdata[5] ?? ''])->first();
                            if (!$exists) {
                                $this->Clients->save($this->Clients->newEntity([
                                    'category_id' => $category_id,
                                    'company' => $getdata[0] ?? '',
                                    'fname' => $getdata[1] ?? '',
                                    'mobile' => $getdata[2] ?? '',
                                    'landline' => $getdata[3] ?? '',
                                    'address1' => $getdata[4] ?? '',
                                    'email' => $getdata[5] ?? '',
                                    'website' => $getdata[6] ?? '',
                                    'status' => 1,
                                ]));
                            }
                        }
                        $i++;
                    }
                    fclose($openfile);
                    $this->Flash->success('The customer has been saved');
                    return $this->redirect(['action' => 'admin_index']);
                }
            }
        }
        $ClientTypeArr = $this->ClientTypes->find('all')->all();
        $this->set(compact('ClientTypeArr'));
    }

    public function admin_add()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Add New customer');
        $this->checkAdminSession();
        $client = $this->Clients->newEntity([]);
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $client = $this->Clients->patchEntity($client, $data['Client'] ?? $data);
            if ($this->Clients->save($client)) {
                $this->Flash->success('The customer has been saved');
                return $this->redirect(['action' => 'admin_index']);
            }
            $this->Flash->error('The customer could not be saved. Please, try again.');
        }
        $ClientTypeArr = $this->ClientTypes->find('all')->all();
        $this->set(compact('client', 'ClientTypeArr'));
    }

    public function admin_edit($id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Edit customer');
        $this->checkAdminSession();
        $client = $this->Clients->get($id);
        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $client = $this->Clients->patchEntity($client, $data['Client'] ?? $data);
            $client->id = (int)$id;
            if ($this->Clients->save($client)) {
                $this->Flash->success('The customer has been updated');
                return $this->redirect(['action' => 'admin_index']);
            }
            $this->Flash->error('The customer could not be saved. Please, try again.');
        }
        $clientArr = ['Client' => $client->toArray()];
        $ClientTypeArr = $this->ClientTypes->find('all')->all();
        $this->set(compact('clientArr', 'ClientTypeArr'));
        $this->request = $this->request->withParsedBody($clientArr);
    }

    public function admin_clienttype_add()
    {
        $this->checkAdminSession();
        $this->viewBuilder()->setLayout(false);
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $entity = $this->ClientTypes->newEntity(['name' => $data['name'] ?? '']);
            if ($this->ClientTypes->save($entity)) {
                return $this->redirect(['action' => 'admin_clienttype']);
            }
        }
    }

    public function admin_clienttype_edit($id)
    {
        $this->checkAdminSession();
        $this->viewBuilder()->setLayout(false);
        $ct = $this->ClientTypes->get($id);
        if ($this->request->is(['post', 'put', 'patch'])) {
            $ct = $this->ClientTypes->patchEntity($ct, $this->request->getData());
            $ct->id = (int)$id;
            if ($this->ClientTypes->save($ct)) {
                return $this->redirect(['action' => 'admin_clienttype']);
            }
        }
        $ClientTypeArr = [['ClientType' => $ct->toArray()]];
        $this->set('ClientTypeArr', $ClientTypeArr);
        $this->request = $this->request->withParsedBody($ClientTypeArr);
    }

    public function admin_clienttype()
    {
        $this->checkAdminSession();
        $this->viewBuilder()->setLayout(false);
        $this->paginate = ['limit' => 25];
        $ClientTypeArr = $this->paginate($this->ClientTypes->find());
        $this->set(compact('ClientTypeArr'));
    }

    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Edit customer');
        $this->checkSatffSession();
        $user_id = $this->request->getSession()->read('Customer.id');
        $client = $this->Clients->find()->where(['Clients.user_id' => $user_id, 'Clients.id' => $id])->first();
        if (!$client) {
            $this->Flash->error('Sorry, you have no permission.');
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['post', 'put', 'patch'])) {
            $client = $this->Clients->patchEntity($client, $this->request->getData());
            $client->id = (int)$id;
            if ($this->Clients->save($client)) {
                $this->Flash->success('The customer has been updated');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('The customer could not be saved. Please, try again.');
        }
        $clientArr = ['Client' => $client->toArray()];
        $ClientTypeArr = $this->ClientTypes->find('all')->all();
        $this->set(compact('clientArr', 'ClientTypeArr', 'user_id'));
        $this->request = $this->request->withParsedBody($clientArr);
    }

    public function add()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Add New customer');
        $this->checkSatffSession();
        $user_id = (int)$this->request->getSession()->read('Customer.id');
        $client = $this->Clients->newEntity([]);
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['Client'] = $data['Client'] ?? $data;
            $data['Client']['user_id'] = $user_id;
            $client = $this->Clients->patchEntity($client, $data['Client']);
            if ($this->Clients->save($client)) {
                $this->StaffClients->save($this->StaffClients->newEntity(['staff_id' => $user_id, 'client_id' => $client->id]));
                $this->Flash->success('The customer has been saved');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('The customer could not be saved. Please, try again.');
        }
        $clientTypes = $this->ClientTypes->find()->all();
        $ClientTypeArr = [];
        foreach ($clientTypes as $entity) {
            $ClientTypeArr[] = ['ClientType' => $entity->toArray()];
        }
        $this->set(compact('ClientTypeArr'));
    }

    public function index($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' customer list');
        $this->checkSatffSession();
        $user_id = (int)$this->request->getSession()->read('Customer.id');
        $this->set('user_id', $user_id);
        if ($id === 'clear') {
            $this->request->getSession()->delete('client');
            return $this->redirect(['action' => 'index']);
        }
        $StaffClientArr = $this->StaffClients->find('list', ['valueField' => 'client_id'])->where(['StaffClients.staff_id' => $user_id])->toArray();
        $StaffClientArr = array_values($StaffClientArr);
        $session = $this->request->getSession();
        $clientArr = $session->read('client');
        $data = $this->request->getData();
        $category_id = $clientArr['category_id'] ?? ($data['category_id'] ?? '');
        $search = trim($clientArr['search'] ?? ($data['search'] ?? ''));
        if ($this->request->is('post')) {
            if (!empty($category_id)) {
                $session->write('client.category_id', $category_id);
            } else {
                $session->delete('client.category_id');
            }
            if (!empty($search)) {
                $session->write('client.search', $search);
            } else {
                $session->delete('client.search');
            }
        } elseif (!empty($clientArr)) {
            $category_id = $session->read('client.category_id');
            $search = $session->read('client.search');
        }
        $conditions = ['Clients.id IN' => $StaffClientArr ?: [0]];
        if (!empty($category_id)) {
            $conditions['Clients.category_id'] = $category_id;
        }
        if (!empty($search)) {
            $conditions['OR'] = [
                'Clients.mobile LIKE' => '%' . $search . '%',
                'Clients.fname LIKE' => '%' . $search . '%',
                'Clients.email LIKE' => '%' . $search . '%',
            ];
        }
        $this->paginate = ['limit' => 300, 'order' => ['Clients.fname' => 'asc']];
        $query = $this->Clients->find()->contain(['ClientTypes', 'StaffClients' => ['NappUser' => ['fields' => ['name', 'lname']]]])->where($conditions);
        $clientArr = $this->paginate($query);
        $clientTypes = $this->ClientTypes->find()->all();
        $ClientTypeArr = [];
        foreach ($clientTypes as $entity) {
            $ClientTypeArr[] = ['ClientType' => $entity->toArray()];
        }
        $userper = $this->UserPermission->find('list', ['valueField' => 'user_id'])->where(['UserPermission.meta_val' => 'sr'])->toArray();
        $userIds = array_values($userper);
        $cuserQuery = $this->NappUser->find('all', ['fields' => ['id', 'name', 'lname']])
            ->where(['NappUser.is_staff_id' => 1, 'NappUser.id IN' => $userIds]);
        $cuser = $userIds ? $cuserQuery->all() : [];
        $client_id = '';
        $this->set(compact('clientArr', 'ClientTypeArr', 'category_id', 'search', 'client_id', 'cuser'));
    }

    public function addcomment($client_id = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $this->set('title_for_layout', SITENAME . ' Employee Comments');
        $this->checkSatffSession();
        $user_id = (int)$this->request->getSession()->read('Customer.id');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $documents = '';
            if (!empty($_FILES['documents']['name'])) {
                $path = WWW_ROOT . 'clientdoc' . DIRECTORY_SEPARATOR;
                $filename = time() . '_' . $_FILES['documents']['name'];
                if (is_dir($path) && move_uploaded_file($_FILES['documents']['tmp_name'], $path . $filename)) {
                    $documents = $filename;
                }
            }
            $entity = $this->ClientComments->newEntity([
                'comment' => $data['comment'] ?? '',
                'client_id' => (int)$client_id,
                'emp_id' => $user_id,
                'type' => 0,
                'documents' => $documents,
            ]);
            if ($this->ClientComments->save($entity)) {
                $this->Flash->success('Comment posted successfully');
                return $this->redirect(['action' => 'comment', $client_id]);
            }
        }
        $this->set('client_id', $client_id);
    }

    public function comment($client_id = null)
    {
        $this->viewBuilder()->setLayout('admin_new_layout');
        $this->set('title_for_layout', SITENAME . ' Employee Comments');
        $this->checkSatffSession();
        $clientArr = $this->ClientComments->find('all')
            ->where(['ClientComments.client_id' => $client_id])
            ->contain(['Clients' => ['fields' => ['fname', 'lname']], 'User' => ['fields' => ['name']], 'NappUser' => ['fields' => ['name', 'lname']]])
            ->orderDesc('ClientComments.id')
            ->all();
        $this->set(compact('clientArr', 'client_id'));
    }

    public function addclientdialers()
    {
        $this->viewBuilder()->setLayout(false);
        $client_list = $this->request->getQuery('client_list') ?: $this->request->getData('client_list');
        if (is_string($client_list)) {
            $client_list = array_filter(explode(',', $client_list));
        }
        if (!empty($client_list)) {
            $clients = $this->Clients->find('all', ['fields' => ['id', 'mobile']])->where(['Clients.id IN' => $client_list])->all();
            foreach ($clients as $client) {
                if (empty($client->mobile)) {
                    continue;
                }
                $dial = $this->DialerNumbers->find()->where(['DialerNumbers.client_id' => $client->id])->orderDesc('DialerNumbers.id')->first();
                if (($dial && (int)$dial->status === 1) || !$dial) {
                    $phone = str_replace(['+', ' '], '', $client->mobile);
                    if (strpos($phone, '0') === 0) {
                        $phone = '61' . ltrim($phone, '0');
                    }
                    $this->DialerNumbers->save($this->DialerNumbers->newEntity([
                        'client_id' => $client->id,
                        'phone' => $phone,
                        'comments' => '',
                        'status' => 0,
                    ]));
                }
            }
        }
    }
}
