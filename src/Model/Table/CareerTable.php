<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Career table
 */
class CareerTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('careers');
        $this->setPrimaryKey('id');
        $this->setDisplayField('title');
        
        $this->hasMany('CareerApplyJob', [
            'foreignKey' => 'job_id',
            'className' => 'CareerApplyJob'
        ]);
    }
}
