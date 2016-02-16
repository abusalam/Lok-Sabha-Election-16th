<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Employee Swapping Details</title>
<?php
include('header/header.php');
?>

<script type="text/javascript" language="javascript">
function fatch_office_agsubdiv(str)
{
	document.getElementById("poststat_details").innerHTML="<img src='images/loading_s.gif' alt='' height='15px' width='20px'/>";
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
	//	xmlhttp1=new XMLHttpRequest();
		xmlhttp2=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	//	xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("office_details").innerHTML=xmlhttp.responseText;
		}
	  }	 
    xmlhttp.open("GET","ajaxfun.php?subdiv_swp="+str+"&off=n",true);
	xmlhttp.send();
	document.getElementById('chksetoffice').checked=false;
	
	/*xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
			document.getElementById("pc_result").innerHTML=xmlhttp1.responseText;
		}
	  }	 
    xmlhttp1.open("GET","ajaxfun.php?subdiv_swp="+str+"&opn=pc_swp",true);
	xmlhttp1.send();*/
	
	xmlhttp2.onreadystatechange=function()
	  {
	  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			document.getElementById("poststat_details").innerHTML=xmlhttp2.responseText;
		}
	  }
	 //alert("ajaxfun.php?sub_swp="+str+"&opn=poststat");
    xmlhttp2.open("GET","ajaxfun.php?sub_swp="+str+"&opn=poststat",true);
	xmlhttp2.send();
}

function for_subdiv_change(str)
{
		document.getElementById("for_poststat_details").innerHTML="<img src='images/loading_s.gif' alt='' height='15px' width='20px'/>";
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	//	xmlhttp1=new XMLHttpRequest();
		xmlhttp3=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
		//xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	
	/*xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
			document.getElementById("forpc_result").innerHTML=xmlhttp1.responseText;
		}
	  }	 
    xmlhttp1.open("GET","ajaxfun.php?subdiv_swp="+str+"&opn=forpc_swp",true);
	xmlhttp1.send();*/
	
	xmlhttp3.onreadystatechange=function()
	  {
	  if (xmlhttp3.readyState==4 && xmlhttp2.status==200)
		{
			document.getElementById("for_poststat_details").innerHTML=xmlhttp3.responseText;
		}
	  }
	 //alert("ajaxfun.php?forsub_swp="+str+"&opn=prev_poststat");
    xmlhttp3.open("GET","ajaxfun.php?forsub_swp="+str+"&opn=prev_poststat",true);
	xmlhttp3.send();
}
	
function chksetsubdivision_change()
{
	
	if(document.getElementById('chksetsubdivision').checked==true)
	{
		/*document.getElementById('chksetoffice').checked=true;*/
		/*chksetoffice.checked=true;*/
		document.getElementById('Subdivision').disabled=false;
		document.getElementById('forsubdivision').disabled=false;
	//	document.getElementById('pc').disabled=false;
		document.getElementById('ex_ass').disabled=false;
		document.getElementById('ex_ass1').disabled=false;
		document.getElementById('ex_ass2').disabled=false
		
		document.getElementById('chksetoffice').disabled=false;
		document.getElementById('chksetgender').disabled=false;
		document.getElementById('chksetpostingstatus').disabled=false;
		document.getElementById('chksetnumberofemployee').disabled=false;
		
		fatch_office_agsubdiv('0');
		//for_subdiv_change('0');
		/*chksetoffice.disabled=false;*/
	}
	else if(document.getElementById('chksetsubdivision').checked==false)	
	{
		document.getElementById('chksetoffice').checked=false;
		document.getElementById('chksetoffice').disabled=true;
		document.getElementById('Subdivision').disabled=true;
		document.getElementById('Subdivision').selectedIndex="0";
	//	document.getElementById('pc').disabled=true;
	//	document.getElementById('pc').selectedIndex="-1";
		document.getElementById('ex_ass').disabled=true;
		document.getElementById('ex_ass').value="";
		document.getElementById('ex_ass1').disabled=true;
		document.getElementById('ex_ass1').value="";
		document.getElementById('ex_ass2').disabled=true;
		document.getElementById('ex_ass2').value="";
		
		document.getElementById('forsubdivision').disabled=true;
		document.getElementById('forsubdivision').selectedIndex="0";
	//	document.getElementById('forpc').disabled=true;
	//	document.getElementById('forpc').selectedIndex="-1";
		document.getElementById('officename').disabled=true;
		document.getElementById('officename').selectedIndex="";
		
		document.getElementById('chksetgender').disabled=true;
		document.getElementById('chksetgender').checked=false;
		document.getElementById('gender').selectedIndex="0";
		document.getElementById('gender').disabled=true;
		
		document.getElementById('chksetpostingstatus').disabled=true;
		document.getElementById('chksetpostingstatus').checked=false;
		document.getElementById('posting_status').selectedIndex="0";
		document.getElementById('posting_status').disabled=true;
		
		document.getElementById('chksetnumberofemployee').disabled=true;
		document.getElementById('chksetnumberofemployee').checked=false;
		document.getElementById('numberofemployee').disabled=true;
		document.getElementById('numberofemployee').value="";
		
		document.getElementById("poststat_details").innerHTML="";
		document.getElementById("for_poststat_details").innerHTML="";
	}
}
/*function pc_change(str)
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
	 
    xmlhttp.open("GET","ajaxfun.php?pc_swp="+str+"&sub_swp="+sub_swp+"&opn=poststat",true);
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
}*/
function chksetoffice_change()
{
	if(document.getElementById('chksetoffice').checked==true)
	{
		document.getElementById('officename').disabled=false;
	}
	else if(document.getElementById('chksetoffice').checked==false)	
	{
		document.getElementById('officename').disabled=true;
		document.getElementById('officename').selectedIndex="0";
	}
}
function chksetgender_change()
{
	if(document.getElementById('chksetgender').checked==true)
	{
		document.getElementById('gender').disabled=false;
	}
	else if(document.getElementById('chksetgender').checked==false)
	{
		document.getElementById('gender').disabled=true;
		document.getElementById('gender').selectedIndex="0";
	}
}
function chksetpostingstatus_change()
{
	if(document.getElementById('chksetpostingstatus').checked==true)
	{
		document.getElementById('posting_status').disabled=false;
	}
	else if(document.getElementById('chksetpostingstatus').checked==false)
	{
		document.getElementById('posting_status').disabled=true;
		document.getElementById('posting_status').selectedIndex="0";
	}
}
function chksetnumberofemployee_change()
{
	if(document.getElementById('chksetnumberofemployee').checked==true)
	{
		document.getElementById('numberofemployee').disabled=false;
	}
	else if(document.getElementById('chksetnumberofemployee').checked==false)
	{
		document.getElementById('numberofemployee').disabled=true;
		document.getElementById('numberofemployee').value="";
	}
}
/*$(document).ready(function(){  $('.overlay').fadeOut();  });
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
}*/
function validate()
{
	var subdivision=document.getElementById("Subdivision").value;
	var forsubdivision=document.getElementById("forsubdivision").value;
	if(subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision Name";
		document.getElementById("Subdivision").focus();
      //  fadeout();
		return false;
	}
	if(forsubdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select For Subdivision Name";
		document.getElementById("forsubdivision").focus();
		//fadeout();
		return false;
	}
	document.getElementById("msg").innerHTML="";
	//fadein();
}
</script>

</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Swapping')
{
	$subdivision=isset($_POST['Subdivision'])?$_POST['Subdivision']:"";
	$forsubdivision=isset($_POST['forsubdivision'])?$_POST['forsubdivision']:"";
	$pc=isset($_POST['pc'])?$_POST['pc']:"";
	$ex_ass=isset($_POST['ex_ass'])?$_POST['ex_ass']:"";
	$ex_ass1=isset($_POST['ex_ass1'])?$_POST['ex_ass1']:"";
	$ex_ass2=isset($_POST['ex_ass2'])?$_POST['ex_ass2']:"";
	$forpc=isset($_POST['forpc'])?$_POST['forpc']:"";
	$officename=isset($_POST['officename'])?$_POST['officename']:"";
	$posting_status=isset($_POST['posting_status'])?$_POST['posting_status']:"";
	$gender=isset($_POST['gender'])?$_POST['gender']:"";
	$numberofemployee=isset($_POST['numberofemployee'])?$_POST['numberofemployee']:"";
	$usercd=$user_cd;
	if($forsubdivision>0)
	{
	    $rsEmp=fatch_PersonaldtlAgSubdiv($subdivision,$pc,$ex_ass,$officename,$posting_status,$numberofemployee,$forsubdivision,$ex_ass1,$ex_ass2,$gender);
		//$num_rows=rowCount($rsEmp);
	
		if($rsEmp<1)
		{
			$msg="<div class='alert-error'>No record found for transfer</div>";
		}
		else
		{
			   //--------------------------------------------		  
		   //----------------------------------	 
	//---------------------------------------
	       $msg="<div class='alert-success'>".$rsEmp." Record(s) has been transferred successfully</div>";
		}
		$rsEmp=NULL;
 	} 
			   //--------------------------------------------		  
		   //----------------------------------	 
	//---------------------------------------
}

?>
<body oncontextmenu="return false;">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1060px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">EMPLOYEE SWAPPING DETAILS </td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
  <table width="100%" class="form" cellpadding="0" style="padding-left:6px;">
    <tr>
      <td align="center" colspan="6"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="6" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <!--<tr>
      <td align="center" colspan="6">
      <div class="overlay">
  			<img id="loading_spinner" src="images/loading1.gif" height="80px" width="80px" />
	  </div>
      </td>
    </tr>-->
    <tr>
    <td align="left" width="17%"><input type="checkbox" id="chksetsubdivision" name="chksetsubdivision" onclick="return chksetsubdivision_change();" />
        <label for="chksetsubdivision" class="text_small">Sub division wise</label></td>
    
      <td align="left" valign="top" width="20%"><span class="error">&nbsp;&nbsp;</span>Sub Division</td>
      <td align="left" valign="top" width="21%"><select name="Subdivision" id="Subdivision" style="width:170px;" disabled="disabled" onchange="return fatch_office_agsubdiv(this.value);">
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
                <td align="left" valign="top" width="20%"><span class="error">*</span>For Sub Division</td>
      <td align="left" valign="top" width="22%"><select name="forsubdivision" id="forsubdivision" style="width:170px;" disabled="disabled" onchange="return for_subdiv_change(this.value);">
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
   <!-- <tr>
    <td align="left">&nbsp;</td>
    <td align="left" valign="top"><span class="error">&nbsp;&nbsp;</span>PC</td>
    <td align="left" valign="top" id="pc_result"><select name="pc" id="pc" style="width:170px;" disabled="disabled" onchange="return pc_change(this.value);"></select></td>
                <td align="left" valign="top"><span class="error">*</span>For PC</td>
      <td align="left" valign="top" id="forpc_result"><select name="forpc" id="forpc" style="width:170px;" disabled="disabled" onchange="return forpc_change(this.value);"></select></td>
    </tr>-->
    <tr>
    <td align="left">&nbsp;</td>
    <td align="left" valign="top"><span class="error">&nbsp;&nbsp;</span>Excluding Assembly</td>
    <td align="left" valign="top"><span style="width: 162px;"><input type="text" name="ex_ass" id="ex_ass" maxlength="3" onkeypress="javascript:return wholenumbersonly(event);" style="width:41px" disabled="disabled" />&nbsp;
    <input type="text" name="ex_ass1" id="ex_ass1" maxlength="3" onkeypress="javascript:return wholenumbersonly(event);" style="width:41px" disabled="disabled" />&nbsp;
    <input type="text" name="ex_ass2" id="ex_ass2" maxlength="3" onkeypress="javascript:return wholenumbersonly(event);" style="width:41px" disabled="disabled" /></span></td>
    <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr><td class="text_small" align="right" ><b>Total Member ::</b>&nbsp;&nbsp;&nbsp;&nbsp;</td><td align="left" id="poststat_details" colspan="2" class="text_small" style="height: 20px;"></td>
    	<td  id="for_poststat_details" colspan="2" class="text_small"></td></tr>
    <tr>
    <td align="left"><input type="checkbox" id="chksetoffice" name="chksetoffice" onclick="return chksetoffice_change();" disabled="disabled" />
        <label for="chksetoffice" class="text_small">Office wise
         </label></td>   
      <td align="left" valign="middle"><span class="error">&nbsp;</span>Office Name</td>
      <td align="left" valign="middle"><span id='office_details'><select name="officename" id="officename" disabled="disabled" style="width:170px;">
</select></span></td><td colspan="2">&nbsp;</td> 
    </tr>
     <tr>
       <td align="left"><input type="checkbox" id="chksetgender" name="chksetgender" onclick="return chksetgender_change();" disabled="disabled" />
        <label for="chksetgender" class="text_small">Gender wise</label></td>
      <td align="left" valign="middle"><span class="error">&nbsp;</span>Gender</td>
      <td align="left" valign="middle"><select name="gender" id="gender" disabled="disabled" style="width:170px;">
      						<option value="0">-Select Gender-</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
      				</select></td>
       <td colspan="2">&nbsp;</td>             
    </tr>
    <tr>
     <td align="left"><input type="checkbox" id="chksetpostingstatus" name="chksetpostingstatus" onclick="return chksetpostingstatus_change();" disabled="disabled" />
        <label for="chksetpostingstatus" class="text_small">Post status wise</label></td>
      <td align="left" valign="middle"><span class="error">&nbsp;</span>Post Status</td>
      <td align="left" valign="middle"><select name="posting_status" id="posting_status" disabled="disabled" style="width:170px;">
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
    <td align="left"><input type="checkbox" id="chksetnumberofemployee" name="chksetnumberofemployee" onclick="return chksetnumberofemployee_change();" disabled="disabled" />
        <label for="chksetnumberofemployee" class="text_small">Number of employee wise<br /></label></td> 
      <td align="left" valign="middle"><span class="error">&nbsp;</span>Number of employee</td>
      <td align="left" valign="middle"><input type="text" name="numberofemployee" id="numberofemployee" disabled="disabled" style="width:162px;" onkeypress="javascript:return wholenumbersonly(event);" />
      </td>
       <td colspan="2">&nbsp;</td>         
    </tr>
     <tr>
      <td align="center" colspan="6"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
      <td colspan="6" align="center"><input type="submit" name="submit" id="submit" value="Swapping" class="button" onclick="javascript:return validate();" /></td>
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
<div id="fakecontainer" style="display:none;"><div id="loading">Please wait...</div></div> 
</body>

</html>

<script language="javascript" type="text/javascript">
(function (d) {
  d.getElementById('form1').onsubmit = function () {
	  d.getElementById('form1').style.display= 'none';
      d.getElementById('fakecontainer').style.display = 'block';
  };
}(document));
</script>