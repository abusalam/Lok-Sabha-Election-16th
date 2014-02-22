<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Form 12</title>
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
	$rsF12=form_12_report($personcd,$type);
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
  <table width="300" border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td align="center">FORM 12</td>
    </tr>
    <tr>
      <td align="center">(<em>See </em>rules 19  and 20)</td>
    </tr>
    <tr>
      <td align="center" class="text1">LETTER OF INTIMATION TO RETURNING  OFFICER</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="750px" border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td align="left"><p>To <br />
        The Returning  Officer for <br />
      <?php print $pcname;?> Parliamentary Constituency</p>
        <p>Sir, <br />
    I intend to cast my vote by post at the  ensuing election to the Legislative Assembly/House of the People from the <b><?php print $rowF12['pccd1']." - ".$rowF12['pcname1'];?></b> Parliamentary constituency.</p>
        <p>    My name is entered at S.No <b><?php print $rowF12['slno'];?></b> in Part  No <b><?php print $rowF12['partno'];?></b> of the electoral role for <b><?php print $rowF12['acno']." - ".$assemblyname;?></b> assembly constituency comprised within <b><?php print $rowF12['pccd']." - ".$pcname;?></b> Parliamentary constituency. </p>
        <p>    The ballot paper may be sent to me at the  following address:— </p>
        <p><?php print $rowF12['present_addr1'];?>, <br />
          <?php print $rowF12['present_addr2'];?> <br />
          ................................. </p>
        <p>Place  ...........................                                                                                                                           Yours  faithfully, <br />
        Date  ............................                                                                                                                   <?php print $rowF12['officer_name'];?> </p>
        <br />
        <hr />
        <p>1. Subs. by Notifn. No. S.O. 3662, dated the  12th October, 1964, for Form 12.</p></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>