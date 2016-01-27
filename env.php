
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Environment Master</title>
<div align="center" ><table cellpadding="0" cellspacing="0" style="background-image:url(images/bbg.gif); background-repeat:repeat-y; background-size:100% 150px;" width="100%"><tr><!--<td><img src="/election/images/sj.png" alt="" height="100px" /></td>--><td colspan="2" align="center"><img src="images/pge.png" alt="" height="150px" /></td></tr></table></div>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<link href="css/cal/css/examples-offline.css" rel="stylesheet">
<link href="css/cal/css/kendo.common.min.css" rel="stylesheet">
<link href="css/cal/css/kendo.default.min.css" rel="stylesheet">
<script src="css/cal/js/jquery.min.js"></script>
<script src="css/cal/js/kendo.web.min.js"></script>

<script type="text/javascript" language="javascript">


function edit_police(ps_code)
{
	location.replace("police_station_master.php?ps_cd="+ps_code);
	
}
function delete_police(str)
{
	if (confirm("Do you really want to delete the record?")==true)
	{
		window.open("ajax-master.php?ps_cd="+str+"&act=del","_blank","height=200,width=250,left=400,top=250, status=yes,toolbar=no,menubar=no,location=no,fullscreen=no");
		//location.replace("ajax-master.php?sub_cd="+str+"&act=del");
	}
}
function validate()
{
	var district=document.getElementById("district").value;
  //  var envname=document.getElementById("envname").value;
	var apt1_orderno=document.getElementById("apt1_orderno").value;
	var apt2_orderno=document.getElementById("apt2_orderno").value;
	var apt1_date=document.getElementById("apt1_date").value;
	var apt2_date=document.getElementById("apt2_date").value;
	if(district=="0")
	{
		document.getElementById("msg").innerHTML="Select District";
		document.getElementById("district").focus();
		return false;
	}
	/*if($.trim(envname)=="")
	{
		document.getElementById("msg").innerHTML="Enter Environment";
		document.getElementById("envname").focus();
		return false;
	}*/
	if($.trim(apt1_orderno)=="")
	{
		document.getElementById("msg").innerHTML="Enter App. Letter 1 order no";
		document.getElementById("apt1_orderno").focus();
		return false;
	}
	if($.trim(apt1_date)=="")
	{
		document.getElementById("msg").innerHTML="Enter App. Letter 1 date";
		document.getElementById("apt1_date").focus();
		return false;
	}

	if($.trim(apt2_orderno)=="")
	{
		document.getElementById("msg").innerHTML="Enter App. Letter 2 order no";
		document.getElementById("apt2_orderno").focus();
		return false;
	}
	if($.trim(apt2_date)=="")
	{
		document.getElementById("msg").innerHTML="Enter App. Letter 2 date";
		document.getElementById("apt2_date").focus();
		return false;
	}
}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/env_fun.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Save')
{
	$district_cd=$_POST['district'];
	$dist_name=mysql_real_escape_string($_POST['district']);
	$distnm_sml=ucwords(strtolower($dist_name));
	$distnm_cap=strtoupper($dist_name);
	$envname="West Bengal Assembly Election , 2016";
	$apt1_orderno=clean_spl($_POST['apt1_orderno']);
	$apt1_date=clean_spl($_POST['apt1_date']);
	$apt2_orderno=clean_spl($_POST['apt2_orderno']);
	$apt2_date=clean_spl($_POST['apt2_date']);
	//$ps_code=($_POST['hid_ps_code']);
	$c_env=duplicate_env($env_code,$district_cd);
	//$c_env=0;
	if($c_env==0)
	{
		if(isset($_REQUEST['env_cd']))
		{
			$ps_code=decode($_REQUEST['ps_cd']);
			$dt = new DateTime();
			$posted_date=$dt->format('Y-m-d H:i:s');
			$ret=update_police($ps_code,$psname,$dist_cd,$subdivisioncd,$usercd,$posted_date);
			if($ret==1)
			{
				redirect("police_station_master.php?msg=success");
			}
		}
		else
		{
			update_adminstrator($district_cd);
			$ret=save_env($district_cd,$distnm_sml,$distnm_cap,$envname,$apt1_orderno,$apt1_date,$apt2_orderno,$apt2_date);
		}
		if($ret==1)
		{
			$msg="<div class='alert-success'>Record saved successfully</div>";
		}
	}
	else
	{
		$msg="<div class='alert-error'>Environment already set</div>";
	}
	unset($ret,$district_cd,$dist_name,$distnm_sml,$distnm_cap,$envname,$c_env);
}
?>

<?php
/*if(isset($_REQUEST['ps_cd']))
{
	$ps_code=decode($_REQUEST['ps_cd']);
	//$sub_code=decode($_REQUEST['sub_code']);
	$rsPerDiv=fatch_police_station_master($ps_code);
	$rowPerDiv=getRows($rsPerDiv);
	$subdiv_cd=$rowPerDiv['subdivisioncd'];
}
if(isset($_REQUEST['msg']))
{
	if($_REQUEST['msg']=='success')
	{
		$msg="<div class='alert-success'>Record updated successfully</div>";
	}
}*/
?>
<script language="javascript" type="text/javascript">
function bind_all()
{
	<?php if(isset($rowPerDiv)) { ?>
	var subdivision = document.getElementById('Subdivision');
	subdivision.value = "<?php echo $rowPerDiv['subdivisioncd']; ?>";
	var psname=document.getElementById('psname');
	psname.value="<?php echo $rowPerDiv['policestation']; ?>";
	var ps_code=document.getElementById('hid_ps_code');
	ps_code.value="<?php echo $rowPerDiv['policestationcd']; ?>";
	<?php } ?>
}
</script>
<body oncontextmenu="return false;" onload="javascript: return bind_all();">
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2">Environment Master</div></td>
</tr>
<tr><td align="center"></td></tr>
<tr><td align="center"></td></tr>
<tr><td align="center" valign="top"><form method="post" name="form1" id="form1">
  <table width="60%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="2"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td height="16px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td>
    </tr>
    <tr>

      <td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    
    
    <tr>
     <td align="left"><span class="error">*</span>District</td>
	  <td align="left"><select name="district" id="district" style="width:258px;">
      						<option value="0">-Select District-</option>
                            <?php 	$districtcd=$dist_cd;
									$rsBn=fatch_district_master('');
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowDist=getRows($rsBn);
											echo "<option value='$rowDist[0]'>$rowDist[1]</option>";
										}
									}
									unset($rsBn,$num_rows,$rowDist);
							?>
      				</select></td></tr>
    <!--<tr>
      <td align="left"><span class="error">*</span>Environment</td>
      <td align="left"><input type="text" name="envname" id="envname" style="width:250px;" /></td>
    </tr>-->
    
     <tr>
      <td align="left"><span class="error">*</span>App. Letter 1 order no</td>
      <td align="left"><input type="text" name="apt1_orderno" id="apt1_orderno" style="width:250px;" /></td>
    </tr>
      
    <tr>
      <td align="left"><span class="error">*</span>App. Letter 1 date</td>
      <td align="left"><input type="text" name="apt1_date" id="apt1_date" style="width:258px;" /></td>
    </tr> 
    <tr>
      <td align="left"><span class="error">*</span>App. Letter 2 order no</td>
      <td align="left"><input type="text" name="apt2_orderno" id="apt2_orderno" style="width:250px;" /></td>
    </tr> 
    <tr>
      <td align="left"><span class="error">*</span>App. Letter 2 date</td>
      <td align="left"><input type="text" name="apt2_date" id="apt2_date" style="width:258px;" /></td>
    </tr>              
   <input type="hidden" id="hid_ps_code" name="hid_ps_code" />
    
	<tr>
	  <td align="left" colspan="2">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Save" class="button" onclick="javascript:return validate();" /></td>
    </tr>
    <tr><td colspan="2" align="left"><div id="form1_errorloc" class="error"></div></td></tr>
    <tr><td colspan="2" align="center"><div class="scroller1">
            <?php
			//include_once('function\training_fun.php');
			/*$rsAssDiv=fatch_ps_masterlist($dist_cd);
			$num_rows = rowCount($rsAssDiv);
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
				echo "<tr height='30px'><th>Sl. No.</th><th align='center'>Police Station Code</th><th align='left'>Subdivision</th><th align='left'>Police Station Name</th><th>Edit</th><th>Delete</th></tr>\n";
				for($i=1;$i<=$num_rows;$i++)
				{
				  $rowAssDiv=getRows($rsAssDiv);
				  $ps_code='"'.encode($rowAssDiv['0']).'"';
				  //$sub_code='"'.encode($rowAssDiv['subdivisioncd']).'"';
				  echo "<tr><td align='right' width='10%'>$i.</td><td align='center' width='20%'>$rowAssDiv[0]</td><td width='35%' align='left'>$rowAssDiv[1]</td>";
				  echo "<td width='35%' align='left'>$rowAssDiv[2]</td>";
				  echo "<td align='center' width='10%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_police($ps_code);' /></td>\n";
				  echo "<td align='center' width='10%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_police($ps_code);' /></td></tr>\n";
				}
				echo "</table>\n";
			}
			else
			{
				echo "<div id='table1' style='border: 1px solid;'>No records found</div>";
			}
			unset($rsAssDiv,$num_rows,$rowAssDiv);*/
			?></div>
    </td></tr>
  </table>
</form>
</td></tr>
<tr><td>&nbsp;</td></tr></table>
</td></tr>
</table>
</div>
<div id="calendar" style="width: 243px;display:none;"></div>  
<script>
	$(document).ready(function() {
		$("#calendar").kendoCalendar();

		var calendar = $("#calendar").data("kendoCalendar");
		calendar.value(new Date());

		var navigate = function () {
			var value = $("#direction").val();
			switch(value) {
				case "up":
					calendar.navigateUp();
					break;
				case "down":
					calendar.navigateDown(calendar.value());
					break;
				case "past":
					calendar.navigateToPast();
					break;
				default:
					calendar.navigateToFuture();
					break;
			}
		},
		setValue = function () {
			calendar.value($("#apt1_date").val());
			calendar.value($("#apt2_date").val());
		};

		$("#get").click(function() {
			alert(calendar.value());
		});

		$("#apt1_date").kendoDatePicker({
			change: setValue
		});
        $("#apt2_date").kendoDatePicker({
			change: setValue
		});

		$("#set").click(setValue);

		$("#direction").kendoDropDownList({
			change: navigate
		});

		$("#navigate").click(navigate);
	});
</script>
</body>
</html>