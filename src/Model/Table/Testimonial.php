<?php
App::uses('AppModel', 'Model');

class Testimonial extends AppModel {

    public $name = 'Testimonial';

    public $belongsTo = [
        'Employee' => [
            'className' => 'Employee',
            'foreignKey' => 'created_by'
        ]
    ];

    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter client name.'
        ),
        'quote' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter testimonial quote.'
        )
    );
}
