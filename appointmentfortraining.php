<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Personal List for LS14</title>
<?php
include('header/header.php');
?>

<script type="text/javascript" language="javascript">

function personnel_ls14_list(str)
{
	var qstr;
	var subdiv=document.getElementById('subdivision').value;
	var officeid=document.getElementById('officeID').value;
	var page="<?php echo $_GET['p']; ?>";
	var all="<?php echo $_GET['a']; ?>";
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
			document.getElementById("personnel_ls14_result").innerHTML=xmlhttp.responseText;
		}
	  }

	if(str=="search")
    qstr="ajax-appointmentfortraning.php?subdiv="+subdiv+"&officeid="+officeid;
	else
    qstr="ajax-appointmentfortraning.php?subdiv="+subdiv+"&officeid="+officeid+"&p="+page+"&a="+all;
	xmlhttp.open("GET",qstr,true);
	xmlhttp.send();
}

//=================================================

 function selectAllFiles(c) {
            for (i = 1; i <= 5; i++)
			{
                document.getElementById('checkbox' + i).checked = c;
            }
        }
//==========================================================

</script>
<?php

// Check if print button active, start this
if($print){
	$subdiv=$_POST['subdivision'];
	$officeid=$_POST['officeID'];
	$usercode=$_SESSION['user_cd'];
	$rs=fatch_Personnel_ls14Listeee($subdiv,$officeid,$usercode);
	$count = rowCount($rs);
      for($i=0;$i<$count;$i++)
	  {
         $p_cd = $checkbox[$i];
		 
		 
		$result = mysql_query($sql);
}

// if successful redirect to delete_multiple.php
if($result){
echo "<meta http-equiv=\"refresh\" content=\"0;URL=delete_multiple.php\">";
}
}
?>
<link type="text/css" rel="stylesheet" href="css/paging.css"/>
</head>
<body oncontextmenu="return false;" onload="javascript:return personnel_ls14_list('pload');">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment;?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">APPOINTMENT LETTER FOR TRAINING</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="95%" class="form" cellpadding="0">
    
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr><td align="left" valign="top"><span class="error">*</span>Sub Division</td>
      <td align="left" valign="top"><select name="subdivision" id="subdivision" style="width:200px;">
    							<option value="0">-Select Subdivision-</option>
								<?php 	$rsSubDiv=fatch_Subdivision();
										$num_rows=rowCount($rsSubDiv);
										if($num_rows>0)
										{
											for($i=1;$i<=$num_rows;$i++)
											{
												$rowSubDiv=getRows($rsSubDiv);
												echo "<option value='$rowSubDiv[0]'>$rowSubDiv[2]</option>\n";
											}
										}
										$rsSubDiv=null;
										$num_rows=0;
										$rowSubDiv=null;
								?>
                            </select></td> <td align="left"><span class="error">&nbsp;&nbsp;</span>Office ID</td>
      <td align="left"><input type="text" name="officeID" id="officeID" style="width:250px;" /></td> </tr>
   
    <tr>
      <td colspan="4" align="center"><input type="button" name="search" id="search" value="Search" class="button" onclick="javascript:return personnel_ls14_list('search');" /><input name="print" type="print" id="print" value="print"> <input id="chkAllFiles" type="checkbox" title="All Files" onchange="selectAllFiles(this.checked);" /></td>
    </tr>
    <tr><td colspan="2" align="left">&nbsp;</td></tr>
    <tr>
      <td align="center" colspan="4" id="personnel_ls14_result">
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