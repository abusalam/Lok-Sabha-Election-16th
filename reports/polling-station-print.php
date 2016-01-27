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
<title>Polling Station Report</title>
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
	include_once('../function/polling_fun.php');
	$subdivcd=isset($_REQUEST["subdivision"])?$_REQUEST["subdivision"]:"";
$dcrc=isset($_REQUEST["dcrc"])?$_REQUEST["dcrc"]:"";
$assemb=isset($_REQUEST["assembly"])?$_REQUEST["assembly"]:"";
$noofmember=isset($_REQUEST["member"])?$_REQUEST["member"]:"";

?>
<body>
<div align="center">
<table width="800px" cellpadding="0" cellspacing="0" border="0">
	<tr><td align="center">
	<table width="100%">
		<tr><td align="center" colspan="2" class="heading2">POLLING STATION REPORT</td></tr>
		<tr><td align="center" colspan="2" class="heading2"><?php print $_SESSION['environment']; ?></td></tr>
		<tr><td align="center" colspan="2">
		<?php
			$rsPsl=fatch_PollingstationList($dcrc,$assemb,$noofmember,$subdivcd);
			$num_rows = rowCount($rsPsl);
		
			if($num_rows>0)
			{
				echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' class='table'>\n";
				
				for($i=1;$i<=$num_rows;$i++)
				{
				echo "<tr height='30px'><th align='center'>Sl. No.</th><th>Subdivision</th>
            <th>DC Venue</th>
            <th>Assembly</th>
            <th>Member</th></tr>\n";
				  $rowPsl=getRows($rsPsl);
	
				  echo "<tr><td align='center' width='8%'>$i.</td><td width='10%' align='left'>$rowPsl[0]</td><td align='left' width='46%'>$rowPsl[1]</td><td width='28%' align='left'>$rowPsl[2]-$rowPsl[3]</td><td width='10%' align='left'>$rowPsl[4]</td>";
				  echo "</tr>\n";
				  echo "<tr><td align='center' colspan='5'>";
				    $rsPsno=fatch_sd_asm_member($rowPsl['sd_cd'],$rowPsl['asm_cd'],$rowPsl['dcrccd'],$rowPsl['member']);
					$num_rows1 = rowCount($rsPsno);
					if($num_rows1>0)
					{
						echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' class='table'>\n";
						echo "<tr height='30px'><th align='center'>Sl. No</th><th align='center'>PS No</th><th align='left'>PS Name</th></tr>\n";
						for($j=1;$j<=$num_rows1;$j++)
						{
						  $rowPsno=getRows($rsPsno);
	
						  echo "<tr><td width='8%' align='center'>$j.</td><td align='center' width='32%'>$rowPsno[psno]$rowPsno[psfix]</td><td width='60%' align='left'>$rowPsno[psname]</td>";
						 
						  echo "</tr>\n";
						  unset($rowPsno);
						}
						echo "</table>\n";
						
					}
					else
					{
						echo "No records found";
					}
					echo "</td></tr>\n";
					unset($rsPsno,$num_rows1);
				  
				}
				echo "</table>\n";
				
			}
			else
			{
				echo "<div id='table1' style='border: 1px solid;'>No records found</div>";
			}
			unset($rsPsl,$num_rows,$rowPsl);
			?>
		</td></tr>
	</table>
	</td></tr>
</table>
</div>
</body>
</html>
