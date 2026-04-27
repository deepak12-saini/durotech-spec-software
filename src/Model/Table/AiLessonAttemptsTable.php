<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class AiLessonAttemptsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('ai_lesson_attempts');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('AiLessons', [
            'foreignKey' => 'lesson_id',
        ]);
    }
}

