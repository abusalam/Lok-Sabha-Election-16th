<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Training Type Master</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function edit_training_desc(str)
{
	location.replace("training-type-master.php?tr_cd="+str);
}
function delete_training_desc(str)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
		location.replace("ajax-training.php?tr_cd="+str+"&act=del");
	}
}
function validate()
{
	var training_desc=document.getElementById("training_desc").value;

	if(training_desc=="")
	{
		document.getElementById("msg").innerHTML="Enter Training Description";
		document.getElementById("training_desc").focus();
		return false;
	}
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
$action=$_REQUEST['submit'];
if($action=='Save')
{
	include_once('function\training_fun.php');
	$training_desc=clean_spl($_POST['training_desc']);
	$training_code=($_POST['hid_training_code']);
	//=============== Getting Training Code ==================	
	if($training_code=='')
	{
		$rsmaxcode=fatch_training_type_maxcode();
		$rowmaxcode=getRows($rsmaxcode);
		if($rowmaxcode['training_code']==null)
			$training_code="01";
		else
			$training_code=sprintf("%02d",$rowmaxcode['training_code']+1);
	}
	$usercd=$user_cd;
	//str_pad($invID, 2, '0', STR_PAD_LEFT)
	
	$ret;
	$c_training_type=duplicate_training_type($training_code,$training_desc);
	
	if($c_training_type==0)
	{
		if(isset($_REQUEST['tr_cd']))
		{
			$tr_cd=decode($_REQUEST['tr_cd']);
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_training_type($training_code,$training_desc,$usercd,$posted_date);
			if($ret==1)
			{
				?> <script>location.replace("training-type-master.php?msg=success");</script> <?php
			}
		}
		else
		{
			$ret=save_training_type($training_code,$training_desc,$usercd);
		}
		if($ret==1)
		{
			$msg="<div class='alert-success'>Record saved successfully</div>";
			echo "<script>document.getElementById('training_desc').value='';</script>";
		}
	}
	else
	{
		$msg="<div class='alert-error'>Training description already exists</div>";
	}
}
?>

<?php
if(isset($_REQUEST['tr_cd']))
{
	include_once('function\training_fun.php');
	$tr_cd=decode($_REQUEST['tr_cd']);

	$rsTraining=fatch_training_type($tr_cd);
	$rowTraining=getRows($rsTraining);
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
	var training_desc=document.getElementById('training_desc');
	training_desc.value="<?php echo $rowTraining['training_desc']; ?>";
	var training_code=document.getElementById('hid_training_code');
	training_code.value="<?php echo $rowTraining['training_code']; ?>";
}
</script>
<body oncontextmenu="return false;" onload="javascript: return bind_all();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">TRAINING TYPE MASTER</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="55%" class="form" cellpadding="0">
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
      <td align="left"><span class="error">*</span>Training Description</td>
      <td align="left"><input type="text" name="training_desc" id="training_desc" style="width:250px;" /></td>
    </tr><input type="hidden" id="hid_training_code" name="hid_training_code" />
    
	<tr>
	  <td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr><td colspan="2" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
    <tr><td colspan="2" align="center">
            <?php
			include_once('function\training_fun.php');
			$rsTrainingType=fatch_training_type('');
			$num_rows = rowCount($rsTrainingType);
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
				echo "<tr height='30px'><th>Training Code</th><th>Training Description</th><th>Edit</th><th>Delete</th></tr>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowTrainingType=getRows($rsTrainingType);
				  $training_cd='"'.encode($rowTrainingType['training_code']).'"';
				  echo "<tr><td align='center' width='20%'>$rowTrainingType[0]</td><td width='60%' align='left'>$rowTrainingType[1]</td>";
				  echo "<td align='center' width='10%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_training_desc($training_cd);' /></td>\n";
				  echo "<td align='center' width='10%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_training_desc($training_cd);' /></td></tr>\n";
				}
				echo "</table>\n";
			}
			else
			{
				echo "<div id='table1' style='border: 1px solid;'>No records found</div>";
			}
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