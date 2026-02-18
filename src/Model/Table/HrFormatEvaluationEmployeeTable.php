<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HrFormatEvaluationEmployee table
 */
class HrFormatEvaluationEmployeeTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('hr_format_evaluation_employees');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id'
        ]);
        
        $this->hasMany('HrFormatEvaluationEmployeRecord', [
            'foreignKey' => 'hr_id'
        ]);
    }
}
