<?php
session_start();
ob_start();
extract($_GET);
date_default_timezone_set('Asia/Calcutta');

require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/training2_fun.php');

	$sub=(isset($_GET['sub'])?decode($_GET['sub']):'0');
	$assembly=(isset($_GET['assembly'])?decode($_GET['assembly']):'0');
	$group_id=(isset($_GET['group_id'])?decode($_GET['group_id']):'0');
	$env=isset($_SESSION['environment'])?$_SESSION['environment']:"";
	$distnm_cap=isset($_SESSION['distnm_cap'])?$_SESSION['distnm_cap']:"";
	$from=(isset($_GET['txtfrom'])?decode($_GET['txtfrom']):'0');
	$to=(isset($_GET['txtto'])?decode($_GET['txtto']):'0');
	$chksub=(isset($_GET['chksub'])?decode($_GET['chksub']):'0');
	$chkasm=(isset($_GET['chkasm'])?decode($_GET['chkasm']):'0');
	$mem_no='';
	if($sub=='0' && $assembly='0')
	{
		echo "Select Subdivision wise or Assembly wise";
		exit;
	}
    
	if($sub !='')
	{
		/* if($from>$hid_rec || $to>$hid_rec)
		{
			echo "Please check record no";
			exit;
		}*/
		if($from>$to || $from<1 || $to<1)
		{
			echo "Please check record no";
			exit;
		}
		if((($to)-($from))>2000)
		{
			echo "Records should not be greater than 2000";
			exit;
		}
	}
	if($chksub=='on')
	{
		$rsApp=second_appointment_letter_print_4_5_sub($sub,$assembly,$group_id,$mem_no,$from-1,$to-$from+1);
	}
	if($chkasm=='on')
	{
		$rsApp=second_appointment_letter_print_4_5_asm($sub,$assembly,$group_id,$mem_no,$from-1,$to-$from+1);
	
	}

class PDF extends FPDF
{

function Header()
{

}

// Page footer
function Footer()
{

}



function FancyTable($header, $data)
{
    // Colors, line width and bold font
	
	
   
	//$w = array(190);
 
    // Color and font restoration
    //$this->SetFillColor(224,235,255);
  //  $this->SetTextColor(0);
    //$this->SetDisplayMode('fullwidth','default');
    // Data
    $fill = false;
	$count=0;
	$per_page=1;
	
    for($i=1;$i<=rowCount($data);$i++)
	{
		$this->SetFont('Arial','',9);
		$row=getRows($data);
		if($count<$per_page)
	    {
			$chksub=(isset($_GET['chksub'])?decode($_GET['chksub']):'0');
			
			$poll_date=$row['polldate'];
			$poll_time=$row['polltime'];
			$training_venue=$row['training_venue'];
			$venue_addr=$row['venue_addr1'].", ".$row['venue_addr2'];
			$training_date=$row['training_date'];
			$training_time=$row['training_time'];
			
			$dc=($row['dc_venue']!=''?$row['dc_venue'].", ".$row['dc_address']:"___________________________________");
			$dc_date=($row['dc_date']!=''?$row['dc_date']:"___________");
			$dc_time=($row['dc_time']!=''?$row['dc_time']:"___________");
			$rcvenue=($row['rc_venue']!=''?$row['rc_venue']:"_______________________________");
			
			/*$euname="ELECTION URGENT";
			$euname1="ORDER OF APPOINTMENT FOR POLLING DUTIES";
			$euname2="GENERAL ELECTION TO WEST BENGAL LEGISLATIVE ASSEMBLY ELECTION, 2016";
			$euname3="* Polling Party No. ".$row['groupid'];
			$euname4="Order No: ".$_SESSION['apt2_orderno'];
			$euname5="Date: ".$_SESSION['apt2_date'];*/
			
			$euname="ELECTION URGENT";
			$euname1="ORDER OF APPOINTMENT FOR POLLING DUTIES";
			$euname2="GENERAL ELECTION TO WEST BENGAL LEGISLATIVE";
			$euname21="ASSEMBLY ELECTION, 2016";
			$euname3=($chksub=='on')?$row['pers_off']."/".$row['per_poststat']:"";
			$euname22="Polling Party No. ".$row['groupid'];
			$euname4="Order No: ".$_SESSION['apt2_orderno'];
			$euname5="Date: ".$_SESSION['apt2_date'];
			
			$euname6="     In persuance of sub-selection(1) and sub-selection(3) of section 26 of the Representation of the People Act,1963(43 of 1951), I hereby ";
			$euname7="appoint the officers specified in columb(2) and (3) of the table below as Presiding Officer and Polling Officers respectively for the Polling ";
			$euname8="Station specified in corresponding entry in column(1) of the table provided by me for ".$row['assembly']." - ".$row['assembly_name']." L.A. Constituency ";
			$euname78="forming part of ".$row['pcname']." Parliamentary Constituency.";
			$euname81="I also authorise the Polling Officer specified in column(4) of the table against that entry to perform the functions of the Presiding Officer";
			$euname82="during the unavoidable absence, if any, of the Presiding Officer.";
			
			$euname9="The Poll will be taken on ".$poll_date." during the hours ".$poll_time.". The Presiding Officer should arrange to collect the Polling ";
			$euname10="materials from ".$dc." on ".$dc_date." at ".$dc_time." ";
			$euname11="and after the Poll, these should be returned to collecting centre at ".$rcvenue;
			
			$euname12="Place: ".uppercase($_SESSION['dist_name']);
			$euname13="Date: ".date("d/m/Y");
			$euname14="District ".wordcase($_SESSION['dist_name']);
			$nb1="You are requested to attend the training at ".$training_venue." , ".$venue_addr;
			$nb2="on ".$training_date." from ".$training_time;
			$nb3="(__________________________)";
			
	        $signature="../images/ro/".$row['assembly'].".jpg";
			//$signature="../images/ro/259.jpg";
			$roname="RO/".$row['assembly']." - ".$row['assembly_name'];
			
			$this->SetFont('Arial','B',10);
			$this->Cell(37,6,$euname,1,0,'L');
			$this->SetFont('Arial','B',10);
			$this->Cell(20);
			$this->Cell(84,4,$euname1,'B',0,'C');
			$this->SetFont('Arial','B',8);
			$this->Cell(28);
			$this->Cell(10,3,$euname3,0,0,'R');
			   
			// Line break
			$this->Ln(6);
			
			//$this->Cell(90);
			$this->SetFont('Arial','B',8);
			$this->Cell(15,10,'',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->Cell(38);
			$this->Cell(92,4,$euname2,'B',0,'C');
			$this->SetFont('Arial','B',8);
			$this->Cell(8);
			$this->SetFont('Arial','B',10);
			$this->Cell(37,6,$euname22,1,0,'R');
			
			$this->Ln(5);
			
			$this->SetFont('Arial','B',8);
			$this->Cell(15,10,'',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->Cell(60);
			$this->Cell(47,4,$euname21,'B',0,'C');
			$this->SetFont('Arial','B',8);
			$this->Cell(13);
			$this->SetFont('Arial','B',10);
			$this->Cell(33,6,'',0,0,'R');
			// Line break
			
			$this->Ln(4);
			
			$this->SetFont('Arial','',9);
			$this->Cell(15,10,$euname4,0,0,'L');
			$this->SetFont('Arial','',10);
			$this->Cell(60);
			$this->Cell(47,4,'','',0,'C');
			$this->SetFont('Arial','',8);
			$this->Cell(33);
			$this->SetFont('Arial','',9);
			$this->Cell(33,6,$euname5,0,0,'R');
			
			$this->Ln(9);
			
			/*$this->SetFont('Arial','B',8);
			$this->Cell(30,5,$euname,1,0,'L');
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(40,6,$euname1,0,0,'C');
			$this->SetFont('Arial','B',8);
			$this->Cell(58);
			$this->Cell(10,7,$euname3,0,0,'R');
			   
			// Line break
			$this->Ln(5);
			
			//$this->Cell(90);
			$this->SetFont('Arial','B',8);
			$this->Cell(15,10,$euname4,0,0,'L');
			$this->SetFont('Arial','B',6.5);
			$this->Cell(38);
			$this->Cell(92,4,$euname2,'B',0,'C');
			$this->SetFont('Arial','B',8);
			$this->Cell(36);
			$this->Cell(10,10,$euname5,0,0,'R');
			   
			// Line break
			$this->Ln(6);
			
			/*$this->SetFont('Arial','',8.7);
			$this->Cell(87);
			$this->Cell(20,10,$euname6,0,0,'C');
			
			 // Line break
			$this->Ln(4);
			
			$this->SetFont('Arial','',8.7);
			$this->Cell(50,10,$euname7,0,0,'L');
		
			// Line break
			$this->Ln(4);
			
			$this->SetFont('Arial','',8.7);
			$this->Cell(50,10,$euname8,0,0,'L');
		
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',8.7);
			$this->Cell(50,10,$euname78,0,0,'L');*/
			
			$this->Ln();
			$this->SetFont('Arial','',8.7);
			$this->MultiCell(190,4,$euname6.$euname7.$euname8.$euname78,0,'J');
			
			
			// Line break
			//$this->Ln(4);
		
			// Line break
			//$this->Ln(10);
			
			$this->SetFont('Arial','',8.7);
			$this->Cell(87);
			$this->Cell(20,10,$euname81,0,0,'C');
		
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',8.7);
			$this->Cell(50,10,$euname82,0,0,'L');
		
			// Line break
			$this->Ln(14);
			
			
						
			//$this->SetFillColor(253,236,236);
			$this->SetFillColor(255,255,255);
		//	$this->SetTextColor(0,0,0);
			$this->SetDrawColor(0,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('Arial','B','8');
			  
			$head = array('Polling','Name of the Presiding Officer','Name of the Polling Officers','Polling Officer authorised to perform');
			$w = array(11,59,60,60);
			$head1=array('Party','','','the functions of the Presiding Officer');
			$head2=array('No.','','',"in the latter's absence");
			$head3=array('(1)','(2)','(3)',"(4)");
			
			//	$this->SetFont('Arial','',9);
			for($j=0;$j<count($head);$j++)
				$this->Cell($w[$j],5,$head[$j],'LTR',0,'C',true);				 
			$this->Ln();
			for($j1=0;$j1<count($head1);$j1++)
				$this->Cell($w[$j1],4,$head1[$j1],'LR',0,'C',true);
			$this->Ln();	
			for($j2=0;$j2<count($head2);$j2++)
				$this->Cell($w[$j2],5,$head2[$j2],'LR',0,'C',true);
			$this->Ln();
			
			for($j3=0;$j3<count($head3);$j3++)
				$this->Cell($w[$j3],7,$head3[$j3],1,0,'C',true);
			$this->Ln();
			
	        
			
			$pr_name=$row['pr_name'];
			$pr_desig=$row['pr_designation'];
			$pr_code=$row['pr_personcd'];
			$pr_office=$row['pr_officename'];
			$pr_ofc_address=$row['pr_officeaddress'];
			$pr_ofc_address1="P.O. - ".$row['pr_postoffice'].", Subdiv. - ".$row['pr_subdivision'].", ".$row['district'];
			$pr_ofc_cd="OFFICE - (".$row['pr_officecd'].")";
			$pr_post_stat=$row['pr_post_stat'];
			$pr_join=$pr_post_stat." PIN - (".$pr_code.")";
			
			$p1_name="1. ".$row['p1_name'];
			$p1_desig=$row['p1_designation'];
			$p1_code=$row['p1_personcd'];
			$p1_office=$row['p1_officename'];
			$p1_ofc_address=$row['p1_officeaddress'];
			$p1_ofc_address1="P.O. - ".$row['p1_postoffice'].", Subdiv. - ".$row['p1_subdivision'].", ".$row['district'];
			$p1_ofc_cd="OFFICE - (".$row['p1_officecd'].")";
			$p1_post_stat=$row['p1_post_stat'];
			$p1_join=$p1_post_stat." PIN - (".$p1_code.")";
			
			$p2_name="2. ".$row['p2_name'];
			$p2_desig=$row['p2_designation'];
			$p2_code=$row['p2_personcd'];
			$p2_office=$row['p2_officename'];
			$p2_ofc_address=$row['p2_officeaddress'];
			$p2_ofc_address1="P.O. - ".$row['p2_postoffice'].", Subdiv. - ".$row['p2_subdivision'].", ".$row['district'];
			$p2_ofc_cd="OFFICE - (".$row['p2_officecd'].")";
			$p2_post_stat=$row['p2_post_stat'];
			$p2_join=$p2_post_stat." PIN - (".$p2_code.")";
			
			$sl=(($row['pa_name']=='')?"3. ":(($row['pb_name']=='')?"4. ":"5. "));
			
			$p3_name=$sl.$row['p3_name'];
			$p3_desig=$row['p3_designation'];
			$p3_code=$row['p3_personcd'];
			$p3_office=$row['p3_officename'];
			$p3_ofc_address=$row['p3_officeaddress'];
			$p3_ofc_address1="P.O. - ".$row['p3_postoffice'].", Subdiv. - ".$row['p3_subdivision'].", ".$row['district'];
			$p3_ofc_cd="OFFICE - (".$row['p3_officecd'].")";
			$p3_post_stat=$row['p3_post_stat'];
			$p3_join=$p3_post_stat." PIN - (".$p3_code.")";
			
			
			if($row['pa_name']!=''){
			$pa_name="3. ".$row['pa_name'];
			$pa_desig=$row['pa_designation'];
			$pa_code=$row['pa_personcd'];
			$pa_office=$row['pa_officename'];
			$pa_ofc_address=$row['pa_officeaddress'];
			$pa_ofc_address1="P.O. - ".$row['pa_postoffice'].", Subdiv. - ".$row['pa_subdivision'].", ".$row['district'];
			$pa_ofc_cd="OFFICE - (".$row['pa_officecd'].")";
			$pa_post_stat=$row['pa_post_stat'];
			$pa_join=$pa_post_stat." PIN - (".$pa_code.")";
			}
			
			if($row['pb_name']!=''){
			$pb_name="4. ".$row['pb_name'];
			$pb_desig=$row['pb_designation'];
			$pb_code=$row['pb_personcd'];
			$pb_office=$row['pb_officename'];
			$pb_ofc_address=$row['pb_officeaddress'];
			$pb_ofc_address1="P.O. - ".$row['pb_postoffice'].", Subdiv. - ".$row['pb_subdivision'].", ".$row['district'];
			$pb_ofc_cd="OFFICE - (".$row['pb_officecd'].")";
			$pb_post_stat=$row['pb_post_stat'];
			$pb_join=$pb_post_stat." PIN - (".$pb_code.")";
			}
			
			
		
		   $this->SetFont('Arial','B','7');
			$this->Cell($w[0],6,$row['groupid'],'LTR',0,'C',$fill);						
			$this->Cell($w[1],6,$pr_name,'LTR',0,'L',$fill);
			$this->Cell($w[2],6,$p1_name,'LTR',0,'L',$fill);
			$this->Cell($w[3],6,$p1_name,'LTR',0,'L',$fill);
			$this->Ln(4);
			
			$this->SetFont('Arial','','4.5');
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,$pr_desig,'LR',0,'L',$fill);
			$this->Cell($w[2],4,$p1_desig,'LR',0,'L',$fill);
			$this->Cell($w[3],4,$p1_desig,'LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,$pr_join,'LR',0,'L',$fill);
			$this->Cell($w[2],4,$p1_join,'LR',0,'L',$fill);
			$this->Cell($w[3],4,$p1_join,'LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,$pr_office,'LR',0,'L',$fill);
			$this->Cell($w[2],4,$p1_office,'LR',0,'L',$fill);
			$this->Cell($w[3],4,$p1_office,'LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,$pr_ofc_address,'LR',0,'L',$fill);
			$this->Cell($w[2],4,$p1_ofc_address,'LR',0,'L',$fill);
			$this->Cell($w[3],4,$p1_ofc_address,'LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,$pr_ofc_address1,'LR',0,'L',$fill);
			$this->Cell($w[2],4,$p1_ofc_address1,'LR',0,'L',$fill);
			$this->Cell($w[3],4,$p1_ofc_address1,'LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],5,'','LR',0,'L',$fill);						
			$this->Cell($w[1],5,$pr_ofc_cd,'LR',0,'L',$fill);
			$this->Cell($w[2],5,$p1_ofc_cd,'LR',0,'L',$fill);
			$this->Cell($w[3],5,$p1_ofc_cd,'LR',0,'L',$fill);
			$this->Ln();
			
			$this->SetFont('Arial','B','7');
			$this->Cell($w[0],6,'','LR',0,'L',$fill);						
			$this->Cell($w[1],6,'','LR',0,'L',$fill);
			$this->Cell($w[2],6,$p2_name,'LR',0,'L',$fill);
			$this->Cell($w[3],6,'','LR',0,'L',$fill);
			$this->Ln(4);
			
			$this->SetFont('Arial','','4.5');
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$p2_desig,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);

			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$p2_join,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$p2_office,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$p2_ofc_address,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$p2_ofc_address1,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],5,'','LR',0,'L',$fill);						
			$this->Cell($w[1],5,'','LR',0,'L',$fill);
			$this->Cell($w[2],5,$p2_ofc_cd,'LR',0,'L',$fill);
			$this->Cell($w[3],5,'','LR',0,'L',$fill);
			$this->Ln();
			//memb 5//
			if($row['mem_no']==5 || $row['mem_no']==6)
			{
			$this->SetFont('Arial','B','7');
			$this->Cell($w[0],6,'','LR',0,'L',$fill);						
			$this->Cell($w[1],6,'','LR',0,'L',$fill);
			$this->Cell($w[2],6,$pa_name,'LR',0,'L',$fill);
			$this->Cell($w[3],6,'','LR',0,'L',$fill);
			$this->Ln(4);
			
			$this->SetFont('Arial','','4.5');
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$pa_desig,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);

			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$pa_join,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$pa_office,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$pa_ofc_address,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$pa_ofc_address1,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],5,'','LR',0,'L',$fill);						
			$this->Cell($w[1],5,'','LR',0,'L',$fill);
			$this->Cell($w[2],5,$pa_ofc_cd,'LR',0,'L',$fill);
			$this->Cell($w[3],5,'','LR',0,'L',$fill);
			$this->Ln();
			}
			//memb 6//
			if($row['mem_no']==6)
			{
			$this->SetFont('Arial','B','7');
			$this->Cell($w[0],6,'','LR',0,'L',$fill);						
			$this->Cell($w[1],6,'','LR',0,'L',$fill);
			$this->Cell($w[2],6,$pb_name,'LR',0,'L',$fill);
			$this->Cell($w[3],6,'','LR',0,'L',$fill);
			$this->Ln(4);
			
			$this->SetFont('Arial','','4.5');
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$pb_desig,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);

			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$pb_join,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$pb_office,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$pb_ofc_address,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$pb_ofc_address1,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],5,'','LR',0,'L',$fill);						
			$this->Cell($w[1],5,'','LR',0,'L',$fill);
			$this->Cell($w[2],5,$pb_ofc_cd,'LR',0,'L',$fill);
			$this->Cell($w[3],5,'','LR',0,'L',$fill);
			$this->Ln();
			}
			
			//memb 6//
			$this->SetFont('Arial','B','7');
			$this->Cell($w[0],6,'','LR',0,'L',$fill);						
			$this->Cell($w[1],6,'','LR',0,'L',$fill);
			$this->Cell($w[2],6,$p3_name,'LR',0,'L',$fill);
			$this->Cell($w[3],6,'','LR',0,'L',$fill);
			$this->Ln(4);
			
			$this->SetFont('Arial','','4.5');
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$p3_desig,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);

			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$p3_join,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$p3_office,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$p3_ofc_address,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,'','LR',0,'L',$fill);
			$this->Cell($w[2],4,$p3_ofc_address1,'LR',0,'L',$fill);
			$this->Cell($w[3],4,'','LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],5,'','LR',0,'L',$fill);						
			$this->Cell($w[1],5,'','LR',0,'L',$fill);
			$this->Cell($w[2],5,$p3_ofc_cd,'LR',0,'L',$fill);
			$this->Cell($w[3],5,'','LR',0,'L',$fill);
			

			$this->Ln();
			$this->Cell(array_sum($w),0,'',1,0,'L',$fill);
		//	$this->Ln(5);
			
			$this->Ln(4);
			
			$this->SetFont('Arial','',8.7);
			$this->MultiCell(190,4,"     ".$euname9.$euname10.$euname11.".",0,'J',$fill);
			/*$this->SetFont('Arial','',8.7);
			$this->Cell(87);
			$this->Cell(20,10,$euname9,0,0,'C');
		
			// Line break
			$this->Ln(4);		
			$this->SetFont('Arial','',8.7);
			$this->Cell(50,10,$euname10,0,0,'L');
		
			// Line break
			$this->Ln(4);			
			$this->SetFont('Arial','',8.7);
			$this->Cell(50,10,$euname11,0,0,'L');*/
		
			// Line break
			$this->Ln(5);
			
			
			$this->SetFont('Arial','',9);
			//$this->Cell(80);
			$this->Cell(30,10,$euname12,0,0,'L');
			$this->SetFont('Arial','',10);			
			$this->Cell(120);
			$this->Cell(10,10,"Signature",0,0,'R');
			// Line break
			$this->Ln(8.3);
			
			$this->SetFont('Arial','',9);
			$this->Cell(30,1,$euname13,0,0,'L');
			$this->SetFont('Arial','',10);			
			$this->Cell(110);
		//	$this->Cell(10,10,"yuyu",0,0,'R');
			$this->Cell(10, 10, $this->Image($signature, $this->GetX(), $this->GetY(), 30.78), 0, 0, 'R', false );
			// Line break
			$this->Ln(7);
			
			$this->SetFont('Arial','',8);
			$this->Cell(164);
			$this->Cell(10,10,$nb3,0,0,'R');
		
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',9);
			$this->Cell(160);
			$this->Cell(10,10,$roname,0,0,'R');
		
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',9);
			$this->Cell(160);
			$this->Cell(10,10,$euname14,0,0,'R');
		
			// Line break
			$this->Ln();			
			$this->Cell(190,0,'',1,0,'L',$fill);
			$this->Ln();
			
			
			$this->SetFont('Arial','',8.7);
			$this->Ln(2);
			$this->MultiCell(190,4,$nb1.$nb2,0,'J',$fill);
			$this->Ln(5);
			//$bmname=$row['block_muni_cd'];
			$bmname=($chksub=='on')?"Block/Municipality: ".$row['block_muni_name']:"";
			//if($chksub=='on')
	        //{
				//$bmname=fetch_block_2nd_appt($row['block_muni_name']);
				$this->SetFont('Arial','',9);
				$this->Cell(190,5,$bmname,0,0,'C');
			//}
		/*	$this->Cell(10,10,$nb1,0,0,'L');
			$this->Ln(4);
			$this->SetFont('Arial','',8.5);
			$this->Cell(10,10,$nb2,0,0,'L');*/
			//$this->Ln(4);
			
			
			$fill = !$fill;
		    $count++;
		}
		if($count==$per_page)
		{
			$per_page=$per_page+1;
			if($count!=rowCount($data))
		    {		
			  $this->AddPage();
			}
		} 
    }
    // Closing line
  //  $this->Cell(array_sum($w),0,'','T');
 }
}

     $pdf = new PDF('P','mm','A4');
      // Column headings
   //   $header = array('Name of Polling Officer');
   // Data loading
    $header="";
	$data=$rsApp;
    $pdf->SetFont('Arial','',4);
    $pdf->AddPage();
	$pdf->FancyTable($header,$data);

$pdf->Output();
?>