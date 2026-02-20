<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * WelcomeProducts Table (CakePHP 3.10)
 */
class WelcomeProductsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('welcome_products');
        $this->setPrimaryKey('id');

        $this->belongsTo('Welcomes', [
            'foreignKey' => 'welcome_id',
            'className' => 'Welcomes',
        ]);
    }
}
