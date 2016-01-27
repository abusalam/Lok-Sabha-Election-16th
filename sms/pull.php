<?php

require_once( '../lib.inc.php');

if ($_SERVER['REMOTE_ADDR'] === SMSGW_IP) {

  $Data = new MySQLiDB();
  $smsData = $Data->SqlSafe(json_encode($_GET));
  $Qry = "insert into SMS_Data(`IP`,`MsgData`) values('{$_SERVER['REMOTE_ADDR']}','{$smsData}')";
  $Data->do_ins_query($Qry);
  $Data->do_close();

  $KeyWords = explode(" ", $_GET['Message'], 2);
  switch (strtolower($KeyWords[0])) {
    case strtolower("GetID"):
      SMSGW::SendSMS("Request for ID Registered Successfully.", $_GET['Sender']);
      break;
    case strtolower("DOB"):
      SMSGW::SendSMS("Request for Date of Birth Change Registered Successfully.", $_GET['Sender']);
      break;
    default:
      SMSGW::SendSMS("Invalid Keyword: {$KeyWords[0]}", $_GET['Sender']);
      break;
  }
} else {

  header("HTTP/1.1 404 Not Found");
}
?>
