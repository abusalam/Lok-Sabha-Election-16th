<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Polling Station List</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function search_click(str)
{
	var qstr;
	var assembly=document.getElementById('assembly').value;
	var noofmember=document.getElementById('noofmember').value;
	var page="<?php echo isset($_GET['p'])?$_GET['p']:""; ?>";
	var all="<?php echo isset($_GET['a'])?$_GET['a']:""; ?>";
	
    if(str=="search")
		qstr="assemb="+assembly+"&noofmember="+noofmember+"&search="+str;
	else
		qstr="assemb="+assembly+"&noofmember="+noofmember+"&p="+page+"&a="+all;
   document.getElementById("polling_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
    $.ajax({
		   type:"get",
		   url: "ajax/ajax_polling.php",
		   cache: false,
		   data: qstr,
		   success: function(data1) {
		    $("#polling_result").html(data1);
		  //  $('#watingdiv').hide();
		  }
	});
		
	
}
$(document).ready(function(){  $('.overlay').fadeOut();  });
function edit_PS(str,str1,str2)
{
	location.replace("polling-station.php?code="+str2+"&psno="+str+"&assembly="+str1);
}
function delete_PS(str)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
		window.open("ajax-master.php?pscode="+str+"&act=del","_blank","height=200,width=250,left=400,top=250, status=yes,toolbar=no,menubar=no,location=no,fullscreen=0");
		//location.replace("ajax-master.php?sub_cd="+str+"&act=del");
	}
}
</script>
<link type="text/css" rel="stylesheet" href="css/paging.css" />
</head>
<body oncontextmenu="return false;" onload="return search_click('pload');">
<?php
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$msg="<div class='alert-success'>Record updated successfully</div>";
	}
}
?>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">POLLING STATION LIST</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="90%" class="form" cellpadding="0">
   <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr><td colspan="4" align="center"><?php print isset($msg)?$msg:""; ?></td></tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Assembly</td>
      <td align="left"><input type="text" name="assembly" id="assembly" style="width:120px;" /></td>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>No of Member</td>
      <td align="left"><input type="text" name="noofmember" id="noofmember" style="width:120px;" /></td>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>
    <tr>
      <td colspan="4" align="center"><input type="button" name="search" id="search" value="Search" class="button" onclick="javascript:return search_click('search');" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>»</strong>&nbsp;<a href="polling-station-report.php" class="k-button">Print</a></td>
    </tr>
    <tr><td colspan="2" align="left">&nbsp;</td></tr>
    <tr>
      <td align="center" colspan="4" id="polling_result">
      	<div class="overlay">
  			<img id="loading_spinner" src="images/loading.gif" />
		</div>
      	<!--<table width="100%" cellpadding="0" cellspacing="0" border="0" id="table1">
        <tr><th>Sl.</th>
        	<th>Office ID</th>
            <th>Office Name</th>
            <th>Office Address</th>
            <th>Nature of Office</th>
            <th>Edit</th></tr>
        <tr><td align="center"><img src="images/edit.png" alt="" height="20px" /></td></tr>
        </table>-->
      </td>
    </tr>  
    <tr><td></td><td colspan="3" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
  </table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>