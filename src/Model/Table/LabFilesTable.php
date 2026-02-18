<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * LabFiles Table (CakePHP 3.10) - lab level/file definitions
 */
class LabFilesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('lab_files');
        $this->setPrimaryKey('id');
        $this->hasMany('LabAssigns', ['foreignKey' => 'lab_id']);
    }
}
