<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Training Allocation</title>
<?php
include('header/header.php');
?>
<?php
$subdiv_cd="0";
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
?>

<script type="text/javascript" language="javascript">
function chksetpollingperson_change()
{
	var totalno_pp=document.getElementById("hidno_pp").value;
	if(document.getElementById('chksetpollingperson').checked==true)
	{
		document.getElementById('no_pp').disabled=false;
		
	}
	else if(document.getElementById('chksetpollingperson').checked==false)	
	{
		document.getElementById('no_pp').value=totalno_pp;
		document.getElementById('no_pp').disabled=true;
		
	}
}
function venue_capacity(str)
{
	if (window.XMLHttpRequest)
	  {
	  xmlhttp=new XMLHttpRequest();
	  xmlhttp1=new XMLHttpRequest();
	  }
	else
	  {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("venue_capacity").innerHTML=xmlhttp.responseText;
		training_alloted(document.getElementById('training_type').value);
		}
	  }
	xmlhttp.open("GET","ajax-training.php?venue="+str+"&opn=venuecap",true);
	xmlhttp.send();
	
	xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
		document.getElementById('no_pp').value=xmlhttp1.responseText;
		document.getElementById('hidno_pp').value=xmlhttp1.responseText;
		}
	  }
	xmlhttp1.open("GET","ajax-training.php?venue="+str+"&opn=venuecap1",true);
	xmlhttp1.send();
	
}
function training_alloted()
{
	var training_venue=document.getElementById('training_venue').value;
	var training_type=document.getElementById('training_type').value;
	var training_dt=document.getElementById('training_dt').value;
	var training_time=document.getElementById('training_time').value;
	if (window.XMLHttpRequest)
	  {
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("training_alloted").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-training.php?tr_type="+training_type+"&training_venue="+training_venue+"&training_dt="+training_dt+"&training_time="+training_time+"&opn=trnalloted",true);
	xmlhttp.send();
	if(document.getElementById('post_status').selectedIndex>0)
	{
		member_available(document.getElementById('post_status').value);
	}
}
function area_detail(str)
{
	document.getElementById('post_status').selectedIndex=0;
	document.getElementById('member_available').innerHTML="";
	if (window.XMLHttpRequest)
	  {
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("area_of_preference").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-training.php?area="+str+"&subdivision=<?php print $subdiv_cd; ?>&opn=areadtl",true);
	xmlhttp.send();
}
function member_available(str)
{
	if(document.getElementById("area_pref").value!="0")
	{
		var areapref=document.getElementById("area_pref").value;
		var area=document.getElementById("area").value;
	}
	var training_type=document.getElementById("training_type").value;
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
	xmlhttpMA.open("GET","ajax-training.php?post_stat="+str+"&tr_type="+training_type+"&subdivision=<?php print $subdiv_cd; ?>&areapref="+areapref+"&area="+area+"&opn=membavl1",true);
	xmlhttpMA.send();
}

function validate()
{
	
	var training_venue=document.getElementById("training_venue").value;
	var training_type=document.getElementById("training_type").value;
	var area_pref=document.getElementById("area_pref").value;
	var training_dt=document.getElementById("training_dt").value;
	var training_time=document.getElementById("training_time").value;
	var post_status=document.getElementById("post_status").value;
	var no_pp=document.getElementById("no_pp").value;
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
	if(area_pref=="0")
	{
		document.getElementById("msg").innerHTML="Select Area of Preference";
		document.getElementById("area_pref").focus();
		return false;
	}
	if(area_pref!="0")
	{
		var area=document.getElementById("area").value;
		if(area=="")
		{
			document.getElementById("msg").innerHTML="Area is not available";
			document.getElementById("area").focus();
			return false;
		}
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
	if(post_status=="0")
	{
		document.getElementById("msg").innerHTML="Select Post Status";
		document.getElementById("post_status").focus();
		return false;
	}
	//if(document.getElementById('chksetpollingperson').checked==true)
	//{
		if(no_pp=="" || no_pp=="0")
		{
			document.getElementById("msg").innerHTML="Enter no of Polling Personnel";
			document.getElementById("no_pp").focus();
			return false;
		}
	//}
	//alert(no_pp);
	var v_Cap=document.getElementById("v_Cap").value;
	var trn_alloted=document.getElementById("trn_alloted").value;
	if(((+v_Cap)-(+trn_alloted))<no_pp)
	{
		document.getElementById("msg").innerHTML="Venue Seat is not available";
		document.getElementById("no_pp").focus();
		return false;
	}
	var memb_avl=document.getElementById('memb_avl').innerHTML;
	if((+memb_avl)<no_pp)
	{
		document.getElementById("msg").innerHTML="Member Seat is not available";
		document.getElementById("no_pp").focus();
		return false;
	}
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/training_fun.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Submit')
{
	$training_venue=$_POST['training_venue'];
	$training_type=$_POST['training_type'];
	$area_pref=$_POST['area_pref'];
	$training_dt=$_POST['training_dt'];
	$training_time=$_POST['training_time'];
	$post_status=$_POST['post_status'];
	$no_pp1=isset($_POST['no_pp'])?$_POST['no_pp']:"";
	$hidno_pp=$_POST['hidno_pp'];
	$no_pp=($no_pp1=="")?$hidno_pp:$no_pp1;
	//echo $no_pp;
	//exit();
	$usercd=$user_cd;
	
	$subdivision=0; $for_subdivision=0; $for_pc=0; $assembly_temp=0; $assembly_perm=0; $assembly_off=0; $choice_type=0; $choice_area=0;
	if($area_pref=='S')
		$choice_area=$_POST['area'];
	if($area_pref=='D')
		$choice_area=$_POST['area'];
	if($area_pref=='T')
		$choice_area=$_POST['area'];
	if($area_pref=='P')
		$choice_area=$_POST['area'];
	if($area_pref=='O')
		$choice_area=$_POST['area'];
		
		
	$choice_type=$area_pref;
	$schedule_cd;
	$rsmaxcode=fatch_schedule_maxcode($training_venue);
	$rowmaxcode=getRows($rsmaxcode);
	if($rowmaxcode['schedule_code']==null)
		$schedule_cd=$training_venue."001";
	else
		$schedule_cd=sprintf("%09d",$rowmaxcode['schedule_code']+1);
			
	$ret=save_training_schedule1($schedule_cd,$training_venue,$training_type,$training_dt,$training_time,$post_status,$no_pp,$usercd,$choice_type,$choice_area);
	if($ret==1)
	{
		$msg="<div class='alert-success'>Record saved successfully</div>";
		/*$rsTrainingPP=fatch_personnel_ag_training_pp($training_type,$post_status,$subdivision,$for_subdivision,$for_pc,$assembly_temp,$assembly_off,$assembly_perm,$no_pp);
		$num_rows=rowCount($rsTrainingPP);
		if($num_rows>0)
		{
			$rec=0;
			include_once('inc/commit_con.php');
			mysqli_autocommit($link,FALSE);
			$sql="update training_pp set training_sch=?, training_booked='Y', training_attended='P' where training_type=? and
	post_stat=? and per_code=?";
			$stmt = mysqli_prepare($link, $sql);
			for($i=0;$i<$num_rows;$i++)
			{
				$rowTrainingPP=getRows($rsTrainingPP);
				$person_cd=$rowTrainingPP['per_code'];
				//$returnVal=update_training_pp_ag_training_schedule($schedule_cd,$training_type,$post_status,$rowTrainingPP['per_code']);

				
				mysqli_stmt_bind_param($stmt, 'ssss', $schedule_cd,$training_type,$post_status,$person_cd);
				mysqli_stmt_execute($stmt);
				$rec+=mysqli_stmt_affected_rows($stmt);

				$rowTrainingVenue=null;
			}
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
}
?>
<script type="text/javascript" language="javascript">
function training_required()
{
	if (window.XMLHttpRequest)
	  {
	  xmlhttp=new XMLHttpRequest();
	  xmlhttp1=new XMLHttpRequest(); 
	  }
	else
	  {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {  
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("trng_req").innerHTML=xmlhttp.responseText;
		}
	  }	   
	xmlhttp.open("GET","ajax-training.php?subdiv=<?php print $subdiv_cd; ?>&opn=trnreq1",true);
	xmlhttp.send();
	
	xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
		document.getElementById("trng_alloted").innerHTML=xmlhttp1.responseText;
		}
	  }
	  //alert("ajax-training.php?subdiv="<?php /*?><?php print $subdiv_cd; ?><?php */?>);
	xmlhttp1.open("GET","ajax-training.php?subdiv=<?php print $subdiv_cd; ?>&opn=trnalloted_forsub1",true);
	xmlhttp1.send();
}
</script>
<body onload="javascript:return training_required();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $subdiv_name; ?> SUBDIVISION</td></tr>
<tr>
  <td align="center">TRAINING ALLOCATION</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="70%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    <tr><td align="left" colspan="2"><b>For Subdivision [<?php echo $subdiv_name; ?>] Training to be alloted:</b></td></tr>
    <tr><td align="left" colspan="2">
    	<table width="100%" id="trng_req" class="table2 demo-section" cellpadding="0" cellspacing="0" border="0"></table>
    </td></tr>
    <tr><td align="left" colspan="2"><b>For Subdivision [<?php echo $subdiv_name; ?>] Training is alloted:</b></td></tr>
    <tr><td align="left" colspan="2">
    	<table width="100%" id="trng_alloted" class="table2 demo-section" cellpadding="0" cellspacing="0" border="0"></table>
    </td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
	<tr>
	  <td align="left"><span class="error">*</span>Training Venue</td>
	  <td align="left" width="60%"><select name="training_venue" id="training_venue" style="width:220px;" onchange="javascript:return venue_capacity(this.value);">
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
					$rowTrainingVenue=NULL;
				}
			}
			unset($rowTrainingVenue,$num_rows);
		?>
	    </select>&nbsp;&nbsp;<span id="venue_capacity"></span></td></tr>
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
										$rowTrainingType=NULL;
									}
								}
								unset($rsTrainingType,$num_rows,$rowTrainingType);
							?>
      </select></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Area of Preference</td>
      <td align="left"><select name="area_pref" id="area_pref" style="width:220px;" onchange="javascript:return area_detail(this.value);">
		<option value="0">-Select Preference-</option>
        <option value="S">Subdivision of PP</option>
        <option value="D">Alloted Subdivision</option>
        <option value="T">Assembly of Temporary Address</option>
        <option value="P">Assembly of Permanent Address</option>
        <option value="O">Assembly of Office Address</option>
      </select></td></tr>
    <tr id="area_of_preference"></tr>
    <tr>
      <td align="left"><span class="error">*</span>Training Date</td>
      <td align="left"><input type="text" name="training_dt" id="training_dt" maxlength="10" style="width:220px;" onchange="javascript:return training_alloted();" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Training Time</td>
      <td align="left"><input type="text" name="training_time" id="training_time" maxlength="20" style="width:212px;" onchange="javascript:return training_alloted();" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Post Status</td>
      <td align="left"><select name="post_status" id="post_status" style="width:220px;" onchange="javascript:return member_available(this.value)">
    							<option value="0">-Select Post Status-</option>
								<?php 	
									$rsP=fatch_postingstatus();
									$num_rows=rowCount($rsP);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowP=getRows($rsP);
											echo "<option value='$rowP[0]'>$rowP[1]</option>\n";
											$rowP=NULL;
										}
									}
									unset($rsP,$num_rows,$rowP);
								?>
                            </select>&nbsp;&nbsp;<label id="member_available"><span id='memb_avl'></span></label></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>No of Polling Personnel</td>
      <td align="left"><input type="text" name="no_pp" id="no_pp" maxlength="10" style="width:212px;" onkeypress="javascript:return wholenumbersonly(event);" disabled='true'/>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="chksetpollingperson" name="chksetpollingperson" onclick="return chksetpollingperson_change();" />
      <input type="hidden" name="hidno_pp" id="hidno_pp" />
        <label for="chksetpollingperson" class="text_small">Change No</label></td>
    </tr>
    <tr id="trSubdiv" style="visibility:hidden;"><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr>
    <tr>
       <td colspan="2" align="center">
    	<table width="70%" id="training_alloted" class="table2 demo-section" cellpadding="0" cellspacing="0"></table>
       </td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Submit" class="button" onclick="javascript:return validate();" /></td></tr>
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