<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php
include('../header/header.php');
?>
</head>

<body oncontextmenu="return false;">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2">PERLIAMENT GENERAL ELECTION, 2014</div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">OFFICE DETAILS ENTRY</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">

</form></td></tr>
</table></td></tr>
</table></div>
</body>
</html>