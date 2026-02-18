<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Conformance table
 */
class ConformanceTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('conformances');
        $this->setPrimaryKey('id');
        
        // Define associations
        $this->belongsTo('NappUser1', [
            'className' => 'NappUser',
            'foreignKey' => 'compaint_by'
        ]);
        
        $this->belongsTo('Department', [
            'foreignKey' => 'dept_id'
        ]);
        
        $this->belongsTo('User', [
            'foreignKey' => 'admin_id'
        ]);
        
        $this->hasMany('ConformanceRelation', [
            'foreignKey' => 'conformance_id'
        ]);
        
        $this->hasMany('TaskDocuments', [
            'className' => 'TaskDocuments',
            'foreignKey' => 'con_id'
        ]);
        
        // Complaint association (if complaintid field exists)
        $this->belongsTo('Complaint', [
            'foreignKey' => 'complaintid',
            'conditions' => ['Complaint.id IS NOT NULL']
        ]);
    }
}
