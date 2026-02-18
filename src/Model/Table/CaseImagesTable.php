<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CaseImagesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('case_images');
        $this->setPrimaryKey('id');

        $this->belongsTo('CaseStudies', [
            'foreignKey' => 'case_study_id',
        ]);
    }
}

