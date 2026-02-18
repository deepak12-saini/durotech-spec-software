<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * DocumentLibrary table
 */
class DocumentLibraryTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('document_libraries');
        $this->setPrimaryKey('id');
        
        // Define associations
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id'
        ]);
        
        $this->belongsTo('NappUser1', [
            'className' => 'NappUser',
            'foreignKey' => 'sign_of_indentor',
            'propertyName' => 'NappUser1'
        ]);
        
        $this->belongsTo('NappUser2', [
            'className' => 'NappUser',
            'foreignKey' => 'sign_of_coordinator',
            'propertyName' => 'NappUser2'
        ]);
        
        $this->belongsTo('NappUser3', [
            'className' => 'NappUser',
            'foreignKey' => 'sign_of_hod',
            'propertyName' => 'NappUser3'
        ]);
        
        $this->belongsTo('NappUser4', [
            'className' => 'NappUser',
            'foreignKey' => 'sign_of_library',
            'propertyName' => 'NappUser4'
        ]);
        
        $this->hasMany('DocumentLibraryRecord', [
            'foreignKey' => 'doc_id'
        ]);
    }
}
