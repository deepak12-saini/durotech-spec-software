<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InstagramPost Entity (CakePHP 3)
 */
class InstagramPost extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
