<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>District Wise Swapping Details</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">


	
function chksetsubdivision_change()
{
	
	if(document.getElementById('chksetsubdivision').checked==true)
	{
		/*document.getElementById('chksetoffice').checked=true;*/
		/*chksetoffice.checked=true;*/
		document.getElementById('Subdivision').disabled=false;
		document.getElementById('tosubdivision').disabled=false;
		//document.getElementById('pc').disabled=false;
		//document.getElementById('forpc').disabled=false;
		//document.getElementById('ex_ass').disabled=false;
		
		//document.getElementById('chksetoffice').disabled=false;
		//document.getElementById('chksetpostingstatus').disabled=false;
		//document.getElementById('chksetnumberofemployee').disabled=false;
		
		//fatch_office_agsubdiv('0');
		//for_subdiv_change('0');
		/*chksetoffice.disabled=false;*/
	}
	else if(document.getElementById('chksetsubdivision').checked==false)	
	{
		//document.getElementById('chksetoffice').checked=false;
		//document.getElementById('chksetoffice').disabled=true;
		document.getElementById('Subdivision').disabled=true;
		document.getElementById('Subdivision').selectedIndex="0";

		
		document.getElementById('tosubdivision').disabled=true;
		document.getElementById('tosubdivision').selectedIndex="0";
		
		
	}
}
function chksetdistrict_change()
{
	if(document.getElementById('chksetdistrict').checked==true)
	{
		document.getElementById('district').disabled=false;
		document.getElementById('todistrict').disabled=false;
		document.getElementById('chksetoffice').disabled=false;
		document.getElementById('chksetpostingstatus').disabled=false;
		document.getElementById('chksetnumberofemployee').disabled=false;
		document.getElementById('chksetsubdivision').disabled=false;
	}
	else if(document.getElementById('chksetdistrict').checked==false)	
	{
		document.getElementById('district').disabled=true;
		document.getElementById('district').selectedIndex="0";
		
		document.getElementById('todistrict').disabled=true;
		document.getElementById('todistrict').selectedIndex="0";
		
		document.getElementById('chksetsubdivision').checked=false;
		document.getElementById('chksetsubdivision').disabled=true;
		
		document.getElementById('Subdivision').disabled=true;
		document.getElementById('Subdivision').selectedIndex="0";

		
		document.getElementById('tosubdivision').disabled=true;
		document.getElementById('tosubdivision').selectedIndex="0";
		
		document.getElementById('chksetoffice').checked=false;
		document.getElementById('chksetoffice').disabled=true;
		
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
$(document).ready(function(){  $('.overlay').fadeOut();  });
function fadein() {
	$("#submit").click(function () {
		$(".overlay").fadeIn();
	//	document.getElementById("submit").disabled=true;
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
	var district=document.getElementById("district").value;
	var todistrict=document.getElementById("todistrict").value;
	var Subdivision=document.getElementById("Subdivision").value;
	var tosubdivision=document.getElementById("tosubdivision").value;
	if(district=="0")
	{
		document.getElementById("msg").innerHTML="Select From District Name";
		document.getElementById("district").focus();
		fadeout();
		return false;
	}
	if(todistrict=="0")
	{
		document.getElementById("msg").innerHTML="Select To District Name";
		document.getElementById("todistrict").focus();
		fadeout();
		return false;
	}
    if(Subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select From Subdivision Name";
		document.getElementById("Subdivision").focus();
		fadeout();
		return false;
	}
    
	if(tosubdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select To Subdivision Name";
		document.getElementById("tosubdivision").focus();
		fadeout();
		return false;
	}
	document.getElementById("submit").innerHTML="";
	fadein();
	//document.getElementById("submit").disabled=true;
}
function fatch_from_district(str)
{
	document.getElementById('chksetsubdivision').checked=false;
	document.getElementById('chksetoffice').checked=false;
	document.getElementById('chksetpostingstatus').checked=false;
	fatch_office_fromsubdiv("0");
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp1=new XMLHttpRequest();
		xmlhttp2=new XMLHttpRequest();
		xmlhttp3=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
		xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	
	xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
			document.getElementById("from_sub_result").innerHTML=xmlhttp1.responseText;
		}
	  }	 
    xmlhttp1.open("GET","ajax/ajax_district_swap.php?frmdist="+str+"&opn=district",true);
	xmlhttp1.send();
	
	xmlhttp2.onreadystatechange=function()
	  {
	  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			document.getElementById("poststat_details").innerHTML=xmlhttp2.responseText;
		}
	  }
	 //alert("ajaxfun.php?sub_swp="+str+"&opn=poststat");
    xmlhttp2.open("GET","ajax/ajax_district_swap.php?frmdist="+str+"&opn=poststat",true);
	xmlhttp2.send();
	
	xmlhttp3.onreadystatechange=function()
	  {
	  if (xmlhttp3.readyState==4 && xmlhttp3.status==200)
		{
			document.getElementById("postdetails").innerHTML=xmlhttp3.responseText;
		}
	  }
	 //alert("ajaxfun.php?sub_swp="+str+"&opn=poststat");
    xmlhttp3.open("GET","ajax/ajax_district_swap.php?frmdist="+str+"&opn=postwise",true);
	xmlhttp3.send();
}
function fatch_office_fromsubdiv(str)
{
	document.getElementById('chksetoffice').checked=false;
	var district=document.getElementById('district').value;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
		//xmlhttp1=new XMLHttpRequest();
		xmlhttp2=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		//xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("office_details").innerHTML=xmlhttp.responseText;
		}
	  }	 
    xmlhttp.open("GET","ajax/ajax_district_swap.php?subdiv="+str+"&frmdist="+district+"&off=n",true);
	xmlhttp.send();
//	document.getElementById('chksetoffice').checked=false;
	
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
    xmlhttp2.open("GET","ajax/ajax_district_swap.php?subdiv="+str+"&frmdist="+district+"&opn=poststat",true);
	xmlhttp2.send();
}

function fatch_to_district(str)
{
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp1=new XMLHttpRequest();
		xmlhttp2=new XMLHttpRequest();
		//xmlhttp3=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
		xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
		//xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	
	xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
			document.getElementById("to_sub_result").innerHTML=xmlhttp1.responseText;
		}
	  }	 
    xmlhttp1.open("GET","ajax/ajax_todistrict_swap.php?todist="+str+"&opn=district",true);
	xmlhttp1.send();
	
	xmlhttp2.onreadystatechange=function()
	  {
	  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			document.getElementById("for_poststat_details").innerHTML=xmlhttp2.responseText;
		}
	  }
	 //alert("ajaxfun.php?sub_swp="+str+"&opn=poststat");
    xmlhttp2.open("GET","ajax/ajax_todistrict_swap.php?todist="+str+"&opn=prev_poststat",true);
	xmlhttp2.send();
	
}
function to_subdiv_change(str)
{
	var todist=document.getElementById('todistrict').value;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
		//xmlhttp1=new XMLHttpRequest();
		xmlhttp2=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
		//xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
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
	
	xmlhttp2.onreadystatechange=function()
	  {
	  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			document.getElementById("for_poststat_details").innerHTML=xmlhttp2.responseText;
		}
	  }
	 //alert("ajaxfun.php?forsub_swp="+str+"&opn=prev_poststat");
    xmlhttp2.open("GET","ajax/ajax_todistrict_swap.php?subdiv="+str+"&todist="+todist+"&opn=prev_poststat",true);
	xmlhttp2.send();
}
</script>
<?php

include_once('function/distwise_fun.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Swapping')
{
	$frmdist=isset($_POST['district'])?$_POST['district']:"";
	$todist=isset($_POST['todistrict'])?$_POST['todistrict']:"";
	$subdivision=isset($_POST['Subdivision'])?$_POST['Subdivision']:"";
	$tosubdivision=isset($_POST['tosubdivision'])?$_POST['tosubdivision']:"";
	$officename=isset($_POST['officename'])?$_POST['officename']:"";
	$posting_status=isset($_POST['posting_status'])?$_POST['posting_status']:"";
	$numberofemployee=isset($_POST['numberofemployee'])?$_POST['numberofemployee']:"";
	$usercd=$user_cd;
	
	    //$rsPer=fatch_Personal_wisedistrict($frmdist,$subdivision,$officename,$posting_status,$numberofemployee);
		//$num_row=2;
		
		//mysql_close($link);	
		
	  $rsEmp=fatch_Personaldistrict_wiseSubdiv($frmdist,$subdivision,$officename,$posting_status,$todist,$numberofemployee,$tosubdivision);
	   if($rsEmp<1)
		{
			$msg="<div class='alert-error'>No record found for transffer</div>";
		}
		else
		{
			   //--------------------------------------------		  
		   //----------------------------------	 
	//---------------------------------------
	       $msg="<div class='alert-success'>".$rsEmp." Record(s) transffered successfully</div>";
		}
		$rsEmp=NULL;
		
		
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
<tr><td align="center">DISTRICT WISE EMPLOYEE SWAPPING DETAILS </td></tr>
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
    <td align="left"><input type="checkbox" id="chksetdistrict" name="chksetdistrict" onclick="return chksetdistrict_change();" />
        <label for="chksetdistrict" class="text_small">District wise</label></td>
    
      <td align="left" valign="top"><span class="error">*</span>From District</td>
      <td align="left" valign="top"><select name="district" id="district" style="width:170px;" onchange="return fatch_from_district(this.value);" disabled="disabled">
      <option value="0">-Select From District-</option>    
                        <option value="Alipurduar">Alipurduar</option>
                        <option value="Bankura">Bankura</option>
                        <option value="Bardhaman">Bardhaman</option>  
                        <option value="Birbhum">Birbhum</option>                     
                        <option value="Cooch Behar">Cooch Behar</option>
                        <option value="Darjeeling">Darjeeling</option>
                        <option value="East Midnapore">East Midnapore</option>
                        <option value="Hooghly">Hooghly</option>
                        <option value="Howrah">Howrah</option>
                        <option value="Jalpaiguri">Jalpaiguri</option>
                        <option value="Kolkata">Kolkata</option>
                        <option value="Malda">Malda</option>
                        <option value="Murshidabad">Murshidabad</option>
                        <option value="Nadia">Nadia</option>
                        <option value="North 24 Parganas">North 24 Parganas</option>
                        <option value="Purulia">Purulia</option>                        
                        <option value="South 24 Parganas">South 24 Parganas</option>
                        <option value="South Dinajpur">South Dinajpur</option>
                        <option value="West Midnapore">West Midnapore</option>                   
      				</select></td>
      <td align="left" valign="top"><span class="error">*</span>To District</td>
      <td align="left" valign="top"><select name="todistrict" id="todistrict" style="width:170px;" onchange="return fatch_to_district(this.value);" disabled="disabled">
      <option value="0">-Select To District-</option>
                        <option value="Alipurduar">Alipurduar</option>
                        <option value="Bankura">Bankura</option>
                        <option value="Bardhaman">Bardhaman</option>  
                        <option value="Birbhum">Birbhum</option>                     
                        <option value="Cooch Behar">Cooch Behar</option>
                        <option value="Darjeeling">Darjeeling</option>
                        <option value="East Midnapore">East Midnapore</option>
                        <option value="Hooghly">Hooghly</option>
                        <option value="Howrah">Howrah</option>
                        <option value="Jalpaiguri">Jalpaiguri</option>
                        <option value="Kolkata">Kolkata</option>
                        <option value="Malda">Malda</option>
                        <option value="Murshidabad">Murshidabad</option>
                        <option value="Nadia">Nadia</option>
                        <option value="North 24 Parganas">North 24 Parganas</option>
                        <option value="Purulia">Purulia</option>                        
                        <option value="South 24 Parganas">South 24 Parganas</option>
                        <option value="South Dinajpur">South Dinajpur</option>
                        <option value="West Midnapore">West Midnapore</option>
      				</select></td>
    </tr>
    <tr>
   <td align="left"><input type="checkbox" id="chksetsubdivision" name="chksetsubdivision" onclick="return chksetsubdivision_change();" disabled="disabled" />
        <label for="chksetsubdivision" class="text_small">Sub division wise</label></td>
    
      <td align="left" valign="top"><span class="error">*</span>From Sub Division</td>
      <td align="left" valign="top" id="from_sub_result"><select name="Subdivision" id="Subdivision" style="width:170px;"  disabled="disabled" >
      <option value="0">-Select From Subdivision-</option>                           
     </select></td>
      <td align="left" valign="top"><span class="error">*</span>To Sub Division</td>
      <td align="left" valign="top" id="to_sub_result"><select name="tosubdivision" id="tosubdivision" style="width:170px;" disabled="disabled">
      <option value="0">-Select To Subdivision-</option>
                           
      				</select></td>
    </tr>
    
    
    <tr><td class="text_small" align="right">Total Member&nbsp;&nbsp;&nbsp;&nbsp;</td><td align="left" id="poststat_details" colspan="2" class="text_small"></td>
    	<td align="left" id="for_poststat_details" colspan="2" class="text_small"></td></tr>
    <tr>
    <td align="left"><input type="checkbox" id="chksetoffice" name="chksetoffice" onclick="return chksetoffice_change();" disabled="disabled"/>
        <label for="chksetoffice" class="text_small">Office wise
         </label></td>   
      <td align="left" valign="top"><span class="error">&nbsp;</span>Office Name</td>
      <td align="left" valign="top"><span id='office_details'><select name="officename" id="officename" disabled="disabled" style="width:170px;">
		  <option value="0">-Select Officename-</option>                           

</select></span></td><td colspan="2">&nbsp;</td> 
    </tr>
    <tr>
    <td align="left"><input type="checkbox" id="chksetpostingstatus" name="chksetpostingstatus" onclick="return chksetpostingstatus_change();" disabled="disabled" />
        <label for="chksetpostingstatus" class="text_small">Post status wise</label></td>
      <td align="left" valign="top"><span class="error">&nbsp;</span>Post Status</td>
      <td align="left" valign="top" id="postdetails"><select name="posting_status" id="posting_status" disabled="disabled" style="width:170px;">
      						<option value="0">-Select Post Status-</option>
                          
      				</select></td>
    <td colspan="2">&nbsp;</td>             
    </tr>
    <tr>
    <td align="left"><input type="checkbox" id="chksetnumberofemployee" name="chksetnumberofemployee" onclick="return chksetnumberofemployee_change();" disabled="disabled" />
        <label for="chksetnumberofemployee" class="text_small">Number of employee wise<br /></label></td> 
      <td align="left" valign="top"><span class="error">&nbsp;</span>Number of employee</td>
      <td align="left" valign="top"><input type="text" name="numberofemployee" id="numberofemployee" disabled="disabled" style="width:162px;" onkeypress="javascript:return wholenumbersonly(event);" />
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
</body>
</html>