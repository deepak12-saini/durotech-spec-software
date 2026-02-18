<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HrTrainingNeedAssessment table
 */
class HrTrainingNeedAssessmentTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('hr_training_need_assessments');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id'
        ]);
        
        $this->hasMany('HrTrainingNeedAssessmentRecord', [
            'foreignKey' => 'hr_id'
        ]);
    }
}
