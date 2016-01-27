<?php
date_default_timezone_set('Asia/Calcutta');
session_start();
include_once('inc/db_trans.inc.php');
include_once('function/master_fun.php');

$user_cd=$_SESSION['user_cd'];
	
$action=isset($_REQUEST['opn'])?$_REQUEST['opn']:"";
if($action=='save')
{
	$psno=$_REQUEST['psno'];
	$postfix=$_REQUEST['postfix'];
	$subdivision=$_REQUEST['subdivision'];
	$assembly=$_REQUEST['assembly'];
	$dcrc=$_REQUEST['dcrc'];
	$member=$_REQUEST['member'];
	$psname=clean_spl($_REQUEST['psname']);	

	$usercd=$user_cd;
	
	$cnt=duplicate_polling_stn($psno,$assembly,$psname,$postfix);	
	/*if(isset($_GET['psno']) && isset($_GET['assembly']))
	{
		$cnt=0;
	}*/
	if($cnt==0)
	{
		/*if(isset($_GET['psno']) && isset($_GET['assembly']))
		{
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_polling_stn($psno,$postfix,$assembly,$psname,$usercd,$posted_date);
			if($ret==1)
			{
				redirect("polling-station.php?msg=success");
			}
		}
		else
		{*/
		$ret=save_polling_stn($psno,$postfix,$subdivision,$assembly,$dcrc,$member,$psname,$usercd);
		
		if($ret==1)
		{
			$msg="<div class='alert-success'>Record saved successfully</div>";
		}
	}
	else
	{
		$msg="<div class='alert-error'>Deplicate Polling Station ID not allowed</div>";
	}
	echo $msg;
	unset($ret,$psno,$postfix,$subdivision,$assembly,$dcrc,$member,$psname);
}
if($action=='update')
{
	$psno=$_REQUEST['psno'];
	$postfix=$_REQUEST['postfix'];
	$subdivision=$_REQUEST['subdivision'];
	$assembly=$_REQUEST['assembly'];
	$dcrc=$_REQUEST['dcrc'];
	$psname=$_REQUEST['psname'];
	$pscode=$_REQUEST['pscode'];
	$usercd=$user_cd;
	$cnt=0;

	if($cnt==0)
	{
		//echo $assembly;
	  	    $dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_polling_stn($psno,$postfix,$assembly,$psname,$usercd,$posted_date,$pscode);
			if($ret==1)
			{
				echo "<div class='alert-success'>Record updated successfully</div>";
				return;
			}
			
	}
	//echo $msg;
	unset($cnt,$ret,$psno,$postfix,$subdivision,$assembly,$dcrc,$member,$psname);
}
?>
