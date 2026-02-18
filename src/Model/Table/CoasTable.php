<?php
namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Coas Table (CakePHP 3) - COA Durotech
 */
class CoasTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('coas');
        $this->setPrimaryKey('id');
        $this->setDisplayField('product');

        // Ensure column types to avoid string-to-integer conversion errors
        $schema = $this->getSchema();
        $schema->setColumnType('id', 'integer');
        $schema->setColumnType('admin_id', 'integer');
        $schema->setColumnType('created', 'datetime');
        $schema->setColumnType('modified', 'datetime');
        $schema->setColumnType('date_of_manu', 'date');
        $schema->setColumnType('expiry_date', 'date');
        $schema->setColumnType('signature_date', 'date');

        $this->belongsTo('User', [
            'foreignKey' => 'admin_id',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('CoaResults', [
            'foreignKey' => 'coa_id',
            'dependent' => true,
        ]);
    }
}
