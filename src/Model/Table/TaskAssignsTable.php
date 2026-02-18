<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * TaskAssigns Table (CakePHP 3.10) - DuroLab task assignments
 */
class TaskAssignsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('task_assigns');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id',
        ]);
        $this->belongsTo('NappUser', [
            'foreignKey' => 'emp_id',
        ]);
    }
}
