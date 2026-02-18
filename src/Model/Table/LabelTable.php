<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class LabelTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('labels');
        $this->setPrimaryKey('id');
        $this->belongsTo('LabelCategory', ['foreignKey' => 'label_cate_id']);
    }
}
