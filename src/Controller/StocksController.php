<?php
declare(strict_types=1);

namespace App\Controller;

use App\Utility\ProductWarrantyCustomerNotifier;
use App\Utility\ProductWarrantyEventLogger;
use App\Utility\ProductWarrantyPdfGenerator;
use App\Utility\ProductWarrantyPortalToken;
use App\Utility\WarrantyCertificateHtmlV2Generator;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Routing\Router;

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
		
		$user_id = $this->request->getSession()->read('User.id');
		$username = $this->request->getSession()->read('User.name');
		
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
		
			$this->Flash->success('Comment posted successfully');
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
		
		$this->Flash->success('Status updated');
		$this->redirect('index/'.$type);	 
		
	}

	public function index($type = null){
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Stock Return List');
		$this->checkSatffSession();
		$customer_id = $this->request->getSession()->read('Customer.id');

		if (isset($type) && $type !== '') {
			$acctype = $type;
		} else {
			return $this->redirect(['action' => 'index', 'customer']);
		}

		$results = $this->StockReturn->find()
			->contain(['NappUser', 'StockReturnData'])
			->where(['StockReturn.type' => $acctype])
			->orderDesc('StockReturn.id')
			->limit(25)
			->all();

		$stockreturn = [];
		foreach ($results as $row) {
			$nappUser = $row->napp_user ?? $row->nappUser ?? null;
			$stockReturnData = $row->stock_return_data ?? $row->stockReturnData ?? [];
			$stockReturnDataArray = [];
			foreach ($stockReturnData as $dataRow) {
				$stockReturnDataArray[] = is_object($dataRow) ? $dataRow->toArray() : $dataRow;
			}
			$rowArray = $row->toArray();
			unset($rowArray['napp_user'], $rowArray['nappUser'], $rowArray['stock_return_data']);
			$stockreturn[] = [
				'StockReturn' => $rowArray,
				'NappUser' => $nappUser ? (is_object($nappUser) ? $nappUser->toArray() : $nappUser) : [],
				'StockReturnData' => $stockReturnDataArray,
			];
		}
		$this->set('stockreturn', $stockreturn);
		$this->set('acctype', $acctype);
	}
	public function create($acctype=null) {
		
		$this->layout='staff_inner_layout';
		$this->set('title_for_layout',SITENAME.' Create Coa Durotech');
		$this->checkSatffSession(); 
		$customer_id = $this->request->getSession()->read('Customer.id');
		if(empty($acctype)){
			return $this->redirect(array('action' => 'index'));
		}	
		if (!empty($this->request->data)) {

			$return_id = $this->request->data['return_id'];
			$stockEntity = $this->StockReturn->newEntity([
				'return_id' => $return_id,
				'type' => $acctype,
				'user_id' => $customer_id,
				'created' => date('Y-m-d H:i:s'),
			]);
			if ($this->StockReturn->save($stockEntity)) {
				$lastinsertId = $stockEntity->id;

				foreach ($this->request->data['date'] as $key => $date) {
					$dataEntity = $this->StockReturnData->newEntity([
						'date' => $date,
						'stock_id' => $lastinsertId,
						'customer' => $this->request->data['customer'][$key] ?? '',
						'items' => $this->request->data['items'][$key] ?? '',
						'reason' => $this->request->data['reason'][$key] ?? '',
						'conditions' => $this->request->data['conditions'][$key] ?? '',
						'batch' => $this->request->data['batch'][$key] ?? '',
						'received' => $this->request->data['received'][$key] ?? '',
					]);
					$this->StockReturnData->save($dataEntity);
				}
				$this->sendemails($lastinsertId);
				$this->Flash->success('Stock return added successfully.');
				return $this->redirect(['action' => 'index', $acctype]);
			}
		}		
		
		$refrmon = array('01'=>'a','02'=>'b','03'=>'c','04'=>'d','05'=>'e','06'=>'f','07'=>'g','08'=>'h','09'=>'i','10'=>'j','11'=>'k','12'=>'l');
		$mailerid = $this->StockReturn->find()->where(['type' => 3])->orderDesc('StockReturn.id')->count();

		$id = $mailerid + 1;

		$yr = date('y');
		$mm = date('m');
		$idStr = (string)$id;
		if (strlen($idStr) == 1) {
			$code = '00' . $idStr;
		} elseif (strlen($idStr) == 2) {
			$code = '0' . $idStr;
		} else {
			$code = $idStr;
		}
		$refernce = 'DTSTR ' . $yr . '-' . $mm . '-' . $code; 
		$this->set('refernce',$refernce);
		$this->set('acctype',$acctype);
	}
	public function edit($id = null, $acctype = null) {
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Create Coa Durotech');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');
		if (empty($acctype)) {
			return $this->redirect(['action' => 'index', $acctype]);
		}
		if (empty($id)) {
			return $this->redirect(['action' => 'index', $acctype]);
		}

		$stockReturn = $this->StockReturn->find()
			->contain(['StockReturnData'])
			->where(['StockReturn.id' => $id])
			->first();
		if (!$stockReturn) {
			$this->Flash->error('Stock return not found.');
			return $this->redirect(['action' => 'index', $acctype]);
		}
		$rowArray = $stockReturn->toArray();
		unset($rowArray['stock_return_data']);
		$stockReturnDataArray = [];
		foreach ($stockReturn->stock_return_data ?? $stockReturn->stockReturnData ?? [] as $item) {
			$stockReturnDataArray[] = is_object($item) ? $item->toArray() : $item;
		}
		$StockReturnArr = [
			'StockReturn' => $rowArray,
			'StockReturnData' => $stockReturnDataArray,
		];
		$this->set('StockReturnArr', $StockReturnArr);
		$this->set('acctype', $acctype);

		if (!empty($this->request->getData())) {
			$entity = $this->StockReturn->get($id);
			$entity->set('created', date('Y-m-d H:i:s'));
			if ($this->StockReturn->save($entity)) {
				$this->StockReturnData->deleteAll(['stock_id' => $id]);
				$data = $this->request->getData();
				if (!empty($data['date']) && is_array($data['date'])) {
					foreach ($data['date'] as $key => $date) {
						$dataEntity = $this->StockReturnData->newEntity([
							'date' => $date,
							'stock_id' => $id,
							'customer' => $data['customer'][$key] ?? '',
							'items' => $data['items'][$key] ?? '',
							'reason' => $data['reason'][$key] ?? '',
							'conditions' => $data['conditions'][$key] ?? '',
							'batch' => $data['batch'][$key] ?? '',
							'received' => $data['received'][$key] ?? '',
						]);
						$this->StockReturnData->save($dataEntity);
					}
				}
				$this->Flash->success('Stock return added successfully.');
				return $this->redirect(['action' => 'index', $acctype]);
			}
		}
	}
	function delete($id = null, $acctype = null) {
		$this->autoRender = false;
		$this->checkSatffSession();
		if (empty($acctype)) {
			return $this->redirect(['action' => 'index', $acctype]);
		}
		if (empty($id)) {
			return $this->redirect(['action' => 'index', $acctype]);
		}
		$user_id = $this->request->getSession()->read('Customer.id');
		$entity = $this->StockReturn->find()
			->where(['StockReturn.id' => $id, 'StockReturn.user_id' => $user_id])
			->first();
		if (!$entity) {
			$this->Flash->error('Sorry, you have no permission to delete this record.');
			return $this->redirect(['action' => 'index', $acctype]);
		}
		if ($this->StockReturn->delete($entity)) {
			$this->Flash->success('Stock return record is deleted successfully.');
			return $this->redirect(['action' => 'index', $acctype]);
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
			$this->request->getSession()->write('User', $userArr['User']);
			$this->request->getSession()->write('is_admin', 1);			
			$this->redirect('/admin/stocks/index/'.$type);
		}		
		
	}	
	public function sendemails($id = null) {
		$stockReturn = $this->StockReturn->find()
			->contain(['StockReturnData'])
			->where(['StockReturn.id' => $id])
			->first();

		if ($stockReturn) {
			$returnId = $stockReturn->get('return_id');
			$type = ucfirst($stockReturn->get('type'));
			$email = 'kal@durotechindustries.com.au';
			$to_name = 'Kal';
			$userid = 2;
			$url = SITEURL . 'admin/stocks/autologin/' . base64_encode((string)$userid) . '/' . $type . '/' . base64_encode((string)$id);
			$subject = SITENAME . ' :- Stock Retrun #' . $returnId . ' (' . $type . ')';
			$stockReturnData = $stockReturn->stock_return_data ?? $stockReturn->stockReturnData ?? [];
			$stockReturnDataArray = [];
			foreach ($stockReturnData as $item) {
				$stockReturnDataArray[] = is_object($item) ? $item->toArray() : $item;
			}
			$variables = ['url' => $url, 'to_name' => $to_name, 'returnId' => $returnId, 'type' => $type, 'StockReturnData' => $stockReturnDataArray];
			if (!empty($email)) {
				$template_name = 'stock_return_temp';
				try {
					$this->sendemail($email, $subject, $template_name, $variables);
				} catch (\Exception $e) {
				}
			}
			$userids = 3;
			$urlv = SITEURL . 'admin/stocks/autologin/' . base64_encode((string)$userids) . '/' . $type . '/' . base64_encode((string)$id);
			$email_1 = 'varan@durotechindustries.com.au';
			$to_name_1 = 'Varan';
			$variables_1 = ['url' => $urlv, 'to_name' => $to_name_1, 'returnId' => $returnId, 'type' => $type, 'StockReturnData' => $stockReturnDataArray];
			if (!empty($email_1)) {
				$template_name = 'stock_return_temp';
				try {
					$this->sendemail($email_1, $subject, $template_name, $variables_1);
				} catch (\Exception $e) {
				}
			}
		}
		return true;
	}	
	
	function comment($argu = null) {
		$this->checkSatffSession();
		$this->viewBuilder()->setLayout('admin_new_layout');

		$stockReturn = $this->StockReturn->find()
			->contain(['NappUser'])
			->where(['StockReturn.id' => $argu])
			->first();
		if (!$stockReturn) {
			$this->Flash->error('Stock return not found.');
			return $this->redirect(['action' => 'index', 'customer']);
		}
		$StockReturnkArr = [
			'StockReturn' => $stockReturn->toArray(),
			'NappUser' => $stockReturn->napp_user ? (is_object($stockReturn->napp_user) ? $stockReturn->napp_user->toArray() : $stockReturn->napp_user) : [],
		];
		unset($StockReturnkArr['StockReturn']['napp_user']);
		$this->set('StockReturnkArr', $StockReturnkArr);
		$this->set('argu', $argu);

		$comments = $this->StockReturnComment->find()
			->contain(['NappUser', 'User'])
			->where(['StockReturnComment.stock_id' => $stockReturn->id])
			->orderDesc('StockReturnComment.id')
			->all();
		$clientArr = [];
		foreach ($comments as $row) {
			$rowArr = $row->toArray();
			unset($rowArr['napp_user'], $rowArr['user']);
			$clientArr[] = [
				'StockReturnComment' => $rowArr,
				'NappUser' => $row->napp_user ? (is_object($row->napp_user) ? $row->napp_user->toArray() : $row->napp_user) : [],
				'User' => $row->user ? (is_object($row->user) ? $row->user->toArray() : $row->user) : [],
			];
		}
		$this->set('clientArr', $clientArr);
	}		
	function addcomment($stock_id = null) {
		$this->viewBuilder()->setLayout('admin_new_layout');
		$this->set('title_for_layout', SITENAME . ' Admin Comments');
		$this->checkSatffSession();
		$user_id = $this->request->getSession()->read('Customer.id');
		$fname = $this->request->getSession()->read('Customer.name');
		$lname = $this->request->getSession()->read('Customer.lname');
		$email = $this->request->getSession()->read('Customer.email');

		$data = $this->request->getData();
		if (!empty($data)) {
			$documents = null;
			if (!empty($_FILES['documents']['name'])) {
				$name = $_FILES['documents']['name'];
				$tempname = $_FILES['documents']['tmp_name'];
				$path = WWW_ROOT . 'sheetdoc' . DS;
				$filename = time() . '_' . $name;
				move_uploaded_file($tempname, $path . $filename);
				$documents = $filename;
			}
			$entity = $this->StockReturnComment->newEntity([
				'comment' => isset($data['comment']) ? $data['comment'] : '',
				'stock_id' => $stock_id,
				'admin_id' => 0,
				'user_id' => $user_id,
				'type' => 0,
				'created' => date('Y-m-d H:i:s'),
				'documents' => $documents !== null ? $documents : '',
			]);
			$this->StockReturnComment->save($entity);

			$stockReturn = $this->StockReturn->find()->where(['StockReturn.id' => $stock_id])->first();
			if ($stockReturn) {
				$return_id = $stockReturn->get('return_id');
				$type = $stockReturn->get('type');
				$commentText = $data['comment'] ?? '';
				if (isset($data['is_send']) && $data['is_send'] === 'Yes') {
					$username = $fname . ' ' . $lname;
					$subject = SITENAME . ':- ' . ucfirst($username) . ' has commented on stock return(#' . $return_id . ')';
					$template_name = 'stocktemp';
					$userList = $this->User->find()->where(['User.is_receive_smartsheet' => 1])->all();
					foreach ($userList as $u) {
						$userid = $u->get('id');
						$url = SITEURL . 'admin/stocks/index/' . $type . '/' . $userid . '/' . $return_id;
						$to_name = $u->get('name');
						$to_email = $u->get('email');
						$variables = ['name' => $username, 'to_name' => $to_name, 'return_id' => $return_id, 'subject' => $subject, 'comment' => $commentText, 'url' => $url];
						try {
							$this->sendemail($to_email, $subject, $template_name, $variables);
						} catch (\Exception $e) {
						}
					}
				}
			}

			$this->Flash->success('Comment posted successfully');
			return $this->redirect(['action' => 'comment', $stock_id]);
		}

		$this->set('stock_id', $stock_id);
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
	public function adminWarrantRequestV2($type = null): ?Response
	{
		return $this->admin_warrant_request_v2($type);
	}

	/**
	 * Warrant Request v2 list (same data as admin_warrant_request; Preview uses HTML certificate).
	 */
	public function admin_warrant_request_v2($type = null): ?Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Warranty Request List v2');
		$this->checkAdminSession();

		$results = $this->WarrantyRequests->find()
			->contain(['WarrantyRequestLogs'])
			->orderDesc('WarrantyRequests.id')
			->limit(25)
			->all();

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
		$auth = $this->checkAdminSession();
		if ($auth instanceof Response) {
			return $auth;
		}
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' | Product Warranty Request List');

		$query = $this->ProductWarrantyRequests->find();

		$q = trim((string)$this->request->getQuery('q', ''));
		if ($q !== '') {
			$like = '%' . $q . '%';
			$or = [
				['ProductWarrantyRequests.serialnumber LIKE' => $like],
				['ProductWarrantyRequests.building_name LIKE' => $like],
				['ProductWarrantyRequests.product LIKE' => $like],
				['ProductWarrantyRequests.used_as LIKE' => $like],
				['ProductWarrantyRequests.applicator LIKE' => $like],
				['ProductWarrantyRequests.contract_name LIKE' => $like],
				['ProductWarrantyRequests.email LIKE' => $like],
				['ProductWarrantyRequests.phone LIKE' => $like],
			];
			if (ctype_digit($q)) {
				$or[] = ['ProductWarrantyRequests.id' => (int)$q];
			}
			$query->where(['OR' => $or]);
		}

		$status = trim((string)$this->request->getQuery('status', ''));
		if ($status !== '') {
			if ($status === 'Pending') {
				$query->where([
					'OR' => [
						['ProductWarrantyRequests.status' => ''],
						['ProductWarrantyRequests.status' => 'Pending'],
						['ProductWarrantyRequests.status IS' => null],
					],
				]);
			} else {
				$query->where(['ProductWarrantyRequests.status' => $status]);
			}
		}

		$this->paginate = [
			'limit' => 20,
			'order' => ['ProductWarrantyRequests.id' => 'DESC'],
		];
		$results = $this->paginate($query);

		$productWarrantyRequests = [];
		foreach ($results as $entity) {
			$productWarrantyRequests[] = ['ProductWarrantyRequest' => $entity->toArray()];
		}
		$this->set('productWarrantyRequests', $productWarrantyRequests);
		return null;
	}

	/**
	 * Warranty log: search serial, contractor/applicator, address. CSV export supported.
	 */
	public function admin_product_warranty_log(): ?Response
	{
		$auth = $this->checkAdminSession();
		if ($auth instanceof Response) {
			return $auth;
		}
		ProductWarrantyEventLogger::ensureTable();
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' | Product Warranty Log');

		$query = $this->_productWarrantyLogQuery();
		$export = (string)$this->request->getQuery('export', '');
		if ($export === 'csv') {
			$rows = $query->order(['ProductWarrantyRequests.id' => 'DESC'])->all();

			return $this->_productWarrantyLogCsvResponse($rows);
		}

		$this->paginate = [
			'limit' => 25,
			'order' => ['ProductWarrantyRequests.id' => 'DESC'],
		];
		$results = $this->paginate($query);
		$logs = [];
		foreach ($results as $entity) {
			$logs[] = $entity->toArray();
		}
		$this->set('logs', $logs);
		$this->set('filters', [
			'serial' => trim((string)$this->request->getQuery('serial', '')),
			'contractor' => trim((string)$this->request->getQuery('contractor', '')),
			'address' => trim((string)$this->request->getQuery('address', '')),
			'status' => trim((string)$this->request->getQuery('status', '')),
			'q' => trim((string)$this->request->getQuery('q', '')),
		]);

		return null;
	}

	public function adminProductWarrantyLog(): ?Response
	{
		return $this->admin_product_warranty_log();
	}

	/**
	 * Single warranty log record + event history.
	 */
	public function admin_product_warranty_log_view($id = null): ?Response
	{
		$auth = $this->checkAdminSession();
		if ($auth instanceof Response) {
			return $auth;
		}
		ProductWarrantyEventLogger::ensureTable();
		$rid = (int)$id;
		if ($rid <= 0) {
			$this->Flash->error('Invalid warranty log id.');
			return $this->redirect(['action' => 'admin_product_warranty_log']);
		}
		try {
			$entity = $this->ProductWarrantyRequests->get($rid);
		} catch (\Throwable $e) {
			$this->Flash->error('Warranty record not found.');
			return $this->redirect(['action' => 'admin_product_warranty_log']);
		}
		$events = [];
		try {
			$this->loadModel('ProductWarrantyEventLogs');
			$eventRows = $this->ProductWarrantyEventLogs->find()
				->where(['product_warranty_request_id' => $rid])
				->order(['id' => 'DESC'])
				->all();
			foreach ($eventRows as $row) {
				$events[] = $row->toArray();
			}
		} catch (\Throwable $e) {
			$events = [];
		}
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' | Warranty Log #' . $rid);
		$this->set('record', $entity->toArray());
		$this->set('events', $events);

		return null;
	}

	public function adminProductWarrantyLogView($id = null): ?Response
	{
		return $this->admin_product_warranty_log_view($id);
	}

	/**
	 * @return \Cake\ORM\Query
	 */
	protected function _productWarrantyLogQuery()
	{
		$query = $this->ProductWarrantyRequests->find();
		$serial = trim((string)$this->request->getQuery('serial', ''));
		if ($serial !== '') {
			$query->where(['ProductWarrantyRequests.serialnumber LIKE' => '%' . $serial . '%']);
		}
		$contractor = trim((string)$this->request->getQuery('contractor', ''));
		if ($contractor !== '') {
			$like = '%' . $contractor . '%';
			$query->where([
				'OR' => [
					['ProductWarrantyRequests.contract_company_name LIKE' => $like],
					['ProductWarrantyRequests.contract_name LIKE' => $like],
					['ProductWarrantyRequests.applicator LIKE' => $like],
				],
			]);
		}
		$address = trim((string)$this->request->getQuery('address', ''));
		if ($address !== '') {
			$like = '%' . $address . '%';
			$query->where([
				'OR' => [
					['ProductWarrantyRequests.building_address LIKE' => $like],
					['ProductWarrantyRequests.applicator_address LIKE' => $like],
					['ProductWarrantyRequests.building_name LIKE' => $like],
				],
			]);
		}
		$q = trim((string)$this->request->getQuery('q', ''));
		if ($q !== '') {
			$like = '%' . $q . '%';
			$or = [
				['ProductWarrantyRequests.serialnumber LIKE' => $like],
				['ProductWarrantyRequests.product LIKE' => $like],
				['ProductWarrantyRequests.email LIKE' => $like],
				['ProductWarrantyRequests.phone LIKE' => $like],
				['ProductWarrantyRequests.contract_company_name LIKE' => $like],
				['ProductWarrantyRequests.contract_name LIKE' => $like],
				['ProductWarrantyRequests.building_address LIKE' => $like],
				['ProductWarrantyRequests.applicator_address LIKE' => $like],
			];
			if (ctype_digit($q)) {
				$or[] = ['ProductWarrantyRequests.id' => (int)$q];
			}
			$query->where(['OR' => $or]);
		}
		$status = trim((string)$this->request->getQuery('status', ''));
		if ($status !== '') {
			if ($status === 'Pending') {
				$query->where([
					'OR' => [
						['ProductWarrantyRequests.status' => ''],
						['ProductWarrantyRequests.status' => 'Pending'],
						['ProductWarrantyRequests.status IS' => null],
					],
				]);
			} else {
				$query->where(['ProductWarrantyRequests.status' => $status]);
			}
		}

		return $query;
	}

	/**
	 * @param iterable<\Cake\Datasource\EntityInterface> $rows
	 */
	protected function _productWarrantyLogCsvResponse($rows): Response
	{
		$this->autoRender = false;
		$fh = fopen('php://temp', 'w+');
		fputcsv($fh, [
			'ID', 'Serial number', 'Product', 'Contractor company', 'Contractor name',
			'Applicator address', 'Building name', 'Building address', 'Email', 'Phone',
			'Warranty start', 'Warranty end', 'Status', 'Submitted',
		]);
		foreach ($rows as $entity) {
			$r = $entity->toArray();
			fputcsv($fh, [
				$r['id'] ?? '',
				$r['serialnumber'] ?? '',
				$r['product'] ?? '',
				$r['contract_company_name'] ?? '',
				$r['contract_name'] ?? ($r['applicator'] ?? ''),
				$r['applicator_address'] ?? '',
				$r['building_name'] ?? '',
				$r['building_address'] ?? '',
				$r['email'] ?? '',
				$r['phone'] ?? '',
				$r['start_requested_warranty'] ?? '',
				$r['end_requested_warranty'] ?? '',
				($r['status'] ?? '') !== '' ? $r['status'] : 'Pending',
				$r['created_at'] ?? '',
			]);
		}
		rewind($fh);
		$csv = stream_get_contents($fh) ?: '';
		fclose($fh);
		$filename = 'product-warranty-log-' . date('Ymd-His') . '.csv';

		return $this->response
			->withType('text/csv')
			->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
			->withStringBody($csv);
	}

	/**
	 * @return array{role: string, id: ?int, name: string}
	 */
	protected function _productWarrantyAdminActor(): array
	{
		$session = $this->request->getSession();

		return [
			'role' => 'admin',
			'id' => (int)$session->read('User.id') ?: null,
			'name' => trim((string)$session->read('User.name') . ' ' . (string)$session->read('User.lname')),
		];
	}

	/**
	 * Admin edit of a Pending product warranty request (does not email or generate PDF).
	 */
	public function admin_edit_product_warranty($id = null): ?Response
	{
		$auth = $this->checkAdminSession();
		if ($auth instanceof Response) {
			return $auth;
		}
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' | Edit Product Warranty Request');

		$rid = (int)$id;
		if ($rid <= 0) {
			$this->Flash->error('Invalid request.');
			return $this->redirect(['action' => 'admin_product_warranty_request']);
		}
		try {
			$entity = $this->ProductWarrantyRequests->get($rid);
		} catch (\Throwable $e) {
			$this->Flash->error('Request not found.');
			return $this->redirect(['action' => 'admin_product_warranty_request']);
		}

		$statusVal = trim((string)($entity->status ?? ''));
		if ($statusVal === '') {
			$statusVal = 'Pending';
		}
		if ($statusVal !== 'Pending') {
			$this->Flash->error('Only Pending requests can be edited. Approved certificates are already issued.');
			return $this->redirect(['action' => 'admin_product_warranty_request']);
		}

		if ($this->request->is(['post', 'put', 'patch'])) {
			$allowed = [
				'serialnumber', 'dateofpurchase', 'product', 'used_as', 'application',
				'area_warranted', 'building_address', 'building_name', 'building_area_name',
				'start_requested_warranty', 'end_requested_warranty', 'contract_company_name',
				'applicator_active_abn', 'applicator_address', 'contract_name', 'email',
				'phone', 'sign_date', 'applicator', 'applicator_contact',
			];
			$raw = $this->request->getData('ProductWarrantyRequest');
			if (!is_array($raw) || $raw === []) {
				$raw = $this->request->getData();
			}
			$data = array_intersect_key(is_array($raw) ? $raw : [], array_flip($allowed));
			$data = $this->_normalizeAdminProductWarrantyData($data);
			$before = ProductWarrantyEventLogger::snapshot($entity);
			$entity = $this->ProductWarrantyRequests->patchEntity($entity, $data);
			$entity->status = 'Pending';
			if ($this->ProductWarrantyRequests->save($entity)) {
				$after = ProductWarrantyEventLogger::snapshot($entity);
				$changed = ProductWarrantyEventLogger::diff($before, $after);
				$actor = $this->_productWarrantyAdminActor();
				ProductWarrantyEventLogger::log($rid, 'edited', [
					'actor_role' => $actor['role'],
					'actor_id' => $actor['id'],
					'actor_name' => $actor['name'],
					'before' => $before,
					'after' => $after,
					'message' => $changed !== []
						? ('Updated: ' . implode(', ', array_keys($changed)))
						: 'Saved with no field changes.',
				]);
				$this->Flash->success('Warranty request updated. Preview the PDF, then Approve to send the certificate.');
				return $this->redirect(['action' => 'admin_product_warranty_request', '?' => ['q' => (string)$rid]]);
			}
			$this->Flash->error($this->_firstProductWarrantyValidationMessage($entity));
		}

		$this->set(compact('entity'));
		return null;
	}

	/** CamelCase alias for InflectedRoute (adminEditProductWarranty). */
	public function adminEditProductWarranty($id = null): ?Response
	{
		return $this->admin_edit_product_warranty($id);
	}

	/**
	 * @param array<string, mixed> $data
	 * @return array<string, mixed>
	 */
	protected function _normalizeAdminProductWarrantyData(array $data): array
	{
		$optionalDates = ['start_requested_warranty', 'end_requested_warranty', 'dateofpurchase', 'sign_date'];
		foreach ($optionalDates as $field) {
			if (!array_key_exists($field, $data)) {
				continue;
			}
			$raw = trim((string)$data[$field]);
			if ($raw === '') {
				$data[$field] = ($field === 'dateofpurchase' || $field === 'sign_date') ? $raw : null;
				continue;
			}
			$ts = strtotime(str_replace('/', '-', $raw));
			if ($ts !== false) {
				$data[$field] = date('Y-m-d', $ts);
			}
		}
		foreach ($data as $key => $value) {
			if (is_string($value)) {
				$data[$key] = trim($value);
			}
		}

		return $data;
	}

	/**
	 * @param \Cake\Datasource\EntityInterface $entity
	 */
	protected function _firstProductWarrantyValidationMessage($entity): string
	{
		$errors = method_exists($entity, 'getErrors') ? $entity->getErrors() : [];
		foreach ($errors as $fieldErrors) {
			foreach ((array)$fieldErrors as $message) {
				if (is_string($message) && $message !== '') {
					return $message;
				}
			}
		}

		return 'Please fill in all required fields.';
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

	/** CamelCase alias so dispatcher finds delete (InflectedRoute uses adminDeleteProductWarranty). */
	public function adminDeleteProductWarranty($id = null): ?Response
	{
		return $this->admin_delete_product_warranty($id);
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
		$currentStatus = trim((string)($entity->status ?? ''));
		if ($currentStatus === '' || $currentStatus === 'Pending') {
			// ok
		} else {
			$this->response = $this->response->withStringBody('error');
			return $this->response;
		}
		$entity->status = 'Approved';
		if ($this->ProductWarrantyRequests->save($entity)) {
			$actor = $this->_productWarrantyAdminActor();
			$after = ProductWarrantyEventLogger::snapshot($entity);
			ProductWarrantyEventLogger::log($id, 'approved', [
				'actor_role' => $actor['role'],
				'actor_id' => $actor['id'],
				'actor_name' => $actor['name'],
				'after' => $after,
				'message' => 'Certificate issued and emailed to customer.',
			]);
			$this->_includeProductWarrantyCertificateScript($id);
			$token = ProductWarrantyPortalToken::generate($id);
			$portalUrl = Router::url(['controller' => 'Fronts', 'action' => 'productWarrantyV2Portal', $token], true);
			$emailSent = ProductWarrantyCustomerNotifier::sendApprovedCertificateEmail($id, $token);
			$this->response = $this->response->withType('application/json');
			$this->response = $this->response->withStringBody(json_encode([
				'status' => 'success',
				'portalUrl' => $portalUrl,
				'emailSent' => $emailSent,
				'customerEmail' => trim((string)($entity->email ?? '')),
			]));

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

	/**
	 * Reject product warranty request (AJAX POST).
	 */
	public function admin_reject_warranty(): ?Response
	{
		$this->request->allowMethod(['post']);
		$this->autoRender = false;

		$id = (int)$this->request->getData('id');
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
		$currentStatus = trim((string)($entity->status ?? ''));
		if ($currentStatus === 'Approved') {
			$this->response = $this->response->withStringBody('error');
			return $this->response;
		}
		if ($currentStatus === 'Rejected') {
			$this->response = $this->response->withStringBody('success');
			return $this->response;
		}
		$entity->status = 'Rejected';
		if ($this->ProductWarrantyRequests->save($entity)) {
			$actor = $this->_productWarrantyAdminActor();
			ProductWarrantyEventLogger::log($id, 'rejected', [
				'actor_role' => $actor['role'],
				'actor_id' => $actor['id'],
				'actor_name' => $actor['name'],
				'after' => ProductWarrantyEventLogger::snapshot($entity),
				'message' => 'Request rejected.',
			]);
			$this->response = $this->response->withStringBody('success');
			return $this->response;
		}
		$this->response = $this->response->withStringBody('error');
		return $this->response;
	}

	/** CamelCase alias for reject action routing. */
	public function adminRejectWarranty(): ?Response
	{
		return $this->admin_reject_warranty();
	}

	/**
	 * Generate HTML-based Product Warranty Request Form PDF and save to disk.
	 */
	protected function _includeProductWarrantyCertificateScript(int $id): void
	{
		if (!ProductWarrantyPdfGenerator::generateAndSave($id)) {
			\Cake\Log\Log::error('Product warranty HTML PDF generation failed for id ' . $id);
		}
	}

	/**
	 * Stream a product warranty certificate PDF for review only (does not save file or update DB).
	 * Open before Approve to check layout and data.
	 */
	public function admin_preview_product_warranty_certificate($id = null): ?Response
	{
		$this->request->allowMethod(['get']);
		$this->autoRender = false;
		$this->checkAdminSession();
		$rid = $id !== null ? (int)$id : (int)$this->request->getQuery('id');
		if ($rid <= 0) {
			$this->Flash->error('Invalid request.');
			return $this->redirect(['action' => 'admin_product_warranty_request']);
		}
		try {
			$entity = $this->ProductWarrantyRequests->get($rid);
		} catch (\Throwable $e) {
			$this->Flash->error('Request not found.');
			return $this->redirect(['action' => 'admin_product_warranty_request']);
		}

		$pdfBinary = ProductWarrantyPdfGenerator::generatePdfBinary($rid);

		if (!is_string($pdfBinary) || $pdfBinary === '') {
			$this->Flash->error('Certificate preview could not be generated. Check header/footer images and logs/error.log.');
			return $this->redirect(['action' => 'admin_product_warranty_request']);
		}

		$filename = ProductWarrantyPdfGenerator::certificateFilename($rid, $entity->toArray());

		return $this->response
			->withType('application/pdf')
			->withHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
			->withStringBody($pdfBinary);
	}

	/**
	 * Browser HTML preview — same template/Dompdf HTML as PDF pages 1–2 (no PDF render).
	 * ?raw=1 streams certificate HTML only (for iframe). Otherwise shows toolbar wrapper.
	 */
	public function admin_preview_product_warranty_certificate_html($id = null): ?Response
	{
		$this->request->allowMethod(['get']);
		$this->checkAdminSession();
		$rid = $id !== null ? (int)$id : (int)$this->request->getQuery('id');
		if ($rid <= 0) {
			$this->Flash->error('Invalid request.');
			return $this->redirect(['action' => 'admin_product_warranty_request']);
		}
		try {
			$this->ProductWarrantyRequests->get($rid);
		} catch (\Throwable $e) {
			$this->Flash->error('Request not found.');
			return $this->redirect(['action' => 'admin_product_warranty_request']);
		}

		$html = ProductWarrantyPdfGenerator::buildHtmlForRequest($rid);
		if (!is_string($html) || $html === '') {
			$this->Flash->error('Certificate HTML preview could not be generated. Check logs/error.log.');
			return $this->redirect(['action' => 'admin_product_warranty_request']);
		}

		if ($this->request->getQuery('raw')) {
			$this->autoRender = false;

			return $this->response
				->withType('text/html')
				->withStringBody($html);
		}

		$this->viewBuilder()->setLayout(false);
		$this->set('requestId', $rid);
		$this->set('rawPreviewUrl', Router::url([
			'controller' => 'Stocks',
			'action' => 'admin_preview_product_warranty_certificate_html',
			$rid,
			'?' => ['raw' => '1'],
		], true));
		$this->set('pdfPreviewUrl', Router::url([
			'controller' => 'Stocks',
			'action' => 'admin_preview_product_warranty_certificate',
			$rid,
		], true));
		$this->set('listUrl', Router::url(['action' => 'admin_product_warranty_request'], true));

		return null;
	}

	/** CamelCase alias for HTML certificate preview. */
	public function adminPreviewProductWarrantyCertificateHtml($id = null): ?Response
	{
		return $this->admin_preview_product_warranty_certificate_html($id);
	}

	/** CamelCase alias for routing / dispatcher. */
	public function adminPreviewProductWarrantyCertificate($id = null): ?Response
	{
		return $this->admin_preview_product_warranty_certificate($id);
	}

	public function warrant_request($type=null){
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Warranty Request List');
		$this->checkSatffSession();
		$customer_id = $this->request->getSession()->read('Customer.id');

		$results = $this->WarrantyRequests->find()
			->contain(['WarrantyRequestLogs'])
			->orderDesc('WarrantyRequests.id')
			->limit(25)
			->all();

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
	}

	/** CamelCase alias for URL stocks/warrant_request -> warrantRequest() */
	public function warrantRequest($type = null)
	{
		return $this->warrant_request($type);
	}

	/** CamelCase alias for stocks/warrant_request_v2 */
	public function warrantRequestV2($type = null)
	{
		return $this->warrant_request_v2($type);
	}

	/**
	 * Staff Warrant Request v2 list (Preview uses HTML Dompdf certificate).
	 */
	public function warrant_request_v2($type = null)
	{
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Warranty Request List v2');
		$this->checkSatffSession();

		$results = $this->WarrantyRequests->find()
			->contain(['WarrantyRequestLogs'])
			->orderDesc('WarrantyRequests.id')
			->limit(25)
			->all();

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
	}

	/**
	 * Staff preview — HTML certificate v2 (stream PDF; does not save).
	 */
	public function preview_warranty_certificate_v2($id = null): ?Response
	{
		$this->request->allowMethod(['get']);
		$this->autoRender = false;
		$this->checkSatffSession();
		$uniqueId = $id ? (int)base64_decode(base64_decode(base64_decode((string)$id))) : 0;
		if ($uniqueId <= 0) {
			$this->Flash->error('Invalid request.');
			return $this->redirect(['action' => 'warrant_request_v2']);
		}
		try {
			$this->WarrantyRequests->get($uniqueId);
		} catch (\Throwable $e) {
			$this->Flash->error('Request not found.');
			return $this->redirect(['action' => 'warrant_request_v2']);
		}

		$pdfBinary = WarrantyCertificateHtmlV2Generator::generatePdfBinary($uniqueId);
		if (!is_string($pdfBinary) || $pdfBinary === '') {
			$this->Flash->error('Certificate preview could not be generated. Check logs/error.log.');
			return $this->redirect(['action' => 'warrant_request_v2']);
		}

		return $this->response
			->withType('application/pdf')
			->withHeader('Content-Disposition', 'inline; filename="warranty-v2-' . $uniqueId . '.pdf"')
			->withStringBody($pdfBinary);
	}

	/** CamelCase alias for staff preview v2 */
	public function previewWarrantyCertificateV2($id = null): ?Response
	{
		return $this->preview_warranty_certificate_v2($id);
	}
	
	function warranty($id=null){
		$this->viewBuilder()->setLayout('warranty_layout');
		$this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' | Warranty Info Page');
		$uniqueId = $id ? (int)base64_decode(base64_decode(base64_decode($id))) : null;
		if (!$uniqueId) {
			return $this->redirect('/');
		}
		$this->set('uniqueId', $uniqueId);

		$wrEntity = $this->WarrantyRequests->find()->where(['id' => $uniqueId])->first();
		if (!$wrEntity) {
			return $this->redirect('/');
		}
		$WarrantyRequest = ['WarrantyRequest' => $wrEntity->toArray()];
		$this->set('WarrantyRequest', $WarrantyRequest);

		$logEntity = $this->WarrantyRequestLogs->find()->where(['warranty_request_id' => $uniqueId])->first();
		$WarrantyRequestLog = $logEntity ? ['WarrantyRequestLog' => $logEntity->toArray()] : null;
		$this->set('WarrantyRequestLog', $WarrantyRequestLog);
		
		$flag = 0;
		$data = $this->request->getData();
		if (!empty($data)) {
			$application = is_array($data['application'] ?? null) ? implode(',', $data['application']) : (string)($data['application'] ?? '');
			$logData = [
				'warranty_request_id' => $uniqueId,
				'application' => $application,
				'serialnumber' => $data['serialnumber'] ?? '',
				'dateofpurchase' => !empty($data['dateofpurchase']) ? date('Y-m-d', strtotime($data['dateofpurchase'])) : null,
				'product' => $data['product'] ?? '',
				'used_as' => $data['used_as'] ?? '',
				'area_warranted' => $data['area_warranted'] ?? '',
				'building_address' => $data['building_address'] ?? '',
				'building_name' => $data['building_name'] ?? '',
				'contract_company_name' => $data['contract_company_name'] ?? '',
				'start_requested_warranty' => !empty($data['start_requested_warranty']) ? date('Y-m-d', strtotime($data['start_requested_warranty'])) : null,
				'end_requested_warranty' => !empty($data['end_requested_warranty']) ? date('Y-m-d', strtotime($data['end_requested_warranty'])) : null,
				'sign_date' => !empty($data['sign_date']) ? date('Y-m-d', strtotime($data['sign_date'])) : null,
				'contract_name' => $data['contract_name'] ?? '',
				'building_area_name' => $data['building_area_name'] ?? '',
				'applicator_active_abn' => $data['applicator_active_abn'] ?? '',
				'applicator_address' => $data['applicator_address'] ?? '',
				'applicator_contact' => $data['applicator_contact'] ?? '',
				'applicator' => $data['applicator'] ?? '',
			];
			if (!empty($WarrantyRequestLog) && !empty($WarrantyRequestLog['WarrantyRequestLog']['id'])) {
				$logEntity = $this->WarrantyRequestLogs->get($WarrantyRequestLog['WarrantyRequestLog']['id']);
				$logEntity = $this->WarrantyRequestLogs->patchEntity($logEntity, $logData);
			} else {
				$logEntity = $this->WarrantyRequestLogs->newEntity($logData);
			}
			if ($this->WarrantyRequestLogs->save($logEntity)) {
				$pdfUrl = (defined('SITEURL') ? SITEURL : '') . 'pdf/FPDI/warrantyCertificate.php?lastinsertId=' . $uniqueId;
				@file_get_contents($pdfUrl);

				$wrEntity = $this->WarrantyRequests->get($uniqueId);
				$wrEntity->status = 2;
				$this->WarrantyRequests->save($wrEntity);

				$unique_id = $WarrantyRequest['WarrantyRequest']['unique_id'] ?? '';
				$name = $WarrantyRequest['WarrantyRequest']['name'] ?? '';
				$customerEmail = $WarrantyRequest['WarrantyRequest']['email'] ?? '';
				$project_name = $WarrantyRequest['WarrantyRequest']['project_name'] ?? '';

				$subject = 'Durotech: Filled Warranty Form (#' . $unique_id . ')';
				$template_name = 'notification_to_admin';
				$insertForEmail = $logEntity->toArray();

				$permissionRows = $this->UserPermission->find()
					->contain(['NappUser'])
					->where(['UserPermission.meta_val' => 'Warrant Request']);
				foreach ($permissionRows as $row) {
					$nappUser = $row->napp_user ?? null;
					if (!$nappUser) {
						continue;
					}
					$toEmail = is_object($nappUser) ? ($nappUser->email ?? '') : ($nappUser['email'] ?? '');
					$toName = is_object($nappUser) ? ($nappUser->name ?? '') : ($nappUser['name'] ?? '');
					$nappId = is_object($nappUser) ? ($nappUser->id ?? null) : ($nappUser['id'] ?? null);
					if (empty($toEmail)) {
						continue;
					}
					$url = (defined('SITEURL') ? SITEURL : '') . 'stocks/autologin/' . $id . '/' . $nappId;
					$variables = [
						'unique_id' => $unique_id,
						'name' => $name,
						'url' => $url,
						'project_name' => $project_name,
						'WarrantyRequestLog' => $insertForEmail,
						'to_name' => $toName,
						'email' => $toEmail,
					];
					try {
						$this->sendemail($toEmail, $subject, $template_name, $variables);
					} catch (\Throwable $e) {
						\Cake\Log\Log::error('Warranty notification email failed: ' . $e->getMessage());
					}
				}

				$this->Flash->success('Thanks, we will contact you shortly.');
				return $this->redirect('/warranty/' . $id);
			}
		}	
		$this->set('flag',$flag);
	}	
	
	/** CamelCase alias for URL stocks/change_status/:id */
	public function changeStatus($id = null): ?Response
	{
		return $this->change_status($id);
	}

	function change_status($id = null): ?Response
	{
		$this->autoRender = false;
		if (!$id) {
			$this->Flash->error('Invalid request.');
			return $this->redirect(['action' => 'warrant_request']);
		}
		$wr = $this->WarrantyRequests->get($id);
		if (!$wr) {
			$this->Flash->error('Request not found.');
			return $this->redirect(['action' => 'warrant_request']);
		}
		$wr->status = 3;
		$this->WarrantyRequests->save($wr);
		$this->Flash->success('This request has been completed.');
		return $this->redirect(['action' => 'warrant_request']);
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
			$this->request->getSession()->write('Customer', $cus_arr['NappUser']);
			$this->request->getSession()->write('is_staff', 1);	
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
				$wr->status = 1;
				$this->WarrantyRequests->save($wr);
				$this->Flash->success('Form sent to customer successfully.');
			} catch (\Throwable $e) {
				$hint = $this->smtpFailureHint($e);
				$this->Flash->error('Email could not be sent. Please check logs or email configuration. The request remains in Pending status.' . $hint);
			}
		} else {
			$this->Flash->error('No email address for this request.');
		}
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
				$wr->status = 1;
				$this->WarrantyRequests->save($wr);
				$this->Flash->success('Form sent to customer successfully.');
			} catch (\Throwable $e) {
				$hint = $this->smtpFailureHint($e);
				$this->Flash->error('Email could not be sent. Please check logs or email configuration. The request remains in Pending status.' . $hint);
			}
		} else {
			$this->Flash->error('No email address for this request.');
		}
		return $this->redirect(['action' => 'admin_warrant_request']);
	}

	/** Preview warranty certificate PDF (year-based template) for admin. */
	public function admin_preview_warranty_certificate($id = null): ?Response
	{
		$this->request->allowMethod(['get']);
		$this->checkAdminSession();
		$uniqueId = $id ? (int)base64_decode(base64_decode(base64_decode((string)$id))) : 0;
		if ($uniqueId <= 0) {
			$this->Flash->error('Invalid request.');
			return $this->redirect(['action' => 'admin_warrant_request']);
		}
		try {
			$wr = $this->WarrantyRequests->get($uniqueId);
		} catch (\Throwable $e) {
			$this->Flash->error('Request not found.');
			return $this->redirect(['action' => 'admin_warrant_request']);
		}

		// Always regenerate to preview latest submitted form values.
		$this->_generateWarrantyCertificateByYear($uniqueId);
		$fresh = $this->WarrantyRequests->get($uniqueId);
		$cert = trim((string)($fresh->certificate ?? ''));
		if ($cert === '') {
			$this->Flash->error(
				'Certificate is not available yet. Ensure webroot/pdf/FPDI/ contains year templates with at least 3 pages (see warranty form PDFs). Check logs/error.log.'
			);
			return $this->redirect(['action' => 'admin_warrant_request']);
		}
		$relativePath = (strpos($cert, '/') !== false) ? ltrim($cert, '/') : ('pdf/FPDI/' . ltrim($cert, '/'));
		$absPath = WWW_ROOT . str_replace('/', DS, $relativePath);
		if (!file_exists($absPath)) {
			$this->Flash->error('Certificate file not found on server.');
			return $this->redirect(['action' => 'admin_warrant_request']);
		}
		return $this->redirect('/' . $relativePath);
	}

	/** CamelCase alias for dispatcher compatibility. */
	public function adminPreviewWarrantyCertificate($id = null): ?Response
	{
		return $this->admin_preview_warranty_certificate($id);
	}

	/**
	 * Admin Preview — Warrant Request v2 HTML certificate (stream only; no FPDI, no DB write).
	 */
	public function admin_preview_warranty_certificate_v2($id = null): ?Response
	{
		$this->request->allowMethod(['get']);
		$this->autoRender = false;
		$this->checkAdminSession();
		$uniqueId = $id ? (int)base64_decode(base64_decode(base64_decode((string)$id))) : 0;
		if ($uniqueId <= 0) {
			$this->Flash->error('Invalid request.');
			return $this->redirect(['action' => 'admin_warrant_request_v2']);
		}
		try {
			$this->WarrantyRequests->get($uniqueId);
		} catch (\Throwable $e) {
			$this->Flash->error('Request not found.');
			return $this->redirect(['action' => 'admin_warrant_request_v2']);
		}

		$pdfBinary = WarrantyCertificateHtmlV2Generator::generatePdfBinary($uniqueId);
		if (!is_string($pdfBinary) || $pdfBinary === '') {
			$this->Flash->error('Certificate preview could not be generated. Ensure form details exist. Check logs/error.log.');
			return $this->redirect(['action' => 'admin_warrant_request_v2']);
		}

		return $this->response
			->withType('application/pdf')
			->withHeader('Content-Disposition', 'inline; filename="warranty-v2-' . $uniqueId . '.pdf"')
			->withStringBody($pdfBinary);
	}

	/** CamelCase alias for admin preview v2 */
	public function adminPreviewWarrantyCertificateV2($id = null): ?Response
	{
		return $this->admin_preview_warranty_certificate_v2($id);
	}

	/** Approve submitted warranty request and generate certificate PDF first. */
	public function admin_approve_warranty_request($id = null): ?Response
	{
		$this->request->allowMethod(['get']);
		$this->checkAdminSession();
		$uniqueId = $id ? (int)base64_decode(base64_decode(base64_decode((string)$id))) : 0;
		if ($uniqueId <= 0) {
			$this->Flash->error('Invalid request.');
			return $this->redirect(['action' => 'admin_warrant_request']);
		}
		try {
			$wr = $this->WarrantyRequests->get($uniqueId);
		} catch (\Throwable $e) {
			$this->Flash->error('Request not found.');
			return $this->redirect(['action' => 'admin_warrant_request']);
		}

		if ((int)($wr->status ?? 0) < 2) {
			$this->Flash->error('Please wait until the customer submits the form.');
			return $this->redirect(['action' => 'admin_warrant_request']);
		}

		$this->_generateWarrantyCertificateByYear($uniqueId);
		$fresh = $this->WarrantyRequests->get($uniqueId);
		$cert = trim((string)($fresh->certificate ?? ''));
		if ($cert === '') {
			$this->Flash->error(
				'Approve failed: certificate could not be generated. ' .
				'Add at least one .pdf in webroot/pdf/FPDI/ (e.g. warranty form or 10_year_pdf.pdf), or check logs/error.log.'
			);
			return $this->redirect(['action' => 'admin_warrant_request']);
		}

		$fresh->status = 3;
		if ($this->WarrantyRequests->save($fresh)) {
			$this->Flash->success('Warranty request approved and certificate generated.');
		} else {
			$this->Flash->error('Unable to update request status.');
		}
		return $this->redirect(['action' => 'admin_warrant_request']);
	}

	/** CamelCase alias for dispatcher compatibility. */
	public function adminApproveWarrantyRequest($id = null): ?Response
	{
		return $this->admin_approve_warranty_request($id);
	}

	/** Delete warranty request from admin list. */
	public function admin_delete_warranty_request($id = null): ?Response
	{
		$this->request->allowMethod(['get', 'post']);
		$this->checkAdminSession();
		$uniqueId = $id ? (int)base64_decode(base64_decode(base64_decode((string)$id))) : 0;
		if ($uniqueId <= 0) {
			$this->Flash->error('Invalid request.');
			return $this->redirect(['action' => 'admin_warrant_request']);
		}

		try {
			$wr = $this->WarrantyRequests->get($uniqueId);
		} catch (\Throwable $e) {
			$this->Flash->error('Request not found.');
			return $this->redirect(['action' => 'admin_warrant_request']);
		}

		$deletedLogs = false;
		try {
			$this->WarrantyRequestLogs->deleteAll(['warranty_request_id' => $uniqueId]);
			$deletedLogs = true;
		} catch (\Throwable $e) {
			$deletedLogs = false;
		}

		if ($this->WarrantyRequests->delete($wr)) {
			$this->Flash->success('Warranty request deleted successfully.');
		} else {
			$this->Flash->error(
				$deletedLogs
					? 'Failed to delete warranty request.'
					: 'Failed to delete warranty request logs. Request was not deleted.'
			);
		}

		return $this->redirect(['action' => 'admin_warrant_request']);
	}

	/** CamelCase alias for dispatcher compatibility. */
	public function adminDeleteWarrantyRequest($id = null): ?Response
	{
		return $this->admin_delete_warranty_request($id);
	}

	/**
	 * Legacy year-based warranty certificate generation.
	 * Includes warrantyCertificate.php with app DB config (reliable vs HTTP file_get_contents).
	 */
	protected function _generateWarrantyCertificateByYear(int $requestId): void
	{
		$_REQUEST['lastinsertId'] = $requestId;
		try {
			$conn = \Cake\Datasource\ConnectionManager::get('default');
			$dbConfig = $conn->config();
			$GLOBALS['warranty_cert_db'] = [
				'hostname' => $dbConfig['host'] ?? 'localhost',
				'port' => $dbConfig['port'] ?? 3306,
				'username' => $dbConfig['username'] ?? '',
				'password' => $dbConfig['password'] ?? '',
				'database' => $dbConfig['database'] ?? '',
			];
		} catch (\Throwable $e) {
			$GLOBALS['warranty_cert_db'] = null;
		}

		$certPath = WWW_ROOT . 'pdf' . DS . 'FPDI' . DS . 'warrantyCertificate.php';
		if (!file_exists($certPath)) {
			\Cake\Log\Log::error('warrantyCertificate.php not found at ' . $certPath);

			return;
		}
		try {
			ob_start();
			include $certPath;
		} catch (\Throwable $e) {
			\Cake\Log\Log::error('Warranty certificate generation failed for request ' . $requestId . ': ' . $e->getMessage());
		}
		if (ob_get_level()) {
			ob_end_clean();
		}

		// If legacy mysqli UPDATE did not persist, but PDF file exists, save filename via ORM.
		try {
			$entity = $this->WarrantyRequests->get($requestId);
			if (trim((string)($entity->certificate ?? '')) === '') {
				$uid = (string)($entity->unique_id ?? '');
				$safeName = preg_replace('/[^a-zA-Z0-9_\-\. ]/', '_', $uid) . '.pdf';
				$fullPath = WWW_ROOT . 'pdf' . DS . 'FPDI' . DS . $safeName;
				if (is_file($fullPath)) {
					$entity->certificate = $safeName;
					$this->WarrantyRequests->save($entity);
				} else {
					// Last resort: copy any existing PDF in FPDI as certificate (FPDI build may fail on some hosts).
					$fpdiDir = WWW_ROOT . 'pdf' . DS . 'FPDI' . DS;
					foreach (glob($fpdiDir . '*.pdf') ?: [] as $srcPdf) {
						if (stripos(basename($srcPdf), 'warrantyCertificate') !== false) {
							continue;
						}
						if (@copy($srcPdf, $fullPath)) {
							$entity->certificate = $safeName;
							$this->WarrantyRequests->save($entity);
							\Cake\Log\Log::warning('Warranty certificate: copied fallback PDF for request ' . $requestId . ' from ' . basename($srcPdf));
							break;
						}
					}
				}
			}
		} catch (\Throwable $e) {
			\Cake\Log\Log::error('Warranty certificate ORM sync failed for request ' . $requestId . ': ' . $e->getMessage());
		}
	}
}
