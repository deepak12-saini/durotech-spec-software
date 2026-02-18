<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Complaint table
 */
class ComplaintTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('complaints');
        $this->setPrimaryKey('id');
        
        // Define associations
        $this->belongsTo('Department', [
            'foreignKey' => 'dept_id'
        ]);
        
        $this->belongsTo('ComplaintType', [
            'foreignKey' => 'complaint_type',
            'propertyName' => 'ComplaintType' // Explicitly set property name to avoid conflict with field name
        ]);
        
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'complaint_to'
        ]);
        
        $this->belongsTo('NappUser1', [
            'className' => 'NappUser',
            'foreignKey' => 'emp_id'
        ]);
        
        $this->hasMany('Conformance', [
            'foreignKey' => 'complaintid'
        ]);
    }
}
