<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SpecUseareaTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('spec_useareas');
        $this->setPrimaryKey('id');
        $this->belongsTo('Mailer', ['foreignKey' => 'mailer_id']);
    }
}
