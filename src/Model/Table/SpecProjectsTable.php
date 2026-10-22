<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Datasource\ConnectionManager;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use ArrayObject;

class SpecProjectsTable extends Table
{
    /** @var array<string, string> */
    public const APPLICATIONS = [
        'wet_areas' => 'Wet areas',
        'balconies_terraces' => 'Balconies & terraces',
        'roofs' => 'Roofs',
        'facade_joints' => 'Façade joints',
        'other' => 'Other',
    ];

    /** @var array<string, string> */
    public const STAGES = [
        'brief_received' => 'Brief received',
        'drafting' => 'Drafting',
        'technical_review' => 'Technical review',
        'issued' => 'Issued',
    ];

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('spec_projects');
        $this->setPrimaryKey('id');
        $this->setEntityClass('App\Model\Entity\SpecProject');
        $this->addBehavior('Timestamp');
        $this->hasMany('SpecProjectAreas', ['foreignKey' => 'spec_project_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name', 'Project name is required.');
        $validator->allowEmptyString('code');
        $validator->allowEmptyString('architect');
        $validator->allowEmptyString('location');
        $validator->allowEmptyString('application');
        $validator->allowEmptyString('area_m2');
        $validator->allowEmptyString('owner');
        $validator->allowEmptyDate('follow_up_on');
        $validator->allowEmptyString('stage');
        $validator->allowEmptyString('revision');
        $validator->allowEmptyString('substrate');
        $validator->allowEmptyString('proposed_system');
        $validator->allowEmptyString('document_url');
        $validator->allowEmptyString('scope_notes');
        $validator->allowEmptyString('reviewer');
        $validator->allowEmptyDate('review_date');
        $validator->allowEmptyString('review_outcome');
        $validator->allowEmptyString('request_json');
        $validator->allowEmptyString('request_status');
        $validator->allowEmptyString('contact_name');
        $validator->allowEmptyString('contact_email');
        $validator->allowEmptyString('contact_phone');
        $validator->allowEmptyString('contact_company');
        $validator->allowEmptyString('contact_role');
        $validator->allowEmptyString('source');
        $validator->allowEmptyString('internal_notes');
        $validator->allowEmptyDate('confirmed_issue_date');
        $validator->allowEmptyString('docs_missing_reason');
        $validator->allowEmptyString('clarification');

        return $validator;
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew() && trim((string)($entity->get('code') ?? '')) === '') {
            $entity->set('code', $this->allocateCode());
        }
        if (trim((string)($entity->get('revision') ?? '')) === '') {
            $entity->set('revision', 'A');
        }
        if (trim((string)($entity->get('stage') ?? '')) === '') {
            $entity->set('stage', 'brief_received');
        }
        if (trim((string)($entity->get('application') ?? '')) === '') {
            $entity->set('application', 'wet_areas');
        }
        foreach (['follow_up_on', 'review_date'] as $dateField) {
            $raw = $entity->get($dateField);
            if ($raw === '') {
                $entity->set($dateField, null);
            }
        }
    }

    public static function applicationLabel(string $key): string
    {
        return self::APPLICATIONS[$key] ?? $key;
    }

    public static function stageLabel(string $key): string
    {
        return self::STAGES[$key] ?? $key;
    }

    public function ensureTable(): void
    {
        static $ready = false;
        if ($ready) {
            return;
        }
        $sqlPath = defined('ROOT')
            ? ROOT . DS . 'config' . DS . 'schema' . DS . 'spec_projects.sql'
            : dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'spec_projects.sql';
        $sql = is_file($sqlPath) ? file_get_contents($sqlPath) : false;
        if (!is_string($sql) || trim($sql) === '') {
            return;
        }
        try {
            ConnectionManager::get('default')->execute($sql);
            $this->ensureExtraColumns();
            $areasSqlPath = defined('ROOT')
                ? ROOT . DS . 'config' . DS . 'schema' . DS . 'spec_project_areas.sql'
                : dirname($sqlPath) . DIRECTORY_SEPARATOR . 'spec_project_areas.sql';
            $areasSql = is_file($areasSqlPath) ? file_get_contents($areasSqlPath) : false;
            if (is_string($areasSql) && trim($areasSql) !== '') {
                ConnectionManager::get('default')->execute($areasSql);
            }
            try {
                $this->getAssociation('SpecProjectAreas')->getTarget()->ensureExtraColumns();
            } catch (\Throwable $e) {
                Log::warning('SpecProjectAreas extra columns: ' . $e->getMessage());
            }
            $ready = true;
        } catch (\Throwable $e) {
            Log::error('SpecProjectsTable ensureTable: ' . $e->getMessage());
        }
    }

    public function ensureExtraColumns(): void
    {
        $cols = [
            'request_json' => 'MEDIUMTEXT NULL',
            'request_status' => 'VARCHAR(40) NULL',
            'contact_name' => 'VARCHAR(255) NULL',
            'contact_email' => 'VARCHAR(255) NULL',
            'contact_phone' => 'VARCHAR(64) NULL',
            'contact_company' => 'VARCHAR(255) NULL',
            'contact_role' => 'VARCHAR(80) NULL',
            'source' => 'VARCHAR(20) NULL',
            'internal_notes' => 'TEXT NULL',
            'confirmed_issue_date' => 'DATE NULL',
            'docs_not_available' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'docs_missing_reason' => 'TEXT NULL',
            'clarification' => 'TEXT NULL',
        ];
        $conn = $this->getConnection();
        foreach ($cols as $name => $ddl) {
            try {
                $conn->execute('ALTER TABLE `spec_projects` ADD COLUMN `' . $name . '` ' . $ddl);
            } catch (\Throwable $e) {
                // already exists
            }
        }
    }

    public function allocateCode(): string
    {
        $conn = $this->getConnection();
        $gotLock = false;
        try {
            $stmt = $conn->execute('SELECT GET_LOCK(?, 15) AS acquired', ['spec_project_code']);
            $row = $stmt ? $stmt->fetch('assoc') : null;
            $gotLock = (int)($row['acquired'] ?? 0) === 1;
        } catch (\Throwable $e) {
            Log::warning('SpecProjects GET_LOCK: ' . $e->getMessage());
        }
        try {
            $sql = 'SELECT MAX(CAST(SUBSTRING_INDEX(`code`, \'-\', -1) AS UNSIGNED)) AS max_code FROM `spec_projects` WHERE `code` LIKE ?';
            $row = ['max_code' => 0];
            try {
                $row = $conn->execute($sql, ['DSP-%'])->fetch('assoc') ?: $row;
            } catch (\Throwable $e) {
                Log::warning('SpecProjects max code: ' . $e->getMessage());
            }
            $next = (int)($row['max_code'] ?? 0) + 1;
            $code = 'DSP-' . str_pad((string)$next, 3, '0', STR_PAD_LEFT);
            while ($this->exists(['code' => $code])) {
                $next++;
                $code = 'DSP-' . str_pad((string)$next, 3, '0', STR_PAD_LEFT);
            }

            return $code;
        } finally {
            if ($gotLock) {
                try {
                    $conn->execute('SELECT RELEASE_LOCK(?)', ['spec_project_code']);
                } catch (\Throwable $e) {
                    // ignore
                }
            }
        }
    }
}
