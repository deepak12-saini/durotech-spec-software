<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class AiSpec extends Entity
{
    protected $_accessible = [
        'admin_id' => true,
        'tracknumber' => true,
        'project' => true,
        'client' => true,
        'revision' => true,
        'doc_reference' => true,
        'section_number' => true,
        'section_title' => true,
        'subsection_number' => true,
        'subsection_title' => true,
        'pdf_attachment' => true,
        'save_status' => true,
        'deleted_at' => true,
        'created' => true,
        'modified' => true,
        'ai_spec_sections' => true,
    ];
}
