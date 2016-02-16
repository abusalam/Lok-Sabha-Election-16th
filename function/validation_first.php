<?php
include_once("string_fun.php");
/***************Post status validation***********/
function check_post_status($asm_memb)
{
   $sql;$rs;
   $i=0;
   $data_list=array();
   $sql="Select poststat from  poststatorder where 	memberparty='$asm_memb'";
   	$rs=execSelect($sql);
	while($post_status = getRows($rs)) {
	$data_list[$i]=$post_status['poststat'];
	$i++;
	}
	return $data_list;
}
function define_post_status($asm_memb)
{
	switch($asm_memb)
	{
		case ($asm_memb==4):
		 $asm_list = array(
			"0" => 'PR',
			"1" => 'P1',
			"2" => 'P2',
			"3" => 'P3',
		);
		 break;
		 case ($asm_memb==5):
		 $asm_list = array(
			"0" => 'PR',
			"1" => 'P1',
			"2" => 'P2',
			"3" => 'PA',
			"4" => 'P3',
		);
		 break;
		 case ($asm_memb==6):
		 $asm_list = array(
			"0" => 'PR',
			"1" => 'P1',
			"2" => 'P2',
			"3" => 'PA',
			"4" => 'PB',
			"5" => 'P3',
		);
		 break;
		 default:
		  break;
	}
	return $asm_list;
}
function fetch_assembly_member()
{
	$sql;$rs;
    $sql="Select no_of_member from assembly_party group by no_of_member";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
/************************Assembly party validate**************/
function fetch_array_asmparty($sdcd)
{
   $sql;$rs;
   $i=0;
   $data_list=array();
   $sql="Select assemblycd,no_of_member,no_party,subdivisioncd from assembly_party where subdivisioncd='$sdcd'";
   	$rs=execSelect($sql);
	while($asm_status = getRows($rs)) {
	$data_list[$i]['ad']=$asm_status['assemblycd'];
	$data_list[$i]['nm']=$asm_status['no_of_member'];
	$data_list[$i]['np']=$asm_status['no_party'];
	$data_list[$i]['sd']=$asm_status['subdivisioncd'];
	$i++;
	}
	return $data_list;
}
function check_in_dcrcparty($asmcd,$nm,$np,$sdcd)
{
	$sql;$rs;
	$sql="Select Count(*) as cnt from dcrc_party where assemblycd='$asmcd' and number_of_member='$nm' and partyindcrc='$np' and subdivisioncd='$sdcd'";
	$rs=execSelect($sql);
	$row=getRows($rs);	
	$i=$row['cnt'];
	connection_close();
	return $i;
}
/***********************Assembly party and reserve validate*********************/
function fetch_subdivision($subdiv_cd)
{
	 $sql;$rs;
   $i=0;
   $data_list=array();
   $sql="Select subdivisioncd from subdivision";
   if($subdiv_cd <> '0')
     $sql.=" Where subdivisioncd='$subdiv_cd'";
   	$rs=execSelect($sql);
	while($asm_status = getRows($rs)) {
	$data_list[$i]['sd']=$asm_status['subdivisioncd'];
	$i++;
	}
	return $data_list;
}
function fetch_percentage_number($subdiv,$poststat)
{
	$sql; $rs;
	$sql="SELECT a.forassembly AS fasm, a.forsubdivision AS fsub, a.forpc AS fpc, a.number_of_member AS memb, a.no_or_pc AS npc, a.numb AS pnumb, a.poststat AS pst, b.no_party AS ptyrqd
FROM reserve a,  `assembly_party` b
WHERE a.forassembly = b.assemblycd
AND a.forsubdivision = b.subdivisioncd
AND a.number_of_member = b.no_of_member
AND a.forsubdivision =  '$subdiv'";
if($poststat!='')
		$sql.=" and a.poststat='$poststat'";
 //echo $sql;
    $rs=execSelect($sql);
	return $rs;
}
/***********************Personnela validation***********************/
 function getPostno($col_post,$col_sub) {
					$sql="SELECT count(*) as cnt FROM personnela WHERE poststat='$col_post' and forsubdivision='$col_sub'";
					//echo $sql;
					//exit;
					$rs=execSelect($sql);
					while($user_data = getRows($rs)) {
					$level_list=$user_data['cnt'];
					}
					return $level_list;
}
function fatch_personnelavalidation()
{
	$sql;$rs;
	$sql="Select personnela.officecd,
	      personnela.personcd,officer_name,off_desg,dateofbirth,gender,subdivisioncd,poststat,assembly_temp,assembly_off,assembly_perm,acno,qualificationcd
From personnela

 where  1=1 and ( ";  
$sql.="  (personnela.officecd = '' or personnela.officecd = '0' or LENGTH(personnela.officecd) <> 10) 
      or (personnela.subdivisioncd = '' or personnela.subdivisioncd = '0') 
	  or (personnela.forsubdivision = '' or personnela.forsubdivision = '0') 
      or (personnela.personcd = '' or personnela.personcd = '0' or LENGTH(personnela.personcd) <> 11)  
      or (personnela.officer_name = '' or personnela.officer_name = '0') 
	  or (personnela.off_desg = '' or personnela.off_desg = '0') 
	  or (personnela.dateofbirth = '' or personnela.dateofbirth = '0000-00-00 00:00:00')
	  or (personnela.gender = '' or personnela.gender = '0')
	  or (personnela.poststat = '' or personnela.poststat = '0')
	  or (personnela.assembly_temp = '' or personnela.assembly_temp = '0' or LENGTH(personnela.assembly_temp) <> 3)
	  or (personnela.assembly_off = '' or personnela.assembly_off = '0' or LENGTH(personnela.assembly_off) <> 3)
	  or (personnela.assembly_perm = '' or personnela.assembly_perm = '0' or LENGTH(personnela.assembly_perm) <> 3)
	  or (personnela.qualificationcd = '' or personnela.qualificationcd = '0') )";
	$rs=execSelect($sql);	
	connection_close();
	return $rs;
}
/*function fetch_array_dcrcparty()
{
	$sql;$rs;
   $i=0;
   $data_list1=array();
   $sql="Select assemblycd,number_of_member,partyindcrc,subdivisioncd from dcrc_party where subdivisioncd='1801'";
   	$rs=execSelect($sql);
	while($asm_status1 = getRows($rs)) {
	$data_list1[$i]['ad']=$asm_status1['assemblycd'];
	$data_list1[$i]['nm']=$asm_status1['number_of_member'];
	$data_list1[$i]['np']=$asm_status1['partyindcrc'];
	$data_list1[$i]['sd']=$asm_status1['subdivisioncd'];
	$i++;
	}
	return $data_list1;
}*/
?>