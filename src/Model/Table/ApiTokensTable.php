<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ApiTokensTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('api_tokens');
        $this->setPrimaryKey('id');

        $this->belongsTo('Employee', [
            'foreignKey' => 'employee_id',
            'className' => 'Employee',
        ]);
    }
}
