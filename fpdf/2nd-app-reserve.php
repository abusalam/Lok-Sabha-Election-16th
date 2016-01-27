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
		if((($to)-($from))>250)
		{
			echo "Records should not be greater than 250";
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
	$signature="../images/deo/img.jpg";
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
			
			$euname="ELECTION URGENT";
			$euname1="ORDER OF APPOINTMENT FOR POLLING DUTIES";
			$euname2="ASSEMBLY ELECTION , 2016";
			$euname3="* Reserve Serial No. ".$row['groupid'];
			$euname4="Order No: ".$_SESSION['apt2_orderno'];
			$euname5="Date: ".$_SESSION['apt2_date'];
			$euname6="In persuance of sub-selection(1) and sub-selection(3) of section 26 of the Representation of the People Act,1963(43 of 1951), I hereby";
			$euname7="appoint the officers specified in columb(2) and (3) of the table below as Presiding Officer and Polling Officers respectively for the Polling";
			$euname8="Station specified in corresponding entry in column(1) of the table provided by me for $row[assembly] - $row[assembly_name] L.A. Constituency";
			$euname78="forming part of .. Parliamentary Constituency.";
			$euname81="I also authorise the Polling Officer specified in column(4) of the table against that entry to perform the functions of the Presiding Officer";
			$euname82="during the unavoidable absence, if any, of the Presiding Officer.";
			
			$euname9="The Poll will be taken on $poll_date during the hours $poll_time. The Presiding Officer should arrange to collect the Polling ";
			$euname10="materials from $dc on $dc_date at $dc_time  ";
			$euname11="and after the Poll, these should be returned to collecting centre at $rcvenue";
			
			$euname12="Place: ".uppercase($_SESSION['dist_name']);
			$euname13="Date: ".date("d/m/Y");
			$euname14="District ".wordcase($_SESSION['dist_name']);
			$nb1="You are requested to attend the training at $training_venue , $venue_addr";
			$nb2="on $training_date from $training_time";
			$nb3="(__________________________)";
			
	
			$this->SetFont('Arial','B',8);
			$this->Cell(30,5,$euname,1,0,'L');
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(40,5,$euname1,0,0,'C');
			$this->SetFont('Arial','B',8);
			$this->Cell(58);
			$this->Cell(10,7,$euname3,0,0,'R');
			   
			// Line break
			$this->Ln(5);
			
			//$this->Cell(90);
			$this->SetFont('Arial','B',8);
			$this->Cell(15,10,$euname4,0,0,'L');
			$this->SetFont('Arial','B',7);
			$this->Cell(70);
			$this->Cell(40,4,$euname2,'B',0,'C');
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(10,10,$euname5,0,0,'R');
			   
			// Line break
			$this->Ln(17);
			
			$this->SetFont('Arial','',8.7);
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
			$this->Cell(50,10,$euname78,0,0,'L');
		
			// Line break
			$this->Ln(10);
			
			$this->SetFont('Arial','',8.7);
			$this->Cell(87);
			$this->Cell(20,10,$euname81,0,0,'C');
		
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',8.7);
			$this->Cell(50,10,$euname82,0,0,'L');
		
			// Line break
			$this->Ln(18);
			
			
						
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
			if($row['post_status']=='PR')
			{
				$pr_name=$row['person_name'];
				$pr_desig=$row['person_designation'];
				$pr_code=$row['personcd'];
				$pr_office=$row['office_name'];
				$pr_ofc_address=$row['office_address'];
				$pr_ofc_address1="P.O. - ".$row['post_office'].", Subdiv. - ".$row['subdivision'].", Dist. - ".$row['district'];
				$pr_ofc_cd="OFFICE - (".$row['officecd'].")";
				$pr_post_stat=$row['post_stat'];
				$pr_join=$pr_post_stat." PIN - (".$pr_code.")";
				
				$p1_name='';
				$p1_desig='';
				$p1_code='';
				$p1_office='';
				$p1_ofc_address='';
				$p1_ofc_address1='';
				$p1_ofc_cd='';
				$p1_post_stat='';
				$p1_join='';
				
				$pp_name='';
				$pp_desig='';
				$pp_code='';
				$pp_office='';
				$pp_ofc_address='';
				$pp_ofc_address1='';
				$pp_ofc_cd='';
				$pp_post_stat='';
				$pp_join='';
				
			}
		    if ($row['post_status']=='P1' || $row['post_status']=='P2' || $row['post_status']=='P3' || $row['post_status']=='PA')
			{
				$p1_name=$row['person_name'];
				$p1_desig=$row['person_designation'];
				$p1_code=$row['personcd'];
				$p1_office=$row['office_name'];
				$p1_ofc_address=$row['office_address'];
				$p1_ofc_address1="P.O. - ".$row['post_office'].", Subdiv. - ".$row['subdivision'].", Dist. - ".$row['district'];
				$p1_ofc_cd="OFFICE - (".$row['officecd'].")";
				$p1_post_stat=$row['post_stat'];
				$p1_join=$p1_post_stat." PIN - (".$p1_code.")";
				
				$pr_name='';
				$pr_desig='';
				$pr_code='';
				$pr_office='';
				$pr_ofc_address='';
				$pr_ofc_address1='';
				$pr_ofc_cd='';
				$pr_post_stat='';
				$pr_join='';
				 if ($row['post_status']!='P1')
				 {
					$pp_name='';
					$pp_desig='';
					$pp_code='';
					$pp_office='';
					$pp_ofc_address='';
					$pp_ofc_address1='';
					$pp_ofc_cd='';
					$pp_post_stat='';
					$pp_join='';
				 }
				
				
				
			}
		    if ($row['post_status']=='P1')
			{
				$pp_name=$row['person_name'];
				$pp_desig=$row['person_designation'];
				$pp_code=$row['personcd'];
				$pp_office=$row['office_name'];
				$pp_ofc_address=$row['office_address'];
				$pp_ofc_address1="P.O. - ".$row['post_office'].", Subdiv. - ".$row['subdivision'].", Dist. - ".$row['district'];
				$pp_ofc_cd="OFFICE - (".$row['officecd'].")";
				$pp_post_stat=$row['post_stat'];
				$pp_join=$pp_post_stat." PIN - (".$pp_code.")";
				
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
			
			
		
		   $this->SetFont('Arial','B','7');
			$this->Cell($w[0],6,$row['groupid'],'LR',0,'L',$fill);						
			$this->Cell($w[1],6,$pr_name,'LR',0,'L',$fill);
			$this->Cell($w[2],6,$p1_name,'LR',0,'L',$fill);
			$this->Cell($w[3],6,$pp_name,'LR',0,'L',$fill);
			$this->Ln(4);
			
			$this->SetFont('Arial','','4.7');
			
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
			$this->MultiCell(190,4,"     ".$euname9.$euname10.$euname11,0,'J',$fill);
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
			$this->Cell(164);
			$this->Cell(10,10,$nb3,0,0,'R');
		
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',9);
			$this->Cell(160);
			$this->Cell(10,10,"District Election Officer",0,0,'R');
		
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
			$this->Ln(4);
			$this->MultiCell(190,4,$nb1.$nb2,0,'J',$fill);
			/*$this->Cell(10,10,$nb1,0,0,'L');
			$this->Ln(4);
			$this->SetFont('Arial','',8.5);
			$this->Cell(10,10,$nb2,0,0,'L');*/
			$this->Ln(4);
			
			
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