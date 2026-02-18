<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HrTrainingNeedAssessmentRecord table
 */
class HrTrainingNeedAssessmentRecordTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('hr_training_need_assessment_records');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('HrTrainingNeedAssessment', [
            'foreignKey' => 'hr_id'
        ]);
    }
}
