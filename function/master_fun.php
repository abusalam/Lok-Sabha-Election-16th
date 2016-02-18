<?php
include_once('string_fun.php');
//===========District============
function fatch_district_master($dist_cd)
{
	$sql="Select Distinct district.districtcd,
	  district.district	From district where district.districtcd>0";
	if($dist_cd!='' && $dist_cd!='0')
		$sql.=" and districtcd='$dist_cd'";
	$sql.=" order by district";
	$rs=execSelect($sql);
	return $rs;
}
//==========Subdivision==============
function fatch_subdivision_maxcode($dist_cd)
{
	$sql;$rs;
	$sql="select max(subdivisioncd) as subdivision_cd from subdivision where districtcd='$dist_cd'";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_subdivision($subdivision_code,$subdivision)
{
	$sql="select count(*) as c_subdivision from subdivision where subdivisioncd<>'$subdivision_code' and subdivision='$subdivision'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$c_subdivision=$row['c_subdivision'];
	return $c_subdivision;
}
function save_subdivision($subdivision_code,$subdivision,$dist_cd,$usercd)
{
	$sql="insert into subdivision (subdivisioncd,districtcd,subdivision,usercode) values ('$subdivision_code','$dist_cd','$subdivision','$usercd')";
	$i=execInsert($sql);
	return $i;
}
function update_subdivision($subdivision_code,$subdivision,$usercd,$posted_date)
{
	$sql="update subdivision set subdivision='$subdivision',usercode='$usercd',posted_date='$posted_date' where subdivisioncd='$subdivision_code'";
	$i=execUpdate($sql);
	return $i;
}
function fatch_subdivision_master($subdivision_code,$dist_cd)
{
	$sql="Select subdivisioncd, subdivision, districtcd From subdivision where subdivisioncd>0";
	if($subdivision_code!='' && $subdivision_code!='0')
		$sql.=" and subdivisioncd='$subdivision_code'";
	if($dist_cd!='')
		$sql.=" and districtcd='$dist_cd'";
	$sql.=" order by subdivision";
	$rs=execSelect($sql);
	return $rs;
}
function check_subdivision_delete($sub_cd)
{
	$sql="Select Count(pccd) as cnt1 from pc where subdivisioncd='$sub_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt1=$row['cnt1'];
	unset($sql,$rs,$row);
	$sql="Select Count(policestationcd) as cnt2 from policestation where subdivisioncd='$sub_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt2=$row['cnt2'];
	unset($sql,$rs,$row);
	$sql="Select Count(blockminicd) as cnt3 from block_muni where subdivisioncd='$sub_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt3=$row['cnt3'];
	unset($sql,$rs,$row);
	$sql="Select Count(personcd) as cnt4 from personnel where subdivisioncd='$sub_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt4=$row['cnt4'];
	$sql="Select Count(personcd) as cnt5 from personnela where forsubdivision='$sub_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt5=$row['cnt5'];
	$sql="Select Count(per_code) as cnt6 from training_pp where for_subdivision='$sub_cd' or subdivision='$sub_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt6=$row['cnt6'];
	unset($sql,$rs,$row);

	return ($cnt1>0?$cnt1:($cnt2>0?$cnt2:($cnt3>0?$cnt3:($cnt4>0?$cnt4:($cnt5>0?$cnt5:($cnt6>0?$cnt6:0))))));
}
function delete_subdivision($sub_cd)
{
	$sql="delete from subdivision where subdivisioncd='$sub_cd'";
	$i=execDelete($sql);
	return $i;
}
//========================Block/Municipality==========================
function fatch_block_muni_maxcode($subdivision)
{
	$sql="select max(blockminicd) as blockmuni_cd from block_muni where subdivisioncd='$subdivision'";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_block_muni($block_muni_code,$block_muni)
{
	$sql="select count(*) as c_block_muni from block_muni where blockminicd<>'$block_muni_code' and blockmuni='$block_muni'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$c_block_muni=$row['c_block_muni'];
	return $c_block_muni;
}
function save_block_muni($block_muni_code,$subdivision,$block_muni,$block_muni_type,$dist_cd,$usercd)
{
	$sql="insert into block_muni (blockminicd,subdivisioncd,blockmuni,block_or_muni,districtcd,usercode) values ('$block_muni_code','$subdivision','$block_muni','$block_muni_type','$dist_cd','$usercd')";
	$i=execInsert($sql);
	return $i;
}
function update_block_muni($block_muni_code,$block_muni,$block_muni_type,$usercd,$posted_date)
{
	$sql="update block_muni set blockmuni='$block_muni',block_or_muni='$block_muni_type',usercode='$usercd',posted_date='$posted_date' where blockminicd='$block_muni_code'";
	$i=execUpdate($sql);
	return $i;
}
function fatch_block_muni_master($block_muni_code,$dist_cd)
{
	$sql="Select block_muni.blockminicd,
	  block_muni.subdivisioncd,
	  subdivision.subdivision,
	  block_muni.blockmuni,
	  block_muni.block_or_muni,
	  block_muni.districtcd
	From subdivision
	  Inner Join block_muni On subdivision.subdivisioncd = block_muni.subdivisioncd where block_muni.blockminicd>0";
	if($block_muni_code!='')
		$sql.=" and block_muni.blockminicd='$block_muni_code'";
	if($dist_cd!='')
		$sql.=" and block_muni.districtcd='$dist_cd'";
	$sql.=" order by block_muni.blockminicd";
	$rs=execSelect($sql);
	return $rs;
}
function check_block_muni_delete($blockminicd)
{
	$sql="Select Count(officecd) as cnt from office where blockormuni_cd='$blockminicd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt=$row['cnt'];
	unset($sql,$rs,$row);
	return $cnt;
}
function delete_block_muni($blockminicd)
{
	$sql="delete from block_muni where blockminicd='$blockminicd'";
	$i=execDelete($sql);
	return $i;
}
//========================Bank==========================
function fatch_bank_maxcode($dist_cd)
{
	$sql="select max(bank_cd) as bank_cd from bank where distcd='$dist_cd'";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_bank($bank_code,$bank)
{
	$sql="select count(*) as c_bank from bank where bank_cd<>'$bank_code' and bank_name='$bank'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$c_bank=$row['c_bank'];
	return $c_bank;
}
function save_bank($bank_code,$bank,$dist_cd,$usercd)
{
	$sql="insert into bank (bank_cd,bank_name,distcd,usercode) values ('$bank_code','$bank','$dist_cd','$usercd')";
	$i=execInsert($sql);
	return $i;
}
function update_bank($bank_code,$bank,$usercd,$posted_date)
{
	$sql="update bank set bank_name='$bank',usercode='$usercd',posted_date='$posted_date' where bank_cd='$bank_code'";
	$i=execUpdate($sql);
	return $i;
}
function fatch_bank_master($bank_code,$dist_cd)
{
	$sql="Select bank_cd, bank_name, distcd From bank where bank_cd>0";
	if($bank_code!='')
		$sql.=" and bank_cd='$bank_code'";
	if($dist_cd!='')
		$sql.=" and distcd='$dist_cd'";
	$sql.=" order by bank_cd";
	$rs=execSelect($sql);
	return $rs;
}
function check_bank_delete($bank_code)
{
	$sql="Select Count(branchcd) as cnt1 from branch where bank_cd='$bank_code'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt1=$row['cnt1'];
	unset($sql,$rs,$row);
	$sql="Select Count(personcd) as cnt2 from personnel where bank_cd='$bank_code'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt2=$row['cnt2'];
	unset($sql,$rs,$row);
	$sql="Select Count(personcd) as cnt3 from personnela where bank_cd='$bank_code'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt3=$row['cnt3'];
	unset($sql,$rs,$row);
	
	return ($cnt1>0?$cnt1:($cnt2>0?$cnt2:($cnt3>0?$cnt3:0)));
}
function delete_bank($bank_code)
{
	$sql="delete from bank where bank_cd='$bank_code'";
	$i=execDelete($sql);
	return $i;
}
//====================== Branch =======================
function fatch_branch_maxcode($bank)
{
	$sql="select max(branchcd) as branch_cd from branch where bank_cd='$bank'";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_branch($bank,$branch_code,$branch_name)
{
	$sql="select count(*) as c_branch from branch where branchcd<>'$branch_code' and branch_name='$branch_name' and bank_cd='$bank'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$c_branch=$row['c_branch'];
	return $c_branch;
}
function save_branch($branch_code,$bank,$branch_name,$branch_address,$ifsc,$usercd)
{
	$sql="insert into branch (branchcd,bank_cd,branch_name,address,ifsc_code,usercode) values ('$branch_code','$bank','$branch_name','$branch_address','$ifsc','$usercd')";
	$i=execInsert($sql);
	return $i;
}
function update_branch($branch_code,$bank,$branch_name,$branch_address,$ifsc,$usercd,$posted_date)
{
	$sql="update branch set branch_name='$branch_name',address='$branch_address',ifsc_code='$ifsc',usercode='$usercd',posted_date='$posted_date' where branchcd='$branch_code' and bank_cd='$bank'";
	$i=execUpdate($sql);
	return $i;
}
function fatch_branch_master($branch_code,$dist_cd)
{
	$sql="Select branch.branchcd,
	  branch.bank_cd,
	  branch.branch_name,
	  branch.address,
	  branch.ifsc_code
	From branch
	  Inner Join bank On branch.bank_cd = bank.bank_cd where branch.branchcd>0";
	if($branch_code!='')
		$sql.=" and branch.branchcd='$branch_code'";
	if($dist_cd!='')
		$sql.=" and bank.distcd='$dist_cd'";
	$sql.=" order by branch.bank_cd,branch.ifsc_code";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_branch_master_dtl($branch_code,$bank)
{
	$sql="Select branch.branchcd,
	  branch.bank_cd,
	  branch.branch_name,
	  branch.address,
	  branch.ifsc_code
	From branch
	  Inner Join bank On branch.bank_cd = bank.bank_cd where branch.branchcd>0";
	if($branch_code!='')
		$sql.=" and branch.branchcd='$branch_code'";
	if($bank!='')
		$sql.=" and bank.bank_cd='$bank'";
	$sql.=" order by branch.bank_cd,branch.ifsc_code";
	$rs=execSelect($sql);
	return $rs;
}
function check_branch_delete($branch_code,$bank)
{
	$sql="Select Count(personcd) as cnt1 from personnel where branchcd='$branch_code' and bank_cd='$bank'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt1=$row['cnt1'];
	unset($sql,$rs,$row);
	$sql="Select Count(personcd) as cnt2 from personnela where branchcd='$branch_code' and bank_cd='$bank'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt2=$row['cnt2'];
	unset($sql,$rs,$row);
	return ($cnt1>0?$cnt1:($cnt2>0?$cnt2:0));
}
function delete_branch($branch_code,$bank)
{
	$sql="delete from branch where branchcd='$branch_code' and bank_cd='$bank'";
	$i=execDelete($sql);
	return $i;
}
//============================PC=======================================

function fatch_parliament_maxcode()
{
	$sql;$rs;
	$sql="SELECT max( pccd ) AS pc_cd FROM pc";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_parliament($parliament_code,$parliament,$subdivisioncd,$pc_code)
{
	$sql="select count(*) as c_parliament from pc Where subdivisioncd = '$subdivisioncd'";
	if($pc_code != "" && $pc_code !="0")
	  $sql.=" and pc.pccd = '$pc_code' and pcname='$parliament'"; 
	else
	  $sql.=" and pc.pccd = '$parliament_code'";
	// echo $sql;
	// exit;
	$rs=execSelect($sql);
	$row=getRows($rs);
	$c_parliament=$row['c_parliament'];
	return $c_parliament;
}

function save_parliament($parliament_code,$parliament,$dist_cd,$subdivisioncd,$usercd)
{
	$sql="insert into pc (pccd,pcname,district,subdivisioncd,usercode) values ('$parliament_code','$parliament','$dist_cd','$subdivisioncd','$usercd')";
	$i=execInsert($sql);
	return $i;
}

function update_parliament($parliament_code,$parliament,$dist_cd,$subdivisioncd,$usercd,$posted_date)
{
	$sql="update pc set pcname='$parliament',district='$dist_cd',usercode='$usercd',posted_date='$posted_date' where pccd='$parliament_code' and subdivisioncd=$subdivisioncd";
	$i=execUpdate($sql);
	return $i;
}
function fatch_parliament_master($parliament_code,$sub_code)
{
	$sql="Select pc.pccd,
  pc.pcname,
  pc.usercode,
  pc.posted_date,
  subdivision.subdivision,
  district.district As districtact,
  pc.district,
  pc.subdivisioncd 
From pc                                
  Inner Join subdivision On pc.subdivisioncd = subdivision.subdivisioncd
  Inner Join district On pc.district = district.districtcd";
	if($parliament_code!='')
		$sql.=" where pccd='$parliament_code' and pc.subdivisioncd ='$sub_code'";
	$sql.=" order by subdivision";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_parliament_masterlist($dist)
{
  $sql="Select pc.pccd,
	  pc.pcname,
	  pc.usercode,
	  pc.posted_date,
	  subdivision.subdivision,
	  district.district As districtact,
	  pc.district,
	  pc.subdivisioncd 
	From pc                                
	  Inner Join subdivision On pc.subdivisioncd = subdivision.subdivisioncd
	  Inner Join district On pc.district = district.districtcd";
	if($dist!='')
		$sql.=" where pc.district='$dist'";
	$sql.=" order by subdivision";
	$rs=execSelect($sql);
	return $rs;
}
function check_parliament_delete($pc_cd,$sub_div)
{
	$sql="Select Count(pccd) as cnt1 from assembly where pccd='$pc_cd' and subdivisioncd='$sub_div'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt1=$row['cnt1'];
	unset($sql,$rs,$row);
	$sql="Select Count(per_code) as cnt2 from training_pp where for_pc='$pc_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt2=$row['cnt2'];
	$sql="Select Count(personcd) as cnt3 from personnela where forpc='$pc_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt3=$row['cnt3'];
	unset($sql,$rs,$row);
	$sql="Select count(*) as cnt4 From assembly_party  where pccd='$pc_cd' and subdivisioncd='$sub_div'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt4=$row['cnt4'];
	unset($sql,$rs,$row);
	return ($cnt1>0?$cnt1:($cnt2>0?$cnt2:($cnt2>0?$cnt3:($cnt4>0?$cnt4:0))));
}
function delete_parliament($pc_cd,$sub_div)
{
	$sql="delete from pc where pccd='$pc_cd' and subdivisioncd='$sub_div'";
	$i=execDelete($sql);
	return $i;
}
//=============================Assembly==================================
function fatch_assembly_member($subdiv,$asmbly,$nomember)
{
	//$sql;$rs;
	$sql="select * from assembly_party where 1=1";
	if($subdiv!='0' && $subdiv!='')
		$sql.=" and subdivisioncd='$subdiv'";
	if($asmbly!='0' && $asmbly!='')
		$sql.=" and assemblycd='$asmbly'";
    if($nomember!='0' && $nomember!='')
		$sql.=" and no_of_member='$nomember'";
	$sql.=" order by assemblycd asc";
	//echo $sql;
	//exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_assembly_maxcode($pc)
{
	$sql;$rs;
	$sql="SELECT max(assemblycd) AS ass_cd FROM assembly where pccd='$pc'";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_assembly($subdivisioncd,$assembly_code,$pc,$assemblyname,$asm_code)
{
	$sql="select count(*) as c_assembly from assembly Where pccd = '$pc' and subdivisioncd = '$subdivisioncd' ";
	if($assembly_code != "" && $assembly_code !="0")
	  $sql.=" and assemblycd = '$assembly_code' and assemblyname ='$assemblyname'"; 
	else
	  $sql.=" and assemblycd = '$asm_code'";
	//echo $sql;
	//exit;
	
	$rs=execSelect($sql);
	$row=getRows($rs);
	$c_assembly=$row['c_assembly'];
	return $c_assembly;
}

function save_assembly($assembly_code,$assemblyname,$dist_cd,$subdivisioncd,$pc,$usercd)
{
	$sql="insert into assembly (assemblycd,pccd,assemblyname,districtcd,subdivisioncd,usercode) values ('$assembly_code','$pc','$assemblyname','$dist_cd','$subdivisioncd','$usercd')";
	
	$i=execInsert($sql);
	return $i;
}

function update_assembly($assembly_code,$assemblyname,$dist_cd,$subdivisioncd,$pc,$usercd,$posted_date)
{
	$sql="update assembly set pccd='$pc',assemblyname='$assemblyname',districtcd='$dist_cd',
	usercode='$usercd',posted_date='$posted_date' where assemblycd='$assembly_code' and subdivisioncd='$subdivisioncd'";
	//echo $sql; exit;
	$i=execUpdate($sql);
	return $i;
}

function fatch_assembly_master($assembly_code,$subdiv_code)
{
  $sql="Select Distinct assembly.assemblycd,
	  assembly.pccd,
	  assembly.assemblyname,
	  assembly.districtcd,
	  assembly.subdivisioncd
	From assembly ";
	if($assembly_code!='')
		$sql.=" where assembly.assemblycd='$assembly_code' and assembly.subdivisioncd='$subdiv_code'";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_assembly_masterlist($dist_cd)
{
  $sql="Select assembly.assemblycd,
	  assembly.pccd,
	  pc.pcname,
	  assembly.assemblyname,
	  subdivision.subdivisioncd,
	  subdivision.subdivision
	From assembly
	  Inner Join pc On assembly.pccd = pc.pccd And assembly.subdivisioncd =
		pc.subdivisioncd
	Inner Join subdivision On assembly.subdivisioncd = subdivision.subdivisioncd
	where assembly.assemblycd>0";
	if($dist_cd!='')
		$sql.=" and assembly.districtcd='$dist_cd'";
	$sql.=" order by subdivision.subdivisioncd,assembly.assemblycd,assembly.assemblyname";
	$rs=execSelect($sql);
	return $rs;
}
function check_assembly_delete($ass_cd)
{
	$sql="Select Count(personcd) as cnt1 from personnel where acno='$ass_cd' or assembly_temp='$ass_cd' or assembly_off='$ass_cd' or assembly_perm='$ass_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt1=$row['cnt1'];
	unset($sql,$rs,$row);
	$sql="Select Count(per_code) as cnt2 from training_pp where assembly_temp='$ass_cd' or assembly_off='$ass_cd' or assembly_perm='$ass_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt2=$row['cnt2'];
	unset($sql,$rs,$row);
	$sql="Select Count(personcd) as cnt3 from personnela where forassembly='$ass_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt3=$row['cnt3'];
	unset($sql,$rs,$row);
	$sql="Select count(*) as cnt4 From assembly_party where assemblycd='$ass_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt4=$row['cnt4'];
	unset($sql,$rs,$row);
	$sql="Select count(*) as cnt5 From reserve where forassembly='$ass_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt5=$row['cnt5'];
	unset($sql,$rs,$row);
	$sql="Select count(*) as cnt6 From dcrcmaster where assemblycd='$ass_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt6=$row['cnt6'];
	unset($sql,$rs,$row);
	$sql="Select count(*) as cnt7 From dcrc_party where assemblycd='$ass_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt7=$row['cnt7'];
	unset($sql,$rs,$row);
	$sql="Select count(*) as cnt8 From pollingstation where forassembly='$ass_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt8=$row['cnt8'];
	unset($sql,$rs,$row);
	$sql="select count(*) as cnt9 from training_pp where assembly_temp='$ass_cd' or assembly_off='$ass_cd' or assembly_perm='$ass_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt9=$row['cnt9'];
	unset($sql,$rs,$row);
	return ($cnt1>0?$cnt1:($cnt2>0?$cnt2:($cnt3>0?$cnt3:($cnt4>0?$cnt4:($cnt5>0?$cnt5:($cnt6>0?$cnt6:($cnt7>0?$cnt7:($cnt8>0?$cnt8:($cnt9>0?$cnt9:0)))))))));
}
function delete_assembly($ass_cd,$subcode)
{
	$sql="delete from assembly where assemblycd='$ass_cd' and subdivisioncd='$subcode'";
	$i=execDelete($sql);
	return $i;
}
//========================Police Station=============================
function fatch_police_maxcode($subdivisioncd)
{
	$sql;$rs;
	$sql="SELECT max(policestationcd) AS ps_cd FROM policestation where subdivisioncd='$subdivisioncd'";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_police($ps_code,$psname,$subdivisioncd)
{
	$sql="select count(*) as c_ps from policestation Where policestationcd <> '$ps_code' and policestation = '$psname' and subdivisioncd='$subdivisioncd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$c_ps=$row['c_ps'];
	return $c_ps;
}
function save_police($ps_code,$psname,$dist_cd,$subdivisioncd,$usercd)
{
	$sql="insert into policestation (policestationcd,policestation,districtcd,subdivisioncd,usercode) values ('$ps_code','$psname','$dist_cd','$subdivisioncd','$usercd')";
	
	$i=execInsert($sql);
	return $i;
}

function update_police($ps_code,$psname,$dist_cd,$subdivisioncd,$usercd,$posted_date)
{
	$sql="update policestation set policestation='$psname',districtcd='$dist_cd',
	subdivisioncd='$subdivisioncd',usercode='$usercd',posted_date='$posted_date' where policestationcd='$ps_code'";
	//echo $sql; exit;
	$i=execUpdate($sql);
	return $i;
}

function fatch_ps_masterlist($dist_cd)
{
  $sql="Select policestation.policestationcd,
               subdivision.subdivision,
	           policestation.policestation
	From policestation
	  Inner Join subdivision On policestation.subdivisioncd = subdivision.subdivisioncd  where policestation.policestationcd>0";
	if($dist_cd!='')
		$sql.=" and policestation.districtcd='$dist_cd'";
	$sql.=" order by policestation.policestationcd";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_police_station_master($ps_code)
{
  $sql="Select policestation.policestationcd,
                policestation.subdivisioncd,
	           policestation.policestation
	From policestation ";
	if($ps_code!='')
		$sql.=" where policestation.policestationcd='$ps_code'";
	$rs=execSelect($sql);
	return $rs;
}
function check_police_delete($ps_cd)
{
	$sql="Select Count(policestn_cd) as cnt1 from office where policestn_cd='$ps_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt1=$row['cnt1'];
	return $cnt1;
}
function delete_police($ps_cd)
{
	$sql="delete from policestation where 	policestationcd='$ps_cd'";
	$i=execDelete($sql);
	return $i;
}
//======================== Polling Station ===========================
function fatch_dcrc($assembly)
{
	$sql="Select dcrc_party.dcrcgrp,
	  dcrc_party.number_of_member,
	  dcrc_party.assemblycd
	From dcrc_party where dcrc_party.assemblycd='$assembly'";
	$sql.=" order by dcrc_party.dcrcgrp";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_dcrc_member($dcrc,$assembly)
{
	$sql="Select dcrc_party.dcrcgrp,
	  dcrc_party.number_of_member,
	  dcrc_party.assemblycd
	From dcrc_party where dcrc_party.assemblycd='$assembly' and dcrc_party.dcrcgrp='$dcrc'";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_dcrc_assembly($subdiv)
{
	$sql="Select 
	  dcrcmaster.assemblycd,
	  dcrcmaster.no_of_member,
	  assembly.assemblyname
	From dcrcmaster
	  Inner Join assembly On assembly.assemblycd = dcrcmaster.assemblycd   where 1=1";
	if($subdiv!='0' && $subdiv!='')
		$sql.=" and dcrcmaster.subdivisioncd='$subdiv'";
	$sql.=" group by dcrcmaster.assemblycd";
	$sql.=" order by dcrcmaster.assemblycd asc";

	//echo $sql;
	//exit;
	$rs=execSelect($sql);
	return $rs;
}
//fetch member
function fatch_dcrc_member_assembly($subdiv,$member,$assembly)
{
	$sql="Select distinct
	  dcrcmaster.assemblycd,
	  dcrcmaster.no_of_member,
	  assembly.assemblyname

	From dcrcmaster
	  Inner Join assembly On assembly.assemblycd = dcrcmaster.assemblycd 
	   and dcrcmaster.subdivisioncd = assembly.subdivisioncd
	  where 1=1";
	if($subdiv!='0' && $subdiv!='')
		$sql.=" and dcrcmaster.subdivisioncd='$subdiv'";
	if($assembly!='0' && $assembly!='')
		$sql.=" and dcrcmaster.assemblycd='$assembly'";
    if($member!='0' && $member!='')
		$sql.=" and dcrcmaster.no_of_member='$member'";
	$sql.=" order by dcrcmaster.assemblycd asc";

	$rs=execSelect($sql);
	return $rs;
}
//fetch dcrc venue
function fatch_dcrc_member_assembly_venue($subdiv,$member,$assembly)
{
	$sql="Select 
	  dcrcmaster.dcrcgrp,
	  dcrcmaster.dc_venue,
          DATE_FORMAT(dcrc_party.dc_date,'%d/%m/%Y') as dc_date,
          dcrc_party.dc_time
	From dcrcmaster
	  Inner Join assembly On assembly.assemblycd = dcrcmaster.assemblycd 
	   and dcrcmaster.subdivisioncd = assembly.subdivisioncd
         Inner Join dcrc_party On dcrc_party.dcrcgrp= dcrcmaster.dcrcgrp
	  where 1=1";
	if($subdiv!='0' && $subdiv!='')
		$sql.=" and dcrcmaster.subdivisioncd='$subdiv'";
	if($assembly!='0' && $assembly!='')
		$sql.=" and dcrcmaster.assemblycd='$assembly'";
    if($member!='0' && $member!='')
		$sql.=" and dcrcmaster.no_of_member='$member'";
	$sql.=" order by dcrcmaster.assemblycd asc";

	$rs=execSelect($sql);
	return $rs;
}
function fatch_dcrcname($sub_div)
{
	$sql="Select dcrcmaster.dcrcgrp,
	  dcrcmaster.dc_venue
	From dcrcmaster where dcrcmaster.subdivisioncd='$sub_div'";
	$sql.=" order by dcrcmaster.dc_venue";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_polling_stn($psno,$assembly,$member,$psname,$postfix)
{
	$sql="Select count(*) As cnt From pollingstation where psno='$psno' and forassembly='$assembly' and psfix='$postfix' and member='$member'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt=$row['cnt'];
	return $cnt;
}
function save_polling_stn($psno,$postfix,$subdivision,$assembly,$dcrc,$member,$psname,$usercd)
{
	$sql="insert into pollingstation (psno,forassembly,psfix,forsubdivision,dcrccd,member,psname,usercode) values ('$psno','$assembly','$postfix','$subdivision','$dcrc','$member','$psname','$usercd')";
	$i=execInsert($sql);
	return $i;
}
function update_polling_stn($psno,$postfix,$assembly,$psname,$usercd,$posted_date,$pscode)
{
	$sql="update pollingstation set psfix='$postfix',psname='$psname',usercode='$usercd',posted_date='$posted_date' where psno='$psno' and forassembly='$assembly' and code='$pscode'";
	$i=execUpdate($sql);
	return $i;
}
function fetch_polling_station($psno,$assembly,$dist,$ps_cd)
{
	$sql="Select pollingstation.psno,
	  pollingstation.forassembly,
	  pollingstation.psfix,
	  pollingstation.forsubdivision,
	  pollingstation.dcrccd,
	  pollingstation.member,
	  pollingstation.psname,
	  assembly.assemblyname,
	  subdivision.subdivision
	From pollingstation
	  Inner Join assembly On pollingstation.forassembly = assembly.assemblycd
	  Inner Join subdivision On pollingstation.forsubdivision =
		subdivision.subdivisioncd where pollingstation.psno>0 and subdivision.districtcd='$dist'";
	if($psno!='' && $assembly!='')
		$sql.=" and pollingstation.psno='$psno' and pollingstation.forassembly='$assembly'";
	if($ps_cd!='' && $ps_cd!='')
		$sql.=" and pollingstation.code='$ps_cd'";
	$sql.=" order by pollingstation.psno, pollingstation.forassembly";
	$rs=execSelect($sql);
	return $rs;
}
function delete_ps($pscode)
{
	$sql="delete from pollingstation where code='$pscode'";
	$i=execDelete($sql);
	return $i;
}
//======================= DCRC Master ========================
function fatch_pc_ag_assembly($assembly)
{
	$sql="select pccd from assembly where assemblycd='$assembly'";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_dcrc_maxcode($subdivision)
{
	$sql="select max(dcrcgrp) as dcrc_cd from dcrcmaster where subdivisioncd='$subdivision'";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_dcrc_master($party_req,$assembly,$member,$subdivision)
{
	$sql="select count(*) as cnt from dcrc_party where subdivisioncd='$subdivision' and dcrc_party.assemblycd='$assembly' and number_of_member='$member' and partyindcrc='$party_req'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['cnt'];
	return $i;
}
function save_dcrc_master($dcrc_code,$subdivision,$assembly,$member,$dc_venue,$dc_address,$rc_venue,$dist_cd,$usercd,$rc_address)
{
	$sql="insert into dcrcmaster (dcrcgrp, assemblycd, no_of_member, dc_venue, dc_addr, rcvenue, districtcd, subdivisioncd,usercode, rc_addr) values ('$dcrc_code','$assembly','$member','$dc_venue','$dc_address','$rc_venue','$dist_cd','$subdivision','$usercd','$rc_address')";
	$i=execInsert($sql);
	return $i;
}
function save_dcrc_party($assembly,$member,$party_req,$dcrc_code,$subdivision,$pc,$dc_date,$dc_time,$usercd)
{
	$sql="insert into dcrc_party (dcrcgrp, assemblycd, number_of_member, partyindcrc, subdivisioncd, forpc, dc_date, dc_time, usercode) values ('$dcrc_code','$assembly','$member','$party_req','$subdivision','$pc','$dc_date','$dc_time','$usercd')";
	$i=execInsert($sql);
	return $i;
}
/*function fatch_dcrc_mo_party_sup($sub_div,$assembly,$m,$p,$c)
{
	$sql="Select dcrcmaster.dcrcgrp,
	  dcrcmaster.no_of_member,
	  dcrcmaster.dc_venue,
	  dcrcmaster.rcvenue,
	  date_format(dcrc_party.dc_date,'%d/%m/%Y') as dc_date,
	  dcrc_party.dc_time,
	  dcrc_party.partyindcrc,
	  dcrcmaster.dc_addr,
	  dcrcmaster.rc_addr
	  
	From dcrcmaster
	  Inner Join dcrc_party On dcrcmaster.dcrcgrp = dcrc_party.dcrcgrp

	where dcrcmaster.dcrcgrp>0 ";
	if($sub_div!='' && $sub_div!='0')
		$sql.=" AND dcrcmaster.subdivisioncd='$sub_div'";
	if($assembly!='' && $assembly!='0')
		$sql.=" AND dcrcmaster.assemblycd='$assembly'";
	if($m!='' && $m!='0')
		$sql.=" and dcrcmaster.no_of_member=1";
	if($p!='' && $p!='0')
		$sql.=" and (dcrcmaster.no_of_member>=4 and dcrcmaster.no_of_member<=6)";
	if($c!='' && $c!='0')
		$sql.=" and dcrcmaster.no_of_member=3";
	//echo $sql;
	$rs=execSelect($sql);
	return $rs;
}*/

function fatch_dcrc_list($sub_div,$assembly,$dist)
{
	$sql="Select dcrcmaster.dcrcgrp,
	  dcrcmaster.no_of_member,
	  dcrcmaster.dc_venue,
	  dcrcmaster.rcvenue,
	  date_format(dcrc_party.dc_date,'%d/%m/%Y') as dc_date,
	  dcrc_party.dc_time,
	  dcrc_party.partyindcrc,
	  dcrcmaster.dc_addr,
	  dcrcmaster.rc_addr,
	  dcrcmaster.assemblycd
	  
	From dcrcmaster
	  Inner Join dcrc_party On dcrcmaster.dcrcgrp = dcrc_party.dcrcgrp
	where dcrcmaster.dcrcgrp>0 ";
	if($sub_div!='' && $sub_div!='0')
		$sql.=" AND dcrcmaster.subdivisioncd='$sub_div'";
	if($assembly!='' && $assembly!='0')
		$sql.=" AND dcrcmaster.assemblycd='$assembly'";
	if($dist!='' && $dist!='0')
		$sql.=" and dcrcmaster.districtcd='$dist'";
	//echo $sql;
	$rs=execSelect($sql);
	return $rs;
}
function dcrc_del_check($dcrc)
{
	$sql="Select count(*) as cnt From pollingstation where dcrccd='$dcrc'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt=$row['cnt'];
	connection_close();
	return $cnt;
}
function delete_dcrc($dcrc)
{
	$sql="delete from dcrc_party where dcrcgrp='$dcrc'";
	execDelete($sql);
	$sql1="delete from dcrcmaster where dcrcgrp='$dcrc'";
	$i=execDelete($sql1);
	connection_close();
	return $i;
}
?>