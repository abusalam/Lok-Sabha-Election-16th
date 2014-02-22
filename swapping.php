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
	
	xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
			document.getElementById("pc_result").innerHTML=xmlhttp1.responseText;
		}
	  }	 
    xmlhttp1.open("GET","ajaxfun.php?subdiv_swp="+str+"&opn=pc_swp",true);
	xmlhttp1.send();
	
	xmlhttp2.onreadystatechange=function()
	  {
	  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			document.getElementById("poststat_details").innerHTML=xmlhttp2.responseText;
		}
	  }
	 
    xmlhttp2.open("GET","ajaxfun.php?sub_swp="+str+"&opn=poststat",true);
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
	 
    xmlhttp2.open("GET","ajaxfun.php?forsub_swp="+str+"&opn=prev_poststat",true);
	xmlhttp2.send();
}
	
function chksetsubdivision_change()
{
	
	if(document.getElementById('chksetsubdivision').checked==true)
	{
		/*document.getElementById('chksetoffice').checked=true;*/
		/*chksetoffice.checked=true;*/
		document.getElementById('Subdivision').disabled=false;
		document.getElementById('forsubdivision').disabled=false;
		document.getElementById('pc').disabled=false;
		document.getElementById('forpc').disabled=false;
		
		document.getElementById('chksetoffice').disabled=false;
		document.getElementById('chksetpostingstatus').disabled=false;
		document.getElementById('chksetnumberofemployee').disabled=false;
		
		/*chksetoffice.disabled=false;*/
	}
	else if(document.getElementById('chksetsubdivision').checked==false)
	
	{
		document.getElementById('chksetoffice').checked=false;
		document.getElementById('chksetoffice').disabled=true;
		document.getElementById('Subdivision').disabled=true;
		document.getElementById('Subdivision').selectedIndex="0";
		document.getElementById('forsubdivision').disabled=true;
		document.getElementById('forsubdivision').selectedIndex="0";
		document.getElementById('officename').disabled=true;
		document.getElementById('officename').selectedIndex="";
		
		document.getElementById('chksetpostingstatus').disabled=true;
		document.getElementById('chksetpostingstatus').checked=false;
		document.getElementById('posting_status').selectedIndex="0";
		document.getElementById('posting_status').disabled=true;
		document.getElementById('chksetnumberofemployee').disabled=true;
		document.getElementById('chksetnumberofemployee').checked=false;
		document.getElementById('numberofemployee').disabled=true;
		document.getElementById('numberofemployee').value="";
	}
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
}
function chksetoffice_change()
{
	if(document.getElementById('chksetoffice').checked==true)
	{
		//chksetsubdivision.checked=true;
		//document.getElementById('Subdivision').disabled=false;
		//document.getElementById('forsubdivision').disabled=false;
		document.getElementById('officename').disabled=false;
	}
	else if(document.getElementById('chksetoffice').checked==false)	
	{
		//document.getElementById('Subdivision').disabled=true;
		//document.getElementById('Subdivision').selectedIndex="0";
		//document.getElementById('forsubdivision').disabled=true;
		//document.getElementById('forsubdivision').selectedIndex="0";
		document.getElementById('officename').disabled=true;
		document.getElementById('officename').selectedIndex="0";
	}
}

function chksetpostingstatus_change()
{
	if(document.getElementById('chksetpostingstatus').checked==true)
	{
		//chksetsubdivision.checked=true;
		//document.getElementById('Subdivision').disabled=false;
		//document.getElementById('forsubdivision').disabled=false;
		document.getElementById('posting_status').disabled=false;
	}
	else if(document.getElementById('chksetpostingstatus').checked==false)
	{
		//document.getElementById('Subdivision').disabled=true;
		//document.getElementById('Subdivision').selectedIndex="0";
		//document.getElementById('forsubdivision').disabled=true;
		//document.getElementById('forsubdivision').selectedIndex="0";
		document.getElementById('posting_status').disabled=true;
		document.getElementById('posting_status').selectedIndex="0";
	}
}
function chksetnumberofemployee_change()
{
	if(document.getElementById('chksetnumberofemployee').checked==true)
	{
		//chksetsubdivision.checked=true;
		//document.getElementById('Subdivision').disabled=false;
		//document.getElementById('forsubdivision').disabled=false;
		document.getElementById('numberofemployee').disabled=false;
	}
	else if(document.getElementById('chksetnumberofemployee').checked==false)
	{
		
		//document.getElementById('Subdivision').disabled=true;
		//document.getElementById('Subdivision').selectedIndex="0";
		//document.getElementById('forsubdivision').disabled=true;
		//document.getElementById('forsubdivision').selectedIndex="0";
		document.getElementById('numberofemployee').disabled=true;
		document.getElementById('numberofemployee').value="";
	}
}

function validate()
{
	var subdivision=document.getElementById("Subdivision").value;
	var forsubdivision=document.getElementById("forsubdivision").value;
	if(subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision Name";
		document.getElementById("Subdivision").focus();
		return false;
	}
	if(forsubdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select For Subdivision Name";
		document.getElementById("forsubdivision").focus();
		return false;
	}
	
}
</script>

</head>
<?php
include_once('inc\db_trans.inc.php');
include_once('function\add_fun.php');
$action=$_REQUEST['submit'];
if($action=='Swapping')
{
	$subdivision=$_POST['Subdivision'];
	$forsubdivision=$_POST['forsubdivision'];
	$pc=$_POST['pc'];
	$forpc=$_POST['forpc'];
	$officename=$_POST['officename'];
	$posting_status=$_POST['posting_status'];
	$numberofemployee=$_POST['numberofemployee'];
	$usercd=$user_cd;
	if ($subdivision>0)
	{
	    $rsEmp=fatch_PersonaldtlAgSubdiv($subdivision,$pc,$officename,$posting_status);
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
			include_once('inc\commit_con.php');
			mysqli_autocommit($link,FALSE);
			$sql="insert into personnela (personcd,officecd,officer_name,off_desg,present_addr1,present_addr2,";
			$sql.="perm_addr1,perm_addr2,dateofbirth,gender,scale,basic_pay,grade_pay,workingstatus,email,resi_no, mob_no,";
			$sql.="qualificationcd,languagecd,epic,acno,slno,partno,poststat,assembly_temp,assembly_off,assembly_perm,";
			$sql.="districtcd,subdivisioncd,forsubdivision,bank_acc_no,";
			$sql.="bank_cd, branchcd, remarks, pgroup, upload_file,usercode,forpc,forassembly,groupid,booked,rand_numb,edcpb) values (";
			$sql.="?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$stmt = mysqli_prepare($link, $sql);
			$sql_up="update personnel set f_cd=? where personcd=?";
			$stmt_up = mysqli_prepare($link, $sql_up);
			$row_aff=0;
			for($i=1;$i<=$num_rows;$i++)
			{ 
				$rowEmp=getRows($rsEmp);
				//print_r($rowEmp); exit;
				$personcd=$rowEmp['personcd'];
				$officecd=$rowEmp['officecd'];
				$officer_name=$rowEmp['officer_name'];
				$off_desg=$rowEmp['off_desg'];
				$present_addr1=$rowEmp['present_addr1'];
				$present_addr2=$rowEmp['present_addr2'];
				$perm_addr1=$rowEmp['perm_addr1'];
				$perm_addr2=$rowEmp['perm_addr2'];
				$dateofbirth=$rowEmp['dateofbirth'];
				$gender=$rowEmp['gender'];
				$scale=$rowEmp['scale'];
				$basic_pay=$rowEmp['basic_pay'];
				$grade_pay=$rowEmp['grade_pay'];
				$workingstatus=$rowEmp['workingstatus'];
				$email=$rowEmp['email'];
				$resi_no=$rowEmp['resi_no'];
				$mob_no=$rowEmp['mob_no'];
				$qualificationcd=$rowEmp['qualificationcd'];
				$languagecd=$rowEmp['languagecd'];
				$epic=$rowEmp['epic'];
				$acno=$rowEmp['acno'];
				$slno=$rowEmp['slno'];
				$partno=$rowEmp['partno'];
				$poststat=$rowEmp['poststat'];
				$assembly_temp=$rowEmp['assembly_temp'];
				$assembly_off=$rowEmp['assembly_off'];
				$assembly_perm=$rowEmp['assembly_perm'];
				$districtcd=$rowEmp['districtcd'];
				$subdivisioncd=$rowEmp['subdivisioncd'];
				$bank_acc_no=$rowEmp['bank_acc_no'];
				$bank_cd=$rowEmp['bank_cd'];
				$branchcd=$rowEmp['branchcd'];
				$remarks=$rowEmp['remarks'];
				$pgroup=$rowEmp['pgroup'];
				$upload_file=$rowEmp['upload_file'];
				if($forpc=="" || $forpc=="0")
				{
					$forpc=$rowEmp['pccd'];
				}
				if($pc==$forpc)
				{
					$edcpb='E';
				}
				else
				{
					$edcpb='P';
				}
				//$usercode=$rowmaxcode['usercode'];
				$f_cd=1;
				
				//$forpc=NULL;
				$forassembly=NULL;
				$groupid=NULL;
				$booked=NULL;
				$rand_numb=NULL;
				
				mysqli_stmt_bind_param($stmt, 'sssssssssssiisssssssssssssssssssssssissisis', $personcd,$officecd,$officer_name,$off_desg,$present_addr1,$present_addr2,$perm_addr1,$perm_addr2,$dateofbirth,$gender,$scale,$basic_pay,$grade_pay,$workingstatus,$email,$resi_no,$mob_no,$qualificationcd,$languagecd,$epic,$acno,$slno,$partno,$poststat,$assembly_temp,$assembly_off ,$assembly_perm,$districtcd,$subdivision,$forsubdivision,$bank_acc_no,$bank_cd,$branchcd,$remarks,$pgroup,$upload_file,$usercd,$forpc,$forassembly,$groupid,$booked,$rand_numb,$edcpb);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_param($stmt_up, 'is', $f_cd,$personcd);
				mysqli_stmt_execute($stmt_up);
				$row_aff+=mysqli_stmt_affected_rows($stmt);
				mysqli_stmt_affected_rows($stmt_up);
				$rowEmp=NULL;
			}
			if (!mysqli_commit($link)) {
				print("Transaction commit failed\n");
				exit();
			}
			else
			{
				$msg="<div class='alert-success'>".$row_aff." Record(s) transffered successfully</div>";
			}
			mysqli_stmt_close($stmt);
			mysqli_stmt_close($stmt_up);
			/* close connection */
			mysqli_close($link);
			
			$rsEmp=NULL;
		}
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
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">EMPLOYEE SWAPPING DETAILS </td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" enctype="multipart/form-data">
  <table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="6"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="6" align="center"><?php print $msg; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="6"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
    <td align="left"><input type="checkbox" id="chksetsubdivision" name="chksetsubdivision" onclick="return chksetsubdivision_change();" />
        <label for="chksetsubdivision" class="text_small">Sub division wise<br />
          </label></td>
    
      <td align="left" valign="top"><span class="error">*</span>Sub Division</td>
      <td align="left" valign="top"><select name="Subdivision" id="Subdivision" style="width:170px;" disabled="disabled" onchange="return fatch_office_agsubdiv(this.value);">
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
                <td align="left" valign="top"><span class="error">*</span>For Sub Division</td>
      <td align="left" valign="top"><select name="forsubdivision" id="forsubdivision" style="width:170px;" disabled="disabled" onchange="return for_subdiv_change(this.value);">
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
    <td align="left" valign="top"><span class="error">*</span>PC</td>
    <td align="left" valign="top" id="pc_result"><select name="pc" id="pc" style="width:170px;" disabled="disabled" onchange="return pc_change(this.value);"></select></td>
                <td align="left" valign="top"><span class="error">*</span>For PC</td>
      <td align="left" valign="top" id="forpc_result"><select name="forpc" id="forpc" style="width:170px;" disabled="disabled" onchange="return forpc_change(this.value);"></select></td>
    </tr>
    <tr><td class="text_small" align="right">Total Member&nbsp;&nbsp;&nbsp;&nbsp;</td><td align="left" id="poststat_details" colspan="2" class="text_small"></td>
    	<td align="left" id="for_poststat_details" colspan="2" class="text_small"></td></tr>
    <tr>
    <td align="left"><input type="checkbox" id="chksetoffice" name="chksetoffice" onclick="return chksetoffice_change();" disabled="disabled" />
        <label for="chksetoffice" class="text_small">Office wise<br />
         </label></td>   
      <td align="left" valign="top"><span class="error">&nbsp;</span>Office Name</td>
      <td align="left" valign="top"><span id='office_details'><select name="officename" id="officename" disabled="disabled" style="width:170px;">
</select></span></td><td colspan="2">&nbsp;</td> 
    </tr>
    <tr>
    <td align="left"><input type="checkbox" id="chksetpostingstatus" name="chksetpostingstatus" onclick="return chksetpostingstatus_change();" disabled="disabled" />
        <label for="chksetpostingstatus" class="text_small">Post status wise<br /></label></td>
      <td align="left" valign="top"><span class="error">&nbsp;</span>Posting Status</td>
      <td align="left" valign="top"><select name="posting_status" id="posting_status" disabled="disabled" style="width:170px;">
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
      <td align="left" valign="top"><span class="error">&nbsp;</span>Number of employee</td>
      <td align="left" valign="top"><input type="text" name="numberofemployee" id="numberofemployee" disabled="disabled" style="width:162px;" />
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