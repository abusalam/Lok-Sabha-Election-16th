<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Appointment Letter Populate</title>
<?php
include('header/header.php');
?>
<?php
$pc_cd="0";
if(isset($_SESSION['subdiv_cd']) && $_SESSION['subdiv_cd']!=null)
	$subdiv_cd=sprintf("%04d",$_SESSION['subdiv_cd']);
?>
</head>
<?php
if(isset($_REQUEST['populate']) && $_REQUEST['populate']!=null)
	$sub=$_REQUEST['populate'];
else
	$sub="";
if($sub=="Populate")
{
 ?>
<script type="text/javascript" language="javascript">
function populate_click()
{
	var subdiv=document.getElementById('hid_subdiv').value;
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
		document.getElementById("populate_result").innerHTML=xmlhttp.responseText;
		document.getElementById("populate").disabled=true;
		document.getElementById("form1").style="cursor:default";
		}
	  }
	xmlhttp.open("GET","populate_second_appt.php?subdiv_cd="+subdiv+"&dist=<?php print $dist_cd; ?>",true);
	document.getElementById("populate_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
	document.getElementById("form1").style="cursor:wait";
	xmlhttp.send();
}
</script>
<?php
}

$gensl=isset($_POST['gensl'])?$_POST['gensl']:"";
if($gensl=="Serial")
{
 ?>
<script type="text/javascript" language="javascript">
function populate_click()
{
	var subdiv=document.getElementById('hid_subdiv').value;
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
		document.getElementById("populate_result").innerHTML=xmlhttp.responseText;
		document.getElementById("gensl").disabled=true;
		document.getElementById("form1").style="cursor:default";
		}
	  }
	xmlhttp.open("GET","second-app-sl-no.php?subdiv_cd="+subdiv+"&dist=<?php print $dist_cd; ?>",true);
	document.getElementById("populate_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
	document.getElementById("form1").style="cursor:wait";
	xmlhttp.send();
}
</script>
<?php
}

$multiply=isset($_POST['multiply'])?$_POST['multiply']:"";
if($multiply=="Multiply")
{
 ?>
<script type="text/javascript" language="javascript">
function populate_click()
{
	var subdiv=document.getElementById('hid_subdiv').value;
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
		document.getElementById("populate_result").innerHTML=xmlhttp.responseText;
		document.getElementById("multiply").disabled=true;
		document.getElementById("form1").style="cursor:default";
		}
	  }
	xmlhttp.open("GET","multiply-second-app.php?subdiv_cd="+subdiv+"&dist=<?php print $dist_cd; ?>",true);
	document.getElementById("populate_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
	document.getElementById("form1").style="cursor:wait";
	xmlhttp.send();
}
</script>
<?php
}
?>
<body onload="return populate_click();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $subdiv_name; ?> SUBDIVISION</td></tr>
<tr>
<td align="center">SECOND APPOINTMENT LETTER POPULATE</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="50%" class="form" cellpadding="0">
	<tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td height="18px" colspan="3" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
	<tr>
      <td align="center" colspan="3"><div id="populate_result">&nbsp;</div></td></tr>
    <tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<input type="hidden" id="hid_subdiv" value="<?php print $subdiv_cd; ?>" />
    <input type="hidden" name="hid_rand" value="<?php echo rand(0,500); ?>" />
	<!--<tr><td align="center" colspan="2">Password: &nbsp;&nbsp;&nbsp;<input type="password" id="txt1" name="txt1" /></td></tr>-->
    <tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<tr>
	  <td align="center"><input type="submit" name="populate" id="populate" value="Populate" class="button"  style="height:50px; width:100px;" /></td>
	  <td align="left">&nbsp;</td>
	  <!--td align="center"><input type="submit" name="multiply" id="multiply" value="Multiply" class="button"  style="height:50px; width:100px;" /></td-->
      <td align="center"><input type="submit" name="gensl" id="gensl" value="Serial" class="button"  style="height:50px; width:100px;" /></td></tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr><td colspan="3" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table></form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>