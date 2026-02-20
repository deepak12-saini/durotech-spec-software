<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * CircularInternalAuditLists Table
 */
class CircularInternalAuditListsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('circular_internal_audit_lists');
        $this->setPrimaryKey('id');

        $this->belongsTo('CircularInternalAudits', [
            'foreignKey' => 'cia_id'
        ]);
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'auditor'
        ]);
        $this->belongsTo('NappUser1', [
            'className' => 'NappUser',
            'foreignKey' => 'auditee'
        ]);
    }
}
