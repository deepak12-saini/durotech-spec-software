<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Http\Exception\NotFoundException;

/**
 * Coas Controller (COA Durotech - CakePHP 3.10)
 */
class CoasController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('Coas');
        $this->loadModel('CoaResults');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event): ?Response
    {
        $result = parent::beforeFilter($event);
        if ($result instanceof Response) {
            return $result;
        }
        $this->callConstants();
        return null;
    }

    /**
     * Front /coas list (staff or admin): list COAs for current user.
     */
    public function index(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' COA Durotech');
        $result = $this->checkSatffSession();
        if ($result instanceof Response) {
            return $result;
        }
        $userId = (int)$this->request->getSession()->read('Customer.id');
        if (!$userId) {
            $userId = (int)$this->request->getSession()->read('User.id');
        }
        $query = $this->Coas->find()
            ->where(['Coas.admin_id' => $userId])
            ->contain(['User' => function ($q) {
                return $q->select(['id', 'name', 'username']);
            }])
            ->orderDesc('Coas.id');
        $paginated = $this->paginate($query, ['limit' => 25]);
        $coa = [];
        foreach ($paginated as $entity) {
            $user = $entity->user ?? null;
            $coa[] = [
                'Coa' => $entity->toArray(),
                'NappUser' => $user ? ['name' => $user->name ?? '', 'lname' => $user->get('lname') ?? $user->get('username') ?? ''] : ['name' => '', 'lname' => ''],
            ];
        }
        $this->set(compact('coa'));
        return null;
    }

    /**
     * Admin: list COAs for logged-in admin
     */
    public function admin_index(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Coa Durotech List');
        $this->checkAdminSession();

        $userId = (int)$this->request->getSession()->read('User.id');
        $coa = $this->paginate($this->Coas->find()
            ->where(['Coas.admin_id' => $userId])
            ->contain(['User' => function ($q) {
                return $q->select(['name', 'username']);
            }])
            ->orderDesc('Coas.id'),
            ['limit' => 25]
        );
        $this->set(compact('coa'));
        return null;
    }

    /** CamelCase alias */
    public function adminIndex(): ?Response
    {
        return $this->admin_index();
    }

    /**
     * Staff: create new COA (/coas/create)
     */
    public function create(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Create COA');
        $result = $this->checkSatffSession();
        if ($result instanceof Response) {
            return $result;
        }
        $userId = (int)$this->request->getSession()->read('Customer.id');
        if (!$userId) {
            $userId = (int)$this->request->getSession()->read('User.id');
        }
        if ($this->request->is('post') && $this->request->getData()) {
            $data = $this->request->getData();
            $coa = $this->Coas->newEntity([]);
            $coa->admin_id = $userId;
            $coa->subject = $data['subject'] ?? '';
            $coa->name = $data['name'] ?? '';
            $coa->email = $data['email'] ?? '';
            $coa->product = $data['product'] ?? '';
            $coa->batch_no = $data['batch_no'] ?? '';
            $coa->date_of_manu = $data['date_of_manu'] ?? null;
            $coa->expiry_date = $data['expiry_date'] ?? null;
            $coa->form_no = $data['form_no'] ?? '';
            $coa->signature_date = $data['signature_date'] ?? null;
            $coa->created = date('Y-m-d H:i:s');
            $pdfname = 'COA-' . rand(111111, 999999);
            $coa->pdfname = $pdfname . '.pdf';

            if ($this->Coas->save($coa)) {
                $lastinsertId = (int)$coa->id;
                $tests = $data['test'] ?? [];
                $results = $data['result'] ?? [];
                $specs = $data['specfication'] ?? [];
                foreach ($tests as $key => $testVal) {
                    $res = $this->CoaResults->newEntity([]);
                    $res->coa_id = $lastinsertId;
                    $res->test = $testVal;
                    $res->result = $results[$key] ?? '';
                    $res->specfication = $specs[$key] ?? '';
                    $this->CoaResults->save($res);
                }
                $fields = [
                    'pdfname' => urlencode($pdfname),
                    'coa_id' => urlencode((string)$lastinsertId),
                    'name' => urlencode($coa->name),
                    'email' => urlencode($coa->email),
                    'product' => urlencode($coa->product),
                    'batch_no' => urlencode($coa->batch_no),
                    'form_no' => urlencode($coa->form_no),
                    'date_of_manu' => urlencode(date('M Y', strtotime($coa->date_of_manu ?? 'now'))),
                    'date' => urlencode(date('M Y', strtotime($coa->expiry_date ?? 'now'))),
                    'signature_date' => urlencode(date('M Y', strtotime($coa->signature_date ?? 'now'))),
                ];
                $fieldsString = http_build_query($fields);
                $url = (defined('SITEURL') ? SITEURL : '') . 'dompdf/generatecoapdf.php?' . $fieldsString;
                @file_get_contents($url);

                $this->Flash->success('COA PDF file generated successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }
        return null;
    }

    /**
     * Admin: create new COA
     */
    public function admin_create(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Create Durotech List');
        $this->checkAdminSession();

        $userId = (int)$this->request->getSession()->read('User.id');
        if ($this->request->is('post') && $this->request->getData()) {
            $data = $this->request->getData();
            $coa = $this->Coas->newEntity([]);
            $coa->admin_id = $userId;
            $coa->subject = $data['subject'] ?? '';
            $coa->name = $data['name'] ?? '';
            $coa->email = $data['email'] ?? '';
            $coa->product = $data['product'] ?? '';
            $coa->batch_no = $data['batch_no'] ?? '';
            $coa->date_of_manu = $data['date_of_manu'] ?? null;
            $coa->expiry_date = $data['expiry_date'] ?? null;
            $coa->form_no = $data['form_no'] ?? '';
            $coa->signature_date = $data['signature_date'] ?? null;
            $coa->created = date('Y-m-d H:i:s');
            $pdfname = 'COA-' . rand(111111, 999999);
            $coa->pdfname = $pdfname . '.pdf';

            if ($this->Coas->save($coa)) {
                $lastinsertId = (int)$coa->id;
                $tests = $data['test'] ?? [];
                $results = $data['result'] ?? [];
                $specs = $data['specfication'] ?? [];
                foreach ($tests as $key => $testVal) {
                    $res = $this->CoaResults->newEntity([]);
                    $res->coa_id = $lastinsertId;
                    $res->test = $testVal;
                    $res->result = $results[$key] ?? '';
                    $res->specfication = $specs[$key] ?? '';
                    $this->CoaResults->save($res);
                }
                $fields = [
                    'pdfname' => urlencode($pdfname),
                    'coa_id' => urlencode((string)$lastinsertId),
                    'name' => urlencode($coa->name),
                    'email' => urlencode($coa->email),
                    'product' => urlencode($coa->product),
                    'batch_no' => urlencode($coa->batch_no),
                    'form_no' => urlencode($coa->form_no),
                    'date_of_manu' => urlencode(date('M Y', strtotime($coa->date_of_manu ?? 'now'))),
                    'date' => urlencode(date('M Y', strtotime($coa->expiry_date ?? 'now'))),
                    'signature_date' => urlencode(date('M Y', strtotime($coa->signature_date ?? 'now'))),
                ];
                $fieldsString = http_build_query($fields);
                $url = (defined('SITEURL') ? SITEURL : '') . 'dompdf/generatecoapdf.php?' . $fieldsString;
                @file_get_contents($url);

                $this->Flash->success('COA PDF file generated successfully.');
                return $this->redirect(['controller' => 'Coas', 'action' => 'admin_index']);
            }
        }
        return null;
    }

    /** CamelCase alias */
    public function adminCreate(): ?Response
    {
        return $this->admin_create();
    }

    /**
     * Staff: edit COA (/coas/edit/:id)
     */
    public function edit($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Edit COA');
        $result = $this->checkSatffSession();
        if ($result instanceof Response) {
            return $result;
        }
        $userId = (int)$this->request->getSession()->read('Customer.id');
        if (!$userId) {
            $userId = (int)$this->request->getSession()->read('User.id');
        }
        $id = $id !== null ? (int)$id : null;
        if (!$id || !$this->Coas->exists(['id' => $id, 'admin_id' => $userId])) {
            $this->Flash->error('Invalid COA.');
            return $this->redirect(['action' => 'index']);
        }

        $entity = $this->Coas->get($id, ['contain' => ['CoaResults']]);
        $CoaArr = [
            'Coa' => $entity->toArray(),
            'CoaResult' => array_map(function ($r) {
                return $r->toArray();
            }, $entity->coa_results ?? []),
        ];

        if ($this->request->is(['post', 'put', 'patch']) && $this->request->getData()) {
            $data = $this->request->getData();
            $coa = $this->Coas->get($id);
            $coa->admin_id = $userId;
            $coa->subject = $data['subject'] ?? '';
            $coa->name = $data['name'] ?? '';
            $coa->email = $data['email'] ?? '';
            $coa->product = $data['product'] ?? '';
            $coa->batch_no = $data['batch_no'] ?? '';
            $coa->date_of_manu = $data['date_of_manu'] ?? null;
            $coa->expiry_date = $data['expiry_date'] ?? null;
            $coa->form_no = $data['form_no'] ?? '';
            $coa->signature_date = $data['signature_date'] ?? null;

            $pdfname = pathinfo($entity->pdfname ?? '', PATHINFO_FILENAME);
            if (empty($pdfname)) {
                $pdfname = 'COA-' . rand(111111, 999999);
                $coa->pdfname = $pdfname . '.pdf';
            }

            if ($this->Coas->save($coa)) {
                $this->CoaResults->deleteAll(['coa_id' => $id]);
                $tests = $data['test'] ?? [];
                $results = $data['result'] ?? [];
                $specs = $data['specfication'] ?? [];
                foreach ($tests as $key => $testVal) {
                    $res = $this->CoaResults->newEntity([]);
                    $res->coa_id = (int)$id;
                    $res->test = $testVal;
                    $res->result = $results[$key] ?? '';
                    $res->specfication = $specs[$key] ?? '';
                    $this->CoaResults->save($res);
                }
                $fields = [
                    'pdfname' => urlencode($pdfname),
                    'coa_id' => urlencode((string)$id),
                    'name' => urlencode($coa->name),
                    'email' => urlencode($coa->email),
                    'product' => urlencode($coa->product),
                    'batch_no' => urlencode($coa->batch_no),
                    'form_no' => urlencode($coa->form_no),
                    'date_of_manu' => urlencode(date('F Y', strtotime((string)($coa->date_of_manu ?? 'now')))),
                    'date' => urlencode(date('F Y', strtotime((string)($coa->expiry_date ?? 'now')))),
                    'signature_date' => urlencode(date('F Y', strtotime((string)($coa->signature_date ?? 'now')))),
                ];
                $fieldsString = http_build_query($fields);
                $url = (defined('SITEURL') ? SITEURL : '') . 'dompdf/generatecoapdf.php?' . $fieldsString;
                @file_get_contents($url);

                $this->Flash->success('COA PDF file generated successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set('CoaArr', $CoaArr);
        return null;
    }

    /**
     * Admin: edit COA
     */
    public function admin_edit($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Create Durotech List');
        $this->checkAdminSession();

        $id = $id !== null ? (int)$id : null;
        if (!$id || !$this->Coas->exists(['id' => $id])) {
            throw new NotFoundException('Invalid COA');
        }

        $CoaArr = $this->Coas->get($id, ['contain' => ['CoaResults']]);

        if ($this->request->is(['post', 'put', 'patch']) && $this->request->getData()) {
            $data = $this->request->getData();
            $userId = (int)$this->request->getSession()->read('User.id');

            $coa = $this->Coas->get($id);
            $coa->admin_id = $userId;
            $coa->subject = $data['subject'] ?? '';
            $coa->name = $data['name'] ?? '';
            $coa->email = $data['email'] ?? '';
            $coa->product = $data['product'] ?? '';
            $coa->batch_no = $data['batch_no'] ?? '';
            $coa->date_of_manu = $data['date_of_manu'] ?? null;
            $coa->expiry_date = $data['expiry_date'] ?? null;
            $coa->form_no = $data['form_no'] ?? '';
            $coa->signature_date = $data['signature_date'] ?? null;
            // Do not overwrite created on edit (keep original; avoid type issues)

            $pdfname = pathinfo($CoaArr->pdfname ?? '', PATHINFO_FILENAME);
            if (empty($pdfname)) {
                $pdfname = 'COA-' . rand(111111, 999999);
                $coa->pdfname = $pdfname . '.pdf';
            }

            if ($this->Coas->save($coa)) {
                $this->CoaResults->deleteAll(['coa_id' => $id]);
                $tests = $data['test'] ?? [];
                $results = $data['result'] ?? [];
                $specs = $data['specfication'] ?? [];
                foreach ($tests as $key => $testVal) {
                    $res = $this->CoaResults->newEntity([]);
                    $res->coa_id = (int)$id;
                    $res->test = $testVal;
                    $res->result = $results[$key] ?? '';
                    $res->specfication = $specs[$key] ?? '';
                    $this->CoaResults->save($res);
                }
                $fields = [
                    'pdfname' => urlencode($pdfname),
                    'coa_id' => urlencode((string)$id),
                    'name' => urlencode($coa->name),
                    'email' => urlencode($coa->email),
                    'product' => urlencode($coa->product),
                    'batch_no' => urlencode($coa->batch_no),
                    'form_no' => urlencode($coa->form_no),
                    'date_of_manu' => urlencode(date('F Y', strtotime($coa->date_of_manu ?? 'now'))),
                    'date' => urlencode(date('F Y', strtotime($coa->expiry_date ?? 'now'))),
                    'signature_date' => urlencode(date('F Y', strtotime($coa->signature_date ?? 'now'))),
                ];
                $fieldsString = http_build_query($fields);
                $url = (defined('SITEURL') ? SITEURL : '') . 'dompdf/generatecoapdf.php?' . $fieldsString;
                @file_get_contents($url);

                $this->Flash->success('COA PDF file generated successfully.');
                return $this->redirect(['controller' => 'Coas', 'action' => 'admin_index']);
            }
        }

        $this->set('CoaArr', $CoaArr);
        return null;
    }

    /** CamelCase alias */
    public function adminEdit($id = null): ?Response
    {
        return $this->admin_edit($id);
    }

    /**
     * Admin: send COA email
     */
    public function admin_sendemail($id = null): ?Response
    {
        $this->checkAdminSession();

        $id = $id !== null ? (int)$id : null;
        if (!$id || !$this->Coas->exists(['id' => $id])) {
            $this->Flash->error('Record not found.');
            return $this->redirect(['controller' => 'Coas', 'action' => 'admin_index']);
        }

        $coa = $this->Coas->get($id);
        $email = trim((string)($coa->email ?? ''));
        if ($email !== '') {
            $pdfname = base64_encode(base64_encode($coa->pdfname ?? ''));
            $subject = trim((string)($coa->subject ?? ''));
            if ($subject === '') {
                $subject = (defined('SITENAME') ? SITENAME : 'Durotech') . ' - Certificate of Analysis';
                if ($coa->product ?? '') {
                    $subject .= ' - ' . $coa->product;
                }
            }
            $dateOfManu = $coa->date_of_manu;
            $expiryDate = $coa->expiry_date;
            if (is_object($dateOfManu) && $dateOfManu instanceof \DateTimeInterface) {
                $dateOfManu = $dateOfManu->format('Y-m-d');
            } else {
                $dateOfManu = $dateOfManu !== null && $dateOfManu !== '' ? (string)$dateOfManu : '';
            }
            if (is_object($expiryDate) && $expiryDate instanceof \DateTimeInterface) {
                $expiryDate = $expiryDate->format('Y-m-d');
            } else {
                $expiryDate = $expiryDate !== null && $expiryDate !== '' ? (string)$expiryDate : '';
            }
            $variables = [
                'subject' => $subject,
                'pdfname' => $pdfname,
                'name' => (string)($coa->name ?? ''),
                'product' => (string)($coa->product ?? ''),
                'batch_no' => (string)($coa->batch_no ?? ''),
                'date_of_manu' => $dateOfManu,
                'expiry_date' => $expiryDate,
                'form_no' => (string)($coa->form_no ?? ''),
            ];
            try {
                $this->sendemail($email, $subject, 'coapdf', $variables);
                $this->Flash->success('Email sent successfully.');
            } catch (\Exception $e) {
                \Cake\Log\Log::error('COA send email failed: ' . $e->getMessage());
                $msg = 'Failed to send email.';
                if (Configure::read('debug')) {
                    $msg .= ' ' . $e->getMessage();
                } else {
                    $msg .= ' Please check mail configuration or try again later.';
                }
                $this->Flash->error($msg);
            }
        } else {
            $this->Flash->error('No email address set for this COA.');
        }
        return $this->redirect(['controller' => 'Coas', 'action' => 'admin_index']);
    }

    /** CamelCase alias */
    public function adminSendemail($id = null): ?Response
    {
        return $this->admin_sendemail($id);
    }

    /**
     * Admin: download COA PDF (serve from webroot/dompdf/). Generates PDF on the fly if missing.
     */
    public function admin_download($id = null): ?Response
    {
        $this->checkAdminSession();
        $id = $id !== null ? (int)$id : null;
        if (!$id || !$this->Coas->exists(['id' => $id])) {
            throw new NotFoundException('COA not found');
        }
        $coa = $this->Coas->get($id);
        $pdfname = $coa->pdfname ?? '';
        $pdfnameBase = $pdfname !== '' ? pathinfo($pdfname, PATHINFO_FILENAME) : '';
        if ($pdfnameBase === '') {
            $pdfnameBase = 'COA-' . rand(111111, 999999);
            $pdfname = $pdfnameBase . '.pdf';
            $coa->pdfname = $pdfname;
            $this->Coas->save($coa);
        }
        $path = WWW_ROOT . 'dompdf' . DS . $pdfname;
        if (!is_file($path)) {
            $this->generateCoaPdfFile($id, $coa, $pdfnameBase);
            if (!is_file($path)) {
                throw new NotFoundException('PDF could not be generated. Check dompdf and coa_results data.');
            }
        }
        $this->response = $this->response->withFile($path, [
            'download' => true,
            'name' => $pdfname,
        ]);
        return $this->response;
    }

    /**
     * Generate COA PDF file using Dompdf (in-process; no HTTP call).
     */
    protected function generateCoaPdfFile(int $coaId, \Cake\Datasource\EntityInterface $coa, string $pdfnameBase): void
    {
        $dateStr = function ($v) {
            if ($v === null || $v === '') {
                return 'now';
            }
            if (is_object($v)) {
                return $v instanceof \DateTimeInterface ? $v->format('Y-m-d') : (string)$v;
            }
            return (string)$v;
        };
        $dateOfManu = date('F Y', strtotime($dateStr($coa->date_of_manu ?? null)));
        $expiryDate = date('F Y', strtotime($dateStr($coa->expiry_date ?? null)));
        $signatureDate = date('F Y', strtotime($dateStr($coa->signature_date ?? null)));

        $coaWithResults = $this->Coas->get($coaId, ['contain' => ['CoaResults']]);
        $results = $coaWithResults->coa_results ?? [];
        $trow = '<table cellpadding="0" cellspacing="0" style=" padding:6px 0px 6px 0px; width: 100%; margin-top:0px;"><tr><td></td>';
        $trow .= '<tr style="padding: 4px;"><td style="padding: 4px 10px 0px;font-size: 14px;font-weight: bold;font-family: arial;">Test</td><td style="padding: 4px 10px 0px;font-size: 14px;font-weight: bold;font-family: arial;">Result</td><td style="padding: 4px 10px 0px;font-size: 14px;font-weight: bold;font-family: arial;">Specfication</td></tr>';
        foreach ($results as $row) {
            $trow .= '<tr style="background: #ffffff;padding: 4px;"><td style="padding: 4px 10px 0px;font-size: 12px;font-family: arial;">' . htmlspecialchars((string)($row->test ?? '')) . '</td><td style="padding: 4px 10px 0px;font-size: 12px;font-family: arial;">' . htmlspecialchars((string)($row->result ?? '')) . '</td><td style="padding: 4px 10px 0px;font-size: 12px;font-family: arial;">' . htmlspecialchars((string)($row->specfication ?? '')) . '</td></tr>';
        }
        $trow .= '</tr></table>';

        $product = htmlspecialchars((string)($coa->product ?? ''));
        $batchNo = htmlspecialchars((string)($coa->batch_no ?? ''));
        $formNo = htmlspecialchars((string)($coa->form_no ?? ''));

        $html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head><body bgcolor="#fff">';
        $html .= '<table class="head-wrap" style="width: 100%;" border="0" cellspacing="0" cellpadding="0" style="background: #e7f5f9;"><tr><td></td><td class="header container" style="display:block!important;max-width:900px !important;margin:0 auto!important;clear:both!important;">';
        $html .= '<div class="content" style="padding:15px;max-width:900px;margin:0 auto;display:block;">';
        $html .= '<table border="0" cellspacing="0" cellpadding="0"><tr><td><a href="https://durotechindustries.com.au"><img src="https://www.durotechindustries.com.au/dompdf/img/page 1 header-01.jpg" style="width: 100% !important;" /></a></td><td align="right"></td></tr></table>';
        $html .= '<table cellpadding="0" cellspacing="0" style="margin:0;padding:6px 0px;"><tr><td><h3 style="border-bottom: 2px solid #000 !important;width: 100%; font-family: arial;">TECHNICAL SERVICE</h3></td></tr></table>';
        $html .= '<table cellpadding="0" cellspacing="0" style="margin:0;padding:6px 0px;"><tr><td><h3 style="text-decoration: underline !important; text-align:center; font-family: arial;">CERTIFICATE OF ANALYSIS</h3></td></tr></table>';
        $html .= '<table cellpadding="0" cellspacing="0" style="margin:0;padding:6px 0px; width: 900px;"><tr><td align="left" style="padding:0px 9px;">';
        $html .= '<table cellpadding="0" cellspacing="0" style="margin:0;width: 95%;"><tr><th style="padding: 4px 9px;font-size: 12px;text-align: left;font-family: arial;">Product:</th><th style="padding: 4px 9px;font-size: 12px;text-align: center;font-family: arial;">' . $product . '</th></tr>';
        $html .= '<tr><th style="padding: 4px 9px;font-size: 12px;text-align: left;font-family: arial;">Batch No.:</th><th style="padding: 4px 9px;font-size: 12px;text-align: center;font-family: arial;">' . $batchNo . '</th></tr>';
        $html .= '<tr><th style="padding: 4px 9px;font-size: 12px;text-align: left;font-family: arial;">Date of Manu: </th><th style="padding: 4px 9px;font-size: 12px;text-align: center;font-family: arial;">' . $dateOfManu . '</th></tr>';
        $html .= '<tr><th style="padding: 4px 9px;font-size: 12px;text-align: left;font-family: arial;">Expiry Date:</th><th style="padding: 4px 9px;font-size: 12px;text-align: center;font-family: arial;">' . $expiryDate . '</th></tr></table></td></tr></table>';
        $html .= '<table cellpadding="0" cellspacing="0" style="margin:0;width: 95%; margin-top:18px; width: 900px"><tr><td align="left" style="padding:0px 9px;">' . $trow . '</td></tr></table>';
        $html .= '<table cellpadding="0" cellspacing="0" style="margin:0;width: 95%; margin-top:18px;"><tr><td align="left" style="padding:0px 9px;"><p style="padding: 0px 9px; font-size: 12px; font-family: arial; color:#353336;"><br/>PRINTED ELECTRONICALLY, NO SIGNATURE REQUIRED</p></td></tr></table>';
        $html .= '<p style="width: 100%; font-family: arial; font-size: 12px; color:#353336;text-align: right;">FORM NO: ' . $formNo . '</p><p style="width: 100%; font-family: arial; font-size: 12px; color:#353336;text-align: right;">' . strtoupper($signatureDate) . '</p>';
        $html .= '<p style="width: 100%; font-family: arial; font-size: 8px; color:#353336;text-align: left;">Disclaimer: "This document, including any attached files, is strictly confidential and intended solely for the use of the individual or entity to which it is addressed. Durotech Industries prohibits the right to publish, copy, distribute or disclose any information contained in this document, or its attachments, by any party other than the intended recipient. If you have received this document in error, please notify the sender and delete it from your system immediately."</p>';
        $html .= '</div></td><td></td></tr></table></body></html>';

        $autoload = WWW_ROOT . 'dompdf' . DS . 'vendor' . DS . 'autoload.php';
        if (!is_file($autoload)) {
            return;
        }
        // Buffer all output so Dompdf warnings don't cause "headers already sent" and break the download
        ob_start();
        $prevErrorReporting = error_reporting(E_ERROR | E_PARSE);
        try {
            require_once $autoload;
            $dompdf = new \Dompdf\Dompdf(['enable_remote' => true]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $output = $dompdf->output();
            $path = WWW_ROOT . 'dompdf' . DS . $pdfnameBase . '.pdf';
            file_put_contents($path, $output);
        } finally {
            error_reporting($prevErrorReporting);
            ob_end_clean();
        }
    }

    /** CamelCase alias */
    public function adminDownload($id = null): ?Response
    {
        return $this->admin_download($id);
    }

    /**
     * Staff: download COA PDF. Generates on the fly if file is missing (fixes 404).
     */
    public function download($id = null): ?Response
    {
        $result = $this->checkSatffSession();
        if ($result instanceof Response) {
            return $result;
        }
        $userId = (int)$this->request->getSession()->read('Customer.id');
        if (!$userId) {
            $userId = (int)$this->request->getSession()->read('User.id');
        }
        $id = $id !== null ? (int)$id : null;
        if (!$id || !$this->Coas->exists(['id' => $id, 'admin_id' => $userId])) {
            $this->Flash->error('COA not found.');
            return $this->redirect(['action' => 'index']);
        }
        $coa = $this->Coas->get($id);
        $pdfname = $coa->pdfname ?? '';
        $pdfnameBase = $pdfname !== '' ? pathinfo($pdfname, PATHINFO_FILENAME) : '';
        if ($pdfnameBase === '') {
            $pdfnameBase = 'COA-' . rand(111111, 999999);
            $pdfname = $pdfnameBase . '.pdf';
            $coa->pdfname = $pdfname;
            $this->Coas->save($coa);
        }
        $path = WWW_ROOT . 'dompdf' . DS . $pdfname;
        if (!is_file($path)) {
            $this->generateCoaPdfFile($id, $coa, $pdfnameBase);
            if (!is_file($path)) {
                $this->Flash->error('PDF could not be generated.');
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->response = $this->response->withFile($path, [
            'download' => true,
            'name' => $pdfname,
        ]);
        return $this->response;
    }
}
