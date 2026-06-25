<?php
/**
 * One-off setup: creates api_tokens table if missing.
 * Run: php bin/setup_api_tokens.php
 */
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

use Cake\Datasource\ConnectionManager;

$sql = file_get_contents(dirname(__DIR__) . '/config/schema/api_tokens.sql');
$conn = ConnectionManager::get('default');
$conn->execute($sql);
echo "api_tokens table ready.\n";
