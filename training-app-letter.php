<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order of Appointment for Training</title>
<style type="text/css">
body{font: 12px Verdana, Geneva, sans-serif;}
</style>
</head>
<body>
<div>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td align="center">
<?php
date_default_timezone_set('Asia/Calcutta');
	include_once('../inc/db_trans.inc.php');
	include_once('../function/appointment_fun.php');
	$usercd=$_SESSION['user_cd'];
	$env=isset($_SESSION['environment'])?$_SESSION['environment']:"";
	$distnm_cap=isset($_SESSION['distnm_cap'])?$_SESSION['distnm_cap']:"";
	$rstmp=fetch_id_temp_app_letter($usercd);
	$tmprow=getRows($rstmp);
	$str_per_code=$tmprow['per_code'];
	$del_ret=delete_prev_data_single($str_per_code);
	
	$rsId=fetch_id_temp_app_letter($usercd);
	$num_rows=rowCount($rsId);
	if($num_rows>0)
	{
		include_once('../inc/commit_con.php');
		mysqli_autocommit($link,FALSE);
		$sql="insert into first_rand_table (officer_name,person_desig,personcd,office,address,postoffice,subdivision,policestation, district,pin,officecd,poststatus,mob_no,training_desc,venuename,venueaddress,training_dt,training_time,pc_code,pc_name,forsubdivision,epic,acno,partno,slno, bank,branch,bank_accno,ifsc,token) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt = mysqli_prepare($link, $sql);
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowId=getRows($rsId);
			$rsApp=first_appointment_letter_hdr($rowId['per_code']);
			if(rowCount($rsApp)==0)
			{
				echo "Appointment Letter not available. </td></tr></table></div></body></html>";
				exit;
			}
			$rowApp=getRows($rsApp);
			$token_no=substr($rowApp['pp_subdivision'], 0, 4)."/".$rowApp['post_stat']."/".$rowApp['token'];
			echo "<table width='750'>
  <tr>
    <td align='left'><div style='border:1px solid; width:150px;text-align:center;'>ELECTION URGENT</div></td>
	<td align='right'><div style='border:0px solid; width:250px;text-align:right;'>Token No. $token_no</div></td>
  </tr>
</table>
<p align='center'><strong><u>ORDER OF APPOINTMENT FOR TRAINING</u></strong><br />
<u>$env</u></p>
<table cellspacing='0' cellpadding='0' width='750'>
  <tr>
    <td width='70%' align='left'>Order No: $_SESSION[apt1_orderno]</td>
    <td width='20%' align='right'>Date:&nbsp;</td>
	<td width='10%' align='left'>&nbsp;$_SESSION[apt1_date]</td>
  </tr>
</table>
<table cellspacing='0' cellpadding='0' width='750'>
	<tr><td align='left'>
<p>&nbsp;&nbsp; In exercise of the power conferred upon vide Section 26 of the R. P. Act, 1951, I do hereby appoint the officer specified below as $rowApp[poststatus] for undergoing training in connection with the conduct of General Election to House of People, 2014 from $rowApp[forpc]-$rowApp[pcname] PC</p>";
 //from $rowApp[forpc]-$rowApp[pcname] PC
echo "</td></tr>
</table>
<div align='center'>
  <table width='600px' border='1' cellspacing='0' cellpadding='0'>
    <tr>
      <td align='center'><strong>Name of Polling Officer</strong></td>
    </tr>
    <tr>
      <td align='center'>$rowApp[officer_name], $rowApp[person_desig]&nbsp;&nbsp;&nbsp;&nbsp;<b>PIN-$rowApp[personcd]</b>
      <br />$rowApp[office], $rowApp[address1], $rowApp[address2], P.O.-$rowApp[postoffice], Subdiv-$rowApp[subdivision], P.S.-$rowApp[policestation], Dist.-$rowApp[district], PIN-$rowApp[pin]
      <br /><br />($rowApp[officecd])&nbsp;&nbsp;&nbsp;&nbsp;<b>$rowApp[poststatus]</b>
      <br />Mobile : $rowApp[mob_no]</td>
    </tr>
  </table>
</div>
<div align='center'><table width='600px'><tr><td align='left'>The Officer should report for Training as per following Schedule.</td></tr></table></div>
<div align='center'><br />
  <table width='730px' border='1' cellspacing='0' cellpadding='0'>
    <tr>
      <td colspan='5' align='center'><strong>Training Schedule</strong></td>
    </tr>
    <tr>
      <td width='20%'><strong>Training</strong></td>
      <td width='25%'><strong>Venue</strong></td>
      <td width='27%'><strong>Address</strong></td>
      <td width='12%'><strong>Date</strong></td>
      <td width='15%'><strong>Time</strong></td>
    </tr>";
	$office_address=$rowApp['address1'].", ".$rowApp['address2'];
	$rsAppDtl=first_appointment_letter($rowApp['personcd']);
	if(rowCount($rsAppDtl)>0)
	{
		for($j=1;$j<=rowCount($rsAppDtl);$j++)
		{
			$rowAppDtl=getRows($rsAppDtl);
			echo "<tr>
			  <td height='70'>$rowAppDtl[training_desc]</td>
			  <td>$rowAppDtl[venuename]</td>
			  <td>$rowAppDtl[venueaddress1], $rowAppDtl[venueaddress2]</td>
			  <td>$rowAppDtl[training_dt]</td>
			  <td>$rowAppDtl[training_time]</td>
			</tr>";
			
			
			$training_desc=$rowAppDtl['training_desc'];
			$venuename=$rowAppDtl['venuename'];
			$venue_add=$rowAppDtl['venueaddress1'].", ".$rowAppDtl['venueaddress2'];
			$training_dt=$rowAppDtl['training_dt'];
			$training_time=$rowAppDtl['training_time'];
			
			mysqli_stmt_bind_param($stmt, 'ssssssssssssssssssssssssssssss', $rowApp['officer_name'],$rowApp['person_desig'],$rowApp['personcd'],$rowApp['officer_desig'],$office_address,$rowApp['postoffice'],$rowApp['subdivision'],$rowApp['policestation'],$rowApp['district'],$rowApp['pin'],$rowApp['officecd'],$rowApp['poststatus'],$rowApp['mob_no'],$training_desc,$venuename,$venue_add,$training_dt,$training_time,$rowApp['forpc'],$rowApp['pcname'],$rowApp['forsubdivision'],$rowApp['epic'],$rowApp['acno'],$rowApp['partno'],$rowApp['slno'],$rowApp['bank_name'],$rowApp['branch_name'],$rowApp['bank_acc_no'],$rowApp['ifsc_code'],$token_no);
			mysqli_stmt_execute($stmt);
			$rowAppDtl=NULL;
		}
		unset($rsAppDtl);
	}
	else
	{
			$training_desc='';
			$venuename='';
			$venue_add='';
			$training_dt='';
			$training_time='';
			
			mysqli_stmt_bind_param($stmt, 'ssssssssssssssssssssssssssssss', $rowApp['officer_name'],$rowApp['person_desig'],$rowApp['personcd'],$rowApp['officer_desig'],$office_address,$rowApp['postoffice'],$rowApp['subdivision'],$rowApp['policestation'],$rowApp['district'],$rowApp['pin'],$rowApp['officecd'],$rowApp['poststatus'],$rowApp['mob_no'],$training_desc,$venuename,$venue_add,$training_dt,$training_time,$rowApp['forpc'],$rowApp['pcname'],$rowApp['forsubdivision'],$rowApp['epic'],$rowApp['acno'],$rowApp['partno'],$rowApp['slno'],$rowApp['bank_name'],$rowApp['branch_name'],$rowApp['bank_acc_no'],$rowApp['ifsc_code'],$token_no);
			mysqli_stmt_execute($stmt);
	}
	echo "
  </table>
</div>
<hr width='750px' />
<div align='center'>
<table cellspacing='0' cellpadding='0' width='750'>
	<tr><td align='left'>&nbsp;&nbsp;&nbsp;&nbsp; This is a compulsory duty on your part to attend the said programme, as per the provisions of The Representation of the People Act, 1951. <br />
&nbsp;&nbsp;&nbsp;&nbsp; You are directed to bring your Elector's Photo Identity Card (EPIC) or any proof of Identity affixed with your Photograph.</td></tr></table></div>
<div align='center'>
<table cellspacing='0' cellpadding='0' width='750'>
	<tr><td height='20px' colspan='2'>&nbsp;</td></tr>
	<tr><td align='right' colspan='2'>Signature &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></div>
<tr><td align='left'>Place: ".uppercase($distnm_cap)."</td><td rowspan='3' align='right'><img src='../images/deo/$_SESSION[signature]' alt='' height='50px' width='100px' /></td></tr>
<tr><td align='left'>Date: ".date('d/m/Y')."</td></tr>
<tr><td height='30px' align='right'>&nbsp;</td></tr>
<tr><td align='right' colspan='2'>District Election Officer <br />
District ".wordcase($distnm_cap)." &nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table>
<hr  width='750px' />
<table cellspacing='0' cellpadding='0' width='750px'>
  <tr>
    <td width='5%' rowspan='6' valign='top'>NB.</td>
    <td width='5%' valign='top'>1.</td>
    <td width='90%' align='left'>Please fillup form 12A (for Election Duty Certificate) if you have been deployed for poll duty within your home Parliamentary Constituency. In other cases fill up form form 12 (for Postal Ballot).</td>
  </tr>
  <tr>
    <td valign='top'>2.</td>
    <td align='left'>Please submit duly filled in form 12/12A allong with duplicate copy of appointment letter at training venue on the first day of training.</td>
  </tr>
  <tr>
    <td valign='top'>3.</td>
    <td align='left'>Please write particulars on the supplied blank Identity Card and also affix your colour passport size photograph on it. Please bring it at training venue for attestation.</td>
  </tr>
  <tr>
    <td valign='top'>4.</td>
    <td align='left'>Please check your electoral data and bank details given below. For any inconsistancy please inform the authority.</td>
  </tr>
  <tr>
    <td valign='top'>&nbsp;</td>
    <td align='left'>EPIC No.- $rowApp[epic] &nbsp;&nbsp; Assembly- $rowApp[acno] &nbsp;&nbsp; Part No.- $rowApp[partno] &nbsp;&nbsp; Sl. No.- $rowApp[slno] <br /> Bank- $rowApp[bank_name] &nbsp;&nbsp; Branch- $rowApp[branch_name] &nbsp;&nbsp; A/c No.- $rowApp[bank_acc_no] &nbsp;&nbsp; IFS Code- $rowApp[ifsc_code]</td>
  </tr>
  <tr>
    <td valign='top'>5.</td>
    <td align='left'>Please bring in the filled up data sheet, as attached herewith, during the first training.</td>
  </tr>
</table>
<table width='750px' cellspacing='0' cellpadding='0'>
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
  <table width='700' border='0' cellspacing='0' cellpadding='0'>
    <tr>
      <td width='70%' valign='top'>Receipt of Appointment Letter</td>
      <td width='30%' valign='top'>Signature of the Recepient<br />
      Date:</td>
    </tr>
  </table>
</div>";
echo "\n<h6></h6>\n";
			
			echo "\n<h6></h6>\n";
			
			$rowPer=NULL;
		}
		unset($rsId,$num_rows);

		if (!mysqli_commit($link)) {
			print("Transaction commit failed\n");
			exit();
		}
		mysqli_stmt_close($stmt);
		mysqli_close($link);
		
		//delete_temp_app_letter($usercd);
	}
?>
</td></tr></table>
</div>
</body>
<style>
@media print
{
h6 {page-break-after:always;}
}
</style>
</html>