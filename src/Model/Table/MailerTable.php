<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Mailer (specification mailer records).
 * Cake 3 Table for Mailer entity; table name may be 'mailer' or 'mailers'.
 */
class MailerTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('mailers');
        $this->setPrimaryKey('id');
        $this->belongsTo('Employee', ['foreignKey' => 'employee_id']);
        $this->belongsTo('User', ['foreignKey' => 'admin_id']);
        $this->belongsTo('NappUser', ['foreignKey' => 'user_id']);
        $this->hasMany('MailerComment', ['foreignKey' => 'mailer_id']);
        $this->hasMany('SpecUsearea', ['foreignKey' => 'mailer_id']);
    }
}
