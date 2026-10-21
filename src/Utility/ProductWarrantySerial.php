<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\I18n\FrozenTime;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

/**
 * System warranty serial: DT-{MM}-{YYYY}-{NNNN} (sequence resets each month).
 */
final class ProductWarrantySerial
{
    public static function prefix(?\DateTimeInterface $when = null): string
    {
        $tz = new \DateTimeZone('Australia/Sydney');
        if ($when instanceof FrozenTime) {
            $dt = $when->setTimezone($tz);
        } elseif ($when instanceof \DateTimeInterface) {
            $dt = (new FrozenTime($when->format('c')))->setTimezone($tz);
        } else {
            $dt = FrozenTime::now($tz);
        }

        return 'DT-' . $dt->format('m') . '-' . $dt->format('Y') . '-';
    }

    public static function peekNext(): string
    {
        return self::prefix() . str_pad((string)(self::maxSequence(self::prefix()) + 1), 4, '0', STR_PAD_LEFT);
    }

    public static function allocate(): string
    {
        $table = TableRegistry::getTableLocator()->get('ProductWarrantyRequests');
        $conn = $table->getConnection();
        $lockName = 'product_warranty_serial';
        $gotLock = false;
        try {
            $stmt = $conn->execute('SELECT GET_LOCK(?, 15) AS acquired', [$lockName]);
            $row = $stmt ? $stmt->fetch('assoc') : null;
            $gotLock = (int)($row['acquired'] ?? 0) === 1;
            if (!$gotLock) {
                Log::warning('ProductWarrantySerial: GET_LOCK failed; allocating without lock.');
            }
        } catch (\Throwable $e) {
            Log::warning('ProductWarrantySerial GET_LOCK: ' . $e->getMessage());
        }

        try {
            $prefix = self::prefix();
            $next = self::maxSequence($prefix) + 1;
            $serial = $prefix . str_pad((string)$next, 4, '0', STR_PAD_LEFT);
            while (self::exists($serial)) {
                $next++;
                $serial = $prefix . str_pad((string)$next, 4, '0', STR_PAD_LEFT);
            }

            return $serial;
        } finally {
            if ($gotLock) {
                try {
                    $conn->execute('SELECT RELEASE_LOCK(?)', [$lockName]);
                } catch (\Throwable $e) {
                    // ignore
                }
            }
        }
    }

    public static function maxSequence(string $prefix): int
    {
        $table = TableRegistry::getTableLocator()->get('ProductWarrantyRequests');
        $conn = $table->getConnection();
        $tbl = $table->getTable();
        $sql = 'SELECT MAX(CAST(SUBSTRING_INDEX(`serialnumber`, \'-\', -1) AS UNSIGNED)) AS max_code'
            . ' FROM `' . $tbl . '` WHERE `serialnumber` LIKE ?';
        try {
            $row = $conn->execute($sql, [$prefix . '%'])->fetch('assoc');
        } catch (\Throwable $e) {
            Log::warning('ProductWarrantySerial maxSequence: ' . $e->getMessage());
            $row = ['max_code' => 0];
        }

        return (int)($row['max_code'] ?? 0);
    }

    public static function exists(string $serial): bool
    {
        $table = TableRegistry::getTableLocator()->get('ProductWarrantyRequests');

        return $table->exists(['serialnumber' => $serial]);
    }
}
