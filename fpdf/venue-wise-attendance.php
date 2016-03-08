<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
extract($_POST);
require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/training_fun.php');
$training_venue=$_POST['training_venue'];
$training_type=$_POST['training_type'];
$rsTV=venue_name_training_date_and_time($training_venue,$training_type);



class PDF extends FPDF
{

function Header()
{
	//$this->SetXY(10,10);
	$this->SetFont('','B',9);
	$this->Cell(195,5,'GENERAL ELECTION TO WEST BENGAL LEGISLATIVE ASSEMBLY ELECTION, 2016',0,0,'C');
	$this->Ln(8);
	$this->Cell(195,0,'',1,0,'C');
}

// Page footer
function Footer()
{
	//$this->SetY(-30);
	/*$pacno1=$_REQUEST["pacno"];
	$rsacp=fatch_assembly_part($pacno1);
    $rowacp=getRows($rsacp);
    $this->Cell(array_sum($w),0,'','T');
	$this->Ln(15);
	//$Sig1 ="../sig/".$pacno1.".jpeg";
	//$image1 = $rowacp['image_file'];
	//$pdf->Image($image1,50,30);
	/*$pdf->Cell(220);
	$this->Cell(30,5,$pdf->Image($image1,50,30),0,0,'C');
	$this->Ln(1);*/
	
//	$this->Image($Sig1,10,6,30);
  // $this->Cell( 20, 20, $pdf->Image('284.jpeg',10, 20, 0, 0, '','http://localhost/birbhumelection/sig/'), 0, 0, 'C');

	/*$Sig ="(Signature of ERO)";
	$this->Cell(220);
	$this->Cell(30,5,$Sig,0,0,'C');
	$this->Ln(5);
	
	$TOTAL = $rowacp['assemblycd']." & ".$rowacp['assemblyname'];
	//$TOTAL =$pacno;
	$this->Cell(220);
	$this->Cell(30,5,$TOTAL,0,0,'C');*/
	
	//$TOTAL = "Timeline";  
	//$this->Cell(30,10,$TOTAL,0,0,'C'); 
	/*$this->Ln(6);
	$tMname1="Timeline";
	$this->SetFont('Arial','B',9);
	$this->Cell(30,10,$tMname1,0,0,'C');
	$this->Ln(5);
	$tMname2="1. ERO will prepare the list in excel format and signed copy in PDF format by 13.10.2015 and send it to his/her own DEO.";
	$this->SetFont('Arial','B',9);
	$this->Cell(84);
	$this->Cell(30,10,$tMname2,0,0,'C');
	$this->Ln(4);
	$tMname3="2. DEO will compile the list (District/AC wise) in excel sheet and PDF format and share it with all DEOs outside his/her districty using CEOWB Web Portal by 15.10.2015.";
	$this->SetFont('Arial','B',9);
	$this->Cell(120);
	$this->Cell(30,10,$tMname3,0,0,'C');
	$this->Ln(4);
	$tMname4="3. Receiving DEO will download the Acwise list received from other DEOs through CEOWB Web portal and send those to concerned EROs of";
	$this->SetFont('Arial','B',9);
	$this->Cell(100);
	$this->Cell(30,10,$tMname4,0,0,'C');
	$this->Ln(4);
    $tMname5="his district for taking necessary action for deletion by 02.11.2015.";
	$this->SetFont('Arial','B',9);
    $this->Cell(46);
	$this->Cell(30,10,$tMname5,0,0,'C');
	$this->Ln(4);
	 $tMname6="4. ERO will dispose & flag all deletions in the Roll Data Entry Software by 09.11.2015.";
	$this->SetFont('Arial','B',9);
    $this->Cell(57);
	$this->Cell(30,10,$tMname6,0,0,'C');
	$this->Ln(3);*/
	
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
	$counter=0;

	//$signature="../images/deo/img.jpg";
    for($i=1;$i<=rowCount($data);$i++)
	{
		$this->SetFont('Arial','',9);
		$rowTV=getRows($data);
		if($count<$per_page)
	    {
			//$subdiv=isset($_POST['Subdivision'])?$_POST['Subdivision']:"";
			//$euname="ELECTION URGENT";
			//$office=$rowOff['officecd'];
			
			$date=new DateTime($rowTV['training_dt']);
		    $venue="VENUE : ".$rowTV['venuename'].", ".$rowTV['venueaddress1'].", ".$rowTV['venueaddress2'];
			$venue1= "on ".$date->format('d/m/Y')." from ".$rowTV['training_time'];
		    $venue_cd=$rowTV['venue_cd'];
		    $training_dt=$rowTV['training_dt'];
		    $training_time=$rowTV['training_time'];
			
		
			$this->Ln();
			$this->SetFont('','B',8);
			$this->Cell(195,5,$venue,"LTR",0,'L');
			$this->Ln(4);
			$this->Cell(195,5,$venue1,"LR",0,'L');
			$this->Ln();
			
			
			$this->SetFillColor(255,255,255);
		//	$this->SetTextColor(0,0,0);
			$this->SetDrawColor(0,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			
			$head = array('SlNo','PIN','Name','Designation','Posting Status','Enrollment Details','Token No','Signature');
			$header1 = array('','','','','','AC / Part /Sl No.','','');
			$w = array(10,15,40,40,22,25,18,25);
				$this->SetFont('Arial','',8);
			for($j=0;$j<count($head);$j++)
				$this->Cell($w[$j],7,$head[$j],'LTR',0,'C',true);
			$this->Ln();
			for($l=0;$l<count($header1);$l++)
				$this->Cell($w[$l],4,$header1[$l],'LR',0,'C',true);
			$counter=0;
			$this->Ln();
		//	$this->Cell(10,5,$subdiv,0,0,'L');
		   

			$rsPersonnel=venue_wise_list($venue_cd,$training_dt,$training_time);
			
			for($k=1;$k<=rowCount($rsPersonnel);$k++)
	        {
			$counter=$counter+1;
			
			
				
				$rowPersonnel=getRows($rsPersonnel);
			//	$sql="";
				$this->SetFont('','',5.2);
                   
				  $totaljoin=$rowPersonnel['acno']." / ".$rowPersonnel['partno']." / ".$rowPersonnel['slno'];
				  $token_join=$rowPersonnel['forsubdivision']." / ".$rowPersonnel['poststat']." / ".$rowPersonnel['token'];
				    $this->Cell($w[0],6,$counter,'LTR',0,'L',$fill);
					$this->Cell($w[1],6,$rowPersonnel['personcd'],'LTR',0,'L',$fill);						
					$this->Cell($w[2],6,$rowPersonnel['officer_name'],'LTR',0,'L',$fill);
					$this->Cell($w[3],6,$rowPersonnel['designation'],'LTR',0,'L',$fill);
					$this->Cell($w[4],6,$rowPersonnel['poststatus'],'LTR',0,'L',$fill);
					$this->Cell($w[5],6,$totaljoin,'LTR',0,'L',$fill);
					$this->Cell($w[6],6,$token_join,'LTR',0,'L',$fill);
					$this->Cell($w[7],6,'','LTR',0,'L',$fill);
					//count1++;
					$this->Ln();
					$r=fmod($counter,50);
					if($r==0)
					{   
						$this->AddPage();
						$this->Ln();
					}
					
					$this->Cell(array_sum($w),0,'',1,0,'L',$fill);
					$this->Ln();
					
			
			
			}
			
			
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
	$data=$rsTV;
    $pdf->SetFont('Arial','',4);
    $pdf->AddPage();
	//$pdf->Image('284.jpeg',10, 20, 0, 0, '','http://localhost/birbhumelection/sig/');
	$pdf->FancyTable($header,$data);

$pdf->Output();
?>