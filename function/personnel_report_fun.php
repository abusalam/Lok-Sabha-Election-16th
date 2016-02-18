<?php
include_once("string_fun.php");

function fatch_personnelDtl($Subdivision)
{
	$sql;$rs;
	$sql="Select personnel.officecd As officecd,
	
	govtcategory.govt_description,
    count(gender) as gen
From personnel
Left Join office on personnel.officecd=office.officecd
Inner Join  govtcategory on govtcategory.govt=office.govt";  
$sql.=" where personnel.officecd>0 ";
if($Subdivision!='' && $Subdivision!="0")
	$sql.="and personnel.subdivisioncd='$Subdivision'";
if($gender!='' && $gender!="0")
	$sql.="and personnel.gender='$gender' ";
if($offccd!='' && $offccd!="0")
	$sql.="and personnel.officecd='$offccd' ";	
if($Statusofoffice!='' && $Statusofoffice!="0")
	$sql.="and office.govt='$Statusofoffice' ";
$sql.="order by personnel.officecd ASC";
//echo $sql;
//exit();
    $rs=execSelect($sql);	
	connection_close();
	return $rs;
}
function fatch_personnelDtl1($offccd,$Subdivision,$gender,$Statusofoffice,$posting_status,$partno,$sl_no,$epic_no,$mobile,$emailid,$bank,$epic)
{
	$sql;$rs;
	$sql="Select personnel.officecd As officecd,
	      personnel.personcd,personnel.gender

From personnel
Left Join office on personnel.officecd=office.officecd
Left Join termination On personnel.personcd = termination.personal_id ";  
$sql.=" where personnel.officecd>0 And termination.personal_id Is Null ";
if($Subdivision!='' && $Subdivision!="0")
	$sql.="and personnel.subdivisioncd='$Subdivision'";
if($gender!='' && $gender!="0")
	$sql.="and personnel.gender='$gender' ";
if($offccd!='' && $offccd!="0")
	$sql.="and personnel.officecd='$offccd' ";	
if($Statusofoffice!='' && $Statusofoffice!="0")
	$sql.="and office.govt='$Statusofoffice' ";
if($posting_status!='' && $posting_status!="0")
	$sql.="and personnel.poststat='$posting_status' ";
if($partno=="1")
    $sql.="and personnel.partno <>'0'";
if($sl_no=="1")
    $sql.="and personnel.slno <>'0'";
if($epic=="1")
    $sql.="and personnel.epic <>'0'";
if($epic_no!='' && $epic_no!="0")
	$sql.="and personnel.epic_no='$epic_no' ";
if($mobile=='YES')
	$sql.="and personnel.mob_no <> '' ";
if($mobile=='NO')
	$sql.="and personnel.mob_no = '' ";
if($emailid=='YES')
	$sql.="and personnel.email <> '' ";
if($emailid=='NO')
	$sql.="and personnel.email = '' ";
if($bank=='YES')
	$sql.="and (personnel.bank_acc_no <> '' and personnel.bank_acc_no <> '0')";
if($bank=='NO')
	$sql.="and (personnel.bank_acc_no = '' and personnel.bank_acc_no = '0') ";
$sql.="order by personnel.officecd ASC";

    $rs=execSelect($sql);	
	connection_close();
	return $rs;
}
function fatch_personnelsgm($sub_div,$gender,$Statusofoffice)
{
	$sql;$rs;$row;$i;
	$sql="Select 
    count(gender) as gen
From personnel
Left Join office on personnel.officecd=office.officecd 
Left Join termination On personnel.personcd = termination.personal_id";  
$sql.=" where personnel.officecd>0 and termination.personal_id Is Null ";
	if($sub_div!='' && $sub_div!="0")
	  $sql.="and personnel.subdivisioncd='$sub_div'";
    if($gender!='' && $gender!="0")
	  $sql.="and personnel.gender='$gender' ";
	if($Statusofoffice!='' && $Statusofoffice!="Other")
	  $sql.="and office.govt='$Statusofoffice' ";
	if($Statusofoffice=="Other")
	  $sql.="and office.govt in('05','06','07','08') ";
	$rs=execSelect($sql);
	$row=getRows($rs);	
	$i=$row['gen'];
	connection_close();
	return $i;
}
//======================================Personnel Validation=======================
function fatch_personnelvalidation($sub_div)
{
	$sql;$rs;
	$sql="Select personnel.officecd,
	      personnel.personcd,officer_name,off_desg,dateofbirth,gender,subdivisioncd,poststat,assembly_temp,assembly_off,assembly_perm,acno,qualificationcd,bank_cd,branchcd,mob_no,bank_acc_no,epic
From personnel
 Left Join termination On personnel.personcd = termination.personal_id
 where  termination.personal_id is null and ( ";  
$sql.="  (personnel.officecd = '' or personnel.officecd = '0' or LENGTH(personnel.officecd) <> 10) 
      or (personnel.subdivisioncd = '' or personnel.subdivisioncd = '0') 
      or (personnel.personcd = '' or personnel.personcd = '0' or LENGTH(personnel.personcd) <> 11)  
      or (personnel.officer_name = '' or personnel.officer_name = '0') 
	  or (personnel.off_desg = '' or personnel.off_desg = '0') 
	  or (personnel.dateofbirth = '' or personnel.dateofbirth = '0000-00-00 00:00:00')
	  or (personnel.gender = '' or personnel.gender = '0')
	  or (personnel.poststat = '' or personnel.poststat = '0')
	  or (personnel.assembly_temp = '' or personnel.assembly_temp = '0' or LENGTH(personnel.assembly_temp) <> 3)
	  or (personnel.assembly_off = '' or personnel.assembly_off = '0' or LENGTH(personnel.assembly_off) <> 3)
	  or (personnel.assembly_perm = '' or personnel.assembly_perm = '0' or LENGTH(personnel.assembly_perm) <> 3)
	  or (personnel.acno = '' or personnel.acno = '0' or LENGTH(personnel.acno) <> 3)
	  or (personnel.qualificationcd = '' or personnel.qualificationcd = '0')
	  or (personnel.bank_cd = '' or personnel.bank_cd = '0')
	  or (personnel.branchcd = '' or personnel.branchcd = '0')
	  or (personnel.bank_acc_no = '' or personnel.bank_acc_no = '0')
	  or (LENGTH(personnel.mob_no) <> 10)
	  or (LENGTH( personnel.epic ) <6 or personnel.epic LIKE  'x%x'))";
 if($sub_div!='' && $sub_div!="0")
	  $sql.="and personnel.subdivisioncd='$sub_div'";
	$rs=execSelect($sql);	
	connection_close();
	return $rs;
}
/////pp wise bank details////
function pp_wise_bank_excel($subdiv,$dist_cd)
{
	$sql;$rs;
	$sql="
	SELECT bank.bank_name, (

SELECT branch.branch_name
FROM branch
WHERE branch.branchcd = personnel.branchcd
AND branch.bank_cd = personnel.bank_cd
) AS branch_name, (

SELECT branch.ifsc_code
FROM branch
WHERE branch.branchcd = personnel.branchcd
AND branch.bank_cd = personnel.bank_cd
) AS ifsc_code, personnel.`bank_acc_no` , personnel.`officer_name` , personnel.`mob_no` 
FROM personnel
INNER JOIN bank ON bank.bank_cd = personnel.bank_cd
LEFT JOIN termination ON personnel.personcd = termination.personal_id
WHERE personnel.personcd >0
AND termination.personal_id IS NULL  
 ";  
if($subdiv!='' && $subdiv!="0")
	$sql.="AND personnel.`subdivisioncd` = '$subdiv'";
$sql.="AND personnel.districtcd= '$dist_cd'";
$sql.="ORDER BY personnel.bank_cd ";
//echo $sql;
//exit();
    $rs=execSelect($sql);	
	connection_close();
	return $rs;
}
?>