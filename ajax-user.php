<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');
include_once('function/user_fun.php');
include_once('function/pagination.php');
$opn=isset($_GET["opn"])?$_GET["opn"]:"";
$dist=isset($_GET["dist"])?$_GET["dist"]:"";
$userid=isset($_GET["userid"])?$_GET["userid"]:"";
$category=isset($_GET["category"])?$_GET["category"]:"";
$delcode=isset($_GET["delcode"])?$_GET["delcode"]:"";

if($opn=="subdiv")
{
	$dist=$_GET["dist"];
	$rsSubdiv=fatch_Subdivision($dist);
	$num_rows=rowCount($rsSubdiv);
	echo "<select name='subdiv' id='subdiv' style='width:200px;' onchange='return subdiv_change(this.value);'>";
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Subdivision-</option>";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowSubdiv=getRows($rsSubdiv);
			echo "<option value='$rowSubdiv[0]'>$rowSubdiv[2]</option>";
		}
	}
	echo "</select>";
	unset($rsSubdiv,$$num_rows,$rowSubdiv);
}
if($opn=="pc")
{
	$subdiv=$_GET["subdiv"];
	$rsPC=fatch_pc($subdiv);
	$num_rows=rowCount($rsPC);
	echo "<select name='parliament' id='parliament' style='width:200px;'>";
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Parliament-</option>";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowPC=getRows($rsPC);
			echo "<option value='$rowPC[0]'>$rowPC[1]</option>";
		}
	}
	echo "</select>";
	unset($rsPC,$$num_rows,$rowPC);
}
if($opn=="listuser")
{
	$rsUser_dum=fatch_UserList($dist,$userid,$category);
	$num_rows_dum = rowCount($rsUser_dum);
	
	$items = 5; // number of items per page.
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
	$section='list-users';
	if($page < "1")
	{
		$page = "0";
	}
	$p_num = $items*$page;
	
	$rsUser = fatch_UserList1($dist,$userid,$category,$p_num ,$items);
	$num_rows = rowCount($rsUser);
	if($num_rows<1)
	{
		echo "No record found";
		//echo $officeid.",".$officename.",".$frmdt.",".$todt.",".$usercode;
	}
	else
	{
		echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
		echo "<tr height='30px'><th>Sl.</th><th>User ID</th>
				<th>Category</th>
				<th>District</th>
				<th>Subdivision</th>
				<th>Parliament</th>
				<th>Creation Date</th>
				<th>Edit</th>
				<th>Delete</th></tr>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
		  $rowUser=getRows($rsUser);
		  $user_cd='"'.encode($rowUser[0]).'"';
		  echo "<tr><td align='right' width='3%'>$i.</td><td align='center' width='8%'>$rowUser[1]</td><td width='10%' align='left'>$rowUser[2]</td>";
		  echo "<td width='15%' align='left'>$rowUser[5]</td><td width='15%' align='left'>$rowUser[7]</td><td width='15%' align='left'>$rowUser[9]</td>";
		  echo "<td width='15%' align='left'>$rowUser[3]</td>";
		  echo "<td align='center' width='5%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_user($user_cd);' title='Click to edit' /></td>\n";
		  echo "<td align='center' width='5%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_user($user_cd);' title='Click to delete' /></td></tr>\n";
		}
		echo "</table>\n";
		paging();
	}
}
?>