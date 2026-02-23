<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class MintueAgendDetailsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('mintue_agend_details');
        $this->setPrimaryKey('id');
        $this->belongsTo('MintueMeets', ['foreignKey' => 'meet_id', 'className' => 'MintueMeets']);
    }
}
