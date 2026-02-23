<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class NewPriceListLogTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('new_price_list_logs');
        $this->setPrimaryKey('id');
    }
}
