<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AiSpecSectionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('ai_spec_sections');
        $this->setPrimaryKey('id');
        $this->setEntityClass(\App\Model\Entity\AiSpecSection::class);
        $this->belongsTo('AiSpecs', ['foreignKey' => 'ai_spec_id']);
        $this->hasMany('AiSpecItems', [
            'foreignKey' => 'ai_spec_section_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('standards_text')
            ->maxLength('standards_text', 512)
            ->allowEmptyString('standards_text');

        return $validator;
    }
}
