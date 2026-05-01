<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Admin: Quick Spec requests from the public website form.
 */
class QuickSpecsController extends AppController
{
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
        $this->loadModel('QuickSpecs');
    }

    public function adminIndex(): ?Response
    {
        return $this->admin_index();
    }

    public function adminView($id = null): ?Response
    {
        return $this->admin_view($id);
    }

    public function adminDelete($id = null): ?Response
    {
        return $this->admin_delete($id);
    }

    public function admin_index(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Quick Spec requests');
        $this->checkAdminSession();

        $query = $this->QuickSpecs->find()->order(['QuickSpecs.id' => 'DESC']);
        $quickSpecs = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('quickSpecs'));

        return null;
    }

    public function admin_view($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Quick Spec request');
        $this->checkAdminSession();

        $id = (int)$id;
        $spec = $this->QuickSpecs->get($id);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $status = (string)($this->request->getData('status') ?? '');
            if (in_array($status, ['new', 'seen', 'done'], true)) {
                $spec = $this->QuickSpecs->patchEntity($spec, ['status' => $status]);
                if ($this->QuickSpecs->save($spec)) {
                    $this->Flash->success(__('Status updated.'));
                    return $this->redirect(['action' => 'admin_view', $id]);
                }
            }
            $this->Flash->error(__('Could not update status.'));
        } elseif ($spec->status === 'new') {
            $spec = $this->QuickSpecs->patchEntity($spec, ['status' => 'seen']);
            $this->QuickSpecs->save($spec);
            $spec = $this->QuickSpecs->get($id);
        }

        $this->set('quickSpec', $spec);

        return null;
    }

    public function admin_delete($id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->checkAdminSession();
        $id = (int)$id;
        $spec = $this->QuickSpecs->get($id);
        if ($this->QuickSpecs->delete($spec)) {
            $this->Flash->success(__('Deleted.'));
        } else {
            $this->Flash->error(__('Could not delete.'));
        }

        return $this->redirect(['action' => 'admin_index']);
    }
}
