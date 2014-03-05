<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reserve Master Roll Report</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function subdivision_change(str)
{
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
	xmlhttp.open("GET","ajax-master.php?sub_div="+str+"&opn=assembly",true);
	xmlhttp.send();
}
function validate()
{
	var sub_div=document.getElementById("sub_div").value;
	var assembly=document.getElementById("assembly").value;
	if(sub_div=="0" || sub_div=="")
	{
		document.getElementById("msg").innerHTML="Select Subdivision Name";
		document.getElementById("sub_div").focus();
		return false;
	}
	if(assembly=="0" || assembly=="")
	{
		document.getElementById("msg").innerHTML="Select Assembly Name";
		document.getElementById("assembly").focus();
		return false;
	}
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/master_fun.php');
?>

<?php
extract($_POST);
$submit=isset($_POST['submit'])?$_POST['submit']:"";
if($submit=="Submit")
{
	$assembly=encode($_POST['assembly']);

	{
	?>
    <script>
		window.open("reports/master-roll-reserve.php?assembly=<?php echo $assembly; ?>");
	</script>
    <?php
	}
}
?>
<body oncontextmenu="return false;">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>

<tr><td align="center">RESERVE MASTER ROLL REPORT</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="65%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="4" align="center"><?php  print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Subdivision Name</td>
      <td align="left"><select name="sub_div" id="sub_div" style="width:200px;" onchange="return subdivision_change(this.value);">
      							<option value='0'>Select</option>
      					<?php
						$districtcd=$dist_cd;
						$rsSubDiv=fatch_Subdivision($districtcd);
						$num_rows = rowCount($rsSubDiv);
						for($i=1;$i<=$num_rows;$i++)
						{
							$rowSubDiv=getRows($rsSubDiv);
							echo "<option value='$rowSubDiv[subdivisioncd]'>$rowSubDiv[subdivision]</option>";
							unset($rowSubDiv);
						}
						unset($num_rows,$rsSubDiv);
						?>
                       </select></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Assembly</td>
      <td align="left" id="assembly_result"><select name="assembly" id="assembly" style="width:200px;"></select></td>
    </tr>
	<tr>
	  <td align="left" colspan="2">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Submit" class="button" onclick="javascript:return validate();" /></td>
    </tr>   
  </table>
</form>
</td></tr>
<tr><td>&nbsp;</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>