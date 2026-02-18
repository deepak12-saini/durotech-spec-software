<?php 
App::uses('AppController','Controller');
class ProductsController extends AppController{
	public $helpers = array('Html','Form','Session');
	public $components = array('Session','Paginator');	
	public $uses = array('Product','Subcategory','Category','Cart','Project','Label','UserPermission','NappUser','User','LabelCategory','VocCertificate');
	
	
	public function admin_voc_vertificate(){
		
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Voc Certificate List');		
		$this->checkAdminSession(); 
		
		$this->paginate = array('conditions'=>array(),'order'=>array('VocCertificate.id'=>'DESC'),'page' => 1, 'limit' => 10);	
		$VocCertificate = $this->Paginator->paginate('VocCertificate');		
		$this->set('VocCertificate', $VocCertificate);			
	}
	
	public function admin_vocadd() {
		
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Add Product');
		$this->checkAdminSession(); 		
		if(!empty($this->request->data)){
			$this->request->data['VocCertificate']['created'] = date('Y-m-d H:i:s');
			$this->VocCertificate->save($this->request->data);
		
			$this->Session->setFlash('Voc Certificate saved','default',array('class' => 'alert alert-success'));
			return $this->redirect(array('action' => 'voc_vertificate'));
		}
	}
	public function admin_vocedit($id) {
		
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Add Product');
		$this->checkAdminSession(); 		
		if(!empty($this->request->data)){
			$this->request->data['VocCertificate']['id'] = $id;
			$this->request->data['VocCertificate']['created'] = date('Y-m-d H:i:s');
			$this->VocCertificate->save($this->request->data);
		
			$this->Session->setFlash('Voc Certificate updated','default',array('class' => 'alert alert-success'));
			return $this->redirect(array('action' => 'voc_vertificate'));
		}
		$VocCertificateArr = $this->VocCertificate->find('first',array('conditions'=>array('VocCertificate.id'=>$id)));
		$this->request->data = $VocCertificateArr;
		$this->set('VocCertificateArr',$VocCertificateArr);
	}
	
	public function index($slug=null){
		
		$this->layout='customduro_layout';			
		$this->Category->bindModel(
		array('hasMany' => array('Product' => array(
		'className' => 'Product',    
		'foreignKey' => 'category_id',    
		'conditions' => array('status'=>1),
		'fields' => array('id'),
		'order' => array(),
		))));		
		$category = $this->Category->find("all",array('conditions'=>array('Category.status'=>1),'order'=>array('Category.sort'=>'Asc')));	
		
		$sorting = array('Product.sort asc');
		if(!empty($this->reques->data['sorting']))
		{
			$sorting = $this->reques->data['sorting'];
		
			if($sorting == 'created'){
				$sorting = array('Product.id desc');
			}else if($sorting == 'popularity'){
				$sorting = array('Product.is_featured desc');
			} 	
		}	
	
		if(!empty($slug)){
			$categoryArr = $this->Category->find("first",array('conditions'=>array('Category.status'=>1,'Category.slug'=>$slug)));
			$categoryname = $categoryArr['Category']['category_name'];			
			$products = $this->Product->find("all",array('conditions'=>array('Product.status'=>1,'Product.category_id'=>$categoryArr['Category']['id']),'order'=>$sorting));
			
			$meta_keyword = $categoryArr['Category']['meta_keyword'];	
			$meta_title = $categoryArr['Category']['meta_title'];	
			$meta_description = $categoryArr['Category']['meta_description'];	
			$category_name = $categoryArr['Category']['category_name'];	
		}else{
			$slug = $category[0]['Category']['slug'];
			$categoryname = $category[0]['Category']['category_name'];
			$products = $this->Product->find("all",array('conditions'=>array('Product.status'=>1,'Product.category_id'=>$category[0]['Category']['id']),'order'=>$sorting));
			
			/* $meta_keyword = $category[0]['Category']['meta_keyword'];	
			$meta_title = $category[0]['Category']['meta_title'];	
			$meta_description = $category[0]['Category']['meta_description']; */

			$meta_keyword = 'roof, waterproofing, membrane products, waterproofing products,waterproofing supplies';	
			$meta_title = 'Roof Waterproofing Membrane Products, Liquid Waterproofing Sydney';	
			$meta_description = 'Waterproofing products Melbourne, Brisbane and Sydney. Call 0296031177 for waterproofing products and offers, best quality Membranes at lowest price delivered Australia wide';	
			$category_name =  $category[0]['Category']['category_name'];	
		}
			
		$this->Category->bindModel(
		array('hasMany' => array('Product' => array(
		'className' => 'Product',    
		'foreignKey' => 'category_id',    
		'conditions' => array('status'=>1),
		'fields' => array('id'),
		'order' => array(),
		))));		
		$isBrand = $this->Category->find("all",array('conditions'=>array('Category.is_brand'=>1,'Category.status'=>1),'order'=>array('Category.sort'=>'Asc')));
		
		// echo '<pre>';
		// print_r($products);
		// die();
		
		$this->set(compact('products','category','slug','categoryname','isBrand','category_name'));
		
		
		// setup seo keyword
		if(!empty($meta_title)){
			$this->set('meta_title',$meta_title);
		}	
		if(!empty($meta_description)){
			$this->set('meta_description',$meta_description);
		}
		if(!empty($meta_keyword)){
			$this->set('meta_keyword',$meta_keyword);
		}
		
	}
	
	function search(){
		
		$this->autoRender = false;
		if(!empty($this->request->data)){
			$searchtitle = rtrim($this->request->data['search'],' ');
			$searchtitle = ltrim($searchtitle,' ');
			$this->Session->write('searchtitle',$searchtitle);
			$searchtitles = strtoupper($searchtitle);
			
			$productArr = $this->Product->find("first",array('conditions'=>array('Product.status'=>1,'UPPER(Product.title) like'=>'%'.$searchtitles.'%'),'fields'=>array('slug')));				
			$categoryArr = $this->Category->find("first",array('conditions'=>array('Category.category_name like'=>'%'.$searchtitle.'%')));
			
		
			
			if(!empty($productArr)){
				$this->redirect('/products/detail/'.$productArr['Product']['slug']);
			}else if(!empty($categoryArr)){	
				$categorySlug = $categoryArr['Category']['slug'];
				$this->redirect('/products/index/'.$categorySlug);
			}else{				
				$this->Session->setFlash("Your search <b>".$searchtitle."</b> did not match any products.",'default',array('class' => 'alert alert-danger'));
				$this->redirect('/products');
					
			}				
							
		}else{			
			$this->redirect('/products');		
		}			
	}	
	
	public function detail($produc_slug=null){
		$this->layout='customduro_layout';
		$this->set('title_for_layout',SITENAME.' Product Detail Page');	
		
		$random =  $this->Product->query("select title,slug,image FROM products where status = '1' ORDER BY RAND() LIMIT 0,4");
		
		$this->Product->bindModel(
		array('belongsTo' => array('Category' => array(
		'className' => 'Category',    
		'foreignKey' => 'category_id',    
		'conditions' => array(),
		'fields' => array('id','meta_title','meta_description','meta_keyword'),
		'order' => array(),
		))));	
		$this->Product->bindModel(
		array('hasMany' => array('Project' => array(
		'className' => 'Project',    
		'foreignKey' => 'product_id',    
		'conditions' => array(),
		'fields' => array(),
		'order' => array(),
		))));
		$products = $this->Product->find("first",array('conditions'=>array('Product.status'=>1,'Product.slug'=>$produc_slug)));
		if(empty($products))
		{
			$this->Session->setFlash('Product not found.','default',array('class' => 'alert alert-success'));
			return $this->redirect(array('action' => '/products'));
		}
		$this->set(compact('products'));
		
		
		$this->Category->bindModel(
		array('hasMany' => array('Product' => array(
		'className' => 'Product',    
		'foreignKey' => 'category_id',    
		'conditions' => array(),
		'fields' => array('id'),
		'order' => array(),
		))));		
		$category = $this->Category->find("all",array('conditions'=>array('Category.status'=>1),'order'=>array('Category.sort'=>'Asc')));	
		
		$this->Category->bindModel(
		array('hasMany' => array('Product' => array(
		'className' => 'Product',    
		'foreignKey' => 'category_id',    
		'conditions' => array(),
		'fields' => array('id'),
		'order' => array(),
		))));		
		$isBrand = $this->Category->find("all",array('conditions'=>array('Category.is_brand'=>1,'Category.status'=>1),'order'=>array('Category.sort'=>'Asc')));
		
		$this->set(compact('category','isBrand','random'));
		
		// setup seo keyword
		if(!empty($products['Product']['meta_title'])){
			$this->set('meta_title',$products['Product']['meta_title']);
		}else if(!empty($products['Category']['meta_title'])){
			$this->set('meta_title',$products['Category']['meta_title']);
		}	
		if(!empty($products['Product']['meta_description'])){
			$this->set('meta_description',$products['Product']['meta_description']);
		}else if(!empty($products['Category']['meta_description'])){
			$this->set('meta_title',$products['Category']['meta_description']);
		}
		
		if(!empty($products['Product']['meta_keyword'])){
			$this->set('meta_keyword',$products['Product']['meta_keyword']);
		}else if(!empty($products['Category']['meta_keyword'])){
			$this->set('meta_title',$products['Category']['meta_keyword']);
		}
	}
	public function detail_new($produc_slug=null){
		$this->layout='customduro_layout';
		$this->set('title_for_layout',SITENAME.' Product Detail Page');	
		
		$random =  $this->Product->query("select title,slug,image FROM products where status = '1' ORDER BY RAND() LIMIT 0,4");
		
		$this->Product->bindModel(
		array('belongsTo' => array('Category' => array(
		'className' => 'Category',    
		'foreignKey' => 'category_id',    
		'conditions' => array(),
		'fields' => array('id','meta_title','meta_description','meta_keyword'),
		'order' => array(),
		))));	
		$this->Product->bindModel(
		array('hasMany' => array('Project' => array(
		'className' => 'Project',    
		'foreignKey' => 'product_id',    
		'conditions' => array(),
		'fields' => array(),
		'order' => array(),
		))));
		$products = $this->Product->find("first",array('conditions'=>array('Product.status'=>1,'Product.slug'=>$produc_slug)));
		$this->set(compact('products'));
		
		
		$this->Category->bindModel(
		array('hasMany' => array('Product' => array(
		'className' => 'Product',    
		'foreignKey' => 'category_id',    
		'conditions' => array(),
		'fields' => array('id'),
		'order' => array(),
		))));		
		$category = $this->Category->find("all",array('conditions'=>array('Category.status'=>1),'order'=>array('Category.sort'=>'Asc')));	
		
		$this->Category->bindModel(
		array('hasMany' => array('Product' => array(
		'className' => 'Product',    
		'foreignKey' => 'category_id',    
		'conditions' => array(),
		'fields' => array('id'),
		'order' => array(),
		))));		
		$isBrand = $this->Category->find("all",array('conditions'=>array('Category.is_brand'=>1,'Category.status'=>1),'order'=>array('Category.sort'=>'Asc')));
		
		$this->set(compact('category','isBrand','random'));
		
		// setup seo keyword
		if(!empty($products['Product']['meta_title'])){
			$this->set('meta_title',$products['Product']['meta_title']);
		}else if(!empty($products['Category']['meta_title'])){
			$this->set('meta_title',$products['Category']['meta_title']);
		}	
		if(!empty($products['Product']['meta_description'])){
			$this->set('meta_description',$products['Product']['meta_description']);
		}else if(!empty($products['Category']['meta_description'])){
			$this->set('meta_title',$products['Category']['meta_description']);
		}
		
		if(!empty($products['Product']['meta_keyword'])){
			$this->set('meta_keyword',$products['Product']['meta_keyword']);
		}else if(!empty($products['Category']['meta_keyword'])){
			$this->set('meta_title',$products['Category']['meta_keyword']);
		}
	}
	/***
	/*Author  :Ranjit,
	/*Comment : Check before user is login or not
	****/
	function beforeFilter()
    {
		$this->callConstants();
	}
	
	function admin_addlabel($argu=null){
		
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Add Label');		
		$this->checkAdminSession(); 
		
		if(!empty($this->request->data)){
			$file = '';
			if(!empty($this->request->data['Label']['url']['name'])){
				$file_label = $this->request->data['Label']['url']['name'];
				$tmp_name = $this->request->data['Label']['url']['tmp_name'];
				$file = time().'_'.$file_label;
				$path =  WWW_ROOT . 'label/' . $file;
				move_uploaded_file($tmp_name,$path);				
			}	
			
			$insert['Label']['label_cate_id'] = $this->request->data['Label']['label_cate_id'];
			$insert['Label']['name'] = $this->request->data['Label']['name'];
			$insert['Label']['weight'] = $this->request->data['Label']['weight'];
			$insert['Label']['status'] = $this->request->data['Label']['status'];
			$insert['Label']['url'] = $file;
			$insert['Label']['created'] = date('Y-m-d H:i:s');
			if($argu == 'editable'){
				$insert['Label']['is_edit'] = 1;
			}	
			$this->Label->save($insert);			
			$this->Session->setFlash('Product label has been saved','default',array('class' => 'alert alert-success'));
			if($argu == 'editable'){
				return $this->redirect(array('action' => 'edit_label'));		
			}else{		
				return $this->redirect(array('action' => 'label'));		
			}	
		}	
		
		$LabelCategory = $this->LabelCategory->find('all');
		$this->set('LabelCategory',$LabelCategory);
	}	
	
	function admin_deletelabel($id=null){
		
		$this->checkAdminSession();
		$this->autoRender = false;
		
		if($this->Label->delete($id)){
			$this->Session->setFlash('Deleted label successfully','default',array('class' => 'alert alert-success'));
			return $this->redirect(array('action' => 'label'));	
		}	
	}	
	
	function admin_editlabel($id=null){
		
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Edit Label');		
		$this->checkAdminSession(); 
		
		$labelArr = $this->Label->find('first',array('conditions'=>array('Label.id'=>$id)));		
		if(empty($labelArr)){
			$this->Session->setFlash('sorry wrong label.','default',array('class' => 'alert alert-success'));
			return $this->redirect(array('action' => 'label'));		
		}	
		if(!empty($this->request->data)){
		
			$file = '';
			if(!empty($this->request->data['Label']['url']['name'])){
				$file_label = $this->request->data['Label']['url']['name'];
				$tmp_name = $this->request->data['Label']['url']['tmp_name'];
				$file = time().'_'.$file_label;
				$path =  WWW_ROOT . 'label/' . $file;
				move_uploaded_file($tmp_name,$path);	
				$insert['Label']['url'] = $file;	
			}	
			
			$insert['Label']['id'] = $labelArr['Label']['id'];
			$insert['Label']['label_cate_id'] = $this->request->data['Label']['label_cate_id'];
			$insert['Label']['name'] = $this->request->data['Label']['name'];
			$insert['Label']['weight'] = $this->request->data['Label']['weight'];
			$insert['Label']['status'] = $this->request->data['Label']['status'];
			
			$insert['Label']['created'] = date('Y-m-d H:i:s');
			
			$this->Label->save($insert);			
			$this->Session->setFlash('Product label has been saved','default',array('class' => 'alert alert-success'));
			if($argu == 'editable'){
				return $this->redirect(array('action' => 'edit_label'));		
			}else{		
				return $this->redirect(array('action' => 'label'));		
			}		
		}	
		$this->set('labelArr',$labelArr);	

		$LabelCategory = $this->LabelCategory->find('all');
		$this->set('LabelCategory',$LabelCategory);	
	}
	
	function download($file=null){
	
		$this->autoRender = false;
		
		$filepath = WWW_ROOT .'label/'.$file;
		// Process download
		if(file_exists($filepath)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filepath));
			flush(); // Flush system output buffer
			readfile($filepath);
			exit;
		}
	}	
	
	
	function admin_label(){
		
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Product Label List');		
		$this->checkAdminSession(); 
		$label = '';
		$label_cate_id = '';
		if(!empty($this->request->data)){
			$label =  $this->request->data['label'];
			$label_cate_id =  $this->request->data['label_cate_id'];
			
			if(!empty($label_cate_id) && !empty($label) ){
				$this->paginate = array('conditions'=>array('Label.is_edit'=>0,'Label.label_cate_id'=>$label_cate_id,'Label.name LIKE'=>'%'.$label.'%'),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));	
			}else if(!empty($label_cate_id)){
				$this->paginate = array('conditions'=>array('Label.is_edit'=>0,'Label.label_cate_id'=>$label_cate_id),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));	
			}else if(!empty($label)){
				$this->paginate = array('conditions'=>array('Label.is_edit'=>0,'Label.name LIKE'=>'%'.$label.'%'),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));	
			}	
		}else{	
			$this->paginate = array('conditions'=>array('Label.is_edit'=>0),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));		
		}
		
		
		$this->Label->bindModel(
			array('belongsTo' => array('LabelCategory' => array(
			'className' => 'LabelCategory',    
			'foreignKey' => 'label_cate_id',    
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));	
		$labelArr  = $this->Paginator->paginate('Label');	
		$this->set('labelArr',$labelArr);
		
		$this->set('label',$label);
		$this->set('label_cate_id',$label_cate_id);
		
		$LabelCategory = $this->LabelCategory->find('all');
		$this->set('LabelCategory',$LabelCategory);	
	}	
	/***
	/*Author  :Ranjit,
	/*Comment :Admin Category list
	****/
	public function admin_index(){
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Product List');		
		$this->checkAdminSession(); 
		$this->Product->bindModel(
		array('belongsTo' => array('Category' => array(
		'className' => 'Category',    
		'foreignKey' => 'category_id',    
		'conditions' => array(),
		'fields' => array('category_name'),
		'order' => array(),
		))));
		/* $this->Product->bindModel(
		array('belongsTo' => array('Subcategory' => array(
		'className' => 'Subcategory',    
		'foreignKey' => 'sub_category_id',    
		'conditions' => array(),
		'fields' => array('name'),
		'order' => array(),
		))));		 */	
		//$this->Product->recursive = 3;
		$name = '';
		if(!empty($this->request->data)){
			$name = $this->request->data['productname'];
			$this->paginate = array('conditions'=>array('Product.title LIKE'=>'%'.$name.'%'),'page' => 1, 'limit' => 25);
		}else{
			$this->paginate = array('conditions'=>array(),'page' => 1, 'limit' => 25,'order'=>array('Product.id'=>'desc'));
		}	
		$product = $this->Paginator->paginate('Product');		
		$this->set('product', $product);
		$this->set('name', $name);
		//echo"<pre>";print_r($product);die;	 	
	}
	
	public function admin_projectadd($product_id=null) {
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Add Project Reffernce');
		$this->checkAdminSession(); 
		if(!empty($this->request->data)){
			$file = $this->request->data['Product']['image'];						
			$ext = substr(strtolower(strrchr($file['name'], '.')), 1);
			$arr_ext = array('jpg', 'jpeg', 'gif','png');
			if (in_array($ext, $arr_ext)) {
				$image = time().'.'.$ext;
				move_uploaded_file($file['tmp_name'], WWW_ROOT . 'productimg/' .$image);
				//prepare the filename for database entry
				$ProjectArr['Project']['id'] = '';
				$ProjectArr['Project']['images'] = $image;
				$ProjectArr['Project']['product_id'] = $product_id;
				$this->Project->save($ProjectArr);
				$this->redirect('project/'.$product_id);
			}else{
				$this->Session->setFlash('Please upload the valid image extention.','default',array('class' => 'alert alert-danger'));
			}				
		}		
	}
	public function admin_project($product_id=null) {
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Add Project Reffernce');
		$this->checkAdminSession(); 
		
		$imageArr = $this->Project->find('all',array('conditions'=>array('Project.product_id'=>$product_id)));
		$this->set('imageArr',$imageArr);	
		$this->set('product_id',$product_id);	
	}
	
	/**
	* Author:Ranjit
	* Discription:Add Category
	* @return void
*/
	public function admin_add() {
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Add Product');
		$this->checkAdminSession(); 
		$category = $this->Category->find('all');
		$this->set('category',$category);
		$product_code=$this->random_password(8);
		$this->set('product_code',$product_code);
		/* $subcategory = $this->Subcategory->find('all');
		$this->set('subcategory',$subcategory); */
		if(!empty($this->request->data)){
			
			$cat_slug=str_replace(' ','-',strtolower($this->request->data['Product']['title']));
			$cat_slug=str_replace('&','and',$cat_slug);
			$this->request->data['Product']['slug']=$cat_slug;
		
			//Check if image has been uploaded
			if (!empty($this->request->data['Product']['image']['name'])) {		
				$file = $this->request->data['Product']['image'];						
				$ext = substr(strtolower(strrchr($file['name'], '.')), 1);
				$arr_ext = array('jpg', 'jpeg', 'gif','png');
				if (in_array($ext, $arr_ext)) {
					
				// upload thumnail image
				$width = 285;
				$height = 380;
				/* Get original image x y*/
				list($w, $h) = getimagesize($file['tmp_name']);
				/* calculate new image size with ratio */
				$ratio = max($width/$w, $height/$h);
				$h = ceil($height / $ratio);
				$x = ($w - $width / $ratio) / 2;
				$w = ceil($width / $ratio);
				
				$thumnail_image = time().'_thumnail_'.$file['name']; 
				/* new file name */
				$path =  WWW_ROOT . 'productimg/' . $thumnail_image;
				/* read binary data from image file */
				$imgString = file_get_contents($file['tmp_name']);			
				/* create image from string */
				$image = imagecreatefromstring($imgString);
				$tmp = imagecreatetruecolor($width, $height);
				imagecopyresampled($tmp, $image,
				0, 0,
				$x, 0,
				$width, $height,
				$w, $h);
				/* Save image */
				switch ($file['type']) {
					case 'image/jpeg':
						imagejpeg($tmp, $path, 100);
						break;
					case 'image/png':
						imagepng($tmp, $path, 0);
						break;
					case 'image/gif':
						imagegif($tmp, $path);
						break;
					default:
						exit;
						break;
				}
				/* cleanup memory */
				imagedestroy($image);
				imagedestroy($tmp);						
					
				move_uploaded_file($file['tmp_name'], WWW_ROOT . 'productimg/' . $file['name']);
				//prepare the filename for database entry
				$this->request->data['Product']['image'] = $file['name'];
				$this->request->data['Product']['thumb_image'] = $thumnail_image;
				}else{
					$this->Session->setFlash('Please upload the valid image extention.','default',array('class' => 'alert alert-danger'));
					exit;
				}
			}else{
				$this->request->data['Product']['image'] = '250250-defult.png';
				$this->request->data['Product']['thumb_image'] = '250250-defult.png';
			}
			
			if($this->Product->save($this->request->data)){
				$this->Session->setFlash('The product has been saved','default',array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
				}else{
				$this->Session->setFlash('The product could not be saved. Please, try again.','default',array('class' => 'alert alert-danger'));
			}
		}
	}
	public function admin_check(){
		$this->autoRender=false;
		if(!empty($this->request->data)){
			$category_id =$this->request->data['category_id'];
			$sub_cate = $this->Subcategory->find('all',array('conditions'=>array('Subcategory.category_id'=>$category_id)));
			$this->set('sub_cate',$sub_cate);
			if(!empty($sub_cate)){
				foreach($sub_cate as $sub_cate){
					echo '<option value="'.$sub_cate['Subcategory']['category_id'].'">'.$sub_cate['Subcategory']['name'].'</option>';
				}
			}else{
				echo '<option value="">Subcategory not available</option>';
			}
		}
	}
	function admin_edit($id = null){
	$this->layout='admin_layout';
	$this->set('title_for_layout',SITENAME.' Edit Product');
	$this->checkAdminSession(); 
	$category = $this->Category->find('all');
	$this->set('category',$category);
	
	$product_arr = $this->Product->find('first',array('conditions' => array('Product.id'=>$id)));
	$this->set('product_arr',$product_arr);			
	/* $subcategory = $this->Subcategory->find('all',array('conditions' => array('Subcategory.category_id'=>$product_arr['Product']['sub_category_id'])));
	$this->set('subcategory',$subcategory); */

	if(!empty($this->request->data)){
	
	
	$cat_slug=str_replace(' ','-',strtolower($this->request->data['Product']['title']));
	$cat_slug=str_replace('&','and',$cat_slug);
	$this->request->data['Product']['slug']=$cat_slug;
	
	//Check if image has been uploaded
	if (!empty($this->request->data['Product']['image']['name'])) {
	$file = $this->request->data['Product']['image'];

	$ext = substr(strtolower(strrchr($file['name'], '.')), 1);
	$arr_ext = array('jpg', 'jpeg', 'gif','png');

		if (in_array($ext, $arr_ext)) {
			
			// upload thumnail image
			$width = 255;
			$height = 250;
			/* Get original image x y*/
			list($w, $h) = getimagesize($file['tmp_name']);
			/* calculate new image size with ratio */
			$ratio = max($width/$w, $height/$h);
			$h = ceil($height / $ratio);
			$x = ($w - $width / $ratio) / 2;
			$w = ceil($width / $ratio);
			
			$thumnail_image = time().'_thumnail_'.$file['name']; 
			/* new file name */
			$path =  WWW_ROOT . 'productimg/' . $thumnail_image;
			/* read binary data from image file */
			$imgString = file_get_contents($file['tmp_name']);			
			/* create image from string */
			$image = imagecreatefromstring($imgString);
			$tmp = imagecreatetruecolor($width, $height);
			imagecopyresampled($tmp, $image,
			0, 0,
			$x, 0,
			$width, $height,
			$w, $h);
			/* Save image */
			switch ($file['type']) {
				case 'image/jpeg':
					imagejpeg($tmp, $path, 100);
					break;
				case 'image/png':
					imagepng($tmp, $path, 0);
					break;
				case 'image/gif':
					imagegif($tmp, $path);
					break;
				default:
					exit;
					break;
			}
			/* cleanup memory */
			imagedestroy($image);
			imagedestroy($tmp);
			
			move_uploaded_file($file['tmp_name'], WWW_ROOT . 'productimg/' . $file['name']);
			//prepare the filename for database entry
			$this->request->data['Product']['image'] = $file['name'];
			$this->request->data['Product']['thumb_image'] = $thumnail_image;
		}else{
			$this->Session->setFlash('Please upload the valid image extention.','default',array('class' => 'alert alert-danger'));exit;
			return $this->redirect(array('action' => 'edit/'.$id));
		}
		}else{
			if($product_arr['Product']['image']!=''){
				$this->request->data['Product']['image']=$product_arr['Product']['image'];
				$this->request->data['Product']['thumb_image']=$product_arr['Product']['thumb_image'];
			}else{
				$this->request->data['Product']['image']='';
				$this->request->data['Product']['thumb_image']='';
			}
		
		}
		
			if($this->Product->save($this->request->data)){
				$this->Session->setFlash('The product has been saved','default',array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
				}else{
				$this->Session->setFlash('The product could not be saved. Please, try again.','default',array('class' => 'alert alert-danger'));
			}
		}
	}
	
	public function admin_projectdelete($product_id=null,$id = null) {
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Delete');
		$this->checkAdminSession(); 
		$this->Project->id = $id;
		if (!$this->Project->exists()) {
			throw new NotFoundException(__('Invalid Project'));
		}
		
		//$this->request->allowMethod('post', 'delete');
		if ($this->Project->delete($id)) {
			$this->Session->setFlash('The product has been deleted.','default',array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('The product could not be deleted.Please, try again.','default',array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'project/'.$product_id));
	}
	public function admin_delete($id = null) {
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Delete');
		$this->checkAdminSession(); 
		$this->Product->id = $id;
		if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid Product'));
		}
		
		//$this->request->allowMethod('post', 'delete');
		if ($this->Product->delete()) {
			$this->Session->setFlash('The product has been deleted.','default',array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('The product could not be deleted.Please, try again.','default',array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	
	
	function addtocard($productcode=null){
		
		$this->autoRender = false;
		
		$product_arr = $this->Product->find('first',array('conditions' => array('Product.product_code'=>$productcode)));
		
		if(!empty($product_arr)){
			$title = $product_arr['Product']['title']; 
			$category_id = $product_arr['Product']['category_id']; 
			$product_id = $product_arr['Product']['id']; 
			$price_dollar = $product_arr['Product']['price_dollar']; 
						
			$cart_session_id = $this->Session->read('cart_session_id');	
			
			if(empty($cart_session_id)){
				$cart_session_id = strtolower($this->random_password(12));
				$this->Session->write('cart_session_id',$cart_session_id);		
			}	
						
			//$updatecart = $this->Cart->find('first',array('conditions'=>array('Cart.product_id'=>$product_id,'Cart.cart_session_id'=>$cart_session_id)));	
			// if(!empty($updatecart)){
				// $cart['Cart']['id'] =  $updatecart['Cart']['id'];	
				// $cart['Cart']['quantity'] =  $updatecart['Cart']['quantity'] + 1;	
			// }else{
				// $cart['Cart']['quantity'] = 1;
			// }	
			
			$cart['Cart']['quantity'] = 1;
			$cart['Cart']['cart_session_id'] =  $cart_session_id;			
			$cart['Cart']['product_id'] = $product_id;
			$cart['Cart']['category_id'] = $category_id;
			$cart['Cart']['price'] = $price_dollar;
			
			$cart['Cart']['status'] = 1;
			$cart['Cart']['currency'] = '$';
			$this->Cart->save($cart);
			
			$totalcartpro = $this->Cart->find('count',array('conditions'=>array('Cart.cart_session_id'=>$cart_session_id)));	
			
			echo $title.' has successfully added in shoping cart. ## '.$totalcartpro;	
		}	
	}	
	
	function label(){
		
		$user_id=$this->Session->read('Customer.id');	
		$is_staff_id=$this->Session->read('Customer.is_staff_id');	
		if($is_staff_id == 0){
			$this->layout='inner_layout';
		}else{
			$this->layout='staff_inner_layout';
		}	
		#$this->checkCustomerSession();
		$this->checkcommonSession();
		$this->set('title_for_layout',SITENAME.' Product Label List');	
		

		$label = '';
		$label_cate_id = '';
		if(!empty($this->request->data)){
			$label =  $this->request->data['label'];
			$label_cate_id =  $this->request->data['label_cate_id'];
			
			if(!empty($label_cate_id) && !empty($label) ){
				$this->paginate = array('conditions'=>array('Label.label_cate_id'=>$label_cate_id,'Label.name LIKE'=>'%'.$label.'%'),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));	
			}else if(!empty($label_cate_id)){
				$this->paginate = array('conditions'=>array('Label.label_cate_id'=>$label_cate_id),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));	
			}else if(!empty($label)){
				$this->paginate = array('conditions'=>array('Label.name LIKE'=>'%'.$label.'%'),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));	
			}	
		}else{	
			$this->paginate = array('conditions'=>array(),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));		
		}
		$this->Label->bindModel(
			array('belongsTo' => array('LabelCategory' => array(
			'className' => 'LabelCategory',    
			'foreignKey' => 'label_cate_id',    
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));
		$labelArr  = $this->Paginator->paginate('Label');	
		$this->set('labelArr',$labelArr);
		
		$this->set('label',$label);
		$this->set('label_cate_id',$label_cate_id);
		
		$UserPermission = $this->UserPermission->find('first',array('conditions'=>array('UserPermission.permssion_id'=>4,'UserPermission.user_id'=>$user_id)));
		$this->set('UserPermission',$UserPermission);
		
		$LabelCategory = $this->LabelCategory->find('all');
		$this->set('LabelCategory',$LabelCategory);	
		
	}
	
	function permissionrequest(){
		
		$this->autoRender = false;
		
		$customer_id=$this->Session->read('Customer.id');	
		$user = $this->NappUser->find('first',array('conditions'=>array('NappUser.id'=>$customer_id)));
		
		$to = 'kal@durotechindustries.com.au';				
		#$to = 'web@xoroglobal.com';				
		$subject=SITENAME." :: Product label access request.";				
		$template_name = 'labelrequest';
		$name =  $user['NappUser']['name'].' '.$user['NappUser']['lname'];
		$variables = array('name'=>$name,'email'=>$user['NappUser']['email'],'is_staff'=>$user['NappUser']['is_staff_id'],'userid'=>$user['NappUser']['id']);		
		
		try{
			$this->sendemail($to,$subject,$template_name,$variables);
		}catch (Exception $e){
			
		}	
		$this->Session->setFlash('Request has been sent for ','default',array('class' => 'alert alert-success'));
		$this->redirect('label');
		
	}	
	
	public function admin_autologin($status=null,$user_id=null) {
		$this->autoRender = false;
		
		$admin_arr = $this->User->find('first');						
		if(!empty($admin_arr)){	
			$this->Session->write('User', $admin_arr['User']);
			$this->Session->write('is_admin', 1);
							
			if(isset($status) && ($status == 1)){
				$this->redirect('/admin/users/permission/'.$user_id);
			}else if(isset($status) && ($status == 0)){
				$this->redirect('/admin/users/customerpermission/'.$user_id);
			}	
			
		}else{
			$this->Session->setFlash('Sorry, Sorry you have no access.','default',array('class' => 'alert alert-danger'));
			$this->redirect('/admin');
		}	
	}

	function admin_edit_label(){
		
		$this->layout='admin_layout';
		$this->set('title_for_layout',SITENAME.' Product Label List');		
		$this->checkAdminSession(); 
		$label = '';
		$label_cate_id = '';
		if(!empty($this->request->data)){
			$label =  $this->request->data['label'];
			$label_cate_id =  $this->request->data['label_cate_id'];
			
			if(!empty($label_cate_id) && !empty($label)){
				$this->paginate = array('conditions'=>array('Label.is_edit'=>1,'Label.label_cate_id'=>$label_cate_id,'Label.name LIKE'=>'%'.$label.'%'),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));	
			}else if(!empty($label_cate_id)){
				$this->paginate = array('conditions'=>array('Label.is_edit'=>1,'Label.label_cate_id'=>$label_cate_id),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));	
			}else if(!empty($label)){
				$this->paginate = array('conditions'=>array('Label.is_edit'=>1,'Label.name LIKE'=>'%'.$label.'%'),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));	
			}else{
				$this->paginate = array('conditions'=>array('Label.is_edit'=>1),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));
			}	
		}else{	
			$this->paginate = array('conditions'=>array('Label.is_edit'=>1),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));		
		}
		
		$this->Label->bindModel(
			array('belongsTo' => array('LabelCategory' => array(
			'className' => 'LabelCategory',    
			'foreignKey' => 'label_cate_id',    
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));	
		$labelArr  = $this->Paginator->paginate('Label');	
		$this->set('labelArr',$labelArr);
		
		$this->set('label',$label);
		$this->set('label_cate_id',$label_cate_id);
		
		$LabelCategory = $this->LabelCategory->find('all');
		$this->set('LabelCategory',$LabelCategory);	
	}	
	
	function edit_label(){
		
		$user_id=$this->Session->read('Customer.id');	
		$is_staff_id=$this->Session->read('Customer.is_staff_id');	
		$this->layout='staff_inner_layout';
		$this->checkSatffSession();
		$this->set('title_for_layout',SITENAME.' Product Label List');	
		
		$label = '';
		$label_cate_id = '';
		if(!empty($this->request->data)){
			$label =  $this->request->data['label'];
			$label_cate_id =  $this->request->data['label_cate_id'];
			
			if(!empty($label_cate_id) && !empty($label)){
				$this->paginate = array('conditions'=>array('Label.is_edit'=>1,'Label.label_cate_id'=>$label_cate_id,'Label.name LIKE'=>'%'.$label.'%'),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));	
			}else if(!empty($label_cate_id)){
				$this->paginate = array('conditions'=>array('Label.is_edit'=>1,'Label.label_cate_id'=>$label_cate_id),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));	
			}else if(!empty($label)){
				$this->paginate = array('conditions'=>array('Label.is_edit'=>1,'Label.name LIKE'=>'%'.$label.'%'),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));	
			}else{
				$this->paginate = array('conditions'=>array('Label.is_edit'=>1),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));
			}	
		}else{	
			$this->paginate = array('conditions'=>array('Label.is_edit'=>1),'page' => 1, 'limit' => 150,'order'=>array('Label.name'=>'asc'));		
		}
		
		$this->Label->bindModel(
			array('belongsTo' => array('LabelCategory' => array(
			'className' => 'LabelCategory',    
			'foreignKey' => 'label_cate_id',    
			'conditions' => array(),
			'fields' => array(),
			'order' => array(),
		))));	
		$labelArr  = $this->Paginator->paginate('Label');	
		$this->set('labelArr',$labelArr);
		
		$this->set('label',$label);
		$this->set('label_cate_id',$label_cate_id);
		
		$LabelCategory = $this->LabelCategory->find('all');
		$this->set('LabelCategory',$LabelCategory);	
	}	


	public function download_image() {
        $filePath = WWW_ROOT . DS . 'col-chart.jpg';  // Path to your image file
        if (file_exists($filePath)) {
            $this->response->file($filePath, [
                'download' => true,
                'name' => 'downloaded_image.jpg'  // Name of the downloaded file
            ]);
            return $this->response;
        } else {
            throw new NotFoundException(__('Image file not found'));
        }
    }

	public function downloadColorChart() {
		$this->response->file(
			WWW_ROOT . 'chart-color.jpeg', // Path to your image
			['download' => true, 'name' => 'chart-color.jpeg'] // Forces download with custom name
		);
		return $this->response;
	}

    // Action to render the Color Chart page
    
	public function demo($slug=null){
		
		$this->layout='customduro_layout';			
		$this->Category->bindModel(
		array('hasMany' => array('Product' => array(
		'className' => 'Product',    
		'foreignKey' => 'category_id',    
		'conditions' => array('status'=>1),
		'fields' => array('id'),
		'order' => array(),
		))));		
		$category = $this->Category->find("all",array('conditions'=>array('Category.status'=>1),'order'=>array('Category.sort'=>'Asc')));	
		
		$sorting = array('Product.id asc');
		if(!empty($this->reques->data['sorting'])){
			$sorting = $this->reques->data['sorting'];
		
			if($sorting == 'created'){
				$sorting = array('Product.id desc');
			}else if($sorting == 'popularity'){
				$sorting = array('Product.is_featured desc');
			} 	
		}	
	
		if(!empty($slug)){
			$categoryArr = $this->Category->find("first",array('conditions'=>array('Category.status'=>1,'Category.slug'=>$slug)));
			$categoryname = $categoryArr['Category']['category_name'];			
			$products = $this->Product->find("all",array('conditions'=>array('Product.status'=>1,'Product.category_id'=>$categoryArr['Category']['id']),'order'=>$sorting));
			
			$meta_keyword = $categoryArr['Category']['meta_keyword'];	
			$meta_title = $categoryArr['Category']['meta_title'];	
			$meta_description = $categoryArr['Category']['meta_description'];	
			$category_name = $categoryArr['Category']['category_name'];	
		}else{
			$slug = $category[0]['Category']['slug'];
			$categoryname = $category[0]['Category']['category_name'];
			$products = $this->Product->find("all",array('conditions'=>array('Product.status'=>1,'Product.category_id'=>$category[0]['Category']['id']),'order'=>$sorting));
			
			/* $meta_keyword = $category[0]['Category']['meta_keyword'];	
			$meta_title = $category[0]['Category']['meta_title'];	
			$meta_description = $category[0]['Category']['meta_description']; */

			$meta_keyword = 'roof, waterproofing, membrane products, waterproofing products,waterproofing supplies';	
			$meta_title = 'Roof Waterproofing Membrane Products, Liquid Waterproofing Sydney';	
			$meta_description = 'Waterproofing products Melbourne, Brisbane and Sydney. Call 0296031177 for waterproofing products and offers, best quality Membranes at lowest price delivered Australia wide';	
			$category_name =  $category[0]['Category']['category_name'];	
		}
			
		$this->Category->bindModel(
		array('hasMany' => array('Product' => array(
		'className' => 'Product',    
		'foreignKey' => 'category_id',    
		'conditions' => array('status'=>1),
		'fields' => array('id'),
		'order' => array(),
		))));		
		$isBrand = $this->Category->find("all",array('conditions'=>array('Category.is_brand'=>1,'Category.status'=>1),'order'=>array('Category.sort'=>'Asc')));
		
		// echo '<pre>';
		// print_r($products);
		// die();
		
		$this->set(compact('products','category','slug','categoryname','isBrand','category_name'));
		
		
		// setup seo keyword
		if(!empty($meta_title)){
			$this->set('meta_title',$meta_title);
		}	
		if(!empty($meta_description)){
			$this->set('meta_description',$meta_description);
		}
		if(!empty($meta_keyword)){
			$this->set('meta_keyword',$meta_keyword);
		}
		
	}
}
}
?>