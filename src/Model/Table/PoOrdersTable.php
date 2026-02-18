<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class PoOrdersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('po_orders');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);
        $this->belongsTo('NappUser', [
            'foreignKey' => 'user_id',
            'className' => 'NappUser',
        ]);
        $this->hasMany('PoOrderDetails', [
            'foreignKey' => 'po_order_id',
            'className' => 'PoOrderDetails',
            'dependent' => true,
        ]);
    }
}
