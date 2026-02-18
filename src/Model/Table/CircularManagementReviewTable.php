<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * CircularManagementReview table
 */
class CircularManagementReviewTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('circular_management_reviews');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'emp_id'
        ]);
        
        $this->hasMany('CircularRelation', [
            'foreignKey' => 'circular_id'
        ]);
        
        $this->hasMany('CircularAction', [
            'foreignKey' => 'circular_id'
        ]);
    }
}
