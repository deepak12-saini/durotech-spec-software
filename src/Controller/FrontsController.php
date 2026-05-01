<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Mailer\MailerAwareTrait;

/**
 * FrontsController – CakePHP 3.10
 *
 * Public front-end controller. Action names are camelCase; views are snake_case in templates/Fronts/.
 * Layout: customduro_layout (src/Template/Layout/customduro_layout.ctp).
 */
class FrontsController extends AppController
{
    use MailerAwareTrait;

    /**
     * Initialize: load components and models used by Fronts.
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', ['enableBeforeRedirect' => false]);
        $this->loadComponent('Flash');
        $this->loadComponent('Paginator');

        $this->loadModel('CaseStudies');
        $this->loadModel('Categories');
        $this->loadModel('Products');
        $this->loadModel('Testimonials');
        $this->loadModel('Notifications');
        $this->loadModel('Contact');
        $this->loadModel('Visitor');
        $this->loadModel('QuickSpecs');
        $this->loadModel('MethodStatements');
    }

    /**
     * Before filter – CakePHP 3.10 (EventInterface). Set layout for all actions except captch.
     */
    public function beforeFilter(EventInterface $event): ?Response
    {
        parent::beforeFilter($event);
        $this->callConstants();

        $action = $this->request->getParam('action');
        if ($action === 'captch' || $action === 'quickSpecCaptch' || $action === 'methodStatementCaptch') {
            return null;
        }

        // Admin actions use admin_layout
        if (strpos((string)$action, 'admin') === 0) {
            $this->viewBuilder()->setLayout('admin_layout');
            $this->checkAdminSession();
        } else {
            $this->viewBuilder()->setLayout('customduro_layout');
        }
        return null;
    }

    // -------------------------------------------------------------------------
    // Home & static pages
    // -------------------------------------------------------------------------

    /**
     * Home page. View: Fronts/index.php
     */
    public function index(): ?Response
    {
        $this->viewBuilder()->setLayout('customduro_layout');

        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Home Page');
        $this->set([
            'meta_title' => 'Waterproofing Products & Membranes Australia | Durotech Industries',
            'meta_description' => 'Australian-made waterproofing membranes, coatings & sealants since 1977. For builders, contractors & specifiers. Sydney, Melbourne, Brisbane. Call 02 9603 1177.',
            'meta_keyword' => 'waterproofing membrane, liquid waterproofing, roof waterproofing, terrace waterproofing, sealants, construction chemicals, Australia, Sydney, Melbourne, Durotech',
        ]);

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

        // Home-page testimonials: show published items in display order.
        $homeTestimonials = [];
        $testimonialQuery = $this->Testimonials->find()
            ->where(['Testimonials.status' => 1])
            ->orderAsc('Testimonials.display_order')
            ->orderDesc('Testimonials.id')
            ->limit(6);
        foreach ($testimonialQuery as $entity) {
            $homeTestimonials[] = ['Testimonial' => $entity->toArray()];
        }
        $this->set(compact('homeTestimonials'));
        return null;
    }

    /**
     * Home demo. View: Fronts/index_demo.php
     */
    public function indexDemo(): ?Response
    {
        $this->viewBuilder()->setLayout('customduro_layout');

        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Home Page');
        $this->set([
            'meta_title' => 'Waterproofing Products & Membranes Australia | Durotech Industries',
            'meta_description' => 'Australian-made waterproofing membranes, coatings & sealants since 1977. For builders, contractors & specifiers. Sydney, Melbourne, Brisbane. Call 02 9603 1177.',
            'meta_keyword' => 'waterproofing membrane, liquid waterproofing, roof waterproofing, terrace waterproofing, sealants, construction chemicals, Australia, Sydney, Melbourne, Durotech',
        ]);
        return null;
    }

    /**
     * About. View: Fronts/about.php
     */
    public function about(): ?Response
    {
        $this->viewBuilder()->setLayout('customduro_layout');
        $this->set([
            'meta_title' => 'About Durotech | Australian Waterproofing & Construction Chemicals Manufacturer',
            'meta_description' => 'Durotech Industries — Australian-made waterproofing membranes, coatings & sealants since 1977. For builders, contractors & specifiers.',
            'meta_keyword' => 'Durotech, Australian manufacturer, waterproofing, construction chemicals, membranes, sealants',
        ]);
        return null;
    }

    /**
     * Projects (case study list). View: Fronts/projects.php
     */
    public function projects(): ?Response
    {
        $this->viewBuilder()->setLayout('customduro_layout');

        $this->set([
            'meta_title' => 'Waterproofing Projects & Case Studies | Durotech Australia',
            'meta_description' => 'See how Durotech waterproofing membranes and coatings are used in real projects across Australia. Case studies for specifiers and contractors.',
            'meta_keyword' => 'waterproofing projects, case studies, Durotech, membranes, coatings, Australia',
        ]);

        $query = $this->CaseStudies->find()
            ->orderDesc('CaseStudies.id');
        $projects = [];
        foreach ($query as $entity) {
            $projects[] = ['CaseStudy' => $entity->toArray()];
        }
        $this->set(compact('projects'));
        return null;
    }

    /**
     * Single case study by slug. View: Fronts/case_study.php
     */
    public function caseStudy(?string $slug = null): ?Response
    {
        $this->viewBuilder()->setLayout('customduro_layout');

        if (!$slug) {
            throw new \Cake\Http\Exception\NotFoundException(__('Invalid case study'));
        }

        $caseStudy = $this->CaseStudies->find()
            ->where(['CaseStudies.slug' => $slug])
            ->contain(['CaseImages'])
            ->first();

        if (!$caseStudy) {
            throw new \Cake\Http\Exception\NotFoundException(__('Case study not found'));
        }

        $caseArray = $caseStudy->toArray();
        $case = [
            'CaseStudy' => $caseArray,
            'CaseImage' => [],
        ];
        if (!empty($caseStudy->case_images)) {
            foreach ($caseStudy->case_images as $img) {
                $case['CaseImage'][] = $img->toArray();
            }
        }

        $this->set([
            'meta_title' => ($caseArray['title'] ?? '') . ' | Durotech Industries',
            'meta_description' => mb_substr(strip_tags($caseArray['short_summary'] ?? ''), 0, 150),
            'meta_keyword' => 'waterproofing, project, case study, durotech',
        ]);
        $this->set(compact('case'));
        return null;
    }

    /**
     * Terrace waterproofing. View: Fronts/terrace_waterproofing.php
     */
    public function terraceWaterproofing(): ?Response
    {
        $this->set([
            'meta_title' => 'Terrace & Balcony Waterproofing | Roof Waterproofing Australia | Durotech',
            'meta_description' => 'Terrace and balcony waterproofing with solvent-based PU and acrylic systems. New build and remedial. Australia. Products & specs. 02 9603 1177.',
            'meta_keyword' => 'terrace waterproofing, balcony waterproofing, roof waterproofing, polyurethane, acrylic, remedial, Australia',
        ]);
        return null;
    }

    /**
     * Retaining walls. View: Fronts/retaining_walls.php
     */
    public function retainingWalls(): ?Response
    {
        $this->set([
            'meta_title' => 'Retaining Wall Waterproofing | Below Ground Waterproofing Australia | Durotech',
            'meta_description' => 'Waterproofing for retaining walls and below-ground structures. Avoid costly water damage. Australian solutions. Products & technical support. 02 9603 1177.',
            'meta_keyword' => 'retaining wall waterproofing, below ground waterproofing, basement, tanking, Australia',
        ]);
        return null;
    }

    /**
     * Technical literature (optional segment). View: Fronts/technical_literature_new.php
     */
    public function technicalLiteratureNew(): ?Response
    {
        $pass = (array)$this->request->getParam('pass', []);
        $page = $pass[0] ?? null;

        $this->set([
            'meta_title' => (defined('SITENAME') ? SITENAME : 'Durotech') . ($page ? ' | ' . ucfirst((string)$page) : ' | Technical Literature'),
            'meta_description' => '',
            'meta_keyword' => 'Technical Literature',
        ]);

        $product = [];
        // Only active categories and active products (same as Products menu)
        $categories = $this->Categories->find()
            ->contain(['Products' => function ($q) {
                return $q->where(['Products.status' => 1])->orderAsc('Products.sort');
            }])
            ->where(['Categories.status' => 1])
            ->orderAsc('Categories.sort');

        foreach ($categories as $cat) {
            $products = $cat->products ?? [];
            // Skip categories with no active products
            if (count($products) === 0) {
                continue;
            }
            $product[] = [
                'Category' => $cat->toArray(),
                'Product' => array_map(function ($p) {
                    return $p->toArray();
                }, $products),
            ];
        }

        $this->set(compact('product', 'page'));
        return null;
    }

    /**
     * DuroOEM. View: Fronts/durooem.php
     */
    public function durooem(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | DuroOEM',
            'meta_title' => 'DuroOEM | Custom Manufacturing | Durotech',
            'meta_description' => 'Custom and OEM construction chemicals and waterproofing. Australian manufacturer. Enquire for formulations.',
            'meta_keyword' => 'DuroOEM, custom manufacturing, OEM waterproofing, construction chemicals',
        ]);
        return null;
    }

    /**
     * DuroLab. View: Fronts/durolab.php
     */
    public function durolab(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Duro Lab',
            'meta_title' => 'Duro Lab',
            'meta_description' => 'After establishing in 1977 Durotech is now just over 45 years old making Durotech one of the Original Australian Made and Owned manufactures of construction chemicals.',
            'meta_keyword' => '',
        ]);
        return null;
    }

    /**
     * Flake. View: Fronts/flake.php
     */
    public function flake(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Duro Flake',
            'meta_title' => 'Duro Flake | Decorative Flake Flooring | Durotech',
            'meta_description' => 'Decorative flake flooring systems for commercial and industrial floors. Australian-made.',
            'meta_keyword' => 'Duro Flake, flake flooring, decorative flooring, industrial floor',
        ]);
        return null;
    }

    /**
     * Specification. View: Fronts/specification.php
     */
    public function specification(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Specification',
            'meta_title' => 'Specifiers | Waterproofing Specification & CPD | Durotech',
            'meta_description' => 'Natspec & Architects Australia partner. National specifications and CPD for waterproofing. For architects and specifiers.',
            'meta_keyword' => 'specifiers, waterproofing specification, Natspec, CPD, architects, Durotech',
        ]);
        return null;
    }

    /**
     * Institute waterproofing. View: Fronts/institute_waterproofing.php
     */
    public function instituteWaterproofing(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Durotech Institute Waterproofing',
            'meta_title' => 'Durotech Institute of Waterproofing | Training | Durotech',
            'meta_description' => 'Training and education in waterproofing for contractors and specifiers.',
            'meta_keyword' => 'Durotech Institute Waterproofing, waterproofing training, contractor training',
        ]);
        return null;
    }

    /**
     * Video. View: Fronts/video.php
     */
    public function video(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Project Videos',
            'meta_title' => 'Project Videos | Durotech Waterproofing Projects',
            'meta_description' => 'Watch Durotech waterproofing and coating projects across Australia.',
            'meta_keyword' => 'Durotech video, waterproofing projects, case study video',
        ]);
        return null;
    }

    /**
     * FAQ. View: Fronts/faq.php
     */
    public function faq(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Durotech Faq',
            'meta_title' => 'Waterproofing Solutions FAQs | Durotech Australia',
            'meta_description' => 'Common questions about waterproofing membranes, products and applications. For builders, contractors and specifiers.',
            'meta_keyword' => 'waterproofing FAQ, waterproofing solutions, membranes, products, Australia',
        ]);
        return null;
    }

    /**
     * Competitor product. View: Fronts/competitor_product.php
     */
    public function competitorProduct(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Competitor Products',
            'meta_title' => 'Competitor Product',
            'meta_description' => 'Get detailed information about queries related to waterproofing solutions and waterproofing products in our FAQs section.',
            'meta_keyword' => 'Waterproofing Solutions Faq',
        ]);
        return null;
    }

    /**
     * FAQ new. View: Fronts/faq_new.php
     */
    public function faqNew(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Durotech Faq',
            'meta_title' => 'Waterproofing Solutions FAQs | Durotech Australia',
            'meta_description' => 'Common questions about waterproofing membranes, products and applications. For builders, contractors and specifiers.',
            'meta_keyword' => 'waterproofing FAQ, waterproofing solutions, membranes, products, Australia',
        ]);
        return null;
    }

    /**
     * Distribution. View: Fronts/distribution.php
     */
    public function distribution(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Distribution List',
            'meta_title' => 'Durotech Distribution List',
            'meta_description' => 'Durotech Distribution List',
            'meta_keyword' => '',
        ]);
        return null;
    }

    /**
     * Health & safety. View: Fronts/health_safety.php
     */
    public function healthSafety(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' Safety and Health Topics | Sealant, Waterproofing, Epoxy',
            'meta_title' => ' Safety and Health Topics | Sealant, Waterproofing, Epoxy ',
            'meta_description' => 'Safety and Health Topics | Sealant, Waterproofing, Epoxy , Covid-19 ',
            'meta_keyword' => 'health safety and environment , health safety representative ,Covid-19',
        ]);
        return null;
    }

    /**
     * Test. View: Fronts/test.php
     */
    public function test(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' Safety and Health Topics | Sealant, Waterproofing, Epoxy',
            'meta_title' => ' Safety and Health Topics | Sealant, Waterproofing, Epoxy ',
            'meta_description' => 'Safety and Health Topics | Sealant, Waterproofing, Epoxy , Covid-19 ',
            'meta_keyword' => 'health safety and environment , health safety representative ,Covid-19',
        ]);
        return null;
    }

    /**
     * Testimonials. View: Fronts/testimonials.php
     */
    public function testimonials(): ?Response
    {
        $this->set([
            'meta_title' => 'Customer Testimonials | Durotech Industries',
            'meta_description' => 'Read what our clients say about Durotech Industries waterproofing products and services across Australia.',
            'meta_keyword' => 'Durotech reviews, waterproofing testimonials, customer feedback, product experience',
        ]);

        $results = $this->Testimonials->find()
            ->orderDesc('Testimonials.id');
        $testimonials = [];
        foreach ($results as $entity) {
            $testimonials[] = ['Testimonial' => $entity->toArray()];
        }
        $this->set(compact('testimonials'));
        return null;
    }

    /**
     * New lead (TMC). View: Fronts/newlead.php
     */
    public function newlead(): ?Response
    {
        $this->viewBuilder()->setLayout('customduro_layout');
        return null;
    }

    // -------------------------------------------------------------------------
    // Contact & captcha
    // -------------------------------------------------------------------------

    /**
     * Contact page. GET: show form + set cap_code. POST: validate, send email.
     * View: Fronts/contact.php
     */
    public function contact(): ?Response
    {
        $this->set([
            'meta_title' => 'Contact Durotech | Waterproofing Products & Specification Enquiries',
            'meta_description' => 'Contact Durotech for waterproofing products, specifications and technical support. Sydney-based, Australia-wide. Enquire online or call 02 9603 1177.',
            'meta_keyword' => 'contact Durotech, waterproofing enquiry, specification, technical support, Sydney, Australia',
        ]);

        if (!$this->request->is('post')) {
            $code = (string)rand(10000, 99999);
            $this->request->getSession()->write('cap_code', $code);
            $this->request->getSession()->write('contact_form_started_at', time());
            $this->set('cap_code', $code);
            return null;
        }

        $data = $this->request->getData();
        $session = $this->request->getSession();
        $capCode = $session->read('cap_code');
        $userCap = $data['captcha'] ?? '';
        $honeypot = trim((string)($data['website'] ?? ''));
        $startedAt = (int)$session->read('contact_form_started_at');
        $elapsed = time() - $startedAt;
        $ip = (string)($this->request->clientIp() ?? 'unknown');

        // Spam bots usually fill hidden fields.
        if ($honeypot !== '') {
            Log::warning('Contact spam blocked by honeypot: ' . $ip);
            $this->Flash->error(__('Unable to submit form. Please try again.'));
            return $this->redirect(['action' => 'contact']);
        }

        // Bots often submit instantly; humans need a few seconds.
        if ($startedAt <= 0 || $elapsed < 3) {
            Log::warning('Contact spam blocked by timing check: ' . $ip);
            $this->Flash->error(__('Please wait a few seconds and try again.'));
            return $this->redirect(['action' => 'contact']);
        }

        // Basic IP rate-limit: max 3 submissions per 10 minutes.
        $rateKey = 'contact_rate_' . sha1($ip);
        $bucket = Cache::read($rateKey, 'default');
        if (!is_array($bucket)) {
            $bucket = [];
        }
        $nowTs = time();
        $bucket = array_values(array_filter($bucket, function ($ts) use ($nowTs) {
            return ($nowTs - (int)$ts) < 600;
        }));
        if (count($bucket) >= 3) {
            Log::warning('Contact spam blocked by rate-limit: ' . $ip);
            $this->Flash->error(__('Too many submissions. Please try again later.'));
            return $this->redirect(['action' => 'contact']);
        }
        $bucket[] = $nowTs;
        Cache::write($rateKey, $bucket, 'default');

        if (empty($capCode) || (string)$userCap !== (string)$capCode) {
            $this->Flash->error(__('Wrong captcha code. Please try again.'));
            $session->write('cap_code', (string)rand(10000, 99999));
            return null;
        }

        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $message = trim($data['message'] ?? '');
        $normalizedMessage = html_entity_decode((string)$message, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $normalizedMessage = trim($normalizedMessage);

        if ($name === '' || $email === '' || $phone === '' || $message === '') {
            $this->Flash->error(__('Please fill in all fields.'));
            return null;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->Flash->error(__('Please enter a valid email address.'));
            return null;
        }
        if (!preg_match('/^[0-9\-\+\(\)\s]{7,20}$/', $phone)) {
            $this->Flash->error(__('Please enter a valid phone number.'));
            return null;
        }
        if (mb_strlen($normalizedMessage) < 10 || mb_strlen($normalizedMessage) > 2000) {
            $this->Flash->error(__('Message must be between 10 and 2000 characters.'));
            return null;
        }
        // Reject HTML/anchor injection and URL-like content in the message body.
        if (preg_match('/<[^>]+>|href\s*=|https?:\/\/|www\.|(?:\b[a-z0-9-]+\.)+(?:ru|cn|tk|pw|xyz)\b/i', $normalizedMessage)) {
            $this->Flash->error(__('Links/HTML are not allowed in message.'));
            return null;
        }
        // Reject embedded email addresses inside the message body (common spam pattern).
        if (preg_match('/[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}/i', $normalizedMessage)) {
            $this->Flash->error(__('Please remove email addresses from message body.'));
            return null;
        }

        try {
            $now = date('Y-m-d H:i:s');
            $contactEntity = $this->Contact->newEntity([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'message' => $normalizedMessage,
                'created' => $now,
            ]);
            if (!$this->Contact->save($contactEntity)) {
                Log::error('Contact form DB save failed: ' . json_encode($contactEntity->getErrors()));
                $this->Flash->error(__('Could not save your message. Please try again later.'));

                return null;
            }
            $mailData = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'message' => $normalizedMessage,
            ];
            $this->getMailer('Contact')->send('contactForm', [$mailData]);
            $session->delete('cap_code');
            $session->delete('contact_form_started_at');
            $this->Flash->success(__('Your message has been sent successfully.'));
            return $this->redirect(['action' => 'contact']);
        } catch (\Throwable $e) {
            Log::error('Contact form failed: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            $this->Flash->error(__('Sorry, we could not send your message. Please try again later.'));
        }
        return null;
    }

    /**
     * Public Quick Spec request form. GET: form + captcha. POST: validate, save, email team + acknowledgement.
     * Views: Fronts/quick_spec.php, Fronts/quick_spec_thanks.php
     */
    public function quickSpec(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Quick Spec Request',
            'meta_title' => 'Quick Spec Request | Technical Literature | Durotech',
            'meta_description' => 'Request a quick waterproofing specification from Durotech. Project details and contact information.',
            'meta_keyword' => 'quick spec, waterproofing specification, Durotech, technical literature',
        ]);

        if (!$this->request->is('post')) {
            $code = (string)rand(10000, 99999);
            $session = $this->request->getSession();
            $session->write('qs_cap_code', $code);
            $session->write('qs_started_at', time());
            $this->refreshQuickSpecFormView();

            return null;
        }

        $data = $this->request->getData();
        $session = $this->request->getSession();
        $capStored = $session->read('qs_cap_code');
        $userCap = $data['captcha'] ?? '';
        $honeypot = trim((string)($data['website'] ?? ''));
        $startedAt = (int)$session->read('qs_started_at');
        $elapsed = time() - $startedAt;
        $ip = (string)($this->request->clientIp() ?? 'unknown');

        if ($honeypot !== '') {
            Log::warning('Quick Spec spam blocked by honeypot: ' . $ip);
            $this->Flash->error(__('Unable to submit form. Please try again.'));
            return $this->redirect(['action' => 'quickSpec']);
        }

        if ($startedAt <= 0 || $elapsed < 3) {
            Log::warning('Quick Spec spam blocked by timing check: ' . $ip);
            $this->Flash->error(__('Please wait a few seconds and try again.'));
            return $this->redirect(['action' => 'quickSpec']);
        }

        $rateKey = 'quickspec_rate_' . sha1($ip);
        $bucket = Cache::read($rateKey, 'default');
        if (!is_array($bucket)) {
            $bucket = [];
        }
        $nowTs = time();
        $bucket = array_values(array_filter($bucket, function ($ts) use ($nowTs) {
            return ($nowTs - (int)$ts) < 600;
        }));
        if (count($bucket) >= 3) {
            Log::warning('Quick Spec spam blocked by rate-limit: ' . $ip);
            $this->Flash->error(__('Too many submissions. Please try again later.'));
            return $this->redirect(['action' => 'quickSpec']);
        }
        $bucket[] = $nowTs;
        Cache::write($rateKey, $bucket, 'default');

        if (empty($capStored) || (string)$userCap !== (string)$capStored) {
            $this->Flash->error(__('Wrong captcha code. Please try again.'));
            $session->write('qs_cap_code', (string)rand(10000, 99999));
            $this->refreshQuickSpecFormView();

            return null;
        }

        $projectName = trim((string)($data['project_name'] ?? ''));
        $projectType = trim((string)($data['project_type'] ?? ''));
        $area = trim((string)($data['area'] ?? ''));
        $systemInterest = trim((string)($data['system_interest'] ?? ''));
        $quantityOrSize = trim((string)($data['quantity_or_size'] ?? ''));
        $name = trim((string)($data['name'] ?? ''));
        $email = trim((string)($data['email'] ?? ''));
        $phone = trim((string)($data['phone'] ?? ''));
        $company = trim((string)($data['company'] ?? ''));
        $state = trim((string)($data['state'] ?? ''));
        $notes = trim((string)($data['notes'] ?? ''));

        if ($projectName === '' || $projectType === '' || $area === '' || $name === '' || $email === '' || $phone === '') {
            $this->Flash->error(__('Please fill in all required fields.'));
            $this->refreshQuickSpecFormView();

            return null;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->Flash->error(__('Please enter a valid email address.'));
            $this->refreshQuickSpecFormView();

            return null;
        }
        if (!preg_match('/^[0-9\-\+\(\)\s]{7,20}$/', $phone)) {
            $this->Flash->error(__('Please enter a valid phone number.'));
            $this->refreshQuickSpecFormView();

            return null;
        }
        if ($notes !== '') {
            $notesDecoded = html_entity_decode($notes, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $notesDecoded = trim($notesDecoded);
            if (mb_strlen($notesDecoded) > 2000) {
                $this->Flash->error(__('Notes must be at most 2000 characters.'));
                $this->refreshQuickSpecFormView();

                return null;
            }
            $notes = $notesDecoded;
        }

        $entity = $this->QuickSpecs->newEntity([
            'project_name' => $projectName,
            'project_type' => $projectType,
            'area' => $area,
            'system_interest' => $systemInterest,
            'quantity_or_size' => $quantityOrSize,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'state' => $state,
            'notes' => $notes !== '' ? $notes : null,
            'status' => 'new',
            'ip_address' => $ip,
            'user_agent' => substr((string)$this->request->getHeaderLine('User-Agent'), 0, 512),
        ]);

        if (!$this->QuickSpecs->save($entity)) {
            Log::error('Quick Spec save failed: ' . json_encode($entity->getErrors()));
            $this->Flash->error(__('Could not save your request. Please check the form and try again.'));
            $this->refreshQuickSpecFormView();

            return null;
        }

        $emailFail = false;
        $id = (int)$entity->id;
        $adminViewUrl = \Cake\Routing\Router::url(['controller' => 'QuickSpecs', 'action' => 'admin_view', $id], true);
        $internalRecipients = $this->collectQuickSpecInternalRecipients();
        $site = defined('SITENAME') ? SITENAME : 'Durotech';

        $mailVars = [
            'id' => $id,
            'project_name' => $projectName,
            'project_type' => $projectType,
            'area' => $area,
            'system_interest' => $systemInterest,
            'quantity_or_size' => $quantityOrSize,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'state' => $state,
            'notes' => $notes,
            'admin_view_url' => $adminViewUrl,
            'site_name' => $site,
        ];

        if (!empty($internalRecipients)) {
            try {
                $this->sendemail(
                    $internalRecipients,
                    $site . ' — Quick Spec request #' . $id,
                    'quick_spec_internal',
                    $mailVars
                );
            } catch (\Throwable $e) {
                $emailFail = true;
                Log::error('Quick Spec internal email failed: ' . $e->getMessage());
            }
        } else {
            $emailFail = true;
            Log::warning('Quick Spec: no internal recipients from SpecEmail config.');
        }

        try {
            $this->sendemail(
                $email,
                'We received your Quick Spec request | ' . $site,
                'quick_spec_ack',
                $mailVars
            );
        } catch (\Throwable $e) {
            $emailFail = true;
            Log::error('Quick Spec acknowledgement email failed: ' . $e->getMessage());
        }

        $session->delete('qs_cap_code');
        $session->delete('qs_started_at');

        if ($emailFail) {
            $this->Flash->warning(__('Your request was saved. If you do not hear from us soon, please call Durotech.'));
        } else {
            $this->Flash->success(__('Thank you. Your Quick Spec request has been submitted.'));
        }

        return $this->redirect(['action' => 'quickSpecThanks']);
    }

    /**
     * Thank-you page after Quick Spec submission.
     */
    public function quickSpecThanks(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Quick Spec Received',
            'meta_title' => 'Quick Spec Received | Durotech',
            'meta_description' => 'Thank you for your specification request.',
            'meta_keyword' => 'quick spec, Durotech',
        ]);

        return null;
    }

    /**
     * Product dropdown + captcha display value when re-rendering the Quick Spec form.
     */
    private function refreshQuickSpecFormView(): void
    {
        $productOptions = $this->Products->find()
            ->select(['Products.id', 'Products.title'])
            ->where(['Products.status' => 1])
            ->orderAsc('Products.title')
            ->all();
        $this->set(compact('productOptions'));
        $this->set('qs_cap_code', $this->request->getSession()->read('qs_cap_code'));
    }

    /**
     * Collect SpecEmail to/cc/bcc addresses for Quick Spec notifications.
     *
     * @return string[]
     */
    protected function collectQuickSpecInternalRecipients(): array
    {
        $cfg = (array)Configure::read('SpecEmail');
        $seen = [];
        foreach (['to', 'cc', 'bcc'] as $blockKey) {
            $block = $cfg[$blockKey] ?? [];
            if (!is_array($block)) {
                continue;
            }
            foreach ($block as $key => $val) {
                if (is_string($key) && filter_var($key, FILTER_VALIDATE_EMAIL)) {
                    $seen[$key] = true;
                }
                if (is_int($key) && is_string($val) && filter_var($val, FILTER_VALIDATE_EMAIL)) {
                    $seen[$val] = true;
                }
            }
        }

        return array_keys($seen);
    }

    /**
     * Captcha image for Quick Spec form. Session key: qs_cap_code.
     */
    public function quickSpecCaptch(): Response
    {
        $this->viewBuilder()->setLayout(false);
        $session = $this->request->getSession();
        $code = $session->read('qs_cap_code');
        if ($code === null || $code === '') {
            $code = (string)rand(10000, 99999);
            $session->write('qs_cap_code', $code);
        }

        $width = 80;
        $height = 30;
        $image = imagecreatetruecolor($width, $height);
        if ($image === false) {
            return $this->response->withStatus(500);
        }
        $bg = imagecolorallocate($image, 240, 240, 240);
        $text = imagecolorallocate($image, 0, 0, 0);
        imagefill($image, 0, 0, $bg);
        imagestring($image, 5, 10, 8, (string)$code, $text);

        ob_start();
        imagepng($image);
        $png = ob_get_clean();
        imagedestroy($image);

        return $this->response
            ->withType('image/png')
            ->withStringBody($png === false ? '' : $png);
    }

    /**
     * Public Method Statement request form. GET: form + captcha. POST: validate, save, email team + acknowledgement.
     * Views: Fronts/method_statement.php, Fronts/method_statement_thanks.php
     */
    public function methodStatement(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Method Statement Request',
            'meta_title' => 'Method Statement Request | Technical Literature | Durotech',
            'meta_description' => 'Request a method statement from Durotech. Project scope and contact details.',
            'meta_keyword' => 'method statement, waterproofing, Durotech, technical literature',
        ]);

        if (!$this->request->is('post')) {
            $session = $this->request->getSession();
            $session->write('ms_cap_code', (string)rand(10000, 99999));
            $session->write('ms_started_at', time());
            $this->refreshMethodStatementFormView();

            return null;
        }

        $data = $this->request->getData();
        $session = $this->request->getSession();
        $capStored = $session->read('ms_cap_code');
        $userCap = $data['captcha'] ?? '';
        $honeypot = trim((string)($data['website'] ?? ''));
        $startedAt = (int)$session->read('ms_started_at');
        $elapsed = time() - $startedAt;
        $ip = (string)($this->request->clientIp() ?? 'unknown');

        if ($honeypot !== '') {
            Log::warning('Method Statement spam blocked by honeypot: ' . $ip);
            $this->Flash->error(__('Unable to submit form. Please try again.'));
            return $this->redirect(['action' => 'methodStatement']);
        }

        if ($startedAt <= 0 || $elapsed < 3) {
            Log::warning('Method Statement spam blocked by timing check: ' . $ip);
            $this->Flash->error(__('Please wait a few seconds and try again.'));
            return $this->redirect(['action' => 'methodStatement']);
        }

        $rateKey = 'methodstmt_rate_' . sha1($ip);
        $bucket = Cache::read($rateKey, 'default');
        if (!is_array($bucket)) {
            $bucket = [];
        }
        $nowTs = time();
        $bucket = array_values(array_filter($bucket, function ($ts) use ($nowTs) {
            return ($nowTs - (int)$ts) < 600;
        }));
        if (count($bucket) >= 3) {
            Log::warning('Method Statement spam blocked by rate-limit: ' . $ip);
            $this->Flash->error(__('Too many submissions. Please try again later.'));
            return $this->redirect(['action' => 'methodStatement']);
        }
        $bucket[] = $nowTs;
        Cache::write($rateKey, $bucket, 'default');

        if (empty($capStored) || (string)$userCap !== (string)$capStored) {
            $this->Flash->error(__('Wrong captcha code. Please try again.'));
            $session->write('ms_cap_code', (string)rand(10000, 99999));
            $this->refreshMethodStatementFormView();

            return null;
        }

        $projectName = trim((string)($data['project_name'] ?? ''));
        $projectType = trim((string)($data['project_type'] ?? ''));
        $area = trim((string)($data['area'] ?? ''));
        $scopeOfWork = trim((string)($data['scope_of_work'] ?? ''));
        $systemUsed = trim((string)($data['system_used'] ?? ''));
        $substrate = trim((string)($data['substrate'] ?? ''));
        $projectAddress = trim((string)($data['project_address'] ?? ''));
        $startDate = trim((string)($data['start_date'] ?? ''));
        $name = trim((string)($data['name'] ?? ''));
        $email = trim((string)($data['email'] ?? ''));
        $phone = trim((string)($data['phone'] ?? ''));
        $company = trim((string)($data['company'] ?? ''));
        $state = trim((string)($data['state'] ?? ''));
        $notes = trim((string)($data['notes'] ?? ''));

        if ($projectName === '' || $projectType === '' || $area === '' || $scopeOfWork === '' || $name === '' || $email === '' || $phone === '') {
            $this->Flash->error(__('Please fill in all required fields.'));
            $this->refreshMethodStatementFormView();

            return null;
        }
        if (mb_strlen($scopeOfWork) > 5000) {
            $this->Flash->error(__('Scope of work must be at most 5000 characters.'));
            $this->refreshMethodStatementFormView();

            return null;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->Flash->error(__('Please enter a valid email address.'));
            $this->refreshMethodStatementFormView();

            return null;
        }
        if (!preg_match('/^[0-9\-\+\(\)\s]{7,20}$/', $phone)) {
            $this->Flash->error(__('Please enter a valid phone number.'));
            $this->refreshMethodStatementFormView();

            return null;
        }
        if ($notes !== '') {
            $notesDecoded = html_entity_decode($notes, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $notesDecoded = trim($notesDecoded);
            if (mb_strlen($notesDecoded) > 2000) {
                $this->Flash->error(__('Notes must be at most 2000 characters.'));
                $this->refreshMethodStatementFormView();

                return null;
            }
            $notes = $notesDecoded;
        }

        $entity = $this->MethodStatements->newEntity([
            'project_name' => $projectName,
            'project_type' => $projectType,
            'area' => $area,
            'scope_of_work' => $scopeOfWork,
            'system_used' => $systemUsed,
            'substrate' => $substrate,
            'project_address' => $projectAddress,
            'start_date' => $startDate,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'state' => $state,
            'notes' => $notes !== '' ? $notes : null,
            'status' => 'new',
            'ip_address' => $ip,
            'user_agent' => substr((string)$this->request->getHeaderLine('User-Agent'), 0, 512),
        ]);

        if (!$this->MethodStatements->save($entity)) {
            Log::error('Method Statement save failed: ' . json_encode($entity->getErrors()));
            $this->Flash->error(__('Could not save your request. Please check the form and try again.'));
            $this->refreshMethodStatementFormView();

            return null;
        }

        $emailFail = false;
        $id = (int)$entity->id;
        $adminViewUrl = \Cake\Routing\Router::url(['controller' => 'MethodStatements', 'action' => 'admin_view', $id], true);
        $internalRecipients = $this->collectQuickSpecInternalRecipients();
        $site = defined('SITENAME') ? SITENAME : 'Durotech';

        $mailVars = [
            'id' => $id,
            'project_name' => $projectName,
            'project_type' => $projectType,
            'area' => $area,
            'scope_of_work' => $scopeOfWork,
            'system_used' => $systemUsed,
            'substrate' => $substrate,
            'project_address' => $projectAddress,
            'start_date' => $startDate,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'state' => $state,
            'notes' => $notes,
            'admin_view_url' => $adminViewUrl,
            'site_name' => $site,
        ];

        if (!empty($internalRecipients)) {
            try {
                $this->sendemail(
                    $internalRecipients,
                    $site . ' — Method Statement request #' . $id,
                    'method_statement_internal',
                    $mailVars
                );
            } catch (\Throwable $e) {
                $emailFail = true;
                Log::error('Method Statement internal email failed: ' . $e->getMessage());
            }
        } else {
            $emailFail = true;
            Log::warning('Method Statement: no internal recipients from SpecEmail config.');
        }

        try {
            $this->sendemail(
                $email,
                'We received your Method Statement request | ' . $site,
                'method_statement_ack',
                $mailVars
            );
        } catch (\Throwable $e) {
            $emailFail = true;
            Log::error('Method Statement acknowledgement email failed: ' . $e->getMessage());
        }

        $session->delete('ms_cap_code');
        $session->delete('ms_started_at');

        if ($emailFail) {
            $this->Flash->warning(__('Your request was saved. If you do not hear from us soon, please call Durotech.'));
        } else {
            $this->Flash->success(__('Thank you. Your Method Statement request has been submitted.'));
        }

        return $this->redirect(['action' => 'methodStatementThanks']);
    }

    /**
     * Thank-you page after Method Statement submission.
     */
    public function methodStatementThanks(): ?Response
    {
        $this->set([
            'title_for_layout' => (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Method Statement Received',
            'meta_title' => 'Method Statement Received | Durotech',
            'meta_description' => 'Thank you for your method statement request.',
            'meta_keyword' => 'method statement, Durotech',
        ]);

        return null;
    }

    /**
     * Product dropdown + captcha when re-rendering the Method Statement form.
     */
    private function refreshMethodStatementFormView(): void
    {
        $productOptions = $this->Products->find()
            ->select(['Products.id', 'Products.title'])
            ->where(['Products.status' => 1])
            ->orderAsc('Products.title')
            ->all();
        $this->set(compact('productOptions'));
        $this->set('ms_cap_code', $this->request->getSession()->read('ms_cap_code'));
    }

    /**
     * Captcha image for Method Statement form. Session key: ms_cap_code.
     */
    public function methodStatementCaptch(): Response
    {
        $this->viewBuilder()->setLayout(false);
        $session = $this->request->getSession();
        $code = $session->read('ms_cap_code');
        if ($code === null || $code === '') {
            $code = (string)rand(10000, 99999);
            $session->write('ms_cap_code', $code);
        }

        $width = 80;
        $height = 30;
        $image = imagecreatetruecolor($width, $height);
        if ($image === false) {
            return $this->response->withStatus(500);
        }
        $bg = imagecolorallocate($image, 240, 240, 240);
        $text = imagecolorallocate($image, 0, 0, 0);
        imagefill($image, 0, 0, $bg);
        imagestring($image, 5, 10, 8, (string)$code, $text);

        ob_start();
        imagepng($image);
        $png = ob_get_clean();
        imagedestroy($image);

        return $this->response
            ->withType('image/png')
            ->withStringBody($png === false ? '' : $png);
    }

    /**
     * Captcha image. No layout. Session key: cap_code.
     */
    public function captch(): Response
    {
        $this->viewBuilder()->setLayout(false);
        $session = $this->request->getSession();
        $code = $session->read('cap_code');
        if ($code === null || $code === '') {
            $code = (string)rand(10000, 99999);
            $session->write('cap_code', $code);
        }

        $width = 80;
        $height = 30;
        $image = imagecreatetruecolor($width, $height);
        if ($image === false) {
            return $this->response->withStatus(500);
        }
        $bg = imagecolorallocate($image, 240, 240, 240);
        $text = imagecolorallocate($image, 0, 0, 0);
        imagefill($image, 0, 0, $bg);
        imagestring($image, 5, 10, 8, $code, $text);

        ob_start();
        imagepng($image);
        $png = ob_get_clean();
        imagedestroy($image);

        return $this->response
            ->withType('image/png')
            ->withStringBody($png);
    }

    // -------------------------------------------------------------------------
    // Product warranty
    // -------------------------------------------------------------------------

    /**
     * Product warranty request form (footer link). View is standalone full HTML – use no layout.
     * View: Fronts/product_warranty.php
     */
    public function productWarranty(): ?Response
    {
        $this->viewBuilder()->setLayout(false);

        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Product Warranty Request Form');

        $warrantyLog = ['ProductWarrantyRequest' => []];

        $this->loadModel('ProductWarrantyRequests');
        if ($this->request->is('post')) {
            $data = $this->request->getData('ProductWarrantyRequest') ?? $this->request->getData();
            if (isset($data['application']) && is_array($data['application'])) {
                $data['application'] = implode(', ', array_filter($data['application']));
            }
            $entity = $this->ProductWarrantyRequests->newEntity($data);
            if ($this->ProductWarrantyRequests->save($entity)) {
                // Notify internal team for new Product Warranty Request submissions.
                $baseUrl = defined('SITEURL') ? (string)SITEURL : (string)(Configure::read('App.fullBaseUrl') ?? '');
                $adminListUrl = rtrim($baseUrl, '/') . '/admin/stocks/product_warranty_request';
                $recipients = array_values(array_unique(array_filter([
                    'info@durotechindustries.com.au',
                    'kal@durotechindustries.com.au',
                    'deepaksaini10036@gmail.com',
                ], function ($email) {
                    return is_string($email) && filter_var(trim($email), FILTER_VALIDATE_EMAIL);
                })));

                if (!empty($recipients)) {
                    try {
                        $contactName = trim((string)($data['contract_name'] ?? $data['applicator'] ?? ''));
                        $contactEmail = trim((string)($data['email'] ?? ''));
                        $contactPhone = trim((string)($data['applicator_contact'] ?? $data['phone'] ?? ''));
                        $warrantyPeriod = trim((string)($data['start_requested_warranty'] ?? ''))
                            . ' to '
                            . trim((string)($data['end_requested_warranty'] ?? ''));

                        $logoUrl = $baseUrl !== ''
                            ? (rtrim($baseUrl, '/') . '/customdurotech/images/durotech_logo.png')
                            : '';
                        $siteName = defined('SITENAME') ? (string)SITENAME : 'Durotech Industries';

                        $detailRows = [
                            'Request ID' => (string)$entity->id,
                            'Serial number' => trim((string)($data['serialnumber'] ?? '')),
                            'Product' => trim((string)($data['product'] ?? '')),
                            'Date of purchase' => trim((string)($data['dateofpurchase'] ?? '')),
                            'Used as' => trim((string)($data['used_as'] ?? '')),
                            'Application' => trim((string)($data['application'] ?? '')),
                            'Primary contact' => $contactName,
                            'Contractor company' => trim((string)($data['contract_company_name'] ?? '')),
                            'Contractor name' => trim((string)($data['contract_name'] ?? '')),
                            'Applicator' => trim((string)($data['applicator'] ?? '')),
                            'Email' => $contactEmail,
                            'Phone' => $contactPhone,
                            'Building address' => trim((string)($data['building_address'] ?? '')),
                            'Applicator address' => trim((string)($data['applicator_address'] ?? '')),
                            'Applicator ABN' => trim((string)($data['applicator_active_abn'] ?? '')),
                            'Building name' => trim((string)($data['building_name'] ?? '')),
                            'Building / area name' => trim((string)($data['building_area_name'] ?? '')),
                            'Area warranted' => trim((string)($data['area_warranted'] ?? '')),
                            'Requested warranty' => $warrantyPeriod,
                            'Certificate sign date' => trim((string)($data['sign_date'] ?? '')),
                        ];

                        $email = new Email('default');
                        $email->setTo($recipients)
                            ->setSubject('New Product Warranty Request Submitted')
                            ->setEmailFormat('html')
                            ->setTemplate('product_warranty_admin_notify')
                            ->setLayout('default')
                            ->setViewVars([
                                'siteName' => $siteName,
                                'logoUrl' => $logoUrl,
                                'introLine' => 'A new product warranty request was submitted from the website.',
                                'detailRows' => $detailRows,
                                'adminListUrl' => $adminListUrl,
                            ])
                            ->send();
                    } catch (\Throwable $e) {
                        Log::error('Product warranty request notification email failed: ' . $e->getMessage());
                    }
                }

                $this->Flash->success(__('Thank you for your application a Durotech representative will be in touch shortly.'));
                return $this->redirect(['controller' => 'Fronts', 'action' => 'productWarranty']);
            }
            $this->Flash->error(__('Failed to save warranty details.'));
            $warrantyLog['ProductWarrantyRequest'] = $data;
        }

        $this->set(compact('warrantyLog'));
        return null;
    }

    /**
     * Submit project warranty request form (technical literature / warranty page).
     * Saves to warranty_requests and redirects back with flash.
     */
    public function submitform(): ?Response
    {
        $this->request->allowMethod(['post']);

        $this->loadModel('WarrantyRequests');
        $data = [
            'name' => $this->request->getData('name'),
            'email' => $this->request->getData('email'),
            'phone' => $this->request->getData('phone'),
            'project_name' => $this->request->getData('project_name'),
            'year' => $this->request->getData('year'),
            'unique_id' => 'WR-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8)),
            'status' => 0,
        ];
        $entity = $this->WarrantyRequests->newEntity($data);
        if ($this->WarrantyRequests->save($entity)) {
            // Notify internal team with direct admin link to process/send warranty form.
            $baseUrl = defined('SITEURL') ? (string)SITEURL : (string)(Configure::read('App.fullBaseUrl') ?? '');
            $adminListUrl = rtrim($baseUrl, '/') . '/admin/stocks/warrant_request';
            $recipients = array_values(array_unique(array_filter([
                'info@durotechindustries.com.au',
                'kal@durotechindustries.com.au',
                'deepaksaini10036@gmail.com',
            ], function ($email) {
                return is_string($email) && filter_var(trim($email), FILTER_VALIDATE_EMAIL);
            })));

            if (!empty($recipients)) {
                try {
                    $email = new Email('default');
                    $email->setTo($recipients)
                        ->setSubject('New Warranty Request Submitted - ' . ($data['unique_id'] ?? ''))
                        ->setEmailFormat('html')
                        ->send(
                            '<p>A new warranty request was submitted from the website.</p>' .
                            '<p>' .
                            '<b>Request ID:</b> ' . h((string)($data['unique_id'] ?? '')) . '<br>' .
                            '<b>Name:</b> ' . h((string)($data['name'] ?? '')) . '<br>' .
                            '<b>Email:</b> ' . h((string)($data['email'] ?? '')) . '<br>' .
                            '<b>Phone:</b> ' . h((string)($data['phone'] ?? '')) . '<br>' .
                            '<b>Project Name:</b> ' . h((string)($data['project_name'] ?? '')) . '<br>' .
                            '<b>Year:</b> ' . h((string)($data['year'] ?? '')) .
                            '</p>' .
                            '<p>Open admin panel and send the warranty form to customer:</p>' .
                            '<p><a href="' . h($adminListUrl) . '">' . h($adminListUrl) . '</a></p>'
                        );
                } catch (\Throwable $e) {
                    Log::error('Warranty request notification email failed: ' . $e->getMessage());
                }
            }

            $this->Flash->success(__('Thank you for your warranty request. A representative will be in touch shortly.'));
            return $this->redirect(['controller' => 'Fronts', 'action' => 'technicalLiteratureNew', 'warranty']);
        }
        $this->Flash->error(__('Unable to submit your request. Please try again.'));
        return $this->redirect(['controller' => 'Fronts', 'action' => 'technicalLiteratureNew', 'warranty']);
    }

    // -------------------------------------------------------------------------
    // Subscribe (AJAX, no view)
    // -------------------------------------------------------------------------

    /**
     * Subscribe (e.g. footer newsletter). Expects ?email=... or POST. No view.
     */
    public function subscribe(): Response
    {
        $this->request->allowMethod(['get', 'post']);
        $this->viewBuilder()->setLayout(false);
        $email = $this->request->getQuery('email') ?: $this->request->getData('email') ?: '';

        if ($email === '') {
            return $this->response->withStringBody('Email id required;');
        }

        try {
            $this->loadModel('Subscriber');
            $exists = $this->Subscriber->find()->where(['email' => $email])->first();
            if (!$exists) {
                $entity = $this->Subscriber->newEntity([
                    'email' => $email,
                    'popup' => $this->request->getQuery('popup') ?: $this->request->getData('popup') ?: '',
                ]);
                $this->Subscriber->save($entity);
            }
            return $this->response->withStringBody('You successfully subscribed.');
        } catch (\Throwable $e) {
            return $this->response->withStringBody('You successfully subscribed.');
        }
    }

    /**
     * Visitor entry register page (kiosk style).
     * GET: show today's entries. POST: save visitor in.
     */
    public function welcomevistor(): ?Response
    {
        $this->viewBuilder()->setLayout('visitor_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : 'Durotech') . ' Visitor Entry Register');

        if ($this->request->is('post')) {
            // Accept mixed payloads from legacy template fields:
            // - Front[visitor_name] (FormHelper generated)
            // - data[Front][visitor_card_id], data[Front][visit_for], etc. (manual inputs)
            $front = array_merge(
                (array)($this->request->getData('data.Front') ?? []),
                (array)($this->request->getData('Front') ?? [])
            );
            $visitorName = trim((string)($front['visitor_name'] ?? ''));
            $visitFor = trim((string)($front['visit_for'] ?? ''));
            $visitorCardId = (int)($front['visitor_card_id'] ?? 0);
            $dateRaw = trim((string)($front['date'] ?? ''));

            if ($visitorName === '' || $visitFor === '' || $visitorCardId <= 0) {
                $this->Flash->error('Visitor name, visitor pass id and visit reason are required.');
                return $this->redirect(['action' => 'welcomevistor']);
            }

            $visitDate = date('Y-m-d');
            if ($dateRaw !== '') {
                $parsed = \DateTime::createFromFormat('d/m/Y', $dateRaw);
                if ($parsed instanceof \DateTime) {
                    $visitDate = $parsed->format('Y-m-d');
                }
            }

            $signatureName = '';
            $sigimage = (string)$this->request->getData('sigimage');
            if ($sigimage !== '' && strpos($sigimage, 'data:image') === 0) {
                $signatureData = preg_replace('/^data:image\/\w+;base64,/', '', $sigimage);
                $signatureData = str_replace(' ', '+', (string)$signatureData);
                $decoded = base64_decode((string)$signatureData, true);
                if ($decoded !== false) {
                    $signatureDir = WWW_ROOT . 'signature' . DS;
                    if (!is_dir($signatureDir)) {
                        @mkdir($signatureDir, 0755, true);
                    }
                    $signatureName = uniqid('sign_', true) . '.png';
                    @file_put_contents($signatureDir . $signatureName, $decoded);
                }
            }

            $imageName = '';
            $uploadedFile = $this->request->getUploadedFile('file');
            if ($uploadedFile && $uploadedFile->getError() === UPLOAD_ERR_OK) {
                $signatureDir = WWW_ROOT . 'signature' . DS;
                if (!is_dir($signatureDir)) {
                    @mkdir($signatureDir, 0755, true);
                }
                $original = (string)$uploadedFile->getClientFilename();
                $ext = strtolower((string)pathinfo($original, PATHINFO_EXTENSION));
                if ($ext === '') {
                    $ext = 'jpg';
                }
                $imageName = uniqid('photo_', true) . '.' . preg_replace('/[^a-z0-9]/', '', $ext);
                $uploadedFile->moveTo($signatureDir . $imageName);
            }

            $entity = $this->Visitor->newEntity([
                'visitor_card_id' => $visitorCardId,
                'date' => $visitDate,
                'visitor_name' => $visitorName,
                'visit_for' => $visitFor,
                'timein' => date('Y-m-d H:i:s'),
                'timeout' => '0000-00-00 00:00:00',
                'sign' => $signatureName,
                'image' => $imageName,
            ]);

            if ($this->Visitor->save($entity)) {
                $this->Flash->success('Visitor added successfully.');
            } else {
                $errors = $entity->getErrors();
                if (!empty($errors)) {
                    $firstField = (string)array_key_first($errors);
                    $firstMessages = (array)($errors[$firstField] ?? []);
                    $firstMessage = (string)reset($firstMessages);
                    $this->Flash->error('Unable to add visitor: ' . ($firstMessage !== '' ? $firstMessage : 'validation failed'));
                } else {
                    $this->Flash->error('Unable to add visitor. Please try again.');
                }
            }
            return $this->redirect(['action' => 'welcomevistor']);
        }

        $today = date('Y-m-d');
        $visitorRows = $this->Visitor->find()
            ->where(['date' => $today])
            ->orderDesc('id')
            ->all();
        $visitor = [];
        foreach ($visitorRows as $row) {
            $visitor[] = ['Visitor' => $row->toArray()];
        }
        $this->set(compact('visitor'));
        return null;
    }

    /**
     * Visitor out action: sets timeout for selected visitor row.
     */
    public function punchout(?string $id = null): ?Response
    {
        $this->viewBuilder()->setLayout(false);
        if (empty($id)) {
            $this->Flash->error('Invalid visitor id.');
            return $this->redirect(['action' => 'welcomevistor']);
        }

        $decoded = base64_decode($id, true);
        $visitorId = $decoded === false ? 0 : (int)$decoded;
        if ($visitorId <= 0) {
            $this->Flash->error('Invalid visitor id.');
            return $this->redirect(['action' => 'welcomevistor']);
        }

        $visitor = $this->Visitor->find()->where(['id' => $visitorId])->first();
        if (!$visitor) {
            $this->Flash->error('Visitor not found.');
            return $this->redirect(['action' => 'welcomevistor']);
        }

        $visitor->timeout = date('Y-m-d H:i:s');
        if ($this->Visitor->save($visitor)) {
            $this->Flash->success('Visitor out time updated.');
        } else {
            $this->Flash->error('Unable to update visitor out time.');
        }

        return $this->redirect(['action' => 'welcomevistor']);
    }

    // -------------------------------------------------------------------------
    // Admin: Push Notifications
    // -------------------------------------------------------------------------

    /**
     * Admin: List push notifications. View: Fronts/admin_index.php
     */
    public function adminIndex(): ?Response
    {
        $this->set('title_for_layout', SITENAME . ' Push Notification');
        
        $this->paginate = [
            'limit' => 25,
            'order' => ['Notifications.id' => 'DESC'],
        ];
        $query = $this->Notifications->find()
            ->contain(['Products' => function ($q) {
                return $q->select(['Products.id', 'Products.title']);
            }]);
        $results = $this->paginate($query);
        
        // Convert entities to array format for backward compatibility with view
        $notification = [];
        foreach ($results as $row) {
            $product = $row->product ?? $row->products ?? null;
            $productArray = $product ? (is_object($product) ? $product->toArray() : $product) : [];
            $rowArray = $row->toArray();
            unset($rowArray['product'], $rowArray['products']);
            $notification[] = [
                'Notification' => $rowArray,
                'Product' => $productArray,
            ];
        }
        $this->set(compact('notification'));
        return null;
    }

    /**
     * Admin: Send new notification. View: Fronts/admin_send.php
     */
    public function adminSend(): ?Response
    {
        $this->set('title_for_layout', SITENAME . ' Send Notification');
        
        // Get products for dropdown
        $productsQuery = $this->Products->find()
            ->select(['Products.id', 'Products.title'])
            ->orderAsc('Products.title');
        $product = [];
        foreach ($productsQuery as $p) {
            $product[] = ['Product' => $p->toArray()];
        }
        $this->set(compact('product'));

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Handle file upload
            $imageFile = $this->request->getUploadedFile('image');
            $imageName = '';
            if ($imageFile && $imageFile->getError() === UPLOAD_ERR_OK) {
                $uploadPath = WWW_ROOT . 'product_image' . DS;
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $imageName = time() . '_' . $imageFile->getClientFilename();
                $imageFile->moveTo($uploadPath . $imageName);
            }

            $type = (int)($data['type'] ?? 3);
            $notificationData = [
                'type' => $type,
                'title' => $data['title'] ?? '',
                'description' => $data['description'] ?? '',
                'image' => $imageName,
            ];
            
            // Only set product_id when type is 4 (Product), otherwise set to 0
            if ($type == 4 && !empty($data['product_id'])) {
                $notificationData['product_id'] = (int)$data['product_id'];
            } else {
                $notificationData['product_id'] = 0;
            }

            $notification = $this->Notifications->newEntity($notificationData);
            if ($this->Notifications->save($notification)) {
                $this->Flash->success('Notification sent successfully.');
                return $this->redirect(['action' => 'admin_index']);
            }
            $this->Flash->error('The notification could not be saved. Please, try again.');
        }
        return null;
    }

    /**
     * Admin: Delete notification
     */
    public function adminDelete($id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $notification = $this->Notifications->get($id);
        if ($this->Notifications->delete($notification)) {
            $this->Flash->success('Notification deleted successfully.');
        } else {
            $this->Flash->error('The notification could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'admin_index']);
    }
}
