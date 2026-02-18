<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class NotificationsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('notifications');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'className' => 'Products',
        ]);
    }
}
