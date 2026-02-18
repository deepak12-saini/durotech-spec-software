<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * ComplaintType table
 */
class ComplaintTypeTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('complaint_types');
        $this->setPrimaryKey('id');
    }
}
