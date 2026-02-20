<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Question table – used when model alias is "Question" (loadModel('Question')).
 * DB table name is "questions".
 */
class QuestionTable extends Table
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
