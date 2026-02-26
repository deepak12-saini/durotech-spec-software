 <?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Site Visits controller (CakePHP 3.10)
 * Staff site visit mailer and PDF generation.
 */
class SiteVisitsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('SiteVisits');
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        parent::beforeFilter($event);
		$this->callConstants();
        return null;
    }

    public function index(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Site Visit Mailer');
        $result = $this->checkSatffSession();
        if ($result instanceof Response) {
            return $result;
        }
        $customer_id = $this->request->getSession()->read('Customer.id');
        $query = $this->SiteVisits->find()
            ->where(['SiteVisits.user_id' => $customer_id])
            ->orderDesc('SiteVisits.id');
        $results = $query->all();
        $sitevisit = [];
        foreach ($results as $entity) {
            $sitevisit[] = ['SiteVisit' => $entity->toArray()];
        }
        $this->set('sitevisit', $sitevisit);
        return null;
    }

    public function send(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Site Visit Mailer');
        $result = $this->checkSatffSession();
        if ($result instanceof Response) {
            return $result;
        }
        $user_id = (int)$this->request->getSession()->read('Customer.id');
        if (!$this->request->is('post')) {
            return null;
        }
        $data = $this->request->getData();
        if (empty($data)) {
            return null;
        }
        $last = $this->SiteVisits->find()->orderDesc('SiteVisits.id')->first();
        $nextId = $last ? ((int)$last->id + 1) : 1;
        $code = str_pad((string)$nextId, 3, '0', STR_PAD_LEFT);
        $visit_id = 'DT-SI-' . $code;

        $dateVal = $data['date'] ?? date('Y-m-d');
        if (is_object($dateVal) && method_exists($dateVal, 'format')) {
            $dateVal = $dateVal->format('Y-m-d H:i:s');
        } else {
            $dateVal = date('Y-m-d H:i:s', strtotime((string)$dateVal));
        }
        $entity = $this->SiteVisits->newEntity([
            'user_id' => $user_id,
            'visit_id' => $visit_id,
            'email' => $data['email'] ?? '',
            'userarea' => $data['userarea'] ?? '',
            'sale_reps' => $data['sale_reps'] ?? '',
            'company_name' => $data['company_name'] ?? '',
            'customer_name' => $data['customer_name'] ?? '',
            'project_name' => $data['project_name'] ?? '',
            'subject' => $data['subject'] ?? '',
            'send_from' => $data['send_from'] ?? '',
            'date' => $dateVal,
        ]);
        if (!$this->SiteVisits->save($entity)) {
            $this->Flash->error('Could not save. Please try again.');
            return null;
        }
        $this->_fetchSiteVisitPdf($visit_id, $data);
        $this->Flash->success('Saved successfully.');
        return $this->redirect(['action' => 'index']);
    }

    public function edit($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Site Visit Mailer');
        $result = $this->checkSatffSession();
        if ($result instanceof Response) {
            return $result;
        }
        $user_id = (int)$this->request->getSession()->read('Customer.id');
        $id = (int)$id;
        if (!$id || !$this->SiteVisits->exists(['id' => $id, 'user_id' => $user_id])) {
            $this->Flash->error('Invalid record.');
            return $this->redirect(['action' => 'index']);
        }
        $entity = $this->SiteVisits->get($id);
        $SiteVisitArr = ['SiteVisit' => $entity->toArray()];

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $visit_id = $this->_nextUniqueIdRevision($entity->visit_id ?? '');
            $dateVal = $data['date'] ?? $entity->date;
            if (is_object($dateVal) && method_exists($dateVal, 'format')) {
                $dateVal = $dateVal->format('Y-m-d H:i:s');
            } else {
                $dateVal = date('Y-m-d H:i:s', strtotime((string)$dateVal));
            }
            $entity->visit_id = $visit_id;
            $entity->email = $data['email'] ?? $entity->email;
            $entity->userarea = $data['userarea'] ?? $entity->userarea;
            $entity->sale_reps = $data['sale_reps'] ?? $entity->sale_reps;
            $entity->company_name = $data['company_name'] ?? $entity->company_name;
            $entity->customer_name = $data['customer_name'] ?? $entity->customer_name;
            $entity->project_name = $data['project_name'] ?? $entity->project_name;
            $entity->subject = $data['subject'] ?? $entity->subject;
            $entity->send_from = $data['send_from'] ?? $entity->send_from;
            $entity->date = $dateVal;
            if ($this->SiteVisits->save($entity)) {
                $this->_fetchSiteVisitPdf($visit_id, $data);
                $this->Flash->success('Saved successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set('SiteVisitArr', $SiteVisitArr);
        return null;
    }

    public function sendemails($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $result = $this->checkSatffSession();
        if ($result instanceof Response) {
            return $result;
        }
        $user_id = (int)$this->request->getSession()->read('Customer.id');
        $id = (int)$id;
        if (!$id || !$this->SiteVisits->exists(['id' => $id, 'user_id' => $user_id])) {
            $this->Flash->error('Invalid record.');
            return $this->redirect(['action' => 'index']);
        }
        $entity = $this->SiteVisits->get($id);
        $dateObj = $entity->date;
        if (is_object($dateObj) && method_exists($dateObj, 'format')) {
            $dateFormatted = $dateObj->format('d F,Y');
        } else {
            $dateFormatted = $dateObj ? date('d F,Y', strtotime((string)$dateObj)) : date('d F,Y');
        }
        $fields = [
            'company_name' => $entity->company_name ?? '',
            'customer_name' => $entity->customer_name ?? '',
            'project_name' => $entity->project_name ?? '',
            'subject' => $entity->subject ?? '',
            'email' => $entity->email ?? '',
            'userarea' => $entity->userarea ?? '',
            'send_from' => $entity->send_from ?? '',
            'sale_reps' => $entity->sale_reps ?? '',
            'pdfname' => $entity->visit_id ?? '',
            'date' => $dateFormatted,
        ];
        $url = (defined('SITEURL') ? SITEURL : '') . 'dompdf/sitevistess.php';
        $this->_postToPdfScript($url, $fields);
        $this->Flash->success('Mailer sent successfully.');
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Regenerate PDF from record and redirect to it (fixes empty PDF when opening download link).
     */
    public function downloadPdf($id = null): ?Response
    {
        $result = $this->checkSatffSession();
        if ($result instanceof Response) {
            return $result;
        }
        $user_id = (int)$this->request->getSession()->read('Customer.id');
        $id = (int)$id;
        if (!$id || !$this->SiteVisits->exists(['id' => $id, 'user_id' => $user_id])) {
            $this->Flash->error('Invalid record.');
            return $this->redirect(['action' => 'index']);
        }
        $entity = $this->SiteVisits->get($id);
        $dateObj = $entity->date;
        if (is_object($dateObj) && method_exists($dateObj, 'format')) {
            $dateFormatted = $dateObj->format('d F,Y');
        } else {
            $dateFormatted = $dateObj ? date('d F,Y', strtotime((string)$dateObj)) : date('d F,Y');
        }
        $fields = [
            'company_name' => $entity->company_name ?? '',
            'customer_name' => $entity->customer_name ?? '',
            'project_name' => $entity->project_name ?? '',
            'subject' => $entity->subject ?? '',
            'email' => $entity->email ?? '',
            'userarea' => $entity->userarea ?? '',
            'send_from' => $entity->send_from ?? '',
            'sale_reps' => $entity->sale_reps ?? '',
            'pdfname' => $entity->visit_id ?? '',
            'date' => $dateFormatted,
        ];
        $url = (defined('SITEURL') ? SITEURL : '') . 'dompdf/sitevistess.php';
        $this->_postToPdfScript($url, $fields);
        $pdfUrl = (defined('SITEURL') ? SITEURL : '') . 'dompdf/' . ($entity->visit_id ?? '') . '.pdf';
        return $this->redirect($pdfUrl);
    }

    private function _nextUniqueIdRevision(string $visit_id): string
    {
        $parts = explode('-', $visit_id);
        $suffix = $parts[3] ?? '';
        $seq = ['', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T'];
        $idx = array_search($suffix, $seq, true);
        $next = ($idx !== false && isset($seq[$idx + 1])) ? $seq[$idx + 1] : 'A';
        $base = implode('-', array_slice($parts, 0, 3));
        return $base . ($next !== '' ? '-' . $next : '');
    }

    private function _fetchSiteVisitPdf(string $visit_id, array $data): void
    {
        $dateVal = $data['date'] ?? date('Y-m-d');
        if (is_object($dateVal) && method_exists($dateVal, 'format')) {
            $dateFormatted = $dateVal->format('d F,Y');
        } else {
            $dateFormatted = date('d F,Y', strtotime((string)$dateVal));
        }
        $fields = [
            'company_name' => $data['company_name'] ?? '',
            'customer_name' => $data['customer_name'] ?? '',
            'project_name' => $data['project_name'] ?? '',
            'subject' => $data['subject'] ?? '',
            'email' => $data['email'] ?? '',
            'userarea' => $data['userarea'] ?? '',
            'send_from' => $data['send_from'] ?? '',
            'sale_reps' => $data['sale_reps'] ?? '',
            'pdfname' => $visit_id,
            'date' => $dateFormatted,
        ];
        $url = (defined('SITEURL') ? SITEURL : '') . 'dompdf/sitevistess.php';
        $this->_postToPdfScript($url, $fields);
    }

    /** POST data to PDF script so all params are sent (avoids GET URL length limit). */
    private function _postToPdfScript(string $url, array $fields): void
    {
        $body = http_build_query($fields);
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $body,
            ],
        ];
        @file_get_contents($url, false, stream_context_create($opts));
    }
}
