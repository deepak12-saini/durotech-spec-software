<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\Configure;
use Cake\Utility\Security;

/**
 * Signed portal tokens for product warranty v2 (no extra DB column required).
 */
final class ProductWarrantyPortalToken
{
    public static function generate(int $requestId): string
    {
        $payload = (string)$requestId;
        $sig = hash_hmac('sha256', $payload, self::salt());

        return self::base64UrlEncode($payload . '|' . $sig);
    }

    public static function resolveRequestId(?string $token): ?int
    {
        if ($token === null || $token === '') {
            return null;
        }

        $decoded = self::base64UrlDecode($token);
        if ($decoded === null || strpos($decoded, '|') === false) {
            return null;
        }

        [$payload, $sig] = explode('|', $decoded, 2);
        if (!ctype_digit($payload)) {
            return null;
        }

        $expected = hash_hmac('sha256', $payload, self::salt());
        if (!hash_equals($expected, $sig)) {
            return null;
        }

        $id = (int)$payload;

        return $id > 0 ? $id : null;
    }

    private static function salt(): string
    {
        $salt = (string)Configure::read('Security.salt');

        return $salt !== '' ? $salt : 'durotech-product-warranty-v2';
    }

    private static function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $value): ?string
    {
        $padded = strtr($value, '-_', '+/');
        $mod = strlen($padded) % 4;
        if ($mod > 0) {
            $padded .= str_repeat('=', 4 - $mod);
        }
        $decoded = base64_decode($padded, true);

        return is_string($decoded) ? $decoded : null;
    }
}
