<?php
session_start();
if(isset($_SESSION['dist_cd']))
	$dist_cd=$_SESSION['dist_cd'];
else
	$dist_cd="0";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Branch Report</title>
<style type="text/css">
body{font: 12px Verdana, Geneva, sans-serif;}
.table {border: 1px solid #ccc;	border-collapse: collapse;}
.table2 {border: 1px solid #000; vertical-align:text-top}
.heading1 {font-size:13px; font-weight:bold;}
.heading2 {font-size:14px; font-weight:bold;}
.table td
{
    border-width: 1px;
	padding: 5px;

	border-style: solid;
	border-color: #ccc;}
.table th
{
    border-width: 1px;
	padding: 5px;

	border-style: solid;
	border-color: #ccc;}
</style>
</head>
<?php
date_default_timezone_set('Asia/Calcutta');
	include_once('../inc/db_trans.inc.php');
	include_once('../function/master_fun.php');

?>
<body>
<div align="center">
<table width="800px" cellpadding="0" cellspacing="0" border="0">
	<tr><td align="center">
	<table width="100%">
		<tr><td align="center" colspan="2" class="heading2">BRANCH REPORT</td></tr>
		<tr><td align="center" colspan="2" class="heading2"><?php print $_SESSION['environment']; ?></td></tr>
		<tr><td align="center" colspan="2">
		<?php
			unset($rsBank,$num_rows,$rowBank);
			$rsBank=fatch_bank_master('',$dist_cd);
			$num_rows = rowCount($rsBank);
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' class='table'>\n";
				
				for($i=1;$i<=$num_rows;$i++)
				{
				echo "<tr height='30px'><th align='center'>Sl. No.</th><th align='center'>Bank Code</th><th align='left'>Bank Name</th></tr>\n";
				  $rowBank=getRows($rsBank);
				  $bank_cd=$rowBank['bank_cd'];
				  echo "<tr><td align='center' width='10%'>$i.</td><td align='center' width='20%'>$rowBank[bank_cd]</td><td width='70%' align='left'>$rowBank[bank_name]</td>";
				  echo "</tr>\n";
				  echo "<tr><td align='center' colspan='3'>";
				    $rsBranch=fatch_branch_master_dtl('',$bank_cd);
					$num_rows1 = rowCount($rsBranch);
					if($num_rows1>0)
					{
						echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' class='table'>\n";
						echo "<tr height='30px'><th align='center'>Sl. No</th><th align='center'>Branch Code</th><th align='left'>Branch IFSC</th><th align='left'>Branch Name</th><th align='left'>Branch Address</th></tr>\n";
						for($j=1;$j<=$num_rows1;$j++)
						{
						  $rowBranch=getRows($rsBranch);
	
						  echo "<tr><td width='8%' align='center'>$j.</td><td align='center' width='15%'>$rowBranch[branchcd]</td><td width='17%' align='left'>$rowBranch[ifsc_code]</td>";
						  echo "<td width='30%' align='left'>$rowBranch[branch_name]</td><td width='45%' align='left'>$rowBranch[address]</td>";
						  echo "</tr>\n";
						  unset($rowBranch);
						}
						echo "</table>\n";
					}
					else
					{
						echo "No records found";
					}
					echo "</td></tr>\n";
				  
				}
				echo "</table>\n";
			}
			else
			{
				echo "<div id='table1' style='border: 1px solid;'>No records found</div>";
			}
			unset($rsSubDiv,$num_rows,$rowSubDiv);
			?>
		</td></tr>
	</table>
	</td></tr>
</table>
</div>
</body>
</html>
