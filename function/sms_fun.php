<?php
include_once('string_fun.php');
function fatch_SMS_from_sms_table($from,$limit)
{
	$sql="select name,phone_no,message from tblsms limit $from,$limit";
	//echo $sql; exit;
	$rs=execSelect($sql);
	return $rs;
}
?>