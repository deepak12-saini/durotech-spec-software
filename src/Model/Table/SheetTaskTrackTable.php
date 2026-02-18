<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SheetTaskTrackTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('sheet_task_tracks');
        $this->setPrimaryKey('id');
    }
}
