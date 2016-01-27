<?php
include_once('string_fun.php');
function fatch_assembly_party_details($assemb,$subdiv)
{
	$sql="Select assembly_party.assemblycd,
	  assembly_party.no_of_member,
	  assembly_party.no_party,
	  assembly.assemblyname,
	  subdivision.subdivision
	
	From assembly_party
	  Inner Join assembly On assembly_party.assemblycd = assembly.assemblycd
	  inner join subdivision on subdivision.subdivisioncd=assembly_party.subdivisioncd
		where assembly_party.assemblycd>0";
	if($subdiv!='' && $subdiv!=NULL && $subdiv!=0)
		$sql.=" and assembly_party.subdivisioncd='$subdiv'";
	if($assemb!='' && $assemb!=NULL && $assemb!=0)	
		$sql.="  and assembly_party.assemblycd='$assemb'";
	$sql.=" order by assembly_party.subdivisioncd,assembly.assemblycd";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_assembly_party_details1($assemb,$subdiv,$p_num,$items)
{
	$sql="Select assembly_party.assemblycd,
	  assembly_party.no_of_member,
	  assembly_party.no_party,
	  assembly.assemblyname,
	  subdivision.subdivision,
	  assembly_party.subdivisioncd
	
	From assembly_party
	  Inner Join assembly On assembly_party.assemblycd = assembly.assemblycd
	  inner join subdivision on subdivision.subdivisioncd=assembly_party.subdivisioncd
		where assembly_party.assemblycd>0";
	if($subdiv!='' && $subdiv!=NULL && $subdiv!=0)
		$sql.=" and assembly_party.subdivisioncd='$subdiv'";
	if($assemb!='' && $assemb!=NULL && $assemb!=0)	
		$sql.="  and assembly_party.assemblycd='$assemb'";
	$sql.=" order by assembly_party.subdivisioncd,assembly.assemblycd";
	$sql.=" ASC LIMIT $p_num , $items";
	//echo $sql; exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_reserve_ag_assembly_no($assembly,$noofmember)
{
	$sql="Select reserve.forassembly,
	  reserve.number_of_member,
	  reserve.poststat,
	  reserve.no_or_pc,
	  reserve.numb,
	  assembly.assemblyname
	
	From reserve
	  Inner Join assembly On reserve.forassembly = assembly.assemblycd
 where 1 ";
	if($assembly!='')
		$sql.=" and reserve.forassembly='$assembly'";
	if($noofmember!='')
		$sql.=" and number_of_member='$noofmember'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function assembly_party_del_check($ass,$no)
{
	$sql="Select count(*) as cnt From dcrcmaster where assemblycd='$ass' and no_of_member='$no'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$cnt=$row['cnt'];
	//$sql1="delete from 	assembly_party where assemblycd='$ass' and no_of_member='$no'";
	//$i=execDelete($sql1);
	connection_close();
	return $cnt;
}
function delete_assembly_party_reserve($ass,$no)
{
	$sql="delete from reserve where forassembly='$ass' and number_of_member='$no'";
	execDelete($sql);
	$sql1="delete from 	assembly_party where assemblycd='$ass' and no_of_member='$no'";
	$i=execDelete($sql1);
	connection_close();
	return $i;
}
function fetch_Assembly_party($assembly,$subdivision)
{
	$sql;$rs;$sql1;
    $i=0;
    $data_list=array();
	//$sql1="Update assembly_party set start_sl=0 where assemblycd='$assembly' and subdivisioncd='$subdivision'";
	//execUpdate($sql1);
    $sql="select  start_sl, no_party ,subdivisioncd,assemblycd,no_of_member from assembly_party where assemblycd='$assembly' and subdivisioncd='$subdivision'";
   	$rs=execSelect($sql);
	while($asm_status = getRows($rs)) {
	$data_list[$i]['sl']=$asm_status['start_sl'];
	$data_list[$i]['np']=$asm_status['no_party'];
	$data_list[$i]['sdcd']=$asm_status['subdivisioncd'];
	$data_list[$i]['asmcd']=$asm_status['assemblycd'];
	$data_list[$i]['no_m']=$asm_status['no_of_member'];
	$i++;
	}
	return $data_list;
	
}
function update_next_party_sl($sum_pp,$next_sdcd,$next_asmcd,$next_no_m)
{
	$sql="update assembly_party set start_sl='$sum_pp' where assemblycd='$next_asmcd' and subdivisioncd='$next_sdcd' and no_of_member='$next_no_m'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
function update_Assembly_slno($assembly,$subdivision)
{
	$sql1="Update assembly_party set start_sl=0 where assemblycd='$assembly' and subdivisioncd='$subdivision'";
	$i=execUpdate($sql1);
	connection_close();
	return $i;
}
?>