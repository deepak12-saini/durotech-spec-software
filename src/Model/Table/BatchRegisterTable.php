<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * BatchRegister table
 */
class BatchRegisterTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('batch_registers');
        $this->setPrimaryKey('id');
    }
}
