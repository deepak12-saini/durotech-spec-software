<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class PoOrderDetailsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('po_order_details');
        $this->setPrimaryKey('id');
        $this->belongsTo('PoOrders', [
            'foreignKey' => 'po_order_id',
            'className' => 'PoOrders',
        ]);
    }
}
