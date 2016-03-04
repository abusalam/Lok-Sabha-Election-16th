<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Validation before Second randomisation</title>
<?php
include('header/header.php');
include('function/validation_first.php');
?>
<?php
$pc_cd="0";
if(isset($_SESSION['subdiv_cd']) && $_SESSION['subdiv_cd']!=null)
	$subdiv_cd=sprintf("%04d",$_SESSION['subdiv_cd']);
?>
</head>
<?php
if(isset($_REQUEST['start']) && $_REQUEST['start']!=null)
	$start=$_REQUEST['start'];
else
	$start="";
if($start=="Start")
{
	$count=0;
	
	/************************Assembly party and DCRC validate**************/
	if($count==0)
	{
		$array_asmparty=fetch_array_asmparty($subdiv_cd);
		foreach($array_asmparty as $arprow) {
			$cnt=check_in_dcrcparty($arprow['ad'],$arprow['nm'],$arprow['np'],$arprow['sd']);
			if($cnt==0)
			{
				$count++;
				$msg="<div class='alert-error'>Data does not match between DCRC master and Assembly party</div>";
				break;
			}
		}
	}
	
	//exit();
	/************comparing two array********/
	//$result1=array_intersect($array_asmparty,$array_dcrcparty);
	//echo count($result1);
		
	//exit();
	//echo count($result1);
	
	/*************************show success message*****************/
	if($count==0)
	{
		 $msg="<div class='alert-success'>Data matched</div>";
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
  <td align="center">VALIDATION BEFORE SECOND RANDOMISATION</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="50%" class="form" cellpadding="0">
	<tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td height="18px" colspan="3" align="center"><?php print isset($msg)?$msg:""; ?>&nbsp;&nbsp;&nbsp; <?php print isset($errorfile)?$errorfile:""; ?><span id="msg" class="error"></span></td></tr>
	<tr>
      <td align="center" colspan="3"><div id="populate_result">&nbsp;</div></td></tr>
    <tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<input type="hidden" id="hid_subdiv" value="<?php print $subdiv_cd; ?>" />
    <input type="hidden" name="hid_rand" value="<?php echo rand(0,500); ?>" />
	<!--<tr><td align="center" colspan="2">Password: &nbsp;&nbsp;&nbsp;<input type="password" id="txt1" name="txt1" /></td></tr>-->
    <tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<tr>
	  <td align="center"></td>
      <td align="center"><input type="submit" name="start" id="start" value="Start" class="button"  style="height:50px; width:100px;" /></td>
      <td align="center"></td></tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr><td colspan="3" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
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