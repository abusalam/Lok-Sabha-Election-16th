<?php
include_once('inc/db_trans.inc.php');
include_once('function/appointment_fun.php');
$opn=isset($_REQUEST['opn'])?$_REQUEST['opn']:"";
if($opn=='gen_sl')
{
	$subdiv=(isset($_GET['Subdivision'])?$_GET['Subdivision']:'0');
	$rsApp=first_app_letter3_print($subdiv);
	$num_rows=rowCount($rsApp);
	
	if($num_rows>0)
	{
		include_once('inc/commit_con.php');
		mysqli_autocommit($link,FALSE);
		$sql="update first_rand_table set sl_no=? where personcd=?";
		$stmt1 = mysqli_prepare($link, $sql);
		
		mysqli_stmt_bind_param($stmt1, 'is', $sl,$personcd);
		$sl=0;
		$rec=0;
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowApp=getRows($rsApp);
			$personcd=$rowApp['personcd'];
			$sl=$sl+1;
			mysqli_stmt_execute($stmt1);
			$rec+=mysqli_stmt_affected_rows($stmt1);
		}
		mysqli_commit($link);
		
		mysqli_stmt_close($stmt1);
		mysqli_close($link);
		echo "Records available: $rec;<input type='hidden' name='hid_rec' id='hid_rec' value='$rec' />&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "Print From: &nbsp;<input type='text' name='txtfrom' id='txtfrom' style='width:50px;' />&nbsp;&nbsp;&nbsp;
	To: &nbsp;<input type='text' name='txtto' id='txtto' style='width:50px;' />";
	}
}
?>