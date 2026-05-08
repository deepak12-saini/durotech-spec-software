<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SpecTemplateItemTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('spec_template_items');
        $this->setPrimaryKey('id');
    }
}
