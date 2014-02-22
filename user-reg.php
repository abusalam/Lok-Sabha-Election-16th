<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Registration</title>
<?php
include('header/header.php');
?>

<script type="text/javascript" language="javascript">
function change_category(cat)
{
	if(cat=="District") {
		document.getElementById('trDist').style.visibility="visible";
		document.getElementById('trSubdiv').style.visibility="hidden";
		document.getElementById('trParliament').style.visibility="hidden";
		return false; }
	else
		document.getElementById('trDist').style.visibility="hidden";
	
	if(cat=="Sub-Division") {
		document.getElementById('trSubdiv').style.visibility="visible";
		document.getElementById('trParliament').style.visibility="hidden";
		document.getElementById('trDist').style.visibility="visible";
		return false; }
	else
		document.getElementById('trSubdiv').style.visibility="hidden";
	
	if(cat=="Parliament") {
		document.getElementById('trParliament').style.visibility="visible";
		document.getElementById('trDist').style.visibility="visible";
		document.getElementById('trSubdiv').style.visibility="visible";
		return false; }
	else
		document.getElementById('trParliament').style.visibility="hidden";
}
function district_change(str)
{
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
	  /*if (xmlhttp.readyState==1)
	  {
		 document.getElementById("loadingDiv").innerHTML = "<img src='images/loading.gif'/>";
	  }*/
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("subdiv_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-user.php?dist="+str+"&opn=subdiv",true);
	xmlhttp.send();
}
function subdiv_change(str)
{
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
	  /*if (xmlhttp.readyState==1)
	  {
		 document.getElementById("loadingDiv").innerHTML = "<img src='images/loading.gif'/>";
	  }*/
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("pc_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-user.php?subdiv="+str+"&opn=pc",true);
	xmlhttp.send();
}
function validate()
{
	var userid=document.getElementById("userid").value;
	var password=document.getElementById("password").value;
	var category=document.getElementById("category").value;
	if(userid=="")
	{
		document.getElementById("msg").innerHTML="Enter User ID";
		document.getElementById("userid").focus();
		return false;
	}
	if(password=="")
	{
		document.getElementById("msg").innerHTML="Enter Password";
		document.getElementById("password").focus();
		return false;
	}
	if(category=="0")
	{
		document.getElementById("msg").innerHTML="Select Category";
		document.getElementById("category").focus();
		return false;
	}
	if(category=="District")
	{
		if(document.getElementById("district").value=="0")
		{
			document.getElementById("msg").innerHTML="Select District";
			document.getElementById("district").focus();
			return false;
		}
	}
	if(category=="Sub-Division")
	{
		if(document.getElementById("district").value=="0")
		{
			document.getElementById("msg").innerHTML="Select District";
			document.getElementById("district").focus();
			return false;
		}
		if(document.getElementById("subdiv").value=="0")
		{
			document.getElementById("msg").innerHTML="Select Subdivision";
			document.getElementById("subdiv").focus();
			return false;
		}
	}
	if(category=="Parliament")
	{
		if(document.getElementById("district").value=="0")
		{
			document.getElementById("msg").innerHTML="Select District";
			document.getElementById("district").focus();
			return false;
		}
		if(document.getElementById("subdiv").value=="0")
		{
			document.getElementById("msg").innerHTML="Select Subdivision";
			document.getElementById("subdiv").focus();
			return false;
		}
		if(document.getElementById("parliament").value=="0" || document.getElementById("parliament").value=="")
		{
			document.getElementById("msg").innerHTML="Select Parliament";
			document.getElementById("parliament").focus();
			return false;
		}
	}
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/user_fun.php');
$action=$_REQUEST['submit'];
if($action=='Save')
{
	$district_cd=''; $subdiv=''; $parliament='';
	$userid=$_POST['userid'];
	$password=$_POST['password'];
	$category=$_POST['category'];
	if($category=="District")
	{
		$district_cd=$_POST['district'];
	}
	if($category=="Sub-Division")
	{
		$district_cd=$_POST['district'];
		$subdiv=$_POST['subdiv'];
	}
	if($category=="Parliament")
	{
		$district_cd=$_POST['district'];
		$subdiv=$_POST['subdiv'];
		$parliament=$_POST['parliament'];
	}
	include_once('function\user_fun.php');
	$c_user=duplicate_user($userid);
	if($c_user==0)
	{
		$ret=save_user($userid,$password,$category,$district_cd,$subdiv,$parliament);
		//$sql="select * from user where user_id='$username' and password='$password'";
		if($ret==1) {		
			$user_cd=get_user_cd_ag_username($userid);
			$hid_menucount=$_POST['hid_menucount'];
			for($i=1;$i<=$hid_menucount;$i++)
			{				
				if($_POST['chkmenu_'.$i]=='on')
				{
					$menu_cd=$_POST['hidmenu_'.$i];
					$hid_submenucount=$_POST['hid_submenucount_'.$i];
					if($hid_submenucount==0)
					{
						$ret1=save_user_permission($user_cd,$menu_cd,'');
						if($ret1==1)
							   $msg="<div class='alert-success'>Record added successfully</div>";
						unset($user_cd,$ret1);
					}
					for($j=1;$j<=$hid_submenucount;$j++)
					{
						if($_POST['chksubmenu_'.$i.$j]=='on')
						{
							$submenu_cd=$_POST['hidsubmenu_'.$i.$j];
							$ret1=save_user_permission($user_cd,$menu_cd,$submenu_cd);
							if($ret1==1)
							   $msg="<div class='alert-success'>Record added successfully</div>";
							unset($submenu_cd,$ret1);
						}
					}
					unset($menu_cd);
				}
			}
		}
	}
	else
	{
		$msg="<div class='alert-error'>User already exists</div>";
	}
	unset($userid,$password,$category,$district_cd,$subdiv,$parliament,$c_user,$ret);
}
?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">ADD USER</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="60%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print $msg; ?><span id="msg" class="error"></span></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
	<tr><td align="left" width="50%"><span class="error">*</span>User Id</td><td align="left"><input type="text" name="userid" id="userid" style="width:192px;" /></td></tr>
    <tr><td align="left"><span class="error">*</span>Password</td><td align="left"><input type="password" name="password" id="password" style="width:192px;" /></td></tr>
    <tr><td align="left"><span class="error">*</span>Category</td><td align="left"><select name="category" id="category" style="width:200px;" onchange="change_category(this.value)">
    							<option value="0">-Select-</option>
    							<option value="Administrator">Administrator</option>
                            	<option value="District">District</option>
                                <option value="Sub-Division">Sub-Division</option>
                                <option value="Parliament">Parliament</option>
                            </select></td></tr>
    <tr id="trDist" style="visibility:hidden;"><td align="left"><span class="error">*</span>District</td><td align="left"><select name="district" id="district" style="width:200px;" onchange="return district_change(this.value);">
    							<option value="0">-Select-</option>
                                <?php 	$rsDist=list_district();
									$num_rows=rowCount($rsDist);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowDist=getRows($rsDist);
											echo "<option value='$rowDist[0]'>$rowDist[1]</option>";
										}
									}
									unset($rsDist,$num_rows,$rowDist);
								?>
    							
                            </select></td></tr>
    <tr id="trSubdiv" style="visibility:hidden;"><td align="left"><span class="error">*</span>Sub-Division</td><td align="left" id="subdiv_result"><select name="subdiv" id="subdiv" style="width:200px;"></select></td></tr>
    <tr id="trParliament" style="visibility:hidden;"><td align="left"><span class="error">*</span>Parliament</td><td align="left" id="pc_result"><select name="parliament" id="parliament" style="width:200px;">
    							</select></td></tr>
    <tr><td colspan="2" align="left">Permission</td></tr>
    <tr><td colspan="2">
    <table id="table1" width="100%"><tr><th>Menu</th><th>First Level Submenu</th></tr>
	<?php
    $rsMenu=list_menu();
    $num_rows=rowCount($rsMenu);
    if($num_rows>0)
    {
		echo "\n<input type='hidden' name='hid_menucount' id='hid_menucount' value='$num_rows' />\n";
        for($i=1;$i<=$num_rows;$i++)
        {
            $rowMenu=getRows($rsMenu);
			$menu=$rowMenu['menu_cd'];
            echo "<tr><td align='left'><input type='checkbox' id='chkmenu_$i' name='chkmenu_$i' /><label for='chkmenu_$i'>".$rowMenu['menu']."</label><input type='hidden' name='hidmenu_$i' id='hidmenu_$i' value='$menu' /></td>\n";
			echo "<td align='left'>";
            $rsSubmenu=list_submenu_ag_menu($menu);
            $num_rows_submenu=rowCount($rsSubmenu);
			echo "<input type='hidden' name='hid_submenucount_$i' id='hid_submenucount_$i' value='$num_rows_submenu' />";
            if($num_rows_submenu>0)
            {
                for($j=1;$j<=$num_rows_submenu;$j++)
                {
                    $rowSubmenu=getRows($rsSubmenu);
					$submenu=$rowSubmenu['submenu_cd'];
                    echo "<input type='checkbox' id='chksubmenu_$i$j' name='chksubmenu_$i$j' /><label for='chksubmenu_$i$j'>".$rowSubmenu['submenu']."</label><input type='hidden' name='hidsubmenu_$i$j' id='hidsubmenu_$i$j' value='$submenu' /><br />\n";
                }
            }
            echo "</td></tr>\n";
        }
    }
    //unset($rsDist,$num_rows,$rowDist);
    ?>
    </table>
    </td></tr>
    <tr><td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" /></td></tr>
    <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table></form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>