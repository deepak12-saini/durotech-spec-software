<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Database\Driver\Mysql;
use Cake\Log\Log;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class AiSpecsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('ai_specs');
        $this->setPrimaryKey('id');
        $this->setEntityClass(\App\Model\Entity\AiSpec::class);
        $this->addBehavior('Timestamp');
        $this->hasMany('AiSpecSections', [
            'foreignKey' => 'ai_spec_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('project')
            ->maxLength('project', 512)
            ->requirePresence('project', 'create')
            ->notEmptyString('project', 'Project is required.');

        $validator
            ->scalar('client')
            ->maxLength('client', 255)
            ->requirePresence('client', 'create')
            ->notEmptyString('client', 'Client is required.');

        $validator
            ->integer('revision')
            ->greaterThanOrEqual('revision', 1);

        $validator
            ->scalar('doc_reference')
            ->maxLength('doc_reference', 128)
            ->allowEmptyString('doc_reference');

        $validator
            ->scalar('save_status')
            ->inList('save_status', ['draft', 'submitted'], 'Invalid status.');

        return $validator;
    }

    /**
     * Next track number: AISPEC yy-mm-NNN
     */
    public function getNextTrackNumber(): string
    {
        $yr = date('y');
        $mm = date('m');
        $prefix = 'AISPEC ' . $yr . '-' . $mm . '-';
        $like = $prefix . '%';
        $conn = $this->getConnection();
        $table = $this->getTable();

        if ($conn->getDriver() instanceof Mysql) {
            $lockName = 'cake3_aispec_track';
            $acquired = 0;
            $stmt = $conn->execute('SELECT GET_LOCK(?, 15) AS acquired', [$lockName]);
            $acquired = (int)($stmt->fetch('assoc')['acquired'] ?? 0);
            if ($acquired !== 1) {
                Log::warning('getNextTrackNumber: GET_LOCK failed; allocating without lock.');
            }
            try {
                $sql = 'SELECT MAX(CAST(SUBSTRING_INDEX(TRIM(`tracknumber`), \'-\', -1) AS UNSIGNED)) AS max_code'
                    . ' FROM `' . $table . '` WHERE `tracknumber` LIKE ?'
                    . ' AND (`save_status` IS NULL OR `save_status` != \'draft\')';
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
