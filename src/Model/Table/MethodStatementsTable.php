<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class MethodStatementsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('method_statements');
        $this->setPrimaryKey('id');
        $this->setEntityClass(\App\Model\Entity\MethodStatement::class);
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
            ->notEmptyString('area', 'Area / application is required.');

        $validator
            ->scalar('scope_of_work')
            ->allowEmptyString('scope_of_work');

        $validator
            ->scalar('system_used')
            ->maxLength('system_used', 255)
            ->allowEmptyString('system_used');

        $validator
            ->scalar('substrate')
            ->maxLength('substrate', 255)
            ->allowEmptyString('substrate');

        $validator
            ->scalar('project_address')
            ->maxLength('project_address', 512)
            ->allowEmptyString('project_address');

        $validator
            ->scalar('start_date')
            ->maxLength('start_date', 64)
            ->allowEmptyString('start_date');

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
