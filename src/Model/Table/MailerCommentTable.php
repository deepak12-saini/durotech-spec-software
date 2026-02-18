<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class MailerCommentTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('mailer_comments');
        $this->setPrimaryKey('id');
        $this->belongsTo('Mailer', ['foreignKey' => 'mailer_id']);
    }
}
