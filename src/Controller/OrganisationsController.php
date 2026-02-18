<?php
namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;

/**
 * Organisations Controller
 */
class OrganisationsController extends AppController
{
	public function initialize(): void
	{
		parent::initialize();
		$this->loadComponent('Paginator');
		$this->loadModel('User');
		$this->loadModel('CircularRelation');
		$this->loadModel('CircularManagementReview');
		$this->loadModel('NappUser');
		$this->loadModel('Agenda');
		$this->loadModel('Department');
		$this->loadModel('Complaint');
		$this->loadModel('CircularAction');
	}

	public function beforeFilter(EventInterface $event): ?Response
	{
		$this->callConstants();
		return parent::beforeFilter($event);
	}

	// ========== CAMELCASE WRAPPERS FOR ADMIN METHODS ==========
	
	public function adminIndex()
	{
		return $this->admin_index();
	}

	public function adminResult($circular_id = null)
	{
		return $this->admin_result($circular_id);
	}

	public function adminDetail($complaint_id = null, $type = null)
	{
		return $this->admin_detail($complaint_id, $type);
	}

	// ========== ADMIN METHODS ==========

	function admin_index()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Complaint List');
		$this->checkAdminSession();

		$query = $this->CircularManagementReview->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'dept_id', 'name', 'lname'])
						->contain(['Department']);
				},
				'CircularRelation' => function($q) {
					return $q->contain([
						'NappUser' => function($q2) {
							return $q2->select(['id', 'dept_id', 'name', 'lname'])
								->contain(['Department']);
						}
					]);
				}
			])
			->orderDesc('CircularManagementReview.id');

		$circularArr = $this->paginate($query, ['limit' => 25]);

		// Convert entities to array format for view compatibility
		$circularArrArray = [];
		foreach ($circularArr as $circular) {
			$circularData = $circular->toArray();
			$result = ['CircularManagementReview' => $circularData];
			
			// Extract NappUser association
			if (isset($circular->napp_user) && $circular->napp_user) {
				$result['NappUser'] = $circular->napp_user->toArray();
				if (isset($circular->napp_user->department) && $circular->napp_user->department) {
					$result['NappUser']['Department'] = $circular->napp_user->department->toArray();
				} else {
					$result['NappUser']['Department'] = ['id' => null, 'department_title' => ''];
				}
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => '', 'Department' => ['id' => null, 'department_title' => '']];
			}
			
			// Extract CircularRelation association
			if ($circular->circular_relation) {
				$result['CircularRelation'] = [];
				foreach ($circular->circular_relation as $relation) {
					$relationData = $relation->toArray();
					if (isset($relation->napp_user) && $relation->napp_user) {
						$relationData['NappUser'] = $relation->napp_user->toArray();
						if (isset($relation->napp_user->department) && $relation->napp_user->department) {
							$relationData['NappUser']['Department'] = $relation->napp_user->department->toArray();
						} else {
							$relationData['NappUser']['Department'] = ['id' => null, 'department_title' => ''];
						}
					} else {
						$relationData['NappUser'] = ['id' => null, 'name' => '', 'lname' => '', 'Department' => ['id' => null, 'department_title' => '']];
					}
					$result['CircularRelation'][] = $relationData;
				}
			} else {
				$result['CircularRelation'] = [];
			}
			
			$circularArrArray[] = $result;
		}
		$circularArr = $circularArrArray;

		$this->set('circularArr', $circularArr);
	}

	function admin_result($circular_id = null)
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Result Page');
		$this->checkAdminSession();

		$emp_id = $this->request->getSession()->read('Customer.id');
		
		$reviewArr = $this->CircularAction->find()
			->where(['CircularAction.circular_id' => $circular_id])
			->toArray();
		$reviewArrArray = [];
		foreach ($reviewArr as $review) {
			$reviewArrArray[] = ['CircularAction' => $review->toArray()];
		}
		$this->set('reviewArr', $reviewArrArray);

		$CircularManagementReviewEntity = $this->CircularManagementReview->find()
			->contain([
				'CircularRelation' => function($q) {
					return $q->contain([
						'NappUser' => function($q2) {
							return $q2->select(['id', 'dept_id', 'name', 'lname'])
								->contain(['Department']);
						}
					]);
				}
			])
			->where(['CircularManagementReview.id' => $circular_id])
			->first();

		if (empty($CircularManagementReviewEntity)) {
			return $this->redirect(['action' => 'circular']);
		}

		$circularData = $CircularManagementReviewEntity->toArray();
		$CircularManagementReviewArr = ['CircularManagementReview' => $circularData];
		if ($CircularManagementReviewEntity->circular_relation) {
			$CircularManagementReviewArr['CircularRelation'] = [];
			foreach ($CircularManagementReviewEntity->circular_relation as $relation) {
				$relationData = $relation->toArray();
				if (isset($relation->napp_user) && $relation->napp_user) {
					$relationData['NappUser'] = $relation->napp_user->toArray();
					if (isset($relation->napp_user->department) && $relation->napp_user->department) {
						$relationData['NappUser']['Department'] = $relation->napp_user->department->toArray();
					} else {
						$relationData['NappUser']['Department'] = ['id' => null, 'department_title' => ''];
					}
				} else {
					$relationData['NappUser'] = ['id' => null, 'name' => '', 'lname' => '', 'Department' => ['id' => null, 'department_title' => '']];
				}
				$CircularManagementReviewArr['CircularRelation'][] = $relationData;
			}
		} else {
			$CircularManagementReviewArr['CircularRelation'] = [];
		}
		$this->set('CircularManagementReviewArr', $CircularManagementReviewArr);

		$NappUserEntities = $this->NappUser->find()
			->contain(['Department'])
			->where(['NappUser.id !=' => $emp_id, 'NappUser.is_staff_id' => 1])
			->toArray();
		$NappUser = [];
		foreach ($NappUserEntities as $entity) {
			$userData = $entity->toArray();
			if (isset($entity->department) && $entity->department) {
				$userData['Department'] = $entity->department->toArray();
			} else {
				$userData['Department'] = ['id' => null, 'department_title' => ''];
			}
			$NappUser[] = ['NappUser' => $userData];
		}
		$this->set('NappUser', $NappUser);

		$AgendaEntities = $this->Agenda->find()->toArray();
		$AgendaArr = [];
		foreach ($AgendaEntities as $entity) {
			$AgendaArr[] = ['Agenda' => $entity->toArray()];
		}
		$this->set('AgendaArr', $AgendaArr);
	}

	function admin_detail($complaint_id = null, $type = null)
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Complaint List');
		$this->checkAdminSession();

		$complaint_id = base64_decode($complaint_id);
		
		$ComplaintEntity = $this->Complaint->find()
			->contain([
				'Department',
				'ComplaintType',
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'NappUser1' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				}
			])
			->where(['Complaint.complaint_id' => $complaint_id])
			->first();

		if ($ComplaintEntity) {
			$complaintData = $ComplaintEntity->toArray();
			$ComplaintArr = ['Complaint' => $complaintData];
			if (isset($ComplaintEntity->department) && $ComplaintEntity->department) {
				$ComplaintArr['Department'] = $ComplaintEntity->department->toArray();
			} else {
				$ComplaintArr['Department'] = [];
			}
			if (isset($ComplaintEntity->complaint_type) && $ComplaintEntity->complaint_type) {
				$ComplaintArr['ComplaintType'] = $ComplaintEntity->complaint_type->toArray();
			} else {
				$ComplaintArr['ComplaintType'] = [];
			}
			if (isset($ComplaintEntity->napp_user) && $ComplaintEntity->napp_user) {
				$ComplaintArr['NappUser'] = $ComplaintEntity->napp_user->toArray();
			} else {
				$ComplaintArr['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if (isset($ComplaintEntity->napp_user1) && $ComplaintEntity->napp_user1) {
				$ComplaintArr['NappUser1'] = $ComplaintEntity->napp_user1->toArray();
			} else {
				$ComplaintArr['NappUser1'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			$this->set('ComplaintArr', $ComplaintArr);
		}
		$this->set('type', $type);
	}

	// ========== PUBLIC METHODS ==========

	function index()
	{
		$this->autoRender = false;
		return $this->redirect(['action' => 'circular']);
	}

	function circular()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Circular Management Review List');
		$this->checkSatffSession();
		$emp_id = $this->request->getSession()->read('Customer.id');

		$CircularRelationList = $this->CircularRelation->find('list', [
			'keyField' => 'circular_id',
			'valueField' => 'circular_id'
		])
		->where(['CircularRelation.emp_id' => $emp_id])
		->toArray();
		$CircularRelation = array_values($CircularRelationList);

		$query = $this->CircularManagementReview->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'dept_id', 'name', 'lname'])
						->contain(['Department']);
				},
				'CircularRelation' => function($q) {
					return $q->contain([
						'NappUser' => function($q2) {
							return $q2->select(['id', 'dept_id', 'name', 'lname'])
								->contain(['Department']);
						}
					]);
				}
			])
			->where(function($exp, $q) use ($emp_id, $CircularRelation) {
				return $exp->or_([
					'CircularManagementReview.emp_id' => $emp_id,
					'CircularManagementReview.id IN' => $CircularRelation
				]);
			})
			->orderDesc('CircularManagementReview.id');

		$circularArr = $this->paginate($query, ['limit' => 25]);

		// Convert entities to array format for view compatibility
		$circularArrArray = [];
		foreach ($circularArr as $circular) {
			$circularData = $circular->toArray();
			$result = ['CircularManagementReview' => $circularData];
			
			// Extract NappUser association
			if (isset($circular->napp_user) && $circular->napp_user) {
				$result['NappUser'] = $circular->napp_user->toArray();
				if (isset($circular->napp_user->department) && $circular->napp_user->department) {
					$result['NappUser']['Department'] = $circular->napp_user->department->toArray();
				} else {
					$result['NappUser']['Department'] = ['id' => null, 'department_title' => ''];
				}
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => '', 'Department' => ['id' => null, 'department_title' => '']];
			}
			
			// Extract CircularRelation association
			if ($circular->circular_relation) {
				$result['CircularRelation'] = [];
				foreach ($circular->circular_relation as $relation) {
					$relationData = $relation->toArray();
					if (isset($relation->napp_user) && $relation->napp_user) {
						$relationData['NappUser'] = $relation->napp_user->toArray();
						if (isset($relation->napp_user->department) && $relation->napp_user->department) {
							$relationData['NappUser']['Department'] = $relation->napp_user->department->toArray();
						} else {
							$relationData['NappUser']['Department'] = ['id' => null, 'department_title' => ''];
						}
					} else {
						$relationData['NappUser'] = ['id' => null, 'name' => '', 'lname' => '', 'Department' => ['id' => null, 'department_title' => '']];
					}
					$result['CircularRelation'][] = $relationData;
				}
			} else {
				$result['CircularRelation'] = [];
			}
			
			$circularArrArray[] = $result;
		}
		$circularArr = $circularArrArray;

		$this->set('circularArr', $circularArr);
		$this->set('emp_id', $emp_id);
	}

	function edit($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Circular Management Review List');
		$this->checkSatffSession();
		$emp_id = $this->request->getSession()->read('Customer.id');

		$CircularManagementReviewEntity = $this->CircularManagementReview->find()
			->contain(['CircularRelation'])
			->where(['CircularManagementReview.emp_id' => $emp_id, 'CircularManagementReview.id' => $id])
			->first();

		if (empty($CircularManagementReviewEntity)) {
			return $this->redirect(['action' => 'circular']);
		}

		$circularData = $CircularManagementReviewEntity->toArray();
		$CircularManagementReviewArr = ['CircularManagementReview' => $circularData];
		if ($CircularManagementReviewEntity->circular_relation) {
			$CircularManagementReviewArr['CircularRelation'] = [];
			foreach ($CircularManagementReviewEntity->circular_relation as $relation) {
				$CircularManagementReviewArr['CircularRelation'][] = $relation->toArray();
			}
		} else {
			$CircularManagementReviewArr['CircularRelation'] = [];
		}
		$this->set('CircularManagementReviewArr', $CircularManagementReviewArr);

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			
			$agendId = '';
			if (!empty($data['agendId'])) {
				foreach ($data['agendId'] as $agendIds) {
					$agendId .= $agendIds . '##';
				}
			}

			$entity = $this->CircularManagementReview->get($id);
			$entity = $this->CircularManagementReview->patchEntity($entity, [
				'admin_id' => 2,
				'emp_id' => $emp_id,
				'agenda' => $agendId,
				'date' => $data['Organisation']['date'] ?? null,
				'start_time' => $data['Organisation']['start_time'] ?? null,
				'end_time' => $data['Organisation']['end_time'] ?? null,
				'created' => date('Y-m-d H:i:s')
			], ['validate' => false]);

			if ($this->CircularManagementReview->save($entity)) {
				$CircularManagementReview_id = $entity->id;
				
				// Delete existing relations
				$this->CircularRelation->deleteAll(['circular_id' => $id]);

				if (!empty($data['emp_id'])) {
					foreach ($data['emp_id'] as $emp_ids) {
						$relationEntity = $this->CircularRelation->newEntity([
							'emp_id' => $emp_ids,
							'circular_id' => $CircularManagementReview_id
						], ['validate' => false]);
						$this->CircularRelation->save($relationEntity);
					}
				}

				return $this->redirect(['action' => 'circular']);
			}
		}

		$NappUserEntities = $this->NappUser->find()
			->contain(['Department'])
			->where(['NappUser.id !=' => $emp_id, 'NappUser.is_staff_id' => 1])
			->toArray();
		$NappUser = [];
		foreach ($NappUserEntities as $entity) {
			$userData = $entity->toArray();
			if (isset($entity->department) && $entity->department) {
				$userData['Department'] = $entity->department->toArray();
			} else {
				$userData['Department'] = ['id' => null, 'department_title' => ''];
			}
			$NappUser[] = ['NappUser' => $userData];
		}
		$this->set('NappUser', $NappUser);

		$AgendaEntities = $this->Agenda->find()->toArray();
		$AgendaArr = [];
		foreach ($AgendaEntities as $entity) {
			$AgendaArr[] = ['Agenda' => $entity->toArray()];
		}
		$this->set('AgendaArr', $AgendaArr);
	}

	function result($circular_id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Result Page');
		$this->checkSatffSession();
		$emp_id = $this->request->getSession()->read('Customer.id');

		$reviewArr = $this->CircularAction->find()
			->where(['CircularAction.circular_id' => $circular_id])
			->toArray();
		$reviewArrArray = [];
		foreach ($reviewArr as $review) {
			$reviewArrArray[] = ['CircularAction' => $review->toArray()];
		}
		$this->set('reviewArr', $reviewArrArray);

		$CircularManagementReviewEntity = $this->CircularManagementReview->find()
			->contain([
				'CircularRelation' => function($q) {
					return $q->contain([
						'NappUser' => function($q2) {
							return $q2->select(['id', 'dept_id', 'name', 'lname'])
								->contain(['Department']);
						}
					]);
				}
			])
			->where(['CircularManagementReview.id' => $circular_id])
			->first();

		if (empty($CircularManagementReviewEntity)) {
			return $this->redirect(['action' => 'circular']);
		}

		$circularData = $CircularManagementReviewEntity->toArray();
		$CircularManagementReviewArr = ['CircularManagementReview' => $circularData];
		if ($CircularManagementReviewEntity->circular_relation) {
			$CircularManagementReviewArr['CircularRelation'] = [];
			foreach ($CircularManagementReviewEntity->circular_relation as $relation) {
				$relationData = $relation->toArray();
				if (isset($relation->napp_user) && $relation->napp_user) {
					$relationData['NappUser'] = $relation->napp_user->toArray();
					if (isset($relation->napp_user->department) && $relation->napp_user->department) {
						$relationData['NappUser']['Department'] = $relation->napp_user->department->toArray();
					} else {
						$relationData['NappUser']['Department'] = ['id' => null, 'department_title' => ''];
					}
				} else {
					$relationData['NappUser'] = ['id' => null, 'name' => '', 'lname' => '', 'Department' => ['id' => null, 'department_title' => '']];
				}
				$CircularManagementReviewArr['CircularRelation'][] = $relationData;
			}
		} else {
			$CircularManagementReviewArr['CircularRelation'] = [];
		}
		$this->set('CircularManagementReviewArr', $CircularManagementReviewArr);

		$NappUserEntities = $this->NappUser->find()
			->contain(['Department'])
			->where(['NappUser.id !=' => $emp_id, 'NappUser.is_staff_id' => 1])
			->toArray();
		$NappUser = [];
		foreach ($NappUserEntities as $entity) {
			$userData = $entity->toArray();
			if (isset($entity->department) && $entity->department) {
				$userData['Department'] = $entity->department->toArray();
			} else {
				$userData['Department'] = ['id' => null, 'department_title' => ''];
			}
			$NappUser[] = ['NappUser' => $userData];
		}
		$this->set('NappUser', $NappUser);

		$AgendaEntities = $this->Agenda->find()->toArray();
		$AgendaArr = [];
		foreach ($AgendaEntities as $entity) {
			$AgendaArr[] = ['Agenda' => $entity->toArray()];
		}
		$this->set('AgendaArr', $AgendaArr);
	}

	function closemom($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Close Mintues of Meeting');
		$this->checkSatffSession();
		$emp_id = $this->request->getSession()->read('Customer.id');

		$CircularManagementReviewEntity = $this->CircularManagementReview->find()
			->contain(['CircularRelation'])
			->where(['CircularManagementReview.emp_id' => $emp_id, 'CircularManagementReview.id' => $id])
			->first();

		if (empty($CircularManagementReviewEntity)) {
			return $this->redirect(['action' => 'circular']);
		}

		$circularData = $CircularManagementReviewEntity->toArray();
		$CircularManagementReviewArr = ['CircularManagementReview' => $circularData];
		if ($CircularManagementReviewEntity->circular_relation) {
			$CircularManagementReviewArr['CircularRelation'] = [];
			foreach ($CircularManagementReviewEntity->circular_relation as $relation) {
				$CircularManagementReviewArr['CircularRelation'][] = $relation->toArray();
			}
		} else {
			$CircularManagementReviewArr['CircularRelation'] = [];
		}
		$this->set('CircularManagementReviewArr', $CircularManagementReviewArr);

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$meeting_id = $CircularManagementReviewArr['CircularManagementReview']['meeting_id'];

			if (!empty($data['title'])) {
				// Delete existing actions
				$this->CircularAction->deleteAll(['circular_id' => $id]);

				for ($i = 1; $i <= count($data['title']); $i++) {
					$name = $this->request->getSession()->read('Customer.name') . ' ' . $this->request->getSession()->read('Customer.lname');
					$actionEntity = $this->CircularAction->newEntity([
						'circular_id' => $id,
						'agenda' => $data['title'][$i] ?? '',
						'description' => $data['description'][$i] ?? '',
						'responsiblity' => $data['responsiblity'][$i] ?? '',
						'time_frame' => $data['time_frame'][$i] ?? '',
						'added_by' => $name,
						'created' => date('Y-m-d H:i:s')
					], ['validate' => false]);
					$this->CircularAction->save($actionEntity);
				}

				// Update status
				$updateEntity = $this->CircularManagementReview->get($id);
				$updateEntity = $this->CircularManagementReview->patchEntity($updateEntity, [
					'status' => 1,
					'start_time' => $data['Organisation']['start_time'] ?? null,
					'end_time' => $data['Organisation']['end_time'] ?? null
				], ['validate' => false]);
				$this->CircularManagementReview->save($updateEntity);

				if (!empty($CircularManagementReviewArr['CircularRelation'])) {
					foreach ($CircularManagementReviewArr['CircularRelation'] as $CircularManagementReviewArrs) {
						$NappUserEntity = $this->NappUser->find()
							->where(['NappUser.id' => $CircularManagementReviewArrs['emp_id']])
							->first();
						if ($NappUserEntity) {
							$user_id = $NappUserEntity->id;
							$to_email = $NappUserEntity->email;
							$to_name = $NappUserEntity->name . ' ' . $NappUserEntity->lname;
							$subject = SITENAME . " :: Mintue Of Meeting(#" . $meeting_id . ") Finished";
							$template_name = 'finish_mintue_of_meeting';
							$url = SITEURL . 'organisations/autologin/' . base64_encode((string)$user_id);
							$variables = ['to_name' => $to_name, 'meeting_id' => $meeting_id, 'url' => $url];
							try {
								$this->sendemail($to_email, $subject, $template_name, $variables);
							} catch (\Exception $e) {
								// Email sending failed, continue
							}
						}
					}
				}

				return $this->redirect(['action' => 'circular']);
			}
		}

		$NappUserEntities = $this->NappUser->find()
			->contain(['Department'])
			->where(['NappUser.id !=' => $emp_id, 'NappUser.is_staff_id' => 1])
			->toArray();
		$NappUser = [];
		foreach ($NappUserEntities as $entity) {
			$userData = $entity->toArray();
			if (isset($entity->department) && $entity->department) {
				$userData['Department'] = $entity->department->toArray();
			} else {
				$userData['Department'] = ['id' => null, 'department_title' => ''];
			}
			$NappUser[] = ['NappUser' => $userData];
		}
		$this->set('NappUser', $NappUser);

		$AgendaEntities = $this->Agenda->find()->toArray();
		$AgendaArr = [];
		foreach ($AgendaEntities as $entity) {
			$AgendaArr[] = ['Agenda' => $entity->toArray()];
		}
		$this->set('AgendaArr', $AgendaArr);
	}

	function autologin($user_id = null)
	{
		$this->autoRender = false;

		$decoded_id = base64_decode($user_id);
		$NappUserEntity = $this->NappUser->find()
			->where(['NappUser.id' => $decoded_id])
			->first();

		if ($NappUserEntity) {
			$this->request->getSession()->write('Customer', $NappUserEntity->toArray());
			$this->request->getSession()->write('is_customer', 1);
			return $this->redirect(['action' => 'circular']);
		} else {
			return $this->redirect('/login');
		}
	}

	function add()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Circular Management Review List');
		$this->checkSatffSession();
		$emp_id = $this->request->getSession()->read('Customer.id');

		$cname = $this->request->getSession()->read('Customer.name') . ' ' . $this->request->getSession()->read('Customer.lname');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();

			$circularEntity = $this->CircularManagementReview->find()
				->orderDesc('CircularManagementReview.id')
				->first();
			$meeting_id = 1000 + ($circularEntity ? $circularEntity->id : 0) + 1;
			$meeting_id = 'MM-' . $meeting_id;

			$agendId = '';
			if (!empty($data['agendId'])) {
				foreach ($data['agendId'] as $agendIds) {
					$agendId .= $agendIds . '##';
				}
			}

			$entity = $this->CircularManagementReview->newEntity([
				'admin_id' => 2,
				'meeting_id' => $meeting_id,
				'emp_id' => $emp_id,
				'agenda' => $agendId,
				'date' => $data['Organisation']['date'] ?? null,
				'start_time' => $data['Organisation']['start_time'] ?? null,
				'end_time' => $data['Organisation']['end_time'] ?? null,
				'extra' => $data['Organisation']['extra'] ?? null,
				'created' => date('Y-m-d H:i:s')
			], ['validate' => false]);

			if ($this->CircularManagementReview->save($entity)) {
				$CircularManagementReview_id = $entity->id;

				if (!empty($data['emp_id'])) {
					foreach ($data['emp_id'] as $emp_ids) {
						$relationEntity = $this->CircularRelation->newEntity([
							'emp_id' => $emp_ids,
							'circular_id' => $CircularManagementReview_id
						], ['validate' => false]);
						$this->CircularRelation->save($relationEntity);

						$NappUserEntity = $this->NappUser->find()
							->where(['NappUser.id' => $emp_ids])
							->first();
						if ($NappUserEntity) {
							$user_id = $NappUserEntity->id;
							$to_email = $NappUserEntity->email;
							$to_name = $NappUserEntity->name . ' ' . $NappUserEntity->lname;
							$subject = SITENAME . " :: Schedule mintue of meeting";
							$template_name = 'mintue_of_meeting';
							$url = SITEURL . 'organisations/autologin/' . base64_encode((string)$user_id);
							$date = date('d M Y', strtotime($data['Organisation']['date'] ?? 'now'));
							$time = ($data['Organisation']['start_time'] ?? '') . ' ' . ($data['Organisation']['end_time'] ?? '');
							$variables = ['to_name' => $to_name, 'meeting_id' => $meeting_id, 'cname' => $cname, 'date' => $date, 'time' => $time, 'url' => $url];
							try {
								$this->sendemail($to_email, $subject, $template_name, $variables);
							} catch (\Exception $e) {
								// Email sending failed, continue
							}
						}
					}
				}

				return $this->redirect(['action' => 'circular']);
			}
		}

		$NappUserEntities = $this->NappUser->find()
			->contain(['Department'])
			->where(['NappUser.id !=' => $emp_id, 'NappUser.is_staff_id' => 1])
			->toArray();
		$NappUser = [];
		foreach ($NappUserEntities as $entity) {
			$userData = $entity->toArray();
			if (isset($entity->department) && $entity->department) {
				$userData['Department'] = $entity->department->toArray();
			} else {
				$userData['Department'] = ['id' => null, 'department_title' => ''];
			}
			$NappUser[] = ['NappUser' => $userData];
		}
		$this->set('NappUser', $NappUser);

		$AgendaEntities = $this->Agenda->find()->toArray();
		$AgendaArr = [];
		foreach ($AgendaEntities as $entity) {
			$AgendaArr[] = ['Agenda' => $entity->toArray()];
		}
		$this->set('AgendaArr', $AgendaArr);
	}
}
