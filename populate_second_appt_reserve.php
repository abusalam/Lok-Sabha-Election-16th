<?php
date_default_timezone_set('Asia/Calcutta');
include_once('inc/db_trans.inc.php');
$subdiv_cd=isset($_GET['subdiv_cd'])?$_GET['subdiv_cd']:"";
$dist_cd=isset($_GET['dist'])?$_GET['dist']:"";
//$pc_cd='39'; 
$sql0="delete from second_rand_table_reserve where subdivisioncd='$subdiv_cd' ";
$i=execDelete($sql0);


//Update Training in Personnela
$sql191="update personnela 
set personnela.training2_sch=NULL
where forsubdivision='$subdiv_cd' and  personnela.booked = 'R'";
$i=execUpdate($sql191);

$sql192="update personnela join second_training on personnela.forsubdivision=second_training.for_subdiv and personnela.forassembly=second_training.assembly
set personnela.training2_sch=second_training.schedule_cd
where second_training.party_reserve='R' and personnela.groupid>=second_training.start_sl and personnela.groupid<=second_training.end_sl and second_training.for_subdiv='$subdiv_cd' and  personnela.booked = 'R'";
$i=execUpdate($sql192);


//insert data into second_rand_table_reserve
$sql01="insert into second_rand_table_reserve (groupid,assemblycd,subdivisioncd,pccd,personcd,person_name,person_designation,post_status,officecd,districtcd,dcrccd, training_schd) select groupid,forassembly, forsubdivision,' ',personcd,officer_name,off_desg,poststat,officecd,districtcd,dcrccd,training2_sch from personnela where booked='R' and forsubdivision='$subdiv_cd' and training2_sch is not null";
$i=execInsert($sql01);

//update office details
$sql8="UPDATE second_rand_table_reserve JOIN office ON second_rand_table_reserve.officecd = office.officecd   
SET  second_rand_table_reserve.office_name =  office.office,second_rand_table_reserve.office_address= concat(office.address1,',',office.address2),second_rand_table_reserve.post_office=office.postoffice,second_rand_table_reserve.pincode=office.pin, second_rand_table_reserve.subdivision=office.subdivisioncd,second_rand_table_reserve.block_muni_cd=office.blockormuni_cd WHERE second_rand_table_reserve.subdivisioncd='$subdiv_cd'";
$i=execUpdate($sql8);

//update post status
$sql81="UPDATE second_rand_table_reserve   
SET second_rand_table_reserve.post_stat='Presiding Officer' WHERE second_rand_table_reserve.subdivisioncd='$subdiv_cd' and second_rand_table_reserve.post_status = 'PR'";
$i=execUpdate($sql81);

$sql82="UPDATE second_rand_table_reserve   
SET second_rand_table_reserve.post_stat='1st Polling Officer' WHERE second_rand_table_reserve.subdivisioncd='$subdiv_cd' and second_rand_table_reserve.post_status = 'P1'";
$i=execUpdate($sql82);

$sql83="UPDATE second_rand_table_reserve   
SET second_rand_table_reserve.post_stat='2nd Polling Officer' WHERE second_rand_table_reserve.subdivisioncd='$subdiv_cd' and second_rand_table_reserve.post_status = 'P2'";
$i=execUpdate($sql83);

$sql84="UPDATE second_rand_table_reserve   
SET second_rand_table_reserve.post_stat='3rd Polling Officer' WHERE second_rand_table_reserve.subdivisioncd='$subdiv_cd' and second_rand_table_reserve.post_status = 'P3'";
$i=execUpdate($sql84);

$sql85="UPDATE second_rand_table_reserve   
SET second_rand_table_reserve.post_stat='Addl. 2nd Polling Officer-1' WHERE second_rand_table_reserve.subdivisioncd='$subdiv_cd' and second_rand_table_reserve.post_status = 'PA'";
$i=execUpdate($sql85);

$sql86="UPDATE second_rand_table_reserve   
SET second_rand_table_reserve.post_stat='Addl. 2nd Polling Officer-2' WHERE second_rand_table_reserve.subdivisioncd='$subdiv_cd' and second_rand_table_reserve.post_status = 'PB'";
$i=execUpdate($sql86);

//update assembly

$sql21="update second_rand_table_reserve a join assembly b on a.assemblycd=b.assemblycd and a.subdivisioncd=b.subdivisioncd  set a.assembly=b.assemblyname where a.subdivisioncd='$subdiv_cd'";
$i=execUpdate($sql21);

//update DCRC details

$sql16="UPDATE second_rand_table_reserve JOIN dcrcmaster  ON second_rand_table_reserve.dcrccd=dcrcmaster.dcrcgrp and  dcrcmaster.assemblycd=second_rand_table_reserve.assemblycd   SET second_rand_table_reserve.dc_venue = dcrcmaster.dc_venue, second_rand_table_reserve.dc_address = dcrcmaster.dc_addr,second_rand_table_reserve.rc_venue = dcrcmaster.rcvenue ";
$i=execUpdate($sql16);


$sql18="update  second_rand_table_reserve JOIN dcrc_party on  second_rand_table_reserve.dcrccd=dcrc_party.dcrcgrp and  
second_rand_table_reserve.subdivisioncd=dcrc_party.subdivisioncd set  second_rand_table_reserve.dc_time=dcrc_party.dc_time, 
second_rand_table_reserve.dc_date=DATE(dcrc_party.dc_date)";
$i=execUpdate($sql18);

//update second training details

$sql19="update second_rand_table_reserve join second_training on 
second_rand_table_reserve.subdivisioncd=second_training.for_subdiv and second_rand_table_reserve.training_schd=second_training.schedule_cd

set second_rand_table_reserve.traingcode=second_training.schedule_cd, second_rand_table_reserve.venuecode=second_training.training_venue , second_rand_table_reserve.training_date=second_training.training_dt, second_rand_table_reserve.training_time=second_training.training_time 
where second_rand_table_reserve.subdivisioncd='$subdiv_cd'";
$i=execUpdate($sql19);

//update second training venu details

$sql20="UPDATE second_rand_table_reserve a  JOIN training_venue_2 b ON a.venuecode=b.venue_cd SET  a.`training_venue` = b.venuename,a.`venue_addr1` =b.venueaddress1,  a.`venue_addr2`=b.venueaddress2 where a.	subdivisioncd='$subdiv_cd'";
$i=execUpdate($sql20);

$sql21="update second_rand_table_reserve a 
Inner join assembly on assembly.assemblycd=a.assemblycd and assembly.subdivisioncd=a.subdivisioncd
Inner join pc b on assembly.pccd=b.pccd
set a.pcname=b.pcname,a.pccd=b.pccd where a.subdivisioncd='$subdiv_cd'";
$i=execUpdate($sql21);

$sql22="update second_rand_table_reserve a join subdivision b on a.subdivision=b.subdivisioncd set a.subdivision=b.subdivision where a.subdivisioncd='$subdiv_cd'";
$i=execUpdate($sql22);
$sql23="update second_rand_table_reserve a join block_muni b on a.block_muni_cd=b.blockminicd set a.block_muni_name=b.blockmuni where a.subdivisioncd='$subdiv_cd'";
$i=execUpdate($sql23);

$sql271="update second_rand_table_reserve a join poll_table b on a.assemblycd=b.assembly_cd set a.polldate=b.poll_date, a.polltime=b.poll_time  where a.assemblycd=b.assembly_cd";
$i=execUpdate($sql271);

$sql272="update second_rand_table_reserve a join district b on a.districtcd=b.districtcd set a.district=b.district";
$i=execUpdate($sql272);

echo "<div class='alert-success'>Completed</div>";
?>

