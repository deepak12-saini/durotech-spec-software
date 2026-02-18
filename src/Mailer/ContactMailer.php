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
        $to = defined('EMAIL') ? EMAIL : Configure::read('Site.email');
        $fromName = defined('SITENAME') ? SITENAME : Configure::read('Site.name');

        $this->setFrom([$to => $fromName])
            ->setTo($to)
            ->setSubject('Contact form: ' . ($data['name'] ?? 'No name'))
            ->setViewVars($data)
            ->viewBuilder()
            ->setTemplate('contact_form')
            ->setLayout('default');

        return $this->deliver();
    }
}
