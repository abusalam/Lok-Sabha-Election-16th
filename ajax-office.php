<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');
include_once('function/pagination.php');
$officeid=$_GET["officeid"];
$officename=$_GET["officename"];
$sub_div=$_GET["sub_div"];
$frmdt=$_GET["frmdt"];
$todt=$_GET["todt"];
$usercode=$_SESSION['user_cd'];
$delcode=$_GET["delcode"];
if($delcode!="" && $delcode!=null)
{
	$total=ofc_del_check(decode($delcode));
	if($total=="0")
	{
		$aa=delete_office(decode($delcode));
		if($aa==1)
			echo "<span class='alert-success'>Record deleted successfully</span><br />\n";
	}
	else
	{
		echo "<span class='error'>Record already used</span><br />\n";
	}
}



$rsOffice_dum=fatch_OfficeList($sub_div,$officeid,$officename,$frmdt,$todt,$usercode);
$num_rows_dum = rowCount($rsOffice_dum);

$items = 50; // number of items per page.
$all = $_GET['a'];
if($all == "all")
{
	$items = $num_rows_dum;
}
$items=($items==0?1:$items);
$nrpage_amount = $num_rows_dum/$items;
$page_amount = ceil($num_rows_dum/$items);
$page_amount = $page_amount-1;
$page = $_GET['p'];
$section='list-office-details';
if($page < "1")
{
	$page = "0";
}
$p_num = $items*$page;

$rsOffice = fatch_OfficeList1($sub_div,$officeid,$officename,$frmdt,$todt,$usercode,$p_num ,$items);
$num_rows = rowCount($rsOffice);
if($num_rows<1)
{
	echo "No record found";
	//echo $officeid.",".$officename.",".$frmdt.",".$todt.",".$usercode;
}
else
{
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
	echo "<tr height='30px'><th>Sl.</th><th>Office ID</th>
            <th>Office Name</th>
            <th>Office Address</th>
            <th>Nature of Office</th>
            <th>Edit</th>
			<th>Delete</th></tr>\n";
	for($i=1;$i<=$num_rows;$i++)
	{
	  $rowOffice=getRows($rsOffice);
	  $ofc_cd='"'.encode($rowOffice[0]).'"';
	  echo "<tr><td align='right' width='3%'>$i.</td><td align='center' width='8%'>$rowOffice[0]</td><td width='28%' align='left'>$rowOffice[1]</td>";
	  echo "<td width='38%' align='left'>$rowOffice[2],$rowOffice[3], PO-$rowOffice[4], Pin-$rowOffice[5]</td><td width='15%' align='left'>$rowOffice[6]</td>";
	  echo "<td align='center' width='4%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_office($ofc_cd);' title='Click to edit' /></td>\n";
	  echo "<td align='center' width='4%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_office($ofc_cd);' title='Click to delete' /></td></tr>\n";
	}
	echo "</table>\n";
	paging();
}
?>