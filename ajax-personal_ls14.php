<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');
include_once('function/pagination.php');
//====================================================
$pr_cd=isset($_GET['pr_cd'])?decode($_GET['pr_cd']):"";
$act=isset($_GET['act'])?$_GET['act']:"";
if($pr_cd!='' && $act=='del')
{
	$total=personnela_del_check($pr_cd);
	if($total=="0")
	{
	    $f_cd='0';
	    $rt=update_personnelafttransf($pr_cd,$f_cd);
		$ret=delete_personnela($pr_cd);
		if($ret==1)
		{
			echo "<span class='alert-success'>Record deleted successfully</span><br />\n";
		}
	}
	else
	{
		echo "<span class='error'>Record already used</span><br />\n";
	}
}
//========================================================================
//global $subdiv; global $post_status; global $officeid; global $frmdt; global $todt; //global $usercode;
$subdiv=isset($_GET["subdiv"])?$_GET["subdiv"]:"";
$post_status=isset($_GET["post_status"])?$_GET["post_status"]:"";
$officeid=isset($_GET["officeid"])?$_GET["officeid"]:"";
$frmdt=isset($_GET["frmdt"])?$_GET["frmdt"]:"";
$todt=isset($_GET["todt"])?$_GET["todt"]:"";
$usercode=isset($_SESSION)?$_SESSION['user_cd']:"";

$rsPersonnel_ls14_dum=fatch_Personnel_ls14List($subdiv,$post_status,$officeid,$frmdt,$todt,$usercode);
$num_rows_dum = rowCount($rsPersonnel_ls14_dum);

$items = 50; // number of items per page.
$all = isset($_GET['a'])?$_GET['a']:"";
if($all == "all")
{
	$items = $num_rows_dum;
}
$nrpage_amount = $num_rows_dum/$items;
$page_amount = ceil($num_rows_dum/$items);
$page_amount = $page_amount-1;
$page = isset($_GET['p'])?$_GET['p']:"";
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
			<th>Edit</th>
            <th>Delete</th></tr>\n";
	for($i=1;$i<=$num_rows;$i++)
	{
	  $rowPersonnel_ls14=getRows($rsPersonnel_ls14);
	  $p_cd='"'.encode($rowPersonnel_ls14[0]).'"';
	  echo "<tr><td align='right' width='3%'>$i.</td><td align='center' width='10%'>$rowPersonnel_ls14[0]</td><td width='24%' align='left'>$rowPersonnel_ls14[1]</td>";
	  echo "<td width='44%' align='left'>$rowPersonnel_ls14[2],$rowPersonnel_ls14[3]</td><td width='15%' align='left'>$rowPersonnel_ls14[4]</td>";
	  echo "<td align='center' width='4%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_personnela($p_cd);' /></td>";
	  echo "<td align='center' width='4%'><img src='images/delete.png' alt='' height='20px' ";
	  if($rowPersonnel_ls14['usercode']==$usercode)
	  	echo " onclick='javascript:delete_person($p_cd);'";
	  else
	  	echo " onclick='alert(\"You do not have sufficient privilege to do the operation\");'";
	  echo " /></td></tr>\n";
	 
	}
	echo "</table>\n";
	paging();
}

?>