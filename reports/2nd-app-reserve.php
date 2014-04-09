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
	include_once('../function/appointment_fun.php');
	include_once('../inc/commit_con.php');
	mysqli_autocommit($link,FALSE);
		
	extract($_GET);
	$group_id=decode($_GET['group_id']);
	$forassembly=decode($_GET['assembly']);
	$forpc=decode($_GET['pc']);
	$rsPoll=fetch_polldate_n_time($forpc);
	if(rowCount($rsPoll)>0)
	{
		$rowPoll=getRows($rsPoll);
		$poll_date=$rowPoll['poll_date'];
		$poll_dateD=$rowPoll['poll_dateD'];
		$poll_time=$rowPoll['poll_time'];
	}
	else
	{
		$poll_date="";
		$poll_time="";
	}
	unset($rowPoll,$rsPoll);

	
	$del_ret=delete_prev_data_second_rand_reserve($forassembly,$forpc,$group_id);
	$rec_set_hdr=second_appointment_letter_reserve($group_id,$forassembly,$forpc);
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
			$dc_dateD=$rec_arr_hdr['dc_dateD'];
			$dc_time=($rec_arr_hdr['dc_time']!=''?$rec_arr_hdr['dc_time']:"___________");
			$rcvenue=($rec_arr_hdr['rcvenue']!=''?$rec_arr_hdr['rcvenue']:"_______________________________");
			
//			$rec_set=second_appointment_letter($grp_id,$rec_arr_hdr['assemblycd']);
//			$num_rows=rowCount($rec_set);
//			if($num_rows>0)
			{
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
<?php
//$j=0;
//	for($i=0;$i<$num_rows;$i++)
	{
		
		$sql="insert into second_rand_table_reserve (groupid,assembly,pcname,personcd,person_name,person_designation,post_status,officecd,office_name,office_address,post_office,subdivision,police_stn,district,pincode,dc_venue, dc_address,dc_date,dc_time,rc_venue,polldate,polltime) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt = mysqli_prepare($link, $sql);
		
		{
			$pp_name=$rec_arr_hdr['officer_name'];
			$pp_desig=$rec_arr_hdr['off_desg'];
			$pp_code=$rec_arr_hdr['personcd'];
			$pp_office=$rec_arr_hdr['office'];
			$pp_ofc_address=$rec_arr_hdr['address1'].", ".$rec_arr_hdr['address2'].", P.O.-".$rec_arr_hdr['postoffice'].", Subdiv.-".$rec_arr_hdr['subdivision'].", Dist.-".$rec_arr_hdr['district'];
			$pp_ofc_cd=$rec_arr_hdr['officecd'];
			//$j++;
		}
		$ofc_add=$rec_arr_hdr['address1'].", ".$rec_arr_hdr['address2'];
		mysqli_stmt_bind_param($stmt, 'isssssssssssssssssssss',$grp_id,$for_ass,$for_pc,$rec_arr_hdr['personcd'],$rec_arr_hdr['officer_name'], $rec_arr_hdr['off_desg'],$rec_arr_hdr['poststat'],$rec_arr_hdr['officecd'],$rec_arr_hdr['office'],$ofc_add,$rec_arr_hdr['postoffice'],$rec_arr_hdr['subdivision'], $rec_arr_hdr['policestation'],$rec_arr_hdr['district'],$rec_arr_hdr['pin'],$rec_arr_hdr['dc_venue'],$rec_arr_hdr['dc_addr'],$dc_dateD,$dc_time,$rec_arr_hdr['rcvenue'],$poll_dateD,$poll_time);
		mysqli_stmt_execute($stmt);
	}
		
?>
                        <td align='left'>
                        <?php	
						if($rec_arr_hdr['poststat']=='PR')
						{
							echo $pp_name.", ".$pp_desig." (PIN-".$pp_code.")";
							echo "&nbsp;&nbsp;&nbsp; ".$rec_arr_hdr['poststat']."($grp_id)";
							echo "<br /><br /><br />";
							echo $pp_office.", ".$pp_ofc_address;
							echo "<br /><br />";
							echo "(".$pp_ofc_cd.")";
						}
                        ?>
                        </td>
                        <td align='left'>
                        <?php	
//						$k=0;
//						while($k!=$j)
						if($rec_arr_hdr['poststat']=='P1' || $rec_arr_hdr['poststat']=='P2' || $rec_arr_hdr['poststat']=='P3')
						{
							echo $pp_name.", ".$pp_desig." (PIN-".$pp_code.")";
							echo "&nbsp;&nbsp;&nbsp; ".$rec_arr_hdr['poststat']."($grp_id)";
							echo "<br /><br />";
							echo $pp_office.", ".$pp_ofc_address;
							echo "<br /><br />";
							echo "(".$pp_ofc_cd.")";
							echo "<br /><br />";
//							$k++;
						}						
                        ?>  
                        </td>
                        <td align='left'>
                        <?php	
						if($rec_arr_hdr['poststat']=='P1')
						{
							echo $pp_name.", ".$pp_desig." (PIN-".$pp_code.")";
							echo "<br /><br />";
							echo $pp_office.", ".$pp_ofc_address;
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
</div><div>&nbsp;</div><h7></h7>
<?php
			}
//			else
//				echo "No valid data found.";
		}
		if (!mysqli_commit($link)) {
			print("Transaction commit failed\n");
			exit();
		}
		mysqli_stmt_close($stmt);
		mysqli_close($link);
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