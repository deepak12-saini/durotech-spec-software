<?php
namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Complaints Controller
 */
class ComplaintsController extends AppController
{
	public function initialize(): void
	{
		parent::initialize();
		// Load models explicitly (CakePHP 3 doesn't support $uses)
		$this->loadModel('User');
		$this->loadModel('PaymentSetup');
		$this->loadModel('Category');
		$this->loadModel('Product');
		$this->loadModel('Subscriber');
		$this->loadModel('Contact');
		$this->loadModel('Staff');
		$this->loadModel('NappUser');
		$this->loadModel('UserAnswer');
		$this->loadModel('LabFile');
		$this->loadModel('LabAssign');
		$this->loadModel('Coupon');
		$this->loadModel('UserPermission');
		$this->loadModel('Conformance');
		$this->loadModel('Department');
		$this->loadModel('ComplaintType');
		$this->loadModel('Complaint');
		$this->loadModel('ConformanceRelation');
	}

	public function beforeFilter(EventInterface $event): ?Response
	{
		$this->callConstants();
		return parent::beforeFilter($event);
	}

	function detail($complaint_id = null, $type = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Complaint List');
		$this->checkSatffSession();
		$emp_id = $this->request->getSession()->read('Customer.id');
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

		if (!$ComplaintEntity) {
			$this->Flash->error('Complaint not found');
			return $this->redirect(['action' => 'index']);
		}

		// Convert to array format for view compatibility
		$ComplaintArr = ['Complaint' => $ComplaintEntity->toArray()];
		if ($ComplaintEntity->department) {
			$ComplaintArr['Department'] = $ComplaintEntity->department->toArray();
		}
		if ($ComplaintEntity->ComplaintType) {
			$ComplaintArr['ComplaintType'] = $ComplaintEntity->ComplaintType->toArray();
		}
		if ($ComplaintEntity->napp_user) {
			$ComplaintArr['NappUser'] = $ComplaintEntity->napp_user->toArray();
		}
		if ($ComplaintEntity->napp_user1) {
			$ComplaintArr['NappUser1'] = $ComplaintEntity->napp_user1->toArray();
		}

		$this->set('ComplaintArr', $ComplaintArr);
		$this->set('type', $type);
	}

	function index()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Complaint List');
		$this->checkSatffSession();
		$emp_id = $this->request->getSession()->read('Customer.id');

		$complaint_id = '';
		$complaint_type = '';

		$query = $this->Complaint->find()
			->contain([
				'Department',
				'ComplaintType',
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'NappUser1' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'Conformance'
			]);

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$complaint_type = isset($data['complaint_type']) ? $data['complaint_type'] : '';
			$complaint_id = isset($data['complaint_id']) ? $data['complaint_id'] : '';

			if (!empty($complaint_id)) {
				$query->where(['Complaint.complaint_id' => $complaint_id]);
			} elseif (!empty($complaint_type)) {
				$query->where(['Complaint.complaint_type' => $complaint_type]);
			}
		}

		$query->orderDesc('Complaint.id');

		$ComplaintArr = $this->paginate($query, ['limit' => 25]);

		// Convert entities to array format for view compatibility
		$ComplaintArrArray = [];
		foreach ($ComplaintArr as $complaint) {
			$complaintData = $complaint->toArray();
			$result = ['Complaint' => $complaintData];
			if ($complaint->department) {
				$result['Department'] = $complaint->department->toArray();
			}
			if ($complaint->ComplaintType) {
				$result['ComplaintType'] = $complaint->ComplaintType->toArray();
			}
			if ($complaint->napp_user) {
				$result['NappUser'] = $complaint->napp_user->toArray();
			}
			if ($complaint->napp_user1) {
				$result['NappUser1'] = $complaint->napp_user1->toArray();
			}
			// Always set Conformance array, even if empty
			$result['Conformance'] = [];
			if ($complaint->conformance && !empty($complaint->conformance)) {
				foreach ($complaint->conformance as $conf) {
					$result['Conformance'][] = $conf->toArray();
				}
			}
			$ComplaintArrArray[] = $result;
		}
		$ComplaintArr = $ComplaintArrArray;

		$this->set('ComplaintArr', $ComplaintArr);
		$this->set('complaint_id', $complaint_id);
		$this->set('emp_id', $emp_id);
		$this->set('complaint_type', $complaint_type);

		$ComplaintTypeEntities = $this->ComplaintType->find()->toArray();
		$ComplaintType = [];
		foreach ($ComplaintTypeEntities as $entity) {
			$ComplaintType[] = ['ComplaintType' => $entity->toArray()];
		}
		$this->set('ComplaintType', $ComplaintType);
	}

	function adminAutologin($complaint_id = null, $user_id = null)
	{
		$this->autoRender = false;

		$ComplaintEntity = $this->Complaint->find()
			->where(['Complaint.id' => $complaint_id])
			->first();

		if (!empty($ComplaintEntity)) {
			$decoded_user_id = !empty($user_id) ? base64_decode($user_id) : 2;
			$userEntity = $this->User->find()
				->where(['User.id' => $decoded_user_id])
				->first();

			if (!empty($userEntity)) {
				$this->request->getSession()->write('User', $userEntity->toArray());
				$this->request->getSession()->write('is_admin', 1);
				return $this->redirect('/admin/complaints/detail/' . base64_encode($ComplaintEntity->complaint_id));
			}
		}
		return $this->redirect('/admin');
	}

	function adminIsapproveddisapproved($type = null, $complaint_id = null, $user_id = null)
	{
		$this->autoRender = false;

		$userEntity = $this->User->find()
			->where(['User.id' => base64_decode($user_id)])
			->first();

		if (!empty($userEntity)) {
			$this->request->getSession()->write('User', $userEntity->toArray());
			$this->request->getSession()->write('is_admin', 1);
			$name = $userEntity->name;
			$email = $userEntity->email;

			$ComplaintEntity = $this->Complaint->find()
				->where(['Complaint.complaint_id' => $complaint_id])
				->first();

			if (!$ComplaintEntity) {
				$this->Flash->error('Complaint not found');
				return $this->redirect('/admin/complaints');
			}

			$complaintid = $ComplaintEntity->id;
			$complaint_to = $ComplaintEntity->complaint_to;
			$emp_id = $ComplaintEntity->emp_id;
			$dept_id = $ComplaintEntity->dept_id;
			$reason_for_complaint = $ComplaintEntity->reason_for_complaint;

			$ConformanceEntity = $this->Conformance->find()
				->contain(['User'])
				->where(['Conformance.complaintid' => $complaintid])
				->first();

			if ($ComplaintEntity->is_approve_descline == 1) {
				$userName = $ConformanceEntity && $ConformanceEntity->user ? $ConformanceEntity->user->name : 'Unknown';
				$this->Flash->success('Already raised non-conformance by ' . $userName);
				return $this->redirect('/admin/staffs/conformancelist');
			} elseif ($ComplaintEntity->is_approve_descline == 2) {
				$userName = $ConformanceEntity && $ConformanceEntity->user ? $ConformanceEntity->user->name : 'Unknown';
				$this->Flash->success('Already declined non-conformance request by ' . $userName);
				return $this->redirect('/admin/complaints');
			} elseif (($ComplaintEntity->is_approve_descline == 0) && ($type == 1)) {
				// approved
				$entity = $this->Complaint->get($complaintid);
				$entity = $this->Complaint->patchEntity($entity, ['is_approve_descline' => $type], ['validate' => false]);
				$this->Complaint->save($entity);

				if (empty($ConformanceEntity)) {
					$confirmArr = $this->Conformance->find()
						->orderDesc('Conformance.id')
						->first();

					$randnumber = $confirmArr ? (1000 + $confirmArr->id) : 1000;
					$dtncid = 'DT-NC-' . $randnumber;

					$conformanceData = [
						'nc_number' => $dtncid,
						'complaintid' => $complaintid,
						'non_conforance' => $reason_for_complaint,
						'dept_id' => $dept_id,
						'admin_id' => base64_decode($user_id),
						'compaint_by' => $emp_id,
						'compaint_to' => $complaint_to,
						'date_of_complaint' => date('Y-m-d'),
						'status' => 0,
						'created' => date('Y-m-d H:i:s')
					];

					$conformanceEntity = $this->Conformance->newEntity($conformanceData, ['validate' => false]);
					$this->Conformance->save($conformanceEntity);
					$conformance_id = $conformanceEntity->id;

					$NappUserEntity = $this->NappUser->find()
						->where(['NappUser.id' => $complaint_to])
						->first();

					if ($NappUserEntity) {
						$to_email = $NappUserEntity->email;
						$to_name = $NappUserEntity->name;
						$subject = SITENAME . " :: Non Conformance DT-NC-" . $randnumber . " By " . ucfirst($name);
						$template_name = 'conformance';
						$non_conforance = $reason_for_complaint;
						$variables = ['name' => $name, 'to_name' => $to_name, 'title' => $non_conforance];
						try {
							$this->sendemail($to_email, $subject, $template_name, $variables);
						} catch (\Exception $e) {
							// Silent fail
						}
					}

					$NappUserEntity2 = $this->NappUser->find()
						->where(['NappUser.id' => $emp_id])
						->first();

					if ($NappUserEntity2) {
						$to_email = $NappUserEntity2->email;
						$to_name = $NappUserEntity2->name;
						$subject = SITENAME . " :: Non Conformance DT-NC-" . $randnumber . " By " . ucfirst($name);
						$template_name = 'userconformance';
						$non_conforance = $reason_for_complaint;
						$variables = ['name' => $name, 'to_name' => $to_name, 'title' => $non_conforance];
						try {
							$this->sendemail($to_email, $subject, $template_name, $variables);
						} catch (\Exception $e) {
							// Silent fail
						}
					}

					// assign to
					$conformanceRelation1 = $this->ConformanceRelation->newEntity([
						'conformance_id' => $conformance_id,
						'emp_id' => $complaint_to
					], ['validate' => false]);
					$this->ConformanceRelation->save($conformanceRelation1);

					// assign by
					$conformanceRelation2 = $this->ConformanceRelation->newEntity([
						'conformance_id' => $conformance_id,
						'emp_id' => $emp_id
					], ['validate' => false]);
					$this->ConformanceRelation->save($conformanceRelation2);

					return $this->redirect('/admin/staffs/replyto/' . base64_encode((string)$conformance_id));
				} else {
					return $this->redirect('/admin/complaints');
				}
			} elseif ($type == 2) {
				// declined
				$entity = $this->Complaint->get($complaintid);
				$entity = $this->Complaint->patchEntity($entity, ['is_approve_descline' => $type], ['validate' => false]);
				$this->Complaint->save($entity);

				$NappUserEntity = $this->NappUser->find()
					->where(['NappUser.id' => $emp_id])
					->first();

				if ($NappUserEntity) {
					$to_email = $NappUserEntity->email;
					$to_name = $NappUserEntity->name;
					$subject = SITENAME . " :: Your request for non-conformance(" . $complaint_id . ") has been declined";
					$template_name = 'declined';
					$variables = ['name' => $name, 'to_name' => $to_name, 'reason_for_complaint' => $reason_for_complaint, 'complaint_id' => $complaint_id];
					try {
						$this->sendemail($to_email, $subject, $template_name, $variables);
					} catch (\Exception $e) {
						// Silent fail
					}
				}
				$this->Flash->success('Non conformance request has been declined');
				return $this->redirect('/admin/complaints');
			}
		} else {
			$this->Flash->success('Complaint created successfully');
			return $this->redirect('/admin');
		}
	}

	function requesttoraisenc($complaintId = null)
	{
		$this->checkSatffSession();
		$this->autoRender = false;
		$cname = $this->request->getSession()->read('Customer.name') . ' ' . $this->request->getSession()->read('Customer.lname');
		$complaintId = base64_decode($complaintId);

		$ComplaintEntity = $this->Complaint->find()
			->contain(['ComplaintType'])
			->where(['Complaint.complaint_id' => $complaintId])
			->first();

		if (!empty($ComplaintEntity)) {
			$userEntities = $this->User->find()
				->where(['User.id >' => 1])
				->toArray();

			if (!empty($userEntities)) {
				foreach ($userEntities as $userEntity) {
					$email = $userEntity->email;
					$name = $userEntity->name;
					$user_id = $userEntity->id;
					if (!empty($email)) {
						$complaint_id = $ComplaintEntity->complaint_id;
						$approved = SITEURL . 'admin/complaints/isapproveddisapproved/1/' . $complaint_id . '/' . base64_encode((string)$user_id);
						$disapproved = SITEURL . 'admin/complaints/isapproveddisapproved/2/' . $complaint_id . '/' . base64_encode((string)$user_id);
						$to_email = $userEntity->email;
						$subject = SITENAME . " :: " . $cname . " want to raise non conformance";
						$template_name = 'requestcomplaint';
						$complaintTypeTitle = $ComplaintEntity->ComplaintType ? $ComplaintEntity->ComplaintType->title : '';
						$variables = [
							'reason_for_complaint' => $ComplaintEntity->reason_for_complaint,
							'complainttype' => $complaintTypeTitle,
							'complaint_id' => $complaint_id,
							'name' => $this->request->getSession()->read('Customer.name'),
							'to_name' => $name,
							'disapproved' => $disapproved,
							'approved' => $approved
						];
						try {
							$this->sendemail($to_email, $subject, $template_name, $variables);
						} catch (\Exception $e) {
							// Silent fail
						}
					}
				}
				$this->Flash->success('Non conformance request has been sent successfully.');
				return $this->redirect(['action' => 'index']);
			}
			return $this->redirect(['action' => 'index']);
		} else {
			return $this->redirect(['action' => 'index']);
		}
	}

	function add()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Add Complaint');
		$this->checkSatffSession();
		$emp_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();

			if (!empty($_FILES['file']['name'])) {
				$filename = time() . $_FILES['file']['name'];
				$tmp_name = $_FILES['file']['tmp_name'];
				$uploadDir = WWW_ROOT . 'complaint' . DS;
				if (!is_dir($uploadDir)) {
					mkdir($uploadDir, 0755, true);
				}
				move_uploaded_file($tmp_name, $uploadDir . $filename);
				$data['Complaint']['document'] = $filename;
			}

			$confirm = $this->Complaint->find()
				->orderDesc('Complaint.id')
				->first();
			$complaintid = $confirm ? (1000 + $confirm->id) : 1000;

			$complaintData = [
				'complaint_id' => 'DTC-' . $complaintid,
				'other' => isset($data['Complaint']['other']) ? $data['Complaint']['other'] : null,
				'emp_id' => $emp_id,
				'created' => date('Y-m-d H:i:s')
			];

			if (isset($data['Complaint'])) {
				$complaintData = array_merge($complaintData, $data['Complaint']);
			}

			if (isset($data['Complaint']['is_non_conformance']) && $data['Complaint']['is_non_conformance'] == 2) {
				$complaintData['actioned_by_date'] = '0000-00-00';
			}

			$entity = $this->Complaint->newEntity($complaintData, ['validate' => false]);
			if ($this->Complaint->save($entity)) {
				$complaint_id = $entity->id;
				$this->Flash->success('Complaint created successfully');

				$userEntities = $this->User->find()
					->where(['User.id >' => 1])
					->toArray();

				if (!empty($userEntities)) {
					foreach ($userEntities as $userEntity) {
						$complaintids = 'DTC-' . $complaintid;
						$url = SITEURL . 'admin/complaints/autologin/' . $complaint_id . '/' . base64_encode((string)$userEntity->id);
						$to_email = $userEntity->email;
						$subject = SITENAME . " :: Complaint " . $complaintids . " By " . $this->request->getSession()->read('Customer.name');
						$template_name = 'complaint';
						$variables = [
							'name' => $this->request->getSession()->read('Customer.name'),
							'to_name' => 'Admin',
							'url' => $url,
							'complaint_id' => $complaint_id,
							'detail' => $data['Complaint']
						];
						try {
							$this->sendemail($to_email, $subject, $template_name, $variables);
						} catch (\Exception $e) {
							// Silent fail
						}
					}
				}

				return $this->redirect(['action' => 'index']);
			}
		}

		$departmentEntities = $this->Department->find()->toArray();
		$department = [];
		foreach ($departmentEntities as $entity) {
			$department[] = ['Department' => $entity->toArray()];
		}
		$this->set('departmentArr', $department);

		$NappUserEntities = $this->NappUser->find()
			->contain(['Department'])
			->where(['NappUser.id !=' => $emp_id, 'NappUser.is_staff_id' => 1])
			->toArray();

		$NappUser = [];
		foreach ($NappUserEntities as $entity) {
			$nappUserArray = ['NappUser' => $entity->toArray()];
			if ($entity->department) {
				$nappUserArray['Department'] = $entity->department->toArray();
			}
			$NappUser[] = $nappUserArray;
		}
		$this->set('NappUser', $NappUser);

		$ComplaintTypeEntities = $this->ComplaintType->find()->toArray();
		$ComplaintType = [];
		foreach ($ComplaintTypeEntities as $entity) {
			$ComplaintType[] = ['ComplaintType' => $entity->toArray()];
		}
		$this->set('ComplaintType', $ComplaintType);
	}

	function edit($complaint_id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Edit Complaint');
		$this->checkSatffSession();
		$emp_id = $this->request->getSession()->read('Customer.id');
		$complaint_id = base64_decode($complaint_id);

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();

			if (!empty($_FILES['file']['name'])) {
				$filename = time() . $_FILES['file']['name'];
				$tmp_name = $_FILES['file']['tmp_name'];
				$uploadDir = WWW_ROOT . 'complaint' . DS;
				if (!is_dir($uploadDir)) {
					mkdir($uploadDir, 0755, true);
				}
				move_uploaded_file($tmp_name, $uploadDir . $filename);
				$data['Complaint']['document'] = $filename;
			}

			if (isset($data['Complaint']['is_non_conformance']) && $data['Complaint']['is_non_conformance'] == 2) {
				$data['Complaint']['actioned_by_date'] = '0000-00-00';
			}
			$data['Complaint']['other'] = isset($data['Complaint']['other']) ? $data['Complaint']['other'] : null;

			$ComplaintEntity = $this->Complaint->find()
				->where(['Complaint.complaint_id' => $complaint_id])
				->first();

			if ($ComplaintEntity) {
				$entity = $this->Complaint->patchEntity($ComplaintEntity, $data['Complaint'], ['validate' => false]);
				if ($this->Complaint->save($entity)) {
					$this->Flash->success('Complaint updated successfully');
					return $this->redirect(['action' => 'index']);
				}
			}
		}

		$departmentEntities = $this->Department->find()->toArray();
		$department = [];
		foreach ($departmentEntities as $entity) {
			$department[] = ['Department' => $entity->toArray()];
		}
		$this->set('departmentArr', $department);

		$NappUserEntities = $this->NappUser->find()
			->contain(['Department'])
			->where(['NappUser.id !=' => $emp_id, 'NappUser.is_staff_id' => 1])
			->toArray();

		$NappUser = [];
		foreach ($NappUserEntities as $entity) {
			$nappUserArray = ['NappUser' => $entity->toArray()];
			if ($entity->department) {
				$nappUserArray['Department'] = $entity->department->toArray();
			}
			$NappUser[] = $nappUserArray;
		}
		$this->set('NappUser', $NappUser);

		$ComplaintTypeEntities = $this->ComplaintType->find()->toArray();
		$ComplaintType = [];
		foreach ($ComplaintTypeEntities as $entity) {
			$ComplaintType[] = ['ComplaintType' => $entity->toArray()];
		}
		$this->set('ComplaintType', $ComplaintType);

		$ComplaintEntity = $this->Complaint->find()
			->where(['Complaint.complaint_id' => $complaint_id])
			->first();

		if ($ComplaintEntity) {
			$ComplaintArr = ['Complaint' => $ComplaintEntity->toArray()];
			$this->set('ComplaintArr', $ComplaintArr);
			$this->setRequest($this->getRequest()->withParsedBody($ComplaintArr));
		}
	}

	/**
	 * CamelCase wrapper for admin_index
	 */
	public function adminIndex()
	{
		return $this->admin_index();
	}

	function admin_index()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Complaint List');
		$this->checkAdminSession();

		$complaint_id = '';
		$complaint_type = '';

		$query = $this->Complaint->find()
			->contain([
				'Department',
				'ComplaintType',
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'NappUser1' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'Conformance'
			]);

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$complaint_type = isset($data['complaint_type']) ? $data['complaint_type'] : '';
			$complaint_id = isset($data['complaint_id']) ? $data['complaint_id'] : '';

			if (!empty($complaint_id)) {
				$query->where(['Complaint.complaint_id' => $complaint_id]);
			} elseif (!empty($complaint_type)) {
				$query->where(['Complaint.complaint_type' => $complaint_type]);
			}
		}

		$query->orderDesc('Complaint.id');

		$ComplaintArr = $this->paginate($query, ['limit' => 25]);

		// Convert entities to array format for view compatibility
		$ComplaintArrArray = [];
		foreach ($ComplaintArr as $complaint) {
			$complaintData = $complaint->toArray();
			$result = ['Complaint' => $complaintData];
			if ($complaint->department) {
				$result['Department'] = $complaint->department->toArray();
			}
			if ($complaint->ComplaintType) {
				$result['ComplaintType'] = $complaint->ComplaintType->toArray();
			}
			if ($complaint->napp_user) {
				$result['NappUser'] = $complaint->napp_user->toArray();
			}
			if ($complaint->napp_user1) {
				$result['NappUser1'] = $complaint->napp_user1->toArray();
			}
			// Always set Conformance array, even if empty
			$result['Conformance'] = [];
			if ($complaint->conformance && !empty($complaint->conformance)) {
				foreach ($complaint->conformance as $conf) {
					$result['Conformance'][] = $conf->toArray();
				}
			}
			$ComplaintArrArray[] = $result;
		}
		$ComplaintArr = $ComplaintArrArray;

		$this->set('ComplaintArr', $ComplaintArr);
		$this->set('complaint_id', $complaint_id);
		$this->set('complaint_type', $complaint_type);

		$ComplaintTypeEntities = $this->ComplaintType->find()->toArray();
		$ComplaintType = [];
		foreach ($ComplaintTypeEntities as $entity) {
			$ComplaintType[] = ['ComplaintType' => $entity->toArray()];
		}
		$this->set('ComplaintType', $ComplaintType);
	}

	/**
	 * CamelCase wrapper for admin_detail
	 */
	public function adminDetail($complaint_id = null, $type = null)
	{
		return $this->admin_detail($complaint_id, $type);
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

		if (!$ComplaintEntity) {
			$this->Flash->error('Complaint not found');
			return $this->redirect(['action' => 'admin_index']);
		}

		// Convert to array format for view compatibility
		$ComplaintArr = ['Complaint' => $ComplaintEntity->toArray()];
		if ($ComplaintEntity->department) {
			$ComplaintArr['Department'] = $ComplaintEntity->department->toArray();
		}
		if ($ComplaintEntity->ComplaintType) {
			$ComplaintArr['ComplaintType'] = $ComplaintEntity->ComplaintType->toArray();
		}
		if ($ComplaintEntity->napp_user) {
			$ComplaintArr['NappUser'] = $ComplaintEntity->napp_user->toArray();
		}
		if ($ComplaintEntity->napp_user1) {
			$ComplaintArr['NappUser1'] = $ComplaintEntity->napp_user1->toArray();
		}

		$this->set('ComplaintArr', $ComplaintArr);
		$this->set('type', $type);
	}
}
