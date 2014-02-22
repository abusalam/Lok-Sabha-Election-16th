<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Form 12A</title>
<style type="text/css">
.text1{font-size: 9px;}
body{
	font-size: 14px;
	text-align: justify;
}
</style>
</head>
<body>
<div align="center">
<?php
	include_once('..\inc\db_trans.inc.php');
	include_once('..\function\form_12_fun.php');
	$personcd=decode($_GET['personcd']);
	$type=$_GET['type'];
	$rsF12=form12A_report($personcd,$type);
	$num_rows=rowCount($rsF12);
	$rowF12=getRows($rsF12);
	if($rowF12['assemblyname']=="" || $rowF12['assemblyname']==null)
		$assemblyname="Other";
	else
		$assemblyname=$rowF12['assemblyname'];
	if($rowF12['pcname']=="" || $rowF12['pcname']==null)
		$pcname="__________________";
	else
		$pcname=$rowF12['pcname'];
?>
  <table width="400" border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td><div align="center"><em>Conduct of Elections Rules, 1961</em></div></td>
    </tr>
    <tr>
      <td><div align="center">(Statutory Rules and Order)</div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="center">FORM 12A</div></td>
    </tr>
    <tr>
      <td><div align="center">[<em>See </em>rule 20(<em>2</em>)]</div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="center" class="text1">APPLICATION FOR ELECTION  DUTY CERTIFICATE</div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="750px" border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td align="left"><p>To <br />
The Returning  Officer, <br />
<?php print $pcname;?> Parliamentary Constituency </p>
        <p>Sir, <br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I intend to cast my vote in person at  the ensuing election to the Legislative Assembly/House of the People from the <b><?php print $rowF12['pccd1']." - ".$rowF12['pcname1'];?></b> constituency. </p>
        <p>        I have been posted on election duty  within the constituency at <b><?php print $rowF12['psno']." - ".$rowF12['psname'];?></b> but my name is entered at Serial No <b><?php print $rowF12['slno'];?></b> Part No. <b><?php print $rowF12['partno'];?></b> of  the electoral rolls for <b><?php print $rowF12['acno']." - ".$assemblyname;?></b> assembly constituency comprised  within <b><?php print $rowF12['pccd']." - ".$pcname;?></b> Parliamentary constituency. </p>
        <p>        I request that an Election Duty  Certificate in Form 12B may be issued to enable me to vote at the polling  station where I may be on duty on the polling day. It may be sent to me at the  following address:— </p>
        <p><?php print $rowF12['present_addr1'];?>, <br />
          <?php print $rowF12['present_addr2'];?> <br />
          ................................. </p>
      <p>Place  .............                                                                                                                           Yours faithfully, <br />
      Date ..............                                                                                                                  <?php print $rowF12['officer_name'];?></p>
      <br />
      <hr /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>