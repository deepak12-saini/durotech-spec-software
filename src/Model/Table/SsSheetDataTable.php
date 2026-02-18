<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SsSheetDataTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('ss_sheet_data'); // data is already plural
        $this->setPrimaryKey('id');
    }
}
