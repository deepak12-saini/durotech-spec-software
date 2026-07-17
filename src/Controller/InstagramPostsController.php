<?php
declare(strict_types=1);

namespace App\Controller;

use App\Utility\InstagramEmbedParser;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;

/**
 * InstagramPosts Controller (CakePHP 3)
 */
class InstagramPostsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('InstagramPosts');
    }

    /**
     * Admin: list Instagram posts for home page feed
     */
    public function admin_index(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Instagram Posts');
        $this->checkAdminSession();

        $query = $this->InstagramPosts->find()
            ->orderDesc('InstagramPosts.id');

        $this->paginate = [
            'limit' => 20,
            'order' => ['InstagramPosts.id' => 'DESC'],
        ];
        $instagramPosts = $this->paginate($query);

        $this->set(compact('instagramPosts'));
        return null;
    }

    /** CamelCase alias for dispatcher/routing */
    public function adminIndex(): ?Response
    {
        return $this->admin_index();
    }

    /**
     * Admin: add or edit Instagram post
     */
    public function admin_manage($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Manage Instagram Post');
        $this->checkAdminSession();

        if ($id) {
            $instagramPost = $this->InstagramPosts->get($id);
        } else {
            $instagramPost = $this->InstagramPosts->newEntity([]);
        }

        $embedInput = '';

        if ($this->request->is(['post', 'put', 'patch'])) {
            $rawData = $this->request->getData();
            $embedInput = trim((string)($rawData['embed_input'] ?? ($rawData['InstagramPost']['embed_input'] ?? '')));

            $data = $rawData;
            if (isset($data['InstagramPost'])) {
                $data = $data['InstagramPost'];
            }

            if ($embedInput !== '') {
                $parsed = InstagramEmbedParser::parse($embedInput);
                if ($parsed === null) {
                    $this->Flash->error('Could not parse Instagram embed. Paste the embed code or a valid post/reel URL.');
                    $this->set(compact('instagramPost', 'embedInput'));
                    return null;
                }
                $data['permalink'] = $parsed['permalink'];
                $data['media_type'] = $parsed['media_type'];
            } elseif ($instagramPost->isNew()) {
                $this->Flash->error('Please paste an Instagram embed code or post URL.');
                $this->set(compact('instagramPost', 'embedInput'));
                return null;
            }

            $status = $data['status'] ?? 0;
            $data['status'] = is_array($status) ? 1 : (int)$status;
            $data['display_order'] = (int)($data['display_order'] ?? 0);

            $instagramPost = $this->InstagramPosts->patchEntity($instagramPost, $data);

            if ($this->InstagramPosts->save($instagramPost)) {
                $this->Flash->success('Instagram post saved successfully!');
                return $this->redirect(['controller' => 'InstagramPosts', 'action' => 'admin_index']);
            }
            $this->Flash->error('Failed to save Instagram post.');
        } elseif (!$instagramPost->isNew() && !empty($instagramPost->permalink)) {
            $embedInput = $instagramPost->permalink;
        }

        $this->set(compact('instagramPost', 'embedInput'));
        return null;
    }

    /** CamelCase alias for dispatcher/routing */
    public function adminManage($id = null): ?Response
    {
        return $this->admin_manage($id);
    }

    /**
     * Admin: delete Instagram post
     */
    public function admin_delete($id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->checkAdminSession();

        if (!$id || !$this->InstagramPosts->exists(['id' => $id])) {
            $this->Flash->error('Invalid Instagram post');
            return $this->redirect(['controller' => 'InstagramPosts', 'action' => 'admin_index']);
        }

        $instagramPost = $this->InstagramPosts->get($id);
        if ($this->InstagramPosts->delete($instagramPost)) {
            $this->Flash->success('Instagram post deleted successfully!');
        } else {
            $this->Flash->error('Failed to delete Instagram post.');
        }

        return $this->redirect(['controller' => 'InstagramPosts', 'action' => 'admin_index']);
    }

    /** CamelCase alias for dispatcher/routing */
    public function adminDelete($id = null): ?Response
    {
        return $this->admin_delete($id);
    }

    /**
     * Admin: toggle active status
     */
    public function admin_toggleStatus($id = null): ?Response
    {
        $this->request->allowMethod(['get', 'post']);
        $this->checkAdminSession();

        if (!$id || !$this->InstagramPosts->exists(['id' => $id])) {
            throw new NotFoundException('Invalid Instagram post');
        }

        $instagramPost = $this->InstagramPosts->get($id);
        $instagramPost->status = $instagramPost->status ? 0 : 1;

        if ($this->InstagramPosts->save($instagramPost)) {
            $message = $instagramPost->status ? 'Instagram post activated.' : 'Instagram post hidden from home page.';
            $this->Flash->success($message);
        } else {
            $this->Flash->error('Unable to update status.');
        }

        return $this->redirect(['controller' => 'InstagramPosts', 'action' => 'admin_index']);
    }

    /** CamelCase alias for dispatcher/routing */
    public function adminToggleStatus($id = null): ?Response
    {
        return $this->admin_toggleStatus($id);
    }
}
