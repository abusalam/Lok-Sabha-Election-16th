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
		}
	  }
	xmlhttp.open("GET","ajax-training.php?sch="+str+"&opn=personnel",true);
	xmlhttp.send();
}
function delete_row(r)
{
	var table=document.getElementById("dynTable");
	document.getElementById("dynTable").deleteRow(0);
	var rows = table.getElementsByTagName("tr").length;
	document.getElementById('hidRow').value=rows;
//var i = r.parentNode.parentNode.rowIndex;
//document.getElementById("dynTable").deleteRow(i);
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
	
	var table=document.getElementById("dynTable");
	var rows = table.getElementsByTagName("tr").length;
	document.getElementById('hidRow').value=rows;
}
function tab1_selected()
{
	document.getElementById('tab-page1').style.background="#fff";
	document.getElementById('tab-page1').style.paddingBottom="6px";
	document.getElementById('tab-page2').style='none';
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Submit')
{
	$subdivision=$_POST['Subdivision'];
	$training_venue=$_POST['training_venue'];
	$training_type=$_POST['training_type'];
	$trn_dt_time=$_POST['trn_dt_time'];

	$usercd=$user_cd;
	include_once('function/training_fun.php');
	//include_once('mail/sendmail.php');
	$status=0;
	for($i=1;$i<=$_POST['hidRow'];$i++)
	{
		$post_stst=isset($_POST['chkbox'.$i])?$_POST['chkbox'.$i]:"";
		if($post_stst=='on')
			$per_cd=$_POST['hidId'.$i];
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
			
			send_mail($recipient,$name);
			
			$Message=$name.", You have not attended the training program conducted for election duty.";
			$mob_no = $ph_no;
			include('sms/Index.php');
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
	include_once('function/training_fun.php');
	$subdiv_cd="0";
	if(isset($_SESSION['subdiv_cd']))
		$subdiv_cd=$_SESSION['subdiv_cd'];
		
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$rec=isset($_REQUEST['rec'])?$_REQUEST['rec']:"";
		$msg="<div class='alert-success'>$rec Record(s) saved successfully</div>";
	}
}
?>

<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr>
  <td align="center">TRAINING ATTENDANCE</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
    <table width="70%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
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
											$rowSubDiv=NULL;
										}
									}
									unset($rsBn,$num_rows,$rowSubDiv);
							?>
      				</select></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Training Venue</td>
      <td align="left" id="venue_result"><select name="training_venue" id="training_venue" style="width:200px;" onchange="return training_type_change();"></select></td>
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
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Training Date and Time</td>
      <td align="left" id="dt_time"><select name="trn_dt_time" id="trn_dt_time" style="width:200px;" onchange="return trn_dt_time_change(this.value);"></select></td>
    </tr>
	<tr>
      <td align="center" colspan="2" class="demo-section" valign="top">
      <table border="0" width="80%"><tr><td align="center" width="25%">Personnel ID</td><td align="left" width="65%">Name of Personnel</td><td align="center" width="10%">Absent</td><td>&nbsp;&nbsp;&nbsp;</td></tr>
      </table>
      <div class="scroller">
          <table border="0" width="80%" id="dynTable">
          
          </table>
      </div>
      </td>
    </tr><input type="hidden" id="hidRow" name="hidRow" value="0" />
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Submit" class="button" onclick="javascript:return validate();" /></td></tr>
      <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>