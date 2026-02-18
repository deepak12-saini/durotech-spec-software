<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class DuroOrdersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('duro_orders');
        $this->setPrimaryKey('id');
        $this->setDisplayField('customer_order_no');

        $this->addBehavior('Timestamp');

        $this->belongsTo('NappUser', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('OrderProducts', [
            'foreignKey' => 'order_id',
            'dependent' => true,
        ]);
    }
}
