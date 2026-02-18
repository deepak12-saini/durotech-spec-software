<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class AttendancesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('attendances');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', ['events' => ['Model.beforeSave' => ['created' => 'new']]]);
        $this->belongsTo('NappUser', ['foreignKey' => 'staff_id', 'className' => 'NappUser']);
    }
}
