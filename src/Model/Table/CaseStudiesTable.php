<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CaseStudiesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Database table name (adjust if different)
        $this->setTable('case_studies');
        $this->setPrimaryKey('id');
        $this->setDisplayField('title');

        // Associations inferred from views/controllers and CakePHP 2 CaseStudy model
        $this->hasMany('CaseImages', [
            'foreignKey' => 'case_study_id',
            'dependent' => false,
        ]);

        $this->belongsToMany('Products', [
            'foreignKey' => 'case_study_id',
            'targetForeignKey' => 'product_id',
            'joinTable' => 'case_study_products',
            'dependent' => false,
        ]);

        $this->belongsTo('Employee', [
            'foreignKey' => 'created_by',
            'joinType' => 'LEFT',
        ]);

        // status is 0=Inactive, 1=Active, 2=Approved (integer), not boolean
        $this->getSchema()->setColumnType('status', 'integer');
    }
}

