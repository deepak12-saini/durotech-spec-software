<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class DialerNumbersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('dialer_numbers');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', ['events' => ['Model.beforeSave' => ['created' => 'new']]]);
        $this->belongsTo('Clients', ['foreignKey' => 'client_id', 'className' => 'Clients']);
    }
}
