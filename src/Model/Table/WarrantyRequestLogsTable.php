<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class WarrantyRequestLogsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('warranty_request_logs');
        $this->setPrimaryKey('id');
        $this->belongsTo('WarrantyRequests', [
            'foreignKey' => 'warranty_request_id',
            'className' => 'WarrantyRequests',
        ]);
    }
}
