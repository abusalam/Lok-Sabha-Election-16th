<?php
session_start();
extract($_REQUEST);
include_once('../inc/db_trans.inc.php');
include_once('../function/personnel_report_fun.php');

//$search=isset($_GET["search"])?$_GET["search"]:"";
$offccd=isset($_REQUEST["officename"])?$_REQUEST["officename"]:"";
if($_SESSION['subdiv_cd']!="")
{
   $Subdivision=$_SESSION['subdiv_cd'];
}
else
    $Subdivision=isset($_REQUEST["Subdivision"])?$_REQUEST["Subdivision"]:"";
$Statusofoffice=isset($_REQUEST["Statusofoffice"])?$_REQUEST["Statusofoffice"]:"";
$posting_status=isset($_REQUEST["posting_status"])?$_REQUEST["posting_status"]:"";
$partno=isset($_REQUEST["partno"])?$_REQUEST["partno"]:"";
$sl_no=isset($_REQUEST["sl_no"])?$_REQUEST["sl_no"]:"";
$epic_no=isset($_REQUEST["epic_no"])?$_REQUEST["epic_no"]:"";
$mobile=isset($_REQUEST["mobile"])?$_REQUEST["mobile"]:"";
$emailid=isset($_REQUEST["emailid"])?$_REQUEST["emailid"]:"";
$bank=isset($_REQUEST["bank"])?$_REQUEST["bank"]:"";
$gender=isset($_REQUEST["gender"])?$_REQUEST["gender"]:"";
$epic=isset($_REQUEST["epic"])?$_REQUEST["epic"]:"";


$rsOffice=fatch_personnelDtl1($offccd,$Subdivision,$gender,$Statusofoffice,$posting_status,$partno,$sl_no,$epic_no,$mobile,$emailid,$bank,$epic);
$num_rows = rowCount($rsOffice);
if($num_rows<1)
{
	echo "No record found";
	//echo $officeid.",".$officename.",".$frmdt.",".$todt.",".$usercode;
}
else
{
	/*$offc_cd=encode($offccd);
	$sub_cd=encode($Subdivision);
	$gend=encode($gender);
	echo "<a href='fpdf/office_pdf.php?offccd=$offc_cd&Subdivision=$sub_cd&Statusofoffice=$soffice_cd' target='_blank' class='button'>PDF</a>&nbsp; ";
	
	echo "<a href='ajax/office_excel.php?offccd=$offc_cd&Subdivision=$sub_cd&Statusofoffice=$soffice_cd' class='button'>EXCEL</a>";*/
	
	echo "<div class='scroller'>";
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
	echo "<tr height='30px'><th>Sl.</th>
			<th>Total</th>
			</tr>\n";
	//for($i=1;$i<=$num_rows;$i++)
	//{
	//  $rowOffice=getRows($rsOffice);
	//  $ofc_cd='"'.encode($rowOffice[0]).'"';
	 /* echo "<tr><td align='right' width='10%'>$i.</td><td align='center' width='35%'>$rowOffice[0]</td>";
	  echo "<td width='35%' align='center'>";
	  echo "$rowOffice[1]";
	  echo "</td>";
	  echo "<td width='20%' align='center'>";
	  if($rowOffice['2']=='M')
        echo "Male";
	  else
	    echo "Female";
	  echo "</td>";
	  echo "</tr>\n";*/
	 // echo "<tr><td colspan='2'></td><td align='center'>Total</td><td align='center'>$num_rows</td></tr>\n";
//	}
	echo "<tr><td align='center'>1.</td><td align='center'>$num_rows</td></tr>\n";
	echo "</table>\n";
	echo "</div>";
	//paging();
}
?>