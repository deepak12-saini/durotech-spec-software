<?php
namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HeroSections Table (CakePHP 3)
 */
class HeroSectionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('hero_sections');
        $this->setPrimaryKey('id');
        $this->setDisplayField('title');

        $this->getSchema()->setColumnType('status', 'integer');
    }
}
