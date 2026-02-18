<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * LabAssign Table - alias used by UsersController (loadModel('LabAssign')).
 * Actual DB table is lab_assigns.
 */
class LabAssignTable extends Table
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
        $this->belongsTo('LabFile', [
            'foreignKey' => 'lab_id',
            'className' => 'LabFile',
        ]);
    }
}
