<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Utility\SafeDate;
use Cake\View\Helper;

/**
 * Safe formatting for legacy MySQL datetimes (e.g. 0000-00-00) and Cake entities.
 */
class DateDisplayHelper extends Helper
{
    /**
     * @param mixed $value Primary datetime
     * @param string $format PHP date() format
     * @param array<int, mixed> $fallbacks Additional values to try (e.g. modified if created is invalid)
     */
    public function mysqlDate($value, string $format = 'd F Y', array $fallbacks = []): string
    {
        return SafeDate::format($format, $value, $fallbacks);
    }

    /**
     * @param mixed $value
     * @param array<int, mixed> $fallbacks
     */
    public function mysqlTimestamp($value, array $fallbacks = []): ?int
    {
        return SafeDate::timestamp($value, $fallbacks);
    }
}
