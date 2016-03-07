<?php
include_once('string_fun.php');
function district_name($dist_cd)
{
	$sql="select * from district where districtcd='$dist_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$district=$row['district'];
	connection_close();
	return $district;
}
//========== PC Name ===============
function pc_name($pccd)
{
	$sql="select pccd, pcname from pc where pccd='$pccd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$pc_name=$row['pcname'];
	connection_close();
	return $pc_name;
}
//====================Personnel Function=======================
function check_duplicate_entry($name,$designationOic,$Mb_no,$offccd)
{
	$sql="Select count(*) as cnt from office where office='$name' and officer_desg='$designationOic' and mobile='$Mb_no' and officecd <> '$offccd'";
	//echo $sql;
	//exit();
	$rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['cnt'];
	return $i;
}
function fatch_officecode($sub_div)
{
	$sql;$rs;
	$sql="select * from office";
	if($sub_div!="0" && $sub_div!="")
		$sql.=" where subdivisioncd='$sub_div'";
	$sql.=" order by officecd asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_offcDtl($offccd)
{
	$sql;$rs;
	$sql="Select office.officecd, office.office, office.officer_desg,office.subdivisioncd,
  	office.address1, office.address2, office.postoffice, office.pin, office.blockormuni_cd, office.policestn_cd,
  	office.govt, office.email, office.phone, office.mobile, office.fax, office.tot_staff, office.male_staff, office.female_staff,
  	office.districtcd, office.institutecd,office.ddocode From office";                       
  	$sql.=" where office.officecd='$offccd'";

	$rs=execSelect($sql);
	
	connection_close();
	return $rs;
}

function fatch_offcDtl_policestn_cd($offccd)
{
	$sql;$rs;
	$sql="Select policestn_cd From office";                       
  	$sql.=" where office.officecd='$offccd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$policestn_cd=$row['policestn_cd'];
	connection_close();
	return $policestn_cd;
}
function fatch_personnel_maxcode($subdivisioncd,$police_cd)
{
	$sql;$rs;
	$police_cd.="%";
	$sql="select max(personcd) as personcd from personnel where subdivisioncd='$subdivisioncd' and personcd like '$police_cd'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
/*function fatch_personnel_maxcode($subdivisioncd)
{
	$sql;$rs;
	$sql="select max(personcd) as personcd from personnel where subdivisioncd='$subdivisioncd'";
	//echo $sql;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}*/
function designation_name()
{
	$sql;$rs;
	$sql="select * from designation order by desgcd asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_qualification()
{
	$sql;$rs;
	$sql="select * from qualification order by qualificationcd asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_language()
{
	$sql;$rs;
	$sql="select * from language order by language asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_bank($dist_cd)
{
	$sql;$rs;
	$sql="select * from bank where distcd='$dist_cd' order by bank_name asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_branch($bank_cd)
{
	$sql;$rs;
	$sql="select * from branch where bank_cd='$bank_cd' order by branch_name asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_assembly_all()
{
	$sql;$rs;
	$sql="select * from assembly";
	$sql.=" order by assemblyname asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_assembly_second_rand($dist)
{
	$sql;$rs;
	$sql="Select distinct assembly_party.assemblycd,
	  assembly.assemblyname
	
	From assembly_party
	  Inner Join assembly On assembly_party.assemblycd = assembly.assemblycd
	  Where assembly_party.assemblycd>0 and assembly.districtcd='$dist'";
	$sql.=" order by assemblyname asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_assembly($subdiv)
{
	$sql;$rs;
	$sql="select * from assembly";
	//if($subdiv!='0' || $subdiv!='')
		$sql.=" where subdivisioncd='$subdiv'";
	$sql.=" order by assemblyname asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_pc($subdiv)
{
	$sql;$rs;
	$sql="Select pccd, pcname From pc";
	//if($subdiv!='0' && $subdiv!='')
		$sql.=" where subdivisioncd='$subdiv'";
	$sql.=" order by pcname asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_assembly_ag_pc($pccd,$sub_div)
{
	$sql;$rs;
	$sql="Select assemblycd, assemblyname From assembly where 1=1";
	if($pccd!='0' && $pccd!='')
		$sql.=" and pccd='$pccd'";
	if($sub_div!='0' && $sub_div!='')
		$sql.=" and subdivisioncd='$sub_div'";
	$sql.=" order by assemblyname asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_postingstatus()
{
	$sql="select * from poststat order by poststatus asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_remarks()
{
	$sql="select * from remarks order by remarks asc";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function check_duplicate_personnelrecord($empname,$designation,$dob,$p_id,$epic_no)
{
	$sql="Select count(*) as cnt From personnel where officer_name='$empname' and off_desg='$designation' and dateofbirth='$dob' and personcd<>'$p_id' and epic='$epic_no'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt=$row['cnt'];
	connection_close();
	return $cnt;
}
function save_personnel($p_id,$offcode,$empname,$designation,$preaddress1,$preaddress2,$peraddress1,$peraddress2,$workingstatus,$dob,$sex,$scale,$basicpay,$gradepay,$email,$r_no,$m_no,$qualification,$language,$epic_no,$sl_no,$partno,$posting_status,$ac_pre,$ac_posting,$ac_per,$voterof,$dist_code,$subdiv_cd,$acc_no,$bank,$branch,$remarks,$group,$upload_file,$usercd)
{
	try{
	$sql="insert into personnel (personcd,officecd,officer_name,off_desg,present_addr1,present_addr2,";
	$sql.="perm_addr1,perm_addr2,workingstatus,dateofbirth,gender,scale,basic_pay,grade_pay,email,resi_no, mob_no,";
	$sql.="qualificationcd,languagecd,epic,slno,partno,poststat,assembly_temp,assembly_off,assembly_perm,";
	$sql.="acno,districtcd,subdivisioncd,bank_acc_no,bank_cd,";
	$sql.="branchcd, remarks, pgroup, upload_file, usercode) values (";
	$sql.="'$p_id','$offcode','$empname','$designation','$preaddress1','$preaddress2','$peraddress1',";
	$sql.="'$peraddress2','$workingstatus','$dob','$sex','$scale','$basicpay','$gradepay','$email','$r_no','$m_no',";
	$sql.="'$qualification','$language','$epic_no','$sl_no','$partno','$posting_status','$ac_pre',";
	$sql.="'$ac_posting','$ac_per','$voterof','$dist_code','$subdiv_cd','$acc_no','$bank','$branch','$remarks','$group','$upload_file','$usercd')";
    // echo $sql;
	// exit();
	$i=execInsert($sql);
	connection_close();
	return $i;
	}
	catch(Exception $e)
	{
  		echo "Message: " .$e->getMessage();
  	}
}
function update_personnel($p_id,$offcode,$empname,$designation,$preaddress1,$preaddress2,$peraddress1,$peraddress2,$workingstatus,$dob,$sex,$scale,$basicpay,$gradepay,$email,$r_no,$m_no,$qualification,$language,$epic_no,$sl_no,$partno,$posting_status,$ac_pre,$ac_posting,$ac_per,$voterof,$acc_no,$bank,$branch,$remarks,$group,$upload_file,$usercd,$posted_date)
{
	$sql="update personnel set 
			officecd='$offcode',
			officer_name='$empname',
			off_desg='$designation',
			present_addr1='$preaddress1',
			present_addr2='$preaddress2',
			perm_addr1='$peraddress1',
			perm_addr2='$peraddress2',
			workingstatus='$workingstatus',
			dateofbirth='$dob',
			gender='$sex',
			scale='$scale',
			basic_pay='$basicpay',
			grade_pay='$gradepay',
			email='$email',
			resi_no='$r_no',
			mob_no='$m_no',
			qualificationcd='$qualification',
			languagecd='$language',
			epic='$epic_no',
			slno='$sl_no',
			partno='$partno',	
			poststat='$posting_status',
			assembly_temp='$ac_pre',
			assembly_off='$ac_posting',
			assembly_perm='$ac_per',
			acno='$voterof',
			bank_acc_no='$acc_no',
			bank_cd='$bank',
			branchcd='$branch',	
			remarks='$remarks',
			pgroup='$group',
			upload_file='$upload_file',
			usercode='$usercd',
			posted_date='$posted_date'";
	$sql.="where personcd='$p_id'";
	//echo $sql;
	//exit();
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
function fatch_PersonDetails($p_id)
{
	//$sql; $rs;
	$sql="SELECT personnela.officer_name, personnela.officecd, personnela.off_desg, office.address1, office.address2, office.postoffice,
	policestation.policestation, office.pin, subdivision.subdivision, DATE_FORMAT(personnela.dateofbirth,'%d-%m-%Y') as dateofbirth,
	personnela.gender,personnela.epic,personnela.forpc,personnela.forassembly,personnela.groupid, personnela.booked, poststat.poststatus, personnela.present_addr1, personnela.present_addr2,
	personnela.assembly_temp as pre_ass_cd,ass_pre.assemblyname AS pre_ass, personnela.assembly_perm as per_ass_cd,ass_per.assemblyname AS per_ass, personnela.assembly_off as post_ass_cd,ass_ofc.assemblyname AS post_ass,personnela.personcd, personnela.email, personnela.mob_no, personnela.poststat, personnela.forsubdivision,
	personnela.dcrccd,personnela.training2_sch,
	personnela.subdivisioncd
	 FROM personnela INNER JOIN
    office ON personnela.officecd = office.officecd INNER JOIN 
    assembly AS ass_pre ON personnela.assembly_temp = ass_pre.assemblycd INNER JOIN 
    assembly AS ass_ofc ON personnela.assembly_off = ass_ofc.assemblycd INNER JOIN 
    assembly AS ass_per ON personnela.assembly_perm = ass_per.assemblycd INNER JOIN 
    subdivision ON office.subdivisioncd = subdivision.subdivisioncd INNER JOIN 
    poststat ON personnela.poststat = poststat.post_stat INNER JOIN 
	policestation ON office.policestn_cd = policestation.policestationcd
	Left Join termination On personnela.personcd = termination.personal_id";
	$sql.=" WHERE personnela.personcd='$p_id' and termination.personal_id is null limit 1";
   // echo $sql;
	//exit;
	
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//=========================Personnel List==============================
function fatch_PersonnelList($officeid,$personcd,$frmdt,$todt,$subdiv_cd)
{
	$sql="Select personnel.personcd, personnel.officer_name, personnel.present_addr1, personnel.present_addr2, poststat.poststatus
			From personnel
		  Inner Join poststat On personnel.poststat = poststat.post_stat 
		  Left Join termination On personnel.personcd = termination.personal_id where personnel.personcd>0 And termination.personal_id Is Null ";
//and personnel.usercode='$usercode'
	if($officeid<>'')
		$sql.=" and personnel.officecd like '$officeid%'";
	if($personcd<>'')
		$sql.=" and personnel.personcd like '$personcd%'";
	if($subdiv_cd!='0')
		$sql.=" and personnel.subdivisioncd = '$subdiv_cd'";  
	if($frmdt<>'')
		$sql.=" and personnel.posted_date >= '$frmdt'";
	if($todt<>'')
		$sql.=" and personnel.posted_date <= '$todt'";
	$sql.=" order by personnel.personcd";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_PersonnelList1($officeid,$personcd,$frmdt,$todt,$subdiv_cd,$p_num,$items)
{
	$sql="Select personnel.personcd, personnel.officer_name, personnel.present_addr1, personnel.present_addr2, poststat.poststatus
			From personnel
		  Inner Join poststat On personnel.poststat = poststat.post_stat Left Join termination On personnel.personcd = termination.personal_id where personnel.personcd>0 And termination.personal_id Is Null ";
//and personnel.usercode='$usercode'
	if($officeid<>'')
		$sql.=" and personnel.officecd like '$officeid%'";
	if($personcd<>'')
		$sql.=" and personnel.personcd like '$personcd%'";
	if($subdiv_cd!='0')
		$sql.=" and personnel.subdivisioncd = '$subdiv_cd'";  
	if($frmdt<>'')
		$sql.=" and personnel.posted_date >= '$frmdt'";
	if($todt<>'')
		$sql.=" and personnel.posted_date <= '$todt'";
	$sql.=" order by personnel.personcd";
	$sql.=" ASC LIMIT $p_num , $items";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function person_details($personcd)
{
	$sql="SELECT personnel.personcd, personnel.officecd, office.office, personnel.officer_name, personnel.off_desg, personnel.present_addr1, personnel.present_addr2, personnel.perm_addr1, personnel.perm_addr2, Date_Format( personnel.dateofbirth, '%d/%m/%Y' ) AS dateofbirth, personnel.gender, personnel.scale, personnel.basic_pay, personnel.grade_pay, personnel.workingstatus, personnel.email, personnel.resi_no, personnel.mob_no, personnel.qualificationcd, personnel.languagecd, personnel.epic, personnel.slno, personnel.partno, personnel.poststat, personnel.assembly_temp, personnel.assembly_off, personnel.assembly_perm, personnel.acno, personnel.bank_acc_no, personnel.bank_cd, personnel.branchcd, personnel.remarks, personnel.pgroup, personnel.upload_file
FROM personnel
INNER JOIN office ON personnel.officecd = office.officecd";
  	$sql.=" where personnel.personcd='$personcd'";                            
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//============================Office Details Function==============================
function ofc_del_check($delcode)
{
	$sql="Select count(personcd) as total From personnel where officecd='$delcode'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$total=$row['total'];
	unset($sql,$rs,$row);
	connection_close();
	return $total;
}
function delete_office($delcode)
{
	$sql="delete from office where officecd='$delcode'";
	$i=execDelete($sql);
	connection_close();
	return $i;
}
function fatch_office_maxcode($ps_code)
{
	$sql;$rs;
	$sql="select max(officecd) as officecd from office where policestn_cd='$ps_code'";
	//echo $sql;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_Subdivision($districtcd)
{
	$sql;$rs;
	$sql="SELECT distinct * FROM subdivision ";
//	if($districtcd!='0' && $districtcd!='')
		$sql.=" where districtcd='$districtcd'";
	$sql.=" ORDER BY subdivision ASC";
	//echo $sql;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_statusofoffice($govt_cat)
{
	$sql;$rs;
	$sql="SELECT * FROM govtcategory";
	if($govt_cat!='' && $govt_cat!='0')
		$sql.=" where govt='$govt_cat'";
	$sql.=" ORDER BY govt_description ASC ";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_Natureofoffice()
{
	$sql;$rs;
	$sql="SELECT * FROM institute ORDER BY institute ASC ";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function save_officedetails($OfficeID,$designationOic,$officename,$ddocode,$Street,$Town,$PostOffice,$Pincode,$Municipality,	$PoliceStation,$Statusofoffice,$email,$Ph_no,$Mb_no,$FAX_no,$ExistingStaff,$MaleStaff,$FemaleStaff,$Subdivision,$dist_code,$Natureofoffice,$usercd)
{
	$sql="insert into office (officecd,officer_desg,office,address1,address2,postoffice,pin,";
	$sql.="blockormuni_cd,policestn_cd,ddocode,govt,email,phone,mobile,fax,tot_staff,male_staff,female_staff,";
	$sql.="subdivisioncd,districtcd,institutecd,usercode) values (";
	$sql.="'$OfficeID','$designationOic','$officename','$Street','$Town','$PostOffice','$Pincode',";
	$sql.="'$Municipality','$PoliceStation','$ddocode','$Statusofoffice','$email','$Ph_no','$Mb_no','$FAX_no',";
	$sql.="'$ExistingStaff','$MaleStaff','$FemaleStaff','$Subdivision','$dist_code','$Natureofoffice','$usercd')";
	//echo $sql; exit;
	$i=execInsert($sql);
	connection_close();
	return $i;
}
function update_officedetails($OfficeID,$designationOic,$officename,$ddocode,$Street,$Town,$PostOffice,$Pincode,$Municipality,$PoliceStation,$Statusofoffice,$email,$Ph_no,$Mb_no,$FAX_no,$ExistingStaff,$MaleStaff,$FemaleStaff,$Subdivision,$dist_code,$Natureofoffice,$usercd,$posted_date)
{
	$sql="update office set 
			officer_desg='$designationOic',
			office='$officename',
			address1='$Street',
			address2='$Town',
			postoffice='$PostOffice',
			pin='$Pincode',
			blockormuni_cd='$Municipality',
			policestn_cd='$PoliceStation',
			ddocode='$ddocode',
			govt='$Statusofoffice',
			email='$email',
			phone='$Ph_no',
			mobile='$Mb_no',
			fax='$FAX_no',
			tot_staff='$ExistingStaff',
			male_staff='$MaleStaff',
			female_staff='$FemaleStaff',
			subdivisioncd='$Subdivision',
			districtcd='$dist_code',
			institutecd='$Natureofoffice',
			usercode='$usercd',
			posted_date='$posted_date'";
	$sql.="where officecd='$OfficeID'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
//====================Fatch Block=====================================
function fatch_block($subdiv)
{
	$sql="select * from block_muni where subdivisioncd='$subdiv'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_PoliceStation($subdiv)
{
	$sql="select * from policestation where subdivisioncd='$subdiv'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//=======================Employee Replacement==========================
function fatch_training_venue_available_subdiv($schedule_cd,$subdiv,$post_stat)
{
	$sql="Select training_schedule.schedule_code,
	  training_venue.venuename,
	  DATE(training_schedule.training_dt) as t_date,
	  training_schedule.training_time
	  
	From training_venue
	  Inner Join training_schedule On training_schedule.training_venue =
		training_venue.venue_cd
	  Inner Join training_type On training_schedule.training_type =
		training_type.training_code
	Where (training_schedule.no_pp-training_schedule.no_used) > 0 ";
	if($subdiv !='')
		$sql.=" and training_schedule.forsubdiv='$subdiv'";
	if($post_stat !='')
		$sql.=" and training_schedule.post_status='$post_stat'";
	if($schedule_cd !='0')
		$sql.=" and training_schedule.schedule_code='$schedule_cd'";
		//echo $sql;
		//exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_assembly_ag_subdiv($subdiv)
{
	$sql="select * from assembly where subdivisioncd='$subdiv'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_Personnel_list($ass,$polling_party,$post_stat)
{
	$sql="Select personnela.personcd, personnela.officer_name From personnela WHERE personnela.forassembly='$ass'
	and personnela.groupid='$polling_party' and personnela.poststat='$post_stat' and personnela.booked='P'";
	
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_employee()
{
	$sql="select * from personnel";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function Subdivision_ag_subdivcd($subdivcd)
{
	$sql;$rs;
	$sql="SELECT subdivision FROM subdivision where subdivisioncd='$subdivcd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$subdivision=$row['subdivision'];
	connection_close();
	return $subdivision;
}
function fatch_Random_personnel_for_PreGroupReplacement($forpc,$ofc_id,$gender,$post_stat)
{
	$sqlc="select count(*) as cnt
	From personnela 
	Inner Join office On personnela.officecd = office.officecd 
  	Inner Join policestation On office.policestn_cd = policestation.policestationcd
  	Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
  	Inner Join poststat On personnela.poststat = poststat.post_stat
  	Inner Join district On district.districtcd = subdivision.districtcd
	Left Join termination On personnela.personcd = termination.personal_id ";
	$sqlc.="WHERE termination.personal_id is null and personnela.gender='$gender' ";
	if($forpc !="" && $forpc !="0")
	   $sqlc.="and personnela.forpc='$forpc' ";
	$sqlc.=" and (personnela.booked='' or personnela.booked is null) and personnela.poststat='$post_stat'";
	$fsql=$sqlc."and personnela.subdivisioncd=substr('$ofc_id',1,4)";
	
	$rsc=execSelect($fsql);
	$rowc=getRows($rsc);
	$mode="own-sub";
	if($rowc['cnt']==0)
	{
		$rsc=execSelect($sqlc);
		$rowc=getRows($rsc);
		$mode="other-sub";
	}
	$limit=$rowc['cnt'];
	$random_no=rand(0,$limit-1);
	
	$sql="Select personnela.personcd,personnela.officecd,personnela.officer_name,personnela.off_desg,office.address1,
  	office.address2,office.postoffice,policestation.policestation,subdivision.subdivision,district.district,
  	office.pin,DATE_FORMAT(personnela.dateofbirth,'%d-%m-%Y') as dateofbirth,personnela.gender,personnela.epic,
  	poststat.poststatus,personnela.present_addr1,personnela.present_addr2,
	
	(Select distinct  assemblyname from assembly asmb where asmb.assemblycd = personnela.assembly_temp and personnela.subdivisioncd=asmb.subdivisioncd) As pre_ass,
         (Select distinct  assemblyname from assembly asmb where asmb.assemblycd = personnela.assembly_off and personnela.subdivisioncd=asmb.subdivisioncd) As post_ass,
         (Select distinct assemblyname from assembly asmb where asmb.assemblycd = personnela.assembly_perm and personnela.subdivisioncd=asmb.subdivisioncd) As per_ass
	
	From personnela Inner Join office On personnela.officecd = office.officecd 
  	Inner Join policestation On office.policestn_cd = policestation.policestationcd 
  	Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
  	Inner Join poststat On personnela.poststat = poststat.post_stat
	
  	Inner Join district On district.districtcd = subdivision.districtcd 
	Left Join termination On personnela.personcd = termination.personal_id ";
	$sql.="WHERE termination.personal_id is null and personnela.gender='$gender' ";
	 if($forpc !="" && $forpc !="0")
	   $sql.="and personnela.forpc='$forpc' ";
	$sql.="and (personnela.booked='' or personnela.booked is null) and personnela.poststat='$post_stat' ";
	if($mode=="own-sub")
		$sql.=" and personnela.subdivisioncd=substr('$ofc_id',1,4)";
	$sql.=" order by rand_numb asc";
	
	//$sql.=" limit 1 ";
	$sql.=" limit 1";
	
	//echo $sql;
	//exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function update_personnel_PreGroupReplacement_change_post_status($old_p_id,$forassembly,$post_status,$booked,$selected)
{
	$sql2="update personnel set poststat='$post_status' where personcd='$old_p_id'";
	execUpdate($sql2);
	$sql="update personnela set booked='$booked',poststat='$post_status',rand_numb=0,selected='$selected' where personcd='$old_p_id'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
	
}
function update_personnel_PreGroupReplacement($p_id,$forassembly,$forpc,$booked,$selected)
{
	$sql="update personnela set booked='$booked',forpc='$forpc',selected='$selected' where personcd='$p_id'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
function update_training_booked_denied($p_id)
{
	$sql="update training_pp set training_booked='',	training_attended='',training_showcause='' where per_code='$p_id'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
function personnelDetails_PreGroupReplacement($p_id)
{
	$sql="Select personnela.personcd, personnela.officer_name,
	  personnela.off_desg, personnela.poststat,
	  personnela.assembly_temp, personnela.assembly_off,
	  personnela.assembly_perm, personnela.forsubdivision,
	  personnela.forpc, personnela.subdivisioncd
	From personnela where personcd='$p_id'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function update_personnel_PreGroupReplacement_training($per_code,$per_name,$desig,$post_stat,$subdiv,$for_subdiv,$for_pc,$ass_temp,$ass_off, $ass_perm,$usercode,$posted_date,$old_per_code)
{
	$sql="update training_pp set per_code='$per_code',per_name='$per_name',designation='$desig',post_stat='$post_stat', subdivision='$subdiv',for_subdivision='$for_subdiv',for_pc='$for_pc',assembly_temp='$ass_temp',assembly_off='$ass_off', assembly_perm='$ass_perm',usercode='$usercode',posted_date='$posted_date' where per_code='$old_per_code'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
function fetch_training_schedule_code($old_p_id)
{
	$sql;$rs;
	$sql="SELECT training_sch FROM training_pp where per_code='$old_p_id'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$training_sch=$row['training_sch'];
	connection_close();
	return $training_sch;
}
function fetch_no_used_training_schedule($old_s_cd)
{
	$sql;$rs;
	$sql="SELECT no_used FROM training_schedule where schedule_code='$old_s_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$no_used=$row['no_used'];
	connection_close();
	return $no_used;
}
function update_training_schedule_PreGroupReplacement($noused,$old_s_cd)
{
	$sql="update training_schedule set no_used='$noused' where schedule_code='$old_s_cd'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
function update_personnel_PreGroupReplacement_training_pp($per_code,$per_name,$desig,$post_stat,$subdiv,$for_subdiv,$for_pc,$ass_temp,$ass_off, $ass_perm,$usercode,$posted_date,$old_per_code,$training_sch)
{
	$sql="update training_pp set per_code='$per_code',per_name='$per_name',designation='$desig',post_stat='$post_stat', subdivision='$subdiv',for_subdivision='$for_subdiv',for_pc='$for_pc',assembly_temp='$ass_temp',assembly_off='$ass_off', assembly_perm='$ass_perm',usercode='$usercode',posted_date='$posted_date',training_sch='$training_sch' where per_code='$old_per_code'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
function delete_old_pp_trainingpp($old_p_id)
{
	$sql="delete from training_pp where per_code='$old_p_id'";
	$i=execDelete($sql);
	connection_close();
	return $i;
}
function add_employee_PreGroupReplacement_log($new_p_id,$old_p_id,$forassembly,$forpc,$reason,$usercd)
{
	$sql="insert into replacement_log_pregroup (old_personnel, new_personnel, forassembly, forpc,reason, usercode) values ";
	$sql.="('$old_p_id','$new_p_id','$forassembly','$forpc','$reason','$usercd')";
	$i=execInsert($sql);
	connection_close();
	return $i;
}
/************************* Second apppt replace *******************************/
function fatch_Random_personnel_for_replacement($for_subdiv,$forpc,$assembly,$posting_status,$groupid,$gender,$draft_subdiv)
{
	$sqltmp="select officecd from personnela where groupid='$groupid' and personnela.forsubdivision='$for_subdiv' and personnela.forassembly='$assembly' and booked='P'";

	$rs_tmp=execSelect($sqltmp);
	$num_rows_tmp=rowCount($rs_tmp);
	//echo $sqltmp;
//	exit;
	for($i=0;$i<$num_rows_tmp;$i++)
	{
		$row_tmp=getRows($rs_tmp);
		$office[$i]=$row_tmp['officecd'];
	}
	$row_tmp=NULL; $rs_tmp=NULL;
	$sqlc="select count(*) as cnt
	From personnela Inner Join office On personnela.officecd = office.officecd 
  	Inner Join policestation On office.policestn_cd = policestation.policestationcd
  	Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
  	Inner Join poststat On personnela.poststat = poststat.post_stat
  	Inner Join district On district.districtcd = subdivision.districtcd 
	Left Join termination On personnela.personcd = termination.personal_id";
	$sqlc.=" WHERE termination.personal_id is null and personnela.gender='$gender' and personnela.assembly_temp<>'$assembly' and personnela.assembly_perm<>'$assembly' and personnela.assembly_off<>'$assembly' and personnela.poststat='$posting_status' ";
	$sqlc.=" and (personnela.booked='' or personnela.booked is null) and personnela.subdivisioncd='$draft_subdiv'";
	for($i=0;$i<$num_rows_tmp;$i++)
	{
		$sqlc.=" and personnela.officecd<>'$office[$i]'";
	}
	$rsc=execSelect($sqlc);
	$rowc=getRows($rsc);
	$limit=$rowc['cnt'];
	//echo $limit; exit;
	$random_no=rand(0,$limit-1);
	$sql="Select personnela.personcd,personnela.officecd,personnela.officer_name,personnela.off_desg,office.address1,
  	office.address2,office.postoffice,policestation.policestation,subdivision.subdivision,district.district,
  office.pin,DATE_FORMAT(personnela.dateofbirth,'%d-%m-%Y') as dateofbirth,personnela.gender,personnela.epic,
  	poststat.poststatus,personnela.present_addr1,personnela.present_addr2,
	
	(Select distinct  assemblyname from assembly asmb where asmb.assemblycd = personnela.assembly_temp and personnela.subdivisioncd=asmb.subdivisioncd) As pre_ass,
         (Select distinct  assemblyname from assembly asmb where asmb.assemblycd = personnela.assembly_off and personnela.subdivisioncd=asmb.subdivisioncd) As post_ass,
         (Select distinct assemblyname from assembly asmb where asmb.assemblycd = personnela.assembly_perm and personnela.subdivisioncd=asmb.subdivisioncd) As per_ass
		 
	From personnela 
	Inner Join office On personnela.officecd = office.officecd
  	Inner Join policestation On office.policestn_cd = policestation.policestationcd 
  	Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
  	Inner Join poststat On personnela.poststat = poststat.post_stat
  
  	Inner Join district On district.districtcd = subdivision.districtcd
	Left Join termination On personnela.personcd = termination.personal_id ";
	$sql.=" WHERE termination.personal_id is null and personnela.gender='$gender' and personnela.assembly_temp<>'$assembly' and personnela.assembly_perm<>'$assembly' and personnela.assembly_off<>'$assembly' and personnela.poststat='$posting_status' ";
	$sql.=" and (personnela.booked='' or personnela.booked is null) and personnela.subdivisioncd='$draft_subdiv'";
	for($i=0;$i<$num_rows_tmp;$i++)
	{
		$sql.=" and personnela.officecd<>'$office[$i]'";
	}
	$sql.=" limit 1 offset $random_no";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
/***************** Save in second appt after replace *************************/
function save_data_in_second_appt_after_rplc($forassembly,$groupid,$poststat)
{
	/*$sql0="delete from second_appt where assembly='$forassembly' and groupid='$groupid'";
	$a=execDelete($sql0);
	
	$sql1="INSERT INTO second_appt( assembly, subdivcd, groupid ,mem_no)  SELECT  forassembly, forsubdivision, groupid,count(*)  FROM personnela WHERE booked = 'P' and forassembly='$forassembly' and groupid='$groupid' GROUP BY forassembly, groupid ";
	$b=execInsert($sql1);*/
	
	//================================Personnel join=================================//
	
	switch($poststat)
	{
		 case ($poststat=='PR'):
            $sql2="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly and second_appt.groupid=personnela.groupid
	  SET second_appt.pr_personcd = personnela.personcd,second_appt.pr_name = personnela.officer_name,second_appt.`pr_designation` =personnela.off_desg,second_appt.`pr_officecd`= personnela.officecd,second_appt.pr_mobno =personnela.mob_no
	WHERE personnela.booked = 'P'  and personnela.poststat = 'PR' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
	        $c=execUpdate($sql2);
	       $sql8="UPDATE second_appt JOIN office ON second_appt.pr_officecd = office.officecd   SET  second_appt.pr_officename =  office.office,second_appt.`pr_officeaddress`= concat(office.address1,',',office.address2),second_appt.pr_postoffice=office.postoffice,second_appt.pr_pincode=office.pin, second_appt.pr_subdivision=office.subdivisioncd WHERE second_appt.pr_status = 'PR' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	        $i=execUpdate($sql8);
			$sql28="update second_appt set second_appt.pers_off= second_appt.pr_officecd where second_appt.assembly='$forassembly' and second_appt.groupid='$groupid' and second_appt.per_poststat='PR'";
		   $d1=execUpdate($sql28);
			break;
		case ($poststat=='P1'):
         $sql3="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
	second_appt.groupid=personnela.groupid  SET second_appt.p1_personcd = personnela.personcd,second_appt.p1_name = personnela.officer_name,second_appt.`p1_designation`=personnela.off_desg,second_appt.`p1_officecd`=personnela.officecd,second_appt.p1_mobno =personnela.mob_no 
	WHERE  personnela.booked = 'P' and personnela.poststat = 'P1' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
	       $i=execUpdate($sql3);
			$sql9="UPDATE second_appt JOIN office ON second_appt.p1_officecd = office.officecd   SET  second_appt.p1_officename =  office.office,second_appt.`p1_officeaddress`= concat(office.address1,',',office.address2),second_appt.p1_postoffice=office.postoffice,second_appt.p1_pincode=office.pin ,second_appt.p1_subdivision=office.subdivisioncd WHERE second_appt.p1_status = 'P1' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	        $j=execUpdate($sql9);
	        $sql28="update second_appt set second_appt.pers_off= second_appt.p1_officecd where  second_appt.assembly='$forassembly' and second_appt.groupid='$groupid' and  second_appt.per_poststat='P1'";
		$d1=execUpdate($sql28); 
		break;	
		
		case ($poststat=='P2'):
           $sql4="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
	second_appt.groupid=personnela.groupid  SET second_appt.p2_personcd = personnela.personcd,second_appt.p2_name = personnela.officer_name,second_appt.`p2_designation` 
	=personnela.off_desg,second_appt.`p2_officecd`= personnela.officecd,second_appt.p2_mobno =personnela.mob_no
	WHERE personnela.booked = 'P'  and personnela.poststat = 'P2' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
	      $e=execUpdate($sql4);
		  $sql10="UPDATE second_appt JOIN office ON second_appt.p2_officecd = office.officecd   SET  second_appt.p2_officename =  office.office,second_appt.`p2_officeaddress`= concat(office.address1,',',office.address2),second_appt.p2_postoffice=office.postoffice,second_appt.p2_pincode=office.pin,second_appt.p2_subdivision=office.subdivisioncd  WHERE second_appt.p2_status = 'P2' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	      $k=execUpdate($sql10);
		  $sql28="update second_appt set second_appt.pers_off= second_appt.p2_officecd where  second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'  and second_appt.per_poststat='P2'";
		$d1=execUpdate($sql28);
		break;	
	   case ($poststat=='P3'):
           $sql5="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
	second_appt.groupid=personnela.groupid  SET second_appt.p3_personcd = personnela.personcd,second_appt.p3_name = personnela.officer_name,second_appt.`p3_designation` 
	=personnela.off_desg,second_appt.`p3_officecd`= personnela.officecd,second_appt.p3_mobno =personnela.mob_no
	WHERE  personnela.booked = 'P'  and personnela.poststat = 'P3' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
	     $f=execUpdate($sql5);
		 $sql11="UPDATE second_appt JOIN office ON second_appt.p3_officecd = office.officecd   SET  second_appt.p3_officename =  office.office,second_appt.`p3_officeaddress`= concat(office.address1,',',office.address2),second_appt.p3_postoffice=office.postoffice,second_appt.p3_pincode=office.pin, second_appt.p3_subdivision=office.subdivisioncd WHERE second_appt.p3_status = 'P3' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	     $l=execUpdate($sql11);
		 $sql28="update second_appt set second_appt.pers_off= second_appt.p3_officecd where second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'  and second_appt.per_poststat='P3'";
		$d1=execUpdate($sql28);
		break;	
	    case ($poststat=='PA'):
           $sql6="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
	second_appt.groupid=personnela.groupid  SET second_appt.pa_personcd = personnela.personcd,second_appt.pa_name = personnela.officer_name,second_appt.`pa_designation`=personnela.off_desg, second_appt.`pa_officecd`= personnela.officecd,second_appt.`pa_status`='PA', second_appt.pa_post_stat='Addl. 2nd Polling Officer-1' ,second_appt.pa_mobno =personnela.mob_no
	WHERE personnela.booked = 'P'  and personnela.poststat = 'PA' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
	    $g=execUpdate($sql6);
		$sql12="UPDATE second_appt JOIN office ON second_appt.pa_officecd = office.officecd   SET  second_appt.pa_officename =  office.office,second_appt.`pa_officeaddress`= concat(office.address1,',',office.address2),second_appt.pa_postoffice=office.postoffice,second_appt.pa_pincode=office.pin , second_appt.pa_subdivision=office.subdivisioncd WHERE second_appt.pa_status = 'PA' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	     $m=execUpdate($sql12);
		 $sql28="update second_appt set second_appt.pers_off= second_appt.pa_officecd where second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'  and second_appt.per_poststat='PA'";
		$d1=execUpdate($sql28);
		break;
	   case ($poststat=='PB'):
	      $sql7="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
	second_appt.groupid=personnela.groupid  SET second_appt.pb_personcd = personnela.personcd,second_appt.pb_name = personnela.officer_name,second_appt.`pb_designation`=personnela.off_desg,second_appt.`pb_officecd`= personnela.officecd,second_appt.pb_mobno =personnela.mob_no
	WHERE personnela.booked = 'P'  and personnela.poststat = 'PB' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
	      $h=execUpdate($sql7);
		  $sql13="UPDATE second_appt JOIN office ON second_appt.pb_officecd = office.officecd   SET  second_appt.pb_officename =  office.office,second_appt.`pb_officeaddress`= concat(office.address1,',',office.address2),second_appt.pb_postoffice=office.postoffice,second_appt.pb_pincode=office.pin, second_appt.pb_subdivision=office.subdivisioncd WHERE second_appt.pb_status = 'PB' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	      $n=execUpdate($sql13);
		  $sql28="update second_appt set second_appt.pers_off= second_appt.pb_officecd where  second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'  and second_appt.per_poststat='PB'";
		$d1=execUpdate($sql28);
	   break;
	   default:
		break;
	}
	/*$sql2="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly and second_appt.groupid=personnela.groupid
	  SET second_appt.pr_personcd = personnela.personcd,second_appt.pr_name = personnela.officer_name,second_appt.`pr_designation` =personnela.off_desg,second_appt.`pr_officecd`= personnela.officecd,second_appt.`pr_status`='PR',second_appt.pr_post_stat='Presiding Officer',second_appt.pr_mobno =personnela.mob_no
	WHERE personnela.booked = 'P'  and personnela.poststat = 'PR' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
	$c=execUpdate($sql2);
	
	
	
	$sql4="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
	second_appt.groupid=personnela.groupid  SET second_appt.p2_personcd = personnela.personcd,second_appt.p2_name = personnela.officer_name,second_appt.`p2_designation` 
	=personnela.off_desg,second_appt.`p2_officecd`= personnela.officecd,second_appt.`p2_status`='P2',second_appt.p2_post_stat='2nd Polling Officer',second_appt.p2_mobno =personnela.mob_no
	WHERE personnela.booked = 'P'  and personnela.poststat = 'P2' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
	$e=execUpdate($sql4);
	
	$sql5="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
	second_appt.groupid=personnela.groupid  SET second_appt.p3_personcd = personnela.personcd,second_appt.p3_name = personnela.officer_name,second_appt.`p3_designation` 
	=personnela.off_desg,second_appt.`p3_officecd`= personnela.officecd,second_appt.`p3_status`='P3',second_appt.p3_post_stat='3rd Polling Officer',second_appt.p3_mobno =personnela.mob_no
	WHERE  personnela.booked = 'P'  and personnela.poststat = 'P3' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
	$f=execUpdate($sql5);
	
	$sql6="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
	second_appt.groupid=personnela.groupid  SET second_appt.pa_personcd = personnela.personcd,second_appt.pa_name = personnela.officer_name,second_appt.`pa_designation`=personnela.off_desg, second_appt.`pa_officecd`= personnela.officecd,second_appt.`pa_status`='PA', second_appt.pa_post_stat='Addl. 2nd Polling Officer-1' ,second_appt.pa_mobno =personnela.mob_no
	WHERE personnela.booked = 'P'  and personnela.poststat = 'PA' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
	$g=execUpdate($sql6);
	
	$sql7="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
	second_appt.groupid=personnela.groupid  SET second_appt.pb_personcd = personnela.personcd,second_appt.pb_name = personnela.officer_name,second_appt.`pb_designation`=personnela.off_desg,second_appt.`pb_officecd`= personnela.officecd,second_appt.`pb_status`='PB',second_appt.pa_post_stat='Addl. 2nd Polling Officer-2' ,second_appt.pb_mobno =personnela.mob_no
	WHERE personnela.booked = 'P'  and personnela.poststat = 'PB' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
	$h=execUpdate($sql7);
	//================================end of personnel join=======================//
	
	//================================office join=================================//
	$sql8="UPDATE second_appt JOIN office ON second_appt.pr_officecd = office.officecd   SET  second_appt.pr_officename =  office.office,second_appt.`pr_officeaddress`= concat(office.address1,',',office.address2),second_appt.pr_postoffice=office.postoffice,second_appt.pr_pincode=office.pin, second_appt.pr_subdivision=office.subdivisioncd WHERE second_appt.pr_status = 'PR' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	$i=execUpdate($sql8);
	
	$sql9="UPDATE second_appt JOIN office ON second_appt.p1_officecd = office.officecd   SET  second_appt.p1_officename =  office.office,second_appt.`p1_officeaddress`= concat(office.address1,',',office.address2),second_appt.p1_postoffice=office.postoffice,second_appt.p1_pincode=office.pin ,second_appt.p1_subdivision=office.subdivisioncd WHERE second_appt.p1_status = 'P1' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	$j=execUpdate($sql9);
	
	$sql10="UPDATE second_appt JOIN office ON second_appt.p2_officecd = office.officecd   SET  second_appt.p2_officename =  office.office,second_appt.`p2_officeaddress`= concat(office.address1,',',office.address2),second_appt.p2_postoffice=office.postoffice,second_appt.p2_pincode=office.pin,second_appt.p2_subdivision=office.subdivisioncd  WHERE second_appt.p2_status = 'P2' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	$k=execUpdate($sql10);
	
	$sql11="UPDATE second_appt JOIN office ON second_appt.p3_officecd = office.officecd   SET  second_appt.p3_officename =  office.office,second_appt.`p3_officeaddress`= concat(office.address1,',',office.address2),second_appt.p3_postoffice=office.postoffice,second_appt.p3_pincode=office.pin, second_appt.p3_subdivision=office.subdivisioncd WHERE second_appt.p3_status = 'P3' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	$l=execUpdate($sql11);
	
	$sql12="UPDATE second_appt JOIN office ON second_appt.pa_officecd = office.officecd   SET  second_appt.pa_officename =  office.office,second_appt.`pa_officeaddress`= concat(office.address1,',',office.address2),second_appt.pa_postoffice=office.postoffice,second_appt.pa_pincode=office.pin , second_appt.pa_subdivision=office.subdivisioncd WHERE second_appt.pa_status = 'PA' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	$m=execUpdate($sql12);
	
	$sql13="UPDATE second_appt JOIN office ON second_appt.pb_officecd = office.officecd   SET  second_appt.pb_officename =  office.office,second_appt.`pb_officeaddress`= concat(office.address1,',',office.address2),second_appt.pb_postoffice=office.postoffice,second_appt.pb_pincode=office.pin, second_appt.pb_subdivision=office.subdivisioncd WHERE second_appt.pb_status = 'PB' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	$n=execUpdate($sql13);
	//================================End of office join=================================//
	
	//================================Start DCRC join====================================//
	
	$sql14="UPDATE second_appt JOIN grp_dcrc ON second_appt.assembly=grp_dcrc.forassembly  and 
	second_appt.groupid=grp_dcrc.groupid  SET second_appt.dcrcgrp = grp_dcrc.dcrccd
	WHERE  grp_dcrc.forassembly='$forassembly' and grp_dcrc.groupid='$groupid'";
	$o=execUpdate($sql14);
	
	$sql16="UPDATE second_appt JOIN dcrcmaster  ON second_appt.dcrcgrp=dcrcmaster.dcrcgrp and  dcrcmaster.assemblycd=second_appt.assembly   SET second_appt.dc_venue = dcrcmaster.dc_venue, second_appt.dc_address = dcrcmaster.dc_addr,second_appt.rc_venue = dcrcmaster.rcvenue where second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	$p=execUpdate($sql16);
	
	$sql18="update  second_appt JOIN dcrc_party on  second_appt.dcrcgrp=dcrc_party.dcrcgrp and  
	second_appt.subdivcd=dcrc_party.subdivisioncd set  second_appt.dc_time=dcrc_party.dc_time, 
	second_appt.dc_date=DATE(dcrc_party.dc_date) where second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
	$q=execUpdate($sql18);
	//==================================END of DCRC join=============================================//
	
	//=================================Start of Training==============================================//
	$sql192="update personnela 
set personnela.training2_sch=NULL
where personnela.forassembly='$forassembly' and personnela.groupid='$groupid' and  personnela.booked = 'P'";
$i=execUpdate($sql192);
	
	$sql19="update second_appt join second_training on second_appt.subdivcd=second_training.for_subdiv and second_appt.assembly=second_training.assembly set second_appt.traingcode=second_training.schedule_cd, second_appt.venuecode=second_training.training_venue , second_appt.training_date=second_training.training_dt, second_appt.training_time=second_training.training_time where second_training.party_reserve='P' and second_appt.groupid>=second_training.start_sl and second_appt.groupid<=second_training.end_sl and second_training.assembly='$forassembly' and second_appt.groupid='$groupid'";
	$r=execUpdate($sql19);
	
	//Update Training in Personnela
	$sql191="update personnela join second_training on personnela.forsubdivision=second_training.for_subdiv and personnela.forassembly=second_training.assembly
	set personnela.training2_sch=second_training.schedule_cd
	where second_training.party_reserve='P' and personnela.groupid>=second_training.start_sl and personnela.groupid<=second_training.end_sl and personnela.forassembly='$forassembly' and personnela.groupid='$groupid' and  personnela.booked = 'P'";
	$i=execUpdate($sql191);

	$sql20="UPDATE second_appt a  JOIN training_venue_2 b ON a.venuecode=b.venue_cd SET  a.`training_venue` =b.venuename,a.`venue_addr1` =b.venueaddress1,  a.`venue_addr2`=b.venueaddress2 where a.assembly='$forassembly' and a.groupid='$groupid'";
	$s=execUpdate($sql20);
	//=================================END of Training==============================================//
	
	$sql21="update second_appt a join assembly b on a.assembly=b.assemblycd 
	        and a.subdivcd=b.subdivisioncd set a.assembly_name=b.assemblyname where   a.assembly='$forassembly' and a.groupid='$groupid'";
	$t=execUpdate($sql21);
	
	//$sql21="update second_appt a join  pc b on a.pccd=b.pccd set a.pcname=b.pcname where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
	//$u=execUpdate($sql21);
	
	$sql22="update second_appt a join subdivision b on a.pr_subdivision=b.subdivisioncd set a.pr_subdivision=b.subdivision where  a.assembly='$forassembly' and a.groupid='$groupid'";
	$v=execUpdate($sql22);
	
	$sql23="update second_appt a join subdivision b on a.p1_subdivision=b.subdivisioncd set a.p1_subdivision=b.subdivision where  a.assembly='$forassembly' and a.groupid='$groupid'";
	$w=execUpdate($sql23);
	$sql24="update second_appt a join subdivision b on a.p2_subdivision=b.subdivisioncd set a.p2_subdivision=b.subdivision where a.assembly='$forassembly' and a.groupid='$groupid'";
	$x=execUpdate($sql24);
	
	$sql25="update second_appt a join subdivision b on a.p3_subdivision=b.subdivisioncd set a.p3_subdivision=b.subdivision where a.assembly='$forassembly' and a.groupid='$groupid'";
	$y=execUpdate($sql25);
	
	$sql26="update second_appt a join subdivision b on a.pa_subdivision=b.subdivisioncd set a.pa_subdivision=b.subdivision where a.assembly='$forassembly' and a.groupid='$groupid'";
	$z=execUpdate($sql26);
	
	$sql27="update second_appt a join subdivision b on a.pb_subdivision=b.subdivisioncd set a.pb_subdivision=b.subdivision where a.assembly='$forassembly' and a.groupid='$groupid'";
	$a1=execUpdate($sql27);
	
	$sql271="update second_appt a join poll_table b on a.assembly=b.assembly_cd set a.polldate=b.poll_date, a.polltime=b.poll_time where a.assembly='$forassembly' and a.groupid='$groupid'";
	$b1=execUpdate($sql271);
	
	$sql272="update second_appt a join district b on substr(a.dcrcgrp,1,2)=b.districtcd set a.district=b.district  where a.assembly='$forassembly' and a.groupid='$groupid'";
	$c1=execUpdate($sql272);
	
	if($poststat=='PR')
	{
		$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.pr_officecd, second_appt.per_poststat= a.pr_status where a.assembly='$forassembly' and a.groupid='$groupid'";
		$d1=execUpdate($sql28);
	}
	if($poststat=='P1')
	{
		$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.p1_officecd, second_appt.per_poststat= a.p1_status where  a.assembly='$forassembly' and a.groupid='$groupid'";
		$d1=execUpdate($sql28);
	}
	if($poststat=='P2')
	{
		$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.p2_officecd, second_appt.per_poststat= a.p2_status where  a.assembly='$forassembly' and a.groupid='$groupid'";
		$d1=execUpdate($sql28);
	}
	if($poststat=='P3')
	{
		$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.p3_officecd, second_appt.per_poststat= a.p3_status where a.assembly='$forassembly' and a.groupid='$groupid'";
		$d1=execUpdate($sql28);
	}
	if($poststat=='PA')
	{
		$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.pa_officecd, second_appt.per_poststat= a.pa_status where a.assembly='$forassembly' and a.groupid='$groupid'";
		$d1=execUpdate($sql28);
	}
	if($poststat=='PB')
	{
		$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.pb_officecd, second_appt.per_poststat= a.pb_status where  a.assembly='$forassembly' and a.groupid='$groupid'";
		$d1=execUpdate($sql28);
	}*/
	return 1;
}
function fatch_Random_personnel_for_replacement_r($for_subdiv,$forpc,$assembly,$posting_status,$groupid,$gender,$draft_subdiv)
{
	$sqltmp="select officecd from personnela where groupid='$groupid' and personnela.forsubdivision='$for_subdiv' and personnela.subdivisioncd<>'$draft_subdiv' and personnela.forassembly='$assembly' and booked='P'";

	$rs_tmp=execSelect($sqltmp);
	$num_rows_tmp=rowCount($rs_tmp);
	//echo $sqltmp;
//	exit;
	for($i=0;$i<$num_rows_tmp;$i++)
	{
		$row_tmp=getRows($rs_tmp);
		$office[$i]=$row_tmp['officecd'];
	}
	$row_tmp=NULL; $rs_tmp=NULL;
	$sqlc="select count(*) as cnt
	From personnela Inner Join office On personnela.officecd = office.officecd 
  	Inner Join policestation On office.policestn_cd = policestation.policestationcd
  	Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
  	Inner Join poststat On personnela.poststat = poststat.post_stat
  	Inner Join district On district.districtcd = subdivision.districtcd 
	Left Join termination On personnela.personcd = termination.personal_id";
	$sqlc.=" WHERE termination.personal_id is null and personnela.gender='$gender' and personnela.assembly_temp<>'$assembly' and personnela.assembly_perm<>'$assembly' and personnela.assembly_off<>'$assembly' and personnela.poststat='$posting_status' ";
	$sqlc.=" and personnela.booked='R' and personnela.subdivisioncd='$draft_subdiv'";
	for($i=0;$i<$num_rows_tmp;$i++)
	{
		$sqlc.=" and personnela.officecd<>'$office[$i]'";
	}
	$rsc=execSelect($sqlc);
	$rowc=getRows($rsc);
	$limit=$rowc['cnt'];
	//echo $limit; exit;
	$random_no=rand(0,$limit-1);
	$sql="Select personnela.personcd,personnela.officecd,personnela.officer_name,personnela.off_desg,office.address1,
  	office.address2,office.postoffice,policestation.policestation,subdivision.subdivision,district.district,
  office.pin,DATE_FORMAT(personnela.dateofbirth,'%d-%m-%Y') as dateofbirth,personnela.gender,personnela.epic,
  	poststat.poststatus,personnela.present_addr1,personnela.present_addr2,
	
	(Select distinct  assemblyname from assembly asmb where asmb.assemblycd = personnela.assembly_temp and personnela.subdivisioncd=asmb.subdivisioncd) As pre_ass,
         (Select distinct  assemblyname from assembly asmb where asmb.assemblycd = personnela.assembly_off and personnela.subdivisioncd=asmb.subdivisioncd) As post_ass,
         (Select distinct assemblyname from assembly asmb where asmb.assemblycd = personnela.assembly_perm and personnela.subdivisioncd=asmb.subdivisioncd) As per_ass
		 
	From personnela 
	Inner Join office On personnela.officecd = office.officecd
  	Inner Join policestation On office.policestn_cd = policestation.policestationcd 
  	Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
  	Inner Join poststat On personnela.poststat = poststat.post_stat
  
  	Inner Join district On district.districtcd = subdivision.districtcd
	Left Join termination On personnela.personcd = termination.personal_id ";
	$sql.=" WHERE termination.personal_id is null and personnela.gender='$gender' and personnela.assembly_temp<>'$assembly' and personnela.assembly_perm<>'$assembly' and personnela.assembly_off<>'$assembly' and personnela.poststat='$posting_status' ";
	$sql.=" and personnela.booked='R' and personnela.subdivisioncd='$draft_subdiv'";
	for($i=0;$i<$num_rows_tmp;$i++)
	{
		$sql.=" and personnela.officecd<>'$office[$i]'";
	}
	$sql.=" limit 1 offset $random_no";
	$rs=execSelect($sql);
	connection_close();
	return $rs;

}
/*function fatch_Random_personnel_for_replacement_r($for_subdiv,$forpc,$assembly,$posting_status,$groupid,$gender,$draft_subdiv)
{
	
	$sqlc="select count(*) as cnt
	From personnela Inner Join office On personnela.officecd = office.officecd 
  	Inner Join policestation On office.policestn_cd = policestation.policestationcd
  	Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
  	Inner Join poststat On personnela.poststat = poststat.post_stat
  	Inner Join district On district.districtcd = subdivision.districtcd 
	Left Join termination On personnela.personcd = termination.personal_id";
	$sqlc.=" WHERE termination.personal_id is null and personnela.gender='$gender' and personnela.assembly_temp<>'$assembly' and personnela.assembly_perm<>'$assembly' and personnela.assembly_off<>'$assembly' and personnela.poststat='$posting_status' ";
	$sqlc.=" and personnela.subdivisioncd='$draft_subdiv' and personnela.forassembly='$assembly' and booked='R'";
	$rsc=execSelect($sqlc);
	$rowc=getRows($rsc);
	$limit=$rowc['cnt'];
	//echo $limit; exit;
	$random_no=rand(0,$limit-1);
	$sql="Select personnela.personcd,personnela.officecd,personnela.officer_name,personnela.off_desg,office.address1,
  	office.address2,office.postoffice,policestation.policestation,subdivision.subdivision,district.district,
  office.pin,DATE_FORMAT(personnela.dateofbirth,'%d-%m-%Y') as dateofbirth,personnela.gender,personnela.epic,
  	poststat.poststatus,personnela.present_addr1,personnela.present_addr2,
	
	(Select distinct  assemblyname from assembly asmb where asmb.assemblycd = personnela.assembly_temp) As pre_ass,
         (Select distinct  assemblyname from assembly asmb where asmb.assemblycd = personnela.assembly_off) As post_ass,
         (Select distinct assemblyname from assembly asmb where asmb.assemblycd = personnela.assembly_perm) As per_ass
		
	From personnela Inner Join office On personnela.officecd = office.officecd
  	Inner Join policestation On office.policestn_cd = policestation.policestationcd 
  	Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
  	Inner Join poststat On personnela.poststat = poststat.post_stat

  	Inner Join district On district.districtcd = subdivision.districtcd
	Left Join termination On personnela.personcd = termination.personal_id ";
	$sql.=" WHERE termination.personal_id is null and personnela.gender='$gender' and personnela.assembly_temp<>'$assembly' and personnela.assembly_perm<>'$assembly' and personnela.assembly_off<>'$assembly' and personnela.poststat='$posting_status' ";
	$sql.=" and  personnela.subdivisioncd='$draft_subdiv' and personnela.forassembly='$assembly' and booked='R'";
	$sql.=" limit 1 offset $random_no";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}*/
/*function update_personnel_replacement($p_id,$groupid,$ass,$forpc,$booked,$selected)
{
	$sql="update personnela set booked='$booked',groupid='$groupid',forpc='$forpc',forassembly='$ass',selected='$selected' where personcd='$p_id'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}*/
function delete_second_rand_table_reserve($new_p_id)
{
	$sqld="Delete from second_rand_table_reserve where personcd='$new_p_id'";
	execDelete($sqld);
	$i=connection_close();
	return $i;
}
function update_personnel_replacement($p_id,$groupid,$ass,$forpc,$booked,$selected,$dcrccd,$training2_sch)
{
	$sql="update personnela set booked='$booked',groupid='$groupid',forpc='$forpc',forassembly='$ass',selected='$selected',dcrccd='$dcrccd', training2_sch='$training2_sch' where personcd='$p_id'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
function add_employee_replacement_log($new_p_id,$old_p_id,$ass,$groupid,$usercd)
{
	$sql="insert into relpacement_log (old_personnel, new_personnel, assemblycd, groupid, usercode) values ";
	$sql.="('$old_p_id','$new_p_id','$ass','$groupid','$usercd')";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
//============ Pre group Cancelletion =========================
function save_pregroup_cancelletion($PersonalID,$usercd)
{
	$sql="delete from personnela where personcd='$PersonalID'";
	$i=execDelete($sql);
	if($i==1)
	{
		$sql1="delete from training_pp where per_code='$PersonalID'";
		$j=execDelete($sql1);
		$sql2="update personnel set f_cd=NULL where personcd='$PersonalID'";
		$j=execUpdate($sql2);
		$sql3="delete from first_rand_table where personcd='$PersonalID'";
		$j=execUpdate($sql3);
	}	
	connection_close();
	return $i;
}
function save_pregroup_post_status_cancelletion($PersonalID,$post_status,$usercd)
{
	$sql="delete from first_rand_table where personcd='$PersonalID'";
	$i=execDelete($sql);
	//if($i==1)
	//{
		$sql1="delete from training_pp where per_code='$PersonalID'";
		$j=execDelete($sql1);
		$sql2="update personnel set poststat='$post_status' where personcd='$PersonalID'";
		$j=execUpdate($sql2);
		$sql3="update personnela set booked=' ', groupid=0, forassembly='', poststat='$post_status',rand_numb=0,selected=0 where personcd='$PersonalID'";
		$j=execUpdate($sql3);
	//}	
	connection_close();
	return 1;
}
//============Reserve Cancellation================================
function save_reserve_pp_cancelletion($PersonalID,$usercd)
{
	$sql="delete from personnela where personcd='$PersonalID'";
	$i=execDelete($sql);
	if($i==1)
	{
		$sql1="delete from second_rand_table_reserve where personcd='$PersonalID'";
		$j=execDelete($sql1);
		$sql2="update personnel set f_cd=NULL where personcd='$PersonalID'";
		$j=execUpdate($sql2);
	}	
	connection_close();
	return $i;
}
//=========================FatchPersonal==============================
function fatch_Personaldtl_mobile($mobile)
{
	$sql="SELECT personnel.personcd, personnel.usercode, personnel.officer_name, office.office, personnel.off_desg, personnel.scale,
          personnel.basic_pay, personnel.grade_pay, 
          personnel.mob_no,personnel.present_addr1,personnel.present_addr2,
		 (Select distinct assemblyname from assembly asmb where asmb.assemblycd = personnel.assembly_temp ) As assembly_temp,
         (Select distinct  assemblyname from assembly asmb where asmb.assemblycd = personnel.assembly_off) As assembly_off,
         (Select distinct  assemblyname from assembly asmb where asmb.assemblycd = personnel.assembly_perm) As assembly_perm
          FROM personnel
          INNER JOIN office ON personnel.officecd = office.officecd where mob_no='$mobile'";
		 // echo $sql;
		//  exit();
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//=====================FatchPersonal (BLO Update)====================================
function fatch_Personaldtl($PersonalCd)
{
	$sql="SELECT personnel.personcd, personnel.usercode, personnel.officer_name, office.office, personnel.off_desg, personnel.scale,
          personnel.basic_pay, personnel.grade_pay, 
          personnel.mob_no,personnel.present_addr1,personnel.present_addr2,
		 (Select distinct  assemblyname from assembly asmb where asmb.assemblycd = personnel.assembly_temp) As assembly_temp,
         (Select distinct  assemblyname from assembly asmb where asmb.assemblycd = personnel.assembly_off) As assembly_off,
         (Select distinct assemblyname from assembly asmb where asmb.assemblycd = personnel.assembly_perm) As assembly_perm
          FROM personnel
          INNER JOIN office ON personnel.officecd = office.officecd where personcd='$PersonalCd'";
		 // echo $sql;
		//  exit();
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//=========================Office List==============================
function fatch_OfficeList($sub_div,$officeid,$officename,$frmdt,$todt,$usercode)
{
	$sql="Select office.officecd, office.office, office.address1, office.address2, office.postoffice, office.pin, institute.institute, office.usercode 
			From office
		  Inner Join institute On office.institutecd = institute.institutecd  where office.officecd>0 ";
	if($sub_div!='' && $sub_div!='0')
		$sql.=" and office.subdivisioncd='$sub_div'";
	if($officeid!='' && $officeid!='0')
		$sql.=" and office.officecd like '$officeid%'";
	if($officename!='')
		$sql.=" and office.office like '$officename%'";
	if($frmdt!='')
		$sql.=" and office.posted_date >= '$frmdt'";
	if($todt!='')
		$sql.=" and office.posted_date <= '$todt'";
	$sql.=" order by office.office";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_OfficeList1($sub_div,$officeid,$officename,$frmdt,$todt,$usercode,$p_num,$items)
{
	$sql="Select office.officecd, office.office, office.address1, office.address2, office.postoffice, office.pin, institute.institute,office.usercode
			From office
		  Inner Join institute On office.institutecd = institute.institutecd  where office.officecd>0 ";
	if($sub_div!='' && $sub_div!='0')
		$sql.=" and office.subdivisioncd='$sub_div'";
	if($officeid!='' && $officeid!='0')
		$sql.=" and office.officecd like '$officeid%'";
	if($officename!='')
		$sql.=" and office.office like '$officename%'";
	if($frmdt!='')
		$sql.=" and office.posted_date >= '$frmdt'";
	if($todt!='')
		$sql.=" and office.posted_date <= '$todt'";
	$sql.=" order by office.office";
	$sql.=" ASC LIMIT $p_num , $items";
//	echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}

//============================ Designation =====================================

function save_Designationdetails($desgcd,$designation,$usercd)
{
	$sql="insert into designation (desgcd,designation,usercode) values (";
	$sql.="'$desgcd','$designation','$usercd')";
	$i=execInsert($sql);
	connection_close();
	return $i;
}

function fatch_designation_maxcode()
{
	$sql;$rs;
	$sql="select max(desgcd) as desgcd from designation";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//============================= Data Transffer =================================================
function fatch_office_agsubdiv($subdiv_swp)
{
	$sql;$rs;
	$sql="select officecd,office from office where subdivisioncd='$subdiv_swp'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_post_stat_wise_dtl_available($subdiv,$pc)
{
	$sql="Select personnel.poststat,
	  Count(personnel.personcd) as total
	From personnel
	";
	$sql.="Left Join termination On personnel.personcd = termination.personal_id  
          WHERE (personnel.f_cd IS NULL or personnel.f_cd is null ) and termination.personal_id is null ";
	//$sql.=" where (personnel.f_cd Is Null Or personnel.f_cd = 0) and personnel.personcd not in (Select termination.personal_id from termination)";
	if($subdiv!='' && $subdiv!=0)
		$sql.=" and personnel.subdivisioncd='$subdiv'";
	if($pc!='' && $pc!=0)
		$sql.=" and pc.pccd='$pc'";
	$sql.=" Group By personnel.poststat
	Order By personnel.poststat";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_post_stat_wise_dtl_transffered($subdiv,$pc)
{
	$sql="Select personnela.poststat,
	  Count(personnela.personcd) As total
	From personnela";
	$sql.=" where 1";
	if($subdiv!='' && $subdiv!=0)
		$sql.=" and personnela.forsubdivision='$subdiv'";
	if($pc!='' && $pc!=0)
		$sql.=" and personnela.forpc='$pc'";
	$sql.=" Group By personnela.poststat
	Order By personnela.poststat";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//training available
function fatch_post_stat_wise_dtl_tran_pp_available($subdiv,$fsubdiv_cd)
{
	$sql="Select Count(training_pp.per_code) as total,poststat.poststatus,poststat.post_stat
			From poststat
			  Inner Join training_pp On training_pp.post_stat = poststat.post_stat
			where training_pp.for_subdivision='$fsubdiv_cd' and training_pp.subdivision='$subdiv' and training_pp.training_sch Is Null Group By poststat.poststatus,poststat.post_stat";
	//echo $sql; //exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_post_stat_wise_dtl_unbooked($subdiv,$pc)
{
	$sql="Select personnela.poststat,
	  Count(personnela.personcd) As total
	From personnela
	  Inner Join pc On personnela.forpc = pc.pccd And personnela.forsubdivision =
		pc.subdivisioncd";
	$sql.=" where (booked='' or booked is null)";
	if($subdiv!='' && $subdiv!=0)
		$sql.=" and personnela.forsubdivision='$subdiv'";
	if($pc!='' && $pc!=0)
		$sql.=" and personnela.forpc='$pc'";
	$sql.=" Group By personnela.poststat
	Order By personnela.poststat";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//===========================Fatch Personal Details for Ls14=================================
/*function fatch_PersonaldtlAgSubdiv($subdivision,$pc,$ex_ass,$officename,$posting_status)
{
	$sql="Select personnel.personcd, personnel.officecd, personnel.officer_name, personnel.off_desg, personnel.present_addr1,
	  personnel.present_addr2, personnel.perm_addr1, personnel.perm_addr2, Date_Format(personnel.dateofbirth, '%Y-%m-%d') As dateofbirth,
	  personnel.gender, personnel.scale, personnel.basic_pay, personnel.grade_pay, personnel.workingstatus, personnel.email,
	  personnel.resi_no, personnel.mob_no, personnel.qualificationcd, personnel.languagecd, personnel.epic, personnel.acno,
	  personnel.slno, personnel.partno, personnel.poststat, personnel.assembly_temp, personnel.assembly_off, personnel.assembly_perm,
	  personnel.districtcd, personnel.subdivisioncd, personnel.bank_acc_no, personnel.bank_cd, personnel.branchcd,
	  personnel.remarks, personnel.pgroup, personnel.upload_file, personnel.usercode, personnel.posted_date, personnel.f_cd
	From personnel
	  Left Join termination On personnel.personcd = termination.personal_id  
          WHERE  (personnel.f_cd IS NULL or personnel.f_cd='0') and termination.personal_id is null";
	if($subdivision!='' && $subdivision!='0')
		  $sql.=" and personnel.subdivisioncd= '$subdivision'";
	if($pc!='' && $pc!='0')
		  $sql.=" and assembly.pccd='$pc'";
	if($ex_ass!='' && $ex_ass!='0')
		  $sql.=" and personnel.assembly_temp<>'$ex_ass'and personnel.assembly_off<>'$ex_ass'and personnel.assembly_perm<>'$ex_ass'";
	if($officename!='' && $officename!='0')
		  $sql.=" and personnel.officecd='$officename'";
	if($posting_status!='' && $posting_status!='0')
		  $sql.=" and personnel.poststat ='$posting_status'";
	$sql.=" order by rand()";
		//  echo $sql; exit;
	$rs=execSelect($sql);
//	connection_close();
	return $rs;
}*/
//////Swapping pp////////
function fatch_PersonaldtlAgSubdiv($subdivision,$pc,$ex_ass,$officename,$posting_status,$numberofemployee,$forsubdivision,$ex_ass1,$ex_ass2,$gender)
{
	$sql1="insert into personnela (personcd,officecd,officer_name,off_desg,present_addr1,present_addr2,";
$sql1.="perm_addr1,perm_addr2,dateofbirth,gender,scale,basic_pay,grade_pay,workingstatus,email,resi_no, mob_no,qualificationcd,languagecd,epic,acno,slno,partno,poststat,assembly_temp,assembly_off,assembly_perm,districtcd,subdivisioncd,bank_acc_no,bank_cd, branchcd, remarks, pgroup, upload_file,usercode)";

$sql1.=" Select personnel.personcd, personnel.officecd, personnel.officer_name, personnel.off_desg, personnel.present_addr1,
	  personnel.present_addr2, personnel.perm_addr1, personnel.perm_addr2, Date_Format(personnel.dateofbirth, '%Y-%m-%d') As dateofbirth,
	  personnel.gender, personnel.scale, personnel.basic_pay, personnel.grade_pay, personnel.workingstatus, personnel.email,
	  personnel.resi_no, personnel.mob_no, personnel.qualificationcd, personnel.languagecd, personnel.epic, personnel.acno,
	  personnel.slno, personnel.partno, personnel.poststat, personnel.assembly_temp, personnel.assembly_off, personnel.assembly_perm,
	  personnel.districtcd, personnel.subdivisioncd, personnel.bank_acc_no, personnel.bank_cd, personnel.branchcd,
	  personnel.remarks, personnel.pgroup, personnel.upload_file, personnel.usercode
	From personnel	
	Left Join termination On personnel.personcd = termination.personal_id  
          WHERE  (personnel.f_cd IS NULL or personnel.f_cd='0') and termination.personal_id is null";
    if($subdivision!='' && $subdivision!='0')
		  $sql1.=" and personnel.subdivisioncd= '$subdivision'";
	if($pc!='' && $pc!='0')
		  $sql1.=" and assembly.pccd='$pc'";
	if($ex_ass!='' && $ex_ass!='0')
		  $sql1.=" and personnel.assembly_temp<>'$ex_ass'and personnel.assembly_off<>'$ex_ass'and personnel.assembly_perm<>'$ex_ass'";
    if($ex_ass1!='' && $ex_ass1!='0')
		  $sql1.=" and personnel.assembly_temp<>'$ex_ass1'and personnel.assembly_off<>'$ex_ass1'and personnel.assembly_perm<>'$ex_ass1'";
	if($ex_ass2!='' && $ex_ass2!='0')
		  $sql1.=" and personnel.assembly_temp<>'$ex_ass2'and personnel.assembly_off<>'$ex_ass2'and personnel.assembly_perm<>'$ex_ass2'";
	if($officename!='' && $officename!='0')
		  $sql1.=" and personnel.officecd='$officename'";
	if($gender!='' && $gender!='0')
		  $sql1.=" and personnel.gender='$gender'";
	if($posting_status!='' && $posting_status!='0')
		  $sql1.=" and personnel.poststat ='$posting_status'";
	     $sql1.=" order by rand()";
    if($numberofemployee!='' && $numberofemployee!='0')
	      $sql1.=" LIMIT $numberofemployee";
	//echo $sql1;
	//exit;
    execInsert($sql1);
	
	$sql2="Update personnel
	   JOIN personnela ON personnel.personcd=personnela.personcd 
       set personnel.f_cd=1 
       WHERE personnela.forsubdivision is null or personnela.forsubdivision ='' ";
   execUpdate($sql2);
   
   $cntsql="Select count(*) as cnt from personnela 
		WHERE personnela.forsubdivision is null or personnela.forsubdivision =''";
    $countrs=execSelect($cntsql);
	$crow=getRows($countrs);
	$cd_cnt=$crow['cnt'];

	$upsql="Update personnela 
        SET personnela.forsubdivision='$forsubdivision'
		WHERE personnela.forsubdivision is null or personnela.forsubdivision =''";

    execUpdate($upsql);
	
	return $cd_cnt;
}
////Extra Swapping PP/////
function fatch_PersonaldtlAgSubdiv_extra($subdivision,$pc,$ex_ass,$officename,$posting_status,$numberofemployee,$forsubdivision,$ex_ass1,$ex_ass2,$gender)
{
	$sql1="insert into personnela (personcd,officecd,officer_name,off_desg,present_addr1,present_addr2,";
$sql1.="perm_addr1,perm_addr2,dateofbirth,gender,scale,basic_pay,grade_pay,workingstatus,email,resi_no, mob_no,qualificationcd,languagecd,epic,acno,slno,partno,poststat,assembly_temp,assembly_off,assembly_perm,districtcd,subdivisioncd,bank_acc_no,bank_cd, branchcd, remarks, pgroup, upload_file,usercode)";

$sql1.=" Select personnel.personcd, personnel.officecd, personnel.officer_name, personnel.off_desg, personnel.present_addr1,
	  personnel.present_addr2, personnel.perm_addr1, personnel.perm_addr2, Date_Format(personnel.dateofbirth, '%Y-%m-%d') As dateofbirth,
	  personnel.gender, personnel.scale, personnel.basic_pay, personnel.grade_pay, personnel.workingstatus, personnel.email,
	  personnel.resi_no, personnel.mob_no, personnel.qualificationcd, personnel.languagecd, personnel.epic, personnel.acno,
	  personnel.slno, personnel.partno, personnel.poststat, personnel.assembly_temp, personnel.assembly_off, personnel.assembly_perm,
	  personnel.districtcd, personnel.subdivisioncd, personnel.bank_acc_no, personnel.bank_cd, personnel.branchcd,
	  personnel.remarks, personnel.pgroup, personnel.upload_file, personnel.usercode
	From personnel	
	Left Join termination On personnel.personcd = termination.personal_id  
          WHERE  (personnel.f_cd IS NULL or personnel.f_cd='0') and termination.personal_id is null";
    if($subdivision!='' && $subdivision!='0')
		  $sql1.=" and personnel.subdivisioncd= '$subdivision'";
	if($pc!='' && $pc!='0')
		  $sql1.=" and assembly.pccd='$pc'";
	if($ex_ass!='' && $ex_ass!='0')
		  $sql1.=" and personnel.assembly_temp<>'$ex_ass'and personnel.assembly_off<>'$ex_ass'and personnel.assembly_perm<>'$ex_ass'";
    if($ex_ass1!='' && $ex_ass1!='0')
		  $sql1.=" and personnel.assembly_temp<>'$ex_ass1'and personnel.assembly_off<>'$ex_ass1'and personnel.assembly_perm<>'$ex_ass1'";
	if($ex_ass2!='' && $ex_ass2!='0')
		  $sql1.=" and personnel.assembly_temp<>'$ex_ass2'and personnel.assembly_off<>'$ex_ass2'and personnel.assembly_perm<>'$ex_ass2'";
	if($officename!='' && $officename!='0')
		  $sql1.=" and personnel.officecd='$officename'";
	if($gender!='' && $gender!='0')
		  $sql1.=" and personnel.gender='$gender'";
	if($posting_status!='' && $posting_status!='0')
		  $sql1.=" and personnel.poststat ='$posting_status'";
	     $sql1.=" order by rand()";
    if($numberofemployee!='' && $numberofemployee!='0')
	      $sql1.=" LIMIT $numberofemployee";
	//echo $sql1;
	//exit;
    execInsert($sql1);
	
	$sql2="Update personnel
	   JOIN personnela ON personnel.personcd=personnela.personcd 
       set personnel.f_cd=1 
       WHERE personnela.forsubdivision is null or personnela.forsubdivision ='' ";
   execUpdate($sql2);
   
   $cntsql="Select count(*) as cnt from personnela 
		WHERE personnela.forsubdivision is null or personnela.forsubdivision =''";
    $countrs=execSelect($cntsql);
	$crow=getRows($countrs);
	$cd_cnt=$crow['cnt'];
	
	//$sql21="Update personnela set ttrgschcopy=0";
   // execUpdate($sql21);
   
	$cntsql1="Select max(ttrgschcopy) as cnt from personnela where personnela.forsubdivision='$forsubdivision'";
    $countrs1=execSelect($cntsql1);
	$crow1=getRows($countrs1);
	if($crow1['cnt']==NULL)
	  $cd_cnt1=1;
	else
	  $cd_cnt1=$crow1['cnt']+1;

	$upsql="Update personnela 
        SET personnela.forsubdivision='$forsubdivision',
		personnela.selected=1,
		personnela.booked='P',
		personnela.ttrgschcopy='$cd_cnt1'
		WHERE personnela.forsubdivision is null or personnela.forsubdivision =''";

    execUpdate($upsql);
	
	return $cd_cnt;
}
//--------------------------------------------------------------
/****************************anti swapping*****************/
function fatch_Personaldtl_antiAgSubdiv($subdivision,$pc,$ex_ass,$officename,$posting_status,$numberofemployee,$forsubdivision)
{
   $sql1="Delete from personnela ";
   $sql1.=" where 1=1 ";
    if($forsubdivision!='' && $forsubdivision!='0')
		  $sql1.=" and personnela.forsubdivision= '$forsubdivision'";
	if($pc!='' && $pc!='0')
		  $sql1.=" and assembly.pccd='$pc'";
	if($ex_ass!='' && $ex_ass!='0')
		  $sql1.=" and personnela.assembly_temp<>'$ex_ass'and personnela.assembly_off<>'$ex_ass'and personnela.assembly_perm<>'$ex_ass'";
	if($officename!='' && $officename!='0')
		  $sql1.=" and personnela.officecd='$officename'";
	if($posting_status!='' && $posting_status!='0')
		  $sql1.=" and personnela.poststat ='$posting_status'";
	     $sql1.=" order by rand()";
    if($numberofemployee!='' && $numberofemployee!='0')
	      $sql1.=" LIMIT $numberofemployee";
	//$sql1.="";
//	echo $sql1;
//	exit;
    execDelete($sql1);
	
	$cntsql="Select count(*) as cnt from personnel 
	Left JOIN personnela ON personnel.personcd=personnela.personcd
		WHERE personnel.f_cd=1 and personnela.personcd is null";
    $countrs=execSelect($cntsql);
	$crow=getRows($countrs);
	$cd_cnt=$crow['cnt'];
	
	$sql2="Delete F from first_rand_table F
	Left Join personnela On personnela.personcd = F.personcd 
	 where personnela.personcd is null";
	 execDelete($sql2);
	 
	$sql3="Delete F from training_pp F
	Left Join personnela On personnela.personcd = F.per_code 
	 where personnela.personcd is null";
	 execDelete($sql3);
	 
	$upsql="Update personnel 
Left JOIN personnela ON personnel.personcd=personnela.personcd
set personnel.f_cd=NULL 	
		WHERE personnel.f_cd=1 and personnela.personcd is null";

    execUpdate($upsql);	
	return $cd_cnt;
}
//////reverse swapping(not booked)/////
function fatch_Personaldtl_antiAgSubdiv1($subdivision,$pc,$ex_ass,$officename,$posting_status,$numberofemployee,$forsubdivision)
{
   $sql1="Delete from personnela ";
   $sql1.=" where 1=1 and personnela.booked='' ";
    if($forsubdivision!='' && $forsubdivision!='0')
		  $sql1.=" and personnela.forsubdivision= '$forsubdivision'";
	if($pc!='' && $pc!='0')
		  $sql1.=" and assembly.pccd='$pc'";
	if($ex_ass!='' && $ex_ass!='0')
		  $sql1.=" and personnela.assembly_temp<>'$ex_ass'and personnela.assembly_off<>'$ex_ass'and personnela.assembly_perm<>'$ex_ass'";
	if($officename!='' && $officename!='0')
		  $sql1.=" and personnela.officecd='$officename'";
	if($posting_status!='' && $posting_status!='0')
		  $sql1.=" and personnela.poststat ='$posting_status'";
	     $sql1.=" order by rand()";
    if($numberofemployee!='' && $numberofemployee!='0')
	      $sql1.=" LIMIT $numberofemployee";
	//$sql1.="";
//	echo $sql1;
//	exit;
    execDelete($sql1);
	
	$cntsql="Select count(*) as cnt from personnel 
	Left JOIN personnela ON personnel.personcd=personnela.personcd
		WHERE personnel.f_cd=1 and personnela.personcd is null";
    $countrs=execSelect($cntsql);
	$crow=getRows($countrs);
	$cd_cnt=$crow['cnt'];
	
	$upsql="Update personnel 
Left JOIN personnela ON personnel.personcd=personnela.personcd
set personnel.f_cd=NULL 	
		WHERE personnel.f_cd=1 and personnela.personcd is null";

    execUpdate($upsql);	
	return $cd_cnt;
}
function fatch_dup_check($personcd)
{
	$sql;$rt;
	$sql="SELECT COUNT(personcd) as personcd FROM personnela WHERE personcd = '$personcd'";
	$rt=execSelect($sql);
	$row=getRows($rt);
	$cd_pers=$row['personcd'];
	connection_close();
	return $cd_pers;
}

//================================================
function save_personnel_LS14($personcd,$officecd,$officer_name,$off_desg,$present_addr1,$present_addr2,$perm_addr1,$perm_addr2,$dateofbirth,$gender,$scale,$basic_pay,$grade_pay,$workingstatus,$email,$resi_no,$mob_no,$qualificationcd,$languagecd,$epic,$acno,$slno,$partno,$poststat,$assembly_temp,$assembly_off ,$assembly_perm,$districtcd,$subdivision,$forsubdivision,$bank_acc_no,$bank_cd,$branchcd,$remarks,$pgroup,$upload_file,$usercd)
{
	try{
		$sql="insert into personnela (personcd,officecd,officer_name,off_desg,present_addr1,present_addr2,";
		$sql.="perm_addr1,perm_addr2,dateofbirth,gender,scale,basic_pay,grade_pay,workingstatus,email,resi_no, mob_no,";
		$sql.="qualificationcd,languagecd,epic,acno,slno,partno,poststat,assembly_temp,assembly_off,assembly_perm,";
		$sql.="districtcd,subdivisioncd,forsubdivision,bank_acc_no,";
		$sql.="bank_cd, branchcd, remarks, pgroup, upload_file,usercode) values (";
		$sql.="'$personcd','$officecd','$officer_name','$off_desg','$present_addr1','$present_addr2','$perm_addr1',";
		$sql.="'$perm_addr2','$dateofbirth','$gender','$scale','$basic_pay','$grade_pay','$workingstatus','$email','$resi_no','$mob_no',";
		$sql.="'$qualificationcd','$languagecd','$epic','$acno','$slno','$partno','$poststat',";
		$sql.="'$assembly_temp','$assembly_off','$assembly_perm','$districtcd',";
		$sql.="'$subdivision','$forsubdivision','$bank_acc_no','$bank_cd','$branchcd',";
		$sql.="'$remarks','$pgroup','$upload_file','$usercd')";
		
		$i=execInsert($sql);
		connection_close();
		return $i;
	}
	catch(Exception $e)
	{
  		echo "Message: " .$e->getMessage();
  	}
}
//================================
function update_personnel_blo($mobile,$chksetblo)
{
	$sql="update personnel set remarks='$chksetblo'";
	$sql.=" where mob_no='$mobile'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
//=====================update blo=====================
function update_personnelafttransf($personcd,$f_cd)
{
	$sql="update personnel set f_cd='$f_cd'";
	$sql.=" where personcd='$personcd'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
//===================================Personal_LS14=================================
function fatch_Personnel_ls14List($subdiv,$p_id,$post_status,$officeid,$frmdt,$todt,$usercode)
{
	$sql="Select personnela.personcd, personnela.officer_name, personnela.present_addr1, personnela.present_addr2, poststat.poststatus, personnela.usercode
          FROM poststat
          INNER JOIN personnela ON poststat.post_stat = personnela.poststat where personnela.personcd >0 ";
    if($subdiv!='0')
		$sql.=" and personnela.forsubdivision='$subdiv'";
	if($p_id!='')
		$sql.=" and personnela.personcd like '$p_id%'";
	if($post_status!='' && $post_status!='0')
	    $sql.=" and personnela.poststat ='$post_status'";
    if($officeid!='')
		$sql.=" and personnela.officecd like '$officeid%'";
	if($frmdt!='')
		$sql.=" and personnela.posted_date >= '$frmdt'";
	if($todt!='')
		$sql.=" and personnela.posted_date <= '$todt'";
	$sql.=" order by personnela.officer_name"; //echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_Personnel_ls14List1($subdiv,$p_id,$post_status,$officeid,$frmdt,$todt,$usercode,$p_num ,$items)
{
	$sql="Select personnela.personcd, personnela.officer_name, personnela.present_addr1, personnela.present_addr2, poststat.poststatus, personnela.usercode
          FROM poststat
          INNER JOIN personnela ON poststat.post_stat = personnela.poststat where personnela.personcd >0 ";
	if($subdiv!='0')
		$sql.=" and personnela.forsubdivision='$subdiv'";
	if($p_id!='')
		$sql.=" and personnela.personcd like '$p_id%'";
	if($post_status!='' && $post_status!='0')
	    $sql.=" and personnela.poststat ='$post_status'";
    if($officeid!='')
		$sql.=" and personnela.officecd like '$officeid%'";
	if($frmdt!='')
		$sql.=" and personnela.posted_date >= '$frmdt'";
	if($todt!='')
		$sql.=" and personnela.posted_date <= '$todt'";
	$sql.=" order by personnela.officer_name";
	$sql.=" ASC LIMIT $p_num , $items";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function personnela_details($personcd)
{
	$sql="SELECT personnela.personcd, personnela.officecd, office.office, personnela.officer_name, personnela.off_desg, personnela.present_addr1, personnela.present_addr2, personnela.perm_addr1, personnela.perm_addr2, Date_Format( personnela.dateofbirth, '%Y-%m-%d' ) AS dateofbirth, personnela.gender, personnela.scale, personnela.basic_pay, personnela.grade_pay, personnela.workingstatus, personnela.email, personnela.resi_no, personnela.mob_no, personnela.qualificationcd, personnela.languagecd, personnela.epic, personnela.slno, personnela.partno, personnela.poststat, personnela.assembly_temp, personnela.assembly_off, personnela.assembly_perm, personnela.acno, personnela.bank_acc_no, personnela.bank_cd, personnela.branchcd, personnela.remarks, personnela.pgroup, personnela.upload_file
FROM personnela
INNER JOIN office ON personnela.officecd = office.officecd";
  	$sql.=" where personnela.personcd='$personcd'";                            
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function update_personnela($p_id,$offcode,$empname,$designation,$preaddress1,$preaddress2,$peraddress1,$peraddress2,$workingstatus,$dob,$sex,$scale,$basicpay,$gradepay,$email,$r_no,$m_no,$qualification,$language,$epic_no,$sl_no,$partno,$posting_status,$ac_pre,$ac_posting,$ac_per,$voterof,$acc_no,$bank,$branch,$remarks,$group,$upload_file,$usercd,$posted_date)
{
	$sql="update personnela set 
			officecd='$offcode',
			officer_name='$empname',
			off_desg='$designation',
			present_addr1='$preaddress1',
			present_addr2='$preaddress2',
			perm_addr1='$peraddress1',
			perm_addr2='$peraddress2',
			workingstatus='$workingstatus',
			dateofbirth='$dob',
			gender='$sex',
			scale='$scale',
			basic_pay='$basicpay',
			grade_pay='$gradepay',
			email='$email',
			resi_no='$r_no',
			mob_no='$m_no',
			qualificationcd='$qualification',
			languagecd='$language',
			epic='$epic_no',
			slno='$sl_no',
			partno='$partno',	
			poststat='$posting_status',
			assembly_temp='$ac_pre',
			assembly_off='$ac_posting',
			assembly_perm='$ac_per',
			acno='$voterof',
			bank_acc_no='$acc_no',
			bank_cd='$bank',
			branchcd='$branch',	
			remarks='$remarks',
			pgroup='$group',
			upload_file='$upload_file',
			usercode='$usercd',
			posted_date='$posted_date'";
	$sql.=" where personcd='$p_id'";

	$i=execUpdate($sql);
	connection_close();
	return $i;
}
//=======================Delete Personal LS14================================
function personnela_del_check($per_code)
{
	$sql="Select count(personcd) as total1 From personnela where selected=1 and personcd='$per_code'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$total1=$row['total1'];
	unset($sql,$rs,$row);
	$sql="Select count(per_code) as total2 From training_pp where per_code='$per_code'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$total2=$row['total2'];
	unset($sql,$rs,$row);
	connection_close();
	return ($total1>0?$total1:($total2>0?$total2:0));
}
function delete_personnela($pr_cd)
{
	$sql="DELETE FROM personnela WHERE personcd='$pr_cd'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}

//=======================================================
//================================ Assembly Party =================================
function fatch_max_end_asm_party($subdivision,$assembly)
{
	 $sql="Select max(no_party) as cnt from  assembly_party where subdivisioncd='$subdivision' and assemblycd='$assembly'";
	 if($member!='' && $member!='0')
		$sql.=" and no_of_member ='$member'";
	   $rs=execSelect($sql);
	   $row=getRows($rs);
	   $total=$row['cnt'];
	   return $total;
}
function duplicate_Assembly_party($assembly,$member)
{
	$sql="select count(*) as duplicate_rec from assembly_party where assemblycd='$assembly' and no_of_member='$member'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$c_Ass=$row['duplicate_rec'];
	connection_close();
	return $c_Ass;
}
function fetch_Assembly_party($assembly,$subdivision)
{
	$sql;$rs;
    $i=0;
    $data_list=array();
	
    $sql="select  start_sl, no_party ,subdivisioncd,assemblycd,no_of_member from assembly_party where assemblycd='$assembly' and subdivisioncd='$subdivision'";
   	$rs=execSelect($sql);
	while($asm_status = getRows($rs)) {
	$data_list[$i]['sl']=$asm_status['start_sl'];
	$data_list[$i]['np']=$asm_status['no_party'];
	$data_list[$i]['sdcd']=$asm_status['subdivisioncd'];
	$data_list[$i]['asmcd']=$asm_status['assemblycd'];
	$data_list[$i]['no_m']=$asm_status['no_of_member'];
	$i++;
	}
	return $data_list;
	
}
function update_next_party_sl($sum_pp,$next_sdcd,$next_asmcd,$next_no_m)
{
	$sql="update assembly_party set start_sl='$sum_pp' where assemblycd='$next_asmcd' and subdivisioncd='$next_sdcd' and no_of_member='$next_no_m'";
	//echo $sql;
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
function update_Assembly_slno($assembly,$subdivision)
{
	$sql1="Update assembly_party set start_sl=0 where assemblycd='$assembly' and subdivisioncd='$subdivision'";
	$i=execUpdate($sql1);
	connection_close();
	return $i;
}
function save_assembly_party($subdivision,$pc,$assembly,$member,$party_req,$usercd)
{
	$sql="insert into assembly_party (assemblycd, no_of_member, pccd, no_party, subdivisioncd, usercode) values ('$assembly','$member','$pc','$party_req', '$subdivision','$usercd')";
	$i=execInsert($sql);
	connection_close();
	return $i;
}
function save_reserve($assembly,$member,$poststat,$no_or_pc,$numb,$subdivision,$forpc,$usercd)
{
	$sql="insert into reserve (forassembly, number_of_member, poststat, no_or_pc, numb, forsubdivision, forpc, usercode) values ('$assembly','$member','$poststat','$no_or_pc','$numb','$subdivision','$forpc','$usercd')";
	$i=execInsert($sql);
	connection_close();
	return $i;
}

function fatch_reserve_ag_assembly($assembly,$noofmember)
{
	$sql="Select reserve.forassembly,
	  reserve.number_of_member,
	  reserve.poststat,
	  reserve.no_or_pc,
	  reserve.numb,
	  assembly.assemblyname,
	  pc.pcname,
	  pc.pccd
	From reserve
	  Inner Join assembly On reserve.forassembly = assembly.assemblycd
	  Inner Join pc On assembly.pccd = pc.pccd And assembly.subdivisioncd =
		pc.subdivisioncd where 1 ";
	if($assembly!='')
		$sql.=" and reserve.forassembly='$assembly'";
	if($noofmember!='')
		$sql.=" and number_of_member='$noofmember'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_assembly_party_list($subdiv,$pc)
{
	$sql="Select assembly_party.assemblycd,
	  assembly_party.no_of_member,
	  assembly_party.no_party,
	  assembly.assemblyname,
	  subdivision.subdivision,
	  assembly_party.pccd,
	  pc.pcname
	From assembly_party
	  Inner Join assembly On assembly_party.assemblycd = assembly.assemblycd
	  Inner Join pc On assembly_party.pccd = pc.pccd And assembly_party.subdivisioncd =
		pc.subdivisioncd inner join subdivision on subdivision.subdivisioncd=assembly_party.subdivisioncd
		where assembly_party.assemblycd>0";
	if($subdiv!='' && $subdiv!=NULL && $subdiv!=0)
		$sql.=" and assembly_party.subdivisioncd='$subdiv'";
	if($pc!='' && $pc!=NULL && $pc!=0)	
		$sql.="  and assembly_party.pccd='$pc'";
	$sql.=" order by assembly_party.subdivisioncd,assembly_party.pccd,assembly.assemblyname";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_assembly_party_details($assembly,$noofparty,$poststat)
{
	$sql="Select assembly_party.assemblycd,
	  assembly_party.no_of_member,
	  assembly_party.pccd,
	  assembly_party.no_party,
	  assembly_party.subdivisioncd,
	  reserve.poststat,
	  reserve.no_or_pc,
	  reserve.numb
	From reserve
	  Inner Join assembly_party On assembly_party.assemblycd = reserve.forassembly
		And assembly_party.no_of_member = reserve.number_of_member";
	$sql.=" where assembly_party.assemblycd='$assembly' and assembly_party.no_of_member='$noofparty' and reserve.poststat='$poststat'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function update_reserve($assembly,$member,$poststat,$no_or_pc,$numb,$usercd)
{
	$sql="update reserve set no_or_pc='$no_or_pc', numb='$numb', usercode='$usercd' where forassembly='$assembly' and number_of_member='$member' and poststat='$poststat'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
function assembly_party_del_check($ass,$no)
{
	$sql="Select count(*) as cnt From dcrcmaster where assemblycd='$ass' and no_of_member='$no'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt=$row['cnt'];
	//$sql1="delete from 	assembly_party where assemblycd='$ass' and no_of_member='$no'";
	//$i=execDelete($sql1);
	connection_close();
	return $cnt;
}
function delete_assembly_party_reserve($ass,$no)
{
	$sql="delete from reserve where forassembly='$ass' and number_of_member='$no'";
	execDelete($sql);
	$sql1="delete from 	assembly_party where assemblycd='$ass' and no_of_member='$no'";
	$i=execDelete($sql1);
	connection_close();
	return $i;
}
//===========================================Termination List===============================================
function fatch_termination_list($personalid,$frmdt,$todt,$usercode)
{
	$sql="Select termination.termination_id, termination.personal_id, personnel.officer_name, termination.termination_cause, Date_Format( termination.termination_date, '%Y-%m-%d' ) As termination_date, termination.users_id,
  termination.posted_date
From personnel
  Inner Join termination On personnel.personcd = termination.personal_id where termination.personal_id >0 ";
    if($personalid!='')
		$sql.=" and termination.personal_id='$personalid'";
	if($frmdt!='')
		$sql.=" and termination.posted_date >= '$frmdt'";
	if($todt!='')
		$sql.=" and termination.posted_date <= '$todt'";
	$sql.=" order by personnel.officer_name";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}

function fatch_termination_listAct($personalid,$frmdt,$todt,$usercode,$p_num ,$items)
{
	$sql="Select termination.termination_id, termination.personal_id, personnel.officer_name, termination.termination_cause, Date_Format( termination.termination_date, '%Y-%m-%d' ) As termination_date, termination.users_id,
  termination.posted_date 
From personnel
  Inner Join termination On personnel.personcd = termination.personal_id where termination.personal_id >0 ";
	 if($personalid!='')
		$sql.=" and termination.personal_id ='$personalid'";
	if($frmdt!='')
		$sql.=" and termination.posted_date >= '$frmdt'";
	if($todt!='')
		$sql.=" and termination.posted_date <= '$todt'";
	$sql.=" order by personnel.officer_name";
	$sql.=" ASC LIMIT $p_num , $items";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}


function Termination_details($termination_id)
{
	$sql="Select termination.termination_id, termination.personal_id, personnel.officer_name, termination.termination_cause,
  Date_Format(termination.termination_date, '%Y-%m-%d') As termination_date,
  termination.users_id,
  termination.remarks,
  termination.posted_date,personnel.personcd, personnel.usercode, personnel.officer_name, office.office, personnel.off_desg, personnel.scale,
          personnel.basic_pay, personnel.grade_pay, 
          personnel.mob_no,personnel.present_addr1,personnel.present_addr2,
         (Select assemblyname from assembly asmb where asmb.assemblycd = personnel.assembly_temp) As assembly_temp,
         (Select assemblyname from assembly asmb where asmb.assemblycd = personnel.assembly_off) As assembly_off,
         (Select assemblyname from assembly asmb where asmb.assemblycd = personnel.assembly_perm) As assembly_perm
From personnel                                                                       
  Inner Join termination On personnel.personcd = termination.personal_id 
  INNER JOIN office ON personnel.officecd = office.officecd ";
  	$sql.=" where termination.termination_id='$termination_id'";                            
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}

//========================SaveTermination===================================
function check_duplicate_personnelid($PersonalID,$ter_id)
{
	$sql="Select count(*) as cnt From termination where personal_id='$PersonalID' and termination_id<>'$ter_id'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt=$row['cnt'];
	connection_close();
	return $cnt;
}
function save_Termination($ter_id,$PersonalID,$TerminationCause,$DateofTermination,$Remarks,$usercd)
{
	$sql="insert into termination (personal_id,termination_cause,termination_date,remarks,users_id) values (";
	$sql.="'$PersonalID','$TerminationCause','$DateofTermination','$Remarks','$usercd')";
	$i=execInsert($sql);
	connection_close();
	return $i;
}
function update_Termination($ter_id,$PersonalID,$TerminationCause,$DateofTermination,$Remarks,$usercd,$posted_date)
{
	$sql="update termination set personal_id='$PersonalID',termination_cause='$TerminationCause',termination_date='$DateofTermination',remarks='$Remarks',users_id = '$usercd',posted_date = '$posted_date' where termination_id='$ter_id'";
	//echo $sql; exit;
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
function delete_Termination($delcode)
{
	$sql="delete from termination where termination_id='$delcode'";
	$i=execDelete($sql);
	connection_close();
	return $i;
}
//============================ Post status replacement==========================//
function update_post_status_replacement_in_group($p_id,$post_stat)
{
	$sql="update personnela set poststat='$post_stat' where personcd='$p_id'";
	$i=execUpdate($sql);
	//if($i==1)
//	{
		$sql1="update personnel set poststat='$post_stat' where personcd='$p_id'";
	    $i1=execUpdate($sql1);
	//}
	connection_close();
	return $i1;
}

?>
