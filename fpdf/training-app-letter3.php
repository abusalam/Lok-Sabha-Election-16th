<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
//extract($_POST);
require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/appointment_fun.php');
$subdiv=(isset($_REQUEST['Subdivision'])?decode($_REQUEST['Subdivision']):'0');
	$from=(isset($_REQUEST['txtfrom'])?decode($_REQUEST['txtfrom']):'0');
	$to=(isset($_REQUEST['txtto'])?decode($_REQUEST['txtto']):'0');
	$hid_rec=(isset($_REQUEST['hid_rec'])?decode($_REQUEST['hid_rec']):'0');
	$office=(isset($_REQUEST['office'])?$_REQUEST['office']:'0');
	$env=isset($_SESSION['environment'])?$_SESSION['environment']:"";
	$distnm_cap=isset($_SESSION['distnm_cap'])?$_SESSION['distnm_cap']:"";
	if($from>$hid_rec || $to>$hid_rec)
	{
		echo "Please check record no";
		exit;
	}
	if($from>$to || $from<1 || $to<1)
	{
		echo "Please check record no";
		exit;
	}
	if((($to)-($from))>500)
	{
		echo "Records should not be greater than 500";
		exit;
	}
	
	/*if($from>$hid_rec || $to>$hid_rec)
	{
		echo "Please check record no";
		exit;
	}*/
$rsApp=first_app_letter3_print1($subdiv,$from-1,$to-$from+1);

//echo $subdiv;
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
	$signature="../images/deo/img.jpg";
    for($i=1;$i<=rowCount($data);$i++)
	{
		$this->SetFont('Arial','',9);
		$row=getRows($data);
		if($count<$per_page)
	    {
			
			$euname="ELECTION URGENT";
			$euname1="ORDER OF APPOINTMENT FOR TRAINING";
			$euname2="General Election to West Bengal Legislative Assembly 2016";
			$euname3="Token No. ".$row['token'];
			$euname4="Order No: ".$_SESSION['apt1_orderno'];
			$euname5="Date: ".$_SESSION['apt1_date'];
			$euname6="In exercise of the power conferred upon vide Section 26 of the R. P. Act, 1951, I do hereby appoint the officer specified below";
			$euname7="as ".$row['poststatus']." for undergoing training in connection with the conduct of General Election to West Bengal Legislative Assembly 2016.";
			//$euname8="$row[forpc]-$row[pcname] PC";			
			$euname9="The Officer should report for Training as per following Schedule.";
			$euname10="This is a compulsory duty on your part to attend the said programme, as per the provisions of The Representation of the People Act, 1951.";
			$euname11="You are directed to bring your Elector's Photo Identity Card (EPIC) or any proof of Identity affixed with your Photograph.";
			$euname12="Place: ".uppercase($_SESSION['distnm_cap']);
			$euname13="Date: ".date("d/m/Y");
			$euname14="".wordcase($_SESSION['distnm_cap']);
			$nb1="Please fillup Form 12 (for postal ballot) annexed herewith and submit at the Training Venue on the 1st day of training along with";
			$nb2="the duplicate copy of your appointment letter and a copy of EPIC or any other ID including service ID.";
			$nb3="Please indicate your PIN Number as given in your appointment letter on the body of Form 12 to help us locate you for delivery of";
			$nb4="postal ballot.Also indicate your EPIC Number on the body of Form 12 for verification of your Electoral roll entry.";
			$nb5="Please fill up the blank identity card sent herewith and paste your recent colour photograph and bring it at training venue for";
			$nb6="attestation.";
			$nb7="If the mobile no. is not submitted or incorrect, please inform PP cell.";
			$nb8="Please check your electoral data and bank details given below. For any inconsistancy please inform PP Cell.";
			$nb9="EPIC No. - $row[epic], Assembly - $row[acno], Part No. - $row[partno], Sl. No .- $row[slno] ";
			$nb89="Bank - $row[bank_name], Branch - $row[branch_name]";
			$nb10="A/c No.- $row[bank_acc_no], IFS Code- $row[ifsc_code]";
			
			
	
			$this->SetFont('Arial','B',8);
			$this->Cell(30,5,$euname,1,0,'L');
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(40,10,$euname1,0,0,'C');
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
			$this->Cell(30,8,$euname2,0,0,'C');
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(10,10,$euname5,0,0,'R');
			   
			// Line break
			$this->Ln(16);
			//$this->Cell(190,0,'',1,0,'L');
			//$this->Ln();
			
			$this->SetFont('Arial','',8.7);
			$this->Cell(88);
			$this->Cell(20,10,$euname6,0,0,'C');
			
			 // Line break
			$this->Ln(4);
			
			$this->SetFont('Arial','',8.7);
			//$this->Cell(80);
			$this->Cell(50,10,$euname7,0,0,'L');
		
			// Line break
			$this->Ln();
			
			$this->SetFont('Arial','',8.7);
			//$this->Cell(80);
			//$this->Cell(50,10,$euname8,0,0,'L');
		
			// Line break
			$this->Ln(10);
						
			//$this->SetFillColor(253,236,236);
			$this->SetFillColor(255,255,255);
		//	$this->SetTextColor(0,0,0);
			$this->SetDrawColor(0,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			  
			$head = array('Name of Polling Officer');
			$w = array(190);
			//	$this->SetFont('Arial','',9);
			for($j=0;$j<count($head);$j++)
				$this->Cell($w[$j],7,$head[$j],1,0,'C',true);
				 
			$this->Ln();
						
	        $name="              ".$row['0'].", ".$row['1']."                    PIN - ".$row['2']." ";
			//$name1=$row['0'].", ".$row['1'].", PIN - (".$row['2'].") ";
			$address="  ".$row['3'].", ".$row['4'].", P.O. - ".$row['5'];
			$ppo=" Subdiv - ".$row['6'].", P.S. - ".$row['7'].", Dist. - ".$row['8'].", PIN - ".$row['9'];
			$odetails="  OFFICE - (".$row['10'].")                                  Post Status - ".$row['12']."                                      Mobile No : ".$row['11'];
		    $this->SetFont('Arial','B',10);
			$this->Cell($w[0],5,$name,'LR',0,'L',$fill);
			$this->Ln();
			$this->SetFont('Arial','',8);
			$this->Cell($w[0],3,'','LR','L');
			$this->Ln();
			$this->MultiCell($w[0],4,$address.$ppo,'LR','J');

			$this->Cell($w[0],6,$odetails,'LRB',0,'L',$fill);
			$this->Ln(5);
			
			$this->SetFont('Arial','',8.7);
			$this->Cell(50,10,$euname9,0,0,'L');
		
			// Line break
			$this->Ln();
			
			$this->SetFont('','B');
			$header1 = array('Training Schedule');
			$header2 = array('Training','Venue & Address','Date & Time');
			$w1 = array(190);
			$w2 = array(24,136,30);
			//	$this->SetFont('Arial','',9);
			for($k=0;$k<count($header1);$k++)
				$this->Cell($w1[$k],7,$header1[$k],1,0,'C',true);
			$this->Ln();
			for($l=0;$l<count($header2);$l++)
				$this->Cell($w2[$l],7,$header2[$l],1,0,'C',true);	 
			$this->Ln();
			
			$this->SetFont('Arial','',7.5);
			$data1=fetch_ppwise_training($row['2']);
			for($m=1;$m<=rowCount($data1);$m++)
	        {
				$row2=getRows($data1);
				$this->Cell($w2[0],5,$row2['training_desc'],'LTR',0,'L',$fill);						
				$this->Cell($w2[1],5,$row2['venuename'],'LTR',0,'L',$fill);
				$this->Cell($w2[2],5,$row2['training_dt'],'LTR',0,'L',$fill);
				
				$this->Ln(4);
			    $this->Cell($w2[0],6,'','LR',0,'L',$fill);	
			    $this->Cell($w2[1],6,$row2['venueaddress'],'LR',0,'L',$fill);			
			    $this->Cell($w2[2],6,$row2['training_time'],'LR',0,'L',$fill);
				$this->Ln();
				$this->Cell(array_sum($w2),0,'',1,0,'L',$fill);
				$this->Ln();
			}
			/*$this->Cell($w2[0],6,$row['training_desc'],'LTR',0,'L',$fill);						
			$this->Cell($w2[1],6,$row['venuename'],'LTR',0,'L',$fill);
			$this->Cell($w2[2],6,$row['training_dt'],'LTR',0,'L',$fill);
			$this->Ln(4);
			$this->Cell($w2[0],6,'','LR',0,'L',$fill);	
			$this->Cell($w2[1],6,$row['venueaddress'],'LR',0,'L',$fill);			
			$this->Cell($w2[2],6,$row['training_time'],'LR',0,'L',$fill);
			$this->Ln();
			$this->Cell(array_sum($w2),0,'',1,0,'L',$fill);
			$this->Ln(5);*/
			
			$this->SetFont('Arial','',8.7);
			$this->Cell(50,10,$euname10,0,0,'L');
		
			// Line break
			$this->Ln(6);
			
			$this->SetFont('Arial','',8.7);
			$this->Cell(50,10,$euname11,0,0,'L');
		
			// Line break
			$this->Ln(11);
			
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
			$this->Ln(5);
			
			$this->SetFont('Arial','',9);
			$this->Cell(160);
			$this->Cell(6,10,"District Election Officer",0,0,'R');
		
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',9);
			$this->Cell(153);
			$this->Cell(10,10,$euname14,0,0,'R');
		
			// Line break
			$this->Ln();			
			$this->Cell(190,0,'',1,0,'L',$fill);
			$this->Ln();
			
			$this->SetFont('Arial','',10);
			//$this->Cell(160);
			$this->Cell(10,10,"NB.",0,0,'L');
			$this->Ln(4);
			
			$this->SetFont('Arial','',9);
			$this->Cell(10,10,"1.",0,0,'L');
			$this->Cell(10,10,$nb1,0,0,'L');
			$this->Ln(4);
			$this->SetFont('Arial','',9);
			$this->Cell(10,10,"",0,0,'L');
			$this->Cell(10,10,$nb2,0,0,'L');
			$this->Ln(5);
			
			$this->SetFont('Arial','',9);
			$this->Cell(10,10,"2.",0,0,'L');
			$this->Cell(10,10,$nb3,0,0,'L');
			$this->Ln(4);
			$this->SetFont('Arial','',9);
			$this->Cell(10,10,"",0,0,'L');
			$this->Cell(10,10,$nb4,0,0,'L');
			$this->Ln(5);
			
			$this->SetFont('Arial','',9);
			$this->Cell(10,10,"3.",0,0,'L');
			$this->Cell(10,10,$nb5,0,0,'L');
			$this->Ln(4);
			$this->SetFont('Arial','',9);
			$this->Cell(10,10,"",0,0,'L');
			$this->Cell(10,10,$nb6,0,0,'L');
			$this->Ln(5);
			
			$this->SetFont('Arial','',9);
			$this->Cell(10,10,"4.",0,0,'L');
			$this->Cell(10,10,$nb7,0,0,'L');
			$this->Ln(5);
			$this->SetFont('Arial','',9);
			$this->Cell(10,10,"5.",0,0,'L');
			$this->Cell(10,10,$nb8,0,0,'L');
			$this->Ln(4);
			$this->SetFont('Arial','',9);
			$this->Cell(10,10,"",0,0,'L');
			$this->Cell(10,10,$nb9,0,0,'L');
			$this->Ln(4);
			$this->SetFont('Arial','',9);
			$this->Cell(10,10,"",0,0,'L');
			$this->Cell(10,10,$nb89,0,0,'L');
			$this->Ln(4);
			
			$this->SetFont('Arial','',9);
			$this->Cell(10,10,"",0,0,'L');
			$this->Cell(10,10,$nb10,0,0,'L');
			$this->Ln();			
			//$this->Cell(190,0,'',1,0,'L',$fill);
			//$this->Ln(2);
			$this->Cell(190,0,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -',0,0,'L',$fill);
			$this->Ln();
			$this->SetFont('Arial','',9);
			$this->Cell(10,10,"Copy to DDO / Head of Office to serve the Letter and submit the service return.",0,0,'L');
			$this->Ln();
		//	$this->Cell(190,0,'',1,0,'L',$fill);
		//	$this->Ln(2);
			$this->Cell(190,0,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -',0,0,'L',$fill);
			$this->Ln(12);
			
			$this->SetFont('Arial','',9);
			$this->Cell(30,10,"Receipt of Appointment Letter",0,0,'L');
			$this->SetFont('Arial','',10);			
			$this->Cell(140);
			$this->Cell(10,10,"Signature of the Recepient",0,0,'R');
			$this->Ln(4);
			
			$this->SetFont('Arial','',9);
			$this->Cell(136);
			$this->Cell(10,10,"Date:",0,0,'R');
			$this->Ln();
			
			$bmname=$row['block_muni_name'];
			$this->SetFont('Arial','',9);
			$this->Cell(190,5,"Block/Municipality: ".$bmname,0,0,'C');
			
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
   $header='';
	$data=$rsApp;
    $pdf->SetFont('Arial','',4);
    $pdf->AddPage();
	//$pdf->Image('284.jpeg',10, 20, 0, 0, '','http://localhost/birbhumelection/sig/');
	$pdf->FancyTable($header,$data);

$pdf->Output();
?>