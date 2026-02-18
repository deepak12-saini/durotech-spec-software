<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * DocumentPreventiveMaintenanceRecord table
 */
class DocumentPreventiveMaintenanceRecordTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('document_preventive_maintenance_records');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('DocumentPreventiveMaintenance', [
            'foreignKey' => 'doc_preventive_id'
        ]);
    }
}
