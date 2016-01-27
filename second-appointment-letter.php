<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Appointment Letter</title>
<?php
include('header/header.php');
?>
<?php
$subdiv_cd="0";
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
?>
<script language="javascript" type="text/javascript">
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
function chksetsubdivision_change()
{
	
	if(document.getElementById('chksetsubdivision').checked==true)
	{
		document.getElementById('Subdivision').disabled=false;
		document.getElementById('txtfrom').disabled=false;
		
		document.getElementById('txtto').disabled=false;
		document.getElementById('chksetassembly').checked=false;
		document.getElementById('assembly').disabled=true;
		document.getElementById('assembly').selectedIndex="0";
		document.getElementById('txtGroupId').disabled=true;
		document.getElementById('txtGroupId').value="";
		
	}
	else if(document.getElementById('chksetsubdivision').checked==false)	
	{
		
		document.getElementById('Subdivision').disabled=true;
		document.getElementById('Subdivision').selectedIndex="0";
		
		document.getElementById('txtfrom').disabled=true;
		document.getElementById('txtfrom').value="";
		
		document.getElementById('txtto').disabled=true;
		document.getElementById('txtto').value="";
		
	}
}
function chksetassembly_change()
{
	
	if(document.getElementById('chksetassembly').checked==true)
	{
		//document.getElementById('Subdivision').disabled=false;
		//document.getElementById('txtfrom').disabled=true;
		
		//document.getElementById('txtto').disabled=true;
		document.getElementById('chksetsubdivision').checked=false;
		document.getElementById('assembly').disabled=false;
		document.getElementById('assembly').selectedIndex="0";
		document.getElementById('txtGroupId').disabled=false;
		document.getElementById('txtGroupId').value="";
		
		document.getElementById('Subdivision').disabled=true;
		document.getElementById('Subdivision').selectedIndex="0";
		
		document.getElementById('txtfrom').disabled=true;
		document.getElementById('txtfrom').value="";
		
		document.getElementById('txtto').disabled=true;
		document.getElementById('txtto').value="";
		
		
	}
	else if(document.getElementById('chksetassembly').checked==false)	
	{
		
		document.getElementById('assembly').disabled=true;
		document.getElementById('assembly').selectedIndex="0";
				
		document.getElementById('txtGroupId').disabled=true;
		document.getElementById('txtGroupId').value="";
		
	}
}
function validate()
{
	var chksub=document.getElementById('chksetsubdivision');
	var chkasbly=document.getElementById('chksetassembly');
	if((chksub.checked==false) && (chkasbly.checked==false))
	{
		document.getElementById('msg').innerHTML="Select Subdivision wise or Assembly wise";
		chksub.focus();
		return false;
	}
	else if((chksub.checked==true) && (chkasbly.checked==true))
	{
		document.getElementById('msg').innerHTML="Select Subdivision wise or Assembly wise";
		chksub.focus();
		return false;
	}
	if(chksub.checked==true)
	{
		var Subdivision=document.getElementById('Subdivision');
		if(Subdivision.value=='0')
		{
			document.getElementById('msg').innerHTML="Select Subdivision";
			Subdivision.focus();
			return false;
		}
		var txtfrom=document.getElementById('txtfrom');
		if(txtfrom.value=='')
		{
			document.getElementById('msg').innerHTML="Enter From";
			txtfrom.focus();
			return false;
		}
		var txtto=document.getElementById('txtto');
		if(txtto.value=='')
		{
			document.getElementById('msg').innerHTML="Enter To";
			txtto.focus();
			return false;
		}
	}
	if(chkasbly.checked==true)
	{
		var assembly=document.getElementById('assembly');
		if(assembly.value=='0')
		{
			document.getElementById('msg').innerHTML="Select Assembly Constituency";
			assembly.focus();
			return false;
		}
		var txtGroupId=document.getElementById('txtGroupId');
		if(txtGroupId.value=='')
		{
			document.getElementById('msg').innerHTML="Enter Group Id";
			txtGroupId.focus();
			return false;
		}
	}
}
</script>
</head>
<body>
<?php
extract($_POST);
$submit=isset($_POST['search'])?$_POST['search']:"";
if($submit=="Submit")
{
	$Subdivision=isset($_POST['Subdivision'])?encode($_POST['Subdivision']):"";
	$assembly=isset($_POST['assembly'])?encode($_POST['assembly']):"";
	$group_id=isset($_POST['txtGroupId'])?encode($_POST['txtGroupId']):"";
	$from=(isset($_POST['txtfrom'])?encode($_POST['txtfrom']):'0');
	$to=(isset($_POST['txtto'])?encode($_POST['txtto']):'0');
	?>
    <script>
		window.open("fpdf/2nd-app-letter.php?sub=<?php echo $Subdivision; ?>&assembly=<?php echo $assembly; ?>&group_id=<?php echo $group_id; ?>&txtfrom=<?php echo $from; ?>&txtto=<?php echo $to; ?>");
	</script>
    <?php
}
?>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo isset($subdiv_name)?$subdiv_name." SUBDIVISION":""; ?></td></tr>
<tr><td align="center">SECOND APPOINTMENT LETTER</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
	<table width="75%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="3"><span id='msg' class='error'></span></td>
    </tr>
    <tr>
      <td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <input type="hidden" id="hid_subdiv" value="<?php print $subdiv_cd; ?>" />
    <tr>
      <td align="left"><input type="checkbox" id="chksetsubdivision" name="chksetsubdivision" onclick="return chksetsubdivision_change();" />
        <label for="chksetsubdivision" class="text_small">Sub division wise</label></td>
        <td align="left"><span class="error">*</span>Subdivision</td>
        <td align="left"><select name="Subdivision" id="Subdivision" style="width:180px;" disabled="disabled">
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
      					</select>
          </td>
     </tr>
       
     <tr>
       <td></td>
       <td><span class="error">*</span>Records Print</td>
       <td>From: &nbsp;<input type='text' name='txtfrom' id='txtfrom' style='width:40px;' disabled="disabled"/>&nbsp;&nbsp;
	To: &nbsp;<input type='text' name='txtto' id='txtto' style='width:40px;'disabled="disabled" /></td>
      </tr> 
        
      <tr>
        <td colspan="3" align="center" style="font-size:12px; font-weight:bold;">OR</td>
       </tr>
    <tr>
      <td align="left"><input type="checkbox" id="chksetassembly" name="chksetassembly" onclick="return chksetassembly_change();" />
        <label for="chksetassembly" class="text_small">Assembly wise</label></td>
        <td align="left"><span class="error">*</span>Assembly Constituency</td>
        <td align="left"><select name="assembly" id="assembly" style="width:180px;" disabled="disabled">
          					<option value="0">-Select Assembly-</option>
                            <?php 	//$districtcd=$dist_cd;
									$rsBn1=fatch_assembly_all();
									$num_rows=rowCount($rsBn1);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowSubDiv=getRows($rsBn1);
											echo "<option value='$rowSubDiv[0]'>$rowSubDiv[2]</option>";
										}
									}
									$rsBn1=null;
									$num_rows=0;
									$rowSubDiv=null;
							?>
      					</select>
          </td>
     </tr> 
     <tr>
         <td></td>
         <td><span class="error">*</span>Group ID</td><td><input type="text" name="txtGroupId" id="txtGroupId" width="130px" disabled="disabled"/></td>
     </tr>    
    
    <tr><td colspan="3" align="center"><img src="images/blank.gif" alt="" height="10px" /></td></tr>
    <tr><td colspan="3" align="center"><input type="submit" name="search" id="search" value="Submit" class="button" onclick='return validate();' /></td></tr>
    <tr><td colspan="3" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    </table>
</form></td></tr>
</table></td></tr>
</table></div>
</body>
</html>