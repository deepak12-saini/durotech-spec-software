<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class VisitorTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('visitors');
        $this->setPrimaryKey('id');
    }
}
