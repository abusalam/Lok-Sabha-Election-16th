<?php
include_once('string_fun.php');
function fatch_PollingstationList($dcrc,$assemb,$noofmember,$subdiv_cd)
{
	$sql="Select subdivision.subdivision, 
			  dcrcmaster.dc_venue,
			  assembly.assemblycd,
	           assembly.assemblyname,			    
			     pollingstation.member,
				  pollingstation.forsubdivision as sd_cd,
				   pollingstation.forassembly as asm_cd,
				    pollingstation.dcrccd
	             
			From pollingstation
		  Inner Join subdivision On subdivision.subdivisioncd = pollingstation.forsubdivision 
		  Inner Join assembly On assembly.assemblycd = pollingstation.forassembly 
		  Inner Join dcrcmaster On dcrcmaster.dcrcgrp = pollingstation.dcrccd 
		  where 1=1 ";
	if($dcrc<>'' && $dcrc<>'0')
		$sql.=" and pollingstation.dcrccd = '$dcrc'";
	if($assemb<>'' && $assemb<>'0')
		$sql.=" and pollingstation.forassembly = '$assemb'";
	if($noofmember<>'' && $noofmember<>'0')
		$sql.=" and pollingstation.member = '$noofmember'";
	if($subdiv_cd!='0')
		$sql.=" and pollingstation.forsubdivision = '$subdiv_cd'"; 
	 $sql.=" group by pollingstation.forassembly,pollingstation.forsubdivision,pollingstation.dcrccd,pollingstation.member";	
	$sql.=" order by pollingstation.forassembly";
	
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_PollingstationList1($dcrc,$assemb,$noofmember,$subdiv_cd,$p_num,$items)
{
	$sql="Select 
	          subdivision.subdivision, 
			  dcrcmaster.dc_venue,
			  assembly.assemblycd,
	           assembly.assemblyname,			    
			     pollingstation.member,
				  pollingstation.forsubdivision as sd_cd,
				   pollingstation.forassembly as asm_cd,
				    pollingstation.dcrccd
					
			From pollingstation
		  Inner Join subdivision On subdivision.subdivisioncd = pollingstation.forsubdivision 
		  Inner Join assembly On assembly.assemblycd = pollingstation.forassembly 
		  Inner Join dcrcmaster On dcrcmaster.dcrcgrp = pollingstation.dcrccd 
		  where 1=1 ";
	if($dcrc<>'' && $dcrc<>'0')
		$sql.=" and pollingstation.dcrccd = '$dcrc'";
	if($assemb<>'' && $assemb<>'0')
		$sql.=" and pollingstation.forassembly = '$assemb'";
	if($noofmember<>'' && $noofmember<>'0')
		$sql.=" and pollingstation.member = '$noofmember'";
	if($subdiv_cd!='0')
		$sql.=" and pollingstation.forsubdivision = '$subdiv_cd'"; 
	 $sql.=" group by pollingstation.forassembly,pollingstation.forsubdivision,pollingstation.dcrccd,pollingstation.member";	
	$sql.=" order by pollingstation.forassembly";
	$sql.=" ASC LIMIT $p_num , $items";
	//echo $sql;
	//exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_sd_asm_member($subdiv_cd,$assemb,$dcrc,$member)
{
	$sql="Select			    
			     pollingstation.psno,
				  pollingstation.psfix,
				   pollingstation.psname,
				   pollingstation.forassembly,
				   pollingstation.code
			From pollingstation	
		  where 1=1 ";
	if($assemb<>'')
		$sql.=" and pollingstation.forassembly = '$assemb'";
	if($member<>'')
		$sql.=" and pollingstation.member = '$member'";
	if($dcrc<>'')
		$sql.=" and pollingstation.dcrccd = '$dcrc'";
	if($subdiv_cd!='0')
		$sql.=" and pollingstation.forsubdivision = '$subdiv_cd'"; 
	$sql.=" order by pollingstation.psno,pollingstation.psfix";
	//echo $sql;
	//exit;
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
?>