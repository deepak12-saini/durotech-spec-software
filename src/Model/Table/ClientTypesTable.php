<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ClientTypesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('client_types');
        $this->setPrimaryKey('id');
        $this->hasMany('Clients', ['foreignKey' => 'category_id', 'className' => 'Clients']);
    }
}
