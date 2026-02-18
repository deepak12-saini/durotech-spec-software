<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Productions Controller (Batch Register / Batch Count Sheet)
 */
class ProductionsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('BatchRegister');   // BatchRegisterTable
        $this->loadModel('BatchCountSheet'); // BatchCountSheetTable
        $this->loadModel('NappUser');       // NappUserTable
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        $result = parent::beforeFilter($event);
        if ($result instanceof Response) {
            return $result;
        }
        $this->callConstants();
        return null;
    }

    /**
     * Admin: Batch Register list
     */
    public function adminIndex()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Batch Register List');
        $this->checkAdminSession();

        $this->paginate = [
            'limit' => 10,
            'order' => ['BatchRegister.id' => 'DESC'],
        ];
        $query = $this->BatchRegister->find()
            ->contain(['NappUser' => function ($q) {
                return $q->select(['NappUser.id', 'NappUser.name', 'NappUser.lname']);
            }]);
        $results = $this->paginate($query);
        $BatchRegisterArr = $this->_entitiesToBatchRegisterArrays($results, 'BatchRegister');
        $this->set(compact('BatchRegisterArr'));
    }

    /**
     * Admin: Add Batch Register
     */
    public function adminBatchRegisterAdd()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Add Batch Register');
        $this->checkAdminSession();

        $data = $this->request->getData();
        if (!empty($data['BatchRegister'])) {
            $batchData = $data['BatchRegister'];
            $batchData['created'] = date('Y-m-d H:i:s');
            $entity = $this->BatchRegister->newEntity($batchData);
            if ($this->BatchRegister->save($entity)) {
                $this->Flash->success('Batch register added successfully.');
                return $this->redirect(['action' => 'adminIndex']);
            }
            $this->Flash->error('The batch register could not be saved. Please, try again.');
        }
        // Get all users for dropdown
        $users = $this->NappUser->find('list', [
            'keyField' => 'id',
            'valueField' => function ($user) {
                return trim($user->name . ' ' . $user->lname);
            }
        ])->toArray();
        $this->set(compact('users'));
    }

    /**
     * Admin: Edit Batch Register
     */
    public function adminBatchRegisterEdit($id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Edit Batch Register');
        $this->checkAdminSession();

        $batchRegister = $this->BatchRegister->get($id);
        $data = $this->request->getData();
        if (!empty($data['BatchRegister'])) {
            $batchData = $data['BatchRegister'];
            $entity = $this->BatchRegister->patchEntity($batchRegister, $batchData);
            $entity->id = (int)$id;
            if ($this->BatchRegister->save($entity)) {
                $this->Flash->success('Batch register updated successfully.');
                return $this->redirect(['action' => 'adminIndex']);
            }
            $this->Flash->error('The batch register could not be saved. Please, try again.');
        }
        // Get all users for dropdown
        $users = $this->NappUser->find('list', [
            'keyField' => 'id',
            'valueField' => function ($user) {
                return trim($user->name . ' ' . $user->lname);
            }
        ])->toArray();
        $this->set(compact('batchRegister', 'users'));
    }

    /**
     * Admin: Batch Count Sheet list
     */
    public function adminBatchCountSheet()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Batch Count Sheet List');
        $this->checkAdminSession();

        $this->paginate = [
            'limit' => 10,
            'order' => ['BatchCountSheet.id' => 'DESC'],
        ];
        $query = $this->BatchCountSheet->find()
            ->contain(['NappUser' => function ($q) {
                return $q->select(['NappUser.id', 'NappUser.name', 'NappUser.lname']);
            }]);
        $results = $this->paginate($query);
        $BatchRegisterArr = $this->_entitiesToBatchRegisterArrays($results, 'BatchCountSheet');
        $this->set(compact('BatchRegisterArr'));
    }

    /**
     * Staff: Batch Register list (own records)
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Batch Register List');
        $this->checkSatffSession();

        $userId = $this->request->getSession()->read('Customer.id');
        $this->paginate = [
            'limit' => 10,
            'order' => ['BatchRegister.id' => 'DESC'],
        ];
        $query = $this->BatchRegister->find()
            ->contain(['NappUser' => function ($q) {
                return $q->select(['NappUser.id', 'NappUser.name', 'NappUser.lname']);
            }])
            ->where(['BatchRegister.user_id' => $userId]);
        $results = $this->paginate($query);
        $BatchRegisterArr = $this->_entitiesToBatchRegisterArrays($results, 'BatchRegister');
        $this->set(compact('BatchRegisterArr'));
    }

    /**
     * Staff: Add Batch Register
     */
    public function batchRegisterAdd()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Batch Register List');
        $this->checkSatffSession();

        $userId = $this->request->getSession()->read('Customer.id');
        $data = $this->request->getData('BatchRegister');
        if (!empty($data)) {
            $data['user_id'] = $userId;
            $data['created'] = date('Y-m-d H:i:s');
            $entity = $this->BatchRegister->newEntity($data);
            if ($this->BatchRegister->save($entity)) {
                $this->Flash->success('Batch register added successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    /**
     * Staff: Edit Batch Register
     */
    public function batchRegisterEdit($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Batch Register List');
        $this->checkSatffSession();

        $userId = $this->request->getSession()->read('Customer.id');
        $batchRegisterArr = $this->BatchRegister->get($id);
        $data = $this->request->getData('BatchRegister');
        if (!empty($data)) {
            $entity = $this->BatchRegister->patchEntity($batchRegisterArr, $data);
            $entity->user_id = $userId;
            $entity->id = (int)$id;
            if ($this->BatchRegister->save($entity)) {
                $this->Flash->success('Batch register added successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('batchRegisterArr'));
    }

    /**
     * Staff: Batch Count Sheet list (own records)
     */
    public function batchCountSheet()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Batch Count Sheet List');
        $this->checkSatffSession();

        $userId = $this->request->getSession()->read('Customer.id');
        $this->paginate = [
            'limit' => 10,
            'order' => ['BatchCountSheet.id' => 'DESC'],
        ];
        $query = $this->BatchCountSheet->find()
            ->contain(['NappUser' => function ($q) {
                return $q->select(['NappUser.id', 'NappUser.name', 'NappUser.lname']);
            }])
            ->where(['BatchCountSheet.user_id' => $userId]);
        $results = $this->paginate($query);
        $BatchRegisterArr = $this->_entitiesToBatchRegisterArrays($results, 'BatchCountSheet');
        $this->set(compact('BatchRegisterArr'));
    }

    /**
     * Staff: Add Batch Count Sheet
     */
    public function batchCountSheetAdd()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Batch Count Sheet List');
        $this->checkSatffSession();

        $userId = $this->request->getSession()->read('Customer.id');
        $data = $this->request->getData('BatchCountSheet');
        if (!empty($data)) {
            $data['user_id'] = $userId;
            $data['created'] = date('Y-m-d H:i:s');
            $entity = $this->BatchCountSheet->newEntity($data);
            if ($this->BatchCountSheet->save($entity)) {
                $this->Flash->success('Batch added successfully.');
                return $this->redirect(['action' => 'batchCountSheet']);
            }
        }
    }

    /**
     * Staff: Edit Batch Count Sheet
     */
    public function batchCountSheetEdit($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Batch Count Sheet List');
        $this->checkSatffSession();

        $userId = $this->request->getSession()->read('Customer.id');
        $batchCountSheetArr = $this->BatchCountSheet->get($id);
        $data = $this->request->getData('BatchCountSheet');
        if (!empty($data)) {
            $entity = $this->BatchCountSheet->patchEntity($batchCountSheetArr, $data);
            $entity->id = (int)$id;
            $entity->user_id = $userId;
            if ($this->BatchCountSheet->save($entity)) {
                $this->Flash->success('Batch added successfully.');
                return $this->redirect(['action' => 'batchCountSheet']);
            }
        }
        $this->set(compact('batchCountSheetArr'));
    }

    /**
     * Convert paginated entities to array format expected by views (CakePHP 2 style)
     * @param \Cake\ORM\ResultSet $results
     * @param string $alias 'BatchRegister' or 'BatchCountSheet'
     * @return array
     */
    protected function _entitiesToBatchRegisterArrays($results, $alias)
    {
        $out = [];
        foreach ($results as $row) {
            $napp = $row->get('napp_user') ?? $row->get('nappUser') ?? null;
            $out[] = [
                $alias => $row->toArray(),
                'NappUser' => $napp ? $napp->toArray() : [],
            ];
        }
        return $out;
    }
}
