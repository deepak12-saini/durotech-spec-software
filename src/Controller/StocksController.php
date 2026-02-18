<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Stocks Controller (Stock Return, Warranty Request - CakePHP 3.10)
 */
class StocksController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('User');
        $this->loadModel('StockReturn');
        $this->loadModel('StockReturnData');
        $this->loadModel('NappUser');
        $this->loadModel('StockReturnComment');
        $this->loadModel('WarrantyRequests');
        $this->loadModel('WarrantyRequestLogs');
        $this->loadModel('UserPermission');
        $this->loadModel('ProductWarrantyRequests');
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        $result = parent::beforeFilter($event);
        if ($result instanceof Response) {
            return $result;
        }
        $this->callConstants();
        return null;
    }
	
	/** CamelCase alias for CakePHP 3 routing (FTIR status link) */
	public function adminStatus($status = null, $stcok_id = null, $type = null): ?Response
	{
		return $this->admin_status($status, $stcok_id, $type);
	}

	public function admin_status($status = null, $stcok_id = null, $type = null): ?Response
	{
		$result = $this->checkAdminSession();
		if ($result instanceof Response) {
			return $result;
		}
		$stcok_id = (int)$stcok_id;
		if ($stcok_id && $this->StockReturn->exists(['id' => $stcok_id])) {
			$row = $this->StockReturn->get($stcok_id);
			$row->qc_ftir = (int)$status;
			$this->StockReturn->save($row);
			$this->Flash->success('Status updated');
		}
		return $this->redirect(['action' => 'admin_index', $type ?: 'customer']);
	}

	
	function admin_addcomment($stock_id=null){
		
		$this->layout='admin_new_layout';
		$this->set('title_for_layout',SITENAME.' Admin Comments');		
		$this->checkAdminSession(); 
		
		$user_id = $this->Session->read('User.id');
		$username = $this->Session->read('User.name');
		
		if(!empty($this->request->data)){
			
			if(!empty($_FILES['documents']['name'])){
				$name = $_FILES['documents']['name'];
				$tempname = $_FILES['documents']['tmp_name'];
				$path  = WWW_ROOT.'sheetdoc/';
				$ext = pathinfo($name, PATHINFO_EXTENSION);
				$filename =  time().'_'.$name;										
				move_uploaded_file($tempname,$path.'/'.$filename);
				$insert['StockReturnComment']['documents'] = $filename;
			}	
			$insert['StockReturnComment']['comment'] = $this->request->data['comment'];			
			$insert['StockReturnComment']['stock_id'] = $stock_id;
			$insert['StockReturnComment']['admin_id'] =$user_id;
			$insert['StockReturnComment']['user_id'] = 0;
			$insert['StockReturnComment']['type'] =1; // employee
			$insert['StockReturnComment']['created'] = date('Y-m-d H:i:s');
			// echo '<pre>';
			// print_r($insert);
			// die();
			$this->StockReturnComment->save($insert);
		
			$this->StockReturn->bindModel(
				array('belongsTo' => array('NappUser' => array(
				'className' => 'NappUser',    
				'foreignKey' => 'user_id',    
				'conditions' => array(),
				'fields' => array('name','lname','email','id'),
				'order' => array(),
			))));
			$StockReturnkArr = $this->StockReturn->find('first',array('conditions'=>array('StockReturn.id'=>$stock_id)));
			$return_id = $StockReturnkArr['StockReturn']['return_id'];		
			$type = $StockReturnkArr['StockReturn']['type'];	
			$to_email = $StockReturnkArr['NappUser']['email'];	
			$fname = $StockReturnkArr['NappUser']['name'];	
			$lname = $StockReturnkArr['NappUser']['lname'];	
			if($this->request->data['is_send'] == 'Yes'){				
				$to_name = $fname.' '.$lname;						 					
				$subject = SITENAME.':- '.ucfirst($username).' has commented on stock return(#'.$return_id.')';						
				$template_name = 'stocktemp';	
				$userid = $StockReturnkArr['NappUser']['id'];
				$url = SITEURL.'stocks/index/'.$type.'/'.$userid.'/'.$return_id;									
				$variables = array('name'=>$username,'to_name'=>$to_name,'return_id'=>$return_id,'subject'=>$subject,'comment'=>$this->request->data['comment'],'url'=>$url);
									
				try{
					$this->sendemail($to_email,$subject,$template_name,$variables);
				}catch (Exception $e){
					
				}								
			}
		
			$this->Session->setFlash('Comment posted successfully','default',array('class' => 'alert alert-success'));
			$this->redirect('comment/'.$stock_id);	 
		}
		
		$this->set('stock_id',$stock_id);
	}
	function admin_comment($argu=null){
		
		$this->checkAdminSession(); 	
		$this->layout = 'admin_new_layout';
		
		$this->StockReturn->bindModel(
			array('belongsTo' => array('NappUser' => array(
			'className' => 'NappUser',    
			'foreignKey' => 'user_id',    
			'conditions' => array(),
			'fields' => array('name','lname'),
			'order' => array(),
		))));
				
		$StockReturnkArr = $this->StockReturn->find('first',array('conditions'=>array('StockReturn.id'=>$argu)));
		$this->set('StockReturnkArr',$StockReturnkArr);
		$this->set('argu',$argu);
		
		$this->StockReturnComment->bindModel(
			array('belongsTo' => array('NappUser' => array(
			'className' => 'NappUser',    
			'foreignKey' => 'user_id',    
			'conditions' => array(),
			'fields' => array('name','lname'),
			'order' => array(),
		))));
		$this->StockReturnComment->bindModel(
			array('belongsTo' => array('User' => array(
			'className' => 'User',    
			'foreignKey' => 'admin_id',    
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));
		$StockReturnComment = $this->StockReturnComment->find('all',array('conditions'=>array('StockReturnComment.stock_id'=>$StockReturnkArr['StockReturn']['id']),'order' => array('StockReturnComment.id'=>'DESC')));
		$this->set('clientArr',$StockReturnComment);
	}
	/** CamelCase alias for CakePHP 3 routing (sidebar Customer Return link) */
	public function adminIndex($type = null)
	{
		return $this->admin_index($type);
	}

	public function admin_index($type = null): ?Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Stock Return List');
		$result = $this->checkAdminSession();
		if ($result instanceof Response) {
			return $result;
		}
		$user_id = (int)($this->request->getSession()->read('User.id') ?? 0);

		if (isset($type) && $type !== '' && $type !== null) {
			$acctype = $type;
		} else {
			return $this->redirect(['action' => 'admin_index', 'customer']);
		}

		$query = $this->StockReturn->find()
			->contain([
				'NappUser' => function ($q) {
					return $q->select(['name', 'lname']);
				},
				'StockReturnData',
			])
			->where(['StockReturn.type' => $acctype])
			->orderDesc('StockReturn.id');
		$stockreturn = $this->paginate($query, ['limit' => 25]);

		$this->set(compact('stockreturn', 'acctype'));
		return null;
	}
	/** CamelCase alias for CakePHP 3 routing (Delete button) */
	public function adminDelete($id = null, $acctype = null): ?Response
	{
		return $this->admin_delete($id, $acctype);
	}

	public function admin_delete($id = null, $acctype = null): ?Response
	{
		$result = $this->checkAdminSession();
		if ($result instanceof Response) {
			return $result;
		}
		$acctype = $acctype ?: 'customer';
		$id = (int)$id;
		if (!$id) {
			$this->Flash->error('Invalid record.');
			return $this->redirect(['action' => 'admin_index', $acctype]);
		}
		if (!$this->StockReturn->exists(['id' => $id])) {
			$this->Flash->error('Sorry, you have no permission to delete this record.');
			return $this->redirect(['action' => 'admin_index', $acctype]);
		}
		$entity = $this->StockReturn->get($id);
		if ($this->StockReturn->delete($entity)) {
			$this->Flash->success('Stock return record is deleted successfully.');
		} else {
			$this->Flash->error('Could not delete record.');
		}
		return $this->redirect(['action' => 'admin_index', $acctype]);
	}
	function download($id){
		
		$this->autoRender = false ;

		$id = base64_decode(base64_decode($id));		
		
		$path = WWW_ROOT.'dompdf/'.$id;

		if (file_exists($path)) {
			header("Content-Disposition: attachment; filename=" . urlencode($path));  
			header('Content-Description: File Transfer');
			 header("Content-type: application/pdf");
			header('Content-Disposition: attachment; filename='.basename($path));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');	
			header('Content-Length: ' . filesize($path));
			ob_clean();
			flush();
			readfile($path);
			exit;
		}else{

		}	
	}
	public function status($status=null,$stcok_id=null,$type=null) {
		$this->checkSatffSession(); 
		$this->autoRender = false;
		
		$update['StockReturn']['id'] = $stcok_id; // employee
		$update['StockReturn']['qc_ftir'] = $status;
		$this->StockReturn->save($update);
		
		$this->Session->setFlash('Status updated','default',array('class' => 'alert alert-success'));
		$this->redirect('index/'.$type);	 
		
	}

	public function index($type=null){		
		
		$this->layout='staff_inner_layout';
		$this->set('title_for_layout',SITENAME.' Stock Return List');		
		$this->checkSatffSession(); 
		$customer_id=$this->Session->read('Customer.id');
		
		if(isset($type) && !empty($type)){
			$acctype= $type;
		}else{
			return $this->redirect(array('action' => 'index/customer'));			
		}	
		$this->StockReturn->bindModel(
		array('belongsTo' => array('NappUser' => array(
			'className' => 'NappUser',			 
			'foreignKey' => 'user_id',				
			'conditions' => array(),
			'fields' => array('name','lname'),
			'order' => array(),
		))));
		$this->StockReturn->bindModel(
		array('hasMany' => array('StockReturnData' => array(
			'className' => 'StockReturnData',			 
			'foreignKey' => 'stock_id',				
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));
		$this->StockReturn->recursive = 2;
		$stockreturn = $this->StockReturn->find('all',array('conditions'=>array('StockReturn.type'=>$acctype),'page' => 1, 'limit' => 25,'order'=>array('StockReturn.id'=>'desc')));
		//$this->paginate = array('conditions'=>array('StockReturn.type'=>$acctype,'StockReturn.user_id'=>$customer_id),'page' => 1, 'limit' => 25,'order'=>array('StockReturn.id'=>'desc'));
		//$stockreturn = $this->Paginator->paginate('StockReturn');
		// echo '<pre>';
		// print_r($stockreturn);
		// die();
		$this->set('stockreturn', $stockreturn);	
		$this->set('acctype', $acctype);	
	}
	public function create($acctype=null) {
		
		$this->layout='staff_inner_layout';
		$this->set('title_for_layout',SITENAME.' Create Coa Durotech');
		$this->checkSatffSession(); 
		$customer_id=$this->Session->read('Customer.id');
		if(empty($acctype)){
			return $this->redirect(array('action' => 'index'));
		}	
		if (!empty($this->request->data)) {
					
			$return_id = $this->request->data['return_id'];					
			$inserty['StockReturn']['return_id'] = $return_id;
			$inserty['StockReturn']['type'] = $acctype;
			$inserty['StockReturn']['user_id'] = $customer_id;	
			$inserty['StockReturn']['created'] = date('Y-m-d H:i:s');			
			if($this->StockReturn->save($inserty)){
				$lastinsertId = $this->StockReturn->id;
			
				foreach($this->request->data['date'] as $key=>$date){
					$insert['StockReturnData']['id'] = '';
					$insert['StockReturnData']['date'] = $date;
					$insert['StockReturnData']['stock_id'] = $lastinsertId;
					$insert['StockReturnData']['customer'] = $this->request->data['customer'][$key];		
					$insert['StockReturnData']['items'] = $this->request->data['items'][$key];		
					$insert['StockReturnData']['reason'] = $this->request->data['reason'][$key];		
					$insert['StockReturnData']['conditions'] = $this->request->data['conditions'][$key];		
					$insert['StockReturnData']['batch'] = $this->request->data['batch'][$key];				
					$insert['StockReturnData']['received'] = $this->request->data['received'][$key];				
					$this->StockReturnData->save($insert);
				}		
				// send email to customer	
				$this->sendemails($lastinsertId);				
				$this->Session->setFlash('Stock return added successfully.','default',array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index/'.$acctype));
			}
		}		
		
		$refrmon = array('01'=>'a','02'=>'b','03'=>'c','04'=>'d','05'=>'e','06'=>'f','07'=>'g','08'=>'h','09'=>'i','10'=>'j','11'=>'k','12'=>'l');
		$mailerid = $this->StockReturn->find('count',array('conditions'=>array('type'=>3),'order'=>array('StockReturn.id'=>'desc')));
			
		//$id= $mailerid['Mailer']['id'] + 1;
		$id= $mailerid + 1;
		
		$yr = date('y');
		$mm = date('m');
		if(strlen($id) == 1){
			$code = '00'.$id;
		}else if(strlen($id) == 2){
			$code = '0'.$id;
		}else{
			$code = $id;
		}			
		$refernce = 'DTSTR '.$yr.'-'.$mm.'-'.$code; 
		$this->set('refernce',$refernce);
		$this->set('acctype',$acctype);
	}
	public function edit($id=null,$acctype=null) {
		
		$this->layout='staff_inner_layout';
		$this->set('title_for_layout',SITENAME.' Create Coa Durotech');
		$this->checkSatffSession(); 
		$user_id=$this->Session->read('Customer.id');
		if(empty($acctype)){
			return $this->redirect(array('action' => 'index/'.$acctype));
		}	
		if(empty($id)){
			return $this->redirect(array('action' =>  'index/'.$acctype));
		}	
		$this->StockReturn->bindModel(
		array('hasMany' => array('StockReturnData' => array(
			'className' => 'StockReturnData',			 
			'foreignKey' => 'stock_id',				
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));
		$StockReturnArr = $this->StockReturn->find('first',array('conditions'=>array('id'=>$id)));			
		$this->set('StockReturnArr',$StockReturnArr);
		$this->set('acctype',$acctype);
		
		if (!empty($this->request->data)) {
									
			$inserty['StockReturn']['id'] = $id;	
			
			$inserty['StockReturn']['created'] = date('Y-m-d H:i:s');			
			if($this->StockReturn->save($inserty)){				
				$lastinsertId = $id;
				$this->StockReturnData->query('delete from stock_return_datas where stock_id='.$lastinsertId.'');
				foreach($this->request->data['date'] as $key=>$date){
					$insert['StockReturnData']['id'] = '';
					$insert['StockReturnData']['date'] = $date;
					$insert['StockReturnData']['stock_id'] = $lastinsertId;
					$insert['StockReturnData']['customer'] = $this->request->data['customer'][$key];		
					$insert['StockReturnData']['items'] = $this->request->data['items'][$key];		
					$insert['StockReturnData']['reason'] = $this->request->data['reason'][$key];		
					$insert['StockReturnData']['conditions'] = $this->request->data['conditions'][$key];		
					$insert['StockReturnData']['batch'] = $this->request->data['batch'][$key];				
					$insert['StockReturnData']['received'] = $this->request->data['received'][$key];				
					$this->StockReturnData->save($insert);
				}				
								
				$this->Session->setFlash('Stock return added successfully.','default',array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index/'.$acctype));
			}
		}
		
	}
	function delete($id=null,$acctype=null){
		$this->autoRender = false;		
		$this->checkSatffSession(); 
		if(empty($acctype)){
			return $this->redirect(array('action' =>  'index/'.$acctype));
		}	
		if(empty($id)){
			return $this->redirect(array('action' =>  'index/'.$acctype));
		}	
		$user_id=$this->Session->read('Customer.id');
		$StockReturnArr = $this->StockReturn->find('first',array('conditions'=>array('id'=>$id,'user_id'=>$user_id)));			
		if(empty($StockReturnArr)){
			$this->Session->setFlash('Sorry, you have no permission to delete this record..','default',array('class' => 'alert alert-success'));
			return $this->redirect(array('action' =>  'index/'.$acctype));
		}
		
		if($this->StockReturn->delete($id)){
			$this->Session->setFlash('Stock return record is deleted successfully.','default',array('class' => 'alert alert-success'));
			return $this->redirect(array('action' => 'index/'.$acctype));
		}	
	}
	function admin_autologin($userid=null,$type=null,$id=null){
		$this->autoRender = false;
			
		//$id = base64_decode($id);	
		if(!empty($userid)){
			$userArr  = $this->User->find('first',array('conditions'=>array('User.id'=>base64_decode($userid))));
		}else{
			$userArr  = $this->User->find('first',array('conditions'=>array('User.id'=>2)));
		}		
			
		if(!empty($userArr)){				
			$this->Session->write('User', $userArr['User']);
			$this->Session->write('is_admin', 1);			
			$this->redirect('/admin/stocks/index/'.$type);
		}		
		
	}	
	public function sendemails($id=null) {
	
		$this->StockReturn->bindModel(
		array('hasMany' => array('StockReturnData' => array(
			'className' => 'StockReturnData',			 
			'foreignKey' => 'stock_id',				
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));
		$StockReturnArr = $this->StockReturn->find('first',array('conditions'=>array('id'=>$id)));			
		if(!empty($StockReturnArr)){				
			$returnId= $StockReturnArr['StockReturn']['return_id'];
			$type= ucfirst($StockReturnArr['StockReturn']['type']);
			$email = 'kal@durotechindustries.com.au';
		
			$to_name = 'Kal';
			$userid = 2;
			$url = SITEURL.'admin/stocks/autologin/'.base64_encode($userid).'/'.$type.'/'.base64_encode($id);
			$subject = SITENAME.' :- Stock Retrun #'.$returnId.' ('.$type.')';				
			$variables = array('url'=>$url,'to_name'=>$to_name,'returnId'=>$returnId,'type'=>$type,'StockReturnData'=>$StockReturnArr['StockReturnData']);			
			if(!empty($email)){
				$template_name = 'stock_return_temp';				
				try{
					$temp = $this->sendemail($email,$subject,$template_name,$variables);
				}catch (Exception $e){
					
				}
			}
			$userids = 3;
			$urlv = SITEURL.'admin/stocks/autologin/'.base64_encode($userids).'/'.$type.'/'.base64_encode($id);
			$email_1 = 'varan@durotechindustries.com.au';
			$to_name_1 = 'Varan';					
			$variables_1 = array('url'=>$urlv,'to_name'=>$to_name_1,'returnId'=>$returnId,'type'=>$type,'StockReturnData'=>$StockReturnArr['StockReturnData']);			
			if(!empty($email_1)){
				$template_name = 'stock_return_temp';				
				try{
					$temp = $this->sendemail($email_1,$subject,$template_name,$variables_1);
				}catch (Exception $e){
					
				}
			}	
		}
		return true;	
	}	
	
	function comment($argu=null){
		
		$this->checkSatffSession(); 	
		$this->layout = 'admin_new_layout';
		
		$this->StockReturn->bindModel(
			array('belongsTo' => array('NappUser' => array(
			'className' => 'NappUser',    
			'foreignKey' => 'user_id',    
			'conditions' => array(),
			'fields' => array('name','lname'),
			'order' => array(),
		))));
				
		$StockReturnkArr = $this->StockReturn->find('first',array('conditions'=>array('StockReturn.id'=>$argu)));
		$this->set('StockReturnkArr',$StockReturnkArr);
		$this->set('argu',$argu);
		
		$this->StockReturnComment->bindModel(
			array('belongsTo' => array('NappUser' => array(
			'className' => 'NappUser',    
			'foreignKey' => 'user_id',    
			'conditions' => array(),
			'fields' => array('name','lname'),
			'order' => array(),
		))));
		$this->StockReturnComment->bindModel(
			array('belongsTo' => array('User' => array(
			'className' => 'User',    
			'foreignKey' => 'admin_id',    
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));
		$StockReturnComment = $this->StockReturnComment->find('all',array('conditions'=>array('StockReturnComment.stock_id'=>$StockReturnkArr['StockReturn']['id']),'order' => array('StockReturnComment.id'=>'DESC')));
		$this->set('clientArr',$StockReturnComment);
	}		
	function addcomment($stock_id=null){
		
		$this->layout='admin_new_layout';
		$this->set('title_for_layout',SITENAME.' Admin Comments');		
		$this->checkSatffSession(); 
		$user_id = $this->Session->read('Customer.id');
		$fname = $this->Session->read('Customer.name');
		$lname = $this->Session->read('Customer.lname');
		$email = $this->Session->read('Customer.email');
		
		if(!empty($this->request->data)){
			
			if(!empty($_FILES['documents']['name'])){
				$name = $_FILES['documents']['name'];
				$tempname = $_FILES['documents']['tmp_name'];
				$path  = WWW_ROOT.'sheetdoc/';
				$ext = pathinfo($name, PATHINFO_EXTENSION);
				$filename =  time().'_'.$name;										
				move_uploaded_file($tempname,$path.'/'.$filename);
				$insert['StockReturnComment']['documents'] = $filename;
			}	
			$insert['StockReturnComment']['comment'] = $this->request->data['comment'];			
			$insert['StockReturnComment']['stock_id'] = $stock_id;
			$insert['StockReturnComment']['admin_id'] =0;
			$insert['StockReturnComment']['user_id'] = $user_id;
			$insert['StockReturnComment']['type'] =0; // employee
			$insert['StockReturnComment']['created'] = date('Y-m-d H:i:s');
			// echo '<pre>';
			// print_r($insert);
			// die();
			$this->StockReturnComment->save($insert);
			
			$StockReturnkArr = $this->StockReturn->find('first',array('conditions'=>array('StockReturn.id'=>$stock_id)));
			$return_id = $StockReturnkArr['StockReturn']['return_id'];		
			$type = $StockReturnkArr['StockReturn']['type'];		
			if($this->request->data['is_send'] == 'Yes'){				
				$username = $fname.' '.$lname;						 					
				$subject = SITENAME.':- '.ucfirst($username).' has commented on stock return(#'.$return_id.')';						
				$template_name = 'stocktemp';					
				$userArr = $this->User->find('all',array('conditions'=>array('User.is_receive_smartsheet'=>1)));
				if(!empty($userArr)){
					foreach($userArr as $userArrs){
						$userid = $userArrs['User']['id'];
						$url = SITEURL.'admin/stocks/index/'.$type.'/'.$userid.'/'.$return_id;		
						$to_name = $userArrs['User']['name'];
						$to_email = $userArrs['User']['email'];							
						$variables = array('name'=>$username,'to_name'=>$to_name,'return_id'=>$return_id,'subject'=>$subject,'comment'=>$this->request->data['comment'],'url'=>$url);
												
						try{
							$this->sendemail($to_email,$subject,$template_name,$variables);
						}catch (Exception $e){
							
						}
							
					}
				}				
			}
		
			$this->Session->setFlash('Comment posted successfully','default',array('class' => 'alert alert-success'));
			$this->redirect('comment/'.$stock_id);	 
		}
		
		$this->set('stock_id',$stock_id);
	}
	
	/** CamelCase alias for routing */
	public function adminWarrantRequest($type = null): ?Response
	{
		return $this->admin_warrant_request($type);
	}

	public function admin_warrant_request($type = null): ?Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Warranty Request List');
		$this->checkAdminSession();

		$results = $this->WarrantyRequests->find()
			->contain(['WarrantyRequestLogs'])
			->orderDesc('WarrantyRequests.id')
			->limit(25)
			->all();

		// Convert entities to array format for backward compatibility with view
		$WarrantyRequest = [];
		foreach ($results as $row) {
			$logs = $row->warranty_request_logs ?? $row->warrantyRequestLogs ?? [];
			$logsArray = [];
			foreach ($logs as $log) {
				$logsArray[] = is_object($log) ? $log->toArray() : $log;
			}
			$rowArray = $row->toArray();
			unset($rowArray['warranty_request_logs'], $rowArray['warrantyRequestLogs']);
			$WarrantyRequest[] = [
				'WarrantyRequest' => $rowArray,
				'WarrantyRequestLog' => $logsArray,
			];
		}
		$this->set('WarrantyRequest', $WarrantyRequest);
		return null;
	}


	/** CamelCase alias for routing */
	public function adminProductWarrantyRequest(): ?Response
	{
		return $this->admin_product_warranty_request();
	}

	public function admin_product_warranty_request(): ?Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' | Product Warranty Request List');

		$results = $this->ProductWarrantyRequests->find()
			->orderDesc('ProductWarrantyRequests.id')
			->all();

		// Convert to array format expected by view
		$productWarrantyRequests = [];
		foreach ($results as $entity) {
			$productWarrantyRequests[] = ['ProductWarrantyRequest' => $entity->toArray()];
		}
		$this->set('productWarrantyRequests', $productWarrantyRequests);
		return null;
	}


	public function admin_delete_product_warranty($id = null): ?Response
	{
		$this->autoRender = false;

		if (!$id) {
			$this->Flash->error('Invalid request ID.');
			return $this->redirect($this->referer());
		}

		$exists = $this->ProductWarrantyRequests->exists(['id' => $id]);
		if (!$exists) {
			$this->Flash->error('Request not found.');
			return $this->redirect($this->referer());
		}

		$entity = $this->ProductWarrantyRequests->get($id);
		if ($this->ProductWarrantyRequests->delete($entity)) {
			$this->Flash->success('Warranty request deleted successfully.');
		} else {
			$this->Flash->error('Failed to delete warranty request.');
		}

		return $this->redirect($this->referer());
	}

	/**
	 * Approve product warranty request (AJAX POST). Alias for URL compatibility.
	 */
	public function admin_approve_warranty(): ?Response
	{
		$this->request->allowMethod(['post']);
		$this->autoRender = false;

		$id = (int) $this->request->getData('id');
		if (!$id) {
			$this->response = $this->response->withStringBody('error');
			return $this->response;
		}
		try {
			$entity = $this->ProductWarrantyRequests->get($id);
		} catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
			$this->response = $this->response->withStringBody('error');
			return $this->response;
		}
		$entity->status = 'Approved';
		if ($this->ProductWarrantyRequests->save($entity)) {
			$_REQUEST['lastinsertId'] = $id;
			$certPath = WWW_ROOT . 'pdf' . DS . 'FPDI' . DS . 'warrantyCertificate_new.php';
			if (file_exists($certPath)) {
				include $certPath;
			}
			$this->response = $this->response->withStringBody('success');
			return $this->response;
		}
		$this->response = $this->response->withStringBody('error');
		return $this->response;
	}

	/**
	 * CamelCase alias so dispatcher finds the action (CakePHP may resolve to adminApproveWarranty).
	 */
	public function adminApproveWarranty(): ?Response
	{
		return $this->admin_approve_warranty();
	}
	
	public function warrant_request($type=null){		
		
		$this->layout='staff_inner_layout';
		$this->set('title_for_layout',SITENAME.' Warranty Request List');		
		$this->checkSatffSession(); 
		$customer_id=$this->Session->read('Customer.id');
		$this->WarrantyRequests->bindModel(
			array('hasMany' => array('WarrantyRequestLog' => array(
			'className' => 'WarrantyRequestLog',    
			'foreignKey' => 'warranty_request_id',    
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));	
		$WarrantyRequest = $this->WarrantyRequests->find('all',array('page' => 1, 'limit' => 25,'order'=>array('WarrantyRequest.id'=>'desc')));
		// echo '<pre>';
		// print_r($WarrantyRequest);
		// die();
		$this->set('WarrantyRequest', $WarrantyRequest);			
	}
	
	function warranty($id=null){
		
		$this->layout='warranty_layout';
		$this->set('title_for_layout',SITENAME.' | Warranty Info Page');	
		$uniqueId = base64_decode(base64_decode(base64_decode($id)));
		$this->set('uniqueId', $uniqueId);
		
		$WarrantyRequest = $this->WarrantyRequests->find('first',array('conditions'=>array('id' => $uniqueId)));
		if(empty($WarrantyRequest)){
			$this->redirect('/');	
		}	
		$this->set('WarrantyRequest', $WarrantyRequest);
		
		$WarrantyRequestLog = $this->WarrantyRequestLogs->find('first',array('conditions'=>array('WarrantyRequestLog.warranty_request_id'=>$uniqueId)));
		$this->set('WarrantyRequestLog', $WarrantyRequestLog);
		
		$flag = 0;
		if(!empty($this->request->data)){
			
			$application = '';
			if(!empty($this->request->data)){
				$application = implode(',',$this->request->data['application']);
			}	
			
			if(!empty($WarrantyRequestLog)){
				$insert['WarrantyRequestLog']['id'] = $WarrantyRequestLog['WarrantyRequestLog']['id'];
			}	
			$insert['WarrantyRequestLog']['warranty_request_id'] = $uniqueId;
			$insert['WarrantyRequestLog']['application'] = $application;
			$insert['WarrantyRequestLog']['serialnumber'] = $this->request->data['serialnumber'];
			$insert['WarrantyRequestLog']['dateofpurchase'] = date('Y-m-d',strtotime($this->request->data['dateofpurchase']));
			$insert['WarrantyRequestLog']['product'] = $this->request->data['product'];
			$insert['WarrantyRequestLog']['used_as'] = $this->request->data['used_as'];
			$insert['WarrantyRequestLog']['area_warranted'] = $this->request->data['area_warranted'];
			$insert['WarrantyRequestLog']['building_address'] = $this->request->data['building_address'];
			$insert['WarrantyRequestLog']['building_name'] = $this->request->data['building_name'];
			$insert['WarrantyRequestLog']['contract_company_name'] = $this->request->data['contract_company_name'];
			$insert['WarrantyRequestLog']['start_requested_warranty'] = date('Y-m-d',strtotime($this->request->data['start_requested_warranty']));
			$insert['WarrantyRequestLog']['end_requested_warranty'] = date('Y-m-d',strtotime($this->request->data['end_requested_warranty']));
			$insert['WarrantyRequestLog']['sign_date'] = date('Y-m-d',strtotime($this->request->data['sign_date']));
			$insert['WarrantyRequestLog']['contract_name'] = $this->request->data['contract_name'];
			$insert['WarrantyRequestLog']['building_area_name'] = $this->request->data['building_area_name'];
			$insert['WarrantyRequestLog']['applicator_active_abn'] = $this->request->data['applicator_active_abn'];
			$insert['WarrantyRequestLog']['applicator_address'] = $this->request->data['applicator_address'];
			$insert['WarrantyRequestLog']['applicator_contact'] = $this->request->data['applicator_contact'];
			$insert['WarrantyRequestLog']['applicator'] = $this->request->data['applicator'];
			
			$this->UserPermission->bindModel(
				array('belongsTo' => array('NappUser' => array(
				'className' => 'NappUser',    
				'foreignKey' => 'user_id',    
				'conditions' => array(),
				'fields' => array('id','name','lname','email'),
				'order' => array(),
			))));
					
			if($this->WarrantyRequestLogs->save($insert)){
				
				$url = SITEURL.'pdf/FPDI/warrantyCertificate.php?lastinsertId='.$uniqueId;			
				$result = file_get_contents($url);
				
				$update['WarrantyRequest']['id'] = $uniqueId;
				$update['WarrantyRequest']['status'] = 2;
				$this->WarrantyRequests->save($update);
				
				$unique_id = $WarrantyRequest['WarrantyRequest']['unique_id'];
				$name = $WarrantyRequest['WarrantyRequest']['name'];
				$email = $WarrantyRequest['WarrantyRequest']['email'];
				$phone = $WarrantyRequest['WarrantyRequest']['phone'];
				$project_name = $WarrantyRequest['WarrantyRequest']['project_name'];
				
				
				$subject = 'Durotech: Filled Warranty Form (#'.$unique_id.')';	
				$template_name = 'notification_to_admin';	
				
				$StockReturnkArr = $this->UserPermission->find('all',array('conditions'=>array('UserPermission.meta_val'=>'Warrant Request')));
				if(!empty($StockReturnkArr)){
					foreach($StockReturnkArr as $StockReturnkArrs){
						$to_name = $StockReturnkArrs['NappUser']['name'];
						$email = $StockReturnkArrs['NappUser']['email'];
						
						
						$url = SITEURL.'stocks/autologin/'.$id.'/'.$StockReturnkArrs['NappUser']['id'];								
						$variables = array('unique_id'=>$unique_id,'name'=>$name,'url'=>$url,'project_name'=>$project_name,'WarrantyRequestLog'=>$insert['WarrantyRequestLog'],'to_name'=>$to_name,'email'=>$email);			
						
						try{
							$this->sendemail($email,$subject,$template_name,$variables);
						}catch (Exception $e){
							
						}
					}
				}				
				
				$this->Session->setFlash('Thanks, we will contact you shortly.','default',array('class' => 'alert alert-success'));
				//$flag = 1;
				$this->redirect('/warranty/'.$id);	 
			}						
		}	
		$this->set('flag',$flag);
	}	
	
	function change_status($id){
		$this->autoRender = false;
		
		$update['WarrantyRequest']['id'] = $id;
		$update['WarrantyRequest']['status'] = 3;
		$this->WarrantyRequests->save($update);
		$this->Session->setFlash('This request has been completed.','default',array('class' => 'alert alert-success'));
		$this->redirect('warrant_request');	
		
	}
	
	public function autologin($id=null,$user_id=null) {
		$this->autoRender = false;
		
		//$this->checkSatffSession(); 
		//$customer_id=$this->Session->read('Customer.id');
		$uniqueId = base64_decode(base64_decode(base64_decode($id)));
		$WarrantyRequest = $this->WarrantyRequests->find('first',array('conditions'=>array('id' => $uniqueId)));
		
		if(empty($WarrantyRequest)){
			$this->redirect('/');	
		}			
		$cus_arr = $this->NappUser->find('first',array('conditions'=>array('NappUser.id'=>$user_id)));
		
		if(empty($cus_arr)){
			$this->redirect('/');	
		}else if($cus_arr['NappUser']['is_staff_id'] == 1){
			$this->Session->write('Customer', $cus_arr['NappUser']);
			$this->Session->write('is_staff', 1);	
			$this->redirect('warrant_request');	
		}else{
			$this->redirect('/');	
		}	
	}

	function sendformtocsutomer($id = null): ?Response
	{
		$this->request->allowMethod(['get']);
		$this->autoRender = false;
		$this->checkSatffSession();
		$uniqueId = $id ? (int)base64_decode(base64_decode(base64_decode($id))) : null;
		if (!$uniqueId) {
			return $this->redirect('/');
		}
		$wr = $this->WarrantyRequests->get($uniqueId);
		if (!$wr) {
			return $this->redirect('/');
		}
		$email = $wr->email ?? '';
		$unique_id = $wr->unique_id ?? '';
		$name = $wr->name ?? '';
		if (!empty($email)) {
			$url = (defined('SITEURL') ? SITEURL : '') . 'warranty/' . $id;
			$variables = ['name' => $name, 'email' => $email, 'url' => $url, 'unique_id' => $unique_id];
			$subject = 'Durotech: Warranty Request Form';
			$template_name = 'sendformrequest';
			try {
				$this->sendemail($email, $subject, $template_name, $variables);
			} catch (\Throwable $e) {
			}
			$wr->status = 1;
			$this->WarrantyRequests->save($wr);
		}
		$this->Flash->success('Form sent to customer successfully.');
		return $this->redirect(['action' => 'warrant_request']);
	}

	/** Admin: send warranty form to customer, then redirect to admin list */
	/** CamelCase alias for routing /admin/stocks/sendformtocsutomer/:id */
	public function adminSendformtocsutomer($id = null): ?Response
	{
		return $this->admin_sendformtocsutomer($id);
	}

	public function admin_sendformtocsutomer($id = null): ?Response
	{
		$this->request->allowMethod(['get']);
		$this->autoRender = false;
		$this->checkAdminSession();
		$uniqueId = $id ? (int)base64_decode(base64_decode(base64_decode($id))) : null;
		if (!$uniqueId) {
			$this->Flash->error('Invalid request.');
			return $this->redirect(['action' => 'admin_warrant_request']);
		}
		$wr = $this->WarrantyRequests->get($uniqueId);
		if (!$wr) {
			$this->Flash->error('Request not found.');
			return $this->redirect(['action' => 'admin_warrant_request']);
		}
		$email = $wr->email ?? '';
		$unique_id = $wr->unique_id ?? '';
		$name = $wr->name ?? '';
		if (!empty($email)) {
			$url = (defined('SITEURL') ? SITEURL : '') . 'warranty/' . $id;
			$variables = ['name' => $name, 'email' => $email, 'url' => $url, 'unique_id' => $unique_id];
			$subject = 'Durotech: Warranty Request Form';
			$template_name = 'sendformrequest';
			try {
				$this->sendemail($email, $subject, $template_name, $variables);
			} catch (\Throwable $e) {
			}
			$wr->status = 1;
			$this->WarrantyRequests->save($wr);
		}
		$this->Flash->success('Form sent to customer successfully.');
		return $this->redirect(['action' => 'admin_warrant_request']);
	}
}
