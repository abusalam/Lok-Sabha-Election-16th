<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Police Station Master</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">


function edit_police(ps_code)
{
	location.replace("police_station_master.php?ps_cd="+ps_code);
	
}
function delete_police(str)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
		window.open("ajax-master.php?ps_cd="+str+"&act=del","_blank","height=200,width=250,left=400,top=250, status=yes,toolbar=no,menubar=no,location=no,fullscreen=no");
		//location.replace("ajax-master.php?sub_cd="+str+"&act=del");
	}
}
function validate()
{
	var subdivision=document.getElementById("Subdivision").value;
    var parliament=document.getElementById("psname").value;
	if(subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("Subdivision").focus();
		return false;
	}
	if(parliament=="")
	{
		document.getElementById("msg").innerHTML="Enter police Station Name";
		document.getElementById("psname").focus();
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
	$subdivisioncd=$_POST['Subdivision'];
	$psname=$_POST['psname'];
	$ps_code=($_POST['hid_ps_code']);
	//=============== Getting Training Code ==================	
	if($ps_code=='')
	{
		$rspmaxcode=fatch_police_maxcode($subdivisioncd);
		$rowpmaxcode=getRows($rspmaxcode);
		if($rowpmaxcode['ps_cd']==null)
			$ps_code=$subdivisioncd."01";
		else
			$ps_code=sprintf("%06d",$rowpmaxcode['ps_cd']+1);
	}
	$usercd=$user_cd;
	
	$ret;
	$c_ps=duplicate_police($ps_code,$psname,$subdivisioncd);
	
	if($c_ps==0)
	{
		if(isset($_REQUEST['ps_cd']))
		{
			$ps_code=decode($_REQUEST['ps_cd']);
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_police($ps_code,$psname,$dist_cd,$subdivisioncd,$usercd,$posted_date);
			if($ret==1)
			{
				redirect("police_station_master.php?msg=success");
			}
		}
		else
		{
			$ret=save_police($ps_code,$psname,$dist_cd,$subdivisioncd,$usercd);
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
	unset($ret,$posted_date,$c_ps,$ps_code,$psname,$subdivisioncd);
}
?>

<?php
if(isset($_REQUEST['ps_cd']))
{
	$ps_code=decode($_REQUEST['ps_cd']);
	//$sub_code=decode($_REQUEST['sub_code']);
	$rsPerDiv=fatch_police_station_master($ps_code);
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
	var psname=document.getElementById('psname');
	psname.value="<?php echo $rowPerDiv['policestation']; ?>";
	var ps_code=document.getElementById('hid_ps_code');
	ps_code.value="<?php echo $rowPerDiv['policestationcd']; ?>";
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
<tr><td align="center">POLICE STATION MASTER</td></tr>
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
    <tr><td align="left"><input type="hidden" id="district" name="district" <?php echo $dist_cd." - ".$district; ?>/></td></tr>
    <tr>
     <td align="left"><span class="error">*</span>Subdivision</td>
	  <td align="left"><select name="Subdivision" id="Subdivision" style="width:200px;">
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
      				</select></td></tr>
                  
    <tr>
      <td align="left"><span class="error">*</span>Police Station Name</td>
      <td align="left"><input type="text" name="psname" id="psname" style="width:250px;" maxlength="20"/></td>
      <td align="left"></td>
    </tr><input type="hidden" id="hid_ps_code" name="hid_ps_code" />
    
	<tr>
	  <td align="left" colspan="4">&nbsp;</td></tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr><td colspan="4" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
    <tr><td colspan="4" align="center"><div class="scroller">
            <?php
			//include_once('function\training_fun.php');
			$rsAssDiv=fatch_ps_masterlist($dist_cd);
			$num_rows = rowCount($rsAssDiv);
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
				echo "<tr height='30px'><th>Sl. No.</th><th align='center'>Police Station Code</th><th align='left'>Subdivision</th><th align='left'>Police Station Name</th><th>Edit</th><th>Delete</th></tr>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowAssDiv=getRows($rsAssDiv);
				  $ps_code='"'.encode($rowAssDiv['0']).'"';
				  //$sub_code='"'.encode($rowAssDiv['subdivisioncd']).'"';
				  echo "<tr><td align='right' width='10%'>$i.</td><td align='center' width='20%'>$rowAssDiv[0]</td><td width='35%' align='left'>$rowAssDiv[1]</td>";
				  echo "<td width='35%' align='left'>$rowAssDiv[2]</td>";
				  echo "<td align='center' width='10%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_police($ps_code);' /></td>\n";
				  echo "<td align='center' width='10%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_police($ps_code);' /></td></tr>\n";
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