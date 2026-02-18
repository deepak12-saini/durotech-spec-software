<?php

session_start();
// Database connection details from app_local.php
$db['hostname'] = 'localhost';
$db['username'] = 'customer_durotech';
$db['password'] = '_XTH3oe3wm~ajnp6'; 
$db['database'] = 'xoroglobal_customer_durotech';
$link = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);

date_default_timezone_set('Asia/Kolkata');
$site_url = "https://www.durotechindustries.com.au/";
mysqli_query($link,"SET SESSION SQL_MODE := ''");

?>