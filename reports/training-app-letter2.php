<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order of Appointment for Training</title>
<style type="text/css">
body{font: 13px Verdana, Geneva, sans-serif;}
</style>
</head>
<body>
<?php
	include_once('../inc/db_trans.inc.php');
	include_once('../function/appointment_fun.php');
	$subdiv=(isset($_POST['Subdivision'])?$_POST['Subdivision']:'0');
	$office=(isset($_POST['office'])?$_POST['office']:'0');
	$env=isset($_SESSION['environment'])?$_SESSION['environment']:"";
	$rstmp=first_appointment_letter2_subdiv($subdiv,$office);
	$row=0;
	$rsApp=first_appointment_letter2_hdr($subdiv,$office);
	
	$num_rows=rowCount($rsApp);
	if($num_rows>0)
	{
		include_once('../inc/commit_con.php');
		mysqli_autocommit($link,FALSE);
		$sql="insert into first_rand_table (officer_name,person_desig,personcd,office,address,postoffice,subdivision,policestation, district,pin,officecd,poststatus,mob_no,training_desc,venuename,venueaddress,training_dt,training_time,pc_code,pc_name,epic,acno,partno,slno,bank,branch,bank_accno,ifsc) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt = mysqli_prepare($link, $sql);
		
		$sql1="delete from first_rand_table where subdivision=?";
		$stmt1 = mysqli_prepare($link, $sql1);
		while($row <= rowCount($rstmp))
		{
			$tmprow=getRows($rstmp);
			$str_sub_div=$tmprow['subdivision'];
			//$del_ret=delete_prev_data($str_sub_div);
			//	echo "vall=".$del_ret;
			mysqli_stmt_bind_param($stmt1, 's', $str_sub_div);
			mysqli_stmt_execute($stmt1);
			$row++;
		}
		unset($row,$tmprow,$str_sub_div,$rstmp);
		
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowApp=getRows($rsApp);
			echo "<table width='200' border='1'>
  <tr>
    <td align='center'>ELECTION URGENT</td>
  </tr>
</table>
<p align='center'><strong><u>ORDER OF APPOINTMENT FOR TRAINING</u></strong><br />
<u>$env</u></p>
<table cellspacing='0' cellpadding='0' width='100%'>
  <tr>
    <td width='70%' align='left'>Order No: $_SESSION[apt1_orderno]</td>
    <td width='20%' align='right'>Date: </td>
	<td width='10%' align='left'>&nbsp;$_SESSION[apt1_date]</td>
  </tr>
</table>
<p>&nbsp;&nbsp; In exercise of the power conferred upon vide Section 26 of the R. P. Act, 1951, I do hereby appoint the officer specified below as $rowApp[poststatus] for undergoing training in connection with the conduct of General Election to House of People, 2014</p>";
 //from $rowApp[forpc]-$rowApp[pcname] PC
echo "<div align='center'>
  <table width='470px' border='1' cellspacing='0' cellpadding='0'>
    <tr>
      <td align='center'><strong>Name of Polling Officer</strong></td>
    </tr>
    <tr>
      <td align='center'>".$rowApp['officer_name'].", ".$rowApp['person_desig']."&nbsp;&nbsp;&nbsp;&nbsp;<b>PIN-".$rowApp['personcd']."</b>
      <br />O/O ".$rowApp['officer_desig'].", ".$rowApp['address1'].", ".$rowApp['address2'].", P.O.-".$rowApp['postoffice'].", Subdiv-".$rowApp['subdivision'].", P.S.-".$rowApp['policestation'].", Dist.-".$rowApp['district'].", PIN-".$rowApp['pin']."
      <br /><br />(".$rowApp['officecd'].")&nbsp;&nbsp;&nbsp;&nbsp;<b>".$rowApp['poststatus']."</b>
      <br />Mobile : ".$rowApp['mob_no']."</td>
    </tr>
  </table>
</div>
<div>The Officer should report for Training as per following Schedule.</div>
<div align='center'><br />
  <table width='750px' border='1' cellspacing='0' cellpadding='0'>
    <tr>
      <td colspan='5' align='center'><strong>Training Schedule</strong></td>
    </tr>
    <tr>
      <td width='137'><strong>Training</strong></td>
      <td width='165'><strong>Venue</strong></td>
      <td width='199'><strong>Address</strong></td>
      <td width='86'><strong>Date</strong></td>
      <td width='104'><strong>Time</strong></td>
    </tr>";
	$rsAppDtl=first_appointment_letter2($rowApp['personcd']);
	if(rowCount($rsAppDtl)>0)
	{
		for($j=1;$j<=rowCount($rsAppDtl);$j++)
		{
			$rowAppDtl=getRows($rsAppDtl);
			echo "<tr>
			  <td height='70'>".$rowAppDtl['training_desc']."</td>
			  <td>".$rowAppDtl['venuename']."</td>
			  <td>".$rowAppDtl['venueaddress1'].", ".$rowAppDtl['venueaddress2']."</td>
			  <td>".$rowAppDtl['training_dt']."</td>
			  <td>".$rowAppDtl['training_time']."</td>
			</tr>";
			
			$office_address=$rowApp['address1'].", ".$rowApp['address2'];
			$venue_add=$rowAppDtl['venueaddress1'].", ".$rowAppDtl['venueaddress2'];
			
			mysqli_stmt_bind_param($stmt, 'ssssssssssssssssssssssssssss', $rowApp['officer_name'],$rowApp['person_desig'],$rowApp['personcd'],$rowApp['officer_desig'],$office_address,$rowApp['postoffice'],$rowApp['subdivision'],$rowApp['policestation'],$rowApp['district'],$rowApp['pin'],$rowApp['officecd'],$rowApp['poststatus'],$rowApp['mob_no'],$rowAppDtl['training_desc'],$rowAppDtl['venuename'],$venue_add,$rowAppDtl['training_dt'],$rowAppDtl['training_time'],$rowApp['forpc'],$rowApp['pcname'],$rowApp['epic'],$rowApp['acno'],$rowApp['partno'],$rowApp['slno'],$rowApp['bank_name'],$rowApp['branch_name'],$rowApp['bank_acc_no'],$rowApp['ifsc_code']);
			mysqli_stmt_execute($stmt);
			$rowAppDtl=NULL;
		}
		unset($rsAppDtl);
	}
	echo "
  </table>
</div>
<hr />
<div align='left'>&nbsp;&nbsp;&nbsp;&nbsp; This is a compulsory duty on your part to attend the said programme, as per the provisions of The Representation of the People Act, 1951. <br />
&nbsp;&nbsp;&nbsp;&nbsp; You are directed to bring your Elector's Photo Identity Card (EPIC) or any proof of Identity affixed with your Photograph.</div>
<div align='center'>
<table cellspacing='0' cellpadding='0' width='750'>
	<tr><td height='20px' colspan='2'>&nbsp;</td></tr>
	<tr><td align='right' colspan='2'>Signature &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></div>
<tr><td align='left'>Place: ".uppercase($_SESSION['dist_name'])."</td><td rowspan='3' align='right'><img src='../images/deo/$_SESSION[signature]' alt='' height='50px' width='100px' /></td></tr>
<tr><td align='left'>Date: ".date('d/m/Y')."</td></tr>
<tr><td height='30px' align='right'>&nbsp;</td></tr>
<tr><td align='right' colspan='2'>District Election Officer <br />
District ".wordcase($_SESSION['dist_name'])." &nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table>
</div>
<hr />
<table cellspacing='0' cellpadding='0' width='750'>
  <tr>
    <td width='5%' rowspan='5' valign='top'>NB.</td>
    <td width='5%' valign='top'>1.</td>
    <td width='90%'>Please fillup form 12A (for Election Duty Certificate) if you have been deployed for poll duty within your home Parliamentary Constituency. In other cases fill up form form 12 (for Postal Ballot).</td>
  </tr>
  <tr>
    <td valign='top'>2.</td>
    <td>Please submit duly filled in form 12/12A allong with duplicate copy of appointment letter at training venue on the first day of training.</td>
  </tr>
  <tr>
    <td valign='top'>3.</td>
    <td>Please write particulars on the supplied blank Identity Card and also affix your colour passport size photograph on it. Please bring it at training venue for attestation.</td>
  </tr>
  <tr>
    <td valign='top'>4.</td>
    <td>Please check your electoral data and bank details given below. For any inconsistancy please inform the authority.</td>
  </tr>
  <tr>
    <td valign='top'>&nbsp;</td>
    <td>EPIC No.- $rowApp[epic] &nbsp;&nbsp; Assembly- $rowApp[acno] &nbsp;&nbsp; Part No.- $rowApp[partno] &nbsp;&nbsp; Sl. No.- $rowApp[slno] <br /> Bank- $rowApp[bank_name] &nbsp;&nbsp; Branch- $rowApp[branch_name] &nbsp;&nbsp; A/c No.- $rowApp[bank_acc_no] &nbsp;&nbsp; IFS Code- $rowApp[ifsc_code]</td>
  </tr>";
  
echo "
</table>
<table width='750' cellspacing='0' cellpadding='0'>
  <tr>
    <td>---------------------------------------------------------------------------------------------------------------------------------------------------</td>
  </tr>
  <tr>
    <td>Copy to DDO / Head of Office to serve the Letter and submit the service return.</td>
  </tr>
  <tr>
    <td>---------------------------------------------------------------------------------------------------------------------------------------------------</td>
  </tr>
</table>
<p>&nbsp;</p>
<div align='center'>
  <table width='750' border='0' cellspacing='0' cellpadding='0'>
    <tr>
      <td width='437' valign='top'>Repeipt of Appointment Letter</td>
      <td width='215' valign='top'>Signature of the Recepient<br >
      Date:</td>
    </tr>
  </table>
</div>";
//			$office_address=$rowApp['address1'].", ".$rowApp['address2'];
//			$venue_add=$rowApp['venueaddress1'].", ".$rowApp['venueaddress2'];
			echo "\n<h6></h6>\n";
//			mysqli_stmt_bind_param($stmt, 'ssssssssssssssssss', $rowApp['officer_name'],$rowApp['person_desig'],$rowApp['personcd'],$rowApp['officer_desig'],$office_address,$rowApp['postoffice'],$rowApp['subdivision'],$rowApp['policestation'],$rowApp['district'],$rowApp['pin'],$rowApp['officecd'],$rowApp['poststatus'],$rowApp['mob_no'],$rowApp['training_desc'],$rowApp['venuename'],$venue_add,$rowApp['training_dt'],$rowApp['training_time']);
//			mysqli_stmt_execute($stmt);
			
			$rowApp=NULL;
		}
		unset($rsApp,$num_rows,$rowApp);
		
		if (!mysqli_commit($link)) {
			print("Transaction commit failed\n");
			exit();
		}
		mysqli_stmt_close($stmt);
		mysqli_stmt_close($stmt1);
		mysqli_close($link);
		
		//delete_temp_app_letter($usercd);
	}
?>
</body>
<style>
@media print
{
h6 {page-break-after:always;}
}
</style>
</html>