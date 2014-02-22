<?php
session_start();
session_destroy();
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include_once('inc\db_trans.inc.php');
$action=$_REQUEST['submit'];
if($action=='Log In')
{
	$username=safe($_POST['username']);
	$password=safe($_POST['password']);
	
	$sql="select * from user where user_id='$username' and password='$password'";
	$rs=execSelect($sql);
	if(rowCount($rs)<1)
	{
        $msg="<div id='invalid-id-pwd' class='invalid'>Invalid User Name or Password</div>";
	}
	else
	{
		$_SESSION['alogin']="true";
		$_SESSION['user']= $username;
		$row=getRows($rs);
		$_SESSION['user_cd']= $row[0];
		$_SESSION['user_cat']= $row[3];
		$_SESSION['dist_cd']= $row[5];
		$_SESSION['subdiv_cd']= $row[6];
		$_SESSION['pc_cd']= ($row[7]!=NULL?$row[7]:'');
		if($_SERVER['QUERY_STRING']=="")
		{
			echo "<script type='text/javascript'>\n";
			echo "window.location.href = 'home.php';\n";
			echo "</script>";
		}
		else
		{
			if(isset($_REQUEST['redirect']))
			{
				$redirect=$_REQUEST['redirect'];
				echo "<script type='text/javascript'>\n";
				echo "window.location.href = '$redirect';\n";
				echo "</script>";
			}
			else
			{
				echo "<script type='text/javascript'>\n";
				echo "window.location.href = 'home.php';\n";
				echo "</script>";
			}
		}
	}
}
?>
<title>Login</title>
<link href="css/login.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function validate()
{
	var login=document.getElementById("username").value;
	var password=document.getElementById("password").value;
	document.getElementById('invalidsp').innerHTML="";
	document.getElementById('invalidsp').setAttribute("style","display:none;");
	if(login=="")
	{
		document.getElementById("msg").innerHTML="Enter Username";
		document.getElementById("username").focus();
		return false;
	}
	if(password=="")
	{
		document.getElementById("msg").innerHTML="Enter Password";
		//document.getElementById("msg").style="color:red; font-size:11px;";
		document.getElementById("password").focus();
		return false;
	}
}
function form_load()
{
	document.getElementById('username').focus();
}
</script>
<style type="text/css" media="all">
body {background-image:url("images/royal-blue-bg-big-header-holder.png") !important;height:438px !important;}
html {background-repeat:repeat-x !important;}
html {background-color:#F4F4F2 !important;}

.login h1 a {background-size:274px 63px !important;}
#login {width:300px !important;}
form {width:300px !important; font-family:verdana !important; border:1px solid #ffffff !important;}
</style>
</head>
<body class="oneColFixCtrHdr" oncontextmenu="return false;" onload="form_load();">
<!--<div align="left" style="background:#009ADE;"><img src="images/login-img.gif" alt="" height="100px" /></div>-->
<div id="container">
  <div id="mainContent" align="center">
  <div style="background:#009ADE; border-radius:4px 4px 0 0;"><img src="images/login-img.png" alt="" height="90px" width="100%" /></div>
  <form name="login" method="post">
    <table width="50%" cellpadding="2" cellspacing="0" border="0">
    <tr><td align="center" height="30px"><span id="invalidsp"><?php print $msg; ?></span><span id="msg" class="error"></span></td></tr>
    <tr><td align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    <tr><td class="text1" align="left">User Name</td></tr>
    <tr><td align="left"><input type="text" name="username" id="username" style="width:250px;" /></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    <tr><td class="text1" align="left">Password</td></tr>
    <tr><td align="left"><input type="password" name="password" id="password" style="width:250px;" /></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    <tr><td align="right"><input type="submit" name="submit" id="submit" value="Log In" class="classname" onclick="javascript:return validate();" /></td>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="10px" /></td></tr>
    <tr><td align="left" colspan="2"><img src="images/logo.png" alt="" /></td></tr>
    </table>
  </form>

	<!-- end #mainContent --></div>
<!-- end #container --></div>
<!--<div style="background-image:url(images/bar.gif); height:50px;">&nbsp;</div>-->
</body>
</html>