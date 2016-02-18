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
	var txtfrom=document.getElementById("txtfrom");
	var txtto=document.getElementById("txtto");
	var phase=document.getElementById("phase").value;
	var subdivision=document.getElementById("subdivision").value;
	if(subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("subdivision").focus();
		return false;
	}

	if(phase=="0")
	{
		document.getElementById("msg").innerHTML="Select Phase Type";
		document.getElementById("phase").focus();
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
		document.getElementById("phase_type").innerHTML=xmlhttp.responseText;
	//	document.getElementById("load_result").innerHTML="";
		document.getElementById("form1").style="cursor:default";
		}
	  }
	xmlhttp.open("GET","ajax-first-app3.php?Subdivision="+str+"&opn=tr_phase_print",true);
	//document.getElementById("load_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
	document.getElementById("form1").style="cursor:wait";
	xmlhttp.send();
}
function phse_change(str)
{
	//window.history.back();
	var subdivision=document.getElementById("subdivision").value;
	if(str!=0 || subdivision !=0)
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
			document.getElementById("limit_txt").innerHTML=xmlhttp.responseText;
			document.getElementById("load_result").innerHTML="";
			document.getElementById("form1").style="cursor:default";
			document.getElementById("msg").innerHTML="";
			}
		  }
		xmlhttp.open("GET","ajax-first-app3.php?Subdivision="+subdivision+"&phase="+str+"&opn=gen_sl_extra",true);
		document.getElementById("load_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
		document.getElementById("form1").style="cursor:wait";
		xmlhttp.send();
	}
}
</script>
</head>
<?php
/*include_once('inc/db_trans.inc.php');
include_once('function/appointment_fun.php');
$submit=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($submit=='Submit')
{
	$subdiv=(isset($_POST['Subdivision'])?$_POST['Subdivision']:'0');
	$rsApp=first_app_letter3_print($subdiv);
	$num_rows=rowCount($rsApp);
	
	if($num_rows>0)
	{
		include_once('inc/commit_con.php');
		mysqli_autocommit($link,FALSE);
		$sql="update first_rand_table set sl_no=? where personcd=?";
		$stmt1 = mysqli_prepare($link, $sql);
		
		mysqli_stmt_bind_param($stmt1, 'is', $sl,$personcd);
		$sl=0;
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowApp=getRows($rsApp);
			$personcd=$rowApp['personcd'];
			$sl=$sl+1;
			mysqli_stmt_execute($stmt1);
		}
		mysqli_commit($link);
		
		mysqli_stmt_close($stmt1);
		mysqli_close($link);
		$limit_txt="From: &nbsp;<input type='text' name='txtfrom' />&nbsp;&nbsp;&nbsp;
	To: &nbsp;<input type='text' name='txtto' />";
	}
}*/
?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print uppercase($district); ?> DISTRICT</td></tr>
<tr>
  <td align="center">FIRST APPOINTMENT LETTER PRINT FOR EXTRA PP</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" action="fpdf/training-app-letter3-extra.php" target="_blank">
    <table width="70%" class="form" cellpadding="0">
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td colspan="2" align="center">&nbsp;</td></tr>
	<tr>
      <td align="center" colspan="2"><div id="load_result"></div></td>
    </tr>
     <tr>
      <td align="left"><span class="error">*</span>Subdivision</td>
      <td align="left"><select name="subdivision" id="subdivision" style="width:240px;" onchange="Subdivision_change(this.value)">
    							<option value="0">-Select Subdivision-</option>
								<?php 	$rsSubDiv=fatch_Subdivision($dist_cd);
										$num_rows=rowCount($rsSubDiv);
										if($num_rows>0)
										{
											for($i=1;$i<=$num_rows;$i++)
											{
												$rowSubDiv=getRows($rsSubDiv);
												echo "<option value='$rowSubDiv[0]'>$rowSubDiv[2]</option>\n";
												$rowSubDiv=NULL;
											}
										}
										unset($rsSubDiv,$num_rows,$rowSubDiv);;
								?>
                            </select></td></tr>
     <tr>
      <td align="left"><span class="error">*</span>Phase Type</td>
      <td align="left" id="phase_type"><select name="phase" id="phase" style="width:240px;">
		<option value="0">-Select Phase Type-</option>
                            <?php 	/*$rsP=fatch_personnela_phasetype();
									$num_rows=rowCount($rsP);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowP=getRows($rsP);
											$phase_name=convert_number_to_words($rowP['0']);
											echo "<option value='$rowP[0]'>$phase_name</option>\n";
											$rowP=NULL;
										}
									}
									unset($rsP,$num_rows,$rowP);*/
							?>
      </select></td>
    </tr>
 
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
	<tr><td colspan="2" id="limit_txt" align="left"></td></tr>
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