<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Alias for categories table (loadModel('Category') in controller)
 */
class CategoryTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('categories');
        $this->setPrimaryKey('id');
        $this->setDisplayField('category_name');
        $this->hasMany('Product', ['foreignKey' => 'category_id']);
    }
}
