<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
extract($_POST);
include_once('../inc/db_trans.inc.php');
include_once('../function/appointment_fun.php');

$filename = "first_appt.xls"; // File Name
// Download file
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$subdiv=(isset($_REQUEST['subdiv'])?decode($_REQUEST['subdiv']):'0');
$from=(isset($_REQUEST['txtfrom'])?decode($_REQUEST['txtfrom']):'0');
	$to=(isset($_REQUEST['txtto'])?decode($_REQUEST['txtto']):'0');
	$hid_rec=(isset($_REQUEST['hid_rec'])?decode($_REQUEST['hid_rec']):'0');
//echo $subdiv;
if($from>$hid_rec || $to>$hid_rec)
	{
		echo "Please check record no";
		exit;
	}
	if($from>$to || $from<1 || $to<1)
	{
		echo "Please check record no";
		exit;
	}
	if((($to)-($from))>3000)
	{
		echo "Records should not be greater than 3000";
		exit;
	}
$rs_f_excel=first_appointment_letter_excel($subdiv,$from-1,$to-$from+1);
$num_rows = rowCount($rs_f_excel);
if($num_rows<1)
{
	echo "No record found";
}
else
{
	 $body = "Officer Name"."\t"."Designation"."\t"."Personcd"."\t"."Office"."\t"."Address"."\t"."Block/Muni Name"."\t"."Post Office"."\t"."Subdivision"."\t"."Police Station"."\t"."District"."\t"."Pin"."\t"."Officecd"."\t"."Post Status"."\t"."Mob No"."\t"."Training"."\t"."Training Venue"."\t"."Venue Address"."\t"."Training Date"."\t"."Training Time"."\t"."Epic"."\t"."Ac No"."\t"."Part No"."\t"."Sl No"."\t"."Bank"."\t"."Branch"."\t"."Bank Ac/c No"."\t"."Ifsc"."\t"."Token"."\t \n ";
	 echo $body;
	 for($i=1;$i<=$num_rows;$i++)
	{
		$row=getRows($rs_f_excel);
	         //  echo $i."\t";
			   echo $row['officer_name']."\t";
			   echo $row['person_desig']."\t";
			   echo $row['personcd']."\t";
			   echo $row['office']."\t";
			   echo $row['address']."\t";
			   echo $row['block_muni_name']."\t";
			   echo $row['postoffice']."\t";
			   echo $row['subdivision']."\t";
			   echo $row['policestation']."\t";
			   echo $row['district']."\t";
			   echo $row['pin']."\t";
			   echo $row['officecd']."\t";
			   
			   echo $row['post_stat']."\t";
			   echo $row['mob_no']."\t";
			   echo $row['training_desc']."\t";
			   echo $row['venuename']."\t";
			   echo $row['venueaddress']."\t";
			   echo $row['training_dt']."\t";
			   echo $row['training_time']."\t";
			   echo $row['epic']."\t";
			   echo $row['acno']."\t";
			   
			   echo $row['partno']."\t";
			   echo $row['slno']."\t";
			   echo $row['bank_name']."\t";
			   echo $row['branch_name']."\t";
			   echo $row['bank_acc_no']."\t";
			   echo $row['ifsc_code']."\t";
			   
			   echo $row['token']."\t \n";
	}
	 
}
?>