<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class AiSpecSection extends Entity
{
    protected $_accessible = [
        'ai_spec_id' => true,
        'name' => true,
        'standards_text' => true,
        'sort_order' => true,
        'ai_spec_items' => true,
    ];
}
