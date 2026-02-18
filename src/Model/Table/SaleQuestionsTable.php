<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SaleQuestionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('sale_questions');
        $this->setPrimaryKey('id');
        $this->hasMany('SaleReps', ['foreignKey' => 'sales_question_id', 'className' => 'SaleReps']);
    }
}
