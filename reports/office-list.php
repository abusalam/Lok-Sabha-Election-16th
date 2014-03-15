<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Office List</title>
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
//require("../function/paging.php");
$user=$_REQUEST['user'];
echo "Date";
$frmdate=$_REQUEST['frmdate'];
if($frmdate!="")
	echo " From ".$frmdate;
$todate=$_REQUEST['todate'];
if($todate!="")
	echo " To ".$todate;
if($frmdate=="" && $todate=="")
	echo " All";
?>

<body>
<div align="center" class="heading">Checklist (Office List)</div>
<?php
date_default_timezone_set('Asia/Calcutta');
//require_once('../inc/dbcon.inc.php');
require_once('../inc/db_trans.inc.php');
$sql="Select office.officecd As officecd,
  office.office As office,
  office.address1 As address1,
  office.address2 As address2,
  office.postoffice As postoffice,
  district.district As district,
  policestation.policestation As policestation,
  office.pin As pin,
  govtcategory.govt_description As govt_description,
  institute.institute As institute,
  office.phone As phone,
  office.mobile As mobile,
  office.fax As fax,
  office.email As email,
  office.tot_staff As tot_staff,
  block_muni.blockmuni As blockmuni,
  office.blockormuni_cd As blockormuni_cd,
  office.usercode As usercode,
  office.posted_date As posted_date
From ((((block_muni
  Join office On block_muni.blockminicd = Convert(office.blockormuni_cd Using
    utf8))
  Join district On district.districtcd = office.districtcd)
  Join policestation On Convert(office.policestn_cd Using utf8) =
    policestation.policestationcd)
  Join govtcategory On govtcategory.govt = office.govt)
  Join institute On office.institutecd = institute.institutecd ";
$sql.=" where office.officecd>0 ";
if($frmdate!='' && $frmdate!=null)
	$sql.="and office.posted_date>='$frmdate' ";
if($todate!='' && $todate!=null)
	$sql.="and office.posted_date<='$todate' ";
if($user!='' && $user!=null)
	$sql.="and office.usercode='$user' ";	
$sql.="order by office.office ASC";
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
		echo $i."<div style='padding-left:10px;'><span align='left'><b>Code :</b></span><span align='left' ";
		echo "style='margin-right: ".(80-strlen($row['officecd'])*5)."pt;'";
		echo "> <b>$row[0]</b></span><span class='sp1'>&nbsp;</span><span align='left'><b>Name and Address :</b></span><span align='left'> $row[1], $row[2], $row[3], PO-$row[4], Dist.-$row[5], PIN-$row[7]</span></div>\n";
		echo "<div  style='padding-left:10px;'><span align='left'><b>PS :</b></span><span align='left' ";
		echo "style='margin-right: ".(100-strlen($row[6])*5)."pt;'";
		echo ">&nbsp;$row[6]</span></div>\n";
		echo "<div style='padding-left:10px;'><span align='left'><b>Govt. Category :</b></span><span align='left' ";
		echo "style='margin-right: ".(150-strlen($row[8])*5)."pt;'";
		echo ">&nbsp;$row[8]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Institute :</b></span><span align='left' ";
		echo "style='margin-right: ".(150-strlen($row[9])*3)."px;'";
		echo ">&nbsp;$row[9]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Phone :</b></span><span align='left' ";
		echo "style='margin-right: ".(80-strlen($row[10])*5)."pt;'";
		echo "> $row[10]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Mobile :</b></span><span align='left'> $row[11]</span></div>\n";
		echo "<div style='padding-left:10px;'><span align='left'><b>Fax :</b></span><span align='left' ";
		echo "style='margin-right: ".(80-strlen($row[12])*5)."pt;'";
		echo "> $row[12]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Email :</b></span><span align='left' ";
		echo "style='margin-right: ".(120-strlen($row[13])*5)."pt;'";
		echo "> $row[13]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Total Staff Strength :</b></span><span align='left' ";
		echo "style='margin-right: ".(20-strlen($row[14])*5)."pt;'";
		echo "> $row[14]</span><span class='sp1'>&nbsp;</span><span align='left'><b>Block/Municipality :</b></span><span align='left' ";
		echo "style='margin-right: ".(90-strlen($row[15])*5)."pt;'";
		echo "> $row[15]</span><span class='sp1'>&nbsp;</span><span align='right' style='margin-right:20pt;'> $row[16]</span></div>\n";
		echo "<div><span><hr width='100%' /></span></div>\n";
		
		echo "</div>\n";	
		if($i%6==0)
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