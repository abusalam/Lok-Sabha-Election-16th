<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Venue Wise List - Attendance</title>
<style type="text/css">
body{font-size:11px; font-family:Verdana, Geneva, sans-serif;}
tbody td {height:30px; vertical-align:top;}
tfoot td{ background:#E9E9E9; vertical-align:middle; padding-left: 5px;}
hr { border: 1px solid #ccc;}
@media print
{
label {page-break-after:always}
}
</style>
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td align="center">
<table width="800px" cellpadding="0" cellspacing="0" border="0">
<thead>
	<tr><th align="center"><?php print $_SESSION['environment']; ?></th></tr>
</thead>
<tr><td align="center">
<?php
date_default_timezone_set('Asia/Calcutta');
include_once('../inc/db_trans.inc.php');
include_once('../function/training_fun.php');
extract($_POST);
$training_venue=$_POST['training_venue'];
$training_type=$_POST['training_type'];
$rsTV=venue_name_training_date_and_time($training_venue,$training_type);
$num_rows_TV=rowCount($rsTV);
for($i=1;$i<=$num_rows_TV;$i++)
{
	$rowTV=getRows($rsTV);
	$date=new DateTime($rowTV['training_dt']);
	$venue=$rowTV['venuename'].", ".$rowTV['venueaddress1'].", ".$rowTV['venueaddress2'].", on ".$date->format('d/m/Y')." from ".$rowTV['training_time'];
	$venue_cd=$rowTV['venue_cd'];
	$training_dt=$rowTV['training_dt'];
	$training_time=$rowTV['training_time'];
	
?>
	<table width="800px" cellpadding="0" cellspacing="0" border="0">
    <thead>
    	<tr><th align="center" colspan="6">&nbsp;</th></tr>
        <tr><th colspan="6" align="center"><hr width="100%" /></th></tr>
        <tr><th align="left">VENUE: </th><th colspan="4" align="left"><?php print $venue; ?></th></tr>
        <tr><th colspan="6" align="center"><hr width="100%" /></th></tr>
        <tr><th width="90px" align="center">PIN</th><th width="220px" align="left">Name</th><th width="180px" align="left">Designation</th><th width="120px" align="left">Posting Status</th><th width="140px" align="left">Enrollment Details AC/Part No./Sl No.</th><th width="50px" align="left">Token No</th></tr>
        <tr><th colspan="6" align="center"><hr width="100%" /></th></tr>
    </thead>
    <tbody>
    	<?php
		$rsPersonnel=venue_wise_list($venue_cd,$training_dt,$training_time);
		$num_rows_Personnel=rowCount($rsPersonnel);
		$count=0;
		if($num_rows_Personnel>0)
		{
			for($j=1;$j<=$num_rows_Personnel;$j++)
			{
				$rowPersonnel=getRows($rsPersonnel);
				echo "<tr><td align='center'>++$count</td><td align='center'>$rowPersonnel[personcd]</td><td align='left'>$rowPersonnel[officer_name]</td>
				<td align='left'>$rowPersonnel[designation]</td><td align='left'>$rowPersonnel[poststatus]</td>
				<td align='left'>$rowPersonnel[acno]/$rowPersonnel[partno]/$rowPersonnel[slno]</td>
				<td align='left'>$rowPersonnel[token]</td></tr>\n";
			}
		}
		else
		{
			echo "<tr><td align='center' colspan='6'>No Officer Found</td></tr>";
		}
		?>
    </tbody>
    <tr><th colspan="6" align="center"><hr width="100%" /></th></tr>
    </table>
    <label></label>
<?php
}
?>
</td></tr>
<tfoot>
    <tr><td align="left"><?php print date('l, F dS, Y'); ?></td></tr>
</tfoot>
</table>
</td></tr></table>
</body>
</html>