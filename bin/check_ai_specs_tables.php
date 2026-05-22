<?php
if (!function_exists('env')) {
    function env($key, $default = null) {
        $v = getenv($key);
        return $v === false ? $default : $v;
    }
}
$d = (require dirname(__DIR__) . '/config/app_local.php')['Datasources']['default'];
$m = new mysqli($d['host'], $d['username'], $d['password'], $d['database'], (int)$d['port']);
echo 'DB=' . $d['database'] . ' host=' . $d['host'] . ' port=' . $d['port'] . PHP_EOL;
if ($m->connect_error) {
    echo 'connect error: ' . $m->connect_error . PHP_EOL;
    exit(1);
}
$r = $m->query("SHOW TABLES LIKE 'ai_spec%'");
while ($row = $r->fetch_array()) {
    echo $row[0] . PHP_EOL;
}
