<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * DocumentCalibrationReocrd table (note: typo in original table name)
 */
class DocumentCalibrationReocrdTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('document_calibration_reocrds');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('DocumentCalibration', [
            'foreignKey' => 'doc_id'
        ]);
    }
}
