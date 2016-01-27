<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Office Wise PP</title>
<?php
include('header/header.php');
?>
<?php
$subdiv_cd="0";
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
?>

<script type="text/javascript" language="javascript">
var ddlText, ddlValue, ddl, lblMesg;
    function CacheItems() {
        ddlText = new Array();
        ddlValue = new Array();
        ddl = document.getElementById("office");
        //lblMesg = document.getElementById("<%=lblMessage.ClientID%>");
        for (var i = 0; i < ddl.options.length; i++) {
            ddlText[ddlText.length] = ddl.options[i].text;
            ddlValue[ddlValue.length] = ddl.options[i].value;
        }
    }
    window.onload = CacheItems;
    function FilterItems(value) {
        ddl.options.length = 0;
        for (var i = 0; i < ddlText.length; i++) {
            if (ddlText[i].toLowerCase().indexOf(value) != -1) {
                AddItem(ddlText[i], ddlValue[i]);
            }
        }
    }
    function AddItem(text, value) {
        var opt = document.createElement("option");
        opt.text = text;
        opt.value = value;
        ddl.options.add(opt);
    }
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/training_fun.php');
?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $subdiv_name; ?> SUBDIVISION</td></tr>
<tr>
  <td align="center">OFFICE WISE POLLING PERSONNEL</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" action="fpdf/office-wise-personnel.php" target="_blank">
<table width="50%" class="form" cellpadding="0">
<input type="hidden" id="hid_subdiv"  name="hid_subdiv" value="<?php print $subdiv_cd; ?>" />
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    <tr>
      <td align="center">&nbsp;</td><td align="left"><input type="text" name="ofc_ser" id="ofc_ser" onkeyup="return FilterItems(this.value);" maxlength="10" /></td>
    </tr>
	<tr>
	  <td align="left"><span class="error">*</span>Office</td>
	  <td align="left" width="60%"><select name="office" id="office" style="width:220px;">
	    <option value="0">-Select Office-</option>
		<?php 	$sub_div=$subdiv_cd;
				$rsOc=fatch_officecode($sub_div);
				$num_rows=rowCount($rsOc);
				if($num_rows>0)
				{
					for($i=1;$i<=$num_rows;$i++)
					{
						$rowOc=getRows($rsOc);
						echo "<option value='$rowOc[0]'>$rowOc[0]</option>\n";
					}
				}
				$rsOc=null;
				$num_rows=0;
				$rowOc=null;
		?>
	    </select></td></tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Submit" class="button"  /></td></tr>
      <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table></form>
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
			calendar.value($("#training_dt").val());
		};

		$("#get").click(function() {
			alert(calendar.value());
		});

		$("#training_dt").kendoDatePicker({
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