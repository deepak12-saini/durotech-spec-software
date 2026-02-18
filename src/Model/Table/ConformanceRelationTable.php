<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * ConformanceRelation table
 */
class ConformanceRelationTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('conformance_relations');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('Conformance', [
            'foreignKey' => 'conformance_id'
        ]);
        
        $this->belongsTo('NappUser', [
            'foreignKey' => 'emp_id'
        ]);
    }
}
