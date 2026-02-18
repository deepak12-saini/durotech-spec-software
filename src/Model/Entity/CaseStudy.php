<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CaseStudy extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}

