<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SpecTemplateCommentTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('spec_template_comments');
        $this->setPrimaryKey('id');
    }
}
