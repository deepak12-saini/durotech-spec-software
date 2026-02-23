<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * DebitCollections Controller (CakePHP 3.10)
 * Staff panel: debt collection list, add, edit, send notifications.
 */
class DebitCollectionsController extends AppController
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
        $this->loadModel('DebitCollections');
    }

    /**
     * List debit collections for current staff user.
     */
    public function index(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Debit Collection List');
        $res = $this->checkSatffSession();
        if ($res instanceof Response) {
            return $res;
        }
        $customer_id = $this->request->getSession()->read('Customer.id');
        if (empty($customer_id)) {
            $this->Flash->error('Invalid session.');
            return $this->redirect(['action' => 'index']);
        }
        $query = $this->DebitCollections->find()
            ->where(['DebitCollections.user_id' => $customer_id])
            ->orderDesc('DebitCollections.id');
        $results = $query->all();
        $list = [];
        foreach ($results as $entity) {
            $arr = $entity->toArray();
            // Ensure view gets all columns (entity may use different key format)
            $list[] = ['DebitCollection' => [
                'id' => $entity->get('id'),
                'invoice_id' => $entity->get('invoice_id'),
                'name' => $entity->get('name'),
                'number' => $entity->get('number'),
                'amount' => $entity->get('amount'),
                'email' => $entity->get('email'),
                'due_date' => $entity->get('due_date'),
                'status' => $entity->get('status'),
                'is_sms' => $entity->get('is_sms'),
                'is_email' => $entity->get('is_email'),
                'created' => $entity->get('created'),
                'modified_date' => $entity->get('modified_date'),
            ] + $arr];
        }
        $this->set('DebitCollection', $list);
        return null;
    }

    /**
     * Add new debit collection.
     */
    public function addnew(): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Add New Debit Collection');
        $res = $this->checkSatffSession();
        if ($res instanceof Response) {
            return $res;
        }
        $user_id = $this->request->getSession()->read('Customer.id');
        if (empty($user_id)) {
            $this->Flash->error('Invalid session.');
            return $this->redirect(['action' => 'index']);
        }
        $entity = $this->DebitCollections->newEntity([]);
        if ($this->request->is('post') && $this->request->getData()) {
            $data = $this->request->getData();
            $is_email = isset($data['is_email']) ? (int)$data['is_email'] : 0;
            $is_sms = isset($data['is_sms']) ? (int)$data['is_sms'] : 0;
            $template_1 = isset($data['template_1']) ? (int)$data['template_1'] : 0;
            $template_2 = isset($data['template_2']) ? (int)$data['template_2'] : 0;
            $template_3 = isset($data['template_3']) ? (int)$data['template_3'] : 0;
            $template_4 = isset($data['template_4']) ? (int)$data['template_4'] : 0;
            $patch = [
                'user_id' => $user_id,
                'is_email' => $is_email,
                'is_sms' => $is_sms,
                'template_1' => $template_1,
                'template_2' => $template_2,
                'template_3' => $template_3,
                'template_4' => $template_4,
                'created' => date('Y-m-d H:i:s'),
                'modified_date' => date('Y-m-d H:i:s'),
            ];
            $modelData = array_merge(
                $data['DebitCollections'] ?? [],
                $data['DebitCollection'] ?? [],
                $data['data']['DebitCollection'] ?? []
            );
            if (!empty($modelData)) {
                $patch = array_merge($modelData, $patch);
            }
            if (isset($data['status'])) {
                $patch['status'] = (int)$data['status'];
            }
            $entity = $this->DebitCollections->patchEntity($entity, $patch);
            if ($this->DebitCollections->save($entity)) {
                $this->Flash->success('Saved successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Could not save. Please try again.');
        }
        $this->set(compact('entity'));
        return null;
    }

    /**
     * Edit debit collection.
     */
    public function edit($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('staff_inner_layout');
        $this->set('title_for_layout', (defined('SITENAME') ? SITENAME : '') . ' Add New Debit Collection');
        $res = $this->checkSatffSession();
        if ($res instanceof Response) {
            return $res;
        }
        $user_id = $this->request->getSession()->read('Customer.id');
        if (empty($user_id)) {
            $this->Flash->error('Invalid session.');
            return $this->redirect(['action' => 'index']);
        }
        $entity = $this->DebitCollections->find()
            ->where(['DebitCollections.id' => $id, 'DebitCollections.user_id' => $user_id])
            ->first();
        if (!$entity) {
            $this->Flash->error('Unauthorized access.');
            return $this->redirect(['action' => 'index']);
        }
        $DebitCollection = ['DebitCollection' => $entity->toArray()];
        if ($this->request->is(['post', 'put']) && $this->request->getData()) {
            $data = $this->request->getData();
            $is_email = isset($data['is_email']) ? (int)$data['is_email'] : 0;
            $is_sms = isset($data['is_sms']) ? (int)$data['is_sms'] : 0;
            $template_1 = isset($data['template_1']) ? (int)$data['template_1'] : 0;
            $template_2 = isset($data['template_2']) ? (int)$data['template_2'] : 0;
            $template_3 = isset($data['template_3']) ? (int)$data['template_3'] : 0;
            $template_4 = isset($data['template_4']) ? (int)$data['template_4'] : 0;
            $patch = [
                'id' => $entity->id,
                'user_id' => $user_id,
                'is_email' => $is_email,
                'is_sms' => $is_sms,
                'template_1' => $template_1,
                'template_2' => $template_2,
                'template_3' => $template_3,
                'template_4' => $template_4,
                'modified_date' => date('Y-m-d H:i:s'),
            ];
            $modelData = array_merge(
                $data['DebitCollections'] ?? [],
                $data['DebitCollection'] ?? [],
                $data['data']['DebitCollection'] ?? []
            );
            if (!empty($modelData)) {
                $patch = array_merge($modelData, $patch);
            }
            if (isset($data['status'])) {
                $patch['status'] = (int)$data['status'];
            }
            $entity = $this->DebitCollections->patchEntity($entity, $patch);
            if ($this->DebitCollections->save($entity)) {
                $this->Flash->success('Saved successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Could not save. Please try again.');
        }
        $this->set('DebitCollection', $DebitCollection);
        $this->set('entity', $entity);
        return null;
    }

    /**
     * Send notifications (cron/script). No layout.
     */
    public function sendnotification(): ?Response
    {
        $this->viewBuilder()->setLayout(false);
        $this->request->allowMethod(['get', 'post']);
        $query = $this->DebitCollections->find()
            ->where(['DebitCollections.status' => 0]);
        $items = $query->all();
        $siteName = defined('SITENAME') ? SITENAME : 'Site';
        foreach ($items as $row) {
            $invoice_id = $row->invoice_id ?? '';
            $amount = $row->amount ?? '';
            $name = $row->name ?? '';
            $number = $row->number ?? '';
            $email = $row->email ?? '';
            $due_date = $row->due_date ?? '';
            $currendate = date('Y-m-d');
            $date1 = strtotime($due_date);
            $date2 = strtotime($currendate);
            $diff = abs($date2 - $date1);
            $days = (int)floor($diff / (60 * 60 * 24));
            if ($days == 0) {
                $subject = $siteName . ':- Reminder ahead of due date';
                $template_name = 'reminder-ahead-of-due-date';
                $variables = ['client_name' => $name, 'your_company' => 'Durotech Industries', 'invoice_ref_number' => $invoice_id, 'invoice_balance' => $amount, 'invoice_due_date' => date('d, M Y', strtotime($due_date)), 'sender_name' => 'Durotech'];
                $this->sendemail($email, $subject, $template_name, $variables);
            } elseif ($days == 1) {
                $subject = $siteName . ':- First overdue payment reminder template';
                $template_name = 'first-overdue-payment-reminder';
                $variables = ['client_name' => $name, 'your_company' => 'Durotech Industries', 'invoice_ref_number' => $invoice_id, 'invoice_balance' => $amount, 'invoice_due_date' => date('d, M Y', strtotime($due_date)), 'sender_name' => 'Durotech'];
                $this->sendemail($email, $subject, $template_name, $variables);
            } elseif ($days == 15) {
                $subject = $siteName . ':- Second overdue payment reminder template';
                $template_name = 'invoices-more-than-14-days-overdue';
                $variables = ['client_name' => $name, 'your_company' => 'Durotech Industries', 'invoice_ref_number' => $invoice_id, 'invoice_balance' => $amount, 'invoice_due_date' => date('d, M Y', strtotime($due_date)), 'sender_name' => 'Durotech'];
                $this->sendemail($email, $subject, $template_name, $variables);
            } elseif ($days == 30) {
                $subject = $siteName . ':- Extremely late invoices';
                $template_name = 'extremely-late-invoices';
                $variables = ['client_name' => $name, 'your_company' => 'Durotech Industries', 'invoice_ref_number' => $invoice_id, 'invoice_balance' => $amount, 'invoice_due_date' => date('d, M Y', strtotime($due_date)), 'sender_name' => 'Durotech'];
                $this->sendemail($email, $subject, $template_name, $variables);
            }
        }
        $this->response = $this->response->withStringBody('success');
        return $this->response;
    }

    /**
     * Send notification (template 1) - cron.
     */
    public function send_notification(): ?Response
    {
        $this->viewBuilder()->setLayout(false);
        $this->request->allowMethod(['get', 'post']);
        $currendate = date('Y-m-d');
        $query = $this->DebitCollections->find()
            ->where([
                'DebitCollections.status' => 0,
                'DebitCollections.template_1' => 1,
            ])
            ->where(function ($exp, $q) use ($currendate) {
                return $exp->eq($q->func('DATE', ['DebitCollections.date_1']), $currendate);
            });
        $this->_sendTemplateNotifications($query, 'date_1', 'subject_1', 'message_1', 'sms_1');
        $this->response = $this->response->withStringBody('ok');
        return $this->response;
    }

    public function send_notification_second(): ?Response
    {
        $this->viewBuilder()->setLayout(false);
        $this->request->allowMethod(['get', 'post']);
        $currendate = date('Y-m-d');
        $query = $this->DebitCollections->find()
            ->where([
                'DebitCollections.status' => 0,
                'DebitCollections.template_2' => 1,
            ])
            ->where(function ($exp, $q) use ($currendate) {
                return $exp->eq($q->func('DATE', ['DebitCollections.date_2']), $currendate);
            });
        $this->_sendTemplateNotifications($query, 'date_2', 'subject_2', 'message_2', 'sms_2');
        $this->response = $this->response->withStringBody('ok');
        return $this->response;
    }

    public function send_notification_third(): ?Response
    {
        $this->viewBuilder()->setLayout(false);
        $this->request->allowMethod(['get', 'post']);
        $currendate = date('Y-m-d');
        $query = $this->DebitCollections->find()
            ->where([
                'DebitCollections.status' => 0,
                'DebitCollections.template_3' => 1,
            ])
            ->where(function ($exp, $q) use ($currendate) {
                return $exp->eq($q->func('DATE', ['DebitCollections.date_3']), $currendate);
            });
        $this->_sendTemplateNotifications($query, 'date_3', 'subject_3', 'message_3', 'sms_3');
        $this->response = $this->response->withStringBody('ok');
        return $this->response;
    }

    public function send_notification_fourth(): ?Response
    {
        $this->viewBuilder()->setLayout(false);
        $this->request->allowMethod(['get', 'post']);
        $currendate = date('Y-m-d');
        $query = $this->DebitCollections->find()
            ->where([
                'DebitCollections.status' => 0,
                'DebitCollections.template_4' => 1,
            ])
            ->where(function ($exp, $q) use ($currendate) {
                return $exp->eq($q->func('DATE', ['DebitCollections.date_4']), $currendate);
            });
        $this->_sendTemplateNotifications($query, 'date_4', 'subject_4', 'message_4', 'sms_4');
        $this->response = $this->response->withStringBody('ok');
        return $this->response;
    }

    /**
     * Helper: send email/SMS for template notifications.
     */
    protected function _sendTemplateNotifications($query, string $dateField, string $subjectField, string $messageField, string $smsField): void
    {
        $items = $query->all();
        $template_name = 'Reminder-ahead-of-due-date';
        $from = defined('FROM_NUMBER') ? FROM_NUMBER : '';
        foreach ($items as $row) {
            $invoice_id = $row->invoice_id ?? '';
            $amount = $row->amount ?? '';
            $name = $row->name ?? '';
            $number = $row->number ?? '';
            $email = $row->email ?? '';
            $due_date = $row->due_date ?? '';
            $is_email = (int)($row->is_email ?? 0);
            $is_sms = (int)($row->is_sms ?? 0);
            $subject = $row->{$subjectField} ?? '';
            $message_1 = $row->{$messageField} ?? '';
            $sms_1 = $row->{$smsField} ?? '';
            $message = str_replace('[client_name]', $name, $message_1);
            $message = str_replace('[your_company]', 'Durotech', $message);
            $message = str_replace('[invoice_ref_number]', '#' . $invoice_id, $message);
            $message = str_replace('[invoice_balance]', '$' . $amount, $message);
            $message = str_replace('[invoice_due_date]', $due_date, $message);
            $message = str_replace('[sender_name]', 'Kal Bhinder', $message);
            $variables = ['message' => $message];
            if ($is_email == 1) {
                $this->sendemail($email, $subject, $template_name, $variables);
            }
            $sms = str_replace('[client_name]', $name, $sms_1);
            $sms = str_replace('[your_company]', 'Durotech', $sms);
            $sms = str_replace('[invoice_ref_number]', '#' . $invoice_id, $sms);
            $sms = str_replace('[invoice_balance]', '$' . $amount, $sms);
            $sms = str_replace('[invoice_due_date]', $due_date, $sms);
            $sms = str_replace('[sender_name]', 'Kal Bhinder', $sms);
            $phone = str_replace('+', '', $number);
            $to = '+' . $phone;
            if ($is_sms == 1 && $from !== '' && isset($this->Twilio) && is_object($this->Twilio) && method_exists($this->Twilio, 'sendsms')) {
                $this->Twilio->AccountSid = defined('TSID') ? TSID : '';
                $this->Twilio->AccountToken = defined('TOKEN') ? TOKEN : '';
                $this->Twilio->sendsms($to, $from, $sms);
            }
        }
    }
}
