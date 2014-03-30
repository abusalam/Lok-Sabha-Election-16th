<?php
date_default_timezone_set('Asia/Calcutta');
	include_once('inc/db_trans.inc.php');
	include_once('function/appointment_fun.php');
	include_once('inc/commit_con.php');
	mysqli_autocommit($link,FALSE);
	
	$sql="insert into second_rand_table_reserve (groupid,assembly,pcname,personcd,person_name,person_designation,post_status,officecd,office_name,office_address,post_office,subdivision,police_stn,district,pincode,dc_venue, dc_address,dc_date,dc_time,rc_venue) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$stmt = mysqli_prepare($link, $sql);
	mysqli_stmt_bind_param($stmt, 'isssssssssssssssssss',$grp_id,$for_ass,$for_pc,$pp_code,$pp_name, $pp_desig,$post_status,$pp_ofc_cd,$pp_office,$ofc_add,$postofc,$subdiv, $ps,$dist,$pin,$dcvenue,$dc_addr,$dc_dateD,$dc_time,$rcvenue);
	
	$rec=0;
	extract($_GET);
	$group_id=isset($_GET['group_id'])?decode($_GET['group_id']):"";
	$forassembly=isset($_GET['assembly'])?decode($_GET['assembly']):"";
	$forpc=decode($_GET['pc_cd']);
	//$forpc='40';
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
			$dc=($rec_arr_hdr['dc_venue']!=''?$rec_arr_hdr['dc_venue'].", ".$rec_arr_hdr['dc_addr']:"");
			$dc_date=($rec_arr_hdr['dc_date']!=''?$rec_arr_hdr['dc_date']:"");
			$dc_dateD=($rec_arr_hdr['dc_dateD']!=''?$rec_arr_hdr['dc_dateD']:"");
			$dc_time=($rec_arr_hdr['dc_time']!=''?$rec_arr_hdr['dc_time']:"");
			$rcvenue=($rec_arr_hdr['rcvenue']!=''?$rec_arr_hdr['rcvenue']:"");
			$dcvenue=$rec_arr_hdr['dc_venue'];
			$dc_addr=$rec_arr_hdr['dc_addr'];

			$pp_name=$rec_arr_hdr['officer_name'];
			$pp_desig=$rec_arr_hdr['off_desg'];
			$pp_code=$rec_arr_hdr['personcd'];
			$post_status=$rec_arr_hdr['poststat'];
			$pp_office=$rec_arr_hdr['office'];
			$ofc_add=$rec_arr_hdr['address1'].", ".$rec_arr_hdr['address2'];
			$postofc=$rec_arr_hdr['postoffice'];
			$subdiv=$rec_arr_hdr['subdivision'];
			$ps=$rec_arr_hdr['policestation'];
			$dist=$rec_arr_hdr['district'];
			$pin=$rec_arr_hdr['pin'];
			$pp_ofc_address=$rec_arr_hdr['address1'].", ".$rec_arr_hdr['address2'].", P.O.-".$rec_arr_hdr['postoffice'].", Subdiv.-".$rec_arr_hdr['subdivision'].", P.S.-".$rec_arr_hdr['policestation'].", Dist.-".$rec_arr_hdr['district'].", PIN-".$rec_arr_hdr['pin'];
			$pp_ofc_cd=$rec_arr_hdr['officecd'];

			mysqli_stmt_execute($stmt);
			$rec+=mysqli_stmt_affected_rows($stmt);
		}
		if (!mysqli_commit($link)) {
			print("Transaction commit failed\n");
			exit();
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($link);
		
		$sql19="update second_rand_table_reserve join second_training on substr(second_rand_table_reserve.pcname,1,2)=second_training.for_pc and substr(second_rand_table_reserve.assembly,1,3)=second_training.assembly set second_rand_table_reserve.traingcode=second_training.schedule_cd, second_rand_table_reserve.venuecode=second_training.training_venue , second_rand_table_reserve.training_date=second_training.training_dt, second_rand_table_reserve.training_time=second_training.training_time where second_training.party_reserve='R' and second_rand_table_reserve.groupid>=second_training.start_sl and second_rand_table_reserve.groupid<=second_training.end_sl and second_training.for_pc='$pc_cd'";
		$i=execUpdate($sql19);
		$sql20="UPDATE second_rand_table_reserve a  JOIN training_venue_2 b ON a.venuecode=b.venue_cd SET  a.`training_venue` =b.venuename,a.`venue_addr1` =b.venueaddress1,  a.`venue_addr2`=b.venueaddress2 where substr(a.pcname,1,2)='$pc_cd'";
		$i=execUpdate($sql20);
		$sql271="update second_rand_table_reserve a join poll_table b on substr(a.pcname,1,2)=b.pc_cd set a.polldate=b.poll_date, a.polltime=b.poll_time where substr(a.pcname,1,2)='$pc_cd'";
		$i=execUpdate($sql271);
		
		print "$rec Record(s) updated successfully\n";
	}
	else
		echo "No valid data found.";
?>