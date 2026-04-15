<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contact form row (table: contacts).
 */
class Contact extends Entity
{
    /**
     * @var array<string, bool>
     */
    protected $_accessible = [
        'name' => true,
        'email' => true,
        'phone' => true,
        'message' => true,
        'created' => true,
        'modified' => true,
    ];
}
