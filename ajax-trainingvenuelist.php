<?php
session_start();
extract($_GET);
include_once('inc\db_trans.inc.php');
include_once('function\training_fun.php');
include_once('function\pagination.php');
//====================================================

global $subdivision; global $venuename; global $usercode;
$subdivision=$_GET["subdivision"];
$venuename=$_GET["venuename"];
$usercode=$_SESSION['user_cd'];
$delcode=$_GET["delcode"];
if($delcode!="" && $delcode!=null)
{
	$total=chk_trainingvenue(decode($delcode));
	if($total=="0")
	{
		$aa=delete_trainingvenue(decode($delcode));
		if($aa==1)
			echo "<span class='alert-success'>Record deleted successfully</span><br />\n";
	}
	else
	{
		echo "<span class='error'>Record already used</span><br />\n";
	}
}
$rstrainingvenue_list_T=fatch_trainingvenue_list($subdivision,$venuename,$usercode);
$num_rows_T = rowCount($rstrainingvenue_list_T);

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
$section='training_venue_list';
if($page < "1")
{
	$page = "0";
}
$p_num = $items*$page;

$rstrainingvenue_list = fatch_trainingvenue_listAct($subdivision,$venuename,$usercode,$p_num ,$items);
$num_rows = rowCount($rstrainingvenue_list);
if($num_rows<1)
{
	echo "no record found";
	//echo $officeid.",".$officename.",".$frmdt.",".$todt.",".$usercode;
}
else
{
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
	echo "<tr height='30px'><th>Sl.</th><th>Sub Division</th>
            <th>Venue Name</th>
            <th>Venue Address</th>
            <th>Maximum Capacity</th>
			<th>Edit</th>
            <th>Delete</th></tr>\n";
	for($i=1;$i<=$num_rows;$i++)
	{
	  $rowtrainingvenue_list=getRows($rstrainingvenue_list);
	  $venue_cd='"'.encode($rowtrainingvenue_list[0]).'"';
	  echo "<tr><td align='right' width='3%'>$i.</td><td align='center' width='10%'>$rowtrainingvenue_list[1]</td><td width='24%' align='left'>$rowtrainingvenue_list[2]</td>";
	  echo "<td width='44%' align='left'>$rowtrainingvenue_list[3],$rowtrainingvenue_list[4]</td><td width='15%' align='left'>$rowtrainingvenue_list[5]</td>";
	  echo "<td align='center' width='4%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_trainingvenue($venue_cd);' /></td>";
	  echo "<td align='center' width='4%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_trainingvenue($venue_cd);' /></td></tr>\n";
	 
	}
	echo "</table>\n";
	paging();
}

?>