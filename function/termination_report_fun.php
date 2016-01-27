<?php
include_once("string_fun.php");

function fetch_termination_detail($Subdivision)
{
	//echo $Subdivision;die;
	$sql;$rs;
	$sql="Select personnel.subdivisioncd As subdivisioncode,subdivision.subdivision As subdivision,count(termination.personal_id) as personcdcount  From termination Join personnel on termination.personal_id=personnel.personcd Join subdivision on personnel.subdivisioncd=subdivision.subdivisioncd"; 
$sql.=" where termination.termination_id>0 ";
if($Subdivision!='' && $Subdivision!="0"){
$sql.=" and personnel.subdivisioncd='$Subdivision'";
}
$sql.="group by personnel.subdivisioncd";

   $rs=execSelect($sql);	
	connection_close();
	return $rs;
}
?>