<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Send SMS</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function Subdivision_change(str)
{
	//alert(str);
	//window.history.back();
	//document.getElementById("rand_result").innerHTML="";
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
		document.getElementById("phase_type").innerHTML=xmlhttp.responseText;
	//	document.getElementById("load_result").innerHTML="";
		document.getElementById("form1").style="cursor:default";
		}
	  }
	xmlhttp.open("GET","ajax-first-app3.php?Subdivision="+str+"&opn=tr_phase",true);
	document.getElementById("form1").style="cursor:wait";
	xmlhttp.send();
}
</script>
</head>
<?php
include_once('function/sms_fun.php');
if(isset($_REQUEST['send']) && $_REQUEST['send']!=null)
	$sub=$_REQUEST['send'];
else
	$sub="";
if($sub=="Send SMS")
{
		$from=isset($_REQUEST['from'])?$_REQUEST['from']:0;
		$to=isset($_REQUEST['to'])?$_REQUEST['to']:0;
		$limit=$to-$from;
		$rs_data=fatch_SMS_from_sms_table(($from-1),$limit);
		if(rowCount($rs_data)>0)
		{
			for($i=1;$i<=rowCount($rs_data);$i++)
			{
				$row_data=getRows($rs_data);
				$name=$row_data['name'];
				$mob_no=$row_data['phone_no'];
				$Message=$row_data['message'];
				
				$DestinationAddress = $mob_no;
				//include('sms/Index.php');			
			}
				
		}
		else
			$msg="<div class='alert-error'>No record found</div>";

?>	
<script>location.replace("send-sms.php?msg=success");</script>           
 <?php
}
?>
<?php
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$msg="<div class='alert-success'>Message sent successfully</div>";
	}
}
?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $subdiv_name; ?> SUBDIVISION</td></tr>
<tr>
  <td align="center">SEND SMS</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="65%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<tr><td align="left" width="35%"> <input type="checkbox" id="chkextrapp" name="chkextrapp" onclick="return chkextrapp_change();" />
    <label for="chkextrapp">For Extra PP</label></td>
	<td align="left" width="65%"><span class="error">*</span>From : <input type="text" name="from" id="from" style="width:50px;" onkeypress="javascript:return wholenumbersonly(event);" />&nbsp; <span class="error">*</span>To : <input type="text" name="to" id="to" style="width:50px;" onkeypress="javascript:return wholenumbersonly(event);" /></td></tr>
    <tr> 
     <td align="left" ><span class="error">*</span>Subdivision :</td>
	  <td align="left"><select name="Subdivision" id="Subdivision" style="width:220px;">
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
									unset($rsBn,$num_rows,$rowSubDiv);
							?>
      				</select></td>
    </tr>
     <tr style="display:none" id="phase_rw">
      <td align="left"><span class="error">*</span>Phase Type</td>
      <td align="left" id="phase_type"><select name="phase" id="phase" style="width:220px;">
		<option value="0">-Select Phase Type-</option>
        </select></td>
    </tr> 
    <tr>
      <td align="left"><span class="error">*</span>Post Status</td>
      <td align="left"><select name="post_status" id="post_status" style="width:220px;" >
    							<option value="0">-Select Post Status-</option>
								<?php 	
									$rsP=fatch_postingstatus();
									$num_rows=rowCount($rsP);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowP=getRows($rsP);
											echo "<option value='$rowP[0]'>$rowP[1]</option>\n";
											$rowP=NULL;
										}
									}
									unset($rsP,$num_rows,$rowP);
								?>
                            </select></td></tr> 
     <tr>
      <td align="left"><span class="error">*</span>Message [Max 100 chars]</td>
      <td align="left"><textarea name="text_msg" id="text_msg" style="max-width:212px;min-width: 212px;min-height: 60px;"></textarea></td></tr>
   
    <tr>
      <td align="left"><span class="error">*</span>Type of Information</td>
      <td align="left"><select name="type_details" id="type_details" style="width:220px;" >
                                <option value="0">-Select Information -</option>
    							<option value="B">Bank Details</option>
							    <option value="T">Training Details</option>
                                
                                 <option value="V">Voter Information</option>
                            </select></td></tr>
    
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<tr>
	  <td align="center" colspan="2"><input type="submit" name="send" id="send" value="Send SMS" class="button" /></td></tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table></form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
<script>
function chkextrapp_change()
{
	if(document.getElementById('chkextrapp').checked==true)
	{
		$("#phase_rw").show();
		var subdivision=document.getElementById("Subdivision").value;
		Subdivision_change(subdivision);
	}
	else
	{
		
		$("#phase_rw").hide();
		document.getElementById('phase').value='0';
	}
}
</script>
</html>