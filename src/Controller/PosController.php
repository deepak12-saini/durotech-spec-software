<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Pos Controller (DT PO - Purchase Orders)
 */
class PosController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('PoOrders');
        $this->loadModel('PoOrderDetails');
        $this->loadModel('NappUser');
        $this->loadModel('UserPermission');
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        $result = parent::beforeFilter($event);
        if ($result instanceof Response) {
            return $result;
        }
        $this->callConstants();
        return null;
    }

    // CamelCase aliases for CakePHP 3 routing
    public function adminIndex() { return $this->admin_index(); }
    public function adminApprove($id = null): ?Response { return $this->admin_approve($id); }
    public function adminComplete($id = null): ?Response { return $this->admin_complete($id); }

    /**
     * Admin: PO Order list
     */
    public function admin_index()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Po Order Detail');
        $this->checkAdminSession();

        $this->paginate = [
            'limit' => 25,
            'order' => ['PoOrders.id' => 'DESC'],
        ];
        $query = $this->PoOrders->find()
            ->contain(['NappUser' => function ($q) {
                return $q->select(['NappUser.id', 'NappUser.name', 'NappUser.lname']);
            }, 'PoOrderDetails']);
        $results = $this->paginate($query);
        $poorders = $this->_entitiesToPoOrderArrays($results);
        $this->set(compact('poorders'));
    }

    /**
     * Admin: Approve a PO order and set approvedby.
     */
    public function admin_approve($id = null): ?Response
    {
        $this->request->allowMethod(['post']);
        $this->checkAdminSession();

        $id = (int)$id;
        if ($id <= 0) {
            $this->Flash->error('Invalid PO order.');
            return $this->redirect(['action' => 'admin_index']);
        }

        try {
            $po = $this->PoOrders->get($id);
        } catch (\Throwable $e) {
            $this->Flash->error('PO order not found.');
            return $this->redirect(['action' => 'admin_index']);
        }

        $admin = (array)$this->request->getSession()->read('User');
        $approvedBy = trim((string)($admin['name'] ?? $admin['username'] ?? 'Admin'));

        if ((int)($po->status ?? 0) < 1) {
            $po->status = 1; // In-Process
        }
        $po->approvedby = $approvedBy;

        if ($this->PoOrders->save($po)) {
            $this->Flash->success('PO approved successfully.');
        } else {
            $this->Flash->error('Unable to approve PO order.');
        }

        return $this->redirect(['action' => 'admin_index']);
    }

    /**
     * Admin: Complete a PO order.
     */
    public function admin_complete($id = null): ?Response
    {
        $this->request->allowMethod(['post']);
        $this->checkAdminSession();

        $id = (int)$id;
        if ($id <= 0) {
            $this->Flash->error('Invalid PO order.');
            return $this->redirect(['action' => 'admin_index']);
        }

        try {
            $po = $this->PoOrders->get($id);
        } catch (\Throwable $e) {
            $this->Flash->error('PO order not found.');
            return $this->redirect(['action' => 'admin_index']);
        }

        $admin = (array)$this->request->getSession()->read('User');
        $approvedBy = trim((string)($admin['name'] ?? $admin['username'] ?? 'Admin'));

        if (empty((string)($po->approvedby ?? ''))) {
            $po->approvedby = $approvedBy;
        }
        $po->status = 2; // Completed

        if ($this->PoOrders->save($po)) {
            $this->Flash->success('PO marked as completed.');
        } else {
            $this->Flash->error('Unable to complete PO order.');
        }

        return $this->redirect(['action' => 'admin_index']);
    }

    /**
     * Staff: PO Order list (own records)
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Po Order Detail');
        $this->checkSatffSession();
        $userId = $this->request->getSession()->read('Customer.id');

        $this->paginate = [
            'limit' => 25,
            'order' => ['PoOrders.id' => 'DESC'],
        ];
        $query = $this->PoOrders->find()
            ->contain(['PoOrderDetails'])
            ->where(['PoOrders.user_id' => $userId]);
        $results = $this->paginate($query);
        $poorders = $this->_entitiesToPoOrderArrays($results);
        $this->set(compact('poorders'));
    }

    /**
     * Staff: Add PO Order
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Add New Po Order');
        $this->checkSatffSession();
        $userId = $this->request->getSession()->read('Customer.id');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $legacy = (array)($data['data'] ?? []);
            $PoOrderArr = $this->PoOrders->find()->orderDesc('id')->first();
            if (!empty($PoOrderArr)) {
                $order = $PoOrderArr->id + 1;
                if (strlen((string)$order) == 1) {
                    $newid = '00' . $order;
                } elseif (strlen((string)$order) == 2) {
                    $newid = '0' . $order;
                } else {
                    $newid = (string)$order;
                }
            } else {
                $newid = 'DT PO001';
            }

            $poOrderData = array_merge(
                (array)($legacy['PoOrder'] ?? []),
                (array)($data['PoOrder'] ?? [])
            );
            $itemNames = $data['item_name'] ?? ($legacy['item_name'] ?? []);
            $quantities = $data['quantity'] ?? ($legacy['quantity'] ?? []);
            $poOrderData['orderid'] = $newid;
            $poOrderData['user_id'] = $userId;
            $poOrderData['created'] = date('Y-m-d H:i:s');
            
            $poOrder = $this->PoOrders->newEntity($poOrderData);
            if ($this->PoOrders->save($poOrder)) {
                $lastinsertId = $poOrder->id;
                if (!empty($itemNames) && is_array($itemNames)) {
                    $details = [];
                    foreach ($itemNames as $i => $itemName) {
                        if (!empty($itemName)) {
                            $details[] = [
                                'po_order_id' => $lastinsertId,
                                'item_name' => $itemName,
                                'quantity' => $quantities[$i] ?? 0,
                            ];
                        }
                    }
                    if (!empty($details)) {
                        $poOrderDetails = $this->PoOrderDetails->newEntities($details);
                        $this->PoOrderDetails->saveMany($poOrderDetails);
                    }
                }
                $this->Flash->success('Po Order Added successfully');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('The PO order could not be saved. Please, try again.');
        }
    }

    /**
     * Staff: Edit PO Order
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Edit Po Order');
        $this->checkSatffSession();
        $userId = $this->request->getSession()->read('Customer.id');

        $PoOrderArr = $this->PoOrders->find()
            ->contain(['PoOrderDetails'])
            ->where(['PoOrders.user_id' => $userId, 'PoOrders.id' => $id])
            ->first();

        if (empty($PoOrderArr)) {
            $this->Flash->error('Sorry, you have no permission to edit this order');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $legacy = (array)($data['data'] ?? []);
            $poOrderData = array_merge(
                (array)($legacy['PoOrder'] ?? []),
                (array)($data['PoOrder'] ?? [])
            );
            $itemNames = $data['item_name'] ?? ($legacy['item_name'] ?? []);
            $quantities = $data['quantity'] ?? ($legacy['quantity'] ?? []);
            $poOrderData['id'] = (int)$id;
            
            $poOrder = $this->PoOrders->patchEntity($PoOrderArr, $poOrderData);
            if ($this->PoOrders->save($poOrder)) {
                // Delete existing details
                $this->PoOrderDetails->deleteAll(['po_order_id' => $id]);
                
                // Add new details
                if (!empty($itemNames) && is_array($itemNames)) {
                    $details = [];
                    foreach ($itemNames as $i => $itemName) {
                        if (!empty($itemName)) {
                            $details[] = [
                                'po_order_id' => $id,
                                'item_name' => $itemName,
                                'quantity' => $quantities[$i] ?? 0,
                            ];
                        }
                    }
                    if (!empty($details)) {
                        $poOrderDetails = $this->PoOrderDetails->newEntities($details);
                        $this->PoOrderDetails->saveMany($poOrderDetails);
                    }
                }
                $this->Flash->success('Po Order updated successfully');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('The PO order could not be saved. Please, try again.');
        }
        
        // Convert entity to array format for backward compatibility with view
        $PoOrderArr = ['PoOrder' => $PoOrderArr->toArray()];
        if (!empty($PoOrderArr['PoOrder']['po_order_details'])) {
            $PoOrderArr['PoOrderDetail'] = [];
            foreach ($PoOrderArr['PoOrder']['po_order_details'] as $detail) {
                $PoOrderArr['PoOrderDetail'][] = is_object($detail) ? $detail->toArray() : $detail;
            }
        }
        $this->set('PoOrderArr', $PoOrderArr);
        $this->request = $this->request->withParsedBody($PoOrderArr);
    }

    /**
     * Convert paginated entities to array format expected by views (CakePHP 2 style)
     * @param \Cake\ORM\ResultSet $results
     * @return array
     */
    protected function _entitiesToPoOrderArrays($results)
    {
        $out = [];
        foreach ($results as $row) {
            // Get NappUser association (CakePHP 3 uses camelCase for associations)
            $napp = $row->napp_user ?? $row->nappUser ?? null;
            if (is_object($napp)) {
                $nappArray = $napp->toArray();
            } else {
                $nappArray = $napp ?? [];
            }
            
            // Get PoOrderDetails association (CakePHP 3 uses camelCase)
            $details = $row->po_order_details ?? $row->poOrderDetails ?? [];
            if (!is_array($details) && !is_iterable($details)) {
                $details = [];
            }
            
            $detailsArray = [];
            foreach ($details as $detail) {
                $detailsArray[] = is_object($detail) ? $detail->toArray() : $detail;
            }
            
            $rowArray = $row->toArray();
            // Remove association keys from main array to avoid duplication
            unset($rowArray['napp_user'], $rowArray['nappUser'], $rowArray['po_order_details'], $rowArray['poOrderDetails']);
            
            $out[] = [
                'PoOrder' => $rowArray,
                'NappUser' => $nappArray,
                'PoOrderDetail' => $detailsArray,
            ];
        }
        return $out;
    }
}
