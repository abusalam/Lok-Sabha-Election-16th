<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Randomisation</title>
<style type="text/css">
.lock{ background-attachment:fixed; background: #999 url(images/Lock-icon.png) left no-repeat; background-size: 45%; padding-left:50px; border: outset;}
.unlock{ background-attachment:fixed; background: #999 url(images/Unlock-icon.png) left no-repeat; background-size: 45%; padding-left:50px; border: outset;}
.button1{ background:#999; border:outset;}
</style>
<?php
include('header/header.php');
?>
<?php
$pc_cd="0";
if(isset($_SESSION['pc_cd']) && $_SESSION['pc_cd']!=null)
	$pc_cd=sprintf("%02d",$_SESSION['pc_cd']);
?>
<script type="text/javascript">
function lock_all()
{
	var pwd=document.getElementById('txt1');
	var unlock=document.getElementById('unlock');
	var lock=document.getElementById('lock');
	var randomisation=document.getElementById('randomisation');
	var message=document.getElementById('msg');
	message.innerHTML="";
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
			if(xmlhttp.responseText=="lock")
			{
				lock.disabled=true;
				randomisation.disabled=true;
				unlock.disabled=false;
				pwd.readOnly=false;
			}
		}
	  }
	xmlhttp.open("GET","lock-unlock.php?opn=lock_secondrand",true);
	xmlhttp.send();
}
function unlock_all()
{
	var pwd=document.getElementById('txt1').value;
	var unlock=document.getElementById('unlock');
	var lock=document.getElementById('lock');
	var randomisation=document.getElementById('randomisation');
	var message=document.getElementById('msg');
	message.innerHTML="";
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
			if(xmlhttp.responseText=="unlock")
			{
				lock.disabled=false;
				randomisation.disabled=false;
				unlock.disabled=true;
				document.getElementById('txt1').value="";
			}
			else
			{
				message.innerHTML=xmlhttp.responseText;
			}
		}
	  }
	xmlhttp.open("GET","lock-unlock.php?pass="+pwd+"&opn=unlock_secondrand",true);
	xmlhttp.send();
}
function state_check()
{
	var pwd=document.getElementById('txt1');
	pwd.readOnly=false;
	var unlock=document.getElementById('unlock');
	var lock=document.getElementById('lock');
	var randomisation=document.getElementById('randomisation');
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
			if(xmlhttp.responseText=="true")
			{
				lock.disabled=true;
				randomisation.disabled=true;
				unlock.disabled=false;
			}
			else if(xmlhttp.responseText=="false")
			{
				lock.disabled=false;
				randomisation.disabled=false;
				unlock.disabled=true;
			}
			else
			{
				document.getElementById('msg').innerHTML="Set second randomisation password";
				lock.disabled=true;
				randomisation.disabled=true;
				unlock.disabled=true;
				pwd.readOnly=true;
			}
		}
	  }
	xmlhttp.open("GET","lock-unlock.php?&opn=state_secondrand",true);
	xmlhttp.send();
}
function randomise_click()
{
	var message=document.getElementById('msg');
	message.innerHTML="";
	if(document.getElementById('txt1').value=='admin')
	{
	var pc=document.getElementById('hid_pc').value;
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
		document.getElementById("rand_result").innerHTML=xmlhttp.responseText;
		document.getElementById("randomisation").disabled=true;
		document.getElementById("form1").style="cursor:default";
		document.getElementById('txt1').value="";
		}
	  }
	xmlhttp.open("GET","randomise2.php?pc_cd="+pc+"&dist=<?php print $dist_cd; ?>",true);
	document.getElementById("rand_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
	document.getElementById("form1").style="cursor:wait";
	xmlhttp.send();
	}
	else
	{
		message.innerHTML="Wrong Password !!!";
		document.getElementById('txt1').focus();
	}
}
</script>
</head>
<body onload="return state_check();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $pc_name; ?> PARLIAMENT CONSTITUENCY</td></tr>
<tr>
  <td align="center">SECOND RANDOMISATION</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="50%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
	<tr>
      <td align="center" colspan="2"><div id="rand_result">&nbsp;</div></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<input type="hidden" id="hid_pc" value="<?php print $pc_cd; ?>" />
    <input type="hidden" name="hid_rand" value="<?php echo rand(0,500); ?>" />
	<tr><td align="center" colspan="2">Password: &nbsp;&nbsp;&nbsp;<input type="password" id="txt1" name="txt1" readonly="readonly" /></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<tr>
	  <td align="center" colspan="2"><input type="button" name="randomisation" id="randomisation" value="Randomise" class="button1"  style="height:50px; width:150px;" onclick="return randomise_click();" /></td></tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
	  <td align="center"><input type="button" name="lock" id="lock" value="Lock" class="lock" style="height:50px; width:100px;" onclick="return lock_all();" /></td>
      <td align="center"><input type="button" name="unlock" id="unlock" value="Unlock" class="unlock"  style="height:50px; width:100px;" onclick="return unlock_all();" /></td></tr>
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