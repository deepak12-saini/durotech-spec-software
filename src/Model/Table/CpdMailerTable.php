<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * CpdMailer table – used when model alias is "CpdMailer".
 * DB table name is "cpd_mailers" (or set to "cpd_mailer" if your DB uses singular).
 */
class CpdMailerTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('cpd_mailers');
        $this->setPrimaryKey('id');
    }
}
