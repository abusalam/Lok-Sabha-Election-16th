<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Validation</title>
</head>
<?php
include('header/header.php');
include_once('inc/db_trans.inc.php');
include_once('function/personnel_report_fun.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Start Validation')
{
	//$Subdivision=isset($_REQUEST["Subdivision"])?$_REQUEST["Subdivision"]:"";
	if(isset($_SESSION['subdiv_cd']))
	  $subdiv_cd=$_SESSION['subdiv_cd'];
    else
	  $subdiv_cd="0";
	$type=isset($_REQUEST["type"])?$_REQUEST["type"]:"";
	if($type==1)
	{
	  $rsOffice=fatch_personnelvalidation($subdiv_cd);
	  $num_rows = rowCount($rsOffice);
	  if($num_rows<1)
		{
			$msg="<div class='alert-success'>Successfully validate</div>";
		}
		else
		{
			//redirect("ajax/office_excel.php");
			$msg="<div class='alert-error'>Record invalid</div>";
			$errorfile="<a href='ajax/personnel_validation_error.php'>View File</a>";
			/*$filename = "officereport.xls"; // File Name
			// Download file
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Type: application/vnd.ms-excel");
			
			$body = "Sl No"."\t"."Office ID"."\t"."Personnel Id"."\t"."Name"."\t"."Designation."."\t"."Date of Birth"."\t"."Gender"."\t"."Subdivision"."\t"."Post Status"."\t"."Present Assembly"."\t"."Place of Posting"."\t"."Permanent Assembly"."\t"."Voter of Assembly"."\t"."Qualification"."\t \n ";
			 echo $body;
			for($i=1;$i<=$num_rows;$i++)
			{
			   $row=getRows($rsOffice);
			   echo $i."\t";
			   echo $row['0']."\t";
			   
			   echo $row['1']."\t";
			   echo $row['2']."\t";
			   echo $row['3']."\t";
			   echo $row['4']."\t";
			   echo $row['5']."\t";
			   echo $row['6']."\t";
			   echo $row['7']."\t";
			   echo $row['8']."\t";
			   echo $row['9']."\t";
			   echo $row['10']."\t";
			   echo $row['11']."\t \n";
			}*/

		}
	}
}
?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2">
  <?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">Validation</td></tr>
<tr><td align="center">
<form method="post" name="form1" id="form1" action="">
	<table width="80%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="left" width="20%">Type</td>
      <td align="left">
      <select name="type" id="type" style="width:160px;">
          <option value="1">Personnel Wise</option>
          <!--<option value="2">Office Wise</option>-->
      </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php print isset($errorfile)?$errorfile:""; ?>
      </td>
    </tr>
   <input type="hidden" name="user" value="<?php echo $user_cd; ?>" />
  <!--  <tr>
      <td align="left">Gender</td>
      <td><select name="gender" id="gender" style="width:150px;">
          <option value="0">-Select Gender-</option>
           <option value="Male">Male</option>
           <option value="Female">Female</option>
          </select></td>
      <td colspan="2"></td>
    </tr>--> 
    
    <tr>
       <td colspan="2" align="center"><img src="images/blank.gif" alt="" height="10px" /></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Start Validation" class="button" />&nbsp;</td></tr>
    <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
     <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    </table>
</form></td></tr>
</table></td></tr>
</table></div>
<div id="calendar" style="width: 243px;display:none;"></div>  
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