<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class PaymentSetupTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('payment_setups');
        $this->setPrimaryKey('id');
    }
}
