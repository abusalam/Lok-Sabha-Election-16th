<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>First Appointment Letter</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function subdivision_change(str)
{
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  xmlhttp1=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("office_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-appointment.php?sub_div="+str+"&opn=office",true);
	xmlhttp.send();

	xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
	
		document.getElementById("dynList").innerHTML=xmlhttp1.responseText;
		if(document.getElementById('office').length>=1)
	{
		document.getElementById('chkAll').disabled=false;
	}
	else
	{
		document.getElementById('chkAll').disabled=true;
		document.getElementById('chkAll').checked=false;
	}
		}
	  }
	xmlhttp1.open("GET","ajax-appointment.php?sub_div="+str+"&opn=personnel",true);
	xmlhttp1.send();
}
function office_change(str)
{
	var sub_div=document.getElementById('Subdivision').value;
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
		document.getElementById("dynList").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-appointment.php?office="+str+"&sub_div="+sub_div+"&opn=personnel",true);
	xmlhttp.send();
	if(document.getElementById('office').length>0)
	{
		document.getElementById('chkAll').disabled=false;
	}
	else
	{
		document.getElementById('chkAll').disabled=true;
		document.getElementById('chkAll').checked=false;
	}
}
function check_change()
{
	var List=document.getElementById("dynList");
	var rec = (List.getElementsByTagName("input").length)/2;
	document.getElementById('hidRec').value=rec;
	for( var i=1;i<=rec;i++)
	{
		document.getElementById('chkbox'+i).checked=document.getElementById('chkAll').checked;
	}
}
function validate()
{
//	var subdivision=document.getElementById("Subdivision");
//	var office=document.getElementById("office");
//
//	if(subdivision.value=="0")
//	{
//		document.getElementById("msg").innerHTML="Select Subdivision";
//		document.getElementById("Subdivision").focus();
//		return false;
//	}
//
//	var List=document.getElementById("dynList");
//	var rec = (List.getElementsByTagName("input").length)/2;
//	document.getElementById('hidRec').value=rec;

	var p_id=document.getElementById("p_id");
	if(p_id.value=="")
	{
		document.getElementById("msg").innerHTML="Enter Personnel ID";
		document.getElementById("p_id").focus();
		return false;
	}
}
</script>
</head>
<?php
include_once('inc\db_trans.inc.php');
$action=$_REQUEST['submit'];
if($action=='Submit')
{
	//$subdivision=$_POST['Subdivision'];
	$per_cd=$_POST['p_id'];
	$usercd=$user_cd;
	include_once('function\appointment_fun.php');

	delete_temp_app_letter($usercd);
	$count=0;
	include_once('inc\commit_con.php');
	mysqli_autocommit($link,FALSE);
	$sql="insert into tmp_app_let (per_code,usercode) values (?,?)";
	$stmt = mysqli_prepare($link, $sql);
//	for($i=1;$i<=$_POST['hidRec'];$i++)
//	{
//		$chkbox=$_POST['chkbox'.$i];
//		if($chkbox=='on')
//		{
//			$per_cd=$_POST['hidId'.$i];
			//$res=add_temp_app_letter($per_cd,$usercd);
			mysqli_stmt_bind_param($stmt, 'si', $per_cd,$usercd);
			mysqli_stmt_execute($stmt);
//		}
//		else
//		{
//			$count++;
//		}
//	}
	if (!mysqli_commit($link)) {
		print("Transaction commit failed\n");
		exit();
	}
	mysqli_stmt_close($stmt);
	mysqli_close($link);
	if($count<($i-1))
	{
?>
<script>
window.open("reports/training-app-letter.php");
</script>
<?php
	}
	else
	{
		$msg="<div class='alert-error'>No person selected for appintment letter issue</div>";
	}
}
?>
<?php
	include_once('function\training_fun.php');
	$subdiv_cd="0";
	if(isset($_SESSION['subdiv_cd']))
		$subdiv_cd=$_SESSION['subdiv_cd'];
?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $_SESSION[subdiv_name]; ?> SUBDIVISION</td></tr>
<tr>
  <td align="center">FIRST APPOINTMENT LETTER ISSUE</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
    <table width="60%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print $msg; ?><span id="msg" class="error"></span></td></tr>
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
	<!--<tr>
	  <td align="left"><span class="error">*</span>Subdivision</td>
	  <td align="left"><select name="Subdivision" id="Subdivision" style="width:240px;" onchange="javascript:return subdivision_change(this.value);">
      						<option value="0">-Select Subdivision-</option>
                            <?php /*?><?php 	$districtcd=$dist_cd;
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
							?><?php */?>
      				</select></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Office</td>
      <td align="left" id="office_result"><select name="office" id="office" style="width:240px;" onchange="return office_change(this.value);"></select></td>
    </tr>
    <tr>
      <td align="left" valign="top"><span class="error">*</span>Personnel</td>
      <td align="left" valign="top">
      <div class="scroller" style="width:235px; height: 200px;">
      <input type="checkbox" id="chkAll" name="chkAll" onchange="return check_change();" disabled="disabled" /><label for="chkAll">Select All</label>
          <div id="dynList"></div>
      </div>
      </td>
    </tr>
	<input type="hidden" id="hidRec" name="hidRec" value="0" />-->
    <tr><td align="left">Personnel ID</td>
    	<td align="left"><input type="text" name="p_id" id="p_id" /></td>
    </tr>
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