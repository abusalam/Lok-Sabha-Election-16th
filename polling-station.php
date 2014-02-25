<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Polling Station Master</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function subdivision_change(str)
{
	<?php if(isset($_GET['psno']) && isset($_GET['assembly']))
	{ ?>
		document.getElementById("msg").innerHTML="Subdivision can't be changed while modifying";
		bind_all();
		return false;
	<?php
	} ?>
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
	xmlhttp.open("GET","ajax-master.php?sub_div="+str+"&opn=assembly",true);
	xmlhttp.send();
}
function assembly_change(str)
{
	<?php if(isset($_GET['psno']) && isset($_GET['assembly']))
	{ ?>
		document.getElementById("msg").innerHTML="Assembly can't be changed while modifying";
		bind_all();
		return false;
	<?php
	} ?>
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
	xmlhttp.open("GET","ajax-master.php?assembly="+str+"&opn=dcrc",true);
	xmlhttp.send();
}
function dcrc_change(str)
{
	<?php if(isset($_GET['psno']) && isset($_GET['assembly']))
	{ ?>
		document.getElementById("msg").innerHTML="DCRC can't be changed while modifying";
		bind_all();
		return false;
	<?php
	} ?>
	var ass=document.getElementById('assembly').value;
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
		document.getElementById("member_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-master.php?assembly="+ass+"&dcrc="+str+"&opn=member",true);
	xmlhttp.send();
}
function edit_PS(str,str1)
{
	location.replace("polling-station.php?psno="+str+"&assembly="+str1);
}
function delete_PS(str,str1)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
		window.open("ajax-master.php?psno="+str+"&assembly="+str1+"&act=del","_blank","height=200,width=250,left=400,top=250, status=yes,toolbar=no,menubar=no,location=no,fullscreen=0");
		//location.replace("ajax-master.php?sub_cd="+str+"&act=del");
	}
}
function validate()
{
	var psno=document.getElementById("psno").value;
	var postfix=document.getElementById("postfix").value;
	var subdivision=document.getElementById("subdivision").value;
	var assembly=document.getElementById("assembly").value;
	var dcrc=document.getElementById("dcrc").value;
	var member=document.getElementById("member").value;
	var psname=document.getElementById("psname").value;
	if(psno=="")
	{
		document.getElementById("msg").innerHTML="Enter Polling Station No";
		document.getElementById("psno").focus();
		return false;
	}
	if(postfix=="")
	{
		document.getElementById("msg").innerHTML="Enter Postfix";
		document.getElementById("postfix").focus();
		return false;
	}
	if(subdivision=="0" || subdivision=="")
	{
		document.getElementById("msg").innerHTML="Select Subdivision Name";
		document.getElementById("subdivision").focus();
		return false;
	}
	if(assembly=="0" || assembly=="")
	{
		document.getElementById("msg").innerHTML="Select Assembly Name";
		document.getElementById("assembly").focus();
		return false;
	}
	if(dcrc=="0" || dcrc=="")
	{
		document.getElementById("msg").innerHTML="Select DCRC";
		document.getElementById("dcrc").focus();
		return false;
	}
	if(member=="")
	{
		document.getElementById("msg").innerHTML="Member can't blank";
		document.getElementById("member").focus();
		return false;
	}
	if(psname=="")
	{
		document.getElementById("msg").innerHTML="Enter Polling Station Name";
		document.getElementById("psname").focus();
		return false;
	}
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/master_fun.php');
$action=$_REQUEST['submit'];
if($action=='Save')
{
	$psno=$_POST['psno'];
	$postfix=$_POST['postfix'];
	$subdivision=$_POST['subdivision'];
	$assembly=$_POST['assembly'];
	$dcrc=$_POST['dcrc'];
	$member=($_POST['member']);
	$psname=clean_spl($_POST['psname']);	

	$usercd=$user_cd;
	
	$cnt=duplicate_polling_stn($psno,$assembly,$psname);	
	if(isset($_GET['psno']) && isset($_GET['assembly']))
	{
		$cnt=0;
	}
	if($cnt==0)
	{
		if(isset($_GET['psno']) && isset($_GET['assembly']))
		{
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_polling_stn($psno,$postfix,$assembly,$psname,$usercd,$posted_date);
			if($ret==1)
			{
				?> <script>location.replace("polling-station.php?msg=success");</script> <?php
			}
		}
		else
		{
			$ret=save_polling_stn($psno,$postfix,$subdivision,$assembly,$dcrc,$member,$psname,$usercd);
		}
		if($ret==1)
		{
			$msg="<div class='alert-success'>Record saved successfully</div>";
		}
	}
	else
	{
		$msg="<div class='alert-error'>Deplicate Polling Station ID not allowed</div>";
	}
	unset($ret,$psno,$postfix,$subdivision,$assembly,$dcrc,$member,$psname);
}
?>

<?php
if(isset($_GET['psno']) && isset($_GET['assembly']))
{
	$ps_no=decode($_GET['psno']);
	$ass_cd=decode($_GET['assembly']);
	
	$rsPS_E=fetch_polling_station($ps_no,$ass_cd,$dist_cd);
	$rowPS_E=getRows($rsPS_E);
	$sub_div=$rowPS_E['forsubbdivision'];
	$ass_cd=$rowPS_E['forassembly'];
	$dcrccd=$rowPS_E['dcrccd'];
}
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$msg="<div class='alert-success'>Record updated successfully</div>";
	}
}
?>
<script language="javascript" type="text/javascript">
function bind_all()
{
	<?php if(isset($_GET['psno']) && isset($_GET['assembly']))
	{ ?>
		var psno=document.getElementById('psno');
		psno.value="<?php echo $rowPS_E['psno']; ?>";
		psno.readOnly=true;
		var postfix=document.getElementById('postfix');
		postfix.value="<?php echo $rowPS_E['psfix']; ?>";
		var subdivision=document.getElementById('subdivision');
		subdivision.value="<?php echo $rowPS_E['forsubbdivision']; ?>";
		var assembly=document.getElementById('assembly');
		assembly.value="<?php echo $rowPS_E['forassembly']; ?>";
		var dcrc=document.getElementById('dcrc');
		dcrc.value="<?php echo $rowPS_E['dcrccd']; ?>";
		var member=document.getElementById('member');
		member.value="<?php echo $rowPS_E['member']; ?>";
		var psname=document.getElementById('psname');
		psname.value="<?php echo $rowPS_E['psname']; ?>";
	<?php 
	} ?>
}
</script>
<body oncontextmenu="return false;" onload="javascript: return bind_all();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>

<tr><td align="center">POLLING STATION MASTER</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="65%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="4" align="center"><?php print $msg; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Polling Station No</td>
      <td align="left"><input type="text" name="psno" id="psno" style="width:192px;" maxlength="5" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Postfix</td>
      <td align="left"><input type="text" name="postfix" id="postfix" style="width:192px;" maxlength="1" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Subdivision Name</td>
      <td align="left"><select name="subdivision" id="subdivision" style="width:200px;" onchange="return subdivision_change(this.value);">
      							<option value='0'>Select</option>
      					<?php
						$districtcd=$dist_cd;
						$rsSubDiv=fatch_Subdivision($districtcd);
						$num_rows = rowCount($rsSubDiv);
						for($i=1;$i<=$num_rows;$i++)
						{
							$rowSubDiv=getRows($rsSubDiv);
							echo "<option value='$rowSubDiv[subdivisioncd]'>$rowSubDiv[subdivision]</option>";
							unset($rowSubDiv);
						}
						unset($num_rows,$rsSubDiv);
						?>
                       </select></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Assembly</td>
      <td align="left" id="assembly_result"><select name="assembly" id="assembly" style="width:200px;" onchange="return assembly_change(this.value);">
      <?php
	  if(isset($_GET['psno']) && isset($_GET['assembly']))
	  {
		  	include_once('function/add_fun.php'); 						
			$rsAss=fatch_assembly($sub_div);
			$num_rows=rowCount($rsAss);
			if($num_rows>0)
			{
				echo "<option value='0'>-Select Assembly-</option>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
					$rowAss=getRows($rsAss);
					echo "<option value='$rowAss[assemblycd]'>$rowAss[assemblyname]</option>\n";
					unset($rowAss);
				}
			}
			unset($rsAss,$num_rows);
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>DCRC</td>
      <td align="left" id="dcrc_result"><select name="dcrc" id="dcrc" style="width:200px;" onchange="return dcrc_change(this.value);">
      <?php
	  if(isset($_GET['psno']) && isset($_GET['assembly']))
	  {   						
			$rsDCRC=fatch_dcrc($ass_cd);
			$num_rows=rowCount($rsDCRC);
			if($num_rows>0)
			{
				echo "<option value='0'>-Select DCRC-</option>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
					$rowDCRC=getRows($rsDCRC);
					echo "<option value='$rowDCRC[dcrcgrp]'>$rowDCRC[dcrcgrp]</option>\n";
					unset($rowDCRC);
				}
			}
			unset($rsDCRC,$num_rows);
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Member No</td>
      <td align="left" id="member_result"><input type="text" name="member" id="member" style="width:192px;" maxlength="2" readonly="readonly" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Polling Station Name</td>
      <td align="left"><input type="text" name="psname" id="psname" style="width:192px;" maxlength="150" /></td>
    </tr>
	<tr>
	  <td align="left" colspan="2">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr><td colspan="2" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
    <tr><td colspan="2" align="center"><div class="scroller">
            <?php
			//include_once('function/training_fun.php');
			$rsPS=fetch_polling_station('','',$dist_cd);
			$num_rows = rowCount($rsPS);
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
				echo "<tr height='30px'><th align='center'>Sl. No</th><th align='center'>PS No</th><th align='left'>Assembly</th><th align='left'>PS Name</th><th>Edit</th><th>Delete</th></tr>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowPS=getRows($rsPS);
				  $psno='"'.encode($rowPS['psno']).'"';
				  $ass='"'.encode($rowPS['forassembly']).'"';
				  echo "<tr><td width='5%' align='right'>$i.</td><td align='center' width='20%'>$rowPS[psno]</td><td width='30%' align='left'>$rowPS[assemblyname]</td>";
				  echo "<td width='30%' align='left'>$rowPS[psname]</td>";
				  echo "<td align='center' width='10%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_PS($psno,$ass);' /></td>\n";
				  echo "<td align='center' width='10%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_PS($psno,$ass);' /></td></tr>\n";
				}
				echo "</table>\n";
			}
			else
			{
				echo "<div id='table1' style='border: 1px solid;'>No records found</div>";
			}
			unset($rsPS,$num_rows,$rowPS);
			?></div>
    </td></tr>
  </table>
</form>
</td></tr>
<tr><td>&nbsp;</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>