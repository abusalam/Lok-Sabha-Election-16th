<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reserve Personnel Replacement</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function per_id_change(str)
{
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  xmlhttp1=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("ofc_id").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
			if(xmlhttp1.responseText.length!=0)
			{
				document.getElementById("op_dtl").innerHTML=xmlhttp1.responseText;
				document.getElementById('search').disabled=false;
			}
		}
	  }
	xmlhttp.open("GET","ajax-reserve-replacement.php?p_id="+str,true);
	xmlhttp1.open("GET","ajax-reserve-replacement.php?p_id="+str+"&p_dtl=y",true);
	xmlhttp.send();
	xmlhttp1.send();
}
function new_per_search()
{
	document.getElementById('replace').disabled=true;
	var forpc=document.getElementById('hid_forpc').innerHTML;
	var forassembly=document.getElementById('hid_forassembly').innerHTML;
	var ofc_id=document.getElementById('ofc_id').innerHTML;
	var booked=document.getElementById('hid_booked').innerHTML;
	var gender=document.getElementById('hid_gender').innerHTML;
	var post_stat=document.getElementById('hid_post_stat').innerHTML;


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
		document.getElementById("new_personnel").innerHTML=xmlhttp.responseText;
		
		if(document.getElementById("new_personnel").innerHTML!='')
			document.getElementById('replace').disabled=false;
		else
			document.getElementById('replace').disabled=true;	
		document.getElementById('print').disabled=true;
		}
	  }
	  
	xmlhttp.open("GET","ajax-reserve-replacement.php?forpc="+forpc+"&forassembly="+forassembly+"&post_stat="+post_stat+"&gender="+gender+"&opn=new_search",true);
	xmlhttp.send();
}
function replacement()
{
	var old_p_id=document.getElementById('hid_per_cd').innerHTML;
	var booked=document.getElementById('hid_booked').innerHTML;
	var new_p_id=document.getElementById('new_per_id').innerHTML;
	var forassembly=document.getElementById('hid_forassembly').innerHTML;
	var forpc=document.getElementById('hid_forpc').innerHTML;
	var groupid=document.getElementById('hid_groupid').innerHTML;
	var dcrccd=document.getElementById('hid_dcrccd').innerHTML;
	var training2_sch=document.getElementById('hid_training2_sch').innerHTML;
	//alert(old_p_id+","+new_p_id+","+assembly+","+groupid);
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
		document.getElementById("o_booked").innerHTML=xmlhttp.responseText;
		document.getElementById('n_booked').innerHTML='Yes';
		document.getElementById('replace').disabled=true;
		document.getElementById('search').disabled=true;
		//document.getElementById('p_id').disabled=true;
		document.getElementById('print').disabled=false;
		}
	  }
	  //alert("ajax-replacement.php?old_p_id="+old_p_id+"&new_p_id="+new_p_id+"&forassembly="+forassembly+"&forpc="+forpc+"&opn=pg_rplc&samevenuetraining="+samevenuetraining);
	xmlhttp.open("GET","ajax-reserve-replacement.php?old_p_id="+old_p_id+"&booked="+booked+"&new_p_id="+new_p_id+"&forassembly="+forassembly+"&forpc="+forpc+"&opn=g_rplc&groupid="+groupid+"&dcrccd="+dcrccd+"&training2_sch="+training2_sch,true);
	xmlhttp.send();
}
function print_appletter()
{
	var new_p_id=document.getElementById('new_per_id').innerHTML;
	var old_p_id=document.getElementById('hid_per_cd').innerHTML;
	var forassembly=document.getElementById('hid_forassembly').innerHTML;
	var forpc=document.getElementById('hid_forpc').innerHTML;
	var groupid=document.getElementById('hid_groupid').innerHTML;
	var usercd=<?php print $user_cd; ?>;
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
		window.open(xmlhttp.responseText);
		}
	  }
alert("ajax-reserve-replacement.php?new_p_id="+new_p_id+"&old_p_id="+old_p_id+"&forassembly="+forassembly+"&forpc="+forpc+"&groupid="+groupid+"&opn=reserve_appletter");
	xmlhttp.open("GET","ajax-reserve-replacement.php?new_p_id="+new_p_id+"&old_p_id="+old_p_id+"&forassembly="+forassembly+"&forpc="+forpc+"&groupid="+groupid+"&opn=reserve_appletter",true);
	xmlhttp.send();
}
</script>
</head>

<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
  </tr>
<tr><td align="center"><?php print $district." DISTRICT"; ?></td></tr>
<tr><td align="center"><?php print $subdiv_name." SUBDIVISION"; ?></td></tr>
<tr><td align="center">PRE GROUPING REPLACEMENT</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" enctype="multipart/form-data">
<table width="95%" class="form" cellpadding="0">
	<tr>
      <td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="3" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="3"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
    	<td width="50%" class="table2 demo-section" valign="top">
        	<table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td align="center" colspan="4"><b>OLD PERSONNEL</b></td>
                </tr>
                <tr><td align="center"><img src='images/blank.gif' alt='' height='5px' /></td></tr>
                <tr>
                	<td align="left"><b>Personnel ID:</b></td>
                    <td align="left"><input type="text" name="per_id" id="per_id" style="width:152px;" onchange="return per_id_change(this.value);" maxlength="9" onkeypress="javascript:return wholenumbersonly(event);" /></td>
                    <td align="left"><b>Office ID:</b></td>
                    <td align="left" width="70px"><span id="ofc_id"></span></td>
                </tr>
                <tr>
                	<td colspan="4"><span id="op_dtl"></span></td>
                </tr>
            </table>
        </td>
    	<td width="50%" class="table2  demo-section1" valign="top"><span id="new_personnel">&nbsp;</span></td>
    </tr>
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="1" /></td></tr>
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="1" /></td></tr>
    <tr>
    	<td align="center" colspan="2">
        	<input id="search" name="search" value="Search" type="button" onclick="return new_per_search();" disabled="true" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="replace" name="replace" value="Replace" type="button" onclick="return replacement();" disabled="true" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="print" name="print" value="Print Appointment Letter" type="button" onclick="return print_appletter();" disabled="true" />
        </td>
    </tr>
    <tr><td><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table>
</form>
</td></tr></table>
</td></tr></table>
</div>
</body>
</html>