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
<?php
if(isset($_REQUEST['populate']) && $_REQUEST['populate']!=null)
	$sub=$_REQUEST['populate'];
else
	$sub="";
if($sub=="Populate")
{
 ?>
<script type="text/javascript" language="javascript">
function populate_click()
{
	var subdiv=document.getElementById('hid_subdiv').value;
	//window.history.back();
	//document.getElementById("rand_result").innerHTML="";
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
		document.getElementById("populate_result").innerHTML=xmlhttp.responseText;
		document.getElementById("populate").disabled=true;
		document.getElementById("form1").style="cursor:default";
		}
	  }
	xmlhttp.open("GET","first_app_letter_populate.php?subdiv_cd="+subdiv+"&dist=<?php print $dist_cd; ?>",true);
	document.getElementById("populate_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
	document.getElementById("form1").style="cursor:wait";
	xmlhttp.send();
}
</script>
<?php
}
?>
</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/appointment_fun.php');
/*$subdiv=(isset($_POST['Subdivision'])?$_POST['Subdivision']:'0');
$posting_status=isset($_POST['posting_status'])?$_POST['posting_status']:'0';
$submit=(isset($_POST['submit'])?$_POST['submit']:'');
$n=0;
if($submit=='Submit')
{
	/*$rstmp=first_appointment_letter3_subdiv($subdiv,$posting_status);
	$row=0;
	//echo rowCount($rstmp);
	//exit();
	while($row <= rowCount($rstmp))
	{
		$tmprow=getRows($rstmp);
		//$str_sub_div=$tmprow['subdivision'];
		$str_post_stat=$tmprow['poststatus'];
		delete_prev_data_app3($subdiv,$str_post_stat);
		//$del_ret=delete_prev_data_app3($subdiv,$str_post_stat);
		//	echo "vall=".$del_ret;
		//mysqli_stmt_bind_param($stmt1, 's', $str_sub_div);
		//mysqli_stmt_execute($stmt1);
		$row++;
	}*/
	
	//$str_post_stat=mysql_real_escape_string($_REQUEST['posting_status']);
	//echo $str_post_stat;
	//exit;
	/*$maker = isset($_POST['selected_text'])?$_POST['selected_text']:'0';
	delete_prev_data_app3($subdiv,$maker);
	$rsApp=first_appointment_letter3($subdiv,$posting_status,$maker);
	if($rsApp<1)
	{
		$msg="<div class='alert-error'>Selected persons are not available for training</div>";
	}
	else
	{
		$msg="<div class='alert-success'>$rsApp Record(s) saved successfully</div>";
	}
	unset($rsApp);
	
	/*$num_rows=rowCount($rsApp);
	
	if($num_rows>0)
	{
		include_once('inc/commit_con.php');
		mysqli_autocommit($link,FALSE);
		$sql="insert into first_rand_table (officer_name,person_desig,personcd,office,address,block_muni,postoffice,subdivision,policestation, district,pin,officecd,poststatus,mob_no,training_desc,venuename,venueaddress,training_dt,training_time,pc_code,pc_name,forsubdivision,epic,acno,partno,slno,bank,branch,bank_accno,ifsc,token) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt = mysqli_prepare($link, $sql);
		
		mysqli_stmt_bind_param($stmt, 'sssssssssssssssssssssssssssssss', $officer_name,$person_desig,$personcd,$office,$office_address,$block_muni,$postoffice,$subdivision,$policestation,$district,$pin,$officecd,$poststatus,$mob_no,$training_desc,$venuename,$venue_add,$training_dt,$training_time,$forpc,$pcname,$forsubdivision,$epic,$acno,$partno,$slno,$bank_name,$branch_name,$bank_acc_no,$ifsc_code,$token);
				
		for($i=1;$i<=$num_rows;$i++)
		{
		
			$rowApp=getRows($rsApp);
			
			$officer_name=$rowApp['officer_name'];
			$person_desig=$rowApp['person_desig'];
			$personcd=$rowApp['personcd'];
			$office=$rowApp['office'];
			$office_address=$rowApp['address1'].", ".$rowApp['address2'];
			$block_muni=$rowApp['blockormuni_cd'];
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
			$pcname="";
			$epic=$rowApp['epic'];
			$acno=$rowApp['acno'];
			$partno=$rowApp['partno'];
			$slno=$rowApp['slno'];
			$bank_name=$rowApp['bank_name'];
			$branch_name=$rowApp['branch_name'];
			$bank_acc_no=$rowApp['bank_acc_no'];
			$ifsc_code=$rowApp['ifsc_code'];
			$forsubdivision=$rowApp['forsubdivision'];
			$token=substr($rowApp['pp_subdivision'], 0, 4)."/".$rowApp['post_stat']."/".$rowApp['token'];
			
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
		$msg="<div class='alert-error'>Selected persons are not available for training</div>";
	}*/
/*}*/
?>
<body onload="return populate_click();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print uppercase($district); ?> DISTRICT</td></tr>
<tr>
  <td align="center">FIRST APPOINTMENT LETTER ISSUE</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" >
    <table width="50%" class="form" cellpadding="0">
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td colspan="2" style="height:10px" align="center">&nbsp;</td></tr>
    <tr>
      <td align="center" colspan="2"><div id="populate_result">&nbsp;</div></td></tr>
      
    <tr><td align="center"><img src="images/blank.gif" alt="" height="5px" /></td><td align="right"><strong>»</strong>&nbsp;<a href="first-appointment-letter3-print.php" class="k-button">Print Letter</a></td></tr>
    <input type="hidden" id="hid_subdiv" value="<?php print $subdiv_cd; ?>" />
    <tr><td colspan="2" style="height:10px" align="center">&nbsp;</td></tr>
	<tr>
	  <td align="center" colspan="2"><input type="submit" name="populate" id="populate" value="Populate" class="button"  style="height:50px; width:100px;" /></td>
  
    </tr>
      <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
      <tr><td colspan="2" style="height:10px" align="center">&nbsp;</td></tr>
      <tr><td colspan="2" style="height:10px" align="center">&nbsp;</td></tr>
</table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
<div id="fakecontainer" style="display:none;"><div id="loading">Please wait...</div></div> 
</body>

</html>
<script type="text/javascript" language="javascript">
function bind_data()
{
	var subdivision=document.getElementById('Subdivision');
	for (var i = 0; i < subdivision.options.length; i++) 
	{
		if (subdivision.options[i].value == "<?php echo $subdiv_cd; ?>")
		{
			subdivision.options[i].selected = true;
		}
    }
	
}
</script>
<script language="javascript" type="text/javascript">
/*(function (d) {
  d.getElementById('form1').onsubmit = function () {
	  d.getElementById('form1').style.display= 'none';
      d.getElementById('fakecontainer').style.display = 'block';
  };
}(document));*/
</script>