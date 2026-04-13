<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use DateTimeInterface;

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
        $candidates = array_merge([$value], $fallbacks);
        foreach ($candidates as $v) {
            if ($v === null || $v === '') {
                continue;
            }
            if ($v instanceof DateTimeInterface) {
                $ts = $v->getTimestamp();
                if ($ts > 0) {
                    return $v->format($format);
                }
                continue;
            }
            $s = trim((string)$v);
            if ($s === '' || strncmp($s, '0000-00-00', 10) === 0) {
                continue;
            }
            $ts = strtotime($s);
            if ($ts !== false && $ts > 0) {
                return date($format, $ts);
            }
        }

        return '';
    }
}
