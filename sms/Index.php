<?php
include_once("MICS_SMS.php");

// Declare variables.
$Username = "BWNMSE1";
$Password = "bwnmse123";
$MsgSender = "BWNMSE";
$DestinationAddress = $mob_no;
$Message = "Welcome ".$name.", Your ".$training_desc." will be held on ".$training_dt." at ".$training_time." at ".$venuename;

// Create ViaNettSMS object with params $Username and $Password
$MICS_SMS = new MICS_SMS($Username, $Password);
try
{
	// Send SMS through the HTTP API
	$Result = $MICS_SMS->SendSMS($MsgSender, $DestinationAddress, $Message);
	// Check result object returned and give response to end user according to success or not.
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