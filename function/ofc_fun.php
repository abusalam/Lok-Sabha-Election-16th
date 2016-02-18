<?php
include_once('string_fun.php');
function office_details($offccd)
{
	$sql;$rs;
	$sql="Select Distinct office.officecd,
	  office.officer_desg as designation,
	  office.office,
	  office.address1,
	  office.address2,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin
	From office
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  Inner Join district On office.districtcd = district.districtcd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd where office.officecd<>''";
	if($offccd!="" && $offccd!="0")
		$sql.=" and office.officecd='$offccd'";
	$rs=execSelect($sql);
	return $rs;
}
function office_details_ag_sub($offccd,$subdiv)
{
	$sql;$rs;
	$sql="Select Distinct office.officecd,
	  office.officer_desg as designation,
	  office.office,
	  office.address1,
	  office.address2,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  block_muni.blockmuni
	From office
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  Inner Join district On office.districtcd = district.districtcd
	  Inner Join block_muni On block_muni.blockminicd = office.blockormuni_cd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd where office.officecd<>'' and office.subdivisioncd='$subdiv'";
	if($offccd!="" && $offccd!="0")
		$sql.=" and office.officecd='$offccd'";
	$sql.=" order by office.subdivisioncd,office.blockormuni_cd,office.officecd";
	$rs=execSelect($sql);
	return $rs;
}

function office_wise_list($office)
{
	$sql="Select Distinct personnela.personcd,
	  personnela.officer_name,
	  personnela.off_desg as designation,
	  poststat.poststatus
	From office
	  Inner Join personnela On office.officecd = personnela.officecd
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	Where personnela.personcd<>''";
	$sql.=" and personnela.officecd='$office' and personnela.selected='1'";
	$sql.=" Order By personnela.personcd,
	  poststat.poststatus,
	  personnela.off_desg";
	$rs=execSelect($sql);
	return $rs;
}
function office_n_forsub_wise_list($office,$subdiv)
{
	$sql="Select Distinct personnela.personcd,
	  personnela.officer_name,
	  personnela.off_desg as designation,
	  poststat.poststatus
	From office
	  Inner Join personnela On office.officecd = personnela.officecd
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	Where personnela.personcd<>''";
	$sql.=" and personnela.officecd='$office' and personnela.subdivisioncd='$subdiv' and personnela.selected='1'";
	$sql.=" Order By personnela.personcd,
	  poststat.poststatus,
	  personnela.off_desg";
	$rs=execSelect($sql);
	return $rs;
}
function office_details_ag_forsub($subdiv,$from,$to)
{
	$sql="Select Distinct office.officecd,
	  office.officer_desg as designation,
	  office.office,
	  office.address1,
	  office.address2,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  block_muni.blockmuni
	From office
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  Inner Join district On office.districtcd = district.districtcd
	  Inner Join block_muni On block_muni.blockminicd = office.blockormuni_cd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd 
		inner join personnela on personnela.officecd=office.officecd where personnela.subdivisioncd='$subdiv' and personnela.selected=1";
		if($from!='-1')
		  $sql.=" order by office.subdivisioncd,office.blockormuni_cd,office.officecd limit $from,$to";
		else
		   $sql.=" order by office.subdivisioncd,office.blockormuni_cd,office.officecd";
		
		
	//echo $sql;
	//exit;
	
	$rs=execSelect($sql);
	return $rs;
}
?>