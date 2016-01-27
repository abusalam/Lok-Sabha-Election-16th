<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Form 12 Application</title>
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
		document.getElementById("office_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-form12.php?sub_div="+str+"&opn=office",true);
	xmlhttp.send();
}
function office_change(str)
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
		document.getElementById("personnel_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-form12.php?office="+str+"&opn=personnel",true);
	xmlhttp.send();
}
function personnel_change(str)
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
		document.getElementById("personnel_details").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-form12.php?personcd="+str+"&opn=per_dtl",true);
	xmlhttp.send();
}
function epic_change(str)
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
		document.getElementById("personnel_details").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-form12.php?epic="+str+"&opn=per_dtl",true);
	xmlhttp.send();
}
function validate()
{
	var subdivision=document.getElementById("subdivision");
	var office=document.getElementById("office");
	var personnel=document.getElementById("personnel");
	var epic=document.getElementById("epic");
	//var pc=document.getElementById("pc");
	var ed_pb=document.getElementById("ed_pb");
	if(epic.value=="")
	{
		if(subdivision.value=="0")
		{
			document.getElementById("msg").innerHTML="Select Subdivision";
			document.getElementById("subdivision").focus();
			return false;
		}
		//alert(pc.options.length);
		if(office.value=="" || office.value=="0")
		{
			document.getElementById("msg").innerHTML="Select Office";
			document.getElementById("office").focus();
			return false;
		}
		if(personnel.value=="" || personnel.value=="0")
		{
			document.getElementById("msg").innerHTML="Select Personnel";
			document.getElementById("personnel").focus();
			return false;
		}
	}
	
	//if(pc.value=="0")
//	{
//		document.getElementById("msg").innerHTML="Select Applying From";
//		document.getElementById("pc").focus();
//		return false;
//	}
	if(ed_pb.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Type";
		document.getElementById("ed_pb").focus();
		return false;
	}
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Submit')
{
	$personnel=$_POST['hid_per_cd'];
	$pc=$_POST['hid_pc'];
	$ed_pb=$_POST['ed_pb'];
	
	$usercd=$user_cd;
	include_once('function/form_12_fun.php');

	//delete_temp_app_letter($usercd);
	
	$dup=duplicate_po_ed($personnel);
	if($dup==0)
	{
		$ret=save_po_ed($personnel,$pc,$ed_pb,$usercd);
		if($ret==1)
		{
			$msg="<div class='alert-success'>Application submitted successfully</div>";
		}
	}
	else
	{
		$msg="<div class='alert-error'>Application already exists</div>";
	}
	$personcd=encode($personnel);
	if($ed_pb=="pb")
	{
?>
<script>
window.open("reports/form-12.php?personcd=<?php print $personcd; ?>&type=pb");
</script>
<?php
	}
	else
	{
?>
<script>
window.open("reports/form-12a.php?personcd=<?php print $personcd; ?>&type=ed");
</script>
<?php		
	}
}
?>
<?php
	include_once('function/training_fun.php');
	$subdiv_cd="0";
	if(isset($_SESSION['subdiv_cd']))
		$subdiv_cd=$_SESSION['subdiv_cd'];
?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr>
  <td align="center">LETTER OF INTIMATION TO RETURNING OFFICER</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
    <table width="70%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
	<tr>
	  <td align="left"><span class="error">*</span>Subdivision</td>
	  <td align="left"><select name="subdivision" id="subdivision" style="width:240px;" onchange="javascript:return subdivision_change(this.value);">
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
											$rowSubDiv=null;
										}
									}
									$rsBn=null;
									$num_rows=0;
							?>
      				</select></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Office</td>
      <td align="left" id="office_result"><select name="office" id="office" style="width:240px;" onchange="return office_change(this.value);"></select></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Personnel</td>
      <td align="left" id="personnel_result"><select name="personnel" id="personnel" style="width:240px;" onchange="return personnel_change(this.value);"></select>
      </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">OR</td>
    </tr>
    <tr>
    	<td align="left"><span class="error">*</span>EPIC NO</td>
        <td align="left"><input type="text" name="epic" id="epic" style="width:232px;" onchange="return epic_change(this.value);" /></td>
    </tr>
	<tr>
    	<td colspan="2" id="personnel_details">
    	<table border='0' width='100%'>
        <tr><td align='left' width='19%'><span class='error'>&nbsp;</span>Personnel Name:</td><td width='30%'>&nbsp;</td><td align='left' width='8%'> Designation:</td><td width='21%'>&nbsp;</td><td align='left' width='10%'> EPIC No:</td><td width='12%'>&nbsp;</td></tr>
        <tr><td align='left'><span class='error'>&nbsp;</span>AC No:</td><td>&nbsp;</td><td align='left'> Part No:</td><td>&nbsp;</td><td align='left'> Sl No:</td><td>&nbsp;</td></tr>
        </table><input type="hidden" id="hid_pc" name="hid_pc" /><input type='hidden' id='hid_per_cd' name='hid_per_cd' />
    	</td>
    </tr>
    <!--<tr>
	  <td align="left"><span class="error">*</span>Applying From</td>
	  <td align="left"><select name="pc" id="pc" style="width:240px;">
      						<option value="0">-Select PC-</option>
                            <?php /*?><?php 	$districtcd=$dist_cd;
									include_once('function\form_12_fun.php');
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
							?><?php */?>
      				</select></td>
    </tr>-->
    <tr>
	  <td align="left"><span class="error">*</span>Type</td>
	  <td align="left"><select name="ed_pb" id="ed_pb" style="width:240px;">
      						<option value="0">-Select Type-</option>
                            <option value="pb">Postal Ballot (Form 12)</option>
                            <option value="ed">Election Duty (Form 12A)</option>
      				</select></td>
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