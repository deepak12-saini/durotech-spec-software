<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\Database\Driver\Mysql;
use Cake\Log\Log;
use Cake\ORM\Table;

/**
 * Mailer (specification mailer records).
 * Cake 3 Table for Mailer entity; table name may be 'mailer' or 'mailers'.
 */
class MailerTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('mailers');
        $this->setPrimaryKey('id');
        $this->belongsTo('Employee', ['foreignKey' => 'employee_id']);
        $this->belongsTo('User', ['foreignKey' => 'admin_id']);
        $this->belongsTo('NappUser', ['foreignKey' => 'user_id']);
        $this->hasMany('MailerComment', ['foreignKey' => 'mailer_id']);
        $this->hasMany('SpecUsearea', ['foreignKey' => 'mailer_id']);
    }

    /**
     * Get next sequential track number for specs (type=3).
     * Format: DTSPEC DD-MM-NNN (e.g. DTSPEC 22-07-675).
     * MAX is scoped to today's DD-MM prefix only, so other series (e.g. yy-mm admin
     * leftovers) cannot bump the sequence. Includes drafts that already reserved a number.
     *
     * @return string
     */
    public function getNextSpecTrackNumber(): string
    {
        $dd = date('d');
        $mm = date('m');
        $prefix = 'DTSPEC ' . $dd . '-' . $mm . '-';
        $like = $prefix . '%';
        $conn = $this->getConnection();
        $table = $this->getTable();
        // Same day-month series only; include reserved drafts; ignore empty / 5000+ leftovers.
        $where = 'type = 3 AND tracknumber LIKE ?'
            . " AND CAST(SUBSTRING_INDEX(TRIM(tracknumber), '-', -1) AS UNSIGNED) <= 999";

        if ($conn->getDriver() instanceof Mysql) {
            $lockName = 'cake3_dtspec_employee_track';
            $acquired = 0;
            $stmt = $conn->execute('SELECT GET_LOCK(?, 15) AS acquired', [$lockName]);
            $acquired = (int)($stmt->fetch('assoc')['acquired'] ?? 0);
            if ($acquired !== 1) {
                Log::warning('getNextSpecTrackNumber: GET_LOCK failed; allocating without lock.');
            }
            try {
                $sql = 'SELECT MAX(CAST(SUBSTRING_INDEX(TRIM(`tracknumber`), \'-\', -1) AS UNSIGNED)) AS max_code'
                    . ' FROM `' . $table . '` WHERE ' . $where;
                $row = $conn->execute($sql, [$like])->fetch('assoc');
                $next = (int)($row['max_code'] ?? 0) + 1;

                return $prefix . str_pad((string)$next, 3, '0', STR_PAD_LEFT);
            } finally {
                if ($acquired === 1) {
                    $conn->execute('SELECT RELEASE_LOCK(?)', [$lockName]);
                }
            }
        }

        $maxCode = 0;
        $rows = $this->find()
            ->where(['type' => 3, 'tracknumber LIKE' => $like])
            ->select(['tracknumber'])
            ->all();
        foreach ($rows as $r) {
            $tn = trim((string)($r->tracknumber ?? ''));
            if ($tn !== '' && preg_match('/-(\d+)$/', $tn, $m)) {
                $n = (int)$m[1];
                if ($n <= 999 && $n > $maxCode) {
                    $maxCode = $n;
                }
            }
        }

        return $prefix . str_pad((string)($maxCode + 1), 3, '0', STR_PAD_LEFT);
    }

    /**
     * Admin-style spec track number: "DTSPEC yy-mm-NNN" (e.g. DTSPEC 26-04-596).
     * Uses MAX existing suffix for the current year-month plus MySQL advisory lock so
     * two simultaneous creates cannot receive the same number (count()+1 race).
     */
    public function getNextAdminStyleSpecTrackNumber(): string
    {
        $yr = date('y');
        $mm = date('m');
        $prefix = 'DTSPEC ' . $yr . '-' . $mm . '-';
        $like = $prefix . '%';
        $conn = $this->getConnection();
        $table = $this->getTable();

        if ($conn->getDriver() instanceof Mysql) {
            $lockName = 'cake3_dtspec_admin_track';
            $acquired = 0;
            $stmt = $conn->execute('SELECT GET_LOCK(?, 15) AS acquired', [$lockName]);
            $acquired = (int)($stmt->fetch('assoc')['acquired'] ?? 0);
            if ($acquired !== 1) {
                Log::warning('getNextAdminStyleSpecTrackNumber: GET_LOCK failed; allocating without lock.');
            }
            try {
                $sql = 'SELECT MAX(CAST(SUBSTRING_INDEX(TRIM(`tracknumber`), \'-\', -1) AS UNSIGNED)) AS max_code'
                    . ' FROM `' . $table . '` WHERE `type` = 3 AND `tracknumber` LIKE ?';
                $row = $conn->execute($sql, [$like])->fetch('assoc');
                $next = (int)($row['max_code'] ?? 0) + 1;
                $suffix = $next <= 999 ? str_pad((string)$next, 3, '0', STR_PAD_LEFT) : (string)$next;

                return $prefix . $suffix;
            } finally {
                if ($acquired === 1) {
                    $conn->execute('SELECT RELEASE_LOCK(?)', [$lockName]);
                }
            }
        }

        $sql = 'SELECT MAX(CAST(SUBSTRING_INDEX(TRIM(tracknumber), \'-\', -1) AS UNSIGNED)) AS max_code'
            . ' FROM ' . $table . ' WHERE type = 3 AND tracknumber LIKE ?';
        try {
            $row = $conn->execute($sql, [$like])->fetch('assoc');
        } catch (\Throwable $e) {
            $row = ['max_code' => 0];
        }
        $next = (int)($row['max_code'] ?? 0) + 1;
        $suffix = $next <= 999 ? str_pad((string)$next, 3, '0', STR_PAD_LEFT) : (string)$next;

        return $prefix . $suffix;
    }
}
