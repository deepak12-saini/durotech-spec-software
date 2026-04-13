<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Users Controller (admin, customer, login, register, etc.)
 */
class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('User');
        $this->loadModel('PaymentSetup');
        $this->loadModel('Category');
        $this->loadModel('Product');
        $this->loadModel('Subscriber');
        $this->loadModel('Contact');
        $this->loadModel('Staff');
        $this->loadModel('NappUser');
        $this->loadModel('UserAnswer');
        $this->loadModel('Question');
        $this->loadModel('QuestionOption');
        $this->loadModel('QuestionSubmits');
        $this->loadModel('LabFile');
        $this->loadModel('LabAssign');
        $this->loadModel('Coupon');
        $this->loadModel('Permission');
        $this->loadModel('UserPermission');
        $this->loadModel('Department');
        $this->loadModel('CpdMailer');
        $this->loadModel('Conformance');
        $this->loadModel('LoginHistory');
        $this->loadModel('EoiMailer');
        $this->loadModel('Config');
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        parent::beforeFilter($event);
        $this->callConstants();
        return null;
    }
	
	function getlo(){
		
		$this->autoRender = false;
		
		
		// $this->Conformance->query('delete  from conformances');
		// $userArr = $this->Conformance->find('all');
		
		
		
		// echo '<pre>';
		// print_r($userArr);
		// die();
	}	
	
	public function adminPermission($id = null)
	{
		return $this->admin_permission($id);
	}
	
	public function admin_permission($id = null)
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Staff Permission');
		$this->checkAdminSession();
		if ($this->request->is('post') && !empty($this->request->getData())) {
			$this->UserPermission->deleteAll(['user_id' => $id]);
			$permIds = $this->request->getData('permssion_id');
			if (!empty($permIds)) {
				foreach ((array)$permIds as $permssion_id) {
					$permssionId = explode('-', $permssion_id);
					$ent = $this->UserPermission->newEntity([
						'user_id' => $id,
						'meta_val' => $permssionId[1] ?? '',
						'permssion_id' => $permssionId[0] ?? '',
					]);
					$this->UserPermission->save($ent);
				}
			}
			$this->Flash->success('updated successfully');
			return $this->redirect(['action' => 'admin_staff']);
		}
		$permission = [];
		foreach ($this->Permission->find() as $p) {
			$permission[] = ['Permission' => $p->toArray()];
		}
		$upermission = [];
		foreach ($this->UserPermission->find()->where(['UserPermission.user_id' => $id]) as $u) {
			$upermission[] = ['UserPermission' => $u->toArray()];
		}
		$nappUserEntity = $this->NappUser->find()->where(['NappUser.id' => $id])->first();
		$NappUser = $nappUserEntity ? ['NappUser' => $nappUserEntity->toArray()] : ['NappUser' => []];
		$this->set(compact('permission', 'upermission', 'NappUser'));
	}

	public function adminCustomerpermission($id = null)
	{
		return $this->admin_customerpermission($id);
	}

	public function admin_customerpermission($id = null)
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Customer Permission');
		$this->checkAdminSession();
		if ($this->request->is('post') && !empty($this->request->getData())) {
			$this->UserPermission->deleteAll(['user_id' => $id]);
			$permIds = $this->request->getData('permssion_id');
			if (!empty($permIds)) {
				foreach ((array)$permIds as $permssion_id) {
					$permssionId = explode('-', $permssion_id);
					$ent = $this->UserPermission->newEntity([
						'user_id' => $id,
						'meta_val' => $permssionId[1] ?? '',
						'permssion_id' => $permssionId[0] ?? '',
					]);
					$this->UserPermission->save($ent);
				}
			}
			$this->Flash->success('updated successfully');
			return $this->redirect(['action' => 'admin_customer']);
		}
		$permission = [];
		foreach ($this->Permission->find()->where(['Permission.id' => 4]) as $p) {
			$permission[] = ['Permission' => $p->toArray()];
		}
		$upermission = [];
		foreach ($this->UserPermission->find()->where(['UserPermission.user_id' => $id]) as $u) {
			$upermission[] = ['UserPermission' => $u->toArray()];
		}
		$nappUserEntity = $this->NappUser->find()->where(['NappUser.id' => $id])->first();
		$NappUser = $nappUserEntity ? ['NappUser' => $nappUserEntity->toArray()] : ['NappUser' => []];
		$this->set(compact('permission', 'upermission', 'NappUser'));
	}

/**
 * Dashboard a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function adminDashboard()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Admin Dashboard Page');
		$this->checkAdminSession();
		$userPermResults = $this->UserPermission->find('all')
			->contain(['NappUser' => ['EoiMailer']])
			->where(['UserPermission.permssion_id' => 14]);
		$UserPermission = [];
		foreach ($userPermResults as $up) {
			$nu = $up->get('napp_user');
			$nappArr = $nu ? $nu->toArray() : [];
			$eoi = $nu && $nu->get('eoi_mailer') ? (is_object($nu->get('eoi_mailer')) ? iterator_to_array($nu->get('eoi_mailer')) : (array)$nu->get('eoi_mailer')) : [];
			$nappArr['EoiMailer'] = $eoi;
			$UserPermission[] = ['UserPermission' => $up->toArray(), 'NappUser' => $nappArr];
		}
		$totalcate = $this->Category->find()->count();
		$totalpro = $this->Product->find()->count();
		$totalStaff = $this->Staff->find()->count();
		$totalCustomer = $this->NappUser->find()->count();
		$this->set(compact('UserPermission', 'totalCustomer', 'totalStaff', 'totalcate', 'totalpro'));
	}


	// public function admin_dashboard() 
	// {
	// 	$this->layout = 'admin_layout';
	// 	$this->set('title_for_layout', SITENAME . ' Admin Dashboard Page');
	// 	$this->checkAdminSession();

	// 	$this->UserPermission->bindModel([
	// 		'belongsTo' => [
	// 			'NappUser' => [
	// 				'className' => 'NappUser',
	// 				'foreignKey' => 'user_id',
	// 				'fields' => ['id', 'name', 'lname']
	// 			]
	// 		]
	// 	]);

	// 	$this->NappUser->bindModel([
	// 		'hasMany' => [
	// 			'EoiMailer' => [
	// 				'className' => 'EoiMailer',
	// 				'foreignKey' => 'user_id',
	// 				'fields' => ['id', 'user_id']
	// 			]
	// 		]
	// 	]);

	// 	$this->UserPermission->recursive = 2;

	// 	$UserPermission = $this->UserPermission->find('all', [
	// 		'conditions' => ['UserPermission.permssion_id' => 14]
	// 	]);

	// 	// 🔥 Remove records with no EOI Mailers
	// 	$filteredUsers = [];
	// 	foreach ($UserPermission as $u) {
	// 		if (!empty($u['NappUser']['EoiMailer'])) {
	// 			$filteredUsers[] = $u;
	// 		}
	// 	}

	// 	$this->set('UserPermission', $filteredUsers);

	// 	// Other dashboard counts
	// 	$this->set('totalcate', $this->Category->find('count'));
	// 	$this->set('totalpro', $this->Product->find('count'));
	// 	$this->set('totalStaff', $this->Staff->find('count'));
	// 	$this->set('totalCustomer', $this->NappUser->find('count'));
    // }

	
/***
/*Author  :Ranjit,
/*Comment : admin Login page
****/
	public function adminLogin() {
		$this->viewBuilder()->setLayout('admin_login');
		$this->set('title_for_layout',SITENAME.' Admin Login Page');		
		$admin_id=$this->request->getSession()->read('User.id');
		if(!empty($admin_id)){
			return $this->redirect(rtrim(SITEURL, '/') . '/admin/dashboard');
		}		
		if ($this->request->is('post') && !empty($this->request->getData())){
			$data = $this->request->getData();
			$admin_arr = $this->User->find()
				->where([
					'username' => $data['User']['username'] ?? '',
					'password' => $data['User']['password'] ?? ''
				])
				->first();
			if ($admin_arr) {
				$ent = $this->LoginHistory->newEntity([
					'admin_id' => $admin_arr->get('id'),
					'role' => 'Admin',
					'logintime' => date('Y-m-d H:i:s'),
				]);
				$this->LoginHistory->save($ent);
				$this->request->getSession()->write('User', $admin_arr->toArray());
				$this->request->getSession()->write('is_admin', 1);
				return $this->redirect(rtrim(SITEURL, '/') . '/admin/dashboard');
			} else {
				//$this->Flash->success(__('Wrong username/password', true));
				$this->Flash->error('Wrong username/password');
			}
		}
		
	}
/***
	/*Author  :Ranjit,
	/*Comment : User Logout page (CakePHP 3 route uses adminLogout; this does the work)
****/
	public function adminLogout(): ?Response
	{
		return $this->admin_logout();
	}

	public function admin_logout(): ?Response
	{
		$this->autoRender = false;
		$userId = $this->request->getSession()->read('User.id');
		$loginRec = $this->LoginHistory->find()
			->where(['logouttime' => '0000-00-00 00:00:00', 'admin_id' => $userId])
			->orderDesc('id')
			->first();
		if ($loginRec) {
			$loginRec->set('logouttime', date('Y-m-d H:i:s'));
			$this->LoginHistory->save($loginRec);
		}
		$this->request->getSession()->destroy();
		return $this->redirect(rtrim(SITEURL, '/') . '/admin');
	}
	
	/***
	/*Author  :Ranjit,
	/*Comment : Admin profile
****/	
	/** CamelCase wrapper for routing */
	public function adminProfile(): ?Response
	{
		return $this->admin_profile();
	}

	public function admin_profile(): ?Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Profile Page');
		$this->checkAdminSession();
		$admin_id = $this->request->getSession()->read('User.id');
		$user = $this->User->find()->where(['User.id' => $admin_id])->first();
		if ($this->request->is('post') && !empty($this->request->getData())) {
			if ($user) {
				$user = $this->User->patchEntity($user, $this->request->getData('User'));
				if ($this->User->save($user)) {
					$this->Flash->success('Your profile has been updated');
					return $this->redirect(['action' => 'admin_profile']);
				}
				$this->Flash->error('Your profile has not updated');
			}
		}
		$this->set(compact('user'));
		return null;
	}

	/** CamelCase wrapper for routing */
	public function adminSubscriberList()
	{
		return $this->admin_subscriber_list();
	}

	public function admin_subscriber_list()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Subscriber List');
		$this->checkAdminSession();
		$this->paginate = ['limit' => 10, 'order' => ['Subscriber.id' => 'DESC']];
		$results = $this->paginate($this->Subscriber->find());
		// Convert entities to CakePHP 2-style array for view
		$Subscribers = [];
		foreach ($results as $entity) {
			$Subscribers[] = ['Subscriber' => $entity->toArray()];
		}
		$this->set(compact('Subscribers'));
	}

	/** CamelCase wrapper for routing */
	public function adminContactus()
	{
		return $this->admin_contactus();
	}

	public function admin_contactus()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Contact List');
		$this->checkAdminSession();
		$this->paginate = ['limit' => 10, 'order' => ['Contact.id' => 'DESC']];
		$results = $this->paginate($this->Contact->find());
		// Convert entities to CakePHP 2-style array for view
		$contact = [];
		foreach ($results as $entity) {
			$contact[] = ['Contact' => $entity->toArray()];
		}
		$this->set(compact('contact'));
	}

	/** CamelCase wrapper for routing */
	public function adminContactDelete($id = null): ?Response
	{
		return $this->admin_contact_delete($id);
	}

	public function admin_contact_delete($id = null): ?Response
	{
		$this->checkAdminSession();
		$this->autoRender = false;
		if (!empty($id)) {
			$entity = $this->Contact->get($id);
			$this->Contact->delete($entity);
			$this->Flash->success('Deleted successfully');
			return $this->redirect(['action' => 'admin_contactus']);
		}
		return null;
	}	
	

	
	/** CamelCase wrapper for routing */
	public function adminWebSetting(): ?Response
	{
		return $this->admin_web_setting();
	}

	public function admin_web_setting(): ?Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Web setting');
		$this->checkAdminSession();
		$Config = $this->Config->find()->where(['Config.id' => 1])->first();
		if (!$Config) {
			$Config = $this->Config->find()->first();
		}
		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			if (!empty($data['image']['name'])) {
				$file = $data['image'];
				$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
				$arr_ext = ['jpg', 'jpeg', 'gif', 'png'];
				if (in_array($ext, $arr_ext)) {
					move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $file['name']);
					$data['Config']['logo'] = $file['name'];
				} else {
					$this->Flash->error('Please upload the valid image extention.');
					return $this->redirect(['action' => 'admin_web_setting']);
				}
			}
			if ($Config) {
				$configData = array_merge($Config->toArray(), $data['Config'] ?? []);
				$Config = $this->Config->patchEntity($Config, $configData, ['guard' => false]);
				if ($this->Config->save($Config)) {
					$this->Flash->success('Your web setting has been updated');
					return $this->redirect(['action' => 'admin_web_setting']);
				}
			}
			$this->Flash->error('Your web setting has not updated');
		}
		// View expects $Config['Config']['field']; convert Entity to that array format
		if ($Config && is_object($Config)) {
			$Config = ['Config' => $Config->toArray()];
		} elseif (!$Config) {
			$Config = ['Config' => []];
		}
		$this->set(compact('Config'));
		return null;
	}

/***
	/*Author  :Ranjit,
	/*Comment : Admin change password (CamelCase alias for routing)
****/
	public function adminChangePassword(): ?Response
	{
		$this->viewBuilder()->setTemplate('admin_change_password');
		return $this->admin_change_password();
	}

	public function admin_change_password(): ?Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Change Password Page');
		$this->checkAdminSession();
		if ($this->request->is('post')) {
			$admin_id = $this->request->getSession()->read('User.id');
			$User = $this->User->find()->where(['User.id' => $admin_id])->first();
			if ($User) {
				$data = $this->request->getData('User');
				if (($data['new_password'] ?? '') === ($data['confirm_password'] ?? '')) {
					if (($User->get('password') ?? '') === ($data['current_password'] ?? '')) {
						$User->set('password', $data['new_password']);
						$this->User->save($User);
						$this->Flash->success('Your password has been changed successfully.');
					} else {
						$this->Flash->error('Current password not correct.Please, try again.');
					}
				} else {
					$this->Flash->error('New and confirm password not matched.Please, try again.');
				}
			} else {
				$this->Flash->error('User record not found.Please, try again.');
			}
		}
		return null;
	}
	
	function send_forgot_password()
	{
		if($this->request->is('post')){
			
			$User = $this->NappUser->find()->where(['NappUser.email' => $this->request->getData()['User']['email']])->first();
			if(!empty($User)){
				
				//$this->NappUser->id = $User['NappUser']['id'];
				//$password=$this->random_password(8);
				//$this->NappUser->saveField("password",md5($password));
				
				
				$userId = base64_encode(base64_encode(base64_encode($User['NappUser']['id'])));
				$url = SITEURL.'users/forgot_password/'.$userId;
				//$to = 'web@xoroglobal.com';	
				$to = $User['NappUser']['email'];	
				$subject=SITENAME." :: Reset your password.";				
				$template_name = 'setpassword';
				$variables = array('url'=>$url,'name'=>$User['NappUser']['name'],'email'=>$this->request->getData()['User']['email']);		
				try{
					$this->sendemail($to,$subject,$template_name,$variables);
				}catch (Exception $e){
					
				}				
				$this->Flash->success('Please check your email and set your password. ');
			}else{
				$this->Flash->error('The email entered is not found. Please, try again.');
			}
			$this->redirect('/login');
		}
	}
	
	function forgot_password($usersId=null)
	{
		$this->viewBuilder()->setLayout('admin_login');
		
		$userId = base64_decode(base64_decode(base64_decode($usersId)));
		$usersArr = $this->NappUser->find()->where(['NappUser.id' => $userId])->first();
		if(empty($usersArr)){
			$this->Flash->error('This users is not exits. Please try again!');	
			$this->redirect('/login');	
		}	
		if($this->request->is('post')){			
			$password = $this->request->getData()['NappUser']['password'];
			if(!empty($usersArr)){
				$this->NappUser->id= $usersArr['NappUser']['id'];				
				$this->NappUser->saveField("password",md5($password));
				
				$to = $usersArr['NappUser']['email'];				
				//$to = 'web@xoroglobal.com';				
				$subject = SITENAME." :: Your password changed successfully.";				
				$template_name = 'message';
				$variables = array('password'=>$password,'name'=>$usersArr['NappUser']['name'],'email'=>$usersArr['NappUser']['email'],'type'=>'forgot');		
				try{
					$this->sendemail($to , $subject ,$template_name,$variables);
				}catch (Exception $e){
					
				}	
			
				$this->Flash->success('Passowrd reset successfully.');
			}else{
				$this->Flash->error('The email entered is not found. Please, try again.');
			}
			$this->redirect('/login');
		}
	}
	
	/***
	/*Author  :Ranjit,
	/*Comment : Admin forgot password
****/	
	function admin_forgot_password()
	{
		if($this->request->is('post')){
			$User = $this->User->find()->where(['User.email' => $this->request->getData()['User']['email']])->first();
			if(!empty($User)){
				$this->User->id=$User['User']['id'];
				$password=$this->random_password(8);
				$this->User->saveField("password",$password);
				$to=$this->request->getData()['User']['email'];
				$subject=SITENAME." Password reset";
				// find template
			/* 	$emailTemplate = $this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.tag'=>'forgot-password')));
				$name = $User['User']['name'];
				$email_template = $emailTemplate['EmailTemplate']['description'];
				$email_template = str_replace('[NAME]',$name,$email_template);	
				$email_template = str_replace('[EMAIL]',$to,$email_template);	
				$email_template = str_replace('[PASSWORD]',$password,$email_template);	
				// SEND EMAIL
				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				// More headers
				$headers .= 'From: <no-reply@expressooh.com>' . "\r\n";	
				mail($to,$subject,$email_template,$headers); */
				$this->Flash->success('The mail has been sent to reset password.');
			}else{
				$this->Flash->error('The email entered is not found.Please, try again.');
			}
			$this->redirect(rtrim(SITEURL, '/') . '/admin');
		}
	}
	
	/***
	/*Author  :Ranjit,
	/*Comment : Admin Payment Setup
	****/	
	function admin_payment_setting()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' payment setting');
		$this->checkAdminSession();
		$admin_id= $this->request->getSession()->read('User.id');
		$PaymentSetup = $this->PaymentSetup->find()->where(['PaymentSetup.id' => 1])->first();
		if(!empty($this->request->getData())){			
			if(!empty($PaymentSetup)){
				$this->request->getData()['PaymentSetup']['id']=$PaymentSetup['PaymentSetup']['id'];
			
				if ($this->PaymentSetup->save($this->request->getData())) {
				$this->Flash->success('Your Payment Setup has been updated');
				return $this->redirect(['action' => 'admin_payment_setting']);
				}else{
				$this->Flash->error('Your Payment Setup has not updated');
					
				}
			}
		}
	
		$this->set('payment_setup', $PaymentSetup);
	}
	
	function admin_uploadprodcut(){
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' payment setting');
		$this->checkAdminSession();
		
		if(!empty($this->request->getData())){
			if(!empty($this->request->getData()['file']['name'])){
				$filename = $this->request->getData()['file']['name'];
				$tmp_name = $this->request->getData()['file']['tmp_name'];
				$org  = time().$filename;
				move_uploaded_file($tmp_name,'uploadfile/'.$org);
				
				
				echo '<pre>';
				print_r($this->request->getData());
				die();	
			}			
		}		
	}	
	
	public function random_password(int $length = 8): string {
		
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		//$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%?";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}
	
	
	
	/**
	 * Admin: Customer list (non-staff NappUser with LabAssigns). CakePHP 3.10 compatible.
	 */
	public function admin_customer(): ?Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Customer Management');
		$result = $this->checkAdminSession();
		if ($result instanceof Response) {
			return $result;
		}

		$name = trim((string)($this->request->getQuery('name') ?? $this->request->getData('name') ?? ''));
		$conditions = ['NappUser.is_staff_id' => 0];
		if ($name !== '') {
			$conditions['OR'] = [
				'NappUser.name LIKE' => '%' . $name . '%',
				'NappUser.lname LIKE' => '%' . $name . '%',
				'NappUser.email LIKE' => '%' . $name . '%',
			];
		}
		$query = $this->NappUser->find()
			->contain([
				'LabAssigns' => [
					'LabFiles',
				],
			])
			->where($conditions)
			->orderDesc('NappUser.id');

		$nappUser = $this->paginate($query, ['limit' => 25]);
		$this->set(compact('nappUser', 'name'));
		return null;
	}
	
	/** CamelCase alias for CakePHP 3 routing (sidebar Customers link) */
	public function adminCustomer(): ?Response
	{
		return $this->admin_customer();
	}

	/** Activate/Deactivate customer account login access. */
	public function admin_customer_status($id = null, $status = null): ?Response
	{
		$this->request->allowMethod(['get', 'post']);
		$this->viewBuilder()->setLayout('admin_layout');
		$result = $this->checkAdminSession();
		if ($result instanceof Response) {
			return $result;
		}

		$uid = (int)$id;
		$active = ((int)$status === 1) ? 1 : 0;
		$backTo = (string)$this->request->getQuery('back', 'customer');
		$redirectAction = ($backTo === 'staff') ? 'admin_staff' : 'admin_customer';
		if ($uid <= 0) {
			$this->Flash->error('Invalid user.');
			return $this->redirect(['action' => $redirectAction]);
		}

		$user = $this->NappUser->find()
			->where(['NappUser.id' => $uid])
			->first();
		if (!$user) {
			$this->Flash->error('User not found.');
			return $this->redirect(['action' => $redirectAction]);
		}

		$user->is_active = $active;
		if ($this->NappUser->save($user)) {
			$this->Flash->success($active === 1 ? 'Login activated successfully.' : 'Login deactivated successfully.');
		} else {
			$this->Flash->error('Unable to update login status.');
		}

		return $this->redirect(['action' => $redirectAction]);
	}

	/** CamelCase alias for dispatcher compatibility. */
	public function adminCustomerStatus($id = null, $status = null): ?Response
	{
		return $this->admin_customer_status($id, $status);
	}

	// CamelCase alias for CakePHP 3 routing
	public function adminQuizz() { return $this->admin_quizz(); }

	function admin_quizz()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Submited Quizz');
		$this->checkAdminSession();
		
		$this->paginate = [
			'limit' => 10,
			'order' => ['QuestionSubmits.id' => 'DESC'],
		];
		$query = $this->QuestionSubmits->find()
			->contain(['NappUser' => function ($q) {
				return $q->select(['NappUser.id', 'NappUser.name', 'NappUser.lname']);
			}]);
		$results = $this->paginate($query);
		
		// Convert entities to array format for backward compatibility with view
		$QuestionSubmitArr = [];
		foreach ($results as $row) {
			$napp = $row->napp_user ?? $row->nappUser ?? null;
			$nappArray = $napp ? (is_object($napp) ? $napp->toArray() : $napp) : [];
			$rowArray = $row->toArray();
			unset($rowArray['napp_user'], $rowArray['nappUser']);
			$QuestionSubmitArr[] = [
				'QuestionSubmit' => $rowArray,
				'NappUser' => $nappArray,
			];
		}
		$this->set('QuestionSubmitArr', $QuestionSubmitArr);	
	}
	
	/**
	 * CamelCase alias for routing: /admin/users/staff -> admin_staff
	 */
	public function adminStaff()
	{
		return $this->admin_staff();
	}

	function admin_staff()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Staff List');
		$result = $this->checkAdminSession();
		if ($result instanceof \Cake\Http\Response) {
			return $result;
		}

		$name = trim((string)($this->request->getQuery('name', $this->request->getData('name') ?? '')));

		$query = $this->NappUser->find()
			->contain(['LabAssigns' => ['LabFiles']])
			->orderDesc('NappUser.id');
		if ($name !== '') {
			$query->where([
				'NappUser.is_staff_id' => 1,
				'OR' => [
					'NappUser.name LIKE' => '%' . $name . '%',
					'NappUser.lname LIKE' => '%' . $name . '%',
					'NappUser.email LIKE' => '%' . $name . '%',
				],
			]);
		} else {
			$query->where(['NappUser.is_staff_id' => 1]);
		}
		$paginated = $this->paginate($query, ['limit' => 25]);
		$staffArr = [];
		foreach ($paginated as $entity) {
			$labAssign = [];
			$labAssigns = $entity->lab_assigns ?? [];
			if (is_object($labAssigns) && method_exists($labAssigns, 'toArray')) {
				$labAssigns = $labAssigns->toArray();
			} elseif (!is_array($labAssigns)) {
				$labAssigns = [];
			}
			foreach ($labAssigns as $la) {
				$laArr = is_object($la) ? $la->toArray() : (array)$la;
				$labFile = isset($la->lab_files) ? $la->lab_files : (isset($la->lab_file) ? $la->lab_file : null);
				$labAssign[] = [
					'LabAssign' => $laArr,
					'LabFile' => $labFile ? (is_object($labFile) ? $labFile->toArray() : (array)$labFile) : [],
				];
			}
			$staffArr[] = [
				'NappUser' => $entity->toArray(),
				'LabAssign' => $labAssign,
			];
		}
		$this->set('staffArr', $staffArr);
		$this->set('name', $name);
	}
	
	public function adminLabfile()
	{
		return $this->admin_labfile();
	}

	function admin_labfile()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Label File List');
		$this->checkAdminSession();
		$query = $this->LabFile->find();
		$paginatedResults = $this->paginate($query);
		// Convert entities to CakePHP 2 array format for view compatibility
		$staffArrArr = [];
		foreach ($paginatedResults as $entity) {
			$staffArrArr[] = ['LabFile' => $entity->toArray()];
		}
		//echo '<pre>'; print_r($staffArrArr); die;
		$this->set('staffArrArr',$staffArrArr);	
	}
	
	public function adminUpdatelabfile($id = null)
	{
		return $this->admin_updatelabfile($id);
	}

	function admin_updatelabfile($id=null)
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' update Label File');
		$this->checkAdminSession();
		$labfileEntity = $this->LabFile->find()->where(['LabFile.id' => $id])->first();
		if (!$labfileEntity) {
			$this->Flash->error('Lab file not found');
			return $this->redirect(['action' => 'admin_labfile']);
		}
		$labfile = ['LabFile' => $labfileEntity->toArray()];
		$this->set('labfile', $labfile);
		
		if(!empty($this->request->getData())){
			$data = $this->request->getData();
			$dir = $labfile['LabFile']['dir'];
			$password = $data['User']['password'] ?? '';
			
			$updateData = ['password' => $password];
			
			if(!empty($_FILES['filename']['name'])){
				$filename = time().$_FILES['filename']['name'];
				$tmp_name = $_FILES['filename']['tmp_name'];
				
				// Clean up directory path (remove leading/trailing slashes)
				$dir = trim($dir, '/\\');
				$uploadDir = WWW_ROOT . DS . $dir;
				
				// Create directory if it doesn't exist
				if (!is_dir($uploadDir)) {
					if (!mkdir($uploadDir, 0755, true)) {
						$this->Flash->error('Failed to create upload directory');
						return;
					}
				}
				
				$targetPath = $uploadDir . DS . $filename;
				
				if (move_uploaded_file($tmp_name, $targetPath)) {
					$updateData['filename'] = $filename;
				} else {
					$this->Flash->error('Failed to upload file. Please check directory permissions.');
					return;
				}
			}
			
			$labfileEntity = $this->LabFile->patchEntity($labfileEntity, $updateData, ['validate' => false, 'guard' => false]);
			if($this->LabFile->save($labfileEntity)){
				$this->Flash->success('File updated successfully');
				return $this->redirect(['action' => 'admin_labfile']);
			} else {
				$this->Flash->error('File could not be updated');
			}
		}		
	}
	
	function apppricelistrequest(){
		
		$this->autoRender = false;
		
		isset($_REQUEST['customer_id']) ? $customer_id = $_REQUEST['customer_id'] : $customer_id = 0;		
		$user = $this->NappUser->find()->where(['NappUser.id' => $customer_id])->first();
		if(!empty($user)){			
			$custId = base64_encode(base64_encode($customer_id));
			$url = SITEURL.'admin/users/accesstouser/'.$custId;
			
			$to = 'kal@durotechindustries.com.au';				
			#$to = 'web@xoroglobal.com';				
			$subject=SITENAME." :: Request For Price List";				
			$template_name = 'pricelist';
			$name =  $user['NappUser']['name'].' '.$user['NappUser']['lname'];
			$variables = array('name'=>$name,'email'=>$user['NappUser']['email'],'type'=>'pricelist','url'=>$url);		
			try{
				$this->sendemail($to,$subject,$template_name,$variables);
			}catch (Exception $e){
				
			}	
			$data['status'] = true;
			$data['message'] = 'Request sent successfully';		
		}else{
			$data['status'] = false;
			$data['message'] = 'This user is not exist';			
		}	
		echo json_encode($data);	
	}
	
	function accesslabfile(){
		
		$this->autoRender = false;
		
		isset($_REQUEST['customer_id']) ? $customer_id = $_REQUEST['customer_id'] : $customer_id = 0;
		if (!empty($customer_id)) {
			$LabAssign = $this->LabAssign->find()
				->where(['LabAssign.customer_id' => $customer_id])
				->contain(['LabFile'])
				->all();
			if ($LabAssign->count() > 0) {
				$lablist = [];
				$i = 1;
				foreach ($LabAssign as $entity) {
					$lf = $entity->lab_file;
					$lab = [
						'id' => $i,
						'label' => $lf ? ($lf->label ?? '') : '',
						'password' => $lf ? ($lf->password ?? '') : '',
						'url' => (defined('SITEURL') ? SITEURL : '') . ($lf ? ($lf->dir ?? '') . '/' . ($lf->filename ?? '') : ''),
					];
					$lablist[] = $lab;
					$i++;
				}
				$data['status'] = true;
				$data['data'] = $lablist;
			} else {
				$data['status'] = false;
				$data['data'] = 'No File Access';
			}
		} else {
			$data['status'] = false;
			$data['message'] = 'user id missing';
		}	
		echo json_encode($data);
	}	
	
	function labfile()
	{
		$is_staff_id=$this->request->getSession()->read('Customer.is_staff_id');	
		if($is_staff_id == 0){
			$this->viewBuilder()->setLayout('inner_layout');
		}else{
			$this->viewBuilder()->setLayout('staff_inner_layout');
		}	
		#$this->checkCustomerSession();
		$this->checkcommonSession();
		
		$this->set('title_for_layout', SITENAME . ' Label File List');
		$customer_id = $this->request->getSession()->read('Customer.id');
		$query = $this->LabAssign->find()
			->where(['LabAssign.customer_id' => $customer_id])
			->contain(['LabFile']);
		$paginated = $this->paginate($query, ['limit' => 10]);
		$LabAssignArr = [];
		foreach ($paginated as $entity) {
			$LabAssignArr[] = [
				'LabAssign' => $entity->toArray(),
				'LabFile' => $entity->lab_file ? (is_object($entity->lab_file) ? $entity->lab_file->toArray() : (array)$entity->lab_file) : [],
			];
		}
		$this->set('LabAssignArr', $LabAssignArr);	
	}
	
	
	
	public function labelpdffile($dir = null): ?Response
	{
		$is_staff_id = $this->request->getSession()->read('Customer.is_staff_id');
		if ($is_staff_id == 0) {
			$this->viewBuilder()->setLayout('inner_layout');
		} else {
			$this->viewBuilder()->setLayout('staff_inner_layout');
		}
		$this->checkcommonSession();

		$this->set('title_for_layout', SITENAME . ' | Price PDF File');

		$customer_id = $this->request->getSession()->read('Customer.id');
		$LabFile = $this->LabFile->find()->where(['LabFile.dir' => $dir])->first();
		if (empty($LabFile)) {
			return $this->redirect(['action' => 'labfile']);
		}

		$this->set('is_access', 0);
		$opt = $this->request->getSession()->read('opt');
		$pdfaceess = $this->request->getSession()->read('pdfaceess');

		if ($this->request->is('post') && $this->request->getData('otp') !== null && $this->request->getData('otp') !== '') {
			$uotp = (string)$this->request->getData('otp');
			$userEntity = $this->NappUser->find()->where(['NappUser.otp' => $uotp, 'NappUser.id' => $customer_id])->first();

			if ($userEntity) {
				$userEntity = $this->NappUser->patchEntity($userEntity, ['otp' => '']);
				$this->NappUser->save($userEntity);
				$this->request->getSession()->write('pdfaceess', 1);
				$this->request->getSession()->delete('opt');
				$this->Flash->success('Thank for verifying your account.');
				return $this->redirect(['controller' => 'Users', 'action' => 'labelpdffile', $dir]);
			}
			$this->Flash->error('Wrong otp password. Please try again.');
		} elseif (!empty($opt)) {
			$this->set('is_access', 1);
		} elseif (empty($pdfaceess) && $customer_id) {
			$rand = random_int(0, 999999);
			$userEntity = $this->NappUser->get($customer_id);
			$userEntity = $this->NappUser->patchEntity($userEntity, ['otp' => (string)$rand]);
			$this->NappUser->save($userEntity);

			$name = trim(($userEntity->name ?? '') . ' ' . ($userEntity->lname ?? ''));
			$to = $userEntity->email ?? '';
			$subject = SITENAME . ' :: One Time Password (OTP) for Price List Access. OTP is ' . $rand;
			$template_name = 'otp';
			$variables = ['name' => $name, 'otp' => $rand];

			try {
				$this->sendemail($to, $subject, $template_name, $variables);
			} catch (\Exception $e) {
			}

			$this->request->getSession()->write('opt', $rand);
			$this->Flash->success('OTP sent at email. Please check your mail and verify.');
			return $this->redirect(['controller' => 'Users', 'action' => 'labelpdffile', $dir]);
		}

		$this->set('LabFile', ['LabFile' => $LabFile->toArray()]);

		return null;
	}
	
	function admin_access($id = null): ?Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' update Label File');
		$result = $this->checkAdminSession();
		if ($result instanceof Response) {
			return $result;
		}
		$id = (int)$id;
		if (!$id || !$this->NappUser->exists(['id' => $id])) {
			$this->Flash->error('Invalid user.');
			return $this->redirect(['action' => 'admin_customer']);
		}

		$LabAssign = $this->LabAssign->find()->where(['customer_id' => $id])->all();
		$this->set('LabAssign', $LabAssign);

		$NappUser = $this->NappUser->get($id);
		$this->set('NappUser', $NappUser);

		$labfile = $this->LabFile->find()->all();
		$this->set('labfile', $labfile);

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$name = ucfirst($NappUser->name ?? '') . ' ' . ucfirst($NappUser->lname ?? '');

			$this->LabAssign->deleteAll(['customer_id' => $id]);
			$labIds = $this->request->getData('lab_id');
			if (!empty($labIds) && is_array($labIds)) {
				$labelParts = [];
				foreach ($labIds as $lab_id) {
					$lab_id = (int)$lab_id;
					if ($lab_id <= 0) continue;
					$labFile = $this->LabFile->find()->where(['id' => $lab_id])->first();
					if ($labFile) {
						$labelParts[] = $labFile->label ?? '';
					}
					$this->LabAssign->save($this->LabAssign->newEntity([
						'customer_id' => $id,
						'lab_id' => $lab_id,
					]));
				}
				$label = implode(' , ', $labelParts);
				if ($label !== '') {
					$to = $NappUser->email ?? '';
					if ($to !== '') {
						$subject = (defined('SITENAME') ? SITENAME : '') . ' :: Access To Price List Approved';
						$template_name = 'congrates_price_list';
						$variables = [
							'name' => $name,
							'label' => $label,
							'type' => (int)($NappUser->is_staff_id ?? 0),
						];
						try {
							$this->sendemail($to, $subject, $template_name, $variables);
						} catch (\Exception $e) {
							// log if needed
						}
					}
				}
			}

			$this->Flash->success('Labs Assigned');
			return $this->redirect((int)($NappUser->is_staff_id ?? 0) === 0
				? ['action' => 'admin_customer']
				: ['action' => 'admin_staff']);
		}
		return null;
	}

	/** CamelCase alias for CakePHP 3 routing (Price PDF link) */
	public function adminAccess($id = null): ?Response
	{
		return $this->admin_access($id);
	}
	
	/** CamelCase wrapper for routing */
	public function adminAddStaff()
	{
		return $this->admin_add_staff();
	}

	function admin_add_staff()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Add Staff Page');
		$result = $this->checkAdminSession();
		if ($result instanceof \Cake\Http\Response) {
			return $result;
		}
		$data = $this->request->getData('data.Staff') ?? $this->request->getData('Staff');
		if (!empty($data) && is_array($data)) {
			$email = $data['email'] ?? '';
			$existing = $this->Staff->find()->where(['Staff.email' => $email])->first();
			if (!$existing) {
				$entity = $this->Staff->newEntity($data, ['validate' => false, 'guard' => false]);
				if ($this->Staff->save($entity)) {
					$this->Flash->success('Added successfully');
					return $this->redirect(['action' => 'admin_contact']);
				}
				$this->Flash->error('Your profile has not updated');
			} else {
				$this->Flash->error('email id is already exist');
			}
		}
		$departmentList = [];
		try {
			foreach ($this->Department->find() as $d) {
				$departmentList[] = ['Department' => (is_object($d) ? $d->toArray() : (array)$d)];
			}
		} catch (\Throwable $e) {
			// Table 'departments' may not exist
		}
		$this->set('departmentArr', $departmentList);
	}
	/**
	 * CamelCase alias for routing: /admin/users/edit_staff/:id
	 */
	public function adminEditStaff($id = null)
	{
		return $this->admin_edit_staff($id);
	}

	function admin_edit_staff($id=null)
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Edit Staff Page');
		$result = $this->checkAdminSession();
		if ($result instanceof \Cake\Http\Response) {
			return $result;
		}
		$admin_id = $this->request->getSession()->read('User.id');
		$id = (int)$id;

		$entity = $this->NappUser->find()->where(['NappUser.id' => $id])->first();
		$staffArr = $entity ? ['NappUser' => $entity->toArray()] : ['NappUser' => []];

		$data = $this->request->getData('data.NappUser') ?? $this->request->getData('NappUser');
		if (!empty($data) && is_array($data)) {
			$email = $data['email'] ?? '';
			$existing = $this->NappUser->find()->where(['NappUser.id !=' => $id, 'NappUser.email' => $email])->first();
			if (!$existing) {
				$entity = $this->NappUser->get($id);
				$entity = $this->NappUser->patchEntity($entity, $data, ['validate' => false, 'guard' => false]);
				if ($this->NappUser->save($entity)) {
					$this->Flash->success('Updated successfully');
					return $this->redirect(['action' => 'admin_staff']);
				}
				$this->Flash->error('Your profile has not updated');
				$staffArr = ['NappUser' => $entity->toArray()];
			} else {
				$this->Flash->error('This employee id is already exist');
			}
		}

		$this->set(compact('staffArr'));
		$departmentList = [];
		try {
			foreach ($this->Department->find() as $d) {
				$departmentList[] = ['Department' => (is_object($d) ? $d->toArray() : (array)$d)];
			}
		} catch (\Throwable $e) {
			// Table 'departments' may not exist
		}
		$this->set('departmentArr', $departmentList);
	} 
	
	/** CamelCase wrapper for routing */
	public function adminEditNewStaff($id = null)
	{
		return $this->admin_edit_new_staff($id);
	}

	function admin_edit_new_staff($id=null)
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Edit Staff Page');
		$result = $this->checkAdminSession();
		if ($result instanceof \Cake\Http\Response) {
			return $result;
		}
		$id = (int)$id;
		$entity = $this->Staff->find()->where(['Staff.id' => $id])->first();
		$staffArr = $entity ? ['Staff' => $entity->toArray()] : ['Staff' => []];
		$data = $this->request->getData('data.Staff') ?? $this->request->getData('Staff');
		if (!empty($data) && is_array($data)) {
			$email = $data['email'] ?? '';
			$existing = $this->Staff->find()->where(['Staff.id !=' => $id, 'Staff.email' => $email])->first();
			if (!$existing) {
				$entity = $this->Staff->get($id);
				$entity = $this->Staff->patchEntity($entity, $data, ['validate' => false, 'guard' => false]);
				if ($this->Staff->save($entity)) {
					$this->Flash->success('Updated successfully');
					return $this->redirect(['action' => 'admin_contact']);
				}
				$this->Flash->error('Your profile has not updated');
				$staffArr = ['Staff' => $entity->toArray()];
			} else {
				$this->Flash->error('This employee id is already exist');
			}
		}
		$this->set(compact('staffArr'));
		$departmentList = [];
		try {
			foreach ($this->Department->find() as $d) {
				$departmentList[] = ['Department' => (is_object($d) ? $d->toArray() : (array)$d)];
			}
		} catch (\Throwable $e) {
			// Table 'departments' may not exist
		}
		$this->set('departmentArr', $departmentList);
	} 
	function register(){
		
		$this->viewBuilder()->setLayout('admin_login');
		$this->set('title_for_layout',SITENAME.' Customer Register Page');

		$data = $this->request->getData('data.NappUser') ?? $this->request->getData('NappUser') ?? ($this->request->getData()['data']['NappUser'] ?? $this->request->getData()['NappUser'] ?? null);
		if (!empty($data) && is_array($data)) {

			$email = trim((string)($data['email'] ?? ''));
			$name = trim((string)($data['name'] ?? ''));
			$pass = (string)($data['password'] ?? '');
			if ($email === '' || $name === '' || $pass === '') {
				$this->Flash->error('Please fill in Register Type, First Name, Last Name, Email and Password.');
			} else {
			$existing = $this->NappUser->find()->where(['email' => $email])->first();
			if (!$existing) {
				
				$empid = 'DT-'.rand(000000,999999);
				$password = $data['password'] ?? '';
				$autopassword = md5($password);

				$userData = [
					'name' => $data['name'] ?? '',
					'lname' => $data['lname'] ?? '',
					'email' => $email,
					'password' => $autopassword,
					'address_5' => $password,
					'emp_id' => $empid,
					'is_staff_id' => isset($data['is_staff_id']) ? (int)$data['is_staff_id'] : 0,
					'insert_date' => date('Y-m-d H:i:s'),
				];

				$entity = $this->NappUser->newEntity($userData, ['guard' => false]);
				if ($this->NappUser->save($entity)) {
					$to = $email;
					$subject = SITENAME." :: Welcome To Durotech Activate Your Account.";
					$template_name = 'activation';
					$variables = [
						'password' => base64_encode($to),
						'name' => $userData['name'],
						'email' => $to,
						'type' => 'activation'
					];
					try {
						$this->sendemail($to, $subject, $template_name, $variables);
						$this->Flash->success('Register successfully. Please check your mail and activate your account.');
					} catch (\Throwable $e) {
						$this->Flash->success('Register successfully.');
					}
					return $this->redirect('/login');
				}
				$this->Flash->error('Registration could not be saved. Please try again.');				
			} else {
				$this->Flash->error('Email id already exist.');
			}
			}
		}
	}

	function activateaccount($code=null){

		$this->autoRender = false;
		if (empty($code)) {
			$this->Flash->error('activateion code is wrong.');
			return $this->redirect('/login');
		}

		$decodedEmail = base64_decode((string)$code, true);
		if ($decodedEmail === false || $decodedEmail === '') {
			$this->Flash->error('activateion code is wrong.');
			return $this->redirect('/login');
		}

		$cus_arr = $this->NappUser->find()->where(['email' => $decodedEmail])->first();
		if (!$cus_arr) {
			$this->Flash->success('wrong activation code.');
			return $this->redirect('/login');
		}

		if ((int)($cus_arr->is_active ?? 0) !== 0) {
			$this->Flash->error('your account is already activated.');
			return $this->redirect('/login');
		}

		$password = (string)($cus_arr->address_5 ?? '');
		$cus_arr->is_active = 1;
		$cus_arr->address_5 = '';
		$this->NappUser->save($cus_arr);

		$to = (string)($cus_arr->email ?? '');
		$subject = SITENAME." :: Your account is activated.";
		$template_name = 'message';
		$variables = array('password'=>$password ,'name'=>(string)($cus_arr->name ?? ''),'email'=>$to,'type'=>'signup');
		try{
			$this->sendemail($to , $subject ,$template_name,$variables);
		}catch (\Exception $e){
			$this->Flash->success('Register successfully.');
			return $this->redirect('/login');
		}

		if ((int)($cus_arr->is_staff_id ?? 0) == 0){
			$this->Flash->success('You account has been activated successfully.');
			$this->request->getSession()->write('Customer', $cus_arr->toArray());
			$this->request->getSession()->write('is_customer', 1);
			return $this->redirect(['action' => 'dashboard']);
		}

		$semployeeid =  base64_encode(base64_encode(base64_encode((string)($cus_arr->email ?? ''))));
		$staff_to = 'kal@durotechindustries.com.au';
		$staff_subject = SITENAME." :: New Employee Registered.";
		$staff_template_name = 'staffmessage';
		$staff_variables = array(
			'emp_id'=>$semployeeid,
			'name'=>trim((string)($cus_arr->name ?? '') . ' ' . (string)($cus_arr->lname ?? '')),
			'email'=>(string)($cus_arr->email ?? ''),
			'type'=>'register'
		);
		try{
			$this->sendemail($staff_to , $staff_subject ,$staff_template_name,$staff_variables);
		}catch (\Exception $e){
			// non-blocking
		}
		$this->Flash->success('You account has been activated successfully.');
		$this->request->getSession()->write('Customer', $cus_arr->toArray());
		$this->request->getSession()->write('is_staff', 1);
		return $this->redirect('/staffs/dashboard');
	}
	
	public function autologin($email=null) {
		
		$this->viewBuilder()->setLayout('admin_login');
		$this->set('title_for_layout',SITENAME.' Customer Login Page');		
		$is_customer=$this->request->getSession()->read('is_customer');
		$is_staff=$this->request->getSession()->read('is_staff');
		
		if(!empty($is_customer)){
			return $this->redirect(['action' => 'dashboard']);
		}else if(!empty($is_staff)){
			$this->redirect('/staffs/dashboard');
		}		
		if(!empty($email)){
			
			$cus_arr = $this->NappUser->find()->where(['email' => $email])->first();
			// echo '<pre>';
			// print_r($cus_arr);
			// die();			
			if(!empty($cus_arr)){	
				if($cus_arr['NappUser']['is_active'] == 0){
					$this->Flash->error('You account is not active');
				}else{
					
				$insert['LoginHistory']['user_id'] = $cus_arr['NappUser']['id'];
				$insert['LoginHistory']['role'] = 'Customer';
				$insert['LoginHistory']['logintime'] = date('Y-m-d H:i:s');
				$this->LoginHistory->save($insert);
				
				if($cus_arr['NappUser']['is_staff_id'] == 0){					
					$this->request->getSession()->write('Customer', $cus_arr['NappUser']);
					$this->request->getSession()->write('is_customer', 1);			
					return $this->redirect(['action' => 'dashboard']);
				}else{
					$this->request->getSession()->write('Customer', $cus_arr['NappUser']);
					$this->request->getSession()->write('is_staff', 1);			
					$this->redirect('/staffs/dashboard');
				}	
				
				}
			}else{
				//$this->Flash->success(__('Wrong username/password', true));
				$this->Flash->error('Wrong username/password');
			}
		}	
	}
	
	public function login() {
		
		$this->viewBuilder()->setLayout('admin_login');
		$this->set('title_for_layout',SITENAME.' Customer Login Page');		
		$is_customer=$this->request->getSession()->read('is_customer');
		$is_staff=$this->request->getSession()->read('is_staff');
		
		if(!empty($is_customer)){
			return $this->redirect(['action' => 'dashboard']);
		}else if(!empty($is_staff)){
			$this->redirect('/staffs/dashboard');
		}		
		if(!empty($this->request->getData())){
			$password = md5($this->request->getData()['NappUser']['password']);
			$email = $this->request->getData()['NappUser']['email'] ?? '';
			$cus_arr = $this->NappUser->find()
				->where(['email' => $email, 'password' => $password])
				->first();
			if($cus_arr){
				if((int)$cus_arr->is_active === 0){
					$this->Flash->error('Your account is not active');
				}else{
					$loginEntity = $this->LoginHistory->newEntity([
						'user_id' => $cus_arr->id,
						'role' => ($cus_arr->is_staff_id == 0) ? 'Customer' : 'Staff',
						'logintime' => date('Y-m-d H:i:s'),
					]);
					$this->LoginHistory->save($loginEntity);
					$this->request->getSession()->write('Customer', $cus_arr->toArray());
					if($cus_arr->is_staff_id == 0){
						$this->request->getSession()->write('is_customer', 1);
						return $this->redirect(['action' => 'dashboard']);
					}else{
						$this->request->getSession()->write('is_staff', 1);
						return $this->redirect('/staffs/dashboard');
					}
				}
			}else{
				$this->Flash->error('Wrong username/password');
			}
		}	
	}
	
	/***
	/*Author  :Ranjit,
	/*Comment : User Logout page
****/	
	function logout()
	{
		
		$userId = $this->request->getSession()->read('Customer.id');
		$loginRec = $this->LoginHistory->find()
			->where(['logouttime' => '0000-00-00 00:00:00', 'user_id' => $userId])
			->orderDesc('id')
			->first();
		if($loginRec){
			$loginRec->logouttime = date('Y-m-d H:i:s');
			$this->LoginHistory->save($loginRec);
		}

		$this->request->getSession()->destroy();
		return $this->redirect('/login');

	}
	
	public function dashboard() {
		$this->viewBuilder()->setLayout('inner_layout');
		$this->set('title_for_layout',SITENAME.' Customer Dashboard Page');
		$this->checkCustomerSession(); 
		
	}
	
	public function questionlist($type=null){
		
		$is_staff_id = $this->request->getSession()->read('Customer.is_staff_id');
		if($is_staff_id == 1){
			$this->viewBuilder()->setLayout('staff_inner_layout');	
		}else{
			$this->viewBuilder()->setLayout('inner_layout');
		}	
		$this->checkcommonSession();
		
		$user_id = $this->request->getSession()->read('Customer.id');
		$cpdquestionaceess = $this->request->getSession()->read('cpdquestionaceess');

		if ($this->request->is('post') && $this->request->getData('otp') !== null && $this->request->getData('otp') !== '') {
			$uotp = (string)$this->request->getData('otp');
			$userEntity = $this->NappUser->find()->where(['NappUser.otp' => $uotp, 'NappUser.id' => $user_id])->first();

			if ($userEntity) {
				$userEntity = $this->NappUser->patchEntity($userEntity, ['otp' => '']);
				$this->NappUser->save($userEntity);
				$this->request->getSession()->write('cpdquestionaceess', 2);
				$this->request->getSession()->delete('opt');
				$this->Flash->success('Thank for verifying your account.');
				return $this->redirect(['action' => 'questionlist']);
			}
			$this->Flash->error('Wrong otp password. Please try again.');
			return $this->redirect(['action' => 'questionlist']);
		}
		if (!empty($cpdquestionaceess)) {
			$this->set('is_access', $cpdquestionaceess);
		} elseif (empty($cpdquestionaceess) && !empty($type) && $user_id) {
			$rand = random_int(0, 999999);
			$userEntity = $this->NappUser->get($user_id);
			$userEntity = $this->NappUser->patchEntity($userEntity, ['otp' => (string)$rand]);
			$this->NappUser->save($userEntity);

			$name = trim(($userEntity->name ?? '') . ' ' . ($userEntity->lname ?? ''));
			$to = $userEntity->email ?? '';
			$subject = SITENAME . ' :: Secure One-Time-Password (OTP) for  Architect CPD Questionnaire. OTP is ' . $rand;
			$template_name = 'durolabotp';
			$variables = ['email' => $to, 'name' => $name, 'otp' => $rand];
			try {
				$this->sendemail($to, $subject, $template_name, $variables);
			} catch (\Exception $e) {
			}
			if (!empty($userEntity->mobile_number) && ((int)($userEntity->is_active_otp ?? 0) === 1)) {
				if (strtolower((string)($userEntity->country ?? '')) !== 'india') {
					$phones = str_replace(' ', '', (string)$userEntity->mobile_number);
					$phone = ltrim($phones, '+');
					$smsTo = '+' . $phone;
					$from = defined('FROM_NUMBER') ? FROM_NUMBER : '';
					$body = 'Hi, Secure OTP for  Architect CPD Questionnaire Access. OTP is ' . $rand;
					if (isset($this->Twilio) && is_object($this->Twilio) && method_exists($this->Twilio, 'sendsms')) {
						$this->Twilio->AccountSid = defined('TSID') ? TSID : '';
						$this->Twilio->AccountToken = defined('TOKEN') ? TOKEN : '';
						$this->Twilio->sendsms($smsTo, $from, $body);
					}
				}
			}
			$this->request->getSession()->write('cpdquestionaceess', 1);
			return $this->redirect(['action' => 'questionlist']);
		} else {
			$this->set('is_access', 0);
		}
		
		
		//$this->viewBuilder()->setLayout('inner_layout');
		$this->set('title_for_layout', SITENAME . ' Customer questionlist');
		$customer_id = $this->request->getSession()->read('Customer.id');
		$user = $this->NappUser->find()->where(['NappUser.id' => $customer_id])->first();
		$this->set('user', $user);

		$questionQuery = $this->Question->find()->contain(['QuestionOptions'])->orderAsc('Question.id');
		$questionResult = $questionQuery->all();
		// Convert to CakePHP 2-style array for view compatibility
		$question = [];
		foreach ($questionResult as $q) {
			$row = ['Question' => $q->toArray(), 'QuestionOption' => []];
			foreach ($q->question_options ?? [] as $opt) {
				$row['QuestionOption'][] = is_object($opt) ? $opt->toArray() : $opt;
			}
			$question[] = $row;
		}
		$this->set('question', $question);

		$user_answers = $this->UserAnswer->find()->where(['UserAnswer.user_id' => $customer_id])->all();
		$this->set('user_answers', $user_answers);
		
		if (!empty($this->request->getData())) {
			$data = $this->request->getData();
			$name = $data['name'] ?? '';
			$lname = $data['lname'] ?? '';
			$email = $data['email'] ?? '';
			$phone = $data['mobile'] ?? '';
			$landlineno = $data['landlineno'] ?? '';
			$company = $data['company'] ?? '';
			$company_address = $data['company_address'] ?? '';

			$entity = $this->QuestionSubmits->newEntity([
				'user_id' => $customer_id,
				'name' => $name,
				'lname' => $lname,
				'phone' => $phone,
				'email' => $email,
				'landlineno' => $landlineno,
				'company' => $company,
				'company_address' => $company_address,
			]);
			if ($this->QuestionSubmits->save($entity)) {
				$url = rtrim(SITEURL, '/') . '/finalsubmit.php?user_id=' . $customer_id;
				@file_get_contents($url);
				$custname = base64_encode(base64_encode($name));
				return $this->redirect(['action' => 'thanks', $custname]);
			}
		}	
		
	}
	
	
	function welcomemailer(){
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$name = $data['name'] ?? '';
			$lname = $data['lname'] ?? '';
			$email = $data['email'] ?? '';
			$phone = $data['phone'] ?? '';

			$entity = $this->CpdMailer->newEntity([
				'user_id' => $user_id,
				'name' => $name,
				'lname' => $lname,
				'phone' => $phone,
				'email' => $email,
			]);
			if ($this->CpdMailer->save($entity)) {
				$QuestionSubmitId = $entity->id;
				$url = rtrim(SITEURL, '/') . '/welcomecertifcatie.php?user_id=' . $QuestionSubmitId;
				@file_get_contents($url);
				$this->Flash->success('CPD Presentation Mailer sent successfully.');
				return $this->redirect(['action' => 'welcomemailer']);
			}
		}

		$query = $this->CpdMailer->find()
			->where(['CpdMailer.user_id' => $user_id])
			->orderDesc('CpdMailer.id');
		$results = $this->paginate($query, ['limit' => 10]);
		$CpdMailerArr = [];
		foreach ($results as $row) {
			$CpdMailerArr[] = ['CpdMailer' => $row->toArray()];
		}
		$this->set('CpdMailer', $CpdMailerArr);
	}	
	
	function cert(){
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->checkSatffSession();

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$data = $this->request->getData();
			$name = $data['name'] ?? '';
			$lname = $data['lname'] ?? '';
			$email = $data['email'] ?? '';
			$phone = $data['phone'] ?? '';
			$landlineno = $data['landlineno'] ?? '';
			$company = $data['company'] ?? '';
			$company_address = $data['company_address'] ?? '';

			$entity = $this->QuestionSubmits->newEntity([
				'user_id' => 0,
				'name' => $name,
				'lname' => $lname,
				'phone' => $phone,
				'email' => $email,
				'landlineno' => $landlineno,
				'company' => $company,
				'company_address' => $company_address,
			]);
			if ($this->QuestionSubmits->save($entity)) {
				$QuestionSubmitId = $entity->id;
				$url = rtrim(SITEURL, '/') . '/finalcertifcatie.php?user_id=' . $QuestionSubmitId;
				@file_get_contents($url);
				$custname = base64_encode(base64_encode($name));
				$this->Flash->success('Cpd certification sent successfully');
				return $this->redirect(['action' => 'cert']);
			}
		}

		$query = $this->QuestionSubmits->find()->orderDesc('QuestionSubmits.id');
		$results = $this->paginate($query, ['limit' => 10]);
		$QuestionSubmitArr = [];
		foreach ($results as $row) {
			$QuestionSubmitArr[] = ['QuestionSubmit' => $row->toArray()];
		}
		$this->set('QuestionSubmitArr', $QuestionSubmitArr);
	}	
	public function thanks($custname=null) {
		
		$this->set('title_for_layout',SITENAME.' Customer Dashboard Page');		
		$is_staff_id = $this->request->getSession()->read('Customer.is_staff_id');
		if($is_staff_id == 1){
			$this->viewBuilder()->setLayout('staff_inner_layout');	
		}else{
			$this->viewBuilder()->setLayout('inner_layout');
		}	
		$this->checkcommonSession();
		
		$this->set('custname',$custname);
		
	}
	
	
	function profile()
	{
		$this->viewBuilder()->setLayout('inner_layout');
		$this->set('title_for_layout',SITENAME.' Profile Page');
		$this->checkCustomerSession();
		$customer_id=$this->request->getSession()->read('Customer.id');
			
		$user = $this->NappUser->find()->where(['NappUser.id' => $customer_id])->first();
		if(!empty($this->request->getData())){
			if(!empty($user)){
				$data = $this->request->getData();
				$data['NappUser']['id'] = $customer_id;
				if ($this->NappUser->save($data)) {
					$this->Flash->success('Your profile has been updated');
					return $this->redirect(['action' => 'profile']);
				}
				$this->Flash->error('Your profile has not updated');
			}
		}
		$this->set('user', $user);
	}

	/**
	 * Toggle Natspec presentation status for a customer/staff. CakePHP 3.10.
	 */
	public function admin_natspec_presentation_status($user_id = null, $status = null, $type = null): ?Response
	{
		$user_id = (int)$user_id;
		if (!$user_id || !$this->NappUser->exists(['id' => $user_id])) {
			$this->Flash->error('Invalid user.');
			return $this->redirect(['action' => 'admin_customer']);
		}
		$user = $this->NappUser->get($user_id);
		$user->is_natspec_presentation = (int)$status;
		$this->NappUser->save($user);
		$this->Flash->success('Natspec presentation status has been updated.');
		return $this->redirect(($type == 1) ? ['action' => 'admin_staff'] : ['action' => 'admin_customer']);
	}

	/**
	 * Toggle CPD presentation status for a customer/staff. CakePHP 3.10.
	 */
	public function admin_cpd_presentation_status($user_id = null, $status = null, $type = null): ?Response
	{
		$user_id = (int)$user_id;
		if (!$user_id || !$this->NappUser->exists(['id' => $user_id])) {
			$this->Flash->error('Invalid user.');
			return $this->redirect(['action' => 'admin_customer']);
		}
		$user = $this->NappUser->get($user_id);
		$user->is_cpd_presentation = (int)$status;
		$this->NappUser->save($user);
		$this->Flash->success('CPD presentation status has been updated.');
		return $this->redirect(($type == 1) ? ['action' => 'admin_staff'] : ['action' => 'admin_customer']);
	}

	/** CamelCase alias for CakePHP 3 routing */
	public function adminNatspecPresentationStatus($user_id = null, $status = null, $type = null): ?Response
	{
		return $this->admin_natspec_presentation_status($user_id, $status, $type);
	}

	/** CamelCase alias for CakePHP 3 routing */
	public function adminCpdPresentationStatus($user_id = null, $status = null, $type = null): ?Response
	{
		return $this->admin_cpd_presentation_status($user_id, $status, $type);
	}

	function change_password()
	{
		$this->viewBuilder()->setLayout('inner_layout');
		$this->set('title_for_layout',SITENAME.' Change Password Page');
		$this->checkCustomerSession();
		if($this->request->is('post')){
			$customer_id=$this->request->getSession()->read('Customer.id');
			$user = $this->NappUser->find()->where(['NappUser.id' => $customer_id])->first();
			if(!empty($user)){
				$this->NappUser->id=$user['NappUser']['id'];
				if($this->request->getData()['NappUser']['new_password']==$this->request->getData()['NappUser']['confirm_password'])
				{
						
					if($user['NappUser']['password']==$this->request->getData()['NappUser']['current_password'])
					{
						
						$this->NappUser->saveField("password",$this->request->getData()['NappUser']['new_password']);
						
						$this->Flash->success('Your password has been changed successfully.');
					}else{
						$this->Flash->error('Current password not correct.Please, try again.');
					}
				}else{
					
					$this->Flash->error('New and confirm password not matched.Please, try again.');
				}
				
				
			}else{
				$this->Flash->error('User record not found.Please, try again.');
			}
			
		}
	}

	/** CamelCase alias for CakePHP 3 dispatcher compatibility. */
	public function changePassword()
	{
		return $this->change_password();
	}
	
	function admin_accesstouser($custId=null){
		
		$this->autoRender = false;
		if(!empty($custId)){
			$custId = base64_decode(base64_decode($custId));
			$user = $this->NappUser->find()->where(['NappUser.id' => $custId])->first();
			if(!empty($user)){						
				$admin_arr = $this->User->find()->first();
				if(!empty($admin_arr)){				
				$this->request->getSession()->write('User', $admin_arr['User']);
				$this->request->getSession()->write('is_admin', 1);			
				$this->redirect('access/'.$custId);
				}else{
					//$this->Flash->success(__('Wrong username/password', true));
					$this->Flash->error('Wrong username/password');
				}
			}else{
				$this->Flash->error('sorry this customer not exist.');	
				$this->redirect(rtrim(SITEURL, '/') . '/admin');		
			}	
		}else{
			$this->Flash->error('customer id is missing.');	
			$this->redirect(rtrim(SITEURL, '/') . '/admin');
		}	
	}	
	
	
	
	function pricelistrequest(){
		
		$this->autoRender = false;
		
		$customer_id = $this->request->getSession()->read('Customer.id');	
		$user = $this->NappUser->find()->where(['NappUser.id' => $customer_id])->first();
		if(!empty($user)){			
			$custId = base64_encode(base64_encode((string)$customer_id));
			$url = SITEURL.'admin/users/accesstouser/'.$custId;
			$name = ($user->get('name') ?? '') . ' ' . ($user->get('lname') ?? '');
			$to = 'kal@durotechindustries.com.au';				
			#$to = 'web@xoroglobal.com';				
			$subject=SITENAME." :: Request For Price List by ".$name;				
			$template_name = 'pricelist';
			
			$variables = array('name'=>$name,'email'=>$user->get('email') ?? '','type'=>'pricelist','url'=>$url);		
			try{
				$this->sendemail($to,$subject,$template_name,$variables);
			}catch (Exception $e){
				
			}	
			$this->Flash->success('Your request has been sent!.');
			$this->redirect(['action' => 'labfile']);
		}		
	}	
	function access($status=null){
		
		$this->autoRender = false;
		$customer_id=$this->request->getSession()->read('Customer.id');
		$user = $this->NappUser->find()->where(['NappUser.id' => $customer_id])->first();
		if(!empty($user)){
			
			if($status == 0){
							
				$to = 'kal@durotechindustries.com.au';				
				$subject=SITENAME." :: Refuel CPD Access";				
				$template_name = 'refuel';
				$name =  (string)($user->name ?? '') . ' ' . (string)($user->lname ?? '');
				$variables = array('name'=>trim($name),'email'=>(string)($user->email ?? ''),'type'=>'Refuel');		
				try{
					$this->sendemail($to,$subject,$template_name,$variables);
				}catch (Exception $e){
					
				}	
				$this->Flash->success('Your request has been sent!');
				return $this->redirect(['action' => 'questionlist']);
			}else{ 
				$to = 'kal@durotechindustries.com.au';				
				$subject=SITENAME." :: Natspec Presentation Access";				
				$template_name = 'refuel';
				$name =  (string)($user->name ?? '') . ' ' . (string)($user->lname ?? '');
				$variables = array('name'=>trim($name),'email'=>(string)($user->email ?? ''),'type'=>'Presentation');		
				try{
					$this->sendemail($to,$subject,$template_name,$variables);
				}catch (Exception $e){
					
				}
				$this->Flash->success('Your request has been sent!');
				return $this->redirect(['action' => 'presentation']);	
			}	
				
		}	
	}	
	
	function coupon(){
		$this->autoRender = false;
		isset($_REQUEST['code'])? $code = $_REQUEST['code'] : $code = '';
		if(!empty($code)){
			
			$codeArr = $this->Coupon->find()->where(['Coupon.code' => $code])->first();
			if(!empty($codeArr)){
				
				if($codeArr['Coupon']['is_read'] == 0){
					
					$update['Coupon']['id'] = $codeArr['Coupon']['id'];
					$update['Coupon']['is_read'] = 1;
					$this->Coupon->save($update);
					if($codeArr['Coupon']['is_ok'] == 1){
						$data['status'] = true;
						$data['message'] = 'Congrats! you have won $'.$codeArr['Coupon']['price'].'  Now contact technical@durotechindustries.com.au to redeeem your prize';	
					}else{
						$data['status'] = false;
						$data['message'] = 'Sorry this wrong coupon code';
					}					
				}else{
					$data['status'] = false;
					$data['message'] = 'This coupon code has already been used.';
				}	
				
			}else{
				$data['status'] = false;
				$data['message'] = 'wrong code';
			}	
		}else{
			$data['status'] = false;
			$data['message'] = 'please enter code';	
		}	
		echo json_encode($data);
	}	
	public function cpdpresentation($type=null){
		$is_staff_id = $this->request->getSession()->read('Customer.is_staff_id');
		if($is_staff_id == 1){
			$this->viewBuilder()->setLayout('staff_inner_layout');	
		}else{
			$this->viewBuilder()->setLayout('inner_layout');
		}
		
		$this->checkcommonSession();
		$this->set('title_for_layout',SITENAME.' | CPD Presentation');			
		$user_id=$this->request->getSession()->read('Customer.id');
		$cpdaceess=$this->request->getSession()->read('cpdaceess');
		
		if ($this->request->is('post') && $this->request->getData('otp') !== null && $this->request->getData('otp') !== '') {
			$uotp = (string)$this->request->getData('otp');
			$userEntity = $this->NappUser->find()->where(['NappUser.otp' => $uotp, 'NappUser.id' => $user_id])->first();

			if ($userEntity) {
				$userEntity = $this->NappUser->patchEntity($userEntity, ['otp' => '']);
				$this->NappUser->save($userEntity);
				$this->request->getSession()->write('cpdaceess', 2);
				$this->request->getSession()->delete('opt');
				$this->Flash->success('Thank for verifying your account.');
				return $this->redirect(['action' => 'cpdpresentation']);
			}
			$this->Flash->error('Wrong otp password. Please try again.');
			return $this->redirect(['action' => 'cpdpresentation']);
		}
		if (!empty($cpdaceess)) {
			$this->set('is_access', $cpdaceess);
		} elseif (empty($cpdaceess) && !empty($type) && $user_id) {
			$rand = random_int(0, 999999);
			$userEntity = $this->NappUser->get($user_id);
			$userEntity = $this->NappUser->patchEntity($userEntity, ['otp' => (string)$rand]);
			$this->NappUser->save($userEntity);

			$name = trim(($userEntity->name ?? '') . ' ' . ($userEntity->lname ?? ''));
			$to = $userEntity->email ?? '';
			$subject = SITENAME . ' :: Secure One-Time-Password (OTP) for CPD Presentation. OTP is ' . $rand;
			$template_name = 'durolabotp';
			$variables = ['email' => $to, 'name' => $name, 'otp' => $rand];
			try {
				$this->sendemail($to, $subject, $template_name, $variables);
			} catch (\Exception $e) {
			}
			if (!empty($userEntity->mobile_number) && ((int)($userEntity->is_active_otp ?? 0) === 1)) {
				if (strtolower((string)($userEntity->country ?? '')) !== 'india') {
					$phones = str_replace(' ', '', (string)$userEntity->mobile_number);
					$phone = ltrim($phones, '+');
					$smsTo = '+' . $phone;
					$from = defined('FROM_NUMBER') ? FROM_NUMBER : '';
					$body = 'Hi, Secure OTP for CPD Presentation Access. OTP is ' . $rand;
					if (isset($this->Twilio) && is_object($this->Twilio) && method_exists($this->Twilio, 'sendsms')) {
						$this->Twilio->AccountSid = defined('TSID') ? TSID : '';
						$this->Twilio->AccountToken = defined('TOKEN') ? TOKEN : '';
						$this->Twilio->sendsms($smsTo, $from, $body);
					}
				}
			}
			$this->request->getSession()->write('cpdaceess', 1);
			return $this->redirect(['action' => 'cpdpresentation']);
		} else {
			$this->set('is_access', 0);
		}

		$customer_id = $this->request->getSession()->read('Customer.id');
		$user = $customer_id ? $this->NappUser->find()->where(['NappUser.id' => $customer_id])->first() : null;
		$this->set('user', $user);
	}
	public function presentation($type=null){
		$is_staff_id = $this->request->getSession()->read('Customer.is_staff_id');
		if($is_staff_id == 1){
			$this->viewBuilder()->setLayout('staff_inner_layout');	
		}else{
			$this->viewBuilder()->setLayout('inner_layout');
		}
		
		$this->checkcommonSession();
		$this->set('title_for_layout',SITENAME.' | Presentation');			
		$user_id=$this->request->getSession()->read('Customer.id');
		$cpdaceess=$this->request->getSession()->read('cpdaceess');
		
		if ($this->request->is('post') && $this->request->getData('otp') !== null && $this->request->getData('otp') !== '') {
			$uotp = (string)$this->request->getData('otp');
			$userEntity = $this->NappUser->find()->where(['NappUser.otp' => $uotp, 'NappUser.id' => $user_id])->first();

			if ($userEntity) {
				$userEntity = $this->NappUser->patchEntity($userEntity, ['otp' => '']);
				$this->NappUser->save($userEntity);
				$this->request->getSession()->write('cpdaceess', 2);
				$this->request->getSession()->delete('opt');
				$this->Flash->success('Thank for verifying your account.');
				return $this->redirect(['action' => 'presentation']);
			}
			$this->Flash->error('Wrong otp password. Please try again.');
			return $this->redirect(['action' => 'presentation']);
		}
		if (!empty($cpdaceess)) {
			$this->set('is_access', $cpdaceess);
		} elseif (empty($cpdaceess) && !empty($type) && $user_id) {
			$rand = random_int(0, 999999);
			$userEntity = $this->NappUser->get($user_id);
			$userEntity = $this->NappUser->patchEntity($userEntity, ['otp' => (string)$rand]);
			$this->NappUser->save($userEntity);

			$name = trim(($userEntity->name ?? '') . ' ' . ($userEntity->lname ?? ''));
			$to = $userEntity->email ?? '';
			$subject = SITENAME . ' :: Secure One-Time-Password (OTP) for Architect Presentation. OTP is ' . $rand;
			$template_name = 'durolabotp';
			$variables = ['email' => $to, 'name' => $name, 'otp' => $rand];
			try {
				$this->sendemail($to, $subject, $template_name, $variables);
			} catch (\Exception $e) {
			}
			if (!empty($userEntity->mobile_number) && ((int)($userEntity->is_active_otp ?? 0) === 1)) {
				if (strtolower((string)($userEntity->country ?? '')) !== 'india') {
					$phones = str_replace(' ', '', (string)$userEntity->mobile_number);
					$phone = ltrim($phones, '+');
					$smsTo = '+' . $phone;
					$from = defined('FROM_NUMBER') ? FROM_NUMBER : '';
					$body = 'Hi, Secure OTP for Architect Presentation Access. OTP is ' . $rand;
					if (isset($this->Twilio) && is_object($this->Twilio) && method_exists($this->Twilio, 'sendsms')) {
						$this->Twilio->AccountSid = defined('TSID') ? TSID : '';
						$this->Twilio->AccountToken = defined('TOKEN') ? TOKEN : '';
						$this->Twilio->sendsms($smsTo, $from, $body);
					}
				}
			}
			$this->request->getSession()->write('cpdaceess', 1);
			return $this->redirect(['action' => 'presentation']);
		} else {
			$this->set('is_access', 0);
		}

		$customer_id = $this->request->getSession()->read('Customer.id');
		$user = $customer_id ? $this->NappUser->find()->where(['NappUser.id' => $customer_id])->first() : null;
		$this->set('user', $user);
	}
	function contact()
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Staff List');
		$query = $this->Staff->find()->contain(['Department'])->orderDesc('Staff.id');
		$results = $this->paginate($query, ['limit' => 25]);
		$staffArr = [];
		foreach ($results as $entity) {
			$row = ['Staff' => $entity->toArray()];
			$row['Department'] = (isset($entity->department) && $entity->department)
				? $entity->department->toArray()
				: ['id' => null, 'department_title' => ''];
			$staffArr[] = $row;
		}
		$this->set('staffArr', $staffArr);
	}

	/** CamelCase wrapper for routing */
	public function adminContact()
	{
		return $this->admin_contact();
	}

	function admin_contact()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Staff List');
		$this->checkAdminSession();

		$query = $this->Staff->find()->contain(['Department'])->orderDesc('Staff.id');
		$results = $this->paginate($query, ['limit' => 25]);
		// Convert to CakePHP 2-style array for view
		$staffArr = [];
		foreach ($results as $entity) {
			$row = ['Staff' => $entity->toArray()];
			$row['Department'] = (isset($entity->department) && $entity->department)
				? $entity->department->toArray()
				: ['id' => null, 'department_title' => ''];
			$staffArr[] = $row;
		}
		$this->set('staffArr', $staffArr);
	}

	/**
	 * CamelCase alias for admin_loginhisotry (CakePHP 3 routing).
	 */
	public function adminLoginhisotry()
	{
		return $this->admin_loginhisotry();
	}

	function admin_loginhisotry()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Login History');
		$this->checkAdminSession();

		$this->paginate = [
			'limit' => 10,
			'order' => ['LoginHistory.id' => 'DESC'],
		];
		$LoginHistoryArr = $this->paginate(
			$this->LoginHistory->find()->contain(['User', 'NappUser'])
		);
		$this->set('LoginHistoryArr', $LoginHistoryArr);
	}

	/**
	 * CakePHP 3 dispatches admin_logintostaff as adminLogintostaff(); keep wrapper + legacy method.
	 */
	public function adminLogintostaff(): ?Response
	{
		return $this->admin_logintostaff();
	}

	public function admin_logintostaff(): ?Response
	{
		$this->checkAdminSession();
		$this->autoRender = false;

		$cus_arr = $this->NappUser->find()->where(['email' => 'kal@durotechindustries.com.au'])->first();
		if (!empty($cus_arr)) {
			$this->request->getSession()->write('Customer', $cus_arr->toArray());
			$this->request->getSession()->write('is_staff', 1);
			return $this->redirect('/staffs/dashboard');
		}
		$this->Flash->error('Staff profile for this switch was not found.');
		return $this->redirect('/admin/users/dashboard');
	}	
	
	function logintostaff(){
		$this->checkAdminSession();
		$this->autoRender = false;
		
		$admin_arr = $this->User->find()->where(['id' => 2])->first();
		if(!empty($admin_arr)){
			$this->request->getSession()->write('User', $admin_arr['User']);
			$this->request->getSession()->write('is_admin', 1);					
			$this->redirect(rtrim(SITEURL, '/') . '/admin/users/dashboard');
		}	
	}

    function eoireport(){
		$this->autoRender = false;
		$UserPermission = $this->UserPermission->find()
			->where(['UserPermission.permssion_id' => 14])
			->contain(['NappUser' => ['fields' => ['id', 'name', 'lname', 'kpi']]])
			->all();
		$date = date('Y-m-d', strtotime(' -1 days'));
		$showdate = date('d F Y', strtotime('-1 days'));
		$report = [];
		foreach ($UserPermission as $up) {
			$napp = $up->napp_user;
			$name = $napp ? trim(($napp->name ?? '') . ' ' . ($napp->lname ?? '')) : '';
			$user_id = $napp ? $napp->id : null;
			$kpi = $napp ? ($napp->kpi ?? null) : null;
			$count = $this->EoiMailer->find()
				->where(['EoiMailer.user_id' => $user_id])
				->where(function ($exp, $q) use ($date) {
					return $exp->eq($q->func('DATE', ['EoiMailer.created']), $date);
				})
				->count();
			$report[] = ['name' => $name, 'total' => $count, 'kpi' => $kpi];
		}	
		
		$to = 'kal@durotechindustries.com.au';								
		$subject= SITENAME.":- EOI Report (".$showdate.")";				
		$template_name = 'eoi_report';										
		$variables = array('report'=>$report,'showdate'=>$showdate);	
		
		try{
			$this->sendemail($to,$subject,$template_name,$variables);
		}catch (Exception $e){
			
		}
		echo 'success';
	}	
}
