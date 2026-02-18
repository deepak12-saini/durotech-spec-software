<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * DocumentFieldExecutiveDuty table
 */
class DocumentFieldExecutiveDutyTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('document_field_executive_duties');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id'
        ]);
    }
}
