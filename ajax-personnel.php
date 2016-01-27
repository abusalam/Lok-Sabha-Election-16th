<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');
include_once('function/pagination.php');
$search=isset($_GET["search"])?$_GET["search"]:"";
$officeid=isset($_GET["officeid"])?$_GET["officeid"]:"";
$personcd=isset($_GET["personcd"])?$_GET["personcd"]:"";
$frmdt=isset($_GET["frmdt"])?$_GET["frmdt"]:"";
$todt=isset($_GET["todt"])?$_GET["todt"]:"";
$usercode=$_SESSION['user_cd'];
$subdiv_cd=$_SESSION['subdiv_cd'];
if($search=="search")
{
	$_SESSION['officeid_p']=$officeid;
	$_SESSION['personcd_p']=$personcd;
	$_SESSION['frmdt']=$frmdt;
	$_SESSION['todt']=$todt;
}
else
{
	$officeid=isset($_SESSION['officeid_p'])?$_SESSION['officeid_p']:'';
	$personcd=isset($_SESSION['personcd_p'])?$_SESSION['personcd_p']:'';
	$frmdt=isset($_SESSION['frmdt'])?$_SESSION['frmdt']:'';
	$todt=isset($_SESSION['todt'])?$_SESSION['todt']:'';
}
$rsPersonnel_dum=fatch_PersonnelList($officeid,$personcd,$frmdt,$todt,$subdiv_cd);
$num_rows_dum = rowCount($rsPersonnel_dum);

$items = 100; // number of items per page.
$all = isset($_GET['a'])?$_GET['a']:"";
if($all == "all")
{
	$items = $num_rows_dum;
}
$items=($items==0?1:$items);
$nrpage_amount = $num_rows_dum/$items;
$page_amount = ceil($num_rows_dum/$items);
$page_amount = $page_amount-1;

$page = isset($_GET['p'])? $_GET['p']:"";
$section='list-personnel';
if($page < "1")
{
	$page = "0";
}
$p_num = $items*$page;

$rsPersonnel = fatch_PersonnelList1($officeid,$personcd,$frmdt,$todt,$subdiv_cd,$p_num ,$items);
$num_rows = rowCount($rsPersonnel);
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
            <th>Edit</th></tr>\n";
	//$count=0;		
	for($i=1;$i<=$num_rows;$i++)
	{
	  $rowPersonnel=getRows($rsPersonnel);
	  $p_cd='"'.encode($rowPersonnel[0]).'"';
	  $count=$p_num+$i;
	  
	  echo "<tr><td align='left' width='4%'>$count.</td><td align='center' width='10%'>$rowPersonnel[0]</td><td width='24%' align='left'>$rowPersonnel[1]</td>";
	  echo "<td width='43%' align='left'>$rowPersonnel[2],$rowPersonnel[3]</td><td width='15%' align='left'>$rowPersonnel[4]</td>";
	  echo "<td align='center' width='4%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_person($p_cd);' /></td></tr>\n";
	  
	}
	echo "</table>\n";
	paging();
}
?>