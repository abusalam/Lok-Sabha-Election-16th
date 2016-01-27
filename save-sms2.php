<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Save SMS For Second Training</title>
<?php
include('header/header.php');
?>
<?php
$subdiv_cd="0";
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
?>
</head>
<?php
//include_once('function/add_fun.php');
include_once('function/training2_fun.php');
if(isset($_REQUEST['send']) && $_REQUEST['send']!=null)
	$sub=$_REQUEST['send'];
else
	$sub="";
if($sub=="Save SMS")
{
	$rec=insert_second_training();
		if ($rec>0)
		{
			$msg="<div class='alert-success'>$rec Record(s) saved successfully</div>";
		}
		else
		{
			$msg="<div class='alert-error'>No Record(s) saved</div>";
		}
?>		<script>window.open('tt.php?mode=2');</script>		
<!--<script>location.replace("save-sms.php?msg=success");</script> -->            
                <?php
}
?>
<?php
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		//$msg="<div class='alert-success'>Message sent successfully</div>";
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
  <td align="center">SAVE SMS FOR POLLING PERSONNEL & RESERVE PERSONNEL FOE SECOND TRAINING</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="50%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<tr>
	  <td align="center" colspan="2"><input type="submit" name="send" id="send" value="Save SMS" class="button"  style="height:100px; width:200px;" /></td></tr>
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