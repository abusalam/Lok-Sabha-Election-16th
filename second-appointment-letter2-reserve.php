<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Appointment Letter For Reserve</title>
<?php
include('header/header.php');
?>
<?php
$subdiv_cd="0";
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
?>
</head>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">SECOND APPOINTMENT LETTER FOR RESERVE PERSONNEL</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" action="reports/2nd-app-letter2-reserve.php" target="_blank">
	<table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <!--<tr>
      <td align="left">User ID</td>
      <td align="left"><select name="user" id="user"></select></td><td colspan="2">&nbsp;</td>
    </tr>-->
    <tr><td colspan="2" width="55%" align="center">
        <table width="50%">
        <tr>
          <td align="left">Print Record</td>
          <td align="left">From :<input type="text" name="txtfrom" id="txtfrom" style="width:50px" /></td>
          <td align="right">To :</td>
          <td align="left"><input type="text" name="txtto" id="txtto" style="width:50px" /></td>
        </tr>
        </table>
        </td>
        
    </tr>
    <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="10px" /></td></tr>
    <tr><td colspan="4" align="center"><input type="submit" name="search" id="search" value="Submit" class="button" /></td></tr>
    <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    </table>
</form></td></tr>
</table></td></tr>
</table></div>
</body>
</html>