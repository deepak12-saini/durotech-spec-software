<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Broucher Products (brochure products) - CakePHP 3.10
 * Table name: broucher_products (if your DB uses brochure_products, change setTable below)
 */
class BroucherProductTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('broucher_products');
        $this->setPrimaryKey('id');
        $this->setDisplayField('title');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Category', ['foreignKey' => 'category_id']);
        $this->belongsTo('BorucherCategory', ['foreignKey' => 'boucher_cate_id']);
        $this->hasMany('Project', ['foreignKey' => 'product_id']);
    }
}
