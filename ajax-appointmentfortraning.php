<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');
include_once('function/pagination.php');
//====================================================

//========================================================================
$subdiv=$_GET["subdiv"];
$officeid=$_GET["officeid"];
$usercode=$_SESSION['user_cd'];

$rsPersonnel_ls14_dum=fatch_Personnel_ls14Listeee($subdiv,$officeid,$usercode);
$num_rows_dum = rowCount($rsPersonnel_ls14_dum);

$items = 30; // number of items per page.
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

$rsPersonnel_ls14 = fatch_Personnel_ls14List1we($subdiv,$officeid,$usercode,$p_num ,$items);
$num_rows = rowCount($rsPersonnel_ls14);
if($num_rows<1)
{
	echo "no record found";
	//echo $officeid.",".$officename.",".$frmdt.",".$todt.",".$usercode;
}
else
{
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
	echo "<tr height='30px'><th>Sl.</th><th>Personnel ID</th>
            <th>Personnel Name</th>
            <th>Present Address</th>
            <th>Posting Status</th>
            <th>Select</th></tr>\n";
	for($i=1;$i<=$num_rows;$i++)
	{
	  $rowPersonnel_ls14=getRows($rsPersonnel_ls14);
	  $p_cd='"'.encode($rowPersonnel_ls14[0]).'"';
	  echo "<tr><td align='right' width='3%'>$i.</td><td align='center' width='10%'>$rowPersonnel_ls14[0]</td><td width='24%' align='left'>$rowPersonnel_ls14[1]</td>";
	  echo "<td width='44%' align='left'>$rowPersonnel_ls14[2],$rowPersonnel_ls14[3]</td><td width='15%' align='left'>$rowPersonnel_ls14[4]</td>";
	  echo "<td align='center' width='4%'><input name='checkbox[$i]' type='checkbox' id='checkbox[$i]' value='$p_cd'></td></tr>\n";
	 
	}
	echo "</table>\n";
	paging();
}

?>