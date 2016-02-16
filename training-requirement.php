<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Training Requirement</title>
<?php
include('header/header.php');
?>

<script type="text/javascript" language="javascript">
function validate()
{
	var training_type=document.getElementById("training_type").value;
	var post_status=document.getElementById("post_status").value;
	var subdivision=document.getElementById("subdivision").value;
	if(training_type=="0")
	{
		document.getElementById("msg").innerHTML="Select Training Type";
		document.getElementById("training_type").focus();
		return false;
	}
	if(post_status=="0")
	{
		document.getElementById("msg").innerHTML="Select Post Status";
		document.getElementById("post_status").focus();
		return false;
	}
	if(subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("subdivision").focus();
		return false;
	}
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Select PP')
{
	$training_type=$_POST['training_type'];
	$post_status=$_POST['post_status'];
	$subdivision=$_POST['subdivision'];
	$usercd=$user_cd;
	include_once('function/training_fun.php');
	$rec=0;	$ct_emp=0;
	
	delete_training_pp($training_type,$post_status,$subdivision);
	
	$rsEmp=fatch_employee_for_training_req($usercd,$post_status,$subdivision,$training_type);
	if($rsEmp<1)
	{
		$msg="<div class='alert-error'>No personnel found</div>";
	}
	else
	{
		$msg="<div class='alert-success'>$rsEmp Record(s) saved successfully</div>";
	}
	unset($rsEmp);
	/*$num_rows_Emp=rowCount($rsEmp);
    //echo $num_rows_Emp;
	//exit;
	$ct_emp=$num_rows_Emp;
	if($num_rows_Emp>0)
	{	
		include_once('inc/commit_con.php');
		mysqli_autocommit($link,FALSE);
		$sql="insert into training_pp (per_code,per_name,designation,training_type,post_stat,subdivision,for_subdivision,for_pc,assembly_temp,";
		$sql.="assembly_off, assembly_perm, usercode,training_sch,training_booked,training_attended,training_showcause) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt = mysqli_prepare($link, $sql);
		for($i=1;$i<=$num_rows_Emp;$i++)
		{
			$rowEmp=getRows($rsEmp);
			
			$per_code=$rowEmp['personcd'];
			$per_name=$rowEmp['officer_name'];
			$per_desg=$rowEmp['off_desg'];
			$for_subdiv=$rowEmp['forsubdivision'];
			$for_pc=$rowEmp['forpc'];
			$ass_temp=$rowEmp['assembly_temp'];
			$ass_off=$rowEmp['assembly_off'];
			$ass_per=$rowEmp['assembly_perm'];
			$subdiv=$rowEmp['subdivisioncd'];
			
			$training_sch=NULL;
			$training_booked=NULL;
			$training_attended=NULL;
			$training_showcause=NULL;	//$ret=save_training_req($per_code,$per_name,$per_desg,$training_type,$post_status,$subdivision,$for_subdiv,$for_pc,$ass_temp,$ass_off,$ass_per,$usercd);
			mysqli_stmt_bind_param($stmt, 'sssssssssssissss', $per_code,$per_name,$per_desg,$training_type,$post_status,$subdiv,$for_subdiv,$for_pc,$ass_temp,$ass_off,$ass_per,$usercd,$training_sch,$training_booked,$training_attended,$training_showcause);
			mysqli_stmt_execute($stmt);
			$rec+=mysqli_stmt_affected_rows($stmt);
			$rowEmp=NULL;
		}
		if (!mysqli_commit($link)) {
			print("Transaction commit failed\n");
			exit();
		}
		else
		{
			if($rec>0)
				$msg="<div class='alert-success'>$rec Record(s) saved successfully</div>";
			else if($rec+$ct_emp==0)
				$msg="<div class='alert-error'>No record saved</div>";
		}
		mysqli_stmt_close($stmt);
		mysqli_close($link);
	}
	else
	{
		$msg="<div class='alert-error'>No personnel found</div>";
	}
	unset($rsEmp,$num_rows_Emp);*/
}
?>
<?php
	include_once('function/training_fun.php');
	$subdiv_cd="0";
	if(isset($_SESSION['subdiv_cd']))
		$subdiv_cd=$_SESSION['subdiv_cd'];

	$rsSelectedPP=fatch_no_of_PP_selected($subdiv_cd);
	$num_rows_SelectedPP=rowCount($rsSelectedPP);
	if($num_rows_SelectedPP>0)
	{
		for($i=0;$i<$num_rows_SelectedPP;$i++)
		{
			$rowSelectedPP=getRows($rsSelectedPP);
			$tr_type[$i]=$rowSelectedPP['training_desc'];
			$post_stat[$i]=$rowSelectedPP['poststatus'];
			$total[$i]=$rowSelectedPP['total'];
			$rowSelectedPP=null;
		}
	}
	$rsSelectedPP=null;
?>
<script type="text/javascript" language="javascript">
function bind_data()
{
	var subdivision=document.getElementById('subdivision');
	for (var i = 0; i < subdivision.options.length; i++) 
	{
		if (subdivision.options[i].value == "<?php echo $subdiv_cd; ?>")
		{
			subdivision.options[i].selected = true;
		}
    }
	var no_pp_selected=document.getElementById('no_pp_selected');
	no_pp_selected.innerHTML="<?php
		for($i=0;$i<$num_rows_SelectedPP;$i++)
		{
			//echo "P".($i+1).": ".$total[$i]."<br>";
			echo $post_stat[$i].": ".$total[$i]." - ".$tr_type[$i]."<br>";
		}
	?>";
	
}
</script>
<body onload="javascript:return bind_data();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $subdiv_name; ?> SUBDIVISION</td></tr>
<tr>
  <td align="center">TRAINING REQUIREMENT</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="70%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    <tr><td align="left" valign="top" width="35%"><span class="error">&nbsp;&nbsp;</span>No of PP Selected</td><td align="left" id="no_pp_selected"></td></tr>
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
	<tr>
	  <td align="left"><span class="error">*</span>Training Type</td>
	  <td align="left"><select name="training_type" id="training_type" style="width:200px;">
	    <option value="0">-Select Training Type-</option>
		<?php
			$rsTrainingType=fatch_training_type('');
			$num_rows=rowCount($rsTrainingType);
			if($num_rows>0)
			{
				for($i=1;$i<=$num_rows;$i++)
				{
					$rowTrainingType=getRows($rsTrainingType);
					echo "<option value='$rowTrainingType[0]' >$rowTrainingType[1]</option>\n";
					$rowTrainingType=NULL;
				}
			}
			unset($rsTrainingType,$num_rows,$rowTrainingType);
		?>
	    </select></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Post Status</td>
      <td align="left"><select name="post_status" id="post_status" style="width:200px;">
		<option value="0">-Select Posting Status-</option>
                            <?php 	$rsP=fatch_postingstatus();
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
      </select></td>
    </tr>
    
    <tr>
      <td align="left"><span class="error">*</span>Subdivision</td>
      <td align="left"><select name="subdivision" id="subdivision" style="width:200px;">
    							<option value="0">-Select Subdivision-</option>
								<?php 	$rsSubDiv=fatch_Subdivision($dist_cd);
										$num_rows=rowCount($rsSubDiv);
										if($num_rows>0)
										{
											for($i=1;$i<=$num_rows;$i++)
											{
												$rowSubDiv=getRows($rsSubDiv);
												echo "<option value='$rowSubDiv[0]'>$rowSubDiv[2]</option>\n";
												$rowSubDiv=NULL;
											}
										}
										unset($rsSubDiv,$num_rows,$rowSubDiv);;
								?>
                            </select></td></tr>
    
    <tr id="trSubdiv" style="visibility:hidden;"><td align="left">&nbsp;</td><td align="left">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Select PP" class="button" onclick="javascript:return validate();" /></td></tr>
      <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table></form>
</td></tr></table>
</td></tr>
</table>
</div>
<div id="fakecontainer" style="display:none;"><div id="loading">Please wait...</div></div> 
</body>

</html>

<script language="javascript" type="text/javascript">
(function (d) {
  d.getElementById('form1').onsubmit = function () {
	  d.getElementById('form1').style.display= 'none';
      d.getElementById('fakecontainer').style.display = 'block';
  };
}(document));
</script>