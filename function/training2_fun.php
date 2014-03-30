<?php
include_once('string_fun.php');
function fatch_venue2_maxcode($subdiv_cd)
{
	$sql;$rs;
	$sql="select max(venue_cd) as venue_cd from training_venue_2 where subdivisioncd='$subdiv_cd'";
	$rs=execSelect($sql);
	return $rs;
}
function save_trainingvenue2($venue_cd,$subdiv_cd,$venuename,$venueaddress1,$venueaddress2,$usercd)
{
	$sql="insert into training_venue_2 (venue_cd,subdivisioncd,venuename,venueaddress1,venueaddress2,usercode) values (";
	$sql.="'$venue_cd','$subdiv_cd','$venuename','$venueaddress1','$venueaddress2','$usercd')";
	$i=execInsert($sql);
	return $i;
}
function fatch_training_venue2_ag_subdiv($subdiv)
{
	$sql="Select training_venue_2.venue_cd, training_venue_2.venuename From training_venue_2 ";
	if($subdiv!='')
		$sql.=" where training_venue_2.subdivisioncd='$subdiv'";
	$sql.=" order by training_venue_2.venuename";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_training_venue2($venue_cd)
{
	$sql="Select training_venue_2.venue_cd,
		  training_venue_2.subdivisioncd,
		  training_venue_2.venuename,
		  training_venue_2.venueaddress1,
		  training_venue_2.venueaddress2
		From training_venue_2 ";
	if($venue_cd<>'')
		$sql.=" where training_venue_2.venue_cd='$venue_cd'";
	$sql.=" order by training_venue_2.venue_cd";
	$rs=execSelect($sql);
	return $rs;
}
function update_trainingvenue2($venue_cd,$subdiv_cd,$venuename,$venueaddress1,$venueaddress2,$usercd,$posted_date)
{
	$sql="update training_venue_2 set subdivisioncd='$subdiv_cd',venuename='$venuename',venueaddress1='$venueaddress1',venueaddress2='$venueaddress2',usercode = '$usercd', posted_date = '$posted_date' where venue_cd='$venue_cd'";
	//echo $sql; exit;
	$i=execUpdate($sql);
	return $i;
}
function chk_trainingvenue($venue_cd)
{
	$sql="Select count(*) as total From second_training  WHERE second_training.training_venue='$venue_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$total=$row['total'];
	unset($sql,$rs,$row);
	return $total;
}
function delete_trainingvenue($venue_cd)
{
	$sql="DELETE FROM training_venue_2 WHERE venue_cd='$venue_cd'";
	$rs=execDelete($sql);
	return $rs;
}
function fatch_trainingvenue_list($subdivision,$venuename,$usercode,$dist)
{
	$sql="Select training_venue_2.venue_cd, subdivision.subdivision, training_venue_2.venuename, training_venue_2.venueaddress1, training_venue_2.venueaddress2, training_venue_2.usercode, training_venue_2.posted_date,training_venue_2.subdivisioncd
From training_venue_2
  Inner Join subdivision On training_venue_2.subdivisioncd = subdivision.subdivisioncd where training_venue_2.venue_cd >0 and subdivision.districtcd = '$dist'";
    if($subdivision!='' && $subdivision!='0')
		$sql.=" and training_venue_2.subdivisioncd ='$subdivision'";
	if($venuename!='')
		$sql.=" and training_venue_2.venuename like '$venuename%'";
	$sql.=" order by subdivision.subdivision";
	$rs=execSelect($sql);	
	return $rs;
}

function fatch_trainingvenue_listAct($subdivision,$venuename,$usercode,$p_num ,$items,$dist)
{
	$sql="Select training_venue_2.venue_cd, subdivision.subdivision, training_venue_2.venuename, training_venue_2.venueaddress1, training_venue_2.venueaddress2, training_venue_2.usercode, training_venue_2.posted_date,training_venue_2.subdivisioncd
From training_venue_2
  Inner Join subdivision On training_venue_2.subdivisioncd = subdivision.subdivisioncd where training_venue_2.venue_cd >0 ";
    if($subdivision!='' && $subdivision!='0')
		$sql.=" and training_venue_2.subdivisioncd ='$subdivision'";
	if($dist!='' && $dist!='0')
		$sql.=" and subdivision.districtcd = '$dist'";
	if($venuename!='')
		$sql.=" and training_venue_2.venuename like '$venuename%'";
	$sql.=" order by subdivision.subdivision";
	$sql.=" ASC LIMIT $p_num , $items";
	$rs=execSelect($sql); 
	return $rs;
}

function fatch_schedule2_maxcode($training_venue)
{
	$sql; $rs;
	$sql="select max(schedule_cd) as schedule_code from second_training where training_venue='$training_venue'";
	$rs=execSelect($sql);
	return $rs;
}
function save_training2_schedule($schedule_cd,$forpc,$assembly,$party_reserve,$start_sl,$end_sl,$training_venue,$training_dt,$training_time,$usercd)
{
	$sql="insert into second_training (schedule_cd,for_pc,assembly,party_reserve,start_sl,end_sl,training_venue,training_dt,training_time,	usercode) values ('$schedule_cd','$forpc','$assembly','$party_reserve','$start_sl','$end_sl','$training_venue','$training_dt','$training_time','$usercd')";
	$i=execInsert($sql);
	return $i;
}
function delete_training2_allocation($delcode)
{
	$sql="update personnela set training2_sch=NULL  where training2_sch='$delcode'";
	$i=execUpdate($sql);
	$sql="delete from second_training where schedule_cd='$delcode'";
	$i=execDelete($sql);
	return $i;
}
function fatch_training2_allocation_list($sub_div,$training_venue,$PC,$assembly)
{
	$sql="Select second_training.schedule_cd,
	  assembly.assemblyname,
	  second_training.party_reserve,
	  second_training.start_sl,
	  second_training.end_sl,
	  training_venue_2.venuename,
	  Date_Format(second_training.training_dt, '%d/%m/%Y') As training_dt,
	  second_training.training_time
	From training_venue_2
	  Inner Join second_training On training_venue_2.venue_cd =
		second_training.training_venue
	  Inner Join assembly On second_training.assembly = assembly.assemblycd And
		second_training.for_pc = assembly.pccd
	Where second_training.schedule_cd > 0 ";
//    if($sub_div!='' && $sub_div!='0')
//		$sql.=" and training_venue_2.subdivisioncd ='$sub_div'";
	if($training_venue!='')
		$sql.=" and training_venue_2.venuename like '$training_venue%'";
	if($PC!='0')
		$sql.=" and second_training.for_pc = '$PC'";
	if($assembly!='0' && $assembly!='')
		$sql.=" and second_training.assembly = '$assembly'";
	$sql.=" order by second_training.schedule_cd";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_training2_allocation_listAct($sub_div,$training_venue,$PC,$assembly,$p_num,$items)
{
	$sql="Select second_training.schedule_cd,
	  assembly.assemblyname,
	  second_training.party_reserve,
	  second_training.start_sl,
	  second_training.end_sl,
	  training_venue_2.venuename,
	  Date_Format(second_training.training_dt, '%d/%m/%Y') As training_dt,
	  second_training.training_time,
	  second_training.usercode
	From training_venue_2
	  Inner Join second_training On training_venue_2.venue_cd =
		second_training.training_venue
	  Inner Join assembly On second_training.assembly = assembly.assemblycd And
		second_training.for_pc = assembly.pccd
	Where second_training.schedule_cd > 0 ";
//    if($sub_div!='' && $sub_div!='0')
//		$sql.=" and training_venue_2.subdivisioncd ='$sub_div'";
	if($training_venue!='')
		$sql.=" and training_venue_2.venuename like '$training_venue%'";
	if($PC!='0')
		$sql.=" and second_training.for_pc = '$PC'";
	if($assembly!='0' && $assembly!='')
		$sql.=" and second_training.assembly = '$assembly'";
	$sql.=" order by second_training.schedule_cd";
	$sql.=" ASC LIMIT $p_num , $items";

	$rs=execSelect($sql);
	return $rs;
}

function second_appointment_letter2_print($from,$to,$mem_no)
{
	$sql="Select second_appt.slno,  second_appt.pers_off,  second_appt.groupid,  second_appt.assembly,  second_appt.assembly_name,
	  second_appt.pccd,  second_appt.pcname,  second_appt.pr_personcd,  second_appt.p1_personcd,  second_appt.p2_personcd,
	  second_appt.p3_personcd,  second_appt.pa_personcd,  second_appt.pb_personcd,  second_appt.pr_name,  second_appt.p1_name,
	  second_appt.p2_name,  second_appt.p3_name,  second_appt.pa_name,  second_appt.pb_name,  second_appt.pr_designation,
	  second_appt.p1_designation,  second_appt.p2_designation,  second_appt.p3_designation,  second_appt.pa_designation,
	  second_appt.pb_designation,  second_appt.pr_status,  second_appt.p1_status,  second_appt.p2_status,  second_appt.p3_status,
	  second_appt.pa_status,  second_appt.pb_status, second_appt.pr_post_stat, second_appt.p1_post_stat, second_appt.p2_post_stat, 	second_appt.p3_post_stat, second_appt.pa_post_stat, second_appt.pb_post_stat,
	  second_appt.pr_officecd,  second_appt.p1_officecd,  second_appt.p2_officecd,
	  second_appt.p3_officecd,  second_appt.pa_officecd,  second_appt.pb_officecd,  second_appt.pr_officename,  second_appt.p1_officename,
	  second_appt.p2_officename,  second_appt.p3_officename,  second_appt.pa_officename,  second_appt.pb_officename,  second_appt.pr_officeaddress,
	  second_appt.p1_officeaddress,  second_appt.p2_officeaddress,  second_appt.p3_officeaddress,  second_appt.pa_officeaddress,
	  second_appt.pb_officeaddress,  second_appt.pr_postoffice,  second_appt.p1_postoffice,  second_appt.p2_postoffice,
	  second_appt.p3_postoffice,  second_appt.pa_postoffice,  second_appt.pb_postoffice,  second_appt.pr_subdivision,  second_appt.p1_subdivision,
	  second_appt.p2_subdivision,  second_appt.p3_subdivision,  second_appt.pa_subdivision,  second_appt.pb_subdivision,
	  second_appt.district,  second_appt.pr_pincode,  second_appt.p1_pincode,  second_appt.p2_pincode,
	  second_appt.p3_pincode,  second_appt.pa_pincode,  second_appt.pb_pincode,  second_appt.dc_venue,  second_appt.dc_address, 
	  date_format(second_appt.dc_date,'%d/%m/%Y') as dc_date,  second_appt.dc_time,  second_appt.rc_venue, second_appt.mem_no,
	  second_appt.dcrcgrp, second_appt.traingcode,  second_appt.training_venue,  second_appt.venue_addr1, second_appt.venue_addr2,
	  date_format(second_appt.training_date,'%d/%m/%Y') as training_date, 
	  second_appt.training_time, date_format(second_appt.polldate,'%d/%m/%Y') as polldate, second_appt.polltime
	From second_appt where mem_no='$mem_no'";
	$sql.=" order by slno limit $from,$to";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fetch_second_apt()
{
	$sql="select pers_off,pr_personcd from second_appt order by pers_off";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fetch_second_apt_reserve()
{
	$sql="select personcd from second_rand_table_reserve order by officecd";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}

function second_appointment_letter_reserve2_print($from,$to)
{
	$sql="SELECT `slno`,`groupid`,`assembly`,`pcname`,`personcd`,`person_name`,`person_designation`,`post_status`,	
	`post_stat`,`officecd`,`office_name`,`office_address`,`post_office`,`subdivision`,`police_stn`,`district`,
	`pincode`,`dc_venue`,`dc_address`,date_format(`dc_date`,'%d/%m/%Y') as dc_date,`dc_time`,`rc_venue`,`traingcode`,`training_venue`,`venuecode`,
	`venue_addr1`,`venue_addr2`,date_format(`training_date`,'%d/%m/%Y') as training_date,`training_time`,date_format(`polldate`,'%d/%m/%Y') as polldate,`polltime` 
	FROM `second_rand_table_reserve`";
	$sql.=" order by slno limit $from,$to";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
?>