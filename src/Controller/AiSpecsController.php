<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Event\EventInterface;
use Cake\Http\Response;
/**
 * AiSpec Waterproofing Materials Matrix (admin and employee panels)
 */
class AiSpecsController extends AppController
{
    /** @var \App\Model\Table\AiSpecsTable */
    public $AiSpecs;

    /** @var \App\Model\Table\AiSpecSectionsTable */
    public $AiSpecSections;

    /** @var \App\Model\Table\AiSpecItemsTable */
    public $AiSpecItems;

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
        $this->loadModel('AiSpecs');
        $this->loadModel('AiSpecSections');
        $this->loadModel('AiSpecItems');
    }

    public function adminIndex(): ?Response
    {
        return $this->admin_index();
    }

    public function adminSend(): ?Response
    {
        return $this->admin_send();
    }

    public function adminEdit($id = null): ?Response
    {
        return $this->admin_edit($id);
    }

    public function adminDelete($id = null): ?Response
    {
        return $this->admin_delete($id);
    }

    public function employeeIndex(): ?Response
    {
        return $this->employee_index();
    }

    public function employeeSend(): ?Response
    {
        return $this->employee_send();
    }

    public function employeeEdit($id = null): ?Response
    {
        return $this->employee_edit($id);
    }

    public function employeeDelete($id = null): ?Response
    {
        return $this->employee_delete($id);
    }

    public function admin_index(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' AiSpec materials matrix');
        $redirect = $this->checkAdminSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $query = $this->AiSpecs->find()
            ->where(['AiSpecs.deleted_at IS' => null])
            ->orderDesc('AiSpecs.id');
        $aiSpecs = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('aiSpecs'));

        return null;
    }

    public function admin_send(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' AiSpec — New matrix');
        $redirect = $this->checkAdminSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $userId = (int)$this->request->getSession()->read('User.id');
        if ($userId <= 0) {
            $this->Flash->error('Session expired. Please login again.');

            return $this->redirect(rtrim(SITEURL, '/') . '/admin');
        }

        if ($this->request->is('post')) {
            $result = $this->_processSave($userId, null, 'admin_index', false);
            if ($result instanceof Response) {
                return $result;
            }
        }

        $this->set('tracknumber', $this->AiSpecs->getNextTrackNumber());
        $this->set('aiSpec', null);
        $this->set('isEdit', false);

        return null;
    }

    public function employee_index(): ?Response
    {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', SITENAME . ' AiSpec materials matrix');
        $redirect = $this->_requireEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $aiSpecs = $this->AiSpecs->find()
            ->where(['AiSpecs.deleted_at IS' => null])
            ->orderDesc('AiSpecs.id')
            ->all();
        $this->set(compact('aiSpecs'));
        $this->set('aispecActions', $this->_employeeAispecActions());
        $this->set('showAispecStats', false);
        $this->set('showAispecWidgetTitle', false);
        $this->set('enableAispecTableSearch', true);
        $this->viewBuilder()->setTemplate('admin_index');

        return null;
    }

    public function employee_send(): ?Response
    {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', SITENAME . ' AiSpec — New matrix');
        $redirect = $this->_requireEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        if ($this->request->is('post')) {
            $result = $this->_processSave(0, null, 'employee_index', true);
            if ($result instanceof Response) {
                return $result;
            }
        }

        $this->set('tracknumber', $this->AiSpecs->getNextTrackNumber());
        $this->set('aiSpec', null);
        $this->set('isEdit', false);
        $this->set('aispecFormAction', ['action' => 'employee_send']);
        $this->set('aispecListAction', 'employee_index');
        $this->viewBuilder()->setTemplate('admin_send');

        return null;
    }

    public function employee_edit($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', SITENAME . ' AiSpec — Edit matrix');
        $redirect = $this->_requireEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $id = (int)$id;
        if ($id <= 0) {
            $this->Flash->error('Invalid record.');

            return $this->redirect(['action' => 'employee_index']);
        }

        try {
            $aiSpec = $this->AiSpecs->get($id, [
                'contain' => [
                    'AiSpecSections' => [
                        'sort' => ['AiSpecSections.sort_order' => 'ASC', 'AiSpecSections.id' => 'ASC'],
                        'AiSpecItems' => [
                            'sort' => ['AiSpecItems.sort_order' => 'ASC', 'AiSpecItems.id' => 'ASC'],
                        ],
                    ],
                ],
            ]);
        } catch (\Throwable $e) {
            $this->Flash->error('Record not found.');

            return $this->redirect(['action' => 'employee_index']);
        }

        if ($aiSpec->deleted_at !== null) {
            $this->Flash->error('Record not found.');

            return $this->redirect(['action' => 'employee_index']);
        }

        if ($this->request->is('post')) {
            $result = $this->_processSave(0, $aiSpec, 'employee_index', true);
            if ($result instanceof Response) {
                return $result;
            }
        }

        $displayTrack = trim((string)($aiSpec->tracknumber ?? ''));
        if ($displayTrack === '') {
            $displayTrack = $this->AiSpecs->getNextTrackNumber();
        }

        $this->set(compact('aiSpec'));
        $this->set('tracknumber', $displayTrack);
        $this->set('isEdit', true);
        $this->set('aispecFormAction', ['action' => 'employee_edit', $id]);
        $this->set('aispecListAction', 'employee_index');
        $this->viewBuilder()->setTemplate('admin_edit');

        return null;
    }

    public function employee_delete($id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $redirect = $this->_requireEmployeeSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $id = (int)$id;
        try {
            $aiSpec = $this->AiSpecs->get($id);
        } catch (\Throwable $e) {
            $this->Flash->error('Record not found.');

            return $this->redirect(['action' => 'employee_index']);
        }

        $aiSpec = $this->AiSpecs->patchEntity($aiSpec, ['deleted_at' => date('Y-m-d H:i:s')]);
        if ($this->AiSpecs->save($aiSpec)) {
            $this->Flash->success('AiSpec deleted.');
        } else {
            $this->Flash->error('Could not delete.');
        }

        return $this->redirect(['action' => 'employee_index']);
    }

    public function admin_edit($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' AiSpec — Edit matrix');
        $redirect = $this->checkAdminSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $userId = (int)$this->request->getSession()->read('User.id');
        $id = (int)$id;
        if ($id <= 0) {
            $this->Flash->error('Invalid record.');

            return $this->redirect(['action' => 'admin_index']);
        }

        try {
            $aiSpec = $this->AiSpecs->get($id, [
                'contain' => [
                    'AiSpecSections' => [
                        'sort' => ['AiSpecSections.sort_order' => 'ASC', 'AiSpecSections.id' => 'ASC'],
                        'AiSpecItems' => [
                            'sort' => ['AiSpecItems.sort_order' => 'ASC', 'AiSpecItems.id' => 'ASC'],
                        ],
                    ],
                ],
            ]);
        } catch (\Throwable $e) {
            $this->Flash->error('Record not found.');

            return $this->redirect(['action' => 'admin_index']);
        }

        if ($aiSpec->deleted_at !== null) {
            $this->Flash->error('Record not found.');

            return $this->redirect(['action' => 'admin_index']);
        }

        if ($this->request->is('post')) {
            $result = $this->_processSave($userId, $aiSpec, 'admin_index', false);
            if ($result instanceof Response) {
                return $result;
            }
        }

        $displayTrack = trim((string)($aiSpec->tracknumber ?? ''));
        if ($displayTrack === '') {
            $displayTrack = $this->AiSpecs->getNextTrackNumber();
        }

        $this->set(compact('aiSpec'));
        $this->set('tracknumber', $displayTrack);
        $this->set('isEdit', true);

        return null;
    }

    public function admin_delete($id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $redirect = $this->checkAdminSession();
        if ($redirect instanceof Response) {
            return $redirect;
        }

        $id = (int)$id;
        try {
            $aiSpec = $this->AiSpecs->get($id);
        } catch (\Throwable $e) {
            $this->Flash->error('Record not found.');

            return $this->redirect(['action' => 'admin_index']);
        }

        $aiSpec = $this->AiSpecs->patchEntity($aiSpec, ['deleted_at' => date('Y-m-d H:i:s')]);
        if ($this->AiSpecs->save($aiSpec)) {
            $this->Flash->success('AiSpec deleted.');
        } else {
            $this->Flash->error('Could not delete.');
        }

        return $this->redirect(['action' => 'admin_index']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
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

    /**
     * @return array<string, string>
     */
    protected function _employeeAispecActions(): array
    {
        return [
            'index' => 'employee_index',
            'send' => 'employee_send',
            'edit' => 'employee_edit',
            'delete' => 'employee_delete',
        ];
    }

    /**
     * @param int $userId Admin user id (0 when saving from employee panel)
     * @param \App\Model\Entity\AiSpec|null $existing
     * @param string $redirectAction
     * @param bool $forEmployee
     * @return \Cake\Http\Response|null
     */
    protected function _processSave(int $userId, $existing, string $redirectAction, bool $forEmployee = false): ?Response
    {
        $data = $this->request->getData();
        $saveStatus = ($data['save_action'] ?? '') === 'draft' ? 'draft' : 'submitted';

        $tracknumber = trim((string)($data['tracknumber'] ?? ''));
        if ($tracknumber === '' && $existing !== null) {
            $tracknumber = trim((string)($existing->tracknumber ?? ''));
        }
        if ($tracknumber === '') {
            $tracknumber = $this->AiSpecs->getNextTrackNumber();
        }

        $header = [
            'tracknumber' => $tracknumber,
            'project' => trim((string)($data['project'] ?? '')),
            'client' => trim((string)($data['client'] ?? '')),
            'revision' => max(1, (int)($data['revision'] ?? 1)),
            'doc_reference' => trim((string)($data['doc_reference'] ?? '')),
            'section_number' => trim((string)($data['section_number'] ?? '4')) ?: '4',
            'section_title' => trim((string)($data['section_title'] ?? 'Material Review by Area')) ?: 'Material Review by Area',
            'subsection_number' => trim((string)($data['subsection_number'] ?? '4.1')) ?: '4.1',
            'subsection_title' => trim((string)($data['subsection_title'] ?? 'Waterproofing Materials Matrix')) ?: 'Waterproofing Materials Matrix',
            'save_status' => $saveStatus,
        ];
        if ($forEmployee) {
            if ($existing === null) {
                $header['admin_id'] = 0;
            }
        } else {
            $header['admin_id'] = $userId;
        }

        $conn = ConnectionManager::get('default');
        $conn->begin();

        try {
            if ($existing !== null) {
                $entity = $this->AiSpecs->patchEntity($existing, $header);
            } else {
                $entity = $this->AiSpecs->newEntity($header);
            }

            if (!$this->AiSpecs->save($entity)) {
                $conn->rollback();
                $this->Flash->error('Could not save AiSpec header.');

                return null;
            }

            $specId = (int)$entity->id;

            $sectionIds = $this->AiSpecSections->find()
                ->select(['id'])
                ->where(['ai_spec_id' => $specId])
                ->enableHydration(false)
                ->all()
                ->extract('id')
                ->toList();

            if (!empty($sectionIds)) {
                $this->AiSpecItems->deleteAll(['ai_spec_section_id IN' => $sectionIds]);
                $this->AiSpecSections->deleteAll(['ai_spec_id' => $specId]);
            }

            $sections = $this->_normalizeSectionsFromRequest($data);
            $sectionOrder = 0;
            $savedItemCount = 0;
            foreach ($sections as $section) {
                $sectionName = $this->_cleanPlaceholderText((string)($section['name'] ?? ''));
                $standards = $this->_cleanPlaceholderText((string)($section['standards_text'] ?? ''));
                $items = (array)($section['items'] ?? []);

                $sectionHasItems = false;
                foreach ($items as $item) {
                    if (is_array($item) && $this->_itemHasContent($item)) {
                        $sectionHasItems = true;
                        break;
                    }
                }
                if ($sectionName === '' && $standards === '' && !$sectionHasItems) {
                    continue;
                }

                $sectionEntity = $this->AiSpecSections->newEntity([
                    'ai_spec_id' => $specId,
                    'name' => $sectionName,
                    'standards_text' => $standards,
                    'sort_order' => $sectionOrder++,
                ]);
                if (!$this->AiSpecSections->save($sectionEntity)) {
                    continue;
                }
                $sectionId = (int)$sectionEntity->id;
                if ($sectionId <= 0) {
                    continue;
                }

                $itemOrder = 0;
                foreach ($items as $item) {
                    if (!is_array($item) || !$this->_itemHasContent($item)) {
                        continue;
                    }
                    $wpm = trim((string)($item['wpm_code'] ?? ''));
                    $product = trim((string)($item['product_name'] ?? ''));
                    $area = trim((string)($item['application_area'] ?? ''));
                    $tagColor = trim((string)($item['tag_color'] ?? '#23550C'));
                    if ($tagColor === '') {
                        $tagColor = '#23550C';
                    }
                    if ($tagColor[0] !== '#') {
                        $tagColor = '#' . $tagColor;
                    }

                    $itemEntity = $this->AiSpecItems->newEntity([
                        'ai_spec_section_id' => $sectionId,
                        'wpm_code' => $wpm,
                        'tag_color' => $tagColor,
                        'application_area' => $area,
                        'product_name' => $product,
                        'description' => trim((string)($item['description'] ?? '')),
                        'fall_requirement' => trim((string)($item['fall_requirement'] ?? '')),
                        'sort_order' => $itemOrder++,
                    ]);
                    if ($this->AiSpecItems->save($itemEntity)) {
                        $savedItemCount++;
                    }
                }
            }

            if ($saveStatus === 'submitted' && $savedItemCount === 0) {
                $conn->rollback();
                $this->Flash->error('No material rows were saved. Please fill at least WPM code (and product details) in each row, then try again.');

                return null;
            }

            $conn->commit();
        } catch (\Throwable $e) {
            $conn->rollback();
            $this->Flash->error('Save failed: ' . $e->getMessage());

            return null;
        }

        if ($saveStatus === 'submitted') {
            if ($existing !== null && !empty($existing->pdf_attachment)) {
                $oldFile = WWW_ROOT . str_replace('/', DS, (string)$existing->pdf_attachment);
                if (is_file($oldFile)) {
                    @unlink($oldFile);
                }
            }
            $pdfPath = $this->_generatePdf($specId, $tracknumber);
            if ($pdfPath !== '') {
                $entity = $this->AiSpecs->get($specId);
                $entity = $this->AiSpecs->patchEntity($entity, ['pdf_attachment' => $pdfPath]);
                $this->AiSpecs->save($entity);
            } else {
                $this->Flash->warning('Saved but PDF generation failed. Edit and submit again to regenerate.');
            }
        }

        $this->Flash->success($saveStatus === 'draft' ? 'Draft saved.' : 'AiSpec saved and PDF generated.');

        return $this->redirect(['action' => $redirectAction]);
    }

    /**
     * Normalize sections/items from POST (fix gaps, flat single-row shape).
     *
     * @param array $data Request data
     * @return array<int, array<string, mixed>>
     */
    protected function _normalizeSectionsFromRequest(array $data): array
    {
        $sections = $data['sections'] ?? [];
        if (!is_array($sections)) {
            return [];
        }
        ksort($sections, SORT_NUMERIC);
        $normalized = [];
        foreach ($sections as $section) {
            if (!is_array($section)) {
                continue;
            }
            $items = $section['items'] ?? [];
            if (!is_array($items)) {
                $items = [];
            }
            if ($this->_isAssocItemRow($items)) {
                $items = [$items];
            } else {
                ksort($items, SORT_NUMERIC);
                $items = array_values(array_filter($items, 'is_array'));
            }
            $section['items'] = $items;
            $normalized[] = $section;
        }

        return $normalized;
    }

    protected function _isAssocItemRow(array $items): bool
    {
        return isset($items['wpm_code'])
            || isset($items['product_name'])
            || isset($items['application_area'])
            || isset($items['description'])
            || isset($items['fall_requirement'])
            || isset($items['tag_color']);
    }

    protected function _itemHasContent(array $item): bool
    {
        foreach (['wpm_code', 'application_area', 'product_name', 'description', 'fall_requirement'] as $field) {
            if (trim((string)($item[$field] ?? '')) !== '') {
                return true;
            }
        }

        return false;
    }

    protected function _cleanPlaceholderText(string $value): string
    {
        $value = trim($value);
        if ($value === '') {
            return '';
        }
        if (stripos($value, 'e.g. ') === 0) {
            return '';
        }

        return $value;
    }

    protected function _generatePdf(int $aiSpecId, string $tracknumber): string
    {
        $pdfname = $aiSpecId . '-' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $tracknumber);
        $fields = [
            'ai_spec_id' => (string)$aiSpecId,
            'pdfname' => $pdfname,
        ];
        $fieldsString = http_build_query($fields);
        $url = SITEURL . 'dompdf/generate_aispec_pdf.php?' . $fieldsString;
        $ctx = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);
        $result = @file_get_contents($url, false, $ctx);
        if ($result === false) {
            return '';
        }
        $json = json_decode((string)$result, true);
        if (!is_array($json) || empty($json['success'])) {
            return '';
        }

        return (string)($json['path'] ?? '');
    }
}
