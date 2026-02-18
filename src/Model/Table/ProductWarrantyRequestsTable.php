<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ProductWarrantyRequestsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('product_warranty_request');
        $this->setPrimaryKey('id');
    }
}
