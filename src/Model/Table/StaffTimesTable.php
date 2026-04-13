<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class StaffTimesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('staff_times');
        $this->setPrimaryKey('id');
        // Table has `created` but not necessarily `modified`; only auto-fill created on insert.
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                ],
            ],
        ]);
    }
}
