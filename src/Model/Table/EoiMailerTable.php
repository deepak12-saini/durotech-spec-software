<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class EoiMailerTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('eoi_mailers');
        $this->setPrimaryKey('id');
        $this->belongsTo('NappUser', ['foreignKey' => 'user_id']);
    }
}
