<?php
include_once('string_fun.php');
function second_app_hrd3($forassembly,$forpc,$group_id)
{
	$sql="Select Distinct personnela.groupid,
	  assembly.assemblycd,
	  assembly.assemblyname,
	  pc.pccd,
	  pc.pcname,
	  date_format(poll_table.poll_date,'%d/%m/%Y') as poll_date,
	  poll_table.poll_time,
	  dcrcmaster.dc_venue,
	  dcrcmaster.dc_addr,
	  date_format(dcrc_party.dc_date,'%d/%m/%Y') as dc_date,
	  dcrc_party.dc_time,
	  dcrcmaster.rcvenue
	From personnela
	  Inner Join pc On personnela.forpc = pc.pccd
	  Inner Join assembly On personnela.forassembly = assembly.assemblycd
	  Inner Join poll_table On personnela.forpc = poll_table.pc_cd
	  Inner Join grp_dcrc On personnela.groupid = grp_dcrc.groupid And
		personnela.forassembly = grp_dcrc.forassembly And personnela.forpc =
		grp_dcrc.forpc
	  Inner Join dcrc_party On dcrc_party.dcrcgrp = grp_dcrc.dcrccd
	  Inner Join dcrcmaster On grp_dcrc.dcrccd = dcrcmaster.dcrcgrp
	Where personnela.groupid Is Not Null And personnela.groupid != '0' ";
	//if($forassembly!='' && $forassembly!=null && $forassembly!=0)
	$sql.=" and personnela.forassembly='$forassembly'";
	//elseif($forpc!='' && $forpc!=null && $forpc!=0)
	$sql.=" and personnela.forpc='$forpc'";
	//if($group_id!='' && $group_id!=null)
	$sql.=" and personnela.groupid='$group_id'";
	$sql.=" order by personnela.forpc,personnela.forassembly,personnela.groupid";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}

function second_appointment_letter3($group_id,$forassembly)
{
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
	  district.district,
	  office.officecd,
	  personnela.poststat,
	  personnela.off_desg,
	  poststat.poststatus
	From personnela
	  Inner Join office On personnela.officecd = office.officecd
	  Inner Join subdivision On subdivision.subdivisioncd = office.subdivisioncd
	  Inner Join district On office.districtcd = district.districtcd
	  Left Join pc On personnela.forpc = pc.pccd And personnela.forsubdivision =
		pc.subdivisioncd
	  Left Join assembly On personnela.forassembly = assembly.assemblycd
	  Inner Join poststat On personnela.poststat = poststat.post_stat ";
	$sql.=" where personnela.groupid='$group_id' and personnela.forassembly='$forassembly' and personnela.booked='P'";
	$sql.=" order by personnela.groupid, personnela.poststat";
//		print $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
?>