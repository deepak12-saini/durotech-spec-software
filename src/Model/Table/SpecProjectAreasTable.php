<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SpecProjectAreasTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('spec_project_areas');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('SpecProjects', ['foreignKey' => 'spec_project_id']);
    }

    public function ensureExtraColumns(): void
    {
        $cols = [
            'custom_label' => 'VARCHAR(255) NULL',
            'area_type' => 'VARCHAR(80) NULL',
        ];
        $conn = $this->getConnection();
        foreach ($cols as $name => $ddl) {
            try {
                $conn->execute('ALTER TABLE `spec_project_areas` ADD COLUMN `' . $name . '` ' . $ddl);
            } catch (\Throwable $e) {
                // already exists
            }
        }
    }
}
