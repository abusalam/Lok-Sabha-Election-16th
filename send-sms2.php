<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Send SMS For Second Training</title>
<?php
include('header/header.php');
?>

</head>
<?php
include_once('function/sms_fun.php');
if(isset($_REQUEST['send']) && $_REQUEST['send']!=null)
	$sub=$_REQUEST['send'];
else
	$sub="";
if($sub=="Send SMS")
{
		$from=isset($_REQUEST['from'])?$_REQUEST['from']:0;
		$to=isset($_REQUEST['to'])?$_REQUEST['to']:0;
		$limit=$to-$from+1;
		$rs_data=fatch_SMS_from_sms_table2(($from-1),$limit);
		if(rowCount($rs_data)>0)
		{
			for($i=1;$i<=rowCount($rs_data);$i++)
			{
				$row_data=getRows($rs_data);
				$name=$row_data['name'];
				$mob_no=$row_data['phone_no'];
				$Message=$row_data['message'];
				
				$DestinationAddress = $mob_no;
				include('sms/Index.php');			
			}
				
		}
		else
			$msg="<div class='alert-error'>No record found</div>";

?>	
<script>location.replace("send-sms.php?msg=success");</script>           
 <?php
}
?>
<?php
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$msg="<div class='alert-success'>Message sent successfully</div>";
	}
}
?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $subdiv_name; ?> SUBDIVISION</td></tr>
<tr>
  <td align="center">SEND SMS FOR SECOND TRAINING</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="50%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<tr><td align="center" width="50%">From : <input type="text" name="from" id="from" style="width:50px;" onkeypress="javascript:return wholenumbersonly(event);" /></td>
	<td align="center" width="50%">To : <input type="text" name="to" id="to" style="width:50px;" onkeypress="javascript:return wholenumbersonly(event);" /></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<tr>
	  <td align="center" colspan="2"><input type="submit" name="send" id="send" value="Send SMS" class="button" /></td></tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table></form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>