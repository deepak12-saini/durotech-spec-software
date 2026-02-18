<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CoaResult extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected function _setCoaId($value)
    {
        return $value === null || $value === '' ? null : (int)$value;
    }
}
