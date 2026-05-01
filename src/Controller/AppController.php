<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Mailer\Email;
use Cake\Log\Log;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    /**
     * Set menu categories for layouts/elements. Avoids requestAction which would
     * invoke getMenuCategories() as an action (it returns array, causing "actions can only return Response|null" error).
     */
    public function beforeFilter(EventInterface $event): ?Response
    {
        $result = parent::beforeFilter($event);
        if ($result instanceof Response) {
            return $result;
        }
        try {
            $this->loadModel('Category');
            $categoriesQuery = $this->Category->find()
                ->contain(['Product' => function ($q) {
                    return $q->where(['Product.status' => 1])
                        ->select(['title', 'slug', 'category_id'])
                        ->orderAsc('sort');
                }])
                ->where(['Category.status' => 1])
                ->select(['id', 'category_name', 'slug'])
                ->orderAsc('sort')
                ->limit(16);
            $categories = [];
            foreach ($categoriesQuery as $cat) {
                $products = $cat->product ?? $cat->products ?? [];
                if (is_object($products) && method_exists($products, 'toArray')) {
                    $products = $products->toArray();
                } elseif (!is_array($products)) {
                    $products = [];
                }
                $categories[] = [
                    'Category' => [
                        'category_name' => $cat->category_name ?? '',
                        'slug' => $cat->slug ?? '',
                    ],
                    'Product' => array_map(function ($p) {
                        return [
                            'title' => is_object($p) ? ($p->title ?? '') : ($p['title'] ?? ''),
                            'slug' => is_object($p) ? ($p->slug ?? '') : ($p['slug'] ?? ''),
                        ];
                    }, $products),
                ];
            }
            $this->set('getCategories', $categories);
            $this->set('category', $categories);
        } catch (\Throwable $e) {
            $this->set('getCategories', []);
            $this->set('category', []);
        }
        return null;
    }

    public function checkAdminSession(): ?Response
    {
        // if the admin session hasn't been set
        $session = $this->request->getSession();
        if (!$session->read('is_admin')) {
            // set flash message and redirect
            $this->Flash->error('You need to be logged in to access this area.');
            return $this->redirect(rtrim(SITEURL, '/') . '/admin');
        }
        return null;
    }
	
    //Function 'checkCustomerSession' for admin check in controller
    public function checkcommonSession(): ?Response
    {
        // if the admin session hasn't been set
        $session = $this->request->getSession();
        if (!$session->read('Customer')) {
            // set flash message and redirect
            $this->Flash->error('Sorry, you have no access. Please login with user account.');
            return $this->redirect(rtrim(SITEURL, '/') . '/login');
        }
        return null;
    }
	
    //Function 'checkCustomerSession' for admin check in controller
    public function checkCustomerSession(): ?Response
    {
        // if the admin session hasn't been set
        $session = $this->request->getSession();
        if (!$session->read('is_customer')) {
            // set flash message and redirect
            $this->Flash->error('Sorry, you have no user account access. Please login with user account.');
            return $this->redirect(rtrim(SITEURL, '/') . '/login');
        }
        return null;
    }

    //Function 'checkCustomerSession' for admin check in controller
    public function checkEmployeeSession(): ?Response
    {
        // if the admin session hasn't been set
        $session = $this->request->getSession();
        if (!$session->read('is_employee')) {
            // set flash message and redirect
            $this->Flash->error('Sorry, you have no user account access. Please login with user account.');
            if (($this->request->is('get') || $this->request->is('head'))
                && !$this->request->is('ajax')) {
                $target = $this->request->getRequestTarget();
                if ($this->isSafeEmployeeRedirectUrl($target)
                    && stripos($target, 'spec-draft-autosave') === false) {
                    $session->write('Employee.intended_url', $target);
                }
            }
            return $this->redirect(rtrim(SITEURL, '/') . '/employees/login');
        }
        return null;
    }

    /**
     * Whether a path (request-target) is safe to use after employee login (same-site, /employees/* only).
     */
    protected function isSafeEmployeeRedirectUrl(string $url): bool
    {
        if ($url === '' || $url[0] !== '/') {
            return false;
        }
        if (strpos($url, '//') === 0) {
            return false;
        }
        if (strpos($url, '/employees/') === false) {
            return false;
        }
        if (preg_match('#/employees/(login|register|send_forgot_password)(/|\?|$)#i', $url)) {
            return false;
        }

        return true;
    }

    /**
     * Return stored post-login redirect for employee panel, or default list URL.
     */
    protected function getAndClearEmployeeIntendedUrl(): string
    {
        $session = $this->request->getSession();
        $default = '/employees/monthly_specs';
        $url = (string)$session->read('Employee.intended_url');
        $session->delete('Employee.intended_url');
        if ($url !== '' && $this->isSafeEmployeeRedirectUrl($url)) {
            return $url;
        }

        return $default;
    }

    //Function 'checkStaffession' for admin check in controller
    public function checkSatffSession(): ?Response
    {
        // if the admin session hasn't been set
        $session = $this->request->getSession();
        if (!$session->read('is_staff')) {
            // set flash message and redirect
            $this->Flash->error('Sorry, you have no staff account access. Please login with staff account.');
            return $this->redirect(rtrim(SITEURL, '/') . '/login');
        }
        return null;
    }
	
    public function chkuserpermission(): array
    {
        $session = $this->request->getSession();
        $user_id = $session->read('Customer.id');
        
        $this->loadModel('UserPermission');
        $userArr = $this->UserPermission->find('list', [
            'keyField' => 'id',
            'valueField' => 'permssion_id'
        ])
        ->where(['UserPermission.user_id' => $user_id])
        ->toArray();
        
        return $userArr;
    }	
    public function getproducttype(): array
    {
        $this->loadModel('Product');
        $productArr = $this->Product->find()
            ->where(['Product.status' => 1, 'Product.product_type' => 1])
            ->select(['title', 'slug'])
            ->toArray();
        
        return $productArr;
    }
    public function getproductbyuse(): array
    {
        $this->loadModel('Product');
        $productArr = $this->Product->find()
            ->where(['Product.status' => 1, 'Product.product_type' => 2])
            ->select(['title', 'slug'])
            ->toArray();
        
        return $productArr;
    }
    public function getCartList(): void
    {
        $session = $this->request->getSession();
        $sessionId = $session->read('cart');
        $items_list = [];
        
        if (!empty($sessionId)) {
            $this->loadModel('ShopCart');
            
            $items_list = $this->ShopCart->find()
                ->contain(['Product' => function ($q) {
                    return $q->where(['Product.status' => 1]);
                }])
                ->where(['ShopCart.session_id' => $sessionId])
                ->toArray();
        }
        
        $this->set('sessionItems', $items_list);
    }
    //Function 'callConstants' to define constants (from config table, or fallbacks if table missing)
    public function callConstants(): void
    {
        try {
            $this->loadModel('Config');
            $configs = $this->Config->find()->first();
            if ($configs) {
                foreach ($configs->toArray() as $key => $value) {
                    if (!defined(strtoupper($key))) {
                        define(strtoupper($key), $value);
                    }
                }
            }
        } catch (\Exception $e) {
            // Config table missing or error - fallbacks will be set below
        }
        // Define any constants not set from DB (fallbacks when config table missing or incomplete)
        $this->_defineDefaultConstants();
    }

    /**
     * Define default constants only if not already set (e.g. when config table is missing).
     */
    protected function _defineDefaultConstants(): void
    {
        if (!defined('SITEURL')) {
            define('SITEURL', Router::url('/', true));
        }
        if (!defined('SITENAME')) {
            define('SITENAME', 'Durotech Industries');
        }
        if (!defined('EMAIL')) {
            // define('EMAIL', 'info@durotechindustries.com.au');
            define('EMAIL', 'deepaksaini10036@gmail.com');

        }
        if (!defined('PHONE')) {
            define('PHONE', '');
        }
        if (!defined('ADDRESS')) {
            define('ADDRESS', '');
        }
        if (!defined('FACEBOOK')) {
            define('FACEBOOK', '#');
        }
        if (!defined('TWITER')) {
            define('TWITER', '#');
        }
        if (!defined('GOOGLE_PLUS')) {
            define('GOOGLE_PLUS', '#');
        }
    }
	
	/***
	/*Author  :Ranjit,
	/*Comment :get Categories on menu
	****/
    public function getCategories(): void
    {
        $this->loadModel('Category');
        $categories = $this->Category->find()
            ->where(['Category.status' => 1])
            ->orderAsc('Category.category_name')
            ->toArray();
        $this->set('categories', $categories);
    }
	
	public function getMenuCategories(): array
	{
		// Load the Category model
		$this->loadModel('Category');
	
		// Query categories with their active products
		$categoriesQuery = $this->Category->find()
			->contain(['Product' => function ($q) {
				return $q->where(['Product.status' => 1])
						 ->select(['title', 'slug'])
						 ->orderAsc('sort');
			}])
			->where(['Category.status' => 1])
			->select(['category_name', 'slug'])
			->orderAsc('sort')
			->limit(16);
	
		// Convert results to array (optional: depending on what format you need)
		$categories = [];
		foreach ($categoriesQuery as $cat) {
			$products = $cat->products ?? [];
			if (is_object($products) && method_exists($products, 'toArray')) {
				$products = $products->toArray();
			}
			$categories[] = [
				'Category' => [
					'category_name' => $cat->category_name,
					'slug' => $cat->slug,
				],
				'Product' => array_map(function ($p) {
					return [
						'title' => $p->title,
						'slug' => $p->slug
					];
				}, $products),
			];
		}
	
		return $categories;
	}
	
	
    public function getcarttotal(): int
    {
        $this->loadModel('Cart');
        $session = $this->request->getSession();
        $cart_session_id = $session->read('cart_session_id');
        
        $totalcount = 0;
        if (!empty($cart_session_id)) {
            $totalcount = $this->Cart->find()
                ->where(['Cart.cart_session_id' => $cart_session_id])
                ->count();
        }
        
        return $totalcount;
    }
	
    public function getproduct(): array
    {
        $this->loadModel('Product');
        $ProductArr = $this->Product->find()
            ->where(['Product.status' => 1])
            ->select(['title'])
            ->toArray();
        
        return $ProductArr;
    }	
	
    public function random_password(int $length = 8): string
    {
        //$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        //$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%?";
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }
	
    // send message email to client
    public function sendemail(string $to, string $subject, string $template_name, array $variables): void
    {
        $this->autoRender = false;
        
        try {
            // From must match the SMTP-authenticated mailbox (e.g. Gmail). The EMAIL
            // constant can come from the DB and differ, which causes Gmail to reject or drop mail.
            $fromProfile = Configure::read('Email.default.from');
            $from = '';
            $from_name = defined('SITENAME') ? SITENAME : 'Site';
            if (is_array($fromProfile) && $fromProfile !== []) {
                $keys = array_keys($fromProfile);
                $from = (string)($keys[0] ?? '');
                $named = $from !== '' ? ($fromProfile[$from] ?? '') : '';
                if (is_string($named) && $named !== '') {
                    $from_name = $named;
                }
            } elseif (is_string($fromProfile) && strpos($fromProfile, '@') !== false) {
                $from = $fromProfile;
            }
            if ($from === '') {
                $gmailUser = Configure::read('EmailTransport.gmail.username');
                if (is_string($gmailUser) && strpos($gmailUser, '@') !== false) {
                    $from = $gmailUser;
                }
            }
            if ($from === '') {
                $from = defined('EMAIL') ? (string)EMAIL : 'deepaksaini10036@gmail.com';
            }
            
            $email = new Email('default');
            // Use AppView so email templates use .php extension (e.g. Email/html/coapdf.php)
            $email->viewBuilder()
                ->setClassName('App\View\AppView')
                ->setTemplate($template_name);
            $email->setFrom([$from => $from_name])
                ->setTo($to)
                ->setSubject($subject)
                ->setEmailFormat('html')
                ->setViewVars($variables)
                ->send();
        } catch (\Throwable $e) {
            Log::write('error', 'Email sending failed: ' . $e->getMessage());
            throw $e; // rethrow to trigger catch in calling method
        }
    }

    /**
     * Write one spec audit row (best-effort, never blocks main flow).
     */
    protected function logSpecAudit(array $data): void
    {
        try {
            $this->loadModel('SpecAuditLogs');
            $entity = $this->SpecAuditLogs->newEntity([
                'mailer_id' => isset($data['mailer_id']) ? (int)$data['mailer_id'] : null,
                'tracknumber' => (string)($data['tracknumber'] ?? ''),
                'action' => (string)($data['action'] ?? 'updated'),
                'actor_role' => (string)($data['actor_role'] ?? 'system'),
                'actor_id' => isset($data['actor_id']) ? (int)$data['actor_id'] : null,
                'source' => (string)($data['source'] ?? ''),
                'ip_address' => (string)$this->request->clientIp(),
                'message' => (string)($data['message'] ?? ''),
                'meta_json' => !empty($data['meta']) ? json_encode($data['meta']) : null,
                'created' => date('Y-m-d H:i:s'),
            ]);
            $this->SpecAuditLogs->save($entity);
        } catch (\Throwable $e) {
            Log::warning('Spec audit log write failed: ' . $e->getMessage());
        }
    }
}
