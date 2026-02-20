<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Welcomes Table (CakePHP 3.10)
 */
class WelcomesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('welcomes');
        $this->setPrimaryKey('id');

        $this->belongsTo('NappUser', [
            'foreignKey' => 'user_id',
            'className' => 'NappUser',
        ]);
        $this->belongsTo('User', [
            'foreignKey' => 'admin_id',
            'className' => 'User',
        ]);
        $this->belongsTo('LabFiles', [
            'foreignKey' => 'price_id',
            'className' => 'LabFiles',
        ]);
        $this->hasMany('WelcomeProducts', [
            'foreignKey' => 'welcome_id',
            'className' => 'WelcomeProducts',
        ]);
    }
}
