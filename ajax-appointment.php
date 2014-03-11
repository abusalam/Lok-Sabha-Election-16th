<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/appointment_fun.php');

$opn=$_GET['opn'];
if($opn=='office')
{
	$sub_div=$_GET['sub_div'];
	echo "<select id='office' name='office' style='width:240px;' onchange='return office_change(this.value);'>\n";
	$rsOfc=fatch_Office_ag_subdiv($sub_div);
	$num_rows=rowCount($rsOfc);
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Office-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowOfc=getRows($rsOfc);
			echo "<option value='$rowOfc[0]'>$rowOfc[1]</option>\n";
			$rowOfc=null;
		}
	}
	$rsOfc=null;
	$num_rows=0;
	echo "</select>";
}
if($opn=='for_sub_emp_office')
{
	include_once('function/ofc_fun.php');
	$sub_div=$_GET['sub_div'];
	echo "<select id='office' name='office' style='width:240px;' onchange='return office_change(this.value);'>\n";
	$rsOfc=office_details_ag_forsub($sub_div);
	$num_rows=rowCount($rsOfc);
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Office-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowOfc=getRows($rsOfc);
			echo "<option value='$rowOfc[0]'>$rowOfc[2]</option>\n";
			$rowOfc=null;
		}
	}
	$rsOfc=null;
	$num_rows=0;
	echo "</select>";
}
if($opn=='personnel')
{
	$office=$_GET['office'];
	$sub_div=$_GET['sub_div'];
	$rsPer=fatch_personnel_ag_office($sub_div,$office);
	$num_rows=rowCount($rsPer);
	if($num_rows>0)
	{
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowPer=getRows($rsPer);
			echo "\n<input type='checkbox' id='chkbox$i' name='chkbox$i' /><label for='chkbox$i'>$rowPer[0]</label><br>\n";
			echo "<input type='hidden' name='hidId$i' value='$rowPer[0]' />";
			$rowPer=null;
		}
	}
	$rsPer=null;
	$num_rows=0;
}
if($opn=='assembly')
{
	$pc=$_GET['pc'];
	$sub_div=$_GET['sub_div'];
	echo "<select id='assembly' name='assembly' style='width:180px;'>\n";
	include_once('function/add_fun.php');
	//$rsAssembly=fatch_assembly_ag_pc($pc,$sub_div);
	$rsAssembly=fatch_assembly_ag_pc1($pc);
	$num_rows = rowCount($rsAssembly);
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Assembly-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowAssembly=getRows($rsAssembly);
			echo "<option value='$rowAssembly[assemblycd]'>$rowAssembly[assemblyname]</option>\n";
		}
	}
	$rsAssembly=null;
	$num_rows=0;
	$rowAssembly=null;
	echo "</select>";
}

if($opn=='app_replacement')
{
	$per_cd=$_GET['p_id'];
	$usercd=$_GET['usercd'];
	include_once('function/appointment_fun.php');

	delete_temp_app_letter($usercd);
	$count=0;
	include_once('inc/commit_con.php');
	mysqli_autocommit($link,FALSE);
	$sql="insert into tmp_app_let (per_code,usercode) values (?,?)";
	$stmt = mysqli_prepare($link, $sql);
	mysqli_stmt_bind_param($stmt, 'si', $per_cd,$usercd);
	mysqli_stmt_execute($stmt);

	if (!mysqli_commit($link)) {
		print("Transaction commit failed\n");
		exit();
	}
	mysqli_stmt_close($stmt);
	mysqli_close($link);
//	if($count<($i-1))
	{
		echo "reports/training-app-letter.php";
	}
}
?>