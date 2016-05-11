<?php
session_start();
ob_start();

date_default_timezone_set('Asia/Calcutta');

require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/appointment_fun.php');
extract($_GET);
	$sub=(isset($_GET['sub'])?decode($_GET['sub']):'0');
	$assembly=(isset($_GET['assembly'])?decode($_GET['assembly']):'0');
	$group_id=(isset($_GET['group_id'])?decode($_GET['group_id']):'0');
	$env=isset($_SESSION['environment'])?$_SESSION['environment']:"";
	$distnm_cap=isset($_SESSION['distnm_cap'])?$_SESSION['distnm_cap']:"";
	$from=(isset($_GET['txtfrom'])?decode($_GET['txtfrom']):'0');
	$to=(isset($_GET['txtto'])?decode($_GET['txtto']):'0');
	//$mem_no=4;

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
$rsApp=second_appointment_letter_reserve1($sub,$assembly,$group_id,$from-1,$to-$from+1);


class PDF extends FPDF
{

function Header()
{
	
}

// Page footer
function Footer()
{
	//$this->SetY(-30);
	
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
	//$signature="../images/deo/img.jpg";
		$sql2="select * from environment";// Venue Address
			$rs2=execSelect($sql2);
			$row4=getRows($rs2);
			
    for($i=1;$i<=rowCount($data);$i++)
	{
		$this->SetFont('Arial','',9);
		$row=getRows($data);
		if($count<$per_page)
	    {
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
			$euname3="* Reserve Serial No. ".$row['groupid'];
			$euname4="Order No: ".$_SESSION['apt2_orderno'];
			$euname5="Date: ".$_SESSION['apt2_date'];*/
			$euname="ELECTION URGENT";
			$euname1="APPOINTMENT OF MICRO OBSERVER";
			$euname2="GENERAL ELECTION TO WEST BENGAL LEGISLATIVE";
			$euname21="ORDER";
			$euname3="";
			$euname22="Reserve Serial No. ".$row['groupid'];
			$euname4="Order No: ".$_SESSION['apt2_orderno'];
			$euname5="Date: ".$_SESSION['apt2_date'];
			$post=$row['post_status'];
			$ass_code=$row['assemblycd'];
			//$groupid=$row['groupid'];
			$sql="select * from assembly where assemblycd=".$ass_code."";// RO Name & Deseignation
			$rs1=execSelect($sql);
			$row3=getRows($rs1);
			$ro_name=$row3['ro_name'];
			$euname6="     Election to the House of the People/ Legislative Assembly ".$row['assembly']." Constituency. ";
			$euname7="     I  ".$ro_name.", Reurning Officer/".$row['assembly']." AC, appoint the persons whose names are specified bellow to act as Counting Supervisors/ Assistants and to attend at ".$row4['counting_venue'].", ".$row4['venue_address'].", for the purpose of assisting me in the counting of votes at the said election.   ";
			$euname8="Station specified in corresponding entry in column(1) of the table provided below for ".$row['assemblycd']." - ".$row['assembly']." L.A. Constituency ";
			$euname78="forming part of ".$row['pcname']." Parliamentary Constituency.";
			$euname81="I also authorise the Polling Officer of Sl. No.1 specified in column(4) of the table against that entry to perform the functions of the Presiding Officer";
			$euname82="during the unavoidable absence, if any, of the Presiding Officer.";
			
			$euname9="The Poll will be taken on ".$poll_date." during the hours ".$poll_time.". The Presiding Officer should arrange to collect the Polling ";
			$euname10="materials from ".$dc." on ".$dc_date." at $dc_time  ";
			$euname11="and after the Poll, these should be returned to collecting centre at ".$rcvenue;
			
			$euname12="Place: ".uppercase($_SESSION['dist_name']);
			$euname13="Date: ".date("d/m/Y");
			$euname14="".wordcase($_SESSION['dist_name']);
			$a= "Note: Only Presiding Officer & Addl. 2nd Polling Officer will attend VVPAT training at Nirmal Hriday Ashram High School on 29/03/2016 at 1:30 PM";
			$nb1="You are requested to attend the training at ".$training_venue." , ".$venue_addr;
			$nb2="on ".$training_date." from ".$training_time;
			$nb3="(__________________________)";
			$signature="../images/ro/".$row['assemblycd'].".jpg";
			//$signature="../images/ro/259.jpg";
			$roname="Returning Officer/".$row['assemblycd']." - ".$row['assembly']." AC";
			
				$this->ln(20);
			$this->SetFont('Arial','B',10);
			$this->Cell(37,6,$euname,1,0,'L');
			$this->Cell(110);
			$this->Cell(40,6,$euname22,1,0,'R');
			$this->ln(10);
			$this->SetFont('Arial','B',11);
			$this->Cell(60);
			$this->Cell(70,5,$euname1,'B',0,'C');
			$this->SetFont('Arial','B',9);
			$this->Cell(5);
			   
			// Line break
			$this->Ln(6);
			
			//$this->Cell(90);
			$this->SetFont('Arial','B',8);
			$this->Cell(15,10,'',0,0,'L');
			$this->SetFont('Arial','',10);
			$this->Cell(38);
			//$this->Cell(92,4,$euname2,'B',0,'C');
			$this->SetFont('Arial','B',8);
			$this->Cell(8);
			/*$this->SetFont('Arial','B',10);
			$this->Cell(37,6,$euname22,1,0,'R');*/
			$this->Ln(5);
			
			$this->SetFont('Arial','B',8);
			$this->Cell(15,10,'',0,0,'L');
			$this->SetFont('Arial','',12);
			$this->Cell(70);
			$this->Cell(15,4,$euname21,'B',0,'C');
			$this->SetFont('Arial','B',8);
			//$this->Cell(4);
			$this->SetFont('Arial','B',10);
			$this->Cell(33,6,'',0,0,'R');
			// Line break
			
			$this->Ln(20);
			
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
			$this->Ln(7);
			
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
			$this->SetFont('Arial','',9);
			$this->MultiCell(180,4,$euname6,0,'C');
			
			
			// Line break
			$this->Ln(4);
		$this->SetFont('Arial','',9);
			$this->MultiCell(185,4,$euname7,0,'J');
			// Line break
			//$this->Ln(10);
			
			$this->SetFont('Arial','',8.7);
			$this->Cell(87);
			//$this->Cell(50,10,$euname82,0,0,'L');
		
			// Line break
			$this->Ln(18);
			
			
						
			//$this->SetFillColor(253,236,236);
			/*$this->SetFillColor(255,255,255);
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
			$this->Ln();*/
			
	        
			
		//	$ps=$row['post_status'];
			/*switch($ps)
			{
				case ($ps=='PR'):
				 $pr_name=$row['person_name'];
				$pr_desig=$row['person_designation'];
				$pr_code=$row['personcd'];
				$pr_office=$row['office_name'];
				$pr_ofc_address=$row['office_address'];
				$pr_ofc_address1="P.O. - ".$row['post_office'].", Subdiv. - ".$row['subdivision'].", Dist. - ".$row['district'];
				$pr_ofc_cd="OFFICE - (".$row['officecd'].")";
				$pr_post_stat=$row['post_stat'];
				$pr_join=$pr_post_stat." PIN - (".$pr_code.")";
				break;
				case ($ps=='P1'):
				 $pp_name=$row['person_name'];
				$pp_desig=$row['person_designation'];
				$pp_code=$row['personcd'];
				$pp_office=$row['office_name'];
				$pp_ofc_address=$row['office_address'];
				$pp_ofc_address1="P.O. - ".$row['post_office'].", Subdiv. - ".$row['subdivision'].", Dist. - ".$row['district'];
				$pp_ofc_cd="OFFICE - (".$row['officecd'].")";
				$pp_post_stat=$row['post_stat'];
				$pp_join=$pp_post_stat." PIN - (".$pp_code.")";
				break;
				
				default:
				  break;
				  
			}*/
			/*if($row['post_status']=='PR')
			{*/
			$p1_name="1.   ".$row['person_name'];
			$p1_desig=$row['person_designation'];
			$p1_code=$row['personcd'];
			$p1_office=$row['office_name'];
			$p1_ofc_address="Office (".$row['officecd'].") : ".$row['office_name'].", ".$row['office_address'];
			//$p1_ofc_address1="P.O. - ".$row['p1_postoffice'].", Subdiv. - ".$row['p1_subdivision'].", ".$row['district'];
			$p1_ofc_cd="OFFICE - (".$row['officecd'].")";
			$p1_post_stat=$row['post_stat'];
			$p1_join=$p1_post_stat." PIN - (".$p1_code.")";
				
				
				
			/*}
		    if($row['post_status']=='P1')
			{
			$p1_name="1.   ".$row['person_name'];
			$p1_desig=$row['person_designation'];
			$p1_code=$row['personcd'];
			$p1_office=$row['officename'];
			$p1_ofc_address="Office (".$row['officecd'].") : ".$row['p1_officename'].", ".$row['officeaddress'];
			$p1_ofc_address1="P.O. - ".$row['p1_postoffice'].", Subdiv. - ".$row['p1_subdivision'].", ".$row['district'];
			$p1_ofc_cd="OFFICE - (".$row['p1_officecd'].")";
			$p1_post_stat=$row['p1_post_stat'];
			$p1_join=$p1_post_stat." PIN - (".$p1_code.")";
				
			
				
		
			}
		    if ($row['post_status']=='PA')
			{
				$pa_name="1.  ".$row['pa_name'];
				$pa_desig=$row['pa_designation'];
				$pa_code=$row['pa_personcd'];
				$pa_office=$row['pa_officename'];
				$pa_ofc_address=$row['pa_officeaddress'];
				$pa_ofc_address1="P.O. - ".$row['pa_postoffice'].", Subdiv. - ".$row['pa_subdivision'].", ".$row['district'];
				$pa_ofc_cd="OFFICE - (".$row['pa_officecd'].")";
				$pa_post_stat=$row['pa_post_stat'];
				$pa_join=$pa_post_stat." PIN - (".$pa_code.")";
			
				$pr_name='';
				$pr_desig='';
				$pr_code='';
				$pr_office='';
				$pr_ofc_address='';
				$pr_ofc_address1='';
				$pr_ofc_cd='';
				$pr_post_stat='';
				$pr_join='';
			}
			if ($row['post_status']=='P2')
			{
				$p2_name="1.  ".$row['p2_name'];
				$p2_desig=$row['p2_designation'];
				$p2_code=$row['p2_personcd'];
				$p2_office=$row['p2_officename'];
				$p2_ofc_address=$row['p2_officeaddress'];
				$p2_ofc_address1="P.O. - ".$row['p2_postoffice'].", Subdiv. - ".$row['p2_subdivision'].", ".$row['district'];
				$p2_ofc_cd="OFFICE - (".$row['p2_officecd'].")";
				$p2_post_stat=$row['p2_post_stat'];
				$p2_join=$p2_post_stat." PIN - (".$p2_code.")";
			
				$pr_name='';
				$pr_desig='';
				$pr_code='';
				$pr_office='';
				$pr_ofc_address='';
				$pr_ofc_address1='';
				$pr_ofc_cd='';
				$pr_post_stat='';
				$pr_join='';
			}*/
			if($row['post_status']=="PR")
			{
				$a="For the Post: Counting Supervisor";
;			}
			else if($row['post_status']=="P1")
			{
				$a="For the Post: Counting Assistant";
			}
			else if($row['post_status']=="P2" || $row['post_status']=="PA")
			{
				$a="For the Post: Counting Supervisor";
			}
			
		$this->Ln(4);
			$this->SetFont('Arial','B',9);
			$this->Cell(50,4,$p1_name.",".$p1_desig." (Pin-".$p1_code.")",0,'L');
			$this->Ln(4);
			$this->SetFont('Arial','',9);
			$this->Cell(140,4,"      ".$p1_ofc_address,0,0,'L');
			//$this->Cell(30,10,$pr_ofc_address,0,0,'L');
			
		  /* $this->SetFont('Arial','B','7');
			$this->Cell($w[0],6,$row['groupid'],'LTR',0,'C',$fill);						
			$this->Cell($w[1],6,$pr_name,'LTR',0,'L',$fill);
			$this->Cell($w[2],6,$p1_name,'LTR',0,'L',$fill);
			$this->Cell($w[3],6,$pp_name,'LTR',0,'L',$fill);
			$this->Ln(4);
			
			$this->SetFont('Arial','','4.5');
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,$pr_desig,'LR',0,'L',$fill);
			$this->Cell($w[2],4,$p1_desig,'LR',0,'L',$fill);
			$this->Cell($w[3],4,$pp_desig,'LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,$pr_join,'LR',0,'L',$fill);
			$this->Cell($w[2],4,$p1_join,'LR',0,'L',$fill);
			$this->Cell($w[3],4,$pp_join,'LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,$pr_office,'LR',0,'L',$fill);
			$this->Cell($w[2],4,$p1_office,'LR',0,'L',$fill);
			$this->Cell($w[3],4,$pp_office,'LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,$pr_ofc_address,'LR',0,'L',$fill);
			$this->Cell($w[2],4,$p1_ofc_address,'LR',0,'L',$fill);
			$this->Cell($w[3],4,$pp_ofc_address,'LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],4,'','LR',0,'L',$fill);						
			$this->Cell($w[1],4,$pr_ofc_address1,'LR',0,'L',$fill);
			$this->Cell($w[2],4,$p1_ofc_address1,'LR',0,'L',$fill);
			$this->Cell($w[3],4,$pp_ofc_address1,'LR',0,'L',$fill);
			$this->Ln(3);
			
			$this->Cell($w[0],5,'','LR',0,'L',$fill);						
			$this->Cell($w[1],5,$pr_ofc_cd,'LR',0,'L',$fill);
			$this->Cell($w[2],5,$p1_ofc_cd,'LR',0,'L',$fill);
			$this->Cell($w[3],5,$pp_ofc_cd,'LR',0,'L',$fill);
			
			$this->Ln();
			$this->Cell(array_sum($w),0,'',1,0,'L',$fill);
		//	$this->Ln(5);
			
			$this->Ln(4);
			
			$this->SetFont('Arial','',8.7);
			$this->MultiCell(190,4,"     ".$euname9.$euname10.$euname11.".",0,'J',$fill);
			$this->Ln();
			if($ass_code=="236"&&($post=="PR" || $post=="PA"))
			{
			$this->SetFont('Arial','B',8);
			$this->MultiCell(190,4,"".$a.".",0,'J',$fill);
			}
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
		
			// Line break*/
			$this->Ln(18);
			
			$this->SetFont('Arial','',9);
			//$this->Cell(80);
			$this->Cell(30,10,$euname12,0,0,'L');
			$this->SetFont('Arial','',10);			
			$this->Cell(120);
			$this->Cell(10,10,"Signature",0,0,'R');
			// Line break
			$this->Ln(9);
			
			$this->SetFont('Arial','',9);
			$this->Cell(30,1,$euname13,0,0,'L');
			$this->SetFont('Arial','',10);			
			$this->Cell(110);
		//	$this->Cell(10,10,"yuyu",0,0,'R');
			$this->Cell(10, 10, $this->Image($signature, $this->GetX(), $this->GetY(), 30.78), 0, 0, 'R', false );
			// Line break
			$this->Ln(8);
			
			$this->SetFont('Arial','',8);
			$this->Cell(165);
			$this->Cell(10,10,$nb3,0,0,'R');
			
		
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',9);
			$this->Cell(170);
			$this->Cell(10,10,$roname,0,0,'R');
		
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',9);
			$this->Cell(160);
			$this->Cell(10,10,$euname14,0,0,'R');

			// Line break
			$this->Ln(10);			
			$this->Cell(190,0,'',1,0,'L',$fill);
			$this->Ln();
			
			
			/*$this->SetFont('Arial','',8.7);
			$this->Ln(4);
			$this->SetFont('Arial','B',9);
			$this->MultiCell(190,4,"Second Training: ".$nb1.$nb2,0,'J',$fill);
			$this->Ln();			
			$this->Cell(190,0,'',1,0,'L',$fill);
			$this->Ln();*/
			/*$this->Cell(10,10,$nb1,0,0,'L');
			$this->Ln(4);
			$this->SetFont('Arial','',8.5);
			$this->Cell(10,10,$nb2,0,0,'L');*/
			$this->Ln(4);
		
				//$bmname=fetch_block_2nd_appt_reserve($row['block_muni_name']);
				$this->SetFont('Arial','',9);
				$this->Cell(190,5,"Block/Municipality: ".$row['block_muni_name'],0,0,'C');
			
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