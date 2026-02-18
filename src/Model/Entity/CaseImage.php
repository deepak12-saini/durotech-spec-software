<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CaseImage extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}

