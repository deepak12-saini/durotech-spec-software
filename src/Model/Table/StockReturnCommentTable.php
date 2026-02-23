<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Stock Return Comments (CakePHP 3) – comments/documents on stock returns
 */
class StockReturnCommentTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('stock_return_comments');
        $this->setPrimaryKey('id');
        $this->belongsTo('NappUser', [
            'foreignKey' => 'user_id',
            'className' => 'NappUser',
        ]);
        $this->belongsTo('User', [
            'foreignKey' => 'admin_id',
            'className' => 'User',
        ]);
    }
}
