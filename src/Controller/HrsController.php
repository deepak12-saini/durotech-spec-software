<?php
namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;

/**
 * Hrs Controller
 */
class HrsController extends AppController
{
	public function initialize(): void
	{
		parent::initialize();
		$this->loadComponent('Paginator');
		$this->loadModel('HrFormatTrainingCalendarRecord');
		$this->loadModel('HrFormatTrainingCalendar');
		$this->loadModel('HrTrainingNeedAssessment');
		$this->loadModel('HrTrainingNeedAssessmentRecord');
		$this->loadModel('NappUser');
		$this->loadModel('User');
		$this->loadModel('HrTrainingAttendanceRecord');
		$this->loadModel('HrTrainingAttendance');
		$this->loadModel('HrPerformanceFeedback');
		$this->loadModel('HrNewJoiningDetail');
		$this->loadModel('HrReportOrganization');
		$this->loadModel('HrDuringLeave');
		$this->loadModel('HrDuringLeaveRecord');
		$this->loadModel('HrFormatEvaluationEmployeRecord');
		$this->loadModel('HrFormatEvaluationEmployee');
		$this->loadModel('HrAppraisalFormRecord');
		$this->loadModel('HrAppraisalForm');
	}

	public function beforeFilter(EventInterface $event): ?Response
	{
		$this->callConstants();
		return parent::beforeFilter($event);
	}

	// ========== CAMELCASE WRAPPERS FOR ADMIN METHODS ==========
	
	public function adminHrAppraisalForm()
	{
		return $this->admin_hr_appraisal_form();
	}

	public function adminFormatEvaluationEmploye()
	{
		return $this->admin_format_evaluation_employe();
	}

	public function adminFormatTrainingCalendars()
	{
		return $this->admin_format_training_calendars();
	}

	public function adminResDuringLeave()
	{
		return $this->admin_res_during_leave();
	}

	public function adminReportorganization()
	{
		return $this->admin_reportorganization();
	}

	public function adminNewjoining()
	{
		return $this->admin_newjoining();
	}

	public function adminPerformancefeedback()
	{
		return $this->admin_performancefeedback();
	}

	public function adminAttendence()
	{
		return $this->admin_attendence();
	}

	public function adminIndex()
	{
		return $this->admin_index();
	}

	// ========== CAMELCASE WRAPPERS FOR PUBLIC METHODS ==========
	
	public function attendanceAdd()
	{
		return $this->attendance_add();
	}

	public function attendanceEdit($id = null)
	{
		return $this->attendance_edit($id);
	}

	public function performanceFeedbackAdd()
	{
		return $this->performance_feedback_add();
	}

	public function performanceFeedbackEdit($id = null)
	{
		return $this->performance_feedback_edit($id);
	}

	public function newjoiningAdd()
	{
		return $this->newjoining_add();
	}

	public function newjoiningEdit($id = null)
	{
		return $this->newjoining_edit($id);
	}

	public function reportorganizationAdd()
	{
		return $this->reportorganization_add();
	}

	public function reportorganizationEdit($id = null)
	{
		return $this->reportorganization_edit($id);
	}

	public function resDuringLeaveAdd()
	{
		return $this->res_during_leave_add();
	}

	public function resDuringLeaveEdit($id)
	{
		return $this->res_during_leave_edit($id);
	}

	public function formatEvaluationEmployeAdd()
	{
		return $this->format_evaluation_employe_add();
	}

	public function formatEvaluationEmployeEdit($id = null)
	{
		return $this->format_evaluation_employe_edit($id);
	}

	public function formatTrainngCalendarAdd()
	{
		return $this->format_trainng_calendar_add();
	}

	public function formatTrainngCalendarEdit($id = null)
	{
		return $this->format_trainng_calendar_edit($id);
	}

	public function appraisalFormEdit($id = null)
	{
		return $this->appraisal_form_edit($id);
	}

	public function appraisalFormAdd()
	{
		return $this->appraisal_form_add();
	}

	// ========== ADMIN METHODS ==========

	function admin_hr_appraisal_form()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Appraisal Form');
		$this->checkSatffSession();

		$query = $this->HrAppraisalForm->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'HrAppraisalFormRecord'
			])
			->orderDesc('HrAppraisalForm.id');

		$HrDuringLeaveArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$HrDuringLeaveArrArray = [];
		foreach ($HrDuringLeaveArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrAppraisalForm' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->hr_appraisal_form_record) {
				$result['HrAppraisalFormRecord'] = [];
				foreach ($doc->hr_appraisal_form_record as $record) {
					$result['HrAppraisalFormRecord'][] = $record->toArray();
				}
			} else {
				$result['HrAppraisalFormRecord'] = [];
			}
			$HrDuringLeaveArrArray[] = $result;
		}
		$HrDuringLeaveArr = $HrDuringLeaveArrArray;

		$this->set('HrDuringLeaveArr', $HrDuringLeaveArr);
	}

	function admin_format_evaluation_employe()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Hr format training calendars');
		$this->checkAdminSession();

		$query = $this->HrFormatEvaluationEmployee->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'HrFormatEvaluationEmployeRecord'
			])
			->orderDesc('HrFormatEvaluationEmployee.id');

		$HrDuringLeaveArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrDuringLeaveArrArray = [];
		foreach ($HrDuringLeaveArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrFormatEvaluationEmployee' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->hr_format_evaluation_employe_record) {
				$result['HrFormatEvaluationEmployeRecord'] = [];
				foreach ($doc->hr_format_evaluation_employe_record as $record) {
					$result['HrFormatEvaluationEmployeRecord'][] = $record->toArray();
				}
			} else {
				$result['HrFormatEvaluationEmployeRecord'] = [];
			}
			$HrDuringLeaveArrArray[] = $result;
		}
		$HrDuringLeaveArr = $HrDuringLeaveArrArray;

		$this->set('HrDuringLeaveArr', $HrDuringLeaveArr);
	}

	function admin_format_training_calendars()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Hr format training calendars');
		$this->checkAdminSession();

		$query = $this->HrFormatTrainingCalendar->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'HrFormatTrainingCalendarRecord'
			])
			->orderDesc('HrFormatTrainingCalendar.id');

		$HrDuringLeaveArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrDuringLeaveArrArray = [];
		foreach ($HrDuringLeaveArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrFormatTrainingCalendar' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->hr_format_training_calendar_record) {
				$result['HrFormatTrainingCalendarRecord'] = [];
				foreach ($doc->hr_format_training_calendar_record as $record) {
					$result['HrFormatTrainingCalendarRecord'][] = $record->toArray();
				}
			} else {
				$result['HrFormatTrainingCalendarRecord'] = [];
			}
			$HrDuringLeaveArrArray[] = $result;
		}
		$HrDuringLeaveArr = $HrDuringLeaveArrArray;

		$this->set('HrDuringLeaveArr', $HrDuringLeaveArr);
	}

	function admin_res_during_leave()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Handling/Taking Over Duties & Responsibilties During Leave');
		$this->checkAdminSession();

		$query = $this->HrDuringLeave->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'HrDuringLeaveRecord'
			])
			->orderDesc('HrDuringLeave.id');

		$HrDuringLeaveArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrDuringLeaveArrArray = [];
		foreach ($HrDuringLeaveArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrDuringLeave' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->hr_during_leave_record) {
				$result['HrDuringLeaveRecord'] = [];
				foreach ($doc->hr_during_leave_record as $record) {
					$result['HrDuringLeaveRecord'][] = $record->toArray();
				}
			} else {
				$result['HrDuringLeaveRecord'] = [];
			}
			$HrDuringLeaveArrArray[] = $result;
		}
		$HrDuringLeaveArr = $HrDuringLeaveArrArray;

		$this->set('HrDuringLeaveArr', $HrDuringLeaveArr);
	}

	function admin_reportorganization()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Joining Report to organization');
		$this->checkAdminSession();

		$query = $this->HrReportOrganization->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				}
			])
			->orderDesc('HrReportOrganization.id');

		$HrReportOrganizationArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrReportOrganizationArrArray = [];
		foreach ($HrReportOrganizationArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrReportOrganization' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			$HrReportOrganizationArrArray[] = $result;
		}
		$HrReportOrganizationArr = $HrReportOrganizationArrArray;

		$this->set('HrReportOrganizationArr', $HrReportOrganizationArr);
	}

	function admin_newjoining()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' New Joining List');
		$this->checkAdminSession();

		$query = $this->HrNewJoiningDetail->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				}
			])
			->orderDesc('HrNewJoiningDetail.id');

		$HrNewJoiningDetailArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrNewJoiningDetailArrArray = [];
		foreach ($HrNewJoiningDetailArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrNewJoiningDetail' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			$HrNewJoiningDetailArrArray[] = $result;
		}
		$HrNewJoiningDetailArr = $HrNewJoiningDetailArrArray;

		$this->set('HrNewJoiningDetailArr', $HrNewJoiningDetailArr);
	}

	function admin_performancefeedback()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Performance Feedback');
		$this->checkAdminSession();

		$query = $this->HrPerformanceFeedback->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				}
			])
			->orderDesc('HrPerformanceFeedback.id');

		$HrPerformanceFeedbackArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrPerformanceFeedbackArrArray = [];
		foreach ($HrPerformanceFeedbackArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrPerformanceFeedback' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			$HrPerformanceFeedbackArrArray[] = $result;
		}
		$HrPerformanceFeedbackArr = $HrPerformanceFeedbackArrArray;

		$this->set('HrPerformanceFeedbackArr', $HrPerformanceFeedbackArr);
	}

	function admin_attendence()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Training Attendance');
		$this->checkAdminSession();

		$query = $this->HrTrainingAttendance->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'HrTrainingAttendanceRecord'
			])
			->orderDesc('HrTrainingAttendance.id');

		$HrTrainingAttendanceArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrTrainingAttendanceArrArray = [];
		foreach ($HrTrainingAttendanceArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrTrainingAttendance' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->hr_training_attendance_record) {
				$result['HrTrainingAttendanceRecord'] = [];
				foreach ($doc->hr_training_attendance_record as $record) {
					$result['HrTrainingAttendanceRecord'][] = $record->toArray();
				}
			} else {
				$result['HrTrainingAttendanceRecord'] = [];
			}
			$HrTrainingAttendanceArrArray[] = $result;
		}
		$HrTrainingAttendanceArr = $HrTrainingAttendanceArrArray;

		$this->set('HrTrainingAttendanceArr', $HrTrainingAttendanceArr);
	}

	function admin_index()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Training Need Assessment');
		$this->checkAdminSession();

		$query = $this->HrTrainingNeedAssessment->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'HrTrainingNeedAssessmentRecord'
			])
			->orderDesc('HrTrainingNeedAssessment.id');

		$HrTrainingNeedAssessmentArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrTrainingNeedAssessmentArrArray = [];
		foreach ($HrTrainingNeedAssessmentArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrTrainingNeedAssessment' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->hr_training_need_assessment_record) {
				$result['HrTrainingNeedAssessmentRecord'] = [];
				foreach ($doc->hr_training_need_assessment_record as $record) {
					$result['HrTrainingNeedAssessmentRecord'][] = $record->toArray();
				}
			} else {
				$result['HrTrainingNeedAssessmentRecord'] = [];
			}
			$HrTrainingNeedAssessmentArrArray[] = $result;
		}
		$HrTrainingNeedAssessmentArr = $HrTrainingNeedAssessmentArrArray;

		$this->set('HrTrainingNeedAssessmentArr', $HrTrainingNeedAssessmentArr);
	}

	// ========== PUBLIC METHODS ==========

	function index()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Training Need Assessment');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->HrTrainingNeedAssessment->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'HrTrainingNeedAssessmentRecord'
			])
			->where(['HrTrainingNeedAssessment.user_id' => $user_id])
			->orderDesc('HrTrainingNeedAssessment.id');

		$HrTrainingNeedAssessmentArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrTrainingNeedAssessmentArrArray = [];
		foreach ($HrTrainingNeedAssessmentArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrTrainingNeedAssessment' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->hr_training_need_assessment_record) {
				$result['HrTrainingNeedAssessmentRecord'] = [];
				foreach ($doc->hr_training_need_assessment_record as $record) {
					$result['HrTrainingNeedAssessmentRecord'][] = $record->toArray();
				}
			} else {
				$result['HrTrainingNeedAssessmentRecord'] = [];
			}
			$HrTrainingNeedAssessmentArrArray[] = $result;
		}
		$HrTrainingNeedAssessmentArr = $HrTrainingNeedAssessmentArrArray;

		$this->set('HrTrainingNeedAssessmentArr', $HrTrainingNeedAssessmentArr);
	}

	public function add()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Add Hr Training Need Assessment');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrTrainingNeedAssessment']['user_id'] = $user_id;
			$data['HrTrainingNeedAssessment']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrTrainingNeedAssessment->newEntity($data['HrTrainingNeedAssessment'], ['validate' => false]);
			if ($this->HrTrainingNeedAssessment->save($entity)) {
				$hr_id = $entity->id;

				if (!empty($data['performance_rating'])) {
					$i = 0;
					foreach ($data['performance_rating'] as $record) {
						$recordEntity = $this->HrTrainingNeedAssessmentRecord->newEntity([
							'hr_id' => $hr_id,
							'performance_rating' => $data['performance_rating'][$i] ?? '',
							'record_1' => $data['record_1'][$i] ?? '',
							'record_2' => $data['record_2'][$i] ?? '',
							'record_3' => $data['record_3'][$i] ?? '',
							'record_4' => $data['record_4'][$i] ?? '',
							'record_5' => $data['record_5'][$i] ?? '',
							'remark' => $data['remark'][$i] ?? ''
						], ['validate' => false]);
						$this->HrTrainingNeedAssessmentRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'index']);
			}
		}

		$cuserEntities = $this->NappUser->find()
			->where(['NappUser.is_staff_id' => 1])
			->select(['id', 'name', 'lname'])
			->toArray();
		$cuser = [];
		foreach ($cuserEntities as $entity) {
			$cuser[] = ['NappUser' => $entity->toArray()];
		}
		$this->set('cuser', $cuser);

		$docEntity = $this->HrTrainingNeedAssessment->find()
			->orderDesc('HrTrainingNeedAssessment.id')
			->select(['HrTrainingNeedAssessment.id'])
			->first();
		$docArr = $docEntity ? ['HrTrainingNeedAssessment' => $docEntity->toArray()] : ['HrTrainingNeedAssessment' => ['id' => null]];
		if (!empty($docArr['HrTrainingNeedAssessment']['id'])) {
			$docId = 'DTHR-TNA-' . (1000 + $docArr['HrTrainingNeedAssessment']['id'] + 1);
		} else {
			$docId = 'DTHR-TNA-1001';
		}
		$this->set('docId', $docId);
	}

	public function edit($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Add Hr Training Need Assessment');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrTrainingNeedAssessment']['id'] = $id;
			$data['HrTrainingNeedAssessment']['user_id'] = $user_id;
			$data['HrTrainingNeedAssessment']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrTrainingNeedAssessment->get($id);
			$entity = $this->HrTrainingNeedAssessment->patchEntity($entity, $data['HrTrainingNeedAssessment'], ['validate' => false]);
			if ($this->HrTrainingNeedAssessment->save($entity)) {
				$hr_id = $entity->id;

				// Delete existing records
				$this->HrTrainingNeedAssessmentRecord->deleteAll(['hr_id' => $hr_id]);

				if (!empty($data['performance_rating'])) {
					$i = 0;
					foreach ($data['performance_rating'] as $record) {
						$recordEntity = $this->HrTrainingNeedAssessmentRecord->newEntity([
							'hr_id' => $hr_id,
							'performance_rating' => $data['performance_rating'][$i] ?? '',
							'record_1' => $data['record_1'][$i] ?? '',
							'record_2' => $data['record_2'][$i] ?? '',
							'record_3' => $data['record_3'][$i] ?? '',
							'record_4' => $data['record_4'][$i] ?? '',
							'record_5' => $data['record_5'][$i] ?? '',
							'remark' => $data['remark'][$i] ?? ''
						], ['validate' => false]);
						$this->HrTrainingNeedAssessmentRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'index']);
			}
		}

		$cuserEntities = $this->NappUser->find()
			->where(['NappUser.is_staff_id' => 1])
			->select(['id', 'name', 'lname'])
			->toArray();
		$cuser = [];
		foreach ($cuserEntities as $entity) {
			$cuser[] = ['NappUser' => $entity->toArray()];
		}
		$this->set('cuser', $cuser);

		$docEntity = $this->HrTrainingNeedAssessment->find()
			->contain(['HrTrainingNeedAssessmentRecord'])
			->where(['HrTrainingNeedAssessment.id' => $id])
			->first();

		if ($docEntity) {
			$docData = $docEntity->toArray();
			$docArr = ['HrTrainingNeedAssessment' => $docData];
			if ($docEntity->hr_training_need_assessment_record) {
				$docArr['HrTrainingNeedAssessmentRecord'] = [];
				foreach ($docEntity->hr_training_need_assessment_record as $record) {
					$docArr['HrTrainingNeedAssessmentRecord'][] = $record->toArray();
				}
			} else {
				$docArr['HrTrainingNeedAssessmentRecord'] = [];
			}
			$this->set('docArr', $docArr);
		}
	}

	function attendence()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Training Attendance');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->HrTrainingAttendance->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'HrTrainingAttendanceRecord'
			])
			->where(['HrTrainingAttendance.user_id' => $user_id])
			->orderDesc('HrTrainingAttendance.id');

		$HrTrainingAttendanceArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrTrainingAttendanceArrArray = [];
		foreach ($HrTrainingAttendanceArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrTrainingAttendance' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->hr_training_attendance_record) {
				$result['HrTrainingAttendanceRecord'] = [];
				foreach ($doc->hr_training_attendance_record as $record) {
					$result['HrTrainingAttendanceRecord'][] = $record->toArray();
				}
			} else {
				$result['HrTrainingAttendanceRecord'] = [];
			}
			$HrTrainingAttendanceArrArray[] = $result;
		}
		$HrTrainingAttendanceArr = $HrTrainingAttendanceArrArray;

		$this->set('HrTrainingAttendanceArr', $HrTrainingAttendanceArr);
	}

	public function attendance_add()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Training Attendance');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrTrainingAttendance']['user_id'] = $user_id;
			$data['HrTrainingAttendance']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrTrainingAttendance->newEntity($data['HrTrainingAttendance'], ['validate' => false]);
			if ($this->HrTrainingAttendance->save($entity)) {
				$lastinsrtId = $entity->id;

				if (!empty($data['trainee_name'])) {
					$i = 0;
					foreach ($data['trainee_name'] as $trainee_name) {
						$recordEntity = $this->HrTrainingAttendanceRecord->newEntity([
							'user_id' => $user_id,
							'hr_id' => $lastinsrtId,
							'trainee_name' => $data['trainee_name'][$i] ?? '',
							'department' => $data['department'][$i] ?? '',
							'signature' => $data['signature'][$i] ?? '',
							'date' => $data['date'][$i] ?? ''
						], ['validate' => false]);
						$this->HrTrainingAttendanceRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'attendence']);
			}
		}

		$cuserEntities = $this->NappUser->find()
			->where(['NappUser.is_staff_id' => 1])
			->select(['id', 'name', 'lname'])
			->toArray();
		$cuser = [];
		foreach ($cuserEntities as $entity) {
			$cuser[] = ['NappUser' => $entity->toArray()];
		}
		$this->set('cuser', $cuser);

		$docEntity = $this->HrTrainingAttendance->find()
			->orderDesc('HrTrainingAttendance.id')
			->select(['HrTrainingAttendance.id'])
			->first();
		$docArr = $docEntity ? ['HrTrainingAttendance' => $docEntity->toArray()] : ['HrTrainingAttendance' => ['id' => null]];
		if (!empty($docArr['HrTrainingAttendance']['id'])) {
			$docId = 'DTTA-' . (1000 + $docArr['HrTrainingAttendance']['id'] + 1);
		} else {
			$docId = 'DTTA-1001';
		}
		$this->set('docId', $docId);
	}

	public function attendance_edit($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Training Attendance');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrTrainingAttendance']['id'] = $id;
			$data['HrTrainingAttendance']['user_id'] = $user_id;
			$data['HrTrainingAttendance']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrTrainingAttendance->get($id);
			$entity = $this->HrTrainingAttendance->patchEntity($entity, $data['HrTrainingAttendance'], ['validate' => false]);
			if ($this->HrTrainingAttendance->save($entity)) {
				// Delete existing records
				$this->HrTrainingAttendanceRecord->deleteAll(['hr_id' => $id]);

				if (!empty($data['trainee_name'])) {
					$i = 0;
					foreach ($data['trainee_name'] as $trainee_name) {
						$recordEntity = $this->HrTrainingAttendanceRecord->newEntity([
							'user_id' => $user_id,
							'hr_id' => $id,
							'trainee_name' => $data['trainee_name'][$i] ?? '',
							'department' => $data['department'][$i] ?? '',
							'signature' => $data['signature'][$i] ?? '',
							'date' => $data['date'][$i] ?? ''
						], ['validate' => false]);
						$this->HrTrainingAttendanceRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'attendence']);
			}
		}

		$cuserEntities = $this->NappUser->find()
			->where(['NappUser.is_staff_id' => 1])
			->select(['id', 'name', 'lname'])
			->toArray();
		$cuser = [];
		foreach ($cuserEntities as $entity) {
			$cuser[] = ['NappUser' => $entity->toArray()];
		}
		$this->set('cuser', $cuser);

		$docEntity = $this->HrTrainingAttendance->find()
			->contain(['HrTrainingAttendanceRecord'])
			->where(['HrTrainingAttendance.id' => $id])
			->first();

		if ($docEntity) {
			$docData = $docEntity->toArray();
			$docArr = ['HrTrainingAttendance' => $docData];
			if ($docEntity->hr_training_attendance_record) {
				$docArr['HrTrainingAttendanceRecord'] = [];
				foreach ($docEntity->hr_training_attendance_record as $record) {
					$docArr['HrTrainingAttendanceRecord'][] = $record->toArray();
				}
			} else {
				$docArr['HrTrainingAttendanceRecord'] = [];
			}
			$this->set('docArr', $docArr);
		}
	}

	function performancefeedback()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Performance Feedback');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->HrPerformanceFeedback->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				}
			])
			->where(['HrPerformanceFeedback.user_id' => $user_id])
			->orderDesc('HrPerformanceFeedback.id');

		$HrPerformanceFeedbackArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrPerformanceFeedbackArrArray = [];
		foreach ($HrPerformanceFeedbackArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrPerformanceFeedback' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			$HrPerformanceFeedbackArrArray[] = $result;
		}
		$HrPerformanceFeedbackArr = $HrPerformanceFeedbackArrArray;

		$this->set('HrPerformanceFeedbackArr', $HrPerformanceFeedbackArr);
	}

	public function performance_feedback_add()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Add Hr Performance Feedback');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrPerformanceFeedback']['user_id'] = $user_id;
			$data['HrPerformanceFeedback']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrPerformanceFeedback->newEntity($data['HrPerformanceFeedback'], ['validate' => false]);
			if ($this->HrPerformanceFeedback->save($entity)) {
				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'performancefeedback']);
			}
		}

		$docEntity = $this->HrPerformanceFeedback->find()
			->orderDesc('HrPerformanceFeedback.id')
			->select(['HrPerformanceFeedback.id'])
			->first();
		$docArr = $docEntity ? ['HrPerformanceFeedback' => $docEntity->toArray()] : ['HrPerformanceFeedback' => ['id' => null]];
		if (!empty($docArr['HrPerformanceFeedback']['id'])) {
			$docId = 'DTTA-' . (1000 + $docArr['HrPerformanceFeedback']['id'] + 1);
		} else {
			$docId = 'DTTA-1001';
		}
		$this->set('docId', $docId);
	}

	public function performance_feedback_edit($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Add Hr Performance Feedback');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrPerformanceFeedback']['id'] = $id;
			$data['HrPerformanceFeedback']['user_id'] = $user_id;
			$data['HrPerformanceFeedback']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrPerformanceFeedback->get($id);
			$entity = $this->HrPerformanceFeedback->patchEntity($entity, $data['HrPerformanceFeedback'], ['validate' => false]);
			if ($this->HrPerformanceFeedback->save($entity)) {
				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'performancefeedback']);
			}
		}

		$docEntity = $this->HrPerformanceFeedback->find()
			->where(['HrPerformanceFeedback.id' => $id])
			->first();
		if ($docEntity) {
			$docArr = ['HrPerformanceFeedback' => $docEntity->toArray()];
			$this->set('docArr', $docArr);
		}
	}

	function newjoining()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' New Joining List');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->HrNewJoiningDetail->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				}
			])
			->where(['HrNewJoiningDetail.user_id' => $user_id])
			->orderDesc('HrNewJoiningDetail.id');

		$HrNewJoiningDetailArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrNewJoiningDetailArrArray = [];
		foreach ($HrNewJoiningDetailArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrNewJoiningDetail' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			$HrNewJoiningDetailArrArray[] = $result;
		}
		$HrNewJoiningDetailArr = $HrNewJoiningDetailArrArray;

		$this->set('HrNewJoiningDetailArr', $HrNewJoiningDetailArr);
	}

	public function newjoining_add()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Add Hr New Joining');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrNewJoiningDetail']['user_id'] = $user_id;
			$data['HrNewJoiningDetail']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrNewJoiningDetail->newEntity($data['HrNewJoiningDetail'], ['validate' => false]);
			if ($this->HrNewJoiningDetail->save($entity)) {
				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'newjoining']);
			}
		}

		$docEntity = $this->HrNewJoiningDetail->find()
			->orderDesc('HrNewJoiningDetail.id')
			->select(['HrNewJoiningDetail.id'])
			->first();
		$docArr = $docEntity ? ['HrNewJoiningDetail' => $docEntity->toArray()] : ['HrNewJoiningDetail' => ['id' => null]];
		if (!empty($docArr['HrNewJoiningDetail']['id'])) {
			$docId = 'DTNJ-' . (1000 + $docArr['HrNewJoiningDetail']['id'] + 1);
		} else {
			$docId = 'DTNJ-1001';
		}
		$this->set('docId', $docId);
	}

	public function newjoining_edit($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Edit Hr New Joining');
		$this->checkSatffSession();

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrNewJoiningDetail']['id'] = $id;

			$entity = $this->HrNewJoiningDetail->get($id);
			$entity = $this->HrNewJoiningDetail->patchEntity($entity, $data['HrNewJoiningDetail'], ['validate' => false]);
			if ($this->HrNewJoiningDetail->save($entity)) {
				$this->Flash->success('Record updated successfully.');
				return $this->redirect(['action' => 'newjoining']);
			}
		}

		$docEntity = $this->HrNewJoiningDetail->find()
			->where(['HrNewJoiningDetail.id' => $id])
			->first();
		if ($docEntity) {
			$docArr = ['HrNewJoiningDetail' => $docEntity->toArray()];
			$this->set('docArr', $docArr);
		}
	}

	function reportorganization()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' New Joining List');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->HrReportOrganization->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				}
			])
			->where(['HrReportOrganization.user_id' => $user_id])
			->orderDesc('HrReportOrganization.id');

		$HrReportOrganizationArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrReportOrganizationArrArray = [];
		foreach ($HrReportOrganizationArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrReportOrganization' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			$HrReportOrganizationArrArray[] = $result;
		}
		$HrReportOrganizationArr = $HrReportOrganizationArrArray;

		$this->set('HrReportOrganizationArr', $HrReportOrganizationArr);
	}

	public function reportorganization_add()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Add Report Organization');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrReportOrganization']['user_id'] = $user_id;
			$data['HrReportOrganization']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrReportOrganization->newEntity($data['HrReportOrganization'], ['validate' => false]);
			if ($this->HrReportOrganization->save($entity)) {
				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'reportorganization']);
			}
		}

		$docEntity = $this->HrReportOrganization->find()
			->orderDesc('HrReportOrganization.id')
			->select(['HrReportOrganization.id'])
			->first();
		$docArr = $docEntity ? ['HrReportOrganization' => $docEntity->toArray()] : ['HrReportOrganization' => ['id' => null]];
		if (!empty($docArr['HrReportOrganization']['id'])) {
			$docId = 'DTJRO-' . (1000 + $docArr['HrReportOrganization']['id'] + 1);
		} else {
			$docId = 'DTJRO-1001';
		}
		$this->set('docId', $docId);
	}

	public function reportorganization_edit($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Edit Hr New Joining');
		$this->checkSatffSession();

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrReportOrganization']['id'] = $id;

			$entity = $this->HrReportOrganization->get($id);
			$entity = $this->HrReportOrganization->patchEntity($entity, $data['HrReportOrganization'], ['validate' => false]);
			if ($this->HrReportOrganization->save($entity)) {
				$this->Flash->success('Record updated successfully.');
				return $this->redirect(['action' => 'reportorganization']);
			}
		}

		$docEntity = $this->HrReportOrganization->find()
			->where(['HrReportOrganization.id' => $id])
			->first();
		if ($docEntity) {
			$docArr = ['HrReportOrganization' => $docEntity->toArray()];
			$this->set('docArr', $docArr);
		}
	}

	function res_during_leave()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Handling/Taking Over Duties & Responsibilties During Leave');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->HrDuringLeave->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'HrDuringLeaveRecord'
			])
			->where(['HrDuringLeave.user_id' => $user_id])
			->orderDesc('HrDuringLeave.id');

		$HrDuringLeaveArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrDuringLeaveArrArray = [];
		foreach ($HrDuringLeaveArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrDuringLeave' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->hr_during_leave_record) {
				$result['HrDuringLeaveRecord'] = [];
				foreach ($doc->hr_during_leave_record as $record) {
					$result['HrDuringLeaveRecord'][] = $record->toArray();
				}
			} else {
				$result['HrDuringLeaveRecord'] = [];
			}
			$HrDuringLeaveArrArray[] = $result;
		}
		$HrDuringLeaveArr = $HrDuringLeaveArrArray;

		$this->set('HrDuringLeaveArr', $HrDuringLeaveArr);
	}

	public function res_during_leave_add()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Add Handling/Taking Over Duties & Responsibilties During Leave');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrDuringLeave']['user_id'] = $user_id;
			$data['HrDuringLeave']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrDuringLeave->newEntity($data['HrDuringLeave'], ['validate' => false]);
			if ($this->HrDuringLeave->save($entity)) {
				$lastinsrtId = $entity->id;

				if (!empty($data['description_of_duty'])) {
					$i = 0;
					foreach ($data['description_of_duty'] as $description_of_duty) {
						$recordEntity = $this->HrDuringLeaveRecord->newEntity([
							'hr_id' => $lastinsrtId,
							'description_of_duty' => $data['description_of_duty'][$i] ?? '',
							'description_of_responsibility' => $data['description_of_responsibility'][$i] ?? '',
							'handed_over' => $data['handed_over'][$i] ?? '',
							'assigned_to' => $data['assigned_to'][$i] ?? '',
							'signature' => $data['signature'][$i] ?? ''
						], ['validate' => false]);
						$this->HrDuringLeaveRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'res_during_leave']);
			}
		}

		$docEntity = $this->HrDuringLeave->find()
			->orderDesc('HrDuringLeave.id')
			->select(['HrDuringLeave.id'])
			->first();
		$docArr = $docEntity ? ['HrDuringLeave' => $docEntity->toArray()] : ['HrDuringLeave' => ['id' => null]];
		if (!empty($docArr['HrDuringLeave']['id'])) {
			$docId = 'DTRDL-' . (1000 + $docArr['HrDuringLeave']['id'] + 1);
		} else {
			$docId = 'DTRDL-1001';
		}
		$this->set('docId', $docId);
	}

	public function res_during_leave_edit($id)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Edit Handling/Taking Over Duties & Responsibilties During Leave');
		$this->checkSatffSession();

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrDuringLeave']['id'] = $id;
			$data['HrDuringLeave']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrDuringLeave->get($id);
			$entity = $this->HrDuringLeave->patchEntity($entity, $data['HrDuringLeave'], ['validate' => false]);
			if ($this->HrDuringLeave->save($entity)) {
				// Delete existing records
				$this->HrDuringLeaveRecord->deleteAll(['hr_id' => $id]);

				if (!empty($data['description_of_duty'])) {
					$i = 0;
					foreach ($data['description_of_duty'] as $description_of_duty) {
						$recordEntity = $this->HrDuringLeaveRecord->newEntity([
							'hr_id' => $id,
							'description_of_duty' => $data['description_of_duty'][$i] ?? '',
							'description_of_responsibility' => $data['description_of_responsibility'][$i] ?? '',
							'handed_over' => $data['handed_over'][$i] ?? '',
							'assigned_to' => $data['assigned_to'][$i] ?? '',
							'signature' => $data['signature'][$i] ?? ''
						], ['validate' => false]);
						$this->HrDuringLeaveRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'res_during_leave']);
			}
		}

		$docEntity = $this->HrDuringLeave->find()
			->contain(['HrDuringLeaveRecord'])
			->where(['HrDuringLeave.id' => $id])
			->first();

		if ($docEntity) {
			$docData = $docEntity->toArray();
			$docArr = ['HrDuringLeave' => $docData];
			if ($docEntity->hr_during_leave_record) {
				$docArr['HrDuringLeaveRecord'] = [];
				foreach ($docEntity->hr_during_leave_record as $record) {
					$docArr['HrDuringLeaveRecord'][] = $record->toArray();
				}
			} else {
				$docArr['HrDuringLeaveRecord'] = [];
			}
			$this->set('docArr', $docArr);
		}
	}

	function format_evaluation_employe()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr format training calendars');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->HrFormatEvaluationEmployee->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'HrFormatEvaluationEmployeRecord'
			])
			->where(['HrFormatEvaluationEmployee.user_id' => $user_id])
			->orderDesc('HrFormatEvaluationEmployee.id');

		$HrDuringLeaveArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrDuringLeaveArrArray = [];
		foreach ($HrDuringLeaveArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrFormatEvaluationEmployee' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->hr_format_evaluation_employe_record) {
				$result['HrFormatEvaluationEmployeRecord'] = [];
				foreach ($doc->hr_format_evaluation_employe_record as $record) {
					$result['HrFormatEvaluationEmployeRecord'][] = $record->toArray();
				}
			} else {
				$result['HrFormatEvaluationEmployeRecord'] = [];
			}
			$HrDuringLeaveArrArray[] = $result;
		}
		$HrDuringLeaveArr = $HrDuringLeaveArrArray;

		$this->set('HrDuringLeaveArr', $HrDuringLeaveArr);
	}

	public function format_evaluation_employe_add()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Add Format evaluation employe');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrFormatEvaluationEmployee']['user_id'] = $user_id;
			$data['HrFormatEvaluationEmployee']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrFormatEvaluationEmployee->newEntity($data['HrFormatEvaluationEmployee'], ['validate' => false]);
			if ($this->HrFormatEvaluationEmployee->save($entity)) {
				$lastinsrtId = $entity->id;

				if (!empty($data['detail'])) {
					$i = 0;
					foreach ($data['detail'] as $detail) {
						$recordEntity = $this->HrFormatEvaluationEmployeRecord->newEntity([
							'hr_id' => $lastinsrtId,
							'detail' => $detail,
							'acceptable' => $data['acceptable'][$i] ?? '',
							'not_acceptable' => $data['not_acceptable'][$i] ?? '',
							'to_be_improved' => $data['to_be_improved'][$i] ?? ''
						], ['validate' => false]);
						$this->HrFormatEvaluationEmployeRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'format_evaluation_employe']);
			}
		}

		$docEntity = $this->HrFormatEvaluationEmployee->find()
			->orderDesc('HrFormatEvaluationEmployee.id')
			->select(['HrFormatEvaluationEmployee.id'])
			->first();
		$docArr = $docEntity ? ['HrFormatEvaluationEmployee' => $docEntity->toArray()] : ['HrFormatEvaluationEmployee' => ['id' => null]];
		if (!empty($docArr['HrFormatEvaluationEmployee']['id'])) {
			$docId = 'DTFEE-' . (1000 + $docArr['HrFormatEvaluationEmployee']['id'] + 1);
		} else {
			$docId = 'DTFEE-1001';
		}
		$this->set('docId', $docId);
	}

	public function format_evaluation_employe_edit($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Add Format evaluation employe');
		$this->checkSatffSession();

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrFormatEvaluationEmployee']['id'] = $id;

			$entity = $this->HrFormatEvaluationEmployee->get($id);
			$entity = $this->HrFormatEvaluationEmployee->patchEntity($entity, $data['HrFormatEvaluationEmployee'], ['validate' => false]);
			if ($this->HrFormatEvaluationEmployee->save($entity)) {
				// Delete existing records
				$this->HrFormatEvaluationEmployeRecord->deleteAll(['hr_id' => $id]);

				if (!empty($data['detail'])) {
					$i = 0;
					foreach ($data['detail'] as $detail) {
						$recordEntity = $this->HrFormatEvaluationEmployeRecord->newEntity([
							'hr_id' => $id,
							'detail' => $detail,
							'acceptable' => $data['acceptable'][$i] ?? '',
							'not_acceptable' => $data['not_acceptable'][$i] ?? '',
							'to_be_improved' => $data['to_be_improved'][$i] ?? ''
						], ['validate' => false]);
						$this->HrFormatEvaluationEmployeRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'format_evaluation_employe']);
			}
		}

		$docEntity = $this->HrFormatEvaluationEmployee->find()
			->contain(['HrFormatEvaluationEmployeRecord'])
			->where(['HrFormatEvaluationEmployee.id' => $id])
			->first();

		if ($docEntity) {
			$docData = $docEntity->toArray();
			$docArr = ['HrFormatEvaluationEmployee' => $docData];
			if ($docEntity->hr_format_evaluation_employe_record) {
				$docArr['HrFormatEvaluationEmployeRecord'] = [];
				foreach ($docEntity->hr_format_evaluation_employe_record as $record) {
					$docArr['HrFormatEvaluationEmployeRecord'][] = $record->toArray();
				}
			} else {
				$docArr['HrFormatEvaluationEmployeRecord'] = [];
			}
			$this->set('docArr', $docArr);
		}
	}

	function format_training_calendars()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr format training calendars');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->HrFormatTrainingCalendar->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'HrFormatTrainingCalendarRecord'
			])
			->where(['HrFormatTrainingCalendar.user_id' => $user_id])
			->orderDesc('HrFormatTrainingCalendar.id');

		$HrDuringLeaveArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrDuringLeaveArrArray = [];
		foreach ($HrDuringLeaveArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrFormatTrainingCalendar' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->hr_format_training_calendar_record) {
				$result['HrFormatTrainingCalendarRecord'] = [];
				foreach ($doc->hr_format_training_calendar_record as $record) {
					$result['HrFormatTrainingCalendarRecord'][] = $record->toArray();
				}
			} else {
				$result['HrFormatTrainingCalendarRecord'] = [];
			}
			$HrDuringLeaveArrArray[] = $result;
		}
		$HrDuringLeaveArr = $HrDuringLeaveArrArray;

		$this->set('HrDuringLeaveArr', $HrDuringLeaveArr);
	}

	public function format_trainng_calendar_add()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Add Format training calendars');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrFormatTrainingCalendar']['user_id'] = $user_id;
			$data['HrFormatTrainingCalendar']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrFormatTrainingCalendar->newEntity($data['HrFormatTrainingCalendar'], ['validate' => false]);
			if ($this->HrFormatTrainingCalendar->save($entity)) {
				$lastinsrtId = $entity->id;

				if (!empty($data['month'])) {
					$i = 0;
					foreach ($data['month'] as $month) {
						$recordEntity = $this->HrFormatTrainingCalendarRecord->newEntity([
							'hr_id' => $lastinsrtId,
							'month' => $month,
							'planed' => !empty($data['planed'][$i]) ? $data['planed'][$i] : '',
							'actual' => !empty($data['actual'][$i]) ? $data['actual'][$i] : ''
						], ['validate' => false]);
						$this->HrFormatTrainingCalendarRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'format_training_calendars']);
			}
		}

		$docEntity = $this->HrFormatTrainingCalendar->find()
			->orderDesc('HrFormatTrainingCalendar.id')
			->select(['HrFormatTrainingCalendar.id'])
			->first();
		$docArr = $docEntity ? ['HrFormatTrainingCalendar' => $docEntity->toArray()] : ['HrFormatTrainingCalendar' => ['id' => null]];
		if (!empty($docArr['HrFormatTrainingCalendar']['id'])) {
			$docId = 'DTFTC-' . (1000 + $docArr['HrFormatTrainingCalendar']['id'] + 1);
		} else {
			$docId = 'DTFTC-1001';
		}
		$this->set('docId', $docId);
	}

	public function format_trainng_calendar_edit($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Add Format training calendars');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrFormatTrainingCalendar']['id'] = $id;

			$entity = $this->HrFormatTrainingCalendar->get($id);
			$entity = $this->HrFormatTrainingCalendar->patchEntity($entity, $data['HrFormatTrainingCalendar'], ['validate' => false]);
			if ($this->HrFormatTrainingCalendar->save($entity)) {
				// Delete existing records
				$this->HrFormatTrainingCalendarRecord->deleteAll(['hr_id' => $id]);

				if (!empty($data['month'])) {
					$i = 0;
					foreach ($data['month'] as $month) {
						$recordEntity = $this->HrFormatTrainingCalendarRecord->newEntity([
							'hr_id' => $id,
							'month' => $month,
							'planed' => !empty($data['planed'][$i]) ? $data['planed'][$i] : '',
							'actual' => !empty($data['actual'][$i]) ? $data['actual'][$i] : ''
						], ['validate' => false]);
						$this->HrFormatTrainingCalendarRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'format_training_calendars']);
			}
		}

		$docEntity = $this->HrFormatTrainingCalendar->find()
			->contain(['HrFormatTrainingCalendarRecord'])
			->where(['HrFormatTrainingCalendar.id' => $id])
			->first();

		if ($docEntity) {
			$docData = $docEntity->toArray();
			$docArr = ['HrFormatTrainingCalendar' => $docData];
			if ($docEntity->hr_format_training_calendar_record) {
				$docArr['HrFormatTrainingCalendarRecord'] = [];
				foreach ($docEntity->hr_format_training_calendar_record as $record) {
					$docArr['HrFormatTrainingCalendarRecord'][] = $record->toArray();
				}
			} else {
				$docArr['HrFormatTrainingCalendarRecord'] = [];
			}
			$this->set('docArr', $docArr);
		}
	}

	function hr_appraisal_form()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Appraisal Form');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->HrAppraisalForm->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'HrAppraisalFormRecord'
			])
			->where(['HrAppraisalForm.user_id' => $user_id])
			->orderDesc('HrAppraisalForm.id');

		$HrDuringLeaveArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$HrDuringLeaveArrArray = [];
		foreach ($HrDuringLeaveArr as $doc) {
			$docData = $doc->toArray();
			$result = ['HrAppraisalForm' => $docData];
			if (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->hr_appraisal_form_record) {
				$result['HrAppraisalFormRecord'] = [];
				foreach ($doc->hr_appraisal_form_record as $record) {
					$result['HrAppraisalFormRecord'][] = $record->toArray();
				}
			} else {
				$result['HrAppraisalFormRecord'] = [];
			}
			$HrDuringLeaveArrArray[] = $result;
		}
		$HrDuringLeaveArr = $HrDuringLeaveArrArray;

		$this->set('HrDuringLeaveArr', $HrDuringLeaveArr);
	}

	public function appraisal_form_edit($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Edit Appraisal Form');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrAppraisalForm']['id'] = $id;

			$entity = $this->HrAppraisalForm->get($id);
			$entity = $this->HrAppraisalForm->patchEntity($entity, $data['HrAppraisalForm'], ['validate' => false]);
			if ($this->HrAppraisalForm->save($entity)) {
				// Delete existing records
				$this->HrAppraisalFormRecord->deleteAll(['hr_id' => $id]);

				if (!empty($data['performance_criteria'])) {
					$i = 0;
					foreach ($data['performance_criteria'] as $performance_criteria) {
						$recordEntity = $this->HrAppraisalFormRecord->newEntity([
							'hr_id' => $id,
							'performance_criteria' => $performance_criteria,
							'rating' => !empty($data['rating'][$i]) ? $data['rating'][$i] : '',
							'applicabe_for' => !empty($data['applicabe_for'][$i]) ? $data['applicabe_for'][$i] : '',
							'rating_by_appraiser' => !empty($data['rating_by_appraiser'][$i]) ? $data['rating_by_appraiser'][$i] : ''
						], ['validate' => false]);
						$this->HrAppraisalFormRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Record edit successfully.');
				return $this->redirect(['action' => 'hr_appraisal_form']);
			}
		}

		$docEntity = $this->HrAppraisalForm->find()
			->contain(['HrAppraisalFormRecord'])
			->where(['HrAppraisalForm.id' => $id])
			->first();

		if ($docEntity) {
			$docData = $docEntity->toArray();
			$docArr = ['HrAppraisalForm' => $docData];
			if ($docEntity->hr_appraisal_form_record) {
				$docArr['HrAppraisalFormRecord'] = [];
				foreach ($docEntity->hr_appraisal_form_record as $record) {
					$docArr['HrAppraisalFormRecord'][] = $record->toArray();
				}
			} else {
				$docArr['HrAppraisalFormRecord'] = [];
			}
			$this->set('docArr', $docArr);
		}
	}

	public function appraisal_form_add()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Hr Add Appraisal Form');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['HrAppraisalForm']['user_id'] = $user_id;
			$data['HrAppraisalForm']['created'] = date('Y-m-d H:i:s');

			$entity = $this->HrAppraisalForm->newEntity($data['HrAppraisalForm'], ['validate' => false]);
			if ($this->HrAppraisalForm->save($entity)) {
				$lastinsrtId = $entity->id;

				if (!empty($data['performance_criteria'])) {
					$i = 0;
					foreach ($data['performance_criteria'] as $performance_criteria) {
						$recordEntity = $this->HrAppraisalFormRecord->newEntity([
							'hr_id' => $lastinsrtId,
							'performance_criteria' => $performance_criteria,
							'rating' => !empty($data['rating'][$i]) ? $data['rating'][$i] : '',
							'applicabe_for' => !empty($data['applicabe_for'][$i]) ? $data['applicabe_for'][$i] : '',
							'rating_by_appraiser' => !empty($data['rating_by_appraiser'][$i]) ? $data['rating_by_appraiser'][$i] : ''
						], ['validate' => false]);
						$this->HrAppraisalFormRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Record added successfully.');
				return $this->redirect(['action' => 'hr_appraisal_form']);
			}
		}

		$docEntity = $this->HrAppraisalForm->find()
			->orderDesc('HrAppraisalForm.id')
			->select(['HrAppraisalForm.id'])
			->first();
		$docArr = $docEntity ? ['HrAppraisalForm' => $docEntity->toArray()] : ['HrAppraisalForm' => ['id' => null]];
		if (!empty($docArr['HrAppraisalForm']['id'])) {
			$docId = 'DTPAF-' . (1000 + $docArr['HrAppraisalForm']['id'] + 1);
		} else {
			$docId = 'DTPAF-1001';
		}
		$this->set('docId', $docId);
	}
}
