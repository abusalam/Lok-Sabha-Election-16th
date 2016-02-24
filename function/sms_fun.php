<?php
include_once('string_fun.php');
function fatch_SMS_from_sms_table($from,$limit)
{
	$sql="select name,phone_no,message from tblsms limit $from,$limit";
	//echo $sql; exit;
	$rs=execSelect($sql);
	return $rs;
}
/*function fatch_post_status_for_first_rand($post_stat)
{
	$sql="select poststatus from poststat where post_stat='$post_stat' order by poststatus asc";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$amount=$row['poststatus'];
	connection_close();
	return $amount;
}*/
/////save sms 1st//
function delete_first_tbl_sms()
{
	$sql="delete from tblsms";
	$i=execDelete($sql);
	return $i;
}

function first_rand_member_available($post_stat,$subdiv,$phase,$chkextrapp,$type_details,$text_msg)
{
		    if($type_details=='B')
			{
				$Message = "concat('$text_msg', '(',first_rand_table.poststatus,') bank :',first_rand_table.bank,' a/c no: ',first_rand_table.bank_accno,' ifsc: ',first_rand_table.ifsc)";
			}
			else if($type_details=='T')
			{
				$Message = "concat('$text_msg', '(',first_rand_table.poststatus,') venue :',first_rand_table.venuename,' date: ',first_rand_table.training_dt,' time: ',first_rand_table.training_time)";
		
			}
			else if($type_details=='V')
			{
				$Message = "concat('$text_msg', '(',first_rand_table.poststatus,') ac :',first_rand_table.acno,' part: ',first_rand_table.partno,' sl: ',first_rand_table.slno,' epic: ',first_rand_table.epic)";
				
			}
			else if($type_details=='0')
			{
				$Message = "'$text_msg'";
			}
			if($chkextrapp=='on')
			{
				$sql="Insert into tblsms (name,phone_no,message) 		
				SELECT concat(first_rand_table.officer_name,' PIN -',first_rand_table.personcd), first_rand_table.mob_no,
				$Message 
				from first_rand_table 
				Inner Join personnela On personnela.personcd = first_rand_table.personcd
				where personnela.forsubdivision = '$subdiv' and personnela.ttrgschcopy='$phase' and personnela.booked='P' And personnela.selected = 1";
				if($post_stat!='' && $post_stat!='0')
				  $sql.=" and personnela.poststat='$post_stat'";
				$rs=execSelect($sql);
				connection_close();
				//return $rs;
			}
			else
			{
				$sql="Insert into tblsms (name,phone_no,message) 		
				SELECT concat(first_rand_table.officer_name,' PIN -',first_rand_table.personcd), first_rand_table.mob_no,
				$Message
				
				from first_rand_table 
				Inner Join personnela On personnela.personcd = first_rand_table.personcd
				where personnela.forsubdivision = '$subdiv' and (personnela.ttrgschcopy is Null or personnela.ttrgschcopy='0') And personnela.selected = 1 ";
				if($post_stat!='' && $post_stat!='0')
				$sql.=" and personnela.poststat='$post_stat'";
				
				$rs=execSelect($sql);		
				connection_close();
				//return $rs;
			}
			
			$sql1="select count(*) as cnt  from tblsms";
			$rs1=execSelect($sql1);
			$row1=getRows($rs1);
			$amount1=$row1['cnt'];
			connection_close();
			return $amount1;
	
}
//save sms 2nd//
function delete_2nd_tbl_sms2()
{
	$sql="delete from tblsms2";
	$i=execDelete($sql);
	return $i;
}
//from second appt//
function fetch_second_appt_member_available($post_stat,$Subdivision,$type_details,$text_msg)
{
	if($post_stat=='PR')
	{
		$Message=" concat(pr_name,' PIN -',pr_personcd), pr_mobno ";
		 if($type_details=='D')
		  {
			  $Message.= ", concat('$text_msg', '(',pr_post_stat,') dc venue:',dc_venue,' dc date: ',dc_date,' dc time: ',dc_time,' rc venue:',rc_venue)";
		  }
		  else if($type_details=='T')
		  {
			  $Message.= ", concat('$text_msg', '(',pr_post_stat,') venue :',training_venue,' date: ',training_date,' time: ',training_time)";
	  
		  } 
		
	}
	if($post_stat=='P1')
	{
		$Message=" concat(p1_name,' PIN -',p1_personcd), p1_mobno ";
		 if($type_details=='D')
		  {
			  $Message.= ", concat('$text_msg', '(',p1_post_stat,') dc venue:',dc_venue,' dc date: ',dc_date,' dc time: ',dc_time,' rc venue:',rc_venue)";
		  }
		  else if($type_details=='T')
		  {
			  $Message.= ", concat('$text_msg', '(',p1_post_stat,') venue :',training_venue,' date: ',training_date,' time: ',training_time)";
	  
		  } 
		
	}
	if($post_stat=='P2')
	{
		$Message=" concat(p2_name,' PIN -',p2_personcd), p2_mobno ";
		 if($type_details=='D')
		  {
			  $Message.= ", concat('$text_msg', '(',p2_post_stat,') dc venue:',dc_venue,' dc date: ',dc_date,' dc time: ',dc_time,' rc venue:',rc_venue)";
		  }
		  else if($type_details=='T')
		  {
			  $Message.= ", concat('$text_msg', '(',p2_post_stat,') venue :',training_venue,' date: ',training_date,' time: ',training_time)";
	  
		  } 
		
	}
	if($post_stat=='P3')
	{
		$Message=" concat(p1_name,' PIN -',p3_personcd), p3_mobno ";
		 if($type_details=='D')
		  {
			  $Message.= ", concat('$text_msg', '(',p3_post_stat,') dc venue:',dc_venue,' dc date: ',dc_date,' dc time: ',dc_time,' rc venue:',rc_venue)";
		  }
		  else if($type_details=='T')
		  {
			  $Message.= ", concat('$text_msg', '(',p3_post_stat,') venue :',training_venue,' date: ',training_date,' time: ',training_time)";
	  
		  } 
		
	}
	if($post_stat=='PA')
	{
		$Message=" concat(pa_name,' PIN -',pa_personcd), pa_mobno ";
		 if($type_details=='D')
		  {
			  $Message.= ", concat('$text_msg', '(',pa_post_stat,') dc venue:',dc_venue,' dc date: ',dc_date,' dc time: ',dc_time,' rc venue:',rc_venue)";
		  }
		  else if($type_details=='T')
		  {
			  $Message.= ", concat('$text_msg', '(',pa_post_stat,') venue :',training_venue,' date: ',training_date,' time: ',training_time)";
	  
		  } 
		
	}
	if($post_stat=='PB')
	{
		$Message=" concat(pb_name,' PIN -',pb_personcd), pb_mobno ";
		 if($type_details=='D')
		  {
			  $Message.= ", concat('$text_msg', '(',pb_post_stat,') dc venue:',dc_venue,' dc date: ',dc_date,' dc time: ',dc_time,' rc venue:',rc_venue)";
		  }
		  else if($type_details=='T')
		  {
			  $Message.= ", concat('$text_msg', '(',pb_post_stat,') venue :',training_venue,' date: ',training_date,' time: ',training_time)";
	  
		  } 
		
	}
	
	$sql="Insert into tblsms2 (name,phone_no,message) 		
		  SELECT 
		  $Message
		  
		  from second_appt
		  where second_appt.subdivcd = '$Subdivision' ";
		  if($post_stat!='' && $post_stat!='0')
		  $sql.=" and second_appt.per_poststat='$post_stat'";
		//echo $sql;
		//exit;
		  $rs=execSelect($sql);		
		  connection_close();
		  //return $rs;
	  
	  $sql1="select count(*) as cnt  from tblsms2";
	  $rs1=execSelect($sql1);
	  $row1=getRows($rs1);
	  $amount1=$row1['cnt'];
	  connection_close();
	  return $amount1;
}
//from second appt reserve//
function fetch_second_appt_reserve_member_available($post_stat,$Subdivision,$type_details,$text_msg)
{
	$Message=" concat(second_rand_table_reserve.person_name,' PIN -',second_rand_table_reserve.personcd), mob_no ";
		 if($type_details=='D')
		  {
			  $Message.= ", concat('$text_msg', '(',second_rand_table_reserve.post_stat,') dc venue:',dc_venue,' dc date: ',dc_date,' dc time: ',dc_time,' rc venue:',rc_venue)";
		  }
		  else if($type_details=='T')
		  {
			  $Message.= ", concat('$text_msg', '(',second_rand_table_reserve.post_stat,') venue :',training_venue,' date: ',training_date,' time: ',training_time)";
	  
		  } 
	
	$sql="Insert into tblsms2 (name,phone_no,message) 		
		  SELECT 
		  $Message
		  
		  from second_rand_table_reserve
		  Inner Join personnela on personnela.personcd = second_rand_table_reserve.personcd
		  where second_rand_table_reserve.subdivisioncd = '$Subdivision' ";
		  if($post_stat!='' && $post_stat!='0')
		  $sql.=" and second_rand_table_reserve.post_status='$post_stat'";
		//echo $sql;
		//exit;
		  $rs=execSelect($sql);		
		  connection_close();
		  //return $rs;
	  
	  $sql1="select count(*) as cnt  from tblsms2";
	  $rs1=execSelect($sql1);
	  $row1=getRows($rs1);
	  $amount1=$row1['cnt'];
	  connection_close();
	  return $amount1;
}
/*function first_rand_member_available($post_stat,$subdiv,$phase,$chkextrapp)
{
	if($chkextrapp=='on')
	{
		$sql="SELECT first_rand_table.officer_name,first_rand_table.poststatus,first_rand_table.mob_no,first_rand_table.venuename,first_rand_table.training_dt,first_rand_table.training_time,first_rand_table.acno,first_rand_table.partno,first_rand_table.slno,first_rand_table.epic,first_rand_table.bank,first_rand_table.bank_accno,first_rand_table.ifsc,first_rand_table.personcd from first_rand_table 
		Inner Join personnela On personnela.personcd = first_rand_table.personcd
		where personnela.forsubdivision = '$subdiv' and personnela.ttrgschcopy='$phase' and personnela.booked='P' And personnela.selected = 1 and personnela.poststat='$post_stat'";
		$rs=execSelect($sql);
		connection_close();
		return $rs;
	}
	else
	{
		$sql="SELECT first_rand_table.officer_name,first_rand_table.poststatus,first_rand_table.mob_no,first_rand_table.venuename,first_rand_table.training_dt,first_rand_table.training_time,first_rand_table.acno,first_rand_table.partno,first_rand_table.slno,first_rand_table.epic,first_rand_table.bank,first_rand_table.bank_accno,first_rand_table.ifsc,first_rand_table.personcd from first_rand_table 
		Inner Join personnela On personnela.personcd = first_rand_table.personcd
		where personnela.forsubdivision = '$subdiv' and (personnela.ttrgschcopy is Null or personnela.ttrgschcopy='0') And personnela.selected = 1 and personnela.poststat='$post_stat'";
		$rs=execSelect($sql);
		connection_close();
		return $rs;
	}
}*/
?>