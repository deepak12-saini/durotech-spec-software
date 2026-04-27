<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class AiLessonsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('ai_lessons');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('AiLessonAttempts', [
            'foreignKey' => 'lesson_id',
            'dependent' => true,
        ]);
    }
}

