<?php

session_start();
// $db['hostname'] = 'localhost';
// $db['username'] = 'customer_duro';
// $db['password'] = 'fI06li!2'; 
// $db['database'] = 'customer_durotech';

$db['hostname'] = 'localhost';
$db['username'] = 'root';
$db['password'] = ''; 
$db['database'] = 'custom_durotech';
$link = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);

date_default_timezone_set('Asia/Kolkata');
$site_url = "https://www.durotechindustries.com.au/";
mysqli_query($link,"SET SESSION SQL_MODE := ''");

?>