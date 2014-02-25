<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Appointment Letter</title>
<?php
include('header/header.php');
?>
<?php
$subdiv_cd="0";
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
?>
<script language="javascript" type="text/javascript">
function PC_change(str)
{
	var sub_div=document.getElementById('hid_subdiv').value;
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
		document.getElementById("assembly_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-appointment.php?pc="+str+"&sub_div="+sub_div+"&opn=assembly",true);
	xmlhttp.send();
}
</script>
</head>
<body>
<?php
extract($_POST);
$submit=$_POST['search'];
if($submit=="Submit")
{
	$pc=encode($_POST['PC']);
	$assembly=encode($_POST['assembly']);
	$group_id=encode($_POST['txtGroupId']);
	?>
    <script>
		window.open("reports/2nd-app-letter.php?pc=<?php echo $pc; ?>&assembly=<?php echo $assembly; ?>&group_id=<?php echo $group_id; ?>");
	</script>
    <?php
}
?>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $_SESSION[subdiv_name]; ?> SUBDIVISION</td></tr>
<tr><td align="center">SECOND APPOINTMENT LETTER</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
	<table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <!--<tr>
      <td align="left">User ID</td>
      <td align="left"><select name="user" id="user"></select></td><td colspan="2">&nbsp;</td>
    </tr>-->
    <tr><td colspan="2" width="55%">
        <table width="100%">
        <tr><input type="hidden" id="hid_subdiv" value="<?php print $subdiv_cd; ?>" />
          <td align="left">Parliamentary Constituency</td>
          <td align="left"><select name="PC" id="PC" style="width:180px;" onchange="return PC_change(this.value);">
          					<option value="0">-Select PC-</option>
                            <?php 	$districtcd=$dist_cd;
									include_once('function/form_12_fun.php');
									$rsPC=fatch_PC_ag_dist($districtcd);
									$num_rows=rowCount($rsPC);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowPC=getRows($rsPC);
											echo "<option value='$rowPC[0]'>$rowPC[1]</option>\n";
											$rowPC=null;
										}
									}
									$rsPC=null;
									$num_rows=0;
							?>
      					</select>
          </td>
          <td rowspan="2" width="50px">OR</td>
        </tr>
        <tr>
          <td align="left">Assembly Constituency</td>
          <td align="left" id="assembly_result"><select name="assembly" id="assembly" style="width:180px;"></select></td>
        </tr>
        </table>
        </td>
        <td>Group ID</td><td><input type="text" name="txtGroupId" id="txtGroupId" width="130px" /></td>
    </tr>
    <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="10px" /></td></tr>
    <tr><td colspan="4" align="center"><input type="submit" name="search" id="search" value="Submit" class="button" /></td></tr>
    <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    </table>
</form></td></tr>
</table></td></tr>
</table></div>
</body>
</html>