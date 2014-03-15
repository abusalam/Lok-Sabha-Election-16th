<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>First Appointment Letter</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function validate()
{
	var subdivision=document.getElementById("Subdivision");
	var posting_status=document.getElementById("posting_status");

	if(subdivision.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("Subdivision").focus();
		return false;
	}
	//alert(pc.options.length);
	if(posting_status.value=="" || posting_status.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Office";
		document.getElementById("office").focus();
		return false;
	}

}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/appointment_fun.php');
$subdiv=(isset($_POST['Subdivision'])?$_POST['Subdivision']:'0');
$posting_status=(isset($_POST['posting_status'])?$_POST['posting_status']:'0');
$submit=(isset($_POST['submit'])?$_POST['submit']:'');
$n=0;
if($submit=='Submit')
{
	$rstmp=first_appointment_letter3_subdiv($subdiv,$posting_status);
	$row=0;
	while($row <= rowCount($rstmp))
	{
		$tmprow=getRows($rstmp);
		//$str_sub_div=$tmprow['subdivision'];
		$str_post_stat=$tmprow['poststatus'];
		$del_ret=delete_prev_data_app3($subdiv,$str_post_stat);
		//	echo "vall=".$del_ret;
		//mysqli_stmt_bind_param($stmt1, 's', $str_sub_div);
		//mysqli_stmt_execute($stmt1);
		$row++;
	}
	$rsApp=first_appointment_letter3($subdiv,$posting_status);
	$num_rows=rowCount($rsApp);
	if($num_rows>0)
	{
		include_once('inc/commit_con.php');
		mysqli_autocommit($link,FALSE);
		$sql="insert into first_rand_table (officer_name,person_desig,personcd,office,address,postoffice,subdivision,policestation, district,pin,officecd,poststatus,mob_no,training_desc,venuename,venueaddress,training_dt,training_time,pc_code,pc_name,forsubdivision,epic,acno,partno,slno,bank,branch,bank_accno,ifsc,token) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt = mysqli_prepare($link, $sql);
		
		mysqli_stmt_bind_param($stmt, 'ssssssssssssssssssssssssssssss', $officer_name,$person_desig,$personcd,$office,$office_address,$postoffice,$subdivision,$policestation,$district,$pin,$officecd,$poststatus,$mob_no,$training_desc,$venuename,$venue_add,$training_dt,$training_time,$forpc,$pcname,$forsubdivision,$epic,$acno,$partno,$slno,$bank_name,$branch_name,$bank_acc_no,$ifsc_code,$token);
				
		for($i=1;$i<=$num_rows;$i++)
		{
		
			$rowApp=getRows($rsApp);
			
			$officer_name=$rowApp['officer_name'];
			$person_desig=$rowApp['person_desig'];
			$personcd=$rowApp['personcd'];
			$office=$rowApp['office'];
			$office_address=$rowApp['address1'].", ".$rowApp['address2'];
			$postoffice=$rowApp['postoffice'];
			$subdivision=$rowApp['subdivision'];
			$policestation=$rowApp['policestation'];
			$district=$rowApp['district'];
			$pin=$rowApp['pin'];
			$officecd=$rowApp['officecd'];
			$poststatus=$rowApp['poststatus'];
			$mob_no=$rowApp['mob_no'];
			
			$training_desc=$rowApp['training_desc'];
			$venuename=$rowApp['venuename'];
			$venue_add=$rowApp['venueaddress1'].", ".$rowApp['venueaddress2'];
			$training_dt=$rowApp['training_dt'];
			$training_time=$rowApp['training_time'];	
			
			$forpc=$rowApp['forpc'];
			$pcname=$rowApp['pcname'];
			$epic=$rowApp['epic'];
			$acno=$rowApp['acno'];
			$partno=$rowApp['partno'];
			$slno=$rowApp['slno'];
			$bank_name=$rowApp['bank_name'];
			$branch_name=$rowApp['branch_name'];
			$bank_acc_no=$rowApp['bank_acc_no'];
			$ifsc_code=$rowApp['ifsc_code'];
			$forsubdivision=$rowApp['forsubdivision'];
			$token=$rowApp['post_stat']."/".$rowApp['token'];
			
			mysqli_stmt_execute($stmt);
			$n+=mysqli_stmt_affected_rows($stmt);
			$rowApp=NULL;
		}
		unset($rsApp,$num_rows,$rowApp);
		if (!mysqli_commit($link)) {
			print("Transaction commit failed\n");
			exit();
		}
		else
		{
			$msg="<div class='alert-success'>".$n." Record(s) saved successfully</div>";
		}
		mysqli_stmt_close($stmt);
		mysqli_close($link);
	}
	else
	{
		$msg="<div class='alert-error'>Selected persons are not alloted for training</div>";
	}
}
?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print uppercase($district); ?> DISTRICT</td></tr>
<tr>
  <td align="center">FIRST APPOINTMENT LETTER ISSUE</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" >
    <table width="70%" class="form" cellpadding="0">
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td colspan="2" style="height:10px" align="center">&nbsp;</td></tr>
	<tr>
	  <td align="left"><span class="error">*</span>Subdivision</td>
	  <td align="left"><select name="Subdivision" id="Subdivision" style="width:240px;">
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
									$rsBn=null;
									$num_rows=0;
									$rowSubDiv=null;
							?>
      				</select></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Post Status </td>
      <td align="left"><select name="posting_status" id="posting_status" style="width:170px;">
      						<option value="0">-Select Post Status-</option>
                            <?php 	$rsP=fatch_postingstatus();
									$num_rows=rowCount($rsP);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowP=getRows($rsP);
											echo "<option value='$rowP[0]'>$rowP[1]</option>\n";
										}
									}
									$rsP=null;
									$num_rows=0;
									$rowP=null;
							?>
      				</select></td>
    </tr>   
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Submit" class="button" onclick="javascript:return validate();" /></td></tr>
      <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>