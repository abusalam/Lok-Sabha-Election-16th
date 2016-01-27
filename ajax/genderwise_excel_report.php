<?php
session_start();
include_once('../inc/db_trans.inc.php');
include_once('../function/personnel_report_fun.php');

$search=isset($_GET["search"])?$_GET["search"]:"";
//$offccd=isset($_REQUEST["offccd"])?decode($_REQUEST["offccd"]):"";
if($_SESSION['subdiv_cd']!="")
{
   $Subdivision=$_SESSION['subdiv_cd'];
}
else
    $Subdivision=isset($_REQUEST["Subdivision"])?$_REQUEST["Subdivision"]:"";


//$Statusofoffice=isset($_REQUEST["Statusofoffice"])?decode($_REQUEST["Statusofoffice"]):"";

$filename = "genderreport.xls"; // File Name
// Download file
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

//$rs_fatch_beneficiary=fatch_personnelDtl($Subdivision);
//$num_rows = rowCount($rs_fatch_beneficiary);
/*if($num_rows<1)
{
	echo "No record found";
}
else
{*/
	$body1 ="District"."\t"."No of employees of State Govt."."\t".""."\t".""."\t"."No of employees of State Govt. Undertaking"."\t".""."\t".""."\t"."No of employees of Central Govt."."\t".""."\t".""."\t"."No of employees of Central Govt. Undertaking"."\t".""."\t".""."\t"."No of Teacher and Others"."\t".""."\t".""."\t"."Grand Total"."\t".""."\t".""."\t \n";
	 $body2 = ""."\t"."Male"."\t"."Female"."\t"."Total"."\t"."Male."."\t"."Female"."\t"."Total"."\t"."Male."."\t"."Female"."\t"."Total"."\t"."Male."."\t"."Female"."\t"."Total"."\t"."Male."."\t"."Female"."\t"."Total"."\t"."Male."."\t"."Female"."\t"."Total"."\t \n ";
	 echo $body1;
	 echo $body2;
	  
	  $sgm=fatch_personnelsgm($Subdivision,"M","02");
	  $sgf=fatch_personnelsgm($Subdivision,"F","02");
	  $total_sgmf=$sgm+$sgf;
	  
	  $sgum=fatch_personnelsgm($Subdivision,"M","04");
	  $sguf=fatch_personnelsgm($Subdivision,"F","04");
	  $total_sgumf=$sgum+$sguf;
	  
	  $cgm=fatch_personnelsgm($Subdivision,"M","01");
	  $cgf=fatch_personnelsgm($Subdivision,"F","01");
	  $total_cgmf=$cgm+$cgf;
	  
	  $cgum=fatch_personnelsgm($Subdivision,"M","03");
	  $cguf=fatch_personnelsgm($Subdivision,"F","03");
	  $total_cgumf=$cgum+$cguf;
	  
	  $ogm=fatch_personnelsgm($Subdivision,"M","Other");
	  $ogf=fatch_personnelsgm($Subdivision,"F","Other");
	  $total_ogmf=$ogm+$ogf;
	  
	  $grandmale=fatch_personnelsgm($Subdivision,"M","");
	  $grandfemale=fatch_personnelsgm($Subdivision,"F","");
	  $total_grandmf=$grandmale+$grandfemale;
	  
	   echo $_SESSION['dist_name']."\t";
	   echo $sgm."\t";
	   echo $sgf."\t";
	   echo $total_sgmf."\t";
	   echo $sgum."\t";
	   echo $sguf."\t";
	   echo $total_sgumf."\t";
	   echo $cgm."\t";
	   echo $cgf."\t";
	   echo $total_cgmf."\t";
	   echo $cgum."\t";
	   echo $cguf."\t";
	   echo $total_cgumf."\t";
	   echo $ogm."\t";
	   echo $ogf."\t";
	   echo $total_ogmf."\t";
	   echo $grandmale."\t";
	   echo $grandfemale."\t";
	   echo $total_grandmf."\t \n";
	//}
//}
//ExportToExcel("export.xls");					
//unset($rs_fatch_beneficiary);
?>