<?php

declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;

/**
 * Contact form mailer (CakePHP 3.10 style).
 */
class ContactMailer extends Mailer
{
    /**
     * Send contact form submission to site email.
     *
     * @param array $data Keys: name, email, phone, message
     * @return \Cake\Mailer\Message
     */
    public function contactForm(array $data)
    {
        $this->setProfile('default');
        $primaryTo = defined('EMAIL') ? EMAIL : Configure::read('Site.email');
        if (!is_string($primaryTo)) {
            $primaryTo = '';
        }
        $primaryTo = trim($primaryTo);
        if ($primaryTo === '' || !filter_var($primaryTo, FILTER_VALIDATE_EMAIL)) {
            $from = Configure::read('Email.default.from');
            if (is_array($from)) {
                $primaryTo = (string)key($from);
            } elseif (is_string($from)) {
                $primaryTo = $from;
            } else {
                $primaryTo = 'info@durotechindustries.com.au';
            }
        }
        $recipients = [
            $primaryTo,
            'info@durotechindustries.com.au',
            'kal@durotechindustries.com.au',
        ];
        $recipients = array_values(array_unique(array_filter($recipients, function ($recipient) {
            return is_string($recipient) && filter_var(trim($recipient), FILTER_VALIDATE_EMAIL);
        })));

        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        if ($email !== '') {
            $this->setReplyTo([$email => $name ?: $email]);
        }
        $this->setTo($recipients)
            ->setSubject('Contact form: ' . ($name ?: 'No name'))
            ->setEmailFormat('html')
            ->setViewVars($data)
            ->viewBuilder()
            ->setClassName(\App\View\EmailView::class)
            ->setTemplate('contact_form')
            ->setLayout('default');

        // Do not call deliver() here. Mailer::send() calls _email->send() after this action returns.
    }
}
