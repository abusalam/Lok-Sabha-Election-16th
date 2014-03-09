<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Polling Party Against PS No</title>
<style type="text/css">
body{font: 12px Verdana, Geneva, sans-serif;}
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
<body>
<?php
date_default_timezone_set('Asia/Calcutta');
	include_once('../inc/db_trans.inc.php');
	include_once('../function/report_fun.php');
	extract($_GET);
	$sub_div=($_REQUEST['sub_div']);
	$ass=($_REQUEST['assembly']);
	$orderby=($_REQUEST['orderby']);
	$rs_hrd=get_assembly_dcrc_venue($sub_div,$ass);
	if(rowCount($rs_hrd)>0)
	{
		for($i=0;$i<rowCount($rs_hrd);$i++)
		{
			$rec_hdr=getRows($rs_hrd);
			$assembly=$rec_hdr['assemblycd']."-".$rec_hdr['assemblyname'];
			$dcrc_venue=$rec_hdr['dc_venue']." & ".$rec_hdr['rcvenue'].", ".$rec_hdr['dc_addr'];
			$dcrc=$rec_hdr['dcrcgrp'];
?>
<div align="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr>
      <td align="center">
      	<table width="800px" cellpadding="1" cellspacing="0" class="table1">
        <thead>
        	<tr>
            	<th align='center' colspan='3' class="text-large"><?php echo $assembly; ?></th>
            </tr>
            <tr>
            	<td align="left" colspan="2" width="25%"><strong>DC/RC Venue :</strong></td>
                <td align="left"><strong><?php echo $dcrc_venue; ?></strong></td>
            </tr>
            <tr class="text-mid">
            	<td align="center">Party No</td>
                <td align="center">P.S. No.</td>
                <td align="left">Polling Station Name</td>
            </tr>
         </thead>
            <?php
			$rs_rec=polling_party_ag_psno($dcrc,$orderby);
			if(rowCount($rs_rec)>0)
			{
				for($j=0;$j<rowCount($rs_rec);$j++)
				{
					$row_rec=getRows($rs_rec);
					$partyno=$row_rec['groupid'];
					$psno=$row_rec['psno'];
					$psname=$row_rec['psname'];
			?>
            <tr>
            	<td align="center"><?php echo $partyno; ?></td>
                <td align="center"><?php echo $psno; ?></td>
                <td align="left"><?php echo $psname; ?></td>
            </tr>
            <?php
					$row_rec=NULL;
				}
				unset($rs_rec);
			}
			else
				echo "<tr><td align='center' colspan='3'>No data found</td></tr>";
			?>
        </table>
      </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
  </table>
</div>
<?php
			$rec_hdr=NULL;
		}
		unset($rs_hrd);
	}
	else
		echo "<div align='center'>No data found</div>";
?>
<h7></h7>
</body>
</html>