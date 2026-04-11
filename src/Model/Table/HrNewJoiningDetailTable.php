<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HrNewJoiningDetail table
 */
class HrNewJoiningDetailTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('hr_new_joining_details');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', [
            'events' => ['Model.beforeSave' => ['created' => 'new']],
        ]);

        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id'
        ]);
    }
}
