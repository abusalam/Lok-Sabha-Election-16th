<?php
session_start();

include_once('../inc/db_trans.inc.php');
include_once('../function/office_report_fun.php');

$search=isset($_GET["search"])?$_GET["search"]:"";
$offccd=isset($_REQUEST["offccd"])?decode($_REQUEST["offccd"]):"";
$Subdivision=isset($_REQUEST["Subdivision"])?decode($_REQUEST["Subdivision"]):"";
$Statusofoffice=isset($_REQUEST["Statusofoffice"])?decode($_REQUEST["Statusofoffice"]):"";

$filename = "officereport.xls"; // File Name
// Download file
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$rs_fatch_beneficiary=fatch_offcDtl($offccd,$Subdivision,$Statusofoffice);
$num_rows = rowCount($rs_fatch_beneficiary);
if($num_rows<1)
{
	echo "No record found";
}
else
{
	 $body = "Sl No"."\t"."Office ID"."\t"."Office Name"."\t"."Office Status"."\t"."Male."."\t"."Female"."\t"."Total"."\t \n ";
	 echo $body;
	for($i=1;$i<=$num_rows;$i++)
	{
	   $row=getRows($rs_fatch_beneficiary);
	  // $addate= date("d/m/Y",strtotime($rowapps['date']));
	     /* $name=$row['1']." ".$row['2']." ".$row['3'];
			$rname=$row['4']." ".$row['5']." ".$row['6'];
			if($row['14']!=29)
			{
			  $state=$row['15'];
			  $acname="";
			}
			else
			{
			   $acname=$row['12'];
			   $state=$row['13'];	
			}*/
	   
	   echo $i."\t";
	   echo $row['0']."\t";
	   echo $row['1']."\t";
	   echo $row['2']."\t";
	   echo $row['3']."\t";
	   echo $row['4']."\t";
	   echo $row['5']."\t \n";
	}
}
//ExportToExcel("export.xls");					
unset($rs_fatch_beneficiary);
?>