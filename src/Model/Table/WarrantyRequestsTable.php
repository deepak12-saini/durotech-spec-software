<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class WarrantyRequestsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('warranty_requests');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);
        $this->hasMany('WarrantyRequestLogs', [
            'foreignKey' => 'warranty_request_id',
            'className' => 'WarrantyRequestLogs',
            'dependent' => true,
        ]);
    }
}
