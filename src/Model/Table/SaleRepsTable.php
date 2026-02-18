<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class SaleRepsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('sale_reps');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', ['events' => ['Model.beforeSave' => ['created' => 'new']]]);
        $this->belongsTo('SaleQuestions', ['foreignKey' => 'sales_question_id', 'className' => 'SaleQuestions']);
        $this->belongsTo('NappUser', ['foreignKey' => 'staff_id', 'className' => 'NappUser']);
    }
}
