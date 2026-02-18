<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Natas Controller (CakePHP 3.10) - NATA (National Association of Testing Authorities)
 */
class NatasController extends AppController
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

    /**
     * Build array format for views (NataCategory + NataEvent)
     */
    private function _categoryToViewArray($categories): array
    {
        $out = [];
        foreach ($categories as $c) {
            $arr = ['NataCategory' => $c->toArray()];
            $events = $c->nata_events ?? [];
            $arr['NataEvent'] = is_object($events) ? iterator_to_array($events) : (array)$events;
            foreach ($arr['NataEvent'] as &$e) {
                if (is_object($e)) {
                    $e = $e->toArray();
                }
            }
            $out[] = $arr;
        }
        return $out;
    }

    /**
     * Admin: NATA list by year
     */
    public function admin_index($nextdate = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' NATA LIST');
        $this->checkAdminSession();

        $this->loadModel('NataCategories');
        $this->loadModel('NataEvents');

        if (empty($nextdate)) {
            $nextdate = (string)date('Y');
        }
        $nextdate = (string)$nextdate;

        $categories = $this->NataCategories->find()
            ->contain([
                'NataEvents' => function ($q) use ($nextdate) {
                    return $q->where(['NataEvents.year' => $nextdate]);
                },
            ])
            ->all();

        $natacategory = $this->_categoryToViewArray($categories);
        $this->set(compact('natacategory', 'nextdate'));
    }

    /**
     * Admin: update event (description/status)
     */
    public function admin_update($id = null, $status = null)
    {
        $this->checkAdminSession();
        $this->viewBuilder()->setLayout('admin_layout');

        $this->loadModel('NataEvents');
        $session = $this->request->getSession();
        $user_id = $session->read('User.id');

        $event = $this->NataEvents->get($id, ['contain' => ['NataCategories']]);
        $natacateArr = [
            'NataEvent' => $event->toArray(),
            'NataCategory' => $event->nata_category ? $event->nata_category->toArray() : [],
        ];

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $evData = $data['NataEvent'] ?? $data;
            $event = $this->NataEvents->patchEntity($event, [
                'admin_id' => $user_id,
                'description' => $evData['description'] ?? null,
                'status' => $evData['status'] ?? null,
            ]);
            if ($this->NataEvents->save($event)) {
                $this->Flash->success('Status updated successfully.');
                return $this->redirect(['action' => 'admin_update', $id, '1']);
            }
        }

        $this->set(compact('natacateArr', 'status'));
    }

    /**
     * Admin: add event
     */
    public function admin_addevent()
    {
        $this->checkAdminSession();
        $this->viewBuilder()->setLayout('admin_layout');

        $this->loadModel('NataCategories');
        $this->loadModel('NataEvents');
        $session = $this->request->getSession();
        $user_id = $session->read('User.id');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $ev = $data['NataEvent'] ?? $data;
            $monthInput = $ev['month'] ?? null;
            if ($monthInput) {
                $monthyear = date('m-Y', strtotime($monthInput));
                $year = date('Y', strtotime($monthInput));
                $date = date('Y-m-d', strtotime($monthInput));
                $existing = $this->NataEvents->find()->where(['NataEvents.month' => $monthyear])->first();
                $entity = $existing ? $this->NataEvents->patchEntity($existing, [
                    'date' => $date,
                    'month' => $monthyear,
                    'year' => $year,
                    'admin_id' => $user_id,
                    'cate_id' => $ev['cate_id'] ?? null,
                    'description' => $ev['description'] ?? null,
                ]) : $this->NataEvents->newEntity([
                    'date' => $date,
                    'month' => $monthyear,
                    'year' => $year,
                    'admin_id' => $user_id,
                    'cate_id' => $ev['cate_id'] ?? null,
                    'description' => $ev['description'] ?? null,
                ]);
                if ($this->NataEvents->save($entity)) {
                    return $this->redirect(['action' => 'admin_index']);
                }
            }
        }

        $natacateArr = [];
        foreach ($this->NataCategories->find('all') as $c) {
            $natacateArr[] = ['NataCategory' => $c->toArray()];
        }
        $this->set(compact('natacateArr'));
    }

    /**
     * Admin: add category (client type)
     */
    public function admin_clienttype_add()
    {
        $this->checkAdminSession();
        $this->viewBuilder()->setLayout('admin_layout');

        $this->loadModel('NataCategories');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $catData = $data['NataCategory'] ?? $data;
            $last = $this->NataCategories->find()->orderDesc('NataCategories.id')->first();
            $catData['unique_id'] = $last ? (1000 + (int)$last->id) : 1000;
            $entity = $this->NataCategories->newEntity($catData);
            if ($this->NataCategories->save($entity)) {
                return $this->redirect(['action' => 'admin_clienttype']);
            }
        }

        $natacate = [];
        foreach ($this->NataCategories->find('all')->where(['NataCategories.parent_id' => 0]) as $c) {
            $natacate[] = $c->toArray();
        }
        $this->set(compact('natacate'));
    }

    /**
     * Admin: edit category (client type)
     */
    public function admin_clienttype_edit($id)
    {
        $this->checkAdminSession();
        $this->viewBuilder()->setLayout('admin_layout');

        $this->loadModel('NataCategories');
        $entity = $this->NataCategories->get($id);
        $ClientTypeArr = [['NataCategory' => $entity->toArray()]];

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $catData = $data['NataCategory'] ?? $data;
            $entity = $this->NataCategories->patchEntity($entity, $catData);
            if ($this->NataCategories->save($entity)) {
                return $this->redirect(['action' => 'admin_clienttype']);
            }
        }

        $this->request = $this->request->withParsedBody(['NataCategory' => $entity->toArray()]);
        $natacate = [];
        foreach ($this->NataCategories->find('all')->where(['NataCategories.parent_id' => 0]) as $c) {
            $natacate[] = $c->toArray();
        }
        $this->set(compact('ClientTypeArr', 'natacate'));
    }

    /**
     * Admin: client type (category) list
     */
    public function admin_clienttype()
    {
        $this->checkAdminSession();
        $this->viewBuilder()->setLayout('admin_layout');

        $this->loadModel('NataCategories');
        $list = $this->NataCategories->find('all')->toArray();
        $ClientTypeArr = [];
        foreach ($list as $c) {
            $ClientTypeArr[] = ['NataCategory' => $c->toArray()];
        }
        $natacate = [];
        foreach ($ClientTypeArr as $row) {
            $natacate[$row['NataCategory']['id']] = $row['NataCategory']['name'];
        }
        $this->set(compact('ClientTypeArr', 'natacate'));
    }

    /**
     * Staff: NATA list by year
     */
    public function index($nextdate = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' NATA LIST');
        $this->checkSatffSession();

        $this->loadModel('NataCategories');
        $this->loadModel('NataEvents');

        if (empty($nextdate)) {
            $nextdate = (string)date('Y');
        }
        $nextdate = (string)$nextdate;

        $categories = $this->NataCategories->find()
            ->contain([
                'NataEvents' => function ($q) use ($nextdate) {
                    return $q->where(['NataEvents.year' => $nextdate]);
                },
            ])
            ->all();

        $natacategory = $this->_categoryToViewArray($categories);
        $this->set(compact('natacategory', 'nextdate'));
    }

    /**
     * Staff: add event
     */
    public function addevent()
    {
        $this->checkSatffSession();
        $this->viewBuilder()->setLayout('staff_inner_layout');

        $this->loadModel('NataCategories');
        $this->loadModel('NataEvents');
        $session = $this->request->getSession();
        $user_id = $session->read('Customer.id');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $ev = $data['NataEvent'] ?? $data;
            $monthInput = $ev['month'] ?? null;
            if ($monthInput) {
                $monthyear = date('m-Y', strtotime($monthInput));
                $year = date('Y', strtotime($monthInput));
                $date = date('Y-m-d', strtotime($monthInput));
                $existing = $this->NataEvents->find()->where(['NataEvents.month' => $monthyear])->first();
                $entity = $existing ? $this->NataEvents->patchEntity($existing, [
                    'date' => $date,
                    'month' => $monthyear,
                    'year' => $year,
                    'user_id' => $user_id,
                    'cate_id' => $ev['cate_id'] ?? null,
                    'description' => $ev['description'] ?? null,
                ]) : $this->NataEvents->newEntity([
                    'date' => $date,
                    'month' => $monthyear,
                    'year' => $year,
                    'user_id' => $user_id,
                    'cate_id' => $ev['cate_id'] ?? null,
                    'description' => $ev['description'] ?? null,
                ]);
                if ($this->NataEvents->save($entity)) {
                    return $this->redirect(['action' => 'index']);
                }
            }
        }

        $natacateArr = [];
        foreach ($this->NataCategories->find('all') as $c) {
            $natacateArr[] = ['NataCategory' => $c->toArray()];
        }
        $this->set(compact('natacateArr'));
    }

    /**
     * Staff: update event
     */
    public function update($id = null, $status = null)
    {
        $this->checkSatffSession();
        $this->viewBuilder()->setLayout('admin_layout');

        $this->loadModel('NataEvents');
        $session = $this->request->getSession();
        $user_id = $session->read('Customer.id');

        $event = $this->NataEvents->get($id, ['contain' => ['NataCategories']]);
        $natacateArr = [
            'NataEvent' => $event->toArray(),
            'NataCategory' => $event->nata_category ? $event->nata_category->toArray() : [],
        ];

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $evData = $data['NataEvent'] ?? $data;
            $event = $this->NataEvents->patchEntity($event, [
                'user_id' => $user_id,
                'description' => $evData['description'] ?? null,
                'status' => $evData['status'] ?? null,
            ]);
            if ($this->NataEvents->save($event)) {
                $this->Flash->success('Status updated successfully.');
                return $this->redirect(['action' => 'update', $id, '1']);
            }
        }

        $this->set(compact('natacateArr', 'status'));
    }

    /** CamelCase aliases for routing */
    public function adminIndex($nextdate = null) { return $this->admin_index($nextdate); }
    public function adminUpdate($id = null, $status = null) { return $this->admin_update($id, $status); }
    public function adminAddevent() { return $this->admin_addevent(); }
    public function adminClienttypeAdd() { return $this->admin_clienttype_add(); }
    public function adminClienttypeEdit($id) { return $this->admin_clienttype_edit($id); }
    public function adminClienttype() { return $this->admin_clienttype(); }
}
