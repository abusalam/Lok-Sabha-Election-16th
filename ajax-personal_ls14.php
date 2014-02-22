<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');
include_once('function/pagination.php');
//====================================================
$pr_cd=decode($_GET['pr_cd']);
$act=$_GET['act'];
if($pr_cd!='' && $act=='del')
{
	    $f_cd=' ';
	    $rt=update_personnelafttransf($pr_cd,$f_cd);
		$ret=delete_personnela($pr_cd);
		if($ret==1)
		{
			echo "<script>location.replace('list-personnel_ls14.php');</script>";		
		}
}
//========================================================================
global $subdiv; global $post_status; global $officeid; global $frmdt; global $todt; global $usercode;
$subdiv=$_GET["subdiv"];
$post_status=$_GET["post_status"];
$officeid=$_GET["officeid"];
$frmdt=$_GET["frmdt"];
$todt=$_GET["todt"];
$usercode=$_SESSION['user_cd'];

$rsPersonnel_ls14_dum=fatch_Personnel_ls14List($subdiv,$post_status,$officeid,$frmdt,$todt,$usercode);
$num_rows_dum = rowCount($rsPersonnel_ls14_dum);

$items = 50; // number of items per page.
$all = $_GET['a'];
if($all == "all")
{
	$items = $num_rows_dum;
}
$nrpage_amount = $num_rows_dum/$items;
$page_amount = ceil($num_rows_dum/$items);
$page_amount = $page_amount-1;
$page = $_GET['p'];
$section='list-personnel_ls14';
if($page < "1")
{
	$page = "0";
}
$p_num = $items*$page;

$rsPersonnel_ls14 = fatch_Personnel_ls14List1($subdiv,$post_status,$officeid,$frmdt,$todt,$usercode,$p_num ,$items);
$num_rows = rowCount($rsPersonnel_ls14);
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
            <th>Present Address</th>
            <th>Posting Status</th>
            <th>Delete</th></tr>\n";
	for($i=1;$i<=$num_rows;$i++)
	{
	  $rowPersonnel_ls14=getRows($rsPersonnel_ls14);
	  $p_cd='"'.encode($rowPersonnel_ls14[0]).'"';
	  echo "<tr><td align='right' width='3%'>$i.</td><td align='center' width='10%'>$rowPersonnel_ls14[0]</td><td width='24%' align='left'>$rowPersonnel_ls14[1]</td>";
	  echo "<td width='44%' align='left'>$rowPersonnel_ls14[2],$rowPersonnel_ls14[3]</td><td width='15%' align='left'>$rowPersonnel_ls14[4]</td>";
	  echo "<td align='center' width='4%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_person($p_cd);' /></td></tr>\n";
	 
	}
	echo "</table>\n";
	paging();
}

?>