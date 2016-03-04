<?php
date_default_timezone_set('Asia/Calcutta');
include_once('inc/db_trans.inc.php');
$sub_div=isset($_GET['subdiv_cd'])?$_GET['subdiv_cd']:"";
$dist=isset($_GET['dist'])?$_GET['dist']:"";

//$sql1="Delete F from first_rand_table F
	//Inner Join personnela On personnela.personcd = F.personcd 
	//where personnela.selected = 1 and (personnela.ttrgschcopy is Null or personnela.ttrgschcopy='0') and personnela.forsubdivision='$sub_div'";
	$sql1="delete from first_rand_table where forsubdivision='$sub_div'";
	$i=execDelete($sql1);

$sql="insert into first_rand_table (officer_name,person_desig,personcd,office,address,block_muni,block_muni_name,postoffice,subdivision,policestation, district,pin,officecd,poststatus,mob_no,training_desc,venuename,venueaddress,training_dt,training_time,pc_code,forsubdivision,epic,acno,partno,slno,bank,branch,bank_accno,ifsc,token)";
	
	$sql.="Select Distinct personnela.officer_name,
	  personnela.off_desg As person_desig,
	  personnela.personcd,
	  office.office,
	  concat(office.address1,',',office.address2),
	  office.blockormuni_cd,
	  block_muni.blockmuni,
	  office.postoffice,
	  subdivision.subdivision,
	  policestation.policestation,
	  district.district,
	  office.pin,
	  office.officecd,
	  poststat.poststatus,
	  personnela.mob_no,
	  
	  training_type.training_desc,
	  training_venue.venuename,
	  concat(training_venue.venueaddress1,',',training_venue.venueaddress2),
	  Date_Format(training_schedule.training_dt, '%d/%m/%Y') As training_dt,
	  training_schedule.training_time,
	  
	  personnela.forpc,
	  personnela.forsubdivision,
	  
	  personnela.epic,
	  personnela.acno,
	  personnela.partno,
	  personnela.slno,
	   
	  bank.bank_name,
	  branch.branch_name,
	  personnela.bank_acc_no,
	  branch.ifsc_code,
	 
	  REPLACE(concat(SUBSTRING(subdivision1.subdivisioncd,1,4),'/',poststat.post_stat,'/',training_pp.token),'','') 
 as r_token
	  
	From personnela
	  Inner Join office On office.officecd = personnela.officecd
	  Inner Join block_muni On office.blockormuni_cd = block_muni.blockminicd
	  Inner Join policestation
		On office.policestn_cd = policestation.policestationcd
	  Inner Join district On office.districtcd = district.districtcd
	  Inner Join training_pp On personnela.personcd = training_pp.per_code
	  Inner Join poststat On personnela.poststat = poststat.post_stat
	  Inner Join subdivision On office.subdivisioncd = subdivision.subdivisioncd
	  
	  Left Join bank On personnela.bank_cd = bank.bank_cd
	  Left Join branch On personnela.branchcd = branch.branchcd And
		personnela.bank_cd = branch.bank_cd
	  Inner Join training_type On training_type.training_code =
		training_pp.training_type
	  Left Join training_schedule On training_schedule.schedule_code =
		training_pp.training_sch
	  Left Join training_venue On training_venue.venue_cd =
		training_schedule.training_venue
	  Inner Join subdivision subdivision1 On training_pp.for_subdivision =
		subdivision1.subdivisioncd
	Where personnela.forsubdivision = '$sub_div' and personnela.selected = 1";
//	if($office!='0')
//	$sql.=" and office.officecd='$office'";
	$sql.=" order by office.subdivisioncd,office.blockormuni_cd,office.officecd, personnela.personcd,
	  poststat.poststatus, personnela.off_desg";
	//print $sql; exit;
	execSelect($sql);
	
	 $cntsql="Select count(*) as cnt from first_rand_table 
		where first_rand_table.forsubdivision='$sub_div'";
    $countrs=execSelect($cntsql);
	$crow=getRows($countrs);
	$cd_cnt=$crow['cnt'];
	
	connection_close();
	if($cd_cnt>0)
	{
		echo "<div class='alert-success'>$cd_cnt Record(s) saved successfully</div>";
	}
	else
	{
		echo "<div class='alert-error'>Selected persons are not available</div>";
	}
?>