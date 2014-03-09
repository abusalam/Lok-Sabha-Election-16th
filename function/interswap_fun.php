<?php
include_once('string_fun.php');

function fatch_PersonaldtlForInterSwap($subdivision,$pc,$posting_status)
{
	$sql="Select personnela.personcd,
	  personnela.forsubdivision,
	  personnela.forpc
	From personnela   
	  where (personnela.booked is null or personnela.booked='')";
	if($subdivision!='' && $subdivision!='0')
		  $sql.=" and personnela.forsubdivision= '$subdivision'";
	if($pc!='' && $pc!='0')
		  $sql.=" and personnela.forpc='$pc'";
	if($posting_status!='' && $posting_status!='0')
		  $sql.=" and personnela.poststat ='$posting_status'";
	$sql.=" order by rand()";
//		  echo $sql; exit;
	$rs=execSelect($sql);
//	connection_close();
	return $rs;
}
?>