<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Termination Report</title>
<?php
include('header/header.php');
include_once('function/add_fun.php');
?>
</head>
<script>
function search_value(str){
	
	    var Subdivision=document.getElementById('Subdivision').value;
		//alert(Subdivision);
		//var Subdivision=document.getElementById('Subdivision').value;
		//var Statusofoffice=document.getElementById('Statusofoffice').value;
	    var data= {Subdivision:Subdivision}; 
		document.getElementById("details").innerHTML="<img src='images/loading1.gif' height='60px'/>";
	    $.ajax({
		type:"post",
		url: "ajax/ajax_termination_report.php",
		cache: false,
		data: data,
		success: function(msg) {
		   $("#details").html(msg);
		}
	});		
}
</script>
<body oncontextmenu="return false;">

<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
  <td align="center"><table width="1000px" class="table_blue">
  <tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td>
</tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center">TERMINATION REPORT</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1" action="" >
	<table width="95%" class="form" cellpadding="0">
    <tr>
      <td align="center" colspan="4"><img src="images/blank.gif" alt="" height="1px" /></td>
    </tr>
    <!--<tr>
      <td align="left">User ID</td>
      <td align="left"><select name="user" id="user"></select></td><td colspan="2">&nbsp;</td>
    </tr>-->
    
    <tr>
     <td align="left" style="padding-left:30px;">Subdivision</td>
      <td align="left" style="padding-left:30px;"><select name="Subdivision" id="Subdivision" style="width:150px;" <?php  if($subdiv_cd != 0) {?>disabled="disabled" <?php }  ?>  > 
      
      <option value="">------All Subdivision------------</option> 
     
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

</body>
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
</html>