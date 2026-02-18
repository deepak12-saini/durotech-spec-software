<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class DepartmentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('departments');
        $this->setPrimaryKey('id');
        $this->hasMany('NappUser', ['foreignKey' => 'dept_id', 'className' => 'NappUser']);
    }
}
