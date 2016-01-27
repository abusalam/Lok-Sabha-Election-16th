<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Personnel Report</title>
<?php
include('header/header.php');
include_once('function/add_fun.php');
?>
</head>
<script>
function search_value(str){
	    var officename=document.getElementById('officename').value;
		var Subdivision=document.getElementById('Subdivision').value;
		var Statusofoffice=document.getElementById('Statusofoffice').value;
		var posting_status=document.getElementById('posting_status').value;
		var partno=$('#partno:checked').val();
		var sl_no=$('#sl_no:checked').val();
		var epic_no=$('#epic_no').val();
		var mobile=document.getElementById('mobile').value;
		var emailid=document.getElementById('emailid').value;
		var bank=document.getElementById('bank').value;
		var gender=document.getElementById('gender').value;
		var epic=$('#epic:checked').val();

	    var data= {officename:officename,Subdivision:Subdivision,Statusofoffice:Statusofoffice,posting_status:posting_status,partno:partno,sl_no:sl_no,epic_no:epic_no,mobile:mobile,emailid:emailid,bank:bank,gender:gender,epic:epic}; 
		document.getElementById("details").innerHTML="<img src='images/loading1.gif' height='60px'/>";
	    $.ajax({
		type:"post",
		url: "ajax/ajax_personnel1_report.php",
		cache: false,
		data: data,
		success: function(msg) {
		   $("#details").html(msg);
		}
	});		
}
</script>
<body >
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2">
  <?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">POLLING PERSONNEL COUNT</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" action="">
	<table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <tr>
      <td align="left">Office ID</td>
      <td align="left"><input type="text" name="officename" id="officename" style="width:142px;" onkeypress="javascript:return wholenumbersonly(event);" maxlength="10" /></td>
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
    </tr>
    <tr>
       <td align="left">Post Status</td>
      <td align="left"><select name="posting_status" id="posting_status" style="width:150px;">
      						<option value="0">-Select Posting Status-</option>
                            <?php 	$rsP=fatch_postingstatus();
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
      				</select></td>
      <td align="left">Status of Office</td>
      <td align="left"><select name="Statusofoffice" id="Statusofoffice" style="width:150px;">
              <option value="0">-Select Status of Office-</option>
                            <?php 	$rsBn=fatch_statusofoffice('');
									$num_rows=rowCount($rsBn);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowBn=getRows($rsBn);
											echo "<option value='$rowBn[0]'>$rowBn[1]</option>\n";
										}
									}
									$rsBn=null;
									$num_rows=0;
									$rowBn=null;
							?>

      </select></td>
    </tr><input type="hidden" name="user" value="<?php echo $user_cd; ?>" />
  <!--  <tr>
      <td align="left">Gender</td>
      <td><select name="gender" id="gender" style="width:150px;">
          <option value="0">-Select Gender-</option>
           <option value="Male">Male</option>
           <option value="Female">Female</option>
          </select></td>
      <td colspan="2"></td>
    </tr>-->
    <tr>
      <td align="left">Part No</td>
      <td align="left"><input type="checkbox" name="partno" id="partno" style="width:142px;" value="1"/>
      </td>
      <td align="left">Serial No</td>
       <td align="left"><input type="checkbox" name="sl_no" id="sl_no" style="width:142px;" maxlength="5" value="1" /></td>
    </tr> 
    
     <tr>
        <td align="left">EPIC No</td>
       <td align="left"><input type="checkbox" name="epic" id="epic" style="width:142px;" value="1"/>
       </td>
       <td align="left">EPIC No</td>
       <td align="left"><input type="text" name="epic_no" id="epic_no" style="width:142px;" maxlength="50" />
       </td>
      
       <!--<td align="left">Gender</td>
       <td><select name="gender" id="gender" style="width:150px;">
          <option value="0">-Select Gender-</option>
           <option value="Male">Male</option>
           <option value="Female">Female</option>
          </select></td>-->
     </tr> 
      
       <tr>
       <td align="left">Mobile No</td>
       <td align="left"><select name="mobile" id="mobile" style="width:150px;">
          <option value="0">-Select-</option>
           <option value="YES">YES</option>
           <option value="NO">NO</option>
          </select>
       </td>
       <td align="left">Email Id</td>
       <td><select name="emailid" id="emailid" style="width:150px;">
          <option value="0">-Select-</option>
           <option value="YES">YES</option>
           <option value="NO">NO</option>
          </select></td>
     </tr> 
     <tr>
       <td align="left">Bank Details</td>
       <td><select name="bank" id="bank" style="width:150px;">
          <option value="0">-Select-</option>
           <option value="YES">YES</option>
           <option value="NO">NO</option>
          </select></td>
      <td align="left">Gender</td>
      <td><select name="gender" id="gender" style="width:150px;">
          <option value="0">-Select Gender-</option>
           <option value="M">Male</option>
           <option value="F">Female</option>
          </select></td>
     </tr>   
    <tr>
       <td colspan="4" align="center"><img src="images/blank.gif" alt="" height="10px" /></td></tr>
    <tr><td colspan="4" align="center"><input type="button" name="search" id="search" value="Search" class="button" onClick="javascript:return search_value('search');" />&nbsp;</td></tr>
    <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    <tr>
      <td colspan="4" align="center" id="details">
      
      </td>
     </tr>
     <tr><td colspan="4" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
    </table>
</form></td></tr>
</table></td></tr>
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