<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Save SMS For Second Training</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function Subdivision_change(str)
{
	//alert(str);
	//window.history.back();
	//document.getElementById("rand_result").innerHTML="";
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
		document.getElementById("phase_type").innerHTML=xmlhttp.responseText;
	//	document.getElementById("load_result").innerHTML="";
		document.getElementById("form1").style="cursor:default";
		}
	  }
	xmlhttp.open("GET","ajax-first-app3.php?Subdivision="+str+"&opn=tr_phase",true);
	document.getElementById("form1").style="cursor:wait";
	xmlhttp.send();
}
/*function member_available()
{
	var Subdivision=document.getElementById("Subdivision").value;
	var phase=document.getElementById("phase").value;
	var chkextrapp=document.getElementById('chkextrapp').checked;
	var str=document.getElementById("post_status").value;
	if (window.XMLHttpRequest)
	  {
	  xmlhttpMA=new XMLHttpRequest();
	  }
	else
	  {
	  xmlhttpMA=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttpMA.onreadystatechange=function()
	  {
	  if (xmlhttpMA.readyState==4 && xmlhttpMA.status==200)
		{
		document.getElementById("member_available").innerHTML=xmlhttpMA.responseText;
		if(str==0)
			document.getElementById("member_available").innerHTML="";
		}
	  }
	xmlhttpMA.open("GET","ajax-first-app31.php?post_stat="+str+"&subdivision="+Subdivision+"&phase="+phase+"&chkextrapp="+chkextrapp+"&opn=membavl",true);
	xmlhttpMA.send();
}*/
function validate()
{
	
	//var from=document.getElementById("from").value;
	//var to=document.getElementById("to").value;
	var Subdivision=document.getElementById("Subdivision").value;
	var party=document.getElementById("party").value;
	var text_msg=document.getElementById("text_msg").value;
	var post_status=document.getElementById("post_status").value;
	var type_details=document.getElementById("type_details").value;
	
	
	if(Subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("Subdivision").focus();
		return false;
	}

	  if(party=="0")
	  {
		  document.getElementById("msg").innerHTML="Select Party / Reserve";
		  document.getElementById("party").focus();
		  return false;
	  }
	if(party=="P")
	{
		if(post_status=="0")
		{
			document.getElementById("msg").innerHTML="Select Post Status for Party";
			document.getElementById("post_status").focus();
			return false;
		}
	}
	/*if($.trim(from)=="")
	{
		document.getElementById("msg").innerHTML="Enter From";
		document.getElementById("from").focus();
		return false;
	}
	if($.trim(to)=="")
	{
		document.getElementById("msg").innerHTML="Enter To";
		document.getElementById("to").focus();
		return false;
	}
	if(from>=to)
	{
		
	}*/
	if($.trim(text_msg)=="")
	{
		document.getElementById("msg").innerHTML="Enter Some Message";
		document.getElementById("text_msg").focus();
		return false;
	}
	
	/*if(type_details=="0")
	{
		document.getElementById("msg").innerHTML="Select Type of Information";
		document.getElementById("type_details").focus();
		return false;
	}*/

}
</script>
</head>
<?php
include_once('function/sms_fun.php');
if(isset($_REQUEST['send']) && $_REQUEST['send']!=null)
	$sub=$_REQUEST['send'];
else
	$sub="";
if($sub=="Save SMS")
{
		$rec=0;
		$Subdivision=isset($_POST['Subdivision'])?$_POST['Subdivision']:"";
		$party=isset($_REQUEST['party'])?$_REQUEST['party']:"";
		$post_status=isset($_REQUEST['post_status'])?$_REQUEST['post_status']:'0';
		$text_msg=isset($_REQUEST['text_msg'])?$_REQUEST['text_msg']:'0';
		$type_details=isset($_REQUEST['type_details'])?$_REQUEST['type_details']:'0';
	    //$poststatus=fatch_post_status_for_first_rand($post_stat);
		delete_2nd_tbl_sms2();
		if($party=='P')
		{
		   $rs_t=fetch_second_appt_member_available($post_status,$Subdivision,$type_details,$text_msg);
		}
		else
		{
			 $rs_t=fetch_second_appt_reserve_member_available($post_status,$Subdivision,$type_details,$text_msg);
		}
		
		if($rs_t>0)
		{
		  $msg="<div class='alert-success'>$rs_t Record(s) saved successfully</div>";
		}
		else
		{
			$msg="<div class='alert-success'>Record(s) not found</div>";
		}
		/*include_once('inc/commit_con.php');
		mysqli_autocommit($link,FALSE);
		$sql="insert into tblsms (name,phone_no,message) values (?,?,?)";
		$stmt = mysqli_prepare($link, $sql);
		mysqli_stmt_bind_param($stmt, 'sss', $name,$mob_no,$Msg);
		//$subdiv_name=Subdivision_ag_subdivcd($subdiv_cd);
        delete_first_tbl_sms();
		$rs_data=first_rand_member_available($post_status,$Subdivision,$phase,$chkextrapp);
		//$rs_data=fetch_first_rand_tab_ag_subdiv($subdiv_name);
		if(rowCount($rs_data)>0)
		{
			for($i=1;$i<=rowCount($rs_data);$i++)
			{
				$row_data=getRows($rs_data);
				$name1=$row_data['officer_name'];
				$mob_no=$row_data['mob_no'];			
				$post_status=$row_data['poststatus'];
				$pscd=$row_data['personcd'];
				$name=$name1." PIN-(".$pscd.")";
				if($type_details=='B')
				{
					$Message = "(".$post_status.") bank :".$row_data['bank']." a/c no: ".$row_data['bank_accno'].", ifsc: ".$row_data['ifsc']."";
				}
				else if($type_details=='T')
				{
					$Message = "(".$post_status.") venue :".$row_data['venuename']." date: ".$row_data['training_dt'].", time: ".$row_data['training_time']."";
				}
				else if($type_details=='V')
				{
					$Message = "(".$post_status.") ac :".$row_data['acno']." part :".$row_data['partno'].", sl :".$row_data['slno']." epic :".$row_data['epic']."";
				}
				else if($type_details=='0')
				{
					$Message = "";
				}
				
				$DestinationAddress = $mob_no;
				//$Message = $name.", you are appointed as ".$post_status." for LS-14 election. Your training venue: ".$venuename.",date: ".$training_dt.", time:".$training_time.".";
				$Msg=$text_msg." ".$Message;
				//include('sms/Index.php');
				
				
				mysqli_stmt_execute($stmt);
				$rec+=mysqli_stmt_affected_rows($stmt);
				
			}
				
		}
		if (!mysqli_commit($link)) {
		print("Transaction commit failed\n");
		exit();
		}
		else
		{
			$msg="<div class='alert-success'>$rec Record(s) saved successfully</div>";
		}
		mysqli_stmt_close($stmt);
		mysqli_close($link);*/
?>		<script><!--window.open('tt.php');</script>		
<!--<script>location.replace("save-sms.php?msg=success");</script> -->            
                <?php
}
?>
<?php
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$msg="<div class='alert-success'>Message sent successfully</div>";
	}
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
  <td align="center">SAVE SMS FOR POLLING PERSONNEL & RESERVE PERSONNEL FOR SECOND TRAINING</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="65%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    
    <tr>    
     <td align="left" width="35%"><span class="error">*</span>For Subdivision </td>
	  <td align="left" width="65%"><select name="Subdivision" id="Subdivision" style="width:220px;">
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
									unset($rsBn,$num_rows,$rowSubDiv);
							?>
      				</select></td>
    </tr>
     <tr>
      <td align="left"><span class="error">*</span>Party / Reserve</td>
      <td align="left"><select name="party" id="party" style="width:220px;">
		<option value="0">-Select Party / Reserve-</option>
        <option value="P">Party</option>
        <option value="R">Reserve</option>
        </select></td>
    </tr> 
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Post Status</td>
      <td align="left"><select name="post_status" id="post_status" style="width:220px;" onchange="javascript:return member_available()">
    							<option value="0">-Select Post Status-</option>
								<?php 	
									$rsP=fatch_postingstatus();
									$num_rows=rowCount($rsP);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowP=getRows($rsP);
											echo "<option value='$rowP[0]'>$rowP[1]</option>\n";
											$rowP=NULL;
										}
									}
									unset($rsP,$num_rows,$rowP);
								?>
                            </select></td></tr> 
    <!--  <tr><td align="left"><span class="error">*</span>PP Range </td>
	 <td align="left"><span class="error">*</span>From : <input type="text" name="from" id="from" style="width:50px;" onkeypress="javascript:return wholenumbersonly(event);" />&nbsp; <span class="error">*</span>To : <input type="text" name="to" id="to" style="width:50px;" onkeypress="javascript:return wholenumbersonly(event);" /></td></tr>-->
    <tr> 
    
     <tr>
      <td align="left"><span class="error">*</span>Message [Max. 100]</td>
      <td align="left"><textarea name="text_msg" id="text_msg" style="max-width:212px;min-width: 212px;min-height: 60px;" maxlength='100'></textarea></td></tr>
   
    <tr>
      <td align="left"><span class="error">&nbsp;&nbsp;</span>Type of Information</td>
      <td align="left"><select name="type_details" id="type_details" style="width:220px;" >
                                <option value="0">-Select Type of Information -</option>
    							<option value="D">DCRC Details</option>
							    <option value="T">Training Details</option>
                                
                            </select></td></tr>
    
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<tr>
	  <td align="center" colspan="2"><input type="submit" name="send" id="send" value="Save SMS" class="button" onclick="javascript:return validate();" /></td></tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table></form>
</td></tr></table>
</td></tr>
</table>
</div>
<div id="fakecontainer" style="display:none;"><div id="loading">Please wait...</div></div> 
</body>
<script language="javascript" type="text/javascript">
(function (d) {
  d.getElementById('form1').onsubmit = function () {
	  d.getElementById('form1').style.display= 'none';
      d.getElementById('fakecontainer').style.display = 'block';
  };
}(document));
</script>
</html>