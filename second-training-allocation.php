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
			document.getElementById("assembly_result").innerHTML=xmlhttp.responseText;
			document.getElementById("party_reserve").value="0";
			document.getElementById("member_available").innerHTML="";
			}
		  }
		xmlhttp.open("GET","ajax-appointment.php?sub_div="+str+"&opn=assembly_sec",true);
		xmlhttp.send();
	
}
function member_available()
{

	var Subdivision=document.getElementById("Subdivision").value;
	var assembly=document.getElementById("assembly").value;
	var str=document.getElementById("party_reserve").value;
	if (window.XMLHttpRequest)
	  {
	  xmlhttpMA=new XMLHttpRequest();
	  }
	else
	  {
	  xmlhttpMA=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttpMA.onreadystatechange=function()
	  {
	  if (xmlhttpMA.readyState==4 && xmlhttpMA.status==200)
		{
		document.getElementById("member_available").innerHTML=xmlhttpMA.responseText;
		if(str==0)
			document.getElementById("member_available").innerHTML="";
		}
	  }
	xmlhttpMA.open("GET","ajax-training.php?party_reserve="+str+"&assm="+assembly+"&subdivision="+Subdivision+"&opn=membav_sectr",true);
	xmlhttpMA.send();
}
function validate()
{
	var Subdivision=document.getElementById("Subdivision").value;
	var assembly=document.getElementById("assembly").value;
	//var start_sl=document.getElementById("start_sl").value;
	//var end_sl=document.getElementById("end_sl").value;
	var training_venue=document.getElementById("venue").value;
	var party_reserve=document.getElementById("party_reserve").value;
	var no_pr=document.getElementById("no_pr").value;
	var training_dt=document.getElementById("training_dt").value;
	var training_time=document.getElementById("training_time").value;	
	
	if(Subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select For Subdivision";
		document.getElementById("Subdivision").focus();
		return false;
	}
	if(assembly=="0")
	{
		document.getElementById("msg").innerHTML="Select Assembly";
		document.getElementById("assembly").focus();
		return false;
	}
	if(party_reserve=="0")
	{
		document.getElementById("msg").innerHTML="Select Party / Reserve";
		document.getElementById("party_reserve").focus();
		return false;
	}
	if(no_pr=="")
	{
		document.getElementById("msg").innerHTML="Enter no. of Party / Reserve";
		document.getElementById("no_pr").focus();
		return false;
	}
	/*if(start_sl=="" || start_sl<1)
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
	}*/
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
	var memb_avl=document.getElementById('memb_avl').innerHTML;
	if((+memb_avl)<no_pr)
	{
		document.getElementById("msg").innerHTML="Record(s) not available";
		document.getElementById("no_pr").value="";
		document.getElementById("no_pr").focus();
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
	$forsub=isset($_POST['Subdivision'])?$_POST['Subdivision']:"";
	$assembly=isset($_POST['assembly'])?$_POST['assembly']:"";
	$party_reserve=isset($_POST['party_reserve'])?$_POST['party_reserve']:"";
	//$start_sl=isset($_POST['start_sl'])?$_POST['start_sl']:"";
	$no_pr=isset($_POST['no_pr'])?$_POST['no_pr']:"";
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
		
	
	$max_endsl=fatch_max_end_sl($forsub,$assembly,$party_reserve);
	if($max_endsl==null)
	{
	  $start_sl=1;
	  $end_sl=$no_pr;
	}
	else
	{
	  $start_sl=$max_endsl+1;
	  $end_sl=$max_endsl+$no_pr;
	}
	//$end_sl=0;
	
	$ret=save_training2_schedule($schedule_cd,$forpc,$forsub,$assembly,$party_reserve,$start_sl,$end_sl,$training_venue,$training_dt,$training_time,$usercd);
	
	/*$asm_array=fetch_Assembly_party_reserve_array($assembly,$forsub,$party_reserve);
			print_r($asm_array);
			//echo count($asm_array);
			if(count($asm_array)>1)
			{
				//update_Assembly_slno($assembly,$subdivision);
				$idx = 0;
				$to_cnt=count($asm_array);	
				$u_cnt=1;
				foreach ($asm_array as $key => $value)
				{
					$sum_pp=$value['es']+1;
					//echo $key;
					$idx = $key;
					//print_r ([$idx]['sl']) ;
					//$prev_sdcd=$asm_array[$idx -3]['sh_cd'];
					//echo $prev_sdcd;
					//echo $idx;
					 $next_sdcd=$asm_array[$idx +1]['sh_cd'];		
					if($to_cnt!=$u_cnt)
					{
					  update_next_party_startsl($sum_pp,$next_sdcd);
					  $u_cnt++;
					}
					else
					{
					   break;
					}
					
				}
			}*/
	
	//update_endsl_second_training($total_endsl,$schedule_cd);
	if($ret==1)
	{
		$msg="<div class='alert-success'>Record saved successfully</div>";
	}
	/*if($ret==1)
	{
		$rec=0;
		include_once('inc/commit_con.php');
		mysqli_autocommit($link,FALSE);
		$sql="update personnela set training2_sch=? where forassembly=? and forsubdivision=? and booked=? and (groupid BETWEEN ? and ?)";
		$stmt = mysqli_prepare($link, $sql);
		
		mysqli_stmt_bind_param($stmt, 'ssssii', $schedule_cd,$assembly,$forsub,$party_reserve,$start_sl,$end_sl);
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
	}*/
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
	<table width="80%" class="form" cellpadding="0">
    <tr><td align="center"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td height="18px" align="center"><?php  print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
  
    <tr>
      <td align="right"><strong>»</strong>&nbsp;<a href="second-training-allocation-list.php" class="k-button">Second Training Allocation List</a></td>
    </tr>
    <tr><td align="center">
      <table width="80%">
        <tr><input type="hidden" id="hid_subdiv" value="<?php print $subdiv_cd; ?>" />
	  <td align="left" width="35%"><span class="error">*</span>For Subdivision</td>
	  <td align="left" width="65%"><select name="Subdivision" id="Subdivision" style="width:180px;" onchange="javascript:return subdiv_change(this.value);">
      						<option value="0">-Select For Subdivision-</option>
                            <?php 	$districtcd=$dist_cd;
									$rsBn=fatch_Subdivision($districtcd);
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowSubDiv=getRows($rsBn);
											echo "<option value='$rowSubDiv[0]'>$rowSubDiv[2]</option>";
										}
									}
									$rsBn=null;
									$num_rows=0;
									$rowSubDiv=null;
							?>
      				</select></td>
        </tr>
        <tr>
          <td align="left"><span class="error">*</span>Assembly Constituency</td>
          <td align="left" id="assembly_result"><select name="assembly" id="assembly" style="width:180px;"></select></td>
        </tr>
        <tr>
          <td align="left"><span class="error">*</span>Party / Reserve</td>
          <td align="left"><select name="party_reserve" id="party_reserve" style="width:180px;" onchange="javascript:return member_available()" >
                        <option value="0">-Select-</option>
          				<option value="P">Party</option>
                        <option value="R">Reserve</option>
                        </select>&nbsp;&nbsp;<label id="member_available"><span id='memb_avl'></span></label></td>
        </tr>
      <!--  <tr>
          <td align="left"><span class="error">*</span>Sl. No. Range</td>
          <td align="left"><input type="text" name="start_sl" id="start_sl" style="width:50px" />&nbsp;&nbsp;
          To: <input type="text" name="end_sl" id="end_sl" style="width:50px;" /></td>
        </tr>-->
         <tr>
          <td align="left"><span class="error">*</span>No. of Party / Reserve</td>
          <td align="left"><input type="text" name="no_pr" id="no_pr" style="width:172px" /></td>
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