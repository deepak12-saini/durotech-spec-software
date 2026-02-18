<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class NataCategoriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('nata_categories');
        $this->setPrimaryKey('id');
        $this->setDisplayField('name');

        $this->hasMany('NataEvents', [
            'foreignKey' => 'cate_id',
            'dependent' => true,
        ]);
    }
}
