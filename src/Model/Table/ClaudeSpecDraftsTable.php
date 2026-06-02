<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Database\Driver\Mysql;
use Cake\Log\Log;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ClaudeSpecDraftsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('claude_spec_drafts');
        $this->setPrimaryKey('id');
        $this->setEntityClass(\App\Model\Entity\ClaudeSpecDraft::class);
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('employee_id')
            ->greaterThanOrEqual('employee_id', 0);

        $validator
            ->scalar('project_brief')
            ->requirePresence('project_brief', 'create')
            ->notEmptyString('project_brief', 'Project brief is required.');

        $validator
            ->scalar('status')
            ->inList('status', ['draft', 'generated', 'applied'], 'Invalid status.');

        $validator
            ->allowEmptyString('client_name')
            ->maxLength('client_name', 255);

        $validator
            ->allowEmptyString('company')
            ->maxLength('company', 255);

        $validator
            ->allowEmptyString('email')
            ->maxLength('email', 255);

        $validator
            ->allowEmptyString('address')
            ->maxLength('address', 512);

        $validator->allowEmptyString('generated_payload');

        return $validator;
    }

    /**
     * Next track number: CLAUDE yy-mm-NNN
     */
    public function getNextTrackNumber(): string
    {
        $yr = date('y');
        $mm = date('m');
        $prefix = 'CLAUDE ' . $yr . '-' . $mm . '-';
        $like = $prefix . '%';
        $conn = $this->getConnection();
        $table = $this->getTable();

        if ($conn->getDriver() instanceof Mysql) {
            $lockName = 'cake3_claude_spec_track';
            $acquired = 0;
            $stmt = $conn->execute('SELECT GET_LOCK(?, 15) AS acquired', [$lockName]);
            $acquired = (int)($stmt->fetch('assoc')['acquired'] ?? 0);
            if ($acquired !== 1) {
                Log::warning('ClaudeSpecDrafts getNextTrackNumber: GET_LOCK failed.');
            }
            try {
                $sql = 'SELECT MAX(CAST(SUBSTRING_INDEX(TRIM(`tracknumber`), \'-\', -1) AS UNSIGNED)) AS max_code'
                    . ' FROM `' . $table . '` WHERE `tracknumber` LIKE ?';
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
            . ' FROM ' . $table . ' WHERE tracknumber LIKE ?';
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
