<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CaseStudyTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->addBehavior('Timestamp');

        $this->setTable('case_studies');
        $this->setPrimaryKey('id');
        $this->setDisplayField('title');

        if ($this->getSchema()->hasColumn('created_by')) {
            $this->belongsTo('Employee', [
                'className' => 'Employee',
                'foreignKey' => 'created_by',
                'joinType' => 'LEFT',
            ]);
        }

        $this->hasMany('CaseImage', [
            'className' => 'CaseImage',
            'foreignKey' => 'case_study_id',
        ]);

        $this->belongsToMany('Products', [
            'foreignKey' => 'case_study_id',
            'targetForeignKey' => 'product_id',
            'joinTable' => 'case_study_products',
        ]);
    }
}
