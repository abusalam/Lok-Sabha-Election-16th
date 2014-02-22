<?php
session_start();
extract($_GET);
include_once('inc\db_trans.inc.php');
include_once('function\add_fun.php');
include_once('function\pagination.php');
//====================================================
$pr_cd=decode($_GET['pr_cd']);
$act=$_GET['act'];
if($pr_cd!='' && $act=='del')
{
	    $f_cd=' ';
	    $rt=update_personnelafttransf($pr_cd,$f_cd);
		$ret=delete_personnel_ls14($pr_cd);
		if($ret==1)
		{
			echo "<script>location.replace('list-termination.php');</script>";		
		}
}
//========================================================================
global $personalid; global $frmdt; global $todt; global $usercode;
$personalid=$_GET["personalid"];
$frmdt=$_GET["frmdt"];
$todt=$_GET["todt"];
$usercode=$_SESSION['user_cd'];
$delcode=$_GET["delcode"];
if($delcode!="" && $delcode!=null)
{
//	$total=ofc_del_check(decode($delcode));
//	if($total=="0")
//	{
		$aa=delete_Termination(decode($delcode));
		if($aa==1)
			echo "<span class='alert-success'>Record deleted successfully</span><br />\n";
//	}
//	else
//	{
//		echo "<span class='error'>Record already used</span><br />\n";
//	}
}
$rsTermination_list_T=fatch_termination_list($personalid,$frmdt,$todt,$usercode);
$num_rows_T = rowCount($rsTermination_list_T);

$items = 30; // number of items per page.
$all = $_GET['a'];
if($all == "all")
{
	$items = $num_rows_T;
}
$nrpage_amount = $num_rows_T/$items;
$page_amount = ceil($num_rows_T/$items);
$page_amount = $page_amount-1;
$page = $_GET['p'];
$section='list-termination';
if($page < "1")
{
	$page = "0";
}
$p_num = $items*$page;

$rsTermination_list = fatch_termination_listAct($personalid,$frmdt,$todt,$usercode,$p_num ,$items);
$num_rows = rowCount($rsTermination_list);
if($num_rows<1)
{
	echo "No record found";
	//echo $officeid.",".$officename.",".$frmdt.",".$todt.",".$usercode;
}
else
{
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
	echo "<tr height='30px'><th>Sl.</th><th>Personnel ID</th>
            <th>Personnel Name</th>
            <th>Cause of Termination</th>
            <th>Date of Termination</th>
			<th>Edit</th>
            <th>Delete</th></tr>\n";
	for($i=1;$i<=$num_rows;$i++)
	{
	  $rowTermination_list=getRows($rsTermination_list);
	  $ter_id='"'.encode($rowTermination_list[0]).'"';
	  echo "<tr><td align='right' width='3%'>$i.</td><td align='center' width='10%'>$rowTermination_list[1]</td><td width='24%' align='left'>$rowTermination_list[2]</td>";
	  echo "<td width='44%' align='left'>$rowTermination_list[3]</td><td width='15%' align='left'>$rowTermination_list[4]</td>";
	  echo "<td align='center' width='4%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_termination($ter_id);' /></td>";
	  echo "<td align='center' width='4%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_termination($ter_id);' /></td></tr>\n";
	 
	}
	echo "</table>\n";
	paging();
}

?>