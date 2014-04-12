<?php
session_start();
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ORDER OF APPOINTMENT FOR POLLING DUTIES - RESERVE PERSONNEL</title>
<style type="text/css">
body{font: 12px Verdana, Geneva, sans-serif;}
.div1{border:1px solid #000; padding:2px; text-align:center;}
.spacer{ line-height: 10px;}
.span{ width:40px; display:inline-block;}
.table, .table td{border: 1px solid #ccc;border-collapse: collapse; vertical-align:top; padding:2px;}
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
	include_once('../function/reserve-fun.php');

	$personcd=(isset($_GET['personcd'])?$_GET['personcd']:'0');

	$env=isset($_SESSION['environment'])?$_SESSION['environment']:"";
	$distnm_cap=isset($_SESSION['distnm_cap'])?$_SESSION['distnm_cap']:"";
	
	$rec_set_hdr=second_appointment_letter_reserve3_print($personcd);
	if(rowCount($rec_set_hdr)>0)
	{
		for($n=0;$n<rowCount($rec_set_hdr);$n++)
		{
			$rec_arr_hdr=getRows($rec_set_hdr);
			
			$grp_id=$rec_arr_hdr['groupid'];
			$for_ass=$rec_arr_hdr['assembly'];
			$for_pc=$rec_arr_hdr['pcname'];
			$pp_code=$rec_arr_hdr['personcd'];
			$pp_name=$rec_arr_hdr['person_name'];
			$pp_desig=$rec_arr_hdr['person_designation'];
			$post_status=$rec_arr_hdr['post_status'];
			$post_stat=$rec_arr_hdr['post_stat'];
			$pp_ofc_cd=$rec_arr_hdr['officecd'];
			$pp_office=$rec_arr_hdr['office_name'];
			$office_address=$rec_arr_hdr['office_address'];
			$post_office=$rec_arr_hdr['post_office'];
			$subdivision=$rec_arr_hdr['subdivision'];
			$police_stn=$rec_arr_hdr['police_stn'];
			$district=$rec_arr_hdr['district'];
			$pincode=$rec_arr_hdr['pincode'];
			$dc_venue=$rec_arr_hdr['dc_venue'];
			$dc_address=$rec_arr_hdr['dc_address'];
			$dc_date=$rec_arr_hdr['dc_date'];
			$dc_time=$rec_arr_hdr['dc_time'];
			$rc_venue=$rec_arr_hdr['rc_venue'];
			$training_venue=$rec_arr_hdr['training_venue'];
			$venue_addr=$rec_arr_hdr['venue_addr1'].", ".$rec_arr_hdr['venue_addr2'];
			$training_date=$rec_arr_hdr['training_date'];
			$training_time=$rec_arr_hdr['training_time'];
			$polldate=$rec_arr_hdr['polldate'];
			$polltime=$rec_arr_hdr['polltime'];

				?>
                
<div align="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">
      	<table width="800px" cellpadding="1" cellspacing="0">
            <tr>
            	<td align='left' style='padding:5px 25px 5px 2px;; width:150px; vertical-align:top'><div class='div1'>ELECTION URGENT</div></td>
                <td align='center'><strong><u>ORDER OF APPOINTMENT FOR POLLING DUTIES</u></strong><br />
                					<u>General Parliamentary Election, 2014</u></td>
                <td align='left' style='padding:10px 25px; width:200px; vertical-align:top;'><strong>* Reserve Serial No. <?php echo $grp_id; ?></strong></td>
            </tr>
            <tr>
            	<td align='left' colspan='2'> Order No:  <span><?php print $_SESSION['apt2_orderno']; ?></span></td>
                <td align='right'>Date: <?php print $_SESSION['apt2_date']; ?></td>
            </tr>
            <tr>
            	<td class='spacer' colspan='3'>&nbsp;</td>
            </tr>
            <tr>
            	<td class='spacer' colspan='3'>&nbsp;</td>
            </tr>
            <tr>
            	<td colspan='3' align='left'><span class="span">&nbsp;</span>In persuance of sub-selection(1) and sub-selection(3) of section 26 of the Representation of the People Act, 1963(43 of 1951), I hereby appoint the officers specified in columb(2) and (3) of the table below as Presiding Officer and Polling Officers respectively for the Polling Station specified in corresponding entry in column(1) of the table provided by me for <i><?php echo $for_ass; ?></i> L.A. Constituency forming part of <i><?php echo $for_pc; ?></i> Parliamentary Constituency.</td>
            </tr>
            <tr>
            	<td class='spacer' colspan='3'>&nbsp;</td>
            </tr>
            <tr>
            	<td colspan='3' align='left'><span class="span">&nbsp;</span>I also authorise the Polling Officer specified in column(4) of the table against that entry to perform the functions of the Presiding Officer during the unavoidable absence, if any, of the Presiding Officer.</td>
            </tr>
            <tr>
            	<td class='spacer' colspan='3'>&nbsp;</td>
            </tr>
            <tr>
            	<td align='center' colspan='3'>Table</td>
            </tr>
            <tr>
            	<td align='center' colspan='3'>
                <table width='100%' cellpadding='0' cellspacing="0" border='0' class="table">
                	<tr>
                    	<td align='center' width='13%'>&nbsp;</td>
                        <td align='center' width='29%'>Name of the Presiding Officer</td>
                        <td align='center' width='29%'>Name of the Polling Officers</td>
                        <td align='center' width='29%'>Polling Officer authorised to perform the functions of the Presiding Officer in the latter's absence</td>
                    </tr>
                    <tr>
                    	<td align='center'>(1)</td>
                        <td align='center'>(2)</td>
                        <td align='center'>(3)</td>
                        <td align='center'>(4)</td>
                    </tr>
                    <tr>
                    	<td align='center'>&nbsp;</td>
                        <td align='left'>
                        <?php	
						if($post_status=='PR')
						{
							echo $pp_name.", ".$pp_desig." (PIN-".$pp_code.")";
							echo "&nbsp;&nbsp;&nbsp;".$post_status." (".$grp_id.")";
							echo "<br /><br /><br />";
							echo $pp_office.", ".$office_address.", P.O.-".$post_office.", Subdiv-".$subdivision.", Dist.-".$district;
							echo "<br /><br />";
							echo "(".$pp_ofc_cd.")";
						}
                        ?>
                        </td>
                        <td align='left'>
                        <?php	
//						$k=0;
//						while($k!=$j)
						if($post_status=='P1' || $post_status=='P2' || $post_status=='P3')
						{
							echo $pp_name.", ".$pp_desig." (PIN-".$pp_code.")";
							echo "&nbsp;&nbsp;&nbsp;".$post_status." (".$grp_id.")";
							echo "<br /><br /><br />";
							echo $pp_office.", ".$office_address.", P.O.-".$post_office.", Subdiv-".$subdivision.", Dist.-".$district;
							echo "<br /><br />";
							echo "(".$pp_ofc_cd.")";
						}						
                        ?>  
                        </td>
                        <td align='left'>
                        <?php	
						if($post_status=='P1')
						{
							echo $pp_name.", ".$pp_desig." (PIN-".$pp_code.")";
							echo "&nbsp;&nbsp;&nbsp;".$post_status." (".$grp_id.")";
							echo "<br /><br /><br />";
							echo $pp_office.", ".$office_address.", P.O.-".$post_office.", Subdiv-".$subdivision.", Dist.-".$district;
							echo "<br /><br />";
							echo "(".$pp_ofc_cd.")";
						}
                        ?>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
            	<td colspan='3' align='left'><span class="span">&nbsp;</span>The Poll will be taken on <i><?php print $polldate; ?></i> during the hours <i><?php print $polltime; ?></i>. The Presiding Officer should arrange to collect the Polling materials from <i><?php echo $dc_venue.", ".$dc_address; ?></i> on <i><?php echo $dc_date; ?></i> at <i><?php echo $dc_time; ?></i> and after the Poll, these should be returned to collecting centre at <i><?php echo $rc_venue; ?></i>.</td>
            </tr>
            <tr>
            	<td class='spacer' colspan='3'>&nbsp;</td>
            </tr>
            <tr>
            	<td colspan='2' valign='middle' align='left'>Place : <?php print uppercase($_SESSION['dist_name']); ?><br />
                				Date : <?php print date('d/m/Y'); ?></td>
                <td align='center' valign='top'>Signature<br /><img src=<?php print "../images/deo/$_SESSION[signature]"; ?> alt='' height='50px' width='100px' /><br />
                (__________________)<br />District Election Officer<br /><?php print wordcase($_SESSION['dist_name']) ?> District</td>
            </tr>
            <tr><td colspan="3"><hr style="border:1px solid #999; width:100%;" /></td></tr>
            <tr><td colspan="3" align="left">You are requested to attend the training at <?php print $training_venue.", ".$venue_addr ?> on <?php print $training_date; ?> from <?php print $training_time; ?></td></tr>
        </table>
      </td>
    </tr>
  </table>
</div><div>&nbsp;</div><h7></h7>
<?php
		}		
	}
	else
		echo "No valid data found.";
?>
</body>
</html>
<?php

// run code in x.php file
// ...
// saving captured output to file
file_put_contents('filename.htm', ob_get_contents());
// end buffering and displaying page
ob_end_flush();
?>