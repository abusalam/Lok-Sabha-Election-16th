<?php

require_once 'config.inc.php';

class SMSGW {

  public function SendSMS($SMSData, $MobileNo) {

    $uname = urlencode(SMSGW_USER);

    $pass = urlencode(SMSGW_PASS);

    $send = urlencode(SMSGW_SENDER);

    $dest = urlencode($MobileNo);

    $msg = urlencode($SMSData);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    curl_setopt($ch, CURLOPT_USERPWD, SMSGW_USER . ':' . SMSGW_PASS);

    curl_setopt($ch, CURLOPT_URL, SMSGW_URL);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$uname&password=$pass&sendername=$send&mobileno=$dest&message=$msg");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $curl_output = curl_exec($ch);

    curl_close($ch);

    return $curl_output;
  }

}

?>