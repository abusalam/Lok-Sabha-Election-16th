<?php
include_once("string_fun.php");

function fatch_offcDtl($offccd,$Subdivision,$Statusofoffice)
{
	$sql;$rs;
	$sql="Select office.officecd As officecd,
  office.office As office,
  govtcategory.govt_description,
  office.male_staff,
  office.female_staff,
  office.tot_staff
From office
Inner Join  govtcategory on govtcategory.govt=office.govt";  
$sql.=" where office.officecd>0 ";
if($Subdivision!='' && $Subdivision!="0")
	$sql.="and office.subdivisioncd='$Subdivision'";
if($Statusofoffice!='' && $Statusofoffice!="0")
	$sql.="and office.govt='$Statusofoffice' ";
if($offccd!='' && $offccd!="0")
	$sql.="and office.officecd='$offccd' ";	
$sql.="order by office.officecd ASC";
//echo $sql;
//exit();
$rs=execSelect($sql);	
	connection_close();
	return $rs;
}
?>