<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Personnel List</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function personnel_list(str)
{
	var qstr;
	var officeid=document.getElementById('officeID').value;
	<?php
	if(isset($_REQUEST['msg']))
	{
		if($_REQUEST['msg']=='success')
		{?>
			officeid="<?php echo isset($_SESSION['officeid_p'])?$_SESSION['officeid_p']:""; ?>";
			document.getElementById('officeID').value=officeid;
		<?php }
	}
	?>
	var personnelID=document.getElementById('personnelID').value;
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
			document.getElementById("personnel_result").innerHTML=xmlhttp.responseText;
			document.getElementById("form1").style="cursor:default";
		}
	  }
	if(str=="search")
		qstr="ajax-personnel.php?officeid="+officeid+"&personcd="+personnelID+"&frmdt="+frmdt+"&todt="+todt+"&search="+str;
	else
		qstr="ajax-personnel.php?officeid="+officeid+"&personcd="+personnelID+"&frmdt="+frmdt+"&todt="+todt+"&p="+page+"&a="+all;
	xmlhttp.open("GET",qstr,true);
	document.getElementById("personnel_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
	document.getElementById("form1").style="cursor:wait";
	xmlhttp.send();
}
$(document).ready(function(){  $('.overlay').fadeOut();  });
function edit_person(str)
{
	location.replace("add-personnel.php?personcd="+str);
}
</script>
<?php
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$msg="<div class='alert-success'>Record updated successfully</div>";
	}
}
//onload="javascript:return personnel_list('pload');"
?>

<link type="text/css" rel="stylesheet" href="css/paging.css" />
</head>
<body oncontextmenu="return false;" onload="javascript:return personnel_list('pload');" >
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">PERSONNEL DETAILS LIST</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="95%" class="form" cellpadding="0">
    <tr><td colspan="4" align="center"><?php print $subdiv_name; ?> SUBDIVISION</td></tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
	<tr>
      <td height="16px" colspan="4" align="center"><?php print isset($msg)?$msg:""; ?></td>
    </tr>
	<tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Office ID</td>
      <td align="left"><input type="text" name="officeID" id="officeID" style="width:250px;" /></td>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Personnel ID</td>
      <td align="left"><input type="text" name="personnelID" id="personnelID" style="width:250px;" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>From Date</td>
      <td align="left"><input type="text" name="fromdt" id="fromdt" maxlength="10" style="width:142px;"  /></td>
	  <td align="left"><span class="error">&nbsp;&nbsp;</span>To Date</td>
      <td align="left"><input type="text" name="todt" id="todt" maxlength="10" style="width:142px;" /></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="button" name="search" id="search" value="Search" class="button" onclick="javascript:return personnel_list('search');" /></td>
    </tr>
    <tr><td colspan="2" align="left">&nbsp;</td></tr>
    <tr>
      <td align="center" colspan="4" id="personnel_result">
      	<div class="overlay">
  			<img id="loading_spinner" src="images/loading.gif" />
		</div>
      	<!--<table width="100%" cellpadding="0" cellspacing="0" border="0" id="table1">
        <tr><th>Sl.</th>
        	<th>Office ID</th>
            <th>Office Name</th>
            <th>Office Address</th>
            <th>Nature of Office</th>
            <th>Edit</th></tr>
        <tr><td align="center"><img src="images/edit.png" alt="" height="20px" /></td></tr>
        </table>-->
      </td>
    </tr>  
    <tr><td></td><td colspan="3" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
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
			calendar.value($("#fromdt").val());
			calendar.value($("#todt").val());
		};

		$("#get").click(function() {
			alert(calendar.value());
		});

		$("#fromdt").kendoDatePicker({
			change: setValue
		});
		$("#todt").kendoDatePicker({
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