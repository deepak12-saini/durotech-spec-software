<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class DriversTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('drivers');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('DuroDeliveries', [
            'foreignKey' => 'driver_id',
        ]);
    }
}
