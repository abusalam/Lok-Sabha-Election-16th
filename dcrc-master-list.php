<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DCRC Master List</title>
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
		document.getElementById("assembly_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajaxfun.php?sub-div="+str+"&opn=assembly_ag_sub",true);
	xmlhttp.send();
}
function search_click()
{
	var subdiv=document.getElementById('Subdivision').value;
	var assembly=document.getElementById('assembly').value;
	var dist="<?php echo isset($dist_cd)?$dist_cd:""; ?>";
	
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
			document.getElementById("dcrc_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajaxfun.php?sub_div="+subdiv+"&ass="+assembly+"&opn=dcrc_result&dist="+dist,true);
	xmlhttp.send();
}
$(document).ready(function(){  $('.overlay').fadeOut();  });
function edit_reserve(str,str1,str2)
{
	location.replace("assembly-party.php?assembly="+str+"&noofparty="+str1+"&poststat="+str2);
}
function delete_dcrc(str)
{
	var subdiv=document.getElementById('Subdivision').value;
	var assembly=document.getElementById('assembly').value;
	if (confirm("Do you really want to delete the record?")==true)
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
			document.getElementById("dcrc_result").innerHTML=xmlhttp.responseText;
		}
	  }
	  //alert("ajaxfun.php?dcrc="+str+"&opn=del_dcrc&sub_div="+subdiv+"&assembly="+assembly);
	xmlhttp.open("GET","ajaxfun.php?dcrc="+str+"&opn=del_dcrc&sub_div="+subdiv+"&assembly="+assembly,true);
	xmlhttp.send();
	}
}
</script>
<link type="text/css" rel="stylesheet" href="css/paging.css" />
</head>
<body oncontextmenu="return false;" onload="return search_click();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">DCRC LIST</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="95%" class="form" cellpadding="0">
    <tr><td colspan="4" align="center"><?php //print $subdiv_name." Subdivision"; ?></td></tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
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
									$rsBn=null;
									$num_rows=0;
									$rowSubDiv=null;
							?>
      				</select></td>
      <td align="left"><span class="error">*</span>Assembly</td>
      <td align="left" id="assembly_result"><select name="assembly" id="assembly" style="width:200px;">
      </select></td>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>
    <tr>
      <td colspan="4" align="center"><input type="button" name="search" id="search" value="Search" class="button" onclick="javascript:return search_click();" /></td>
    </tr>
    <tr><td colspan="2" align="left">&nbsp;</td></tr>
    <tr>
      <td align="center" colspan="4" id="dcrc_result">
      	<div class="overlay">
  			<img id="loading_spinner" src="images/loading.gif" />
		</div>
      	<!--<table width="100%" cellpadding="0" cellspacing="0" border="0" id="table1">
        <tr><th>Sl.</th>
        	<th>Office ID</th>
            <th>Office Name</th>
            <th>Office Address</th>
            <th>Nature of Office</th>
            <th>Edit</th></tr>
        <tr><td align="center"><img src="images/edit.png" alt="" height="20px" /></td></tr>
        </table>-->
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