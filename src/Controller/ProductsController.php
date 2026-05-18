<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Routing\Router;

/**
 * Products Controller
 */
class ProductsController extends AppController
{
	public function initialize(): void
	{
		parent::initialize();
		$this->loadComponent('Paginator');
		$this->loadModel('Product');
		$this->loadModel('Subcategory');
		$this->loadModel('Category');
		$this->loadModel('Categories'); // Also load Categories (plural) for menu compatibility
		$this->loadModel('Cart');
		$this->loadModel('Project');
		$this->loadModel('Label');
		$this->loadModel('UserPermission');
		$this->loadModel('NappUser');
		$this->loadModel('User');
		$this->loadModel('LabelCategory');
		$this->loadModel('VocCertificate');
		// Use .php extension for views (instead of default .ctp)
		$this->viewBuilder()->setOptions(['ext' => 'php']);
	}

	public function beforeFilter(EventInterface $event): ?Response
	{
		parent::beforeFilter($event);
		$this->callConstants();
		// Set getCategories for Products menu (categories + products) when using front layout
		$action = $this->request->getParam('action');
		$adminActions = ['adminIndex', 'adminVocVertificate', 'adminVocadd', 'adminVocedit', 'adminAddlabel', 'adminDeletelabel', 'adminEditlabel', 'adminLabel', 'adminAdd', 'adminEdit', 'adminDelete', 'adminProject', 'adminProjectadd', 'adminProjectdelete', 'admin_edit_label', 'adminAutologin'];
		if (!in_array($action, $adminActions, true)) {
			$this->_setGetCategoriesForMenu();
		}
		return null;
	}

	/**
	 * Build getCategories (categories with products) for header menu - same structure as FrontsController index.
	 */
	protected function _setGetCategoriesForMenu(): void
	{
		try {
			// Use Categories table (plural) to match FrontsController - has hasMany('Products') so property is 'products' (lowercase plural)
			$this->loadModel('Categories');
			$categoriesQuery = $this->Categories->find()
				->contain(['Products' => function ($q) {
					return $q->where(['Products.status' => 1])->orderAsc('Products.sort');
				}])
				->where(['Categories.status' => 1])
				->orderAsc('Categories.sort')
				->limit(16);
			$getCategories = [];
			foreach ($categoriesQuery as $cat) {
				// Access products property (lowercase plural from hasMany('Products'))
				$products = $cat->products ?? [];
				// Convert ResultSet to array if needed
				if (is_object($products) && method_exists($products, 'toArray')) {
					$products = $products->toArray();
				} elseif (!is_array($products)) {
					$products = [];
				}
				$getCategories[] = [
					'Category' => [
						'category_name' => $cat->category_name ?? '',
						'slug' => $cat->slug ?? '',
					],
					'Product' => array_map(function ($p) {
						if (is_object($p)) {
							return [
								'title' => $p->title ?? '',
								'slug' => $p->slug ?? ''
							];
						}
						return [
							'title' => $p['title'] ?? '',
							'slug' => $p['slug'] ?? ''
						];
					}, $products),
				];
			}
			$this->set(compact('getCategories'));
		} catch (\Exception $e) {
			$this->set('getCategories', []);
		}
	}

	/**
	 * VOC add/edit forms use legacy field names data[VocCertificate][...]; read nested payload for CakePHP 3.
	 *
	 * @return array<string, mixed>
	 */
	protected function getRequestVocCertificateData(): array
	{
		$all = $this->request->getData();
		if (isset($all['data']['VocCertificate']) && is_array($all['data']['VocCertificate'])) {
			return $all['data']['VocCertificate'];
		}
		if (isset($all['VocCertificate']) && is_array($all['VocCertificate'])) {
			return $all['VocCertificate'];
		}
		$nested = $this->request->getData('data.VocCertificate');
		if (is_array($nested) && $nested !== []) {
			return $nested;
		}
		$flat = $this->request->getData('VocCertificate');
		return is_array($flat) ? $flat : [];
	}

	public function adminVocVertificate()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Voc Certificate List');
		$this->checkAdminSession();

		$this->paginate = ['limit' => 10, 'order' => ['VocCertificate.id' => 'DESC']];
		$query = $this->VocCertificate->find();
		$results = $this->paginate($query);
		$VocCertificate = [];
		foreach ($results as $row) {
			$VocCertificate[] = ['VocCertificate' => $row->toArray()];
		}
		$this->set(compact('VocCertificate'));
	}	

	public function adminVocadd()
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' Add Product');
		$this->checkAdminSession();
		if ($this->request->is('post')) {
			$data = $this->getRequestVocCertificateData();
			if ($data !== []) {
				$data['created'] = date('Y-m-d H:i:s');
				$entity = $this->VocCertificate->newEntity($data);
				if ($this->VocCertificate->save($entity)) {
					$this->Flash->success('Voc Certificate saved');
					return $this->redirect(['action' => 'adminVocVertificate']);
				}
				$this->Flash->error('Could not save VOC certificate. ' . json_encode($entity->getErrors()));
			}
		}
	}

	/** CamelCase action for URL /products/vocedit/:id (Edit link from Voc list) */
	public function vocedit($id = null)
	{
		return $this->adminVocedit($id);
	}

	public function adminVocedit($id = null)
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->viewBuilder()->setTemplate('admin_vocedit');
		$this->set('title_for_layout', SITENAME . ' Add Product');
		$this->checkAdminSession();
		if ($this->request->is('post')) {
			$data = $this->getRequestVocCertificateData();
			if ($data !== []) {
				$data['id'] = (int)$id;
				$data['created'] = date('Y-m-d H:i:s');
				$entity = $this->VocCertificate->get($id);
				$entity = $this->VocCertificate->patchEntity($entity, $data);
				if ($this->VocCertificate->save($entity)) {
					$this->Flash->success('Voc Certificate updated');
					return $this->redirect(['action' => 'adminVocVertificate']);
				}
				$this->Flash->error('Could not update VOC certificate. ' . json_encode($entity->getErrors()));
			}
		}
		$entity = $this->VocCertificate->get($id);
		$VocCertificateArr = ['VocCertificate' => $entity->toArray()];
		$this->set('VocCertificateArr', $VocCertificateArr);
		$this->request = $this->request->withData('VocCertificate', $entity->toArray());
	}
	
	public function index(?string $slug = null)
	{
		$this->viewBuilder()->setLayout('customduro_layout');
		$currentCategory = [];
		// Slug from query string (?slug=... from /category/* redirect), route pass, or param
		$slug = $this->request->getQuery('slug') ?? $slug ?? $this->request->getParam('pass.0') ?? $this->request->getParam('slug');
		$slug = is_string($slug) ? trim($slug) : '';
		if ($slug !== '' && strpos($slug, '%2F') !== false) {
			$slug = rawurldecode($slug);
		}
		// Footer/links use duroseal-sealants; DB slug is sealants-and-silicone
		if ($slug === 'duroseal-sealants') {
			$slug = 'sealants-and-silicone';
		}
		// Footer uses sheet-membranes-1; DB slug may be sheet-membranes
		if ($slug === 'sheet-membranes-1') {
			$slug = 'sheet-membranes';
		}

		$categoryResults = $this->Category->find('all')
			->where(['Category.status' => 1])
			->orderAsc('Category.sort');
		$category = [];
		foreach ($categoryResults as $row) {
			$category[] = ['Category' => $row->toArray()];
		}

		$sorting = ['Product.sort' => 'asc'];
		$sortData = $this->request->getData('sorting');
		if (!empty($sortData)) {
			if ($sortData === 'created') {
				$sorting = ['Product.id' => 'desc'];
			} elseif ($sortData === 'popularity') {
				$sorting = ['Product.is_featured' => 'desc'];
			}
		}

		if (!empty($slug)) {
			$categoryArr = $this->Category->find()
				->where(['Category.status' => 1, 'Category.slug' => $slug])
				->first();
			// If not found, try normalized slug (e.g. collapse // to /) to match DB variants
			if (!$categoryArr && is_string($slug)) {
				$normalized = preg_replace('#/+#', '/', trim($slug, '/'));
				if ($normalized !== $slug) {
					$categoryArr = $this->Category->find()
						->where(['Category.status' => 1, 'Category.slug' => $normalized])
						->first();
					if ($categoryArr) {
						$slug = $normalized;
					}
				}
			}
			// Fallback: footer slugs that may not match DB slug – find by category name
			$slugToCategoryName = [
				'sheet-membranes-1' => 'Sheet Membranes',
				'sheet-membranes'   => 'Sheet Membranes',
			];
			if (!$categoryArr && isset($slugToCategoryName[$slug])) {
				$categoryArr = $this->Category->find()
					->where(['Category.status' => 1, 'Category.category_name' => $slugToCategoryName[$slug]])
					->first();
				if ($categoryArr) {
					$slug = $categoryArr->get('slug') ?: $slug;
				}
			}
			if ($categoryArr) {
				$categoryname = $categoryArr->get('category_name');
				$currentCategory = ['Category' => $categoryArr->toArray()];
				$catId = $categoryArr->get('id');
				$productsQuery = $this->Product->find('all')
					->where(['Product.status' => 1, 'Product.category_id' => $catId])
					->order($sorting);
				$products = [];
				foreach ($productsQuery as $row) {
					$products[] = ['Product' => $row->toArray()];
				}
				// Custom display order for polyurethane-waterproofing-membrane category
				if ($slug === 'polyurethane-waterproofing-membrane' && !empty($products)) {
					$products = $this->_sortPolyurethaneProducts($products);
				}
				// Custom display order for sealants-and-silicone category
				if ($slug === 'sealants-and-silicone' && !empty($products)) {
					$products = $this->_sortSealantsProducts($products);
				}
				$meta_keyword = $categoryArr->get('meta_keyword');
				$meta_title = $categoryArr->get('meta_title');
				$meta_description = $categoryArr->get('meta_description');
				$category_name = $categoryArr->get('category_name');
			} else {
				$categoryArr = $this->Category->find()->where(['Category.status' => 1])->first();
				$categoryname = $categoryArr ? $categoryArr->get('category_name') : '';
				$currentCategory = $categoryArr ? ['Category' => $categoryArr->toArray()] : [];
				$catId = $categoryArr ? $categoryArr->get('id') : null;
				$productsQuery = $this->Product->find('all')
					->where(['Product.status' => 1, 'Product.category_id' => $catId])
					->order($sorting);
				$products = [];
				foreach ($productsQuery as $row) {
					$products[] = ['Product' => $row->toArray()];
				}
				$category_name = $categoryname;
			}
		} else {
			$isProductListingHome = true;
			$first = $category[0]['Category'] ?? null;
			$currentCategory = $first ? ['Category' => $first] : [];
			$slug = $first['slug'] ?? '';
			$categoryname = $first['category_name'] ?? '';
			$catId = $first['id'] ?? null;
			$productsQuery = $this->Product->find('all')
				->where(['Product.status' => 1, 'Product.category_id' => $catId])
				->order($sorting);
			$products = [];
			foreach ($productsQuery as $row) {
				$products[] = ['Product' => $row->toArray()];
			}
			$meta_keyword = 'waterproofing products, membrane products, roof waterproofing, liquid waterproofing, Sydney, Melbourne, Brisbane, Australia';
			$meta_title = 'Roof Waterproofing Membrane Products | Liquid Waterproofing Sydney | Durotech';
			$meta_description = 'Waterproofing products for Melbourne, Brisbane & Sydney. Membranes, sealants & coatings. Quality Australian-made. Call 02 9603 1177 or browse categories.';
			$category_name = $categoryname;
		}

		if (empty($isProductListingHome)) {
			$isProductListingHome = false;
		}

		$isBrandResults = $this->Category->find('all')
			->where(['Category.is_brand' => 1, 'Category.status' => 1])
			->orderAsc('Category.sort');
		$isBrand = [];
		foreach ($isBrandResults as $row) {
			$isBrand[] = ['Category' => $row->toArray()];
		}

		$this->set(compact('products', 'category', 'slug', 'categoryname', 'isBrand', 'category_name', 'isProductListingHome', 'currentCategory'));
		if (!empty($meta_title)) {
			$this->set('meta_title', $meta_title);
		}
		if (!empty($meta_description)) {
			$this->set('meta_description', $meta_description);
		}
		if (!empty($meta_keyword)) {
			$this->set('meta_keyword', $meta_keyword);
		}
	}

	/**
	 * Re-order products for polyurethane-waterproofing-membrane category:
	 * Row 1: NEP STD, NEP HV, NEP SL
	 * Row 2: PUM PRO, PPM STD, PPM SL
	 * Row 3: PU BLACK ECO, TTC, ATC
	 *
	 * @param array<int, array<string, array>> $products Array of ['Product' => [...]]
	 * @return array<int, array<string, array>>
	 */
	protected function _sortPolyurethaneProducts(array $products): array
	{
		$orderKeys = [
			'NEP STD',
			'NEP HV',
			'NEP SL',
			'PUM PRO',
			'PPM STD',
			'PPM SL',
			'PU BLACK ECO',
			'TTC',
			'ATC',
		];

		usort($products, function ($a, $b) use ($orderKeys) {
			$titleA = (string)($a['Product']['title'] ?? '');
			$titleB = (string)($b['Product']['title'] ?? '');
			$posA = 999;
			$posB = 999;
			foreach ($orderKeys as $idx => $key) {
				if (stripos($titleA, $key) !== false) {
					$posA = $idx;
					break;
				}
			}
			foreach ($orderKeys as $idx => $key) {
				if (stripos($titleB, $key) !== false) {
					$posB = $idx;
					break;
				}
			}
			return $posA <=> $posB;
		});

		return $products;
	}

	/**
	 * Re-order products for sealants-and-silicone category:
	 * Row 1: 50FC, 25C, DuroFire A
	 * Row 2: 40fc(PU), FC PRO, 488
	 * Row 3: DS100, DS200, DuroGlaze Pro
	 *
	 * @param array<int, array<string, array>> $products Array of ['Product' => [...]]
	 * @return array<int, array<string, array>>
	 */
	protected function _sortSealantsProducts(array $products): array
	{
		$orderKeys = [
			'50FC',
			'25C',
			'DuroFire A',
			'40fc(PU)',
			'FC PRO',
			'488',
			'DS100',
			'DS200',
			'DuroGlaze Pro',
		];

		usort($products, function ($a, $b) use ($orderKeys) {
			$titleA = (string)($a['Product']['title'] ?? '');
			$titleB = (string)($b['Product']['title'] ?? '');
			$posA = 999;
			$posB = 999;
			foreach ($orderKeys as $idx => $key) {
				if (stripos($titleA, $key) !== false) {
					$posA = $idx;
					break;
				}
			}
			foreach ($orderKeys as $idx => $key) {
				if (stripos($titleB, $key) !== false) {
					$posB = $idx;
					break;
				}
			}
			return $posA <=> $posB;
		});

		return $products;
	}

	public function categories()
	{
		$this->viewBuilder()->setLayout('customduro_layout');
		$categories = $this->Category->find('all')
			->where([
				'Category.status' => 1,
				'Category.is_deteled' => 0
			])
			->order(['Category.sort' => 'ASC']);
		$this->set(compact('categories'));
		$this->set('meta_title', 'Product Categories');
		$this->set('meta_description', 'Browse all product categories');
	}

	public function search(): ?Response
	{
		$this->viewBuilder()->setLayout(false);
		$this->request->allowMethod(['get', 'post']);
		// Accept GET (preferred) or legacy POST; field may be 'search' or 'data[search]'
		$searchtitle = trim(
			$this->request->getQuery('search') ?? $this->request->getData('search') ?? $this->request->getData('data.search') ?? ''
		);
		if ($searchtitle !== '') {
			$this->request->getSession()->write('searchtitle', $searchtitle);
			$searchtitles = strtoupper($searchtitle);
			$productArr = $this->Product->find()
				->where(['Product.status' => 1])
				->where(['UPPER(Product.title) LIKE' => '%' . $searchtitles . '%'])
				->select(['slug'])
				->first();
			$categoryArr = $this->Category->find()
				->where(['Category.category_name LIKE' => '%' . $searchtitle . '%'])
				->first();
			if ($productArr) {
				return $this->redirect(rtrim(SITEURL, '/') . '/product/' . $productArr->get('slug'));
			}
			if ($categoryArr) {
				return $this->redirect(rtrim(SITEURL, '/') . '/category/' . $categoryArr->get('slug'));
			}
			$this->Flash->error('Your search <b>' . h($searchtitle) . '</b> did not match any products.', ['params' => ['escape' => false]]);
			return $this->redirect(rtrim(SITEURL, '/') . '/product');
		}
		return $this->redirect(rtrim(SITEURL, '/') . '/product');
	}	
	
	public function detail(?string $slug = null)
	{
		$this->viewBuilder()->setLayout('customduro_layout');
		$produc_slug = $slug ?? $this->request->getParam('pass.0') ?? $this->request->getParam('slug');
		$this->set('title_for_layout', SITENAME . ' Product Detail Page');

		$productEntity = $this->Product->find()
			->contain(['Category', 'Project'])
			->where(['Product.status' => 1, 'Product.slug' => $produc_slug])
			->first();
		if (!$productEntity) {
			$this->Flash->error('Product not found.');
			return $this->redirect(['controller' => 'Products', 'action' => 'index']);
		}
		$products = [
			'Product' => $productEntity->toArray(),
			'Category' => $productEntity->get('Category') ? $productEntity->get('Category')->toArray() : [],
		];

		$randomQuery = $this->Product->find()
			->where([
				'Product.status' => 1,
				'Product.id !=' => $productEntity->id,
			])
			->select(['title', 'slug', 'image'])
			->order('RAND()')
			->limit(8);
		$random = [];
		foreach ($randomQuery as $row) {
			$random[] = ['Product' => $row->toArray()];
		}
		// Resolve legacy /files/view/123 datasheet URL to real file URL so iframe doesn't hit missing FilesController
		if (!empty($products['Product']['datasheet']) && preg_match('#/files/view/(\d+)#', $products['Product']['datasheet'], $m)) {
			try {
				$other = $this->Product->get((int)$m[1], ['fields' => ['datasheet']]);
				$real = $other->get('datasheet');
				if (!empty($real) && strpos($real, '/files/view/') === false) {
					$products['Product']['datasheet'] = strpos($real, 'http') === 0 ? $real : Router::url($real, true);
				}
			} catch (\Exception $e) {
				// leave datasheet as is; serveFileLegacy will handle the request
			}
		}
		$categoryResults = $this->Category->find('all')
			->where(['Category.status' => 1])
			->orderAsc('Category.sort');
		$category = [];
		foreach ($categoryResults as $row) {
			$category[] = ['Category' => $row->toArray()];
		}
		$isBrandResults = $this->Category->find('all')
			->where(['Category.is_brand' => 1, 'Category.status' => 1])
			->orderAsc('Category.sort');
		$isBrand = [];
		foreach ($isBrandResults as $row) {
			$isBrand[] = ['Category' => $row->toArray()];
		}
		$this->set(compact('products', 'random', 'category', 'isBrand'));

		// Use product title for tab so it matches page content; fallback to meta_title/category for SEO
		if (!empty($products['Product']['title'])) {
			$this->set('meta_title', $products['Product']['title']);
		} elseif (!empty($products['Product']['meta_title'])) {
			$this->set('meta_title', $products['Product']['meta_title']);
		} elseif (!empty($products['Category']['meta_title'])) {
			$this->set('meta_title', $products['Category']['meta_title']);
		}
		if (!empty($products['Product']['meta_description'])) {
			$this->set('meta_description', $products['Product']['meta_description']);
		} elseif (!empty($products['Category']['meta_description'])) {
			$this->set('meta_description', $products['Category']['meta_description']);
		}
		if (!empty($products['Product']['meta_keyword'])) {
			$this->set('meta_keyword', $products['Product']['meta_keyword']);
		} elseif (!empty($products['Category']['meta_keyword'])) {
			$this->set('meta_keyword', $products['Category']['meta_keyword']);
		}
	}

	public function detail_new($produc_slug=null){
		$this->viewBuilder()->setLayout('customduro_layout');
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
	/** CamelCase alias for CakePHP 3 routing (Add Label) */
	public function adminAddlabel($argu = null)
	{
		return $this->admin_addlabel($argu);
	}

	function admin_addlabel($argu = null): ?\Cake\Http\Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Add Label');
		$result = $this->checkAdminSession();
		if ($result instanceof \Cake\Http\Response) {
			return $result;
		}

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$raw = $this->request->getData();
			// Form uses name="data[Label][label_cate_id]" so data may be under 'data' => 'Label'
			$data = $raw['Label'] ?? $raw['data']['Label'] ?? $raw['data'] ?? $raw;
			$data = is_array($data) ? $data : [];

			$file = '';
			$urlInput = $data['url'] ?? null;
			if (empty($urlInput) || (is_array($urlInput) && empty($urlInput['name']))) {
				$uploads = $this->request->getUploadedFiles();
				$urlInput = $uploads['Label']['url'] ?? $uploads['Label'] ?? null;
				if (is_object($urlInput)) {
					$urlInput = $urlInput->getClientFilename() ? $urlInput : null;
				}
			}
			if (is_array($urlInput) && !empty($urlInput['name'])) {
				$file = time() . '_' . basename($urlInput['name']);
				$path = WWW_ROOT . 'label' . DS . $file;
				if (!is_dir(WWW_ROOT . 'label')) {
					mkdir(WWW_ROOT . 'label', 0755, true);
				}
				if (!empty($urlInput['tmp_name']) && is_uploaded_file($urlInput['tmp_name'])) {
					move_uploaded_file($urlInput['tmp_name'], $path);
				}
			} elseif (is_object($urlInput) && method_exists($urlInput, 'getClientFilename') && $urlInput->getClientFilename()) {
				$file = time() . '_' . $urlInput->getClientFilename();
				$path = WWW_ROOT . 'label' . DS . $file;
				if (!is_dir(WWW_ROOT . 'label')) {
					mkdir(WWW_ROOT . 'label', 0755, true);
				}
				$urlInput->moveTo($path);
			}

			$labelCateId = isset($data['label_cate_id']) && $data['label_cate_id'] !== '' ? (int)$data['label_cate_id'] : null;
			if ($labelCateId === null || $labelCateId < 1) {
				$this->Flash->error('Please select a label category.');
				$LabelCategory = $this->LabelCategory->find()->all();
				$this->set('LabelCategory', $LabelCategory);
				return null;
			}

			$entity = $this->Label->newEntity([
				'label_cate_id' => $labelCateId,
				'name' => $data['name'] ?? '',
				'weight' => $data['weight'] ?? '',
				'status' => isset($data['status']) ? (int)$data['status'] : 1,
				'url' => $file,
				'is_edit' => ($argu === 'editable') ? 1 : 0,
			], ['validate' => false]);
			if ($this->Label->save($entity)) {
				$this->Flash->success('Product label has been saved.');
				return $this->redirect(($argu === 'editable') ? ['action' => 'admin_edit_label'] : ['action' => 'admin_label']);
			}
			$this->Flash->error('Could not save label. Please try again.');
		}

		$LabelCategory = $this->LabelCategory->find()->all();
		$this->set('LabelCategory', $LabelCategory);
		return null;
	}	
	
	/** CamelCase alias for CakePHP 3 routing (Delete Label) */
	public function adminDeletelabel($id = null)
	{
		return $this->admin_deletelabel($id);
	}

	function admin_deletelabel($id = null): ?\Cake\Http\Response
	{
		$result = $this->checkAdminSession();
		if ($result instanceof \Cake\Http\Response) {
			return $result;
		}
		$id = (int)$id;
		if (!$id || !$this->Label->exists(['id' => $id])) {
			$this->Flash->error('Invalid label.');
			return $this->redirect(['action' => 'admin_label']);
		}
		$entity = $this->Label->get($id);
		if ($this->Label->delete($entity)) {
			$this->Flash->success('Deleted label successfully.');
		} else {
			$this->Flash->error('Could not delete label.');
		}
		return $this->redirect(['action' => 'admin_label']);
	}	
	
	/** CamelCase alias for CakePHP 3 routing (Edit Label) */
	public function adminEditlabel($id = null)
	{
		return $this->admin_editlabel($id);
	}

	function admin_editlabel($id = null): ?\Cake\Http\Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Edit Label');
		$result = $this->checkAdminSession();
		if ($result instanceof \Cake\Http\Response) {
			return $result;
		}
		$id = (int)$id;
		if (!$id || !$this->Label->exists(['id' => $id])) {
			$this->Flash->error('Sorry, wrong label.');
			return $this->redirect(['action' => 'admin_label']);
		}

		$labelArr = $this->Label->get($id);

		if ($this->request->is('post') && !empty($this->request->getData())) {
			$raw = $this->request->getData();
			$data = $raw['Label'] ?? $raw['data']['Label'] ?? $raw['data'] ?? $raw;
			$data = is_array($data) ? $data : [];

			$file = $labelArr->url ?? '';
			$urlInput = $data['url'] ?? null;
			if (is_array($urlInput) && !empty($urlInput['name'])) {
				$file = time() . '_' . basename($urlInput['name']);
				$path = WWW_ROOT . 'label' . DS . $file;
				if (!is_dir(WWW_ROOT . 'label')) {
					mkdir(WWW_ROOT . 'label', 0755, true);
				}
				if (!empty($urlInput['tmp_name']) && is_uploaded_file($urlInput['tmp_name'])) {
					move_uploaded_file($urlInput['tmp_name'], $path);
				}
			} elseif (is_object($urlInput) && method_exists($urlInput, 'getClientFilename') && $urlInput->getClientFilename()) {
				$file = time() . '_' . $urlInput->getClientFilename();
				$path = WWW_ROOT . 'label' . DS . $file;
				if (!is_dir(WWW_ROOT . 'label')) {
					mkdir(WWW_ROOT . 'label', 0755, true);
				}
				$urlInput->moveTo($path);
			}

			$labelCateId = isset($data['label_cate_id']) && $data['label_cate_id'] !== '' ? (int)$data['label_cate_id'] : (int)($labelArr->label_cate_id ?? 0);
			if ($labelCateId < 1) {
				$this->Flash->error('Please select a label category.');
			} else {
				$labelArr = $this->Label->patchEntity($labelArr, [
					'label_cate_id' => $labelCateId,
					'name' => $data['name'] ?? $labelArr->name,
					'weight' => $data['weight'] ?? $labelArr->weight,
					'status' => isset($data['status']) ? (int)$data['status'] : (int)($labelArr->status ?? 1),
					'url' => $file,
				], ['validate' => false]);
				if ($this->Label->save($labelArr)) {
					$this->Flash->success('Product label has been saved.');
					return $this->redirect(['action' => 'admin_label']);
				}
				$this->Flash->error('Could not save label. Please try again.');
			}
		}

		$this->set('labelArr', $labelArr);
		$LabelCategory = $this->LabelCategory->find()->all();
		$this->set('LabelCategory', $LabelCategory);
		return null;
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

	/**
	 * Serve PDF/file from webroot/files/datasheets/ (for product datasheet iframe/links).
	 * URL: /files/datasheets/filename.pdf
	 */
	public function serveDatasheet(): ?Response
	{
		$this->viewBuilder()->setLayout(false);
		$this->autoRender = false;
		$name = $this->request->getParam('pass.0');
		return $this->_serveFileFromWebroot('datasheets', $name);
	}

	/**
	 * Serve file from webroot/files/vocsheets/
	 */
	public function serveVocsheet(): ?Response
	{
		$this->viewBuilder()->setLayout(false);
		$this->autoRender = false;
		$name = $this->request->getParam('pass.0');
		return $this->_serveFileFromWebroot('vocsheets', $name);
	}

	/**
	 * Serve file from webroot/files/colour_charts/
	 */
	public function serveColourChart(): ?Response
	{
		$this->viewBuilder()->setLayout(false);
		$this->autoRender = false;
		$name = $this->request->getParam('pass.0');
		return $this->_serveFileFromWebroot('colour_charts', $name);
	}

	/**
	 * Serve MSDS PDFs from webroot/uploads/msds/ (product MSDS uploads).
	 */
	public function serveMsds(): ?Response
	{
		$this->viewBuilder()->setLayout(false);
		$this->autoRender = false;
		$name = $this->request->getParam('pass.0');
		return $this->_serveFileFromUploadsMsds($name);
	}

	/**
	 * Serve product PDFs from webroot/dompdf/ (e.g. /dompdf/22-DTSPEC 19-03-004.pdf).
	 * Only files in the dompdf root folder are served (no subdirs like lib/, vendor/).
	 */
	public function serveDompdf(): ?Response
	{
		$this->viewBuilder()->setLayout(false);
		$this->autoRender = false;
		$name = $this->request->getParam('pass.0');
		return $this->_serveFileFromDompdf($name);
	}

	/**
	 * Serve product datasheets from webroot/wp-content/uploads/datasheet/.
	 * DB entries like /wp-content/uploads/datasheet/xxxxxxx.pdf → URL /wp-content/uploads/datasheet/xxxxxxx.pdf
	 */
	public function serveWpDatasheet(): ?Response
	{
		$this->viewBuilder()->setLayout(false);
		$this->autoRender = false;
		$name = $this->request->getParam('pass.0');
		return $this->_serveFileFromWpDatasheet($name);
	}

	/**
	 * Serve MSDS files from webroot/wp-content/uploads/msds/.
	 * DB entries like /wp-content/uploads/msds/xxxxxxx.pdf → URL /wp-content/uploads/msds/xxxxxxx.pdf
	 */
	public function serveWpMsds(): ?Response
	{
		$this->viewBuilder()->setLayout(false);
		$this->autoRender = false;
		$pass = $this->request->getParam('pass', []);
		$name = isset($pass[0]) ? $pass[0] : null;
		return $this->_serveFileFromWpMsds($name);
	}

	/**
	 * Serve files from webroot/wp-content/uploads/* (catch-all for brochures, PDFs, etc.).
	 * URL: /wp-content/uploads/folder/file.pdf → serves webroot/wp-content/uploads/folder/file.pdf
	 */
	public function serveWpUploads(): ?Response
	{
		$this->viewBuilder()->setLayout(false);
		$this->autoRender = false;
		$pass = $this->request->getParam('pass', []);
		if (empty($pass)) {
			return $this->response->withStatus(404);
		}
		$pathParts = $pass;
		return $this->_serveFileFromWpUploads($pathParts);
	}

	/**
	 * Legacy /files/* URLs (e.g. /files/view/123) that would otherwise hit missing FilesController.
	 * Redirects to the product's actual datasheet URL or serves the file.
	 */
	public function serveFileLegacy(): ?Response
	{
		$this->viewBuilder()->setLayout(false);
		$this->autoRender = false;
		$this->request->allowMethod(['GET']);
		$pass = $this->request->getParam('pass', []);
		$action = isset($pass[0]) ? $pass[0] : null;
		$idOrName = isset($pass[1]) ? $pass[1] : null;

		// Old URL: /files/view/123 → load product 123 and redirect to its datasheet URL (if it's a real file path)
		if ($action === 'view' && $idOrName !== null && is_numeric($idOrName)) {
			try {
				$product = $this->Product->get((int)$idOrName, ['fields' => ['id', 'datasheet']]);
				$url = $product->get('datasheet');
				if (!empty($url) && strpos($url, '/files/view/') === false) {
					// Avoid loop: don't redirect if datasheet still points to /files/view/...
					if (strpos($url, 'http') !== 0) {
						$url = Router::url($url, true);
					}
					return $this->redirect($url);
				}
			} catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
				// fall through to 404
			}
		}

		// /files/datasheets/filename or /files/vocsheets/filename (if caught here)
		if ($action === 'datasheets' && $idOrName !== null) {
			return $this->_serveFileFromWebroot('datasheets', $idOrName);
		}
		if ($action === 'vocsheets' && $idOrName !== null) {
			return $this->_serveFileFromWebroot('vocsheets', $idOrName);
		}
		if ($action === 'colour_charts' && $idOrName !== null) {
			return $this->_serveFileFromWebroot('colour_charts', $idOrName);
		}

		return $this->response->withStatus(404);
	}

	/**
	 * Stream a file from webroot/dompdf/ (root only; safe: no path traversal).
	 */
	protected function _serveFileFromDompdf(?string $name): ?Response
	{
		$this->request->allowMethod(['GET']);
		if ($name === null || $name === '') {
			return $this->response->withStatus(404);
		}
		$safeName = basename($name);
		if ($safeName !== $name || strpos($name, '..') !== false || strpos($name, '/') !== false || strpos($name, '\\') !== false) {
			return $this->response->withStatus(400);
		}
		$filePath = WWW_ROOT . 'dompdf' . DS . $safeName;
		if (!is_file($filePath)) {
			return $this->response->withStatus(404);
		}
		$ext = strtolower(pathinfo($safeName, PATHINFO_EXTENSION));
		$mime = ['pdf' => 'application/pdf', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'][$ext] ?? 'application/octet-stream';
		$this->response = $this->response->withHeader('Content-Type', $mime);
		$this->response = $this->response->withHeader('Content-Disposition', 'inline; filename="' . $safeName . '"');
		$this->response = $this->response->withFile($filePath, ['download' => false]);
		return $this->response;
	}

	/**
	 * Stream a file from webroot/wp-content/uploads/datasheet/ (safe: no path traversal).
	 * For DB values like /wp-content/uploads/datasheet/Duro Mastic P15.pdf
	 */
	protected function _serveFileFromWpDatasheet(?string $name): ?Response
	{
		$this->request->allowMethod(['GET']);
		if ($name === null || $name === '') {
			return $this->response->withStatus(404);
		}
		$safeName = basename($name);
		if (strpos($name, '..') !== false || strpos($name, '/') !== false || strpos($name, '\\') !== false) {
			return $this->response->withStatus(400);
		}
		$filePath = WWW_ROOT . 'wp-content' . DS . 'uploads' . DS . 'datasheet' . DS . $safeName;
		if (!is_file($filePath)) {
			return $this->response->withStatus(404);
		}
		$ext = strtolower(pathinfo($safeName, PATHINFO_EXTENSION));
		$mime = ['pdf' => 'application/pdf', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'][$ext] ?? 'application/octet-stream';
		$this->response = $this->response->withHeader('Content-Type', $mime);
		$this->response = $this->response->withHeader('Content-Disposition', 'inline; filename="' . $safeName . '"');
		$this->response = $this->response->withFile($filePath, ['download' => false]);
		return $this->response;
	}

	/**
	 * Stream a file from webroot/files/{folder}/ (safe: no path traversal).
	 */
	protected function _serveFileFromWebroot(string $folder, ?string $name): ?Response
	{
		$this->request->allowMethod(['GET']);
		$allowed = ['datasheets', 'vocsheets', 'colour_charts'];
		if (!in_array($folder, $allowed, true) || $name === null || $name === '') {
			return $this->response->withStatus(404);
		}
		$safeName = basename($name);
		if ($safeName !== $name || strpos($name, '..') !== false) {
			return $this->response->withStatus(400);
		}
		$filePath = WWW_ROOT . 'files' . DS . $folder . DS . $safeName;
		if (!is_file($filePath)) {
			return $this->response->withStatus(404);
		}
		$ext = strtolower(pathinfo($safeName, PATHINFO_EXTENSION));
		$mime = ['pdf' => 'application/pdf', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'][$ext] ?? 'application/octet-stream';
		$this->response = $this->response->withHeader('Content-Type', $mime);
		$this->response = $this->response->withHeader('Content-Disposition', 'inline; filename="' . $safeName . '"');
		$this->response = $this->response->withFile($filePath, ['download' => false]);
		return $this->response;
	}

	/**
	 * Stream a file from webroot/uploads/msds/ (safe: no path traversal).
	 */
	protected function _serveFileFromUploadsMsds(?string $name): ?Response
	{
		$this->request->allowMethod(['GET']);
		if ($name === null || $name === '') {
			return $this->response->withStatus(404);
		}
		$safeName = basename($name);
		if ($safeName !== $name || strpos($name, '..') !== false) {
			return $this->response->withStatus(400);
		}
		$filePath = WWW_ROOT . 'uploads' . DS . 'msds' . DS . $safeName;
		if (!is_file($filePath)) {
			return $this->response->withStatus(404);
		}
		$ext = strtolower(pathinfo($safeName, PATHINFO_EXTENSION));
		$mime = ['pdf' => 'application/pdf'][$ext] ?? 'application/octet-stream';
		$this->response = $this->response->withHeader('Content-Type', $mime);
		$this->response = $this->response->withHeader('Content-Disposition', 'inline; filename="' . $safeName . '"');
		$this->response = $this->response->withFile($filePath, ['download' => false]);
		return $this->response;
	}

	/**
	 * Stream a file from webroot/wp-content/uploads/msds/ (safe: no path traversal).
	 */
	protected function _serveFileFromWpMsds(?string $name): ?Response
	{
		$this->request->allowMethod(['GET']);
		if ($name === null || $name === '') {
			return $this->response->withStatus(404);
		}
		$safeName = basename($name);
		if (strpos($name, '..') !== false || strpos($name, '/') !== false || strpos($name, '\\') !== false) {
			return $this->response->withStatus(400);
		}
		$filePath = WWW_ROOT . 'wp-content' . DS . 'uploads' . DS . 'msds' . DS . $safeName;
		if (!is_file($filePath)) {
			return $this->response->withStatus(404);
		}
		$ext = strtolower(pathinfo($safeName, PATHINFO_EXTENSION));
		$mime = ['pdf' => 'application/pdf', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'][$ext] ?? 'application/octet-stream';
		$this->response = $this->response->withHeader('Content-Type', $mime);
		$this->response = $this->response->withHeader('Content-Disposition', 'inline; filename="' . $safeName . '"');
		$this->response = $this->response->withFile($filePath, ['download' => false]);
		return $this->response;
	}

	/**
	 * Stream a file from webroot/wp-content/uploads/{subfolder}/ (safe: no path traversal).
	 * Handles paths like /wp-content/uploads/brochure/file.pdf or /wp-content/uploads/folder/subfolder/file.pdf
	 */
	protected function _serveFileFromWpUploads(array $pathParts): ?Response
	{
		$this->request->allowMethod(['GET']);
		if (empty($pathParts)) {
			return $this->response->withStatus(404);
		}
		$safeParts = [];
		foreach ($pathParts as $part) {
			$part = basename($part);
			if ($part === '' || $part === '.' || $part === '..' || strpos($part, '/') !== false || strpos($part, '\\') !== false) {
				return $this->response->withStatus(400);
			}
			$safeParts[] = $part;
		}
		$filePath = WWW_ROOT . 'wp-content' . DS . 'uploads' . DS . implode(DS, $safeParts);
		if (!is_file($filePath)) {
			return $this->response->withStatus(404);
		}
		$fileName = end($safeParts);
		$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
		$mime = ['pdf' => 'application/pdf', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif', 'doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'][$ext] ?? 'application/octet-stream';
		$this->response = $this->response->withHeader('Content-Type', $mime);
		$this->response = $this->response->withHeader('Content-Disposition', 'inline; filename="' . $fileName . '"');
		$this->response = $this->response->withFile($filePath, ['download' => false]);
		return $this->response;
	}
	
	
	/** CamelCase alias for CakePHP 3 routing (Normal Product Label menu) */
	public function adminLabel()
	{
		return $this->admin_label();
	}

	function admin_label(): ?\Cake\Http\Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Product Label List');
		$result = $this->checkAdminSession();
		if ($result instanceof \Cake\Http\Response) {
			return $result;
		}

		// Search uses GET (no CSRF); support both query string and POST
		$label = trim((string)($this->request->getQuery('label') ?? $this->request->getData('label') ?? ''));
		$label_cate_id = trim((string)($this->request->getQuery('label_cate_id') ?? $this->request->getData('label_cate_id') ?? ''));

		$conditions = ['Label.is_edit' => 0];
		if ($label_cate_id !== '') {
			$conditions['Label.label_cate_id'] = $label_cate_id;
		}
		if ($label !== '') {
			$conditions['Label.name LIKE'] = '%' . $label . '%';
		}

		$query = $this->Label->find()
			->contain(['LabelCategory'])
			->where($conditions)
			->orderAsc('Label.name');
		$labelArr = $this->paginate($query, ['limit' => 150]);

		$LabelCategory = $this->LabelCategory->find()->all();
		$this->set(compact('labelArr', 'label', 'label_cate_id', 'LabelCategory'));
		return null;
	}	
	/***
	/*Author  :Ranjit,
	/*Comment :Admin Category list (CakePHP 3 route uses adminIndex)
	****/
	public function adminIndex(): void
	{
		$this->admin_index();
	}

	public function admin_index(){
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Product List');
		$this->checkAdminSession();

		$name = (string)($this->request->getData('productname') ?? $this->request->getQuery('productname') ?? '');
		// When search is empty, redirect to clean URL so "all records" shows from page 1
		if ($name === '' && $this->request->getQuery('productname') !== null) {
			return $this->redirect(rtrim(SITEURL, '/') . '/admin/products');
		}
		$this->paginate = [
			'limit' => 25,
			'order' => ['Product.id' => 'DESC'],
		];
		$query = $this->Product->find()->contain(['Category']);
		if ($name !== '') {
			$query->where(['Product.title LIKE' => '%' . $name . '%']);
		}
		$results = $this->paginate($query);

		// Convert to legacy array format for admin_index view (Product + Category keys)
		$product = [];
		foreach ($results as $row) {
			$arr = $row->toArray();
			$category = isset($arr['category']) ? $arr['category'] : [];
			unset($arr['category']);
			$product[] = ['Product' => $arr, 'Category' => $category];
		}
		$this->set('product', $product);
		$this->set('name', $name);
	}
	
	/** CamelCase action for URL /products/admin-projectadd/:id */
	public function adminProjectadd($product_id = null)
	{
		$this->viewBuilder()->setTemplate('admin_projectadd');
		return $this->admin_projectadd($product_id);
	}

	public function admin_projectadd($product_id=null) {
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Add Project Reffernce');
		$this->checkAdminSession();
		$product_id = (int)$product_id;
		$data = $this->request->getData();
		$file = $data['Product']['image'] ?? $data['data']['Product']['image'] ?? null;
		if (!empty($data) && is_array($file) && !empty($file['name']) && !empty($file['tmp_name'])) {
			$name = (string)$file['name'];
			$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION)) ?: substr(strtolower(strrchr($name, '.')), 1);
			$arr_ext = array('jpg', 'jpeg', 'gif', 'png');
			if (in_array($ext, $arr_ext)) {
				$image = time() . '.' . $ext;
				$dest = WWW_ROOT . 'productimg' . DS . $image;
				if (move_uploaded_file($file['tmp_name'], $dest)) {
					$entity = $this->Project->newEntity([
						'images' => $image,
						'product_id' => $product_id,
					]);
					if ($this->Project->save($entity)) {
						$this->Flash->success('Image added.');
						return $this->redirect(rtrim(SITEURL, '/') . '/admin/products/project/' . $product_id);
					}
				}
				$this->Flash->error('Could not save image.');
			} else {
				$this->Flash->error('Please upload a valid image (jpg, jpeg, gif, png).');
			}
		}
		$this->set('product_id', $product_id);
	}
	public function admin_project($product_id=null) {
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Add Project Reffernce');
		$this->checkAdminSession();
		$product_id = (int)$product_id;
		$results = $this->Project->find()->where(['Project.product_id' => $product_id])->all();
		$imageArr = [];
		foreach ($results as $row) {
			$imageArr[] = ['Project' => $row->toArray()];
		}
		$this->set('imageArr', $imageArr);
		$this->set('product_id', $product_id);
	}

	/** CamelCase action for URL /products/project/:id */
	public function project($id = null)
	{
		$this->viewBuilder()->setTemplate('admin_project');
		return $this->admin_project($id);
	}
	
	/**
	* Author:Ranjit
	* Discription:Add Category
	* @return void
*/
	public function adminAdd()
	{
		return $this->admin_add();
	}

	public function admin_add() {

		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Add Product');
		$this->checkAdminSession();
		// CakePHP 3: find()->all() returns entities; convert to legacy array for view
		$categoryRows = $this->Category->find()->all();
		$category = [];
		foreach ($categoryRows as $row) {
			$category[] = ['Category' => $row->toArray()];
		}
		$this->set('category', $category);
		$product_code=$this->random_password(8);
		$this->set('product_code',$product_code);
		/* $subcategory = $this->Subcategory->find('all');
		$this->set('subcategory',$subcategory); */
		if(!empty($this->request->getData())){
			// Normalize: form may send data[Product][...] or Product[...]
			$data = $this->request->getData();
			$productData = $data['Product'] ?? $data['data']['Product'] ?? [];
			if (!is_array($productData)) {
				$productData = [];
			}
			$this->request = $this->request->withData('Product', $productData);

			$title = (string)($productData['title'] ?? '');
			$cat_slug = str_replace(' ', '-', strtolower($title));
			$cat_slug = str_replace('&', 'and', $cat_slug);
			$productData['slug'] = $cat_slug;

			//Check if image has been uploaded
			if (!empty($productData['image']['name'] ?? null)) {
				$file = $productData['image'];						
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
				$h = (int) ceil($height / $ratio);
				$x = (int) round(($w - $width / $ratio) / 2);
				$w = (int) ceil($width / $ratio);
				
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
				$productData['image'] = $file['name'];
				$productData['thumb_image'] = $thumnail_image;
				}else{
					$this->Flash->success('Please upload the valid image extention.','default',array('class' => 'alert alert-danger'));
					exit;
				}
			}else{
				$productData['image'] = '250250-defult.png';
				$productData['thumb_image'] = '250250-defult.png';
			}


			//chart image upload code here

			// Handle Colour Chart Image Upload
			if (!empty($productData['chart_image']['tmp_name'] ?? null)) {
				$file = $productData['chart_image'];
				$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
				$allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

				if (in_array($ext, $allowed_ext)) {
					$filename = time() . '_chart_' . preg_replace('/\s+/', '_', $file['name']);
					$uploadPath_chart = WWW_ROOT . 'files' . DS . 'colour_charts' . DS;

					// Ensure the directory exists
					if (!file_exists($uploadPath_chart)) {
						mkdir($uploadPath_chart, 0755, true);
					}

					if (move_uploaded_file($file['tmp_name'], $uploadPath_chart . $filename)) {
						$productData['chart_image'] = rtrim(SITEURL, '/') . '/files/colour_charts/' . $filename;
					} else {
						$productData['chart_image'] = '';
						// $this->Flash->success('Failed to upload Colour Chart image.','default',array('class' => 'alert alert-danger'));
		}
				} else {
					// $this->Flash->success('Invalid Chart image extension. Only JPG, PNG, GIF allowed.','default',array('class' => 'alert alert-danger'));
					$productData['chart_image'] = '';
				}
			} else {
				$productData['chart_image'] = '';
			}



			// Handle MSDS file upload new_code deepak msds
			$msds_files = is_array($productData['msds'] ?? null) ? $productData['msds'] : [];
			$msds_urls = [];

			if (!empty($msds_files[0]['tmp_name'] ?? null)) {
				$msds_dir = WWW_ROOT . 'uploads/msds/';
				if (!file_exists($msds_dir)) {
					mkdir($msds_dir, 0755, true); // ensures folder exists
				}

				foreach ($msds_files as $file) {
					if (!empty($file['name'])) {
						$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
						if ($ext === 'pdf') {
							$filename = time() . '_' . preg_replace('/\s+/', '_', $file['name']);
							$uploadPath = $msds_dir . $filename;
							if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
								$msds_urls[] = rtrim(SITEURL, '/') . '/uploads/msds/' . $filename;
							}
						}
					}
				}

				$productData['msds'] = implode('##', $msds_urls);
			}else{

				$productData['msds'] = '';

			}

			// Handle datasheet upload
			if (!empty($productData['datasheet']['tmp_name'] ?? null)) {
				$file = $productData['datasheet'];
				$filename = time() . '_' . preg_replace('/\s+/', '_', $file['name']);
				$uploadPath_sheet = WWW_ROOT . 'files' . DS . 'datasheets' . DS;

				// Ensure directory exists
				if (!file_exists($uploadPath_sheet)) {
					mkdir($uploadPath_sheet, 0755, true);
				}

				if (move_uploaded_file($file['tmp_name'], $uploadPath_sheet . $filename)) {
					// Save full URL in DB for consistency (use SITEURL to avoid double base path)
					$productData['datasheet'] = rtrim(SITEURL, '/') . '/files/datasheets/' . $filename;
				}
			}else{
				$productData['datasheet'] = '';
			}

			// Handle VOC PDF upload
			if (!empty($productData['voc_pdf']['tmp_name'] ?? null)) {
				$file = $productData['voc_pdf'];
				$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
				if ($ext === 'pdf') {
					$filename = time() . '_' . preg_replace('/\s+/', '_', $file['name']);
					$uploadPath_voc = WWW_ROOT . 'files' . DS . 'vocsheets' . DS;

					// Ensure the directory exists
					if (!file_exists($uploadPath_voc)) {
						mkdir($uploadPath_voc, 0755, true);
					}

					if (move_uploaded_file($file['tmp_name'], $uploadPath_voc . $filename)) {
						// Save full URL to DB (use SITEURL to avoid double base path)
						$productData['voc_pdf'] = rtrim(SITEURL, '/') . '/files/vocsheets/' . $filename;
					}
				}
			}else{
				$productData['voc_pdf'] = '';
			}

			$this->request = $this->request->withData('Product', $productData);

			$entity = $this->Product->newEntity($productData);
			if ($this->Product->save($entity)) {
				$this->Flash->success('The product has been saved.');
				return $this->redirect(rtrim(SITEURL, '/') . '/admin/products');
			} else {
				$this->Flash->error('The product could not be saved. Please, try again.');
			}	
		}
	}
	public function admin_check(){
		$this->autoRender=false;
		if(!empty($this->request->getData())){
			$category_id =$this->request->getData()['category_id'];
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
	public function adminEdit($id = null)
	{
		return $this->admin_edit($id);
	}

	function admin_edit($id = null){

		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Edit Product');
		$this->checkAdminSession();

		// CakePHP 3: find()->all() and convert to legacy array format for view
		$categoryRows = $this->Category->find()->all();
		$category = [];
		foreach ($categoryRows as $row) {
			$category[] = ['Category' => $row->toArray()];
		}
		$this->set('category', $category);

		$productEntity = $this->Product->find()->where(['Product.id' => $id])->first();
		if (!$productEntity) {
			$this->Flash->error('Product not found.');
			return $this->redirect(['action' => 'admin_index']);
		}
		$product_arr = ['Product' => $productEntity->toArray()];
		// Fix double base path in stored URLs (e.g. .../cake3app/cake3app/files/... -> .../cake3app/files/...)
		$base = rtrim(SITEURL, '/');
		$pathSegment = substr(strrchr($base, '/'), 1); // e.g. 'cake3app'
		if ($pathSegment !== false && $pathSegment !== '') {
			$doublePrefix = $base . '/' . $pathSegment . '/';
			foreach (['datasheet', 'voc_pdf', 'chart_image'] as $field) {
				if (!empty($product_arr['Product'][$field]) && is_string($product_arr['Product'][$field])
					&& strpos($product_arr['Product'][$field], $doublePrefix) === 0) {
					$product_arr['Product'][$field] = $base . substr($product_arr['Product'][$field], strlen($doublePrefix) - 1);
				}
			}
			// MSDS can contain multiple URLs separated by ##
			if (!empty($product_arr['Product']['msds']) && is_string($product_arr['Product']['msds'])) {
				$msdsParts = explode('##', $product_arr['Product']['msds']);
				$fixed = [];
				foreach ($msdsParts as $url) {
					$url = trim($url);
					if ($url !== '' && strpos($url, $doublePrefix) === 0) {
						$url = $base . substr($url, strlen($doublePrefix) - 1);
					}
					$fixed[] = $url;
				}
				$product_arr['Product']['msds'] = implode('##', $fixed);
			}
		}
		$this->set('product_arr', $product_arr);			
		/* $subcategory = $this->Subcategory->find('all',array('conditions' => array('Subcategory.category_id'=>$product_arr['Product']['sub_category_id'])));
		$this->set('subcategory',$subcategory); */

		if(!empty($this->request->getData())){

			// Normalize: form may send data[Product][...] or Product[...]
			$data = $this->request->getData();
			$productData = $data['Product'] ?? $data['data']['Product'] ?? [];
			if (is_array($productData)) {
				$this->request = $this->request->withData('Product', $productData);
			}

			$title = (string)($productData['title'] ?? '');
			$cat_slug = str_replace(' ', '-', strtolower($title));
			$cat_slug = str_replace('&', 'and', $cat_slug);
			$this->request = $this->request->withData('Product.slug', $cat_slug);
			$productData['slug'] = $cat_slug;

		//Check if image has been uploaded
		$img = $this->request->getData('Product.image');
		if (!empty($img['name'])) {
		$file = is_array($img) ? $img : $this->request->getData('Product.image');

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
			$h = (int) ceil($height / $ratio);
			$x = (int) round(($w - $width / $ratio) / 2);
			$w = (int) ceil($width / $ratio);
			
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
			$this->request = $this->request->withData('Product.image', $file['name'])->withData('Product.thumb_image', $thumnail_image);
		}else{
			$this->Flash->success('Please upload the valid image extention.','default',array('class' => 'alert alert-danger'));exit;
			return $this->redirect(rtrim(SITEURL, '/') . '/admin/products/edit/' . $id);
		}
		}else{
			if(!empty($product_arr['Product']['image'])){
				$this->request = $this->request->withData('Product.image', $product_arr['Product']['image'])->withData('Product.thumb_image', $product_arr['Product']['thumb_image'] ?? '');
			}else{
				$this->request = $this->request->withData('Product.image', '')->withData('Product.thumb_image', '');
			}
		
		}

		// Handle Colour Chart Image Upload
		$chartImg = $this->request->getData('Product.chart_image');
		if (!empty($chartImg['tmp_name']) && is_array($chartImg)) {
			$file = $chartImg;
			$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
			$allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

			if (in_array($ext, $allowed_ext)) {
				$filename = time() . '_chart_' . preg_replace('/\s+/', '_', $file['name']);
				$uploadPath_chart = WWW_ROOT . 'files' . DS . 'colour_charts' . DS;

				if (!file_exists($uploadPath_chart)) {
					mkdir($uploadPath_chart, 0755, true);
				}

				if (move_uploaded_file($file['tmp_name'], $uploadPath_chart . $filename)) {
					$this->request = $this->request->withData('Product.chart_image', rtrim(SITEURL, '/') . '/files/colour_charts/' . $filename);
				} else {
					$this->request = $this->request->withData('Product.chart_image', $product_arr['Product']['chart_image'] ?? '');
				}
			} else {
				$this->Flash->success('Invalid Chart image extension. Only JPG, PNG, GIF allowed.','default',array('class' => 'alert alert-danger'));
				return $this->redirect(rtrim(SITEURL, '/') . '/admin/products/edit/' . $id);
			}
		} else {
			$this->request = $this->request->withData('Product.chart_image', $product_arr['Product']['chart_image'] ?? '');
		}


		// Handle MSDS upload - replace old with new if files uploaded
			$msdsFiles = $this->request->getData('Product.msds');
			if (!empty($msdsFiles[0]['tmp_name']) && is_array($msdsFiles)) {
				$uploadedMsdsUrls = [];

				foreach ($msdsFiles as $file) {
					if (!empty($file['name'])) {
						$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
						if ($ext === 'pdf') {
							$filename = time() . '_' . preg_replace('/\s+/', '_', $file['name']);
							$uploadDir = WWW_ROOT . 'uploads/msds/';

							// Ensure directory exists
							if (!file_exists($uploadDir)) {
								mkdir($uploadDir, 0755, true);
							}

							$uploadPath = $uploadDir . $filename;

							if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
								$uploadedMsdsUrls[] = rtrim(SITEURL, '/') . '/uploads/msds/' . $filename;
							}
						}
					}
				}

				// If new MSDS files uploaded, replace old with new
				if (!empty($uploadedMsdsUrls)) {
					$this->request = $this->request->withData('Product.msds', implode('##', $uploadedMsdsUrls));
				}
			} else {
				$this->request = $this->request->withData('Product.msds', $product_arr['Product']['msds'] ?? '');
			}


			// Datasheet upload code
				// if (!empty($this->request->getData()['Product']['datasheet']['tmp_name'])) {


                  
				// 	$file = $this->request->getData()['Product']['datasheet'];

				// 	// Validate file extension
				// 	$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

					
				// 	if ($ext === 'pdf') {
				// 		$filename_data = time() . '_' . preg_replace('/\s+/', '_', $file['name']);
				// 		$uploadData = WWW_ROOT . 'files' . DS . 'datasheets' . DS;

				// 		if (!file_exists($uploadData)) {
				// 			mkdir($uploadData, 0755, true);
				// 		}

				// 		$uploadPath_data = $uploadData . $filename_data;

				// 		if (move_uploaded_file($file['tmp_name'], $uploadPath_data)) {
				// 			$this->request->getData()['Product']['datasheet'] = Router::url('/', true) . 'files/datasheets/' . $filename_data;
				// 		} else {
				// 			$this->request->getData()['Product']['datasheet'] = $product_arr['Product']['datasheet'];
				// 			$this->Flash->success('Failed to upload datasheet file.', 'default', ['class' => 'alert alert-danger']);
				// 		}
				// 	} else {
				// 		$this->Flash->success('Only PDF files are allowed for Technical Literature.', 'default', ['class' => 'alert alert-danger']);
				// 		return $this->redirect(['action' => 'edit/' . $id]);
				// 	}
				// } else {
					
				// 	// No new file uploaded, keep existing filename
				// 	$this->request->getData()['Product']['datasheet'] = $product_arr['Product']['datasheet'];
				// }

				// Handle Datasheet upload (Technical Literature)
				$datasheetFile = $this->request->getData('Product.datasheet');
				if (!empty($datasheetFile['tmp_name']) && is_array($datasheetFile)) {
					$file = $datasheetFile;
					$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

					if ($ext === 'pdf') {
						$filename_data = time() . '_' . preg_replace('/\s+/', '_', $file['name']);
						$uploadDir = WWW_ROOT . 'files' . DS . 'datasheets' . DS;

						if (!file_exists($uploadDir)) {
							mkdir($uploadDir, 0755, true);
						}

						$uploadPath = $uploadDir . $filename_data;

						if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
							if (!empty($product_arr['Product']['datasheet'])) {
								$oldFile = str_replace(rtrim(SITEURL, '/') . '/', '', $product_arr['Product']['datasheet']);
								if (file_exists(WWW_ROOT . $oldFile)) {
									unlink(WWW_ROOT . $oldFile);
								}
							}
							$this->request = $this->request->withData('Product.datasheet', rtrim(SITEURL, '/') . '/files/datasheets/' . $filename_data);
						} else {
							$this->Flash->success('Failed to upload datasheet file.', 'default', ['class' => 'alert alert-danger']);
							$this->request = $this->request->withData('Product.datasheet', $product_arr['Product']['datasheet'] ?? '');
						}
					} else {
						$this->Flash->success('Only PDF files are allowed for Technical Literature.', 'default', ['class' => 'alert alert-danger']);
						return $this->redirect(rtrim(SITEURL, '/') . '/admin/products/edit/' . $id);
					}
				} else {
					$this->request = $this->request->withData('Product.datasheet', $product_arr['Product']['datasheet'] ?? '');
				}

				$ds = $this->request->getData('Product.datasheet');
				if (is_array($ds)) {
					$this->request = $this->request->withData('Product.datasheet', $product_arr['Product']['datasheet'] ?? '');
				}


			//voc_pdf sheet code here

			// Handle VOC PDF upload
			$vocFile = $this->request->getData('Product.voc_pdf');
			if (!empty($vocFile['tmp_name']) && is_array($vocFile)) {
				$file = $vocFile;
				$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
				if ($ext === 'pdf') {
					$filename = time() . '_' . preg_replace('/\s+/', '_', $file['name']);
					$uploadPath_voc = WWW_ROOT . 'files' . DS . 'vocsheets' . DS;

					if (!file_exists($uploadPath_voc)) {
						mkdir($uploadPath_voc, 0755, true);
					}

					if (move_uploaded_file($file['tmp_name'], $uploadPath_voc . $filename)) {
						$this->request = $this->request->withData('Product.voc_pdf', rtrim(SITEURL, '/') . '/files/vocsheets/' . $filename);
					}
				}
			} else {
				$this->request = $this->request->withData('Product.voc_pdf', $product_arr['Product']['voc_pdf'] ?? '');
			}

			$saveData = $this->request->getData('Product');
			if ($saveData) {
				$productEntity = $this->Product->get($id);
				$productEntity = $this->Product->patchEntity($productEntity, $saveData);
				if ($this->Product->save($productEntity)) {
					$this->Flash->success('The product has been saved.');
					return $this->redirect(rtrim(SITEURL, '/') . '/admin/products');
				}
			}
			$this->Flash->error('The product could not be saved. Please, try again.');

		}
	}
	
	/** CamelCase action for URL /products/projectdelete/:product_id/:id (POST from Form->postLink) */
	public function projectdelete($product_id = null, $id = null)
	{
		return $this->admin_projectdelete($product_id, $id);
	}

	public function admin_projectdelete($product_id=null,$id = null) {
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Delete');
		$this->checkAdminSession();
		$product_id = (int)$product_id;
		$id = (int)$id;
		$project = $this->Project->get($id);
		if ($this->Project->delete($project)) {
			$this->Flash->success('The project image has been deleted.');
		} else {
			$this->Flash->error('The project image could not be deleted. Please, try again.');
		}
		return $this->redirect(rtrim(SITEURL, '/') . '/admin/products/project/' . $product_id);
	}
	/** CamelCase action for URL /products/delete/:id (POST from Form->postLink) */
	public function delete($id = null)
	{
		return $this->admin_delete($id);
	}

	public function admin_delete($id = null) {
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Delete');
		$this->checkAdminSession();
		$id = (int)$id;
		$product = $this->Product->get($id);
		if ($this->Product->delete($product)) {
			$this->Flash->success('The product has been deleted.');
		} else {
			$this->Flash->error('The product could not be deleted. Please, try again.');
		}
		return $this->redirect(rtrim(SITEURL, '/') . '/admin/products');
	}	
	
	
	
	function addtocard($productcode=null){
		
		$this->autoRender = false;
		
		$product_arr = $this->Product->find('first',array('conditions' => array('Product.product_code'=>$productcode)));
		
		if(!empty($product_arr)){
			$title = $product_arr['Product']['title']; 
			$category_id = $product_arr['Product']['category_id']; 
			$product_id = $product_arr['Product']['id']; 
			$price_dollar = $product_arr['Product']['price_dollar']; 
						
			$cart_session_id = $this->request->getSession()->read('cart_session_id');	
			
			if(empty($cart_session_id)){
				$cart_session_id = strtolower($this->random_password(12));
				$this->request->getSession()->write('cart_session_id',$cart_session_id);		
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
		
		$user_id=$this->request->getSession()->read('Customer.id');	
		$is_staff_id=$this->request->getSession()->read('Customer.is_staff_id');	
		if($is_staff_id == 0){
			$this->viewBuilder()->setLayout('inner_layout');
		}else{
			$this->viewBuilder()->setLayout('staff_inner_layout');
		}	
		#$this->checkCustomerSession();
		$this->checkcommonSession();
		$this->set('title_for_layout',SITENAME.' Product Label List');	
		

		$label = '';
		$label_cate_id = '';
		$conditions = [];
		if ($this->request->getData()) {
			$label = (string)($this->request->getData('label') ?? '');
			$label_cate_id = (string)($this->request->getData('label_cate_id') ?? '');
			if ($label_cate_id !== '' && $label !== '') {
				$conditions = ['Label.label_cate_id' => $label_cate_id, 'Label.name LIKE' => '%' . $label . '%'];
			} elseif ($label_cate_id !== '') {
				$conditions = ['Label.label_cate_id' => $label_cate_id];
			} elseif ($label !== '') {
				$conditions = ['Label.name LIKE' => '%' . $label . '%'];
			}
		}
		$query = $this->Label->find()
			->where($conditions)
			->contain(['LabelCategory'])
			->orderAsc('Label.name');
		$paginated = $this->paginate($query, ['limit' => 150]);
		$labelArr = [];
		foreach ($paginated as $entity) {
			$labelArr[] = [
				'Label' => $entity->toArray(),
				'LabelCategory' => $entity->label_category ? (is_object($entity->label_category) ? $entity->label_category->toArray() : (array)$entity->label_category) : [],
			];
		}
		$this->set('labelArr', $labelArr);
		$this->set('label', $label);
		$this->set('label_cate_id', $label_cate_id);
		$UserPermission = $this->UserPermission->find()
			->where(['UserPermission.permssion_id' => 4, 'UserPermission.user_id' => $user_id])
			->first();
		$this->set('UserPermission', $UserPermission);
		$LabelCategory = $this->LabelCategory->find()->all();
		$labelCategoryList = [];
		foreach ($LabelCategory as $lc) {
			$labelCategoryList[] = ['LabelCategory' => $lc->toArray()];
		}
		$this->set('LabelCategory', $labelCategoryList);	
		
	}
	
	public function permissionrequest(): ?Response
	{
		$this->autoRender = false;

		$customer_id = $this->request->getSession()->read('Customer.id');
		$user = $this->NappUser->find()
			->where(['NappUser.id' => $customer_id])
			->first();

		if (!$user) {
			$this->Flash->error('Please log in to request access.');
			return $this->redirect(['action' => 'label']);
		}

		$to = 'kal@durotechindustries.com.au';
		$subject = SITENAME . ' :: Product label access request.';
		$template_name = 'labelrequest';
		$name = trim(($user->name ?? '') . ' ' . ($user->lname ?? ''));
		$variables = [
			'name' => $name,
			'email' => $user->email ?? '',
			'is_staff' => $user->is_staff_id ?? '',
			'userid' => $user->id ?? '',
		];

		try {
			$this->sendemail($to, $subject, $template_name, $variables);
		} catch (\Exception $e) {
		}
		$this->Flash->success('Your request has been sent.');
		return $this->redirect(['action' => 'label']);
	}	
	
	public function admin_autologin($status=null,$user_id=null) {
		$this->autoRender = false;
		
		$admin_arr = $this->User->find()->orderAsc('User.id')->first();
		if (!empty($admin_arr)) {
			$this->request->getSession()->write('User', $admin_arr->toArray());
			$this->request->getSession()->write('is_admin', 1);
							
			if(isset($status) && ($status == 1)){
				$this->redirect(rtrim(SITEURL, '/') . '/admin/users/permission/'.$user_id);
			}else if(isset($status) && ($status == 0)){
				$this->redirect(rtrim(SITEURL, '/') . '/admin/users/customerpermission/'.$user_id);
			}	
			
		}else{
			$this->Flash->success('Sorry, Sorry you have no access.','default',array('class' => 'alert alert-danger'));
			$this->redirect(rtrim(SITEURL, '/') . '/admin');
		}	
	}

	/** Editable label list page (underscore name to avoid collision with adminEditlabel($id)). */
	public function admin_edit_label(){
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' Product Label List');		
		$this->checkAdminSession(); 
		$label = '';
		$label_cate_id = '';
		$conditions = ['Label.is_edit' => 1];
		if ($this->request->getData()) {
			$label = (string)($this->request->getData('label') ?? '');
			$label_cate_id = (string)($this->request->getData('label_cate_id') ?? '');
			if ($label_cate_id !== '' && $label !== '') {
				$conditions = ['Label.is_edit' => 1, 'Label.label_cate_id' => $label_cate_id, 'Label.name LIKE' => '%' . $label . '%'];
			} elseif ($label_cate_id !== '') {
				$conditions = ['Label.is_edit' => 1, 'Label.label_cate_id' => $label_cate_id];
			} elseif ($label !== '') {
				$conditions = ['Label.is_edit' => 1, 'Label.name LIKE' => '%' . $label . '%'];
			}
		}
		$query = $this->Label->find()
			->where($conditions)
			->contain(['LabelCategory'])
			->orderAsc('Label.name');
		$paginated = $this->paginate($query, ['limit' => 150]);
		$labelArr = [];
		foreach ($paginated as $entity) {
			$labelArr[] = [
				'Label' => $entity->toArray(),
				'LabelCategory' => $entity->label_category ? (is_object($entity->label_category) ? $entity->label_category->toArray() : (array)$entity->label_category) : [],
			];
		}
		$this->set('labelArr', $labelArr);
		$this->set('label', $label);
		$this->set('label_cate_id', $label_cate_id);
		$LabelCategory = $this->LabelCategory->find()->all();
		$labelCategoryList = [];
		foreach ($LabelCategory as $lc) {
			$labelCategoryList[] = ['LabelCategory' => $lc->toArray()];
		}
		$this->set('LabelCategory', $labelCategoryList);
	}	
	
	public function editLabel(){
		
		$user_id=$this->request->getSession()->read('Customer.id');	
		$is_staff_id=$this->request->getSession()->read('Customer.is_staff_id');	
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->checkSatffSession();
		$this->set('title_for_layout',SITENAME.' Product Label List');	
		
		$label = '';
		$label_cate_id = '';
		$conditions = ['Label.is_edit' => 1];
		if ($this->request->getData()) {
			$label = (string)($this->request->getData('label') ?? '');
			$label_cate_id = (string)($this->request->getData('label_cate_id') ?? '');
			if ($label_cate_id !== '' && $label !== '') {
				$conditions = ['Label.is_edit' => 1, 'Label.label_cate_id' => $label_cate_id, 'Label.name LIKE' => '%' . $label . '%'];
			} elseif ($label_cate_id !== '') {
				$conditions = ['Label.is_edit' => 1, 'Label.label_cate_id' => $label_cate_id];
			} elseif ($label !== '') {
				$conditions = ['Label.is_edit' => 1, 'Label.name LIKE' => '%' . $label . '%'];
			}
		}
		$query = $this->Label->find()
			->where($conditions)
			->contain(['LabelCategory'])
			->orderAsc('Label.name');
		$paginated = $this->paginate($query, ['limit' => 150]);
		$labelArr = [];
		foreach ($paginated as $entity) {
			$labelArr[] = [
				'Label' => $entity->toArray(),
				'LabelCategory' => $entity->label_category ? (is_object($entity->label_category) ? $entity->label_category->toArray() : (array)$entity->label_category) : [],
			];
		}
		$this->set('labelArr', $labelArr);
		$this->set('label', $label);
		$this->set('label_cate_id', $label_cate_id);
		$LabelCategory = $this->LabelCategory->find()->all();
		$labelCategoryList = [];
		foreach ($LabelCategory as $lc) {
			$labelCategoryList[] = ['LabelCategory' => $lc->toArray()];
		}
		$this->set('LabelCategory', $labelCategoryList);
	}	
	
	public function demo($slug=null){
		
		$this->viewBuilder()->setLayout('customduro_layout');			
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
?>