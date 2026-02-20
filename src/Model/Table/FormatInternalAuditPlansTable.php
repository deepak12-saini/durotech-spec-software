<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * FormatInternalAuditPlans Table
 */
class FormatInternalAuditPlansTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('format_internal_audit_plans');
        $this->setPrimaryKey('id');
        $this->setDisplayField('audit_number');

        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'auditor'
        ]);
        $this->belongsTo('NappUser1', [
            'className' => 'NappUser',
            'foreignKey' => 'auditee'
        ]);
        $this->belongsTo('NappUserCreator', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id',
            'propertyName' => 'napp_user_creator'
        ]);
    }
}
