<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class PurchaseTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('purchases');
        $this->setPrimaryKey('id');
        $this->hasMany('PurchaseRequirements', [
            'className' => 'PurchaseRequirement',
            'foreignKey' => 'purchase_id',
        ]);
        $this->belongsTo('NappUser1', [
            'className' => 'NappUser',
            'foreignKey' => 'prepared_by',
        ]);
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'permitted_by',
        ]);
        $this->belongsTo('NappUser2', [
            'className' => 'NappUser',
            'foreignKey' => 'authorized_by',
        ]);
    }
}
