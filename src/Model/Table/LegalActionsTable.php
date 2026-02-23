<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * LegalActions table (legal_actions)
 */
class LegalActionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('legal_actions');
        $this->setPrimaryKey('id');
    }
}
