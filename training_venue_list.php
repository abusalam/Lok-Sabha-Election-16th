<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Training Venue List</title>
<?php
include('header/header.php');
?>

<script type="text/javascript" language="javascript">

function termination_list(str)
{
	var qstr;
	var subdivision=document.getElementById('subdivision').value;
	var venuename=document.getElementById("venuename").value;
	var dist="<?php echo isset($dist_cd)?$dist_cd:""; ?>";
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
			document.getElementById("trainingvenue_list_result").innerHTML=xmlhttp.responseText;
		}
	  }

	if(str=="search")
    qstr="ajax-trainingvenuelist.php?subdivision="+subdivision+"&venuename="+venuename+"&dist="+dist;
	else
    qstr="ajax-trainingvenuelist.php?subdivision="+subdivision+"&venuename="+venuename+"&dist="+dist+"&p="+page+"&a="+all;
	xmlhttp.open("GET",qstr,true);
	xmlhttp.send();
}
$(document).ready(function(){  $('.overlay').fadeOut();  });
//=================================================
function edit_trainingvenue(str)
{
	location.replace("trainingvenue.php?venue_cd="+str);
}

function delete_trainingvenue(str)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
	var delcode=str;
	var sub_div="<?php echo $subdiv_cd; ?>";
	var subdivision=document.getElementById('subdivision').value;
	var venuename=document.getElementById("venuename").value;
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
			document.getElementById("trainingvenue_list_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-trainingvenuelist.php?delcode="+delcode+"&subdivision="+subdivision+"&venuename="+venuename+"&p="+page+"&a="+all,true);
	xmlhttp.send();
	}
}
</script>

<link type="text/css" rel="stylesheet" href="css/paging.css" />
</head>
<body oncontextmenu="return false;" onload="javascript:return termination_list('pload');">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">TRAINING VENUE LIST</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="95%" class="form" cellpadding="0">    
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td align="left" valign="top"><span class="error">*</span>Sub Division</td>
      <td align="left" valign="top"><select name="subdivision" id="subdivision" style="width:200px;">
    							<option value="0">-Select Subdivision-</option>
							 <?php 	$districtcd=$dist_cd;
									$rsBn=fatch_Subdivision($districtcd);
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowBn=getRows($rsBn);
											echo "<option value='$rowBn[0]'>$rowBn[2]</option>";
											$rowBn=NULL;
										}
									}
									unset($rsBn,$num_rows,$rowBn,$districtcd);
							?>
                            </select></td>
      <td align="left"><span class="error">*</span>Venue Name</td>
      <td align="left"><input type="text" name="venuename" id="venuename" maxlength="50" style="width:250px;" /><br />
      								</td>
    </tr>
  
    <tr>
      <td colspan="4" align="center"><input type="button" name="search" id="search" value="Search" class="button" onclick="javascript:return termination_list('search');" /></td>
    </tr>
    <tr><td colspan="2" align="left">&nbsp;</td></tr>
    <tr>
      <td align="center" colspan="4" id="trainingvenue_list_result">
      	<div class="overlay">
  			<img id="loading_spinner" src="images/loading.gif" />
		</div>
      </td>
    </tr>  
    <tr><td></td><td colspan="3" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
  </table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>

</body>
</html>