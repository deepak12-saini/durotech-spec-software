<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\SpecProjectsTable;
use App\Utility\SpecProjectPdf;
use App\Utility\SpecRequestDraft;
use App\Utility\SpecRequestOptions;
use Cake\Http\Response;
use Cake\I18n\FrozenDate;
use Psr\Http\Message\UploadedFileInterface;

class SpecHubController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('SpecProjects');
        $this->loadModel('SpecProjectAreas');
    }

    public function adminOverview(): ?Response
    {
        return $this->admin_overview();
    }

    public function admin_overview(): ?Response
    {
        $auth = $this->checkAdminSession();
        if ($auth instanceof Response) {
            return $auth;
        }
        $this->_hubLayout('overview', 'Specification hub');
        $this->viewBuilder()->setTemplate('admin_overview');
        $table = $this->SpecProjects;
        $table->ensureTable();
        $all = $table->find()->order(['SpecProjects.follow_up_on' => 'ASC', 'SpecProjects.id' => 'DESC'])->all();
        $rows = [];
        $stats = ['active' => 0, 'review' => 0, 'issued' => 0, 'due' => 0];
        $today = date('Y-m-d');
        foreach ($all as $entity) {
            $r = $entity->toArray();
            $rows[] = $r;
            $stage = (string)($r['stage'] ?? '');
            if ($stage === 'issued') {
                $stats['issued']++;
            } else {
                $stats['active']++;
            }
            if ($stage === 'technical_review') {
                $stats['review']++;
            }
            $follow = $this->_dateString($r['follow_up_on'] ?? null);
            if ($follow !== '' && $follow <= $today && $stage !== 'issued') {
                $stats['due']++;
            }
        }
        $moves = [];
        foreach ($rows as $r) {
            if ((string)($r['stage'] ?? '') === 'issued') {
                continue;
            }
            $moves[] = $r;
            if (count($moves) >= 6) {
                break;
            }
        }
        $this->set(compact('stats', 'moves', 'rows'));
        $this->set('openEdit', (int)$this->request->getQuery('edit', 0));
        $this->set('openNew', (string)$this->request->getQuery('new', '') === '1');

        return null;
    }

    public function adminProjects(): ?Response
    {
        return $this->admin_projects();
    }

    public function admin_projects(): ?Response
    {
        $auth = $this->checkAdminSession();
        if ($auth instanceof Response) {
            return $auth;
        }
        $this->_hubLayout('projects', 'Projects');
        $this->viewBuilder()->setTemplate('admin_projects');
        $this->SpecProjects->ensureTable();
        $q = trim((string)$this->request->getQuery('q', ''));
        $stage = trim((string)$this->request->getQuery('stage', ''));
        $due = (string)$this->request->getQuery('due', '') === '1';
        $activeOnly = (string)$this->request->getQuery('active', '') === '1';
        $query = $this->SpecProjects->find()->order(['SpecProjects.id' => 'DESC']);
        if ($q !== '') {
            $like = '%' . $q . '%';
            $query->where([
                'OR' => [
                    ['SpecProjects.name LIKE' => $like],
                    ['SpecProjects.architect LIKE' => $like],
                    ['SpecProjects.code LIKE' => $like],
                    ['SpecProjects.owner LIKE' => $like],
                    ['SpecProjects.location LIKE' => $like],
                ],
            ]);
        }
        if ($stage !== '' && isset(SpecProjectsTable::STAGES[$stage])) {
            $query->where(['SpecProjects.stage' => $stage]);
        }
        if ($activeOnly) {
            $query->where(['SpecProjects.stage !=' => 'issued']);
        }
        $rows = [];
        foreach ($query->all() as $entity) {
            $r = $entity->toArray();
            if ($due) {
                $follow = $this->_dateString($r['follow_up_on'] ?? null);
                $st = (string)($r['stage'] ?? '');
                if ($follow === '' || $follow > date('Y-m-d') || $st === 'issued') {
                    continue;
                }
            }
            $rows[] = $r;
        }
        $this->set(compact('rows', 'q', 'stage', 'due', 'activeOnly'));
        $this->set('openEdit', (int)$this->request->getQuery('edit', 0));
        $this->set('openNew', (string)$this->request->getQuery('new', '') === '1');

        return null;
    }

    public function adminPipeline(): ?Response
    {
        return $this->admin_pipeline();
    }

    public function admin_pipeline(): ?Response
    {
        $auth = $this->checkAdminSession();
        if ($auth instanceof Response) {
            return $auth;
        }
        $this->_hubLayout('pipeline', 'Specification pipeline');
        $this->viewBuilder()->setTemplate('admin_pipeline');
        $this->SpecProjects->ensureTable();
        $columns = [
            'brief_received' => [],
            'drafting' => [],
            'technical_review' => [],
            'issued' => [],
        ];
        foreach ($this->SpecProjects->find()->order(['SpecProjects.id' => 'ASC'])->all() as $entity) {
            $r = $entity->toArray();
            $stage = (string)($r['stage'] ?? 'brief_received');
            if (!isset($columns[$stage])) {
                $stage = 'brief_received';
            }
            $columns[$stage][] = $r;
        }
        $this->set(compact('columns'));
        $this->set('openEdit', (int)$this->request->getQuery('edit', 0));
        $this->set('openNew', (string)$this->request->getQuery('new', '') === '1');

        return null;
    }

    public function adminDocuments(): ?Response
    {
        return $this->admin_documents();
    }

    public function admin_documents(): ?Response
    {
        $auth = $this->checkAdminSession();
        if ($auth instanceof Response) {
            return $auth;
        }
        $this->_hubLayout('documents', 'Technical documents');
        $this->viewBuilder()->setTemplate('admin_documents');
        $this->SpecProjects->ensureTable();
        $rows = [];
        foreach ($this->SpecProjects->find()->order(['SpecProjects.id' => 'DESC'])->all() as $entity) {
            $rows[] = $entity->toArray();
        }
        $this->set(compact('rows'));
        $this->set('openEdit', (int)$this->request->getQuery('edit', 0));
        $this->set('openNew', (string)$this->request->getQuery('new', '') === '1');

        return null;
    }

    public function adminSaveProject(): ?Response
    {
        return $this->admin_save_project();
    }

    public function admin_save_project(): ?Response
    {
        $auth = $this->checkAdminSession();
        if ($auth instanceof Response) {
            return $auth;
        }
        $this->SpecProjects->ensureTable();
        if (!$this->request->is(['post', 'put', 'patch'])) {
            return $this->redirect(['action' => 'admin_projects']);
        }
        $allowed = [
            'name', 'architect', 'location', 'application', 'area_m2', 'owner',
            'follow_up_on', 'stage', 'revision', 'substrate', 'proposed_system',
            'document_url', 'scope_notes', 'reviewer', 'review_date', 'review_outcome',
        ];
        $raw = $this->request->getData();
        $data = array_intersect_key(is_array($raw) ? $raw : [], array_flip($allowed));
        foreach (['follow_up_on', 'review_date'] as $df) {
            if (!isset($data[$df])) {
                continue;
            }
            $v = trim((string)$data[$df]);
            $data[$df] = $v === '' ? null : $v;
        }
        $id = (int)$this->request->getData('id', 0);
        if ($id > 0) {
            try {
                $entity = $this->SpecProjects->get($id);
            } catch (\Throwable $e) {
                $this->Flash->error('Project not found.');
                return $this->redirect($this->_returnHub());
            }
            $entity = $this->SpecProjects->patchEntity($entity, $data);
        } else {
            $session = $this->request->getSession();
            $data['created_by'] = (int)$session->read('User.id') ?: null;
            $entity = $this->SpecProjects->newEntity($data);
        }
        if ($this->SpecProjects->save($entity)) {
            $this->Flash->success((string)$entity->code . ' saved.');
        } else {
            $errs = $entity->getErrors();
            $first = 'Could not save project.';
            foreach ($errs as $field => $list) {
                if (is_array($list)) {
                    $first = (string)reset($list);
                    break;
                }
            }
            $this->Flash->error($first);
        }

        return $this->redirect($this->_returnHub((int)$entity->id));
    }

    public function adminDeleteProject(): ?Response
    {
        return $this->admin_delete_project();
    }

    public function admin_delete_project(): ?Response
    {
        $auth = $this->checkAdminSession();
        if ($auth instanceof Response) {
            return $auth;
        }
        $this->SpecProjects->ensureTable();
        if (!$this->request->is(['post', 'delete'])) {
            return $this->redirect($this->_returnHub());
        }
        $id = (int)$this->request->getData('id', 0);
        if ($id > 0) {
            try {
                $entity = $this->SpecProjects->get($id);
                $this->SpecProjects->delete($entity);
                $this->Flash->success('Project deleted.');
            } catch (\Throwable $e) {
                $this->Flash->error('Project not found.');
            }
        }

        return $this->redirect($this->_returnHub());
    }

    public function adminPrintProject($id = null): ?Response
    {
        return $this->admin_print_project($id);
    }

    public function admin_print_project($id = null): ?Response
    {
        $auth = $this->checkAdminSession();
        if ($auth instanceof Response) {
            return $auth;
        }
        $this->SpecProjects->ensureTable();
        $rid = (int)$id;
        try {
            $project = $this->SpecProjects->get($rid)->toArray();
        } catch (\Throwable $e) {
            $this->Flash->error('Project not found.');
            return $this->redirect($this->_returnHub());
        }
        if ((string)$this->request->getQuery('pdf', '') === '1') {
            $this->autoRender = false;
            $binary = SpecProjectPdf::binary($project);
            if ($binary === null || $binary === '') {
                $this->Flash->error('Could not create PDF.');
                return $this->redirect($this->_returnHub());
            }
            $code = preg_replace('/[^A-Za-z0-9_-]/', '', (string)($project['code'] ?? 'specification')) ?: 'specification';

            return $this->response
                ->withType('pdf')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $code . '-specification.pdf"')
                ->withStringBody($binary);
        }
        $this->viewBuilder()->setLayout(false);
        $this->viewBuilder()->setTemplate('admin_print_project');
        $this->set(compact('project'));

        return null;
    }

    public function adminExport(): ?Response
    {
        return $this->admin_export();
    }

    public function admin_export(): ?Response
    {
        $auth = $this->checkAdminSession();
        if ($auth instanceof Response) {
            return $auth;
        }
        $this->SpecProjects->ensureTable();
        $rows = [];
        foreach ($this->SpecProjects->find()->order(['SpecProjects.id' => 'ASC'])->all() as $entity) {
            $rows[] = $entity->toArray();
        }
        $body = json_encode(['exported_at' => date('c'), 'projects' => $rows], JSON_PRETTY_PRINT);
        $this->autoRender = false;

        return $this->response
            ->withType('json')
            ->withHeader('Content-Disposition', 'attachment; filename="spec-projects-backup.json"')
            ->withStringBody($body !== false ? $body : '{}');
    }

    public function adminImport(): ?Response
    {
        return $this->admin_import();
    }

    public function admin_import(): ?Response
    {
        $auth = $this->checkAdminSession();
        if ($auth instanceof Response) {
            return $auth;
        }
        $this->SpecProjects->ensureTable();
        if (!$this->request->is(['post', 'put', 'patch'])) {
            return $this->redirect(['action' => 'admin_overview']);
        }
        $file = $this->request->getUploadedFile('backup');
        if (!$file || $file->getError() !== UPLOAD_ERR_OK) {
            $this->Flash->error('Choose a spec-projects-backup.json file.');
            return $this->redirect(['action' => 'admin_overview']);
        }
        $decoded = json_decode((string)$file->getStream()->getContents(), true);
        $projects = [];
        if (isset($decoded['projects']) && is_array($decoded['projects'])) {
            $projects = $decoded['projects'];
        } elseif (is_array($decoded) && isset($decoded[0])) {
            $projects = $decoded;
        }
        if ($projects === []) {
            $this->Flash->error('Backup file has no projects.');
            return $this->redirect(['action' => 'admin_overview']);
        }
        $allowed = [
            'code', 'name', 'architect', 'location', 'application', 'area_m2', 'owner',
            'follow_up_on', 'stage', 'revision', 'substrate', 'proposed_system',
            'document_url', 'scope_notes', 'reviewer', 'review_date', 'review_outcome',
            'created_by', 'request_json', 'request_status', 'contact_name', 'contact_email',
            'contact_phone', 'contact_company', 'contact_role', 'source', 'internal_notes',
            'clarification', 'confirmed_issue_date', 'docs_not_available', 'docs_missing_reason',
        ];
        $added = 0;
        $updated = 0;
        foreach ($projects as $row) {
            if (!is_array($row)) {
                continue;
            }
            $data = array_intersect_key($row, array_flip($allowed));
            if (trim((string)($data['name'] ?? '')) === '') {
                continue;
            }
            foreach (['follow_up_on', 'review_date', 'confirmed_issue_date'] as $df) {
                if (!isset($data[$df])) {
                    continue;
                }
                $v = trim((string)$data[$df]);
                $data[$df] = ($v === '' || strpos($v, '0000') === 0) ? null : substr($v, 0, 10);
            }
            $code = trim((string)($data['code'] ?? ''));
            $entity = null;
            if ($code !== '') {
                $entity = $this->SpecProjects->find()->where(['code' => $code])->first();
            }
            if ($entity) {
                $entity = $this->SpecProjects->patchEntity($entity, $data);
                $updated++;
            } else {
                $entity = $this->SpecProjects->newEntity($data);
                $added++;
            }
            $this->SpecProjects->save($entity);
        }
        $this->Flash->success('Backup imported: ' . $added . ' added, ' . $updated . ' updated.');

        return $this->redirect(['action' => 'admin_overview']);
    }

    public function request(): ?Response
    {
        $this->SpecProjects->ensureTable();
        $this->viewBuilder()->setLayout('spec_request');
        $this->viewBuilder()->setTemplate('request');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Customer specification request');
        $this->set('requestNav', 'customer');

        $session = $this->request->getSession();
        if (!$session->read(SpecRequestDraft::TOKEN_KEY)) {
            $session->write(SpecRequestDraft::TOKEN_KEY, bin2hex(random_bytes(8)));
        }
        $draft = SpecRequestDraft::normalize((array)$session->read(SpecRequestDraft::SESSION_KEY));
        $step = (int)$this->request->getQuery('step', 1);
        if ($step < 1 || $step > 5) {
            $step = 1;
        }
        $errors = [];

        if ($this->request->is(['post', 'put', 'patch'])) {
            $nav = (string)$this->request->getData('_nav', 'continue');
            $draft = $this->_mergeDraftFromRequest($draft, $step);
            $session->write(SpecRequestDraft::SESSION_KEY, $draft);

            if ($nav === 'back') {
                return $this->redirect(['action' => 'request', '?' => ['step' => max(1, $step - 1)]], 303);
            }
            if ($nav === 'sync') {
                return $this->redirect(['action' => 'request', '?' => ['step' => 3]], 303);
            }
            if ($nav === 'add_custom') {
                $draft['areas'][] = SpecRequestDraft::emptyArea('custom', true);
                $session->write(SpecRequestDraft::SESSION_KEY, $draft);

                return $this->redirect(['action' => 'request', '?' => ['step' => 3]], 303);
            }
            if ($nav === 'recommend') {
                $uid = (string)$this->request->getData('target_uid', '');
                foreach ($draft['areas'] as $i => $block) {
                    if ((string)($block['uid'] ?? '') === $uid) {
                        $draft['areas'][$i]['preferred_products'] = 'Durotech recommendation';
                    }
                }
                $session->write(SpecRequestDraft::SESSION_KEY, $draft);

                return $this->redirect(['action' => 'request', '?' => ['step' => 3]], 303);
            }
            if ($nav === 'remove_area') {
                $uid = (string)$this->request->getData('target_uid', '');
                $draft['areas'] = array_values(array_filter($draft['areas'], function ($block) use ($uid) {
                    return (string)($block['uid'] ?? '') !== $uid;
                }));
                $session->write(SpecRequestDraft::SESSION_KEY, $draft);

                return $this->redirect(['action' => 'request', '?' => ['step' => 3]], 303);
            }
            if ($nav === 'submit') {
                $errors = $this->_validateDraftStep($draft, 5);
                if ($errors === []) {
                    $saved = $this->_submitCustomerRequest($draft);
                    if ($saved) {
                        $session->delete(SpecRequestDraft::SESSION_KEY);

                        return $this->redirect(['action' => 'requestThanks', '?' => ['code' => $saved]], 303);
                    }
                    $errors[] = 'Could not save your request. Please try again.';
                }
            } else {
                $errors = $this->_validateDraftStep($draft, $step);
                if ($errors === []) {
                    return $this->redirect(['action' => 'request', '?' => ['step' => min(5, $step + 1)]], 303);
                }
            }
        }

        $this->set(compact('draft', 'step', 'errors'));
        $this->set('roles', SpecRequestOptions::ROLES);
        $this->set('buildingTypes', SpecRequestOptions::BUILDING_TYPES);
        $this->set('projectStages', SpecRequestOptions::PROJECT_STAGES);
        $this->set('structures', SpecRequestOptions::STRUCTURES);
        $this->set('requestTypes', SpecRequestOptions::REQUEST_TYPES);
        $this->set('areas', SpecRequestOptions::AREAS);
        $this->set('substrates', SpecRequestOptions::SUBSTRATES);
        $this->set('conditions', SpecRequestOptions::CONDITIONS);
        $this->set('finishes', SpecRequestOptions::FINISHES);
        $this->set('exposures', SpecRequestOptions::EXPOSURES);

        return null;
    }

    public function requestThanks(): ?Response
    {
        $this->viewBuilder()->setLayout('spec_request');
        $this->viewBuilder()->setTemplate('request_thanks');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : 'Durotech') . ' | Request sent');
        $this->set('requestNav', 'customer');
        $this->set('code', (string)$this->request->getQuery('code', ''));

        return null;
    }

    public function adminRequests(): ?Response
    {
        return $this->admin_requests();
    }

    public function admin_requests(): ?Response
    {
        $auth = $this->checkAdminSession();
        if ($auth instanceof Response) {
            return $auth;
        }
        $this->_hubLayout('requests', 'Josh & management');
        $this->viewBuilder()->setTemplate('admin_requests');
        $this->SpecProjects->ensureTable();
        $q = trim((string)$this->request->getQuery('q', ''));
        $status = trim((string)$this->request->getQuery('status', ''));
        $query = $this->SpecProjects->find()
            ->contain(['SpecProjectAreas'])
            ->where(['SpecProjects.source' => 'customer'])
            ->order(['SpecProjects.id' => 'DESC']);
        if ($q !== '') {
            $like = '%' . $q . '%';
            $query->where([
                'OR' => [
                    ['SpecProjects.name LIKE' => $like],
                    ['SpecProjects.code LIKE' => $like],
                    ['SpecProjects.contact_name LIKE' => $like],
                    ['SpecProjects.contact_email LIKE' => $like],
                    ['SpecProjects.location LIKE' => $like],
                ],
            ]);
        }
        if ($status !== '' && isset(SpecRequestOptions::REQUEST_STATUSES[$status])) {
            $query->where(['SpecProjects.request_status' => $status]);
        }
        $rows = [];
        foreach ($query->all() as $entity) {
            $row = $entity->toArray();
            $row['request_decoded'] = [];
            if (!empty($row['request_json'])) {
                $decoded = json_decode((string)$row['request_json'], true);
                $row['request_decoded'] = is_array($decoded) ? $decoded : [];
            }
            $rows[] = $row;
        }
        $selectedId = (int)$this->request->getQuery('id', 0);
        $selected = null;
        foreach ($rows as $row) {
            if ((int)$row['id'] === $selectedId) {
                $selected = $row;
                break;
            }
        }
        if ($selected === null && $rows !== []) {
            $selected = $rows[0];
            $selectedId = (int)$selected['id'];
        }
        $this->set(compact('rows', 'q', 'status', 'selected', 'selectedId'));
        $this->set('requestStatuses', SpecRequestOptions::REQUEST_STATUSES);
        $this->set('openEdit', (int)$this->request->getQuery('edit', 0));
        $this->set('openNew', false);

        return null;
    }

    public function adminUpdateRequest(): ?Response
    {
        return $this->admin_update_request();
    }

    public function admin_update_request(): ?Response
    {
        $auth = $this->checkAdminSession();
        if ($auth instanceof Response) {
            return $auth;
        }
        $this->SpecProjects->ensureTable();
        if (!$this->request->is(['post', 'put', 'patch'])) {
            return $this->redirect(['action' => 'admin_requests']);
        }
        $id = (int)$this->request->getData('id', 0);
        try {
            $entity = $this->SpecProjects->get($id);
        } catch (\Throwable $e) {
            $this->Flash->error('Request not found.');
            return $this->redirect(['action' => 'admin_requests']);
        }
        $status = (string)$this->request->getData('request_status', '');
        if ($status !== '' && isset(SpecRequestOptions::REQUEST_STATUSES[$status])) {
            $entity->set('request_status', $status);
            if ($status === 'issued') {
                $entity->set('stage', 'issued');
            } elseif ($status === 'drafting') {
                $entity->set('stage', 'drafting');
            } elseif ($status === 'in_review') {
                $entity->set('stage', 'technical_review');
            }
        }
        $issue = trim((string)$this->request->getData('confirmed_issue_date', ''));
        $entity->set('confirmed_issue_date', $issue === '' ? null : $issue);
        $entity->set('internal_notes', (string)$this->request->getData('internal_notes', ''));
        $entity->set('clarification', (string)$this->request->getData('clarification', ''));
        if ($this->SpecProjects->save($entity)) {
            $this->Flash->success($entity->code . ' updated.');
        } else {
            $this->Flash->error('Could not update request.');
        }

        return $this->redirect(['action' => 'admin_requests', '?' => ['id' => $id]]);
    }

    /**
     * @param array<string, mixed> $draft
     * @return array<string, mixed>
     */
    protected function _mergeDraftFromRequest(array $draft, int $step): array
    {
        $data = $this->request->getData();
        if ($step === 1) {
            foreach (['full_name', 'company', 'email', 'mobile', 'role', 'other_contact'] as $field) {
                $draft['contact'][$field] = trim((string)($data[$field] ?? ''));
            }
        }
        if ($step === 2) {
            foreach (['name', 'address', 'building_type', 'project_stage', 'spec_required_by', 'install_date', 'structure', 'request_type', 'notes'] as $field) {
                $draft['project'][$field] = trim((string)($data[$field] ?? ''));
            }
        }
        if ($step === 3) {
            $selected = $data['selected_areas'] ?? [];
            if (!is_array($selected)) {
                $selected = [];
            }
            $selected = array_map('strval', $selected);
            $draft = SpecRequestDraft::syncAreas($draft, $selected);
            $posted = $data['areas'] ?? [];
            if (is_array($posted)) {
                foreach ($draft['areas'] as $i => $block) {
                    $uid = (string)($block['uid'] ?? '');
                    $row = [];
                    foreach ($posted as $p) {
                        if (is_array($p) && (string)($p['uid'] ?? '') === $uid) {
                            $row = $p;
                            break;
                        }
                    }
                    if ($row === []) {
                        continue;
                    }
                    foreach (['custom_label', 'area_type', 'location', 'quantity', 'substrate', 'condition', 'finish', 'exposure', 'preferred_products', 'other_brands', 'issues'] as $field) {
                        if (array_key_exists($field, $row)) {
                            $draft['areas'][$i][$field] = trim((string)$row[$field]);
                        }
                    }
                }
            }
            $uploads = $this->request->getUploadedFiles();
            $areaFiles = $uploads['area_file'] ?? [];
            if (!is_array($areaFiles)) {
                $areaFiles = [];
            }
            foreach ($draft['areas'] as $i => $block) {
                $uid = (string)($block['uid'] ?? '');
                $file = $areaFiles[$uid] ?? null;
                $stored = $this->_storeDraftUpload($file, 'area-' . $uid);
                if ($stored) {
                    $draft['areas'][$i]['file'] = $stored;
                }
            }
        }
        if ($step === 4) {
            $draft['docs']['not_available'] = !empty($data['docs_not_available']) ? 1 : 0;
            $draft['docs']['missing_reason'] = trim((string)($data['docs_missing_reason'] ?? ''));
            $draft['docs']['notes'] = trim((string)($data['docs_notes'] ?? ''));
            $uploads = $this->request->getUploadedFiles();
            $kinds = ['plans', 'site_photos', 'existing_specs', 'other_tds'];
            foreach ($kinds as $kind) {
                $file = $uploads['doc_' . $kind] ?? null;
                $stored = $this->_storeDraftUpload($file, $kind);
                if ($stored) {
                    $replaced = false;
                    foreach ($draft['docs']['files'] as $fi => $existing) {
                        if (($existing['kind'] ?? '') === $kind) {
                            $draft['docs']['files'][$fi] = $stored + ['kind' => $kind];
                            $replaced = true;
                            break;
                        }
                    }
                    if (!$replaced) {
                        $draft['docs']['files'][] = $stored + ['kind' => $kind];
                    }
                }
            }
        }
        if ($step === 5) {
            $draft['confirm'] = !empty($data['confirm']) ? 1 : 0;
        }

        return SpecRequestDraft::normalize($draft);
    }

    /**
     * @param array<string, mixed> $draft
     * @return string[]
     */
    protected function _validateDraftStep(array $draft, int $step): array
    {
        $errors = [];
        $c = $draft['contact'];
        $p = $draft['project'];
        if ($step >= 1) {
            if (trim((string)$c['full_name']) === '') {
                $errors[] = 'Full name is required.';
            }
            if (trim((string)$c['company']) === '') {
                $errors[] = 'Company is required.';
            }
            $email = trim((string)$c['email']);
            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'A valid email is required.';
            }
            if (trim((string)$c['mobile']) === '') {
                $errors[] = 'Mobile is required.';
            }
            if (!isset(SpecRequestOptions::ROLES[(string)$c['role']])) {
                $errors[] = 'Please choose your role.';
            }
        }
        if ($step >= 2) {
            if (trim((string)$p['name']) === '') {
                $errors[] = 'Project name is required.';
            }
            if (trim((string)$p['address']) === '') {
                $errors[] = 'Site address is required.';
            }
            if (!isset(SpecRequestOptions::BUILDING_TYPES[(string)$p['building_type']])) {
                $errors[] = 'Building type is required.';
            }
            if (!isset(SpecRequestOptions::PROJECT_STAGES[(string)$p['project_stage']])) {
                $errors[] = 'Project stage is required.';
            }
            if (trim((string)$p['spec_required_by']) === '') {
                $errors[] = 'Specification required by date is required.';
            }
            if (!isset(SpecRequestOptions::STRUCTURES[(string)$p['structure']])) {
                $errors[] = 'New build or existing structure is required.';
            }
            if (!isset(SpecRequestOptions::REQUEST_TYPES[(string)$p['request_type']])) {
                $errors[] = 'Request type is required.';
            }
        }
        if ($step >= 3) {
            if ($draft['areas'] === []) {
                $errors[] = 'Select at least one area.';
            }
            foreach ($draft['areas'] as $block) {
                $title = SpecRequestDraft::areaTitle($block);
                if (trim((string)($block['location'] ?? '')) === '') {
                    $errors[] = $title . ': location / level is required.';
                }
                if (!isset(SpecRequestOptions::SUBSTRATES[(string)($block['substrate'] ?? '')])) {
                    $errors[] = $title . ': substrate is required.';
                }
                if (!isset(SpecRequestOptions::CONDITIONS[(string)($block['condition'] ?? '')])) {
                    $errors[] = $title . ': substrate condition is required.';
                }
                if (!isset(SpecRequestOptions::FINISHES[(string)($block['finish'] ?? '')])) {
                    $errors[] = $title . ': final finish is required.';
                }
                if (!isset(SpecRequestOptions::EXPOSURES[(string)($block['exposure'] ?? '')])) {
                    $errors[] = $title . ': exposure is required.';
                }
                if (trim((string)($block['preferred_products'] ?? '')) === '') {
                    $errors[] = $title . ': preferred products is required.';
                }
            }
        }
        if ($step >= 4) {
            $hasFiles = false;
            foreach ((array)$draft['docs']['files'] as $f) {
                if (!empty($f['tmp']) && is_file((string)$f['tmp'])) {
                    $hasFiles = true;
                    break;
                }
            }
            if (!$hasFiles && empty($draft['docs']['not_available'])) {
                $errors[] = 'Attach documents, or mark them as not available and give a reason.';
            }
            if (!empty($draft['docs']['not_available']) && trim((string)$draft['docs']['missing_reason']) === '') {
                $errors[] = 'Please tell Josh why documents are not available.';
            }
        }
        if ($step >= 5 && empty($draft['confirm'])) {
            $errors[] = 'Please confirm the information is ready to send.';
        }

        return $errors;
    }

    /**
     * @param array<string, mixed> $draft
     */
    protected function _submitCustomerRequest(array $draft): ?string
    {
        $firstKey = (string)($draft['selected_areas'][0] ?? 'other');
        $appMap = [
            'wet_areas' => 'wet_areas',
            'balconies_terraces' => 'balconies_terraces',
            'roof' => 'roofs',
            'facade_joints' => 'facade_joints',
        ];
        $qty = [];
        foreach ($draft['areas'] as $block) {
            if (trim((string)($block['quantity'] ?? '')) !== '') {
                $qty[] = $block['quantity'];
            }
        }
        $entity = $this->SpecProjects->newEntity([
            'name' => $draft['project']['name'],
            'architect' => $draft['contact']['full_name'],
            'location' => $draft['project']['address'],
            'application' => $appMap[$firstKey] ?? 'other',
            'area_m2' => $qty !== [] ? implode(', ', $qty) : null,
            'owner' => $draft['contact']['company'],
            'follow_up_on' => $draft['project']['spec_required_by'] !== '' ? $draft['project']['spec_required_by'] : null,
            'stage' => 'brief_received',
            'substrate' => $draft['project']['notes'],
            'scope_notes' => $draft['project']['notes'],
            'request_status' => 'new_request',
            'contact_name' => $draft['contact']['full_name'],
            'contact_email' => $draft['contact']['email'],
            'contact_phone' => $draft['contact']['mobile'],
            'contact_company' => $draft['contact']['company'],
            'contact_role' => $draft['contact']['role'],
            'source' => 'customer',
            'docs_not_available' => (int)$draft['docs']['not_available'],
            'docs_missing_reason' => $draft['docs']['missing_reason'],
            'request_json' => json_encode($draft),
        ]);
        if (!$this->SpecProjects->save($entity)) {
            return null;
        }
        $id = (int)$entity->id;
        $destDir = WWW_ROOT . 'uploads' . DIRECTORY_SEPARATOR . 'spec_requests' . DIRECTORY_SEPARATOR . $id;
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }
        foreach ($draft['areas'] as $i => $block) {
            $rel = $this->_moveDraftFile($block['file'] ?? null, $destDir, $id);
            $draft['areas'][$i]['file'] = $rel ? ['path' => $rel, 'name' => is_array($block['file']) ? ($block['file']['name'] ?? '') : ''] : null;
            $this->SpecProjectAreas->save($this->SpecProjectAreas->newEntity([
                'spec_project_id' => $id,
                'area_key' => (string)($block['area_key'] ?? 'custom'),
                'custom_label' => (string)($block['custom_label'] ?? ''),
                'area_type' => (string)($block['area_type'] ?? ''),
                'location' => (string)($block['location'] ?? ''),
                'quantity' => (string)($block['quantity'] ?? ''),
                'substrate' => (string)($block['substrate'] ?? ''),
                'substrate_condition' => (string)($block['condition'] ?? ''),
                'finish' => (string)($block['finish'] ?? ''),
                'exposure' => (string)($block['exposure'] ?? ''),
                'preferred_products' => (string)($block['preferred_products'] ?? ''),
                'other_brands' => (string)($block['other_brands'] ?? ''),
                'issues' => (string)($block['issues'] ?? ''),
                'file_path' => $rel,
            ]));
        }
        foreach ($draft['docs']['files'] as $fi => $file) {
            $rel = $this->_moveDraftFile($file, $destDir, $id);
            if ($rel) {
                $draft['docs']['files'][$fi]['path'] = $rel;
                unset($draft['docs']['files'][$fi]['tmp']);
            }
        }
        $entity->set('request_json', json_encode($draft));
        $this->SpecProjects->save($entity);
        $this->_clearDraftUploads();

        return (string)$entity->code;
    }

    /**
     * @param mixed $file
     * @return array<string, string>|null
     */
    protected function _storeDraftUpload($file, string $prefix): ?array
    {
        if (!$file instanceof UploadedFileInterface || $file->getError() !== UPLOAD_ERR_OK) {
            return null;
        }
        $token = (string)$this->request->getSession()->read(SpecRequestDraft::TOKEN_KEY);
        $dir = TMP . 'spec_request' . DIRECTORY_SEPARATOR . $token;
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $orig = (string)$file->getClientFilename();
        $safe = preg_replace('/[^A-Za-z0-9._-]/', '_', $orig) ?: 'file';
        $name = $prefix . '-' . uniqid('', true) . '-' . $safe;
        $path = $dir . DIRECTORY_SEPARATOR . $name;
        $file->moveTo($path);

        return [
            'tmp' => $path,
            'name' => $orig,
        ];
    }

    /**
     * @param mixed $meta
     */
    protected function _moveDraftFile($meta, string $destDir, int $projectId): ?string
    {
        if (!is_array($meta)) {
            return null;
        }
        if (!empty($meta['path']) && empty($meta['tmp'])) {
            return (string)$meta['path'];
        }
        $tmp = (string)($meta['tmp'] ?? '');
        if ($tmp === '' || !is_file($tmp)) {
            return null;
        }
        $base = basename($tmp);
        $dest = $destDir . DIRECTORY_SEPARATOR . $base;
        @rename($tmp, $dest);

        return 'uploads/spec_requests/' . $projectId . '/' . $base;
    }

    protected function _clearDraftUploads(): void
    {
        $token = (string)$this->request->getSession()->read(SpecRequestDraft::TOKEN_KEY);
        $dir = TMP . 'spec_request' . DIRECTORY_SEPARATOR . $token;
        if (!is_dir($dir)) {
            return;
        }
        foreach (glob($dir . DIRECTORY_SEPARATOR . '*') ?: [] as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
        @rmdir($dir);
    }

    protected function _hubLayout(string $nav, string $title): void
    {
        $this->viewBuilder()->setLayout('spec_hub');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : 'Durotech') . ' | ' . $title);
        $this->set('hubNav', $nav);
        $this->set('applications', SpecProjectsTable::APPLICATIONS);
        $this->set('stages', SpecProjectsTable::STAGES);
    }

    /**
     * @return array{controller: string, action: string, '?'?: array<string, mixed>}
     */
    protected function _returnHub(?int $editId = null): array
    {
        $back = (string)$this->request->getData('return_to', '');
        $map = [
            'overview' => 'admin_overview',
            'projects' => 'admin_projects',
            'pipeline' => 'admin_pipeline',
            'documents' => 'admin_documents',
            'requests' => 'admin_requests',
        ];
        $action = $map[$back] ?? 'admin_projects';
        $url = ['controller' => 'SpecHub', 'action' => $action];
        if ($editId && $this->request->getData('keep_open')) {
            $url['?'] = ['edit' => $editId];
        }

        return $url;
    }

    /**
     * @param mixed $value
     */
    protected function _dateString($value): string
    {
        if ($value instanceof FrozenDate || $value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d');
        }
        $s = trim((string)$value);
        if ($s === '' || strpos($s, '0000') === 0) {
            return '';
        }

        return substr($s, 0, 10);
    }
}
