<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
extract($_POST);
include_once('../inc/db_trans.inc.php');
include_once('../function/personnel_report_fun.php');

$filename = "pp_wise_bank.xls"; // File Name
// Download file
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");
$dist_cd=$_SESSION['dist_cd'];
$subdiv=(isset($_REQUEST['Subdivision'])?$_REQUEST['Subdivision']:'0');
//echo $subdiv;

$rs_f_excel=pp_wise_bank_excel($subdiv,$dist_cd);
$num_rows = rowCount($rs_f_excel);
if($num_rows<1)
{
	echo "No record found";
}
else
{
	 $body = "Bank Name"."\t"."Branch Name"."\t"."IFSC Code"."\t"."Bank Acc No"."\t"."Officer Name"."\t"."Mobile No"."\t \n ";
	 echo $body;
	 for($i=1;$i<=$num_rows;$i++)
	{
		$row=getRows($rs_f_excel);
	         //  echo $i."\t";
			   echo $row['bank_name']."\t";
			   echo $row['branch_name']."\t";
			   echo $row['ifsc_code']."\t";
			   echo $row['bank_acc_no']."\t";
			   echo $row['officer_name']."\t";
			   echo $row['mob_no']."\t \n";
	}
	 
}
?>