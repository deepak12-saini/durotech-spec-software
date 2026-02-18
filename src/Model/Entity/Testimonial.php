<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Testimonial extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}

