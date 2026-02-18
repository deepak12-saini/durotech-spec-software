<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class NataEventsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('nata_events');
        $this->setPrimaryKey('id');

        $this->belongsTo('NataCategories', [
            'foreignKey' => 'cate_id',
        ]);
    }
}
