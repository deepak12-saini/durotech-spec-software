<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * UserAnswer table
 */
class UserAnswerTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('user_answers');
        $this->setPrimaryKey('id');
    }
}
