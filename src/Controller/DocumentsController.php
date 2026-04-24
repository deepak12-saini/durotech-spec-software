<?php
namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;

/**
 * Documents Controller
 */
class DocumentsController extends AppController
{
	public function initialize(): void
	{
		parent::initialize();
		// Load models explicitly (CakePHP 3 doesn't support $uses)
		$this->loadModel('BatchRegister');
		$this->loadModel('DocumentLibrary');
		$this->loadModel('NappUser');
		$this->loadModel('User');
		$this->loadModel('DocumentLibraryRecord');
		$this->loadModel('DocumentReceiveInspection');
		$this->loadModel('DocumentPreventiveMaintenance');
		$this->loadModel('DocumentPreventiveMaintenanceRecord');
		$this->loadModel('DocumentFieldExecutiveDuty');
		$this->loadModel('DocumentCalibrationReocrd');
		$this->loadModel('DocumentCalibration');
		$this->loadModel('DocumentNcClosureRecord');
		$this->loadModel('DocumentNcClosure');
	}

	public function beforeFilter(EventInterface $event): ?Response
	{
		$this->callConstants();
		return parent::beforeFilter($event);
	}

	public function adddoc()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Batch Register List');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['DocumentLibrary']['user_id'] = $user_id;
			$data['DocumentLibrary']['status'] = 1;
			$data['DocumentLibrary']['created'] = date('Y-m-d H:i:s');
			// Ensure documentid is set from form or will be set after save
			if (empty($data['DocumentLibrary']['documentid'])) {
				$last = $this->DocumentLibrary->find()->orderDesc('DocumentLibrary.id')->select(['DocumentLibrary.id'])->first();
				$data['DocumentLibrary']['documentid'] = 'DTRL-' . (1000 + ($last ? (int)$last->id + 1 : 1));
			}

			$entity = $this->DocumentLibrary->newEntity($data['DocumentLibrary'], ['validate' => false]);
			if ($this->DocumentLibrary->save($entity)) {
				$this->Flash->success('Record saved successfully.');
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

		$docEntity = $this->DocumentLibrary->find()
			->orderDesc('DocumentLibrary.id')
			->select(['DocumentLibrary.id'])
			->first();
		$docArr = $docEntity ? ['DocumentLibrary' => $docEntity->toArray()] : ['DocumentLibrary' => ['id' => null]];
		$this->set('docArr', $docArr);

		if (!empty($docArr['DocumentLibrary']['id'])) {
			$docId = 'DTRL-' . (1000 + $docArr['DocumentLibrary']['id'] + 1);
		} else {
			$docId = 'DTRL-1001';
		}
		$this->set('docId', $docId);
	}

	public function editdoc($id)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Batch Register List');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$data['DocumentLibrary']['user_id'] = $user_id;
			$data['DocumentLibrary']['status'] = 1;
			$data['DocumentLibrary']['created'] = date('Y-m-d H:i:s');

			$entity = $this->DocumentLibrary->get($id);
			$entity = $this->DocumentLibrary->patchEntity($entity, $data['DocumentLibrary'], ['validate' => false]);
			if ($this->DocumentLibrary->save($entity)) {
				$this->Flash->success('Record saved successfully.');
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

		$docEntity = $this->DocumentLibrary->find()
			->where(['DocumentLibrary.id' => $id])
			->first();

		if ($docEntity) {
			$docData = $docEntity->toArray();
			if (empty($docData['documentid'])) {
				$docData['documentid'] = 'DTRL-' . (1000 + (int)$docData['id']);
			}
			$docArr = ['DocumentLibrary' => $docData];
			$this->set('docArr', $docArr);
			// Pre-fill form using request data (CakePHP Form helper reads from getData())
			$this->setRequest($this->getRequest()->withData('DocumentLibrary', $docData));
		}
	}

	function addtask($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Save Records');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();

			// Delete existing records
			$this->DocumentLibraryRecord->deleteAll(['doc_id' => $id]);

			for ($i = 1; $i <= count($data); $i++) {
				if (!empty($data['nameofthebook'][$i])) {
					$recordData = [
						'doc_id' => $id,
						'nameofthebook' => $data['nameofthebook'][$i],
						'expecteddateofreturn' => isset($data['expecteddateofreturn'][$i]) ? $data['expecteddateofreturn'][$i] : null,
						'qty' => isset($data['qty'][$i]) ? $data['qty'][$i] : null,
						'remarks' => isset($data['remarks'][$i]) ? $data['remarks'][$i] : null
					];
					$entity = $this->DocumentLibraryRecord->newEntity($recordData, ['validate' => false]);
					$this->DocumentLibraryRecord->save($entity);
				}
			}
			$this->Flash->success('Record saved successfully.');
			return $this->redirect(['action' => 'index']);
		}

		$docEntity = $this->DocumentLibrary->find()
			->where(['DocumentLibrary.id' => $id])
			->first();
		$docArr = $docEntity ? ['DocumentLibrary' => $docEntity->toArray()] : ['DocumentLibrary' => []];
		$this->set('docArr', $docArr);

		$doclibrecEntities = $this->DocumentLibraryRecord->find()
			->where(['DocumentLibraryRecord.doc_id' => $id])
			->toArray();
		$doclibrecArr = [];
		foreach ($doclibrecEntities as $entity) {
			$doclibrecArr[] = ['DocumentLibraryRecord' => $entity->toArray()];
		}
		$this->set('doclibrecArr', $doclibrecArr);
	}

	function index()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Batch Register List');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->DocumentLibrary->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'NappUser1' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'NappUser2' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'NappUser3' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'NappUser4' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'DocumentLibraryRecord'
			])
			->where(['DocumentLibrary.user_id' => $user_id])
			->orderDesc('DocumentLibrary.id');

		$DocumentLibraryArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$DocumentLibraryArrArray = [];
		foreach ($DocumentLibraryArr as $doc) {
			$docData = $doc->toArray();
			// Ensure documentid is present for listing (fallback if column missing or null)
			if (empty($docData['documentid']) && !empty($docData['id'])) {
				$docData['documentid'] = 'DTRL-' . (1000 + (int)$docData['id']);
			}
			$result = ['DocumentLibrary' => $docData];
			// Extract NappUser association - always set even if empty
			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->NappUser1) {
				$result['NappUser1'] = $doc->NappUser1->toArray();
			} else {
				$result['NappUser1'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->NappUser2) {
				$result['NappUser_2'] = $doc->NappUser2->toArray();
			} else {
				$result['NappUser_2'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->NappUser3) {
				$result['NappUser_3'] = $doc->NappUser3->toArray();
			} else {
				$result['NappUser_3'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->NappUser4) {
				$result['NappUser_4'] = $doc->NappUser4->toArray();
			} else {
				$result['NappUser_4'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->document_library_record) {
				$result['DocumentLibraryRecord'] = [];
				foreach ($doc->document_library_record as $record) {
					$result['DocumentLibraryRecord'][] = $record->toArray();
				}
			} else {
				$result['DocumentLibraryRecord'] = [];
			}
			$DocumentLibraryArrArray[] = $result;
		}
		$DocumentLibraryArr = $DocumentLibraryArrArray;

		$this->set('DocumentLibraryArr', $DocumentLibraryArr);
	}

	/**
	 * CamelCase wrapper for admin_nc_closure
	 */
	public function adminNcClosure()
	{
		return $this->admin_nc_closure();
	}

	function admin_nc_closure()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' NC and NC Closure');
		$this->checkAdminSession();

		$query = $this->DocumentNcClosure->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'DocumentNcClosureRecord'
			])
			->orderDesc('DocumentNcClosure.id');

		$DocumentNcClosureArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$DocumentNcClosureArrArray = [];
		foreach ($DocumentNcClosureArr as $doc) {
			$docData = $doc->toArray();
			$result = ['DocumentNcClosure' => $docData];
			// Extract NappUser association - always set even if empty
			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->document_nc_closure_record) {
				$result['DocumentNcClosureRecord'] = [];
				foreach ($doc->document_nc_closure_record as $record) {
					$result['DocumentNcClosureRecord'][] = $record->toArray();
				}
			} else {
				$result['DocumentNcClosureRecord'] = [];
			}
			$DocumentNcClosureArrArray[] = $result;
		}
		$DocumentLibraryArr = $DocumentNcClosureArrArray;

		$this->set('DocumentLibraryArr', $DocumentLibraryArr);
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
		$this->set('title_for_layout', SITENAME . ' Batch Register List');
		$this->checkAdminSession();

		$query = $this->DocumentLibrary->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'NappUser1' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'NappUser2' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'NappUser3' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'NappUser4' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'DocumentLibraryRecord'
			])
			->orderDesc('DocumentLibrary.id');

		$DocumentLibraryArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$DocumentLibraryArrArray = [];
		foreach ($DocumentLibraryArr as $doc) {
			$docData = $doc->toArray();
			if (empty($docData['documentid']) && !empty($docData['id'])) {
				$docData['documentid'] = 'DTRL-' . (1000 + (int)$docData['id']);
			}
			$result = ['DocumentLibrary' => $docData];
			// Extract NappUser association - always set even if empty
			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->NappUser1) {
				$result['NappUser1'] = $doc->NappUser1->toArray();
			} else {
				$result['NappUser1'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->NappUser2) {
				$result['NappUser_2'] = $doc->NappUser2->toArray();
			} else {
				$result['NappUser_2'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->NappUser3) {
				$result['NappUser_3'] = $doc->NappUser3->toArray();
			} else {
				$result['NappUser_3'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->NappUser4) {
				$result['NappUser_4'] = $doc->NappUser4->toArray();
			} else {
				$result['NappUser_4'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->document_library_record) {
				$result['DocumentLibraryRecord'] = [];
				foreach ($doc->document_library_record as $record) {
					$result['DocumentLibraryRecord'][] = $record->toArray();
				}
			} else {
				$result['DocumentLibraryRecord'] = [];
			}
			$DocumentLibraryArrArray[] = $result;
		}
		$DocumentLibraryArr = $DocumentLibraryArrArray;

		$this->set('DocumentLibraryArr', $DocumentLibraryArr);
	}

	function edit_receiving_insepction($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Edit Receiving and Insepction');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();

			$updateData = [
				'ph_property' => isset($data['ph']['propery'][0]) ? $data['ph']['propery'][0] : null,
				'ph_certificate_result' => isset($data['ph']['certificate_result'][0]) ? $data['ph']['certificate_result'][0] : null,
				'ph_actual_result' => isset($data['ph']['actual_result'][0]) ? $data['ph']['actual_result'][0] : null,
				'solid_property' => isset($data['solids']['propery'][0]) ? $data['solids']['propery'][0] : null,
				'solid_certificate_result' => isset($data['solids']['certificate_result'][0]) ? $data['solids']['certificate_result'][0] : null,
				'solid_actual_result' => isset($data['solids']['actual_result'][0]) ? $data['solids']['actual_result'][0] : null,
				'gravity_property' => isset($data['gravity']['propery'][0]) ? $data['gravity']['propery'][0] : null,
				'gravity_certificate_result' => isset($data['gravity']['certificate_result'][0]) ? $data['gravity']['certificate_result'][0] : null,
				'gravity_actual_result' => isset($data['gravity']['actual_result'][0]) ? $data['gravity']['actual_result'][0] : null,
				'viscosity_property' => isset($data['viscosity']['propery'][0]) ? $data['viscosity']['propery'][0] : null,
				'viscosity_certificate_result' => isset($data['viscosity']['certificate_result'][0]) ? $data['viscosity']['certificate_result'][0] : null,
				'viscosity_actual_result' => isset($data['viscosity']['actual_result'][0]) ? $data['viscosity']['actual_result'][0] : null,
				'user_id' => $user_id,
				'documentid' => isset($data['DocumentReceiveInspection']['documentid']) ? $data['DocumentReceiveInspection']['documentid'] : null,
				'signature' => isset($data['DocumentReceiveInspection']['signature']) ? $data['DocumentReceiveInspection']['signature'] : null,
				'product_name' => isset($data['DocumentReceiveInspection']['product_name']) ? $data['DocumentReceiveInspection']['product_name'] : null,
				'status' => isset($data['DocumentReceiveInspection']['status']) ? $data['DocumentReceiveInspection']['status'] : null,
				'finaldate' => isset($data['DocumentReceiveInspection']['finaldate']) ? $data['DocumentReceiveInspection']['finaldate'] : null,
				'pass_fail' => isset($data['DocumentReceiveInspection']['pass_fail']) ? $data['DocumentReceiveInspection']['pass_fail'] : null,
				'concessional_pass' => isset($data['DocumentReceiveInspection']['concessional_pass']) ? $data['DocumentReceiveInspection']['concessional_pass'] : null,
				'created' => date('Y-m-d H:i:s')
			];

			$entity = $this->DocumentReceiveInspection->get($id);
			$entity = $this->DocumentReceiveInspection->patchEntity($entity, $updateData, ['validate' => false]);
			if ($this->DocumentReceiveInspection->save($entity)) {
				$this->Flash->success('Receiving and insepction updated successfully.');
				return $this->redirect(['action' => 'receiving_insepction']);
			}
		}

		$docEntity = $this->DocumentReceiveInspection->find()
			->where(['DocumentReceiveInspection.id' => $id])
			->first();
		if ($docEntity) {
			$docArr = ['DocumentReceiveInspection' => $docEntity->toArray()];
			$this->set('docArr', $docArr);
			$this->setRequest($this->getRequest()->withParsedBody($docArr));
		}
	}

	function add_receiving_insepction()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Receiving and Insepction List');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();

			$insertData = [
				'ph_property' => isset($data['ph']['propery'][0]) ? $data['ph']['propery'][0] : null,
				'ph_certificate_result' => isset($data['ph']['certificate_result'][0]) ? $data['ph']['certificate_result'][0] : null,
				'ph_actual_result' => isset($data['ph']['actual_result'][0]) ? $data['ph']['actual_result'][0] : null,
				'solid_property' => isset($data['solids']['propery'][0]) ? $data['solids']['propery'][0] : null,
				'solid_certificate_result' => isset($data['solids']['certificate_result'][0]) ? $data['solids']['certificate_result'][0] : null,
				'solid_actual_result' => isset($data['solids']['actual_result'][0]) ? $data['solids']['actual_result'][0] : null,
				'gravity_property' => isset($data['gravity']['propery'][0]) ? $data['gravity']['propery'][0] : null,
				'gravity_certificate_result' => isset($data['gravity']['certificate_result'][0]) ? $data['gravity']['certificate_result'][0] : null,
				'gravity_actual_result' => isset($data['gravity']['actual_result'][0]) ? $data['gravity']['actual_result'][0] : null,
				'viscosity_property' => isset($data['viscosity']['propery'][0]) ? $data['viscosity']['propery'][0] : null,
				'viscosity_certificate_result' => isset($data['viscosity']['certificate_result'][0]) ? $data['viscosity']['certificate_result'][0] : null,
				'viscosity_actual_result' => isset($data['viscosity']['actual_result'][0]) ? $data['viscosity']['actual_result'][0] : null,
				'user_id' => $user_id,
				'documentid' => isset($data['DocumentReceiveInspection']['documentid']) ? $data['DocumentReceiveInspection']['documentid'] : null,
				'signature' => isset($data['DocumentReceiveInspection']['signature']) ? $data['DocumentReceiveInspection']['signature'] : null,
				'date' => date('Y-m-d'),
				'finaldate' => isset($data['DocumentReceiveInspection']['finaldate']) ? $data['DocumentReceiveInspection']['finaldate'] : null,
				'pass_fail' => isset($data['DocumentReceiveInspection']['pass_fail']) ? $data['DocumentReceiveInspection']['pass_fail'] : null,
				'concessional_pass' => isset($data['DocumentReceiveInspection']['concessional_pass']) ? $data['DocumentReceiveInspection']['concessional_pass'] : null,
				'status' => 1,
				'created' => date('Y-m-d H:i:s')
			];

			$entity = $this->DocumentReceiveInspection->newEntity($insertData, ['validate' => false]);
			if ($this->DocumentReceiveInspection->save($entity)) {
				$this->Flash->success('Receiving and insepction added successfully.');
				return $this->redirect(['action' => 'receiving_insepction']);
			}
		}

		$docEntity = $this->DocumentReceiveInspection->find()
			->orderDesc('DocumentReceiveInspection.id')
			->select(['DocumentReceiveInspection.id'])
			->first();
		$docArr = $docEntity ? ['DocumentReceiveInspection' => $docEntity->toArray()] : ['DocumentReceiveInspection' => ['id' => null]];
		$this->set('docArr', $docArr);

		if (!empty($docArr['DocumentReceiveInspection']['id'])) {
			$docId = 'DTIR-' . (1000 + $docArr['DocumentReceiveInspection']['id'] + 1);
		} else {
			$docId = 'DTIR-1001';
		}

		$this->set('docId', $docId);
	}

	function receiving_insepction()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Receiving and Insepction List');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->DocumentReceiveInspection->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				}
			])
			->where(['DocumentReceiveInspection.user_id' => $user_id])
			->orderDesc('DocumentReceiveInspection.id');

		$DocumentLibraryArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$DocumentLibraryArrArray = [];
		foreach ($DocumentLibraryArr as $doc) {
			$docData = $doc->toArray();
			$result = ['DocumentReceiveInspection' => $docData];
			// Extract NappUser association - always set even if empty
			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			$DocumentLibraryArrArray[] = $result;
		}
		$DocumentLibraryArr = $DocumentLibraryArrArray;

		$this->set('DocumentLibraryArr', $DocumentLibraryArr);
	}

	public function receivingInsepction()
	{
		return $this->staff_receiving_insepction();
	}

	function staff_receiving_insepction()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout'); // ✅ staff layout
		$this->set('title_for_layout', SITENAME . ' Receiving and Insepction List');
		$this->checkSatffSession(); // ✅ staff session check

		$query = $this->DocumentReceiveInspection->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				}
			])
			->orderDesc('DocumentReceiveInspection.id');

		$DocumentLibraryArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format
		$DocumentLibraryArrArray = [];
		foreach ($DocumentLibraryArr as $doc) {
			$docData = $doc->toArray();

			$result = ['DocumentReceiveInspection' => $docData];

			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}

			$DocumentLibraryArrArray[] = $result;
		}

		$this->set('DocumentLibraryArr', $DocumentLibraryArrArray);
	}

	/**
	 * CamelCase wrapper for admin_receiving_insepction
	 */
	public function adminReceivingInsepction()
	{
		return $this->admin_receiving_insepction();
	}

	function admin_receiving_insepction()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Receiving and Insepction List');
		$this->checkAdminSession();

		$query = $this->DocumentReceiveInspection->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				}
			])
			->orderDesc('DocumentReceiveInspection.id');

		$DocumentLibraryArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$DocumentLibraryArrArray = [];
		foreach ($DocumentLibraryArr as $doc) {
			$docData = $doc->toArray();
			$result = ['DocumentReceiveInspection' => $docData];
			// Extract NappUser association - always set even if empty
			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			$DocumentLibraryArrArray[] = $result;
		}
		$DocumentLibraryArr = $DocumentLibraryArrArray;

		$this->set('DocumentLibraryArr', $DocumentLibraryArr);
	}



	/**
	 * CamelCase wrapper for admin_preventive_maintenance
	 */
	public function adminPreventiveMaintenance()
	{
		return $this->admin_preventive_maintenance();
	}

	function admin_preventive_maintenance()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Preventive Maintenance List');
		$this->checkAdminSession();

		$query = $this->DocumentPreventiveMaintenance->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'DocumentPreventiveMaintenanceRecord'
			])
			->orderDesc('DocumentPreventiveMaintenance.id');

		$DocumentLibraryArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$DocumentLibraryArrArray = [];
		foreach ($DocumentLibraryArr as $doc) {
			$docData = $doc->toArray();
			$result = ['DocumentPreventiveMaintenance' => $docData];
			// Extract NappUser association - always set even if empty
			// Check both snake_case (from toArray()) and PascalCase (property name)
			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($docData['NappUser']) && is_array($docData['NappUser'])) {
				$result['NappUser'] = $docData['NappUser'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} elseif (isset($doc->NappUser) && $doc->NappUser) {
				$result['NappUser'] = $doc->NappUser->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->document_preventive_maintenance_record) {
				$result['DocumentPreventiveMaintenanceRecord'] = [];
				foreach ($doc->document_preventive_maintenance_record as $record) {
					$result['DocumentPreventiveMaintenanceRecord'][] = $record->toArray();
				}
			} else {
				$result['DocumentPreventiveMaintenanceRecord'] = [];
			}
			$DocumentLibraryArrArray[] = $result;
		}
		$DocumentLibraryArr = $DocumentLibraryArrArray;

		$this->set('DocumentLibraryArr', $DocumentLibraryArr);
	}

	/**
	 * CamelCase wrapper for admin_executive_duty_requisition
	 */
	public function adminExecutiveDutyRequisition()
	{
		return $this->admin_executive_duty_requisition();
	}

	function admin_executive_duty_requisition()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' executive duty requisition');
		$this->checkAdminSession();

		$query = $this->DocumentFieldExecutiveDuty->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				}
			])
			->orderDesc('DocumentFieldExecutiveDuty.id');

		$DocumentLibraryArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$DocumentLibraryArrArray = [];
		foreach ($DocumentLibraryArr as $doc) {
			$docData = $doc->toArray();
			$result = ['DocumentFieldExecutiveDuty' => $docData];
			// Extract NappUser association - always set even if empty
			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			$DocumentLibraryArrArray[] = $result;
		}
		$DocumentLibraryArr = $DocumentLibraryArrArray;

		$this->set('DocumentLibraryArr', $DocumentLibraryArr);
	}

	/**
	 * CamelCase wrapper for admin_calibration_equipment
	 */
	public function adminCalibrationEquipment()
	{
		return $this->admin_calibration_equipment();
	}

	function admin_calibration_equipment()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Calibration status of Instrument / Equipment');
		$this->checkAdminSession();

		$query = $this->DocumentCalibration->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'DocumentCalibrationReocrd'
			])
			->orderDesc('DocumentCalibration.id');

		$DocumentLibraryArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$DocumentLibraryArrArray = [];
		foreach ($DocumentLibraryArr as $doc) {
			$docData = $doc->toArray();
			$result = ['DocumentCalibration' => $docData];
			// Extract NappUser association - always set even if empty
			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->document_calibration_reocrd) {
				$result['DocumentCalibrationReocrd'] = [];
				foreach ($doc->document_calibration_reocrd as $record) {
					$result['DocumentCalibrationReocrd'][] = $record->toArray();
				}
			} else {
				$result['DocumentCalibrationReocrd'] = [];
			}
			$DocumentLibraryArrArray[] = $result;
		}
		$DocumentLibraryArr = $DocumentLibraryArrArray;

		$this->set('DocumentLibraryArr', $DocumentLibraryArr);
	}

	function preventive_maintenance()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Preventive Maintenance List');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->DocumentPreventiveMaintenance->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'DocumentPreventiveMaintenanceRecord'
			])
			->where(['DocumentPreventiveMaintenance.user_id' => $user_id])
			->orderDesc('DocumentPreventiveMaintenance.id');

		$DocumentLibraryArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$DocumentLibraryArrArray = [];
		foreach ($DocumentLibraryArr as $doc) {
			$docData = $doc->toArray();
			$result = ['DocumentPreventiveMaintenance' => $docData];
			// Extract NappUser association - always set even if empty
			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->document_preventive_maintenance_record) {
				$result['DocumentPreventiveMaintenanceRecord'] = [];
				foreach ($doc->document_preventive_maintenance_record as $record) {
					$result['DocumentPreventiveMaintenanceRecord'][] = $record->toArray();
				}
			} else {
				$result['DocumentPreventiveMaintenanceRecord'] = [];
			}
			$DocumentLibraryArrArray[] = $result;
		}
		$DocumentLibraryArr = $DocumentLibraryArrArray;

		$this->set('DocumentLibraryArr', $DocumentLibraryArr);
	}

	/** CamelCase alias for staff/public route compatibility. */
	public function preventiveMaintenance()
	{
		return $this->preventive_maintenance();
	}

	function add_preventive_maintenance()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Document Preventive Maintenance List');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();

			$maintenanceData = [
				'user_id' => $user_id,
				'status' => 1,
				'created' => date('Y-m-d H:i:s')
			];
			if (isset($data['DocumentPreventiveMaintenance'])) {
				$maintenanceData = array_merge($maintenanceData, $data['DocumentPreventiveMaintenance']);
			}

			$entity = $this->DocumentPreventiveMaintenance->newEntity($maintenanceData, ['validate' => false]);
			if ($this->DocumentPreventiveMaintenance->save($entity)) {
				$lastid = $entity->id;
				if (!empty($data['jobtobedone'])) {
					$i = 1;
					foreach ($data['jobtobedone'] as $jobtobedone) {
						$recordData = [
							'doc_preventive_id' => $lastid,
							'job_to_be_done' => $jobtobedone,
							'frequency' => isset($data['frequency'][$i]) ? $data['frequency'][$i] : null,
							'date' => isset($data['date'][$i]) ? $data['date'][$i] : null,
							'major_job_details' => isset($data['major_job_detail'][$i]) ? $data['major_job_detail'][$i] : null,
							'sign' => isset($data['sign'][$i]) ? $data['sign'][$i] : null
						];
						$recordEntity = $this->DocumentPreventiveMaintenanceRecord->newEntity($recordData, ['validate' => false]);
						$this->DocumentPreventiveMaintenanceRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Receiving and insepction added successfully.');
				return $this->redirect(['action' => 'preventive_maintenance']);
			}
		}

		$docEntity = $this->DocumentPreventiveMaintenance->find()
			->orderDesc('DocumentPreventiveMaintenance.id')
			->select(['DocumentPreventiveMaintenance.id'])
			->first();
		$docArr = $docEntity ? ['DocumentPreventiveMaintenance' => $docEntity->toArray()] : ['DocumentPreventiveMaintenance' => ['id' => null]];
		$this->set('docArr', $docArr);

		if (!empty($docArr['DocumentPreventiveMaintenance']['id'])) {
			$docId = 'DTPM-' . (1000 + $docArr['DocumentPreventiveMaintenance']['id'] + 1);
		} else {
			$docId = 'DTPM-1001';
		}

		$this->set('docId', $docId);
	}

	function edit_preventive_maintenance($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Document Preventive Maintenance List');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();

			$maintenanceData = [
				'id' => $id,
				'user_id' => $user_id,
				'status' => 1,
				'created' => date('Y-m-d H:i:s')
			];
			if (isset($data['DocumentPreventiveMaintenance'])) {
				$maintenanceData = array_merge($maintenanceData, $data['DocumentPreventiveMaintenance']);
			}

			$entity = $this->DocumentPreventiveMaintenance->get($id);
			$entity = $this->DocumentPreventiveMaintenance->patchEntity($entity, $maintenanceData, ['validate' => false]);
			if ($this->DocumentPreventiveMaintenance->save($entity)) {
				// Delete existing records
				$this->DocumentPreventiveMaintenanceRecord->deleteAll(['doc_preventive_id' => $id]);

				if (!empty($data['jobtobedone'])) {
					$i = 1;
					foreach ($data['jobtobedone'] as $jobtobedone) {
						$recordData = [
							'doc_preventive_id' => $id,
							'job_to_be_done' => $jobtobedone,
							'frequency' => isset($data['frequency'][$i]) ? $data['frequency'][$i] : null,
							'date' => isset($data['date'][$i]) ? $data['date'][$i] : null,
							'major_job_details' => isset($data['major_job_detail'][$i]) ? $data['major_job_detail'][$i] : null,
							'sign' => isset($data['sign'][$i]) ? $data['sign'][$i] : null
						];
						$recordEntity = $this->DocumentPreventiveMaintenanceRecord->newEntity($recordData, ['validate' => false]);
						$this->DocumentPreventiveMaintenanceRecord->save($recordEntity);
						$i++;
					}
				}

				$this->Flash->success('Receiving and insepction updated successfully.');
				return $this->redirect(['action' => 'preventive_maintenance']);
			}
		}

		$docEntity = $this->DocumentPreventiveMaintenance->find()
			->contain(['DocumentPreventiveMaintenanceRecord'])
			->where(['DocumentPreventiveMaintenance.id' => $id])
			->first();

		if ($docEntity) {
			$docData = $docEntity->toArray();
			$docArr = ['DocumentPreventiveMaintenance' => $docData];
			if ($docEntity->document_preventive_maintenance_record) {
				$docArr['DocumentPreventiveMaintenanceRecord'] = [];
				foreach ($docEntity->document_preventive_maintenance_record as $record) {
					$docArr['DocumentPreventiveMaintenanceRecord'][] = $record->toArray();
				}
			}
			$this->set('docArr', $docArr);
			$this->setRequest($this->getRequest()->withParsedBody($docArr));
		}
	}

	function executive_duty_requisition()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' executive duty requisition');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->DocumentFieldExecutiveDuty->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				}
			])
			->where(['DocumentFieldExecutiveDuty.user_id' => $user_id])
			->orderDesc('DocumentFieldExecutiveDuty.id');

		$DocumentLibraryArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$DocumentLibraryArrArray = [];
		foreach ($DocumentLibraryArr as $doc) {
			$docData = $doc->toArray();
			$result = ['DocumentFieldExecutiveDuty' => $docData];
			// Extract NappUser association - always set even if empty
			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			$DocumentLibraryArrArray[] = $result;
		}
		$DocumentLibraryArr = $DocumentLibraryArrArray;

		$this->set('DocumentLibraryArr', $DocumentLibraryArr);
	}

	/** CamelCase alias for staff/public route compatibility. */
	public function executiveDutyRequisition()
	{
		return $this->executive_duty_requisition();
	}

	function add_executive_duty()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' executive duty requisition');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$dutyData = [
				'user_id' => $user_id,
				'status' => 1,
				'created' => date('Y-m-d H:i:s')
			];
			if (isset($data['DocumentFieldExecutiveDuty'])) {
				$dutyData = array_merge($dutyData, $data['DocumentFieldExecutiveDuty']);
			}

			$entity = $this->DocumentFieldExecutiveDuty->newEntity($dutyData, ['validate' => false]);
			$this->DocumentFieldExecutiveDuty->save($entity);

			$this->Flash->success('executive duty requisition added successfully.');
			return $this->redirect(['action' => 'executive_duty_requisition']);
		}

		$docEntity = $this->DocumentFieldExecutiveDuty->find()
			->orderDesc('DocumentFieldExecutiveDuty.id')
			->select(['DocumentFieldExecutiveDuty.id'])
			->first();
		$docArr = $docEntity ? ['DocumentFieldExecutiveDuty' => $docEntity->toArray()] : ['DocumentFieldExecutiveDuty' => ['id' => null]];
		$this->set('docArr', $docArr);

		if (!empty($docArr['DocumentFieldExecutiveDuty']['id'])) {
			$docId = 'DTFER-' . (1000 + $docArr['DocumentFieldExecutiveDuty']['id'] + 1);
		} else {
			$docId = 'DTFER-1001';
		}

		$this->set('docId', $docId);
	}

	function edit_executive_duty($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' executive duty requisition');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$dutyData = ['id' => $id];
			if (isset($data['DocumentFieldExecutiveDuty'])) {
				$dutyData = array_merge($dutyData, $data['DocumentFieldExecutiveDuty']);
			}

			$entity = $this->DocumentFieldExecutiveDuty->get($id);
			$entity = $this->DocumentFieldExecutiveDuty->patchEntity($entity, $dutyData, ['validate' => false]);
			$this->DocumentFieldExecutiveDuty->save($entity);

			$this->Flash->success('executive duty requisition added successfully.');
			return $this->redirect(['action' => 'executive_duty_requisition']);
		}

		$docEntity = $this->DocumentFieldExecutiveDuty->find()
			->where(['DocumentFieldExecutiveDuty.id' => $id])
			->first();

		if ($docEntity) {
			$docArr = ['DocumentFieldExecutiveDuty' => $docEntity->toArray()];
			$this->set('docArr', $docArr);
			$this->setRequest($this->getRequest()->withParsedBody($docArr));
		}
	}

	function calibration_equipment()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Calibration status of Instrument / Equipment');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->DocumentCalibration->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'DocumentCalibrationReocrd'
			])
			->where(['DocumentCalibration.user_id' => $user_id])
			->orderDesc('DocumentCalibration.id');

		$DocumentLibraryArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$DocumentLibraryArrArray = [];
		foreach ($DocumentLibraryArr as $doc) {
			$docData = $doc->toArray();
			$result = ['DocumentCalibration' => $docData];
			// Extract NappUser association - always set even if empty
			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->document_calibration_reocrd) {
				$result['DocumentCalibrationReocrd'] = [];
				foreach ($doc->document_calibration_reocrd as $record) {
					$result['DocumentCalibrationReocrd'][] = $record->toArray();
				}
			} else {
				$result['DocumentCalibrationReocrd'] = [];
			}
			$DocumentLibraryArrArray[] = $result;
		}
		$DocumentLibraryArr = $DocumentLibraryArrArray;

		$this->set('DocumentLibraryArr', $DocumentLibraryArr);
	}

	function add_calibration_equipment()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Add Calibration status of Instrument / Equipment');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();

			$calibrationData = [
				'status' => 1,
				'created' => date('Y-m-d H:i:s'),
				'user_id' => $user_id,
				'documentid' => isset($data['DocumentCalibration']['documentid']) ? $data['DocumentCalibration']['documentid'] : null,
				'date' => isset($data['DocumentCalibration']['date']) ? $data['DocumentCalibration']['date'] : null
			];

			$entity = $this->DocumentCalibration->newEntity($calibrationData, ['validate' => false]);
			if ($this->DocumentCalibration->save($entity)) {
				$DocumentCalibration_id = $entity->id;
				$i = 1;
				if (isset($data['tool_equipment_description'])) {
					foreach ($data['tool_equipment_description'] as $tool_equipment_description) {
						if (!empty($tool_equipment_description)) {
							$recordData = [
								'doc_id' => $DocumentCalibration_id,
								'tool_equipment_description' => $tool_equipment_description,
								'location' => isset($data['location'][$i]) ? $data['location'][$i] : null,
								'test_period' => isset($data['test_period'][$i]) ? $data['test_period'][$i] : null,
								'person_responsible' => isset($data['person_responsible'][$i]) ? $data['person_responsible'][$i] : null,
								'date_added' => isset($data['date_added'][$i]) ? $data['date_added'][$i] : null,
								'standard_identification' => isset($data['standard_identification'][$i]) ? $data['standard_identification'][$i] : null
							];
							$recordEntity = $this->DocumentCalibrationReocrd->newEntity($recordData, ['validate' => false]);
							$this->DocumentCalibrationReocrd->save($recordEntity);
						}
						$i++;
					}
				}
				$this->Flash->success('Calibration status of Instrument / Equipment Added Successfully.');
				return $this->redirect(['action' => 'calibration_equipment']);
			}
		}

		$docEntity = $this->DocumentCalibration->find()
			->orderDesc('DocumentCalibration.id')
			->select(['DocumentCalibration.id'])
			->first();
		$docArr = $docEntity ? ['DocumentCalibration' => $docEntity->toArray()] : ['DocumentCalibration' => ['id' => null]];
		$this->set('docArr', $docArr);

		if (!empty($docArr['DocumentCalibration']['id'])) {
			$docId = 'DTCSI-' . (1000 + $docArr['DocumentCalibration']['id'] + 1);
		} else {
			$docId = 'DTCSI-1001';
		}

		$this->set('docId', $docId);
	}

	function edit_calibration_equipment($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Edit Calibration status of Instrument / Equipment');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();

			$calibrationData = [
				'id' => $id,
				'documentid' => isset($data['DocumentCalibration']['documentid']) ? $data['DocumentCalibration']['documentid'] : null,
				'date' => isset($data['DocumentCalibration']['date']) ? $data['DocumentCalibration']['date'] : null
			];

			$entity = $this->DocumentCalibration->get($id);
			$entity = $this->DocumentCalibration->patchEntity($entity, $calibrationData, ['validate' => false]);
			if ($this->DocumentCalibration->save($entity)) {
				// Delete existing records
				$this->DocumentCalibrationReocrd->deleteAll(['doc_id' => $id]);

				$i = 1;
				if (isset($data['tool_equipment_description'])) {
					foreach ($data['tool_equipment_description'] as $tool_equipment_description) {
						if (!empty($tool_equipment_description)) {
							$recordData = [
								'doc_id' => $id,
								'tool_equipment_description' => $tool_equipment_description,
								'location' => isset($data['location'][$i]) ? $data['location'][$i] : null,
								'test_period' => isset($data['test_period'][$i]) ? $data['test_period'][$i] : null,
								'person_responsible' => isset($data['person_responsible'][$i]) ? $data['person_responsible'][$i] : null,
								'date_added' => isset($data['date_added'][$i]) ? $data['date_added'][$i] : null,
								'standard_identification' => isset($data['standard_identification'][$i]) ? $data['standard_identification'][$i] : null
							];
							$recordEntity = $this->DocumentCalibrationReocrd->newEntity($recordData, ['validate' => false]);
							$this->DocumentCalibrationReocrd->save($recordEntity);
						}
						$i++;
					}
				}
				$this->Flash->success('Calibration status of Instrument / Equipment updated Successfully.');
				return $this->redirect(['action' => 'calibration_equipment']);
			}
		}

		$docEntity = $this->DocumentCalibration->find()
			->contain(['DocumentCalibrationReocrd'])
			->where(['DocumentCalibration.id' => $id])
			->first();

		if ($docEntity) {
			$docData = $docEntity->toArray();
			$docArr = ['DocumentCalibration' => $docData];
			if ($docEntity->document_calibration_reocrd) {
				$docArr['DocumentCalibrationReocrd'] = [];
				foreach ($docEntity->document_calibration_reocrd as $record) {
					$docArr['DocumentCalibrationReocrd'][] = $record->toArray();
				}
			}
			$this->setRequest($this->getRequest()->withParsedBody($docArr));
		}
	}

	function nc_closure()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' NC and NC Closure');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		$query = $this->DocumentNcClosure->find()
			->contain([
				'NappUser' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'DocumentNcClosureRecord'
			])
			->where(['DocumentNcClosure.user_id' => $user_id])
			->orderDesc('DocumentNcClosure.id');

		$DocumentNcClosureArr = $this->paginate($query, ['limit' => 10]);

		// Convert entities to array format for view compatibility
		$DocumentNcClosureArrArray = [];
		foreach ($DocumentNcClosureArr as $doc) {
			$docData = $doc->toArray();
			$result = ['DocumentNcClosure' => $docData];
			// Extract NappUser association - always set even if empty
			if (isset($docData['napp_user']) && is_array($docData['napp_user'])) {
				$result['NappUser'] = $docData['napp_user'];
			} elseif (isset($doc->napp_user) && $doc->napp_user) {
				$result['NappUser'] = $doc->napp_user->toArray();
			} else {
				$result['NappUser'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			if ($doc->document_nc_closure_record) {
				$result['DocumentNcClosureRecord'] = [];
				foreach ($doc->document_nc_closure_record as $record) {
					$result['DocumentNcClosureRecord'][] = $record->toArray();
				}
			} else {
				$result['DocumentNcClosureRecord'] = [];
			}
			$DocumentNcClosureArrArray[] = $result;
		}
		$DocumentLibraryArr = $DocumentNcClosureArrArray;

		$this->set('DocumentLibraryArr', $DocumentLibraryArr);
	}

	public function add_ncclosure()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Add NC and NC Closure');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();

			$closureData = [
				'documentid' => isset($data['DocumentNcClosure']['documentid']) ? $data['DocumentNcClosure']['documentid'] : null,
				'date' => isset($data['DocumentNcClosure']['date']) ? $data['DocumentNcClosure']['date'] : null,
				'user_id' => $user_id,
				'created' => date('Y-m-d H:i:s')
			];

			$entity = $this->DocumentNcClosure->newEntity($closureData, ['validate' => false]);
			if ($this->DocumentNcClosure->save($entity)) {
				$doc_id = $entity->id;

				$recordData = [
					'doc_id' => $doc_id,
					'nc' => isset($data['DocumentNcClosureRecord']['nc']) ? $data['DocumentNcClosureRecord']['nc'] : null,
					'source_nc' => isset($data['DocumentNcClosureRecord']['source_nc']) ? $data['DocumentNcClosureRecord']['source_nc'] : null,
					'responsiblity' => isset($data['DocumentNcClosureRecord']['responsiblity']) ? $data['DocumentNcClosureRecord']['responsiblity'] : null,
					'root_cause' => isset($data['DocumentNcClosureRecord']['root_cause']) ? $data['DocumentNcClosureRecord']['root_cause'] : null,
					'action' => isset($data['DocumentNcClosureRecord']['action']) ? $data['DocumentNcClosureRecord']['action'] : null,
					'resource' => isset($data['DocumentNcClosureRecord']['resource']) ? $data['DocumentNcClosureRecord']['resource'] : null,
					'time' => isset($data['DocumentNcClosureRecord']['time']) ? $data['DocumentNcClosureRecord']['time'] : null,
					'closure' => isset($data['DocumentNcClosureRecord']['closure']) ? $data['DocumentNcClosureRecord']['closure'] : null
				];
				$recordEntity = $this->DocumentNcClosureRecord->newEntity($recordData, ['validate' => false]);
				$this->DocumentNcClosureRecord->save($recordEntity);

				$this->Flash->success('Added Successfully.');
				return $this->redirect(['action' => 'nc_closure']);
			}
		}

		$docEntity = $this->DocumentNcClosure->find()
			->orderDesc('DocumentNcClosure.id')
			->select(['DocumentNcClosure.id'])
			->first();
		$docArr = $docEntity ? ['DocumentNcClosure' => $docEntity->toArray()] : ['DocumentNcClosure' => ['id' => null]];
		$this->set('docArr', $docArr);

		if (!empty($docArr['DocumentNcClosure']['id'])) {
			$docId = 'DTDNC-' . (1000 + $docArr['DocumentNcClosure']['id'] + 1);
		} else {
			$docId = 'DTDNC-1001';
		}
		$this->set('docId', $docId);
	}

	public function edit_ncclosure($id = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Add NC and NC Closure');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();

			// Delete existing records
			$this->DocumentNcClosureRecord->deleteAll(['doc_id' => $id]);

			$i = 0;
			if (isset($data['DocumentNcClosureRecord']['nc'])) {
				foreach ($data['DocumentNcClosureRecord']['nc'] as $nc) {
					$recordData = [
						'doc_id' => $id,
						'nc' => $nc,
						'source_nc' => isset($data['DocumentNcClosureRecord']['source_nc'][$i]) ? $data['DocumentNcClosureRecord']['source_nc'][$i] : null,
						'responsiblity' => isset($data['DocumentNcClosureRecord']['responsiblity'][$i]) ? $data['DocumentNcClosureRecord']['responsiblity'][$i] : null,
						'root_cause' => isset($data['DocumentNcClosureRecord']['root_cause'][$i]) ? $data['DocumentNcClosureRecord']['root_cause'][$i] : null,
						'action' => isset($data['DocumentNcClosureRecord']['action'][$i]) ? $data['DocumentNcClosureRecord']['action'][$i] : null,
						'resource' => isset($data['DocumentNcClosureRecord']['resource'][$i]) ? $data['DocumentNcClosureRecord']['resource'][$i] : null,
						'time' => isset($data['DocumentNcClosureRecord']['time'][$i]) ? $data['DocumentNcClosureRecord']['time'][$i] : null,
						'closure' => isset($data['DocumentNcClosureRecord']['closure'][$i]) ? $data['DocumentNcClosureRecord']['closure'][$i] : null
					];
					$recordEntity = $this->DocumentNcClosureRecord->newEntity($recordData, ['validate' => false]);
					$this->DocumentNcClosureRecord->save($recordEntity);
					$i++;
				}
			}
			$this->Flash->success('Records Updated Successfully.');
			return $this->redirect(['action' => 'nc_closure']);
		}

		$docEntity = $this->DocumentNcClosure->find()
			->contain(['DocumentNcClosureRecord'])
			->where(['DocumentNcClosure.id' => $id])
			->first();

		if ($docEntity) {
			$docData = $docEntity->toArray();
			$DocumentNcClosureArr = ['DocumentNcClosure' => $docData];
			if ($docEntity->document_nc_closure_record) {
				$DocumentNcClosureArr['DocumentNcClosureRecord'] = [];
				foreach ($docEntity->document_nc_closure_record as $record) {
					$DocumentNcClosureArr['DocumentNcClosureRecord'][] = $record->toArray();
				}
			}
			$this->set('DocumentNcClosureArr', $DocumentNcClosureArr);
			$this->setRequest($this->getRequest()->withParsedBody($DocumentNcClosureArr));
		}
	}
}
