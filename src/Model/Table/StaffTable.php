<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class StaffTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('staffs');
        $this->setPrimaryKey('id');
        $this->belongsTo('Department', [
            'foreignKey' => 'dept_id',
        ]);
    }
}
