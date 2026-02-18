<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SsSheetCategoryTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        // CakePHP 3 convention uses plural table names
        // If your table is singular, change this to 'ss_sheet_category'
        $this->setTable('ss_sheet_categories');
        $this->setPrimaryKey('id');
        $this->setDisplayField('name');
        
        $this->hasMany('SsSheetColumn', ['foreignKey' => 'sheet_id', 'className' => 'SsSheetColumn']);
        $this->hasMany('SsSheetShare', ['foreignKey' => 'sheet_id', 'className' => 'SsSheetShare']);
        $this->hasMany('SheetTask', ['foreignKey' => 'sheet_cate_id', 'className' => 'SheetTask']);
        $this->belongsTo('NappUser', ['foreignKey' => 'emp_id', 'className' => 'NappUser']);
        $this->belongsTo('User', ['foreignKey' => 'user_id', 'className' => 'User']);
    }
}
