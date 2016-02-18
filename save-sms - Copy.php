<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Save SMS</title>
<?php
include('header/header.php');
?>
<?php
$subdiv_cd="0";
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
?>
</head>
<?php
include_once('function/add_fun.php');
include_once('function/appointment_fun.php');
if(isset($_REQUEST['send']) && $_REQUEST['send']!=null)
	$sub=$_REQUEST['send'];
else
	$sub="";
if($sub=="Save SMS")
{
		$rec=0;
		include_once('inc/commit_con.php');
		mysqli_autocommit($link,FALSE);
		$sql="insert into tblsms (name,phone_no,message) values (?,?,?)";
		$stmt = mysqli_prepare($link, $sql);
		mysqli_stmt_bind_param($stmt, 'sss', $name,$mob_no,$Msg);
		$subdiv_name=Subdivision_ag_subdivcd($subdiv_cd);

		$rs_data=fetch_first_rand_tab_ag_subdiv($subdiv_name);
		if(rowCount($rs_data)>0)
		{
			for($i=1;$i<=rowCount($rs_data);$i++)
			{
				$row_data=getRows($rs_data);
				$name=$row_data['officer_name'];
				$personcd=$row_data['personcd'];
				$mob_no=$row_data['mob_no'];
				$post_status=$row_data['poststatus'];
				$training_desc=$row_data['training_desc'];
				$venuename=$row_data['venuename'];
				$venueaddress=$row_data['venueaddress'];
				$training_dt=$row_data['training_dt'];
				$training_time=$row_data['training_time'];
				
				$DestinationAddress = $mob_no;
				$Message = $name.", you are appointed as ".$post_status." for LS-14 election. Your training venue: ".$venuename.",date: ".$training_dt.", time:".$training_time.".";
				$Msg=$Message;
				//include('sms/Index.php');
				
				
				mysqli_stmt_execute($stmt);
				$rec+=mysqli_stmt_affected_rows($stmt);
				
			}
				
		}
		if (!mysqli_commit($link)) {
		print("Transaction commit failed\n");
		exit();
		}
		else
		{
			$msg="<div class='alert-success'>$rec Record(s) saved successfully</div>";
		}
		mysqli_stmt_close($stmt);
		mysqli_close($link);
?>		<script>window.open('tt.php');</script>		
<!--<script>location.replace("save-sms.php?msg=success");</script> -->            
                <?php
}
?>
<?php
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		//$msg="<div class='alert-success'>Message sent successfully</div>";
	}
}
?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $subdiv_name; ?> SUBDIVISION</td></tr>
<tr>
  <td align="center">SAVE SMS FOR POLLING PERSONNEL</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="50%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<tr>
	  <td align="center" colspan="2"><input type="submit" name="send" id="send" value="Save SMS" class="button"  style="height:100px; width:200px;" /></td></tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table></form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>