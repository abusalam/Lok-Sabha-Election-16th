<?php

function fatch_Personaldistrict_wiseSubdiv($frmdist,$subdivision,$officename,$posting_status,$todist,$numberofemployee,$tosubdivision)
{
	 include_once('inc/distwise_con.php');
$rs_num;$num_rows;	
if(!$link) { die('Could not connect database: ' . mysql_error()); }

$psql="Select personnel.personcd 
	From $db.personnel	
	 Left Join $db.termination On $db.personnel.personcd = $db.termination.personal_id  		 
           WHERE  ($db.personnel.f_cd IS NULL or $db.personnel.f_cd='0') and $db.termination.personal_id is null ";
	if($subdivision!='' && $subdivision!='0')
		  $psql.=" and $db.personnel.subdivisioncd= '$subdivision'";
	 if($officename!='' && $officename!='0')
		  $psql.=" and $db.personnel.officecd='$officename'";
	 if($posting_status!='' && $posting_status!='0')
		  $psql.=" and $db.personnel.poststat ='$posting_status'";
	      $psql.=" order by rand()";
	 if($numberofemployee!='' && $numberofemployee!='0')
	      $psql.=" LIMIT $numberofemployee";

	$rs_num=mysql_query($psql);
$num_rows=mysql_num_rows($rs_num);

$sql="Update $db.personnel
      set $db.personnel.f_cd=2 
       WHERE  $db.personnel.personcd in 
	   (Select * from 
		 (Select $db.personnel.personcd from $db.personnel 
		  Left Join $db.termination On $db.personnel.personcd = $db.termination.personal_id  		 
           WHERE  ($db.personnel.f_cd IS NULL or $db.personnel.f_cd='0') and $db.termination.personal_id is null";
	 if($subdivision!='' && $subdivision!='0')
		  $sql.=" and $db.personnel.subdivisioncd= '$subdivision'";
	 if($officename!='' && $officename!='0')
		  $sql.=" and $db.personnel.officecd='$officename'";
	 if($posting_status!='' && $posting_status!='0')
		  $sql.=" and $db.personnel.poststat ='$posting_status'";
	      $sql.=" order by rand()";
	 if($numberofemployee!='' && $numberofemployee!='0')
	      $sql.=" LIMIT $numberofemployee";
$sql.=" ) dt )";

mysql_query($sql);

		
$sql1="insert into $db1.personnela (personcd,officecd,officer_name,off_desg,present_addr1,present_addr2,";
$sql1.="perm_addr1,perm_addr2,dateofbirth,gender,scale,basic_pay,grade_pay,workingstatus,email,resi_no, mob_no,qualificationcd,languagecd,epic,acno,slno,partno,poststat,assembly_temp,assembly_off,assembly_perm,districtcd,subdivisioncd,bank_acc_no,bank_cd, branchcd, remarks, pgroup, upload_file,usercode)";

$sql1.=" Select personnel.personcd, personnel.officecd, personnel.officer_name, personnel.off_desg, personnel.present_addr1,
	  personnel.present_addr2, personnel.perm_addr1, personnel.perm_addr2, Date_Format(personnel.dateofbirth, '%Y-%m-%d') As dateofbirth,
	  personnel.gender, personnel.scale, personnel.basic_pay, personnel.grade_pay, personnel.workingstatus, personnel.email,
	  personnel.resi_no, personnel.mob_no, personnel.qualificationcd, personnel.languagecd, personnel.epic, personnel.acno,
	  personnel.slno, personnel.partno, personnel.poststat, personnel.assembly_temp, personnel.assembly_off, personnel.assembly_perm,
	  personnel.districtcd, personnel.subdivisioncd, personnel.bank_acc_no, personnel.bank_cd, personnel.branchcd,
	  personnel.remarks, personnel.pgroup, personnel.upload_file, personnel.usercode
	From $db.personnel	
	WHERE $db.personnel.f_cd=2";
	
mysql_query($sql1);

$upsql="Update $db1.personnela 
        SET $db1.personnela.forsubdivision='$tosubdivision'
		WHERE $db1.personnela.personcd in 
		      (Select * from 
			      (Select $db.personnel.personcd from $db.personnel Where $db.personnel.f_cd=2) dt)";

mysql_query($upsql);

$banksql="insert into $db1.bank(bank_cd,bank_name,distcd,usercode)";
$banksql.="Select bank.bank_cd,bank.bank_name,bank.distcd,bank.usercode From $db.personnel
    INNER JOIN $db.bank on $db.bank.bank_cd=$db.personnel.bank_cd	
	WHERE $db.personnel.f_cd=2 AND $db.personnel.bank_cd NOT IN (Select bank_cd from $db1.bank)
	group by $db.personnel.bank_cd";
	

mysql_query($banksql);

$branchsql="insert into $db1.branch(branchcd,bank_cd,branch_name,address,ifsc_code,usercode)";
$branchsql.="Select branch.branchcd,branch.bank_cd,branch.branch_name,branch.address,branch.ifsc_code,branch.usercode From $db.personnel
    INNER JOIN $db.branch on $db.branch.bank_cd=$db.personnel.bank_cd
	WHERE $db.personnel.f_cd=2 
	AND $db.personnel.branchcd=$db.branch.branchcd
	AND ($db.personnel.bank_cd,$db.personnel.branchcd) NOT IN (Select bank_cd,branchcd from $db1.branch)
	group by $db.personnel.bank_cd,$db.personnel.branchcd";

mysql_query($branchsql);



$sql2="Update $db.personnel
      set $db.personnel.f_cd=1 
       WHERE  $db.personnel.f_cd=2 ";
mysql_query($sql2);
return $num_rows;

}
?>