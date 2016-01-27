<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BLO Update</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function fatch_Personaldtl(str)
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
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("Personal_details").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajaxfun.php?mobile="+str,true);
	xmlhttp.send();
}

function validate()
{
	var mobile=document.getElementById("mobile").value;
	var chksetblo=document.getElementById("chksetblo");
	//var DateofTermination=document.getElementById("DateofTermination").value;
	
	if(mobile=="")
	{
		document.getElementById("msg").innerHTML="Enter Mobile No";
		document.getElementById("mobile").focus();
		return false;
	}
	if(chksetblo.checked==false)
	{
		document.getElementById("msg").innerHTML="Checked BLO";
		document.getElementById("chksetblo").focus();
		return false;
	}	
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Update')
{
	$mobile=$_POST['mobile'];
	$chksetblo=$_POST['chksetblo'];
	//$DateofTermination=$_POST['DateofTermination'];
	//$Remarks=$_POST['Remarks'];
	$usercd=$user_cd;
   // $ter_id=$_POST['hid_termination_code'];
	include_once('function/add_fun.php');
	$cnt=0;
	if($cnt==0)
	{
			$ret=update_personnel_blo($mobile,$chksetblo);
			if($ret==1)
			{
				redirect("bloupdate.php?msg=success");
			}
		
	}
	else
	{
		$msg="<div class='alert-error'>Already Used</div>";
	}
	$rsmaxcode=null;
	$rowmaxcode=null;

}
?>
<?php
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$msg="<div class='alert-success'>Record updated successfully</div>";
	}
}
?>

<body oncontextmenu="return false;" onload="javascript: bind_all();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center">
  <table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">BLO UPDATE</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" >
  <table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="4" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Mobile No</td>
      <td align="left"><input type="text" name="mobile" id="mobile" style="width:142px;" onchange="fatch_Personaldtl(this.value)" /></td>
      <td align="left" colspan="2"></td>
    </tr>

    <tr><td colspan="2" align="left"><b>Personal Details</b></td></tr>
    <TR><TD style="height: 1px; background-color: #0066CC; color: #FFFFFF; font-weight:bold;" align=center colSpan=4></TD></TR>

    <tr>
       <td align="left" colspan="4" valign="top" height="95px"><span id="Personal_details"></span></td>
    </tr>
    
    <TR><TD style="height: 1px; background-color: #0066CC; color: #FFFFFF; font-weight:bold;" align=center colSpan=4></TD></TR>
    
    <tr>
      <td align="left" colspan="2" align="left">
           <input type="checkbox" id="chksetblo" name="chksetblo" value='09'/>
        <label for="chksetblo"><span class="error">*</span>BLO<br /></label>
        </td> 
     <td align="left" colspan="2" align="left"></td>
     
    </tr> 
     
    <input type="hidden" id="hid_termination_code" name="hid_termination_code" />
    <tr>
      <td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="Update" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr><td colspan="4"><img src="images/blank.gif" alt="" width="5px" /></td></tr>
  </table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
<div id="calendar" style="width: 243px;display:none;"></div>  
<script>
	$(document).ready(function() {
		$("#calendar").kendoCalendar();

		var calendar = $("#calendar").data("kendoCalendar");
		calendar.value(new Date());

		var navigate = function () {
			var value = $("#direction").val();
			switch(value) {
				case "up":
					calendar.navigateUp();
					break;
				case "down":
					calendar.navigateDown(calendar.value());
					break;
				case "past":
					calendar.navigateToPast();
					break;
				default:
					calendar.navigateToFuture();
					break;
			}
		},
		setValue = function () {
			calendar.value($("#DateofTermination").val());
		};

		$("#get").click(function() {
			alert(calendar.value());
		});

		$("#DateofTermination").kendoDatePicker({
			change: setValue
		});

		$("#set").click(setValue);

		$("#direction").kendoDropDownList({
			change: navigate
		});

		$("#navigate").click(navigate);
	});
</script>
</body>
</html>