<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * LabAssigns Table (CakePHP 3.10) - customer lab assignments
 */
class LabAssignsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('lab_assigns');
        $this->setPrimaryKey('id');
        $this->belongsTo('NappUser', [
            'foreignKey' => 'customer_id',
            'className' => 'NappUser',
        ]);
        $this->belongsTo('LabFiles', [
            'foreignKey' => 'lab_id',
            'className' => 'LabFiles',
        ]);
    }
}
