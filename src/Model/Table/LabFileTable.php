<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * LabFile Table - alias used by UsersController (loadModel('LabFile')).
 * Actual DB table is lab_files.
 */
class LabFileTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('lab_files');
        $this->setPrimaryKey('id');
        $this->hasMany('LabAssign', [
            'foreignKey' => 'lab_id',
            'className' => 'LabAssign',
        ]);
    }
}
