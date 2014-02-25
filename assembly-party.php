<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Assembly Party</title>
<?php
include('header/header.php');
?>
<script type="text/javascript" language="javascript">
function subdivision_change(str)
{
	<?php	if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	{	?>
	document.getElementById("msg").innerHTML="Subdivision can't change while modify";
	load_data();
	return false;
	<?php
	}
	?>
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
	  
	xmlhttp.open("GET","ajaxfun.php?sub-div="+str+"&opn=pc",true);
	xmlhttp.send();
}
function pc_change(str)
{
	var sub_div=document.getElementById('Subdivision').value;
	<?php	if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	{	?>
	document.getElementById("msg").innerHTML="Parliament Constituency can't change while modify";
	load_data();
	return false;
	<?php
	}
	?>
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
	  
	xmlhttp.open("GET","ajaxfun.php?sub_div="+sub_div+"&pc="+str+"&opn=assembly",true);
	xmlhttp.send();
}
function assembly_change()
{
	<?php	if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	{	?>
	document.getElementById("msg").innerHTML="Assembly can't change while modify";
	load_data();
	return false;
	<?php
	}
	?>
}
function post_stat_change()
{
	<?php	if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	{	?>
	document.getElementById("msg").innerHTML="Post status can't change while modify";
	load_data();
	return false;
	<?php
	}
	?>
}
function create_row()
{
	var table=document.getElementById("dynTable");
	var rows = table.getElementsByTagName("tr").length;
	document.getElementById('hidRow').value=(+rows)+1;
	for(var i=0;i<rows;i++)
	{
		if(document.getElementById('posting_status'+i).value=="0")
		{
			document.getElementById("msg").innerHTML="Select Post Status";
			document.getElementById('posting_status'+i).focus();
			return false;
		}
		if(document.getElementById('numb'+i).value=="0" || document.getElementById('numb'+i).value=="")
		{
			document.getElementById("msg").innerHTML="Enter Total Number";
			document.getElementById('numb'+i).focus();
			return false;
		}
	}
    var row=table.insertRow(0);
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
		//document.getElementById("dyn").innerHTML+
		row.innerHTML="\n"+xmlhttp.responseText+"\n";
		}
	  }
	  
	xmlhttp.open("GET","ajaxfun.php?opn=rowcreate&row="+rows,true);
	xmlhttp.send();
}
function delete_row(r)
{
	var table=document.getElementById("dynTable");
	document.getElementById("dynTable").deleteRow(0);
	var rows = table.getElementsByTagName("tr").length;
	document.getElementById('hidRow').value=rows;
//var i = r.parentNode.parentNode.rowIndex;
//document.getElementById("dynTable").deleteRow(i);
}
function validate()
{
	var subdivision=document.getElementById("Subdivision");
	var pc=document.getElementById("pc");
	var assembly=document.getElementById("assembly");
	var member=document.getElementById("member");
	var party_req=document.getElementById("party_req");
	if(subdivision.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision";
		document.getElementById("Subdivision").focus();
		return false;
	}
	//alert(pc.options.length);
	if(pc.value=="" || pc.value=="0")
	{
		document.getElementById("msg").innerHTML="Select Parliament Constituency";
		document.getElementById("pc").focus();
		return false;
	}
	if(assembly.value=="0" || assembly.value=="")
	{
		document.getElementById("msg").innerHTML="Select Assembly";
		document.getElementById("assembly").focus();
		return false;
	}
	if(member.value=="0" || member.value=="")
	{
		document.getElementById("msg").innerHTML="Enter no of member";
		document.getElementById("member").focus();
		return false;
	}
	if(party_req.value=="0" || party_req.value=="")
	{
		document.getElementById("msg").innerHTML="Enter no of party require";
		document.getElementById("party_req").focus();
		return false;
	}
	
	var table=document.getElementById("dynTable");
	var rows = table.getElementsByTagName("tr").length;
	for(var i=0;i<rows;i++)
	{
		if(document.getElementById('posting_status'+i).value=="0")
		{
			document.getElementById("msg").innerHTML="Select Post Status";
			document.getElementById('posting_status'+i).focus();
			return false;
		}
		if(document.getElementById('numb'+i).value=="0" || document.getElementById('numb'+i).value=="")
		{
			document.getElementById("msg").innerHTML="Enter Total Number";
			document.getElementById('numb'+i).focus();
			return false;
		}
	}
	<?php	if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	{	?>
	return true;
	<?php
	} else {
	?>
	if(member.value!=rows)
	{
		document.getElementById("msg").innerHTML="Member details not matching";
		document.getElementById("member").focus();
		return false;
	}
	<?php
	}
	?>
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
$action=$_REQUEST['submit'];
if($action=='Submit')
{
	$subdivision=$_POST['Subdivision'];
	$pc=$_POST['pc'];
	$assembly=$_POST['assembly'];
	$member=$_POST['member'];
	$party_req=$_POST['party_req'];
	$usercd=$user_cd;
	include_once('function/training_fun.php');
	
	if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	{
		$poststat=$_POST['posting_status0'];
		$no_or_pc=$_POST['per_num0'];
		$numb=$_POST['numb0'];
		$res=update_reserve($assembly,$member,$poststat,$no_or_pc,$numb,$usercd);
		if($res==1)
			{
				?> <script>location.replace("assembly-party.php?msg=success");</script> <?php
			}
	}
	else
	{
		$dup_check=duplicate_Assembly_party($assembly,$member);
		if($dup_check==0)
		{
			$ret=save_assembly_party($subdivision,$pc,$assembly,$member,$party_req,$usercd);
			if($ret==1)
			{
				for($i=0;$i<$_POST['hidRow'];$i++)
				{
					$post_stst=$_POST['posting_status'.$i];
					$no_or_pc=$_POST['per_num'.$i];
					$numb=$_POST['numb'.$i];
					$res=save_reserve($assembly,$member,$post_stst,$no_or_pc,$numb,$subdivision,$pc,$usercd);
					if($res==1)
					{
						$msg="<div class='alert-success'>Record saved successfully</div>";
					}
				}
			}
		}
		else
		{
			$msg="<div class='alert-error'>Assembly party already exists</div>";
		}
	}
}
?>
<?php
	include_once('function/training_fun.php');
	$subdiv_cd="0";
	if(isset($_SESSION['subdiv_cd']))
		$subdiv_cd=$_SESSION['subdiv_cd'];

	$rsSelectedPP=fatch_no_of_PP_selected($subdiv_cd);
	$num_rows_SelectedPP=rowCount($rsSelectedPP);
	if($num_rows_SelectedPP>0)
	{
		for($i=0;$i<$num_rows_SelectedPP;$i++)
		{
			$rowSelectedPP=getRows($rsSelectedPP);
			$tr_type[$i]=$rowSelectedPP['training_desc'];
			$post_stat[$i]=$rowSelectedPP['poststatus'];
			$total[$i]=$rowSelectedPP['total'];
			$rowSelectedPP=null;
		}
	}
	$rsSelectedPP=null;
?>
<?php
if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
{
	$assembly=decode($_REQUEST['assembly']);
	$noofparty=decode($_REQUEST['noofparty']);
	$poststat=decode($_REQUEST['poststat']);
	
	$rsAP=fatch_assembly_party_details($assembly,$noofparty,$poststat);
	$rowAP=getRows($rsAP);
	$subdiv_ed=$rowAP['subdivisioncd'];
	$pc_ed=$rowAP['pccd'];
}
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$msg="<div class='alert-success'>Record updated successfully</div>";
	}
}
?>
<script language="javascript" type="text/javascript">
function load_data()
{
	<?php	if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	{	?>
		var subdivision=document.getElementById('Subdivision');
		for (var i = 0; i < subdivision.options.length; i++) 
		{
			if (subdivision.options[i].value == "<?php echo $subdiv_ed; ?>")
			{
				subdivision.options[i].selected = true;
			}
		}

		var pc=document.getElementById('pc');
		pc.value="<?php echo $rowAP['pccd']; ?>";
		var assembly=document.getElementById('assembly');
		assembly.value="<?php echo $rowAP['assemblycd']; ?>";
		
		var member=document.getElementById('member');
		member.value="<?php echo $rowAP['no_of_member']; ?>";
		member.readOnly=true;
		var party_req=document.getElementById('party_req');
		party_req.value="<?php echo $rowAP['no_party']; ?>";
		party_req.readOnly=true;
		var posting_status=document.getElementById('posting_status0');
		posting_status.value="<?php echo $rowAP['poststat']; ?>";
		var per_num=document.getElementById('per_num0');
		per_num.value="<?php echo $rowAP['no_or_pc']; ?>";
		var numb=document.getElementById('numb0');
		numb.value="<?php echo $rowAP['numb']; ?>";
<?php } ?>
	
}
</script>
<body onload="return load_data();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue"><tr><td align="center"><div width="50%" class="h2"><?php print $environment; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr>
  <td align="center">ASSEMBLY PARTY</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="70%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="18px" colspan="2" align="center"><?php print $msg; ?><span id="msg" class="error"></span></td></tr>
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
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
      				</select></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Parliament Constituency</td>
      <td align="left" id="pc_result"><select name="pc" id="pc" style="width:200px;" onchange="return pc_change(this.value);">
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
    <tr>
      <td align="left"><span class="error">*</span>Assembly</td>
      <td align="left" id="assembly_result"><select name="assembly" id="assembly" style="width:200px;" onchange="return assembly_change();">
      <?php
	  if(isset($_REQUEST['assembly']) && isset($_REQUEST['noofparty']) && isset($_REQUEST['poststat']))
	  {
	  	$rsAssembly=fatch_assembly_ag_pc($pc_ed,$subdiv_ed);
		$num_rows=rowCount($rsAssembly);
		if($num_rows>0)
		{
			echo "<option value='0'>-Select Assembly-</option>\n";
			for($i=1;$i<=$num_rows;$i++)
			{
				$rowAssembly=getRows($rsAssembly);
				echo "<option value='$rowAssembly[0]'>$rowAssembly[1]</option>\n";
				$rowAssembly=NULL;
			}
		}
		$num_rows=0;			
		$rsAssembly=NULL;
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>No of Member</td>
      <td align="left"><input type='text' name="member" id="member" maxlength="2" style="width:192px;" onkeypress="javascript:return wholenumbersonly(event);" /></td>
    </tr>
    <tr>
      <td align="left"><span class="error">*</span>Party Required</td>
      <td align="left"><input type='text' name="party_req" id="party_req" maxlength="4" style="width:192px;" onkeypress="javascript:return wholenumbersonly(event);" /></td>
    </tr>
	<tr>
      <td align="center" colspan="2" class="demo-section">
      <table border="0" width="100%"><tr><td align="center" width="45%">Post Status</td><td align="center" width="30%">Number or Percentage</td><td align="center" width="25%">Total Number</td></tr></table>
      <table border="0" width="100%" id="dynTable">
      <tr>
        <td align="center" width="45%"><select name="posting_status0" id="posting_status0" style="width:150px;" onchange="return post_stat_change();">
      						<option value="0">-Select Posting Status-</option>
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
        <td align="center" width="30%"><select name="per_num0" id="per_num0">
        					<option value="N">Number</option>
                            <option value="P">Percentage</option>
                        </select></td>
        <td align="center" width="25%"><input type="text" name="numb0" id="numb0" maxlength="3" onkeypress="javascript:return wholenumbersonly(event);" style="width:30px;" /></td>
      </tr>
      </table>
      <table width="100%"><tr><td align="center">
      <input type="button" name="addbtn" value="Add" onclick="javascript:return create_row();" />&nbsp;&nbsp;&nbsp;&nbsp;
    	<input type="button" name="delbtn" value="Delete" onclick="javascript:return delete_row('');" />
      </td></tr></table>
      </td>
    </tr><input type="hidden" id="hidRow" name="hidRow" value="1" />
    <tr><td colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Submit" class="button" onclick="javascript:return validate();" /></td></tr>
      <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table></form>
</td></tr></table>
</td></tr>
</table>
</div>
</body>
</html>