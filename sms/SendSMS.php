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

$from=$_REQUEST['from'];
$to=$_REQUEST['to'];
$limit=$to-$from+1;
$_SESSION['CountSMS']=$from;
$rs_data=fatch_SMS_from_sms_table(($from-1),$limit);
if(rowCount($rs_data)>0)
{
  //echo rowCount($rs_data);
  /*$smsarray=array('8946088417');
  foreach($smsarray as $send_no)
  {
      $Message="Hi";
      $mob_no = $send_no;
      include('sms/Index.php');
  }*/
  //$mob_no='9233314052';
  //$mob_no='8946088417';
  //$DestinationAddress = "8946088417";
  //$Message="Welcome";
  //include('sms/Index.php');
  for($i=1;$i<=rowCount($rs_data);$i++)
  {
    $row_data=getRows($rs_data);
    $name=$row_data['name'];
    $mob_no=$row_data['phone_no'];
    $Message="To ".$name.", ".$row_data['message'];

    $DestinationAddress = $mob_no;
    $GatewaySMS=new SMSGW();
    $Resp= $GatewaySMS->SendSMS($Message,$mob_no);
    $Resp['MobileNo']=$mob_no;
    $Resp['SentTo']=$name;
    $Resp['Count']=0+$_SESSION['CountSMS']++;
    echo '<li>'.$Resp['MobileNo'].' | '.$Resp['Msg'].' ['.$Resp['Count'].'] '.$Resp['SentTo'].'</li>';
  }
}