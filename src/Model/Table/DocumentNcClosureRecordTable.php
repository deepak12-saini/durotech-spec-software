<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * DocumentNcClosureRecord table
 */
class DocumentNcClosureRecordTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('document_nc_closure_records');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('DocumentNcClosure', [
            'foreignKey' => 'doc_id'
        ]);
    }
}
