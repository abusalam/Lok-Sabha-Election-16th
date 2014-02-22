<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Termination List</title>
<?php
include('header/header.php');
?>

<script type="text/javascript" language="javascript">

function termination_list(str)
{
	var qstr;
	var personalid=document.getElementById('PersonalID').value;
	var frmdt=document.getElementById("fromdt").value;
	var todt=document.getElementById("todt").value;
	var page="<?php echo $_GET['p']; ?>";
	var all="<?php echo $_GET['a']; ?>";
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
			document.getElementById("termination_list_result").innerHTML=xmlhttp.responseText;
		}
	  }

	if(str=="search")
    	qstr="ajax-termination.php?personalid="+personalid+"&frmdt="+frmdt+"&todt="+todt;
	else
    	qstr="ajax-termination.php?personalid="+personalid+"&frmdt="+frmdt+"&todt="+todt+"&p="+page+"&a="+all;
	xmlhttp.open("GET",qstr,true);
	xmlhttp.send();
}
$(document).ready(function(){  $('.overlay').fadeOut();  });
//=================================================
function edit_termination(str)
{
	location.replace("termination-details.php?ter_id="+str);
}

function delete_termination(str)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
	var delcode=str;
	var sub_div="<?php echo $subdiv_cd; ?>";
	var personalid=document.getElementById('PersonalID').value;
	var frmdt=document.getElementById("fromdt").value;
	var todt=document.getElementById("todt").value;
	var page="<?php echo $_GET['p']; ?>";
	var all="<?php echo $_GET['a']; ?>";
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
			document.getElementById("termination_list_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-termination.php?delcode="+delcode+"&personalid="+personalid+"&frmdt="+frmdt+"&todt="+todt+"&p="+page+"&a="+all,true);
	xmlhttp.send();
	}
}
</script>

<link type="text/css" rel="stylesheet" href="css/paging.css" />
</head>
<body oncontextmenu="return false;" onload="javascript:return termination_list('pload');">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">TERMINATION LIST</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="95%" class="form" cellpadding="0">
    
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Personal ID</td>
      <td align="left"><input type="text" name="PersonalID" id="PersonalID" style="width:142px;"/></td>
      <td align="left" colspan="2"></td>
    </tr>
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>From Date</td>
      <td align="left"><input type="text" name="fromdt" id="fromdt" maxlength="10" style="width:142px;"  /></td>
	  <td align="left"><span class="error">&nbsp;&nbsp;</span>To Date</td>
      <td align="left"><input type="text" name="todt" id="todt" maxlength="10" style="width:142px;" /></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="button" name="search" id="search" value="Search" class="button" onclick="javascript:return termination_list('search');" /></td>
    </tr>
    <tr><td colspan="2" align="left">&nbsp;</td></tr>
    <tr>
      <td align="center" colspan="4" id="termination_list_result">
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