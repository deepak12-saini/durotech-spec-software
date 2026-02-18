<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Sales Controller (CakePHP 3.10) – sales staff, attendance, dashboard, reports
 */
class SalesController extends AppController
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
        $this->loadModel('SaleReps');
        $this->loadModel('SaleQuestions');
        $this->loadModel('NappUser');
        $this->loadModel('UserPermission');
        $this->loadModel('Departments');
        $this->loadModel('SaleReminders');
        $this->loadModel('Attendances');
        $this->loadModel('SaleReports');
        $this->loadModel('Logs');
        $this->loadModel('User');
    }

    public function adminAttendanceReport($staff_id = null) { return $this->admin_attendance_report($staff_id); }
    public function adminAttendance() { return $this->admin_attendance(); }
    public function adminIndex() { return $this->admin_index(); }
    public function adminSaledasboard() { return $this->admin_saledasboard(); }
    public function adminReport($staff_id = null) { return $this->admin_report($staff_id); }
    public function adminSettarget($staff_id = null) { return $this->admin_settarget($staff_id); }
    public function adminSalereminder($staff_id = null) { return $this->admin_salereminder($staff_id); }
    public function adminSalesreport($unique_id = null) { return $this->admin_salesreport($unique_id); }

    public function admin_attendance_report($staff_id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Attendance Page');
        $this->checkAdminSession();
        $data = $this->request->getData();
        if (!empty($data['start']) && !empty($data['end'])) {
            $start = date('Y-m-d', strtotime($data['start']));
            $end = date('Y-m-d', strtotime($data['end']));
        } else {
            $start = date('Y-m-d', strtotime('-30 days'));
            $end = date('Y-m-d');
        }
        $napuser = $this->NappUser->get($staff_id);
        $in_time = $napuser->in_time ?? '09:00:00';
        // Convert to string if it's a Time object
        if (is_object($in_time)) {
            $in_time = $in_time->format('H:i:s');
        } elseif (is_null($in_time)) {
            $in_time = '09:00:00';
        }
        $exp = explode(':', (string)$in_time);
        $exph = (int)($exp[0] ?? 9);
        $setdtime = $exph + 0.01;
        $conn = $this->Attendances->getConnection();
        $stmt = $conn->execute(
            "SELECT * FROM attendances WHERE staff_id = :sid AND (DATE(created) >= :start AND DATE(created) <= :end)",
            ['sid' => $staff_id, 'start' => $start, 'end' => $end]
        );
        $attendance = $stmt->fetchAll('assoc');
        $attend = [];
        foreach ($attendance as $row) {
            $dst = date('Y-m-d', strtotime($row['created'] ?? 'now'));
            $i = (int)date('i', strtotime($row['created'] ?? 'now'));
            $h = (int)date('H', strtotime($row['created'] ?? 'now'));
            $dtime = $h + min(59, $i) / 60.0;
            $attend[$dst] = ['date' => $dst, 'time' => $dtime];
        }
        $datediff = strtotime($end) - strtotime($start);
        $day = (int)round($datediff / (60 * 60 * 24));
        $absent = $late = $present = 0;
        $datearr = [];
        for ($i = 0; $i <= $day; $i++) {
            $dt = date('Y-m-d', strtotime($start . ' +' . $i . ' days'));
            $final = ['name' => date('d M Y', strtotime($start . ' +' . $i . ' days')), 'y' => 0.0];
            if (isset($attend[$dt]['date']) && $attend[$dt]['date'] === $dt) {
                $final['y'] = $attend[$dt]['time'];
                if ($setdtime <= $attend[$dt]['time']) {
                    $late++;
                } else {
                    $present++;
                }
            } else {
                $absent++;
            }
            $datearr[] = $final;
        }
        // Convert entity to array format for backward compatibility with view
        $napuser = ['NappUser' => $napuser->toArray()];
        $this->set(compact('start', 'end', 'attendance', 'datearr', 'absent', 'late', 'present', 'napuser'));
    }

    public function admin_attendance()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Staff Attendance');
        $this->checkAdminSession();
        $date = $this->request->getData('date') ?: date('Y-m-d');
        $this->paginate = ['limit' => 25, 'conditions' => ['DATE(Attendances.created)' => $date]];
        $AttendanceArr = $this->paginate($this->Attendances->find()->contain(['NappUser']));
        $this->set(compact('AttendanceArr', 'date'));
    }

    public function admin_index()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Sale Customer List');
        $this->checkAdminSession();
        $userper = $this->UserPermission->find('list', ['valueField' => 'user_id'])->where(['UserPermission.meta_val' => 'sr'])->toArray();
        $userIds = array_values($userper);
        $this->paginate = ['limit' => 25];
        $query = $this->NappUser->find()->contain(['Departments'])->where(['NappUser.is_staff_id' => 1, 'NappUser.id IN' => $userIds ?: [0]]);
        $staffArr = $this->paginate($query);
        $this->set('staff', $staffArr);
    }

    public function admin_saledasboard()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Sale Dashboard');
        $this->checkAdminSession();
        $userper = $this->UserPermission->find('list', ['valueField' => 'user_id'])->where(['UserPermission.meta_val' => 'sr'])->toArray();
        $userper = array_values($userper);
        $Loguserper = $this->Logs->find()->select(['user_id'])->distinct(['user_id'])->all();
        $logUserIds = [];
        foreach ($Loguserper as $r) {
            $logUserIds[] = $r->user_id;
        }
        $userids = array_unique(array_merge($userper, $logUserIds));
        $napuser = $userids ? $this->NappUser->find('all')->where(['NappUser.id IN' => $userids])->all() : [];
        $this->set('napuser', $napuser);
        $data = $this->request->getData();
        if (!empty($data['startdate']) && !empty($data['enddate'])) {
            $startdate = date('Y-m-d', strtotime($data['startdate']));
            $enddate = date('Y-m-d', strtotime($data['enddate']));
        } else {
            $startdate = date('Y-m-d', strtotime('-7 days'));
            $enddate = date('Y-m-d');
        }
        $SaleRepArr = $this->SaleReps->find('all')->where(function ($exp, $q) use ($startdate, $enddate) {
            return $exp->between('DATE(SaleReps.created)', $startdate, $enddate, 'date');
        })->contain(['SaleQuestions', 'NappUser'])->all();
        $LogsArr = $this->Logs->find('all')->where(function ($exp, $q) use ($startdate, $enddate) {
            return $exp->between('DATE(Logs.created)', $startdate, $enddate, 'date');
        })->all();
        $startdates = date('Y-m-d', strtotime('-8 days'));
        $enddates = date('Y-m-d');
        $d = (int)(new \DateTime($enddates))->diff(new \DateTime($startdates))->days;
        $finaldata = [];
        foreach ($napuser as $napusers) {
            $nu = is_object($napusers) ? $napusers : (object)$napusers;
            $nid = $nu->id ?? $napusers['NappUser']['id'] ?? 0;
            $dataItem = ['name' => $nu->name ?? $napusers['NappUser']['name'] ?? '', 'data' => []];
            for ($i = 0; $i < $d; $i++) {
                $startdatenew = date('Y-m-d', strtotime($startdates . ' +' . $i . ' days'));
                $totalsalesrep = $this->SaleReps->find()->where(['DATE(SaleReps.created)' => $startdatenew, 'SaleReps.staff_id' => $nid])->count();
                $totallogs = $this->Logs->find()->where(['DATE(Logs.created)' => $startdatenew, 'Logs.user_id' => $nid])->count();
                $dataItem['data'][] = $totalsalesrep + $totallogs;
            }
            $finaldata[] = $dataItem;
        }
        $finaldate = [];
        for ($k = 0; $k < $d; $k++) {
            $finaldate[] = date('d-M', strtotime($startdates . ' +' . $k . ' days'));
        }
        $slatestype = $this->SaleQuestions->find('all')->all();
        $slaetype = '';
        $this->set(compact('slatestype', 'SaleRepArr', 'startdate', 'enddate', 'slaetype', 'finaldata', 'd', 'finaldate', 'LogsArr'));
    }

    public function admin_report($staff_id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Report Page');
        $this->checkAdminSession();
        $napuser = $this->NappUser->get($staff_id);
        $data = $this->request->getData();
        if (!empty($data['slaetype']) || !empty($data['startdate'])) {
            $slaetype = $data['slaetype'] ?? '';
            $startdate = $data['startdate'] ?? date('Y-m-d', strtotime('-7 days'));
            $enddate = $data['enddate'] ?? date('Y-m-d');
        } else {
            $startdate = date('Y-m-d', strtotime('-7 days'));
            $enddate = date('Y-m-d');
            $slaetype = '';
        }
        $conditions = [
            'DATE(SaleReps.created) >=' => $startdate,
            'DATE(SaleReps.created) <=' => $enddate,
            'SaleReps.staff_id' => $staff_id,
        ];
        if (!empty($slaetype)) {
            $conditions['SaleReps.sales_question_id'] = $slaetype;
        }
        $this->paginate = ['limit' => 100, 'order' => ['SaleReps.id' => 'DESC']];
        $SaleRepArr = $this->paginate($this->SaleReps->find()->contain(['SaleQuestions', 'NappUser'])->where($conditions));
        $totallogs = $this->Logs->find('all')->where([
            'DATE(Logs.created) >=' => $startdate,
            'DATE(Logs.created) <=' => $enddate,
            'Logs.user_id' => $staff_id,
        ])->contain(['Clients'])->all();
        // Convert entity to array format for backward compatibility with view
        $napuser = ['NappUser' => $napuser->toArray()];
        $this->set(compact('napuser', 'totallogs', 'SaleRepArr', 'startdate', 'enddate', 'slaetype'));
        $this->set('slatestype', $this->SaleQuestions->find('all')->all());
    }

    public function admin_settarget($staff_id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Report Page');
        $this->checkAdminSession();
        $napuser = $this->NappUser->get($staff_id);
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $napuser = $this->NappUser->patchEntity($napuser, $data['NappUser'] ?? $data);
            $napuser->id = (int)$staff_id;
            if ($this->NappUser->save($napuser)) {
                $this->Flash->success('Sale target set successfully');
                return $this->redirect(['action' => 'admin_index']);
            }
        }
        // Convert entity to array format for backward compatibility with view
        $napuserArr = ['NappUser' => $napuser->toArray()];
        $this->set('napuser', $napuserArr);
        $this->request = $this->request->withParsedBody($napuserArr);
    }

    public function admin_salereminder($staff_id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Report Page');
        $this->checkAdminSession();
        $SaleReminder = $this->SaleReminders->find()->first();
        // Convert entity to array format for backward compatibility with view, or create empty array if null
        if ($SaleReminder) {
            $SaleReminder = ['SaleReminder' => $SaleReminder->toArray()];
        } else {
            $SaleReminder = ['SaleReminder' => [
                'first_reminder' => '',
                'f_time' => '',
                'second_reminder' => '',
                's_time' => '',
                'third_reminder' => '',
                't_time' => '',
            ]];
        }
        $this->set('SaleReminder', $SaleReminder);
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Get or create SaleReminder entity
            $SaleReminderEntity = $this->SaleReminders->find()->first();
            if (!$SaleReminderEntity) {
                $SaleReminderEntity = $this->SaleReminders->newEntity([]);
            }
            $SaleReminderEntity = $this->SaleReminders->patchEntity($SaleReminderEntity, [
                'first_reminder' => $data['first_reminder'] ?? '',
                'f_time' => $data['f_time'] ?? null,
                'second_reminder' => $data['second_reminder'] ?? '',
                's_time' => $data['s_time'] ?? null,
                'third_reminder' => $data['third_reminder'] ?? '',
                't_time' => $data['t_time'] ?? null,
            ]);
            if ($this->SaleReminders->save($SaleReminderEntity)) {
                $this->Flash->success('Sale reminder setup successfully');
                return $this->redirect(['action' => 'admin_salereminder']);
            }
            // Update SaleReminder array for view if save failed
            $SaleReminder = ['SaleReminder' => $SaleReminderEntity->toArray()];
            $this->set('SaleReminder', $SaleReminder);
        }
    }

    public function admin_salesreport($unique_id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Attendance Page');
        $this->checkAdminSession();
        $userArr = $this->User->find()->where(['User.id' => 2])->first();
        if ($userArr) {
            $this->request->getSession()->write('User', $userArr->toArray());
            $this->request->getSession()->write('is_admin', 1);
        }
        $SaleReportArr = $this->SaleReports->find()->where(['SaleReports.unique_id' => $unique_id])->first();
        if (!$SaleReportArr) {
            return $this->redirect('/admin/users/dashboard');
        }
        $weekto = $SaleReportArr->weekto ?? '';
        $weekfrom = $SaleReportArr->weekfrom ?? '';
        $monthfrom = $SaleReportArr->monthfrom ?? '';
        $monthto = $SaleReportArr->monthto ?? '';
        $currentdate = $SaleReportArr->currentdate ?? '';
        $userArrs = $this->UserPermission->find('all')->where(['UserPermission.permssion_id' => 8])->contain(['NappUser'])->all();
        $reportsummary = [];
        foreach ($userArrs as $userArr) {
            $nu = $userArr->napp_user ?? null;
            if (!$nu || (int)($nu->rating ?? 0) <= 0) {
                continue;
            }
            $staff_id = $nu->id;
            $conn = $this->SaleReps->getConnection();
            $currentday = $conn->execute(
                "SELECT COUNT(IF(sales_question_id=1,id,NULL)) AS totalmeeting, COUNT(IF(sales_question_id=2,id,NULL)) AS totalcalled, COUNT(IF(sales_question_id=3,id,NULL)) AS totaltechsuportcall FROM sale_reps WHERE staff_id = :sid AND (DATE(created) >= :cd AND DATE(created) <= :cd2)",
                ['sid' => $staff_id, 'cd' => $currentdate, 'cd2' => $currentdate]
            )->fetch('assoc');
            $currentweek = $conn->execute(
                "SELECT COUNT(IF(sales_question_id=1,id,NULL)) AS totalmeeting, COUNT(IF(sales_question_id=2,id,NULL)) AS totalcalled, COUNT(IF(sales_question_id=3,id,NULL)) AS totaltechsuportcall FROM sale_reps WHERE staff_id = :sid AND (DATE(created) >= :wf AND DATE(created) <= :wt)",
                ['sid' => $staff_id, 'wf' => $weekfrom, 'wt' => $weekto]
            )->fetch('assoc');
            $currentmonth = $conn->execute(
                "SELECT COUNT(IF(sales_question_id=1,id,NULL)) AS totalmeeting, COUNT(IF(sales_question_id=2,id,NULL)) AS totalcalled, COUNT(IF(sales_question_id=3,id,NULL)) AS totaltechsuportcall FROM sale_reps WHERE staff_id = :sid AND (DATE(created) >= :mf AND DATE(created) <= :mt)",
                ['sid' => $staff_id, 'mf' => $monthfrom, 'mt' => $monthto]
            )->fetch('assoc');
            $achive = [
                'name' => trim(($nu->name ?? '') . ' ' . ($nu->lname ?? '')),
                'currentday' => $currentday ?: ['totalmeeting' => 0, 'totalcalled' => 0, 'totaltechsuportcall' => 0],
                'currentweek' => $currentweek ?: ['totalmeeting' => 0, 'totalcalled' => 0, 'totaltechsuportcall' => 0],
                'currentmonth' => $currentmonth ?: ['totalmeeting' => 0, 'totalcalled' => 0, 'totaltechsuportcall' => 0],
                'ff_day' => (int)($nu->ff_day ?? 0), 'ff_meeting' => (int)($nu->ff_meeting ?? 0), 'ff_month' => (int)($nu->ff_month ?? 0),
                'cc_day' => (int)($nu->cc_day ?? 0), 'cc_meeting' => (int)($nu->cc_meeting ?? 0), 'cc_month' => (int)($nu->cc_month ?? 0),
            ];
            $reportsummary[] = $achive;
        }
        $this->set(compact('reportsummary', 'currentdate'));
    }

    public function cronjob()
    {
        $this->viewBuilder()->setLayout(false);
        exit;
    }
}
