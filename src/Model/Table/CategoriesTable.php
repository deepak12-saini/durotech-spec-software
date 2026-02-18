<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CategoriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('categories');
        $this->setPrimaryKey('id');
        $this->setDisplayField('category_name');

        // Each category has many products (used in technical_literature_new view)
        $this->hasMany('Products', [
            'foreignKey' => 'category_id',
        ]);
    }
}

