<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class QuestionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('questions');
        $this->setPrimaryKey('id');
        $this->hasMany('QuestionOptions', [
            'foreignKey' => 'question_id',
            'className' => 'QuestionOptions',
        ]);
    }
}
