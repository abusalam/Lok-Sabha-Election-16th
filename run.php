<?php 
include 'mysqliconn.php';
include 'token.php';
$sub_div=isset($_GET['subdiv'])?$_GET['subdiv']:'';
new token($sub_div,'01');
?>