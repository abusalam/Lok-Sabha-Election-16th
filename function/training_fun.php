<?php
include_once('string_fun.php');
function fatch_training_type_maxcode()
{
	$sql;$rs;
	$sql="select max(training_code) as training_code from training_type";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_training_type($training_code,$training_desc)
{
	$sql="select count(*) as c_training_type from training_type where training_code<>'$training_code' and training_desc='$training_desc'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$c_training_type=$row['c_training_type'];
	return $c_training_type;
}
function save_training_type($training_code,$training_desc,$usercode)
{
	$sql="insert into training_type (training_code, training_desc, usercode) values ('$training_code','$training_desc','$usercode')";
	$i=execInsert($sql);
	return $i;
}
function update_training_type($training_code,$training_desc,$usercd,$posted_date)
{
	$sql="update training_type set training_desc='$training_desc',usercode='$usercd',posted_date='$posted_date' where training_code='$training_code'";
	$i=execUpdate($sql);
	return $i;
}
function fatch_training_type($training_code)
{
	$sql="Select training_code, training_desc From training_type";
	if($training_code!='' && $training_code!='0')
		$sql.=" where training_code='$training_code'";
	$sql.=" order by training_code";
	$rs=execSelect($sql);
	return $rs;
}
function check_training_delete($training_code)
{
	$sql="Select Count(training_pp.per_code) as cnt from training_pp where training_pp.training_type='$training_code'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt=$row['cnt'];
	return $cnt;
}
function delete_training_type($training_code)
{
	$sql="delete from training_type where training_code='$training_code'";
	//echo $sql;
	$i=execDelete($sql);
	return $i;
}

//=========================Training Requirement==========================
function delete_training_pp($training_type,$post_status,$subdivision)
{
	$sql="delete from training_pp where training_type='$training_type' and for_subdivision='$subdivision' and post_stat='$post_status'";
	$i=execDelete($sql);
	return $i;
}
function fatch_employee_for_training_req($usercd,$post_status,$subdivision,$training_type)
{
	/*$sql="Select personnela.personcd,
		  personnela.officer_name,
		  personnela.off_desg,
		  personnela.subdivisioncd,
		  personnela.forsubdivision,
		  personnela.forpc,
		  personnela.assembly_temp,
		  personnela.assembly_off,
		  personnela.assembly_perm
		From personnela Left Join termination On personnela.personcd = termination.personal_id 
		Left Join training_pp On personnela.personcd = training_pp.per_code
		Where personnela.personcd > 0 and  termination.personal_id is null  and (personnela.booked='P' or personnela.booked='R')";*/
	$sql="insert into training_pp (usercode,training_type,per_code,per_name,designation,post_stat,subdivision,for_subdivision,for_pc,assembly_temp,";
	$sql.="assembly_off, assembly_perm)";
	
	$sql.="Select '$usercd','$training_type',personnela.personcd,
		  personnela.officer_name,
		  personnela.off_desg,
		  personnela.poststat,
		  personnela.subdivisioncd,
		  personnela.forsubdivision,
		  personnela.forpc,
		  personnela.assembly_temp,
		  personnela.assembly_off,
		  personnela.assembly_perm
		From personnela 
		Where personnela.personcd > 0 and (personnela.booked='P' or personnela.booked='R')";
	$sql.=" and personnela.poststat='$post_status' and personnela.forsubdivision='$subdivision' order by personnela.personcd";
	//echo $sql; exit;
	execSelect($sql);
	
	/*$sql2="Update training_pp
	   JOIN personnela ON training_pp.per_code=personnela.personcd 
       set training_pp.training_type='$training_type', training_pp.training_sch=NULL,
			training_pp.training_booked=NULL,
			training_pp.training_attended=NULL,
			training_pp.training_showcause=NULL,
			training_pp.usercode='$usercd'
       Where personnela.personcd > 0 and (personnela.booked='P' or personnela.booked='R') and personnela.poststat='$post_status' and personnela.forsubdivision='$subdivision'";
	   //echo $sql2; exit;
   execUpdate($sql2);*/
   
   $cntsql="Select count(*) as cnt from training_pp 
		where training_type='$training_type' and for_subdivision='$subdivision' and post_stat='$post_status'";
    $countrs=execSelect($cntsql);
	$crow=getRows($countrs);
	$cd_cnt=$crow['cnt'];
	
	return $cd_cnt;
}
//training requirement extra PP
function duplicate_training_pp_for_extra($subdivision,$training_type,$phase)
{
	$sql="Select count(*) as cnt from training_pp 
	Inner Join personnela On personnela.personcd = training_pp.per_code 
	where personnela.selected = 1 and personnela.booked='P' and personnela.ttrgschcopy='$phase' and training_pp.training_type='$training_type' and personnela.forsubdivision='$subdivision'";
	$countrs=execSelect($sql);
	$crow=getRows($countrs);
	$cd_cnt=$crow['cnt'];
	return $cd_cnt;
}
function fatch_employee_for_training_req_extra($usercd,$phase,$training_type,$subdivision)
{
	$sql="insert into training_pp (usercode,training_type,per_code,per_name,designation,post_stat,subdivision,for_subdivision,for_pc,assembly_temp,";
	$sql.="assembly_off, assembly_perm)";
	
	$sql.="Select '$usercd','$training_type',personnela.personcd,
		  personnela.officer_name,
		  personnela.off_desg,
		  personnela.poststat,
		  personnela.subdivisioncd,
		  personnela.forsubdivision,
		  personnela.forpc,
		  personnela.assembly_temp,
		  personnela.assembly_off,
		  personnela.assembly_perm
		From personnela 
		Where personnela.personcd > 0 and personnela.booked='P' and personnela.selected=1";
	$sql.=" and personnela.ttrgschcopy='$phase' and personnela.forsubdivision='$subdivision' order by personnela.personcd";
	//echo $sql; exit;
	execSelect($sql);
	
   
   $cntsql="Select count(*) as cnt from personnela 
		where personnela.booked='P' and personnela.selected=1 and personnela.ttrgschcopy='$phase' and personnela.forsubdivision='$subdivision'";
    $countrs=execSelect($cntsql);
	$crow=getRows($countrs);
	$cd_cnt=$crow['cnt'];
	
	/*$sql2="Update personnela
       set personnela.ttrgschcopy=1
       Where personnela.booked='P' and personnela.selected=1 and personnela.ttrgschcopy=2";
	   //echo $sql2; exit;
    execUpdate($sql2);*/
	
	return $cd_cnt;
}
function save_training_req($per_code,$per_name,$per_desg,$training_type,$post_status,$subdivision,$for_subdiv,$for_pc,$ass_temp,$ass_off,$ass_per,$usercode)
{
	$sql="insert into training_pp (per_code,per_name,designation,training_type,post_stat,subdivision,for_subdivision,for_pc,assembly_temp, assembly_off, assembly_perm, usercode ) values ('$per_code','$per_name','$per_desg','$training_type','$post_status','$subdivision', '$for_subdiv','$for_pc','$ass_temp','$ass_off','$ass_per','$usercode')";
	$i=execInsert($sql);
	return $i;
}
function fatch_no_of_PP_selected($subdivision)
{
	$sql="Select Count(training_pp.per_code) as total, training_type.training_desc, training_pp.post_stat, poststat.poststatus
		From training_pp
  		Right Join poststat On training_pp.post_stat = poststat.post_stat 
		Inner Join training_type On training_pp.training_type = training_type.training_code
		where training_pp.for_subdivision='$subdivision'
		Group By training_type.training_desc, training_pp.post_stat,
  		poststat.poststatus
		order by training_pp.training_type,poststat.poststatus";
	$rs=execSelect($sql);
	return $rs;
}

//============================Venue Details===================================
function fatch_venue_maxcode($subdiv_cd)
{
	$sql;$rs;
	$sql="select max(venue_cd) as venue_cd from training_venue where subdivisioncd='$subdiv_cd'";
	$rs=execSelect($sql);
	return $rs;
}
function save_trainingvenue($venue_cd,$subdiv_cd,$venuename,$venueaddress1,$venueaddress2,$maximumcapacity,$usercd,$assembly)
{
	$sql="insert into training_venue (venue_cd,subdivisioncd,venuename,venueaddress1,venueaddress2,maximumcapacity,usercode,assemblycd) values (";
	$sql.="'$venue_cd','$subdiv_cd','$venuename','$venueaddress1','$venueaddress2','$maximumcapacity','$usercd','$assembly')";
	$i=execInsert($sql);
	return $i;
}
function fatch_training_venue($venue_cd)
{
	$sql="Select training_venue.venue_cd,
		  training_venue.subdivisioncd,
		  training_venue.venuename,
		  training_venue.venueaddress1,
		  training_venue.venueaddress2,
		  training_venue.maximumcapacity
		From training_venue ";
	if($venue_cd<>'')
		$sql.=" where training_venue.venue_cd='$venue_cd'";
	$sql.=" order by training_venue.venue_cd";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_training_venue_ag_subdiv($subdiv)
{
	$sql="Select training_venue.venue_cd, training_venue.venuename From training_venue ";
	if($subdiv<>'')
		$sql.=" where training_venue.subdivisioncd='$subdiv'";
	$sql.=" order by training_venue.venuename";
	$rs=execSelect($sql);
	return $rs;
}
//====================================== Training Schedule ========================================
function venue_capacity($venue)
{
	$sql; $rs;
	$sql="Select training_venue.maximumcapacity From training_venue where training_venue.venue_cd='$venue'";
	$rs=execSelect($sql);
	return $rs;
}
function training_alloted($training_venue,$tr_type,$tr_date,$tr_time)
{
	$sql; $rs;
	$sql="Select Sum(training_schedule.no_pp) as total,training_schedule.post_status,poststat.poststatus,poststat.post_stat,
			training_schedule.training_dt,training_schedule.training_time 
			From training_schedule
			  Inner Join poststat On training_schedule.post_status = poststat.post_stat
			where training_schedule.training_venue='$training_venue' and training_schedule.training_type='$tr_type'";
//	if($tr_date!="" && $tr_time!="")
	$sql.=" and	training_schedule.training_dt='$tr_date' and training_schedule.training_time='$tr_time'";		
	$sql.="Group By training_schedule.training_dt,training_schedule.training_time,training_schedule.post_status,
			  poststat.poststatus,poststat.post_stat order by poststat.post_stat";
	$rs=execSelect($sql);
	return $rs;
}
function training_required($subdiv,$training_type)
{
	$sql; $rs;
	$sql="Select Count(training_pp.per_code) as total,poststat.poststatus,poststat.post_stat
			From poststat
			  Inner Join training_pp On training_pp.post_stat = poststat.post_stat
			where training_pp.for_subdivision='$subdiv' and training_pp.training_type='$training_type' Group By poststat.poststatus,poststat.post_stat";
	//		print $sql; exit;
	$rs=execSelect($sql);
	return $rs;
}
/*****************************training allocation1*******************/

function fetch_percentage_number($subdiv,$poststat)
{
	$sql; $rs;
	$sql="SELECT a.forassembly AS fasm, a.forsubdivision AS fsub, a.forpc AS fpc, a.number_of_member AS memb, a.no_or_pc AS npc, a.numb AS pnumb, a.poststat AS pst, b.no_party AS ptyrqd
FROM reserve a,  `assembly_party` b
WHERE a.forassembly = b.assemblycd
AND a.forsubdivision = b.subdivisioncd
AND a.number_of_member = b.no_of_member
AND a.forsubdivision =  '$subdiv'";
if($poststat!='')
		$sql.=" and a.poststat='$poststat'";
$rs=execSelect($sql);
	return $rs;
}
function fetch_training_post_schedule($subdiv,$post_stat,$tr_type)
{
	$sql; $rs;
	$sql="SELECT sum(no_pp) as total 
	    from training_schedule
		where substr(training_venue,1,4)='$subdiv' and training_type='$tr_type'";
    if($post_stat!='')
		$sql.=" and post_status='$post_stat'";
    $rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['total'];
	return $i;
}
function fetch_training_post_alloted($subdiv,$tr_type)
{
	$sql; $rs;
	$sql="SELECT sum(no_pp) as total ,training_schedule.post_status
	    from training_schedule
		where substr(training_venue,1,4)='$subdiv' and training_type='$tr_type'
		group by training_schedule.post_status";
    $rs=execSelect($sql);
	return $rs;
}
/**************************************end of traning allocation********************/
function training_alloted_forsub($subdiv,$training_type)
{
	$sql; $rs;
	$sql="Select Count(training_pp.per_code) as total,poststat.poststatus,poststat.post_stat
			From poststat
			  Inner Join training_pp On training_pp.post_stat = poststat.post_stat
			where training_pp.for_subdivision='$subdiv' and training_pp.training_type='$training_type' and training_pp.training_sch Is Not Null Group By poststat.poststatus,poststat.post_stat";
	$rs=execSelect($sql);
	return $rs;
}
function member_available($post_stat,$sub,$areapref,$area,$tr_type)
{
	$sql; $rs;
	$sql="Select Count(training_pp.per_code) as memb_avl From training_pp where post_stat='$post_stat' and training_type='$tr_type' and (training_sch='' or training_sch is null)";
	//$sql.=" and for_subdivision='$subdivision'";
	if($areapref=='S')
		$sql.=" and subdivision='$area' and for_subdivision='$sub'";
	if($areapref=='D')
		$sql.=" and for_subdivision='$area'";
	if($areapref=='T')
		$sql.=" and assembly_temp='$area' and subdivision='$sub'";
	if($areapref=='O')
		$sql.=" and assembly_perm='$area' and subdivision='$sub'";
	if($areapref=='P')
		$sql.=" and assembly_off='$area' and subdivision='$sub'";
	$sql.=" and (training_booked='' or training_booked is null)";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_schedule_maxcode($training_venue)
{
	$sql; $rs;
	$sql="select max(schedule_code) as schedule_code from training_schedule where training_venue='$training_venue'";
	$rs=execSelect($sql);
	return $rs;
}
function save_training_schedule($schedule_code,$training_venue,$training_type,$training_dt,$training_time,$post_status,$no_pp,$usercode)
{
	$sql="insert into training_schedule (schedule_code,training_venue,training_type,training_dt,training_time,post_status, no_pp, usercode) values ('$schedule_code','$training_venue','$training_type','$training_dt','$training_time','$post_status', '$no_pp','$usercode')";
	$i=execInsert($sql);
	return $i;
}
function save_training_schedule1($schedule_code,$training_venue,$training_type,$training_dt,$training_time,$post_status,$no_pp,$usercode,$choice_type,$choice_area)
{
	$sql="insert into training_schedule (schedule_code,training_venue,training_type,training_dt,training_time,post_status, no_pp, usercode, choice_type, choice_area) values ('$schedule_code','$training_venue','$training_type','$training_dt','$training_time','$post_status', '$no_pp','$usercode','$choice_type','$choice_area')";
	$i=execInsert($sql);
	return $i;
}

function fatch_personnel_ag_training_pp($training_type,$post_status,$sub,$areapref,$area,$no_pp)
{
	$sql; $rs;
	$sql="select per_code, per_name from training_pp where training_type='$training_type' and
	post_stat='$post_status' and (training_sch='' or training_sch is null) ";
	if($areapref=='S')
		$sql.=" and subdivision='$area' and for_subdivision='$sub'";
	if($areapref=='D')
		$sql.=" and for_subdivision='$area'";
	if($areapref=='T')
		$sql.=" and assembly_temp='$area' and subdivision='$sub'";
	if($areapref=='O')
		$sql.=" and assembly_perm='$area' and subdivision='$sub'";
	if($areapref=='P')
		$sql.=" and assembly_off='$area' and subdivision='$sub'";
	$sql.=" and (training_booked='' or training_booked is null)";
	$sql.=" limit 0, $no_pp";
//	echo $sql; exit;
	$rs=execSelect($sql);
	return $rs;
}
			//Area of Pref//
function fatch_subdiv_from_personal_trainingpp_ag_subdiv($subdiv_cd)
{
	$sql; $rs;
	$sql="Select distinct training_pp.subdivision,  subdivision.subdivision
			From subdivision
			  Inner Join training_pp On training_pp.subdivision =
			subdivision.subdivisioncd  where training_pp.for_subdivision='$subdiv_cd'";
	$rs=execSelect($sql);
	return $rs;
}
//---- Dist wise ----//
function fatch_subdiv_from_personal_trainingpp_ag_dist($dist)
{
	$sql="Select distinct training_pp.subdivision,  subdivision.subdivision
			From subdivision
			  Inner Join training_pp On training_pp.subdivision =
			subdivision.subdivisioncd  where subdivision.districtcd='$dist'";
	$rs=execSelect($sql);
	return $rs;
}
function member_available_ag_dist($post_stat,$dist,$areapref,$area,$tr_type)
{
	$sql="Select Count(training_pp.per_code) as memb_avl From training_pp where post_stat='$post_stat' and training_type='$tr_type'";
	//$sql.=" and for_subdivision='$subdivision'";
	if($areapref=='1')
		$sql.=" and subdivision='$area'";
	/*if($areapref=='2')
		$sql.=" and for_subdivision='$area'";
	if($areapref=='3')
		$sql.=" and for_pc='$area'";
	if($areapref=='4')
		$sql.=" and assembly_temp='$area'";
	if($areapref=='5')
		$sql.=" and assembly_perm='$area'";
	if($areapref=='6')
		$sql.=" and assembly_off='$area'";*/
	$sql.=" and (training_booked='' or training_booked is null)";
	$rs=execSelect($sql);
	return $rs;
}
function training_required_ag_dist($dist,$training_type)
{
	$sql="Select Count(training_pp.per_code) As total,
		  poststat.poststatus,  poststat.post_stat
		From poststat
		  Inner Join training_pp On training_pp.post_stat = poststat.post_stat
		  Inner Join personnela On training_pp.per_code = personnela.personcd
		where personnela.districtcd ='$dist' and training_pp.training_type='$training_type' Group By poststat.poststatus,poststat.post_stat";
	//		print $sql; exit;
	$rs=execSelect($sql);
	return $rs;
}
function training_alloted_ag_dist($dist,$training_type)
{
	$sql="Select Count(training_pp.per_code) as total,poststat.poststatus,poststat.post_stat
			From poststat
			  Inner Join training_pp On training_pp.post_stat = poststat.post_stat
			  Inner Join personnela On training_pp.per_code = personnela.personcd
			where personnela.districtcd ='$dist' and training_pp.training_type='$training_type' and training_pp.training_sch Is Not Null Group By poststat.poststatus,poststat.post_stat";
	$rs=execSelect($sql);
	return $rs;
}
//---- End Dist Wise ----//
//==============subdivision wise==================================//

function fatch_forsubdiv_from_personal_trainingpp_ag_subdiv1($subdiv_cd)
{
	$sql; $rs;
	$sql="Select distinct subdivision.subdivisioncd,  subdivision.subdivision
			From subdivision
			   where 1=1";
    if($subdiv_cd!='' && $subdiv_cd!='0')
     $sql.=" and subdivision.subdivisioncd='$subdiv_cd'";
	$rs=execSelect($sql);
	return $rs;
}

function fatch_tempass_from_personal_trainingpp_ag_subdiv1($subdiv_cd)
{
	$sql; $rs;
	$sql="Select distinct assemblycd, assembly.assemblyname
			From assembly";
    //$sql="where assembly.subdivisioncd	='$subdiv_cd'"
	$rs=execSelect($sql);
	return $rs;
}

//==============END Subdivisionwise===============================//
function fatch_forsubdiv_from_personal_trainingpp_ag_subdiv($subdiv_cd)
{
	$sql; $rs;
	$sql="Select distinct training_pp.for_subdivision,  subdivision.subdivision
			From subdivision
			  Inner Join training_pp On training_pp.for_subdivision =
			subdivision.subdivisioncd  where training_pp.for_subdivision='$subdiv_cd'";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_forpc_from_personal_trainingpp_ag_subdiv($subdiv_cd)
{
	$sql; $rs;
	$sql="Select distinct training_pp.for_pc, pc.pcname
			From training_pp
			  Inner Join pc On training_pp.for_pc = pc.pccd  where training_pp.for_subdivision='$subdiv_cd'";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_tempass_from_personal_trainingpp_ag_subdiv($subdiv_cd)
{
	$sql; $rs;
	$sql="Select distinct training_pp.assembly_temp, assembly.assemblyname
			From training_pp
			  Inner Join assembly On training_pp.assembly_temp = assembly.assemblycd where training_pp.for_subdivision='$subdiv_cd'";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_permass_from_personal_trainingpp_ag_subdiv($subdiv_cd)
{
	$sql; $rs;
	$sql="Select distinct training_pp.assembly_perm, assembly.assemblyname
			From training_pp
			  Inner Join assembly On training_pp.assembly_perm = assembly.assemblycd where training_pp.for_subdivision='$subdiv_cd'";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_ofcass_from_personal_trainingpp_ag_subdiv($subdiv_cd)
{
	$sql; $rs;
	$sql="Select distinct training_pp.assembly_off, assembly.assemblyname
			From training_pp
			  Inner Join assembly On training_pp.assembly_off = assembly.assemblycd where training_pp.for_subdivision='$subdiv_cd'";
	$rs=execSelect($sql);
	return $rs;
}
		//End Area of Pref//
function update_training_pp_ag_training_schedule($schedule_code,$training_type,$post_status,$per_code)
{
	$sql="update training_pp set training_sch='$schedule_code', training_booked='Y', training_attended='P' where training_type='$training_type' and
	post_stat='$post_status' and per_code='$per_code'";

	$i=execUpdate($sql);
	return $i;
}

function fatch_training_allocation_list($sub_div,$training_type,$training_venue,$frmdt,$todt,$usercode)
{
	$sql="Select training_schedule.schedule_code,
	  training_schedule.training_venue,
	  training_venue.venuename,
	  training_schedule.training_type,  
	  training_type.training_desc,
	  Date_Format(training_schedule.training_dt, '%d/%m/%Y') As training_dt,
	  training_schedule.training_time,
	  poststat.poststatus,
	  training_schedule.no_pp,
	  training_venue.subdivisioncd	  
	From training_venue
	  Inner Join training_schedule On training_schedule.training_venue =
		training_venue.venue_cd
	  Inner Join poststat On training_schedule.post_status = poststat.post_stat
	  Inner Join training_type On training_schedule.training_type =
		training_type.training_code
	Where training_schedule.schedule_code > 0 ";
	if($training_type!='0')
		$sql.=" and training_schedule.training_type = '$training_type'";
    if($sub_div!='' && $sub_div!='0')
		$sql.=" and training_venue.subdivisioncd ='$sub_div'";
	if($training_venue!='')
		$sql.=" and training_venue.venuename like '$training_venue%'";
	if($frmdt!='')
		$sql.=" and training_schedule.training_dt >= '$frmdt%'";
	if($todt!='')
		$sql.=" and training_schedule.training_dt <= '$todt%'";
	$sql.=" order by training_schedule.schedule_code";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_training_allocation_listAct($sub_div,$training_type,$training_venue,$frmdt,$todt,$usercode,$p_num,$items)
{
	$sql="Select training_schedule.schedule_code,
	  training_schedule.training_venue,
	  training_venue.venuename,
	  training_schedule.training_type,  
	  training_type.training_desc,
	  Date_Format(training_schedule.training_dt, '%d/%m/%Y') As training_dt,
	  training_schedule.training_time,
	  poststat.poststatus,
	  training_schedule.no_pp,
	  training_venue.subdivisioncd,training_schedule.usercode  
	From training_venue
	  Inner Join training_schedule On training_schedule.training_venue =
		training_venue.venue_cd
	  Inner Join poststat On training_schedule.post_status = poststat.post_stat
	  Inner Join training_type On training_schedule.training_type =
		training_type.training_code
	Where training_schedule.schedule_code > 0 ";
	if($training_type!='0')
		$sql.=" and training_schedule.training_type = '$training_type'";
    if($sub_div!='' && $sub_div!='0')
		$sql.=" and training_venue.subdivisioncd ='$sub_div'";
	if($training_venue!='')
		$sql.=" and training_venue.venuename like '$training_venue%'";
	if($frmdt!='')
		$sql.=" and training_schedule.training_dt >= '$frmdt%'";
	if($todt!='')
		$sql.=" and training_schedule.training_dt <= '$todt%'";
	$sql.=" order by training_schedule.schedule_code";
	$sql.=" ASC LIMIT $p_num , $items";

	$rs=execSelect($sql);
	return $rs;
}
function delete_training_allocation($delcode)
{
	$sql="update training_pp set training_sch=NULL , training_booked=NULL , training_attended=NULL where training_sch='$delcode'";
	$i=execUpdate($sql);
	$sql="delete from training_schedule where schedule_code='$delcode'";
	$i=execDelete($sql);
	return $i;
}
//========================= Training Attendance ===========================
function fatch_training_datetime($trn_type,$venue)
{
	$sql; $rs;
	$sql="Select schedule_code, concat(date_format(training_dt,'%d-%m-%Y'),' - ',training_time) as trn_dt_time from training_schedule";
	$sql.=" where training_venue='$venue' and training_type='$trn_type'";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_personnel_ag_sch($schedule_cd)
{
	$sql; $rs;
	$sql="Select training_pp.per_code, training_pp.per_name From training_pp ";
	$sql.=" where training_pp.training_sch='$schedule_cd'";
	$rs=execSelect($sql);
	return $rs;
}
function update_training_pp_attendance($per_cd,$trn_dt_time,$attend)
{
	$sql="update training_pp set training_attended='$attend' where training_sch='$trn_dt_time' and per_code='$per_cd'";
	$i=execUpdate($sql);
	return $i;
}
//============================= Venue wise List (Attendance) ===============================
function venue_name_training_date_and_time($training_venue,$training_type)
{
	$sql=""; $rs=null;
	$sql="Select distinct training_venue.venuename,
	  training_venue.venueaddress1,
	  training_venue.venueaddress2,
	  training_schedule.training_dt,
	  training_schedule.training_time,
	  training_venue.venue_cd
	From training_venue
	  Inner Join training_schedule On training_venue.venue_cd =
		training_schedule.training_venue
	Where training_venue.venue_cd<>''";
	if($training_venue!="0")
		$sql.=" and training_venue.venue_cd='$training_venue'";
	if($training_type!="0")
		$sql.=" and training_schedule.training_type='$training_type'";
	$sql.=" Order By training_venue.venuename,
	  training_schedule.training_dt,
	  training_schedule.training_time";
	$rs=execSelect($sql);
	return $rs;
}
function venue_wise_list($venue,$training_dt,$training_time)
{
	$sql=""; $rs=null;
	$sql="Select training_venue.venuename,
	  training_venue.venueaddress1,
	  training_venue.venueaddress2,
	  training_schedule.training_dt,
	  training_schedule.training_time,
	  personnela.personcd,
	  personnela.officer_name,
	  personnela.off_desg as designation,
	  poststat.poststatus,
	  personnela.acno,
	  personnela.partno,
	  personnela.slno,
	  training_pp.token
	From training_venue
	  Inner Join training_schedule On training_venue.venue_cd =
		training_schedule.training_venue
	  Inner Join training_pp On training_schedule.schedule_code =
		training_pp.training_sch
	  Inner Join personnela On training_pp.per_code = personnela.personcd
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	  Where personnela.personcd<>''";
	$sql.=" and training_venue.venue_cd='$venue' and training_schedule.training_dt='$training_dt' and training_schedule.training_time='$training_time'";
	$sql.=" Order By training_venue.venuename,
	  training_schedule.training_dt,
	  training_schedule.training_time,
	  poststat.poststatus,
	  personnela.personcd";
	$rs=execSelect($sql);
	return $rs;
}
//==========================================Listtraning Venue============================
function update_trainingvenue($venue_cd,$subdiv_cd,$venuename,$venueaddress1,$venueaddress2,$maximumcapacity,$usercd,$posted_date,$assembly)
{
	$sql="update training_venue set subdivisioncd='$subdiv_cd',venuename='$venuename',venueaddress1='$venueaddress1',venueaddress2='$venueaddress2',maximumcapacity='$maximumcapacity',usercode = '$usercd', posted_date = '$posted_date',assemblycd='$assembly' where venue_cd='$venue_cd'";
	//echo $sql; exit;
	$i=execUpdate($sql);
	return $i;
}
function fatch_trainingvenue_list($subdivision,$venuename,$usercode,$dist)
{
	$sql="Select training_venue.venue_cd, subdivision.subdivision, training_venue.venuename, training_venue.venueaddress1, training_venue.venueaddress2,
  training_venue.maximumcapacity, training_venue.usercode, training_venue.posted_date,training_venue.subdivisioncd
From training_venue
  Inner Join subdivision On training_venue.subdivisioncd = subdivision.subdivisioncd where training_venue.venue_cd >0 and subdivision.districtcd = '$dist'";
    if($subdivision!='' && $subdivision!='0')
		$sql.=" and training_venue.subdivisioncd ='$subdivision'";
	if($venuename!='')
		$sql.=" and training_venue.venuename like '$venuename%'";
	$sql.=" order by subdivision.subdivision";
	$rs=execSelect($sql);
	return $rs;
}

function fatch_trainingvenue_listAct($subdivision,$venuename,$usercode,$p_num ,$items,$dist)
{
	$sql="Select training_venue.venue_cd, subdivision.subdivision, training_venue.venuename, training_venue.venueaddress1, training_venue.venueaddress2,
  training_venue.maximumcapacity, training_venue.usercode, training_venue.posted_date,training_venue.subdivisioncd,training_venue.usercode
From training_venue
  Inner Join subdivision On training_venue.subdivisioncd = subdivision.subdivisioncd where training_venue.venue_cd >0 ";
    if($subdivision!='' && $subdivision!='0')
		$sql.=" and training_venue.subdivisioncd ='$subdivision'";
	if($dist!='' && $dist!='0')
		$sql.=" and subdivision.districtcd = '$dist'";
	if($venuename!='')
		$sql.=" and training_venue.venuename like '$venuename%'";
	$sql.=" order by subdivision.subdivision";
	$sql.=" ASC LIMIT $p_num , $items";
	$rs=execSelect($sql);
	return $rs;
}
function chk_trainingvenue($venue_cd)
{
	$sql="Select count(training_schedule.training_venue) as total From training_schedule  WHERE training_schedule.training_venue='$venue_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$total=$row['total'];
	unset($sql,$rs,$row);
	return $total;
}
function delete_trainingvenue($venue_cd)
{
	$sql="DELETE FROM training_venue WHERE venue_cd='$venue_cd'";
	$rs=execDelete($sql);
	return $rs;
}

function trainingvanue_details($venue_cd)
{
	$sql="Select training_venue.venue_cd, subdivision.subdivision,training_venue.subdivisioncd, training_venue.venuename, training_venue.venueaddress1, training_venue.venueaddress2,
  training_venue.maximumcapacity, training_venue.usercode, training_venue.posted_date,training_venue.assemblycd
From training_venue
  Inner Join subdivision On training_venue.subdivisioncd = subdivision.subdivisioncd where training_venue.venue_cd = $venue_cd";
	$rs=execSelect($sql);
	return $rs;
}
/**********************************update Training pp & schedule*****************/
function update_training_pp_schedule($training_type,$sub)
{
	//$sql;$sql1;
	$sql="Update training_pp set training_sch=NULL,	training_booked=NULL,training_attended=NULL,training_showcause=NULL where `training_type`='$training_type' and for_subdivision='$sub'";
	execUpdate($sql);
	
	$sql1="Update training_schedule set no_used=0 where `training_type`='$training_type' and substr(schedule_code,1,4)='$sub'";
	
	execUpdate($sql1);
	connection_close();
	return 1;
}
function training_pp_not_assigned($training_type,$sub)
{
	 $sql;$rs;
	 $i=0;
     $data_list=array();
	 $sql="Select post_stat,count(*) as cnt from  training_pp where for_subdivision='$sub' and training_type='$training_type'  and training_sch is NULL group by post_stat";
	 $rs=execSelect($sql);
	 while($post_status = getRows($rs)) {
	  $data_list[$i]['ps']=$post_status['post_stat'];
	  $data_list[$i]['cnt']=$post_status['cnt'];
	  $i++;
	 }
	return $data_list;
	 
}
/*************************************set subdiv wise password**************************/
function save_subdiv_pwd($rand,$password,$user_cd,$sub)
{
	$sql="insert into password (randomise,password,status, subdivisioncd, usercode) values ('$rand','$password','unlock','$sub','$user_cd')";
	$i=execInsert($sql);
	return $i;
}
/*************************************Second training allocation***********************/
function fetch_asm_party_available($subdivision,$assm,$party_reserve)
{
	
	   $sql="Select count(distinct groupid) as cnt from  personnela where forsubdivision='$subdivision' and forassembly='$assm' and booked='$party_reserve'";
	  // echo   $sql;
	  // exit;
	   $rs=execSelect($sql);
	   $row=getRows($rs);
	   $total=$row['cnt'];
	   return $total;
}
function fetch_sec_party_reserve_available($subdivision,$assm,$party_reserve)
{
	 $sql="Select max(end_sl) as cnt from  second_training where for_subdiv='$subdivision' and assembly='$assm'";
	 if($party_reserve!='' && $party_reserve!='0')
		$sql.=" and party_reserve ='$party_reserve'";
	   $rs=execSelect($sql);
	   $row=getRows($rs);
	   $total=$row['cnt'];
	   return $total;
}
function fetch_asm_reserve_available($subdivision,$assm,$party_reserve)
{
	 $sql="SELECT a.forassembly AS fasm, a.forsubdivision AS fsub, a.forpc AS fpc, a.number_of_member AS memb, a.no_or_pc AS npc, a.numb AS pnumb, a.poststat AS pst, b.no_party AS ptyrqd
FROM reserve a,  `assembly_party` b
WHERE a.forassembly = b.assemblycd
AND a.forsubdivision = b.subdivisioncd
AND a.number_of_member = b.no_of_member
AND a.forsubdivision ='$subdivision' and a.forassembly='$assm'";
	   $rs=execSelect($sql);
	   return $rs;
}

?>