<?php
session_start();
extract($_GET);
date_default_timezone_set('Asia/Calcutta');
include_once('inc/db_trans.inc.php');
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
$opn=isset($_GET['opn'])?$_GET['opn']:"";
$pass=isset($_GET['pass'])?$_GET['pass']:"";
$usercode=isset($_SESSION['user_cd'])?$_SESSION['user_cd']:"";
$dt = new DateTime();
$posted_date=$dt->format('Y-m-d H:i:s');
if($opn=='unlock_firstrand')
{
	$sql="select * from password where password=MD5('$pass') and randomise ='1' and subdivisioncd='$subdiv_cd'";
	$rs=execSelect($sql);
	if(rowCount($rs)>0)
	{
		//$row=getRows($rs);
		echo "unlock";
		execUpdate("update password set status='unlock', usercode='$usercode', posted_date='$posted_date' where randomise='1' and subdivisioncd='$subdiv_cd'");
	}
	else
	{
		echo "Wrong Password !!!";
	}
}
if($opn=='lock_firstrand')
{
	$sql="update password set status='lock', usercode='$usercode', posted_date='$posted_date' where randomise='1' and subdivisioncd='$subdiv_cd'";
	$i=execUpdate($sql);
	if($i>0)
	{
		echo "lock";		
	}
}
if($opn=='state_firstrand')
{
	$sql="select status from password where randomise ='1' and subdivisioncd='$subdiv_cd'";
	$rs=execSelect($sql);
	if(rowCount($rs)>0)
	{		
		$row=getRows($rs);
		if($row['status']=='unlock')
		{
			echo "false";
		}
		else
		{
			echo "true";
		}
	}
}
// ========== second randomisation ===========
if($opn=='unlock_secondrand')
{
	$sql="select * from password where password=MD5('$pass') and randomise ='2' and subdivisioncd='$subdiv_cd'";
	$rs=execSelect($sql);
	if(rowCount($rs)>0)
	{
		//$row=getRows($rs);
		echo "unlock";
		execUpdate("update password set status='unlock', usercode='$usercode', posted_date='$posted_date' where randomise='2' and subdivisioncd='$subdiv_cd'");
	}
	else
	{
		echo "Wrong Password !!!";
	}
}
if($opn=='lock_secondrand')
{
	$sql="update password set status='lock', usercode='$usercode', posted_date='$posted_date' where randomise='2' and subdivisioncd='$subdiv_cd'";
	$i=execUpdate($sql);
	if($i>0)
	{
		echo "lock";		
	}
}
if($opn=='state_secondrand')
{
	$sql="select status from password where randomise ='2' and subdivisioncd='$subdiv_cd'";
	$rs=execSelect($sql);
	if(rowCount($rs)>0)
	{		
		$row=getRows($rs);
		if($row['status']=='unlock')
		{
			echo "false";
		}
		else
		{
			echo "true";
		}
	}
}
//====== third randomisation
if($opn=='unlock_thirdrand')
{
	$sql="select * from password where password=MD5('$pass') and randomise ='3' and subdivisioncd='$subdiv_cd'";
	$rs=execSelect($sql);
	if(rowCount($rs)>0)
	{
		//$row=getRows($rs);
		echo "unlock";
		execUpdate("update password set status='unlock', usercode='$usercode', posted_date='$posted_date' where randomise='3' and subdivisioncd='$subdiv_cd'");
	}
	else
	{
		echo "Wrong Password !!!";
	}
}
if($opn=='lock_thirdrand')
{
	$sql="update password set status='lock', usercode='$usercode', posted_date='$posted_date' where randomise='3' and subdivisioncd='$subdiv_cd'";
	$i=execUpdate($sql);
	if($i>0)
	{
		echo "lock";		
	}
}
if($opn=='state_thirdrand')
{
	$sql="select status from password where randomise ='3' and subdivisioncd='$subdiv_cd'";
	$rs=execSelect($sql);
	if(rowCount($rs)>0)
	{		
		$row=getRows($rs);
		if($row['status']=='unlock')
		{
			echo "false";
		}
		else
		{
			echo "true";
		}
	}
}
?>