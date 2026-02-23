<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * SiteVisits table (site_visits)
 */
class SiteVisitsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('site_visits');
        $this->setPrimaryKey('id');
    }
}
