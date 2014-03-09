<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inter Swap</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function fatch_office_agsubdiv(str)
{
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
		xmlhttp1=new XMLHttpRequest();
		xmlhttp2=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	
	xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
			document.getElementById("pc_result").innerHTML=xmlhttp1.responseText;
		}
	  }	 
    xmlhttp1.open("GET","ajax-inter-swap.php?subdiv_swp="+str+"&opn=pc_swp",true);
	xmlhttp1.send();
	
	xmlhttp2.onreadystatechange=function()
	  {
	  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			document.getElementById("poststat_details").innerHTML=xmlhttp2.responseText;
		}
	  }
	 //alert("ajaxfun.php?sub_swp="+str+"&opn=poststat");
    xmlhttp2.open("GET","ajax-inter-swap.php?sub_swp="+str+"&opn=poststat",true);
	xmlhttp2.send();
}

function for_subdiv_change(str)
{
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp1=new XMLHttpRequest();
		xmlhttp2=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
		xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	
	xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
			document.getElementById("forpc_result").innerHTML=xmlhttp1.responseText;
		}
	  }	 
    xmlhttp1.open("GET","ajaxfun.php?subdiv_swp="+str+"&opn=forpc_swp",true);
	xmlhttp1.send();
	
	xmlhttp2.onreadystatechange=function()
	  {
	  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			document.getElementById("for_poststat_details").innerHTML=xmlhttp2.responseText;
		}
	  }
	 //alert("ajaxfun.php?forsub_swp="+str+"&opn=prev_poststat");
    xmlhttp2.open("GET","ajaxfun.php?forsub_swp="+str+"&opn=prev_poststat",true);
	xmlhttp2.send();
}
	
function pc_change(str)
{
	var sub_swp=document.getElementById('Subdivision').value;
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
			document.getElementById("poststat_details").innerHTML=xmlhttp.responseText;
		}
	  }
	 
    xmlhttp.open("GET","ajax-inter-swap.php?pc_swp="+str+"&sub_swp="+sub_swp+"&opn=poststat",true);
	xmlhttp.send();
}
function forpc_change(str)
{
	var forsub_swp=document.getElementById('forsubdivision').value;
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
			document.getElementById("for_poststat_details").innerHTML=xmlhttp.responseText;
		}
	  }	 
    xmlhttp.open("GET","ajaxfun.php?forpc_swp="+str+"&forsub_swp="+forsub_swp+"&opn=prev_poststat",true);
	xmlhttp.send();
}

$(document).ready(function(){  $('.overlay').fadeOut();  });
function fadein() {
	$("#submit").click(function () {
		$(".overlay").fadeIn();
	});
}
function fadeout()
{
	$(function () {
		$("#submit").click(function () {
			$(".overlay").fadeOut();
		});
	});
}
function validate()
{
	var subdivision=document.getElementById("Subdivision").value;
	var forsubdivision=document.getElementById("forsubdivision").value;
	var pc=document.getElementById("pc").value;
	var forpc=document.getElementById("forpc").value;
	if(subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select For Subdivision Name";
		document.getElementById("Subdivision").focus();
		fadeout();
		return false;
	}
	if(forsubdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select New For Subdivision Name";
		document.getElementById("forsubdivision").focus();
		fadeout();
		return false;
	}
	if(pc=="0")
	{
		document.getElementById("msg").innerHTML="Select For PC Name";
		document.getElementById("pc").focus();
		fadeout();
		return false;
	}
	if(forpc=="0")
	{
		document.getElementById("msg").innerHTML="Select New For PC Name";
		document.getElementById("forpc").focus();
		fadeout();
		return false;
	}
	document.getElementById("msg").innerHTML="";
	fadein();
}
</script>

</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');
include_once('function/interswap_fun.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Inter Swap')
{
	$oldforsubdivision=isset($_POST['Subdivision'])?$_POST['Subdivision']:"";
	$forsubdivision=isset($_POST['forsubdivision'])?$_POST['forsubdivision']:"";
	$oldforpc=isset($_POST['pc'])?$_POST['pc']:"";
	$forpc=isset($_POST['forpc'])?$_POST['forpc']:"";
	$posting_status=isset($_POST['posting_status'])?$_POST['posting_status']:"";
	$numberofemployee=isset($_POST['numberofemployee'])?$_POST['numberofemployee']:"";
	$usercd=$user_cd;
	if ($forsubdivision>0)
	{
	    $rsEmp=fatch_PersonaldtlForInterSwap($oldforsubdivision,$oldforpc,$posting_status);
		$num_rows=rowCount($rsEmp);
		if($num_rows<1)
		{
			$msg="<div class='alert-error'>No record found for transffer</div>";
		}
		else
		{
			if ($numberofemployee!='' && $numberofemployee!='0')
			{
				$num_rows=$numberofemployee;
			}
			include_once('inc/commit_con.php');
			mysqli_autocommit($link,FALSE);
			$sql="update personnela set forsubdivision=?, forpc=?, edcpb=? where personcd=?";
			$stmt = mysqli_prepare($link, $sql);
			$row_aff=0;
			for($i=1;$i<=$num_rows;$i++)
			{ 
				$rowEmp=getRows($rsEmp);

				$personcd=$rowEmp['personcd'];
				$oldforsubdivision=$rowEmp['forsubdivision'];
				$oldforpc=$rowEmp['forpc'];
				if($oldforpc==$forpc)
				{
					$edcpb='E';
				}
				else
				{
					$edcpb='P';
				}		
				mysqli_stmt_bind_param($stmt, 'ssss', $forsubdivision,$forpc,$edcpb,$personcd);
				mysqli_stmt_execute($stmt);
				$row_aff+=mysqli_stmt_affected_rows($stmt);
				$rowEmp=NULL;
			}
			if (!mysqli_commit($link)) {
				print("Transaction commit failed\n");
				exit();
			}
			else
			{
				$msg="<div class='alert-success'>".$row_aff." Record(s) changed successfully</div>";
			}
			mysqli_stmt_close($stmt);
			/* close connection */
			mysqli_close($link);
			unset($rsEmp,$num_rows,$rowEmp);
		}
 	} 
}
?>
<body oncontextmenu="return false;">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">INTER SWAPPING DETAILS</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
  <table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="6"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="6" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="6">
      <div class="overlay">
  			<img id="loading_spinner" src="images/loading1.gif" height="80px" width="80px" />
	  </div>
      </td>
    </tr>
    <tr>
    <td align="left">&nbsp;</td>
    
      <td align="left" valign="top"><span class="error">*</span>For Sub Division</td>
      <td align="left" valign="top"><select name="Subdivision" id="Subdivision" style="width:170px;" onchange="return fatch_office_agsubdiv(this.value);">
      <option value="0">-Select Subdivision-</option>
                            <?php 	$districtcd=$dist_cd;
									$rsBn=fatch_Subdivision($districtcd);
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowBn=getRows($rsBn);
											echo "<option value='$rowBn[0]'>$rowBn[2]</option>\n";
										}
									}
									$rsBn=null;
									$num_rows=0;
									$rowBn=null;
							?>
      				</select></td>
                <td align="left" valign="top"><span class="error">*</span>New For Sub Division</td>
      <td align="left" valign="top"><select name="forsubdivision" id="forsubdivision" style="width:170px;" onchange="return for_subdiv_change(this.value);">
      <option value="0">-Select For Subdivision-</option>
                            <?php 	$rsBn=fatch_Subdivision($districtcd);
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowBn=getRows($rsBn);
											echo "<option value='$rowBn[0]'>$rowBn[2]</option>\n";
										}
									}
									$rsBn=null;
									$num_rows=0;
									$rowBn=null;
									$districtcd=0;
							?>
      				</select></td>
    </tr>
    <tr>
    <td align="left">&nbsp;</td>
    <td align="left" valign="top"><span class="error">*</span>For PC</td>
    <td align="left" valign="top" id="pc_result"><select name="pc" id="pc" style="width:170px;" onchange="return pc_change(this.value);"></select></td>
                <td align="left" valign="top"><span class="error">*</span>New For PC</td>
      <td align="left" valign="top" id="forpc_result"><select name="forpc" id="forpc" style="width:170px;" onchange="return forpc_change(this.value);"></select></td>
    </tr>
    <tr><td class="text_small" align="right">Total Member&nbsp;&nbsp;&nbsp;&nbsp;</td><td align="left" id="poststat_details" colspan="2" class="text_small"></td>
    	<td align="left" id="for_poststat_details" colspan="2" class="text_small"></td></tr>
    <tr>
    <td align="left">&nbsp;</td>
      <td align="left" valign="top"><span class="error">&nbsp;</span>Post Status</td>
      <td align="left" valign="top"><select name="posting_status" id="posting_status" style="width:170px;">
      						<option value="0">-Select Post Status-</option>
                            <?php 	$rsP=fatch_postingstatus();
									$num_rows=rowCount($rsP);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowP=getRows($rsP);
											echo "<option value='$rowP[0]'>$rowP[1]</option>\n";
										}
									}
									$rsP=null;
									$num_rows=0;
									$rowP=null;
							?>
      				</select></td>
    <td colspan="2">&nbsp;</td>             
    </tr>
    <tr>
    <td align="left"><label for="chksetnumberofemployee" class="text_small"><br /></label></td> 
      <td align="left" valign="top"><span class="error">&nbsp;</span>Number of employee</td>
      <td align="left" valign="top"><input type="text" name="numberofemployee" id="numberofemployee" style="width:162px;" onkeypress="javascript:return wholenumbersonly(event);" />
      </td>
       <td colspan="2">&nbsp;</td>         
    </tr>
     <tr>
      <td align="center" colspan="6"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
      <td colspan="6" align="center"><input type="submit" name="submit" id="submit" value="Inter Swap" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr>
      <td align="center" colspan="6"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
  </table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
<div align="center"></div>
</body>
</html>