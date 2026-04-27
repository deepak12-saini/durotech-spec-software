<?php

declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;

/**
 * Specification / EasySpec email (CakePHP 3.10).
 * Used when sending a spec PDF link to a recipient.
 */
class SpecMailer extends Mailer
{
    /**
     * Send specification email with PDF link and details.
     *
     * @param string $to Recipient email
     * @param string $subject Email subject
     * @param array $vars Keys: pdfname, name, address, company, specification, email, date
     * @return \Cake\Mailer\Message
     */
    public function sendSpec(string $to, string $subject, array $vars)
    {
        // Validate email address
        $to = trim($to);
        if (empty($to)) {
            throw new \InvalidArgumentException('Email recipient address cannot be empty.');
        }
        
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address format: ' . htmlspecialchars($to));
        }

        $fromEmail = defined('EMAIL') ? EMAIL : (Configure::read('Site.email') ?? 'noreply@example.com');
        $fromName = defined('SITENAME') ? SITENAME : (Configure::read('Site.name') ?? 'Durotech');

        // Ensure from email is valid
        if (empty($fromEmail) || !filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
            $fromEmail = 'noreply@durotechindustries.com.au';
        }

        // $this->setFrom([$fromEmail => $fromName])
        //     ->setTo($to)
        //     ->setSubject($subject)
        //     ->setViewVars($vars)
        //     ->viewBuilder()
        //     ->setTemplate('new_sendeasyspec')
        //     ->setLayout('default')
        //     ->setOptions(['ext' => 'php']);

        // return $this->deliver();

        // Prefer attachment path saved in DB.
        $attachmentPath = '';
        $attachmentName = '';
        $pdfAttachment = (string)($vars['pdf_attachment'] ?? '');
        if ($pdfAttachment !== '') {
            $candidate = WWW_ROOT . ltrim(str_replace('/', DS, $pdfAttachment), DS);
            if (is_file($candidate)) {
                $attachmentPath = $candidate;
                $attachmentName = basename($candidate);
            }
        }

        // Fallback for legacy rows where only mailer_id + tracknumber exists.
        if ($attachmentPath === '') {
            $mailerId = (int)($vars['mailer_id'] ?? 0);
            $tracknumber = (string)($vars['tracknumber'] ?? '');
            if ($mailerId > 0 && $tracknumber !== '') {
                $baseName = $mailerId . '-' . $tracknumber;
                $fallbacks = [
                    WWW_ROOT . 'dompdf' . DS . $baseName . '.pdf',
                    WWW_ROOT . 'dompdf' . DS . $baseName . '-V2.pdf',
                ];
                foreach ($fallbacks as $filePath) {
                    if (is_file($filePath)) {
                        $attachmentPath = $filePath;
                        $attachmentName = basename($filePath);
                        break;
                    }
                }
            }
        }

        $this->setFrom([$fromEmail => $fromName]);
        $this->setTo($to);
        $this->setSubject($subject);
        $this->setEmailFormat('html');
        $this->setViewVars($vars);
        if ($attachmentPath !== '') {
            $this->setAttachments([
                $attachmentName => [
                    'file' => $attachmentPath,
                    'mimetype' => 'application/pdf',
                ],
            ]);
        }

        $this->viewBuilder()
            ->setTemplate('new_sendeasyspec')
            ->setLayout('default');

        return $this; // Mailer::send() will handle delivery.
    }
}
