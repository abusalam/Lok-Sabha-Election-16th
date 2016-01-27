<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Assembly Party List</title>
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
		document.getElementById("pc_result").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-master.php?sub_div="+str+"&opn=assembly",true);
	xmlhttp.send();
}
function search_click(str)
{
	var qstr;
	var subdiv=document.getElementById('Subdivision').value;
	var assembly=document.getElementById('assembly').value;
	var page="<?php echo isset($_GET['p'])?$_GET['p']:""; ?>";
	var all="<?php echo isset($_GET['a'])?$_GET['a']:""; ?>";
     
	 if(str=="search")
		qstr="assemb="+assembly+"&subdiv="+subdiv+"&search="+str;
	 else
		qstr="assemb="+assembly+"&subdiv="+subdiv+"&p="+page+"&a="+all;
   document.getElementById("ap_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
    $.ajax({
		   type:"get",
		   url: "ajax/ajax_assembly_party.php",
		   cache: false,
		   data: qstr,
		   success: function(data1) {
		    $("#ap_result").html(data1);
		  //  $('#watingdiv').hide();
		  }
	});
}
$(document).ready(function(){  $('.overlay').fadeOut();  });
function edit_reserve(str,str1,str2)
{
	location.replace("assembly-party.php?assembly="+str+"&noofparty="+str1+"&poststat="+str2);
}
function delete_ass_party(str2,str,str1)
{
	//var subdiv=document.getElementById('Subdivision').value;
	//var assembly=document.getElementById('assembly').value;
	if (confirm("Do you really want to delete the record?")==true)
	{
		var qstr;
	var page="<?php echo isset($_GET['p'])?$_GET['p']:""; ?>";
	var all="<?php echo isset($_GET['a'])?$_GET['a']:""; ?>";
     

	qstr="sub="+str2+"&ass="+str+"&no="+str1+"&opn=delcode&p="+page+"&a="+all;
   document.getElementById("ap_result").innerHTML="<img src='images/loading1.gif' alt='' height='90px' width='90px' />";
    $.ajax({
		   type:"get",
		   url: "ajax/ajax_assembly_party.php",
		   cache: false,
		   data: qstr,
		   success: function(data1) {
		    $("#ap_result").html(data1);
		  //  $('#watingdiv').hide();
		  }
	});
	}
}
</script>
<link type="text/css" rel="stylesheet" href="css/paging.css" />
</head>
<body oncontextmenu="return false;" onload="return search_click();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">ASSEMBLY PARTY LIST</td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="95%" class="form" cellpadding="0">
    <tr><td colspan="4" align="center"><?php //print $subdiv_name." Subdivision"; ?></td></tr>
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
	  <td align="left"><span class="error">*</span>Subdivision</td>
	  <td align="left"><select name="Subdivision" id="Subdivision" style="width:200px;" onchange="javascript:return subdivision_change(this.value);">
      						<option value="0">-Select Subdivision-</option>
                            <?php 	$districtcd=$dist_cd;
									$rsBn=fatch_Subdivision($districtcd);
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowSubDiv=getRows($rsBn);
											echo "<option value='$rowSubDiv[0]'>$rowSubDiv[2]</option>";
										}
									}
									$rsBn=null;
									$num_rows=0;
									$rowSubDiv=null;
							?>
      				</select></td>
      <td align="left"><span class="error">*</span>Assembly</td>
      <td align="left" id="pc_result"><select name="assembly" id="assembly" style="width:200px;" onchange="return pc_change(this.value);">
     <option value='0'>-Select Assembly-</option>
      <?php
	  if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	  {
			$rsPC=fatch_pc($subdiv_ed);
			$num_rows=rowCount($rsPC);
			if($num_rows>0)
			{
				echo "<option value='0'>-Select PC-</option>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
					$rowPC=getRows($rsPC);
					echo "<option value='$rowPC[0]'>$rowPC[1]</option>\n";
					$rowPC=NULL;
				}
			}
			$num_rows=0;			
			$rsPC=NULL;
	  }
	  ?>
      </select></td>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>
    <tr>
      <td colspan="4" align="center"><input type="button" name="search" id="search" value="Search" class="button" onclick="javascript:return search_click('search');" /></td>
    </tr>
    <tr><td colspan="2" align="left">&nbsp;</td></tr>
    <tr>
      <td align="center" colspan="4" id="ap_result">
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