<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Office Report</title>
<?php
include('header/header.php');
?>
</head>
<body oncontextmenu="return false;">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">Office Checklist</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" action="reports/office-list.php" target="_blank">
	<table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <!--<tr>
      <td align="left">User ID</td>
      <td align="left"><select name="user" id="user"></select></td><td colspan="2">&nbsp;</td>
    </tr>-->
    <tr>
      <td align="left">From Date</td>
      <td align="left"><input type="text" name="frmdate" id="frmdate" style="width:130px;" /></td>
      <td align="left">To Date</td>
      <td align="left"><input type="text" name="todate" id="todate" style="width:130px;" /></td>
    </tr><input type="hidden" name="user" value="<?php echo $user_cd; ?>" />
    <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="10px" /></td></tr>
    <tr><td colspan="4" align="center"><input type="submit" name="search" id="search" value="Search" class="button" /></td></tr>
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