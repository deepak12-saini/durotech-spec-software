<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Http\Exception\NotFoundException;

/**
 * Careers Controller
 */
class CareersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('Career');
        $this->loadModel('CareerApplyJob');
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        parent::beforeFilter($event);
        $this->callConstants();
        return null;
    }

    /**
     * Public apply job page
     */
    public function apply($id = null)
    {
        $this->viewBuilder()->setLayout('customduro_layout');
        $this->set('title_for_layout', SITENAME . '  | DuroTech Apply Job');

        $career = $this->Career->find()
            ->where(['Career.code' => $id, 'Career.status' => 1])
            ->first();

        if (empty($career)) {
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            // Handle file upload
            if (!empty($_FILES['file']['name'])) {
                $file = $_FILES['file'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $arr_ext = ['pdf', 'docx', 'doc', 'rtf'];
                
                if (in_array($ext, $arr_ext)) {
                    $filename = time() . $file['name'];
                    $uploadPath = WWW_ROOT . 'category' . DS;
                    
                    // Create directory if it doesn't exist
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    
                    if (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) {
                        $data['CareerApplyJob']['resume'] = SITEURL . 'category/' . $filename;
                    }
                }
            }

            $data['CareerApplyJob']['created'] = date('Y-m-d H:i:s');
            $data['CareerApplyJob']['job_id'] = $career->id;

            $entity = $this->CareerApplyJob->newEntity($data['CareerApplyJob'], ['validate' => false]);
            
            if ($this->CareerApplyJob->save($entity)) {
                $name = $data['CareerApplyJob']['name'] ?? '';
                $email = $data['CareerApplyJob']['email'] ?? '';
                $phone = $data['CareerApplyJob']['phone'] ?? '';
                $description = $data['CareerApplyJob']['description'] ?? '';
                $resume = $data['CareerApplyJob']['resume'] ?? '';

                $to = 'kal@durotechindustries.com.au';
                $subject = SITENAME . " :: " . $name . " has applied job for " . $career->title;
                $template_name = 'applyjob';
                $variables = [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'description' => $description,
                    'resume' => $resume,
                    'title' => $career->title
                ];

                try {
                    $this->sendemail($to, $subject, $template_name, $variables);
                } catch (\Exception $e) {
                    // Log error if needed
                }

                $this->Flash->success('The career apply job has been updated');
                return $this->redirect(['action' => 'apply', $id]);
            } else {
                $this->Flash->error('The career apply job could not be saved. Please, try again.');
                return $this->redirect(['action' => 'apply', $id]);
            }
        }

        // Convert entity to CakePHP 2 style array for view compatibility
        $this->set('careers', ['Career' => $career->toArray()]);
    }

    /**
     * Public careers listing page
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('customduro_layout');
        $this->set('title_for_layout', SITENAME . '  | Durotech Career');

        $careers = $this->Career->find()
            ->where(['Career.status' => 1])
            ->toArray();

        // Convert to CakePHP 2 style array for view compatibility
        $careersArray = [];
        foreach ($careers as $career) {
            $careersArray[] = ['Career' => $career->toArray()];
        }

        $this->set('careers', $careersArray);
    }

    /**
     * Admin careers list
     */
    public function adminIndex()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Career');
        $this->checkAdminSession();

        $query = $this->Career->find();
        $careers = $this->paginate($query, ['limit' => 25]);

        // Convert entities to CakePHP 2 style array for view compatibility
        $careersArray = [];
        foreach ($careers as $career) {
            $careersArray[] = ['Career' => $career->toArray()];
        }

        $this->set('careers', $careersArray);
    }

    /**
     * Wrapper for admin_index
     */
    public function admin_index()
    {
        return $this->adminIndex();
    }

    /**
     * Admin view job applications
     */
    public function adminApply($id)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Career');
        $this->checkAdminSession();

        $query = $this->CareerApplyJob->find()
            ->where(['CareerApplyJob.job_id' => $id]);
        $careerApplyJobs = $this->paginate($query, ['limit' => 25]);

        // Convert entities to CakePHP 2 style array for view compatibility
        $careerApplyJobsArray = [];
        foreach ($careerApplyJobs as $applyJob) {
            $careerApplyJobsArray[] = ['CareerApplyJob' => $applyJob->toArray()];
        }

        $this->set('CareerApplyJob', $careerApplyJobsArray);

        $career = $this->Career->get($id);
        $this->set('careers', ['Career' => $career->toArray()]);
    }

    /**
     * Wrapper for admin_apply
     */
    public function admin_apply($id)
    {
        return $this->adminApply($id);
    }

    /**
     * Admin add career
     */
    public function adminAdd()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Add New Career');
        $this->checkAdminSession();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['Career']['code'] = (string)rand(1111111111, 9999999999);

            $entity = $this->Career->newEntity($data['Career'], ['validate' => false]);

            if ($this->Career->save($entity)) {
                $this->Flash->success('The Career has been saved');
                return $this->redirect(['action' => 'admin_index']);
            } else {
                $this->Flash->error('The Career could not be saved. Please, try again.');
            }
        }
    }

    /**
     * Wrapper for admin_add
     */
    public function admin_add()
    {
        return $this->adminAdd();
    }

    /**
     * Admin edit career
     */
    public function adminEdit($id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Edit Career');
        $this->checkAdminSession();

        try {
            $career = $this->Career->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            throw new NotFoundException(__('Invalid Career'));
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $data['Career']['code'] = $id;

            $entity = $this->Career->patchEntity($career, $data['Career'], ['validate' => false]);

            if ($this->Career->save($entity)) {
                $this->Flash->success('The Career has been updated');
                return $this->redirect(['action' => 'admin_index']);
            } else {
                $this->Flash->error('The Career could not be saved. Please, try again.');
            }
        } else {
            $this->set('careers', ['Career' => $career->toArray()]);
        }
    }

    /**
     * Wrapper for admin_edit
     */
    public function admin_edit($id = null)
    {
        return $this->adminEdit($id);
    }

    /**
     * Admin delete career
     */
    public function adminDelete($id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Delete');
        $this->checkAdminSession();

        try {
            $career = $this->Career->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            throw new NotFoundException(__('Invalid Career'));
        }

        if ($this->Career->delete($career)) {
            $this->Flash->success('The Career has been deleted.');
        } else {
            $this->Flash->error('The Career could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'admin_index']);
    }

    /**
     * Wrapper for admin_delete
     */
    public function admin_delete($id = null)
    {
        return $this->adminDelete($id);
    }
}
