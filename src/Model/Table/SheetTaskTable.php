<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SheetTaskTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('sheet_tasks');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('SsSheetCategory', ['foreignKey' => 'sheet_cate_id', 'className' => 'SsSheetCategory']);
        $this->belongsTo('SsSheetColumn', ['foreignKey' => 'column_id', 'className' => 'SsSheetColumn']);
    }
}
