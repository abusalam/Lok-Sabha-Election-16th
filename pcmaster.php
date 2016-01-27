<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Parliament Constituency Master</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">

function edit_parliament(parliament_code,sub_code)
{
	location.replace("pcmaster.php?pc_cd="+parliament_code + "&sub_code="+ sub_code);
	
}
function delete_parliament(str,str1)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
		window.open("ajax-master.php?pc_cd="+str+"&subdiv="+str1+"&act=del","_blank","height=200,width=250,left=400,top=250, status=yes,toolbar=no,menubar=no,location=no,fullscreen=no");
	}
}
function validate()
{
	var subdivision=document.getElementById("Subdivision").value;
    var pc_cd=document.getElementById("pccode").value;
	var parliament=document.getElementById("parliament").value;
	if(subdivision=="0" || subdivision=="")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("Subdivision").focus();
		return false;
	}
	if(pc_cd=="")
	{
		document.getElementById("msg").innerHTML="Enter Parliament Code";
		document.getElementById("pccode").focus();
		return false;
	}
	if(parliament=="")
	{
		document.getElementById("msg").innerHTML="Enter Parliament Name";
		document.getElementById("parliament").focus();
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
	$parliament=clean_spl($_POST['parliament']);
	$parliament_code=($_POST['pccode']);
	$subdivisioncd=($_POST['Subdivision']);
	//=============== Getting Training Code ==================	
	if($parliament_code=='')
	{
		$rspmaxcode=fatch_parliament_maxcode();
		$rowpmaxcode=getRows($rspmaxcode);
		if($rowpmaxcode['pc_cd']==NULL)
			$parliament_code="01";
		else
			$parliament_code=sprintf("%02d",$rowpmaxcode['pc_cd']+1);
	}
	$usercd=$user_cd;
	
	$ret;
	$pc_code=decode($_REQUEST['pc_cd']);
	$c_parliament=duplicate_parliament($parliament_code,$parliament,$subdivisioncd,$pc_code);
	
	if($c_parliament==0)
	{
		if(isset($_REQUEST['pc_cd']))
		{
			$parliament_code=decode($_REQUEST['pc_cd']);
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_parliament($parliament_code,$parliament,$dist_cd,$subdivisioncd,$usercd,$posted_date);
			if($ret==1)
			{
				redirect("pcmaster.php?msg=success");
			}
		}
		else
		{
			$ret=save_parliament($parliament_code,$parliament,$dist_cd,$subdivisioncd,$usercd);
		}
		if($ret==1)
		{
			$msg="<div class='alert-success'>Record saved successfully</div>";
		}
	}
	else
	{
		$msg="<div class='alert-error'>Parliament already exists</div>";
	}
	unset($ret,$posted_date,$c_parliament,$parliament_code,$parliament,$subdivisioncd);
}
?>

<?php
if(isset($_REQUEST['pc_cd']))
{
	$parliament_code=decode($_REQUEST['pc_cd']);
	$sub_code=decode($_REQUEST['sub_code']);
	$rsPerDiv=fatch_parliament_master($parliament_code, $sub_code);
	$rowPerDiv=getRows($rsPerDiv);
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
	var parliament=document.getElementById('parliament');
	parliament.value="<?php echo $rowPerDiv['pcname']; ?>";
	//var parliament_code=document.getElementById('hid_parliament_code');
	var parliament_code=document.getElementById('pccode');
	parliament_code.value="<?php echo $rowPerDiv['pccd']; ?>";
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
<tr><td align="center">PARLIAMENT CONSTITUENCY MASTER</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="60%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="4" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr><td align="left"><span class="error">*</span>Sub Division</td>
      <td align="left"><select name="Subdivision" id="Subdivision" style="width:150px;">
      <option value="0">-Select Subdivision-</option>
                            <?php 	$districtcd=$dist_cd;
									$rsBn=fatch_Subdivision($districtcd);
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowBn=getRows($rsBn);
											echo "<option value='$rowBn[0]'>$rowBn[2]</option>";
										}
									}
									$rsBn=null;
									$num_rows=0;
									$rowBn=null;
									$districtcd=0;
							?>
      				</select></td>
       <td><span class="error">*</span>PC Code&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="pccode" id="pccode" style="width:30px" /></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Name</td>
      <td align="left"><input type="text" name="parliament" id="parliament" style="width:250px;" /></td>
      <td align="left"></td>
    </tr><input type="hidden" id="hid_parliament_code" name="hid_parliament_code" />
    
	<tr>
	  <td align="left" colspan="4">&nbsp;</td></tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr><td colspan="4" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
    <tr><td colspan="4" align="center"><div class="scroller">
            <?php
			//include_once('function\training_fun.php');
			$rsPerDiv=fatch_parliament_masterlist('');
			$num_rows = rowCount($rsPerDiv);
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
				echo "<tr height='30px'><th align='center'>Parliament Code</th><th align='left'>Subdivision Name</th><th align='left'>Parliament Name</th><th>Edit</th><th>Delete</th></tr>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowPerDiv=getRows($rsPerDiv);
				  $parliament_code='"'.encode($rowPerDiv['pccd']).'"';
				  $sub_code='"'.encode($rowPerDiv['subdivisioncd']).'"';
				  echo "<tr><td align='center' width='20%'>$rowPerDiv[pccd]</td><td width='40%' align='left'>$rowPerDiv[subdivision]</td><td width='40%' align='left'>$rowPerDiv[pcname]</td>";
				  echo "<td align='center' width='10%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_parliament($parliament_code, $sub_code);' /></td>\n";
				  echo "<td align='center' width='10%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_parliament($parliament_code,$sub_code);' /></td></tr>\n";
				}
				echo "</table>\n";
			}
			else
			{
				echo "<div id='table1' style='border: 1px solid;'>No records found</div>";
			}
			unset($rsSubDiv,$num_rows,$rowSubDiv);
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