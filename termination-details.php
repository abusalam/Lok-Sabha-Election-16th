<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Termination Details</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function fatch_Personaldtl(str)
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
		document.getElementById("Personal_details").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajaxfun.php?PersonalCd="+str,true);
	xmlhttp.send();
}

function validate()
{
	var PersonalID=document.getElementById("PersonalID").value;
	var TerminationCause=document.getElementById("TerminationCause").value;
	var DateofTermination=document.getElementById("DateofTermination").value;
	
	if(PersonalID=="")
	{
		document.getElementById("msg").innerHTML="Enter Personal ID";
		document.getElementById("PersonalID").focus();
		return false;
	}
	if(TerminationCause=="")
	{
		document.getElementById("msg").innerHTML="Declare cause of Termination";
		document.getElementById("TerminationCause").focus();
		return false;
	}
	if(DateofTermination=="")
	{
		document.getElementById("msg").innerHTML="Enter Date of Termination";
		document.getElementById("DateofTermination").focus();
		return false;
	}	
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Save')
{
	$PersonalID=$_POST['PersonalID'];
	$TerminationCause=$_POST['TerminationCause'];
	$DateofTermination=$_POST['DateofTermination'];
	$Remarks=$_POST['Remarks'];
	$usercd=$user_cd;
    $ter_id=$_POST['hid_termination_code'];
	include_once('function/add_fun.php');
	$cnt=check_duplicate_personnelid($PersonalID,$ter_id);
	if($cnt==0)
	{
		if(isset($_REQUEST['ter_id']))
		{
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_Termination($ter_id,$PersonalID,$TerminationCause,$DateofTermination,$Remarks,$usercd,$posted_date);
			if($ret==1)
			{
				redirect("termination-details.php?msg=success");
			}
		}
		else
		{
			$ret=save_Termination($ter_id,$PersonalID,$TerminationCause,$DateofTermination,$Remarks,$usercd);
		}
		if($ret==1)
		{
			$msg="<div class='alert-success'>Record added successfully</div>";
		}
	}
	else
	{
		$msg="<div class='alert-error'>Already Terminated</div>";
	}
	$rsmaxcode=null;
	$rowmaxcode=null;

}
?>
<?php
if(isset($_REQUEST['ter_id']))
{
	$termination_id=decode($_REQUEST['ter_id']);

	$rsTermination=Termination_details($termination_id);
	$rowTermination=getRows($rsTermination);
}
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$msg="<div class='alert-success'>Record updated successfully</div>";
	}
}
?>
<script language="javascript" type="text/javascript">
function bind_all()
{
	var hid_termination_code=document.getElementById('hid_termination_code');
	hid_termination_code.value="<?php echo $rowTermination['termination_id']; ?>";
	
	var PersonalID=document.getElementById('PersonalID');
	PersonalID.value="<?php echo $rowTermination['personal_id']; ?>";
	var Personaldtl=document.getElementById('Personal_details');
	<?php
	if($rowTermination['office']!="" && $rowTermination['off_desg']!="") { ?>
		Personaldtl.innerHTML="<?php echo "<label class='text_small'><b>Employee Name: </b>".$rowTermination['officer_name']."<br/> <b>Name of Office: </b>".$rowTermination['office']." <b>Desig. of O/C: </b>".$rowTermination['designation']."<br/> <b>Present Address: </b>".$rowTermination['present_addr1']." <b>; </b>".$rowTermination['present_addr1']."<br/><b>Present Assembly: </b>".$rowTermination['assembly_temp']." <b>Permanent Assembly: </b>".$rowTermination['assembly_perm']." <b>Place of Posting: </b>".$rowTermination['assembly_off']."</label>"; ?>";
		<?php } ?>
	//fatch_Personaldtl(PersonalID);
	var TerminationCause=document.getElementById('TerminationCause');
	TerminationCause.value="<?php echo $rowTermination['termination_cause']; ?>";
	var DateofTermination=document.getElementById('DateofTermination');
	DateofTermination.value="<?php echo $rowTermination['termination_date']; ?>";
	var Remarks=document.getElementById('Remarks');
	Remarks.value="<?php echo $rowTermination['remarks']; ?>";
}
</script>
<body oncontextmenu="return false;" onload="javascript: bind_all();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">TERMINATION DETAILS</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" >
  <table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="4" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Personal ID</td>
      <td align="left"><input type="text" name="PersonalID" id="PersonalID" style="width:142px;" onchange="fatch_Personaldtl(this.value)" /></td>
      <td align="left" colspan="2"></td>
    </tr>

    <tr><td colspan="2" align="left"><b>Personal Details</b></td></tr>
    <TR><TD style="height: 1px; background-color: #0066CC; color: #FFFFFF; font-weight:bold;" align=center colSpan=4></TD></TR>

    <tr>
       <td align="left" colspan="4" valign="top" height="95px"><span id="Personal_details"></span></td>
    </tr>
    
    <TR><TD style="height: 1px; background-color: #0066CC; color: #FFFFFF; font-weight:bold;" align=center colSpan=4></TD></TR>

      <tr><td colspan="2" align="left"><b>Termination Details</b></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Cause of Termination</td>
      <td align="left"><input type="text" name="TerminationCause" id="TerminationCause" style="width:250px;" onblur="return email_valid();" />
        </td>
     <td align="left"><span class="error">*</span>Date of Termination</td>
      <td align="left"><input type="text" name="DateofTermination" id="DateofTermination" maxlength="10" style="width:120px;" /></td>
    </tr>
  
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Remarks</td>
      <td align="left"><input type="text" name="Remarks" id="Remarks" style="width:250px;" /></td>
      <input type="hidden" id="hid_termination_code" name="hid_termination_code" />
    </tr>
   
    <tr>
      <td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr><td colspan="4"><img src="images/blank.gif" alt="" width="5px" /></td></tr>
  </table>
</form>
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
			calendar.value($("#DateofTermination").val());
		};

		$("#get").click(function() {
			alert(calendar.value());
		});

		$("#DateofTermination").kendoDatePicker({
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