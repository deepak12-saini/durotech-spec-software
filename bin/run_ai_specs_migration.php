<?php
if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);
        return $value === false ? $default : $value;
    }
}
$root = dirname(__DIR__);
$appLocal = require $root . '/config/app_local.php';
$d = $appLocal['Datasources']['default'];
$mysqli = new mysqli(
    $d['host'],
    $d['username'],
    $d['password'],
    $d['database'],
    (int)($d['port'] ?? 3307)
);
if ($mysqli->connect_error) {
    fwrite(STDERR, $mysqli->connect_error . PHP_EOL);
    exit(1);
}
$sql = file_get_contents($root . '/config/schema/ai_specs.sql');
$parts = preg_split('/;\s*\R/', $sql);
foreach ($parts as $q) {
    $q = trim($q);
    if ($q === '') {
        continue;
    }
    // Strip leading SQL comment lines only
    $q = preg_replace('/^(?:\s*--[^\r\n]*\r?\n)+/', '', $q);
    $q = trim($q);
    if ($q === '' || stripos($q, 'CREATE TABLE') !== 0) {
        continue;
    }
    if (!$mysqli->query($q)) {
        fwrite(STDERR, $mysqli->error . ' on: ' . substr($q, 0, 80) . PHP_EOL);
        exit(1);
    }
}
echo "Tables created OK\n";
