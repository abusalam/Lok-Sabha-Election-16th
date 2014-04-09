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
	include_once('../function/appointment_fun2.php');
		
	extract($_GET);
	$group_id=$_GET['group_id'];
	$forassembly=$_GET['assembly'];
	$forpc=$_GET['pc'];
	$per_cd=$_GET['per_cd'];
	
	$sql_m="select count(*) as cnt_m from personnela where forassembly='$forassembly' and forpc='$forpc' and groupid='$group_id' and booked='P'";
	$rs_m=execSelect($sql_m);
	$row_m=getRows($rs_m);
	$mem_no=$row_m['cnt_m'];
	
	$rec_set_hdr=second_app_hrd3($forassembly,$forpc,$group_id);
	if(rowCount($rec_set_hdr)>0)
	{
		for($n=0;$n<rowCount($rec_set_hdr);$n++)
		{
			$rec_arr_hdr=getRows($rec_set_hdr);
			
			$grp_id=$rec_arr_hdr['groupid'];
			$for_ass=$rec_arr_hdr['assemblycd']."-".$rec_arr_hdr['assemblyname'];
			$for_pc=$rec_arr_hdr['pccd']."-".$rec_arr_hdr['pcname'];
			//$polling_station=$rec_arr_hdr['psno'].", ".$rec_arr_hdr['psname'];
			$dc=($rec_arr_hdr['dc_venue']!=''?$rec_arr_hdr['dc_venue'].", ".$rec_arr_hdr['dc_addr']:"___________________________________");
			$dc_date=($rec_arr_hdr['dc_date']!=''?$rec_arr_hdr['dc_date']:"___________");
			$dc_time=($rec_arr_hdr['dc_time']!=''?$rec_arr_hdr['dc_time']:"___________");
			$rcvenue=($rec_arr_hdr['rcvenue']!=''?$rec_arr_hdr['rcvenue']:"_______________________________");
			$poll_date=($rec_arr_hdr['poll_date']!=''?$rec_arr_hdr['poll_date']:"___________");
			$poll_time=($rec_arr_hdr['poll_time']!=''?$rec_arr_hdr['poll_time']:"___________");
			
			$rec_set=second_appointment_letter3($grp_id,$rec_arr_hdr['assemblycd']);
			$num_rows=rowCount($rec_set);
			if($num_rows>0)
			{
			$j=0;
			for($i=0;$i<$num_rows;$i++)
			{		
				$rec_arr=getRows($rec_set);
				if($per_cd==$rec_arr['personcd'])
				{
					$per_poststat=$rec_arr['poststat'];
					$pers_off=$rec_arr['officecd'];
				}
				
				if($rec_arr['poststat']=='PR')
				{
					$pr_name=$rec_arr['officer_name'];
					$pr_desig=$rec_arr['off_desg'];
					$pr_code=$rec_arr['personcd'];
					$pr_office=$rec_arr['office'];
					$pr_ofc_address=$rec_arr['address1'].", ".$rec_arr['address2'].", P.O.-".$rec_arr['postoffice'].", Subdiv.-".$rec_arr['subdivision'].", Dist.-".$rec_arr['district'];
					$pr_ofc_cd=$rec_arr['officecd'];
					$pr_post_stat=$rec_arr['poststatus'];
				}
				elseif($rec_arr['poststat']=='P1')
				{
					$p1_name=$rec_arr['officer_name'];
					$p1_desig=$rec_arr['off_desg'];
					$p1_code=$rec_arr['personcd'];
					$p1_office=$rec_arr['office'];
					$p1_ofc_address=$rec_arr['address1'].", ".$rec_arr['address2'].", P.O.-".$rec_arr['postoffice'].", Subdiv.-".$rec_arr['subdivision'].", Dist.-".$rec_arr['district'];
					$p1_ofc_cd=$rec_arr['officecd'];
					$p1_post_stat=$rec_arr['poststatus'];
				}
				elseif($rec_arr['poststat']=='P2')
				{
					$p2_name=$rec_arr['officer_name'];
					$p2_desig=$rec_arr['off_desg'];
					$p2_code=$rec_arr['personcd'];
					$p2_office=$rec_arr['office'];
					$p2_ofc_address=$rec_arr['address1'].", ".$rec_arr['address2'].", P.O.-".$rec_arr['postoffice'].", Subdiv.-".$rec_arr['subdivision'].", Dist.-".$rec_arr['district'];
					$p2_ofc_cd=$rec_arr['officecd'];
					$p2_post_stat=$rec_arr['poststatus'];
				}
				elseif($rec_arr['poststat']=='P3')
				{
					$p3_name=$rec_arr['officer_name'];
					$p3_desig=$rec_arr['off_desg'];
					$p3_code=$rec_arr['personcd'];
					$p3_office=$rec_arr['office'];
					$p3_ofc_address=$rec_arr['address1'].", ".$rec_arr['address2'].", P.O.-".$rec_arr['postoffice'].", Subdiv.-".$rec_arr['subdivision'].", Dist.-".$rec_arr['district'];
					$p3_ofc_cd=$rec_arr['officecd'];
					$p3_post_stat=$rec_arr['poststatus'];
				}
				elseif($rec_arr['poststat']=='PA')
				{
					$pa_name=$rec_arr['officer_name'];
					$pa_desig=$rec_arr['off_desg'];
					$pa_code=$rec_arr['personcd'];
					$pa_office=$rec_arr['office'];
					$pa_ofc_address=$rec_arr['address1'].", ".$rec_arr['address2'].", P.O.-".$rec_arr['postoffice'].", Subdiv.-".$rec_arr['subdivision'].", Dist.-".$rec_arr['district'];
					$pa_ofc_cd=$rec_arr['officecd'];
					$pa_post_stat=$rec_arr['poststatus'];
				}
				elseif($rec_arr['poststat']=='PB')
				{
					$pb_name=$rec_arr['officer_name'];
					$pb_desig=$rec_arr['off_desg'];
					$pb_code=$rec_arr['personcd'];
					$pb_office=$rec_arr['office'];
					$pb_ofc_address=$rec_arr['address1'].", ".$rec_arr['address2'].", P.O.-".$rec_arr['postoffice'].", Subdiv.-".$rec_arr['subdivision'].", Dist.-".$rec_arr['district'];
					$pb_ofc_cd=$rec_arr['officecd'];
					$pb_post_stat=$rec_arr['poststatus'];
				}
			}
				?>           
<div align="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">
      	<table width="800px" cellpadding="1" cellspacing="0">
            <tr>
            	<td align='left' style='padding:5px 25px 5px 2px;; width:150px; vertical-align:top'><div class='div1'>ELECTION URGENT</div></td>
                <td align='center'><strong><u>ORDER OF APOINTMENT FOR POLLING DUTIES</u></strong><br />
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
						if($mem_no==4)
						{
							echo "3. ".$p3_name.", ".$p3_desig." (PIN-".$p3_code.")";
							echo "<br />";
							echo $p3_post_stat;
							echo "<br /><br />";
							echo $p3_office.", ".$p3_ofc_address;
							echo "<br /><br />";
							echo "(".$p3_ofc_cd.")";
							echo "<br /><br />";
						}
						if($mem_no==5)
						{
							echo "3. ".$pa_name.", ".$pa_desig." (PIN-".$pa_code.")";
							echo "<br />";
							echo $pa_post_stat;
							echo "<br /><br />";
							echo $pa_office.", ".$pa_ofc_address;
							echo "<br /><br />";
							echo "(".$pa_ofc_cd.")";
							echo "<br /><br />";
							
							echo "4. ".$p3_name.", ".$p3_desig." (PIN-".$p3_code.")";
							echo "<br />";
							echo $p3_post_stat;
							echo "<br /><br />";
							echo $p3_office.", ".$p3_ofc_address;
							echo "<br /><br />";
							echo "(".$p3_ofc_cd.")";
							echo "<br /><br />";
						}
						if($mem_no==6)
						{
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
						}
                        ?>  
                        </td>
                        <td align='left'>
                        <?php	
						echo $p1_name.", ".$p1_desig." (PIN-".$p1_code.")";
						echo "<br />";
						echo $p1_post_stat;
						echo "<br /><br /><br />";
						echo $p1_office.", ".$p1_ofc_address;
						echo "<br /><br />";
						echo "(".$p1_ofc_cd.")";
                        ?>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
            	<td colspan='3' align='left'><span class="span">&nbsp;</span>The Poll will be taken on <i><?php echo $poll_date; ?></i> during the hours <i><?php echo $poll_time; ?></i>. The Presiding Officer should arrange to collect the Polling materials from <i><?php echo $dc; ?></i> on <i><?php echo $dc_date; ?></i> at <i><?php echo $dc_time; ?></i> and after the Poll, these should be returned to collecting centre at <i><?php echo $rcvenue; ?></i>.</td>
            </tr>
            <tr>
            	<td class='spacer' colspan='3'>&nbsp;</td>
            </tr>
            <tr>
            	<td colspan='2' valign='middle' align='left'>Place : <?php print uppercase($_SESSION['dist_name']); ?><br />
                				Date : <?php print date('d/m/Y'); ?></td>
                <td align='center' valign='top'>Signature<br /><img src=<?php print "../images/deo/$_SESSION[signature]"; ?> alt='0' height='50px' width='100px' /><br />
                (__________________)<br />District Election Officer<br /><?php print wordcase($_SESSION['dist_name']) ?> District</td>
            </tr>
        </table>
      </td>
    </tr>
  </table>
</div><h7></h7>
<?php
			}
			else
				echo "No valid data found.";
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