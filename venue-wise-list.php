<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Venue Wise List</title>
<?php
include('header/header.php');
?>
<?php
$subdiv_cd="0";
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
?>

<script type="text/javascript" language="javascript">
function validate()
{
	
	var training_venue=document.getElementById("training_venue").value;
	var training_type=document.getElementById("training_type").value;
	
	if(training_venue=="0")
	{
		document.getElementById("msg").innerHTML="Select Training Venue";
		document.getElementById("training_venue").focus();
		return false;
	}
	if(training_type=="0")
	{
		document.getElementById("msg").innerHTML="Select Training Type";
		document.getElementById("training_type").focus();
		return false;
	}
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
<tr><td align="center"><?php echo $subdiv_name." SUBDIVISION"; ?></td></tr>
<tr>
  <td align="center">VENUE WISE LIST</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" action="fpdf/venue-wise-attendance.php" target="_blank">
<table width="70%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
	<tr>
	  <td align="left"><span class="error">*</span>Training Venue</td>
	  <td align="left" width="60%"><select name="training_venue" id="training_venue" style="width:220px;">
	    <option value="0">-Select Training Venue-</option>
		<?php
			$rsTrainingVenue=fatch_training_venue_ag_subdiv($subdiv_cd);
			$num_rows=rowCount($rsTrainingVenue);
			if($num_rows>0)
			{
				for($i=1;$i<=$num_rows;$i++)
				{
					$rowTrainingVenue=getRows($rsTrainingVenue);
					echo "<option value='$rowTrainingVenue[0]'>$rowTrainingVenue[1]</option>\n";
					$rowTrainingVenue=null;
				}
			}
			$rowTrainingVenue=null;
			$num_rows=0;
		?>
	    </select></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Training Type</td>
      <td align="left"><select name="training_type" id="training_type" style="width:220px;">
		<option value="0">-Select Training Type-</option>
                            <?php
								$rsTrainingType=fatch_training_type('');
								$num_rows=rowCount($rsTrainingType);
								if($num_rows>0)
								{
									for($i=1;$i<=$num_rows;$i++)
									{
										$rowTrainingType=getRows($rsTrainingType);
										echo "<option value='$rowTrainingType[0]' >$rowTrainingType[1]</option>\n";
									}
								}
								$rsTrainingType=null;
								$num_rows=0;
								$rowTrainingType=null;
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
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Submit" class="button"  onclick="javascript:return validate();"/></td></tr>
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