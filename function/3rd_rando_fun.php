<?php
function fatch_assembly_party_3rdrando_details($subdiv)
{
	$sql="Select assembly_party.assemblycd,
	  assembly_party.rand_status,
	  assembly.assemblyname
	
	From assembly_party
	Inner Join assembly On assembly_party.assemblycd = assembly.assemblycd
		where assembly_party.assemblycd>0";
	if($subdiv!='' && $subdiv!=NULL && $subdiv!=0)
		$sql.=" and assembly_party.subdivisioncd='$subdiv'";
		$sql.="  group by assembly_party.assemblycd";
	$sql.=" order by assembly.assemblycd";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
?>