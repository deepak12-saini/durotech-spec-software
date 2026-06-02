<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class ClaudeSpecDraft extends Entity
{
    protected $_accessible = [
        'employee_id' => true,
        'tracknumber' => true,
        'project_brief' => true,
        'client_name' => true,
        'company' => true,
        'email' => true,
        'address' => true,
        'generated_payload' => true,
        'status' => true,
        'applied_mailer_id' => true,
        'deleted_at' => true,
        'created' => true,
        'modified' => true,
    ];
}
