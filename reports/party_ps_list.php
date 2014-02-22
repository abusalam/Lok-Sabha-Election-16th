<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Party Polling Station List</title>
<style type="text/css">
body{font: 46px Verdana, Geneva, sans-serif;}
.text-large{ font-size: 15px;}
.text-mid{font-weight:bold; font-size:11px;}
.div1{border:1px solid #000; padding:2px; text-align:center;}
.spacer{ line-height: 10px;}
.span{ width:40px; display:inline-block;}
.table, .table td{border: 1px solid #ccc;border-collapse: collapse; vertical-align:top; padding:2px;}
.table1 th,.table1 td{border-bottom: 1px solid #ccc;border-collapse: collapse; vertical-align:top; padding:2px;}
@media print
{
h7 {page-break-after:always;}
}
</style>
</head>
<?php
	include_once('..\inc\db_trans.inc.php');
	include_once('..\function\report_fun.php');
	if(isset($_REQUEST['Subdivision']) && $_REQUEST['Subdivision']!='')
	{
		$sub_div=$_REQUEST['Subdivision'];
	}
	else
	{
		$sub_div=0;
	}
	if(isset($_REQUEST['assembly']) && $_REQUEST['assembly']!='')
	{
		$assembly=$_REQUEST['assembly'];
	}
	else
	{
		$assembly=0;
	}
?>
<body>
<div align="center">
<table width="700px">
<?php
	$rs=get_assembly($sub_div,$assembly);
	if(rowCount($rs)>0)
	{
		for($j=0;$j<rowCount($rs);$j++)
		{
			$row=getRows($rs);
?>
<tr>
	<td align="center" width="50%">
    	<table width="100%" cellpadding="1" cellspacing="1" class="table">       
        <tr><td colspan="2" align="center"><?php print $row['assemblycd']."-".$row['assemblyname']; ?> Assembly</td></tr>
        <tr><td align="center">Party No.</td><td align="center">P.S. No.</td></tr>
        
        	<?php
			$rs_hrd=polling_party_ag_psno_list($row['assemblycd']);
			if(rowCount($rs_hrd)>0)
			{
				for($i=0;$i<rowCount($rs_hrd);$i++)
				{
					$rec_hdr=getRows($rs_hrd);
					$groupid=$rec_hdr['groupid'];
					$psno=$rec_hdr['psno'];
					echo "<tr><td align='center'>$groupid</td><td align='center'>$psno</td></tr>\n";
					$rec_hdr=NULL;
				}
				unset($rs_hrd);
			}
			else
			{
				echo "<tr><td colspan='2' align='center'>No record found</td></tr>";
			}
			?>

        </table>
    </td>
</tr>
<tr><td>&nbsp;</td></tr>
<?php
			$row=NULL;
		}
		unset($rs);
	}
	else
	{
		echo "<tr><td colspan='2' align='center'>No assembly record found</td></tr>";
	}
?>
</table>
</div>
</body>
</html>