<?php
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Set Randomisation</title>
<?php
include('header/header.php');
?>
<?php

extract($_GET);
$sub="0";
if (isset($_SESSION['subdiv_cd']))
{
	$sub=$_SESSION['subdiv_cd'];
}
?>
<script>
/*function area_detail(str)
{

	if (window.XMLHttpRequest)
	  {
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("area_of_preference").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-training.php?area="+str+"&subdivision=<?php print $sub; ?>&opn=areadtl",true);
	xmlhttp.send();
}*/
/*function validate()
{
	var password=document.getElementById("password").value;
	if(password=="")
	{
		document.getElementById("msg").innerHTML="Enter Password";
		document.getElementById("password").focus();
		return false;
	}

	
}*/
</script>

<?php
//include 'mysqliconn.php';
//include 'training_assign.php';
include_once('inc/db_trans.inc.php');
include_once('function/training_fun.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
$rand=isset($_REQUEST['rand'])?decode($_REQUEST['rand']):"";
if($rand =='')
{
	echo "Invalid request";
	exit;
}
//if($action=='Submit')
//{
	//$aa='admin';
    $password=MD5('admin');
	$user_cd=$_SESSION['user_cd'];
	$tr_save=save_subdiv_pwd($rand,$password,$user_cd,$sub);

	if($tr_save==1)
	{
		if($rand=='1')
		   redirect("first-randomisation.php");
		if($rand=='2')
		   redirect("second-randomisation.php");  
		if($rand=='3')
		   redirect("third-randomisation.php");  
	}
//}

?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $subdiv_name; ?> SUBDIVISION</td></tr>
<tr>
  <td align="center">SET RANDOMISATION</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="70%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="30px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    
    <tr>
      <td align="left"><span class="error">*</span>password</td>
      <td align="left"><input type="text" name="password" id="password" style="width:200px;">
		</td></tr>
 
     <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
      <tr><td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Submit" class="button" onclick="javascript:return validate();" /></td></tr>
      <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table></form>
</td></tr></table>
</td></tr>
</table>

</div>

</body>
</html>