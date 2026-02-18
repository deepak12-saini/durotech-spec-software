<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class NappUserTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('napp_users');
        $this->setPrimaryKey('id');
        $this->hasMany('EoiMailer', ['foreignKey' => 'user_id']);
        $this->hasMany('LabAssigns', ['foreignKey' => 'customer_id', 'className' => 'LabAssigns']);
        $this->belongsTo('Departments', ['foreignKey' => 'dept_id', 'className' => 'Departments']);
        $this->belongsTo('Department', ['foreignKey' => 'dept_id', 'className' => 'Department']);
    }
}
