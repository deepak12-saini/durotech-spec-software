<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ProductWarrantyEventLogsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('product_warranty_event_logs');
        $this->setPrimaryKey('id');
        $this->belongsTo('ProductWarrantyRequests', [
            'foreignKey' => 'product_warranty_request_id',
        ]);
    }
}
