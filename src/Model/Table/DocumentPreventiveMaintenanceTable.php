<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * DocumentPreventiveMaintenance table
 */
class DocumentPreventiveMaintenanceTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('document_preventive_maintenances');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id'
        ]);
        
        $this->hasMany('DocumentPreventiveMaintenanceRecord', [
            'foreignKey' => 'doc_preventive_id'
        ]);
    }
}
