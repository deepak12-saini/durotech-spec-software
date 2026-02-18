<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Tasks Table (CakePHP 3.10) - DuroLab tasks
 */
class TasksTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('tasks');
        $this->setPrimaryKey('id');
        $this->setDisplayField('title');

        $this->belongsTo('User', [
            'foreignKey' => 'admin_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('NappUser', [
            'foreignKey' => 'emp_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('TaskAssigns', [
            'foreignKey' => 'task_id',
            'dependent' => true,
        ]);
        $this->hasMany('TaskDocuments', [
            'foreignKey' => 'task_id',
            'dependent' => true,
        ]);
        $this->hasMany('TaskComments', [
            'foreignKey' => 'task_ids',
            'dependent' => true,
        ]);
    }
}
