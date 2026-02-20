<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class QuestionOptionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('question_options');
        $this->setPrimaryKey('id');
        $this->belongsTo('Questions', [
            'foreignKey' => 'question_id',
            'className' => 'Questions',
        ]);
    }
}
