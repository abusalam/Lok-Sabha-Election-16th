<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Training Attendance</title>
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
		document.getElementById("venue_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-training.php?sub_div="+str+"&opn=venue",true);
	xmlhttp.send();
}
function training_type_change()
{
	var venue=document.getElementById('training_venue').value;
	var training_type=document.getElementById('training_type').value;
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
		document.getElementById("dt_time").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-training.php?trn_type="+training_type+"&venue="+venue+"&opn=date_time",true);
	xmlhttp.send();
}
function trn_dt_time_change(str)
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
		document.getElementById("dynTable").innerHTML=xmlhttp.responseText;
		document.getElementById('submit_box').disabled=false;
		document.getElementById('fakecontainer').style.display= 'none';
		}
	  }
	xmlhttp.open("GET","ajax-training.php?sch="+str+"&opn=personnel",true);
	document.getElementById('fakecontainer').style.display = 'block';
	xmlhttp.send();
}

function validate()
{
	var subdivision=document.getElementById("Subdivision");
	var training_venue=document.getElementById("training_venue");
	var training_type=document.getElementById("training_type");
	var trn_dt_time=document.getElementById("trn_dt_time");

	if(subdivision.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("Subdivision").focus();
		return false;
	}
	//alert(pc.options.length);
	if(training_venue.value=="" || training_venue.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Training Venue";
		document.getElementById("training_venue").focus();
		return false;
	}
	if(training_type.value=="0" || training_type.value=="")
	{
		document.getElementById("msg").innerHTML="Select Training Type";
		document.getElementById("training_type").focus();
		return false;
	}
	if(trn_dt_time.value=="0" || trn_dt_time.value=="")
	{
		document.getElementById("msg").innerHTML="Select Training Date Time";
		document.getElementById("trn_dt_time").focus();
		return false;
	}
	
	/*var table=document.getElementById("dynTable");
	var rows = table.getElementsByTagName("tr").length;
	document.getElementById('hidRow').value=rows;*/
}

function validate1()
{
	var subdivision=document.getElementById("Subdivision");
	var training_venue=document.getElementById("training_venue");
	var training_type=document.getElementById("training_type");
	var trn_dt_time=document.getElementById("trn_dt_time");

	if(subdivision.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("Subdivision").focus();
		return false;
	}
	//alert(pc.options.length);
	if(training_venue.value=="" || training_venue.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Training Venue";
		document.getElementById("training_venue").focus();
		return false;
	}
	if(training_type.value=="0" || training_type.value=="")
	{
		document.getElementById("msg").innerHTML="Select Training Type";
		document.getElementById("training_type").focus();
		return false;
	}
	if(trn_dt_time.value=="0" || trn_dt_time.value=="")
	{
		document.getElementById("msg").innerHTML="Select Training Date Time";
		document.getElementById("trn_dt_time").focus();
		return false;
	}
}
</script>
</head>

<body>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/training_fun.php');
$action=isset($_REQUEST['submit_box'])?$_REQUEST['submit_box']:"";

$action1=isset($_REQUEST['submit1'])?$_REQUEST['submit1']:"";
if($action1=='Show Cause Letter Print')
{
	$sub=encode($_POST['Subdivision']);
	$t_venue=encode($_POST['training_venue']);
	$t_type=encode($_POST['training_type']);
	$trn_sch=isset($_POST['trn_dt_time'])?encode($_POST['trn_dt_time']):"";
	$memo_no=isset($_POST['memo_no'])?encode($_POST['memo_no']):"";
	$date=isset($_POST['date'])?encode($_POST['date']):"";
	$p_id="";
	?>
    <script>window.open("fpdf/show_cause_letter.php?sub=<?php echo $sub; ?>&t_venue=<?php echo $t_venue; ?>&t_type=<?php echo $t_type;?>&trn_sch=<?php echo $trn_sch;?>&p_id=<?php echo $p_id;?>&memo_no=<?php echo $memo_no;?>&date=<?php echo $date;?>");</script>
    <?php
}
if($action=='Save')
{
	$subdivision=isset($_REQUEST['Subdivision'])?$_REQUEST['Subdivision']:"";
	$training_venue=isset($_REQUEST['training_venue'])?$_REQUEST['training_venue']:"";
	$training_type=isset($_REQUEST['training_type'])?$_REQUEST['training_type']:"";
	$trn_dt_time=isset($_REQUEST['trn_dt_time'])?$_REQUEST['trn_dt_time']:"";
	//$usercd=$user_cd;
	//include_once('mail/sendmail.php');

	$status=0;	
	
	for($i=1;$i<=$_REQUEST['hidRow'];$i++)
	{
		$post_stst=isset($_REQUEST['chkbox'.$i])?$_REQUEST['chkbox'.$i]:"";
		if($post_stst=='on')
			$per_cd=$_REQUEST['hidId'.$i];
		else
			continue;
		$res=update_training_pp_attendance($per_cd,$trn_dt_time,'A');
		if($res==1)
		{
			$status++;
			if($per_cd!=''){
			$rs=fatch_PersonDetails($per_cd);
			$ra=getRows($rs);
			$name=$ra['officer_name'];
			$recipient=$ra['email'];
			$ph_no=$ra['mob_no'];
			
			//send_mail($recipient,$name);
			
			$Message=$name.", You have not attended the training program conducted for election duty.";
			//$mob_no = $ph_no;
		//	include('sms/Index.php');
			}
			unset($rs,$ra,$name,$recipient,$ph_no,$per_cd);
		}
	}
	if($status>0)
	{
		$msg="<div class='alert-success'>$status Record(s) saved successfully</div>";
		redirect("training-attendance.php?msg=success&rec=".$status);
	}
	else
	{
		$msg="<div class='alert-error'>No status changed</div>";
	}
}
?>
<?php
	/*include_once('function/training_fun.php');
	$subdiv_cd="0";
	if(isset($_SESSION['subdiv_cd']))
		$subdiv_cd=$_SESSION['subdiv_cd'];*/
		
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$rec=isset($_REQUEST['rec'])?$_REQUEST['rec']:"";
		$msg="<div class='alert-success'>$rec Record(s) saved successfully</div>";
	}
}
?>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr>
  <td align="center">TRAINING ATTENDANCE</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
    <table width="85%" class="form" cellpadding="0">
	<tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="18px" colspan="3" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
     <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td><td align="right"><strong>»</strong>&nbsp;<a href="per_id_wise_absent.php" class="k-button">Personnel Id Wise</a></td></tr>
    <tr><td colspan="3"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
	<tr>
	  <td align="left" width="30%"><span class="error">*</span>Subdivision</td>
	  <td align="left" width="40%"><select name="Subdivision" id="Subdivision" style="width:200px;" onchange="javascript:return subdivision_change(this.value);">
      						<option value="0">-Select Subdivision-</option>
                            <?php 	$districtcd=$dist_cd;
									$rsBn=fatch_Subdivision($districtcd);
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowSubDiv=getRows($rsBn);
											echo "<option value='$rowSubDiv[0]'>$rowSubDiv[2]</option>";
											$rowSubDiv=NULL;
										}
									}
									unset($rsBn,$num_rows,$rowSubDiv);
							?>
      				</select></td><td></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Training Venue</td>
      <td align="left" id="venue_result"><select name="training_venue" id="training_venue" style="width:200px;" onchange="return training_type_change();"></select></td>
      <td></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Training Type</td>
      <td align="left"><select name="training_type" id="training_type" style="width:200px;" onchange="javascript:return training_type_change();">
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
									$rowTrainingType=NULL;
                                }
                            }
                            unset($rsTrainingType,$num_rows,$rowTrainingType);
                        ?>
                        </select></td>
                        <td></td>
    </tr>
     <tr>
      <td align="left"><span class="error">*</span>Training Date and Time</td>
      <td align="left" id="dt_time"><select name="trn_dt_time" id="trn_dt_time" style="width:200px;" onchange="return trn_dt_time_change(this.value);"></select></td>
      <td></td>
    </tr>
    <tr>
      <td align="left">&nbsp;&nbsp;&nbsp;Memo No (For Show Cause Letter)</td>
      <td align="left"><input type="text" name="memo_no" style="width:192px;" /></td>
      <td></td>
    </tr>
    <tr>
      <td align="left">&nbsp;&nbsp;&nbsp;Date (For Show Cause Letter)</td>
      <td align="left"><input type="text" name="date" id="date" style="width:200px;" /></td>
      <td align="right"><input type="submit" name="submit_box" id="submit_box" value="Save" class="button" onclick="javascript:return validate();" disabled="disabled" />&nbsp;&nbsp;<input type="submit" name="submit1" id="submit1" value="Show Cause Letter Print" class="button" onclick="javascript:return validate1();" /></td>
    </tr>
	<tr>
      <td align="center" colspan="3" class="demo-section" valign="top">
      <table border="0" width="80%"><tr><td align="center" width="25%">Personnel ID</td><td align="left" width="65%">Name of Personnel</td><td align="center" width="10%">Absent</td><td>&nbsp;&nbsp;&nbsp;</td></tr>
      </table>
      <div class="scroller">
          <table border="0" width="80%" id="dynTable">
          
          </table>
      </div>
      </td>
    </tr>
    <tr><td colspan="3"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr>
      <td colspan="3" align="center"></td></tr>
      <tr><td colspan="3" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
<div id="calendar" style="width: 243px;display:none;"></div>  
<div id="fakecontainer" style="display:none;"><div id="loading">Please wait...</div></div>
</body>

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
			calendar.value($("#date").val());
		};

		$("#get").click(function() {
			alert(calendar.value());
		});

		$("#date").kendoDatePicker({
			change: setValue
		});


		$("#set").click(setValue);

		$("#direction").kendoDropDownList({
			change: navigate
		});

		$("#navigate").click(navigate);
	});
	</script>
</html>