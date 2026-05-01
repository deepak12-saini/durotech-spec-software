<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class QuickSpecsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('quick_specs');
        $this->setPrimaryKey('id');
        $this->setEntityClass(\App\Model\Entity\QuickSpec::class);
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('project_name')
            ->maxLength('project_name', 255)
            ->requirePresence('project_name', 'create')
            ->notEmptyString('project_name', 'Project name is required.');

        $validator
            ->scalar('project_type')
            ->maxLength('project_type', 64)
            ->requirePresence('project_type', 'create')
            ->notEmptyString('project_type', 'Project type is required.');

        $validator
            ->scalar('area')
            ->maxLength('area', 128)
            ->requirePresence('area', 'create')
            ->notEmptyString('area', 'Area / location type is required.');

        $validator
            ->scalar('system_interest')
            ->maxLength('system_interest', 255)
            ->allowEmptyString('system_interest');

        $validator
            ->scalar('quantity_or_size')
            ->maxLength('quantity_or_size', 128)
            ->allowEmptyString('quantity_or_size');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name', 'Name is required.');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'Email is required.');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 64)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone', 'Phone is required.');

        $validator
            ->scalar('company')
            ->maxLength('company', 255)
            ->allowEmptyString('company');

        $validator
            ->scalar('state')
            ->maxLength('state', 64)
            ->allowEmptyString('state');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->scalar('status')
            ->inList('status', ['new', 'seen', 'done'], 'Invalid status.');

        return $validator;
    }
}
