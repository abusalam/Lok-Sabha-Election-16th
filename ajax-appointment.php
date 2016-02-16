<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/appointment_fun.php');

$opn=$_GET['opn'];
if($opn=='office')
{
	$sub_div=$_GET['sub_div'];
	echo "<select id='office' name='office' style='width:240px;' onchange='return office_change(this.value);'>\n";
	$rsOfc=fatch_Office_ag_subdiv($sub_div);
	$num_rows=rowCount($rsOfc);
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Office-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowOfc=getRows($rsOfc);
			echo "<option value='$rowOfc[0]'>$rowOfc[1]</option>\n";
			$rowOfc=null;
		}
	}
	$rsOfc=null;
	$num_rows=0;
	echo "</select>";
}
if($opn=='for_sub_emp_office')
{
	include_once('function/ofc_fun.php');
	$sub_div=$_GET['sub_div'];
	echo "<select id='office' name='office' style='width:240px;' onchange='return office_change(this.value);'>\n";
	$rsOfc=office_details_ag_forsub($sub_div,'-1','');
	$num_rows=rowCount($rsOfc);
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Office-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowOfc=getRows($rsOfc);
			echo "<option value='$rowOfc[0]'>$rowOfc[2]</option>\n";
			$rowOfc=null;
		}
	}
	$rsOfc=null;
	$num_rows=0;
	echo "</select>";
}
if($opn=='personnel')
{
	$office=$_GET['office'];
	$sub_div=$_GET['sub_div'];
	$rsPer=fatch_personnel_ag_office($sub_div,$office);
	$num_rows=rowCount($rsPer);
	if($num_rows>0)
	{
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowPer=getRows($rsPer);
			echo "\n<input type='checkbox' id='chkbox$i' name='chkbox$i' /><label for='chkbox$i'>$rowPer[0]</label><br>\n";
			echo "<input type='hidden' name='hidId$i' value='$rowPer[0]' />";
			$rowPer=null;
		}
	}
	$rsPer=null;
	$num_rows=0;
}
if($opn=='assembly_sec')
{
	$pc=isset($_GET['pc'])?$_GET['pc']:"";
	$sub_div=$_GET['sub_div'];

	echo "<select id='assembly' name='assembly' style='width:180px;' onchange='javascript:return member_available()'>\n";
	include_once('function/add_fun.php');
	//$rsAssembly=fatch_assembly_ag_pc($pc,$sub_div);
	$rsAssembly=fatch_assembly_ag_pc($pc,$sub_div);
	$num_rows = rowCount($rsAssembly);
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Assembly-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowAssembly=getRows($rsAssembly);
			echo "<option value='$rowAssembly[assemblycd]'>$rowAssembly[assemblyname]</option>\n";
		}
	}
	$rsAssembly=null;
	$num_rows=0;
	$rowAssembly=null;
	echo "</select>";
}
if($opn=='assembly')
{
	$pc=isset($_GET['pc'])?$_GET['pc']:"";
	$sub_div=$_GET['sub_div'];

	echo "<select id='assembly' name='assembly' style='width:180px;'>\n";
	include_once('function/add_fun.php');
	//$rsAssembly=fatch_assembly_ag_pc($pc,$sub_div);
	$rsAssembly=fatch_assembly_ag_pc($pc,$sub_div);
	$num_rows = rowCount($rsAssembly);
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Assembly-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowAssembly=getRows($rsAssembly);
			echo "<option value='$rowAssembly[assemblycd]'>$rowAssembly[assemblyname]</option>\n";
		}
	}
	$rsAssembly=null;
	$num_rows=0;
	$rowAssembly=null;
	echo "</select>";
}

if($opn=='app_replacement')
{
	$per_cd=$_GET['p_id'];
	$usercd=$_GET['usercd'];
	$str_per_code=$_GET['old_p_id'];
	include_once('function/appointment_fun.php');
/*
	delete_temp_app_letter($usercd);
	$count=0;
	include_once('inc/commit_con.php');
	mysqli_autocommit($link,FALSE);
	$sql1="insert into tmp_app_let (per_code,usercode) values (?,?)";
	$stmt = mysqli_prepare($link, $sql1);
	mysqli_stmt_bind_param($stmt, 'si', $per_cd,$usercd);
	mysqli_stmt_execute($stmt);

	if (!mysqli_commit($link)) {
		print("Transaction commit failed\n");
		exit();
	}
	mysqli_stmt_close($stmt);
	mysqli_close($link);
	
	
	
	
	//echo $str_per_code;
	//exit;

	$del_ret=delete_prev_data_single($str_per_code);
	
	$del_ret1=delete_prev_data_single($per_cd);
	
	$rsId=fetch_id_temp_app_letter($usercd);
	$num_row1=rowCount($rsId);
	if($num_row1>0)
	{
	  $rsApp=first_appointment_letter_hdr($per_cd);
	  $num_rows=rowCount($rsApp);
	 // $n=0; 
	  if($num_rows>0)
	  {
		for($i=1;$i<=$num_rows;$i++)
		{
		
			$rowApp=getRows($rsApp);
			
			$officer_name=$rowApp['officer_name'];
			$person_desig=$rowApp['person_desig'];
			$personcd=$rowApp['personcd'];
			$office=$rowApp['office'];
			$office_address=$rowApp['address1'].", ".$rowApp['address2'];
			$block_muni=$rowApp['blockormuni_cd'];
			$postoffice=$rowApp['postoffice'];
			$subdivision=$rowApp['subdivision'];
			$policestation=$rowApp['policestation'];
			$district=$rowApp['district'];
			$pin=$rowApp['pin'];
			$officecd=$rowApp['officecd'];
			$poststatus=$rowApp['poststatus'];
			$mob_no=$rowApp['mob_no'];
			
			$training_desc=$rowApp['training_desc'];
			$venuename=$rowApp['venuename'];
			$venue_add=$rowApp['venueaddress1'].", ".$rowApp['venueaddress2'];
			$training_dt=$rowApp['training_dt'];
			$training_time=$rowApp['training_time'];	
			
			$forpc=$rowApp['forpc'];
			$pcname="";
			$epic=$rowApp['epic'];
			$acno=$rowApp['acno'];
			$partno=$rowApp['partno'];
			$slno=$rowApp['slno'];
			$bank_name=$rowApp['bank_name'];
			$branch_name=$rowApp['branch_name'];
			$bank_acc_no=$rowApp['bank_acc_no'];
			$ifsc_code=$rowApp['ifsc_code'];
			$forsubdivision=$rowApp['forsubdivision'];
			$token=substr($rowApp['pp_subdivision'], 0, 4)."/".$rowApp['post_stat']."/".$rowApp['token'];
			
			
			insert_into_first_rand_table($officer_name,$person_desig,$personcd,$office,$office_address,$block_muni,$postoffice,$subdivision,$policestation,$district,$pin,$officecd,$poststatus,$mob_no,$training_desc,$venuename,$venue_add,$training_dt,$training_time,$forpc,$pcname,$forsubdivision,$epic,$acno,$partno,$slno,$bank_name,$branch_name,$bank_acc_no,$ifsc_code,$token);
			
		}
		
		unset($rsApp,$num_rows,$rowApp);
	  }
	}*/
//	if($count<($i-1))
	//{
		//$percd=encode($per_cd);
		//echo "fpdf/first-appointment-letter-peridwise.php?percd=$percd";
		echo "fpdf/training-app-letter.php";
	//}
}

if($opn=='gp_replacement')
{
	$poststat=isset($_GET["poststat"])?$_GET["poststat"]:"";
	$per_cd=isset($_GET["p_id"])?$_GET["p_id"]:"";
	$booked=isset($_GET["booked"])?$_GET["booked"]:"";
	$pc_cd=isset($_GET["forpc"])?$_GET["forpc"]:"";
	$forassembly=isset($_GET["forassembly"])?$_GET["forassembly"]:"";
	$groupid=isset($_GET["groupid"])?$_GET["groupid"]:"";
	include_once('function/appointment_fun.php');

	$sql0="delete from second_appt where assembly='$forassembly' and groupid='$groupid'";
$a=execDelete($sql0);

$sql1="INSERT INTO second_appt( assembly, subdivcd, groupid ,mem_no)  SELECT  forassembly, forsubdivision, groupid,count(*)  FROM personnela WHERE booked = 'P' and forassembly='$forassembly' and groupid='$groupid' GROUP BY forassembly, groupid ";
$b=execInsert($sql1);

//================================Personnel join=================================//

$sql2="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly and second_appt.groupid=personnela.groupid
  SET second_appt.pr_personcd = personnela.personcd,second_appt.pr_name = personnela.officer_name,second_appt.`pr_designation` =personnela.off_desg,second_appt.`pr_officecd`= personnela.officecd,second_appt.`pr_status`='PR',second_appt.pr_post_stat='Presiding Officer',second_appt.pr_mobno =personnela.mob_no
WHERE personnela.booked = 'P'  and personnela.poststat = 'PR' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
$c=execUpdate($sql2);

$sql3="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.p1_personcd = personnela.personcd,second_appt.p1_name = personnela.officer_name,second_appt.`p1_designation`=personnela.off_desg,second_appt.`p1_officecd`=personnela.officecd, second_appt.`p1_status`='P1',second_appt.p1_post_stat='1st Polling Officer',second_appt.p1_mobno =personnela.mob_no 
WHERE  personnela.booked = 'P' and personnela.poststat = 'P1' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
$d=execUpdate($sql3);

$sql4="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.p2_personcd = personnela.personcd,second_appt.p2_name = personnela.officer_name,second_appt.`p2_designation` 
=personnela.off_desg,second_appt.`p2_officecd`= personnela.officecd,second_appt.`p2_status`='P2',second_appt.p2_post_stat='2nd Polling Officer',second_appt.p2_mobno =personnela.mob_no
WHERE personnela.booked = 'P'  and personnela.poststat = 'P2' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
$e=execUpdate($sql4);

$sql5="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.p3_personcd = personnela.personcd,second_appt.p3_name = personnela.officer_name,second_appt.`p3_designation` 
=personnela.off_desg,second_appt.`p3_officecd`= personnela.officecd,second_appt.`p3_status`='P3',second_appt.p3_post_stat='3rd Polling Officer',second_appt.p3_mobno =personnela.mob_no
WHERE  personnela.booked = 'P'  and personnela.poststat = 'P3' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
$f=execUpdate($sql5);

$sql6="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.pa_personcd = personnela.personcd,second_appt.pa_name = personnela.officer_name,second_appt.`pa_designation`=personnela.off_desg, second_appt.`pa_officecd`= personnela.officecd,second_appt.`pa_status`='PA', second_appt.pa_post_stat='Addl. 2nd Polling Officer-1' ,second_appt.pa_mobno =personnela.mob_no
WHERE personnela.booked = 'P'  and personnela.poststat = 'PA' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
$g=execUpdate($sql6);

$sql7="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.pb_personcd = personnela.personcd,second_appt.pb_name = personnela.officer_name,second_appt.`pb_designation`=personnela.off_desg,second_appt.`pb_officecd`= personnela.officecd,second_appt.`pb_status`='PB',second_appt.pa_post_stat='Addl. 2nd Polling Officer-2' ,second_appt.pb_mobno =personnela.mob_no
WHERE personnela.booked = 'P'  and personnela.poststat = 'PB' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
$h=execUpdate($sql7);
//================================end of personnel join=======================//

//================================office join=================================//
$sql8="UPDATE second_appt JOIN office ON second_appt.pr_officecd = office.officecd   SET  second_appt.pr_officename =  office.office,second_appt.`pr_officeaddress`= concat(office.address1,',',office.address2),second_appt.pr_postoffice=office.postoffice,second_appt.pr_pincode=office.pin, second_appt.pr_subdivision=office.subdivisioncd WHERE second_appt.pr_status = 'PR' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$i=execUpdate($sql8);

$sql9="UPDATE second_appt JOIN office ON second_appt.p1_officecd = office.officecd   SET  second_appt.p1_officename =  office.office,second_appt.`p1_officeaddress`= concat(office.address1,',',office.address2),second_appt.p1_postoffice=office.postoffice,second_appt.p1_pincode=office.pin ,second_appt.p1_subdivision=office.subdivisioncd WHERE second_appt.p1_status = 'P1' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$j=execUpdate($sql9);

$sql10="UPDATE second_appt JOIN office ON second_appt.p2_officecd = office.officecd   SET  second_appt.p2_officename =  office.office,second_appt.`p2_officeaddress`= concat(office.address1,',',office.address2),second_appt.p2_postoffice=office.postoffice,second_appt.p2_pincode=office.pin,second_appt.p2_subdivision=office.subdivisioncd  WHERE second_appt.p2_status = 'P2' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$k=execUpdate($sql10);

$sql11="UPDATE second_appt JOIN office ON second_appt.p3_officecd = office.officecd   SET  second_appt.p3_officename =  office.office,second_appt.`p3_officeaddress`= concat(office.address1,',',office.address2),second_appt.p3_postoffice=office.postoffice,second_appt.p3_pincode=office.pin, second_appt.p3_subdivision=office.subdivisioncd WHERE second_appt.p3_status = 'P3' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$l=execUpdate($sql11);

$sql12="UPDATE second_appt JOIN office ON second_appt.pa_officecd = office.officecd   SET  second_appt.pa_officename =  office.office,second_appt.`pa_officeaddress`= concat(office.address1,',',office.address2),second_appt.pa_postoffice=office.postoffice,second_appt.pa_pincode=office.pin , second_appt.pa_subdivision=office.subdivisioncd WHERE second_appt.pa_status = 'PA' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$m=execUpdate($sql12);

$sql13="UPDATE second_appt JOIN office ON second_appt.pb_officecd = office.officecd   SET  second_appt.pb_officename =  office.office,second_appt.`pb_officeaddress`= concat(office.address1,',',office.address2),second_appt.pb_postoffice=office.postoffice,second_appt.pb_pincode=office.pin, second_appt.pb_subdivision=office.subdivisioncd WHERE second_appt.pb_status = 'PB' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$n=execUpdate($sql13);
//================================End of office join=================================//

//================================Start DCRC join====================================//

$sql14="UPDATE second_appt JOIN grp_dcrc ON second_appt.assembly=grp_dcrc.forassembly  and 
second_appt.groupid=grp_dcrc.groupid  SET second_appt.dcrcgrp = grp_dcrc.dcrccd
WHERE  grp_dcrc.forassembly='$forassembly' and grp_dcrc.groupid='$groupid'";
$o=execUpdate($sql14);

$sql16="UPDATE second_appt JOIN dcrcmaster  ON second_appt.dcrcgrp=dcrcmaster.dcrcgrp and  dcrcmaster.assemblycd=second_appt.assembly   SET second_appt.dc_venue = dcrcmaster.dc_venue, second_appt.dc_address = dcrcmaster.dc_addr,second_appt.rc_venue = dcrcmaster.rcvenue where second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$p=execUpdate($sql16);

$sql18="update  second_appt JOIN dcrc_party on  second_appt.dcrcgrp=dcrc_party.dcrcgrp and  
second_appt.subdivcd=dcrc_party.subdivisioncd set  second_appt.dc_time=dcrc_party.dc_time, 
second_appt.dc_date=DATE(dcrc_party.dc_date) where second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$q=execUpdate($sql18);
//==================================END of DCRC join=============================================//

//=================================Start of Training==============================================//
$sql19="update second_appt join second_training on second_appt.subdivcd=second_training.for_subdiv and second_appt.assembly=second_training.assembly set second_appt.traingcode=second_training.schedule_cd, second_appt.venuecode=second_training.training_venue , second_appt.training_date=second_training.training_dt, second_appt.training_time=second_training.training_time where second_training.party_reserve='P' and second_appt.groupid>=second_training.start_sl and second_appt.groupid<=second_training.end_sl and second_training.assembly='$forassembly' and second_appt.groupid='$groupid'";
$r=execUpdate($sql19);

$sql20="UPDATE second_appt a  JOIN training_venue_2 b ON a.venuecode=b.venue_cd SET  a.`training_venue` =b.venuename,a.`venue_addr1` =b.venueaddress1,  a.`venue_addr2`=b.venueaddress2 where a.assembly='$forassembly' and a.groupid='$groupid'";
$s=execUpdate($sql20);
//=================================END of Training==============================================//

$sql21="update second_appt a join assembly b on a.assembly=b.assemblycd set a.assembly_name=b.assemblyname where   a.assembly='$forassembly' and a.groupid='$groupid'";
$t=execUpdate($sql21);

//$sql21="update second_appt a join  pc b on a.pccd=b.pccd set a.pcname=b.pcname where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
//$u=execUpdate($sql21);

$sql22="update second_appt a join subdivision b on a.pr_subdivision=b.subdivisioncd set a.pr_subdivision=b.subdivision where  a.assembly='$forassembly' and a.groupid='$groupid'";
$v=execUpdate($sql22);

$sql23="update second_appt a join subdivision b on a.p1_subdivision=b.subdivisioncd set a.p1_subdivision=b.subdivision where  a.assembly='$forassembly' and a.groupid='$groupid'";
$w=execUpdate($sql23);
$sql24="update second_appt a join subdivision b on a.p2_subdivision=b.subdivisioncd set a.p2_subdivision=b.subdivision where a.assembly='$forassembly' and a.groupid='$groupid'";
$x=execUpdate($sql24);

$sql25="update second_appt a join subdivision b on a.p3_subdivision=b.subdivisioncd set a.p3_subdivision=b.subdivision where a.assembly='$forassembly' and a.groupid='$groupid'";
$y=execUpdate($sql25);

$sql26="update second_appt a join subdivision b on a.pa_subdivision=b.subdivisioncd set a.pa_subdivision=b.subdivision where a.assembly='$forassembly' and a.groupid='$groupid'";
$z=execUpdate($sql26);

$sql27="update second_appt a join subdivision b on a.pb_subdivision=b.subdivisioncd set a.pb_subdivision=b.subdivision where a.assembly='$forassembly' and a.groupid='$groupid'";
$a1=execUpdate($sql27);

$sql271="update second_appt a join poll_table b on a.assembly=b.assembly_cd set a.polldate=b.poll_date, a.polltime=b.poll_time where a.assembly='$forassembly' and a.groupid='$groupid'";
$b1=execUpdate($sql271);

$sql272="update second_appt a join district b on substr(a.dcrcgrp,1,2)=b.districtcd set a.district=b.district  where a.assembly='$forassembly' and a.groupid='$groupid'";
$c1=execUpdate($sql272);

if($poststat=='PR')
{
	$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.pr_officecd, second_appt.per_poststat= a.pr_status where a.assembly='$forassembly' and a.groupid='$groupid'";
	$d1=execUpdate($sql28);
}
if($poststat=='P1')
{
	$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.p1_officecd, second_appt.per_poststat= a.p1_status where  a.assembly='$forassembly' and a.groupid='$groupid'";
	$d1=execUpdate($sql28);
}
if($poststat=='P2')
{
	$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.p2_officecd, second_appt.per_poststat= a.p2_status where  a.assembly='$forassembly' and a.groupid='$groupid'";
	$d1=execUpdate($sql28);
}
if($poststat=='P3')
{
	$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.p3_officecd, second_appt.per_poststat= a.p3_status where a.assembly='$forassembly' and a.groupid='$groupid'";
	$d1=execUpdate($sql28);
}
if($poststat=='PA')
{
	$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.pa_officecd, second_appt.per_poststat= a.pa_status where a.assembly='$forassembly' and a.groupid='$groupid'";
	$d1=execUpdate($sql28);
}
if($poststat=='PB')
{
	$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.pb_officecd, second_appt.per_poststat= a.pb_status where  a.assembly='$forassembly' and a.groupid='$groupid'";
	$d1=execUpdate($sql28);
}

/*	if($count<($i-1))
	{
		echo $a."-".$b."-".$c."-".$d."-".$e."-".$f."-".$g."-".$h."-".$i."-".$j."-".$k."-".$l."-".$m."-".$n."-".$o."-".$p."-".$q."-".$r."-".$s."-".$t."-".$u."-".$v."-".$w."-".$x."-".$y."-".$z."-".$a1."-".$b1."-".$c1."-".$d1;
	}
*/	
    $g_id=encode($groupid);
	$f_asm=encode($forassembly);
	$subd='';
	
	echo "fpdf/2nd-app-letter.php?sub=".$subd."&txtfrom=0&txtto=0&group_id=".$g_id."&assembly=".$f_asm;
}

if($opn=='gp_replacement1')
{
	$poststat=isset($_GET["poststat"])?$_GET["poststat"]:"";
	$per_cd=isset($_GET["p_id"])?$_GET["p_id"]:"";
	$booked=isset($_GET["booked"])?$_GET["booked"]:"";
	$pc_cd=isset($_GET["forpc"])?$_GET["forpc"]:"";
	$forassembly=isset($_GET["forassembly"])?$_GET["forassembly"]:"";
	$groupid=isset($_GET["groupid"])?$_GET["groupid"]:"";
	
	/*$poststat=$_GET['poststat'];
	$per_cd=$_GET['p_id'];
	$booked=$_GET['booked'];
	$pc_cd=$_GET['forpc'];
	$forassembly=$_GET['forassembly'];
	$groupid=$_GET['groupid'];*/
	include_once('function/appointment_fun.php');

	$sql0="delete from second_appt where pccd='$pc_cd' and assembly='$forassembly' and groupid='$groupid'";
$a=execDelete($sql0);

$sql1="INSERT INTO second_appt( assembly, pccd, groupid ,mem_no)  SELECT  forassembly, forpc, groupid,count(*)  FROM personnela WHERE booked = 'P'  and forpc='$pc_cd' and forassembly='$forassembly' and groupid='$groupid' GROUP BY forassembly, groupid ";
$b=execInsert($sql1);

$sql2="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly and second_appt.groupid=personnela.groupid
  SET second_appt.pr_personcd = personnela.personcd,second_appt.pr_name = personnela.officer_name,second_appt.`pr_designation` =personnela.off_desg,second_appt.`pr_officecd`= personnela.officecd,second_appt.`pr_status`='PR',second_appt.pr_post_stat='Presiding Officer'
WHERE personnela.forpc = '$pc_cd' and  personnela.booked = 'P'  and personnela.poststat = 'PR' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
$c=execUpdate($sql2);

$sql3="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.p1_personcd = personnela.personcd,second_appt.p1_name = personnela.officer_name,second_appt.`p1_designation`=personnela.off_desg,second_appt.`p1_officecd`=personnela.officecd, second_appt.`p1_status`='P1',second_appt.p1_post_stat='1st Polling Officer' 
WHERE personnela.forpc = '$pc_cd' and  personnela.booked = 'P' and personnela.poststat = 'P1' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
$d=execUpdate($sql3);

$sql4="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.p2_personcd = personnela.personcd,second_appt.p2_name = personnela.officer_name,second_appt.`p2_designation` 
=personnela.off_desg,second_appt.`p2_officecd`= personnela.officecd,second_appt.`p2_status`='P2',second_appt.p2_post_stat='2nd Polling Officer'
WHERE personnela.forpc = '$pc_cd' and  personnela.booked = 'P'  and personnela.poststat = 'P2' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
$e=execUpdate($sql4);

$sql5="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.p3_personcd = personnela.personcd,second_appt.p3_name = personnela.officer_name,second_appt.`p3_designation` 
=personnela.off_desg,second_appt.`p3_officecd`= personnela.officecd,second_appt.`p3_status`='P3',second_appt.p3_post_stat='3rd Polling Officer'
WHERE personnela.forpc = '$pc_cd' and  personnela.booked = 'P'  and personnela.poststat = 'P3' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
$f=execUpdate($sql5);

$sql6="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.pa_personcd = personnela.personcd,second_appt.pa_name = personnela.officer_name,second_appt.`pa_designation`=personnela.off_desg, second_appt.`pa_officecd`= personnela.officecd,second_appt.`pa_status`='PA', second_appt.pa_post_stat='Addl. 2nd Polling Officer-1' 
WHERE personnela.forpc = '$pc_cd' and  personnela.booked = 'P'  and personnela.poststat = 'PA' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
$g=execUpdate($sql6);

$sql7="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.pb_personcd = personnela.personcd,second_appt.pb_name = personnela.officer_name,second_appt.`pb_designation`=personnela.off_desg,second_appt.`pb_officecd`= personnela.officecd,second_appt.`pb_status`='PB',second_appt.pa_post_stat='Addl. 2nd Polling Officer-2' 
WHERE personnela.forpc = '$pc_cd' and  personnela.booked = 'P'  and personnela.poststat = 'PB' and personnela.forassembly='$forassembly' and personnela.groupid='$groupid'";
$h=execUpdate($sql7);

$sql8="UPDATE second_appt JOIN office ON second_appt.pr_officecd = office.officecd   SET  second_appt.pr_officename =  office.office,second_appt.`pr_officeaddress`= concat(office.address1,',',office.address2),second_appt.pr_postoffice=office.postoffice,second_appt.pr_pincode=office.pin, second_appt.pr_subdivision=office.subdivisioncd WHERE second_appt.pccd='$pc_cd' and second_appt.pr_status = 'PR' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$i=execUpdate($sql8);

$sql9="UPDATE second_appt JOIN office ON second_appt.p1_officecd = office.officecd   SET  second_appt.p1_officename =  office.office,second_appt.`p1_officeaddress`= concat(office.address1,',',office.address2),second_appt.p1_postoffice=office.postoffice,second_appt.p1_pincode=office.pin ,second_appt.p1_subdivision=office.subdivisioncd WHERE second_appt.pccd='$pc_cd' and second_appt.p1_status = 'P1' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$j=execUpdate($sql9);

$sql10="UPDATE second_appt JOIN office ON second_appt.p2_officecd = office.officecd   SET  second_appt.p2_officename =  office.office,second_appt.`p2_officeaddress`= concat(office.address1,',',office.address2),second_appt.p2_postoffice=office.postoffice,second_appt.p2_pincode=office.pin,second_appt.p2_subdivision=office.subdivisioncd  WHERE second_appt.pccd='$pc_cd' and second_appt.p2_status = 'P2' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$k=execUpdate($sql10);

$sql11="UPDATE second_appt JOIN office ON second_appt.p3_officecd = office.officecd   SET  second_appt.p3_officename =  office.office,second_appt.`p3_officeaddress`= concat(office.address1,',',office.address2),second_appt.p3_postoffice=office.postoffice,second_appt.p3_pincode=office.pin, second_appt.p3_subdivision=office.subdivisioncd WHERE second_appt.pccd='$pc_cd' and second_appt.p3_status = 'P3' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$l=execUpdate($sql11);

$sql12="UPDATE second_appt JOIN office ON second_appt.pa_officecd = office.officecd   SET  second_appt.pa_officename =  office.office,second_appt.`pa_officeaddress`= concat(office.address1,',',office.address2),second_appt.pa_postoffice=office.postoffice,second_appt.pa_pincode=office.pin , second_appt.pa_subdivision=office.subdivisioncd WHERE second_appt.pccd='$pc_cd' and second_appt.pa_status = 'PA' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$m=execUpdate($sql12);

$sql13="UPDATE second_appt JOIN office ON second_appt.pb_officecd = office.officecd   SET  second_appt.pb_officename =  office.office,second_appt.`pb_officeaddress`= concat(office.address1,',',office.address2),second_appt.pb_postoffice=office.postoffice,second_appt.pb_pincode=office.pin, second_appt.pb_subdivision=office.subdivisioncd WHERE second_appt.pccd='$pc_cd' and second_appt.pb_status = 'PB' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$n=execUpdate($sql13);

$sql14="UPDATE second_appt JOIN grp_dcrc ON second_appt.assembly=grp_dcrc.forassembly  and 
second_appt.groupid=grp_dcrc.groupid  SET second_appt.dcrcgrp = grp_dcrc.dcrccd
WHERE grp_dcrc.forpc = '$pc_cd' and grp_dcrc.forassembly='$forassembly' and grp_dcrc.groupid='$groupid'";
$o=execUpdate($sql14);

$sql16="UPDATE second_appt JOIN dcrcmaster  ON second_appt.dcrcgrp=dcrcmaster.dcrcgrp and  dcrcmaster.assemblycd=second_appt.assembly   SET second_appt.dc_venue = dcrcmaster.dc_venue, second_appt.dc_address = dcrcmaster.dc_addr,second_appt.rc_venue = dcrcmaster.rcvenue where second_appt.pccd='$pc_cd' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$p=execUpdate($sql16);

$sql18="update  second_appt JOIN dcrc_party on  second_appt.dcrcgrp=dcrc_party.dcrcgrp and  
second_appt.pccd=dcrc_party.forpc set  second_appt.dc_time=dcrc_party.dc_time, 
second_appt.dc_date=dcrc_party.dc_date where second_appt.pccd='$pc_cd' and second_appt.assembly='$forassembly' and second_appt.groupid='$groupid'";
$q=execUpdate($sql18);

$sql19="update second_appt join second_training on second_appt.pccd=second_training.for_pc and second_appt.assembly=second_training.assembly set second_appt.traingcode=second_training.schedule_cd, second_appt.venuecode=second_training.training_venue , second_appt.training_date=second_training.training_dt, second_appt.training_time=second_training.training_time where second_training.party_reserve='P' and second_appt.groupid>=second_training.start_sl and second_appt.groupid<=second_training.end_sl and second_training.for_pc='$pc_cd' and second_training.assembly='$forassembly' and second_appt.groupid='$groupid'";
$r=execUpdate($sql19);

$sql20="UPDATE second_appt a  JOIN training_venue_2 b ON a.venuecode=b.venue_cd SET  a.`training_venue` =b.venuename,a.`venue_addr1` =b.venueaddress1,  a.`venue_addr2`=b.venueaddress2 where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
$s=execUpdate($sql20);

$sql21="update second_appt a join assembly b on a.assembly=b.assemblycd set a.assembly_name=b.assemblyname where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
$t=execUpdate($sql21);

$sql21="update second_appt a join  pc b on a.pccd=b.pccd set a.pcname=b.pcname where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
$u=execUpdate($sql21);

$sql22="update second_appt a join subdivision b on a.pr_subdivision=b.subdivisioncd set a.pr_subdivision=b.subdivision where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
$v=execUpdate($sql22);

$sql23="update second_appt a join subdivision b on a.p1_subdivision=b.subdivisioncd set a.p1_subdivision=b.subdivision where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
$w=execUpdate($sql23);
$sql24="update second_appt a join subdivision b on a.p2_subdivision=b.subdivisioncd set a.p2_subdivision=b.subdivision where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
$x=execUpdate($sql24);

$sql25="update second_appt a join subdivision b on a.p3_subdivision=b.subdivisioncd set a.p3_subdivision=b.subdivision where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
$y=execUpdate($sql25);

$sql26="update second_appt a join subdivision b on a.pa_subdivision=b.subdivisioncd set a.pa_subdivision=b.subdivision where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
$z=execUpdate($sql26);

$sql27="update second_appt a join subdivision b on a.pb_subdivision=b.subdivisioncd set a.pb_subdivision=b.subdivision where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
$a1=execUpdate($sql27);

$sql271="update second_appt a join poll_table b on a.pccd=b.pc_cd set a.polldate=b.poll_date, a.polltime=b.poll_time where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
$b1=execUpdate($sql271);

$sql272="update second_appt a join district b on substr(a.dcrcgrp,1,2)=b.districtcd set a.district=b.district  where a.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
$c1=execUpdate($sql272);

if($poststat=='PR')
{
	$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.pr_officecd, second_appt.per_poststat= a.pr_status where second_appt.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
	$d1=execUpdate($sql28);
}
if($poststat=='P1')
{
	$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.p1_officecd, second_appt.per_poststat= a.p1_status where second_appt.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
	$d1=execUpdate($sql28);
}
if($poststat=='P2')
{
	$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.p2_officecd, second_appt.per_poststat= a.p2_status where second_appt.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
	$d1=execUpdate($sql28);
}
if($poststat=='P3')
{
	$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.p3_officecd, second_appt.per_poststat= a.p3_status where second_appt.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
	$d1=execUpdate($sql28);
}
if($poststat=='PA')
{
	$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.pa_officecd, second_appt.per_poststat= a.pa_status where second_appt.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
	$d1=execUpdate($sql28);
}
if($poststat=='PB')
{
	$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.pb_officecd, second_appt.per_poststat= a.pb_status where second_appt.pccd='$pc_cd' and a.assembly='$forassembly' and a.groupid='$groupid'";
	$d1=execUpdate($sql28);
}

//	if($count<($i-1))
	{
		echo $a."-".$b."-".$c."-".$d."-".$e."-".$f."-".$g."-".$h."-".$i."-".$j."-".$k."-".$l."-".$m."-".$n."-".$o."-".$p."-".$q."-".$r."-".$s."-".$t."-".$u."-".$v."-".$w."-".$x."-".$y."-".$z."-".$a1."-".$b1."-".$c1."-".$d1;
	}
}
?>