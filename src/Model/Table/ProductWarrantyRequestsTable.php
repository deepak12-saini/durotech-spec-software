<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Utility\ProductWarrantySerial;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use ArrayObject;

class ProductWarrantyRequestsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('product_warranty_request');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                ],
            ],
        ]);
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew() && trim((string)($entity->get('serialnumber') ?? '')) === '') {
            $entity->set('serialnumber', ProductWarrantySerial::allocate());
        }
    }

    public function validationAdminAdd(Validator $validator): Validator
    {
        $validator = $this->validationDefault($validator);
        $validator->offsetUnset('contractor_signature');
        $validator->allowEmptyString('contractor_signature');

        return $validator;
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->allowEmptyString('serialnumber')
            ->scalar('serialnumber')
            ->maxLength('serialnumber', 255);

        $validator
            ->scalar('dateofpurchase')
            ->maxLength('dateofpurchase', 32)
            ->requirePresence('dateofpurchase', 'create')
            ->notEmptyString('dateofpurchase', 'Date of purchase is required.')
            ->date('dateofpurchase', ['ymd'], 'Enter a valid date of purchase (YYYY-MM-DD).');

        $validator
            ->scalar('product')
            ->requirePresence('product', 'create')
            ->notEmptyString('product', 'Product is required.');

        $validator
            ->allowEmptyString('used_as')
            ->scalar('used_as');

        $validator
            ->scalar('building_address')
            ->requirePresence('building_address', 'create')
            ->notEmptyString('building_address', 'Building address is required.');

        $validator
            ->scalar('contract_company_name')
            ->requirePresence('contract_company_name', 'create')
            ->notEmptyString('contract_company_name', 'Contractor company name is required.');

        $validator
            ->scalar('contract_name')
            ->requirePresence('contract_name', 'create')
            ->notEmptyString('contract_name', 'Contractor full name is required.');

        $validator
            ->scalar('email')
            ->maxLength('email', 255)
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'Email is required.')
            ->email('email', false, 'Enter a valid email address.');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 32)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone', 'Mobile number is required.');

        $validator
            ->scalar('sign_date')
            ->maxLength('sign_date', 32)
            ->requirePresence('sign_date', 'create')
            ->notEmptyString('sign_date', 'Signature date is required.')
            ->date('sign_date', ['ymd'], 'Enter a valid signature date (YYYY-MM-DD).');

        $validator
            ->scalar('contractor_signature')
            ->maxLength('contractor_signature', 255)
            ->requirePresence('contractor_signature', 'create')
            ->notEmptyString('contractor_signature', 'Signature is required.');

        $validator
            ->allowEmptyString('application')
            ->scalar('application');

        $validator
            ->allowEmptyString('area_warranted')
            ->scalar('area_warranted');

        $validator
            ->allowEmptyString('building_area_name')
            ->scalar('building_area_name');

        $validator
            ->allowEmptyString('building_name')
            ->scalar('building_name');

        $validator
            ->allowEmptyDate('start_requested_warranty')
            ->date('start_requested_warranty', ['ymd'], 'Enter a valid warranty start date (YYYY-MM-DD).');

        $validator
            ->allowEmptyDate('end_requested_warranty')
            ->date('end_requested_warranty', ['ymd'], 'Enter a valid warranty end date (YYYY-MM-DD).');

        $validator
            ->allowEmptyString('applicator')
            ->scalar('applicator');

        $validator
            ->allowEmptyString('applicator_contact')
            ->scalar('applicator_contact');

        $validator
            ->allowEmptyString('applicator_active_abn')
            ->scalar('applicator_active_abn');

        $validator
            ->allowEmptyString('applicator_address')
            ->scalar('applicator_address');

        $validator
            ->allowEmptyString('status')
            ->scalar('status');

        $validator
            ->allowEmptyString('form_version')
            ->scalar('form_version')
            ->maxLength('form_version', 10);

        return $validator;
    }
}
