<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DCRC Master</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function subdivision_change(str)
{
	<?php	if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	{	?>
	document.getElementById("msg").innerHTML="Subdivision can't change while modify";
	load_data();
	return false;
	<?php
	}
	?>
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
	  
	xmlhttp.open("GET","ajax-master.php?sub_div="+str+"&opn=assembly",true);
	xmlhttp.send();
}
function assembly_change()
{
	<?php	if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	{	?>
	document.getElementById("msg").innerHTML="Assembly can't change while modify";
	load_data();
	return false;
	<?php
	}
	?>
}

function validate()
{
	var subdivision=document.getElementById("Subdivision");
	var assembly=document.getElementById("assembly");
	var member=document.getElementById("member");
	var party_req=document.getElementById("party_req");
	var dc_venue=document.getElementById("dc_venue");
	var dc_address=document.getElementById("dc_address");
	var dc_date=document.getElementById("dc_date");
	var dc_time=document.getElementById("dc_time");
	var rc_venue=document.getElementById("rc_venue");
	if(subdivision.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		subdivision.focus();
		return false;
	}
	if(assembly.value=="0" || assembly.value=="")
	{
		document.getElementById("msg").innerHTML="Select Assembly";
		assembly.focus();
		return false;
	}
	if(member.value=="0" || member.value=="")
	{
		document.getElementById("msg").innerHTML="Enter no of member";
		member.focus();
		return false;
	}
	if(party_req.value=="0" || party_req.value=="")
	{
		document.getElementById("msg").innerHTML="Enter no of party require";
		party_req.focus();
		return false;
	}
	
	if(dc_venue.value=="")
	{
		document.getElementById("msg").innerHTML="Enter DC venue";
		dc_venue.focus();
		return false;
	}
	if(dc_address.value=="")
	{
		document.getElementById("msg").innerHTML="Enter DC address";
		dc_address.focus();
		return false;
	}
	if(dc_date.value=="")
	{
		document.getElementById("msg").innerHTML="Enter DC Date";
		dc_date.focus();
		return false;
	}
	if(dc_time.value=="")
	{
		document.getElementById("msg").innerHTML="Enter DC time";
		dc_time.focus();
		return false;
	}
	if(rc_venue.value=="")
	{
		document.getElementById("msg").innerHTML="Enter RC venue";
		rc_venue.focus();
		return false;
	}
}
</script>
</head>
<?php
include_once('inc\db_trans.inc.php');
include_once('function\master_fun.php');
$action=$_REQUEST['submit'];
if($action=='Submit')
{
	$subdivision=$_POST['Subdivision'];
	$assembly=$_POST['assembly'];
	$member=$_POST['member'];
	$party_req=$_POST['party_req'];
	$dc_venue=$_POST['dc_venue'];
	$dc_address=$_POST['dc_address'];
	$dc_date=$_POST['dc_date'];
	$dc_time=$_POST['dc_time'];
	$rc_venue=$_POST['rc_venue'];
	
	// Getting DCRC code
	//if($subdivision_code=='')
	{
		$rsmaxcode=fatch_dcrc_maxcode($subdivision);
		$rowmaxcode=getRows($rsmaxcode);
		if($rowmaxcode['dcrc_cd']==null)
			$dcrc_code=$subdivision."01";
		else
			$dcrc_code=sprintf("%06d",$rowmaxcode['dcrc_cd']+1);
	}
	
	$usercd=$user_cd;
	
	$rsPC=fatch_pc_ag_assembly($assembly);
	if(rowCount($rsPC)>0)
	{
		$rowPC=getRows($rsPC);
		$pc=$rowPC['pccd'];
	}
	else
	{
		$pc='0';
	}

//	if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
//	{
//		$poststat=$_POST['posting_status0'];
//		$no_or_pc=$_POST['per_num0'];
//		$numb=$_POST['numb0'];
//		$res=update_reserve($assembly,$member,$poststat,$no_or_pc,$numb,$usercd);
//		if($res==1)
//			$msg="<div class='alert-success'>Record updated successfully</div>";
//	}
//	else
	{
		//$dup_check=duplicate_Assembly_party($assembly,$member);
		//if($dup_check==0)
		{
			$ret=save_dcrc_master($dcrc_code,$subdivision,$assembly,$member,$dc_venue,$dc_address,$rc_venue,$dist_cd,$usercd);
			if($ret==1)
			{
				$res=save_dcrc_party($assembly,$member,$party_req,$dcrc_code,$subdivision,$pc,$dc_date,$dc_time,$usercd);
				if($res==1)
				{
					$msg="<div class='alert-success'>Record saved successfully</div>";
				}
			}
		}
		//else
		//{
		//	$msg="<div class='alert-error'>Assembly party already exists</div>";
		//}
	}
}
?>
<?php
	include_once('function\training_fun.php');
	$subdiv_cd="0";
	if(isset($_SESSION['subdiv_cd']))
		$subdiv_cd=$_SESSION['subdiv_cd'];

	$rsSelectedPP=fatch_no_of_PP_selected($subdiv_cd);
	$num_rows_SelectedPP=rowCount($rsSelectedPP);
	if($num_rows_SelectedPP>0)
	{
		for($i=0;$i<$num_rows_SelectedPP;$i++)
		{
			$rowSelectedPP=getRows($rsSelectedPP);
			$tr_type[$i]=$rowSelectedPP['training_desc'];
			$post_stat[$i]=$rowSelectedPP['poststatus'];
			$total[$i]=$rowSelectedPP['total'];
			$rowSelectedPP=null;
		}
	}
	$rsSelectedPP=null;
?>
<?php
if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
{
	$assembly=decode($_REQUEST['assembly']);
	$noofparty=decode($_REQUEST['noofparty']);
	$poststat=decode($_REQUEST['poststat']);
	
	$rsAP=fatch_assembly_party_details($assembly,$noofparty,$poststat);
	$rowAP=getRows($rsAP);
	$subdiv_ed=$rowAP['subdivisioncd'];
	$pc_ed=$rowAP['pccd'];
}
?>
<script language="javascript" type="text/javascript">
function load_data()
{
	<?php	if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	{	?>
		var subdivision=document.getElementById('Subdivision');
		for (var i = 0; i < subdivision.options.length; i++) 
		{
			if (subdivision.options[i].value == "<?php echo $subdiv_ed; ?>")
			{
				subdivision.options[i].selected = true;
			}
		}

		var pc=document.getElementById('pc');
		pc.value="<?php echo $rowAP['pccd']; ?>";
		var assembly=document.getElementById('assembly');
		assembly.value="<?php echo $rowAP['assemblycd']; ?>";
		
		var member=document.getElementById('member');
		member.value="<?php echo $rowAP['no_of_member']; ?>";
		member.readOnly=true;
		var party_req=document.getElementById('party_req');
		party_req.value="<?php echo $rowAP['no_party']; ?>";
		party_req.readOnly=true;
		var posting_status=document.getElementById('posting_status0');
		posting_status.value="<?php echo $rowAP['poststat']; ?>";
		var per_num=document.getElementById('per_num0');
		per_num.value="<?php echo $rowAP['no_or_pc']; ?>";
		var numb=document.getElementById('numb0');
		numb.value="<?php echo $rowAP['numb']; ?>";
<?php } ?>
	
}
</script>
<body onload="return load_data();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr>
  <td align="center">DCRC Master</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="70%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print $msg; ?><span id="msg" class="error"></span></td></tr>
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
	<tr>
	  <td align="left"><span class="error">*</span>Subdivision</td>
	  <td align="left"><select name="Subdivision" id="Subdivision" style="width:200px;" onchange="javascript:return subdivision_change(this.value);">
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
										}
									}
									$rsBn=null;
									$num_rows=0;
									$rowSubDiv=null;
							?>
      				</select></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Assembly</td>
      <td align="left" id="assembly_result"><select name="assembly" id="assembly" style="width:200px;" onchange="return assembly_change();">
      <?php
	  if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	  {
	  	$rsAssembly=fatch_assembly($subdiv_ed);
		$num_rows=rowCount($rsAssembly);
		if($num_rows>0)
		{
			echo "<option value='0'>-Select Assembly-</option>\n";
			for($i=1;$i<=$num_rows;$i++)
			{
				$rowAssembly=getRows($rsAssembly);
				echo "<option value='$rowAssembly[assemblycd]'>$rowAssembly[assemblyname]</option>\n";
				$rowAssembly=NULL;
			}
		}
		unset($num_rows,$rsAssembly);
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>No of Member</td>
      <td align="left"><input type='text' name="member" id="member" maxlength="3" style="width:192px;" onkeypress="javascript:return wholenumbersonly(event);" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>No of Party</td>
      <td align="left"><input type='text' name="party_req" id="party_req" maxlength="4" style="width:192px;" onkeypress="javascript:return wholenumbersonly(event);" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>DC Venue</td>
      <td align="left"><input type='text' name="dc_venue" id="dc_venue" maxlength="45" style="width:192px;" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>DC Address</td>
      <td align="left"><input type='text' name="dc_address" id="dc_address" maxlength="45" style="width:192px;" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>DC Date</td>
      <td align="left"><input type='text' name="dc_date" id="dc_date" maxlength="10" style="width:200px;" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>DC Time</td>
      <td align="left"><input type='text' name="dc_time" id="dc_time" maxlength="15" style="width:192px;" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>RC Venue</td>
      <td align="left"><input type='text' name="rc_venue" id="rc_venue" maxlength="45" style="width:192px;" /></td>
    </tr>
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
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
			calendar.value($("#dc_date").val());
		};

		$("#get").click(function() {
			alert(calendar.value());
		});

		$("#dc_date").kendoDatePicker({
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