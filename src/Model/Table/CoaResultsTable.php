<?php
namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * CoaResults Table (CakePHP 3)
 */
class CoaResultsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('coa_results');
        $this->setPrimaryKey('id');

        $this->getSchema()->setColumnType('id', 'integer');
        $this->getSchema()->setColumnType('coa_id', 'integer');

        $this->belongsTo('Coas', [
            'foreignKey' => 'coa_id',
        ]);
    }
}
