<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Scroll(PP)</title>
<style type="text/css">
body{font: 12px Verdana, Geneva, sans-serif;}
.table {border: 1px solid #ccc;}
.table2 {border: 1px solid #000; vertical-align:text-top}
.heading1 {font-size:13px; font-weight:bold;}
.heading2 {font-size:14px; font-weight:bold;}
</style>
</head>
<?php
date_default_timezone_set('Asia/Calcutta');
	include_once('../inc/db_trans.inc.php');
	include_once('../function/appointment_fun.php');
	
	extract($_GET);
	$group_id='';
	if(isset($_GET['assembly']) && $_GET['assembly']!=null)
		$forassembly=decode($_GET['assembly']);
	else
		exit;
	$forpc='';
//$forpc='41';	

	$rsAssembly=assembly_name_ag_code($forassembly);
	$rowAssembly=getRows($rsAssembly);
	$rec_set_hdr=second_app_hrd($forassembly,$forpc,$group_id);
?>
<body>
<div align="center">
<table width="750px" cellpadding="0" cellspacing="0" border="0">
	<tr><td align="center">
	<table width="100%">
		<tr><td align="center" colspan="2" class="heading2">SCROLL (POLLING PERSONNEL)</td></tr>
		<tr><td align="center" colspan="2" class="heading2"><?php print $_SESSION['environment']; ?></td></tr>
		<tr><td align="left" width="150px" class="heading1">ASSEMBLY :</td><td class="heading1"><?php print $rowAssembly['assemblycd']." - ".$rowAssembly['assemblyname']; ?></td></tr>
		<tr><td align="center" colspan="2">
		<table width="100%">
<?php	if(rowCount($rec_set_hdr)>0)
		{
			for($n=0;$n<rowCount($rec_set_hdr);$n++)
			{
				$rec_arr_hdr=getRows($rec_set_hdr);
				$grp_id=$rec_arr_hdr['groupid'];
				
				$rec_set=second_appointment_letter($grp_id,$rec_arr_hdr['assemblycd']);
				$num_rows=rowCount($rec_set);
				if($num_rows>0)
				{
?>
			<tr><td width="10%" class="table2">Polling Party : <?php print $grp_id; ?></td>
				<td align="left" class="table2">
				<table width="100%">
<?php
					for($i=0;$i<$num_rows;$i++)
					{
						$rec_arr=getRows($rec_set);
?>

					<tr><td class="table" width="5%">&nbsp;<?php print $rec_arr['poststat']; ?></td>
						<td class="table" width="95%">&nbsp;<?php print $rec_arr['officer_name'].", ".$rec_arr['off_desg'].", (".$rec_arr['personcd'].") <br />
						&nbsp;".$rec_arr['office'].", ".$rec_arr['address1'].", ".$rec_arr['address2'].", P.O.-".$rec_arr['postoffice'].", Subdiv.-".$rec_arr['subdivision'].", Dist.-".$rec_arr['district'].", PIN-".$rec_arr['pin']." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(".$rec_arr['officecd'].")"; ?>
						</td>
					</tr>
<?php						
					}
?>
					
				</table>
				</td>
			</tr>
<?php			}
			}
		}
?>
			
		</table>
		</td></tr>
	</table>
	</td></tr>
</table>
</div>
</body>
</html>
