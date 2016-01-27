<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gender Wise Personnel Report</title>
<?php
include('header/header.php');
include_once('function/add_fun.php');
?>
</head>
<script>
/*function search_value(str){
		var Subdivision=document.getElementById('Subdivision').value;
		
	    var data= {officename:officename,Subdivision:Subdivision,gender:gender,Statusofoffice:Statusofoffice}; 
		document.getElementById("details").innerHTML="<img src='images/loading1.gif' height='60px'/>";
	    $.ajax({
		type:"post",
		url: "ajax/ajax_genderwise_personnel_report.php",
		cache: false,
		data: data,
		success: function(msg) {
		   $("#details").html(msg);
		}
	});		
}*/
</script>
<body >
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center">
  <table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2">
  <?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">GENDER WISE PERSONNEL REPORT</td></tr>
<tr>
  <td align="center">
  <form method="post" name="form1" id="form1"  action="<?php echo ("ajax/genderwise_excel_report.php");?>">
	<table width="85%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td align="left"></td>
      <td align="left">Subdivision</td>
      <td align="left"><select name="Subdivision" id="Subdivision" style="width:150px;" <?php  if($subdiv_cd != 0) {?> disabled="disabled" <?php } ?> >
      <option value="0">-Select Subdivision-</option>
                            <?php 							  
							        $districtcd=$dist_cd;
									$rsBn=fatch_Subdivision($districtcd);
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowBn=getRows($rsBn);
											echo "<option value='$rowBn[0]'>$rowBn[2]</option>";
										}
									}
									$rsBn=null;
									$num_rows=0;
									$rowBn=null;
									$districtcd=0;
						
							?>
      </select></td>
    <input type="hidden" name="user" value="<?php echo $user_cd; ?>" />
 
      <td align="left"></td>
   
     
    </tr>
  
     
    <tr>
       <td colspan="4" align="center"><img src="images/blank.gif" alt="" height="10px" /></td></tr>
    <tr><td colspan="4" align="center"><input type="submit" name="search" id="search" value="Search" class="button"/>&nbsp;</td></tr>
    <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
   
     <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    </table>
</form>
</td></tr>
</table>
</td></tr>
</table></div>
<div id="calendar" style="width: 243px;display:none;"></div>  
<script>
	<?php	if($subdiv_cd!=0)
	{	?>
		var subdivision=document.getElementById('Subdivision');
		for (var i = 0; i < subdivision.options.length; i++) 
		{
			if (subdivision.options[i].value == "<?php echo $subdiv_cd; ?>")
			{
				subdivision.options[i].selected = true;
			}
		}
 
<?php } 
?>
</script>
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
			calendar.value($("#frmdate").val());
			calendar.value($("#todate").val());
		};

		$("#get").click(function() {
			alert(calendar.value());
		});

		$("#frmdate").kendoDatePicker({
			change: setValue
		});
		$("#todate").kendoDatePicker({
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