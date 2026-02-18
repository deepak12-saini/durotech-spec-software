<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HrTrainingAttendanceRecord table
 */
class HrTrainingAttendanceRecordTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('hr_training_attendance_records');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('HrTrainingAttendance', [
            'foreignKey' => 'hr_id'
        ]);
    }
}
