<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Polling Station Report</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function subdivision_change(str)
{
	<?php if(isset($_GET['psno']) && isset($_GET['assembly']))
	{ ?>
		document.getElementById("msg").innerHTML="Subdivision can't be changed while modifying";
		bind_all();
		return false;
	<?php
	} ?>
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
		document.getElementById("dcrc_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-master.php?sub_div="+str+"&opn=fetchdcrc",true);
	xmlhttp.send();
}
function assembly_change(str)
{
	<?php if(isset($_GET['psno']) && isset($_GET['assembly']))
	{ ?>
		document.getElementById("msg").innerHTML="Assembly can't be changed while modifying";
		bind_all();
		return false;
	<?php
	} ?>
	var sub_div=document.getElementById('subdivision').value;
	var dcrc=document.getElementById('dcrc').value;
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
		document.getElementById("member_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-master.php?assembly="+str+"&sub_div="+sub_div+"&dcrc="+dcrc+"&opn=dcrcmember",true);
	xmlhttp.send();
}
function dcrc_change(str)
{
	<?php if(isset($_GET['psno']) && isset($_GET['assembly']))
	{ ?>
		document.getElementById("msg").innerHTML="DCRC can't be changed while modifying";
		bind_all();
		return false;
	<?php
	} ?>
	var sub_div=document.getElementById('subdivision').value;
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
		//alert(xmlhttp.responseText);
		}
	  }
	xmlhttp.open("GET","ajax-master.php?dcrc1="+str+"&sub_div1="+sub_div+"&opn=dcrcassembly",true);
	xmlhttp.send();
	

}

</script>
</head>


<?php
include_once('inc/db_trans.inc.php');
include_once('function/master_fun.php');


?>

<body oncontextmenu="return false;">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>

<tr><td align="center">POLLING STATION REPORT</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1" action="reports/polling-station-print.php" target="_blank">
  <table width="65%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="4" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span><span id="tmsg" ></span></td>
    </tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    
     <tr>
      <td align="left"><span class="error">&nbsp;</span>Subdivision Name</td>
      <td align="left"><select name="subdivision" id="subdivision" style="width:200px;" onchange="return subdivision_change(this.value);">
      					<option value='0'>-Select Subdivision-</option>
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
      <td align="left"><span class="error">&nbsp;</span>DCRC</td>
      <td align="left" id="dcrc_result"><select name="dcrc" id="dcrc" style="width:200px;" onchange="return dcrc_change(this.value);">
      <option value='0'>-Select DCRC-</option>
      <?php
	  if(isset($_GET['psno']) && isset($_GET['assembly']))
	  {   						
			$rsDCRC=fatch_dcrcname($sub_div);
			$num_rows=rowCount($rsDCRC);
			if($num_rows>0)
			{
				for($i=1;$i<=$num_rows;$i++)
				{
					$rowDCRC=getRows($rsDCRC);
					echo "<option value='$rowDCRC[dcrcgrp]'>$rowDCRC[dc_venue]</option>\n";
					unset($rowDCRC);
				}
			}
			unset($rsDCRC,$num_rows);
	  }
	  ?>
      </select></td>
    </tr>
    
    <tr>
      <td align="left"><span class="error">&nbsp;</span>Assembly</td>
      <td align="left" id="assembly_result"><select name="assembly" id="assembly" style="width:200px;" onchange="return assembly_change(this.value);">
      <option value='0'>-Select Assembly-</option>
      <?php
	  if(isset($_GET['psno']) && isset($_GET['assembly']))
	  {
		  	include_once('function/add_fun.php'); 						
			$rsAss=fatch_dcrc_member_assembly($sub_div,$dcrccd,'');
			$num_rows=rowCount($rsAss);
			if($num_rows>0)
			{
				for($i=1;$i<=$num_rows;$i++)
				{
					$rowAss=getRows($rsAss);
					echo "<option value='$rowAss[assemblycd]'>$rowAss[assemblyname]</option>\n";
					unset($rowAss);
				}
			}
			unset($rsAss,$num_rows);
	  }
	  ?>
      </select></td>
    </tr>
    
    <tr>
      <td align="left"><span class="error">&nbsp;</span>Member No</td>
      <td align="left" id="member_result"><select name="member" id="member" style="width:200px;">
            <option value='0'>-Select no of member-</option>
       <?php
	  if(isset($_GET['psno']) && isset($_GET['assembly']))
	  {
		  	include_once('function/add_fun.php'); 						
			$rsAss1=fatch_dcrc_member_assembly($sub_div,$dcrccd,$ass_cd);
			$num_rows1=rowCount($rsAss1);
			if($num_rows1>0)
			{
				for($i=1;$i<=$num_rows1;$i++)
				{
					$rowAss=getRows($rsAss1);
					echo "<option value='$rowAss[no_of_member]'>$rowAss[no_of_member]</option>\n";
					unset($rowAss);
				}
			}
			unset($rsAss1,$num_rows1);
	  }
	  ?>
      </select>
                                  
      </td>
    </tr>
    
	<tr>
	  <td align="left" colspan="2">&nbsp;</td></tr>

    <tr>
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Search" class="button"/></td>
    </tr>

    <tr><td colspan="2" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
    <tr><td colspan="2" align="center">
            <?php
			//include_once('function\training_fun.php');
		/*	$rsPS=fetch_polling_station('','',$dist_cd);
			$num_rows = rowCount($rsPS);
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
				echo "<tr height='30px'><th align='center'>Sl. No</th><th align='center'>PS No</th><th align='left'>Assembly</th><th align='left'>PS Name</th><th>Edit</th><th>Delete</th></tr>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowPS=getRows($rsPS);
				  $psno='"'.encode($rowPS['psno']).'"';
				  $ass='"'.encode($rowPS['forassembly']).'"';
				  echo "<tr><td width='5%' align='right'>$i.</td><td align='center' width='20%'>$rowPS[psno]</td><td width='30%' align='left'>$rowPS[assemblyname]</td>";
				  echo "<td width='30%' align='left'>$rowPS[psname]</td>";
				  echo "<td align='center' width='10%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_PS($psno,$ass);' /></td>\n";
				  echo "<td align='center' width='10%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_PS($psno,$ass);' /></td></tr>\n";
				}
				echo "</table>\n";
			}
			else
			{
				echo "<div id='table1' style='border: 1px solid;'>No records found</div>";
			}
			unset($rsPS,$num_rows,$rowPS);*/
			?>
    </td></tr>
  </table>
</form>
</td></tr>
<tr><td>&nbsp;</td></tr></table>
</td></tr>
</table>
</div>
</body>

</html>