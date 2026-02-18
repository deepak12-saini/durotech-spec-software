<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HrDuringLeave table
 */
class HrDuringLeaveTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('hr_during_leaves');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id'
        ]);
        
        $this->hasMany('HrDuringLeaveRecord', [
            'foreignKey' => 'hr_id'
        ]);
    }
}
