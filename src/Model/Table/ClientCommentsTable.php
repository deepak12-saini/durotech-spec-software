<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ClientCommentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('client_comments');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', ['events' => ['Model.beforeSave' => ['created' => 'new']]]);
        $this->belongsTo('Clients', ['foreignKey' => 'client_id', 'className' => 'Clients']);
        $this->belongsTo('User', ['foreignKey' => 'admin_id', 'className' => 'User']);
        $this->belongsTo('NappUser', ['foreignKey' => 'emp_id', 'className' => 'NappUser']);
    }
}
