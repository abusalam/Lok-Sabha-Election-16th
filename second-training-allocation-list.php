<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Training Allocation List</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
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
			}
		  }
		xmlhttp.open("GET","ajax-appointment.php?sub_div="+str+"&opn=assembly",true);
		xmlhttp.send();
	
}
function office_list(str)
{
	//var sub_div="<?php echo $subdiv_cd; ?>";
	var qstr;
	var PC="";
	var training_venue=document.getElementById('training_venue').value;
	var sub_div=document.getElementById("Subdivision").value;
	var assembly=document.getElementById("assembly").value;
	var page="<?php echo isset($_GET['p'])?$_GET['p']:""; ?>";
	var all="<?php echo isset($_GET['a'])?$_GET['a']:""; ?>";
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
			document.getElementById("training_allocation_result").innerHTML=xmlhttp.responseText;
			document.getElementById("form1").style="cursor:default";
		}
	  }
	if(str=="search")
     qstr="ajax-training2.php?sub_div="+sub_div+"&training_venue="+training_venue+"&PC="+PC+"&assembly="+assembly+"&opn=tal&search=search";
	else
     qstr="ajax-training2.php?sub_div="+sub_div+"&training_venue="+training_venue+"&PC="+PC+"&assembly="+assembly+"&opn=tal&p="+page+"&a="+all;
	xmlhttp.open("GET",qstr,true);
	
	//xmlhttp.open("GET","ajax-training2.php?sub_div="+sub_div+"&training_venue="+training_venue+"&PC="+PC+"&assembly="+assembly+"&opn=tal&p="+page+"&a="+all,true);
	document.getElementById("training_allocation_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
	document.getElementById("form1").style="cursor:wait";
	xmlhttp.send();
}
$(document).ready(function(){  $('.overlay').fadeOut();  });

function delete_training2_allocation(str,str_sub,str_asm,str_pr)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
	var delcode=str;
	var sub_div="<?php echo $subdiv_cd; ?>";
	var training_venue=document.getElementById('training_venue').value;
	var PC="";
	var assembly=document.getElementById("assembly").value;
	var page="<?php echo isset($_GET['p'])?$_GET['p']:""; ?>";
	var all="<?php echo isset($_GET['a'])?$_GET['a']:""; ?>";
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
			document.getElementById("training_allocation_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-training2.php?delcode="+delcode+"&sub_div="+sub_div+"&training_venue="+training_venue+"&PC="+PC+"&assembly="+assembly+"&strsub="+str_sub+"&strasm="+str_asm+"&strpr="+str_pr+"&opn=tal&p="+page+"&a="+all,true);
	xmlhttp.send();
	}
}
</script>
<link type="text/css" rel="stylesheet" href="css/paging.css" />
</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/training2_fun.php');
?>
<body oncontextmenu="return false;" onload="return office_list('pload');">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">SECOND TRAINING ALLOCATION LIST</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="95%" class="form" cellpadding="0">
    <tr><td colspan="4" align="center"><?php print $subdiv_name; ?> Subdivision</td></tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr><input type="hidden" id="hid_subdiv" value="<?php print $subdiv_cd; ?>" />
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Subdivision</td>
	  <td align="left"><select name="Subdivision" id="Subdivision" style="width:180px;" onchange="javascript:return subdiv_change(this.value);">
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
      				</select></td>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Assembly Constituency</td>
      <td align="left" id="assembly_result"><select name="assembly" id="assembly" style="width:180px;"></select></td>
    </tr>
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Training Venue</td>
      <td align="left"><input type="text" name="training_venue" id="training_venue" style="width:172px;" /></td>
      <td colspan="2">&nbsp;</td>
    </tr>
   
    <tr><td colspan="4" align="left">&nbsp;</td></tr>
    <tr>
      <td colspan="4" align="center"><input type="button" name="search" id="search" value="Search" class="button" onclick="javascript:return office_list('search');" /></td>
    </tr>
    <tr><td colspan="4" align="left">&nbsp;</td></tr>
    <tr>
      <td align="center" colspan="4" id="training_allocation_result">
      	<div class="overlay">
  			<img id="loading_spinner" src="images/loading.gif" />
		</div>
      </td>
    </tr>  
    <tr><td></td><td colspan="4" align="left">&nbsp;</td></tr>
  </table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>