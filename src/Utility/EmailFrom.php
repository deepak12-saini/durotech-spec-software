<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\Configure;

/**
 * Resolve outbound email From address (company address, not personal Gmail).
 */
class EmailFrom
{
    /**
     * @param array<string, mixed>|null $fromConfig e.g. WarrantyEmail['from'] or Email.default.from
     * @return array{0: string, 1: string}|null [email, display name]
     */
    public static function parseFromConfig($fromConfig, string $defaultName): ?array
    {
        if (is_array($fromConfig) && $fromConfig !== []) {
            $email = trim((string)key($fromConfig));
            $name = $fromConfig[$email] ?? $defaultName;
            if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return [$email, is_string($name) && $name !== '' ? $name : $defaultName];
            }
        }

        if (is_string($fromConfig)) {
            $email = trim($fromConfig);
            if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return [$email, $defaultName];
            }
        }

        return null;
    }

    /**
     * Default From for site emails: WarrantyEmail → Email.default → sales@.
     *
     * @return array{0: string, 1: string}
     */
    public static function resolve(string $siteName = 'Durotech Industries'): array
    {
        $warranty = self::parseFromConfig(Configure::read('WarrantyEmail.from'), $siteName);
        if ($warranty !== null) {
            return $warranty;
        }

        $default = self::parseFromConfig(Configure::read('Email.default.from'), $siteName);
        if ($default !== null) {
            return $default;
        }

        return ['sales@durotechindustries.com.au', $siteName];
    }

    /**
     * Only for local dev when Email.useSmtpAuthAddressAsFrom is true (personal Gmail SMTP).
     */
    public static function smtpAuthAddressIfAllowed(): ?string
    {
        if (!Configure::read('Email.useSmtpAuthAddressAsFrom')) {
            return null;
        }

        $transportName = (string)(Configure::read('Email.default.transport') ?? '');
        if ($transportName === '') {
            return null;
        }

        $user = Configure::read('EmailTransport.' . $transportName . '.username');
        if (is_string($user) && filter_var($user, FILTER_VALIDATE_EMAIL)) {
            return $user;
        }

        return null;
    }
}
