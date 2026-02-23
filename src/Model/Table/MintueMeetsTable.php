<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class MintueMeetsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('mintue_meets');
        $this->setPrimaryKey('id');
        $this->setDisplayField('referid');
        $this->hasMany('MintueAgends', ['foreignKey' => 'meet_id', 'className' => 'MintueAgends']);
        $this->hasMany('MintueAgendDetails', ['foreignKey' => 'meet_id', 'className' => 'MintueAgendDetails']);
    }
}
