<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Single Personnel Replacement</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function per_id_change(str)
{
	
	//alert(subdiv_cd);
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  xmlhttp1=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
	 
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("ofc_id").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
			if(xmlhttp1.responseText.length!=0)
			{
				document.getElementById("op_dtl").innerHTML=xmlhttp1.responseText;
				document.getElementById('search').disabled=false;
			}
		
		}
	  }
	
	xmlhttp.open("GET","ajax-replacement.php?p_id="+str,true);
	xmlhttp1.open("GET","ajax-replacement.php?p_id="+str+"&p_dtl=y",true);
	
	xmlhttp.send();
	xmlhttp1.send();
}
function new_per_search()
{
	document.getElementById('replace').disabled=true;
	var forpc=document.getElementById('hid_forpc').innerHTML;
	var for_subdiv=document.getElementById('hid_for_subdiv').innerHTML;
	var forassembly=document.getElementById('hid_forassembly').innerHTML;
	var ofc_id=document.getElementById('ofc_id').innerHTML;
	var booked=document.getElementById('hid_booked').innerHTML;
	var gender=document.getElementById('hid_gender').innerHTML;
	var post_stat=document.getElementById('hid_post_stat').innerHTML;
	var subdiv_cd='<?php print $subdiv_cd; ?>';
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  xmlhttp2=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	   xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("new_personnel").innerHTML=xmlhttp.responseText;
		
		if(document.getElementById("new_personnel").innerHTML!='')
		{
			document.getElementById('replace').disabled=false;
			$("#venue_sch").show();
			$("#post_sch").show();
			
		}
		else
		{
			document.getElementById('replace').disabled=true;	
			$("#venue_sch").hide();
			$("#difnt_sch").hide();
			$("#post_sch").hide();
			$("#difnt_post").hide();
			
		}
		document.getElementById('print').disabled=true;
		}
	  }
	   xmlhttp2.onreadystatechange=function()
	  {
	  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
		document.getElementById("drop_sch").innerHTML=xmlhttp2.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-replacement.php?forpc="+forpc+"&post_stat="+post_stat+"&gender="+gender+"&ofc_id="+ofc_id+"&for_subdiv="+for_subdiv+"&opn=new_search",true);
	xmlhttp2.open("GET","ajax-replacement.php?subdiv_cd="+subdiv_cd+"&poststat="+post_stat+"&opn=new_search",true);
	xmlhttp.send();
	xmlhttp2.send();
}
function replacement()
{
	var training_sch=document.getElementById('training_sch').value;
	var old_p_id=document.getElementById('hid_per_cd').innerHTML;
	var booked=document.getElementById('hid_booked').innerHTML;
	var new_p_id=document.getElementById('new_per_id').innerHTML;
	var forassembly=document.getElementById('hid_forassembly').innerHTML;
	var forpc=document.getElementById('hid_forpc').innerHTML;
	var reason=document.getElementById('reason').value;
	var samevenuetraining=document.getElementById('chkSameVenueTraining').checked;
	var chngepoststatus=document.getElementById('chkpoststatus').checked;
	//var per_id1=document.getElementById('per_id').value;
	var post_status=document.getElementById("post_status").value;
	var usercd=<?php print $user_cd; ?>;
	//alert(per_id1);
	/*if(per_id1=="")
	{
		document.getElementById("msg").innerHTML="Select Personnel ID";
		document.getElementById("per_id").focus();
		return false;
	}*/
	
	if(document.getElementById('chkpoststatus').checked==true)
	{
			if(post_status=="")
			{
				document.getElementById("msg").innerHTML="Select Post Status";
				document.getElementById("post_status").focus();
				return false;
			}
	}
	if(document.getElementById('chkSameVenueTraining').checked==false)
	{
		/*if(training_sch=="")
		{
			document.getElementById("msg").innerHTML="Select Training Schedule";
				document.getElementById("training_sch").focus();
				return false;
		}*/
	}
	else
	{
		document.getElementById('training_sch').value='';
	}
	//alert(old_p_id+","+new_p_id+","+assembly+","+groupid);
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
			//alert(xmlhttp.responseText.length);
			if(xmlhttp.responseText.length==8)
			{
					document.getElementById("o_booked").innerHTML=xmlhttp.responseText;
					document.getElementById('n_booked').innerHTML='Yes';
					document.getElementById('replace').disabled=true;
					document.getElementById('search').disabled=true;
					//document.getElementById('p_id').disabled=true;
					document.getElementById('print').disabled=false;
			}
			else 
			{
				    document.getElementById("new_personnel").innerHTML=xmlhttp.responseText;
					document.getElementById('replace').disabled=false;
					document.getElementById('search').disabled=false;
					//document.getElementById('p_id').disabled=true;
					document.getElementById('print').disabled=true;
			}
	
		}
	  }
	  //alert("ajax-replacement.php?old_p_id="+old_p_id+"&new_p_id="+new_p_id+"&forassembly="+forassembly+"&forpc="+forpc+"&opn=pg_rplc&samevenuetraining="+samevenuetraining);
	xmlhttp.open("GET","ajax-replacement.php?training_sch="+training_sch+"&old_p_id="+old_p_id+"&booked="+booked+"&new_p_id="+new_p_id+"&forassembly="+forassembly+"&forpc="+forpc+"&opn=pg_rplc&samevenuetraining="+samevenuetraining+"&reason="+reason+"&usercd="+usercd+"&chngepoststatus="+chngepoststatus+"&post_status="+post_status,true);
	xmlhttp.send();
}
function print_appletter()
{
	var new_p_id=document.getElementById('new_per_id').innerHTML;
	var old_p_id=document.getElementById('hid_per_cd').innerHTML;
	//exit;
	var usercd=<?php print $user_cd; ?>;
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
		window.open(xmlhttp.responseText);
		}
	  }

	xmlhttp.open("GET","ajax-appointment.php?p_id="+new_p_id+"&old_p_id="+old_p_id+"&usercd="+usercd+"&opn=app_replacement",true);
	xmlhttp.send();
}
function schedule_change(str)
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
		document.getElementById("venue_details").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-replacement.php?schedule_cd="+str+"&opn=venue_details",true);
	xmlhttp.send();
}
</script>
</head>

<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
  </tr>
  
<tr><td align="center"><?php print $district." DISTRICT"; ?></td></tr>
<tr><td align="center"><?php print $subdiv_name." SUBDIVISION"; ?></td></tr>
<tr><td align="center">PRE GROUPING REPLACEMENT</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" enctype="multipart/form-data">
<table width="95%" class="form" cellpadding="0">
	<tr>
      <td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
    	<td width="50%" class="table2" valign="top">
        	<table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td align="center" colspan="4"><b>OLD PERSONNEL</b></td>
                </tr>
                <tr><td align="center"><img src='images/blank.gif' alt='' height='5px' /></td></tr>
                <tr>
                	<td align="left"><b>Personnel ID:</b></td>
                    <td align="left"><input type="text" name="per_id" id="per_id" style="width:152px;" onkeyup="return per_id_change(this.value);" maxlength="11" onkeypress="javascript:return wholenumbersonly(event);" /></td>
                    <td align="left"><b>Office ID:</b></td>
                    <td align="left" width="70px"><span id="ofc_id"></span></td>
                </tr>
                <tr>
                	<td colspan="4"><span id="op_dtl"></span></td>
                </tr>
            </table>
        </td>
    	<td width="50%" class="table2  demo-section1" valign="top"><span id="new_personnel">&nbsp;</span></td>
    </tr>
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="1" /></td></tr>
	<tr><td colspan="2" align="right">Reason for Replacement: &nbsp;<input type="text" name="reason" id="reason" maxlength="30" style="width:250px" /></td></tr>
    
    <tr><td colspan="2" align="left" style="display:none;" id="post_sch"><input type="checkbox" id="chkpoststatus" name="chkpoststatus" onclick="return chkpoststatus_change();" />
    <label for="chkpoststatus">Change Post Status for Old Personnel</label></td></tr>  
	  <tr><td colspan="2" style="height: 1px; background-color: #0066CC; color: #FFFFFF; font-weight:bold;"></td></tr>
    
    <tr style="display:none;" id="difnt_post" >
      
          <td align="left" colspan="2" style="padding-top:2px;"><span class="error">*</span>Post Status&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<select name="post_status" id="post_status" style="width:220px;">
	    <option value="">-Select Post Status-</option>
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
     
     </tr>
    
     
    <tr><td colspan="2" align="left" style="display:none;" id="venue_sch"><input type="checkbox" id="chkSameVenueTraining" name="chkSameVenueTraining" checked onclick="return chkSameVenueTraining_change();" />
    <label for="chkSameVenueTraining">Training at Same Venue for New Personnel</label></td></tr>
      <tr><td colspan="2" style="height: 1px; background-color: #0066CC; color: #FFFFFF; font-weight:bold;"></td></tr>
    
     <tr style="display:none;" id="difnt_sch" >
          <td align="left" style="padding-top:2px;"><span class="error">&nbsp;&nbsp;</span>Training Schedule Code &nbsp;&nbsp;&nbsp; <span id="drop_sch"><select name="training_sch" id="training_sch" style="width:220px;">
	    <option value="">-Select Training Schedule-</option>
	    </select></span></td>
          <td align="left" id="venue_details" style="font-size:10.4px">&nbsp;
           
          </td>
     </tr>
     
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="1" /></td></tr>
    <tr>
    	<td align="center" colspan="2">
        	<input id="search" name="search" value="Search" type="button" onclick="return new_per_search();" disabled="true" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="replace" name="replace" value="Replace" type="button" onclick="return replacement();" disabled="true" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="print" name="print" value="Print Appointment Letter" type="button" onclick="return print_appletter();" disabled="true" />
        </td>
    </tr>
    <tr><td><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table>
</form>
</td></tr></table>
</td></tr></table>
</div>
</body>
<script>
function chkSameVenueTraining_change()
{
	if(document.getElementById('chkSameVenueTraining').checked==true)
	{
		$("#difnt_sch").hide();
		document.getElementById('training_sch').value='';
		schedule_change('');
		
	}
	else
	{
		$("#difnt_sch").show();
	}
}
function chkpoststatus_change()
{
	if(document.getElementById('chkpoststatus').checked==true)
	{
			$("#difnt_post").show();
	}
	else
	{
		$("#difnt_post").hide();
		document.getElementById('post_status').value='';
	
	}
}
</script>
</html>