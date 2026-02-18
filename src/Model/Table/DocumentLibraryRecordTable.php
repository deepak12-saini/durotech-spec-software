<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * DocumentLibraryRecord table
 */
class DocumentLibraryRecordTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('document_library_records');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('DocumentLibrary', [
            'foreignKey' => 'doc_id'
        ]);
    }
}
