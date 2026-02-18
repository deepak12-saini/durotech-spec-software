<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * CircularAction table
 */
class CircularActionTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('circular_actions');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('CircularManagementReview', [
            'foreignKey' => 'circular_id'
        ]);
    }
}
