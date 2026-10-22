<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\SpecProjectsTable;
use Cake\Http\Response;
use Cake\I18n\FrozenDate;

class SpecHubController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('SpecProjects');
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
        $rows = [];
        foreach ($query->all() as $entity) {
            $rows[] = $entity->toArray();
        }
        $this->set(compact('rows', 'q', 'stage'));
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
