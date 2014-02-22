<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Branch Master</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">

function edit_branch(str,str1)
{
	location.replace("branch-master.php?branch_cd="+str+"&bank="+str1);
}
function delete_branch(str,str1)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
		window.open("ajax-master.php?branch_cd="+str+"&bank="+str1+"&act=del","_blank","height=200,width=250,left=400,top=250, status=yes,toolbar=no,menubar=no,location=no,fullscreen=0");
		//location.replace("ajax-master.php?sub_cd="+str+"&act=del");
	}
}
function validate()
{
	var bank=document.getElementById("bank").value;
	var branch_name=document.getElementById("branch_name").value;
	var branch_address=document.getElementById("branch_address").value;
	
	if(bank=="" || bank=="0")
	{
		document.getElementById("msg").innerHTML="Select Bank Name";
		document.getElementById("bank").focus();
		return false;
	}
	if(branch_name=="")
	{
		document.getElementById("msg").innerHTML="Enter Branch Name";
		document.getElementById("branch_name").focus();
		return false;
	}
	if(branch_address=="")
	{
		document.getElementById("msg").innerHTML="Enter Branch Address";
		document.getElementById("branch_address").focus();
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
	$bank=$_POST['bank'];
	$ifsc=clean_spl($_POST['ifsc']);
	$branch_name=clean_spl($_POST['branch_name']);
	$branch_address=clean_spl($_POST['branch_address']);
	$branch_code=($_POST['hid_branch_code']);
	//=============== Getting Block_Muni Code ==================	
	if($branch_code=='')
	{
		$rsmaxcode=fatch_branch_maxcode($bank);
		$rowmaxcode=getRows($rsmaxcode);
		if($rowmaxcode['branch_cd']==null)
			$branch_code="001";
		else
			$branch_code=sprintf("%03d",$rowmaxcode['branch_cd']+1);
	}
	$usercd=$user_cd;
	
	$c_branch=duplicate_branch($bank,$branch_code,$branch_name);	
	if($c_branch==0)
	{
		if(isset($_REQUEST['branch_cd']))
		{
			$branch_code=decode($_REQUEST['branch_cd']);
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_branch($branch_code,$bank,$branch_name,$branch_address,$ifsc,$usercd,$posted_date);
			if($ret==1)
			{
				?> <script>location.replace("branch-master.php?msg=success");</script> <?php
			}
		}
		else
		{
			$ret=save_branch($branch_code,$bank,$branch_name,$branch_address,$ifsc,$usercd);
		}
		if($ret==1)
		{
			$msg="<div class='alert-success'>Record saved successfully</div>";
		}
	}
	else
	{
		$msg="<div class='alert-error'>Branch already exists</div>";
	}
	//unset($ret,$posted_date,$c_branch,$branch_code,$branch_name,$bank,$ifsc);
}
?>

<?php
if(isset($_REQUEST['branch_cd']))
{
	$branch_cd=decode($_REQUEST['branch_cd']);
	$bank_cd=decode($_REQUEST['bank']);
	
	$rsBranch=fatch_branch_master_dtl($branch_cd,$bank_cd);
	$rowBranch=getRows($rsBranch);
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
	bank.value="<?php echo $rowBranch['bank_cd']; ?>";
	var ifsc=document.getElementById('ifsc');
	ifsc.value="<?php echo $rowBranch['ifsc_code']; ?>";
	var branch_name=document.getElementById('branch_name');
	branch_name.value="<?php echo $rowBranch['branch_name']; ?>";
	var branch_address=document.getElementById('branch_address');
	branch_address.value="<?php echo $rowBranch['address']; ?>";
	var branch_code=document.getElementById('hid_branch_code');
	branch_code.value="<?php echo $rowBranch['branchcd']; ?>";
}
</script>
<body oncontextmenu="return false;" onload="javascript: return bind_all();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">BRANCH MASTER</td></tr>
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
      <td align="left"><span class="error">*</span>Bank Name</td>
      <td align="left"><select name="bank" id="bank" style="width:200px;" >
      							<option value='0'>Select</option>
      					<?php
						if(isset($rsBank))
							unset($rsBank,$num_rows,$rowBank);
						$districtcd=$dist_cd;
						$rsBank=fatch_bank_master('',$districtcd);
						$num_rows = rowCount($rsBank);
						for($i=1;$i<=$num_rows;$i++)
						{
							$rowBank=getRows($rsBank);
							echo "<option value='$rowBank[bank_cd]'>$rowBank[bank_name]</option>";
							unset($rowBank);
						}
						unset($num_rows,$rsBank);
						?>
                       </select></td>
      <td align="left">Branch IFS Code</td>
      <td align="left"><input type="text" name="ifsc" id="ifsc" style="width:82px;" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Branch Name</td>
      <td align="left" colspan="3"><input type="text" name="branch_name" id="branch_name" style="width:192px;" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Branch Address</td>
      <td align="left" colspan="3"><input type="text" name="branch_address" id="branch_address" style="width:360px;" /></td>
      <input type="hidden" id="hid_branch_code" name="hid_branch_code" />
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
			if(isset($rsBranch))
				unset($rsBranch,$rowBranch,$num_rows);
			$rsBranch=fatch_branch_master('',$dist_cd);
			$num_rows = rowCount($rsBranch);
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
				echo "<tr height='30px'><th align='center'>Sl. No</th><th align='center'>Bank Code</th><th align='left'>Branch IFSC</th><th align='left'>Branch Name</th><th align='left'>Branch Address</th><th>Edit</th><th>Delete</th></tr>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowBranch=getRows($rsBranch);
				  $branch_cd='"'.encode($rowBranch['branchcd']).'"';
				  $bank_cd='"'.encode($rowBranch['bank_cd']).'"';
				  echo "<tr><td width='5%' align='right'>$i.</td><td align='center' width='15%'>$rowBranch[bank_cd]</td><td width='15%' align='left'>$rowBranch[ifsc_code]</td>";
				  echo "<td width='25%' align='left'>$rowBranch[branch_name]</td><td width='35%' align='left'>$rowBranch[address]</td>";
				  echo "<td align='center' width='10%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_branch($branch_cd,$bank_cd);' /></td>\n";
				  echo "<td align='center' width='10%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_branch($branch_cd,$bank_cd);' /></td></tr>\n";
				  unset($rowBranch,$branch_cd,$bank_cd);
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