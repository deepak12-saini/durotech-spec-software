<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * DuroOrders Controller (CakePHP 3.10)
 */
class DuroOrdersController extends AppController
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
    }

    /**
     * Admin: order list
     */
    public function admin_index()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Durotech Order List');
        $this->checkAdminSession();

        $this->paginate = [
            'limit' => 10,
            'order' => ['DuroOrders.id' => 'DESC'],
            'contain' => ['NappUser' => ['fields' => ['name', 'lname']], 'OrderProducts'],
        ];
        $DuroOrderArr = $this->paginate($this->DuroOrders);
        $this->set(compact('DuroOrderArr'));
    }

    /**
     * Admin: edit order
     */
    public function admin_edit($id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Add Order');
        $this->checkAdminSession();

        $this->loadModel('OrderProducts');
        $doc = $this->DuroOrders->get($id, [
            'contain' => ['NappUser', 'OrderProducts'],
        ]);
        $orderData = $doc->toArray();
        unset($orderData['napp_user'], $orderData['order_products']);
        $docArr = ['DuroOrder' => $orderData];
        $nappUser = $doc->napp_user ?? null;
        if ($nappUser) {
            $docArr['NappUser'] = is_object($nappUser) ? $nappUser->toArray() : (array)$nappUser;
        }
        $docArr['OrderProduct'] = $doc->order_products ? (is_object($doc->order_products) ? iterator_to_array($doc->order_products) : (array)$doc->order_products) : [];

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $duroData = $data['DuroOrder'] ?? $data;
            $duroData['id'] = $id;
            $entity = $this->DuroOrders->patchEntity($doc, $duroData);
            if ($this->DuroOrders->save($entity)) {
                $this->OrderProducts->deleteAll(['order_id' => $id]);
                $productName = $data['product_name'] ?? [];
                if (!empty($productName)) {
                    foreach ($productName as $i => $name) {
                        $this->OrderProducts->save($this->OrderProducts->newEntity([
                            'order_id' => $id,
                            'product_name' => $name,
                            'color' => $data['color'][$i] ?? null,
                            'size' => $data['size'][$i] ?? null,
                            'qty' => $data['qty'][$i] ?? null,
                        ]));
                    }
                }
                $status = (int)($duroData['status'] ?? 0);
                $customer_order_no = $duroData['customer_order_no'] ?? '';
                $email = $nappUser && is_object($nappUser) ? $nappUser->email : ($docArr['NappUser']['email'] ?? null);
                if ($email) {
                    $name = ($nappUser->name ?? '') . ' ' . ($nappUser->lname ?? '');
                    if ($status === 1) {
                        try {
                            $this->sendemail($email, SITENAME . " ::  Order #" . $customer_order_no . ' Accepted', 'acceptedorder', ['name' => $name, 'customer_order_no' => $customer_order_no, 'type' => 'Accepted']);
                        } catch (\Exception $e) {}
                    } elseif ($status === 2) {
                        try {
                            $this->sendemail($email, SITENAME . " ::  Order #" . $customer_order_no . ' Delivered', 'acceptedorder', ['name' => $name, 'customer_order_no' => $customer_order_no, 'type' => 'Delivered']);
                        } catch (\Exception $e) {}
                    }
                }
                $this->Flash->success('Product added successfully.');
                return $this->redirect(['action' => 'admin_index']);
            }
        }

        $this->set(compact('docArr'));
        $this->request = $this->request->withParsedBody($docArr);
    }

    /**
     * Staff/Customer: order list
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Durotech Order List');
        $this->checkSatffSession();
        $session = $this->request->getSession();
        $user_id = $session->read('Customer.id');
        if (!$user_id) {
            $this->Flash->error('Please log in.');
            return $this->redirect('/');
        }

        $this->paginate = [
            'limit' => 10,
            'order' => ['DuroOrders.id' => 'DESC'],
            'contain' => ['NappUser' => ['fields' => ['name', 'lname']], 'OrderProducts'],
        ];
        $DuroOrderArr = $this->paginate($this->DuroOrders->find()->where(['DuroOrders.user_id' => $user_id]));
        $this->set(compact('DuroOrderArr'));
    }

    /**
     * Staff: add order
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Add Order');
        $this->checkSatffSession();
        $session = $this->request->getSession();
        $user_id = $session->read('Customer.id');
        if (!$user_id) {
            $this->Flash->error('Please log in.');
            return $this->redirect('/');
        }

        $this->loadModel('NappUser');
        $this->loadModel('OrderProducts');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $duroData = $data['DuroOrder'] ?? $data;
            $duroData['status'] = 0;
            $duroData['user_id'] = $user_id;
            $entity = $this->DuroOrders->newEntity($duroData);
            if ($this->DuroOrders->save($entity)) {
                $lastInsertId = $entity->id;
                $productName = $data['product_name'] ?? [];
                if (!empty($productName)) {
                    foreach ($productName as $i => $name) {
                        $this->OrderProducts->save($this->OrderProducts->newEntity([
                            'order_id' => $lastInsertId,
                            'product_name' => $name,
                            'color' => $data['color'][$i] ?? null,
                            'size' => $data['size'][$i] ?? null,
                            'qty' => $data['qty'][$i] ?? null,
                        ]));
                    }
                }
                $customer_order_no = $duroData['customer_order_no'] ?? '';
                $name = $session->read('Customer.name') . ' ' . $session->read('Customer.lname');
                try {
                    $this->sendemail('management@durotechindustries.com.au', SITENAME . " :: New Order #" . $customer_order_no, 'neworder', ['name' => $name, 'customer_order_no' => $customer_order_no]);
                } catch (\Exception $e) {}
                $this->Flash->success('Product added successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }

        $cuser = $this->NappUser->find('all', ['conditions' => ['NappUser.is_staff_id' => 1], 'fields' => ['id', 'name', 'lname']]);
        $this->set('cuser', $cuser);
        $last = $this->DuroOrders->find()->orderDesc('DuroOrders.id')->first();
        $docId = $last ? ('DT-ORDER-' . (1000 + (int)$last->id + 1)) : 'DT-ORDER-1001';
        $this->set('docId', $docId);
    }

    /**
     * Admin autologin (legacy)
     */
    public function admin_autologin()
    {
        $this->loadModel('User');
        $admin = $this->User->find()->first();
        if ($admin) {
            $this->request->getSession()->write('User', $admin->toArray());
            $this->request->getSession()->write('is_admin', 1);
            return $this->redirect('/duro_orders');
        }
        return $this->redirect('/');
    }

    /**
     * Staff: edit order
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Add Order');
        $this->checkSatffSession();
        $session = $this->request->getSession();
        $user_id = $session->read('Customer.id');
        if (!$user_id) {
            $this->Flash->error('Please log in.');
            return $this->redirect('/');
        }

        $this->loadModel('NappUser');
        $this->loadModel('OrderProducts');

        $doc = $this->DuroOrders->get($id, ['contain' => ['OrderProducts']]);
        $orderData = $doc->toArray();
        unset($orderData['order_products']);
        $docArr = ['DuroOrder' => $orderData];
        $docArr['OrderProduct'] = $doc->order_products ? (is_object($doc->order_products) ? iterator_to_array($doc->order_products) : (array)$doc->order_products) : [];

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $duroData = $data['DuroOrder'] ?? $data;
            $duroData['id'] = $id;
            $entity = $this->DuroOrders->patchEntity($doc, $duroData);
            if ($this->DuroOrders->save($entity)) {
                $this->OrderProducts->deleteAll(['order_id' => $id]);
                $productName = $data['product_name'] ?? [];
                if (!empty($productName)) {
                    foreach ($productName as $i => $name) {
                        $this->OrderProducts->save($this->OrderProducts->newEntity([
                            'order_id' => $id,
                            'product_name' => $name,
                            'color' => $data['color'][$i] ?? null,
                            'size' => $data['size'][$i] ?? null,
                            'qty' => $data['qty'][$i] ?? null,
                        ]));
                    }
                }
                $this->Flash->success('Product added successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }

        $cuser = $this->NappUser->find('all', ['conditions' => ['NappUser.is_staff_id' => 1], 'fields' => ['id', 'name', 'lname']]);
        $this->set(compact('cuser', 'docArr'));
        $this->request = $this->request->withParsedBody($docArr);
    }

    /**
     * Staff: delivery list
     */
    public function delivery()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Duro Delivery');
        $this->checkSatffSession();
        $session = $this->request->getSession();
        $user_id = $session->read('Customer.id');
        if (!$user_id) {
            $this->Flash->error('Please log in.');
            return $this->redirect('/');
        }

        $this->loadModel('DuroDeliveries');
        $this->paginate = [
            'limit' => 25,
            'order' => ['DuroDeliveries.id' => 'DESC'],
            'contain' => ['NappUser' => ['fields' => ['name', 'lname']], 'Drivers'],
        ];
        $delivers = $this->paginate($this->DuroDeliveries->find()->where(['DuroDeliveries.user_id' => $user_id]));
        $this->set(compact('delivers'));
    }

    /**
     * Staff: add delivery
     */
    public function delivery_add()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Add Delivery');
        $this->checkSatffSession();
        $session = $this->request->getSession();
        $user_id = $session->read('Customer.id');
        if (!$user_id) {
            $this->Flash->error('Please log in.');
            return $this->redirect('/');
        }

        $this->loadModel('DuroDeliveries');
        $this->loadModel('Drivers');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $order_id = $data['DuroDelivery']['order_id'] ?? null;
            $docketFile = $_FILES['docket_file']['name'] ?? '';
            $tmp_name = $_FILES['docket_file']['tmp_name'] ?? '';
            $docket_file = null;
            if (!empty($docketFile) && !empty($tmp_name)) {
                $ext = strtolower(pathinfo($docketFile, PATHINFO_EXTENSION));
                $allowed = ['gif', 'png', 'jpg'];
                if (in_array($ext, $allowed)) {
                    $docket_file = $order_id . '.' . $ext;
                    $dir = WWW_ROOT . 'docket_file' . DS;
                    if (!is_dir($dir)) mkdir($dir, 0755, true);
                    move_uploaded_file($tmp_name, $dir . $docket_file);
                    $url = SITEURL . 'dompdf/docket_file.php?docket_file=' . urlencode($docket_file);
                    @file_get_contents($url);
                    $docket_file = $order_id . '.pdf';
                } else {
                    $docket_file = $order_id . '.' . $ext;
                    $dir = WWW_ROOT . 'docket_file' . DS;
                    if (!is_dir($dir)) mkdir($dir, 0755, true);
                    move_uploaded_file($tmp_name, $dir . $docket_file);
                }
            }
            $insert = [
                'user_id' => $user_id,
                'order_id' => $data['DuroDelivery']['order_id'] ?? null,
                'docket_number' => $data['DuroDelivery']['docket_number'] ?? null,
                'date_of_order' => $data['DuroDelivery']['date_of_order'] ?? null,
                'pickup_name' => $data['DuroDelivery']['pickup_name'] ?? null,
                'pickup_date' => $data['DuroDelivery']['pickup_date'] ?? null,
                'pickup_time' => $data['DuroDelivery']['pickup_time'] ?? null,
                'deliver_date' => $data['DuroDelivery']['deliver_date'] ?? null,
                'deliver_time' => $data['DuroDelivery']['deliver_time'] ?? null,
                'driver_id' => $data['DuroDelivery']['driver_id'] ?? null,
            ];
            if ($docket_file) $insert['docket_file'] = $docket_file;
            $entity = $this->DuroDeliveries->newEntity($insert);
            if ($this->DuroDeliveries->save($entity)) {
                $this->Flash->success('Delivery order added successfully.');
                return $this->redirect(['action' => 'delivery']);
            }
        }

        $this->loadModel('DuroDeliveries');
        $last = $this->DuroDeliveries->find()->orderDesc('DuroDeliveries.id')->first();
        $docId = $last ? ('DT-ORDER-' . (1000 + (int)$last->id + 1)) : 'DT-ORDER-1001';
        $this->set('docId', $docId);
        $this->loadModel('Drivers');
        $driver = $this->Drivers->find('all', ['conditions' => ['Drivers.status' => 1]]);
        $this->set('driver', $driver);
    }

    /**
     * Staff: edit delivery
     */
    public function delivery_edit($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Add Delivery');
        $this->checkSatffSession();
        $session = $this->request->getSession();
        $user_id = $session->read('Customer.id');
        if (!$user_id) {
            $this->Flash->error('Please log in.');
            return $this->redirect('/');
        }

        $this->loadModel('DuroDeliveries');
        $this->loadModel('Drivers');
        $doc = $this->DuroDeliveries->get($id);
        $docArr = ['DuroDelivery' => $doc->toArray()];

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $order_id = $data['DuroDelivery']['order_id'] ?? null;
            $docket_file = null;
            if (!empty($_FILES['docket_file']['name'])) {
                $docketFile = $_FILES['docket_file']['name'];
                $tmp_name = $_FILES['docket_file']['tmp_name'];
                $ext = strtolower(pathinfo($docketFile, PATHINFO_EXTENSION));
                $allowed = ['gif', 'png', 'jpg'];
                if (in_array($ext, $allowed)) {
                    $docket_file = $order_id . '.' . $ext;
                    $dir = WWW_ROOT . 'docket_file' . DS;
                    if (!is_dir($dir)) mkdir($dir, 0755, true);
                    move_uploaded_file($tmp_name, $dir . $docket_file);
                    $url = SITEURL . 'dompdf/docket_file.php?docket_file=' . urlencode($docket_file);
                    @file_get_contents($url);
                    $docket_file = $order_id . '.pdf';
                } else {
                    $docket_file = $order_id . '.' . $ext;
                    $dir = WWW_ROOT . 'docket_file' . DS;
                    if (!is_dir($dir)) mkdir($dir, 0755, true);
                    move_uploaded_file($tmp_name, $dir . $docket_file);
                }
            }
            $patch = [
                'order_id' => $data['DuroDelivery']['order_id'] ?? null,
                'docket_number' => $data['DuroDelivery']['docket_number'] ?? null,
                'date_of_order' => $data['DuroDelivery']['date_of_order'] ?? null,
                'pickup_name' => $data['DuroDelivery']['pickup_name'] ?? null,
                'pickup_date' => $data['DuroDelivery']['pickup_date'] ?? null,
                'pickup_time' => $data['DuroDelivery']['pickup_time'] ?? null,
                'deliver_date' => $data['DuroDelivery']['deliver_date'] ?? null,
                'deliver_time' => $data['DuroDelivery']['deliver_time'] ?? null,
                'driver_id' => $data['DuroDelivery']['driver_id'] ?? null,
            ];
            if ($docket_file) $patch['docket_file'] = $docket_file;
            $doc = $this->DuroDeliveries->patchEntity($doc, $patch);
            if ($this->DuroDeliveries->save($doc)) {
                $this->Flash->success('Delivery order added successfully.');
                return $this->redirect(['action' => 'delivery']);
            }
        }

        $this->set(compact('docArr'));
        $this->request = $this->request->withParsedBody($docArr);
        $driver = $this->Drivers->find('all', ['conditions' => ['Drivers.status' => 1]]);
        $this->set('driver', $driver);
    }

    /**
     * Staff: delete delivery
     */
    public function delivery_delete($id = null)
    {
        if ($id) {
            $this->loadModel('DuroDeliveries');
            $entity = $this->DuroDeliveries->get($id);
            if ($this->DuroDeliveries->delete($entity)) {
                $this->Flash->success('Delivery order deleted successfully.');
            }
        }
        return $this->redirect(['action' => 'delivery']);
    }

    /**
     * Staff: driver list
     */
    public function driver()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' All Driver List');
        $this->checkSatffSession();
        $this->loadModel('Drivers');
        $DriverAll = $this->Drivers->find('all', ['order' => ['Drivers.id' => 'DESC']]);
        $this->set(compact('DriverAll'));
    }

    /**
     * Staff: add driver (AJAX/form)
     */
    public function adddriver()
    {
        $this->checkSatffSession();
        $session = $this->request->getSession();
        $user_id = $session->read('Customer.id');
        if ($this->request->is('post')) {
            $this->loadModel('Drivers');
            $data = $this->request->getData('Driver') ?: $this->request->getData();
            $data['user_id'] = $user_id;
            if (!empty($_FILES['photo']['name'])) {
                $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $name = time() . '_photo.' . $ext;
                $dir = WWW_ROOT . 'driver' . DS;
                if (!is_dir($dir)) mkdir($dir, 0755, true);
                move_uploaded_file($_FILES['photo']['tmp_name'], $dir . $name);
                $data['photo'] = $name;
            }
            if (!empty($_FILES['police_certificate']['name'])) {
                $ext = pathinfo($_FILES['police_certificate']['name'], PATHINFO_EXTENSION);
                $name = time() . '_police_certificate.' . $ext;
                $dir = WWW_ROOT . 'driver' . DS;
                if (!is_dir($dir)) mkdir($dir, 0755, true);
                move_uploaded_file($_FILES['police_certificate']['tmp_name'], $dir . $name);
                $data['police_certificate'] = $name;
            }
            if (!empty($_FILES['driver_certificate']['name'])) {
                $ext = pathinfo($_FILES['driver_certificate']['name'], PATHINFO_EXTENSION);
                $name = time() . '_driver_certificate.' . $ext;
                $dir = WWW_ROOT . 'driver' . DS;
                if (!is_dir($dir)) mkdir($dir, 0755, true);
                move_uploaded_file($_FILES['driver_certificate']['tmp_name'], $dir . $name);
                $data['driver_certificate'] = $name;
            }
            $entity = $this->Drivers->newEntity($data);
            if ($this->Drivers->save($entity)) {
                $this->Flash->success('The driver has been saved.');
            }
        }
        return $this->redirect(['action' => 'driver']);
    }

    /**
     * Staff: edit driver (JSON response)
     */
    public function editdriver($brand_id = null)
    {
        $this->checkSatffSession();
        $this->loadModel('Drivers');
        $brand = $this->Drivers->find()->where(['Drivers.id' => $brand_id])->first();
        return $this->response->withStringBody($brand ? json_encode($brand->toArray()) : '{}')
            ->withType('application/json');
    }

    /** CamelCase aliases for routing */
    public function adminIndex() { return $this->admin_index(); }
    public function adminEdit($id = null) { return $this->admin_edit($id); }
    public function adminAutologin() { return $this->admin_autologin(); }
    public function deliveryAdd() { return $this->delivery_add(); }
    public function deliveryEdit($id = null) { return $this->delivery_edit($id); }
    public function deliveryDelete($id = null) { return $this->delivery_delete($id); }
}
