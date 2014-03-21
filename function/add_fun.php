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
  	office.districtcd, office.institutecd From office";                       
  	$sql.=" where office.officecd='$offccd'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_personnel_maxcode($subdivisioncd)
{
	$sql;$rs;
	$sql="select max(personcd) as personcd from personnel where subdivisioncd='$subdivisioncd'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
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
	$sql="Select assemblycd, assemblyname From assembly where pccd='$pccd' and subdivisioncd='$sub_div' order by assemblyname asc";
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
	personnela.assembly_temp as pre_ass_cd,ass_pre.assemblyname AS pre_ass, personnela.assembly_perm as per_ass_cd,ass_per.assemblyname AS per_ass, personnela.assembly_off as post_ass_cd,ass_ofc.assemblyname AS post_ass,personnela.personcd, personnela.email, personnela.mob_no, personnela.poststat, personnela.forsubdivision
	 FROM personnela INNER JOIN
    office ON personnela.officecd = office.officecd INNER JOIN 
    assembly AS ass_pre ON personnela.assembly_temp = ass_pre.assemblycd INNER JOIN 
    assembly AS ass_ofc ON personnela.assembly_off = ass_ofc.assemblycd INNER JOIN 
    assembly AS ass_per ON personnela.assembly_perm = ass_per.assemblycd INNER JOIN 
    subdivision ON office.subdivisioncd = subdivision.subdivisioncd INNER JOIN 
    poststat ON personnela.poststat = poststat.post_stat INNER JOIN 
	policestation ON office.policestn_cd = policestation.policestationcd
	Left Join termination On personnela.personcd = termination.personal_id";
	$sql.=" WHERE personnela.personcd='$p_id' and termination.personal_id is null";

	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//=========================Personnel List==============================
function fatch_PersonnelList($officeid,$personcd,$frmdt,$todt,$usercode)
{
	$sql="Select personnel.personcd, personnel.officer_name, personnel.present_addr1, personnel.present_addr2, poststat.poststatus
			From personnel
		  Inner Join poststat On personnel.poststat = poststat.post_stat Left Join termination On personnel.personcd = termination.personal_id where personnel.personcd>0 And termination.personal_id Is Null and personnel.usercode='$usercode'";
	if($officeid<>'')
		$sql.=" and personnel.officecd like '$officeid%'";
	if($personcd<>'')
		$sql.=" and personnel.personcd like '$personcd%'";
	if($frmdt<>'')
		$sql.=" and personnel.posted_date >= '$frmdt'";
	if($todt<>'')
		$sql.=" and personnel.posted_date <= '$todt'";
	$sql.=" order by personnel.officer_name";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_PersonnelList1($officeid,$personcd,$frmdt,$todt,$usercode,$p_num,$items)
{
	$sql="Select personnel.personcd, personnel.officer_name, personnel.present_addr1, personnel.present_addr2, poststat.poststatus
			From personnel
		  Inner Join poststat On personnel.poststat = poststat.post_stat Left Join termination On personnel.personcd = termination.personal_id where personnel.personcd>0 And termination.personal_id Is Null and personnel.usercode='$usercode'";
	if($officeid<>'')
		$sql.=" and personnel.officecd like '$officeid%'";
	if($personcd<>'')
		$sql.=" and personnel.personcd like '$personcd%'";
	if($frmdt<>'')
		$sql.=" and personnel.posted_date >= '$frmdt'";
	if($todt<>'')
		$sql.=" and personnel.posted_date <= '$todt'";
	$sql.=" order by personnel.officer_name";
	$sql.=" ASC LIMIT $p_num , $items";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function person_details($personcd)
{
	$sql="SELECT personnel.personcd, personnel.officecd, office.office, personnel.officer_name, personnel.off_desg, personnel.present_addr1, personnel.present_addr2, personnel.perm_addr1, personnel.perm_addr2, Date_Format( personnel.dateofbirth, '%Y-%m-%d' ) AS dateofbirth, personnel.gender, personnel.scale, personnel.basic_pay, personnel.grade_pay, personnel.workingstatus, personnel.email, personnel.resi_no, personnel.mob_no, personnel.qualificationcd, personnel.languagecd, personnel.epic, personnel.slno, personnel.partno, personnel.poststat, personnel.assembly_temp, personnel.assembly_off, personnel.assembly_perm, personnel.acno, personnel.bank_acc_no, personnel.bank_cd, personnel.branchcd, personnel.remarks, personnel.pgroup, personnel.upload_file
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
function fatch_office_maxcode($subdivisioncd)
{
	$sql;$rs;
	$sql="select max(officecd) as officecd from office where subdivisioncd='$subdivisioncd'";
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
function save_officedetails($OfficeID,$designationOic,$officename,$Street,$Town,$PostOffice,$Pincode,$Municipality,	$PoliceStation,$Statusofoffice,$email,$Ph_no,$Mb_no,$FAX_no,$ExistingStaff,$MaleStaff,$FemaleStaff,$Subdivision,$dist_code,$Natureofoffice,$usercd)
{
	$sql="insert into office (officecd,officer_desg,office,address1,address2,postoffice,pin,";
	$sql.="blockormuni_cd,policestn_cd,govt,email,phone,mobile,fax,tot_staff,male_staff,female_staff,";
	$sql.="subdivisioncd,districtcd,institutecd,usercode) values (";
	$sql.="'$OfficeID','$designationOic','$officename','$Street','$Town','$PostOffice','$Pincode',";
	$sql.="'$Municipality','$PoliceStation','$Statusofoffice','$email','$Ph_no','$Mb_no','$FAX_no',";
	$sql.="'$ExistingStaff','$MaleStaff','$FemaleStaff','$Subdivision','$dist_code','$Natureofoffice','$usercd')";
	$i=execInsert($sql);
	connection_close();
	return $i;
}
function update_officedetails($OfficeID,$designationOic,$officename,$Street,$Town,$PostOffice,$Pincode,$Municipality,$PoliceStation,$Statusofoffice,$email,$Ph_no,$Mb_no,$FAX_no,$ExistingStaff,$MaleStaff,$FemaleStaff,$Subdivision,$dist_code,$Natureofoffice,$usercd,$posted_date)
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
	$sql="SELECT * FROM subdivision where subdivisioncd='$subdivcd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$subdivision=$row['subdivision'];
	connection_close();
	return $subdivision;
}
function fatch_Random_personnel_for_PreGroupReplacement($forpc,$ofc_id,$gender,$post_stat)
{
	$sqlc="select count(*) as cnt
	From personnela Inner Join office On personnela.officecd = office.officecd 
  	Inner Join policestation On office.policestn_cd = policestation.policestationcd
  	Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
  	Inner Join poststat On personnela.poststat = poststat.post_stat
  	Inner Join assembly As ass_pre On personnela.assembly_temp = ass_pre.assemblycd
  	Inner Join assembly ass_per On personnela.assembly_perm = ass_per.assemblycd
  	Inner Join assembly ass_ofc On personnela.assembly_off = ass_ofc.assemblycd
  	Inner Join district On district.districtcd = subdivision.districtcd
	Left Join termination On personnela.personcd = termination.personal_id ";
	$sqlc.="WHERE termination.personal_id is null and personnela.gender='$gender' and personnela.forpc='$forpc' and ";
	$sqlc.="(personnela.booked='' or personnela.booked is null) and personnela.poststat='$post_stat'";
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
	//print $sqlc; exit;
	$sql="Select personnela.personcd,personnela.officecd,personnela.officer_name,personnela.off_desg,office.address1,
  	office.address2,office.postoffice,policestation.policestation,subdivision.subdivision,district.district,
  	office.pin,DATE_FORMAT(personnela.dateofbirth,'%d-%m-%Y') as dateofbirth,personnela.gender,personnela.epic,
  	poststat.poststatus,personnela.present_addr1,personnela.present_addr2,ass_pre.assemblyname As pre_ass,
  	ass_per.assemblyname As per_ass,ass_ofc.assemblyname As post_ass 
	From personnela Inner Join office On personnela.officecd = office.officecd 
  	Inner Join policestation On office.policestn_cd = policestation.policestationcd 
  	Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
  	Inner Join poststat On personnela.poststat = poststat.post_stat
  	Inner Join assembly As ass_pre On personnela.assembly_temp = ass_pre.assemblycd 
  	Inner Join assembly ass_per On personnela.assembly_perm = ass_per.assemblycd
  	Inner Join assembly ass_ofc On personnela.assembly_off = ass_ofc.assemblycd 
  	Inner Join district On district.districtcd = subdivision.districtcd 
	Left Join termination On personnela.personcd = termination.personal_id ";
	$sql.="WHERE termination.personal_id is null and personnela.gender='$gender' and personnela.forpc='$forpc' and ";
	$sql.="(personnela.booked='' or personnela.booked is null) and personnela.poststat='$post_stat' ";
	if($mode=="own-sub")
		$sql.=" and personnela.subdivisioncd=substr('$ofc_id',1,4)";
	$sql.=" limit 1 offset $random_no";
	
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function update_personnel_PreGroupReplacement($p_id,$forassembly,$forpc,$booked,$selected)
{
	$sql="update personnela set booked='$booked',forpc='$forpc',selected='$selected' where personcd='$p_id'";
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

function fatch_Random_personnel_for_replacement($for_subdiv,$assembly,$posting_status,$groupid,$gender)
{
	$sqltmp="select officecd from personnela where groupid='$groupid' and personnela.forsubdivision='$for_subdiv' and personnela.forassembly='$assembly' and booked='P'";
	$rs_tmp=execSelect($sqltmp);
	$num_rows_tmp=rowCount($rs_tmp);
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
  	Inner Join assembly As ass_pre On personnela.assembly_temp = ass_pre.assemblycd
  	Inner Join assembly ass_per On personnela.assembly_perm = ass_per.assemblycd 
  	Inner Join assembly ass_ofc On personnela.assembly_off = ass_ofc.assemblycd
  	Inner Join district On district.districtcd = subdivision.districtcd 
	Left Join termination On personnela.personcd = termination.personal_id";
	$sqlc.=" WHERE termination.personal_id is null and personnela.gender='$gender' and personnela.assembly_temp<>'$assembly' and personnela.assembly_perm<>'$assembly' and personnela.assembly_off<>'$assembly' and personnela.poststat='$posting_status' ";
	$sqlc.=" and (personnela.booked='' or personnela.booked is null) and personnela.forsubdivision='$for_subdiv'";
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
  	poststat.poststatus,personnela.present_addr1,personnela.present_addr2,ass_pre.assemblyname As pre_ass,
  	ass_per.assemblyname As per_ass,ass_ofc.assemblyname As post_ass
	From personnela Inner Join office On personnela.officecd = office.officecd
  	Inner Join policestation On office.policestn_cd = policestation.policestationcd 
  	Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
  	Inner Join poststat On personnela.poststat = poststat.post_stat
  	Inner Join assembly As ass_pre On personnela.assembly_temp = ass_pre.assemblycd 
  	Inner Join assembly ass_per On personnela.assembly_perm = ass_per.assemblycd
  	Inner Join assembly ass_ofc On personnela.assembly_off = ass_ofc.assemblycd
  	Inner Join district On district.districtcd = subdivision.districtcd
	Left Join termination On personnela.personcd = termination.personal_id ";
	$sql.=" WHERE termination.personal_id is null and personnela.gender='$gender' and personnela.assembly_temp<>'$assembly' and personnela.assembly_perm<>'$assembly' and personnela.assembly_off<>'$assembly' and personnela.poststat='$posting_status' ";
	$sql.=" and (personnela.booked='' or personnela.booked is null) and personnela.forsubdivision='$for_subdiv'";
	for($i=0;$i<$num_rows_tmp;$i++)
	{
		$sql.=" and personnela.officecd<>'$office[$i]'";
	}
	$sql.=" limit 1 offset $random_no";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function update_personnel_replacement($p_id,$groupid,$ass,$forpc,$booked,$selected)
{
	$sql="update personnela set booked='$booked',groupid='$groupid',forpc='$forpc',forassembly='$ass',selected='$selected' where personcd='$p_id'";
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
	}	
	connection_close();
	return $i;
}
//=========================FatchPersonal==============================
function fatch_Personaldtl($PersonalCd)
{
	$sql="SELECT personnel.personcd, personnel.usercode, personnel.officer_name, office.office, personnel.off_desg, personnel.scale,
          personnel.basic_pay, personnel.grade_pay, 
          personnel.mob_no,personnel.present_addr1,personnel.present_addr2,
		 (Select assemblyname from assembly asmb where asmb.assemblycd = personnel.assembly_temp) As assembly_temp,
         (Select assemblyname from assembly asmb where asmb.assemblycd = personnel.assembly_off) As assembly_off,
         (Select assemblyname from assembly asmb where asmb.assemblycd = personnel.assembly_perm) As assembly_perm
          FROM personnel
          INNER JOIN office ON personnel.officecd = office.officecd where personcd='$PersonalCd'";
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
//	if($sub_div!='' && $sub_div!='0')
//		$sql.=" and office.subdivisioncd='$sub_div'";
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
//	if($sub_div!='' && $sub_div!='0')
//		$sql.=" and office.subdivisioncd='$sub_div'";
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
	  Inner Join assembly On personnel.acno = assembly.assemblycd
	  Inner Join pc On assembly.pccd = pc.pccd And assembly.subdivisioncd =
		pc.subdivisioncd";
	$sql.=" where (personnel.f_cd Is Null Or personnel.f_cd = 0)";
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
	From personnela
	  Inner Join pc On personnela.forpc = pc.pccd And personnela.forsubdivision =
		pc.subdivisioncd";
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
function fatch_PersonaldtlAgSubdiv($subdivision,$pc,$ex_ass,$officename,$posting_status)
{
	$sql="Select personnel.personcd, personnel.officecd, personnel.officer_name, personnel.off_desg, personnel.present_addr1,
	  personnel.present_addr2, personnel.perm_addr1, personnel.perm_addr2, Date_Format(personnel.dateofbirth, '%Y-%m-%d') As dateofbirth,
	  personnel.gender, personnel.scale, personnel.basic_pay, personnel.grade_pay, personnel.workingstatus, personnel.email,
	  personnel.resi_no, personnel.mob_no, personnel.qualificationcd, personnel.languagecd, personnel.epic, personnel.acno,
	  personnel.slno, personnel.partno, personnel.poststat, personnel.assembly_temp, personnel.assembly_off, personnel.assembly_perm,
	  personnel.districtcd, personnel.subdivisioncd, personnel.bank_acc_no, personnel.bank_cd, personnel.branchcd,
	  personnel.remarks, personnel.pgroup, personnel.upload_file, personnel.usercode, personnel.posted_date, personnel.f_cd, assembly.pccd
	From personnel
	  Left Join termination On personnel.personcd = termination.personal_id
	  Inner Join assembly On personnel.acno = assembly.assemblycd     
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
//		  echo $sql; exit;
	$rs=execSelect($sql);
//	connection_close();
	return $rs;
}
//--------------------------------------------------------------
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
function duplicate_Assembly_party($assembly,$member)
{
	$sql="select count(*) as duplicate_rec from assembly_party where assemblycd='$assembly' and no_of_member='$member'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$c_Ass=$row['duplicate_rec'];
	connection_close();
	return $c_Ass;
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
		pc.subdivisioncd";
	$sql.=" where reserve.forassembly='$assembly' and number_of_member='$noofmember'";
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
//============================ 
?>
