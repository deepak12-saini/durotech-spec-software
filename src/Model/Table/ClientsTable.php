<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ClientsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('clients');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', [
            'events' => ['Model.beforeSave' => ['created' => 'new', 'modified' => 'always']],
        ]);
        $this->belongsTo('ClientTypes', ['foreignKey' => 'category_id', 'className' => 'ClientTypes']);
        $this->hasMany('StaffClients', ['foreignKey' => 'client_id', 'className' => 'StaffClients']);
    }
}
