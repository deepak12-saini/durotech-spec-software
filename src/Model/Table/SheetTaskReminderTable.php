<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SheetTaskReminderTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('sheet_task_reminders');
        $this->setPrimaryKey('id');
    }
}
