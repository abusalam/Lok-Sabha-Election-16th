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

    curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$uname&password=$pass&smsservicetype=singlemsg&senderid=$send&mobileno=$dest&content=$msg");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //$curl_output = curl_exec($ch);

    curl_close($ch);

    return $this->Response('402');//$curl_output);
  }

  public function Response($MsgCode){
    $RespCode=array(
      '401'=>'Credentials Error, may be invalid username or password',
      '402'=>'Messages submitted successfully',
      '403'=>'Credits not available',
      '404'=>'Internal Database Error',
      '405'=>'Internal Networking Error',
      '406'=>'Invalid or Duplicate numbers',
      '407'=>'Network Error on SMSC',
      '408'=>'Network Error on SMSC',
      '409'=>'SMSC response timed out, message will be submitted',
      '410'=>'Internal Limit Exceeded, Contact support',
      '411'=>'Sender ID not approved.','412'=>'Sender ID not approved.',
      '413'=>'Suspect Spam, we do not accept these messages.',
      '414'=>'Rejected by various reasons by the operator such as DND, SPAM etc');
    $Resp['Code']=explode(',',$MsgCode);
    $Resp['Msg']=$RespCode[trim($Resp['Code'][0])];
    return $Resp;
  }

}

?>