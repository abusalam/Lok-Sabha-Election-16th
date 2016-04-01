<?php
/**
 * Created by PhpStorm.
 * User: abu
 * Date: 31/3/16
 * Time: 4:10 PM
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
include_once('../inc/db_trans.inc.php');
include_once('../function/sms_fun.php');
include_once ('smsgw.inc.php');

$from=301;
$to=400;
$limit=$to-$from+1;
$_SESSION['CountSMS']=$from;
$GatewaySMS=new SMSGW();
$Resp= $GatewaySMS->SendSMS('Test SMS','8348691719');
var_dump($Resp);
?>