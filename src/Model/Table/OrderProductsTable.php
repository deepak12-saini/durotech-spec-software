<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class OrderProductsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('order_products');
        $this->setPrimaryKey('id');

        $this->belongsTo('DuroOrders', [
            'foreignKey' => 'order_id',
        ]);
    }
}
