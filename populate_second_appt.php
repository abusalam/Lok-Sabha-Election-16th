<?php
date_default_timezone_set('Asia/Calcutta');
include_once('inc/db_trans.inc.php');
$subdiv_cd=isset($_GET['subdiv_cd'])?$_GET['subdiv_cd']:"";
$dist_cd=isset($_GET['dist'])?$_GET['dist']:"";
//$pc_cd='39'; 

$sql0="delete from second_appt where subdivcd='$subdiv_cd'";
$i=execDelete($sql0);
//echo $subdiv_cd;
$sql1="INSERT INTO second_appt( assembly, subdivcd, groupid ,mem_no)  SELECT  forassembly, forsubdivision, groupid,count(*)  FROM personnela WHERE booked = 'P'  and forsubdivision='$subdiv_cd'  GROUP BY forassembly, groupid ";
//echo $subdiv_cd;
$i=execInsert($sql1);
//================================Personnel join=================================//

$sql2="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly and second_appt.groupid=personnela.groupid
  SET second_appt.pr_personcd = personnela.personcd,second_appt.pr_name = personnela.officer_name,second_appt.`pr_designation` =personnela.off_desg,second_appt.`pr_officecd`= personnela.officecd,second_appt.`pr_status`='PR',second_appt.pr_post_stat='Presiding Officer',second_appt.pr_mobno =personnela.mob_no
WHERE personnela.forsubdivision = '$subdiv_cd' and  personnela.booked = 'P'  and personnela.poststat = 'PR' ";
$i=execUpdate($sql2);

$sql3="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.p1_personcd = personnela.personcd,second_appt.p1_name = personnela.officer_name,second_appt.`p1_designation`=personnela.off_desg,second_appt.`p1_officecd`=personnela.officecd, second_appt.`p1_status`='P1',second_appt.p1_post_stat='1st Polling Officer' ,second_appt.p1_mobno =personnela.mob_no
WHERE personnela.forsubdivision = '$subdiv_cd' and  personnela.booked = 'P' and personnela.poststat = 'P1'";
$i=execUpdate($sql3);

$sql4="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.p2_personcd = personnela.personcd,second_appt.p2_name = personnela.officer_name,second_appt.`p2_designation` 
=personnela.off_desg,second_appt.`p2_officecd`= personnela.officecd,second_appt.`p2_status`='P2',second_appt.p2_post_stat='2nd Polling Officer',second_appt.p2_mobno =personnela.mob_no
WHERE personnela.forsubdivision = '$subdiv_cd' and  personnela.booked = 'P'  and personnela.poststat = 'P2'";
$i=execUpdate($sql4);

$sql5="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.p3_personcd = personnela.personcd,second_appt.p3_name = personnela.officer_name,second_appt.`p3_designation` 
=personnela.off_desg,second_appt.`p3_officecd`= personnela.officecd,second_appt.`p3_status`='P3',second_appt.p3_post_stat='3rd Polling Officer',second_appt.p3_mobno =personnela.mob_no
WHERE personnela.forsubdivision = '$subdiv_cd' and  personnela.booked = 'P'  and personnela.poststat = 'P3'";
$i=execUpdate($sql5);

$sql6="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.pa_personcd = personnela.personcd,second_appt.pa_name = personnela.officer_name,second_appt.`pa_designation`=personnela.off_desg, second_appt.`pa_officecd`= personnela.officecd,second_appt.`pa_status`='PA', second_appt.pa_post_stat='Addl. 2nd Polling Officer-1' ,second_appt.pa_mobno =personnela.mob_no 
WHERE personnela.forsubdivision = '$subdiv_cd' and  personnela.booked = 'P'  and personnela.poststat = 'PA'";
$i=execUpdate($sql6);

$sql7="UPDATE second_appt JOIN personnela ON second_appt.assembly=personnela.forassembly  and 
second_appt.groupid=personnela.groupid  SET second_appt.pb_personcd = personnela.personcd,second_appt.pb_name = personnela.officer_name,second_appt.`pb_designation`=personnela.off_desg,second_appt.`pb_officecd`= personnela.officecd,second_appt.`pb_status`='PB',second_appt.pb_post_stat='Addl. 2nd Polling Officer-2' ,second_appt.pb_mobno =personnela.mob_no
WHERE personnela.forsubdivision = '$subdiv_cd' and  personnela.booked = 'P'  and personnela.poststat = 'PB'";
$i=execUpdate($sql7);
//================================end of personnel join=======================//
//echo $subdiv_cd;
//exit;
//================================office join=================================//
$sql8="UPDATE second_appt JOIN office ON second_appt.pr_officecd = office.officecd   SET  second_appt.pr_officename =  office.office,second_appt.`pr_officeaddress`= concat(office.address1,',',office.address2),second_appt.pr_postoffice=office.postoffice,second_appt.pr_pincode=office.pin, second_appt.pr_subdivision=office.subdivisioncd WHERE second_appt.subdivcd='$subdiv_cd' and second_appt.pr_status = 'PR'";
$i=execUpdate($sql8);

$sql9="UPDATE second_appt JOIN office ON second_appt.p1_officecd = office.officecd   SET  second_appt.p1_officename =  office.office,second_appt.`p1_officeaddress`= concat(office.address1,',',office.address2),second_appt.p1_postoffice=office.postoffice,second_appt.p1_pincode=office.pin ,second_appt.p1_subdivision=office.subdivisioncd WHERE second_appt.subdivcd='$subdiv_cd'  and second_appt.p1_status = 'P1' ";
$i=execUpdate($sql9);

$sql10="UPDATE second_appt JOIN office ON second_appt.p2_officecd = office.officecd   SET  second_appt.p2_officename =  office.office,second_appt.`p2_officeaddress`= concat(office.address1,',',office.address2),second_appt.p2_postoffice=office.postoffice,second_appt.p2_pincode=office.pin,second_appt.p2_subdivision=office.subdivisioncd  WHERE second_appt.subdivcd='$subdiv_cd' and second_appt.p2_status = 'P2' ";
$i=execUpdate($sql10);

$sql11="UPDATE second_appt JOIN office ON second_appt.p3_officecd = office.officecd   SET  second_appt.p3_officename =  office.office,second_appt.`p3_officeaddress`= concat(office.address1,',',office.address2),second_appt.p3_postoffice=office.postoffice,second_appt.p3_pincode=office.pin, second_appt.p3_subdivision=office.subdivisioncd WHERE second_appt.subdivcd='$subdiv_cd' and second_appt.p3_status = 'P3' ";
$i=execUpdate($sql11);

$sql12="UPDATE second_appt JOIN office ON second_appt.pa_officecd = office.officecd   SET  second_appt.pa_officename =  office.office,second_appt.`pa_officeaddress`= concat(office.address1,',',office.address2),second_appt.pa_postoffice=office.postoffice,second_appt.pa_pincode=office.pin , second_appt.pa_subdivision=office.subdivisioncd WHERE second_appt.subdivcd='$subdiv_cd' and second_appt.pa_status = 'PA' ";
$i=execUpdate($sql12);

$sql13="UPDATE second_appt JOIN office ON second_appt.pb_officecd = office.officecd   SET  second_appt.pb_officename =  office.office,second_appt.`pb_officeaddress`= concat(office.address1,',',office.address2),second_appt.pb_postoffice=office.postoffice,second_appt.pb_pincode=office.pin, second_appt.pb_subdivision=office.subdivisioncd WHERE second_appt.subdivcd='$subdiv_cd' and second_appt.pb_status = 'PB' ";
$i=execUpdate($sql13);
//================================End of office join=================================//


//echo $subdiv_cd;
$sql21="update second_appt a join assembly b on a.assembly=b.assemblycd set a.assembly_name=b.assemblyname where a.subdivcd='$subdiv_cd'";
$i=execUpdate($sql21);

//================================Start DCRC join====================================//

$sql14="UPDATE second_appt JOIN grp_dcrc ON second_appt.assembly=grp_dcrc.forassembly  and 
second_appt.groupid=grp_dcrc.groupid  SET second_appt.dcrcgrp = grp_dcrc.dcrccd
WHERE grp_dcrc.forsubdivision = '$subdiv_cd' ";
$i=execUpdate($sql14);

//$sql15="UPDATE second_appt JOIN dcrcmaster  ON second_appt.dcrcgrp=dcrcmaster.dcrcgrp and  dcrcmaster.assemblycd=second_appt.assembly   SET second_appt.dc_venue = grp_dcrc.dc_venue, second_appt.dc_address = grp_dcrc.dc_addr,second_appt.rc_venue = grp_dcrc.rcvenue
//WHERE grp_dcrc.forpc = '$pc_cd'";
//$i=execUpdate($sql15);

$sql16="UPDATE second_appt JOIN dcrcmaster  ON second_appt.dcrcgrp=dcrcmaster.dcrcgrp and  dcrcmaster.assemblycd=second_appt.assembly   SET second_appt.dc_venue = dcrcmaster.dc_venue, second_appt.dc_address = dcrcmaster.dc_addr,second_appt.rc_venue = dcrcmaster.rcvenue ";
$i=execUpdate($sql16);

//$sql17="update  second_appt JOIN dcrc_party on  second_appt.dcrcgrp=dcrc_party.dcrcgrp and  second_appt.pccd=dcrc_party.forpc set  second_appt.dc_time=dcrc_party.dc_time, second_appt.dc_date=dcrc_party.dc_date ";
//$i=execUpdate($sql17);

$sql18="update  second_appt JOIN dcrc_party on  second_appt.dcrcgrp=dcrc_party.dcrcgrp and  
second_appt.subdivcd=dcrc_party.subdivisioncd set  second_appt.dc_time=dcrc_party.dc_time, 
second_appt.dc_date=DATE(dcrc_party.dc_date)";
$i=execUpdate($sql18);
//==================================END of DCRC join=============================================//

//=================================Start of Second Training==============================================//

$sql192="update personnela 
set personnela.training2_sch=NULL
where forsubdivision='$subdiv_cd' and  personnela.booked = 'P'";
$i=execUpdate($sql192);

$sql19="update second_appt join second_training on second_appt.subdivcd=second_training.for_subdiv and second_appt.assembly=second_training.assembly set second_appt.traingcode=second_training.schedule_cd, second_appt.venuecode=second_training.training_venue , second_appt.training_date=second_training.training_dt, second_appt.training_time=second_training.training_time where second_training.party_reserve='P' and second_appt.groupid>=second_training.start_sl and second_appt.groupid<=second_training.end_sl and second_training.for_subdiv='$subdiv_cd'";
$i=execUpdate($sql19);



//Update Training in Personnela
$sql191="update personnela join second_training on personnela.forsubdivision=second_training.for_subdiv and personnela.forassembly=second_training.assembly
set personnela.training2_sch=second_training.schedule_cd
where second_training.party_reserve='P' and personnela.groupid>=second_training.start_sl and personnela.groupid<=second_training.end_sl and second_training.for_subdiv='$subdiv_cd' and  personnela.booked = 'P'";
$i=execUpdate($sql191);

$sql20="UPDATE second_appt a  JOIN training_venue_2 b ON a.venuecode=b.venue_cd SET  a.`training_venue` =b.venuename,a.`venue_addr1` =b.venueaddress1,  a.`venue_addr2`=b.venueaddress2 where a.subdivcd='$subdiv_cd'";
$i=execUpdate($sql20);
//=================================END of Second Training==============================================//

//$sql21="update second_appt a join  pc b on a.pccd=b.pccd set a.pcname=b.pcname where a.pccd='$pc_cd'";
//$i=execUpdate($sql21);

$sql22="update second_appt a join subdivision b on a.pr_subdivision=b.subdivisioncd set a.pr_subdivision=b.subdivision where a.subdivcd='$subdiv_cd'";
$i=execUpdate($sql22);

$sql23="update second_appt a join subdivision b on a.p1_subdivision=b.subdivisioncd set a.p1_subdivision=b.subdivision where a.subdivcd='$subdiv_cd'";
$i=execUpdate($sql23);
$sql24="update second_appt a join subdivision b on a.p2_subdivision=b.subdivisioncd set a.p2_subdivision=b.subdivision where a.subdivcd='$subdiv_cd'";
$i=execUpdate($sql24);

$sql25="update second_appt a join subdivision b on a.p3_subdivision=b.subdivisioncd set a.p3_subdivision=b.subdivision where a.subdivcd='$subdiv_cd'";
$i=execUpdate($sql25);

$sql26="update second_appt a join subdivision b on a.pa_subdivision=b.subdivisioncd set a.pa_subdivision=b.subdivision where a.subdivcd='$subdiv_cd'";
$i=execUpdate($sql26);

$sql27="update second_appt a join subdivision b on a.pb_subdivision=b.subdivisioncd set a.pb_subdivision=b.subdivision where a.subdivcd='$subdiv_cd'";
$i=execUpdate($sql27);

$sql271="update second_appt a join poll_table b on a.assembly=b.assembly_cd set a.polldate=b.poll_date, a.polltime=b.poll_time  where a.assembly=b.assembly_cd";
$i=execUpdate($sql271);



$sql272="update second_appt a join district b on substr(a.dcrcgrp,1,2)=b.districtcd set a.district=b.district";
$i=execUpdate($sql272);

//$sql28="update second_appt join second_appt as a on second_appt.`pr_personcd`=a.`pr_personcd` set second_appt.pers_off= a.pr_officecd, second_appt.per_poststat= a.pr_status where a.subdivcd='$subdiv_cd'";
//$i=execUpdate($sql28);
//echo "Completed";
echo "<div class='alert-success'>Completed</div>";
?>