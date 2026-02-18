<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SsCommentTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('ss_comments');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('SsSheetCategory', ['foreignKey' => 'sheet_cate_id', 'className' => 'SsSheetCategory']);
        $this->belongsTo('User', ['foreignKey' => 'admin_id', 'className' => 'User']);
        $this->belongsTo('NappUser', ['foreignKey' => 'emp_id', 'className' => 'NappUser']);
    }
}
