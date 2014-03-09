<?php
/*
$recipients = array(
   'utsab.87@gmail.com' => 'Person One',
   'arabinda.hazra@gmail.com' => 'Person Two',
   // ..
);
foreach($recipients as $email => $name)
{
   $mail->AddAddress($email, $name);
}
*/
function send_mail($recipient,$name)
{
	if($recipient)
	{
		include_once('class.phpmailer.php');
		$mail = new PHPMailer(true);
		
		//Send mail using gmail
		//if($send_using_gmail){
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->SMTPAuth = true; // enable SMTP authentication
			//$mail->SMTPSecure = "ssl"; // sets the prefix to the servier
			$mail->Host = "smtp.burdwanindustry.com"; // sets SMTP server
			//$mail->Port = 465; // set the SMTP port for the GMAIL server
			$mail->Username = "info@burdwanindustry.com"; //  username
			$mail->Password = "burd#123"; //  password
		//}
	
		//Typical mail data
		$email=$recipient; // Email Recipient
		$name=$name;	// Recipient Name
		$mail->AddAddress($email, $name);
		$email_from="info@burdwanindustry.com";	// Email sender
		$name_from="District Magistrate";	// Sender Name
		$mail->SetFrom($email_from, $name_from);
		$mail->Subject = "Training Absent";
		$str="*************************************************************************************\n";
		$str.="\n";
		$str.="Please do not reply to this email. This is system generated.\n";
		$str.="\n";
		$str.="*************************************************************************************\n";
		$str.="Hi ".$name."\n\tYou have not attend the training conducted for election duty.\n\nRegards,\nAdministrator";
		$mail->Body = $str;
		
		try{
			$mail->Send();
			//echo "Success!";
		} catch(Exception $e){
			//Something went bad
			echo "Fail - " . $mail->ErrorInfo;
		}
	}
}
?>
