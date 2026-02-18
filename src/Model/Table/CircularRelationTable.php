<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * CircularRelation table
 */
class CircularRelationTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('circular_relations');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('CircularManagementReview', [
            'foreignKey' => 'circular_id'
        ]);
        
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'emp_id'
        ]);
    }
}
