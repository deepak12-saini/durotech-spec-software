<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Legal Actions controller (CakePHP 3.10)
 * Staff legal action notifications and PDF generation.
 */
class LegalActionsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('LegalActions');
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
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Legal Action');
        $result = $this->checkSatffSession();
        if ($result instanceof Response) {
            return $result;
        }
        $customer_id = $this->request->getSession()->read('Customer.id');
        $query = $this->LegalActions->find()
            ->where(['LegalActions.user_id' => $customer_id])
            ->orderDesc('LegalActions.id');
        $results = $query->all();
        $LegalAction = [];
        foreach ($results as $entity) {
            $LegalAction[] = ['LegalAction' => $entity->toArray()];
        }
        $this->set('LegalAction', $LegalAction);
        return null;
    }

    public function send(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Legal Action');
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
        $last = $this->LegalActions->find()->orderDesc('LegalActions.id')->first();
        $nextId = $last ? ((int)$last->id + 1) : 1;
        $code = str_pad((string)$nextId, 3, '0', STR_PAD_LEFT);
        $unique_id = 'DT-LA-' . $code;

        $entity = $this->LegalActions->newEntity([
            'user_id' => $user_id,
            'unique_id' => $unique_id,
            'company_name' => $data['company_name'] ?? '',
            'send_from' => $data['send_from'] ?? '',
            'amount' => $data['amount'] ?? '',
            'address' => $data['address'] ?? '',
            'subject' => $data['subject'] ?? '',
            'email' => $data['email'] ?? '',
            'date' => $data['date'] ?? date('Y-m-d'),
        ]);
        if (!$this->LegalActions->save($entity)) {
            $this->Flash->error('Could not save. Please try again.');
            return null;
        }
        $this->_fetchLegalActionPdf($unique_id, $data);
        $this->Flash->success('Saved successfully.');
        return $this->redirect(['action' => 'index']);
    }

    public function edit($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Legal Action');
        $result = $this->checkSatffSession();
        if ($result instanceof Response) {
            return $result;
        }
        $user_id = (int)$this->request->getSession()->read('Customer.id');
        $id = (int)$id;
        if (!$id || !$this->LegalActions->exists(['id' => $id, 'user_id' => $user_id])) {
            $this->Flash->error('Invalid record.');
            return $this->redirect(['action' => 'index']);
        }
        $entity = $this->LegalActions->get($id);
        $SiteVisitArr = ['LegalAction' => $entity->toArray()];

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $visit_id = $this->_nextUniqueIdRevision($entity->unique_id ?? '');
            $entity->company_name = $data['company_name'] ?? $entity->company_name;
            $entity->send_from = $data['send_from'] ?? $entity->send_from;
            $entity->amount = $data['amount'] ?? $entity->amount;
            $entity->address = $data['address'] ?? $entity->address;
            $entity->subject = $data['subject'] ?? $entity->subject;
            $entity->email = $data['email'] ?? $entity->email;
            $entity->date = $data['date'] ?? $entity->date;
            $entity->unique_id = $visit_id;
            if ($this->LegalActions->save($entity)) {
                $this->_fetchLegalActionPdf($visit_id, $data);
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
        if (!$id || !$this->LegalActions->exists(['id' => $id, 'user_id' => $user_id])) {
            $this->Flash->error('Invalid record.');
            return $this->redirect(['action' => 'index']);
        }
        $entity = $this->LegalActions->get($id);
        $dateStr = $entity->date;
        if (is_object($dateStr) && method_exists($dateStr, 'format')) {
            $dateStr = $dateStr->format('Y-m-d');
        }
        $dateFormatted = $dateStr ? date('d F,Y', strtotime((string)$dateStr)) : '';
        $fields = [
            'visit_id' => $entity->unique_id ?? '',
            'company_name' => $entity->company_name ?? '',
            'address' => $entity->address ?? '',
            'amount' => $entity->amount ?? '',
            'subject' => $entity->subject ?? '',
            'email' => $entity->email ?? '',
            'send_from' => $entity->send_from ?? '',
            'date' => $dateFormatted,
        ];
        $url = (defined('SITEURL') ? SITEURL : '') . 'dompdf/legal_actions.php?';
        $url .= http_build_query(array_map('urlencode', $fields));
        @file_get_contents($url);
        $this->Flash->success('Mailer sent successfully.');
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Build next revision suffix for unique_id (e.g. DT-LA-001-A -> DT-LA-001-B).
     */
    private function _nextUniqueIdRevision(string $visit_id): string
    {
        $parts = explode('-', $visit_id);
        $suffix = $parts[3] ?? '';
        $seq = ['', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T'];
        $idx = array_search($suffix, $seq, true);
        $next = $idx !== false && isset($seq[$idx + 1]) ? $seq[$idx + 1] : 'A';
        $base = implode('-', array_slice($parts, 0, 3));
        return $base . ($next !== '' ? '-' . $next : '');
    }

    private function _fetchLegalActionPdf(string $visit_id, array $data): void
    {
        $fields = [
            'visit_id' => $visit_id,
            'company_name' => $data['company_name'] ?? '',
            'address' => $data['address'] ?? '',
            'amount' => $data['amount'] ?? '',
            'subject' => $data['subject'] ?? '',
            'email' => $data['email'] ?? '',
            'send_from' => $data['send_from'] ?? '',
            'date' => isset($data['date']) ? date('d F,Y', strtotime($data['date'])) : date('d F,Y'),
        ];
        $url = (defined('SITEURL') ? SITEURL : '') . 'dompdf/legal_actions.php?';
        $url .= http_build_query(array_map('urlencode', $fields));
        @file_get_contents($url);
    }
}
