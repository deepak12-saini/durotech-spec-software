<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * TaskDocuments Table (CakePHP 3.10) - DuroLab task documents
 */
class TaskDocumentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('task_documents');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id',
        ]);
        $this->belongsTo('NappUser', [
            'foreignKey' => 'employe_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('User', [
            'foreignKey' => 'admin_id',
            'joinType' => 'LEFT',
        ]);
    }
}
