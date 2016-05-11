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
//for replace personnel id///
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
function first_appointment_letter_replace_new_id($per_code)
{
	$sql="insert into first_rand_table (officer_name,person_desig,personcd,office,address,block_muni,block_muni_name,postoffice,subdivision,policestation, district,pin,officecd,poststatus,mob_no,training_desc,venuename,venueaddress,training_dt,training_time,pc_code,forsubdivision,epic,acno,partno,slno,bank,branch,bank_accno,ifsc,token)";
	
	$sql.="Select Distinct personnela.officer_name,
	  personnela.off_desg As person_desig,
	  personnela.personcd,
	  office.office,
	  concat(office.address1,',',office.address2),
	  office.blockormuni_cd,
	  block_muni.blockmuni,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  office.officecd,
	  poststat.poststatus,
	  personnela.mob_no,
	  
	  training_type.training_desc,
	  training_venue.venuename,
	  concat(training_venue.venueaddress1,',',training_venue.venueaddress2),
	  Date_Format(training_schedule.training_dt, '%d/%m/%Y') As training_dt,
	  training_schedule.training_time,
	  
	  personnela.forpc,
	  personnela.forsubdivision,
	  
	  personnela.epic,
	  personnela.acno,
	  personnela.partno,
	  personnela.slno,
	   
	  bank.bank_name,
	  branch.branch_name,
	  personnela.bank_acc_no,
	  branch.ifsc_code,
	 
	  REPLACE(concat(SUBSTRING(subdivision1.subdivisioncd,1,4),'/',poststat.post_stat,'/',training_pp.token),'','') 
 as r_token
	  
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Inner Join block_muni On office.blockormuni_cd = block_muni.blockminicd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Inner Join training_pp On personnela.personcd = training_pp.per_code
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  
	  Left Join bank On personnela.bank_cd = bank.bank_cd
	  Left Join branch On personnela.branchcd = branch.branchcd And
		personnela.bank_cd = branch.bank_cd
	  Inner Join training_type On training_type.training_code =
		training_pp.training_type
	  Left Join training_schedule On training_schedule.schedule_code =
		training_pp.training_sch
	  Left Join training_venue On training_venue.venue_cd =
		training_schedule.training_venue
	  Inner Join subdivision subdivision1 On training_pp.for_subdivision =
		subdivision1.subdivisioncd
	Where personnela.personcd='$per_code' And personnela.selected = 1 ";
	execSelect($sql);
	return 1;
}
function first_appointment_letter_hdr($per_code)
{
	/*$sql="Select Distinct personnela.officer_name,
	  personnela.off_desg As person_desig,
	  personnela.personcd,
	  office.officer_desg As officer_desig,
	  office.office,
	  office.address1,
	  office.address2,
	  office.blockormuni_cd,
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

	  Left Join bank On bank.bank_cd = personnela.bank_cd
	  Left Join branch On personnela.branchcd = branch.branchcd And
		personnela.bank_cd = branch.bank_cd
	  Inner Join subdivision subdivision1 On training_pp.subdivision =
		subdivision1.subdivisioncd";
	$sql.=" where personnela.personcd='$per_code' and personnela.selected='1'";*/
	$sql="Select Distinct personnela.officer_name,
	  personnela.off_desg As person_desig,
	  personnela.personcd,
	  office.officer_desg As officer_desig,
	  office.office,
	  office.address1,
	  office.address2,
	  office.blockormuni_cd,
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
	Where personnela.personcd='$per_code' And personnela.selected = '1'";
	
	//print $sql;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function insert_into_first_rand_table($officer_name,$person_desig,$personcd,$office,$office_address,$block_muni,$postoffice,$subdivision,$policestation,$district,$pin,$officecd,$poststatus,$mob_no,$training_desc,$venuename,$venue_add,$training_dt,$training_time,$forpc,$pcname,$forsubdivision,$epic,$acno,$partno,$slno,$bank_name,$branch_name,$bank_acc_no,$ifsc_code,$token)
{
	$sql="insert into first_rand_table (officer_name,person_desig,personcd,office,address,block_muni,postoffice,subdivision,policestation, district,pin,officecd,poststatus,mob_no,training_desc,venuename,venueaddress,training_dt,training_time,pc_code,pc_name,forsubdivision,epic,acno,partno,slno,bank,branch,bank_accno,ifsc,token) values ('$officer_name','$person_desig','$personcd','$office','$office_address','$block_muni','$postoffice','$subdivision','$policestation','$district','$pin','$officecd','$poststatus','$mob_no','$training_desc','$venuename','$venue_add','$training_dt','$training_time','$forpc','$pcname','$forsubdivision','$epic','$acno','$partno','$slno','$bank_name','$branch_name','$bank_acc_no','$ifsc_code','$token')";
	
	$rs=execInsert($sql);
	connection_close();
	//return $rs;
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
    personnela.forsubdivision where personnela.forsubdivision='$sub_div' and personnela.selected=1 ";
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
	  office.blockormuni_cd,
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
	Where personnela.forsubdivision = '$sub_div' And personnela.selected = 1 ";
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
/*function first_appointment_letter3_subdiv($sub_div,$post_stat)
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
	  where personnela.forsubdivision='$sub_div' and personnela.selected='1' and personnela.poststat='$post_stat' ";
	$sql.=" order by office.subdivisioncd,office.blockormuni_cd,office.officecd, personnela.personcd,
	  poststat.poststatus, personnela.off_desg";
	print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}*/
/***************populate for pp************************/
function delete_prev_data_app3($sub_div,$post_stat)
{
	//echo $post_stat;
	//$post_stat1=mysql_real_escape_string($post_stat);
	$sql="Delete F from first_rand_table F
	Inner Join personnela On personnela.personcd = F.personcd 
	where personnela.selected = 1 and (personnela.ttrgschcopy is Null or personnela.ttrgschcopy='0') and personnela.forsubdivision='$sub_div' and F.poststatus='$post_stat'";
	//delete from first_rand_table where forsubdivision='$sub_div' and poststatus='$post_stat'";
	$i=execDelete($sql);
	connection_close();
	return $i;
}
/*function first_appointment_letter3($sub_div,$post_stat)
{
	$sql="Select Distinct personnela.officer_name,
	  personnela.off_desg As person_desig,
	  personnela.personcd,
	  office.officer_desg As officer_desig,
	  office.office,
	  office.address1,
	  office.address2,
	  office.blockormuni_cd,
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
}*/
function first_appointment_letter3($sub_div,$post_stat,$post_stat1)
{
	$sql="insert into first_rand_table (officer_name,person_desig,personcd,office,address,block_muni,block_muni_name,postoffice,subdivision,policestation, district,pin,officecd,poststatus,mob_no,training_desc,venuename,venueaddress,training_dt,training_time,pc_code,forsubdivision,epic,acno,partno,slno,bank,branch,bank_accno,ifsc,token)";
	
	$sql.="Select Distinct personnela.officer_name,
	  personnela.off_desg As person_desig,
	  personnela.personcd,
	  office.office,
	  concat(office.address1,',',office.address2),
	  office.blockormuni_cd,
	  block_muni.blockmuni,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  office.officecd,
	  poststat.poststatus,
	  personnela.mob_no,
	  
	  training_type.training_desc,
	  training_venue.venuename,
	  concat(training_venue.venueaddress1,',',training_venue.venueaddress2),
	  Date_Format(training_schedule.training_dt, '%d/%m/%Y') As training_dt,
	  training_schedule.training_time,
	  
	  personnela.forpc,
	  personnela.forsubdivision,
	  
	  personnela.epic,
	  personnela.acno,
	  personnela.partno,
	  personnela.slno,
	   
	  bank.bank_name,
	  branch.branch_name,
	  personnela.bank_acc_no,
	  branch.ifsc_code,
	 
	  REPLACE(concat(SUBSTRING(subdivision1.subdivisioncd,1,4),'/',poststat.post_stat,'/',training_pp.token),'','') 
 as r_token
	  
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Inner Join block_muni On office.blockormuni_cd = block_muni.blockminicd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Inner Join training_pp On personnela.personcd = training_pp.per_code
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  
	  Left Join bank On personnela.bank_cd = bank.bank_cd
	  Left Join branch On personnela.branchcd = branch.branchcd And
		personnela.bank_cd = branch.bank_cd
	  Inner Join training_type On training_type.training_code =
		training_pp.training_type
	  Left Join training_schedule On training_schedule.schedule_code =
		training_pp.training_sch
	  Left Join training_venue On training_venue.venue_cd =
		training_schedule.training_venue
	  Inner Join subdivision subdivision1 On training_pp.for_subdivision =
		subdivision1.subdivisioncd
	Where personnela.forsubdivision = '$sub_div' and (personnela.ttrgschcopy is Null or personnela.ttrgschcopy='0') And personnela.selected = 1 and personnela.poststat='$post_stat'";
//	if($office!='0')
//	$sql.=" and office.officecd='$office'";
	$sql.=" order by office.subdivisioncd,office.blockormuni_cd,office.officecd, personnela.personcd,
	  poststat.poststatus, personnela.off_desg";
	//print $sql; exit;
	execSelect($sql);
	
	 $cntsql="Select count(*) as cnt from first_rand_table 
	  Inner Join personnela On personnela.personcd = first_rand_table.personcd
		where first_rand_table.forsubdivision='$sub_div' and (personnela.ttrgschcopy is Null or personnela.ttrgschcopy='0') And personnela.selected = 1 and first_rand_table.poststatus='$post_stat1' ";
    $countrs=execSelect($cntsql);
	$crow=getRows($countrs);
	$cd_cnt=$crow['cnt'];
	
	connection_close();
	return $cd_cnt;
}
/////////////populate for extra pp
function delete_prev_data_app3_extra($phase,$subdivision)
{
	$sql="Delete F from first_rand_table F
	Inner Join personnela On personnela.personcd = F.personcd 
	where personnela.selected = 1 and personnela.ttrgschcopy='$phase' and personnela.booked='P' and personnela.forsubdivision='$subdivision'";
	$i=execDelete($sql);
	connection_close();
	return $i;
}
function first_appointment_letter3_extra($phase,$subdivision)
{
	$sql="insert into first_rand_table (officer_name,person_desig,personcd,office,address,block_muni,block_muni_name,postoffice,subdivision,policestation, district,pin,officecd,poststatus,mob_no,training_desc,venuename,venueaddress,training_dt,training_time,pc_code,forsubdivision,epic,acno,partno,slno,bank,branch,bank_accno,ifsc,token)";
	
	$sql.="Select Distinct personnela.officer_name,
	  personnela.off_desg As person_desig,
	  personnela.personcd,
	  office.office,
	  concat(office.address1,',',office.address2),
	  office.blockormuni_cd,
	  block_muni.blockmuni,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  office.officecd,
	  poststat.poststatus,
	  personnela.mob_no,
	  
	  training_type.training_desc,
	  training_venue.venuename,
	  concat(training_venue.venueaddress1,',',training_venue.venueaddress2),
	  Date_Format(training_schedule.training_dt, '%d/%m/%Y') As training_dt,
	  training_schedule.training_time,
	  
	  personnela.forpc,
	  personnela.forsubdivision,
	  
	  personnela.epic,
	  personnela.acno,
	  personnela.partno,
	  personnela.slno,
	   
	  bank.bank_name,
	  branch.branch_name,
	  personnela.bank_acc_no,
	  branch.ifsc_code,
	 
	  REPLACE(concat(SUBSTRING(subdivision1.subdivisioncd,1,4),'/',poststat.post_stat,'/',training_pp.token),'','') 
 as r_token
	  
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Inner Join block_muni On office.blockormuni_cd = block_muni.blockminicd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Inner Join training_pp On personnela.personcd = training_pp.per_code
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  
	  Left Join bank On personnela.bank_cd = bank.bank_cd
	  Left Join branch On personnela.branchcd = branch.branchcd And
		personnela.bank_cd = branch.bank_cd
	  Inner Join training_type On training_type.training_code =
		training_pp.training_type
	  Left Join training_schedule On training_schedule.schedule_code =
		training_pp.training_sch
	  Left Join training_venue On training_venue.venue_cd =
		training_schedule.training_venue
	  Inner Join subdivision subdivision1 On training_pp.for_subdivision =
		subdivision1.subdivisioncd
	Where personnela.selected = 1 and personnela.ttrgschcopy='$phase' and personnela.booked='P' and personnela.forsubdivision='$subdivision'";
//	if($office!='0')
//	$sql.=" and office.officecd='$office'";
	$sql.=" order by office.subdivisioncd,office.blockormuni_cd,office.officecd, personnela.personcd,
	  poststat.poststatus, personnela.off_desg";
	//print $sql; exit;
	execSelect($sql);
	
	 $cntsql="Select count(*) as cnt from first_rand_table 
	 Inner Join personnela On personnela.personcd = first_rand_table.personcd
		where personnela.selected = 1 and personnela.ttrgschcopy='$phase' and personnela.booked='P' and personnela.forsubdivision='$subdivision'";
    $countrs=execSelect($cntsql);
	$crow=getRows($countrs);
	$cd_cnt=$crow['cnt'];
	
	connection_close();
	return $cd_cnt;
}
/*function first_app_letter3_print($sub_div)
{
	$sql1="Update first_rand_table set sl_no=NULL where first_rand_table.forsubdivision = '$sub_div'";
	execUpdate($sql1);
/*	$sql="Select Distinct first_rand_table.officer_name,first_rand_table.person_desig,first_rand_table.personcd,
	  first_rand_table.office,first_rand_table.address,first_rand_table.postoffice,first_rand_table.subdivision,first_rand_table.policestation,first_rand_table.district,first_rand_table.pin,
	  first_rand_table.officecd,first_rand_table.mob_no,first_rand_table.poststatus,first_rand_table.acno,first_rand_table.partno,first_rand_table.slno,first_rand_table.epic,first_rand_table.pc_code as forpc,first_rand_table.pc_name as pcname,
	  first_rand_table.bank as bank_name,first_rand_table.branch as branch_name,first_rand_table.bank_accno as bank_acc_no,
	  first_rand_table.ifsc as ifsc_code,first_rand_table.training_desc,
	  first_rand_table.venuename,first_rand_table.venueaddress,first_rand_table.training_dt,first_rand_table.training_time,
	  first_rand_table.forsubdivision,first_rand_table.token,first_rand_table.poststatus as post_stat
	From first_rand_table 
	Where substr(first_rand_table.officecd,1,4) = '$sub_div'";
	$sql.=" order by first_rand_table.block_muni,first_rand_table.officecd, first_rand_table.personcd, first_rand_table.poststatus, first_rand_table.person_desig";*/
	
	/*$sql="Select Distinct first_rand_table.officer_name,first_rand_table.person_desig,first_rand_table.personcd, first_rand_table.office,first_rand_table.address,first_rand_table.postoffice,first_rand_table.subdivision,first_rand_table.policestation,first_rand_table.district,first_rand_table.pin, first_rand_table.officecd,first_rand_table.mob_no,first_rand_table.poststatus,first_rand_table.acno,first_rand_table.partno,first_rand_table.slno,first_rand_table.epic,first_rand_table.pc_code as forpc,first_rand_table.pc_name as pcname, first_rand_table.bank as bank_name,first_rand_table.branch as branch_name,first_rand_table.bank_accno as bank_acc_no, first_rand_table.ifsc as ifsc_code From first_rand_table 
	Where first_rand_table.forsubdivision = '$sub_div'";
	$sql.=" order by first_rand_table.block_muni,first_rand_table.officecd, first_rand_table.personcd, first_rand_table.poststatus, first_rand_table.person_desig";
	//echo $sql;
	//exit;
	$rs=execSelect($sql);	
	connection_close();
	return $rs;
}*/
function first_app_letter3_print_extra($sub,$phase)
{
	
	$sql="Update first_rand_table 
	Inner Join personnela On personnela.personcd = first_rand_table.personcd
	set sl_no=NULL
	where personnela.selected = 1 and personnela.ttrgschcopy='$phase' and personnela.booked='P' and personnela.forsubdivision='$sub';";
	$sql.="SET @ordering = 0;";
    $sql.="UPDATE first_rand_table
	        Inner Join personnela On personnela.personcd = first_rand_table.personcd
             SET sl_no = (@ordering := @ordering + 1) ";
	$sql.=" where personnela.selected = 1 and personnela.ttrgschcopy='$phase' and personnela.booked='P' and and personnela.forsubdivision='$sub'";
	//$sql.=" order by first_rand_table.block_muni,first_rand_table.officecd, first_rand_table.personcd, first_rand_table.poststatus, first_rand_table.person_desig";

	execMultiQuery($sql);	
	connection_close();	
	
	return 1;
}
function first_app_letter3_max_slno_extra($sub,$phase)
{
	$sql="select count(*) as slno From first_rand_table 
	Inner Join personnela On personnela.personcd = first_rand_table.personcd
	where personnela.selected = 1 and personnela.ttrgschcopy='$phase' and personnela.booked='P' and personnela.forsubdivision='$sub'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['slno'];
	connection_close();
	return $i;
}
///***********************///print appt letter for PP/////////********************////////
function first_app_letter3_print($sub_div)
{
	
	$sql="Update first_rand_table 
	set sl_no=NULL where first_rand_table.forsubdivision = '$sub_div';";
	$sql.="SET @ordering = 0;";
    $sql.="UPDATE first_rand_table
	 SET sl_no = (@ordering := @ordering + 1) ";
	$sql.=" Where first_rand_table.forsubdivision = '$sub_div' order by first_rand_table.block_muni,first_rand_table.officecd";
	
	execMultiQuery($sql);	
	connection_close();	
	
	return 1;
}
function first_app_letter3_max_slno($subdiv)
{
	$sql="select count(*) as slno From  first_rand_table
	 where first_rand_table.forsubdivision = '$subdiv'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['slno'];
	connection_close();
	return $i;
}
//===============draft subdivision wise=======================//
function first_app_letter3_print_draft($sub_div)
{
	
	$sql="Update first_rand_table 
	set sl_no=NULL where substr(first_rand_table.officecd,1,4) = '$sub_div';";
	$sql.="SET @ordering = 0;";
    $sql.="UPDATE first_rand_table
	 SET sl_no = (@ordering := @ordering + 1) ";
	$sql.=" Where substr(first_rand_table.officecd,1,4) = '$sub_div'";
	$sql.=" order by first_rand_table.block_muni,first_rand_table.officecd";
	
	execMultiQuery($sql);	
	connection_close();	
	
	return 1;
}
function first_app_letter3_max_slno_draft($subdiv)
{
	$sql="select count(*) as slno From  first_rand_table
	 where substr(first_rand_table.officecd,1,4) = '$subdiv'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['slno'];
	connection_close();
	return $i;
}
/*function first_app_letter3_print($sub_div)
{
	
	//$sql.="SET @ordering = 0;";
   /* $sql.="UPDATE first_rand_table
	 Inner Join personnela On personnela.personcd = first_rand_table.personcd 
	 SET sl_no = (@ordering := @ordering + 1) ";
	$sql.=" Select @ordering := @ordering + 1 sl_no from first_rand_table,
	(Select @ordering:= 0) as o
	Inner Join personnela On personnela.personcd = first_rand_table.personcd 
	Where first_rand_table.forsubdivision = '$sub_div' and (personnela.ttrgschcopy is Null or personnela.ttrgschcopy=0)";
	$sql.=" order by first_rand_table.block_muni,first_rand_table.officecd, first_rand_table.personcd, first_rand_table.poststatus, first_rand_table.person_desig";
   echo $sql;
   exit;
	execMultiQuery($sql);	
	connection_close();	
	
	return 1;
}*/

//ofc wise
function first_appointment_letter_ofcwise_percd($subdiv,$office,$percd)
{
	$sql="Select first_rand_table.officer_name,first_rand_table.person_desig,first_rand_table.personcd,
	  first_rand_table.office,first_rand_table.address,first_rand_table.postoffice,first_rand_table.subdivision,first_rand_table.policestation,first_rand_table.district,first_rand_table.pin,
	  first_rand_table.officecd,first_rand_table.mob_no,first_rand_table.poststatus,first_rand_table.acno,first_rand_table.partno,first_rand_table.slno,first_rand_table.epic,first_rand_table.pc_code as forpc,first_rand_table.pc_name as pcname,
	  first_rand_table.bank as bank_name,first_rand_table.branch as branch_name,first_rand_table.bank_accno as bank_acc_no,
	  first_rand_table.ifsc as ifsc_code,first_rand_table.training_desc,
	  first_rand_table.venuename,first_rand_table.venueaddress,first_rand_table.training_dt,first_rand_table.training_time,
	  first_rand_table.forsubdivision,first_rand_table.token,first_rand_table.poststatus as post_stat,first_rand_table.block_muni_name
	From first_rand_table 
	
	Where 1=1 ";
	if($subdiv!='' && $subdiv!='0')
		$sql.=" and  substr(first_rand_table.officecd,1,4) = '$subdiv'";
	if($office!='' && $office!='0')
		$sql.=" and first_rand_table.officecd = '$office'";
	if($percd!='' && $percd!='0')
		$sql.=" and first_rand_table.personcd = '$percd'";
	$sql.=" group by first_rand_table.personcd";	
	$sql.=" order by first_rand_table.block_muni,first_rand_table.officecd, first_rand_table.personcd, first_rand_table.poststatus, first_rand_table.person_desig";
	//echo $sql;
	//exit;
	$rs=execSelect($sql);
	
	connection_close();
	return $rs;
}
//ofc wise mb
function fetch_mobileno_ofc_wise($ofc)
{
	$sql="select mobileno from sub_mobile where sub_mobile.subdivisioncd = substr($ofc,1,4)";
	//echo $sql;
	//exit;
	$rs=execSelect($sql);
	$row=getRows($rs);
	$mb=$row['mobileno'];
	connection_close();
	return $mb;
}
//excel format
function first_appointment_letter_excel($subdiv,$from,$to)
{
	$sql="Select first_rand_table.officer_name,first_rand_table.person_desig,first_rand_table.personcd,
	  first_rand_table.office,first_rand_table.address,first_rand_table.postoffice,first_rand_table.subdivision,first_rand_table.policestation,first_rand_table.district,first_rand_table.pin,
	  first_rand_table.officecd,first_rand_table.mob_no,first_rand_table.poststatus,first_rand_table.acno,first_rand_table.partno,first_rand_table.slno,first_rand_table.epic,first_rand_table.pc_code as forpc,first_rand_table.pc_name as pcname,
	  first_rand_table.bank as bank_name,first_rand_table.branch as branch_name,first_rand_table.bank_accno as bank_acc_no,
	  first_rand_table.ifsc as ifsc_code,first_rand_table.training_desc,
	  first_rand_table.venuename,first_rand_table.venueaddress,first_rand_table.training_dt,first_rand_table.training_time,
	  first_rand_table.forsubdivision,first_rand_table.token,first_rand_table.poststatus as post_stat,first_rand_table.block_muni_name
	From first_rand_table 
	
	Where 1=1 ";
	if($subdiv!='' && $subdiv!='0')
		$sql.=" and  first_rand_table.forsubdivision = '$subdiv'";
	$sql.=" group by first_rand_table.personcd";	
	$sql.=" order by sl_no limit $from,$to";
	$rs=execSelect($sql);
	
	connection_close();
	return $rs;
}
/***************************draft subdiv wsie (excel)****************************/
function first_appointment_letter_excel_draft($subdiv,$from,$to)
{
	$sql="Select first_rand_table.officer_name,first_rand_table.person_desig,first_rand_table.personcd,
	  first_rand_table.office,first_rand_table.address,first_rand_table.postoffice,first_rand_table.subdivision,first_rand_table.policestation,first_rand_table.district,first_rand_table.pin,
	  first_rand_table.officecd,first_rand_table.mob_no,first_rand_table.poststatus,first_rand_table.acno,first_rand_table.partno,first_rand_table.slno,first_rand_table.epic,first_rand_table.pc_code as forpc,first_rand_table.pc_name as pcname,
	  first_rand_table.bank as bank_name,first_rand_table.branch as branch_name,first_rand_table.bank_accno as bank_acc_no,
	  first_rand_table.ifsc as ifsc_code,first_rand_table.training_desc,
	  first_rand_table.venuename,first_rand_table.venueaddress,first_rand_table.training_dt,first_rand_table.training_time,
	  first_rand_table.forsubdivision,first_rand_table.token,first_rand_table.poststatus as post_stat,first_rand_table.block_muni_name
	From first_rand_table 
	
	Where 1=1 ";
	if($subdiv!='' && $subdiv!='0')
		$sql.=" and  substr(first_rand_table.officecd,1,4) = '$subdiv'";
	$sql.=" group by first_rand_table.personcd";	
	$sql.=" order by sl_no limit $from,$to";
	$rs=execSelect($sql);
	
	connection_close();
	return $rs;
}
//sub_div wise pdf
function first_app_letter3_print1($sub_div,$from,$to)
{
	$sql="Select Distinct first_rand_table.officer_name,first_rand_table.person_desig,first_rand_table.personcd,
	  first_rand_table.office,first_rand_table.address,first_rand_table.postoffice,first_rand_table.subdivision,first_rand_table.policestation,first_rand_table.district,first_rand_table.pin,
	  first_rand_table.officecd,first_rand_table.mob_no,first_rand_table.poststatus,first_rand_table.acno,first_rand_table.partno,first_rand_table.slno,first_rand_table.epic,first_rand_table.pc_code as forpc,first_rand_table.pc_name as pcname,
	  first_rand_table.bank as bank_name,first_rand_table.branch as branch_name,first_rand_table.bank_accno as bank_acc_no,
	  first_rand_table.ifsc as ifsc_code,first_rand_table.training_desc,
	  first_rand_table.venuename,first_rand_table.venueaddress,first_rand_table.training_dt,first_rand_table.training_time,
	  first_rand_table.forsubdivision,first_rand_table.token,first_rand_table.poststatus as post_stat,first_rand_table.block_muni_name
	From first_rand_table 
	Where first_rand_table.forsubdivision = '$sub_div'";
	$sql.=" group by first_rand_table.personcd";	
	$sql.=" order by sl_no limit $from,$to";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
/***********************************draft subdivision wise*****************/
function first_app_letter3_print1_draft($sub_div,$from,$to)
{
	$sql="Select Distinct first_rand_table.officer_name,first_rand_table.person_desig,first_rand_table.personcd,
	  first_rand_table.office,first_rand_table.address,first_rand_table.postoffice,first_rand_table.subdivision,first_rand_table.policestation,first_rand_table.district,first_rand_table.pin,
	  first_rand_table.officecd,first_rand_table.mob_no,first_rand_table.poststatus,first_rand_table.acno,first_rand_table.partno,first_rand_table.slno,first_rand_table.epic,first_rand_table.pc_code as forpc,first_rand_table.pc_name as pcname,
	  first_rand_table.bank as bank_name,first_rand_table.branch as branch_name,first_rand_table.bank_accno as bank_acc_no,
	  first_rand_table.ifsc as ifsc_code,first_rand_table.training_desc,
	  first_rand_table.venuename,first_rand_table.venueaddress,first_rand_table.training_dt,first_rand_table.training_time,
	  first_rand_table.forsubdivision,first_rand_table.token,first_rand_table.poststatus as post_stat,first_rand_table.block_muni_name
	From first_rand_table 
	Inner Join replacement_log_pregroup on replacement_log_pregroup.new_personnel=first_rand_table.personcd
	Where substr(first_rand_table.officecd,1,4) = '$sub_div'
	and date(replacement_log_pregroup.posted_date)>='2016-03-17' 
	and date(replacement_log_pregroup.posted_date)<='2016-03-18'";
	$sql.=" group by first_rand_table.personcd";	
	$sql.=" order by block_muni,officecd limit $from,$to";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//phase wise extra
//excel///
function first_app_letter3_print1_extra_excel($subdiv,$phase,$from,$to)
{
	$sql="Select Distinct first_rand_table.officer_name,first_rand_table.person_desig,first_rand_table.personcd,
	  first_rand_table.office,first_rand_table.address,first_rand_table.postoffice,first_rand_table.subdivision,first_rand_table.policestation,first_rand_table.district,first_rand_table.pin,
	  first_rand_table.officecd,first_rand_table.mob_no,first_rand_table.poststatus,first_rand_table.acno,first_rand_table.partno,first_rand_table.slno,first_rand_table.epic,first_rand_table.pc_code as forpc,first_rand_table.pc_name as pcname,
	  first_rand_table.bank as bank_name,first_rand_table.branch as branch_name,first_rand_table.bank_accno as bank_acc_no,
	  first_rand_table.ifsc as ifsc_code,first_rand_table.training_desc,
	  first_rand_table.venuename,first_rand_table.venueaddress,first_rand_table.training_dt,first_rand_table.training_time,
	  first_rand_table.forsubdivision,first_rand_table.token,first_rand_table.poststatus as post_stat,first_rand_table.block_muni_name
	From first_rand_table 
	Inner Join personnela On personnela.personcd = first_rand_table.personcd
	where personnela.selected = 1 and personnela.ttrgschcopy='$phase' and personnela.booked='P' and personnela.forsubdivision='$subdiv'";
	$sql.=" group by first_rand_table.personcd";	
	$sql.=" order by sl_no limit $from,$to";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//pdf//
function first_app_letter3_print1_extra($subdiv,$phase,$from,$to)
{
	$sql="Select Distinct first_rand_table.officer_name,first_rand_table.person_desig,first_rand_table.personcd,
	  first_rand_table.office,first_rand_table.address,first_rand_table.postoffice,first_rand_table.subdivision,first_rand_table.policestation,first_rand_table.district,first_rand_table.pin,
	  first_rand_table.officecd,first_rand_table.mob_no,first_rand_table.poststatus,first_rand_table.acno,first_rand_table.partno,first_rand_table.slno,first_rand_table.epic,first_rand_table.pc_code as forpc,first_rand_table.pc_name as pcname,
	  first_rand_table.bank as bank_name,first_rand_table.branch as branch_name,first_rand_table.bank_accno as bank_acc_no,
	  first_rand_table.ifsc as ifsc_code,first_rand_table.training_desc,
	  first_rand_table.venuename,first_rand_table.venueaddress,first_rand_table.training_dt,first_rand_table.training_time,
	  first_rand_table.forsubdivision,first_rand_table.token,first_rand_table.poststatus as post_stat,first_rand_table.block_muni_name
	From first_rand_table 
	Inner Join personnela On personnela.personcd = first_rand_table.personcd
	where personnela.selected = 1 and personnela.ttrgschcopy='$phase' and personnela.booked='P' and personnela.forsubdivision='$subdiv'";
	$sql.=" group by first_rand_table.personcd";	
	$sql.=" order by sl_no limit $from,$to";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fetch_ppwise_training($per_cd)
{
	$sql="select first_rand_table.training_desc,	  first_rand_table.venuename,first_rand_table.venueaddress,first_rand_table.training_dt,first_rand_table.training_time From first_rand_table 
	Where first_rand_table.personcd = '$per_cd' order by first_rand_table.training_desc";
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
	
	  dcrcmaster.dc_venue,
	  dcrcmaster.dc_addr,
	  Date_Format(dcrc_party.dc_date, '%d/%m/%Y') As dc_date,
	  dcrc_party.dc_time,
	  dcrcmaster.rcvenue
	From personnela

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
	$sql.=" order by personnela.forassembly,personnela.groupid";
	//echo $sql;
//	exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//venue wise party
function master_roll_second_app_venue_wise_party($forassembly,$subdiv)
{
		$sql="Select distinct second_appt.assembly,second_appt.assembly_name,second_appt.training_venue,
	  second_appt.venue_addr1,
	  second_appt.venue_addr2,
	  second_appt.training_date,
	  second_appt.training_time,
	  second_appt.venuecode
	From second_appt
where   second_appt.venuecode is not Null ";
      if($forassembly!='' && $forassembly!=null && $forassembly!=0)
		$sql.=" and second_appt.assembly='$forassembly'";
	if($subdiv!='' && $subdiv!=null)
		$sql.=" and second_appt.subdivcd='$subdiv'";
	$sql.=" order by second_appt.venuecode";
	//echo $sql;
	//exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}

function master_roll_second_app_venue_wise_party_group($venue_cd,$assembly)
{
	$sql="Select Distinct second_appt.groupid,
	second_appt.assembly	  
	From second_appt
	Where second_appt.groupid Is Not Null And second_appt.groupid != '0' and second_appt.assembly='$assembly'";
	if($venue_cd!='' && $venue_cd!=null)
		$sql.=" and second_appt.venuecode='$venue_cd'";
	$sql.=" order by second_appt.assembly,CAST(second_appt.groupid AS UNSIGNED)";
	//echo $sql;
	//exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//master roll report second appt party
function master_roll_second_app_hrd($forassembly,$forpc,$group_id)
{
	$sql="Select Distinct personnela.groupid,
	personnela.forassembly	  
	From personnela
	Where personnela.groupid Is Not Null And personnela.groupid != '0' and personnela.booked='P'";
	if($forassembly!='' && $forassembly!=null && $forassembly!=0)
		$sql.=" and personnela.forassembly='$forassembly'";
	elseif($forpc!='' && $forpc!=null && $forpc!=0)
		$sql.=" and personnela.forpc='$forpc'";
	if($group_id!='' && $group_id!=null)
		$sql.=" and personnela.groupid='$group_id'";
	$sql.=" order by personnela.forassembly,personnela.groupid";
	//echo $sql;
//	exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//master roll second appoint letter party
function master_roll_second_appointment_letter($group_id,$forassembly)
{
	$sql="Select personnela.groupid,
	  assembly.assemblycd,
	  assembly.assemblyname,
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
	  poststat.poststatus,
	  personnela.off_desg
	From personnela
	  Inner Join office On personnela.officecd = office.officecd
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	  Inner Join subdivision On subdivision.subdivisioncd = office.subdivisioncd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Left Join assembly On personnela.forassembly = assembly.assemblycd 
	    and personnela.forsubdivision = assembly.subdivisioncd";
	$sql.=" where personnela.groupid='$group_id' and personnela.forassembly='$forassembly' and personnela.booked='P'";
	$sql.=" order by personnela.groupid, personnela.poststat";
//		print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
/*function second_appointment_letter($group_id,$forassembly)
{
	$sql="Select personnela.groupid,
	  assembly.assemblycd,
	  assembly.assemblyname,
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
	  Left Join assembly On personnela.forassembly = assembly.assemblycd
	  Inner Join dcrcmaster On personnela.forassembly = dcrcmaster.assemblycd
	  Inner Join dcrc_party On dcrc_party.dcrcgrp = dcrcmaster.dcrcgrp ";
	$sql.=" where personnela.groupid='$group_id' and personnela.forassembly='$forassembly' and personnela.booked='P'";
	$sql.=" order by personnela.groupid, personnela.poststat";
//		print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}*/
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
//Venue wise reserve
function venue_wise_second_reserve1($forassembly,$subdiv)
{
		$sql="Select distinct second_rand_table_reserve.assemblycd,second_rand_table_reserve.assembly,second_rand_table_reserve.training_venue,
	  second_rand_table_reserve.venue_addr1,
	  second_rand_table_reserve.venue_addr2,
	  second_rand_table_reserve.training_date,
	  second_rand_table_reserve.training_time,
	  second_rand_table_reserve.venuecode
	From second_rand_table_reserve
where   second_rand_table_reserve.venuecode is not Null ";
      if($forassembly!='' && $forassembly!=null && $forassembly!=0)
		$sql.=" and second_rand_table_reserve.assemblycd='$forassembly'";
	if($subdiv!='' && $subdiv!=null)
		$sql.=" and second_rand_table_reserve.subdivisioncd='$subdiv'";
	$sql.=" order by second_rand_table_reserve.venuecode";
	//echo $sql;
	//exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function second_app_venue_wise_reserve_group($venue_cd,$post_status,$forassembly)
{
	$sql="Select personnela.groupid,
	  assembly.assemblycd,
	  assembly.assemblyname,
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
	  personnela.poststat,
	  personnela.off_desg,
	  personnela.dcrccd,
	  poststat.poststatus
	From personnela
	  Inner Join office On personnela.officecd = office.officecd
	  Inner Join subdivision On subdivision.subdivisioncd = office.subdivisioncd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd        
	  
	  Left Join assembly On personnela.forassembly = assembly.assemblycd
	       and personnela.forsubdivision = assembly.subdivisioncd
	  Inner Join poststat On personnela.poststat = poststat.post_stat 
	  Inner Join second_rand_table_reserve On personnela.personcd = second_rand_table_reserve.	personcd ";
	$sql.=" where personnela.booked='R'";
	if($forassembly!='' && $forassembly!='0')
	    $sql.=" and personnela.forassembly='$forassembly'";
	if($post_status!='' && $post_status!='0')
    	$sql.=" and personnela.poststat='$post_status'";
	if($venue_cd!='' && $venue_cd!='0')
    	$sql.=" and second_rand_table_reserve.venuecode='$venue_cd'";

	$sql.=" order by personnela.forassembly, poststat.post_stat";
	//print $sql; exit;
	$rs=execSelect($sql);
	connection_close();       
	return $rs;
}
//===================== Reserve ========================
function master_roll_second_appointment_letter_reserve1($subdiv,$forassembly,$post_status)
{
	$sql="Select personnela.groupid,
	
	  assembly.assemblycd,
	  assembly.assemblyname,
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
	  personnela.poststat,
	  personnela.off_desg,
	  personnela.dcrccd,
	  poststat.poststatus
	From personnela
	  Inner Join office On personnela.officecd = office.officecd
	  Inner Join subdivision On subdivision.subdivisioncd = office.subdivisioncd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd        
	  
	  Left Join assembly On personnela.forassembly = assembly.assemblycd
	       and personnela.forsubdivision = assembly.subdivisioncd
	  Inner Join poststat On personnela.poststat = poststat.post_stat ";
	$sql.=" where personnela.booked='R'";
	if($forassembly!='' && $forassembly!=0)
	    $sql.=" and personnela.forassembly='$forassembly'";
	//if($forpc!='' && $forpc!=0)
		//$sql.=" and personnela.forpc='$forpc'";
	if($post_status!='' && $post_status!='0')
    	$sql.=" and personnela.poststat='$post_status'";

	$sql.=" order by personnela.forassembly, poststat.post_stat";
	//print $sql; exit;
	$rs=execSelect($sql);
	connection_close();       
	return $rs;
}
function master_roll_second_app_hrd_reserve($group_id,$forassembly,$forpc)
{
	$sql="Select Distinct personnela.groupid,
	personnela.forassembly	  
	From personnela
	Where personnela.groupid Is Not Null And personnela.groupid != '0' and personnela.booked='R'";
	if($forassembly!='' && $forassembly!=null && $forassembly!=0)
		$sql.=" and personnela.forassembly='$forassembly'";
	elseif($forpc!='' && $forpc!=null && $forpc!=0)
		$sql.=" and personnela.forpc='$forpc'";
	if($group_id!='' && $group_id!=null)
		$sql.=" and personnela.groupid='$group_id'";
	$sql.=" order by personnela.forassembly,personnela.groupid";
	//echo $sql;
//	exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function master_roll_second_appointment_letter_reserve($group_id,$forassembly,$forpc)
{


	$sql="Select personnela.groupid,
	  assembly.assemblycd,
	  assembly.assemblyname,
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
	  personnela.poststat,
	  personnela.off_desg,
	  personnela.dcrccd,
	  poststat.poststatus
	From personnela
	  Inner Join office On personnela.officecd = office.officecd
	  Inner Join subdivision On subdivision.subdivisioncd = office.subdivisioncd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd        
	 
	  Left Join assembly On personnela.forassembly = assembly.assemblycd
	  Inner Join poststat On personnela.poststat = poststat.post_stat ";
	$sql.=" where personnela.booked='R'";
	if($forassembly!='' && $forassembly!=0)
		{ $sql.=" and personnela.forassembly='$forassembly'";
//echo 'test '.$forpc.$forassembly.$group_id;
}
	if($forpc!='' && $forpc!=0)
		{$sql.=" and personnela.forpc='$forpc'";
		//echo $forpc.$forassembly.$group_id;
                 }
	if($group_id!='')
{		$sql.=" and personnela.groupid='$group_id'";
//echo $forpc.$forassembly.$group_id;
}
	$sql.=" order by personnela.forassembly,poststat.post_stat";
	//print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
        
	return $rs;
}

/*function second_appointment_letter_reserve($group_id,$forassembly,$forpc)
{


	$sql="Select personnela.groupid,
	  assembly.assemblycd,
	  assembly.assemblyname,
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
	  dcrc_party.dc_date As dc_dateD,
	  dcrc_party.dc_time,
	  dcrcmaster.rcvenue,
	  personnela.poststat,
	  personnela.off_desg,
	  personnela.dcrccd,
	  poststat.poststatus
	From personnela
	  Inner Join office On personnela.officecd = office.officecd
	  Inner Join subdivision On subdivision.subdivisioncd = office.subdivisioncd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd        
	 
	  Left Join assembly On personnela.forassembly = assembly.assemblycd
	  Inner Join dcrcmaster On personnela.dcrccd = dcrcmaster.dcrcgrp
	  Inner Join dcrc_party On dcrc_party.dcrcgrp = dcrcmaster.dcrcgrp
	  Inner Join poststat On personnela.poststat = poststat.post_stat ";
	$sql.=" where personnela.booked='R'";
	if($forassembly!='' && $forassembly!=0)
		{ $sql.=" and personnela.forassembly='$forassembly'";
//echo 'test '.$forpc.$forassembly.$group_id;
}
	if($forpc!='' && $forpc!=0)
		{$sql.=" and personnela.forpc='$forpc'";
		//echo $forpc.$forassembly.$group_id;
                 }
	if($group_id!='')
{		$sql.=" and personnela.groupid='$group_id'";
//echo $forpc.$forassembly.$group_id;
}
	$sql.=" order by personnela.forassembly,office.subdivisioncd,office.blockormuni_cd,office.officecd,personnela.groupid, personnela.poststat";
	//print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
        
	return $rs;
}*/
function second_appointment_letter_reserve1($sub,$assembly,$group_id,$from,$to)
{
	$sql="SELECT `slno`,`groupid`,block_muni_cd,block_muni_name,assemblycd,`assembly`,`pcname`,`personcd`,`person_name`,`person_designation`,`post_status`,	
	`post_stat`,`officecd`,`office_name`,`office_address`,`post_office`,`subdivision`,`police_stn`,`district`,
	`pincode`,`dc_venue`,`dc_address`,date_format(`dc_date`,'%d/%m/%Y') as dc_date,`dc_time`,`rc_venue`,`traingcode`,`training_venue`,`venuecode`,
	`venue_addr1`,`venue_addr2`,date_format(`training_date`,'%d/%m/%Y') as training_date,`training_time`,date_format(`polldate`,'%d/%m/%Y') as polldate,`polltime` 
	FROM `second_rand_table_reserve` where 1=1 ";
	if($sub!='0' && $sub!='')
		$sql.=" and subdivisioncd='$sub' ";
	if($assembly!='0' && $assembly!='')
		$sql.=" and assemblycd='$assembly' ";
	if($group_id!='0' && $group_id!='')
		$sql.=" and groupid='$group_id' ";
	if($from!='-1')
		$sql.=" order by slno limit $from,$to";
	else
	    $sql.=" order by slno";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fetch_block_2nd_appt_reserve($bmcode)
{
	$sql="select blockmuni as cnt From block_muni where 1=1 ";
	if($bmcode!='0' && $bmcode!='')
		$sql.=" and block_muni.blockminicd = '$bmcode' ";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['cnt'];
	connection_close();
	return $i;
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
function fetch_polldate_n_time($forpc)
{
	$sql="select date_format(poll_date,'%d/%m/%Y') as poll_date,poll_date as poll_dateD, poll_time from poll_table where pc_cd='$forpc'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function delete_prev_data_second_rand_reserve($forassembly,$forpc,$group_id)
{
	$sql="delete from second_rand_table_reserve where (slno<>0 or slno=0)";
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
//=========================Third app letter print====================
function third_app_print($forassembly)
{
	$sql="Select groupid,psname,psfix
	From pollingstation
	Where 1=1 ";
	if($forassembly!='' && $forassembly!=null && $forassembly!=0)
		$sql.=" and pollingstation.forassembly='$forassembly'";
	//elseif($forpc!='' && $forpc!=null && $forpc!=0)
	//	$sql.=" and personnela.forpc='$forpc'";
//	if($group_id!='' && $group_id!=null)
		//$sql.=" and personnela.groupid='$group_id'";
	$sql.=" order by pollingstation.groupid,pollingstation.psfix";
	//echo $sql;
//	exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//training requirement extra PP
function fatch_personnela_phasetype($sub)
{
	$sql="Select distinct personnela.ttrgschcopy From personnela ";
		$sql.=" where personnela.ttrgschcopy>0 and personnela.ttrgschcopy is not Null and personnela.forsubdivision='$sub'";
	//$sql.=" order by training_venue.venuename";

	$rs=execSelect($sql);
	return $rs;
}
///save sms (first)////
/*function fatch_post_status_for_first_rand($post_stat)
{
	$sql="select poststatus from poststat where post_stat='$post_stat' order by poststatus asc";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$amount=$row['poststatus'];
	connection_close();
	return $amount;
}
function first_rand_member_available($post_stat,$subdiv,$phase,$chkextrapp,$poststatus)
{
	if($chkextrapp=='true')
	{
		
	}
	else
	{
		$sql="SELECT count(personcd) from first_rand_table where forsubdivision='$subdiv'";
		if($group_id!="")
		 $sql.=" and groupid = '$group_id'";
		$rs=execSelect($sql);
		$row=getRows($rs);
		$amount=$row['amount'];
		connection_close();
		return $amount;
	}
}*/
?>