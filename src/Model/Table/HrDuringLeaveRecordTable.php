<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HrDuringLeaveRecord table
 */
class HrDuringLeaveRecordTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('hr_during_leave_records');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('HrDuringLeave', [
            'foreignKey' => 'hr_id'
        ]);
    }
}
