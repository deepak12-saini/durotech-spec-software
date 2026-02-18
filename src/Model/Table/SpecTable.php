<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SpecTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('specs');
        $this->setPrimaryKey('id');
    }
}
