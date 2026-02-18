<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;

/**
 * HeroSections Controller (CakePHP 3)
 */
class HeroSectionsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('HeroSections');
    }

    /**
     * Admin: list all hero sections
     */
    public function admin_index(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Hero Sections');
        $this->checkAdminSession();

        $heroSections = $this->HeroSections->find()
            ->orderDesc('HeroSections.id')
            ->all();

        $this->set(compact('heroSections'));
        return null;
    }

    /** CamelCase alias for dispatcher/routing */
    public function adminIndex(): ?Response
    {
        return $this->admin_index();
    }

    /**
     * Admin: add or edit hero section
     */
    public function admin_manage($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Manage Hero Section');
        $this->checkAdminSession();

        if ($id) {
            $heroSection = $this->HeroSections->get($id);
        } else {
            $heroSection = $this->HeroSections->newEntity([]);
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            if (isset($data['HeroSection'])) {
                $data = $data['HeroSection'];
            }

            $status = $data['status'] ?? 0;
            $data['status'] = is_array($status) ? 1 : (int)$status;

            $videoFile = $data['video'] ?? null;
            if (is_array($videoFile) && !empty($videoFile['name']) && $videoFile['error'] === UPLOAD_ERR_OK) {
                $filename = time() . '_' . preg_replace('/\s+/', '_', $videoFile['name']);
                $uploadDir = WWW_ROOT . 'uploads' . DS . 'videos' . DS;
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                if (move_uploaded_file($videoFile['tmp_name'], $uploadDir . $filename)) {
                    $data['video'] = $filename;
                }
            } else {
                if ($heroSection->isNew()) {
                    $data['video'] = $data['video'] ?? '';
                } else {
                    unset($data['video']);
                }
            }

            $heroSection = $this->HeroSections->patchEntity($heroSection, $data);

            if ($this->HeroSections->save($heroSection)) {
                $this->Flash->success('Hero Section saved successfully!');
                return $this->redirect(['controller' => 'HeroSections', 'action' => 'admin_index']);
            }
            $this->Flash->error('Failed to save Hero Section.');
        }

        $this->set(compact('heroSection'));
        return null;
    }

    /** CamelCase alias for dispatcher/routing */
    public function adminManage($id = null): ?Response
    {
        return $this->admin_manage($id);
    }

    /**
     * Admin: delete hero section
     */
    public function admin_delete($id = null): ?Response
    {
        $this->checkAdminSession();

        if (!$id || !$this->HeroSections->exists(['id' => $id])) {
            $this->Flash->error('Invalid Hero Section');
            return $this->redirect(['controller' => 'HeroSections', 'action' => 'admin_index']);
        }

        $heroSection = $this->HeroSections->get($id);
        if ($this->HeroSections->delete($heroSection)) {
            $this->Flash->success('Hero Section deleted successfully!');
        } else {
            $this->Flash->error('Failed to delete Hero Section.');
        }

        return $this->redirect(['controller' => 'HeroSections', 'action' => 'admin_index']);
    }

    /** CamelCase alias for dispatcher/routing */
    public function adminDelete($id = null): ?Response
    {
        return $this->admin_delete($id);
    }
}
