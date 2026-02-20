<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Audits Controller (Quality Assurance - Audit)
 * Migrated from CakePHP 2 to CakePHP 3.10
 */
class AuditsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('FormatInternalAuditPlans');
        $this->loadModel('CircularInternalAudits');
        $this->loadModel('CircularInternalAuditLists');
        $this->loadModel('CircularInternalAuditResults');
        $this->loadModel('NappUser');
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        parent::beforeFilter($event);
        $this->callConstants();
        return null;
    }

    /**
     * Convert FormatInternalAuditPlan entity to view array (NappUser, NappUser1 keys)
     */
    protected function _formatInternalAuditPlanToViewArray($entity): array
    {
        $arr = $entity->toArray();
        $out = ['FormatInternalAuditPlan' => $arr];
        $out['NappUser'] = (isset($entity->napp_user) && $entity->napp_user)
            ? $entity->napp_user->toArray()
            : ['id' => null, 'name' => '', 'lname' => ''];
        $out['NappUser1'] = (isset($entity->napp_user1) && $entity->napp_user1)
            ? $entity->napp_user1->toArray()
            : ['id' => null, 'name' => '', 'lname' => ''];
        return $out;
    }

    /**
     * Convert CircularInternalAudit entity to view array
     */
    protected function _circularInternalAuditToViewArray($entity): array
    {
        $arr = $entity->toArray();
        $out = ['CircularInternalAudit' => $arr];
        $out['NappUser'] = (isset($entity->napp_user) && $entity->napp_user)
            ? $entity->napp_user->toArray()
            : ['id' => null, 'name' => '', 'lname' => ''];
        if (isset($entity->circular_internal_audit_lists) && $entity->circular_internal_audit_lists) {
            $out['CircularInternalAuditList'] = [];
            foreach ($entity->circular_internal_audit_lists as $list) {
                $row = $list->toArray();
                $row['NappUser'] = (isset($list->napp_user) && $list->napp_user) ? $list->napp_user->toArray() : ['name' => '', 'lname' => ''];
                $row['NappUser1'] = (isset($list->napp_user1) && $list->napp_user1) ? $list->napp_user1->toArray() : ['name' => '', 'lname' => ''];
                $out['CircularInternalAuditList'][] = $row;
            }
        } else {
            $out['CircularInternalAuditList'] = [];
        }
        return $out;
    }

    // ========== STAFF (PUBLIC) ACTIONS ==========

    public function index()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Format Internal Audit Plan List');
        $this->checkSatffSession();
        $userid = (int)$this->request->getSession()->read('Customer.id');

        $query = $this->FormatInternalAuditPlans->find()
            ->contain(['NappUser', 'NappUser1'])
            ->where([
                'OR' => [
                    'FormatInternalAuditPlans.auditee' => $userid,
                    'FormatInternalAuditPlans.auditor' => $userid,
                    'FormatInternalAuditPlans.user_id' => $userid,
                ]
            ])
            ->orderDesc('FormatInternalAuditPlans.id');
        $results = $this->paginate($query, ['limit' => 25]);
        $FormatInternalAuditPlanArr = [];
        foreach ($results as $row) {
            $FormatInternalAuditPlanArr[] = $this->_formatInternalAuditPlanToViewArray($row);
        }
        $this->set(compact('FormatInternalAuditPlanArr', 'userid'));
    }

    public function add()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Add Internal Audit Plan');
        $this->checkSatffSession();
        $userid = $this->request->getSession()->read('Customer.id');
        $name = $this->request->getSession()->read('Customer.name') . ' ' . $this->request->getSession()->read('Customer.lname');
        $sendername = ucfirst($name);

        $data = $this->request->getData();
        if (!empty($data) && !empty($data['Audit'])) {
            $audit = $data['Audit'];
            $audit['created'] = date('Y-m-d H:i:s');
            $audit['user_id'] = $userid;
            $entity = $this->FormatInternalAuditPlans->newEntity($audit);
            if ($this->FormatInternalAuditPlans->save($entity)) {
                $inserted = $entity->toArray();
                if (!empty($inserted['auditor']) && (int)$inserted['auditor'] > 0) {
                    $audit_number = $inserted['audit_number'] ?? '';
                    $auditee = (int)($inserted['auditee'] ?? 0);
                    $auditor = (int)$inserted['auditor'];
                    $userArr = $this->NappUser->find()->where(['NappUser.id' => $auditor])->first();
                    if ($userArr) {
                        $subject = SITENAME . ' :: Internal Audit Planning Request';
                        $autologinurl = SITEURL . 'audits/autologin/' . base64_encode((string)$userArr->id) . '/audit';
                        $admin_variables = ['autologinurl' => $autologinurl, 'name' => $userArr->name . ' ' . $userArr->lname, 'audit_number' => $audit_number, 'sendername' => $sendername];
                        try {
                            $this->sendemail('web@xoroglobal.com', $subject, 'autditplanning', $admin_variables);
                        } catch (\Exception $e) {
                        }
                    }
                    if ($auditee > 0) {
                        $userArr2 = $this->NappUser->find()->where(['NappUser.id' => $auditee])->first();
                        if ($userArr2) {
                            $subject = SITENAME . ' :: Internal Audit Planning Request';
                            $autologinurl = SITEURL . 'audits/autologin/' . base64_encode((string)$userArr2->id) . '/audit';
                            $admin_variables = ['autologinurl' => $autologinurl, 'name' => $userArr2->name . ' ' . $userArr2->lname, 'audit_number' => $audit_number, 'sendername' => $sendername];
                            try {
                                $this->sendemail('web@xoroglobal.com', $subject, 'autditplanning', $admin_variables);
                            } catch (\Exception $e) {
                            }
                        }
                    }
                }
                $this->Flash->success('Audit Planning request has added successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }

        $last = $this->FormatInternalAuditPlans->find()->orderDesc('FormatInternalAuditPlans.id')->first();
        $auditnumber = $last ? 'AIP-' . (1000 + (int)$last->id + 1) : 'AIP-1000';
        $userArr = $this->NappUser->find('all')->where(['NappUser.is_staff_id' => 1, 'NappUser.is_active' => 1])->toArray();
        $userArrFormatted = [];
        foreach ($userArr as $u) {
            $userArrFormatted[] = ['NappUser' => $u->toArray()];
        }
        $this->set(compact('auditnumber', 'userArr'));
        $this->set('userArr', $userArrFormatted);
    }

    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Edit Internal Audit Plan');
        $this->checkSatffSession();
        $userid = $this->request->getSession()->read('Customer.id');
        $name = $this->request->getSession()->read('Customer.name') . ' ' . $this->request->getSession()->read('Customer.lname');
        $sendername = ucfirst($name);

        $data = $this->request->getData();
        if (!empty($data['Audit']) && $id) {
            $audit = $data['Audit'];
            $audit['created'] = date('Y-m-d H:i:s');
            $audit['user_id'] = $userid;
            $audit['id'] = (int)$id;
            if (isset($audit['status']) && (int)$audit['status'] === 3) {
                $audit['sign_of_mr'] = $sendername;
            }
            $entity = $this->FormatInternalAuditPlans->get($id);
            $entity = $this->FormatInternalAuditPlans->patchEntity($entity, $audit);
            if ($this->FormatInternalAuditPlans->save($entity)) {
                $inserted = $entity->toArray();
                if (!empty($inserted['status']) && (int)$inserted['status'] === 3 && !empty($inserted['auditor'])) {
                    $audit_number = $inserted['audit_number'] ?? '';
                    $auditor = (int)$inserted['auditor'];
                    $auditee = (int)($inserted['auditee'] ?? 0);
                    foreach ([$auditor, $auditee] as $uid) {
                        if ($uid <= 0) continue;
                        $userArr = $this->NappUser->get($uid);
                        $subject = SITENAME . ' :: Internal Audit Planning Request Completed';
                        $autologinurl = SITEURL . 'audits/autologin/' . base64_encode((string)$userArr->id) . '/audit';
                        $admin_variables = ['autologinurl' => $autologinurl, 'name' => $userArr->name . ' ' . $userArr->lname, 'audit_number' => $audit_number, 'sendername' => $sendername];
                        try {
                            $this->sendemail('web@xoroglobal.com', $subject, 'autditplanning', $admin_variables);
                        } catch (\Exception $e) {
                        }
                    }
                }
                $this->Flash->success('Audit planning request has been updated successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }

        $InternalAuditPlanEntity = $this->FormatInternalAuditPlans->find()->where(['FormatInternalAuditPlans.id' => $id])->first();
        $InternalAuditPlan = $InternalAuditPlanEntity ? ['FormatInternalAuditPlan' => $InternalAuditPlanEntity->toArray()] : ['FormatInternalAuditPlan' => []];
        $userArr = $this->NappUser->find('all')->where(['NappUser.is_staff_id' => 1, 'NappUser.is_active' => 1])->toArray();
        $userArrFormatted = [];
        foreach ($userArr as $u) {
            $userArrFormatted[] = ['NappUser' => $u->toArray()];
        }
        $this->set(compact('InternalAuditPlan', 'userArr'));
        $this->set('userArr', $userArrFormatted);
        $this->request = $this->request->withData('Audit', $InternalAuditPlan['FormatInternalAuditPlan'] ?? []);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->checkSatffSession();
        $entity = $this->FormatInternalAuditPlans->get($id);
        if ($this->FormatInternalAuditPlans->delete($entity)) {
            $this->Flash->success('Request has been deleted successfully.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function autologin($id = null)
    {
        $this->autoRender = false;
        if (!empty($id)) {
            $uid = base64_decode($id);
            $userArr = $this->NappUser->find()->where(['NappUser.id' => $uid, 'NappUser.is_staff_id' => 1])->first();
            if ($userArr) {
                if ((int)$userArr->get('is_active') === 0) {
                    $this->Flash->error('You account is not active');
                    return $this->redirect('/login');
                }
                $this->request->getSession()->write('Customer', $userArr->toArray());
                $this->request->getSession()->write('is_customer', 1);
                return $this->redirect('/audits');
            }
        }
        return $this->redirect('/login');
    }

    public function circularinternalauditadd()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Circular Internal Audit List');
        $this->checkSatffSession();

        $data = $this->request->getData();
        if (!empty($data['CircularInternalAudit'])) {
            $data['CircularInternalAudit']['created'] = date('Y-m-d H:i:s');
            $entity = $this->CircularInternalAudits->newEntity($data['CircularInternalAudit']);
            if ($this->CircularInternalAudits->save($entity)) {
                $this->Flash->success('Audit Planning request has added successfully.');
                return $this->redirect(['action' => 'circularinternalauditlist']);
            }
        }

        $last = $this->CircularInternalAudits->find()->orderDesc('CircularInternalAudits.id')->first();
        $auditnumber = $last ? 'AIP-' . (1000 + (int)$last->id + 1) : 'AIP-1000';
        $userArr = $this->NappUser->find('all')->where(['NappUser.is_staff_id' => 1, 'NappUser.is_active' => 1])->toArray();
        $userArrFormatted = [];
        foreach ($userArr as $u) {
            $userArrFormatted[] = ['NappUser' => $u->toArray()];
        }
        $this->set(compact('auditnumber', 'userArr'));
        $this->set('userArr', $userArrFormatted);
    }

    public function circularinternalauditedit($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Circular Internal Audit List');
        $this->checkSatffSession();
        $userid = $this->request->getSession()->read('Customer.id');

        $data = $this->request->getData();
        if (!empty($data['CircularInternalAudit']) && $id) {
            $data['CircularInternalAudit']['id'] = (int)$id;
            $entity = $this->CircularInternalAudits->get($id);
            $entity = $this->CircularInternalAudits->patchEntity($entity, $data['CircularInternalAudit']);
            if ($this->CircularInternalAudits->save($entity)) {
                $this->Flash->success('Audit Planning request has added successfully.');
                return $this->redirect(['action' => 'circularinternalauditlist']);
            }
        }

        $InternalAuditPlanEntity = $this->CircularInternalAudits->get($id);
        $InternalAuditPlan = ['CircularInternalAudit' => $InternalAuditPlanEntity->toArray()];
        $userArr = $this->NappUser->find('all')->where(['NappUser.is_staff_id' => 1, 'NappUser.is_active' => 1])->toArray();
        $userArrFormatted = [];
        foreach ($userArr as $u) {
            $userArrFormatted[] = ['NappUser' => $u->toArray()];
        }
        $this->set(compact('InternalAuditPlan', 'userid', 'userArr'));
        $this->set('userArr', $userArrFormatted);
        $this->request = $this->request->withData('CircularInternalAudit', $InternalAuditPlan['CircularInternalAudit']);
    }

    public function circularinternalauditresult($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Circular Internal Audit List');
        $this->checkSatffSession();
        $userid = $this->request->getSession()->read('Customer.id');

        $data = $this->request->getData();
        if (!empty($data)) {
            if (!empty($data['date'])) {
                $this->CircularInternalAuditResults->deleteAll(['audit_id' => $id]);
                foreach ($data['date'] as $key => $datetime) {
                    $row = [
                        'audit_id' => $id,
                        'department' => $key,
                        'date' => $datetime['datetime'] ?? null,
                        'time' => $datetime['time'] ?? null,
                        'auditor' => $datetime['auditor'] ?? null,
                        'auditee' => $datetime['auditee'] ?? null,
                        'created' => date('Y-m-d H:i:s'),
                    ];
                    $ent = $this->CircularInternalAuditResults->newEntity($row);
                    $this->CircularInternalAuditResults->save($ent);
                }
            }
            if (!empty($data['CircularInternalAudit'])) {
                $entity = $this->CircularInternalAudits->get($id);
                $entity = $this->CircularInternalAudits->patchEntity($entity, [
                    'opening_held_on' => $data['CircularInternalAudit']['opening_held_on'] ?? null,
                    'opening_place_at' => $data['CircularInternalAudit']['opening_place_at'] ?? null,
                    'closing_held_on' => $data['CircularInternalAudit']['closing_held_on'] ?? null,
                    'closing_place_at' => $data['CircularInternalAudit']['closing_place_at'] ?? null,
                ]);
                $this->CircularInternalAudits->save($entity);
            }
        }

        $userArr = $this->NappUser->find('all')->where(['NappUser.is_staff_id' => 1, 'NappUser.is_active' => 1])->toArray();
        $userArrFormatted = [];
        foreach ($userArr as $u) {
            $userArrFormatted[] = ['NappUser' => $u->toArray()];
        }
        $this->set('userArr', $userArrFormatted);
        $CircularInternalAuditResultSet = $this->CircularInternalAuditResults->find()->where(['CircularInternalAuditResults.audit_id' => $id])->all();
        $CircularInternalAuditResultFormatted = [];
        foreach ($CircularInternalAuditResultSet as $r) {
            $CircularInternalAuditResultFormatted[] = ['CircularInternalAuditResult' => $r->toArray()];
        }
        $this->set('CircularInternalAuditResult', $CircularInternalAuditResultFormatted);
        $InternalAuditPlanEntity = $this->CircularInternalAudits->find()->where(['CircularInternalAudits.id' => $id])->first();
        $InternalAuditPlan = $InternalAuditPlanEntity ? ['CircularInternalAudit' => $InternalAuditPlanEntity->toArray()] : ['CircularInternalAudit' => []];
        $this->set(compact('InternalAuditPlan', 'userid'));
    }

    public function circularinternalauditlist()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Circular Internal Audit List');
        $this->checkSatffSession();
        $userid = $this->request->getSession()->read('Customer.id');

        $query = $this->CircularInternalAudits->find()
            ->contain([
                'NappUser',
                'CircularInternalAuditLists' => ['NappUser', 'NappUser1']
            ])
            ->orderDesc('CircularInternalAudits.id');
        $results = $this->paginate($query, ['limit' => 25]);
        $CircularInternalAuditArr = [];
        foreach ($results as $row) {
            $CircularInternalAuditArr[] = $this->_circularInternalAuditToViewArray($row);
        }
        $this->set(compact('CircularInternalAuditArr', 'userid'));
    }

    // ========== ADMIN ACTIONS ==========

    /** CamelCase wrapper for routing */
    public function adminIndex()
    {
        return $this->admin_index();
    }

    public function admin_index()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Format Internal Audit Plan List');
        $this->checkAdminSession();

        $query = $this->FormatInternalAuditPlans->find()
            ->contain(['NappUser', 'NappUser1'])
            ->orderDesc('FormatInternalAuditPlans.id');
        $results = $this->paginate($query, ['limit' => 25]);
        $FormatInternalAuditPlanArr = [];
        foreach ($results as $row) {
            $FormatInternalAuditPlanArr[] = $this->_formatInternalAuditPlanToViewArray($row);
        }
        $this->set(compact('FormatInternalAuditPlanArr'));
    }

    /** CamelCase wrapper for routing */
    public function adminCircularinternalauditlist()
    {
        return $this->admin_circularinternalauditlist();
    }

    public function admin_circularinternalauditlist()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Circular Internal Audit List');
        $this->checkAdminSession();

        $query = $this->CircularInternalAudits->find()
            ->contain([
                'NappUser',
                'CircularInternalAuditLists' => ['NappUser', 'NappUser1']
            ])
            ->orderDesc('CircularInternalAudits.id');
        $results = $this->paginate($query, ['limit' => 25]);
        $CircularInternalAuditArr = [];
        foreach ($results as $row) {
            $CircularInternalAuditArr[] = $this->_circularInternalAuditToViewArray($row);
        }
        $this->set(compact('CircularInternalAuditArr'));
    }

    /** CamelCase wrapper for routing */
    public function adminCircularinternalauditresult($id = null)
    {
        return $this->admin_circularinternalauditresult($id);
    }

    public function admin_circularinternalauditresult($id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Circular Internal Audit List');
        $this->checkAdminSession();

        $data = $this->request->getData();
        if (!empty($data)) {
            if (!empty($data['date'])) {
                $this->CircularInternalAuditResults->deleteAll(['audit_id' => $id]);
                foreach ($data['date'] as $key => $datetime) {
                    $row = [
                        'audit_id' => $id,
                        'department' => $key,
                        'date' => $datetime['datetime'] ?? null,
                        'time' => $datetime['time'] ?? null,
                        'auditor' => $datetime['auditor'] ?? null,
                        'auditee' => $datetime['auditee'] ?? null,
                        'created' => date('Y-m-d H:i:s'),
                    ];
                    $ent = $this->CircularInternalAuditResults->newEntity($row);
                    $this->CircularInternalAuditResults->save($ent);
                }
            }
            if (!empty($data['CircularInternalAudit'])) {
                $entity = $this->CircularInternalAudits->get($id);
                $entity = $this->CircularInternalAudits->patchEntity($entity, [
                    'opening_held_on' => $data['CircularInternalAudit']['opening_held_on'] ?? null,
                    'opening_place_at' => $data['CircularInternalAudit']['opening_place_at'] ?? null,
                    'closing_held_on' => $data['CircularInternalAudit']['closing_held_on'] ?? null,
                    'closing_place_at' => $data['CircularInternalAudit']['closing_place_at'] ?? null,
                ]);
                $this->CircularInternalAudits->save($entity);
            }
        }

        $userArr = $this->NappUser->find('all')->where(['NappUser.is_staff_id' => 1, 'NappUser.is_active' => 1])->toArray();
        $userArrFormatted = [];
        foreach ($userArr as $u) {
            $userArrFormatted[] = ['NappUser' => $u->toArray()];
        }
        $this->set('userArr', $userArrFormatted);
        $CircularInternalAuditResult = $this->CircularInternalAuditResults->find()->where(['CircularInternalAuditResults.audit_id' => $id])->all();
        $CircularInternalAuditResultFormatted = [];
        foreach ($CircularInternalAuditResult as $r) {
            $CircularInternalAuditResultFormatted[] = ['CircularInternalAuditResult' => $r->toArray()];
        }
        $this->set('CircularInternalAuditResult', $CircularInternalAuditResultFormatted);
        $InternalAuditPlanEntity = $this->CircularInternalAudits->find()->where(['CircularInternalAudits.id' => $id])->first();
        $InternalAuditPlan = $InternalAuditPlanEntity ? ['CircularInternalAudit' => $InternalAuditPlanEntity->toArray()] : ['CircularInternalAudit' => []];
        $this->set(compact('InternalAuditPlan'));
    }
}
