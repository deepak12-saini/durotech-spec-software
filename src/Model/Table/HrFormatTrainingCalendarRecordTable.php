<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HrFormatTrainingCalendarRecord table
 */
class HrFormatTrainingCalendarRecordTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('hr_format_training_calendar_records');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('HrFormatTrainingCalendar', [
            'foreignKey' => 'hr_id'
        ]);
    }
}
