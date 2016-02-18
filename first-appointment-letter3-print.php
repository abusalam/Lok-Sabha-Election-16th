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
function validate()
{
	var subdivision=document.getElementById("Subdivision");
	var txtfrom=document.getElementById("txtfrom");
	var txtto=document.getElementById("txtto");
	if(subdivision.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("Subdivision").focus();
		return false;
	}
	if(txtfrom.value=="")
	{
		document.getElementById("msg").innerHTML="Enter from";
		document.getElementById("txtfrom").focus();
		return false;
	}
	if(txtto.value=="")
	{
		document.getElementById("msg").innerHTML="Enter to";
		document.getElementById("txtto").focus();
		return false;
	}
	
}
function Subdivision_change(str)
{
	//window.history.back();
	//document.getElementById("rand_result").innerHTML="";
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
		document.getElementById("limit_txt").innerHTML=xmlhttp.responseText;
		document.getElementById("load_result").innerHTML="";
		document.getElementById("form1").style="cursor:default";
		}
	  }
	xmlhttp.open("GET","ajax-first-app3.php?Subdivision="+str+"&opn=gen_sl",true);
	document.getElementById("load_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
	document.getElementById("form1").style="cursor:wait";
	xmlhttp.send();
}
function excel_print(str)
{
	window.open("ajax/first_app3_excel.php?subdiv="+str);
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/appointment_fun.php');

extract($_POST);
$submit=isset($_POST['submit'])?$_POST['submit']:"";
if($submit=="PDF")
{
	$subdiv=(isset($_POST['Subdivision'])?encode($_POST['Subdivision']):'0');
	$hid_rec=(isset($_POST['hid_rec'])?encode($_POST['hid_rec']):'0');
	$txtfrom=(isset($_POST['txtfrom'])?encode($_POST['txtfrom']):'0');
	$txtto=(isset($_POST['txtto'])?encode($_POST['txtto']):'0');
	?>
    <script>
		window.open("fpdf/training-app-letter3.php?Subdivision=<?php echo $subdiv; ?>&txtfrom=<?php echo $txtfrom; ?>&txtto=<?php echo $txtto;?>&hid_rec=<?php echo $hid_rec;?>");
	</script>
    <?php
}
if($submit=="EXCEL")
{
	$subdiv=(isset($_POST['Subdivision'])?encode($_POST['Subdivision']):'0');
	$hid_rec=(isset($_POST['hid_rec'])?encode($_POST['hid_rec']):'0');
	$txtfrom=(isset($_POST['txtfrom'])?encode($_POST['txtfrom']):'0');
	$txtto=(isset($_POST['txtto'])?encode($_POST['txtto']):'0');
	?>
    <script>
		window.open("ajax/first_app3_excel.php?subdiv=<?php echo $subdiv; ?>&txtfrom=<?php echo $txtfrom; ?>&txtto=<?php echo $txtto;?>&hid_rec=<?php echo $hid_rec;?>");
	</script>
    <?php
}
?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print uppercase($district); ?> DISTRICT</td></tr>
<tr>
  <td align="center">FIRST APPOINTMENT LETTER PRINT</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" action="">
    <table width="70%" class="form" cellpadding="0">
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td colspan="2" align="center">&nbsp;</td></tr>
	<tr>
      <td align="center" colspan="2"><div id="load_result"></div></td></tr>
	<tr>
	  <td align="left"><span class="error">*</span>Subdivision</td>
	  <td align="left"><select name="Subdivision" id="Subdivision" style="width:240px;" onchange="Subdivision_change(this.value)">
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
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
	<tr><td colspan="2" id="limit_txt" align="left"></td></tr>
	<tr><td colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="PDF" class="button" onclick="javascript:return validate();" />&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" name="submit" id="submit" value="EXCEL" class="button" onclick="javascript:return validate();" /></td></tr>
      <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>