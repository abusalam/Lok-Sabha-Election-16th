<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Block/Municipality Master</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">

function edit_block(str)
{
	location.replace("block-muni-master.php?blockminicd="+str);
}
function delete_block(str)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
		window.open("ajax-master.php?blockminicd="+str+"&act=del","_blank","height=200,width=250,left=400,top=250, status=yes,toolbar=no,menubar=no,location=no,fullscreen=0");
		//location.replace("ajax-master.php?sub_cd="+str+"&act=del");
	}
}
function validate()
{
	var subdivision=document.getElementById("subdivision").value;
	var block_muni=document.getElementById("block_muni").value;
	if(subdivision=="0" || subdivision=="")
	{
		document.getElementById("msg").innerHTML="Select Subdivision Name";
		document.getElementById("subdivision").focus();
		return false;
	}
	if(block_muni=="")
	{
		document.getElementById("msg").innerHTML="Enter Block/Municipality Name";
		document.getElementById("block_muni").focus();
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
	$subdivision=$_POST['subdivision'];
	$block_muni=clean_spl($_POST['block_muni']);
	$block_muni_type=$_POST['block_muni_type'];
	$block_muni_code=($_POST['hid_block_muni_code']);
	//=============== Getting Block_Muni Code ==================	
	if($block_muni_code=='')
	{
		$rsmaxcode=fatch_block_muni_maxcode($subdivision);
		$rowmaxcode=getRows($rsmaxcode);
		if($rowmaxcode['blockmuni_cd']==null)
			$block_muni_code=$subdivision."01";
		else
			$block_muni_code=sprintf("%06d",$rowmaxcode['blockmuni_cd']+1);
	}
	$usercd=$user_cd;
	
	$c_block_muni=duplicate_block_muni($block_muni_code,$block_muni);	
	if($c_block_muni==0)
	{
		if(isset($_REQUEST['blockminicd']))
		{
			$block_muni_code=decode($_REQUEST['blockminicd']);
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_block_muni($block_muni_code,$block_muni,$block_muni_type,$usercd,$posted_date);
			if($ret==1)
			{
				?> <script>location.replace("block-muni-master.php?msg=success");</script> <?php
			}
		}
		else
		{
			$ret=save_block_muni($block_muni_code,$subdivision,$block_muni,$block_muni_type,$dist_cd,$usercd);
		}
		if($ret==1)
		{
			$msg="<div class='alert-success'>Record saved successfully</div>";
		}
	}
	else
	{
		$msg="<div class='alert-error'>Block or Municipality already exists</div>";
	}
	unset($ret,$posted_date,$c_block_muni,$block_muni_code,$block_muni,$subdivision,$block_muni_type);
}
?>

<?php
if(isset($_REQUEST['blockminicd']))
{
	$block_muni_cd=decode($_REQUEST['blockminicd']);

	$rsBlock_Muni=fatch_block_muni_master($block_muni_cd,'');
	$rowBlock_Muni=getRows($rsBlock_Muni);
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
	subdivision.value="<?php echo $rowBlock_Muni['subdivisioncd']; ?>";
	var block_muni=document.getElementById('block_muni');
	block_muni.value="<?php echo $rowBlock_Muni['blockmuni']; ?>";
	var block_muni_type=document.getElementById('block_muni_type');
	block_muni_type.value="<?php echo $rowBlock_Muni['block_or_muni']; ?>";
	var block_muni_code=document.getElementById('hid_block_muni_code');
	block_muni_code.value="<?php echo $rowBlock_Muni['blockminicd']; ?>";
}
</script>
<body oncontextmenu="return false;" onload="javascript: return bind_all();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">BLOCK/MUNICIPALITY MASTER</td></tr>
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
      <td align="left"><span class="error">*</span>Subdivision Name</td>
      <td align="left"><select name="subdivision" id="subdivision" style="width:200px;" >
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
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Block/Municipality Name</td>
      <td align="left"><input type="text" name="block_muni" id="block_muni" style="width:192px;" /></td>
      <td align="left">Block/Municipality</td>
      <td align="left"><select name="block_muni_type" id="block_muni_type">
      						<option value="b">Block</option>
                            <option value="m">Municipality</option>
                       </select></td><input type="hidden" id="hid_block_muni_code" name="hid_block_muni_code" />
    </tr>  
	<tr>
	  <td align="left" colspan="4">&nbsp;</td></tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr><td colspan="4" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
    <tr><td colspan="4" align="center"><div class="scroller">
            <?php
			//include_once('function\training_fun.php');
			$rsBlock=fatch_block_muni_master('',$dist_cd);
			$num_rows = rowCount($rsBlock);
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
				echo "<tr height='30px'><th align='center'>Sl. No</th><th align='center'>Block/Municipality Code</th><th align='left'>Block/Municipality Name</th><th align='left'>Subdivision</th><th>Edit</th><th>Delete</th></tr>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowBlock=getRows($rsBlock);
				  $blockminicd='"'.encode($rowBlock['blockminicd']).'"';
				  echo "<tr><td width='5%' align='right'>$i.</td><td align='center' width='20%'>$rowBlock[blockminicd]</td><td width='30%' align='left'>$rowBlock[blockmuni]</td>";
				  echo "<td width='30%' align='left'>$rowBlock[subdivision]</td>";
				  echo "<td align='center' width='10%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_block($blockminicd);' /></td>\n";
				  echo "<td align='center' width='10%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_block($blockminicd);' /></td></tr>\n";
				}
				echo "</table>\n";
			}
			else
			{
				echo "<div id='table1' style='border: 1px solid;'>No records found</div>";
			}
			unset($rsBlock,$num_rows,$rowBlock);
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