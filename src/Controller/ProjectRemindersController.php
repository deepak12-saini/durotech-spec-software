<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Project Reminders Controller
 */
class ProjectRemindersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('ProjectReminder');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->callConstants();
    }

    /**
     * Staff: Project Reminder list (own records)
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Project Reminder List');
        $this->checkSatffSession();

        $customerId = $this->request->getSession()->read('Customer.id');
        $results = $this->ProjectReminder->find('all')
            ->where(['ProjectReminder.created_by' => $customerId])
            ->orderDesc('ProjectReminder.id');
        $ProjectReminder = [];
        foreach ($results as $row) {
            $ProjectReminder[] = ['ProjectReminder' => $row->toArray()];
        }
        $this->set(compact('ProjectReminder'));
    }

    /**
     * Staff: Add Project Reminder
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Project Reminder');
        $this->checkSatffSession();

        $userId = $this->request->getSession()->read('Customer.id');
        $data = $this->request->getData();
        if (!empty($data)) {
            $isEmail = $this->request->getData('is_email');
            $saveData = $this->request->getData('ProjectReminder') ?? [];
            $saveData['is_email'] = $isEmail;
            $saveData['created_by'] = $userId;
            $saveData['datetime'] = date('Y-m-d H:i:s');
            $saveData['created'] = (string)time();

            $entity = $this->ProjectReminder->newEntity($saveData);
            if ($this->ProjectReminder->save($entity)) {
                $this->Flash->success('Project added successfully');
                return $this->redirect(['action' => 'index']);
            }
        }

        $projectcode = $this->ProjectReminder->find()->count();
        $id = $projectcode + 1;
        $yr = date('y');
        $mm = date('m');
        if (strlen((string)$id) === 1) {
            $code = '00' . $id;
        } elseif (strlen((string)$id) === 2) {
            $code = '0' . $id;
        } else {
            $code = (string)$id;
        }
        $projectCode = 'DRP-' . $code;
        $this->set('project_code', $projectCode);
    }

    /**
     * Staff: Edit Project Reminder
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Edit Project Reminder');
        $this->checkSatffSession();

        $userId = $this->request->getSession()->read('Customer.id');
        $data = $this->request->getData();
        if (!empty($data)) {
            $isEmail = $this->request->getData('is_email');
            $saveData = $this->request->getData('ProjectReminder') ?? [];
            $saveData['is_email'] = $isEmail;
            $saveData['id'] = (int)$id;
            $saveData['datetime'] = date('Y-m-d H:i:s');
            $saveData['created'] = (string)time();

            $entity = $this->ProjectReminder->get($id);
            $entity = $this->ProjectReminder->patchEntity($entity, $saveData);
            if ($this->ProjectReminder->save($entity)) {
                $this->Flash->success('Project updated successfully');
                return $this->redirect(['action' => 'index']);
            }
        }

        $projectReminder = $this->ProjectReminder->get($id);
        $ProjectReminder = ['ProjectReminder' => $projectReminder->toArray()];
        $this->set(compact('ProjectReminder'));
        $this->request = $this->request->withData('ProjectReminder', $projectReminder->toArray());
    }
}
