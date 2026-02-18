<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class CaseImageTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('case_images');
        $this->setPrimaryKey('id');
        $this->belongsTo('CaseStudy', [
            'foreignKey' => 'case_study_id',
        ]);
    }
}
