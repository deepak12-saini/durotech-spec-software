<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ProductsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setPrimaryKey('id');
        $this->setDisplayField('title');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Category', [
            'className' => 'Categories',
            'foreignKey' => 'category_id',
        ]);
    }
}

