<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * CareerApplyJob table
 */
class CareerApplyJobTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('career_apply_jobs');
        $this->setPrimaryKey('id');
        $this->setDisplayField('name');
        
        $this->belongsTo('Career', [
            'foreignKey' => 'job_id',
            'className' => 'Career'
        ]);
    }
}
