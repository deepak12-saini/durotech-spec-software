<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * TaskComments Table (CakePHP 3.10) - DuroLab task comments
 */
class TaskCommentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('task_comments');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_ids',
        ]);
        $this->belongsTo('NappUser', [
            'foreignKey' => 'emp_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('User', [
            'foreignKey' => 'admin_id',
            'joinType' => 'LEFT',
        ]);
    }
}
