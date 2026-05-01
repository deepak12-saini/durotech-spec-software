<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Admin: Method Statement requests from the public website form.
 */
class MethodStatementsController extends AppController
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
        $this->loadModel('MethodStatements');
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
        $this->set('title_for_layout', SITENAME . ' Method Statement requests');
        $this->checkAdminSession();

        $query = $this->MethodStatements->find()->order(['MethodStatements.id' => 'DESC']);
        $methodStatements = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('methodStatements'));

        return null;
    }

    public function admin_view($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Method Statement request');
        $this->checkAdminSession();

        $id = (int)$id;
        $row = $this->MethodStatements->get($id);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $status = (string)($this->request->getData('status') ?? '');
            if (in_array($status, ['new', 'seen', 'done'], true)) {
                $row = $this->MethodStatements->patchEntity($row, ['status' => $status]);
                if ($this->MethodStatements->save($row)) {
                    $this->Flash->success(__('Status updated.'));
                    return $this->redirect(['action' => 'admin_view', $id]);
                }
            }
            $this->Flash->error(__('Could not update status.'));
        } elseif ($row->status === 'new') {
            $row = $this->MethodStatements->patchEntity($row, ['status' => 'seen']);
            $this->MethodStatements->save($row);
            $row = $this->MethodStatements->get($id);
        }

        $this->set('methodStatement', $row);

        return null;
    }

    public function admin_delete($id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->checkAdminSession();
        $id = (int)$id;
        $row = $this->MethodStatements->get($id);
        if ($this->MethodStatements->delete($row)) {
            $this->Flash->success(__('Deleted.'));
        } else {
            $this->Flash->error(__('Could not delete.'));
        }

        return $this->redirect(['action' => 'admin_index']);
    }
}
