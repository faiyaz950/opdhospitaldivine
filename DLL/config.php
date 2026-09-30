<?php
require_once __DIR__ . '/mysql_compat.php';

$host = "localhost";
$username = "root";
$password = "root";
$dbname = "dhc-hms-fgh";

// Server credentials live in config.local.php, which is kept out of git.
if (file_exists(__DIR__ . '/config.local.php')) {
    include __DIR__ . '/config.local.php';
}

$con = mysql_connect($host, $username, $password);
if (!$con) {
    die('Database connection failed: ' . mysql_error());
}

$db = mysql_select_db($dbname, $con);
if (!$db) {
    die('Could not select database: ' . mysql_error());
}

mysql_set_charset('utf8', $con);
require_once __DIR__ . '/uhid.php';
$site_name = "Divine Centre";
