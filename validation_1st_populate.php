<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Validation before first randomisation populate</title>
<?php
include('header/header.php');
include('function/validation_first_populate.php');
?>
<?php
$pc_cd="0";
if(isset($_SESSION['subdiv_cd']) && $_SESSION['subdiv_cd']!=null)
	$subdiv_cd=sprintf("%02d",$_SESSION['subdiv_cd']);
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
	$no_rcd;
	/***************Populate validation***********/
	    $cnt_pers=personnel_record_check();
        $cnt_off=office_record_check();
		$cnt_block=block_muni_record_check();
		$cnt_ps=police_station_record_check();
		$cnt_sub=subdiv_record_check();
		
		$cnt_post=poststatus_record_check();
		$cnt_bank=bank_record_check();
		$cnt_branch=branch_record_check();
		$cnt_pp=training_pp_record_check();
		//$cnt_type=training_type_record_check();
    switch($cnt_pers)
	{
		
	    case ($cnt_pers!=$cnt_off):
		      $no_rcd=$cnt_pers-$cnt_off;
			  $msg="<div class=''> <b>$no_rcd</b> Record(s) are inconsistent between office and personnela table.Please check officecd in offce and personnela table.</div>";
	         
			break;
		case ($cnt_pers!=$cnt_block):
		      $no_rcd=$cnt_pers-$cnt_block;
			  $msg="<div class=''> <b>$no_rcd</b> Record(s) are inconsistent between office and block_muni table.Please check blockormuni_cd in offce and blockminicd in block_muni table.</div>";
	         
			break;
		case ($cnt_pers!=$cnt_ps):
		      $no_rcd=$cnt_pers-$cnt_ps;
			  $msg="<div class=''> <b>$no_rcd</b> Record(s) are inconsistent between office and policestation table.Please check policestn_cd in offce and policestationcd in policestation table.</div>";
	       
			break;
		case ($cnt_pers!=$cnt_sub):
		      $no_rcd=$cnt_pers-$cnt_sub;
			  $msg="<div class=''> <b>$no_rcd</b> Record(s) are inconsistent between office and subdivision table.Please check subdivisioncd in offce and subdivisioncd in subdivision table.</div>";
			break;
		case ($cnt_pers!=$cnt_post):
		      $no_rcd=$cnt_pers-$cnt_post;
			  $msg="<div class=''> <b>$no_rcd</b> Record(s) are inconsistent between personnela and poststat table.Please check post_stat in poststat and poststat in personnela table.</div>";
			break;
		case ($cnt_pers!=$cnt_bank):
		      $no_rcd=$cnt_pers-$cnt_bank;
			  $msg="<div class=''> <b>$no_rcd</b> Record(s) are inconsistent between personnela and bank table.Please check bank_cd in bank and bank_cd in personnela table.</div>";
			break;
		case ($cnt_pers!=$cnt_branch):
		      $no_rcd=$cnt_pers-$cnt_branch;
			  $msg="<div class=''> <b>$no_rcd</b> Record(s) are inconsistent between personnela and branch table.Please check branchcd in branch and branchcd in personnela table.</div>";
	         
			break;
		case ($cnt_pers!=$cnt_pp):
		      $no_rcd=$cnt_pers-$cnt_pp;
			  $msg="<div class=''> <b>$no_rcd</b> Record(s) are inconsistent between personnela and training_pp table.Please check per_code in training_pp and personcd in personnela table.</div>";
	          $count++;
			break;
		
	    default:
		   $msg="<div class='alert-success'>Data successfully validate</div>";
		 break;
	}
	/*if($cnt_off=='0' || $cnt_off=='')
	{
	  $msg="<div class='alert-error'>Data inconsistent between office and personnela table</div>";
	  $count++;
	}
	else if($cnt_block=='0' || $cnt_block=='')
	{
	  $msg="<div class='alert-error'>Data inconsistent between office and block_muni table</div>";
	  $count++;
	}
	else if($cnt_ps=='0' || $cnt_ps=='')
	{
	  $msg="<div class='alert-error'>Data inconsistent between office and policestation table</div>";
	  $count++;
	}
	else if($cnt_sub=='0' || $cnt_sub=='')
	{
	  $msg="<div class='alert-error'>Data inconsistent between office and subdivision table</div>";
	  $count++;
	}
	else if($cnt_post=='0' || $cnt_post=='')
	{
	  $msg="<div class='alert-error'>Data inconsistent between personnela and poststat table</div>";
	  $count++;
	}
	else if($cnt_bank=='0' || $cnt_bank=='')
	{
	  $msg="<div class='alert-error'>Data inconsistent between personnela and bank table</div>";
	  $count++;
	}
	else if($cnt_branch=='0' || $cnt_branch=='')
	{
	  $msg="<div class='alert-error'>Data inconsistent between personnela and branch table</div>";
	  $count++;
	}
	else if($cnt_pp=='0' || $cnt_pp=='')
	{
	  $msg="<div class='alert-error'>Data inconsistent between personnela and training_pp table</div>";
	  $count++;
	}
	else if($cnt_type=='0' || $cnt_type=='')
	{
	  $msg="<div class='alert-error'>Data inconsistent between personnela and training_type table</div>";
	  $count++;
	}*/
	  
	
	/*************************show success message*****************/
	
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
  <td align="center">VALIDATION BEFORE FIRST RANDOMISATION POPULATE</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="60%" class="form" cellpadding="0">
	<tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td height="30px" colspan="3" align="center"><?php print isset($msg)?$msg:""; ?>&nbsp;&nbsp;&nbsp; <?php print isset($errorfile)?$errorfile:""; ?><span id="msg" class="error"></span></td></tr>
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