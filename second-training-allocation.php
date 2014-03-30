<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Training</title>
<?php
include('header/header.php');
?>
<?php
$subdiv_cd="0";
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
?>
<script language="javascript" type="text/javascript">
function PC_change(str)
{
	var sub_div=document.getElementById('hid_subdiv').value;
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
		document.getElementById("assembly_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-appointment.php?pc="+str+"&sub_div="+sub_div+"&opn=assembly",true);
	xmlhttp.send();
}

function validate()
{
	var PC=document.getElementById("PC").value;
	var assembly=document.getElementById("assembly").value;
	var start_sl=document.getElementById("start_sl").value;
	var end_sl=document.getElementById("end_sl").value;
	var training_venue=document.getElementById("venue").value;
	var training_dt=document.getElementById("training_dt").value;
	var training_time=document.getElementById("training_time").value;	
	
	if(PC=="0")
	{
		document.getElementById("msg").innerHTML="Select PC";
		document.getElementById("PC").focus();
		return false;
	}
	if(assembly=="0")
	{
		document.getElementById("msg").innerHTML="Select Assembly";
		document.getElementById("assembly").focus();
		return false;
	}
	if(start_sl=="" || start_sl<1)
	{
		document.getElementById("msg").innerHTML="Enter Start Sl No";
		document.getElementById("start_sl").focus();
		return false;
	}
	if(end_sl=="" || end_sl<1)
	{
		document.getElementById("msg").innerHTML="Enter End Sl No";
		document.getElementById("end_sl").focus();
		return false;
	}
	if(+(start_sl)>=+(end_sl))
	{
		document.getElementById("msg").innerHTML="Enter Proper Range";
		document.getElementById("end_sl").focus();
		return false;
	}
	if(training_venue=="0")
	{
		document.getElementById("msg").innerHTML="Select Training Venue";
		document.getElementById("venue").focus();
		return false;
	}
	if(training_dt=="")
	{
		document.getElementById("msg").innerHTML="Enter Training Date";
		document.getElementById("training_dt").focus();
		return false;
	}
	if(training_time=="")
	{
		document.getElementById("msg").innerHTML="Enter Training Time";
		document.getElementById("training_time").focus();
		return false;
	}
}
</script>
</head>
<body>
<?php
include_once('function/training2_fun.php');
extract($_POST);
$submit=isset($_POST['submit'])?$_POST['submit']:"";
if($submit=="Submit")
{
	$forpc=isset($_POST['PC'])?$_POST['PC']:"";
	$assembly=isset($_POST['assembly'])?$_POST['assembly']:"";
	$party_reserve=isset($_POST['party_reserve'])?$_POST['party_reserve']:"";
	$start_sl=isset($_POST['start_sl'])?$_POST['start_sl']:"";
	$end_sl=isset($_POST['end_sl'])?$_POST['end_sl']:"";
	$training_venue=isset($_POST['venue'])?$_POST['venue']:"";
	$training_dt=isset($_POST['training_dt'])?$_POST['training_dt']:"";
	$training_time=isset($_POST['training_time'])?$_POST['training_time']:"";
	$usercd=$user_cd;
	
	$rsmaxcode=fatch_schedule2_maxcode($training_venue);
	$rowmaxcode=getRows($rsmaxcode);
	if($rowmaxcode['schedule_code']==null)
		$schedule_cd=$training_venue."001";
	else
		$schedule_cd=sprintf("%09d",$rowmaxcode['schedule_code']+1);
	$ret=save_training2_schedule($schedule_cd,$forpc,$assembly,$party_reserve,$start_sl,$end_sl,$training_venue,$training_dt,$training_time,$usercd);
	if($ret==1)
	{
		$rec=0;
		include_once('inc/commit_con.php');
		mysqli_autocommit($link,FALSE);
		$sql="update personnela set training2_sch=? where forassembly=? and forpc=? and booked=? and (groupid BETWEEN ? and ?)";
		$stmt = mysqli_prepare($link, $sql);
		
		mysqli_stmt_bind_param($stmt, 'ssssii', $schedule_cd,$assembly,$forpc,$party_reserve,$start_sl,$end_sl);
		mysqli_stmt_execute($stmt);
		$rec+=mysqli_stmt_affected_rows($stmt);
		
		if (!mysqli_commit($link)) {
		print("Transaction commit failed\n");
		exit();
		}
		else
		{
			$msg="<div class='alert-success'>$rec Record(s) saved successfully</div>";
		}
		mysqli_stmt_close($stmt);
		mysqli_close($link);
	}
}
?>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo isset($subdiv_name)?$subdiv_name." SUBDIVISION":""; ?></td></tr>
<tr><td align="center">SECOND TRAINING ALLOCATION</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
	<table width="95%" class="form" cellpadding="0">
    <tr><td align="center"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td height="18px" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr>
      <td align="center"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td align="right"><strong>»</strong>&nbsp;<a href="second-training-allocation-list.php" class="k-button">Second Training Allocation List</a></td>
    </tr>
    <tr><td align="center">
      <table width="55%">
        <tr><input type="hidden" id="hid_subdiv" value="<?php print $subdiv_cd; ?>" />
          <td align="left"><span class="error">*</span>Parliamentary Constituency</td>
          <td align="left"><select name="PC" id="PC" style="width:180px;" onchange="return PC_change(this.value);">
            <option value="0">-Select PC-</option>
            <?php 	
									$districtcd=$dist_cd;
									include_once('function/form_12_fun.php');
									$rsPC=fatch_PC_ag_dist($districtcd);
									$num_rows=rowCount($rsPC);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowPC=getRows($rsPC);
											echo "<option value='$rowPC[0]'>$rowPC[1]</option>\n";
											$rowPC=null;
										}
									}
									$rsPC=null;
									$num_rows=0;
							?>
          </select></td>
        </tr>
        <tr>
          <td align="left"><span class="error">*</span>Assembly Constituency</td>
          <td align="left" id="assembly_result"><select name="assembly" id="assembly" style="width:180px;"></select></td>
        </tr>
        <tr>
          <td align="left"><span class="error">*</span>Party / Reserve</td>
          <td align="left"><select name="party_reserve" id="party_reserve" style="width:180px;">
          				<option value="P">Party</option>
                        <option value="R">Reserve</option>
                        </select></td>
        </tr>
        <tr>
          <td align="left"><span class="error">*</span>Sl. No. Range</td>
          <td align="left"><input type="text" name="start_sl" id="start_sl" style="width:50px" />&nbsp;&nbsp;
          To: <input type="text" name="end_sl" id="end_sl" style="width:50px;" /></td>
        </tr>
        <tr>
          <td align="left"><span class="error">*</span>Venue</td>
          <td align="left"><select name="venue" id="venue" style="width:180px;">
          					<option value="0">-Select Training Venue-</option>
                            <?php 	
									$rsTrainingVenue=fatch_training_venue2_ag_subdiv('');
									$num_rows=rowCount($rsTrainingVenue);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowTrainingVenue=getRows($rsTrainingVenue);
											echo "<option value='$rowTrainingVenue[0]'>$rowTrainingVenue[1]</option>\n";
											$rowTrainingVenue=NULL;
										}
									}
									unset($rowTrainingVenue,$num_rows);
							?>
      					</select>
          </td>
        </tr>
        <tr>
          <td align="left"><span class="error">*</span>Training Date</td>
          <td align="left"><input type="text" name="training_dt" id="training_dt" maxlength="10" style="width:180px;" /></td>
        </tr>
        <tr>
          <td align="left"><span class="error">*</span>Training Time</td>
          <td align="left"><input type="text" name="training_time" id="training_time" maxlength="20" style="width:172px;" /></td>
        </tr>
        </table>  
       </td>
    </tr>
    <tr><td align="center"><img src="images/blank.gif" alt="" height="10px" /></td></tr>
    <tr><td align="center"><input type="submit" name="submit" id="submit" value="Submit" class="button" onclick="return validate();" /></td></tr>
    <tr><td align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
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