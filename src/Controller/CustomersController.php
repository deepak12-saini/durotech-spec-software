<?php 
App::uses('AppController','Controller');
class CustomersController extends AppController{
	public $helpers = array('Html','Form','Session');
	public $components = array('Session','Paginator');	
	public $uses = array('Category','Product','Subscriber','Customer');
	/***
	/*Author  :Paramjit,
	/*Comment : Check before user is login or not
	****/
	function beforeFilter()
    {
		$this->callConstants();
		$this->getCategories();
	}
	

	/***
	/*Author  :Ranjit,
	/*Comment :Home Page
	****/
	public function index(){
		$this->layout='front_layout';
		$this->set('title_for_layout',SITENAME.' Home');	
		$categories = $this->Category->find('all',array('conditions'=>array('Category.status'=>1),'order'=>'Category.category_name asc'));	
		$this->set('categories',$categories);
		$product = $this->Product->find('all',array('conditions'=>array('Product.is_featured'=>1)));
		$this->set('products',$product);			
	}
	
		/***
	/*Author  :Ranjit,
	/*Comment :Home Page
	****/
	public function profile(){
		$this->layout='front_layout';
		$this->set('title_for_layout',SITENAME.' Home');	
		$this->checkCustomerSession();
		$customer_id=$this->Session->read('customer.id');
		$Customer = $this->Customer->find('first',array('conditions'=>array('Customer.id'=>$customer_id)));	
		$this->set('Customer',$Customer);
		if(!empty($this->request->data)){
			$this->request->data['Customer']['id']=$customer_id;
			if($this->Customer->save($this->request->data))
			{
				$this->Session->setFlash('Profile information updated successfully.','default',array('class' => 'alert alert-success'));
				$this->redirect('profile');
			}else{
				$this->Session->setFlash('Error occured,please try again!.','default',array('class' => 'alert alert-danger'));
			}
			
		}
		
		/* $product = $this->Product->find('all',array('conditions'=>array('Product.is_featured'=>1)));
		$this->set('products',$product);	 */		
	}
	
	function logout(){
		
		$this->autoRender = false;		
		$this->checkCustomerSession();
		$this->Session->delete('customer');
		$this->Session->delete('is_customer');
		$this->redirect('/login');
	}

function forgot_password()
	{
		$this->layout='front_layout';
		$this->set('title_for_layout',SITENAME.' Forgot Password Page');	
		if($this->request->is('post')){
			$Customer = $this->Customer->find('first',array('conditions'=>array('Customer.email'=>$this->request->data['Customer']['email'])));
			if(!empty($Customer)){
				$password = $this->random_password(6);
				$data['Customer']['id'] = $Customer['Customer']['id'];
				$data['Customer']['password'] = $password;							
				$this->Customer->save($data);
				
				$to=$Customer['Customer']['email'];
				$name=$Customer['Customer']['fname'];
				
				$subject = SITENAME.' Forgot Password';	
				$template_name='message';
				$top_content = 'Your password has been reset.Here is your login account detail';
				$variables=array('password'=>$password,'top_content'=>$top_content,'name'=>$name,'email'=>$to,'type'=>'signup');
				$this->sendemail($to,$subject,$template_name,$variables);
				$this->Session->setFlash('The mail has been sent for password.','default',array('class' => 'alert alert-success'));
				$this->redirect('/login');
			}else{
				$this->Session->setFlash('Email not found.','default',array('class' => 'alert alert-danger'));
			}
		}
	}	
	
}

?>
	
	