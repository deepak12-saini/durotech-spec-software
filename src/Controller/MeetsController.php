<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Meets Controller (CakePHP 3.10)
 * Minute meetings, informal meetings, staff in/out.
 */
class MeetsController extends AppController
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
        $this->loadModel('MintueMeets');
        $this->loadModel('MintueAgends');
        $this->loadModel('MintueAgendDetails');
        $this->loadModel('StaffTimes');
        $this->loadModel('NappUser');
        $this->loadModel('UserPermission');
    }

    public function newtemplate(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Mintue Meeting');
        $res = $this->checkSatffSession();
        if ($res instanceof Response) {
            return $res;
        }
        return null;
    }

    public function meetingform(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Informal Meeting List');
        $res = $this->checkSatffSession();
        if ($res instanceof Response) {
            return $res;
        }
        $customer_id = $this->request->getSession()->read('Customer.id');
        $query = $this->MintueMeets->find()
            ->where(['MintueMeets.user_id' => $customer_id]);
        $results = $query->all();
        $list = [];
        foreach ($results as $entity) {
            $list[] = ['MintueMeet' => $entity->toArray()];
        }
        $this->set('MintueMeetAll', $list);
        return null;
    }

    public function view($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Informal Meeting List');
        $res = $this->checkSatffSession();
        if ($res instanceof Response) {
            return $res;
        }
        $customer_id = $this->request->getSession()->read('Customer.id');
        $entity = $this->MintueMeets->find()
            ->contain(['MintueAgends', 'MintueAgendDetails'])
            ->where(['MintueMeets.user_id' => $customer_id, 'MintueMeets.id' => $id])
            ->first();
        if (!$entity) {
            $this->Flash->error('Record not found.');
            return $this->redirect(['action' => 'meetingform']);
        }
        $MintueMeetAll = [
            'MintueMeet' => $entity->toArray(),
            'MintueAgend' => $entity->mintue_agends ? array_map(function ($a) { return $a->toArray(); }, $entity->mintue_agends instanceof \Cake\ORM\ResultSet ? iterator_to_array($entity->mintue_agends) : (array)$entity->mintue_agends) : [],
            'MintueAgendDetail' => $entity->mintue_agend_details ? array_map(function ($a) { return $a->toArray(); }, $entity->mintue_agend_details instanceof \Cake\ORM\ResultSet ? iterator_to_array($entity->mintue_agend_details) : (array)$entity->mintue_agend_details) : [],
        ];
        $this->set('MintueMeetAll', $MintueMeetAll);
        return null;
    }

    public function informalmeeting(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Informal Meeting');
        $res = $this->checkSatffSession();
        if ($res instanceof Response) {
            return $res;
        }
        $customer_id = $this->request->getSession()->read('Customer.id');
        $session = $this->request->getSession();
        if ($this->request->is('post') && $this->request->getData()) {
            $data = $this->request->getData();
            $meetEntity = $this->MintueMeets->newEntity([
                'user_id' => $customer_id,
                'referid' => $data['referid'] ?? '',
                'date' => $data['date'] ?? null,
                'time' => $data['time'] ?? null,
                'meeting_created_by' => $data['meeting_created_by'] ?? null,
                'minute_taker' => $data['minute_taker'] ?? null,
                'time_keeper' => $data['time_keeper'] ?? null,
                'please_read' => $data['please_read'] ?? null,
                'note' => $data['note'] ?? null,
                'signature' => $data['signature'] ?? null,
                'attendees_present' => is_array($data['attendees_present'] ?? null) ? implode(',', $data['attendees_present']) : (string)($data['attendees_present'] ?? ''),
            ]);
            if ($this->MintueMeets->save($meetEntity)) {
                $meet_id = $meetEntity->id;
                $agendEntity = $this->MintueAgends->newEntity([
                    'agenda_topic' => $data['agenda_topic'] ?? null,
                    'time_allocate' => $data['time_allocate'] ?? null,
                    'presented_by' => $data['presented_by'] ?? null,
                    'discussion' => $data['discussion'] ?? null,
                    'conclusion' => $data['conclusion'] ?? null,
                    'meet_id' => $meet_id,
                ]);
                $this->MintueAgends->save($agendEntity);
                $agenda_id = $agendEntity->id;
                $actions = $data['action'] ?? [];
                $actionBy = $data['action_to_be_taken_by'] ?? [];
                $actionDate = $data['date_to_be_actioned_by'] ?? [];
                if (!empty($actions) && is_array($actions)) {
                    foreach ($actions as $i => $action) {
                        if (isset($action) && $action !== '') {
                            $detailEntity = $this->MintueAgendDetails->newEntity([
                                'meet_id' => $meet_id,
                                'agenda_id' => $agenda_id,
                                'action' => $action,
                                'action_to_be_taken_by' => $actionBy[$i] ?? null,
                                'date_to_be_actioned_by' => !empty($actionDate[$i]) ? $actionDate[$i] : date('Y-m-d'),
                            ]);
                            $this->MintueAgendDetails->save($detailEntity);
                        }
                    }
                }
                $pdfUrl = (defined('SITEURL') ? SITEURL : '') . 'pdf/FPDI/mintuemeeting.php?lastinsertId=' . $meet_id;
                @file_get_contents($pdfUrl);
            }
            $session->delete('start');
            $this->Flash->success('Saved successfully.');
            return $this->redirect(['action' => 'meetingform']);
        }
        $count = $this->MintueMeets->find()->count();
        $id = $count + 1;
        $code = strlen((string)$id) === 1 ? '00' . $id : (strlen((string)$id) === 2 ? '0' . $id : (string)$id);
        $this->set('refernce', 'IMMT-' . $code);
        $start = $session->read('start');
        if (empty($start)) {
            $start = date('Y-m-d H:i:s');
            $session->write('start', $start);
        }
        return null;
    }

    public function sendpdf($referid = null): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Staff In/Out');
        $res = $this->checkSatffSession();
        if ($res instanceof Response) {
            return $res;
        }
        $entity = $this->MintueMeets->find()->where(['MintueMeets.referid' => $referid])->first();
        $MintueMeet = $entity ? ['MintueMeet' => $entity->toArray()] : [];
        if ($this->request->is('post') && $this->request->getData()) {
            $emailStr = $this->request->getData('email');
            $emails = $emailStr ? array_map('trim', explode(',', $emailStr)) : [];
            foreach ($emails as $to) {
                if ($to && $entity) {
                    $variables = [
                        'referid' => $entity->referid,
                        'date' => $entity->date,
                        'time' => $entity->time,
                        'meeting_created_by' => $entity->meeting_created_by,
                        'minute_taker' => $entity->minute_taker,
                        'facilitator' => $entity->get('facilitator'),
                        'time_keeper' => $entity->time_keeper,
                        'pdffile' => $entity->get('pdffile'),
                        'email' => $to,
                    ];
                    $subject = (defined('SITENAME') ? SITENAME : '') . ' Informal Meeting Report #' . $entity->referid;
                    $this->sendemail($to, $subject, 'mintuemeetingreport', $variables);
                }
            }
            $this->Flash->success('Mail sent successfully.');
            return $this->redirect(['action' => 'meetingform']);
        }
        $this->set('MintueMeet', $MintueMeet);
        return null;
    }

    public function staffinoutlist(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Staff In/Out');
        $res = $this->checkSatffSession();
        if ($res instanceof Response) {
            return $res;
        }
        $customer_id = $this->request->getSession()->read('Customer.id');
        $email = $this->request->getSession()->read('Customer.email');
        $isopen = 0;
        if ($email === 'kal@durotechindustries.com.au' || $email === 'web@xoroglobal.com') {
            $query = $this->StaffTimes->find()->orderDesc('StaffTimes.id');
            $isopen = 1;
        } else {
            $query = $this->StaffTimes->find()->where(['StaffTimes.user_id' => $customer_id])->orderDesc('StaffTimes.id');
        }
        $list = [];
        foreach ($query->all() as $e) {
            $list[] = ['StaffTime' => $e->toArray()];
        }
        $this->set('StaffTime', $list);
        $this->set('isopen', $isopen);
        return null;
    }

    public function sendurl(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Staff In/Out');
        $res = $this->checkSatffSession();
        if ($res instanceof Response) {
            return $res;
        }
        if ($this->request->is('post') && $this->request->getData()) {
            $data = $this->request->getData();
            $last = $this->StaffTimes->find()->orderDesc('StaffTimes.id')->first();
            $referid = $last ? $last->id + 1 : 1;
            $code = strlen((string)$referid) === 1 ? '00' . $referid : (strlen((string)$referid) === 2 ? '0' . $referid : (string)$referid);
            $unique_id = time();
            $email = $data['email'] ?? '';
            $phone = $data['phone'] ?? '';
            $napp = $this->NappUser->find()->where(['NappUser.email' => $email])->first();
            if ($napp) {
                $user_id = $napp->id;
            } else {
                $empid = 'DT-' . rand(0, 999999);
                $password = $data['NappUser']['password'] ?? '';
                $autopassword = md5($password);
                $insert = [
                    'insert_date' => date('Y-m-d H:i:s'),
                    'emp_id' => $empid,
                    'password' => $autopassword,
                    'address_5' => $password,
                    'designation' => 'Worker',
                    'name' => explode('@', $email)[0] ?? '',
                    'mobile_number' => $phone,
                    'is_staff_id' => 1,
                    'is_approved' => 1,
                    'is_active' => 1,
                    'country' => 'Australia',
                ];
                $newUser = $this->NappUser->newEntity($insert);
                $this->NappUser->save($newUser);
                $user_id = $newUser->id;
                $perm = $this->UserPermission->newEntity(['user_id' => $user_id, 'permssion_id' => 30, 'meta_val' => 'staff-in-out']);
                $this->UserPermission->save($perm);
                $this->sendemail($email, (defined('SITENAME') ? SITENAME : '') . ' Welcome To Durotech', 'welcomemail', ['password' => $password, 'name' => explode('@', $email)[0] ?? '', 'email' => $email]);
            }
            $url = (defined('SITEURL') ? SITEURL : '') . 'meets/autologin/' . $unique_id . '/' . base64_encode(base64_encode(base64_encode((string)$user_id)));
            $staffEntity = $this->StaffTimes->newEntity([
                'user_id' => $user_id,
                'email' => $email,
                'unique_id' => (string)$unique_id,
                'referid' => 'DRSIO-' . $code,
            ]);
            if ($phone) {
                $staffEntity->phone = $phone;
                if (isset($this->Twilio) && is_object($this->Twilio) && method_exists($this->Twilio, 'sendsms')) {
                    $this->Twilio->AccountSid = defined('TSID') ? TSID : '';
                    $this->Twilio->AccountToken = defined('TOKEN') ? TOKEN : '';
                    $this->Twilio->sendsms('+' . str_replace('+', '', $phone), defined('FROM_NUMBER') ? FROM_NUMBER : '', 'Hello dear, Please click the link and start new job ' . $url);
                }
            }
            $this->StaffTimes->save($staffEntity);
            $this->sendemail($email, (defined('SITENAME') ? SITENAME : '') . ' Start New Job', 'joblink', ['url' => $url]);
            $this->Flash->success('Job link send successfully.');
            return $this->redirect(['action' => 'staffinoutlist']);
        }
        return null;
    }

    public function autologin($unique_id = null, $user_id = null): ?Response
    {
        $this->viewBuilder()->setLayout(false);
        $user_id = $user_id ? base64_decode(base64_decode(base64_decode($user_id))) : null;
        $cus = $this->NappUser->find()->where(['id' => $user_id])->first();
        if ($cus) {
            $this->request->getSession()->write('Customer', $cus->toArray());
            $this->request->getSession()->write('is_staff', 1);
            return $this->redirect((defined('SITEURL') ? SITEURL : '') . 'meets/staffinout/' . $unique_id);
        }
        $this->Flash->error('Sorry, Authentication failed.');
        return $this->redirect('/login');
    }

    public function noexist($referid = null): ?Response
    {
        $this->viewBuilder()->setLayout('visitor_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Staff In/Out');
        $this->set('referid', $referid);
        return null;
    }

    public function staffinout($referid = null): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Staff In/Out');
        $res = $this->checkSatffSession();
        if ($res instanceof Response) {
            return $res;
        }
        $customer_id = $this->request->getSession()->read('Customer.id');
        $staff = $this->StaffTimes->find()->where(['StaffTimes.unique_id' => $referid])->orderDesc('StaffTimes.id')->first();
        if (!$staff) {
            return $this->redirect(['action' => 'noexist', $referid]);
        }
        $this->set('StaffTime', $staff ? ['StaffTime' => $staff->toArray()] : []);
        $this->set('referid', $referid);
        if ($this->request->is('post') && $this->request->getData()) {
            $data = $this->request->getData();
            $staff = $this->StaffTimes->patchEntity($staff, [
                'name' => $data['name'] ?? null,
                'phone' => $data['phone'] ?? null,
                'summary' => $data['summary'] ?? null,
                'end_time' => date('h:i A'),
                'enddate' => date('Y-m-d H:i:s'),
                'work_status' => 'Finished',
            ]);
            if ($this->StaffTimes->save($staff)) {
                $email = 'kal@durotechindustries.com.au';
                $this->sendemail($email, (defined('SITENAME') ? SITENAME : '') . ' Staff Job #' . $staff->referid . ' Finished', 'staff_in_out', [
                    'to_name' => 'Kal',
                    'referid' => $staff->referid,
                    'name' => $data['name'] ?? '',
                    'work_status' => 'Finished',
                    'phone' => $data['phone'] ?? '',
                    'email' => $staff->email,
                    'summary' => $data['summary'] ?? '',
                ]);
                $this->Flash->success(($data['work_status'] ?? '') === 'Started' ? 'Job Started successfully.' : 'Job Finished successfully.');
                return $this->redirect(['action' => 'staffinout', $referid]);
            }
        }
        return null;
    }

    public function starttime($id = null, $name = null, $phone = null): ?Response
    {
        $this->viewBuilder()->setLayout(false);
        $res = $this->checkSatffSession();
        if ($res instanceof Response) {
            return $res;
        }
        $entity = $this->StaffTimes->get($id);
        $entity = $this->StaffTimes->patchEntity($entity, [
            'name' => $name,
            'phone' => $phone,
            'start_time' => date('h:i A'),
            'created' => date('Y-m-d H:i:s'),
            'startdate' => date('Y-m-d H:i:s'),
        ]);
        $this->StaffTimes->save($entity);
        $this->response = $this->response->withStringBody(date('h:i A'));
        return $this->response;
    }
}
