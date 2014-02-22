<?php
session_start();
extract($_GET);
include_once('inc\db_trans.inc.php');
include_once('function\add_fun.php');
//=================================Replacement====================================
//==========================Get Personnel Names===========================
$ass; $polling_party; $post_stat;
$ass=$_GET["ass"];
$polling_party=$_GET["polling_party"];
$post_stat=$_GET["post_stat"];
if($ass!='' && $polling_party!='' && $post_stat!='')
{
	$rs_person_name; $row_person_name;
	$rs_person_name=fatch_Personnel_list($ass,$polling_party,$post_stat);
	$num_rows_pn=rowCount($rs_person_name);
	if($num_rows_pn<1)
	{
		echo "<select name='p_id' id='p_id' style='width:150px'></select>";
	}
	else
	{
		echo "<select name='p_id' id='p_id' onchange='fatch_personnel_dtl(this.value);' style='width:150px'>\n";
		echo "<option value='0'>-Select Personnel ID-</option>\n";
		for($i=1;$i<=$num_rows_pn;$i++)
		{
		  $row_person_name=getRows($rs_person_name);
		  echo "<option value='$row_person_name[0]'>$row_person_name[0]</option>\n";
		}
		echo "</select>\n";
		$row_person_name=null;
		$rs_person_name=null;
		$num_rows_pn=0;
	}
}
else if($ass!='' && $polling_party=='' && $post_stat!='')
{
	echo "<select name='p_id' id='p_id' style='width:150px'></select>";
}

//==========================Get Old Personnel Details=============================
$p_id; $p_dtl;
$p_id=$_GET["p_id"];
$p_dtl=$_GET["p_dtl"];
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
			echo "Not Available for replacement";
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
		echo "<tr><td align='left' colspan='4'><hidden id='hid_forpc' name='hid_forpc' style='display:none;'>".$row_person['forpc']."</hidden>\n<hidden id='hid_forassembly' name='hid_forassembly' style='display:none;'>".$row_person['forassembly']."</hidden>\n<hidden id='hid_groupid' name='hid_groupid' style='display:none;'>".$row_person['groupid']."</hidden>\n<hidden id='hid_booked' name='hid_booked' style='display:none;'>".$row_person['booked']."</hidden>\n<hidden id='hid_per_cd' name='hid_per_cd' style='display:none;'>".$row_person['personcd']."</hidden>\n <hidden id='hid_for_subdiv' name='hid_for_subdiv' style='display:none;'>".$row_person['forsubdivision']."</hidden></td></tr>\n";
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

//============================Get New Personnel Details=================================
$assembly; $forassembly; $forpc; $groupid;
$for_subdiv=$_GET["for_subdiv"];
$assembly=$_GET["assembly"];
$posting_status=$_GET["posting_status"];
$groupid=$_GET["groupid"];
$gender=$_GET["gender"];
if($assembly!='' && $posting_status!='' && $groupid!='' && gender!='')
{
	$rs_new_per; $row_new_per;
	$rs_new_per=fatch_Random_personnel_for_replacement($for_subdiv,$assembly,$posting_status,$groupid,$gender);
	//$random_rs_person=array_rand($rs_new_per);
	$num_rows_new_per=rowCount($rs_new_per);
	if($num_rows_new_per>0)
	{
		$row_new_per=getRows($rs_new_per);
		echo "<table>\n";
		echo "<tr><td align='center' colspan='4'><b>NEW PERSONNEL</b></td></tr>\n";
		echo "<tr><td align='left'><b>Personnel ID: </b></td><td align='left' id='new_per_id'>".$row_new_per['personcd']."</td><td align='left'><b>Office ID: </b></td><td>".$row_new_per['officecd']."</td></tr>\n";
		echo "<tr><td align='left'>Name: </td><td align='left' colspan='3'>".$row_new_per['officer_name']."</td></tr>\n";
		echo "<tr><td align='left'>Designation: </td><td align='left' colspan='3'>".$row_new_per['designation']."</td></tr>\n";
		echo "<tr><td align='left'>Office Address: </td><td align='left' colspan='3'>".$row_new_per['address1'].",".$row_new_per['address2'].", PO-".$row_new_per['postoffice'].", PS-".$row_new_per['policestation'].", Subdiv-".$row_new_per['subdivision'].", Dist.-".$row_new_per['district'].",".$row_new_per['pin']."</td></tr>\n";
		echo "<tr><td align='left'>Date of Birth: </td><td align='left'>".$row_new_per['dateofbirth']."</td><td align='left'>Sex: </td><td align='left'>".$row_new_per['gender']."</td></tr>\n";
		echo "<tr><td align='left'>EPIC No: </td><td align='left'>".$row_new_per['epic']."</td><td align='left'>Posting Status: </td><td align='left'>".$row_new_per['poststatus']."</td></tr>\n";
		echo "<tr><td align='left'>Present Address: </td><td align='left' colspan='3'>".$row_new_per['present_addr1'].", ".$row_new_per['present_addr2']."</td></tr>\n";
		echo "<tr><td align='left' colspan='4'><b>Assembly of</b></td></tr>\n";
		echo "<tr><td align='left' colspan='2'>Present Address: </td><td align='left' colspan='2'>".$row_new_per['pre_ass']."<hidden id='hid_pre_ass' name='hid_pre_ass' style='display:none;'>".$row_new_per['pre_ass']."</hidden></td></tr>\n";
		echo "<tr><td align='left' colspan='2'>Permanent Address: </td><td align='left' colspan='2'>".$row_new_per['per_ass']."<hidden id='hid_per_ass' name='hid_per_ass' style='display:none;'>".$row_new_per['per_ass']."</hidden></td></tr>\n";
		echo "<tr><td align='left' colspan='2'>Place of Posting: </td><td align='left' colspan='2'>".$row_new_per['post_ass']."<hidden id='hid_post_ass' name='hid_post_ass' style='display:none;'>".$row_new_per['post_ass']."</hidden></td></tr>\n";
		echo "<tr><td align='left' colspan='4'><hidden id='hid_forpc' name='hid_forpc' style='display:none;'>".$row_new_per['post_ass']."</hidden>\n<hidden id='hid_forassembly' name='hid_forassembly' style='display:none;'>".$row_new_per['post_ass']."</hidden>\n<hidden id='hid_groupid' name='hid_groupid' style='display:none;'>".$row_new_per['post_ass']."</hidden>\n<hidden id='hid_booked' name='hid_booked' style='display:none;'>".$row_new_per['post_ass']."</hidden></td></tr>\n";
		echo "<tr><td align='right' colspan='2'>Booked : </td><td colspan='2' align='left' id='n_booked'>No</td></tr>\n";
		echo "</table>";
	}
}
//==============================Replace===============================
$old_p_id; $new_p_id; $ass; $forpc; $groupid; $usercd;
$old_p_id=$_GET["old_p_id"];
$new_p_id=$_GET["new_p_id"];
$ass=$_GET["ass"];
$forpc=$_GET["forpc"];
$groupid=$_GET["groupid"];
$usercd=$_SESSION['user_cd'];
if($old_p_id!='' && $new_p_id!='' && $ass!='' && $forpc!='' && $groupid!='')
{
	$selected=1;
	$ret=update_personnel_replacement($new_p_id,$groupid,$ass,$forpc,'P',$selected);
	if($ret==1)
	{
		$selected=0;
		$res1=update_personnel_replacement($old_p_id,' ',$ass,$forpc,'C',$selected);
		if($res1==1)
		{
			echo "Changed";
		}
		$res2=add_employee_replacement_log($new_p_id,$old_p_id,$ass,$groupid,$usercd);
	}
}
//================================ Single Replacement Personnel =======================================
$opn=$_GET["opn"];
if($opn=='new_search')
{
	$forpc=$_GET["forpc"];
	$ofc_id=$_GET["ofc_id"];
	$post_stat=$_GET["post_stat"];

	if($forpc!='' && $ofc_id!='' && $gender!='')
	{
		$rsNew_Per; $rowNew_Per;
		$rsNew_Per=fatch_Random_personnel_for_PreGroupReplacement($forpc,$ofc_id,$gender,$post_stat);
		$num_rowsNew_Per=rowCount($rsNew_Per);
		if($num_rowsNew_Per>0)
		{
			$rowNew_Per=getRows($rsNew_Per);
			echo "<table>\n";
			echo "<tr><td align='center' colspan='4'><b>NEW PERSONNEL</b></td></tr>\n";
			echo "<tr><td align='left' width='22%'><b>Personnel ID: </b></td><td align='left' id='new_per_id'>".$rowNew_Per['personcd']."</td><td align='left'><b>Office ID: </b></td><td>".$rowNew_Per['officecd']."</td></tr>\n";
			echo "<tr><td align='left'>Name: </td><td align='left' colspan='3'>".$rowNew_Per['officer_name']."</td></tr>\n";
			echo "<tr><td align='left'>Designation: </td><td align='left' colspan='3'>".$rowNew_Per['off_desg']."</td></tr>\n";
			echo "<tr><td align='left'>Office Address: </td><td align='left' colspan='3'>".$rowNew_Per['address1'].",".$rowNew_Per['address2'].", PO-".$rowNew_Per['postoffice'].", PS-".$rowNew_Per['policestation'].", Subdiv-".$rowNew_Per['subdivision'].", Dist.-".$rowNew_Per['district'].",".$rowNew_Per['pin']."</td></tr>\n";
			echo "<tr><td align='left'>Date of Birth: </td><td align='left'>".$rowNew_Per['dateofbirth']."</td><td align='left'>Sex: </td><td align='left'>".$rowNew_Per['gender']."</td></tr>\n";
			echo "<tr><td align='left'>EPIC No: </td><td align='left'>".$rowNew_Per['epic']."</td><td align='left'>Posting Status: </td><td align='left'>".$rowNew_Per['poststatus']."</td></tr>\n";
			echo "<tr><td align='left'>Present Address: </td><td align='left' colspan='3'>".$rowNew_Per['present_addr1'].", ".$rowNew_Per['present_addr2']."</td></tr>\n";
			echo "<tr><td align='left' colspan='4'><b>Assembly of</b></td></tr>\n";
			echo "<tr><td align='left' colspan='2'>Present Address: </td><td align='left' colspan='2'>".$rowNew_Per['pre_ass']."<hidden id='hid_pre_ass' name='hid_pre_ass' style='display:none;'>".$rowNew_Per['pre_ass']."</hidden></td></tr>\n";
			echo "<tr><td align='left' colspan='2'>Permanent Address: </td><td align='left' colspan='2'>".$rowNew_Per['per_ass']."<hidden id='hid_per_ass' name='hid_per_ass' style='display:none;'>".$rowNew_Per['per_ass']."</hidden></td></tr>\n";
			echo "<tr><td align='left' colspan='2'>Place of Posting: </td><td align='left' colspan='2'>".$rowNew_Per['post_ass']."<hidden id='hid_post_ass' name='hid_post_ass' style='display:none;'>".$rowNew_Per['post_ass']."</hidden></td></tr>\n";
			echo "<tr><td align='left' colspan='4'><hidden id='hid_forpc' name='hid_forpc' style='display:none;'>".$rowNew_Per['post_ass']."</hidden>\n<hidden id='hid_forassembly' name='hid_forassembly' style='display:none;'>".$rowNew_Per['post_ass']."</hidden>\n<hidden id='hid_groupid' name='hid_groupid' style='display:none;'>".$rowNew_Per['post_ass']."</hidden>\n<hidden id='hid_booked' name='hid_booked' style='display:none;'>".$rowNew_Per['post_ass']."</hidden></td></tr>\n";
			echo "<tr><td align='right' colspan='2'>Booked : </td><td colspan='2' align='left' id='n_booked'>No</td></tr>\n";
			echo "</table>";
		}
		else
			echo "";
	}
	else
		echo "";
}

if($opn=='pg_rplc')
{
	$old_p_id=''; $new_p_id=''; $forassembly=''; $forpc=''; $usercd=0;
	
	$old_p_id=$_GET["old_p_id"];
	$new_p_id=$_GET["new_p_id"];
	$forassembly=$_GET["forassembly"];
	$forpc=$_GET["forpc"];
	$usercd=$_SESSION['user_cd'];
	
	if($old_p_id!='' && $new_p_id!='' && $forassembly!='' && $forpc!='')
	{
		//echo $old_p_id.' '.$new_p_id.' '.$forassembly.' '.$forpc;
		$selected=1;
		$ret=update_personnel_PreGroupReplacement($new_p_id,$forassembly,$forpc,'P',$selected);
		if($ret==1)
		{
		$selected=0;
			$res1=update_personnel_PreGroupReplacement($old_p_id,$forassembly,'','C',$selected);
			if($res1==1)
			{
				echo "Changed";
			}
			$res2=add_employee_PreGroupReplacement_log($new_p_id,$old_p_id,$forassembly,$forpc,$usercd);
		}
	}
	
}
?>