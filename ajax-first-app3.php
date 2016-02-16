<?php
include_once('inc/db_trans.inc.php');
include_once('function/appointment_fun.php');
$opn=isset($_REQUEST['opn'])?$_REQUEST['opn']:"";
if($opn=='gen_sl')
{
	$subdiv=(isset($_GET['Subdivision'])?$_GET['Subdivision']:'0');
	//first_app_update_sl_print($subdiv);
	$rsApp=first_app_letter3_print($subdiv);
	//$num_rows=rowCount($rsApp);
	//echo $num_rows;
	//exit();
	//if($num_rows>0)
	//{
		/*include_once('inc/commit_con.php');
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
		mysqli_close($link);*/
		if($rsApp==1)
		{
			//echo $rsApp;
		//	exit;
		  $f_sl=first_app_letter3_max_slno($subdiv);
		  
		
		echo "Records available: $f_sl;<input type='hidden' name='hid_rec' id='hid_rec' value='$f_sl' />&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "Print From: &nbsp;<input type='text' name='txtfrom' id='txtfrom' style='width:50px;' />&nbsp;&nbsp;&nbsp;
	To: &nbsp;<input type='text' name='txtto' id='txtto' style='width:50px;' />";
		}
	//}
}
if($opn=='gen_sl_extra')
{
	$subdiv=(isset($_GET['Subdivision'])?$_GET['Subdivision']:'0');
	$phase=(isset($_GET['phase'])?$_GET['phase']:'0');
	$rsApp=first_app_letter3_print_extra($subdiv,$phase);
		if($rsApp==1)
		{
			//echo $rsApp;
		//	exit;
		  $f_sl=first_app_letter3_max_slno_extra($subdiv,$phase);
		  
		
		echo "Records available: $f_sl;<input type='hidden' name='hid_rec' id='hid_rec' value='$f_sl' />&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "Print From: &nbsp;<input type='text' name='txtfrom' id='txtfrom' style='width:50px;' />&nbsp;&nbsp;&nbsp;
	To: &nbsp;<input type='text' name='txtto' id='txtto' style='width:50px;' />";
		}
	//}
}
if($opn=='tr_phase')
{
	$subdiv=(isset($_GET['Subdivision'])?$_GET['Subdivision']:'0');
	$rsP=fatch_personnela_phasetype($subdiv);
	$num_rows=rowCount($rsP);
	if($num_rows<1)
	{
		echo "<select name='phase' id='phase' style='width:200px;'><option value='0'>-Select Phase Type-</option></select>";
	}
	else
	{
		echo "<select name='phase' id='phase' style='width:200px;'><option value='0'>-Select Phase Type-</option>";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowP=getRows($rsP);
			$phase_name=convert_number_to_words($rowP['0']);
			echo "<option value='$rowP[0]'>$phase_name</option>\n";
			$rowP=NULL;
		}
		echo "</select>\n";
	}
unset($rsP,$num_rows,$rowP);
}
if($opn=='tr_phase_print')
{
	$subdiv=(isset($_GET['Subdivision'])?$_GET['Subdivision']:'0');
	$rsP=fatch_personnela_phasetype($subdiv);
	$num_rows=rowCount($rsP);
	if($num_rows<1)
	{
		echo "<select name='phase' id='phase' style='width:240px;'><option value='0'>-Select Phase Type-</option></select>";
	}
	else
	{
		echo "<select name='phase' id='phase' style='width:240px;' onchange='phse_change(this.value);'><option value='0'>-Select Phase Type-</option>";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowP=getRows($rsP);
			$phase_name=convert_number_to_words($rowP['0']);
			echo "<option value='$rowP[0]'>$phase_name</option>\n";
			$rowP=NULL;
		}
		echo "</select>\n";
	}
unset($rsP,$num_rows,$rowP);
}
?>