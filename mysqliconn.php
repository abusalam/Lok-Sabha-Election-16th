<?php
class mysqliconn {
private  $DB_NAME = "ppds"; 
private $DB_HOST = "127.0.0.1"; 
private $DB_USER = "pp4ds"; 
private $DB_PASS = "ppds";
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
