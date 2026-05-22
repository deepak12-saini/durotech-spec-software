<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class AiSpecItem extends Entity
{
    protected $_accessible = [
        'ai_spec_section_id' => true,
        'wpm_code' => true,
        'tag_color' => true,
        'application_area' => true,
        'product_name' => true,
        'description' => true,
        'fall_requirement' => true,
        'sort_order' => true,
    ];
}
