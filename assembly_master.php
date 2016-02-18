<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Assembly Master</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function subdivision_change(str)
{
	<?php if(isset($_GET['ass_cd']) && isset($_GET['subdiv_code']))
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
		document.getElementById("pc_result").innerHTML=xmlhttp.responseText;
		}
	  }
	  
	xmlhttp.open("GET","ajaxfun.php?sub-div="+str+"&opn=pc",true);
	xmlhttp.send();
}

function edit_assembly(assembly_code,subcode)
{
	location.replace("assembly_master.php?ass_cd="+assembly_code+"&subdiv_code="+subcode);
	
}
function delete_assembly(str,str1)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
		window.open("ajax-master.php?ass_cd="+str+"&subcode="+str1+"&act=del","_blank","height=200,width=250,left=400,top=250, status=yes,toolbar=no,menubar=no,location=no,fullscreen=no");
		//location.replace("ajax-master.php?sub_cd="+str+"&act=del");
	}
}
function validate()
{
	var subdivision=document.getElementById("Subdivision").value;
    var parliament=document.getElementById("pc").value;
	var asmcode=document.getElementById("asmcode").value;
	var assemblyname=document.getElementById("assemblyname").value;
	if(subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("Subdivision").focus();
		return false;
	}
	if(parliament=="" || parliament=="0")
	{
		document.getElementById("msg").innerHTML="Select Parliament Code";
		document.getElementById("pc").focus();
		return false;
	}
	if(asmcode=="")
	{
		document.getElementById("msg").innerHTML="Enter Assembly Code";
		document.getElementById("asmcode").focus();
		return false;
	}
	if(assemblyname=="")
	{
		document.getElementById("msg").innerHTML="Enter Assembly Name";
		document.getElementById("assemblyname").focus();
		return false;
	}
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/master_fun.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Save')
{
	$subdivisioncd=isset($_POST['Subdivision'])?$_POST['Subdivision']:"";
	$pc=isset($_POST['pc'])?$_POST['pc']:"";
	$asm_code=isset($_POST['asmcode'])?$_POST['asmcode']:"";
	$assemblyname=isset($_POST['assemblyname'])?clean_spl($_POST['assemblyname']):"";
	$assembly_code=($_POST['hid_assembly_code']);
	//=============== Getting Training Code ==================	
	/*if($asm_code=='')
	{
		$rspmaxcode=fatch_assembly_maxcode($pc);
		$rowpmaxcode=getRows($rspmaxcode);
		if($rowpmaxcode['ass_cd']==null)
			$assembly_code="001";
		else
			$assembly_code=sprintf("%03d",$rowpmaxcode['ass_cd']+1);
	}*/
	$usercd=$user_cd;
	
	$ret;
	$c_assembly=duplicate_assembly($subdivisioncd,$assembly_code,$pc,$assemblyname,$asm_code);
	
	if($c_assembly==0)
	{
		if(isset($_REQUEST['ass_cd']))
		{
			$assembly_code=decode($_REQUEST['ass_cd']);
			$subdivisioncd=decode($_REQUEST['subdiv_code']);
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_assembly($assembly_code,$assemblyname,$dist_cd,$subdivisioncd,$pc,$usercd,$posted_date);
			if($ret==1)
			{
				redirect("assembly_master.php?msg=success");
			}
		}
		else
		{
			$ret=save_assembly($asm_code,$assemblyname,$dist_cd,$subdivisioncd,$pc,$usercd);
		}
		if($ret==1)
		{
			$msg="<div class='alert-success'>Record saved successfully</div>";
		}
	}
	else
	{
		$msg="<div class='alert-error'>Assembly already exists</div>";
	}
	unset($ret,$posted_date,$c_assembly,$assembly_code,$assemblyname,$subdivisioncd,$pc,$asm_code);
}
?>

<?php
if(isset($_REQUEST['ass_cd']))
{
	$assembly_code=decode($_REQUEST['ass_cd']);
	$subdiv_code=decode($_REQUEST['subdiv_code']);
	//$sub_code=decode($_REQUEST['sub_code']);
	$rsPerDiv=fatch_assembly_master($assembly_code,$subdiv_code);
	$rowPerDiv=getRows($rsPerDiv);
	$subdiv_cd=$rowPerDiv['subdivisioncd'];
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
	<?php if(isset($rowPerDiv)) { ?>
	var subdivision = document.getElementById('Subdivision');
	subdivision.value = "<?php echo $rowPerDiv['subdivisioncd']; ?>";
	
	//=================================
	
	
	//==============================
	var pc=document.getElementById('pc');
	pc.value="<?php echo $rowPerDiv['pccd']; ?>";
	var assemblyname=document.getElementById('assemblyname');
	assemblyname.value="<?php echo $rowPerDiv['assemblyname']; ?>";
	var assembly_code=document.getElementById('hid_assembly_code');
	assembly_code.value="<?php echo $rowPerDiv['assemblycd']; ?>";
	var asmcode=document.getElementById("asmcode");
	asmcode.value="<?php echo $rowPerDiv['assemblycd']; ?>";
	asmcode.readOnly=true;
	<?php } ?>
}
</script>
<body oncontextmenu="return false;" onload="javascript: return bind_all();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">ASSEMBLY CONSTITUENCY MASTER</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="90%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="4" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr><td align="left"><input type="hidden" id="district" name="district" <?php echo $dist_cd." - ".$district; ?>/></td></tr>
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
									unset($rsBn,$num_rows,$rowSubDiv);
							?>
      				</select></td>
              <td><span class="error">*</span>Assembly Code</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="asmcode" id="asmcode" style="width:35px" maxlength="3" onkeypress="javascript:return wholenumbersonly(event);" /></td></tr>
                    <tr>
                    <td align="left"><span class="error">*</span>Parliament Constituency</td>
      <td align="left" id="pc_result"><select name="pc" id="pc" style="width:200px;">
      									<?php
										if(isset($_REQUEST['ass_cd']))
										{
											include_once("function/add_fun.php");
											$subdiv=$subdiv_cd;
											$rsPC=fatch_pc($subdiv);
											$num_rows=rowCount($rsPC);
											if($num_rows>0)
											{
												echo "<option value='0'>-Select PC-</option>\n";
												for($i=1;$i<=$num_rows;$i++)
												{
													$rowPC=getRows($rsPC);
													echo "<option value='$rowPC[0]'>$rowPC[1]</option>\n";
													$rowPC=null;
												}
											}
											$num_rows=0;			
											$rsPC=null;
										}
      									?>
      								  </select>
      </td>
      <td colspan="2"></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Assembly Name</td>
      <td align="left"><input type="text" name="assemblyname" id="assemblyname" style="width:250px;" /></td>
      <td align="left"></td>
      <td align="left"></td>
    </tr><input type="hidden" id="hid_assembly_code" name="hid_assembly_code" />
    
	<tr>
	  <td align="left" colspan="4">&nbsp;</td></tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" />&nbsp;&nbsp; <a href="assembly_master.php" class="button" style="text-decoration: none; padding: 4px;">Refresh</a></td>
    </tr>
    <tr><td colspan="4" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
    <tr><td colspan="4" align="center"><div class="scroller">
            <?php
			//include_once('function\training_fun.php');
			$rsAssDiv=fatch_assembly_masterlist($dist_cd);
			$num_rows = rowCount($rsAssDiv);
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
				echo "<tr height='30px'><th>Sl.</th><th align='center'>Subdivision</th><th align='center'>Assembly Code</th><th align='left'>Assembly Name</th><th align='left'>Parliament Name</th><th>Edit</th><th>Delete</th></tr>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowAssDiv=getRows($rsAssDiv);
				  $assembly_code='"'.encode($rowAssDiv['assemblycd']).'"';
				  $sub_code='"'.encode($rowAssDiv['subdivisioncd']).'"';
				  
				  echo "<tr><td align='center' width='5%'>$i.</td><td align='center' width='10%'>$rowAssDiv[subdivision]</td><td align='center' width='12%'>$rowAssDiv[assemblycd]</td><td width='30%' align='left'>$rowAssDiv[assemblyname]</td>";
				  echo "<td width='27%' align='left'>$rowAssDiv[pcname]</td>";
				  echo "<td align='center' width='8%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_assembly($assembly_code,$sub_code);' /></td>\n";
				  echo "<td align='center' width='8%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_assembly($assembly_code,$sub_code);' /></td></tr>\n";
				}
				echo "</table>\n";
			}
			else
			{
				echo "<div id='table1' style='border: 1px solid;'>No records found</div>";
			}
			unset($rsAssDiv,$num_rows,$rowAssDiv);
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