<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Office Wise PP List</title>
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
<table width="750px" cellpadding="0" cellspacing="0" border="0">
<thead>
	<tr><th align="center" colspan="5"><?php print $_SESSION['environment']; ?></th></tr>
</thead>
<tr><td align="center">
<?php
include_once('../inc/db_trans.inc.php');
include_once('../function/ofc_fun.php');
extract($_POST);
$subdiv=$_POST['Subdivision'];
$office_cd=$_POST['office'];
$rsOff=office_details_ag_forsub($subdiv);
$num_rows_Off=rowCount($rsOff);
for($i=1;$i<=$num_rows_Off;$i++)
{
	$rowOff=getRows($rsOff);
	$office=$rowOff['officecd'];
	$office_dtl=$rowOff['office'].", ".$rowOff['address1'].", ".$rowOff['address2'].", P.O.-".$rowOff['postoffice'].", Subdiv-".$rowOff['subdivision'].", P.S.-".$rowOff['policestation'].", Dist.-".$rowOff['district'].", PIN-".$rowOff['pin'];
?>
	<table width="750px" cellpadding="0" cellspacing="0" border="0">
    <thead>
    	<tr><th align="center" colspan="4">&nbsp;</th></tr>
        <tr><th colspan="4" align="center"><hr width="100%" /></th></tr>
        <tr><th align="left">OFFICE: <br />(<?php print $office; ?>)</th><th colspan="4" align="left"><?php print $office_dtl; ?></th></tr>
        <tr><th colspan="4" align="center"><hr width="100%" /></th></tr>
        <tr><th width="120px" align="center">PIN</th><th width="270px" align="left">Name</th><th width="210px" align="left">Designation</th><th width="150px" align="left">Posting Status</th></tr>
        <tr><th colspan="5" align="center"><hr width="100%" /></th></tr>
    </thead>
    <tbody>
    	<?php
		$rsPersonnel=office_n_forsub_wise_list($office,$subdiv);
		$num_rows_Personnel=rowCount($rsPersonnel);
		if($num_rows_Personnel>0)
		{
			for($j=1;$j<=$num_rows_Personnel;$j++)
			{
				$rowPersonnel=getRows($rsPersonnel);
				echo "<tr><td align='center'>$rowPersonnel[personcd]</td><td align='left'>$rowPersonnel[officer_name]</td>
				<td align='left'>$rowPersonnel[designation]</td><td align='left'>$rowPersonnel[poststatus]</td></tr>\n";
			}
		}
		else
		{
			echo "<tr><td align='center' colspan='4'>No Officer Found</td></tr>";
		}
		?>
    </tbody>
    <tr><th colspan="4" align="center"><hr width="100%" /></th></tr>
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