<?php
include_once("MICS_SMS.php");

// Declare variables.
$Username = "ceowb";
$Password = "#ceo_election15";
$MsgSender = "WBELEC";
$DestinationAddress = $mob_no;

//echo $DestinationAddress;
//echo $Message;
//exit;
//$Message = "Welcome ".$name.", Your ".$training_desc." will be held on ".$training_dt." at ".$training_time." at ".$venuename;

// Create ViaNettSMS object with params $Username and $Password
$MICS_SMS = new MICS_SMS($Username, $Password);
try
{
	// Send SMS through the HTTP API
	$Result = $MICS_SMS->SendSMS($MsgSender, $DestinationAddress, $Message);
	// Check result object returned and give response to end user according to success or not.
	//echo $Result->ErrorCode;
	//echo $Result->ErrorMessage;
	//echo $Result->Success;
	if ($Result->Success == true)
		$Message = "Message successfully sent!";
	else
		$Message = "Error occured while sending SMS<br />Errorcode: " . $Result->ErrorCode . "<br />Errormessage: " . $Result->ErrorMessage;
}
catch (Exception $e)
{
	//Error occured while connecting to server.
	$Message = $e->getMessage();
}

?>