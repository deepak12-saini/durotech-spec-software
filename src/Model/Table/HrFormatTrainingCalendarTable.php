<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HrFormatTrainingCalendar table
 */
class HrFormatTrainingCalendarTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('hr_format_training_calendars');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id'
        ]);
        
        $this->hasMany('HrFormatTrainingCalendarRecord', [
            'foreignKey' => 'hr_id'
        ]);
    }
}
