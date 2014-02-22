<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subdivision Master</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">

function edit_subdivision(str)
{
	location.replace("subdivision-master.php?sub_cd="+str);
}
function delete_subdivision(str)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
		window.open("ajax-master.php?sub_cd="+str+"&act=del","_blank","height=200,width=250,left=400,top=250, status=yes,toolbar=no,menubar=no,location=no,fullscreen=0");
		//location.replace("ajax-master.php?sub_cd="+str+"&act=del");
	}
}
function validate()
{
	var subdivision=document.getElementById("subdivision").value;

	if(subdivision=="")
	{
		document.getElementById("msg").innerHTML="Enter Subdivision Name";
		document.getElementById("subdivision").focus();
		return false;
	}
}
</script>
</head>
<?php
include_once('inc\db_trans.inc.php');
include_once('function\master_fun.php');
$action=$_REQUEST['submit'];
if($action=='Save')
{
	$subdivision=clean_spl($_POST['subdivision']);
	$subdivision_code=($_POST['hid_subdivision_code']);
	//=============== Getting Training Code ==================	
	if($subdivision_code=='')
	{
		$rsmaxcode=fatch_subdivision_maxcode($dist_cd);
		$rowmaxcode=getRows($rsmaxcode);
		if($rowmaxcode['subdivision_cd']==null)
			$subdivision_code=$dist_cd."01";
		else
			$subdivision_code=sprintf("%04d",$rowmaxcode['subdivision_cd']+1);
	}
	$usercd=$user_cd;
	
	$ret;
	$c_subdivision=duplicate_subdivision($subdivision_code,$subdivision);
	
	if($c_subdivision==0)
	{
		if(isset($_REQUEST['sub_cd']))
		{
			$subdivision_code=decode($_REQUEST['sub_cd']);
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_subdivision($subdivision_code,$subdivision,$usercd,$posted_date);
			if($ret==1)
			{
				?> <script>location.replace("subdivision-master.php?msg=success");</script> <?php
			}
		}
		else
		{
			$ret=save_subdivision($subdivision_code,$subdivision,$dist_cd,$usercd);
		}
		if($ret==1)
		{
			$msg="<div class='alert-success'>Record saved successfully</div>";
		}
	}
	else
	{
		$msg="<div class='alert-error'>Subdivision already exists</div>";
	}
	unset($ret,$posted_date,$c_subdivision,$subdivision_code,$subdivision);
}
?>

<?php
if(isset($_REQUEST['sub_cd']))
{
	$subdivision_code=decode($_REQUEST['sub_cd']);

	$rsSubDiv=fatch_subdivision_master($subdivision_code,'');
	$rowSubDiv=getRows($rsSubDiv);
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
	var subdivision=document.getElementById('subdivision');
	subdivision.value="<?php echo $rowSubDiv['subdivision']; ?>";
	var subdivision_code=document.getElementById('hid_subdivision_code');
	subdivision_code.value="<?php echo $rowSubDiv['subdivisioncd']; ?>";
}
</script>
<body oncontextmenu="return false;" onload="javascript: return bind_all();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">SUBDIVISION MASTER</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="60%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="3" align="center"><?php print $msg; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="3"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Subdivision Name</td>
      <td align="left"><input type="text" name="subdivision" id="subdivision" style="width:250px;" /></td>
      <td align="left">District&nbsp;&nbsp;&nbsp;<label id="district" name="district" ><?php echo $dist_cd." - ".$district; ?></label></td>
    </tr><input type="hidden" id="hid_subdivision_code" name="hid_subdivision_code" />
    
	<tr>
	  <td align="left" colspan="3">&nbsp;</td></tr>
    <tr>
      <td colspan="3" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr><td colspan="3" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
    <tr><td colspan="3" align="center">
            <?php
			//include_once('function\training_fun.php');
			$rsSubDiv=fatch_subdivision_master('',$dist_cd);
			$num_rows = rowCount($rsSubDiv);
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
				echo "<tr height='30px'><th align='center'>Subdivision Code</th><th align='left'>Subdivision Name</th><th>Edit</th><th>Delete</th></tr>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowSubDiv=getRows($rsSubDiv);
				  $subdivision_cd='"'.encode($rowSubDiv['subdivisioncd']).'"';
				  echo "<tr><td align='center' width='30%'>$rowSubDiv[subdivisioncd]</td><td width='50%' align='left'>$rowSubDiv[subdivision]</td>";
				  echo "<td align='center' width='10%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_subdivision($subdivision_cd);' /></td>\n";
				  echo "<td align='center' width='10%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_subdivision($subdivision_cd);' /></td></tr>\n";
				}
				echo "</table>\n";
			}
			else
			{
				echo "<div id='table1' style='border: 1px solid;'>No records found</div>";
			}
			unset($rsSubDiv,$num_rows,$rowSubDiv);
			?>
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