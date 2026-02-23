<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * DebitCollections Table (CakePHP 3.10)
 * Table for debit collection / debt collection records.
 */
class DebitCollectionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('debit_collections');
        $this->setPrimaryKey('id');
        $this->setDisplayField('invoice_id');
    }
}
