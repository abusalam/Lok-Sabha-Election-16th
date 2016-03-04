<?php
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Training Assignment</title>
<?php
include('header/header.php');
?>
<?php

extract($_GET);
$sub="0";
if (isset($_SESSION['subdiv_cd']))
{
	$sub=$_SESSION['subdiv_cd'];
	
}
?>
<script>
/*function area_detail(str)
{

	if (window.XMLHttpRequest)
	  {
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("area_of_preference").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-training.php?area="+str+"&subdivision=<?php print $sub; ?>&opn=areadtl",true);
	xmlhttp.send();
}*/
function validate()
{
	var training_type=document.getElementById("training_type").value;
	if(training_type=="0")
	{
		document.getElementById("msg").innerHTML="Select Training Type";
		document.getElementById("training_type").focus();
		return false;
	}

	
}
</script>

<?php
//include 'mysqliconn.php';
include 'training_assign.php';
include_once('inc/db_trans.inc.php');
include_once('function/training_fun.php');
$action=isset($_REQUEST['submit'])?$_REQUEST['submit']:"";
if($action=='Submit')
{
    $training_type=$_POST['training_type'];
    update_training_pp_schedule($training_type,$sub);
	//echo $training_type;
	//exit;
    new training_assign($training_type,$sub,'O');	
	 new training_assign($training_type,$sub,'T');
	 new training_assign($training_type,$sub,'P');	
	 new training_assign($training_type,$sub,'S');
	 new training_assign($training_type,$sub,'D');	
	 
	$tr_array=training_pp_not_assigned($training_type,$sub);

	if(count($tr_array)>0)
	{
		$Count=0;
		$msg="<b>Training assign not fulfilled</b>";
		$msg.="</br>";
		foreach($tr_array as $key => $value)
		{
		   $Count++;	
			$msg.=$value['ps']." :-- ".$value['cnt']." :: ";
			if($Count%2==0)
			  $msg.="</br>";
		}
	}
	else
 	   $msg="<div class='alert-success'>Training assigned successfully</div>";
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
  <td align="center">TRAINING ASSIGNMENT</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="70%" class="form" cellpadding="0">
	<tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr><td height="30px" colspan="2" align="center"><?php print isset($msg)?$msg:""; ?><span id="msg" class="error"></span></td></tr>
    <tr><td align="center" colspan="2"><img src="images/blank.gif" alt="" height="2px" /></td></tr>
    <tr>
      <td align="left"><span class="error">*</span>Training Type</td>
      <td align="left"><select name="training_type" id="training_type" style="width:220px;">
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
      </select></td></tr>
 
     <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
      <tr><td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Submit" class="button" onclick="javascript:return validate();" /></td></tr>
      <tr><td colspan="2" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table></form>
</td></tr></table>
</td></tr>
</table>

</div>
<div id="fakecontainer" style="display:none;"><div id="loading">Please wait...</div></div> 
</body>
</html>
<script language="javascript" type="text/javascript">
(function (d) {
  d.getElementById('form1').onsubmit = function () {
	  d.getElementById('form1').style.display= 'none';
      d.getElementById('fakecontainer').style.display = 'block';
  };
}(document));
</script>