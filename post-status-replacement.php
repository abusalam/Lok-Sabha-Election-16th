<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Post Status Replacement</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function personnel_list()
{
	var ass=document.getElementById('assembly').value;
	var polling_party=document.getElementById('polling_party_no').value;
	var post_stat=document.getElementById('posting_status').value;	
	$('#assembly_new').val(+ass);
	$('#polling_party_no_new').val(+polling_party);
	
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
		document.getElementById("personnel_list").innerHTML=xmlhttp.responseText;
		  personnel_list_new();
		}
	  }
	xmlhttp.open("GET","ajax-replacement.php?ass="+ass+"&polling_party="+polling_party+"&post_stat="+post_stat,true);
	xmlhttp.send();
}
function personnel_list_new()
{
	var ass=document.getElementById('assembly_new').value;
	var polling_party=document.getElementById('polling_party_no_new').value;
	var post_stat=document.getElementById('posting_status_new').value;
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
		document.getElementById("personnel_list_new").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-post-status-replacement.php?ass="+ass+"&polling_party="+polling_party+"&post_stat="+post_stat,true);
	xmlhttp.send();
}
function fatch_personnel_dtl(str)
{
	//alert(str);
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
				//document.getElementById('replace').disabled=false;
			}
		}
	  }
	xmlhttp.open("GET","ajax-replacement.php?p_id="+str,true);
	xmlhttp1.open("GET","ajax-replacement.php?p_id="+str+"&p_dtl=y",true);
	xmlhttp.send();
	xmlhttp1.send();
}
/*function new_per_search()
{
	document.getElementById('replace').disabled=true;
	var for_subdiv=document.getElementById('hid_for_subdiv').innerHTML;
	var assembly=document.getElementById('assembly').value;
	var posting_status=document.getElementById('posting_status').value;
	var pre_ass=document.getElementById('hid_pre_ass').innerHTML;
	var per_ass=document.getElementById('hid_per_ass').innerHTML;
	var post_ass=document.getElementById('hid_post_ass').innerHTML;
	var forpc=document.getElementById('hid_forpc').innerHTML;
	var forassembly=document.getElementById('hid_forassembly').innerHTML;
	var groupid=document.getElementById('hid_groupid').innerHTML;
	var booked=document.getElementById('hid_booked').innerHTML;
	var gender=document.getElementById('hid_gender').innerHTML;
	
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
		document.getElementById("new_personnel").innerHTML=xmlhttp.responseText;
		
		if(document.getElementById("new_personnel").innerHTML!='')
			document.getElementById('replace').disabled=false;
		else
			document.getElementById('replace').disabled=true;	
		document.getElementById('print').disabled=true;
		}
	  }
	xmlhttp.open("GET","ajax-replacement.php?for_subdiv="+for_subdiv+"&forpc="+forpc+"&assembly="+forassembly+"&posting_status="+posting_status+"&groupid="+groupid+"&gender="+gender+"&opn=g_new_per",true);
	xmlhttp.send();
}*/
function fatch_new_personnel_dtl(str)
{
	//alert(str);
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp2=new XMLHttpRequest();
	  xmlhttp3=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	  xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp2.onreadystatechange=function()
	  {
	  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
		document.getElementById("ofc_id_new").innerHTML=xmlhttp2.responseText;
		}
	  }
	xmlhttp3.onreadystatechange=function()
	  {
	  if (xmlhttp3.readyState==4 && xmlhttp3.status==200)
		{
			//alert(xmlhttp3.responseText.length);
			if(xmlhttp3.responseText.length!=0)
			{
				document.getElementById("op_dtl_new").innerHTML=xmlhttp3.responseText;				
				document.getElementById('replace').disabled=false;				
			}
			
			
		}
	  }
	xmlhttp2.open("GET","ajax-post-status-replacement.php?p_id="+str,true);
	xmlhttp3.open("GET","ajax-post-status-replacement.php?p_id="+str+"&p_dtl=y",true);
	xmlhttp2.send();
	xmlhttp3.send();
}
function fatch_new_personnel_dtl_after_replace(str)
{
	//alert(str);
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp2=new XMLHttpRequest();
	  xmlhttp3=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	  xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp2.onreadystatechange=function()
	  {
	  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
		document.getElementById("ofc_id_new").innerHTML=xmlhttp2.responseText;
		}
	  }
	xmlhttp3.onreadystatechange=function()
	  {
	  if (xmlhttp3.readyState==4 && xmlhttp3.status==200)
		{
			//alert(xmlhttp3.responseText.length);
			if(xmlhttp3.responseText.length!=0)
			{
				document.getElementById("op_dtl_new").innerHTML=xmlhttp3.responseText;				
				document.getElementById('replace').disabled=true;				
			}
			
			
		}
	  }
	xmlhttp2.open("GET","ajax-post-status-replacement.php?p_id="+str,true);
	xmlhttp3.open("GET","ajax-post-status-replacement.php?p_id="+str+"&p_dtl=y",true);
	xmlhttp2.send();
	xmlhttp3.send();
}
function replacement()
{
	var old_p_id=document.getElementById('p_id').value;
	var new_p_id=document.getElementById('newp_id').value;
	var assembly=document.getElementById('assembly').value;
	var groupid=document.getElementById('polling_party_no').value;
	var post_stat=document.getElementById('posting_status').value;
	var post_stat_new=document.getElementById('posting_status_new').value;
	
	if(old_p_id=='' || old_p_id=='0')
	{
		document.getElementById('msg').innerHTML="Select Personnel ID";
		return false;
	}
	if(new_p_id=='' || new_p_id=='0')
	{
		document.getElementById('msg').innerHTML="Select Personnel ID";
		return false;
	}
	if(post_stat==post_stat_new)
	{
		document.getElementById('msg').innerHTML="Post Status should be different";
		document.getElementById('replace').disabled=true;
		 return false;
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
		//document.getElementById("o_booked").innerHTML=xmlhttp.responseText;
		document.getElementById('msg').innerHTML="";
	//	alert(old_p_id);
		fatch_personnel_dtl(old_p_id);
		
	//	document.getElementById('n_booked').innerHTML='Yes';
		
		document.getElementById('newp_id').disabled=true;
		document.getElementById('p_id').disabled=true;
		document.getElementById('print').disabled=false;
		document.getElementById('print1').disabled=false;
		fatch_new_personnel_dtl_after_replace(new_p_id);
		document.getElementById('replace').disabled=true;
		document.getElementById('fakecontainer').style.display= 'none';
		}
	  }
	xmlhttp.open("GET","ajax-post-status-replacement.php?old_p_id="+old_p_id+"&new_p_id="+new_p_id+"&ass="+assembly+"&post_stat="+post_stat+"&groupid="+groupid+"&post_stat_new="+post_stat_new+"&opn=g_rplc",true);
	
	document.getElementById('fakecontainer').style.display = 'block';
	xmlhttp.send();
}
function print_appletter()
{
	var poststat=document.getElementById('posting_status').value;
	var new_p_id=document.getElementById('newp_id').value;
	var booked='';
	var forpc='';
	var forassembly=document.getElementById('assembly').value;
	var groupid=document.getElementById('polling_party_no').value;
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
		//document.getElementById('msg').innerHTML=xmlhttp.responseText;
		}
	  }

	xmlhttp.open("GET","ajax-appointment.php?poststat="+poststat+"&p_id="+new_p_id+"&booked="+booked+"&forpc="+forpc+"&forassembly="+forassembly+"&groupid="+groupid+"&opn=gp_replacement",true);
	xmlhttp.send();
}
function print_appletter1()
{
	var poststat=document.getElementById('posting_status').value;
	var new_p_id=document.getElementById('newp_id').value;
	var booked='';
	var forpc='';
	var forassembly=document.getElementById('assembly').value;
	var groupid=document.getElementById('polling_party_no').value;
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
		//document.getElementById('msg').innerHTML=xmlhttp.responseText;
		}
	  }

	xmlhttp.open("GET","ajax-appointment.php?poststat="+poststat+"&p_id="+new_p_id+"&booked="+booked+"&forpc="+forpc+"&forassembly="+forassembly+"&groupid="+groupid+"&opn=gp_replacement6",true);
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
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $subdiv_name." SUBDIVISION"; ?></td></tr>
<tr><td align="center"><b>POST STATUS SWAPPING IN POLLING PERSONNEL GROUP</b></td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" enctype="multipart/form-data">
<table width="95%" class="form" cellpadding="0">
	<tr>
      <td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="3" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="3"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
    	<td width="50%" class="table2" valign="top">
        	<table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td align="center" colspan="4"><b>POLLING PERSONNEL</b></td>
                </tr>
                <tr><td align="center"><img src='images/blank.gif' alt='' height='5px' /></td></tr>
                <tr>
                	<td align="left">Assembly:</td>
                    <td align="left"><select id="assembly" name="assembly" style="width:150px;" onchange="return personnel_list();">
										<option value="0">-Select Assembly-</option>
										<?php 	$subdiv;
												$subdiv=$subdiv_cd;
												$rsAssembly=fatch_assembly_ag_subdiv($subdiv);
												$num_rows = rowCount($rsAssembly);
												if($num_rows>0)
												{
													for($i=1;$i<=$num_rows;$i++)
													{
														$rowAssembly=getRows($rsAssembly);
														echo "<option value='$rowAssembly[0]'>$rowAssembly[2]</option>\n";
														$rowAssembly=NULL;
													}
												}
												unset($rsAssembly,$num_rows);
										?>
									</select></td>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                	<td align="left">Polling Party No:</td>
                    <td align="left"><input type="text" name="polling_party_no" id="polling_party_no" style="width:142px;" onkeyup="return personnel_list();" /></td><td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                	<td align="left">Post Status:</td>
                    <td align="left" colspan="3"><select id="posting_status" name="posting_status" onchange="return personnel_list();" style="width:150px;">
                    								<option value="0">-Select Posting Status-</option>
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
                <tr>
                	<td align="left"><b>Personnel ID:</b></td>
                    <td align="left"><span id="personnel_list"><select id="p_id" name="p_id" style="width:150px;" onchange="fatch_personnel_dtl(this.value);">
                    					<!--<option value="0">-Select Personnel ID-</option>-->
                                        <?php	/*$rsEmp=fatch_employee();
												$num_rows=rowCount($rsEmp);
												if($num_rows>0)
												{
													for($i=1;$i<=$num_rows;$i++)
													{
														$rowEmp=getRows($rsEmp);
														echo "<option value='$rowEmp[0]'>$rowEmp[0]</option>\n";
													}
												}
												$rsEmp=null;
												$num_rows=0;
												$rowEmp=null;*/
										?>
                    				</select>
                                    </span></td>
                    <td align="left"><b>Office ID:</b></td>
                    <td align="left" width="60px"><span id="ofc_id"></span></td>
                </tr>
                <tr>
                	<td colspan="4"><span id="op_dtl"></span></td>
                </tr>
            </table>
        </td>
    	<td width="50%" class="table2" valign="top">
              <table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td align="center" colspan="4"><b>POLLING PERSONNEL</b></td>
                </tr>
                <tr><td align="center"><img src='images/blank.gif' alt='' height='5px' /></td></tr>
                <tr>
                	<td align="left">Assembly:</td>
                    <td align="left"><select id="assembly_new" name="assembly_new" style="width:150px;" onchange="return personnel_list_new();" disabled="disabled">
										<option value="0">-Select Assembly-</option>
										<?php 	$subdiv;
												$subdiv=$subdiv_cd;
												$rsAssembly=fatch_assembly_ag_subdiv($subdiv);
												$num_rows = rowCount($rsAssembly);
												if($num_rows>0)
												{
													for($i=1;$i<=$num_rows;$i++)
													{
														$rowAssembly=getRows($rsAssembly);
														echo "<option value='$rowAssembly[0]'>$rowAssembly[2]</option>\n";
														$rowAssembly=NULL;
													}
												}
												unset($rsAssembly,$num_rows);
										?>
									</select></td>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                	<td align="left">Polling Party No:</td>
                    <td align="left"><input type="text" name="polling_party_no_new" id="polling_party_no_new" style="width:142px;" onkeyup="return personnel_list_new();" disabled="disabled"/></td><td colspan="2">&nbsp;</td>
                </tr>
               
                
                <tr>
                	<td align="left">Post Status:</td>
                    <td align="left" colspan="3"><select id="posting_status_new" name="posting_status_new" onchange="return personnel_list_new();" style="width:150px;">
                    								<option value="0">-Select Posting Status-</option>
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
                <tr>
                	<td align="left"><b>Personnel ID:</b></td>
                    <td align="left"><span id="personnel_list_new"><select id="newp_id" name="newp_id" style="width:150px;" onchange="fatch_new_personnel_dtl(this.value);">
                    					<!--<option value="0">-Select Personnel ID-</option>-->
                                        <?php	/*$rsEmp=fatch_employee();
												$num_rows=rowCount($rsEmp);
												if($num_rows>0)
												{
													for($i=1;$i<=$num_rows;$i++)
													{
														$rowEmp=getRows($rsEmp);
														echo "<option value='$rowEmp[0]'>$rowEmp[0]</option>\n";
													}
												}
												$rsEmp=null;
												$num_rows=0;
												$rowEmp=null;*/
										?>
                    				</select>
                                    </span></td>
                    <td align="left"><b>Office ID:</b></td>
                    <td align="left" width="60px"><span id="ofc_id_new"></span></td>
                </tr>
                <tr>
                	<td colspan="4"><span id="op_dtl_new"></span></td>
                </tr>
            </table>
        
        </td>
    </tr>
    <tr>
    	<td align="center" colspan="2">
        	
            <input id="replace" name="replace" value="Swapping" type="button" onclick="return replacement();" disabled="true" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="print" name="print" value="Print Appt Letter (4 or 5)" type="button" onclick="return print_appletter();" disabled="true" />
            <input id="print1" name="print1" value="Print Appt Letter (6)" type="button" onclick="return print_appletter1();" disabled="true" />
        </td>
    </tr>
</table>
</form>
</td></tr></table>
</td></tr></table>
</div>
<div id="fakecontainer" style="display:none;"><div id="loading">Please wait...</div></div>
</body>
</html>