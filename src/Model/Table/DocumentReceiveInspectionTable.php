<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * DocumentReceiveInspection table
 */
class DocumentReceiveInspectionTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('document_receive_inspections');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id'
        ]);
    }
}
