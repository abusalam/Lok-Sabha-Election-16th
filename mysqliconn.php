<?php
if (file_exists(__DIR__ . '/inc/config.inc.php')) {
 require_once __DIR__ . '/inc/config.inc.php';
} else {
 require_once __DIR__ . '/inc/config.default.inc.php';
}
class mysqliconn {
private  $DB_NAME = MySQL_DB;
private $DB_HOST = HOST_Name;
private $DB_USER = MySQL_User;
private $DB_PASS = MySQL_Pass;
private $mysqli;
function __construct() {
$this->mysqli= new mysqli($this->DB_HOST, $this->DB_USER, $this->DB_PASS, $this->DB_NAME);
if (mysqli_connect_errno()) 
{printf("Connect failed: %s\n", mysqli_connect_error());
exit();
}
}

public function getconn() {
 return $this->mysqli;
}
}

?>
