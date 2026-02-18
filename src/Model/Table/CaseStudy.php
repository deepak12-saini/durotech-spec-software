<?php
App::uses('AppModel', 'Model');

class CaseStudy extends AppModel {
    public $name = 'CaseStudy';

        public $belongsTo = [
            'Employee' => [
                'className' => 'Employee',
                'foreignKey' => 'created_by'
            ]
        ];

        public $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'Project title is required.'
        ),
        // 'slug' => array(
        //     'rule' => 'notEmpty',
        //     'message' => 'Slug (URL identifier) is required.'
        // ),
        'project_date' => array(
            'rule' => array('custom', '/^\d{4}-\d{2}-\d{2}$/'),
            'allowEmpty' => false,
            'message' => 'Please enter a valid date in YYYY-MM-DD format.'
        ),

        'location' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter project location.'
        ),
        'short_summary' => array(
            'rule' => 'notEmpty',
            'message' => 'Please add a short summary.'
        ),
        'challenge' => array(
            'rule' => 'notEmpty',
            'message' => 'Please describe the challenge.'
        ),
        'solution' => array(
            'rule' => 'notEmpty',
            'message' => 'Please describe the solution.'
        ),
        'outcome' => array(
            'rule' => 'notEmpty',
            'message' => 'Please describe the outcome.'
        ),
    );

    public $hasMany = array(
        'CaseImage' => array(
            'className' => 'CaseImage',
            'foreignKey' => 'case_study_id',
            'dependent' => true,
            'order' => 'CaseImage.ordering ASC'
        )
    );

    // optional HABTM relation to Product
    public $hasAndBelongsToMany = array(
        'Product' => array(
            'className' => 'Product',
            'joinTable' => 'case_study_products',
            'foreignKey' => 'case_study_id',
            'associationForeignKey' => 'product_id',
            'unique' => true
        )
    );

    public function beforeSave($options = array()) {
        if (!empty($this->data[$this->alias]['title']) && empty($this->data[$this->alias]['slug'])) {
            $this->data[$this->alias]['slug'] = Inflector::slug($this->data[$this->alias]['title'], '-');
        }
        return true;
    }
}
