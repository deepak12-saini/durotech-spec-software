<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Coupon table
 */
class CouponTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('coupons');
        $this->setPrimaryKey('id');
    }
}
