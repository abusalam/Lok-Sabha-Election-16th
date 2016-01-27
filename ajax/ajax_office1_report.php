<?php
session_start();
extract($_GET);
include_once('../inc/db_trans.inc.php');
include_once('../function/office_report_fun.php');

$search=isset($_GET["search"])?$_GET["search"]:"";

$offccd=isset($_REQUEST["officename"])?$_REQUEST["officename"]:"";
if($_SESSION['subdiv_cd']!="")
{
   $Subdivision=$_SESSION['subdiv_cd'];
}
else
    $Subdivision=isset($_REQUEST["Subdivision"])?$_REQUEST["Subdivision"]:"";
$Statusofoffice=isset($_REQUEST["Statusofoffice"])?$_REQUEST["Statusofoffice"]:"";

$rsOffice=fatch_offcDtl($offccd,$Subdivision,$Statusofoffice);
$num_rows = rowCount($rsOffice);
if($num_rows<1)
{
	echo "No record found";
	//echo $officeid.",".$officename.",".$frmdt.",".$todt.",".$usercode;
}
else
{
	$offc_cd=encode($offccd);
	$sub_cd=encode($Subdivision);
	$soffice_cd=encode($Statusofoffice);
	echo "<a href='fpdf/office_pdf.php?offccd=$offc_cd&Subdivision=$sub_cd&Statusofoffice=$soffice_cd' target='_blank' class='button'>PDF</a>&nbsp; ";
	
	echo "<a href='ajax/office_excel.php?offccd=$offc_cd&Subdivision=$sub_cd&Statusofoffice=$soffice_cd' class='button'>EXCEL</a>";
	
	echo "<div class='scroller'>";
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
	echo "<tr height='30px'><th>Sl.</th><th>Office ID</th>
            <th>Office Name</th>
			<th>Office Status</th>
            <th>Male</th>
            <th>Female</th>
            <th>Total</th>
			</tr>\n";
	for($i=1;$i<=$num_rows;$i++)
	{
	  $rowOffice=getRows($rsOffice);
	  $ofc_cd='"'.encode($rowOffice[0]).'"';
	  echo "<tr><td align='right' width='5%'>$i.</td><td align='center' width='9%'>$rowOffice[0]</td><td width='40%' align='left'>$rowOffice[1]</td>";
	  echo "<td width='24%' align='left'>$rowOffice[2]</td>";
	  echo "<td width='7%' align='center'>$rowOffice[3]</td>";
	  echo "<td width='7%' align='center'>$rowOffice[4]</td>";
	  echo "<td align='center' width='8%'>$rowOffice[5] ";
	 // if($rowOffice['usercode']==$usercode)
	 // 	echo " onclick='javascript:edit_office($ofc_cd);' title='Click to edit' ";
	 // else
	 // 	echo " onclick='alert(\"You do not have sufficient privilege to do the operation\");'";
	  echo "</td>";
	  echo "</tr>\n";
	}
	echo "</table>\n";
	echo "</div>";
	//paging();
}
?>