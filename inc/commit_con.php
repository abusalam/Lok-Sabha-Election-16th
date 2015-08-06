<?php
if (file_exists(__DIR__ . '/config.inc.php')) {
    require_once __DIR__ . '/config.inc.php';
} else {
    require_once __DIR__ . '/config.default.inc.php';
}
global $link;
$host=HOST_Name;
$db=MySQL_DB;
$user=MySQL_User;
$pass=MySQL_Pass;
$link=mysqli_connect($host,$user,$pass,$db);
?>