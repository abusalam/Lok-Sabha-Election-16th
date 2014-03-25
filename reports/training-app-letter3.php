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
date_default_timezone_set('Asia/Calcutta');
	include_once('../inc/db_trans.inc.php');
	include_once('../function/appointment_fun.php');
	$subdiv=(isset($_POST['Subdivision'])?$_POST['Subdivision']:'0');
	$from=(isset($_POST['txtfrom'])?$_POST['txtfrom']:'0');
	$to=(isset($_POST['txtto'])?$_POST['txtto']:'0');
	$hid_rec=(isset($_POST['hid_rec'])?$_POST['hid_rec']:'0');
	$office=(isset($_POST['office'])?$_POST['office']:'0');
	$env=isset($_SESSION['environment'])?$_SESSION['environment']:"";
	$distnm_cap=isset($_SESSION['distnm_cap'])?$_SESSION['distnm_cap']:"";
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
	if($from>$hid_rec || $to>$hid_rec)
	{
		echo "Please check record no";
		exit;
	}
	$rsApp=first_app_letter3_print1($subdiv,$from-1,$to-$from+1);
	
	$num_rows=rowCount($rsApp);
	if($num_rows>0)
	{
		for($i=1;$i<=$num_rows;$i++)
		{
		
			$rowApp=getRows($rsApp);
			
			$officer_name=$rowApp['officer_name'];
			$person_desig=$rowApp['person_desig'];
			$personcd=$rowApp['personcd'];
			$office=$rowApp['office'];
			$office_address=$rowApp['address'];
			$postoffice=$rowApp['postoffice'];
			$subdivision=$rowApp['subdivision'];
			$policestation=$rowApp['policestation'];
			$district=$rowApp['district'];
			$pin=$rowApp['pin'];
			$officecd=$rowApp['officecd'];
			$poststatus=$rowApp['poststatus'];
			$mob_no=$rowApp['mob_no'];
			
			$training_desc=$rowApp['training_desc'];
			$venuename=$rowApp['venuename'];
			$venue_add=$rowApp['venueaddress'];
			$training_dt=$rowApp['training_dt'];
			$training_time=$rowApp['training_time'];	
			
			$forpc=$rowApp['forpc'];
			$pcname=$rowApp['pcname'];
			$epic=$rowApp['epic'];
			$acno=$rowApp['acno'];
			$partno=$rowApp['partno'];
			$slno=$rowApp['slno'];
			$bank_name=$rowApp['bank_name'];
			$branch_name=$rowApp['branch_name'];
			$bank_acc_no=$rowApp['bank_acc_no'];
			$ifsc_code=$rowApp['ifsc_code'];
			$forsubdivision=$rowApp['forsubdivision'];
			$token=$rowApp['token'];
			//$token=$rowApp['post_stat']."/".$rowApp['token'];

			echo "<table width='100%'>
  <tr>
    <td align='left'><div style='border:1px solid; width:150px;text-align:center;'>ELECTION URGENT</div></td>
	<td align='right'><div style='border:0px solid; width:250px;text-align:right;'>Token No. $token</div></td>
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
<p align='left'>&nbsp;&nbsp; In exercise of the power conferred upon vide Section 26 of the R. P. Act, 1951, I do hereby appoint the officer specified below as $rowApp[poststatus] for undergoing training in connection with the conduct of General Election to House of People, 2014 from $rowApp[forpc]-$rowApp[pcname] PC</p>";
 //from $rowApp[forpc]-$rowApp[pcname] PC
echo "<div align='center'>
  <table width='470px' border='1' cellspacing='0' cellpadding='0'>
    <tr>
      <td align='center'><strong>Name of Polling Officer</strong></td>
    </tr>
    <tr>
      <td align='center'>".$officer_name.", ".$person_desig."&nbsp;&nbsp;&nbsp;&nbsp;<b>PIN-".$personcd."</b>
      <br />".$office.", ".$office_address.", P.O.-".$postoffice.", Subdiv-".$subdivision.", P.S.-".$policestation.", Dist.-".$district.", PIN-".$pin."
      <br /><br />(".$officecd.")&nbsp;&nbsp;&nbsp;&nbsp;<b>".$poststatus."</b>
      <br />Mobile : ".$mob_no."</td>
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

echo "<tr>
			  <td height='70'>".$training_desc."</td>
			  <td>".$venuename."</td>
			  <td>".$venue_add."</td>
			  <td>".$training_dt."</td>
			  <td>".$training_time."</td>
			</tr>";
			
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
<tr><td align='left'>Place: ".uppercase($distnm_cap)."</td><td rowspan='3' align='right'><img src='../images/deo/$_SESSION[signature]' alt='' height='50px' width='100px' /></td></tr>
<tr><td align='left'>Date: ".date('d/m/Y')."</td></tr>
<tr><td height='30px' align='right'>&nbsp;</td></tr>
<tr><td align='right' colspan='2'>District Election Officer <br />
District ".wordcase($distnm_cap)." &nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table>
</div>
<hr />
<table cellspacing='0' cellpadding='0' width='750'>
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
      <td width='437' valign='top'>Receipt of Appointment Letter</td>
      <td width='215' valign='top'>Signature of the Recepient<br >
      Date:</td>
    </tr>
  </table>
</div>";
//			$office_address=$rowApp['address1'].", ".$rowApp['address2'];
//			$venue_add=$rowApp['venueaddress1'].", ".$rowApp['venueaddress2'];
			echo "\n<h6></h6>\n";
			
			$rowApp=NULL;
		}
		unset($rsApp,$num_rows,$rowApp);
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