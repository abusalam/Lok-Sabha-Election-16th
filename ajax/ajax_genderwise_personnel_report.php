<?php
session_start();
extract($_GET);
include_once('../inc/db_trans.inc.php');
include_once('../function/personnel_report_fun.php');

$search=isset($_GET["search"])?$_GET["search"]:"";
$offccd=isset($_REQUEST["officename"])?$_REQUEST["officename"]:"";
$Subdivision=isset($_REQUEST["Subdivision"])?$_REQUEST["Subdivision"]:"";
$gender=isset($_REQUEST["gender"])?$_REQUEST["gender"]:"";
$Statusofoffice=isset($_REQUEST["Statusofoffice"])?$_REQUEST["Statusofoffice"]:"";


$rsOffice=fatch_personnelDtl($offccd,$Subdivision,$gender,$Statusofoffice);
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
	$gend=encode($gender);
	echo "<a href='fpdf/office_pdf.php?offccd=$offc_cd&Subdivision=$sub_cd&Statusofoffice=$soffice_cd' target='_blank' class='button'>PDF</a>&nbsp; ";
	
	echo "<a href='ajax/office_excel.php?offccd=$offc_cd&Subdivision=$sub_cd&Statusofoffice=$soffice_cd' class='button'>EXCEL</a>";
	
	echo "<div class='scroller'>";
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
	echo "<tr height='30px'><th>Sl.</th><th>Office ID</th><th>Office Status</th>
            <th>";
	if($gender=='M')
	   echo "Male";
	else if($gender=='F')
	   echo "Female";
	else
	   echo "Total";
    echo "</th>
			</tr>\n";
	for($i=1;$i<=$num_rows;$i++)
	{
	  $rowOffice=getRows($rsOffice);
	  $ofc_cd='"'.encode($rowOffice[0]).'"';
	  echo "<tr><td align='right' width='10%'>$i.</td><td align='center' width='20%'>$rowOffice[0]</td>";
	  echo "<td width='50%' align='center'>";
	  echo "$rowOffice[1]";
	  echo "</td>";
	  echo "<td width='20%' align='center'>";
	  echo "$rowOffice[2]";
	  echo "</td>";
	  echo "</tr>\n";
	}
	echo "</table>\n";
	echo "</div>";
	//paging();
}
?>