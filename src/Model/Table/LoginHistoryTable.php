<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class LoginHistoryTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('login_histories');
        $this->setPrimaryKey('id');

        $this->belongsTo('User', [
            'foreignKey' => 'admin_id',
            'className' => 'User',
        ]);
        $this->belongsTo('NappUser', [
            'foreignKey' => 'user_id',
            'className' => 'NappUser',
        ]);
    }
}
