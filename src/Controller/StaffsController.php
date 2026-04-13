<?php
namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class StaffsController extends AppController {

/**
 * @var array
 */
	public $uses = array('User','PaymentSetup','Category','Product','Subscriber','Contact','Staff','NappUser','UserAnswer','LabFile','LabAssign','Coupon','UserPermission','Conformance','Department','ConformanceRelation','TaskDocuments','LoginHistory','Mailer','MailerComment','SpecUsearea');
	public $components = array('Paginator');	
	public function initialize(): void
	{
		parent::initialize();
		// CakePHP 3 does not support $uses; load legacy models explicitly.
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
		$this->loadModel('ConformanceRelation');
		$this->loadModel('TaskDocuments');
		$this->loadModel('LoginHistory');
		$this->loadModel('Mailer');
		$this->loadModel('MailerComment');
		$this->loadModel('SpecUsearea');
		$this->loadComponent('Paginator');
	}

	public function beforeFilter(EventInterface $event): ?Response
    {
		$result = parent::beforeFilter($event);
		if ($result instanceof Response) {
			return $result;
		}
		// Legacy controller code uses $this->Session->read()/write().
		$this->Session = $this->request->getSession();
		$this->callConstants();
		try {
			$permissions = $this->Session->read('Customer') ? $this->chkuserpermission() : [];
		} catch (\Throwable $e) {
			$permissions = [];
		}
		$this->set('chkuserpermission', $permissions);
		return null;
	}

	
	/***
	/*Author  :Ranjit,
	/*Comment : User Logout page
	****/	
	function logout()
	{
	
		$userId = $this->Session->read('Customer.id');
		$loginRec = $this->LoginHistory->find()
			->where(['logouttime' => '0000-00-00 00:00:00', 'user_id' => $userId])
			->orderDesc('id')
			->first();
		if($loginRec){
			$loginRec->logouttime = date('Y-m-d H:i:s');
			$this->LoginHistory->save($loginRec);
		}
		
		$this->Session->destroy();
		return $this->redirect('/login');
	}
	
	function activeaccount($semployeeid=null){
		
		$this->autoRender = false;
		
		if(!empty($semployeeid)){
			$email = base64_decode(base64_decode(base64_decode($semployeeid)));
			//$email = 'web@xoroglobal.com';
			$cus_arr = $this->NappUser->find('first',array('conditions'=>array('email'=>$email)));
			if(!empty($cus_arr)){
				$admin_arr = $this->User->find('first');	
				$insert['LoginHistory']['admin_id'] = $admin_arr['User']['id'];
				$insert['LoginHistory']['role'] = 'Admin';
				$insert['LoginHistory']['logintime'] = date('Y-m-d H:i:s');
				$this->LoginHistory->save($insert);
				
				$this->Session->write('User', $admin_arr['User']);
				$this->Session->write('is_admin', 1);
				$this->redirect('/admin/users/edit_staff/'.$cus_arr['NappUser']['id']);				
				
			}else{
				$this->Session->setFlash('Sorry staff id missing','default',array('class' => 'alert alert-success'));
				$this->redirect('/admin');
			}
		}else{
			$this->Session->setFlash('Sorry staff id missing','default',array('class' => 'alert alert-success'));
			$this->redirect('/admin');
		}	
		
	}	
	
	public function dashboard() {
		$this->layout='staff_inner_layout';
		$this->set('title_for_layout',SITENAME.' Staff Dashboard Page');
		$authRedirect = $this->checkSatffSession();
		if ($authRedirect instanceof Response) {
			return $authRedirect;
		}
				
		$customer_id=$this->Session->read('Customer.id');
		$cusEntity = $this->NappUser->find()
			->where(['id' => $customer_id])
			->first();
		$cus_arr = $cusEntity ? ['NappUser' => $cusEntity->toArray()] : [];
		$this->set('cus_arr',$cus_arr);

		return null;
	}

	function profile()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Profile Page');
		$this->checkSatffSession();
		$customer_id = $this->request->getSession()->read('Customer.id');

		$user = $customer_id ? $this->NappUser->find()->where(['NappUser.id' => $customer_id])->first() : null;

		if ($this->request->is('post')) {
			$data = $this->request->getData();
			if (!empty($user) && !empty($data['NappUser'])) {
				$user = $this->NappUser->patchEntity($user, $data['NappUser']);
				if ($this->NappUser->save($user)) {
					$this->Flash->success('Your profile has been updated');
					return $this->redirect(['action' => 'profile']);
				}
				$this->Flash->error('Your profile has not updated');
			}
		}

		$this->set('user', $user);
		$departmentResult = $this->Department->find()->orderAsc('department_title')->all();
		$departmentArr = [];
		foreach ($departmentResult as $dept) {
			$departmentArr[] = ['Department' => ['id' => $dept->id, 'department_title' => $dept->department_title ?? '']];
		}
		$this->set('departmentArr', $departmentArr);
	}
	
	/**
	 * Staff change password (URL: staffs/change_password → changePassword).
	 * NappUser passwords are stored as md5 (legacy).
	 */
	public function changePassword()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Change Password Page');
		$this->checkSatffSession();
		if ($this->request->is('post')) {
			$customer_id = $this->request->getSession()->read('Customer.id');
			$user = $customer_id ? $this->NappUser->find()->where(['NappUser.id' => $customer_id])->first() : null;
			if (!empty($user)) {
				$data = $this->request->getData('NappUser');
				$new = $data['new_password'] ?? '';
				$confirm = $data['confirm_password'] ?? '';
				$current = $data['current_password'] ?? '';
				if ($new !== '' && $new === $confirm) {
					$storedPassword = $user->get('password') ?? '';
					if (md5((string)$current) === $storedPassword) {
						$user->password = md5($new);
						$this->NappUser->save($user);
						$this->Flash->success('Your password has been changed successfully.');
						$this->request = $this->request->withData('NappUser', []);
					} else {
						$this->Flash->error('Current password not correct. Please, try again.');
					}
				} else {
					$this->Flash->error('New and confirm password do not match. Please, try again.');
				}
			} else {
				$this->Flash->error('User record not found. Please, try again.');
			}
		}
	}
	
	public function datasheet(): void
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Product Datasheet');
		$this->checkSatffSession();
		$user_id = $this->Session->read('Customer.id');

		$name = '';
		$category_id = '';

		$query = $this->Product->find()
			->contain(['Category'])
			->where([
				'Product.status' => 1,
				'Product.is_deleted' => 0,
			]);

		$data = $this->request->getData();
		$isPost = $this->request->is('post');
		if ($isPost) {
			$name = trim((string)($data['productname'] ?? ''));
			$category_id = $data['category_id'] ?? '';

			if ($category_id !== '' && $category_id !== null && $name !== '') {
				$query->where([
					'Product.category_id' => $category_id,
					'Product.title LIKE' => '%' . $name . '%',
				]);
				$query->where(function ($exp) {
					return $exp->and_([
						$exp->isNotNull('Product.datasheet'),
						$exp->notEq('Product.datasheet', ''),
					]);
				});
				$this->paginate = ['limit' => 20];
			} elseif ($category_id !== '' && $category_id !== null) {
				$query->where(['Product.category_id' => $category_id]);
				$this->paginate = ['limit' => 20];
			} elseif ($name !== '') {
				$query->where(['Product.title LIKE' => '%' . $name . '%']);
				$query->where(function ($exp) {
					return $exp->and_([
						$exp->isNotNull('Product.datasheet'),
						$exp->notEq('Product.datasheet', ''),
					]);
				});
				$this->paginate = ['limit' => 20];
			} else {
				$query->where(function ($exp) {
					return $exp->and_([
						$exp->isNotNull('Product.datasheet'),
						$exp->notEq('Product.datasheet', ''),
					]);
				});
				$this->paginate = [
					'limit' => 25,
					'order' => ['Product.title' => 'ASC'],
				];
			}
		} else {
			$query->where(function ($exp) {
				return $exp->and_([
					$exp->isNotNull('Product.datasheet'),
					$exp->notEq('Product.datasheet', ''),
				]);
			});
			$this->paginate = [
				'limit' => 25,
				'order' => ['Product.title' => 'ASC'],
			];
		}

		$results = $this->paginate($query);

		$productArr = [];
		foreach ($results as $entity) {
			$row = $entity->toArray();
			$cat = $row['category'] ?? [];
			unset($row['category']);
			$productArr[] = ['Product' => $row, 'Category' => $cat];
		}

		$this->set('productArr', $productArr);
		$this->set('category_id', $category_id);
		$this->set('name', $name);

		$categoryArr = [];
		foreach (
			$this->Category->find()
				->where(['Category.is_deteled' => 0, 'Category.status' => 1])
				as $catEntity
		) {
			$categoryArr[] = ['Category' => $catEntity->toArray()];
		}
		$this->set('categoryArr', $categoryArr);

		$upermission = [];
		foreach (
			$this->UserPermission->find()
				->where(['UserPermission.user_id' => $user_id])
				as $up
		) {
			$upermission[] = ['UserPermission' => $up->toArray()];
		}
		$this->set('upermission', $upermission);
	}	
	
	public function document($product_code = null, $type = null, $num = null): ?Response
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Product Datasheet');
		$this->checkSatffSession();

		if (!empty($product_code) && !empty($type)) {
			$decoded = base64_decode((string)$product_code, true);
			$code = $decoded !== false ? $decoded : (string)$product_code;
			$entity = $this->Product->find()
				->where(['Product.product_code' => $code])
				->first();

			if (empty($entity)) {
				$this->Flash->error('Something missing.');
				return $this->redirect(['action' => 'datasheet']);
			}
			$this->set('data', ['Product' => $entity->toArray()]);
			$this->set('type', $type);
			$this->set('num', $num);

			return null;
		}
		$this->Flash->error('Something missing.');
		return $this->redirect(['action' => 'datasheet']);
	}
	
	function autologin($conformance_id=null){
		
		$this->autoRender = false;
		
		$ConformanceArr = $this->Conformance->find('first',array('conditions'=>array('Conformance.id'=>base64_decode($conformance_id))));
		if(!empty($ConformanceArr)){
			
			$userArr  = $this->User->find('first',array('conditions'=>array('User.id'=>2)));
			$insert['LoginHistory']['admin_id'] = $userArr['User']['id'];
			$insert['LoginHistory']['role'] = 'Admin';
			$insert['LoginHistory']['logintime'] = date('Y-m-d H:i:s');
			$this->LoginHistory->save($insert);
			if(!empty($userArr)){				
				$this->Session->write('User', $userArr['User']);
				$this->Session->write('is_admin', 1);			
				$this->redirect('/admin/staffs/replyto/'.$conformance_id);
			}			
		}else{
			$this->redirect('/admin');
		}	
			
	}	
	
	function replyto($conformance_id=null,$emp_id=null){
		$this->layout='staff_inner_layout';
		$this->set('title_for_layout',SITENAME.' Conformance Reply');
		$this->checkSatffSession();
	
		$user_id=$this->Session->read('Customer.id');
		$dept_id=$this->Session->read('Customer.dept_id');
		
		$Department = $this->Department->find('first',array('Department.id'=>$dept_id));
		
		$name = $this->Session->read('Customer.name').' '.$this->Session->read('Customer.lname').' ('.$Department['Department']['department_title'].')';
				
		$this->ConformanceRelation->bindModel(
		array('belongsTo' => array('Conformance' => array(
			'className' => 'Conformance',			 
			'foreignKey' => 'conformance_id',				
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));
		$ConformanceArr = $this->ConformanceRelation->find('first',array('conditions'=>array('ConformanceRelation.emp_id'=>base64_decode($emp_id),'ConformanceRelation.conformance_id'=>base64_decode($conformance_id))));	
				
		if(!empty($this->request->data)){
						
			$conformance_id = $ConformanceArr['Conformance']['id'];					
			$ConformanceRelation_id = $ConformanceArr['ConformanceRelation']['id'];						
			$updaterelation['ConformanceRelation']['id'] =  $ConformanceRelation_id;		
			
			$updaterelation['ConformanceRelation']['corrective_action_taken'] =  $this->request->data['Conformance']['corrective_action_taken'];
			//$updaterelation['ConformanceRelation']['preventive_action'] =  $this->request->data['Conformance']['preventive_action'];
			$updaterelation['ConformanceRelation']['created'] =  date('Y-m-d H:i:s');
			$this->ConformanceRelation->save($updaterelation);
			
			// send email to intiative
			$compaint_by = $ConformanceArr['Conformance']['compaint_by'];			
			$NappUserArr = $this->NappUser->find('first',array('conditions'=>array('NappUser.id'=>$compaint_by)));			
			$to_email = $NappUserArr['NappUser']['email'];
			//$to_email = 'web@xoroglobal.com';
			$to_name  = $NappUserArr['NappUser']['name'];	
			$subject = SITENAME." :: Non Conformance ".$ConformanceArr['Conformance']['nc_number']." By ".$this->Session->read('Customer.name');				
			$template_name = 'replyconformance';	
			$non_conforance = $ConformanceArr['Conformance']['non_conforance'];			
			$variables = array('name'=>$this->Session->read('Customer.name'),'to_name'=>$to_name,'title'=>$non_conforance,'nc_number'=>$ConformanceArr['Conformance']['nc_number']);		
			try{
				$this->sendemail($to_email,$subject,$template_name,$variables);
			}catch (Exception $e){
				
			}	
			
			$admin_email = 'kal@durotechindustries.com.au';
			#$admin_email = 'web@xoroglobal.com';
			$admin_subject = SITENAME." :: Non Conformance ".$ConformanceArr['Conformance']['nc_number']." By ".$this->Session->read('Customer.name');

			$autologinurl = SITEURL.'staffs/autologin/'.base64_encode($ConformanceArr['Conformance']['id']);	
			$admin_template_name = 'autoreplyconformance';	
			$non_conforance = $ConformanceArr['Conformance']['non_conforance'];			
			$admin_variables = array('autologinurl'=>$autologinurl,'name'=>$this->Session->read('Customer.name'),'to_name'=>'Kal','title'=>$non_conforance,'nc_number'=>$ConformanceArr['Conformance']['nc_number']);		
			try{
				$this->sendemail($admin_email,$admin_subject,$admin_template_name,$admin_variables);
			}catch (Exception $e){
				
			}
			
			$updateConformance['Conformance']['id'] =  $conformance_id;			
		 	if(!empty($this->request->data['Conformance']['corrective_action_taken'])){
				$updateConformance['Conformance']['corrective_action_taken'] =  $this->request->data['Conformance']['corrective_action_taken'];
				$updateConformance['Conformance']['is_corrective'] =  $name;
			}
		/*	
			if(!empty($this->request->data['Conformance']['preventive_action'])){
				$updateConformance['Conformance']['preventive_action'] =  $this->request->data['Conformance']['preventive_action'];
				$updateConformance['Conformance']['is_preventive'] =  $name;
			}	 */
			$updateConformance['Conformance']['why_1'] =  $this->request->data['Conformance']['why_1'];	
			$updateConformance['Conformance']['why_2'] =  $this->request->data['Conformance']['why_2'];	
			$updateConformance['Conformance']['why_3'] =  $this->request->data['Conformance']['why_3'];	
			$updateConformance['Conformance']['why_4'] =  $this->request->data['Conformance']['why_4'];	
			$updateConformance['Conformance']['why_5'] =  $this->request->data['Conformance']['why_5'];	
			
			if($this->request->data['Conformance']['why_1'] !=  '' || $this->request->data['Conformance']['why_2'] !=  '' || $this->request->data['Conformance']['why_3'] !=  '' || $this->request->data['Conformance']['why_4'] !=  '' || $this->request->data['Conformance']['why_5'] !=  ''){
				$updateConformance['Conformance']['is_corrective'] =  $name;
			}
			$updateConformance['Conformance']['status'] = 2;	
			$updateConformance['Conformance']['created'] =  date('Y-m-d H:i:s');
			$this->Conformance->save($updateConformance);
			
			if(!empty($this->request->data['ConformanceRelationnew']['emp_id'])){
				
				$emp_id = $this->request->data['ConformanceRelationnew']['emp_id'];
				$insertrelation['ConformanceRelation']['id'] =  '';		
				$insertrelation['ConformanceRelation']['conformance_id'] =  $conformance_id;		
				$insertrelation['ConformanceRelation']['emp_id'] = $emp_id;					
				$this->ConformanceRelation->save($insertrelation);
				
				
				// $template_name = 'replyconformance';	
				// $non_conforance = $ConformanceArr['Conformance']['non_conforance'];			
				// $variables = array('name'=>$this->Session->read('Customer.name'),'to_name'=>$to_name,'title'=>$non_conforance,'nc_number'=>$ConformanceArr['Conformance']['nc_number']);		
				// try{
					// $this->sendemail($to_email,$subject,$template_name,$variables);
				// }catch (Exception $e){
					
				// }	
				
			}	
		
			$this->Session->setFlash('Replied successfully','default',array('class' => 'alert alert-success'));
			$this->redirect('conformancelist');
		}	
		$this->set('conformanceArr',$ConformanceArr);
		
		$confrel = $this->ConformanceRelation->find('list',array('conditions'=>array('ConformanceRelation.conformance_id'=>base64_decode($conformance_id)),'fields'=>array('emp_id')));	
		
		$NappUser = $this->NappUser->find('all',array('conditions'=>array('NappUser.id !='=>$confrel,'NappUser.is_staff_id'=>1)));
		$this->set('NappUser',$NappUser);
		$this->set('user_id',$user_id);
	
	}	
	function conformance($complaint_id=null){
		
		$this->layout='staff_inner_layout';
		$this->set('title_for_layout',SITENAME.' Conformance List');
		$this->checkSatffSession();
		
		if(!empty($complaint_id)){
			$complaint_id = base64_decode($complaint_id);
			
			$complaintArr = $this->Conformance->find('first',array('conditions'=>array('Conformance.complaintid'=>$complaint_id)));
			if(!empty($complaintArr)){
				$this->redirect('index');
			}	
		}else{
			$complaint_id = 0;
		}	
		
		
		
		$user_id=$this->Session->read('Customer.id');			
		$name=$this->Session->read('Customer.name');	
		if(!empty($this->request->data)){
			
			$confirm = $this->Conformance->find('first',array('order'=>array('Conformance.id'=>'DESC')));
			$randnumber = 1000 + $confirm['Conformance']['id'];		
		
			$this->request->data['Conformance']['nc_number'] = 'DT-NCR-'.$randnumber;				
			$this->request->data['Conformance']['compaint_by'] = $user_id;				
			$this->request->data['Conformance']['status'] = 1;	
					
			$this->request->data['Conformance']['complaintid'] = $complaint_id;				
			$this->request->data['Conformance']['created'] = date('Y-m-d H:i:s');	
			
			//ConformanceRelation
			$this->Conformance->save($this->request->data);	


			$compaint_to = $this->request->data['Conformance']['compaint_to'];
			$NappUserArr = $this->NappUser->find('first',array('conditions'=>array('NappUser.id'=>$compaint_to)));			
			$to_email = $NappUserArr['NappUser']['email'];
			$to_name  = $NappUserArr['NappUser']['name'];	
			$subject = SITENAME." :: Non Conformance DT-NC-".$randnumber." By ".ucfirst($name);				
			$template_name = 'conformance';	
			$non_conforance = $this->request->data['Conformance']['non_conforance'];			
			$variables = array('name'=>$name,'to_name'=>$to_name,'title'=>$non_conforance);		
			try{
				$this->sendemail($to_email,$subject,$template_name,$variables);
			}catch (Exception $e){
				
			}		
			
			$conformance_id = $this->Conformance->id;
				// assign to
			$instConformanceRelation['ConformanceRelation']['id'] = '';
			$instConformanceRelation['ConformanceRelation']['conformance_id'] = $conformance_id;
			$instConformanceRelation['ConformanceRelation']['emp_id'] = $user_id;
			$this->ConformanceRelation->save($instConformanceRelation);
				// assig by
			$instConformanceRelation['ConformanceRelation']['id'] = '';
			$instConformanceRelation['ConformanceRelation']['conformance_id']  = $conformance_id;
			$instConformanceRelation['ConformanceRelation']['emp_id'] = $this->request->data['Conformance']['compaint_to'];
			$this->ConformanceRelation->save($instConformanceRelation);
			
			$this->Session->setFlash('Generated successfully','default',array('class' => 'alert alert-success'));
			$this->redirect('conformancelist');
		}
		$department = $this->Department->find('all');
		$this->set('departmentArr',$department);

		$NappUser = $this->NappUser->find('all',array('conditions'=>array('NappUser.id !='=>$user_id,'NappUser.is_staff_id'=>1)));
		$this->set('NappUser',$NappUser);	
		
	}	
	
	// function detail($complaint_id=null){
		
		// $this->layout='staff_inner_layout';
		// $this->set('title_for_layout',SITENAME.' Conformance List');
		// $this->checkSatffSession();
		// $user_id=$this->Session->read('Customer.id');
		
		// $this->Conformance->find('first',array('conditions'=>array('Conformance.id')));
	// }	
	
	function conformancelist(){
		
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout',SITENAME.' Conformance List');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');
		
		// Get conformance IDs where user is assigned
		$confrelEntities = $this->ConformanceRelation->find()
			->select(['conformance_id'])
			->where(['ConformanceRelation.emp_id' => $user_id])
			->toArray();
		$confrel = [];
		foreach ($confrelEntities as $entity) {
			$confrel[] = $entity->conformance_id;
		}
		
		// Build query with associations using contain() instead of bindModel()
		$query = $this->Conformance->find()
			->contain([
				'NappUser1' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'Department',
				'User' => function($q) {
					return $q->select(['id', 'name']);
				},
				'ConformanceRelation' => [
					'NappUser' => function($q) {
						return $q->select(['id', 'name', 'lname']);
					}
				],
				'TaskDocuments'
			]);
		
		// Apply conditions - filter by conformance IDs where user is assigned
		if (!empty($confrel)) {
			$query->where(['Conformance.id IN' => $confrel]);
		} else {
			// If no conformances found, return empty result
			$query->where(['Conformance.id' => 0]);
		}
		
		$query->orderDesc('Conformance.id');
		
		// Paginate using CakePHP 3 style
		$ConformanceArr = $this->paginate($query, ['limit' => 25]);
		
		// Convert entities to CakePHP 2 style array for view compatibility
		// View expects: ['Conformance' => [...], 'NappUser1' => [...], 'ConformanceRelation' => [...]]
		$ConformanceArrArray = [];
		foreach ($ConformanceArr as $conformance) {
			$conformanceData = $conformance->toArray();
			
			// Extract main Conformance data (remove association keys)
			$conformanceMain = $conformanceData;
			unset($conformanceMain['napp_user1'], $conformanceMain['department'], 
			      $conformanceMain['user'], $conformanceMain['conformance_relation'], 
			      $conformanceMain['task_documents']);
			
			$result = ['Conformance' => $conformanceMain];
			
			// Extract NappUser1 association
			if (isset($conformanceData['napp_user1']) && is_array($conformanceData['napp_user1'])) {
				$result['NappUser1'] = $conformanceData['napp_user1'];
			} elseif (isset($conformance->napp_user1) && $conformance->napp_user1) {
				$result['NappUser1'] = $conformance->napp_user1->toArray();
			} else {
				$result['NappUser1'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			
			// Extract Department association
			if (isset($conformanceData['department']) && is_array($conformanceData['department'])) {
				$result['Department'] = $conformanceData['department'];
			} elseif (isset($conformance->department) && $conformance->department) {
				$result['Department'] = $conformance->department->toArray();
			}
			
			// Extract User association
			if (isset($conformanceData['user']) && is_array($conformanceData['user'])) {
				$result['User'] = $conformanceData['user'];
			} elseif (isset($conformance->user) && $conformance->user) {
				$result['User'] = $conformance->user->toArray();
			}
			
			// Extract ConformanceRelation (hasMany)
			$result['ConformanceRelation'] = [];
			if (isset($conformanceData['conformance_relation']) && is_array($conformanceData['conformance_relation'])) {
				foreach ($conformanceData['conformance_relation'] as $rel) {
					$relArray = is_array($rel) ? $rel : $rel->toArray();
					// Map nested NappUser association
					if (isset($relArray['napp_user']) && is_array($relArray['napp_user'])) {
						$relArray['NappUser'] = $relArray['napp_user'];
						unset($relArray['napp_user']);
					} elseif (isset($rel->napp_user) && $rel->napp_user) {
						$relArray['NappUser'] = $rel->napp_user->toArray();
					}
					$result['ConformanceRelation'][] = $relArray;
				}
			} elseif (isset($conformance->conformance_relation) && !empty($conformance->conformance_relation)) {
				foreach ($conformance->conformance_relation as $rel) {
					$relArray = $rel->toArray();
					if (isset($rel->napp_user) && $rel->napp_user) {
						$relArray['NappUser'] = $rel->napp_user->toArray();
					}
					$result['ConformanceRelation'][] = $relArray;
				}
			}
			
			// Extract TaskDocuments (hasMany)
			$result['TaskDocuments'] = [];
			if (isset($conformanceData['task_documents']) && is_array($conformanceData['task_documents'])) {
				foreach ($conformanceData['task_documents'] as $doc) {
					$result['TaskDocuments'][] = is_array($doc) ? $doc : $doc->toArray();
				}
			} elseif (isset($conformance->task_documents) && !empty($conformance->task_documents)) {
				foreach ($conformance->task_documents as $doc) {
					$result['TaskDocuments'][] = $doc->toArray();
				}
			}
			
			// Also provide TaskDocument (singular) for backward compatibility with views
			$result['TaskDocument'] = $result['TaskDocuments'];
			
			$ConformanceArrArray[] = $result;
		}
		$ConformanceArr = $ConformanceArrArray;
		
		$this->set('ConformanceArr',$ConformanceArr);
		$this->set('user_id',$user_id);	
		
		// Convert User query to CakePHP 3
		$users = $this->User->find()
			->where(['User.is_investigate' => 1])
			->select(['name'])
			->toArray();
		
		// Convert to CakePHP 2 style array for view compatibility
		$UserArr = [];
		foreach ($users as $user) {
			$UserArr[] = ['User' => $user->toArray()];
		}
		$this->set('UserArr',$UserArr);	
	}
	
	function detail($nc_number=null,$type=null){
		
		$this->layout='staff_inner_layout';
		$this->set('title_for_layout',SITENAME.' Conformance Detail');
		$this->checkSatffSession();
		 $user_id=$this->Session->read('Customer.id');
		
		$confrel = $this->ConformanceRelation->find('list',array('conditions'=>array('ConformanceRelation.emp_id'=>$user_id),'fields'=>array('conformance_id')));	
		
		$this->Conformance->bindModel(
		array('belongsTo' => array('NappUser1' => array(
			'className' => 'NappUser',			 
			'foreignKey' => 'compaint_by',				
			'conditions' => array(),
			'fields' => array('name','lname','id'),
			'order' => array(),
		))));

		
		$this->Conformance->bindModel(
		array('belongsTo' => array('Department' => array(
			'className' => 'Department',			 
			'foreignKey' => 'dept_id',				
			'conditions' => array(),
			'fields' => '',
			'order' => array(),
		))));
		
		$this->Conformance->bindModel(
		array('hasMany' => array('ConformanceRelation' => array(
			'className' => 'ConformanceRelation',			 
			'foreignKey' => 'conformance_id',				
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));
		$this->ConformanceRelation->bindModel(
		array('belongsTo' => array('NappUser' => array(
			'className' => 'NappUser',			 
			'foreignKey' => 'emp_id',				
			'conditions' => array(),
			'fields' => array('name','lname','id'),
			'order' => array(),
		))));
		$this->Conformance->bindModel(
		array('belongsTo' => array('User' => array(
			'className' => 'User',			 
			'foreignKey' => 'admin_id',				
			'conditions' => array(),
			'fields' => array('name'),
			'order' => array(),
		))));
		$this->Conformance->bindModel(
		array('belongsTo' => array('Complaint' => array(
			'className' => 'Complaint',			 
			'foreignKey' => 'complaintid',				
			'conditions' => array('complaintid'),
			'fields' => '',
			'order' => array(),
		))));
		$this->Conformance->bindModel(
		array('hasMany' => array('TaskDocument'=>array(
			'className' => 'TaskDocument',			 
			'foreignKey' => 'con_id',				
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));
		$nc_number = base64_decode($nc_number);
		$this->Conformance->recursive = 3;
		$ConformanceArr = $this->Conformance->find('first',array('conditions'=>array('Conformance.nc_number'=>$nc_number)));
		
		$this->set('ComplaintArr',$ConformanceArr);
		$this->set('type',$type);
		$this->set('user_id',$user_id);	
		
		$UserArr = $this->User->find('all',array('conditions'=>array('User.is_investigate'=>1),'fields'=>array('name')));
		$this->set('UserArr',$UserArr);		
		
	}

	public function adminDetail($nc_number = null, $type = null)
	{
		return $this->admin_detail($nc_number, $type);
	}
	
	function admin_detail($nc_number=null,$type=null){
		
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Conformance Detail');
		$this->checkAdminSession();
		
		$nc_number = base64_decode($nc_number);
		
		// Build query with associations using contain() instead of bindModel()
		$query = $this->Conformance->find()
			->contain([
				'NappUser1' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'Department',
				'User' => function($q) {
					return $q->select(['id', 'name']);
				},
				'ConformanceRelation' => [
					'NappUser' => function($q) {
						return $q->select(['id', 'name', 'lname']);
					}
				],
				'TaskDocuments'
			])
			->where(['Conformance.nc_number' => $nc_number]);
		
		$conformance = $query->first();
		
		if (!$conformance) {
			$this->Flash->error('Conformance not found.');
			return $this->redirect(['action' => 'conformancelist']);
		}
		
		// Convert entity to CakePHP 2 style array for view compatibility
		$conformanceData = $conformance->toArray();
		
		// Extract main Conformance data (remove association keys)
		$conformanceMain = $conformanceData;
		unset($conformanceMain['napp_user1'], $conformanceMain['department'], 
		      $conformanceMain['user'], $conformanceMain['conformance_relation'], 
		      $conformanceMain['task_documents']);
		
		$result = ['Conformance' => $conformanceMain];
		
		// Extract NappUser1 association
		if (isset($conformanceData['napp_user1']) && is_array($conformanceData['napp_user1'])) {
			$result['NappUser1'] = $conformanceData['napp_user1'];
		} elseif (isset($conformance->napp_user1) && $conformance->napp_user1) {
			$result['NappUser1'] = $conformance->napp_user1->toArray();
		} else {
			$result['NappUser1'] = ['id' => null, 'name' => '', 'lname' => ''];
		}
		
		// Extract Department association
		if (isset($conformanceData['department']) && is_array($conformanceData['department'])) {
			$result['Department'] = $conformanceData['department'];
		} elseif (isset($conformance->department) && $conformance->department) {
			$result['Department'] = $conformance->department->toArray();
		}
		
		// Extract User association
		if (isset($conformanceData['user']) && is_array($conformanceData['user'])) {
			$result['User'] = $conformanceData['user'];
		} elseif (isset($conformance->user) && $conformance->user) {
			$result['User'] = $conformance->user->toArray();
		}
		
		// Extract ConformanceRelation (hasMany)
		$result['ConformanceRelation'] = [];
		if (isset($conformanceData['conformance_relation']) && is_array($conformanceData['conformance_relation'])) {
			foreach ($conformanceData['conformance_relation'] as $rel) {
				$relArray = is_array($rel) ? $rel : $rel->toArray();
				// Map nested NappUser association
				if (isset($relArray['napp_user']) && is_array($relArray['napp_user'])) {
					$relArray['NappUser'] = $relArray['napp_user'];
					unset($relArray['napp_user']);
				} elseif (isset($rel->napp_user) && $rel->napp_user) {
					$relArray['NappUser'] = $rel->napp_user->toArray();
				}
				$result['ConformanceRelation'][] = $relArray;
			}
		} elseif (isset($conformance->conformance_relation) && !empty($conformance->conformance_relation)) {
			foreach ($conformance->conformance_relation as $rel) {
				$relArray = $rel->toArray();
				if (isset($rel->napp_user) && $rel->napp_user) {
					$relArray['NappUser'] = $rel->napp_user->toArray();
				}
				$result['ConformanceRelation'][] = $relArray;
			}
		}
		
		// Extract TaskDocuments (hasMany)
		$result['TaskDocuments'] = [];
		if (isset($conformanceData['task_documents']) && is_array($conformanceData['task_documents'])) {
			foreach ($conformanceData['task_documents'] as $doc) {
				$result['TaskDocuments'][] = is_array($doc) ? $doc : $doc->toArray();
			}
		} elseif (isset($conformance->task_documents) && !empty($conformance->task_documents)) {
			foreach ($conformance->task_documents as $doc) {
				$result['TaskDocuments'][] = $doc->toArray();
			}
		}
		
		// Also provide TaskDocument (singular) for backward compatibility with views
		$result['TaskDocument'] = $result['TaskDocuments'];
		
		$ConformanceArr = $result;
		
		$this->set('ComplaintArr',$ConformanceArr);
		$this->set('type',$type);
		
		// Convert User query to CakePHP 3
		$users = $this->User->find()
			->where(['User.is_investigate' => 1])
			->select(['name'])
			->toArray();
		
		// Convert to CakePHP 2 style array for view compatibility
		$UserArr = [];
		foreach ($users as $user) {
			$UserArr[] = ['User' => $user->toArray()];
		}
		$this->set('UserArr',$UserArr);	
	
	}
	
	/**
	 * CamelCase wrapper for admin_replyto
	 */
	public function adminReplyto($id = null)
	{
		return $this->admin_replyto($id);
	}
	
	function admin_replyto($id=null){
		
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Conformance Reply');
		$this->checkAdminSession();
		$admin_id = $this->request->getSession()->read('User.id');
		
		// Decode id if it's base64 encoded (from URL)
		$conformance_id = $id;
		$decoded_id = base64_decode($id, true);
		if ($decoded_id !== false && is_numeric($decoded_id)) {
			$conformance_id = (int)$decoded_id;
		} elseif (is_numeric($id)) {
			$conformance_id = (int)$id;
		}
					
		$ConformanceEntity = $this->Conformance->find()
			->where(['Conformance.id' => $conformance_id])
			->first();
		
		if (!$ConformanceEntity) {
			$this->Flash->error('Conformance record not found');
			return $this->redirect(['action' => 'admin_conformancelist']);
		}
		
		// Convert to array format for view compatibility
		$ConformanceArr = ['Conformance' => $ConformanceEntity->toArray()];
					
		if(!empty($this->request->getData())){		
			
			$data = $this->request->getData();
			
			$compaint_by = $ConformanceArr['Conformance']['compaint_by'];
			$NappUserEntity = $this->NappUser->find()
				->where(['NappUser.id' => $compaint_by])
				->first();
			
			if ($NappUserEntity) {
				$to_email = $NappUserEntity->email;
				$to_name = $NappUserEntity->name;
				$subject = SITENAME." :: Non Conformance ".$ConformanceArr['Conformance']['nc_number']." By ".$this->request->getSession()->read('User.name');				
				$template_name = 'replyconformance';	
				$non_conforance = $ConformanceArr['Conformance']['non_conforance'];			
				$variables = [
					'name' => $this->request->getSession()->read('User.name'),
					'to_name' => $to_name,
					'title' => $non_conforance,
					'nc_number' => $ConformanceArr['Conformance']['nc_number']
				];		
				try{
					if(isset($data['Conformance']['status']) && $data['Conformance']['status'] > 1){
						//$this->sendemail($to_email,$subject,$template_name,$variables);
					}
				}catch (\Exception $e){
					
				}
			}
			
			$conformance_id = $ConformanceArr['Conformance']['id'];
			
			// Update using entity-based save
			$entity = $this->Conformance->get($conformance_id);
			$updateData = [
				'admin_id' => $admin_id,
				'short_term' => isset($data['Conformance']['short_term']) ? $data['Conformance']['short_term'] : null,
				'follow_up' => isset($data['Conformance']['follow_up']) ? $data['Conformance']['follow_up'] : null,
				'corrective_action_successfull' => isset($data['Conformance']['corrective_action_successfull']) ? $data['Conformance']['corrective_action_successfull'] : null,
				'support_document' => isset($data['Conformance']['support_document']) ? $data['Conformance']['support_document'] : null,
				'ncr_closed_date' => isset($data['Conformance']['ncr_closed_date']) ? $data['Conformance']['ncr_closed_date'] : null,
				'status' => isset($data['Conformance']['status']) ? $data['Conformance']['status'] : null
			];
			
			if(isset($data['Conformance']['status']) && $data['Conformance']['status'] == 3){
				$updateData['complete_date'] = date('Y-m-d H:i:s');
			}
			
			$entity = $this->Conformance->patchEntity($entity, $updateData, ['validate' => false]);
			$this->Conformance->save($entity);
			
			$this->Flash->success('Replied successfully');
			return $this->redirect(['action' => 'admin_conformancelist']);
		}	
		$this->set('conformanceArr',$ConformanceArr);
		
		
	}

	/**
	 * CamelCase wrapper for admin_conformancelist
	 */
	public function adminConformancelist()
	{
		return $this->admin_conformancelist();
	}
	
	function admin_conformancelist(){
		
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Conformance List');
		$this->checkAdminSession();
		$user_id=$this->request->getSession()->read('Customer.id');
	
		$nc_number = '';		
		// Use CakePHP 3 query builder with contain() to load associations
		// Associations are now defined in ConformanceTable class
		
		$query = $this->Conformance->find()
			->contain([
				'NappUser1' => function($q) {
					return $q->select(['id', 'name', 'lname']);
				},
				'Department',
				'User' => function($q) {
					return $q->select(['id', 'name']);
				},
				'ConformanceRelation' => [
					'NappUser' => function($q) {
						return $q->select(['id', 'name', 'lname', 'dept_id'])
							->contain(['Department' => function($q) {
								return $q->select(['id', 'department_title']);
							}]);
					}
				],
				'TaskDocuments'
			]);
		
		// Apply conditions based on nc_number search
		if(!empty($this->request->getData('nc_number'))){
			$nc_number = $this->request->getData('nc_number');	
			$query->where(['Conformance.nc_number' => $nc_number]);
		}
		
		$query->orderDesc('Conformance.id');
		
		$ConformanceArr = $this->paginate($query, ['limit' => 25]);
		
		// Convert entities to CakePHP 2 style array for view compatibility
		// View expects: ['Conformance' => [...], 'NappUser1' => [...], 'ConformanceRelation' => [...]]
		$ConformanceArrArray = [];
		foreach ($ConformanceArr as $conformance) {
			$conformanceData = $conformance->toArray();
			
			// Extract main Conformance data (remove association keys)
			$conformanceMain = $conformanceData;
			unset($conformanceMain['napp_user1'], $conformanceMain['department'], 
			      $conformanceMain['user'], $conformanceMain['conformance_relation'], 
			      $conformanceMain['task_documents']);
			
			$result = ['Conformance' => $conformanceMain];
			
			// Extract NappUser1 association
			if (isset($conformanceData['napp_user1']) && is_array($conformanceData['napp_user1'])) {
				$result['NappUser1'] = $conformanceData['napp_user1'];
			} elseif (isset($conformance->napp_user1) && $conformance->napp_user1) {
				$result['NappUser1'] = $conformance->napp_user1->toArray();
			} else {
				$result['NappUser1'] = ['id' => null, 'name' => '', 'lname' => ''];
			}
			
			// Extract Department association
			if (isset($conformanceData['department']) && is_array($conformanceData['department'])) {
				$result['Department'] = $conformanceData['department'];
			} elseif (isset($conformance->department) && $conformance->department) {
				$result['Department'] = $conformance->department->toArray();
			}
			
			// Extract User association
			if (isset($conformanceData['user']) && is_array($conformanceData['user'])) {
				$result['User'] = $conformanceData['user'];
			} elseif (isset($conformance->user) && $conformance->user) {
				$result['User'] = $conformance->user->toArray();
			}
			
			// Extract ConformanceRelation (hasMany)
			$result['ConformanceRelation'] = [];
			if (isset($conformanceData['conformance_relation']) && is_array($conformanceData['conformance_relation'])) {
				foreach ($conformanceData['conformance_relation'] as $rel) {
					$relArray = is_array($rel) ? $rel : $rel->toArray();
					// Map nested NappUser association
					if (isset($relArray['napp_user']) && is_array($relArray['napp_user'])) {
						$relArray['NappUser'] = $relArray['napp_user'];
						unset($relArray['napp_user']);
						// Map nested Department
						if (isset($relArray['NappUser']['department']) && is_array($relArray['NappUser']['department'])) {
							$relArray['NappUser']['Department'] = $relArray['NappUser']['department'];
							unset($relArray['NappUser']['department']);
						}
					} elseif (isset($rel->napp_user) && $rel->napp_user) {
						$relArray['NappUser'] = $rel->napp_user->toArray();
						if (isset($rel->napp_user->department) && $rel->napp_user->department) {
							$relArray['NappUser']['Department'] = $rel->napp_user->department->toArray();
						}
					}
					$result['ConformanceRelation'][] = $relArray;
				}
			} elseif (isset($conformance->conformance_relation) && !empty($conformance->conformance_relation)) {
				foreach ($conformance->conformance_relation as $rel) {
					$relArray = $rel->toArray();
					if (isset($rel->napp_user) && $rel->napp_user) {
						$relArray['NappUser'] = $rel->napp_user->toArray();
						if (isset($rel->napp_user->department) && $rel->napp_user->department) {
							$relArray['NappUser']['Department'] = $rel->napp_user->department->toArray();
						}
					}
					$result['ConformanceRelation'][] = $relArray;
				}
			}
			
			// Extract TaskDocuments (hasMany)
			$result['TaskDocuments'] = [];
			if (isset($conformanceData['task_documents']) && is_array($conformanceData['task_documents'])) {
				foreach ($conformanceData['task_documents'] as $doc) {
					$result['TaskDocuments'][] = is_array($doc) ? $doc : $doc->toArray();
				}
			} elseif (isset($conformance->task_documents) && !empty($conformance->task_documents)) {
				foreach ($conformance->task_documents as $doc) {
					$result['TaskDocuments'][] = $doc->toArray();
				}
			}
			
			// Also provide TaskDocument (singular) for backward compatibility with views
			$result['TaskDocument'] = $result['TaskDocuments'];
			
			$ConformanceArrArray[] = $result;
		}
		$ConformanceArr = $ConformanceArrArray;
		
		
		// echo '<pre>';
		// print_r($ConformanceArr);
		// die();
		
		$this->set('ConformanceArr',$ConformanceArr);
		$this->set('user_id',$user_id);	
		$this->set('nc_number',$nc_number);	
				
		$users = $this->User->find()
			->where(['User.is_investigate' => 1])
			->select(['name'])
			->toArray();
		
		// Convert to CakePHP 2 style array for view compatibility
		$UserArr = [];
		foreach ($users as $user) {
			$UserArr[] = ['User' => $user->toArray()];
		}
		$this->set('UserArr',$UserArr);	
	}	
	function sendsms(){
		
		$this->autoRender = false;
		
		$confirgArr =$this->Config->find('first');
				
		$sid = TSID;	
		$token = TOKEN;	
		$to = '+61402963688';	
		$from = FROM_NUMBER;	
		$message = 'Test Message';	
		
		$url = SITEURL."twilio/index.php";						
		$fields = array(
			'sid' => urlencode($sid),
			'token' => urlencode($token),							
			'to' => urlencode($to),							
			'from' => urlencode($from),							
			'message' => urlencode($message),							
		);	
		$fields_string = '';
		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
		//open connection
		$ch = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);
			
		echo '<pre>';
		print_r($result);
		die();	
	}	
	
	function cronsnew(){
		$this->autoRender = false;
		
		$this->Conformance->bindModel(
		array('hasMany' => array('ConformanceRelation' => array(
			'className' => 'ConformanceRelation',			 
			'foreignKey' => 'conformance_id',				
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));
		$this->ConformanceRelation->bindModel(
		array('belongsTo' => array('NappUser' => array(
			'className' => 'NappUser',			 
			'foreignKey' => 'emp_id',				
			'conditions' => array(),
			'fields' => array('name','lname','email','mobile_number','id','country'),
			'order' => array(),
		))));
		$this->Conformance->bindModel(
		array('belongsTo' => array('User' => array(
			'className' => 'User',			 
			'foreignKey' => 'admin_id',				
			'conditions' => array(),
			'fields' => array('name','email'),
			'order' => array(),
		))));
		$this->Conformance->recursive = 2;
		$ConformanceArr = $this->Conformance->find('all',array('conditions'=>array('Conformance.is_reminder'=>1,'Conformance.status <'=>3),'order'=>array('Conformance.id'=>'DESC')));
		// echo '<pre>';
		// print_r($ConformanceArr);
		// die();
	
		if(!empty($ConformanceArr)){
			foreach($ConformanceArr as $Conformances){
				$last_update = $Conformances['Conformance']['lastupdated'];
				
				$nc_number = $Conformances['Conformance']['nc_number'];
				$is_reminder = $Conformances['Conformance']['is_reminder'];
				$is_email = $Conformances['Conformance']['is_email'];
				$is_sms = $Conformances['Conformance']['is_sms'];
				$is_both = $Conformances['Conformance']['is_both'];
				$send_to = $Conformances['Conformance']['send_to'];
				$period = $Conformances['Conformance']['period'];
				if($is_reminder == 1){					
					if($is_both == 1){
						 if(!empty($Conformances['ConformanceRelation'])){
							foreach($Conformances['ConformanceRelation'] as $ConformancesArr){
								if($Conformances['Conformance']['compaint_by'] != $ConformancesArr['NappUser']['id']){
									$name = $ConformancesArr['NappUser']['name'].' '.$ConformancesArr['NappUser']['lname'];
									$email = $ConformancesArr['NappUser']['email'];
									$country = $ConformancesArr['NappUser']['country'];
									
									if($country  == 'india'){
										date_default_timezone_set('Asia/Kolkata');
									}	
									$todate = strtotime($last_update); 
									$fromdate = time();
									$diff = $fromdate - $todate;
									
									if($diff > 0){		
									
									$min = intval($diff / 60);	 					
									$hour = date('H'); 	
									
									$s_flag = 0;
									if($period == '30 min'){
										if($min > 30){
											$s_flag = 1;
										}	
									}else if($period == 'hour'){
										if($min > 60){
											$s_flag = 1;
										}
									}else if($period == 'day'){
										if($min > 1440){
											$s_flag = 1;
										}
									}
									if($Conformances['Conformance']['send_to'] == 1){
										// Office Work Hour
										if($hour >= 9 && $hour <= 17){
											$flag =1;	
										}else{
											$flag = 0;	
										}		
									}else{
										// 24 hour
										$flag =1;
									}
								
									if(($flag == 1) && ($s_flag == 1)){	
										$udpateArrs['Conformance']['lastupdated'] = date('Y-m-d H:i:s');
										$udpateArrs['Conformance']['id'] = $Conformances['Conformance']['id'];
										$this->Conformance->save($udpateArrs);
										
										$receivername = $ConformancesArr['NappUser']['name'].' '.$ConformancesArr['NappUser']['lname'];
										$email = $ConformancesArr['NappUser']['email'];
										if(!empty($email)){											
											$subject = SITENAME.' :: Any update on non conformance('.$nc_number.')';				
											$template_name = 'nc_reminder';										
											$variables = array('to_name'=>$receivername,'nc_number'=>$nc_number);				
											try{
												$this->sendemail($email ,$subject,$template_name,$variables);
											}catch (Exception $e){
												
											} 										
										}
										
										if(!empty($ConformancesArr['NappUser']['mobile_number'])){
											if($country  != 'india'){
												$phones = str_replace(' ','',$NappUser['NappUser']['mobile_number']);
												$phone = ltrim($phones,'+');
												
												$to = '+'.$phone;
												$sid = TSID;	
												$token = TOKEN;							
												$from = FROM_NUMBER;	
												$body = "Hi ".$receivername.' Any update on non conformance('.$nc_number.')';				
												$this->Twilio->AccountSid = TSID;   
												$this->Twilio->AccountToken = TOKEN;						
												$response = $this->Twilio->sendsms($to,$from,$body);
											}	
										}	
										}																		
									}
								}
							}					
						}
					
					}
					if($is_email == 1){
						if(!empty($Conformances['ConformanceRelation'])){
							foreach($Conformances['ConformanceRelation'] as $ConformancesArr){
								if($Conformances['Conformance']['compaint_by'] != $ConformancesArr['NappUser']['id']){
									$name = $ConformancesArr['NappUser']['name'].' '.$ConformancesArr['NappUser']['lname'];
									$email = $ConformancesArr['NappUser']['email'];
									$country = $ConformancesArr['NappUser']['country'];
									
									if($country  == 'india'){
										date_default_timezone_set('Asia/Kolkata');
									}	
									$todate = strtotime($last_update); 
									$fromdate = time();
									$diff = $fromdate - $todate;
									
									if($diff > 0){		
									
									$min = intval($diff / 60);	 					
									$hour = date('H'); 
									
									$s_flag = 0;
									if($period == '30 min'){
										if($min > 30){
											$s_flag = 1;
										}	
									}else if($period == 'hour'){
										if($min > 60){
											$s_flag = 1;
										}
									}else if($period == 'day'){
										if($min > 1440){
											$s_flag = 1;
										}
									}
									if($Conformances['Conformance']['send_to'] == 1){
										// Office Work Hour
										if($hour >= 9 && $hour <= 17){
											$flag =1;	
										}else{
											$flag = 0;	
										}		
									}else{
										// 24 hour
										$flag =1;
									}
									
									if(($flag == 1) && ($s_flag == 1)){	
									
							
										$udpateArrs['Conformance']['lastupdated'] = date('Y-m-d H:i:s');
										$udpateArrs['Conformance']['id'] = $Conformances['Conformance']['id'];
										$this->Conformance->save($udpateArrs);										
										$receivername = $ConformancesArr['NappUser']['name'].' '.$ConformancesArr['NappUser']['lname'];
										$email = $ConformancesArr['NappUser']['email'];
										
										if(!empty($email)){			
											
											$subject = SITENAME.' :: Any update on non conformance('.$nc_number.')';				
											$template_name = 'nc_reminder';										
											$variables = array('to_name'=>$receivername,'nc_number'=>$nc_number);				
											try{
												$this->sendemail($email ,$subject,$template_name,$variables);
											}catch (Exception $e){
												
											} 										
										}
										
									}																		
									}
								}
							}					
						}					
					}
					if($is_sms == 1){
						if(!empty($Conformances['ConformanceRelation'])){
							foreach($Conformances['ConformanceRelation'] as $ConformancesArr){
								if($Conformances['Conformance']['compaint_by'] != $ConformancesArr['NappUser']['id']){
									$name = $ConformancesArr['NappUser']['name'].' '.$ConformancesArr['NappUser']['lname'];
									$email = $ConformancesArr['NappUser']['email'];
									$country = $ConformancesArr['NappUser']['country'];
									
									if($country  == 'india'){
										date_default_timezone_set('Asia/Kolkata');
									}	
									$todate = strtotime($last_update); 
									$fromdate = time();
									$diff = $fromdate - $todate;
									
									if($diff > 0){		
									
									$min = intval($diff / 60);	 					
									$hour = date('H'); 	
									
									$s_flag = 0;
									if($period == '30 min'){
										if($min > 30){
											$s_flag = 1;
										}	
									}else if($period == 'hour'){
										if($min > 60){
											$s_flag = 1;
										}
									}else if($period == 'day'){
										if($min > 1440){
											$s_flag = 1;
										}
									}
									if($Conformances['Conformance']['send_to'] == 1){
										// Office Work Hour
										if($hour >= 9 && $hour <= 17){
											$flag =1;	
										}else{
											$flag = 0;	
										}		
									}else{
										// 24 hour
										$flag =1;
									}
											
									if(($flag == 1) && ($s_flag == 1)){
											if($country  != 'india'){
												$udpateArrs['Conformance']['lastupdated'] = date('Y-m-d H:i:s');
												$udpateArrs['Conformance']['id'] = $Conformances['Conformance']['id'];
												$this->Conformance->save($udpateArrs);											
												$receivername = $ConformancesArr['NappUser']['name'].' '.$ConformancesArr['NappUser']['lname'];																				
												if(!empty($ConformancesArr['NappUser']['mobile_number'])){
													$phones = str_replace(' ','',$NappUser['NappUser']['mobile_number']);
													$phone = ltrim($phones,'+');
													
													$to = '+'.$phone;
													$sid = TSID;	
													$token = TOKEN;							
													$from = FROM_NUMBER;	
													$body = "Hi ".$receivername.' Any update on non conformance('.$nc_number.')';				
													$this->Twilio->AccountSid = TSID;   
													$this->Twilio->AccountToken = TOKEN;						
													$response = $this->Twilio->sendsms($to,$from,$body);
												}	
											}	
										}																		
									}
								}
							}					
						}
							
					}	
				}	
				
			}
		}	
		
	}

	/**
	 * CamelCase wrapper for admin_reminder
	 */
	public function adminReminder($id = null, $emp_id = null)
	{
		return $this->admin_reminder($id, $emp_id);
	}

	function admin_reminder($conformance_id=null,$emp_id=null){
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Conformance Edit');
		$this->checkAdminSession();
		$user_id = $this->request->getSession()->read('User.id');

		// Decode id if base64 encoded
		$decoded_id = base64_decode($conformance_id, true);
		$conformance_primary_id = ($decoded_id !== false && is_numeric($decoded_id)) ? (int)$decoded_id : (is_numeric($conformance_id) ? (int)$conformance_id : null);
		if ($conformance_primary_id === null) {
			$this->Flash->error('Invalid conformance');
			return $this->redirect(['action' => 'admin_conformancelist']);
		}

		$ConformanceEntity = $this->Conformance->find()
			->where(['Conformance.id' => $conformance_primary_id])
			->first();
		if (!$ConformanceEntity) {
			$this->Flash->error('Conformance not found');
			return $this->redirect(['action' => 'admin_conformancelist']);
		}
		$ConformanceArr = ['Conformance' => $ConformanceEntity->toArray()];	
		
		if($this->request->is('post') && !empty($this->request->getData())){
			$data = $this->request->getData();
			$is_reminder = isset($data['is_reminder']) ? (int)$data['is_reminder'] : 0;
			$is_email = isset($data['is_email']) ? (int)$data['is_email'] : 0;
			$is_sms = isset($data['is_sms']) ? (int)$data['is_sms'] : 0;
			$is_both = isset($data['is_both']) ? (int)$data['is_both'] : 0;
			$send_to = isset($data['send_to']) ? (int)$data['send_to'] : 0;
			$period = isset($data['period']) ? $data['period'] : '';

			$entity = $this->Conformance->get($ConformanceArr['Conformance']['id']);
			$entity = $this->Conformance->patchEntity($entity, [
				'is_reminder' => $is_reminder,
				'is_email' => $is_email,
				'is_sms' => $is_sms,
				'is_both' => $is_both,
				'send_to' => $send_to,
				'period' => $period,
				'lastupdated' => date('Y-m-d H:i:s')
			], ['validate' => false]);
			if ($this->Conformance->save($entity)) {
				$this->Flash->success('Reminder set successfully');
				return $this->redirect(['action' => 'admin_conformancelist']);
			}
		}	
		
		$this->set('user_id',$user_id);
		$this->set('ConformanceArr',$ConformanceArr);
	}	
	
	function admin_edit($conformance_id=null,$emp_id=null){
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Conformance Edit');
		$this->checkAdminSession();
	
		$user_id=$this->Session->read('User.id');
		
		$this->Conformance->bindModel(
		array('hasMany' => array('TaskDocument'=>array(
			'className' => 'TaskDocument',			 
			'foreignKey' => 'con_id',				
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));
		
		$ConformanceArr = $this->Conformance->find('first',array('conditions'=>array('Conformance.id'=>base64_decode($conformance_id))));	
		
		if(!empty($this->request->data)){
			
			$conformance_ids = base64_decode($conformance_id);
			$path  = WWW_ROOT.'document/conformance';	
			
			if(!empty($_FILES['document']['name'][0])){
				$i=0;
				
				foreach($_FILES['document']['name'] as $name){					
					$ext = pathinfo($name, PATHINFO_EXTENSION);
					$filename =  time().'_'.$name;
					$tempname = $_FILES['document']['tmp_name'][$i];						
					move_uploaded_file($tempname,$path.'/'.$filename);
					
					$TaskDocument['TaskDocument']['id'] = '';
					$TaskDocument['TaskDocument']['title'] =  '';
					$TaskDocument['TaskDocument']['admin_id'] =  $user_id;
					$TaskDocument['TaskDocument']['con_id'] =  $conformance_ids;	
					$TaskDocument['TaskDocument']['document'] =  'conformance';
					$TaskDocument['TaskDocument']['filename'] =  $filename;
					$TaskDocument['TaskDocument']['ext'] =  $ext;
					$TaskDocument['TaskDocument']['created'] =  date('Y-m-d H:i:s');
					$TaskDocument['TaskDocument']['is_upload'] =  1; 			
					$this->TaskDocuments->save($TaskDocument);					
					$i++;					
				}
			}
			
			$updateConformance['Conformance']['non_conforance'] = $this->request->data['Conformance']['non_conforance'];				
			#$updateConformance['Conformance']['non_conforance_raised'] = $this->request->data['Conformance']['non_conforance_raised'];				
			$updateConformance['Conformance']['customer_name'] = $this->request->data['Conformance']['customer_name'];				
			$updateConformance['Conformance']['client_detail'] = $this->request->data['Conformance']['client_detail'];				
			$updateConformance['Conformance']['other_detail'] = $this->request->data['Conformance']['other_detail'];				
			$updateConformance['Conformance']['status'] = 2;		
			$updateConformance['Conformance']['id'] = $conformance_ids;		
				
			$this->Conformance->save($updateConformance);		
		
			$this->Session->setFlash('updated successfully','default',array('class' => 'alert alert-success'));
			$this->redirect('conformancelist');
		}	
		$this->set('ConformanceArr',$ConformanceArr);	
		$this->set('user_id',$user_id);
	
	}
	function edit($conformance_id=null,$emp_id=null){
		$this->layout='staff_inner_layout';
		$this->set('title_for_layout',SITENAME.' Conformance Reply');
		$this->checkSatffSession();
	
		$user_id=$this->Session->read('Customer.id');
		$dept_id=$this->Session->read('Customer.dept_id');
		
		$Department = $this->Department->find('first',array('Department.id'=>$dept_id));
		
		$name = $this->Session->read('Customer.name').' '.$this->Session->read('Customer.lname').' ('.$Department['Department']['department_title'].')';
				
		$this->Conformance->bindModel(
		array('hasMany' => array('TaskDocument'=>array(
			'className' => 'TaskDocument',			 
			'foreignKey' => 'con_id',				
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));
		
		$ConformanceArr = $this->Conformance->find('first',array('conditions'=>array('Conformance.id'=>base64_decode($conformance_id))));	
		
		if(!empty($this->request->data)){
			
			$conformance_ids = base64_decode($conformance_id);
			$path  = WWW_ROOT.'document/conformance';	
			
			if(!empty($_FILES['document']['name'][0])){
				
				$i=0;
				foreach($_FILES['document']['name'] as $name){					
					$ext = pathinfo($name, PATHINFO_EXTENSION);
					$filename =  time().'_'.$name;
					$tempname = $_FILES['document']['tmp_name'][$i];						
					move_uploaded_file($tempname,$path.'/'.$filename);
					
					$TaskDocument['TaskDocument']['id'] = '';
					$TaskDocument['TaskDocument']['title'] =  '';
					$TaskDocument['TaskDocument']['employe_id'] =  $user_id;
					$TaskDocument['TaskDocument']['con_id'] =  $conformance_ids;	
					$TaskDocument['TaskDocument']['document'] =  'conformance';
					$TaskDocument['TaskDocument']['filename'] =  $filename;
					$TaskDocument['TaskDocument']['ext'] =  $ext;
					$TaskDocument['TaskDocument']['created'] =  date('Y-m-d H:i:s');
					$TaskDocument['TaskDocument']['is_upload'] =  1; 			
					$this->TaskDocuments->save($TaskDocument);					
					$i++;					
				}
			}
			
			/* // send email to intiative
			$compaint_by = $ConformanceArr['Conformance']['compaint_by'];			
			$NappUserArr = $this->NappUser->find('first',array('conditions'=>array('NappUser.id'=>$compaint_by)));			
			$to_email = $NappUserArr['NappUser']['email'];
			//$to_email = 'web@xoroglobal.com';
			$to_name  = $NappUserArr['NappUser']['name'];	
			$subject = SITENAME." :: Non Conformance ".$ConformanceArr['Conformance']['nc_number']." By ".$this->Session->read('Customer.name');				
			$template_name = 'replyconformance';	
			$non_conforance = $ConformanceArr['Conformance']['non_conforance'];			
			$variables = array('name'=>$this->Session->read('Customer.name'),'to_name'=>$to_name,'title'=>$non_conforance,'nc_number'=>$ConformanceArr['Conformance']['nc_number']);		
			try{
				$this->sendemail($to_email,$subject,$template_name,$variables);
			}catch (Exception $e){
				
			}	
			
			$admin_email = 'kal@durotechindustries.com.au';
			#$admin_email = 'web@xoroglobal.com';
			$admin_subject = SITENAME." :: Non Conformance ".$ConformanceArr['Conformance']['nc_number']." By ".$this->Session->read('Customer.name');

			$autologinurl = SITEURL.'staffs/autologin/'.base64_encode($ConformanceArr['Conformance']['id']);	
			$admin_template_name = 'autoreplyconformance';	
			$non_conforance = $ConformanceArr['Conformance']['non_conforance'];			
			$admin_variables = array('autologinurl'=>$autologinurl,'name'=>$this->Session->read('Customer.name'),'to_name'=>'Kal','title'=>$non_conforance,'nc_number'=>$ConformanceArr['Conformance']['nc_number']);		
			try{
				$this->sendemail($admin_email,$admin_subject,$admin_template_name,$admin_variables);
			}catch (Exception $e){
				
			} */
			
			$updateConformance['Conformance']['non_conforance'] = $this->request->data['Conformance']['non_conforance'];$updateConformance['Conformance']['customer_name'] = $this->request->data['Conformance']['customer_name'];				
			#$updateConformance['Conformance']['non_conforance_raised'] = $this->request->data['Conformance']['non_conforance_raised'];				
			$updateConformance['Conformance']['client_detail'] = $this->request->data['Conformance']['client_detail'];				
			$updateConformance['Conformance']['other_detail'] = $this->request->data['Conformance']['other_detail'];				
			$updateConformance['Conformance']['status'] = 2;		
			$updateConformance['Conformance']['id'] = $conformance_ids;		
				
			$this->Conformance->save($updateConformance);			
		
			$this->Session->setFlash('updated successfully','default',array('class' => 'alert alert-success'));
			$this->redirect('conformancelist');
		}	
		$this->set('ConformanceArr',$ConformanceArr);
		
		
		$this->set('user_id',$user_id);
	
	}

	/** CamelCase alias for URL staffs/staff-spec-request-form */
	public function staffSpecRequestForm()
	{
		return $this->staff_specRequest_form();
	}

	public function staff_specRequest_form()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', 'Submit New Spec Request');
		$this->checkSatffSession();

		$user_id = $this->request->getSession()->read('Customer.id');
	
		$data = $this->request->getData();
		if (!empty($data)) {

			$tracknumber = method_exists($this->Mailer, 'getNextSpecTrackNumber')
				? $this->Mailer->getNextSpecTrackNumber()
				: ('DTSPEC ' . date('d-m') . '-' . str_pad((string)($this->Mailer->find()->where(['Mailer.type' => 3])->count() + 1), 3, '0', STR_PAD_LEFT));
			$name = $data['name'] ?? '';
			$email = $data['email'] ?? '';
			$company = $data['company'] ?? '';
			$address = $data['address'] ?? '';
			$specification = $data['specification'] ?? '';
			$date = !empty($data['date']) ? date('Y-m-d', strtotime($data['date'])) : date('Y-m-d');
			$type = $data['type'] ?? '';
			$subject = $data['subject'] ?? '';
			$use_area = $data['use_area'] ?? 1;

			$entity = $this->Mailer->newEntity([
				'user_id' => $user_id,
				'spec_v' => 0,
				'name' => $name,
				'tracknumber' => $tracknumber,
				'address' => $address,
				'specification' => $specification,
				'date' => $date,
				'email' => $email,
				'company' => $company,
				'type' => 3,
				'subject' => $subject,
				'use_area' => $use_area,
				'created' => date('Y-m-d H:i:s'),
			]);

			if ($this->Mailer->save($entity)) {
				$lastinsertId = $entity->id;

				if (!empty($data['comment']) && is_array($data['comment'])) {
					foreach ($data['comment'] as $comment) {
						$commentEntity = $this->MailerComment->newEntity([
							'mailer_id' => $lastinsertId,
							'use_area' => 1,
							'comment' => $comment,
						]);
						$this->MailerComment->save($commentEntity);
					}
				}

				if (!empty($data['product']) && is_array($data['product'])) {
					foreach ($data['product'] as $key => $prodt) {
						$typesKey = $data['types'][$key] ?? null;
						$title = isset($data['title'][$typesKey]) ? $data['title'][$typesKey] : '';
						$specEntity = $this->SpecUsearea->newEntity([
							'mailer_id' => $lastinsertId,
							'use_area' => 1,
							'title' => $title,
							'product' => $prodt,
							'types' => $data['types'][$key] ?? '',
							'serial' => $data['serial'][$key] ?? '',
							'coverage' => $data['coverage'][$key] ?? '',
							'Warranty' => $data['Warranty'][$key] ?? '',
							'coverage_by_pack' => $data['coverage_by_pack'][$key] ?? '',
						]);
						$this->SpecUsearea->save($specEntity);
					}
				}

				$pdfname = $lastinsertId . '-' . $tracknumber;
				$fields = [
					'tracknumber' => $tracknumber,
					'mailer_id' => $lastinsertId,
					'name' => $name,
					'email' => $email,
					'address' => $address,
					'company' => $company,
					'specification' => $specification,
					'date' => $data['date'] ?? '',
					'subject' => $subject,
					'type' => $type,
					'pdfname' => $pdfname,
					'use_area' => $use_area,
				];
				$fields_string = http_build_query($fields);
				$baseUrl = rtrim(SITEURL, '/');
				if (!empty($data['spectype']) && (int)$data['spectype'] == 1) {
					$url = $baseUrl . '/dompdf/generatepdf.php?' . $fields_string;
				} else {
					$url = $baseUrl . '/dompdf/generatewithoutpdf.php?' . $fields_string;
				}
				$arrContextOptions = [
					'ssl' => [
						'verify_peer' => false,
						'verify_peer_name' => false,
					],
				];
				$pdfResponseRaw = @file_get_contents($url, false, stream_context_create($arrContextOptions));
				$pdfResponse = is_string($pdfResponseRaw) ? @json_decode($pdfResponseRaw, true) : null;

				// generatepdf.php sanitizes filenames (spaces -> underscores), so always resolve to actual saved filename.
				$resolvedPdfFileName = $pdfname . '.pdf';
				if (is_array($pdfResponse) && !empty($pdfResponse['filename'])) {
					$resolvedPdfFileName = (string)$pdfResponse['filename'];
				} else {
					$safePdfname = preg_replace('/[^a-zA-Z0-9_\-]/', '_', (string)$pdfname);
					$safePdfname = preg_replace('/_+/', '_', (string)$safePdfname);
					$safePdfname = trim((string)$safePdfname, '_');
					if ($safePdfname !== '') {
						$resolvedPdfFileName = $safePdfname . '.pdf';
					}
				}

				// Send staff spec email to internal recipients (same routing as employee flow).
				$template_name = 'new_sendeasyspec';
				$pdfFileName = $resolvedPdfFileName;
				$pdfFilePath = WWW_ROOT . 'dompdf' . DS . $pdfFileName;
				$toEmail = 'kal@durotechindustries.com.au';
				$ccEmails = ['info@durotechindustries.com.au'];
				$bccEmails = ['deepaksaini10036@gmail.com'];
				$variables = [
					'subject' => $subject,
					'pdfname' => base64_encode(base64_encode($pdfFileName)),
					'name' => $name,
					'address' => $address,
					'company' => $company,
					'specification' => $specification,
					'email' => (string)$email,
					'date' => $data['date'] ?? '',
				];
				try {
					if (is_file($pdfFilePath)) {
						$from = defined('EMAIL') ? EMAIL : 'deepaksaini10036@gmail.com';
						$fromName = defined('SITENAME') ? SITENAME : 'Durotech';
						$emailObj = new \Cake\Mailer\Email('default');
						$emailObj->viewBuilder()
							->setClassName('App\\View\\AppView')
							->setTemplate($template_name);
						$emailObj->setFrom([$from => $fromName])
							->setTo($toEmail)
							->setCc($ccEmails)
							->setBcc($bccEmails)
							->setSubject($subject)
							->setEmailFormat('html')
							->setViewVars($variables)
							->setAttachments([
								$pdfFileName => [
									'file' => $pdfFilePath,
									'mimetype' => 'application/pdf',
								],
							])
							->send();
					} else {
						$this->sendemail($toEmail, $subject, $template_name, $variables);
					}
				} catch (\Throwable $e) {
					\Cake\Log\Log::error('Staff spec request email failed: ' . $e->getMessage());
				}

				$this->Flash->success('PDF file generated successfully.');
				return $this->redirect(['action' => 'staff_specRequest_form']);
			}

			$this->Flash->error('Failed to submit.');
		}
	}
}
