<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pre Group Cancellation</title>
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
				if(xmlhttp1.responseText!="Not Available for Selected Operation" && xmlhttp1.responseText!=" ")
				{
					document.getElementById('submit').disabled=false;
					$("#venue_sch").show();
					
				}
				else
				{
					document.getElementById('submit').disabled=true;
					$("#venue_sch").hide();
					$("#difnt_sch").hide();
				}
			}
		}
	  }
	xmlhttp.open("GET","ajax-replacement.php?p_id="+str,true);
	xmlhttp1.open("GET","ajax-replacement.php?p_id="+str+"&p_dtl=y",true);
	xmlhttp.send();
	xmlhttp1.send();
}

function validate()
{
	var PersonalID=document.getElementById("per_id").value;
	var post_status=document.getElementById("post_status").value;
	if(PersonalID=="")
	{
		document.getElementById("msg").innerHTML="Enter Personal ID";
		document.getElementById("per_id").focus();
		return false;
	}	
	if(document.getElementById('chkpoststatus').checked==true)
	{
			if(post_status=="")
			{
				document.getElementById("msg").innerHTML="Select Post Status";
				document.getElementById("post_status").focus();
				return false;
			}
	}
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Submit')
{
	$PersonalID=isset($_REQUEST['per_id'])?$_REQUEST['per_id']:"";
	$post_status=isset($_REQUEST['post_status'])?$_REQUEST['post_status']:"";
	$usercd=$user_cd;
	
	include_once('function/add_fun.php');
	//fetch old shedule cd
	$old_s_cd=fetch_training_schedule_code($PersonalID);
	//fetch no _used
	$old_noused=fetch_no_used_training_schedule($old_s_cd);
	//update no_used
	update_training_schedule_PreGroupReplacement($old_noused-1,$old_s_cd);
    
	if($post_status =='')
	{
		$ret=save_pregroup_cancelletion($PersonalID,$usercd);	
		if($ret==1)
		{
			$msg="<div class='alert-success'>Polling Personnel Cancelled Successfully</div>";
		}
	}
	else
	{
		$ret1=save_pregroup_post_status_cancelletion($PersonalID,$post_status,$usercd);	
		if($ret1==1)
		{
			$msg="<div class='alert-success'>Polling Personnel Cancelled and Post Status Changed Successfully</div>";
		}
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
<tr>
  <td align="center">PRE GROUP CANCELLATION</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" enctype="multipart/form-data">
  <table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" align="center" colspan="3"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>
      <td align="center" colspan="3"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr><td width="15%">&nbsp;</td>
      <td align="center" valign="top" class="table2 demo-section" style="height:30em; vertical-align:top">
      		<table cellpadding="0" cellspacing="0" width="80%"  >
            	<tr>
                	<td align="center" colspan="4"><b>OLD PERSONNEL</b></td>
                </tr>
                <tr><td align="center" colspan="4"><img src='images/blank.gif' alt='' height='5px' /></td></tr>
                <tr>
                	<td align="left" width="20%"><b>Personnel ID:</b></td>
                    <td align="left" width="35%"><input type="text" name="per_id" id="per_id" style="width:152px;" onkeyup="return per_id_change(this.value);" onkeypress="javascript:return wholenumbersonly(event);" maxlength="11" /></td>
                    <td align="left" width="20%"><b>Office ID:</b></td>
                    <td align="left" width="25%"><span id="ofc_id"></span></td>
                </tr>
                <tr>
                	<td colspan="4"><span id="op_dtl"></span></td>
                </tr>
            </table>
      </td>
      <td width="15%">&nbsp;</td>
    </tr>
    
    <tr><td colspan="3"><img src="images/blank.gif" alt="" height="1" /></td></tr>
    <tr><td colspan="3" align="left" style="display:none;" id="venue_sch"><input type="checkbox" id="chkpoststatus" name="chkpoststatus" onclick="return chkSameVenueTraining_change();" />
    <label for="chkpoststatus">Change Post Status</label></td></tr>
    <tr><td colspan="3"><img src="images/blank.gif" alt="" height="1" /></td></tr>
    
     <tr style="display:none;" id="difnt_sch" >
          <td align="left" colspan="3"><span class="error">*</span>Post Status&nbsp;&nbsp;&nbsp; <select name="post_status" id="post_status" style="width:220px;">
	    <option value="">-Select Post Status-</option>
         <?php 	$rsP=fatch_postingstatus();
									$num_rows=rowCount($rsP);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowP=getRows($rsP);
											echo "<option value='$rowP[0]'>$rowP[1]</option>\n";
										}
									}
									$rsP=null;
									$num_rows=0;
									$rowP=null;
							?>
	    </select></td>
     
     </tr>
     
    <tr>
      <td align="center" colspan="3"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
      <td align="center" colspan="3"><input type="submit" name="submit" id="submit" value="Submit" class="button" onclick="javascript:return validate();" disabled="true" /></td>
    </tr>
    <tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" width="5px" /></td></tr>
  </table>
</form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
<script>
function chkSameVenueTraining_change()
{
	if(document.getElementById('chkpoststatus').checked==true)
	{
			$("#difnt_sch").show();
	}
	else
	{
		$("#difnt_sch").hide();
		document.getElementById('post_status').value='';
	
	}
}
</script>
</html>