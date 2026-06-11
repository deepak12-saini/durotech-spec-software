<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InstagramPosts Table (CakePHP 3)
 */
class InstagramPostsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('instagram_posts');
        $this->setPrimaryKey('id');
        $this->setDisplayField('permalink');

        $this->addBehavior('Timestamp');

        $this->getSchema()->setColumnType('status', 'integer');
        $this->getSchema()->setColumnType('display_order', 'integer');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->requirePresence('permalink', 'create')
            ->notEmptyString('permalink', 'A valid Instagram post URL is required.')
            ->maxLength('permalink', 500);

        return $validator;
    }
}
