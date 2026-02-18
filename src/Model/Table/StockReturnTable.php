<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * StockReturn Table (CakePHP 3.10) - stock return records
 */
class StockReturnTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('stock_returns');
        $this->setPrimaryKey('id');
        $this->belongsTo('NappUser', [
            'foreignKey' => 'user_id',
            'className' => 'NappUser',
        ]);
        $this->hasMany('StockReturnData', [
            'foreignKey' => 'stock_id',
            'className' => 'StockReturnData',
        ]);
    }
}
