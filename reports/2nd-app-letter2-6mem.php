<?php
session_start();
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ORDER OF APPOINTMENT FOR POLLING DUTIES</title>
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
	include_once('../function/training2_fun.php');
	//include_once('../inc/commit_con.php');
	extract($_GET);
	$from=(isset($_POST['txtfrom'])?$_POST['txtfrom']:'0');
	$to=(isset($_POST['txtto'])?$_POST['txtto']:'0');
	//$hid_rec=(isset($_POST['hid_rec'])?$_POST['hid_rec']:'0');
	$env=isset($_SESSION['environment'])?$_SESSION['environment']:"";
	$distnm_cap=isset($_SESSION['distnm_cap'])?$_SESSION['distnm_cap']:"";
	if($from>$to || $from<1 || $to<1)
	{
		echo "Please check record no";
		exit;
	}
	$mem_no=6;
	$rsApp=second_appointment_letter2_print($from-1,$to-$from+1,$mem_no);
	$num_rows=rowCount($rsApp);
	if($num_rows>0)
	{	
		for($i=0;$i<$num_rows;$i++)
		{
			$rowApp=getRows($rsApp);
			
			$pers_off=$rowApp['pers_off'];
			$per_poststat=$rowApp['per_poststat'];
			$grp_id=$rowApp['groupid'];
			$for_ass=$rowApp['assembly']."-".$rowApp['assembly_name'];
			$for_pc=$rowApp['pccd']."-".$rowApp['pcname'];
			//$polling_station=$rec_arr_hdr['psno'].", ".$rec_arr_hdr['psname'];
			$dc=($rowApp['dc_venue']!=''?$rowApp['dc_venue'].", ".$rowApp['dc_address']:"___________________________________");
			$dc_date=($rowApp['dc_date']!=''?$rowApp['dc_date']:"___________");
			$dc_time=($rowApp['dc_time']!=''?$rowApp['dc_time']:"___________");
			$rcvenue=($rowApp['rc_venue']!=''?$rowApp['rc_venue']:"_______________________________");
			
			$pr_name=$rowApp['pr_name'];
			$pr_desig=$rowApp['pr_designation'];
			$pr_code=$rowApp['pr_personcd'];
			$pr_office=$rowApp['pr_officename'];
			$pr_ofc_address=$rowApp['pr_officeaddress'].", P.O.-".$rowApp['pr_postoffice'].", Subdiv.-".$rowApp['pr_subdivision'].", Dist.-".$rowApp['district'].", PIN-".$rowApp['pr_pincode'];
			$pr_ofc_cd=$rowApp['pr_officecd'];
			$pr_post_stat=$rowApp['pr_post_stat'];
			
			$p1_name=$rowApp['p1_name'];
			$p1_desig=$rowApp['p1_designation'];
			$p1_code=$rowApp['p1_personcd'];
			$p1_office=$rowApp['p1_officename'];
			$p1_ofc_address=$rowApp['p1_officeaddress'].", P.O.-".$rowApp['p1_postoffice'].", Dist.-".$rowApp['district'].", PIN-".$rowApp['p1_pincode'];
			$p1_ofc_address1=$rowApp['p1_officeaddress'].", P.O.-".$rowApp['p1_postoffice'].", Subdiv.-".$rowApp['p1_subdivision'].", Dist.-".$rowApp['district'].", PIN-".$rowApp['p1_pincode'];
			$p1_ofc_cd=$rowApp['p1_officecd'];
			$p1_post_stat=$rowApp['p1_post_stat'];
			
			$p2_name=$rowApp['p2_name'];
			$p2_desig=$rowApp['p2_designation'];
			$p2_code=$rowApp['p2_personcd'];
			$p2_office=$rowApp['p2_officename'];
			$p2_ofc_address=$rowApp['p2_officeaddress'].", P.O.-".$rowApp['p2_postoffice'].", Dist.-".$rowApp['district'].", PIN-".$rowApp['p2_pincode'];
			$p2_ofc_cd=$rowApp['p2_officecd'];
			$p2_post_stat=$rowApp['p2_post_stat'];
			
			$p3_name=$rowApp['p3_name'];
			$p3_desig=$rowApp['p3_designation'];
			$p3_code=$rowApp['p3_personcd'];
			$p3_office=$rowApp['p3_officename'];
			$p3_ofc_address=$rowApp['p3_officeaddress'].", P.O.-".$rowApp['p3_postoffice'].", Dist.-".$rowApp['district'].", PIN-".$rowApp['p3_pincode'];
			$p3_ofc_cd=$rowApp['p3_officecd'];
			$p3_post_stat=$rowApp['p3_post_stat'];
			
			$pa_name=$rowApp['pa_name'];
			$pa_desig=$rowApp['pa_designation'];
			$pa_code=$rowApp['pa_personcd'];
			$pa_office=$rowApp['pa_officename'];
			$pa_ofc_address=$rowApp['pa_officeaddress'].", P.O.-".$rowApp['pa_postoffice'].", Dist.-".$rowApp['district'].", PIN-".$rowApp['pa_pincode'];
			$pa_ofc_cd=$rowApp['pa_officecd'];
			$pa_post_stat=$rowApp['pa_post_stat'];
			
			$pb_name=$rowApp['pb_name'];
			$pb_desig=$rowApp['pb_designation'];
			$pb_code=$rowApp['pb_personcd'];
			$pb_office=$rowApp['pb_officename'];
			$pb_ofc_address=$rowApp['pb_officeaddress'].", P.O.-".$rowApp['pb_postoffice'].", Dist.-".$rowApp['district'].", PIN-".$rowApp['pb_pincode'];
			$pb_ofc_cd=$rowApp['pb_officecd'];
			$pb_post_stat=$rowApp['pb_post_stat'];
			
			$poll_date=$rowApp['polldate'];
			$poll_time=$rowApp['polltime'];
			$training_venue=$rowApp['training_venue'];
			$venue_addr=$rowApp['venue_addr1'].", ".$rowApp['venue_addr2'];
			$training_date=$rowApp['training_date'];
			$training_time=$rowApp['training_time'];
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
                <td align='right' style='padding:10px 1px 10px 25px; width:200px; vertical-align:top;'><?php print $per_poststat."/".$pers_off; ?><br /><strong>* Polling Party No. <?php echo $grp_id; ?></strong></td>
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
                    	<td align='center' width='13%'>Polling Party No.</td>
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
                    	<td align='center'><?php echo $grp_id; //echo $polling_station; ?></td>
                        <td align='left'>
                        <?php	
						echo $pr_name.", ".$pr_desig." (PIN-".$pr_code.")";
						echo "<br />";
						echo $pr_post_stat;
						echo "<br /><br /><br />";
						echo $pr_office.", ".$pr_ofc_address;
						echo "<br /><br />";
						echo "(".$pr_ofc_cd.")";
                        ?>
                        </td>
                        <td align='left'>
                        <?php	
						echo "1. ".$p1_name.", ".$p1_desig." (PIN-".$p1_code.")";
						echo "<br />";
						echo $p1_post_stat;
						echo "<br /><br />";
						echo $p1_office.", ".$p1_ofc_address;
						echo "<br /><br />";
						echo "(".$p1_ofc_cd.")";
						echo "<br /><br />";
						
						echo "2. ".$p2_name.", ".$p2_desig." (PIN-".$p2_code.")";
						echo "<br />";
						echo $p2_post_stat;
						echo "<br /><br />";
						echo $p2_office.", ".$p2_ofc_address;
						echo "<br /><br />";
						echo "(".$p2_ofc_cd.")";
						echo "<br /><br />";
						
						echo "3. ".$pa_name.", ".$pa_desig." (PIN-".$pa_code.")";
						echo "<br />";
						echo $pa_post_stat;
						echo "<br /><br />";
						echo $pa_office.", ".$pa_ofc_address;
						echo "<br /><br />";
						echo "(".$pa_ofc_cd.")";
						echo "<br /><br />";
						
						echo "4. ".$pb_name.", ".$pb_desig." (PIN-".$pb_code.")";
						echo "<br />";
						echo $pb_post_stat;
						echo "<br /><br />";
						echo $pb_office.", ".$pb_ofc_address;
						echo "<br /><br />";
						echo "(".$pb_ofc_cd.")";
						echo "<br /><br />";
						
						echo "5. ".$p3_name.", ".$p3_desig." (PIN-".$p3_code.")";
						echo "<br />";
						echo $p3_post_stat;
						echo "<br /><br />";
						echo $p3_office.", ".$p3_ofc_address;
						echo "<br /><br />";
						echo "(".$p3_ofc_cd.")";
						echo "<br /><br />";
                        ?>  
                        </td>
                        <td align='left'>
                        <?php	
						echo "1. ".$p1_name.", ".$p1_desig." (PIN-".$p1_code.")";
						echo "<br />";
						echo $p1_post_stat;
						echo "<br /><br />";
						echo $p1_office.", ".$p1_ofc_address1;
						echo "<br /><br />";
						echo "(".$p1_ofc_cd.")";
                        ?>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
            	<td colspan='3' align='left'><span class="span">&nbsp;</span>The Poll will be taken on <i><?php print $poll_date; ?></i> during the hours <i><?php print $poll_time; ?></i>. The Presiding Officer should arrange to collect the Polling materials from <i><?php echo $dc; ?></i> on <i><?php echo $dc_date; ?></i> at <i><?php echo $dc_time; ?></i> and after the Poll, these should be returned to collecting centre at <i><?php echo $rcvenue; ?></i>.</td>
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
</div><h7></h7>
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