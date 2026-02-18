<?php
App::uses('AppModel', 'Model');

class ProductWarrantyRequest extends AppModel {
    public $useTable = 'product_warranty_request';
    public $primaryKey = 'id';

    public $validate = [
        'serialnumber' => [
            'rule' => 'notEmpty',
            'message' => 'Serial number is required'
        ],
        'dateofpurchase' => [
            'rule' => 'notEmpty',
            'message' => 'Date of purchase is required'
        ],
        'product' => [
            'rule' => 'notEmpty',
            'message' => 'Product is required'
        ],
        'used_as' => [
            'rule' => 'notEmpty',
            'message' => 'Used As is required'
        ],
        'application' => [
            'rule' => 'notEmpty',
            'message' => 'Application is required'
        ],
        'area_warranted' => [
            'rule' => 'notEmpty',
            'message' => 'Area Warrantied is required'
        ],
        'building_address' => [
            'rule' => 'notEmpty',
            'message' => 'Building Address is required'
        ],
        'building_name' => [
            'rule' => 'notEmpty',
            'message' => 'Building Name is required'
        ],
        'start_requested_warranty' => [
            'rule' => 'notEmpty',
            'message' => 'Start date is required'
        ],
        'end_requested_warranty' => [
            'rule' => 'notEmpty',
            'message' => 'End date is required'
        ],
        'contract_company_name' => [
            'rule' => 'notEmpty',
            'message' => 'Contractor Company Name is required'
        ],
        'applicator_active_abn' => [
            'rule' => 'notEmpty',
            'message' => 'ABN No is required'
        ],
        'applicator_address' => [
            'rule' => 'notEmpty',
            'message' => 'Contractor Address is required'
        ],
        'contract_name' => [
            'rule' => 'notEmpty',
            'message' => 'Contractor Name is required'
        ],
        'sign_date' => [
            'rule' => 'notEmpty',
            'message' => 'Signature Date is required'
        ],
    ];
}
