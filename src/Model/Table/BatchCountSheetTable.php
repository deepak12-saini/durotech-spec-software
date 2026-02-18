<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class BatchCountSheetTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('batch_count_sheets');
        $this->setPrimaryKey('id');
        $this->belongsTo('NappUser', [
            'foreignKey' => 'user_id',
        ]);
    }
}
