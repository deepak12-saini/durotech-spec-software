<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * DocumentCalibration table
 */
class DocumentCalibrationTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('document_calibrations');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id'
        ]);
        
        $this->hasMany('DocumentCalibrationReocrd', [
            'foreignKey' => 'doc_id'
        ]);
    }
}
