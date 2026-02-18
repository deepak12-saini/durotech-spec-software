<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HrAppraisalFormRecord table
 */
class HrAppraisalFormRecordTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('hr_appraisal_form_records');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('HrAppraisalForm', [
            'foreignKey' => 'hr_id'
        ]);
    }
}
