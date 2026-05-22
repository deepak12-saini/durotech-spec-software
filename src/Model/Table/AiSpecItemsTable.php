<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AiSpecItemsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('ai_spec_items');
        $this->setPrimaryKey('id');
        $this->setEntityClass(\App\Model\Entity\AiSpecItem::class);
        $this->belongsTo('AiSpecSections', ['foreignKey' => 'ai_spec_section_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('wpm_code')
            ->maxLength('wpm_code', 32)
            ->allowEmptyString('wpm_code');

        $validator
            ->scalar('tag_color')
            ->maxLength('tag_color', 16)
            ->allowEmptyString('tag_color');

        return $validator;
    }
}
