<?php

declare(strict_types=1);

namespace App\Model\Table;

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
     * Format: DTSPEC DD-MM-NNN (e.g. DTSPEC 26-02-546, 26-03-548).
     * Only SUBMITTED specs count – drafts excluded so autosave/resume don't break sequence.
     *
     * @return string
     */
    public function getNextSpecTrackNumber(): string
    {
        $dd = date('d');
        $mm = date('m');
        $prefix = 'DTSPEC ' . $dd . '-' . $mm . '-';
        $conn = $this->getConnection();
        $driver = $conn->getDriver();
        $hasSaveStatus = $this->getSchema()->getColumn('save_status');
        $isMysql = ($driver instanceof \Cake\Database\Driver\Mysql);

        $whereDraftExcluded = "type = 3 AND tracknumber IS NOT NULL AND tracknumber != ''";
        if ($hasSaveStatus) {
            $whereDraftExcluded .= " AND (save_status IS NULL OR save_status != 'draft')";
        }
        // Exclude wrong 5000+ serials from old count-based logic; keep 3-digit pattern (548→549→550)
        $whereDraftExcluded .= " AND CAST(SUBSTRING_INDEX(tracknumber, '-', -1) AS UNSIGNED) <= 999";

        if ($isMysql) {
            $sql = "SELECT MAX(CAST(SUBSTRING_INDEX(tracknumber, '-', -1) AS UNSIGNED)) AS max_code 
                    FROM {$this->getTable()} 
                    WHERE {$whereDraftExcluded}";
            $stmt = $conn->execute($sql);
            $row = $stmt->fetch('assoc');
        } else {
            $q = $this->find()->where(['type' => 3])->select(['tracknumber']);
            if ($hasSaveStatus) {
                $q->andWhere([
                    'OR' => [
                        ['save_status IS' => null],
                        ['save_status !=' => 'draft'],
                    ],
                ]);
            }
            $rows = $q->all();
            $maxCode = 0;
            foreach ($rows as $r) {
                $tn = $r->tracknumber ?? '';
                if (preg_match('/-(\d+)$/', $tn, $m)) {
                    $n = (int)$m[1];
                    if ($n <= 999 && $n > $maxCode) {
                        $maxCode = $n;
                    }
                }
            }
            $row = ['max_code' => $maxCode];
        }

        $next = (int)($row['max_code'] ?? 0) + 1;
        return $prefix . str_pad((string)$next, 3, '0', STR_PAD_LEFT);
    }
}
