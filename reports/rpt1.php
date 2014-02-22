<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Personnel List</title>
<style>body{font-size:12px; font-family:"Courier New", Courier, monospace;}
@media print
{
h3 {page-break-after:always}
}
.sp1{ margin: 10px;}
.heading {font-family:Tahoma, Geneva, sans-serif; font-size: 15px; font-weight:bold;}
</style>
</head>
<?php
$officename=$_REQUEST['officename'];
$user=$_REQUEST['user'];
$frmdate=$_REQUEST['frmdate'];
$todate=$_REQUEST['todate'];
?>

<body>
<div align="center" class="heading">Checklist (Polling Personnel)</div>
<?php
//require_once('../inc/dbcon.inc.php');
require_once('../inc/db_trans.inc.php');
$sql="Select personnel.officer_name As officer_name,
	  personnel.off_desg As designation,
	  personnel.personcd As personcd,
	  Date_Format(personnel.dateofbirth, _latin1'%d/%m/%Y') As dateofbirth,
	  personnel.gender As gender,
	  personnel.scale As scale,
	  personnel.basic_pay As basic_pay,
	  personnel.grade_pay As grade_pay,
	  qualification.qualification As qualification,
	  personnel.email As email,
	  personnel.resi_no As resi_no,
	  personnel.mob_no As mob_no,
	  language.language As language,
	  personnel.present_addr1 As present_addr1,
	  personnel.present_addr2 As present_addr2,
	  personnel.perm_addr1 As perm_addr1,
	  personnel.perm_addr2 As perm_addr2,
	  personnel.acno As acno,
	  personnel.epic As epic,                         
	  personnel.partno As partno,
	  personnel.slno As slno,
	  poststat.poststatus As poststatus,
	  personnel.bank_acc_no As bank_acc_no,
	  personnel.assembly_temp As assembly_temp,
	  personnel.assembly_perm As assembly_perm,
	  personnel.assembly_off As assembly_off,
	  personnel.bank_cd As bank_cd,
	  bank.bank_name As bank_name,
	  branch.ifsc_code As ifsc_code,
	  branch.branch_name As branch_name,
	  branch.address As address,
	  personnel.remarks As remarks,
	  personnel.officecd As officecd,
	  office.office As office,
	  office.address1 As address1,
	  office.address2 As address2,
	  office.postoffice As postoffice,
	  district.district As district,
	  office.pin As pin,
	  personnel.usercode As usercode,
	  personnel.posted_date As posted_date
	From ((((((personnel
	  Left Join bank On bank.bank_cd = personnel.bank_cd)
	  Join qualification On qualification.qualificationcd =
		personnel.qualificationcd)
	  Join language On language.languagecd = personnel.languagecd)
	  Join poststat On poststat.post_stat = personnel.poststat)
	  Left Join branch On branch.branchcd = personnel.branchcd)
	  Join office On personnel.officecd = office.officecd)
	  Join district On office.districtcd = district.districtcd";
$sql.=" where personnel.personcd>0 ";
if($frmdate!='' && $frmdate!=null)
	$sql.="and personnel.posted_date>='$frmdate' ";
if($todate!='' && $todate!=null)
	$sql.="and personnel.posted_date<='$todate' ";
//if($user!='' && $user!=null)
//	$sql.="and personnel.usercode='$user' ";
if($officename!='' && $officename!=null)
	$sql.="and personnel.officecd='$officename' ";	
$sql.="order by personnel.officer_name ASC";
$rs=execSelect($sql);
$num_rows=rowCount($rs);

if($num_rows>0)
{
	echo "<hr width='100%' />\n";
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=getRows($rs);
		//<span>&nbsp;&nbsp;&nbsp;</span>
		echo "<div width='100%'>\n";
		echo $i."<div style='padding-left:10px;'><span align='left'><b>Name, Designation (code) :</b></span><span align='left' ";
		echo "style='margin-right: ".(350-strlen($row[0].', '.$row[1].', ('.$row[2].')')*5)."pt;'";
		echo "> $row[0], $row[1], ($row[2])</span><span class='sp1'>&nbsp;</span><span align='left'><b>Date of Birth :</b></span><span align='left'> $row[3]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Gender :</b></span><span align='left'> $row[4]</span></div>\n";
		echo "<div  style='padding-left:10px;'><span align='left'><b>Pay Scale :</b></span><span align='left' ";
		echo "style='margin-right: ".(80-strlen($row[5])*5)."pt;'";
		echo ">&nbsp;$row[5]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Basic Pay :</b></span><span align='left' ";
		echo "style='margin-right: ".(80-strlen($row[6])*5)."pt;'";
		echo ">&nbsp;$row[6]</span><span class='sp1'>&nbsp;</span><span align='left' width='10%'><b>Grade Pay :</b></span><span align='left' ";
		echo "style='margin-right: ".(80-strlen($row[7])*5)."pt;'";
		echo ">&nbsp;$row[7]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Qualification :</b></span><span align='left'> $row[8]</span></div>\n";
		echo "<div style='padding-left:10px;'><span align='left'><b>Email ID :</b></span><span align='left' ";
		echo "style='margin-right: ".(150-strlen($row[9])*5)."pt;'";
		echo ">&nbsp;$row[9]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Phone :</b></span><span align='left' ";
		echo "style='margin-right: ".(80-strlen($row[10])*5)."pt;'";
		echo ">&nbsp;$row[10]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Mobile :</b></span><span align='left' ";
		echo "style='margin-right: ".(80-strlen($row[11])*5)."pt;'";
		echo "> $row[11]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Language known other than Bengali :</b></span><span align='left'> $row[12]</span></div>\n";
		echo "<div style='padding-left:10px;'><span align='left'><b>Present Address :</b></span><span align='left' ";
		echo "style='margin-right: ".(250-strlen($row[13].', '.$row[14])*5)."pt;'";
		echo "> $row[13], $row[14]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Permanent Address :</b></span><span align='left'> $row[15], $row[16]</span></div>\n";
		echo "<div style='padding-left:10px;'><span align='left'><b>Assembly (Voter) :</b></span><span align='left' ";
		echo "style='margin-right: ".(20-strlen($row[17])*5)."pt;'";
		echo "> $row[17]</span><span class='sp1'>&nbsp;</span><span align='left'><b>EPIC :</b></span><span align='left' ";
		echo "style='margin-right: ".(80-strlen($row[18])*5)."pt;'";
		echo "> $row[18]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Part No :</b></span><span align='left' ";
		echo "style='margin-right: ".(20-strlen($row[19])*5)."pt;'";
		echo "> $row[19]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Sl No :</b></span><span align='left' ";
		echo "style='margin-right: ".(20-strlen($row[20])*5)."pt;'";
		echo "> $row[20]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Post Status :</b></span><span align='left' ";
		echo "style='margin-right: ".(90-strlen($row[21])*5)."pt;'";
		echo "> $row[21]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Bank A/c :</b></span><span align='left'> $row[22]</span></div>\n";
		echo "<div style='padding-left:10px;'><span align='left'><b>Assembly (Present Address) :</b></span><span align='left' ";
		echo "style='margin-right: ".(20-strlen($row[23])*5)."pt;'";
		echo "> $row[23]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Assembly (Permanent Address) :</b></span><span align='left' ";
		echo "style='margin-right: ".(20-strlen($row[24])*5)."pt;'";
		echo "> $row[24]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Assembly (Office) :</b></span><span align='left' ";
		echo "style='margin-right: ".(20-strlen($row[25])*5)."pt;'";
		echo "> $row[25]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Bank :</b></span><span align='left'> $row[26]&nbsp;&nbsp;$row[27]</span></div>\n";
		echo "<div style='padding-left:10px;'><span align='left'><b>Branch IFS Code :</b></span><span align='left' ";
		echo "style='margin-right: ".(60-strlen($row[28])*5)."pt;'";
		echo "> $row[28]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Branch :</b></span><span align='left' ";
		echo "style='margin-right: ".(180-strlen($row[29])*5)."pt;'";
		echo "> $row[29]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Address :</b></span><span align='left'> $row[30]</span></div>\n";
		echo "<div style='padding-left:10px;'><span align='left'><b>Remarks :</b></span><span align='left'> $row[31]</span></div>\n";
		echo "<div><span><hr width='100%' /></span></div>\n";
		
		echo "</div>\n";	
		if($i%5==0)
		{
			echo "<h3></h3>\n";
			echo "<div><span align='center'><hr width='100%' /></span></div>\n";
		}
	}
}
else
	echo "\n<br/><div align='center'>No Result Available</div>";
?>
</body>
</html>