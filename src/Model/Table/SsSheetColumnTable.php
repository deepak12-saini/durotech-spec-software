<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Database\Schema\TableSchemaInterface;

class SsSheetColumnTable extends Table
{
    protected function _initializeSchema(TableSchemaInterface $schema)
    {
        // 'column' is a reserved keyword in MySQL, ensure it's properly escaped
        $schema->setColumnType('column', 'string');
        return $schema;
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('ss_sheet_columns');
        $this->setPrimaryKey('id');
        $this->setDisplayField('column');
        
        $this->belongsTo('SsSheetCategory', ['foreignKey' => 'sheet_id', 'className' => 'SsSheetCategory']);
        $this->hasMany('SheetTask', ['foreignKey' => 'column_id', 'className' => 'SheetTask']);
    }
}
