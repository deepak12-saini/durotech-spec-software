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
     * Normalize stored/posted track numbers (strip leading # / whitespace).
     */
    public function normalizeSpecTrackNumber(string $track): string
    {
        $track = trim($track);
        if ($track !== '' && isset($track[0]) && $track[0] === '#') {
            $track = ltrim($track, "# \t");
        }

        return trim($track);
    }

    /**
     * Today's date prefix: "DTSPEC DD-MM-" (e.g. DTSPEC 03-08-).
     */
    public function currentSpecTrackPrefix(): string
    {
        return 'DTSPEC ' . date('d') . '-' . date('m') . '-';
    }

    /**
     * Whether another type=3 mailer already uses this track number.
     */
    public function isSpecTrackNumberTaken(string $track, ?int $excludeId = null): bool
    {
        $track = $this->normalizeSpecTrackNumber($track);
        if ($track === '') {
            return false;
        }

        $variants = array_values(array_unique([$track, '#' . $track]));
        $query = $this->find()
            ->select(['id'])
            ->where([
                'type' => 3,
                'tracknumber IN' => $variants,
            ]);
        if ($excludeId !== null && $excludeId > 0) {
            $query->andWhere(['id !=' => $excludeId]);
        }

        return (bool)$query->first();
    }

    /**
     * Allocate a unique track. Prefers $preferred when free and matches today's DD-MM;
     * otherwise DTSPEC DD-MM-{globalMax+1} continuing from all existing specs.
     * Uses a MySQL advisory lock so concurrent creates cannot both claim the same number.
     *
     * @param string|null $preferred Form/display track (may be stale / duplicate)
     * @param int|null $excludeId Current mailer id (draft) that may already own the track
     */
    public function allocateUniqueSpecTrackNumber(?string $preferred = null, ?int $excludeId = null): string
    {
        $preferred = $preferred !== null ? $this->normalizeSpecTrackNumber($preferred) : '';
        $conn = $this->getConnection();
        $lockName = 'cake3_dtspec_global_track';
        $acquired = 0;

        if ($conn->getDriver() instanceof Mysql) {
            $stmt = $conn->execute('SELECT GET_LOCK(?, 15) AS acquired', [$lockName]);
            $acquired = (int)($stmt->fetch('assoc')['acquired'] ?? 0);
            if ($acquired !== 1) {
                Log::warning('allocateUniqueSpecTrackNumber: GET_LOCK failed; allocating without lock.');
            }
        }

        try {
            $currentPrefix = $this->currentSpecTrackPrefix();
            // Keep preferred only when it is today's DD-MM series and not already used.
            if (
                $preferred !== ''
                && strpos($preferred, $currentPrefix) === 0
                && !$this->isSpecTrackNumberTaken($preferred, $excludeId)
            ) {
                return $preferred;
            }

            for ($i = 0; $i < 8; $i++) {
                $next = $this->_nextDdMmGlobalTrackNumberUnlocked();
                if (!$this->isSpecTrackNumberTaken($next, $excludeId)) {
                    return $next;
                }
            }

            return $this->_nextDdMmGlobalTrackNumberUnlocked();
        } finally {
            if ($acquired === 1) {
                $conn->execute('SELECT RELEASE_LOCK(?)', [$lockName]);
            }
        }
    }

    /**
     * Next sequential track for specs (type=3).
     * Format: DTSPEC DD-MM-NNN with NNN continuing globally from existing DB max
     * (e.g. after DTSPEC 24-07-370 → DTSPEC 03-08-371; next day → DTSPEC 04-08-372).
     */
    public function getNextSpecTrackNumber(): string
    {
        return $this->allocateUniqueSpecTrackNumber(null, null);
    }

    /**
     * Alias for older admin call sites — same DD-MM + global series.
     */
    public function getNextAdminStyleSpecTrackNumber(): string
    {
        return $this->getNextSpecTrackNumber();
    }

    /**
     * Today’s DD-MM prefix + (MAX suffix across all type=3 DTSPEC tracks) + 1.
     * Caller should hold the advisory lock when possible.
     */
    protected function _nextDdMmGlobalTrackNumberUnlocked(): string
    {
        $prefix = $this->currentSpecTrackPrefix();
        $conn = $this->getConnection();
        $table = $this->getTable();

        // Global continuous sequence: max trailing number on any DTSPEC track (with/without #).
        $sql = 'SELECT MAX(CAST(SUBSTRING_INDEX(TRIM(LEADING \'#\' FROM TRIM(`tracknumber`)), \'-\', -1) AS UNSIGNED)) AS max_code'
            . ' FROM `' . $table . '` WHERE `type` = 3'
            . ' AND (`tracknumber` LIKE ? OR `tracknumber` LIKE ?)'
            . ' AND TRIM(LEADING \'#\' FROM TRIM(`tracknumber`)) <> \'\'';

        try {
            $row = $conn->execute($sql, ['DTSPEC %', '#DTSPEC %'])->fetch('assoc');
        } catch (\Throwable $e) {
            Log::warning('_nextDdMmGlobalTrackNumberUnlocked failed: ' . $e->getMessage());
            $row = ['max_code' => 0];
        }

        $next = (int)($row['max_code'] ?? 0) + 1;
        $suffix = $next <= 999 ? str_pad((string)$next, 3, '0', STR_PAD_LEFT) : (string)$next;

        return $prefix . $suffix;
    }
}
