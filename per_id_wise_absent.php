<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Personnel Id Wise Attendance</title>
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
				}
				else
				{
					document.getElementById('submit').disabled=true;
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
	
	if(PersonalID=="")
	{
		document.getElementById("msg").innerHTML="Enter Personal ID";
		document.getElementById("per_id").focus();
		return false;
	}
	var training_type=document.getElementById("training_type").value;
	if(training_type=="0")
	{
		document.getElementById("msg").innerHTML="Select Training Type";
		document.getElementById("training_type").focus();
		return false;
	}
}
function validate1()
{
	var PersonalID=document.getElementById("per_id").value;
	
	if(PersonalID=="")
	{
		document.getElementById("msg").innerHTML="Enter Personal ID";
		document.getElementById("per_id").focus();
		return false;
	}

}
</script>
</head>
<?php
include_once('inc/db_trans.inc.php');
include_once('function/training_fun.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
$action1=isset($_REQUEST['submit1'])?$_REQUEST['submit1']:"";
if($action1=='Show Cause Letter Print')
{
	$sub="";
	$t_venue="";
	$t_type="";
	$trn_sch="";
	$p_id=isset($_POST['per_id'])?encode($_POST['per_id']):"";
	$memo_no=isset($_POST['memo_no'])?encode($_POST['memo_no']):"";
	$date=isset($_POST['date'])?encode($_POST['date']):"";
	?>
     <script>window.open("fpdf/show_cause_letter.php?sub=<?php echo $sub; ?>&t_venue=<?php echo $t_venue; ?>&t_type=<?php echo $t_type;?>&trn_sch=<?php echo $trn_sch;?>&p_id=<?php echo $p_id;?>&memo_no=<?php echo $memo_no;?>&date=<?php echo $date;?>");</script>
    <?php
}

if($action=='Submit')
{
	$PersonalID=$_POST['per_id'];
	$training_type=$_POST['training_type'];
	$usercd=$user_cd;
	
	include_once('function/add_fun.php');
    $res=update_training_pp_attendance_per_id($PersonalID,'','A');
	/*$ret=save_reserve_pp_cancelletion($PersonalID,$usercd);*/
	
	if($res==1)
	{
		$msg="<div class='alert-success'>Record saved successfully</div>";
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
  <td align="center">PERSONNEL ID WISE TRAINING ATTENDANCE</td></tr>
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
     <tr>
      <td align="center" colspan="3"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
     <tr>
     <td></td>
     <td align="center">
      <table width="100%">
       <tr>
	    <td align="left" width="40%"><span class="error">*</span>Training Type </td>
         <td align="left" >
        <select name="training_type" id="training_type" style="width:200px;">
	    <option value="0">-Select Training Type-</option>
		<?php
			$rsTrainingType=fatch_training_type('');
			$num_rows=rowCount($rsTrainingType);
			if($num_rows>0)
			{
				for($i=1;$i<=$num_rows;$i++)
				{
					$rowTrainingType=getRows($rsTrainingType);
					echo "<option value='$rowTrainingType[0]' >$rowTrainingType[1]</option>\n";
					$rowTrainingType=NULL;
				}
			}
			unset($rsTrainingType,$num_rows,$rowTrainingType);
		?>
	    </select></td>
       </tr>
  
   
         <tr>
      <td align="left">&nbsp;&nbsp;&nbsp;Memo No (For Show Cause Letter)</td>
      <td align="left"><input type="text" name="memo_no" style="width:192px;" /></td>
      
    </tr>
    <tr>
      <td align="left">&nbsp;&nbsp;&nbsp;Date (For Show Cause Letter)</td>
      <td align="left"><input type="text" name="date" id="date" style="width:200px;" /></td>
      
    </tr>
      </table>
      </td>
      <td></td>
     </tr>
     <tr>
      <td align="center" colspan="3"><img src="images/blank.gif" alt="" height="2px" /></td>
    </tr>
    <tr>
      <td align="center" colspan="3"><input type="submit" name="submit" id="submit" value="Submit" class="button" onclick="javascript:return validate();" disabled="true" />&nbsp;&nbsp;<input type="submit" name="submit1" id="submit1" value="Show Cause Letter Print" class="button" onclick="javascript:return validate1();" /></td>
    </tr>
    <tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" width="5px" /></td></tr>
  </table>
</form>
</td></tr></table>
</td></tr>
</table>
<div id="calendar" style="width: 243px;display:none;"></div>  
</div>
</body>
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
			calendar.value($("#date").val());
		};

		$("#get").click(function() {
			alert(calendar.value());
		});

		$("#date").kendoDatePicker({
			change: setValue
		});


		$("#set").click(setValue);

		$("#direction").kendoDropDownList({
			change: navigate
		});

		$("#navigate").click(navigate);
	});
	</script>
</html>