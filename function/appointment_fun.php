<?php
include_once('string_fun.php');

function fatch_Office_ag_subdiv($sub_div)
{
	$sql=''; $rs=null;
	$sql="Select officecd, office From office  where subdivisioncd='$sub_div'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_personnel_ag_office($sub_div, $office)
{
	$sql; $rs;
	$sql="Select personnela.personcd, personnela.officer_name From personnela Inner Join office On personnela.officecd = office.officecd
	where office.subdivisioncd='$sub_div'";
	if($office!="" && $office!="0")
	$sql.=" and personnela.officecd='$office'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function add_temp_app_letter($per_cd,$usercd)
{
	$sql="insert into tmp_app_let (per_code,usercode) values ('$per_cd','$usercd')";
	$i=execInsert($sql);
	connection_close();
	return $i;
}
function delete_temp_app_letter($usercd)
{
	$sql="delete from tmp_app_let where usercode='$usercd'";
	$i=execInsert($sql);
	connection_close();
	return $i;
}
function fetch_id_temp_app_letter($usercd)
{
	$sql="Select per_code From tmp_app_let where usercode='$usercd'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function first_appointment_letter_hdr($per_code)
{
	$sql="Select Distinct personnela.officer_name,
	  personnela.off_desg As person_desig,
	  personnela.personcd,
	  office.officer_desg As officer_desig,
	  office.office,
	  office.address1,
	  office.address2,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  office.officecd,
	  personnela.mob_no,
	  poststat.poststatus,
	  personnela.acno,
	  personnela.partno,
	  personnela.slno,
	  personnela.epic,
	  personnela.forpc,
	  pc.pcname,
	  bank.bank_name,
	  branch.branch_name,
	  personnela.bank_acc_no,
	  branch.ifsc_code,
	  personnela.forsubdivision,
	  training_pp.token,
	  poststat.post_stat,
	  subdivision1.subdivision As pp_subdivision
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Inner Join training_pp On personnela.personcd = training_pp.per_code
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  Inner Join pc On personnela.forpc = pc.pccd And pc.subdivisioncd =
		personnela.forsubdivision
	  Left Join bank On bank.bank_cd = personnela.bank_cd
	  Left Join branch On personnela.branchcd = branch.branchcd And
		personnela.bank_cd = branch.bank_cd
	  Inner Join subdivision subdivision1 On training_pp.subdivision =
		subdivision1.subdivisioncd";
	$sql.=" where personnela.personcd='$per_code' and personnela.selected='1'";
	//print $sql;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function first_appointment_letter($per_code)
{
	$sql="Select Distinct training_type.training_desc,
	  training_venue.venuename,
	  training_venue.venueaddress1,
	  training_venue.venueaddress2,
	  Date_Format(training_schedule.training_dt, '%d/%m/%Y') As training_dt,
	  training_schedule.training_time
	From training_pp
	  Inner Join training_schedule On training_schedule.schedule_code =
		training_pp.training_sch
	  Inner Join training_type On training_schedule.training_type =
		training_type.training_code
	  Inner Join training_venue On training_schedule.training_venue =
		training_venue.venue_cd";
	$sql.=" where training_pp.per_code='$per_code'";
	$sql.= " order by training_schedule.training_type";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function delete_prev_data($sub_div,$str_office)
{
	$sql="delete from first_rand_table where forsubdivision='$sub_div'";
	if($str_office!="")
		$sql.=" and first_rand_table.office='$str_office'";
	$i=execDelete($sql);
	connection_close();
	return $i;
}
function first_appointment_letter2_subdiv($sub_div,$office)
{
	$sql="Select Distinct office.office
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Inner Join training_pp On personnela.personcd = training_pp.per_code
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  Inner Join pc On personnela.forpc = pc.pccd And pc.subdivisioncd =
    personnela.forsubdivision where personnela.forsubdivision='$sub_div' and personnela.selected='1' ";
	//if($office!='0')
	$sql.=" and office.officecd='$office'";
	$sql.=" order by office.subdivisioncd,office.blockormuni_cd,office.officecd, personnela.personcd,
	  poststat.poststatus, personnela.off_desg";
	//print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function first_appointment_letter2_hdr($sub_div,$office)
{
	$sql="Select Distinct personnela.officer_name,
	  personnela.off_desg As person_desig,
	  personnela.personcd,
	  office.officer_desg As officer_desig,
	  office.office,
	  office.address1,
	  office.address2,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  office.officecd,
	  personnela.mob_no,
	  poststat.poststatus,
	  personnela.acno,
	  personnela.partno,
	  personnela.slno,
	  personnela.epic,
	  personnela.forpc,
	  pc.pcname,
	  bank.bank_name,
	  branch.branch_name,
	  personnela.bank_acc_no,
	  branch.ifsc_code,
	  training_type.training_desc,
	  training_venue.venuename,
	  training_venue.venueaddress1,
	  training_venue.venueaddress2,
	  Date_Format(training_schedule.training_dt, '%d/%m/%Y') As training_dt,
	  training_schedule.training_time,
	  personnela.forsubdivision,
	  training_pp.token,
	  poststat.post_stat,
	  subdivision1.subdivision As pp_subdivision
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Inner Join training_pp On personnela.personcd = training_pp.per_code
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  Inner Join pc On personnela.forpc = pc.pccd And pc.subdivisioncd =
		personnela.forsubdivision
	  Left Join bank On personnela.bank_cd = bank.bank_cd
	  Left Join branch On personnela.branchcd = branch.branchcd And
		personnela.bank_cd = branch.bank_cd
	  Inner Join training_type On training_type.training_code =
		training_pp.training_type
	  Left Join training_schedule On training_schedule.schedule_code =
		training_pp.training_sch
	  Left Join training_venue On training_venue.venue_cd =
		training_schedule.training_venue
	  Inner Join subdivision subdivision1 On training_pp.subdivision =
		subdivision1.subdivisioncd
	Where personnela.forsubdivision = '$sub_div' And personnela.selected = '1' ";
	if($office!='0')
	$sql.=" and office.officecd='$office'";
	$sql.=" order by office.subdivisioncd,office.blockormuni_cd,office.officecd, personnela.personcd,
	  poststat.poststatus, personnela.off_desg";
	//print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function first_appointment_letter2($per_code)
{
	$sql="Select Distinct training_type.training_desc,
	  training_venue.venuename,
	  training_venue.venueaddress1,
	  training_venue.venueaddress2,
	  Date_Format(training_schedule.training_dt, '%d/%m/%Y') As training_dt,
	  training_schedule.training_time
	From training_pp
	  Inner Join training_schedule On training_schedule.schedule_code =
		training_pp.training_sch
	  Inner Join training_type On training_schedule.training_type =
		training_type.training_code
	  Inner Join training_venue On training_schedule.training_venue =
		training_venue.venue_cd where  training_pp.per_code='$per_code'";
	$sql.=" order by training_schedule.training_type";
	//print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function first_appointment_letter3_subdiv($sub_div,$post_stat)
{
	$sql="Select Distinct poststat.poststatus 
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Inner Join training_pp On personnela.personcd = training_pp.per_code
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  Inner Join pc On personnela.forpc = pc.pccd And pc.subdivisioncd =
    personnela.forsubdivision where personnela.forsubdivision='$sub_div' and personnela.selected='1' and personnela.poststat='$post_stat' ";
	$sql.=" order by office.subdivisioncd,office.blockormuni_cd,office.officecd, personnela.personcd,
	  poststat.poststatus, personnela.off_desg";
	//print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function delete_prev_data_app3($sub_div,$post_stat)
{
	$sql="delete from first_rand_table where forsubdivision='$str_sub_div' and poststatus='$post_stat'";
	$i=execDelete($sql);
	connection_close();
	return $i;
}
function first_appointment_letter3($sub_div,$post_stat)
{
	$sql="Select Distinct personnela.officer_name,
	  personnela.off_desg As person_desig,
	  personnela.personcd,
	  office.officer_desg As officer_desig,
	  office.office,
	  office.address1,
	  office.address2,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  office.officecd,
	  personnela.mob_no,
	  poststat.poststatus,
	  personnela.acno,
	  personnela.partno,
	  personnela.slno,
	  personnela.epic,
	  personnela.forpc,
	  pc.pcname,
	  bank.bank_name,
	  branch.branch_name,
	  personnela.bank_acc_no,
	  branch.ifsc_code,
	  training_type.training_desc,
	  training_venue.venuename,
	  training_venue.venueaddress1,
	  training_venue.venueaddress2,
	  Date_Format(training_schedule.training_dt, '%d/%m/%Y') As training_dt,
	  training_schedule.training_time,
	  personnela.forsubdivision,
	  training_pp.token,
	  poststat.post_stat,
	  subdivision1.subdivision As pp_subdivision
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Inner Join training_pp On personnela.personcd = training_pp.per_code
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  Inner Join pc On personnela.forpc = pc.pccd And pc.subdivisioncd =
		personnela.forsubdivision
	  Left Join bank On personnela.bank_cd = bank.bank_cd
	  Left Join branch On personnela.branchcd = branch.branchcd And
		personnela.bank_cd = branch.bank_cd
	  Inner Join training_type On training_type.training_code =
		training_pp.training_type
	  Left Join training_schedule On training_schedule.schedule_code =
		training_pp.training_sch
	  Left Join training_venue On training_venue.venue_cd =
		training_schedule.training_venue
	  Inner Join subdivision subdivision1 On training_pp.subdivision =
		subdivision1.subdivisioncd
	Where personnela.forsubdivision = '$sub_div' And personnela.selected = '1' and personnela.poststat='$post_stat'";
//	if($office!='0')
//	$sql.=" and office.officecd='$office'";
	$sql.=" order by office.subdivisioncd,office.blockormuni_cd,office.officecd, personnela.personcd,
	  poststat.poststatus, personnela.off_desg";
	//print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function delete_prev_data_single($str_per_code)
{
	$sql="delete from first_rand_table where personcd='$str_per_code'";
	$i=execDelete($sql);
	connection_close();
	return $i;
}
function fatch_assembly_ag_pc1($pc)
{
	$sql="select * from assembly where pccd='$pc'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fetch_first_rand_tab_ag_subdiv($str_sub_div)
{
	$sql="select * from first_rand_table where subdivision='$str_sub_div'";
	//print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//================= Second App Letter ====================
function second_app_hrd($forassembly,$forpc,$group_id)
{
	$sql="Select Distinct personnela.groupid,
	  assembly.assemblycd,
	  assembly.assemblyname,
	  pc.pccd,
	  pc.pcname,
	  dcrcmaster.dc_venue,
	  dcrcmaster.dc_addr,
	  Date_Format(dcrc_party.dc_date, '%d/%m/%Y') As dc_date,
	  dcrc_party.dc_time,
	  dcrcmaster.rcvenue
	From personnela
	  Inner Join pc On personnela.forpc = pc.pccd
	  Inner Join assembly On personnela.forassembly = assembly.assemblycd
	  Inner Join dcrcmaster On personnela.forassembly = dcrcmaster.assemblycd
	  Inner Join dcrc_party On dcrc_party.dcrcgrp = dcrcmaster.dcrcgrp
	Where personnela.groupid Is Not Null And personnela.groupid != '0'";
	if($forassembly!='' && $forassembly!=null && $forassembly!=0)
		$sql.=" and personnela.forassembly='$forassembly'";
	elseif($forpc!='' && $forpc!=null && $forpc!=0)
		$sql.=" and personnela.forpc='$forpc'";
	if($group_id!='' && $group_id!=null)
		$sql.=" and personnela.groupid='$group_id'";
	$sql.=" order by personnela.forpc,personnela.forassembly,personnela.groupid";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function second_appointment_letter($group_id,$forassembly)
{
/*	$sql="Select personnela.groupid,
	  assembly.assemblycd,
	  assembly.assemblyname,
	  pc.pccd,
	  pc.pcname,
	  pollingstation.psno,
	  pollingstation.psname,
	  personnela.officer_name,
	  personnela.personcd,
	  office.office,
	  office.address1,
	  office.address2,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  office.officecd,
	  dcrcmaster.dc_venue,
	  dcrcmaster.dc_addr,
	  Date_Format(dcrc_party.dc_date, '%d/%m/%Y') As dc_date,
	  dcrc_party.dc_time,
	  dcrcmaster.rcvenue,
	  personnela.poststat,
	  personnela.off_desg
	From personnela
	  Inner Join office On personnela.officecd = office.officecd
	  Inner Join subdivision On subdivision.subdivisioncd = office.subdivisioncd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Left Join pc On personnela.forpc = pc.pccd And personnela.forsubdivision =
		pc.subdivisioncd
	  Left Join assembly On personnela.forassembly = assembly.assemblycd
	  Inner Join pollingstation On personnela.forassembly =
		pollingstation.forassembly
	  Inner Join dcrcmaster On pollingstation.dcrccd = dcrcmaster.dcrcgrp
	  Inner Join dcrc_party On dcrc_party.dcrcgrp = dcrcmaster.dcrcgrp"; */
	$sql="Select personnela.groupid,
	  assembly.assemblycd,
	  assembly.assemblyname,
	  pc.pccd,
	  pc.pcname,
	  personnela.officer_name,
	  personnela.personcd,
	  office.office,
	  office.address1,
	  office.address2,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  office.officecd,
	  dcrcmaster.dc_venue,
	  dcrcmaster.dc_addr,
	  Date_Format(dcrc_party.dc_date, '%d/%m/%Y') As dc_date,
	  dcrc_party.dc_time,
	  dcrcmaster.rcvenue,
	  personnela.poststat,
	  personnela.off_desg
	From personnela
	  Inner Join office On personnela.officecd = office.officecd
	  Inner Join subdivision On subdivision.subdivisioncd = office.subdivisioncd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Left Join pc On personnela.forpc = pc.pccd And personnela.forsubdivision =
		pc.subdivisioncd
	  Left Join assembly On personnela.forassembly = assembly.assemblycd
	  Inner Join dcrcmaster On personnela.forassembly = dcrcmaster.assemblycd
	  Inner Join dcrc_party On dcrc_party.dcrcgrp = dcrcmaster.dcrcgrp ";
	$sql.=" where personnela.groupid='$group_id' and personnela.forassembly='$forassembly' and personnela.booked='P'";
	$sql.=" order by personnela.groupid, personnela.poststat";
//		print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function delete_prev_data_second_rand($forassembly,$forpc,$group_id)
{
	$sql="delete from second_rand_table where code>0";
	if($forassembly!="0" && $forassembly!="")
		$sql.=" and assembly like '$forassembly%'";
	elseif($forpc!="0")
		$sql.=" and pcname like '$forpc%'";
	if($group_id!="")
		$sql.=" and groupid = '$group_id'";
	$i=execDelete($sql);
	//print $sql."   $forpc"; exit;
	connection_close();
	return $i;
}
//===================== Reserve ========================
function second_appointment_letter_reserve($group_id,$forassembly,$forpc)
{
	/*$sql="Select personnela.groupid,
	  assembly.assemblycd,
	  assembly.assemblyname,
	  pc.pccd,
	  pc.pcname,
	  pollingstation.psno,
	  pollingstation.psname,
	  personnela.officer_name,
	  personnela.personcd,
	  office.office,
	  office.address1,
	  office.address2,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  office.officecd,
	  dcrcmaster.dc_venue,
	  dcrcmaster.dc_addr,
	  Date_Format(dcrc_party.dc_date, '%d/%m/%Y') As dc_date,
	  dcrc_party.dc_time,
	  dcrcmaster.rcvenue,
	  personnela.poststat,
	  personnela.off_desg
	From personnela
	  Inner Join office On personnela.officecd = office.officecd
	  Inner Join subdivision On subdivision.subdivisioncd = office.subdivisioncd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Left Join pc On personnela.forpc = pc.pccd And personnela.forsubdivision =
		pc.subdivisioncd
	  Left Join assembly On personnela.forassembly = assembly.assemblycd
	  Inner Join pollingstation On personnela.forassembly =
		pollingstation.forassembly
	  Inner Join dcrcmaster On pollingstation.dcrccd = dcrcmaster.dcrcgrp
	  Inner Join dcrc_party On dcrc_party.dcrcgrp = dcrcmaster.dcrcgrp";*/
	$sql="Select personnela.groupid,
	  assembly.assemblycd,
	  assembly.assemblyname,
	  pc.pccd,
	  pc.pcname,
	  personnela.officer_name,
	  personnela.personcd,
	  office.office,
	  office.address1,
	  office.address2,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  office.officecd,
	  dcrcmaster.dc_venue,
	  dcrcmaster.dc_addr,
	  Date_Format(dcrc_party.dc_date, '%d/%m/%Y') As dc_date,
	  dcrc_party.dc_time,
	  dcrcmaster.rcvenue,
	  personnela.poststat,
	  personnela.off_desg
	From personnela
	  Inner Join office On personnela.officecd = office.officecd
	  Inner Join subdivision On subdivision.subdivisioncd = office.subdivisioncd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Left Join pc On personnela.forpc = pc.pccd And personnela.forsubdivision =
		pc.subdivisioncd
	  Left Join assembly On personnela.forassembly = assembly.assemblycd
	  Inner Join dcrcmaster On personnela.forassembly = dcrcmaster.assemblycd
	  Inner Join dcrc_party On dcrc_party.dcrcgrp = dcrcmaster.dcrcgrp";
	$sql.=" where personnela.booked='R'";
	if($forassembly!='' && $forassembly!=null && $forassembly!=0)
		$sql.=" and personnela.forassembly='$forassembly'";
	elseif($forpc!='' && $forpc!=null && $forpc!=0)
		$sql.=" and personnela.forpc='$forpc'";
	if($group_id!='' && $group_id!=null)
		$sql.=" and personnela.groupid='$group_id'";
	$sql.=" order by personnela.forpc,personnela.forassembly,office.subdivisioncd,office.blockormuni_cd,office.officecd,personnela.groupid, personnela.poststat";
//	print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function assembly_name_ag_code($assembly)
{
	$sql=" SELECT * from assembly where assemblycd='$assembly'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function amount_ag_poststat($poststat)
{
	$sql=" SELECT amount from poststatorder where poststat='$poststat'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$amount=$row['amount'];
	connection_close();
	return $amount;
}
function delete_prev_data_second_rand_reserve($forassembly,$forpc,$group_id)
{
	$sql="delete from second_rand_table_reserve where code>0";
	if($forassembly!="0" && $forassembly!="")
		$sql.=" and assembly like '$forassembly%'";
	elseif($forpc!="0")
		$sql.=" and pcname like '$forpc%'";
	if($group_id!="")
		$sql.=" and groupid = '$group_id'";
	$i=execDelete($sql);
	//print $sql; exit;
	connection_close();
	return $i;
}
?>