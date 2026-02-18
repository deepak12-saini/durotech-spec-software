<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Coa extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected function _setAdminId($value)
    {
        return $value === null || $value === '' ? null : (int)$value;
    }
}
