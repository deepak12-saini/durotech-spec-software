<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ClaudeSpecService;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use Cake\Log\Log;

/**
 * Claude Spec Assistant — employee panel (Phase 1).
 */
class ClaudeSpecsController extends AppController
{
    /** @var \App\Model\Table\ClaudeSpecDraftsTable */
    public $ClaudeSpecDrafts;

    public function beforeFilter(EventInterface $event): ?Response
    {
        $result = parent::beforeFilter($event);
        if ($result instanceof Response) {
            return $result;
        }
        $this->callConstants();

        return null;
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('ClaudeSpecDrafts');
    }

    public function employeeIndex(): ?Response
    {
        return $this->employee_index();
    }

    public function employeeSend(): ?Response
    {
        return $this->employee_send();
    }

    public function employeeView($id = null): ?Response
    {
        return $this->employee_view($id);
    }

    public function employeeEdit($id = null): ?Response
    {
        return $this->employee_edit($id);
    }

    public function employeeRegenerate($id = null): ?Response
    {
        return $this->employee_regenerate($id);
    }

    public function employeeApply($id = null): ?Response
    {
        return $this->employee_apply($id);
    }

    public function employeeDelete($id = null): ?Response
    {
        return $this->employee_delete($id);
    }

    public function employee_index(): ?Response
    {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', SITENAME . ' | Claude Spec Assistant');
        $redirect = $this->_requireEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $employeeId = (int)$this->request->getSession()->read('Employee.id');
        $search = trim((string)$this->request->getQuery('q', ''));
        $statusFilter = trim((string)$this->request->getQuery('status', ''));
        $query = $this->ClaudeSpecDrafts->find()
            ->where([
                'ClaudeSpecDrafts.employee_id' => $employeeId,
                'ClaudeSpecDrafts.deleted_at IS' => null,
            ])
            ->orderDesc('ClaudeSpecDrafts.id');

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where([
                'OR' => [
                    ['ClaudeSpecDrafts.tracknumber LIKE' => $like],
                    ['ClaudeSpecDrafts.client_name LIKE' => $like],
                    ['ClaudeSpecDrafts.company LIKE' => $like],
                    ['ClaudeSpecDrafts.email LIKE' => $like],
                    ['ClaudeSpecDrafts.project_brief LIKE' => $like],
                ],
            ]);
        }
        if ($statusFilter !== '' && in_array($statusFilter, ['draft', 'generated', 'applied'], true)) {
            $query->where(['ClaudeSpecDrafts.status' => $statusFilter]);
        }

        $claudeSpecDrafts = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('claudeSpecDrafts', 'search', 'statusFilter'));

        return null;
    }

    public function employee_send(): ?Response
    {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', SITENAME . ' | Claude Spec — New draft');
        $redirect = $this->_requireEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $employeeId = (int)$this->request->getSession()->read('Employee.id');

        if ($this->request->is('post')) {
            $brief = trim((string)$this->request->getData('project_brief'));
            if ($brief === '') {
                $this->Flash->error('Project brief is required.');
            } elseif (!$this->_checkRegenerateRateLimit($employeeId)) {
                $this->Flash->error('Generation limit reached. Please try again in an hour.');
            } else {
                $context = [
                    'client_name' => trim((string)$this->request->getData('client_name')),
                    'company' => trim((string)$this->request->getData('company')),
                    'email' => trim((string)$this->request->getData('email')),
                    'address' => trim((string)$this->request->getData('address')),
                ];
                $service = new ClaudeSpecService();
                $result = $service->generateFromBrief($brief, $context);
                if (!$result['success']) {
                    Log::error('Claude spec generation failed: ' . ($result['error'] ?? 'unknown'));
                    $this->Flash->error('AI generation failed: ' . ($result['error'] ?? 'Unknown error'));
                } else {
                    $entity = $this->ClaudeSpecDrafts->newEntity([
                        'employee_id' => $employeeId,
                        'tracknumber' => $this->ClaudeSpecDrafts->getNextTrackNumber(),
                        'project_brief' => $brief,
                        'client_name' => $context['client_name'],
                        'company' => $context['company'],
                        'email' => $context['email'],
                        'address' => $context['address'],
                        'generated_payload' => json_encode($result['payload'], JSON_UNESCAPED_UNICODE),
                        'status' => 'generated',
                    ]);
                    if ($this->ClaudeSpecDrafts->save($entity)) {
                        $this->Flash->success('Claude draft generated successfully. Review before applying to DuroEzy.');
                        return $this->redirect(['action' => 'employee_view', $entity->id]);
                    }
                    $this->Flash->error('Could not save Claude draft.');
                }
            }
        }

        $this->set('tracknumber', $this->ClaudeSpecDrafts->getNextTrackNumber());
        $this->set('draft', null);

        return null;
    }

    public function employee_view($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', SITENAME . ' | Claude Spec — View');
        $redirect = $this->_requireEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $draft = $this->_getOwnedDraft((int)$id);
        if ($draft === null) {
            return $this->redirect(['action' => 'employee_index']);
        }

        $payload = $this->_decodePayload($draft);
        $this->set(compact('draft', 'payload'));

        return null;
    }

    public function employee_edit($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', SITENAME . ' | Claude Spec — Edit');
        $redirect = $this->_requireEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $draft = $this->_getOwnedDraft((int)$id);
        if ($draft === null) {
            return $this->redirect(['action' => 'employee_index']);
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $payload = $this->_buildPayloadFromRequest();
            $draft = $this->ClaudeSpecDrafts->patchEntity($draft, [
                'project_brief' => trim((string)$this->request->getData('project_brief')),
                'client_name' => trim((string)$this->request->getData('client_name')),
                'company' => trim((string)$this->request->getData('company')),
                'email' => trim((string)$this->request->getData('email')),
                'address' => trim((string)$this->request->getData('address')),
                'generated_payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
                'status' => 'generated',
            ]);
            if ($this->ClaudeSpecDrafts->save($draft)) {
                $this->Flash->success('Draft updated.');
                return $this->redirect(['action' => 'employee_view', $draft->id]);
            }
            $this->Flash->error('Could not save changes.');
        }

        $payload = $this->_decodePayload($draft);
        $this->set(compact('draft', 'payload'));

        return null;
    }

    public function employee_regenerate($id = null): ?Response
    {
        $this->request->allowMethod(['post']);
        $redirect = $this->_requireEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $employeeId = (int)$this->request->getSession()->read('Employee.id');
        $draft = $this->_getOwnedDraft((int)$id);
        if ($draft === null) {
            return $this->redirect(['action' => 'employee_index']);
        }

        if (!$this->_checkRegenerateRateLimit($employeeId)) {
            $this->Flash->error('Generation limit reached. Please try again in an hour.');
            return $this->redirect(['action' => 'employee_view', $draft->id]);
        }

        $brief = trim((string)($draft->project_brief ?? ''));
        if ($brief === '') {
            $this->Flash->error('Project brief is empty.');
            return $this->redirect(['action' => 'employee_edit', $draft->id]);
        }

        $service = new ClaudeSpecService();
        $result = $service->generateFromBrief($brief, [
            'client_name' => (string)($draft->client_name ?? ''),
            'company' => (string)($draft->company ?? ''),
            'email' => (string)($draft->email ?? ''),
            'address' => (string)($draft->address ?? ''),
        ]);

        if (!$result['success']) {
            Log::error('Claude spec regenerate failed: ' . ($result['error'] ?? 'unknown'));
            $this->Flash->error('AI generation failed: ' . ($result['error'] ?? 'Unknown error'));
            return $this->redirect(['action' => 'employee_view', $draft->id]);
        }

        $draft->generated_payload = json_encode($result['payload'], JSON_UNESCAPED_UNICODE);
        $draft->status = 'generated';
        if ($this->ClaudeSpecDrafts->save($draft)) {
            $this->Flash->success('Draft regenerated with Claude.');
        } else {
            $this->Flash->error('Could not save regenerated draft.');
        }

        return $this->redirect(['action' => 'employee_view', $draft->id]);
    }

    public function employee_apply($id = null): ?Response
    {
        $this->request->allowMethod(['post']);
        $redirect = $this->_requireEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $draft = $this->_getOwnedDraft((int)$id);
        if ($draft === null) {
            return $this->redirect(['action' => 'employee_index']);
        }

        $payload = $this->_decodePayload($draft);
        if (empty($payload['products'])) {
            $this->Flash->error('No generated content to apply. Generate or edit the draft first.');
            return $this->redirect(['action' => 'employee_view', $draft->id]);
        }

        $service = new ClaudeSpecService();
        $header = $payload['header'] ?? [];
        $dateIso = trim((string)($header['date'] ?? ''));
        $dateDisplay = $dateIso;
        if ($dateIso !== '' && preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $dateIso, $m)) {
            $dateDisplay = $m[3] . '/' . $m[2] . '/' . $m[1];
        }

        $prefill = [
            'name' => (string)($header['name'] ?? $draft->client_name ?? ''),
            'email' => (string)($header['email'] ?? $draft->email ?? ''),
            'company' => (string)($header['company'] ?? $draft->company ?? ''),
            'address' => (string)($header['address'] ?? $draft->address ?? ''),
            'specification' => (string)($header['specification'] ?? ''),
            'subject' => (string)($header['subject'] ?? 'Durotech: External Liquid WPM'),
            'date' => $dateDisplay,
            'type' => '3',
            'comments' => $payload['comments'] ?? [],
            'sections' => $service->productsToSections($payload['products'] ?? []),
            'claude_draft_id' => (int)$draft->id,
        ];

        $this->request->getSession()->write('ClaudeSpec.prefill', $prefill);
        $this->Flash->success('Draft loaded into DuroEzy form. Review all fields before submitting.');

        return $this->redirect([
            'controller' => 'Employees',
            'action' => 'employee_send_v3',
            '?' => [
                'mode' => 'claude',
                'claude_draft_id' => (int)$draft->id,
            ],
        ]);
    }

    public function employee_delete($id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $redirect = $this->_requireEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $draft = $this->_getOwnedDraft((int)$id);
        if ($draft === null) {
            return $this->redirect(['action' => 'employee_index']);
        }

        $draft->deleted_at = FrozenTime::now();
        if ($this->ClaudeSpecDrafts->save($draft)) {
            $this->Flash->success('Claude draft deleted.');
        } else {
            $this->Flash->error('Could not delete draft.');
        }

        return $this->redirect(['action' => 'employee_index']);
    }

    protected function _requireEmployeeSession(): ?Response
    {
        $redirect = $this->checkEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }
        $employeeId = (int)$this->request->getSession()->read('Employee.id');
        if ($employeeId <= 0) {
            $this->Flash->error('Session expired. Please login again.');
            return $this->redirect(['controller' => 'Employees', 'action' => 'login']);
        }

        return null;
    }

    protected function _getOwnedDraft(int $id): ?\App\Model\Entity\ClaudeSpecDraft
    {
        if ($id <= 0) {
            $this->Flash->error('Invalid record.');
            return null;
        }
        $employeeId = (int)$this->request->getSession()->read('Employee.id');
        try {
            $draft = $this->ClaudeSpecDrafts->get($id);
        } catch (\Throwable $e) {
            $this->Flash->error('Record not found.');
            return null;
        }
        if ($draft->deleted_at !== null || (int)$draft->employee_id !== $employeeId) {
            $this->Flash->error('Record not found.');
            return null;
        }

        return $draft;
    }

    /**
     * @return array<string, mixed>
     */
    protected function _decodePayload($draft): array
    {
        $raw = (string)($draft->generated_payload ?? '');
        if ($raw === '') {
            return ['header' => [], 'comments' => [], 'products' => []];
        }
        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : ['header' => [], 'comments' => [], 'products' => []];
    }

    /**
     * @return array<string, mixed>
     */
    protected function _buildPayloadFromRequest(): array
    {
        $header = [
            'name' => trim((string)$this->request->getData('header_name')),
            'email' => trim((string)$this->request->getData('header_email')),
            'company' => trim((string)$this->request->getData('header_company')),
            'address' => trim((string)$this->request->getData('header_address')),
            'subject' => trim((string)$this->request->getData('header_subject')),
            'specification' => trim((string)$this->request->getData('header_specification')),
            'date' => trim((string)$this->request->getData('header_date')),
        ];
        $comments = array_values(array_filter(array_map('trim', (array)$this->request->getData('comments'))));
        $products = [];
        $titles = (array)$this->request->getData('product_title');
        $names = (array)$this->request->getData('product_name');
        $serials = (array)$this->request->getData('product_serial');
        $coverages = (array)$this->request->getData('product_coverage');
        $packs = (array)$this->request->getData('product_coverage_by_pack');
        $warranties = (array)$this->request->getData('product_warranty');
        $types = (array)$this->request->getData('product_types');
        $count = max(count($names), count($titles));
        for ($i = 0; $i < $count; $i++) {
            $product = trim((string)($names[$i] ?? ''));
            if ($product === '') {
                continue;
            }
            $products[] = [
                'title' => trim((string)($titles[$i] ?? 'Section')),
                'product' => $product,
                'serial' => trim((string)($serials[$i] ?? (string)($i + 1))),
                'coverage' => trim((string)($coverages[$i] ?? '')),
                'coverage_by_pack' => trim((string)($packs[$i] ?? '')),
                'Warranty' => trim((string)($warranties[$i] ?? '')),
                'types' => trim((string)($types[$i] ?? '1')),
            ];
        }

        return [
            'header' => $header,
            'comments' => $comments,
            'products' => $products,
        ];
    }

    protected function _checkRegenerateRateLimit(int $employeeId): bool
    {
        $since = FrozenTime::now()->subHour();
        $count = $this->ClaudeSpecDrafts->find()
            ->where([
                'ClaudeSpecDrafts.employee_id' => $employeeId,
                'ClaudeSpecDrafts.created >=' => $since,
            ])
            ->count();

        return $count < 10;
    }
}
