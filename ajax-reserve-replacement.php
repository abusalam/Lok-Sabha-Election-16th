<?php
session_start();
extract($_GET);
date_default_timezone_set('Asia/Calcutta');
include_once('inc/db_trans.inc.php');
include_once('function/reserve-fun.php');
//include_once('function/add_fun.php');

$p_id=isset($_GET["p_id"])?$_GET["p_id"]:"";
$p_dtl=isset($_GET["p_dtl"])?$_GET["p_dtl"]:"";
$opn=isset($_GET["opn"])?$_GET["opn"]:"";
if($p_id != '')
{
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
		if($row_person['booked']=='C' || $row_person['booked']=='' || $row_person['booked']=='P')
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
		echo "<tr><td align='left' colspan='4'><hidden id='hid_forpc' name='hid_forpc' style='display:none;'>".$row_person['forpc']."</hidden>\n<hidden id='hid_forassembly' name='hid_forassembly' style='display:none;'>".$row_person['forassembly']."</hidden>\n<hidden id='hid_groupid' name='hid_groupid' style='display:none;'>".$row_person['groupid']."</hidden>\n<hidden id='hid_booked' name='hid_booked' style='display:none;'>".$row_person['booked']."</hidden>\n<hidden id='hid_per_cd' name='hid_per_cd' style='display:none;'>".$row_person['personcd']."</hidden>\n <hidden id='hid_for_subdiv' name='hid_for_subdiv' style='display:none;'>".$row_person['forsubdivision']."</hidden>\n <hidden id='hid_dcrccd' name='hid_dcrccd' style='display:none;'>".$row_person['dcrccd']."</hidden>\n <hidden id='hid_sub_div' name='hid_sub_div' style='display:none;'>".$row_person['subdivisioncd']."</hidden>\n <hidden id='hid_training2_sch' name='hid_training2_sch' style='display:none;'>".$row_person['training2_sch']."</hidden></td></tr>\n";
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

//================================ Reserve Personnel Replacement =======================================

$forassembly=isset($_GET["forassembly"])?$_GET["forassembly"]:"";
$post_stat=isset($_GET["post_stat"])?$_GET["post_stat"]:"";
//$groupid=isset($_GET["groupid"])?$_GET["groupid"]:"";
$gender=isset($_GET["gender"])?$_GET["gender"]:"";
if($opn=='new_search')
{
	$for_subdiv=isset($_GET["for_subdiv"])?$_GET["for_subdiv"]:"";
	if($forassembly!='' && $post_stat!='' && $gender!='')
	{
		$rs_new_per; $row_new_per;
		$rs_new_per=fatch_Random_personnel_for_replacement($for_subdiv,$forassembly,$post_stat,$gender);
		//$random_rs_person=array_rand($rs_new_per);
		$num_rows_new_per=rowCount($rs_new_per);
		if($num_rows_new_per>0)
		{
			$row_new_per=getRows($rs_new_per);
			echo "<table>\n";
			echo "<tr><td align='center' colspan='4'><b>NEW PERSONNEL</b></td></tr>\n";
			echo "<tr><td align='left'><b>Personnel ID: </b></td><td align='left' id='new_per_id'>".$row_new_per['personcd']."</td><td align='left'><b>Office ID: </b></td><td>".$row_new_per['officecd']."</td></tr>\n";
			echo "<tr><td align='left'>Name: </td><td align='left' colspan='3'>".$row_new_per['officer_name']."</td></tr>\n";
			echo "<tr><td align='left'>Designation: </td><td align='left' colspan='3'>".$row_new_per['off_desg']."</td></tr>\n";
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
}
$usercd=isset($_SESSION)?$_SESSION['user_cd']:"";
if($opn=='g_rplc')
{
	$old_p_id=isset($_GET["old_p_id"])?$_GET["old_p_id"]:"";
	$booked=isset($_GET["booked"])?$_GET["booked"]:"";
	$new_p_id=isset($_GET["new_p_id"])?$_GET["new_p_id"]:"";
	$forassembly=isset($_GET["forassembly"])?$_GET["forassembly"]:"";
	$forpc=isset($_GET["forpc"])?$_GET["forpc"]:"";
	$groupid=isset($_GET["groupid"])?$_GET["groupid"]:"";
	$dcrccd=isset($_GET["dcrccd"])?$_GET["dcrccd"]:"";
	$training2_sch=isset($_GET["training2_sch"])?$_GET["training2_sch"]:"";
	if($old_p_id!='' && $new_p_id!='' && $forassembly!='' && $groupid!='')
	{
		$selected=1;
		$ret=update_personnel_replacement($new_p_id,$groupid,$forassembly,$forpc,$booked,$selected,$dcrccd,$training2_sch);
		if($ret==1)
		{
			$selected=0;
			$res1=update_personnel_replacement($old_p_id,0,'',$forpc,'C',$selected,'','');
			if($res1==1)
			{
				echo "Changed";
			}
			$res2=reserve_replacement_log($new_p_id,$old_p_id,$forassembly,$groupid,$usercd);
			
			
			delete_prev_data_second_rand_reserve($old_p_id,$new_p_id);
	
	//include_once('inc/commit_con.php');
//	mysqli_autocommit($link,FALSE);
	
				$sql11="insert into second_rand_table_reserve (groupid,assembly,personcd,person_name,person_designation,post_status,post_stat,officecd,office_name,office_address,post_office,subdivision,police_stn,district,pincode,dc_venue,dc_address,dc_date,dc_time,rc_venue,assemblycd,dcrccd,training_schd,districtcd,subdivisioncd,pccd) Select personnela.groupid,
				  assembly.assemblyname,	 
				  personnela.personcd,
			 personnela.officer_name,
			personnela.off_desg,
			personnela.poststat,
			poststat.poststatus,
			
			 office.officecd,
				  office.office,
				 concat(office.address1,',',office.address2),
				  office.postoffice,
				  subdivision.subdivision,
				  policestation.policestation,
				  district.district,
				  office.pin,
				 
				  dcrcmaster.dc_venue,
				  dcrcmaster.dc_addr,
				  DATE(dcrc_party.dc_date) As dc_date,
				  dcrc_party.dc_time,
				  dcrcmaster.rcvenue,
				  personnela.forassembly,
				  
				  personnela.dcrccd,
				  personnela.training2_sch,
					  personnela.districtcd,
				   personnela.forsubdivision,
			personnela.forpc
				From personnela
				  Inner Join office On personnela.officecd = office.officecd
				  Inner Join subdivision On subdivision.subdivisioncd = office.subdivisioncd
				  Inner Join policestation
					On office.policestn_cd = policestation.policestationcd
				  Inner Join district On office.districtcd = district.districtcd        
			     
				  Inner Join assembly On personnela.forassembly = assembly.assemblycd
				   and personnela.forsubdivision=assembly.subdivisioncd 
				  Inner Join dcrcmaster On personnela.dcrccd = dcrcmaster.dcrcgrp
				  Inner Join dcrc_party On dcrc_party.dcrcgrp = dcrcmaster.dcrcgrp
				  Inner Join poststat On personnela.poststat = poststat.post_stat 
			where personnela.booked='R' and personnela.personcd='$new_p_id'";
			$i=execInsert($sql11);		
					/*$sql19="update second_rand_table_reserve join second_training on substr(second_rand_table_reserve.pcname,1,2)=second_training.for_pc and substr(second_rand_table_reserve.assembly,1,3)=second_training.assembly set second_rand_table_reserve.traingcode=second_training.schedule_cd, second_rand_table_reserve.venuecode=second_training.training_venue , second_rand_table_reserve.training_date=second_training.training_dt, second_rand_table_reserve.training_time=second_training.training_time where second_training.party_reserve='R' and second_rand_table_reserve.groupid>=second_training.start_sl and second_rand_table_reserve.groupid<=second_training.end_sl and second_training.for_pc='$forpc' and second_training.assembly='$forassembly' and second_rand_table_reserve.personcd='$new_p_id'";*/
					$sql19="update second_rand_table_reserve join second_training on 
			second_rand_table_reserve.subdivisioncd=second_training.for_subdiv and second_rand_table_reserve.training_schd=second_training.schedule_cd
			
			set second_rand_table_reserve.traingcode=second_training.schedule_cd, second_rand_table_reserve.venuecode=second_training.training_venue , second_rand_table_reserve.training_date=second_training.training_dt, second_rand_table_reserve.training_time=second_training.training_time 
			where second_rand_table_reserve.personcd='$new_p_id'";
					
					$i=execUpdate($sql19);
					$sql20="UPDATE second_rand_table_reserve a  JOIN training_venue_2 b ON a.venuecode=b.venue_cd SET  a.`training_venue` = b.venuename,a.`venue_addr1` =b.venueaddress1,  a.`venue_addr2`=b.venueaddress2 where a.personcd='$new_p_id'";
					$i=execUpdate($sql20);
					$sql271="update second_rand_table_reserve a join poll_table b on a.assemblycd=b.assembly_cd set a.polldate=b.poll_date, a.polltime=b.poll_time  where a.assemblycd=b.assembly_cd and a.personcd='$new_p_id'";
					$i=execUpdate($sql271);
		}
	}
}
if($opn=='reserve_appletter')
{
	$old_p_id=isset($_GET["old_p_id"])?$_GET["old_p_id"]:"";
	$new_p_id=isset($_GET["new_p_id"])?$_GET["new_p_id"]:"";
	$forassembly=isset($_GET["forassembly"])?$_GET["forassembly"]:"";
	$forpc=isset($_GET["forpc"])?$_GET["forpc"]:"";
	$groupid=isset($_GET["groupid"])?$_GET["groupid"]:"";
	//delete_prev_data_second_rand_reserve($old_p_id,$new_p_id);
	
	//include_once('inc/commit_con.php');
//	mysqli_autocommit($link,FALSE);
	
	/*$sql11="insert into second_rand_table_reserve (groupid,assembly,personcd,person_name,person_designation,post_status,post_stat,officecd,office_name,office_address,post_office,subdivision,police_stn,district,pincode,dc_venue,dc_address,dc_date,dc_time,rc_venue,assemblycd,dcrccd,training_schd,districtcd,subdivisioncd,pccd) Select personnela.groupid,
	  assembly.assemblyname,	 
	  personnela.personcd,
 personnela.officer_name,
personnela.off_desg,
personnela.poststat,
poststat.poststatus,

 office.officecd,
	  office.office,
	 concat(office.address1,',',office.address2),
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	 
	  dcrcmaster.dc_venue,
	  dcrcmaster.dc_addr,
	  DATE(dcrc_party.dc_date) As dc_date,
	  dcrc_party.dc_time,
	  dcrcmaster.rcvenue,
	  personnela.forassembly,
	  
	  personnela.dcrccd,
	  personnela.training2_sch,
          personnela.districtcd,
	   personnela.forsubdivision,
personnela.forpc
	From personnela
	  Inner Join office On personnela.officecd = office.officecd
	  Inner Join subdivision On subdivision.subdivisioncd = office.subdivisioncd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd        

	  Left Join assembly On personnela.forassembly = assembly.assemblycd
	  Inner Join dcrcmaster On personnela.dcrccd = dcrcmaster.dcrcgrp
	  Inner Join dcrc_party On dcrc_party.dcrcgrp = dcrcmaster.dcrcgrp
	  Inner Join poststat On personnela.poststat = poststat.post_stat 
where personnela.booked='R' and personnela.personcd='$new_p_id'";
$i=execInsert($sql11);		
		
		$sql19="update second_rand_table_reserve join second_training on 
second_rand_table_reserve.subdivisioncd=second_training.for_subdiv and second_rand_table_reserve.training_schd=second_training.schedule_cd

set second_rand_table_reserve.traingcode=second_training.schedule_cd, second_rand_table_reserve.venuecode=second_training.training_venue , second_rand_table_reserve.training_date=second_training.training_dt, second_rand_table_reserve.training_time=second_training.training_time 
where second_rand_table_reserve.personcd='$new_p_id'";
		
		$i=execUpdate($sql19);
		$sql20="UPDATE second_rand_table_reserve a  JOIN training_venue_2 b ON a.venuecode=b.venue_cd SET  a.`training_venue` = b.venuename,a.`venue_addr1` =b.venueaddress1,  a.`venue_addr2`=b.venueaddress2 where a.personcd='$new_p_id'";
		$i=execUpdate($sql20);
		$sql271="update second_rand_table_reserve a join poll_table b on a.assemblycd=b.assembly_cd set a.polldate=b.poll_date, a.polltime=b.poll_time  where a.assemblycd=b.assembly_cd and a.personcd='$new_p_id'";
		$i=execUpdate($sql271);*/
		$new_pid=encode($new_p_id);
		print "fpdf/2nd-app-letter3-reserve.php?personcd=$new_pid";
	//}
}
?>