<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Unbooked Personnel Details</title>
<style type="text/css">
.border{ border: 1px solid #cccccc; font:15px "Courier New", Courier, monospace; padding: 10px; width: 500px;}
body{ font: 14px "Trebuchet MS", Arial, Helvetica, sans-serif;}
.date{ background:#ddd;}
</style>
</head>
<?php
	date_default_timezone_set('Asia/Calcutta');
	include_once('../inc/db_trans.inc.php');
	//$sub_div=isset($_GET['sub_div'])?$_GET['sub_div']:"";
	$sql_sub="select subdivisioncd, subdivision from subdivision ";
	//if($subdiv!="")
	//$sql_sub.=" and subdivisioncd='$sub_div'";
	$sql_sub.=" order by subdivisioncd";
	$rs_sub=execSelect($sql_sub);
	
?>
<body>
<div align="center"><br /><br /><strong>Subdivision wise No of Unbooked Personnel</strong><br /><br />
<table width='800px' cellpadding="0" cellspacing="0" border="0"><tr><td align="center">
<?php
for($j=0;$j<rowCount($rs_sub);$j++)
{
	$row_sub=getRows($rs_sub);
	$subdivision=$row_sub['subdivision'];
	$sub_div=$row_sub['subdivisioncd'];
	
//	echo $sub_div;
//}
?>
	<table width="70%">
    	<tr><td>Subdivision : <?php echo $subdivision ; ?></td></tr>
    	<tr><td>
<?php
$sql="select count(*) as total, poststat from personnela where subdivisioncd='$sub_div' and (booked='' or booked is null) group by poststat";
	$rs=execSelect($sql);
	if(rowCount($rs)>0)
	{
		echo "<table class=\"border\"><tr><td>\n";
		for($i=0;$i<rowCount($rs);$i++)
		{
			$row=getRows($rs);
			$total=$row['total'];
			$poststat=$row['poststat'];
			echo $poststat.": ".$total.";  \n";
		}
		echo "</td></tr></table>\n";
	}
?>       
        </td></tr>
    </table>
<?php 
}
?>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr class="date"><td align="left"><?php print date('l, F dS, Y'); ?></td></tr></table>
</div>
</body>
</html>