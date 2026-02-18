<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class MaterialOrdersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('material_orders');
        $this->setPrimaryKey('id');
        $this->belongsTo('Materials', [
            'foreignKey' => 'material_id',
            'className' => 'Materials',
        ]);
    }
}
