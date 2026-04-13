<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Welcomes Controller (CakePHP 3.10) – welcome mailer
 */
class WelcomesController extends AppController
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
        $this->loadModel('Welcomes');
        $this->loadModel('WelcomeProducts');
        $this->loadModel('LabFiles');
        $this->loadModel('NappUser');
        $this->loadModel('User');
    }

    public function index(): ?Response
    {
        $user_id = $this->request->getSession()->read('Customer.id');
        if (!empty($user_id)) {
            $this->viewBuilder()->setLayout('staff_inner_layout');
        } else {
            $this->viewBuilder()->setLayout('admin_layout');
        }

        $this->set('title_for_layout', SITENAME . ' Welcome Mailer');

        $query = $this->Welcomes->find()
            ->contain(['NappUser' => ['fields' => ['name', 'lname']], 'User' => ['fields' => ['name', 'username']], 'LabFiles'])
            ->where(['Welcomes.user_id' => $user_id])
            ->orderDesc('Welcomes.id');

        $mailers = $this->paginate($query, ['limit' => 25]);
        $this->set('mailers', $mailers);
        return null;
    }

    public function sendemails($id = null): ?Response
    {
        $this->checkSatffSession();

        $mailer = $this->Welcomes->find()->where(['Welcomes.id' => $id])->first();
        if ($mailer) {
            $to = trim((string)($mailer->email ?? ''));
            if ($to === '') {
                $this->Flash->error('Recipient email is missing for this record.');
                return $this->redirect(['action' => 'index']);
            }

            $subject = (string)($mailer->subject ?? 'Durotech: Welcome Mailer');
            $priceUrl = (string)($mailer->price_url ?? '');
            if ($priceUrl === '' || stripos($priceUrl, '.pdf') === false) {
                $priceId = (int)($mailer->price_id ?? 0);
                if ($priceId > 0) {
                    $labFile = $this->LabFiles->find()->where(['LabFiles.id' => $priceId])->first();
                    if ($labFile && !empty($labFile->dir) && !empty($labFile->filename)) {
                        $priceUrl = rtrim(SITEURL, '/') . '/webroot/' . trim((string)$labFile->dir, '/') . '/' . rawurlencode((string)$labFile->filename);
                    }
                }
            }
            $variables = [
                'name' => (string)($mailer->name ?? ''),
                'message' => (string)($mailer->message ?? ''),
                'tracknumber' => (string)($mailer->tracknumber ?? ''),
                'price_url' => $priceUrl,
                'label' => (string)($mailer->label ?? ''),
            ];
            try {
                $this->sendemail($to, $subject, 'welcome_mailer', $variables);
                $this->Flash->success('Mailer sent successfully.');
            } catch (\Throwable $e) {
                $this->Flash->error('Failed to send mail. Please check email config/logs.');
            }
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error('Record not found.');
        return $this->redirect(['action' => 'index']);
    }

    public function download($id): ?Response
    {
        $this->viewBuilder()->setLayout(false);
        $path = WWW_ROOT . 'dompdf' . DIRECTORY_SEPARATOR . $id;
        if (file_exists($path)) {
            return $this->response->withFile($path, ['download' => true, 'name' => basename($id)]);
        }
        $this->Flash->error('File not found.');
        return $this->redirect(['action' => 'index']);
    }

    public function send(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Welcome Mailer');
        $this->checkSatffSession();
        $user_id = $this->request->getSession()->read('Customer.id');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $name = $data['name'] ?? '';
            $message = $data['message'] ?? '';
            $email = $data['email'] ?? '';
            $tracknumber = $data['tracknumber'] ?? '';
            $subject = $data['subject'] ?? '';
            $price_id = $data['price_id'] ?? null;

            $labFile = null;
            if ($price_id) {
                $labFile = $this->LabFiles->find()->where(['LabFiles.id' => (int)$price_id])->first();
            }
            $insert = [
                'subject' => $subject,
                'tracknumber' => $tracknumber,
                'user_id' => $user_id,
                'name' => $name,
                'message' => $message,
                'email' => $email,
                'created' => date('Y-m-d H:i:s'),
            ];
            if ($labFile) {
                $insert['label'] = $labFile->label;
                $insert['price_url'] = rtrim(SITEURL, '/') . '/webroot/' . trim((string)$labFile->dir, '/') . '/' . rawurlencode((string)$labFile->filename);
                $insert['price_id'] = $labFile->id;
                $insert['price_password'] = $labFile->password;
            }

            $entity = $this->Welcomes->newEntity($insert);
            if ($this->Welcomes->save($entity)) {
                $lastinsertId = $entity->id;
                if (!empty($data['product_name']) && is_array($data['product_name'])) {
                    foreach ($data['product_name'] as $key => $prodt) {
                        $prodEntity = $this->WelcomeProducts->newEntity([
                            'welcome_id' => $lastinsertId,
                            'product_name' => $data['product_name'][$key] ?? '',
                            'weight' => $data['weight'][$key] ?? '',
                            'price' => $data['price'][$key] ?? '',
                        ]);
                        $this->WelcomeProducts->save($prodEntity);
                    }
                }

                $fields_string = http_build_query([
                    'tracknumber' => urlencode($tracknumber),
                    'mailer_id' => urlencode((string)$lastinsertId),
                    'subject' => urlencode($subject),
                ]);
                $url = rtrim(SITEURL, '/') . '/dompdf/welcomegeneratepdf.php?' . $fields_string;
                @file_get_contents($url);

                $this->Flash->success('PDF file generated successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }

        $mailerid = $this->Welcomes->find()->count();
        $id = $mailerid + 1;
        $yr = date('y');
        $mm = date('m');
        $code = str_pad((string)$id, 3, '0', STR_PAD_LEFT);
        $refernce = 'DTWL ' . $yr . '-' . $mm . '-' . $code;
        $this->set('refernce', $refernce);

        $labFiles = $this->LabFiles->find()->orderAsc('id')->all();
        $this->set('LabFile', $labFiles);
        return null;
    }

    public function edit($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', SITENAME . ' Welcome Mailer');
        $this->checkSatffSession();
        $user_id = $this->request->getSession()->read('Customer.id');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $name = $data['name'] ?? '';
            $message = $data['message'] ?? '';
            $email = $data['email'] ?? '';
            $tracknumber = $data['tracknumber'] ?? '';
            $subject = $data['subject'] ?? '';
            $price_id = $data['price_id'] ?? null;

            $labFile = null;
            if ($price_id) {
                $labFile = $this->LabFiles->find()->where(['LabFiles.id' => (int)$price_id])->first();
            }
            $insert = [
                'id' => $id,
                'subject' => $subject,
                'tracknumber' => $tracknumber,
                'user_id' => $user_id,
                'name' => $name,
                'message' => $message,
                'email' => $email,
                'created' => date('Y-m-d H:i:s'),
            ];
            if ($labFile) {
                $insert['label'] = $labFile->label;
                $insert['price_url'] = rtrim(SITEURL, '/') . '/webroot/' . trim((string)$labFile->dir, '/') . '/' . rawurlencode((string)$labFile->filename);
                $insert['price_id'] = $labFile->id;
                $insert['price_password'] = $labFile->password;
            }

            $entity = $this->Welcomes->get($id);
            $entity = $this->Welcomes->patchEntity($entity, $insert);
            if ($this->Welcomes->save($entity)) {
                $this->WelcomeProducts->deleteAll(['welcome_id' => $id]);
                if (!empty($data['product_name']) && is_array($data['product_name'])) {
                    foreach ($data['product_name'] as $key => $prodt) {
                        $prodEntity = $this->WelcomeProducts->newEntity([
                            'welcome_id' => $id,
                            'product_name' => $data['product_name'][$key] ?? '',
                            'weight' => $data['weight'][$key] ?? '',
                            'price' => $data['price'][$key] ?? '',
                        ]);
                        $this->WelcomeProducts->save($prodEntity);
                    }
                }

                $fields_string = http_build_query([
                    'tracknumber' => urlencode($tracknumber),
                    'mailer_id' => urlencode((string)$id),
                    'subject' => urlencode($subject),
                ]);
                $url = rtrim(SITEURL, '/') . '/dompdf/welcomegeneratepdf.php?' . $fields_string;
                @file_get_contents($url);

                $this->Flash->success('PDF file generated successfully.');
                return $this->redirect(['action' => 'index']);
            }
        }

        $welcomeArr = $this->Welcomes->get($id, ['contain' => ['WelcomeProducts']]);
        $this->set('WelcomeArr', $welcomeArr);

        $labFiles = $this->LabFiles->find()->orderAsc('id')->all();
        $this->set('LabFile', $labFiles);
        return null;
    }
}
