<?php
include_once("string_fun.php");

function govt_cat_wise_report($districtcd,$subdivisioncd,$govt)
{
	$sql="Select Distinct govtcategory.govt_description,
	  Count(personnela.personcd) as count,
	  office.subdivisioncd,
	  office.districtcd
	From office
	  Inner Join personnela On office.officecd = personnela.officecd
	  Right Join govtcategory On govtcategory.govt = office.govt
	where office.districtcd>0";
	if($districtcd>0)
		$sql.=" and office.districtcd='$districtcd'";
	if($subdivisioncd>0)
		$sql.=" and office.subdivisioncd='$subdivisioncd'";
	if($govt>0)
		$sql.=" and office.govt='$govt'";
	$sql.="Group By govtcategory.govt_description,office.subdivisioncd,office.districtcd";
	$sql.=" order by govtcategory.govt_description";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function govt_cat_ag_post_stat_report($post_stat,$subdivisioncd,$gender)
{
	$sql="Select subdivision.subdivision,
	  Count(personnel.personcd) as total,
	  govtcategory.govt_description
	From poststat
	  Inner Join personnel On poststat.post_stat = personnel.poststat
	  Inner Join office On personnel.officecd = office.officecd
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  Inner Join govtcategory On office.govt = govtcategory.govt
	  Left Join termination On personnel.personcd = termination.personal_id where personnel.personcd>0 And termination.personal_id Is Null";
	$sql.=" and poststat.post_stat = '$post_stat' And subdivision.subdivisioncd = '$subdivisioncd'";
	if($gender!='' && $gender!='0')
		$sql.=" and personnel.gender='$gender'";
	$sql.=" Group By subdivision.subdivision, govtcategory.govt_description";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function get_assembly_dcrc_venue($subdivisioncd,$assemblycd)
{
	$sql="Select distinct assembly.assemblycd,
	  assembly.assemblyname,
	  dcrcmaster.dcrcgrp,
	  dcrcmaster.dc_venue,
	  dcrcmaster.rcvenue,
	  dcrcmaster.dc_addr
	From dcrcmaster
	  Inner Join assembly On dcrcmaster.assemblycd = assembly.assemblycd";
	 $sql.=" where dcrcmaster.subdivisioncd='$subdivisioncd'";
	 if($assemblycd!="" && $assemblycd!="0")
	 	$sql.=" and assembly.assemblycd='$assemblycd'";
	$sql.=" order by assembly.assemblycd,dcrcmaster.dcrcgrp";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function polling_party_ag_psno($dcrc, $orderby)
{
	$sql="Select pollingstation.groupid,
	  pollingstation.psno,pollingstation.psfix,
	  pollingstation.psname
	From pollingstation";
	$sql.=" where dcrccd='$dcrc' and (groupid<>'' or groupid is not null)";
	if($orderby=='psno')
		$sql.=" order by pollingstation.psno";
	else
		$sql.=" order by groupid";
		//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function get_assembly($subdivisioncd,$assemblycd)
{
	$sql="Select Distinct assembly.assemblycd,
	  assembly.assemblyname
	From assembly";
	 $sql.=" where subdivisioncd='$subdivisioncd'";
	 if($assemblycd!="" && $assemblycd!="0")
	 	$sql.=" and assembly.assemblycd='$assemblycd'";
	$sql.=" order by assembly.subdivisioncd,assembly.assemblycd";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function polling_party_ag_psno_list($assembly)
{
	$sql="Select pollingstation.groupid,
	  pollingstation.psno
	From pollingstation ";
	$sql.=" where forassembly='$assembly' and (groupid<>'' or groupid is not null)";
	$sql.=" order by groupid";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
//==================== Bulk Query ========================
function get_office_ag_pc_subdiv($subdiv,$pc)
{
	$sql="Select Distinct office.officecd,
	  office.office
	From office
	  Inner Join personnela On personnela.officecd = office.officecd";
	$sql.=" where personnela.forsubdivision='$subdiv' and personnela.forpc='$pc'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function get_person_ag_office($office,$forpc)
{
	$sql="Select Distinct personnela.personcd,
	  personnela.officer_name,
	  personnela.off_desg,
	  personnela.assembly_off,
	  personnela.assembly_perm,
	  personnela.assembly_temp,
	  personnela.epic,
	  personnela.acno,
	  personnela.partno,
	  personnela.slno,
	  personnela.poststat
	From personnela";
	$sql.=" where personnela.officecd='$office' and personnela.forpc='$forpc'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}

?>