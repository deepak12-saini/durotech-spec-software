<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class DuroDeliveriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('duro_deliveries');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('NappUser', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Drivers', [
            'foreignKey' => 'driver_id',
        ]);
    }
}
