<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * CircularInternalAuditResults Table
 */
class CircularInternalAuditResultsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('circular_internal_audit_results');
        $this->setPrimaryKey('id');

        $this->belongsTo('CircularInternalAudits', [
            'foreignKey' => 'audit_id',
            'className' => 'CircularInternalAudits'
        ]);
    }
}
