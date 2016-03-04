<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Personnel Report</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function subdivision_change(str)
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
		document.getElementById("office_result").innerHTML=xmlhttp.responseText;
		document.getElementById("load_result").innerHTML="";
		}
	  }
	xmlhttp.open("GET","ajax-appointment.php?sub_div="+str+"&opn=office",true);
	document.getElementById("load_result").innerHTML="<img src='images/loading1.gif' alt='' height='70px' width='70px' />";
	xmlhttp.send();
}
function validate()
{
	var subdivision=document.getElementById("subdivision");
	
	if(subdivision.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("subdivision").focus();
		return false;
	}
	//var office=document.getElementById("office");

	
	//alert(pc.options.length);
	/*if(office.value=="" || office.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Office";
		document.getElementById("office").focus();
		return false;
	}*/
	var txtfrom=document.getElementById('txtfrom');
		if(txtfrom.value=='')
		{
			document.getElementById('msg').innerHTML="Enter From";
			txtfrom.focus();
			return false;
		}
		var txtto=document.getElementById('txtto');
		if(txtto.value=='')
		{
			document.getElementById('msg').innerHTML="Enter To";
			txtto.focus();
			return false;
		}
}
</script>
<script type="text/javascript" language="javascript">
/*function validate()
{
	var officename=document.getElementById("officename").value;
	//alert(officename);
	if(officename=="")
	{
		document.getElementById("msg").innerHTML="Enter Office Code";
		document.getElementById("officename").focus();
		return false;
	}
}*/
</script>
</head>


<body oncontextmenu="return false;" >
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">Polling Personnel Checklist</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" action="fpdf/rpt1.php" target="_blank">
	<table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
     <tr>
      <td height="16px" colspan="4" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
     <tr>
      <td align="center" colspan="4"><div id="load_result"></div></td></tr>
	<tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td align="left" width="15%"><span class="error">*</span>Subdivision</td>
      <td align="left" width="35%"><select name="subdivision" id="subdivision" style="width:200px;" onchange="javascript:return subdivision_change(this.value);">
              <option value='0'>-Select Subdivision-</option>
      					<?php
						$districtcd=$dist_cd;
						$rsSubDiv=fatch_Subdivision($districtcd);
						$num_rows = rowCount($rsSubDiv);
						for($i=1;$i<=$num_rows;$i++)
						{
							$rowSubDiv=getRows($rsSubDiv);
							echo "<option value='$rowSubDiv[subdivisioncd]'>$rowSubDiv[subdivision]</option>";
							unset($rowSubDiv);
						}
						unset($num_rows,$rsSubDiv);
						?>
                        </select></td>
      <td align="left" width="15%"><span class="error">&nbsp;&nbsp;</span>Office</td>
      <td align="left" width="35%" id="office_result"><select name="office" id="office" style="width:240px;"></select></td>
    </tr>
  <!--  <tr>
      <td align="left"><span class="error">*</span>Office Code</td>
      <td align="left"><input type="text" name="officename" id="officename" style="width:122px;" onkeypress="javascript:return wholenumbersonly(event);" maxlength="10" /></td><td colspan="2">&nbsp;</td>
      <td align="left">User</td>
      <td align="left"><select name="user" id="user"></select></td>
    </tr>-->
   
    <tr>
      <td align="left">&nbsp;&nbsp; From Date</td>
      <td align="left"><input type="text" name="frmdate" id="frmdate" style="width:130px;" /></td>
      <td align="left">To Date</td>
      <td align="left"><input type="text" name="todate" id="todate" style="width:130px;" /></td>
    </tr>
     <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="10px" /></td></tr>
     <tr>

       <td colspan="4" align="center"><span class="error">*</span>Record(s)  Print (office)
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; From: &nbsp;<input type='text' name='txtfrom' id='txtfrom' style='width:50px;'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	To: &nbsp;<input type='text' name='txtto' id='txtto' style='width:50px;' /></td>
    </tr>
    <input type="hidden" name="user" value="<?php echo $user_cd; ?>" />
    <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="10px" /></td></tr>
    <tr><td colspan="4" align="center"><input type="submit" name="search" id="search" value="Search" class="button" onclick="javascript:return validate();" /></td></tr>
    <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    </table>
</form></td></tr>
</table></td></tr>
</table></div>
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
			calendar.value($("#frmdate").val());
			calendar.value($("#todate").val());
		};

		$("#get").click(function() {
			alert(calendar.value());
		});

		$("#frmdate").kendoDatePicker({
			change: setValue
		});
		$("#todate").kendoDatePicker({
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