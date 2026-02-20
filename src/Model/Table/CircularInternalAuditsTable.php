<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * CircularInternalAudits Table
 */
class CircularInternalAuditsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('circular_internal_audits');
        $this->setPrimaryKey('id');

        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('CircularInternalAuditLists', [
            'foreignKey' => 'cia_id',
            'className' => 'CircularInternalAuditLists'
        ]);
        $this->hasMany('CircularInternalAuditResults', [
            'foreignKey' => 'audit_id',
            'className' => 'CircularInternalAuditResults'
        ]);
    }
}
