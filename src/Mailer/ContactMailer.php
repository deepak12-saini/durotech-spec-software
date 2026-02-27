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
        $to = defined('EMAIL') ? EMAIL : Configure::read('Site.email');
        if (!is_string($to)) {
            $to = '';
        }
        $to = trim($to);
        if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $from = Configure::read('Email.default.from');
            if (is_array($from)) {
                $to = (string)key($from);
            } elseif (is_string($from)) {
                $to = $from;
            } else {
                $to = 'info@durotechindustries.com.au';
            }
        }
        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        if ($email !== '') {
            $this->setReplyTo([$email => $name ?: $email]);
        }
        $this->setTo($to)
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
