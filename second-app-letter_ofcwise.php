<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Appointment Letter</title>
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
		document.getElementById("loading1").style.visibility="hidden";
		}
	  }
	xmlhttp.open("GET","ajax-appointment.php?sub_div="+str+"&opn=for_sub_emp_office",true);
	document.getElementById("loading1").style.visibility="visible";
	xmlhttp.send();
}
function validate()
{
	var subdivision=document.getElementById("Subdivision").value;

	if(subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("Subdivision").focus();
		return false;
	}
	var txtfrom=document.getElementById('txtfrom');
		if(txtfrom.value=='')
		{
			document.getElementById('msg').innerHTML="Enter From";
			txtfrom.focus();
			return false;
		}
		var txtto=document.getElementById('txtto');
		if(txtto.value=='')
		{
			document.getElementById('msg').innerHTML="Enter To";
			txtto.focus();
			return false;
		}
}
</script>
</head>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print uppercase($district); ?> DISTRICT</td></tr>
<tr>
  <td align="center">SECOND APPOINTMENT LETTER ISSUE</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" action="fpdf/second-app-letter_ofcwise2.php" target="_blank">
    <table width="60%" class="form" cellpadding="0">
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
  
    <tr>
      <td height="16px" colspan="2" align="center"><span id="msg" class="error"></span></td>
    </tr>
      <tr>
      <td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
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
									unset($rsBn,$num_rows,$rowSubDiv);
							?>
      				</select></td></tr>
    
	<tr>
    <tr>

       <td><span class="error">*</span>Office Print</td>
       <td>From: &nbsp;<input type='text' name='txtfrom' id='txtfrom' style='width:40px;'/>&nbsp;&nbsp;
	To: &nbsp;<input type='text' name='txtto' id='txtto' style='width:40px;' /></td>
      </tr> 
	  <td align="left" colspan="2">&nbsp;</td></tr>
       
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