<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HrFormatEvaluationEmployeRecord table
 */
class HrFormatEvaluationEmployeRecordTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('hr_format_evaluation_employe_records');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('HrFormatEvaluationEmployee', [
            'foreignKey' => 'hr_id'
        ]);
    }
}
