<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Borucher Categories (brochure categories) - CakePHP 3.10
 */
class BorucherCategoryTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('borucher_categories');
        $this->setPrimaryKey('id');
        $this->setDisplayField('title');

        $this->hasMany('BroucherProduct', ['foreignKey' => 'boucher_cate_id']);
    }
}
