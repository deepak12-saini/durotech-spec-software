<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QuickSpec entity — public website quick spec request.
 *
 * @property int $id
 * @property string $project_name
 * @property string $project_type
 * @property string $area
 * @property string $system_interest
 * @property string $quantity_or_size
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $company
 * @property string $state
 * @property string|null $notes
 * @property string $status
 * @property string $ip_address
 * @property string $user_agent
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class QuickSpec extends Entity
{
    /**
     * @var array<string, bool>
     */
    protected $_accessible = [
        'project_name' => true,
        'project_type' => true,
        'area' => true,
        'system_interest' => true,
        'quantity_or_size' => true,
        'name' => true,
        'email' => true,
        'phone' => true,
        'company' => true,
        'state' => true,
        'notes' => true,
        'status' => true,
        'ip_address' => true,
        'user_agent' => true,
        'created' => true,
        'modified' => true,
    ];
}
