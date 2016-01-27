<?php
session_start();
extract($_GET);
date_default_timezone_set('Asia/Calcutta');
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');
//=================================Replacement====================================
//==========================Get Personnel Names===========================
$ass; $polling_party; $post_stat;
$ass=isset($_GET["ass"])?$_GET["ass"]:"";
$polling_party=isset($_GET["polling_party"])?$_GET["polling_party"]:"";
$post_stat=isset($_GET["post_stat"])?$_GET["post_stat"]:"";
$opn=isset($_GET["opn"])?$_GET["opn"]:"";
if($ass!='' && $polling_party!='' && $post_stat!='')
{
	$rs_person_name; $row_person_name;
	$rs_person_name=fatch_Personnel_list($ass,$polling_party,$post_stat);
	$num_rows_pn=rowCount($rs_person_name);
	if($num_rows_pn<1)
	{
		echo "<select name='newp_id' id='newp_id' style='width:150px'></select>";
	}
	else
	{
		echo "<select name='newp_id' id='newp_id' onchange='fatch_new_personnel_dtl(this.value);' style='width:150px'>\n";
		echo "<option value='0'>-Select Personnel ID-</option>\n";
		for($i=1;$i<=$num_rows_pn;$i++)
		{
		  $row_person_name=getRows($rs_person_name);
		  echo "<option value='$row_person_name[0]'>$row_person_name[0]</option>\n";
		  $row_person_name=NULL;
		}
		echo "</select>\n";
		
		unset($rs_person_name,$num_rows_pn,$row_person_name);
	}
}
else if($ass!='' && $polling_party=='' && $post_stat!='')
{
	echo "<select name='newp_id' id='newp_id' style='width:150px'></select>";
}
/****************************************get pp details*************************************/
$p_id=isset($_GET["p_id"])?$_GET["p_id"]:"";
$p_dtl=isset($_GET["p_dtl"])?$_GET["p_dtl"]:"";
if($p_id != '')
{
	
	$rs_person; $row_person;
	$rs_person=fatch_PersonDetails($p_id);
	$num_row=rowCount($rs_person);
	$row_person=getRows($rs_person);
	if(rowCount($rs_person)<1)
	{
		echo " ";
		$rs_person=null; $row_person=null;
		exit();
	}
	if($p_dtl=='y')
	{
		if($row_person['booked']=='C' || $row_person['booked']=='')
		{
			echo "Not Available for Selected Operation";
		}
		else
		{
			
		echo "<table>\n";
		echo "<tr><td align='left'>Name: </td><td align='left' colspan='3'>".$row_person['officer_name']."</td></tr>\n";
		echo "<tr><td align='left'>Designation: </td><td align='left' colspan='3'>".$row_person['off_desg']."</td></tr>\n";
		echo "<tr><td align='left'>Office Address: </td><td align='left' colspan='3'>".$row_person['address1'].",".$row_person['address2'].", PO-".$row_person['postoffice'].", PS-".$row_person['policestation'].", Subdiv-".$row_person['subdivision'].", Dist.-".$_SESSION['dist_name'].",".$row_person['pin']."</td></tr>\n";
		echo "<tr><td align='left'>Date of Birth: </td><td align='left'>".$row_person['dateofbirth']."</td><td align='left'>Sex: </td><td align='left'>".$row_person['gender']."<hidden id='hid_gender' name='hid_gender' style='display:none;'>".$row_person['gender']."</hidden></td></tr>\n";
		echo "<tr><td align='left'>EPIC No: </td><td align='left'>".$row_person['epic']."</td><td align='left'>Posting Status: </td><td align='left'>".$row_person['poststatus']."<hidden id='hid_post_stat' name='hid_post_stat' style='display:none;'>".$row_person['poststat']."</hidden></td></tr>\n";
		echo "<tr><td align='left'>Present Address: </td><td align='left' colspan='3'>".$row_person['present_addr1'].", ".$row_person['present_addr2']."</td></tr>\n";
		echo "<tr><td align='left' colspan='4'><b>Assembly of</b></td></tr>\n";
		echo "<tr><td align='left' colspan='2'>Present Address: </td><td align='left' colspan='2'>".$row_person['pre_ass']."<hidden id='hid_pre_ass' name='hid_pre_ass' style='display:none;'>".$row_person['pre_ass_cd']."</hidden></td></tr>\n";
		echo "<tr><td align='left' colspan='2'>Permanent Address: </td><td align='left' colspan='2'>".$row_person['per_ass']."<hidden id='hid_per_ass' name='hid_per_ass' style='display:none;'>".$row_person['per_ass_cd']."</hidden></td></tr>\n";
		echo "<tr><td align='left' colspan='2'>Place of Posting: </td><td align='left' colspan='2'>".$row_person['post_ass']."<hidden id='hid_post_ass' name='hid_post_ass' style='display:none;'>".$row_person['post_ass_cd']."</hidden></td></tr>\n";
		echo "<tr><td align='left' colspan='4'><hidden id='hid_forpc' name='hid_forpc' style='display:none;'>".$row_person['forpc']."</hidden>\n<hidden id='hid_forassembly' name='hid_forassembly' style='display:none;'>".$row_person['forassembly']."</hidden>\n<hidden id='hid_groupid' name='hid_groupid' style='display:none;'>".$row_person['groupid']."</hidden>\n<hidden id='hid_booked' name='hid_booked' style='display:none;'>".$row_person['booked']."</hidden>\n<hidden id='hid_per_cd' name='hid_per_cd' style='display:none;'>".$row_person['personcd']."</hidden>\n <hidden id='hid_for_subdiv' name='hid_for_subdiv' style='display:none;'>".$row_person['forsubdivision']."</hidden>\n <hidden id='hid_dcrccd' name='hid_dcrccd' style='display:none;'>".$row_person['dcrccd']."</hidden>\n <hidden id='hid_training2_sch' name='hid_training2_sch' style='display:none;'>".$row_person['training2_sch']."</hidden></td></tr>\n";
		echo "<tr><td align='right' colspan='2'>Booked : </td><td colspan='2' align='left' id='o_booked'>Yes</td></tr>\n";
		echo "</table>";
		}
	}
	else
	{
		echo $row_person['officecd'];
	}
	
}
else
	echo " ";
//==============================Replace===============================
//$old_p_id; $new_p_id; $ass; $forpc; $groupid; $usercd;
$old_p_id=isset($_GET["old_p_id"])?$_GET["old_p_id"]:"";
$new_p_id=isset($_GET["new_p_id"])?$_GET["new_p_id"]:"";
$ass=isset($_GET["ass"])?$_GET["ass"]:"";
$post_stat=isset($_GET["post_stat"])?$_GET["post_stat"]:"";
$groupid=isset($_GET["groupid"])?$_GET["groupid"]:"";
$post_stat_new=isset($_GET["post_stat_new"])?$_GET["post_stat_new"]:"";
$usercd=isset($_SESSION)?$_SESSION['user_cd']:"";
if($opn=='g_rplc')
{
	if($old_p_id!='' && $new_p_id!='' && $ass!='' && $groupid!='' && $post_stat !='' && $post_stat_new!='')
	{
		
	   $ret=update_post_status_replacement_in_group($old_p_id,$post_stat_new);
	   if($ret==1)
	   {
	      $res=update_post_status_replacement_in_group($new_p_id,$post_stat);
		  if($res==1)
		  {
			  echo "1";
		  }
	   }
		//echo "Changed";
	}
}
?>