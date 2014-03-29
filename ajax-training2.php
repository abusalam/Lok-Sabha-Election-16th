<?php
if(!isset($_SESSION))
{
	session_start();
}
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/training2_fun.php');
$opn=isset($_GET['opn'])?$_GET['opn']:"";
if($opn=='tal')
{
	include_once('function/pagination.php');
	global $subdivision; global $venuename; global $usercode;
	$sub_div=isset($_GET["sub_div"])?$_GET["sub_div"]:"";
	$training_venue=isset($_GET["training_venue"])?$_GET["training_venue"]:"";
	$PC=isset($_GET["PC"])?$_GET["PC"]:"";
	$assembly=isset($_GET["assembly"])?$_GET["assembly"]:"";
	
	$usercode=isset($_SESSION)?$_SESSION['user_cd']:"";
	$delcode=isset($_GET["delcode"])?$_GET["delcode"]:"";
	if($delcode!="" && $delcode!=NULL)
	{
//		$total=chk_trainingvenue(decode($delcode));
//		if($total=="0")
//		{
			$aa=delete_training2_allocation(decode($delcode));
			if($aa>0)
				echo "<span class='alert-success'>Record deleted successfully</span><br /><br />\n";
//		}
//		else
//		{
//			echo "<span class='error'>Record already used</span><br />\n";
//		}
	}
	
	$rstraining_allocation_list_T=fatch_training2_allocation_list($sub_div,$training_venue,$PC,$assembly);
	$num_rows_T = rowCount($rstraining_allocation_list_T);
	
	$items = 50; // number of items per page.
	$all = $_GET['a'];
	if($all == "all")
	{
		$items = $num_rows_T;
	}
	$nrpage_amount = $num_rows_T/$items;
	$page_amount = ceil($num_rows_T/$items);
	$page_amount = $page_amount-1;
	$page = $_GET['p'];
	$section='training-allocation-list';
	if($page < "1")
	{
		$page = "0";
	}
	$p_num = $items*$page;
	
	$rstraining_alloc_list=fatch_training2_allocation_listAct($sub_div,$training_venue,$PC,$assembly,$p_num,$items);
	$num_rows = rowCount($rstraining_alloc_list);
	if($num_rows<1)
	{
		echo "No record found";
		//echo $officeid.",".$officename.",".$frmdt.",".$todt.",".$usercode;
	}
	else
	{
		echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
		echo "<tr height='30px'><th>Sl.</th><th>Assembly</th>
				<th>Training Venue</th>
				<th>Party/ Reserve</th>
				<th>Sl. Range</th>
				<th>Date</th>
				<th>Time</th>
				<th>Delete</th></tr>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
		  $rowTraining_alloc_list=getRows($rstraining_alloc_list);
		  $schedule_code='"'.encode($rowTraining_alloc_list['schedule_cd']).'"';
		  echo "<tr><td align='right' width='4%'>$i.</td><td align='left' width='15%'>$rowTraining_alloc_list[assemblyname]</td><td align='left' width='30%'>$rowTraining_alloc_list[venuename]</td><td width='15%' align='center'>$rowTraining_alloc_list[party_reserve]</td>";
		  echo "<td width='10%' align='left'>$rowTraining_alloc_list[start_sl]-$rowTraining_alloc_list[end_sl]</td><td width='10%' align='left'>$rowTraining_alloc_list[training_dt]</td><td width='12%' align='left'>$rowTraining_alloc_list[training_time]</td>";
		  echo "<td align='center' width='5%'><img src='images/delete.png' alt='' height='20px'";
		  if($rowTraining_alloc_list['usercode']==$usercode)
		  	echo " onclick='javascript:delete_training2_allocation($schedule_code);' ";
		  else
	  		echo " onclick='alert(\"You do not have sufficient privilege to do the operation\");'";
		  echo " /></td></tr>\n";
		  $rowTraining_alloc_list=NULL;
		}
		echo "</table>\n";
		paging();
	}
	unset($rstraining_alloc_list,$num_rows,$rowTraining_alloc_list);
}
?>