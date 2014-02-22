<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bank Master</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">

function edit_bank(str)
{
	location.replace("bank-master.php?bank_cd="+str);
}
function delete_bank(str)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
		window.open("ajax-master.php?bank_cd="+str+"&act=del","_blank","height=200,width=250,left=400,top=250, status=yes,toolbar=no,menubar=no,location=no,fullscreen=0");
		//location.replace("ajax-master.php?sub_cd="+str+"&act=del");
	}
}
function validate()
{
	var bank=document.getElementById("bank").value;

	if(bank=="")
	{
		document.getElementById("msg").innerHTML="Enter Bank Name";
		document.getElementById("bank").focus();
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
	$bank=clean_spl($_POST['bank']);
	$bank_code=($_POST['hid_bank_code']);
	//=============== Getting Training Code ==================	
	if($bank_code=='')
	{
		$rsmaxcode=fatch_bank_maxcode($dist_cd);
		$rowmaxcode=getRows($rsmaxcode);
		if($rowmaxcode['bank_cd']==null)
			$bank_code=$dist_cd."001";
		else
			$bank_code=sprintf("%05d",$rowmaxcode['bank_cd']+1);
	}
	$usercd=$user_cd;
	
	$ret;
	$c_bank=duplicate_bank($bank_code,$bank);
	
	if($c_bank==0)
	{
		if(isset($_REQUEST['bank_cd']))
		{
			$bank_code=decode($_REQUEST['bank_cd']);
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_bank($bank_code,$bank,$usercd,$posted_date);
			if($ret==1)
			{
				?> <script>location.replace("bank-master.php?msg=success");</script> <?php
			}
		}
		else
		{
			$ret=save_bank($bank_code,$bank,$dist_cd,$usercd);
		}
		if($ret==1)
		{
			$msg="<div class='alert-success'>Record saved successfully</div>";
		}
	}
	else
	{
		$msg="<div class='alert-error'>Bank Name already exists</div>";
	}
	unset($ret,$posted_date,$c_bank,$bank_code,$bank);
}
?>

<?php
if(isset($_REQUEST['bank_cd']))
{
	$bank_code=decode($_REQUEST['bank_cd']);

	$rsBank=fatch_bank_master($bank_code,'');
	$rowBank=getRows($rsBank);
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
	var bank=document.getElementById('bank');
	bank.value="<?php echo $rowBank['bank_name']; ?>";
	var bank_code=document.getElementById('hid_bank_code');
	bank_code.value="<?php echo $rowBank['bank_cd']; ?>";
}
</script>
<body oncontextmenu="return false;" onload="javascript: return bind_all();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">BANK MASTER</td></tr>
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
      <td align="left"><span class="error">*</span>Bank Name</td>
      <td align="left"><input type="text" name="bank" id="bank" style="width:250px;" /></td>
      <td align="left">District&nbsp;&nbsp;&nbsp;<label id="district" name="district" ><?php echo $dist_cd." - ".$district; ?></label></td>
    </tr><input type="hidden" id="hid_bank_code" name="hid_bank_code" />
    
	<tr>
	  <td align="left" colspan="3">&nbsp;</td></tr>
    <tr>
      <td colspan="3" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr><td colspan="3" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
    <tr><td colspan="3" align="center"><div class="scroller">
            <?php
			unset($rsBank,$num_rows,$rowBank);
			$rsBank=fatch_bank_master('',$dist_cd);
			$num_rows = rowCount($rsBank);
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
				echo "<tr height='30px'><th>Sl. No.</th><th align='center'>Bank Code</th><th align='left'>Bank Name</th><th>Edit</th><th>Delete</th></tr>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowBank=getRows($rsBank);
				  $bank_cd='"'.encode($rowBank['bank_cd']).'"';
				  echo "<tr><td width='10%' align='right'>$i.</td><td align='center' width='20%'>$rowBank[bank_cd]</td><td width='50%' align='left'>$rowBank[bank_name]</td>";
				  echo "<td align='center' width='10%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_bank($bank_cd);' /></td>\n";
				  echo "<td align='center' width='10%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_bank($bank_cd);' /></td></tr>\n";
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