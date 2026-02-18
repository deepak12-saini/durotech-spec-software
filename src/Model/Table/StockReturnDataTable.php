<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * StockReturnData Table (CakePHP 3.10)
 */
class StockReturnDataTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('stock_return_datas');
        $this->setPrimaryKey('id');
        $this->belongsTo('StockReturn', [
            'foreignKey' => 'stock_id',
            'className' => 'StockReturn',
        ]);
    }
}
