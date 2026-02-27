<?php

declare(strict_types=1);

namespace App\View;

use Cake\View\View;

/**
 * Email view: uses .php template extension so Email templates under
 * src/Template/Email/ can be contact_form.php, default.php, etc. (CakePHP 3.10).
 */
class EmailView extends View
{
    /**
     * Template file extension for email templates.
     *
     * @var string
     */
    protected $_ext = '.php';
}
