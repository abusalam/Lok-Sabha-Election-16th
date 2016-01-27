<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Token</title>
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
if(isset($_REQUEST['token_create']) && $_REQUEST['token_create']!=null)
	$sub=$_REQUEST['token_create'];
else
	$sub="";
if($sub=="Token Create")
{
	/*if($_REQUEST['txt1']=="admin" && $_POST['hid_rando']==(isset($_SESSION['hid_rand'])?$_SESSION['hid_rand']:$_POST['hid_rando']))
	{*/ ?>
		<script type="text/javascript" language="javascript">
function randomise_click()
{
	var sub_div=document.getElementById('hid_subdiv').value;
	//window.history.back();
	//document.getElementById("rand_result").innerHTML="";
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("token_result").innerHTML=xmlhttp.responseText;
		document.getElementById("form1").style="cursor:default";
		}
	  }
	xmlhttp.open("GET","run.php?subdiv="+sub_div+"&opn=sub",true);
	document.getElementById("token_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
	document.getElementById("form1").style="cursor:wait";
	xmlhttp.send();
}
</script>
	<?php /*}
	else
	{ ?>
		<script>alert('Wrong Password!!');</script>
	<?php }
	$_SESSION['hid_rand']=$_POST['hid_rando'];*/
}
?>
<body onload="return randomise_click();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td>
</tr>
<tr><td align="center"><?php echo $subdiv_name." SUBDIVISION"; ?></td></tr>
<tr>
  <td align="center">TOKEN CREATION</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="50%" class="form" cellpadding="0">
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
	<tr>
      <td align="center" colspan="2"><div id="token_result"></div></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<input type="hidden" id="hid_subdiv" value="<?php print $subdiv_cd; ?>" />
    <input type="hidden" name="hid_rando" value="<?php echo rand(0,500); ?>" />
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<tr>
	  <td align="center" colspan="2"><input type="submit" name="token_create" id="token_create" value="Token Create" class="button"  style="height:100px; width:200px;" /></td></tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>