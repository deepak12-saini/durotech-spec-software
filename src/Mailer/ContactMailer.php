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

        $normalizeList = static function ($list): array {
            if (!is_array($list)) {
                return [];
            }
            $out = [];
            foreach ($list as $addr) {
                if (!is_string($addr)) {
                    continue;
                }
                $addr = trim($addr);
                if ($addr !== '' && filter_var($addr, FILTER_VALIDATE_EMAIL)) {
                    $out[] = $addr;
                }
            }

            return array_values(array_unique($out));
        };

        $cfg = Configure::read('ContactEmail');
        $toList = [];
        $ccList = [];
        $bccList = [];
        if (is_array($cfg)) {
            $toList = $normalizeList($cfg['to'] ?? []);
            $ccList = $normalizeList($cfg['cc'] ?? []);
            $bccList = $normalizeList($cfg['bcc'] ?? []);
        }

        if ($toList === []) {
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
            $toList = [$primaryTo];
        }

        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        if ($email !== '') {
            $this->setReplyTo([$email => $name ?: $email]);
        }
        $this->setTo($toList);
        if ($ccList !== []) {
            $this->setCc($ccList);
        }
        if ($bccList !== []) {
            $this->setBcc($bccList);
        }
        $this
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
