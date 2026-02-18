<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Front Controller for CakePHP 3.x
 *
 * This is the entry point for all requests.
 *
 * Based on the CakePHP 3 application skeleton.
 *
 * @copyright Copyright (c) Cake Software Foundation
 * @link      https://cakephp.org CakePHP(tm) Project
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

// Redirect if URL has duplicate first path segment (e.g. /cake3app/cake3app/... -> /cake3app/...)
// Prevents "Controller class Cake3app could not be found" when base path is duplicated.
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
if ($requestUri !== '' && preg_match('#^/([^/]+)/\1/#', $requestUri, $m)) {
	$path = preg_replace('#^/([^/]+)/\1/#', '/$1/', $requestUri);
	$path = strpos($path, '?') !== false ? $path : $path;
	$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
	$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
	$location = $scheme . '://' . $host . $path;
	header('Location: ' . $location, true, 302);
	exit;
}

// Load application paths (defines ROOT, APP, CORE_PATH, etc.).
require dirname(__DIR__) . '/config/paths.php';

// Use Composer's autoloader.
require ROOT . DS . 'vendor' . DS . 'autoload.php';

// Bootstrap CakePHP framework.
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use App\Application;
use Cake\Http\Server;

$server = new Server(new Application(CONFIG));
$server->emit($server->run());
