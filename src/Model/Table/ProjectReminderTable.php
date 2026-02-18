<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ProjectReminderTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('project_reminders');
        $this->setPrimaryKey('id');
    }
}
