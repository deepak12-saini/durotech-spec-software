<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SsSheetShareTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('ss_sheet_shares');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('SsSheetCategory', ['foreignKey' => 'sheet_id', 'className' => 'SsSheetCategory']);
        $this->belongsTo('NappUser', ['foreignKey' => 'emp_id', 'className' => 'NappUser']);
    }
}
