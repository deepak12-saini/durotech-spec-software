<?php
App::uses('AppModel', 'Model');

class CaseImage extends AppModel {
    public $name = 'CaseImage';
    public $belongsTo = array(
        'CaseStudy' => array(
            'className' => 'CaseStudy',
            'foreignKey' => 'case_study_id'
        )
    );
}
