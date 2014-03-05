<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Users List</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function user_list()
{
	var dist="<?php echo $dist_cd; ?>";
	var userid=document.getElementById('userid').value;
	var category=document.getElementById('category').value;

	var page="<?php echo isset($_GET['p'])?$_GET['p']:""; ?>";
	var all="<?php echo isset($_GET['a'])?$_GET['a']:""; ?>";
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
			document.getElementById("user_result").innerHTML=xmlhttp.responseText;
		}
	  }
	  
	xmlhttp.open("GET","ajax-user.php?dist="+dist+"&userid="+userid+"&category="+category+"&opn=listuser&p="+page+"&a="+all,true);
	xmlhttp.send();
}
$(document).ready(function(){  $('.overlay').fadeOut();  });
function edit_user(str)
{
	location.replace("user-reg.php?user_cd="+str);
}
function delete_user(str)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
	var delcode=str;
	var sub_div="<?php echo $subdiv_cd; ?>";
	var officeid=document.getElementById('officeID').value;
	var officename=document.getElementById('officename').value;
	var frmdt=document.getElementById("fromdt").value;
	var todt=document.getElementById("todt").value;
	var page="<?php echo isset($_GET['p'])?$_GET['p']:""; ?>";
	var all="<?php echo isset($_GET['a'])?$_GET['a']:""; ?>";
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
			document.getElementById("Office_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-office.php?delcode="+delcode+"&sub_div="+sub_div+"&officeid="+officeid+"&officename="+officename+"&frmdt="+frmdt+"&todt="+todt+"&p="+page+"&a="+all,true);
	xmlhttp.send();
	}
}
</script>
<link type="text/css" rel="stylesheet" href="css/paging.css" />
</head>
<body oncontextmenu="return false;" onload="return user_list();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">USERS LIST</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr><td align="left">User Id</td><td align="left"><input type="text" name="userid" id="userid" style="width:192px;" /></td>
    	<td align="left">Category</td><td align="left"><select name="category" id="category" style="width:200px;" onchange="change_category(this.value)">
    							<option value="0">-Select-</option>
    							<option value="Administrator">Administrator</option>
                            	<option value="District">District</option>
                                <option value="Sub-Division">Sub-Division</option>
                                <option value="Parliament">Parliament</option>
                            </select></td></tr>
    <tr>
      <td colspan="4" align="center"><input type="button" name="search" id="search" value="Search" class="button" onclick="javascript:return user_list();" /></td>
    </tr>
    <tr><td colspan="4" align="left">&nbsp;</td></tr>
    <tr>
      <td align="center" colspan="4" id="user_result">
      	<div class="overlay">
  			<img id="loading_spinner" src="images/loading.gif" />
		</div>
      </td>
    </tr>  
    <tr><td></td><td colspan="3" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
  </table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>