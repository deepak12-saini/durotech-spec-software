<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Mailer\Mailer;

/**
 * Durotech logo for HTML emails (inline CID or public HTTPS URL).
 */
class EmailLogo
{
    public const CONTENT_ID = 'durotech-email-logo';
    public const RELATIVE_PATH = 'customdurotech/images/durotech_logo_new.png';

    public static function filePath(): string
    {
        return WWW_ROOT . str_replace('/', DIRECTORY_SEPARATOR, self::RELATIVE_PATH);
    }

    public static function publicUrl(): string
    {
        $configured = Configure::read('Email.logoPublicUrl');
        if (is_string($configured) && trim($configured) !== '') {
            return trim($configured);
        }

        $siteUrl = defined('SITEURL') ? rtrim((string)SITEURL, '/') : '';
        if ($siteUrl !== '' && !self::isLocalhostUrl($siteUrl . '/')) {
            return $siteUrl . '/' . self::RELATIVE_PATH;
        }

        return 'https://www.durotechindustries.com.au/' . self::RELATIVE_PATH;
    }

    public static function isLocalhostUrl(string $url): bool
    {
        return (bool)preg_match('#^https?://(localhost|127\.0\.0\.1)(:\d+)?/#i', $url);
    }

    /**
     * Attach logo inline when possible; otherwise return a public HTTPS URL.
     *
     * @param string|null $logoUrl Optional URL from caller (localhost URLs are replaced).
     */
    public static function resolveForEmail(Email $email, ?string $logoUrl = null): string
    {
        $logoUrl = trim((string)$logoUrl);
        if ($logoUrl !== '' && !self::isLocalhostUrl($logoUrl) && stripos($logoUrl, 'cid:') !== 0) {
            return $logoUrl;
        }

        $path = self::filePath();
        if (is_readable($path)) {
            $email->setAttachments([
                'durotech_logo_new.png' => [
                    'file' => $path,
                    'mimetype' => 'image/png',
                    'contentId' => self::CONTENT_ID,
                ],
            ]);

            return 'cid:' . self::CONTENT_ID;
        }

        return self::publicUrl();
    }

    /**
     * @param string|null $logoUrl
     */
    public static function resolveForMailer(Mailer $mailer, ?string $logoUrl = null): string
    {
        $logoUrl = trim((string)$logoUrl);
        if ($logoUrl !== '' && !self::isLocalhostUrl($logoUrl) && stripos($logoUrl, 'cid:') !== 0) {
            return $logoUrl;
        }

        $path = self::filePath();
        if (is_readable($path)) {
            $mailer->setAttachments([
                'durotech_logo_new.png' => [
                    'file' => $path,
                    'mimetype' => 'image/png',
                    'contentId' => self::CONTENT_ID,
                ],
            ]);

            return 'cid:' . self::CONTENT_ID;
        }

        return self::publicUrl();
    }
}
