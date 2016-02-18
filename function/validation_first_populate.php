<?php
include_once("string_fun.php");
//personnel record check
function personnel_record_check()
{
	$sql="Select
	  count(Distinct personnela.personcd) as cnt	  
	From personnela
	  Where personnela.selected = 1";
	 $rs=execSelect($sql);
	 $crow=getRows($rs);
	 $cd_cnt=$crow['cnt'];	
	 connection_close();
	 return $cd_cnt;
}
//office record check
function office_record_check()
{
	$sql="Select
	  count(Distinct personnela.personcd) as cnt	  
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Where personnela.selected = 1";
	 $rs=execSelect($sql);
	 $crow=getRows($rs);
	 $cd_cnt=$crow['cnt'];	
	 connection_close();
	 return $cd_cnt;
}
//block/muni record check
function block_muni_record_check()
{
	$sql="Select
	  count(Distinct personnela.personcd) as cnt	  
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Inner Join block_muni On office.blockormuni_cd = block_muni.blockminicd
	  Where personnela.selected = 1";
	 $rs=execSelect($sql);
	 $crow=getRows($rs);
	 $cd_cnt=$crow['cnt'];	
	 connection_close();
	 return $cd_cnt;
}
//police station record check
function police_station_record_check()
{
	$sql="Select
	  count(Distinct personnela.personcd) as cnt	  
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Where personnela.selected = 1";
	 $rs=execSelect($sql);
	 $crow=getRows($rs);
	 $cd_cnt=$crow['cnt'];	
	 connection_close();
	 return $cd_cnt;
}
//subdiv record check
function subdiv_record_check()
{
	$sql="Select
	  count(Distinct personnela.personcd) as cnt	  
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  Where personnela.selected = 1";
	 $rs=execSelect($sql);
	 $crow=getRows($rs);
	 $cd_cnt=$crow['cnt'];	
	 connection_close();
	 return $cd_cnt;
}
//post status record check
function poststatus_record_check()
{
	$sql="Select
	  count(Distinct personnela.personcd) as cnt	  
	From personnela
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	  Where personnela.selected = 1";
	 $rs=execSelect($sql);
	 $crow=getRows($rs);
	 $cd_cnt=$crow['cnt'];	
	 connection_close();
	 return $cd_cnt;
}
//bank record check
function bank_record_check()
{
	$sql="Select
	  count(Distinct personnela.personcd) as cnt	  
	From personnela
	  Left Join bank On personnela.bank_cd = bank.bank_cd
	  Where personnela.selected = 1";
	 $rs=execSelect($sql);
	 $crow=getRows($rs);
	 $cd_cnt=$crow['cnt'];	
	 connection_close();
	 return $cd_cnt;
}
//branch record check
function branch_record_check()
{
	$sql="Select
	  count(Distinct personnela.personcd) as cnt	  
	From personnela
	  Left Join branch On personnela.branchcd = branch.branchcd And
		personnela.bank_cd = branch.bank_cd
	  Where personnela.selected = 1";
	 $rs=execSelect($sql);
	 $crow=getRows($rs);
	 $cd_cnt=$crow['cnt'];	
	 connection_close();
	 return $cd_cnt;
}
//training pp record check
function training_pp_record_check()
{
	$sql="Select
	  count(Distinct personnela.personcd) as cnt	  
	From personnela
	 Inner Join training_pp On personnela.personcd = training_pp.per_code
	  Where personnela.selected = 1";
	 $rs=execSelect($sql);
	 $crow=getRows($rs);
	 $cd_cnt=$crow['cnt'];	
	 connection_close();
	 return $cd_cnt;
}
//training type record check
/*function training_type_record_check()
{
	$sql="Select
	  count(Distinct personnela.personcd) as cnt	  
	From personnela
	 Inner Join training_pp On personnela.personcd = training_pp.per_code
	 Inner Join training_type On training_type.training_code =
		training_pp.training_type
	  Where personnela.selected = 1";
	 $rs=execSelect($sql);
	 $crow=getRows($rs);
	 $cd_cnt=$crow['cnt'];	
	 connection_close();
	 return $cd_cnt;
}*/
?>