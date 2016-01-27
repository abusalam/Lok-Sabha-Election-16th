<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Office Category Wise Report</title>
<style type="text/css">
body{font: 12px Verdana, Geneva, sans-serif;}
.div1{border:1px solid #000; padding:2px; text-align:center;}
.spacer{ line-height: 10px;}
.span{ width:40px; display:inline-block;}
.table{border: 1px solid #ccc; vertical-align:top; padding:2px;}
@media print
{
h7 {page-break-after:always;}
}
</style>
</head>
<body>
<table width="100%">
<tr><td align="center">
		<table width='700px' cellpadding='0' cellspacing='0' border='0'>
        <thead>
        	<tr>
            	<th align='center' colspan='2'>Office Category Wise Report</th>
            </tr>
            <tr>
            	<th align='center' colspan='2'>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php
			date_default_timezone_set('Asia/Calcutta');
			include_once('../inc/db_trans.inc.php');
			include_once('../function/master_fun.php');
			include_once('../function/report_fun.php');
			if(isset($_REQUEST['district']))
				$dist_cd=$_REQUEST['district'];
			else
				$dist_cd=='';
			if(isset($_REQUEST['Subdivision']))
				$subdiv_cd=$_REQUEST['Subdivision'];
			else
				$subdiv_cd=='';
			if(isset($_REQUEST['govt_cat']))
				$govt_cat=$_REQUEST['govt_cat'];
			else
				$govt_cat=='';
			include_once('../function/add_fun.php');
			if($govt_cat!='' && $govt_cat!='0')
			{
				$rsBn=fatch_statusofoffice($govt_cat);
				$rowBn=getRows($rsBn);
				$govcat=$rowBn[1];
			}
			else
			{
				$govcat="All";
			}
			$rsDist=fatch_district_master($dist_cd);
			$num_rows=rowCount($rsDist);
			if($num_rows>0)
			{
				for($i=1;$i<=$num_rows;$i++)
				{
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
					$num_rows1=rowCount($rsSubdiv);
					
					if($num_rows1>0)
					{
						for($j=1;$j<=$num_rows1;$j++)
						{
							$rowSubDiv=getRows($rsSubdiv);
							$sub_div=$rowSubDiv['subdivisioncd'];
							?>
            <tr>
            	<th align='left' width='30%'>Subdivision</th><th align='left'><?php echo $rowSubDiv['subdivision']; ?></th>
            </tr>         
            <tr><td colspan='2' align='left'>
            <table width='100%' class='table'>             
                            <?php
							$rsGovtCat=govt_cat_wise_report($dist,$sub_div,$govt_cat);
							$num_rows2=rowCount($rsGovtCat);
							if($num_rows2>0)
							{
								for($k=1;$k<=$num_rows2;$k++)
								{
									$rowGovtCat=getRows($rsGovtCat);
									?>
                            <tr><td align='left' width='50%'><?php echo $rowGovtCat['govt_description'];?></td>
                            	<td align='left'><?php echo $rowGovtCat['count'];?></td>
                            </tr>        
                                    <?php
								}
							}
							else {
							?>
                            <tr><td align='center' colspan='2'>No record found</td></tr>
                            <?php }
			?>
            </table>
            </td></tr>
            <tr><td colspan='2' align='center'>&nbsp;</td></tr>
            <?php				
							unset($rowSubDiv);
						}
					}
					unset($rowDist);
					?>
             </table>
             </td></tr>
             <tr><td colspan='2' align='center'>&nbsp;</td></tr>
                    <?php
				}
			}
			?>
        	<tr><td colspan='2' align='center'>Search by Office Category <?php echo $govcat; ?></td></tr>
        </table>
	</td>
</tr>
</table>
</body>
</html>