<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;

/**
 * Purchases Controller
 */
class PurchasesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('Purchase');
        $this->loadModel('PurchaseRequirement');
        $this->loadModel('NappUser');
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        parent::beforeFilter($event);
        $this->callConstants();
        return null;
    }

    public function add()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Add Purchase Request');
        $this->checkSatffSession();

        $userid = $this->request->getSession()->read('Customer.id');
        $name = $this->request->getSession()->read('Customer.name') . ' ' . $this->request->getSession()->read('Customer.lname');
        $sendername = ucfirst($name);

        $data = $this->request->getData();
        if (!empty($data)) {
            $itemDetails = $this->request->getData('Purchase.item_details') ?? '';
            $uniqueId = 1000;
            $last = $this->Purchase->find()->orderDesc('Purchase.id')->first();
            if ($last) {
                $uniqueId = 1000 + (int)$last->id;
            }
            $uniqueId = 'Rev-' . $uniqueId;

            $purchaseData = $this->request->getData('Purchase') ?? [];
            $purchaseData['unique_id'] = $uniqueId;
            $purchaseData['prepared_by'] = $userid;
            $purchaseData['created'] = date('Y-m-d H:i:s');

            $entity = $this->Purchase->newEntity($purchaseData);
            if ($this->Purchase->save($entity)) {
                $purchaseId = $entity->id;
                $itemNames = $this->request->getData('item_name');
                if (!empty($itemNames)) {
                    $comments = $this->request->getData('comments') ?? [];
                    $quantities = $this->request->getData('quantity') ?? [];
                    $descriptions = $this->request->getData('description_item') ?? [];
                    $i = 0;
                    foreach ($itemNames as $itemName) {
                        $req = [
                            'purchase_id' => $purchaseId,
                            'item_name' => $itemName,
                            'comments' => $comments[$i] ?? '',
                            'quantity' => $quantities[$i] ?? '',
                            'description_item' => $descriptions[$i] ?? '',
                        ];
                        $reqEntity = $this->PurchaseRequirement->newEntity($req);
                        $this->PurchaseRequirement->save($reqEntity);
                        $i++;
                    }
                }
                $permittedBy = (int)($this->request->getData('Purchase.permitted_by') ?? 0);
                if ($permittedBy > 0) {
                    $employe = $this->NappUser->find()->where(['NappUser.id' => $permittedBy])->first();
                    if ($employe) {
                        $receivername = $employe->get('name') . ' ' . $employe->get('lname');
                        $receiveremail = $employe->get('email');
                        $url = SITEURL . 'purchases/autologin/' . base64_encode((string)$employe->get('id'));
                        $subject = SITENAME . ':- ' . $sendername . ' has made request (' . $uniqueId . ')';
                        $templateName = 'sendrequest';
                        $variables = ['unique_id' => $uniqueId, 'sendername' => $sendername, 'receivername' => $receivername, 'url' => $url, 'item_details' => $itemDetails];
                        try {
                            $this->sendemail($receiveremail, $subject, $templateName, $variables);
                        } catch (\Exception $e) {
                        }
                    }
                }
                $this->Flash->success('Request has been created successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }
        $employeEntities = $this->NappUser->find()->where(['NappUser.is_staff_id' => 1])->all();
        $employeArr = [];
        foreach ($employeEntities as $e) {
            $employeArr[] = ['NappUser' => $e->toArray()];
        }
        $requisitionerName = $sendername ?? '';
        $this->set(compact('employeArr', 'requisitionerName'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->checkSatffSession();
        $entity = $this->Purchase->get($id);
        if ($this->Purchase->delete($entity)) {
            $this->Flash->success('Request has been deleted successfully.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function autologin($id = null)
    {
        $this->viewBuilder()->setLayout(false);
        $this->request->allowMethod(['get']);

        if (!empty($id)) {
            $uid = base64_decode($id);
            $userArr = $this->NappUser->find()->where(['NappUser.id' => $uid, 'NappUser.is_staff_id' => 1])->first();
            if ($userArr) {
                if ($userArr->get('is_active') == 0) {
                    $this->Flash->error('You account is not active');
                    return $this->redirect('/login');
                }
                $this->request->getSession()->write('Customer', $userArr->toArray());
                $this->request->getSession()->write('is_customer', 1);
                return $this->redirect('/purchases');
            }
        }
        return $this->redirect('/login');
    }

    public function received($id = null)
    {
        $this->checkSatffSession();
        $this->viewBuilder()->setLayout(false);

        $userid = $this->request->getSession()->read('Customer.id');
        $name = $this->request->getSession()->read('Customer.name') . ' ' . $this->request->getSession()->read('Customer.lname');
        $sendername = ucfirst($name);

        $purchase = $this->Purchase->get($id, ['contain' => ['PurchaseRequirements', 'NappUser1', 'NappUser', 'NappUser2']]);
        $PurchaseArr = $this->_purchaseToViewArray($purchase);

        $entity = $this->Purchase->patchEntity($purchase, ['status' => 2, 'name_of_receiver' => $sendername]);
        $this->Purchase->save($entity);

        $authorizedBy = (int)$PurchaseArr['Purchase']['authorized_by'];
        $uniqueId = $PurchaseArr['Purchase']['unique_id'];
        $itemDetails = $PurchaseArr['Purchase']['item_details'];
        $subject = SITENAME . ' :- Purchase Request(' . $uniqueId . ') has been closed by ' . $sendername;

        if (!empty($PurchaseArr['NappUser_1']['email'])) {
            $id2 = $PurchaseArr['NappUser_1']['id'];
            $email2 = 'web@xoroglobal.com';
            $name2 = $PurchaseArr['NappUser_1']['name'] . ' ' . $PurchaseArr['NappUser_1']['lname'];
            $url = SITEURL . 'purchases/autologin/' . base64_encode((string)$id2);
            $variables = ['unique_id' => $uniqueId, 'sendername' => $sendername, 'receivername' => $name2, 'url' => $url, 'item_details' => $itemDetails];
            try {
                $this->sendemail($email2, $subject, 'closerequest', $variables);
            } catch (\Exception $e) {
            }
        }
        if (!empty($PurchaseArr['NappUser']['email'])) {
            $id1 = $PurchaseArr['NappUser']['id'];
            $email1 = $PurchaseArr['NappUser']['email'];
            $name1 = $PurchaseArr['NappUser']['name'] . ' ' . $PurchaseArr['NappUser']['lname'];
            $url = SITEURL . 'purchases/autologin/' . base64_encode((string)$id1);
            $variables = ['unique_id' => $uniqueId, 'sendername' => $sendername, 'receivername' => $name1, 'url' => $url, 'item_details' => $itemDetails];
            try {
                $this->sendemail($email1, $subject, 'closerequest', $variables);
            } catch (\Exception $e) {
            }
        }
        if ($authorizedBy > 0) {
            $nappUser = $this->NappUser->get($authorizedBy);
            $arr = $nappUser->toArray();
            $url = SITEURL . 'purchases/autologin/' . base64_encode((string)$arr['id']);
            $variables = ['unique_id' => $uniqueId, 'sendername' => $sendername, 'receivername' => $arr['name'] . ' ' . $arr['lname'], 'url' => $url, 'item_details' => $itemDetails];
            try {
                $this->sendemail($arr['email'], $subject, 'closerequest', $variables);
            } catch (\Exception $e) {
            }
        }
        $this->Flash->success('Received successfully.');
        return $this->redirect(['action' => 'index']);
    }

    public function process($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Add Purchase Request');
        $this->checkSatffSession();

        $userid = $this->request->getSession()->read('Customer.id');
        $name = $this->request->getSession()->read('Customer.name') . ' ' . $this->request->getSession()->read('Customer.lname');
        $sendername = ucfirst($name);

        $purchase = $this->Purchase->get($id, ['contain' => ['PurchaseRequirements', 'NappUser1', 'NappUser', 'NappUser2']]);
        $PurchaseArr = $this->_purchaseToViewArray($purchase);
        $this->set(compact('PurchaseArr'));
        $uniqueId = $PurchaseArr['Purchase']['unique_id'];
        $itemDetails = $PurchaseArr['Purchase']['item_details'];

        $data = $this->request->getData();
        $purchaseData = $this->request->getData('Purchase');
        if (!empty($data) && is_array($purchaseData)) {
            $status = (int)($purchaseData['status'] ?? $this->request->getData('Purchase.status') ?? 0);
            $authorizedBy = (int)($purchaseData['authorized_by'] ?? $this->request->getData('Purchase.authorized_by') ?? 0);
            $entity = $this->Purchase->patchEntity($purchase, $purchaseData);
            $entity->id = (int)$id;
            if ($this->Purchase->save($entity)) {
                if (($authorizedBy > 0) && ($status < 2)) {
                    $subject = SITENAME . ' :- Purchase Request(' . $uniqueId . ') has been approved by ' . $sendername;
                    $nappUser = $this->NappUser->get($authorizedBy);
                    $arr = $nappUser->toArray();
                    $url = SITEURL . 'purchases/autologin/' . base64_encode((string)$authorizedBy);
                    $variables = ['unique_id' => $uniqueId, 'sendername' => $sendername, 'receivername' => $arr['name'] . ' ' . $arr['lname'], 'url' => $url, 'item_details' => $itemDetails];
                    try {
                        $this->sendemail($arr['email'], $subject, 'requestassign', $variables);
                    } catch (\Exception $e) {
                    }
                }
                if ($status == 1) {
                    $subject = SITENAME . ' :- Purchase Request(' . $uniqueId . ') has been approved by ' . $sendername;
                    $this->_sendCompletionEmails($PurchaseArr, $sendername, $uniqueId, $itemDetails, $subject, 'completiontask');
                }
                $this->Flash->success('Request updated successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->request = $this->request->withData('Purchase', $PurchaseArr['Purchase']);
        $employeEntities = $this->NappUser->find()->where(['NappUser.is_staff_id' => 1])->all();
        $employeArr = [];
        foreach ($employeEntities as $e) {
            $employeArr[] = ['NappUser' => $e->toArray()];
        }
        $this->set(compact('employeArr'));
    }

    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Add Purchase Request');
        $this->checkSatffSession();

        $userid = $this->request->getSession()->read('Customer.id');
        $data = $this->request->getData();
        if (!empty($data)) {
            $purchaseData = $this->request->getData('Purchase') ?? [];
            $purchaseData['prepared_by'] = $userid;
            $purchaseData['id'] = (int)$id;
            $purchaseData['created'] = date('Y-m-d H:i:s');

            $entity = $this->Purchase->get($id);
            $entity = $this->Purchase->patchEntity($entity, $purchaseData);
            if ($this->Purchase->save($entity)) {
                $this->PurchaseRequirement->deleteAll(['purchase_id' => $id]);
                $itemNames = $this->request->getData('item_name');
                if (!empty($itemNames)) {
                    $i = 0;
                    foreach ($itemNames as $itemName) {
                        $req = [
                            'purchase_id' => $id,
                            'item_name' => $itemName,
                            'comments' => $this->request->getData('comments')[$i] ?? '',
                            'quantity' => $this->request->getData('quantity')[$i] ?? '',
                            'description_item' => $this->request->getData('description_item')[$i] ?? '',
                        ];
                        $reqEntity = $this->PurchaseRequirement->newEntity($req);
                        $this->PurchaseRequirement->save($reqEntity);
                        $i++;
                    }
                }
                $this->Flash->success('Request has been created successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }
        $purchase = $this->Purchase->get($id, ['contain' => ['PurchaseRequirements']]);
        $PurchaseArr = $this->_purchaseToViewArray($purchase);
        $employeEntities = $this->NappUser->find()->where(['NappUser.is_staff_id' => 1])->all();
        $employeArr = [];
        foreach ($employeEntities as $e) {
            $employeArr[] = ['NappUser' => $e->toArray()];
        }
        $this->set(compact('employeArr', 'PurchaseArr'));
        $this->request = $this->request->withData('Purchase', $PurchaseArr['Purchase']);
    }

    public function index()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Purcashes List');
        $this->checkSatffSession();

        $userid = $this->request->getSession()->read('Customer.id');
        $this->paginate = [
            'limit' => 25,
            'order' => ['Purchase.id' => 'DESC'],
        ];
        $query = $this->Purchase->find()
            ->contain(['PurchaseRequirements', 'NappUser1', 'NappUser', 'NappUser2'])
            ->where([
                'Purchase.purchase_type' => 0,
                'OR' => [
                    'Purchase.permitted_by' => $userid,
                    'Purchase.prepared_by' => $userid,
                    'Purchase.authorized_by' => $userid,
                ],
            ]);
        $results = $this->paginate($query);
        $purchaseArr = [];
        foreach ($results as $row) {
            $purchaseArr[] = $this->_purchaseToViewArray($row);
        }
        $this->set(compact('purchaseArr'));
    }

    public function adminResourceRequirement()
    {
        return $this->admin_resource_requirement();
    }

    public function admin_resource_requirement()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Resource Requirement List');
        $this->checkAdminSession();

        $this->paginate = ['limit' => 25, 'order' => ['Purchase.id' => 'DESC']];
        $query = $this->Purchase->find()
            ->contain(['PurchaseRequirements', 'NappUser1', 'NappUser', 'NappUser2'])
            ->where(['Purchase.purchase_type' => 1]);
        $results = $this->paginate($query);
        $purchaseArr = [];
        foreach ($results as $row) {
            $purchaseArr[] = $this->_purchaseToViewArray($row);
        }
        $this->set(compact('purchaseArr'));
    }

    public function adminIndex()
    {
        return $this->admin_index();
    }

    public function admin_index()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Purcashes List');
        $this->checkAdminSession();

        $this->paginate = ['limit' => 25, 'order' => ['Purchase.id' => 'DESC']];
        $query = $this->Purchase->find()
            ->contain(['PurchaseRequirements', 'NappUser1', 'NappUser', 'NappUser2'])
            ->where(['Purchase.purchase_type' => 0]);
        $results = $this->paginate($query);
        $purchaseArr = [];
        foreach ($results as $row) {
            $purchaseArr[] = $this->_purchaseToViewArray($row);
        }
        $this->set(compact('purchaseArr'));
    }

    public function resourceProcess($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Approved / Descline Request');
        $this->checkSatffSession();

        $userid = $this->request->getSession()->read('Customer.id');
        $purchase = $this->Purchase->get($id, ['contain' => ['PurchaseRequirements', 'NappUser1', 'NappUser', 'NappUser2']]);
        $PurchaseArr = $this->_purchaseToViewArray($purchase);
        $this->set(compact('PurchaseArr'));

        $data = $this->request->getData();
        if (!empty($data)) {
            $status = (int)($this->request->getData('Purchase.status') ?? 0);
            $entity = $this->Purchase->patchEntity($purchase, $this->request->getData('Purchase'));
            $entity->id = (int)$id;
            if ($status == 1) {
                $entity->purchase_type = 0;
            }
            if ($this->Purchase->save($entity)) {
                if ($status == 0) {
                    $deleteIds = $this->request->getData('status');
                    if (!empty($deleteIds)) {
                        foreach ($deleteIds as $key => $ids) {
                            $req = $this->PurchaseRequirement->get($key);
                            $this->PurchaseRequirement->patchEntity($req, ['quantity' => $this->request->getData('quantity')[$key][0] ?? 0]);
                            $this->PurchaseRequirement->save($req);
                        }
                        $this->PurchaseRequirement->deleteAll(['purchase_id' => $id, 'id NOT IN' => array_keys($deleteIds)]);
                    }
                } else {
                    $deleteIds = $this->request->getData('status');
                    if (!empty($deleteIds)) {
                        foreach ($deleteIds as $key => $ids) {
                            $req = $this->PurchaseRequirement->get($key);
                            $reqArr = $req->toArray();
                            $this->PurchaseRequirement->patchEntity($req, [
                                'item_name' => $reqArr['resource_requirement'] ?? '',
                                'quantity' => $this->request->getData('quantity')[$key][0] ?? 0,
                            ]);
                            $this->PurchaseRequirement->save($req);
                        }
                        $this->PurchaseRequirement->deleteAll(['purchase_id' => $id, 'id NOT IN' => array_keys($deleteIds)]);
                    }
                }
                $this->Flash->success('Request updated successfully.');
                return $this->redirect($status == 1 ? ['action' => 'index'] : ['action' => 'resourceRequirement']);
            }
        }
        $this->request = $this->request->withData('Purchase', $PurchaseArr['Purchase']);
        $employeEntities = $this->NappUser->find()->where(['NappUser.is_staff_id' => 1])->all();
        $employeArr = [];
        foreach ($employeEntities as $e) {
            $employeArr[] = ['NappUser' => $e->toArray()];
        }
        $this->set(compact('employeArr'));
    }

    public function resourceDelete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->checkSatffSession();
        $entity = $this->Purchase->get($id);
        if ($this->Purchase->delete($entity)) {
            $this->Flash->success('Request has been deleted successfully.');
        }
        return $this->redirect(['action' => 'resourceRequirement']);
    }

    public function resourceEdit($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Add Purchase Request');
        $this->checkSatffSession();

        $userid = $this->request->getSession()->read('Customer.id');
        $data = $this->request->getData();
        if (!empty($data)) {
            $purchaseData = $this->request->getData('Purchase') ?? [];
            $purchaseData['prepared_by'] = $userid;
            $purchaseData['id'] = (int)$id;
            $purchaseData['created'] = date('Y-m-d H:i:s');

            $entity = $this->Purchase->get($id);
            $entity = $this->Purchase->patchEntity($entity, $purchaseData);
            if ($this->Purchase->save($entity)) {
                $this->PurchaseRequirement->deleteAll(['purchase_id' => $id]);
                $resourceReqs = $this->request->getData('resource_requirement');
                if (!empty($resourceReqs)) {
                    $i = 0;
                    foreach ($resourceReqs as $rr) {
                        $req = [
                            'purchase_id' => $id,
                            'resource_requirement' => $rr,
                            'purpose_project' => $this->request->getData('purpose_project')[$i] ?? '',
                            'quantity' => $this->request->getData('quantity')[$i] ?? '',
                            'time' => $this->request->getData('time')[$i] ?? '',
                            'budget' => $this->request->getData('budget')[$i] ?? '',
                            'remark' => $this->request->getData('remark')[$i] ?? '',
                        ];
                        $reqEntity = $this->PurchaseRequirement->newEntity($req);
                        $this->PurchaseRequirement->save($reqEntity);
                        $i++;
                    }
                }
                $this->Flash->success('Request has been created successfully.');
                return $this->redirect(['action' => 'resourceRequirement']);
            }
        }
        $employeEntities = $this->NappUser->find()->where(['NappUser.is_staff_id' => 1])->all();
        $employeArr = [];
        foreach ($employeEntities as $e) {
            $employeArr[] = ['NappUser' => $e->toArray()];
        }
        $this->set(compact('employeArr'));
        $purchase = $this->Purchase->get($id, ['contain' => ['PurchaseRequirements']]);
        $PurchaseArr = $this->_purchaseToViewArray($purchase);
        $this->set(compact('PurchaseArr'));
        $this->request = $this->request->withData('Purchase', $PurchaseArr['Purchase']);
    }

    public function resourceAdd()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Add Purchase Request');
        $this->checkSatffSession();

        $userid = $this->request->getSession()->read('Customer.id');
        $name = $this->request->getSession()->read('Customer.name') . ' ' . $this->request->getSession()->read('Customer.lname');
        $sendername = ucfirst($name);

        $data = $this->request->getData();
        if (!empty($data)) {
            $itemDetails = $this->request->getData('Purchase.item_details') ?? '';
            $uniqueId = 'Rev-' . (1000 + (int)$this->Purchase->find()->orderDesc('Purchase.id')->first()->id);
            $purchaseData = $this->request->getData('Purchase') ?? [];
            $purchaseData['unique_id'] = $uniqueId;
            $purchaseData['prepared_by'] = $userid;
            $purchaseData['purchase_type'] = 1;
            $purchaseData['created'] = date('Y-m-d H:i:s');

            $entity = $this->Purchase->newEntity($purchaseData);
            if ($this->Purchase->save($entity)) {
                $purchaseId = $entity->id;
                $resourceReqs = $this->request->getData('resource_requirement');
                if (!empty($resourceReqs)) {
                    $i = 0;
                    foreach ($resourceReqs as $rr) {
                        $req = [
                            'purchase_id' => $purchaseId,
                            'resource_requirement' => $rr,
                            'purpose_project' => $this->request->getData('purpose_project')[$i] ?? '',
                            'quantity' => $this->request->getData('quantity')[$i] ?? '',
                            'time' => $this->request->getData('time')[$i] ?? '',
                            'budget' => $this->request->getData('budget')[$i] ?? '',
                            'remark' => $this->request->getData('remark')[$i] ?? '',
                        ];
                        $reqEntity = $this->PurchaseRequirement->newEntity($req);
                        $this->PurchaseRequirement->save($reqEntity);
                        $i++;
                    }
                }
                $permittedBy = (int)($this->request->getData('Purchase.permitted_by') ?? 0);
                if ($permittedBy > 0) {
                    $employe = $this->NappUser->find()->where(['NappUser.id' => $permittedBy])->first();
                    if ($employe) {
                        $receivername = $employe->get('name') . ' ' . $employe->get('lname');
                        $receiveremail = $employe->get('email');
                        $url = SITEURL . 'purchases/autologin/' . base64_encode((string)$employe->get('id'));
                        $subject = SITENAME . ':- ' . $sendername . ' has made request (' . $uniqueId . ') for resources';
                        $variables = ['unique_id' => $uniqueId, 'sendername' => $sendername, 'receivername' => $receivername, 'url' => $url, 'item_details' => $itemDetails];
                        try {
                            $this->sendemail($receiveremail, $subject, 'sendrequest', $variables);
                        } catch (\Exception $e) {
                        }
                    }
                }
                $this->Flash->success('Resource requirement request has been created successfully.');
                return $this->redirect(['action' => 'resourceRequirement']);
            }
        }
        $employeEntities = $this->NappUser->find()->where(['NappUser.is_staff_id' => 1])->all();
        $employeArr = [];
        foreach ($employeEntities as $e) {
            $employeArr[] = ['NappUser' => $e->toArray()];
        }
        $this->set(compact('employeArr'));
    }

    public function resourceRequirement()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Resource Requirement List');
        $this->checkSatffSession();

        $userid = $this->request->getSession()->read('Customer.id');
        $this->paginate = ['limit' => 25, 'order' => ['Purchase.id' => 'DESC']];
        $query = $this->Purchase->find()
            ->contain(['PurchaseRequirements', 'NappUser1', 'NappUser', 'NappUser2'])
            ->where([
                'Purchase.purchase_type' => 1,
                'OR' => [
                    'Purchase.permitted_by' => $userid,
                    'Purchase.prepared_by' => $userid,
                    'Purchase.authorized_by' => $userid,
                ],
            ]);
        $results = $this->paginate($query);
        $purchaseArr = [];
        foreach ($results as $row) {
            $purchaseArr[] = $this->_purchaseToViewArray($row);
        }
        $this->set(compact('purchaseArr'));
    }

    protected function _purchaseToViewArray($entity): array
    {
        $p = $entity->toArray();
        $defaults = [
            'item_details' => $p['item_details'] ?? '',
            'requisitioner_name' => $p['requisitioner_name'] ?? '',
            'date' => $p['date'] ?? null,
            'name_of_receiver' => $p['name_of_receiver'] ?? '',
        ];
        $out = ['Purchase' => array_merge($defaults, $p)];
        $n1 = $entity->get('napp_user_1') ?? $entity->get('napp_user1') ?? null;
        $n2 = $entity->get('napp_user') ?? null;
        $n3 = $entity->get('napp_user_2') ?? $entity->get('napp_user2') ?? null;
        $out['NappUser_1'] = $n1 ? (is_object($n1) ? $n1->toArray() : (array)$n1) : ['id' => null, 'name' => '', 'lname' => ''];
        $out['NappUser'] = $n2 ? (is_object($n2) ? $n2->toArray() : (array)$n2) : ['id' => null, 'name' => '', 'lname' => ''];
        $out['NappUser_2'] = $n3 ? (is_object($n3) ? $n3->toArray() : (array)$n3) : ['id' => null, 'name' => '', 'lname' => ''];
        $prs = $entity->get('purchase_requirements') ?? [];
        if ($prs) {
            $out['PurchaseRequirement'] = [];
            foreach ($prs as $pr) {
                $out['PurchaseRequirement'][] = is_object($pr) ? $pr->toArray() : (array)$pr;
            }
        }
        return $out;
    }

    protected function _sendCompletionEmails(array $PurchaseArr, string $sendername, string $uniqueId, string $itemDetails, string $subject, string $template): void
    {
        $urlBase = SITEURL . 'purchases/autologin/';
        $vars = ['unique_id' => $uniqueId, 'sendername' => $sendername, 'item_details' => $itemDetails];
        foreach (['NappUser_1', 'NappUser', 'NappUser_2'] as $key) {
            if (!empty($PurchaseArr[$key]['email'])) {
                $vars['receivername'] = ($PurchaseArr[$key]['name'] ?? '') . ' ' . ($PurchaseArr[$key]['lname'] ?? '');
                $vars['url'] = $urlBase . base64_encode((string)$PurchaseArr[$key]['id']);
                try {
                    $this->sendemail($PurchaseArr[$key]['email'], $subject, $template, $vars);
                } catch (\Exception $e) {
                }
            }
        }
    }
}
