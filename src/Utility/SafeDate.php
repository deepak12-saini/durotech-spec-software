<?php
declare(strict_types=1);

namespace App\Utility;

use DateTimeInterface;

/**
 * Safe parsing/formatting for legacy MySQL datetimes (NULL, 0000-00-00) and Cake entities.
 * Avoids date() with strtotime(false) → 01 Jan 1970.
 */
final class SafeDate
{
    /**
     * @param mixed $value
     * @param array<int, mixed> $fallbacks
     */
    public static function timestamp($value, array $fallbacks = []): ?int
    {
        foreach (array_merge([$value], $fallbacks) as $v) {
            if ($v === null || $v === '') {
                continue;
            }
            if ($v instanceof DateTimeInterface) {
                $ts = $v->getTimestamp();
                if ($ts > 0) {
                    return $ts;
                }
                continue;
            }
            $s = trim((string)$v);
            if ($s === '' || strncmp($s, '0000-00-00', 10) === 0) {
                continue;
            }
            $ts = strtotime($s);
            if ($ts !== false && $ts > 0) {
                return $ts;
            }
        }

        return null;
    }

    /**
     * @param mixed $value
     * @param array<int, mixed> $fallbacks
     */
    public static function format(string $format, $value, array $fallbacks = []): string
    {
        $ts = self::timestamp($value, $fallbacks);
        if ($ts === null) {
            return '';
        }

        return date($format, $ts);
    }
}
