<?php
include_once('string_fun.php');

function fatch_Office_ag_subdiv($sub_div)
{
	$sql=''; $rs=null;
	$sql="Select officecd, office From office where subdivisioncd='$sub_div' order by office";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_personnel_ag_office($office)
{
	$sql=""; $rs=null;
	$sql="Select personcd, officer_name From personnela where officecd='$office' order by personcd";
	$rs=execSelect($sql);
	return $rs;
}
function new_person_details($personcd)
{
	$sql=""; $rs=null;
	$sql="Select personnela.personcd, personnela.officecd, office.office, personnela.off_desg as designation,
  personnela.officer_name, personnela.present_addr1, personnela.present_addr2,
  personnela.perm_addr1, personnela.perm_addr2, Date_Format(personnela.dateofbirth,'%Y-%m-%d') as dateofbirth, personnela.gender,         
  personnela.workingstatus, personnela.email, personnela.resi_no,
  personnela.mob_no, personnela.epic, personnela.slno, personnela.partno, personnela.poststat, personnela.assembly_temp,
  personnela.assembly_off, personnela.assembly_perm, personnela.acno, personnela.bank_acc_no,
  personnela.bank_cd, personnela.branchcd, personnela.remarks, personnela.pgroup, assembly.assemblyname, assembly.pccd";
  	$sql.=" From personnela ";
  	$sql.=" Inner Join office On personnela.officecd = office.officecd";
  	$sql.=" left join assembly on personnela.acno=assembly.assemblycd";
  	$sql.=" where personnela.personcd='$personcd'";
	$rs=execSelect($sql);
	return $rs;
}
function new_person_details_ag_epic($epic)
{
	$sql=""; $rs=null;
	$sql="Select personnela.personcd, personnela.officecd, office.office, personnela.off_desg as designation,
  personnela.officer_name, personnela.present_addr1, personnela.present_addr2,
  personnela.perm_addr1, personnela.perm_addr2, Date_Format(personnela.dateofbirth,'%Y-%m-%d') as dateofbirth, personnela.gender,         
  personnela.workingstatus, personnela.email, personnela.resi_no,
  personnela.mob_no, personnela.epic, personnela.slno, personnela.partno, personnela.poststat, personnela.assembly_temp,
  personnela.assembly_off, personnela.assembly_perm, personnela.acno, personnela.bank_acc_no,
  personnela.bank_cd, personnela.branchcd, personnela.remarks, personnela.pgroup, assembly.assemblyname, assembly.pccd";
  	$sql.=" From personnela ";
  	$sql.=" Inner Join office On personnela.officecd = office.officecd";
  	$sql.=" left join assembly on personnela.acno=assembly.assemblycd";
  	$sql.=" where personnela.epic='$epic'";
	$rs=execSelect($sql);
	return $rs;
}
function fatch_PC_ag_dist($districtcd)
{
	$sql=""; $rs=null;
	$sql="Select distinct pc.pccd, pc.pcname From pc where pc.district='$districtcd'";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_po_ed($personnel)
{
	$sql="select count(*) as dup from po_ed where personcd='$personnel'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$dup=$row['dup'];
	return $dup;
}

function save_po_ed($personnel,$pc,$ed_pb,$usercd)
{
	$sql="insert into po_ed (personcd, pccd, ed_pb, usercode) values ('$personnel','$pc','$ed_pb','$usercd')";
	$i=execInsert($sql);
	return $i;
}
function form_12_report($personcd,$type)
{
	$sql=""; $rs=null;
	$sql="Select pc.pccd,
	  pc.pcname,
	  po_ed.pccd As pccd1,
	  pc1.pcname As pcname1,
	  personnela.slno,
	  personnela.partno,
	  personnela.acno,
	  assembly.assemblyname,
	  personnela.present_addr1,
	  personnela.present_addr2,
	  personnela.personcd,
  	  personnela.officer_name
	From personnela
	  Left Join assembly On personnela.acno = assembly.assemblycd
	  Left Join pc On assembly.pccd = pc.pccd
	  Inner Join po_ed On personnela.personcd = po_ed.personcd
	  Inner Join pc pc1 On po_ed.pccd = pc1.pccd ";
	$sql.=" where personnela.personcd='$personcd' and po_ed.ed_pb='$type'";
	$rs=execSelect($sql);
	return $rs;
}
function form12A_report($personcd,$type)
{
	$sql=""; $rs=null;
	$sql="Select DISTINCT pc.pccd,
	  pc.pcname,
	  po_ed.pccd As pccd1,
	  pc1.pcname As pcname1,
	  personnela.slno,
	  personnela.partno,
	  personnela.acno,
	  assembly.assemblyname,
	  personnela.present_addr1,
	  personnela.present_addr2,
	  personnela.personcd,
	  personnela.officer_name,
	  pollingstation.psno,
	  pollingstation.psname
	From personnela
	  Left Join assembly On personnela.acno = assembly.assemblycd
	  Left Join pc On assembly.pccd = pc.pccd
	  Inner Join po_ed On personnela.personcd = po_ed.personcd
	  Inner Join pc pc1 On po_ed.pccd = pc1.pccd
	  Inner Join pollingstation On personnela.groupid = pollingstation.groupid";	  
	$sql.=" where personnela.personcd='$personcd' and po_ed.ed_pb='$type'";
	$rs=execSelect($sql);
	return $rs;
}
?>