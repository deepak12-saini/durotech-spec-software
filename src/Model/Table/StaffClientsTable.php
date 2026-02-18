<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class StaffClientsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('staff_clients');
        $this->setPrimaryKey('id');
        $this->belongsTo('Clients', ['foreignKey' => 'client_id', 'className' => 'Clients']);
        $this->belongsTo('NappUser', ['foreignKey' => 'staff_id', 'className' => 'NappUser']);
    }
}
