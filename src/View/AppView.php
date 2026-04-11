<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/3/en/views.html#the-app-view
 */
class AppView extends View
{
    /**
     * Legacy CakePHP 2 compatibility for templates using $this->params['controller'/'action'].
     *
     * @var array<string, mixed>
     */
    public $params = [];
    /**
     * Use .php extension for template and layout files (default is .ctp).
     *
     * @var string
     */
    protected $_ext = '.php';

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadHelper('Paginator');
        $controller = (string)$this->getRequest()->getParam('controller', '');
        $action = (string)$this->getRequest()->getParam('action', '');
        // Old templates compare lowercase values like 'staffs' and 'dashboard'.
        $this->params = [
            'controller' => strtolower($controller),
            'action' => strtolower($action),
            'prefix' => $this->getRequest()->getParam('prefix'),
            'pass' => (array)$this->getRequest()->getParam('pass', []),
        ];
    }
}
