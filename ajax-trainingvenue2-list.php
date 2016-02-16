<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/training2_fun.php');
include_once('function/pagination.php');
//====================================================

global $subdivision; global $venuename; global $usercode;

$usercode=isset($_SESSION)?$_SESSION['user_cd']:"";
$delcode=isset($_GET["delcode"])?$_GET["delcode"]:"";
$search=isset($_GET["search"])?$_GET["search"]:"";
//echo $delcode;
	//exit;
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
$subdivision=isset($_GET["subdivision"])?$_GET["subdivision"]:"";
$venuename=isset($_GET["venuename"])?$_GET["venuename"]:"";
$dist=isset($_GET["dist"])?$_GET["dist"]:"";

if($search=="search")
{
	$_SESSION['sub_p']=$subdivision;
	$_SESSION['sub_venue']=$venuename;
	$_SESSION['dist_trn2']=$dist;
}
else
{
	$subdivision=isset($_SESSION['sub_p'])?$_SESSION['sub_p']:'';
	$venuename=isset($_SESSION['sub_venue'])?$_SESSION['sub_venue']:'';
	$dist=isset($_SESSION['dist_trn2'])?$_SESSION['dist_trn2']:'';
}

$rstrainingvenue_list_T=fatch_trainingvenue_list($subdivision,$venuename,$usercode,$dist);
$num_rows_T = rowCount($rstrainingvenue_list_T);

$items = 100; // number of items per page.
$all = isset($_GET['a'])?$_GET['a']:"";
if($all == "all")
{
	$items = $num_rows_T;
}
$nrpage_amount = $num_rows_T/$items;
$page_amount = ceil($num_rows_T/$items);
$page_amount = $page_amount-1;
$page = isset($_GET['p'])?$_GET['p']:"";
$section='training_venue2_list';
if($page < "1")
{
	$page = "0";
}
$p_num = $items*$page;

$rstrainingvenue_list = fatch_trainingvenue_listAct($subdivision,$venuename,$usercode,$p_num ,$items,$dist);
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
			<th>Edit</th>
            <th>Delete</th></tr>\n";
	for($i=1;$i<=$num_rows;$i++)
	{
	  $rowtrainingvenue_list=getRows($rstrainingvenue_list);
	  $venue_cd='"'.encode($rowtrainingvenue_list[0]).'"';
	  $count=$p_num+$i;
	  echo "<tr><td align='left' width='4%'>$count.</td><td align='left' width='13%'>$rowtrainingvenue_list[subdivision]</td><td width='30%' align='left'>$rowtrainingvenue_list[venuename]</td>";
	  echo "<td width='45%' align='left'>$rowtrainingvenue_list[venueaddress1],$rowtrainingvenue_list[venueaddress2]</td>";
	  echo "<td align='center' width='4%'><img src='images/edit.png' alt='' height='20px' ";
	 // if($rowtrainingvenue_list['usercode']==$usercode)
	  	echo "onclick='javascript:edit_trainingvenue($venue_cd);'";
	//  else
	//  	echo " onclick='alert(\"You do not have sufficient privilege to do the operation\");'";
	  echo " /></td>";
	  echo "<td align='center' width='4%'><img src='images/delete.png' alt='' height='20px' ";
	//  if($rowtrainingvenue_list['usercode']==$usercode)
	  	echo "onclick='javascript:delete_trainingvenue($venue_cd);'";
//	  else
	//  	echo " onclick='alert(\"You do not have sufficient privilege to do the operation\");'";
	  echo " /></td></tr>\n";
	 
	}
	echo "</table>\n";
	paging();
}

?>