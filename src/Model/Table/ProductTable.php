<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Alias for products table (loadModel('Product') in controller)
 */
class ProductTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('products');
        $this->setPrimaryKey('id');
        $this->setDisplayField('title');
        $this->belongsTo('Category', ['foreignKey' => 'category_id']);
        $this->hasMany('Project', ['foreignKey' => 'product_id']);
    }
}
