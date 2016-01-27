<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Office Category against Post Status Report</title>
<style type="text/css">
body{font: 12px Verdana, Geneva, sans-serif;}
.div1{border:1px solid #000; padding:2px; text-align:center;}
.spacer{ line-height: 10px;}
.span{ width:40px; display:inline-block;}
.table{border: 1px solid #ccc; vertical-align:top; padding:2px;}
.table1, .table1 td{border: 1px solid #ccc; border-collapse:collapse; vertical-align:top; padding:1px;}
@media print
{
h7 {page-break-after:always;}
}
</style>
</head>
<body>
<?php
if(isset($_REQUEST['district']))
{
	$dist_cd=$_REQUEST['district'];
	if(isset($_REQUEST['Subdivision']))
		$subdiv_cd=$_REQUEST['Subdivision'];
}
date_default_timezone_set('Asia/Calcutta');
include("../inc/db_trans.inc.php");
?>
<table width="100%">
<tr>
	<td align="center">
		<table width='750px' cellpadding='0' cellspacing='0' border='0'>
        <thead>
        	<tr>
            	<th align='center' colspan='2'>Office Category Wise Report</th>
            </tr>
            <tr>
            	<th align='center' colspan='2'>&nbsp;</th>
            </tr>
        </thead>
        <?php
		include_once('../function/master_fun.php');
		$rsDist=fatch_district_master($dist_cd);
		$num_rows=rowCount($rsDist);
		$rowDist=getRows($rsDist);
		$dist=$rowDist['districtcd'];
		?>
        	<tr>
            	<th align='left' width='30%'>District</th><th align='left'><?php echo $rowDist['district']; ?></th>
            </tr>
            <tr><td colspan='2' align='center'>
            <table width='100%' class='table'>
            <?php			
			$rsSubdiv=fatch_subdivision_master($subdiv_cd,$dist);
			$num_rowsSubdiv=rowCount($rsSubdiv);
			if($num_rowsSubdiv>0)
			{
				for($k=1;$k<=$num_rowsSubdiv;$k++)
				{
					$rowSubDiv=getRows($rsSubdiv);
					$sub_div=$rowSubDiv['subdivisioncd'];
			?>
            	<tr>
            		<th align='left' width='30%'>Subdivision</th><th align='left'><?php echo $rowSubDiv['subdivision']; ?></th>
            	</tr> 
                <tr><td colspan='2' align='left'>
            		<table width='100%' class='table1'>
                    	<tr><td align="center">Post Status</td><td align="center">Central Government</td>
                        	<td align="center">State Government</td>
                            <td align="center">Central Government Undertaking</td>
                            <td align="center">State Government Undertaking</td>
                            <td align="center">Local Bodies</td>
                            <td align="center">Govt. Aided Organisation</td>
                            <td align="center">Autonomous Body</td>
                            <td align="center">Other</td></tr>
                        <?php
						include_once('../function/add_fun.php');
						$rsPostStat=fatch_postingstatus();
						$num_rowsPostStat=rowCount($rsPostStat);
						if($num_rowsPostStat>0)
						{
							for($i=1;$i<=$num_rowsPostStat;$i++)
							{
								$rowPostStat=getRows($rsPostStat);
								$post_stat=$rowPostStat['post_stat'];
								?>
                            <tr><td align="center"><?php echo $rowPostStat['post_stat']; ?></td>
                            <?php
							include_once('../function/report_fun.php');
							$c_g=0; $s_g=0; $c_g_u=0; $s_g_u=0; $l_b=0; $g_a_f=0; $a_b=0; $o_g=0;
							$rsNo=govt_cat_ag_post_stat_report($post_stat,$sub_div);
							$num_rows=rowCount($rsNo);
							if($num_rows>0)
							{
								for($j=1;$j<=$num_rows;$j++)
								{
									$rowNo=getRows($rsNo);
									if($rowNo['govt_description']=='Central Government')
									{
										$c_g=$rowNo['total'];
									}
									if($rowNo['govt_description']=='State Government')
									{
										$s_g=$rowNo['total'];
									}
									if($rowNo['govt_description']=='Central Government Undertaking')
									{
										$c_g_u=$rowNo['total'];
									}
									if($rowNo['govt_description']=='State Government Undertaking')
									{
										$s_g_u=$rowNo['total'];
									}
									if($rowNo['govt_description']=='Local Bodies')
									{
										$l_b=$rowNo['total'];
									}
									if($rowNo['govt_description']=='Govt. Aided Organisation')
									{
										$g_a_f=$rowNo['total'];
									}
									if($rowNo['govt_description']=='Autonomous Body')
									{
										$a_b=$rowNo['total'];
									}
									if($rowNo['govt_description']=='Other')
									{
										$o_g=$rowNo['total'];
									}
									unset($rowNo);
								}
							}
							unset($rsNo,$num_rows);
							?>
                            	<td align="right"><?php echo $c_g; ?></td><td align="right"><?php echo $s_g; ?></td>
                                <td align="right"><?php echo $c_g_u; ?></td><td align="right"><?php echo $s_g_u; ?></td>
                                <td align="right"><?php echo $l_b; ?></td><td align="right"><?php echo $g_a_f; ?></td>
                                <td align="right"><?php echo $a_b; ?></td><td align="right"><?php echo $o_g; ?></td>
                            </tr>    
                                <?php
								unset($rowPostStat);
							}
						}
						unset($rsPostStat,$num_rowsPostStat);
						?>
                    </table>
                </td></tr>
            <?php
				unset($rowSubDiv);
            	}
			}
			unset($rsSubDiv,$num_rowsSubdiv);
			?>
            </table>
            </td></tr>
        </table>
	</td>
</tr>
</table>
</body>
</html>