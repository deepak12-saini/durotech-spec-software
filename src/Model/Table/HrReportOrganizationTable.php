<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * HrReportOrganization table
 */
class HrReportOrganizationTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('hr_report_organizations');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('NappUser', [
            'className' => 'NappUser',
            'foreignKey' => 'user_id'
        ]);
    }
}
