<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
extract($_POST);
require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/ofc_fun.php');
$subdiv=isset($_POST['Subdivision'])?$_POST['Subdivision']:"";
$office_cd=isset($_POST['office'])?$_POST['office']:"";
$rsOff=office_details_ag_sub($office_cd,$subdiv);
$num_rows_Off=rowCount($rsOff);


class PDF extends FPDF
{

function Header()
{                   
    $this->SetFont('','B',9);
	$this->Cell(190,5,'ASSEMBLY ELECTION 2016',0,0,'C');
	$this->Ln(8);
	$this->Cell(190,0,'',1,0,'C');
}

// Page footer
function Footer()
{	
	
}

function FancyTable($header, $data)
{ 
   
	$fill = false;
	$count=0;
    $office_cd=isset($_POST['office'])?$_POST['office']:"";
	$per_page=35;

	
    for($i=1;$i<=rowCount($data);$i++)
	{
		$this->SetFont('Arial','',9);
		$rowOff=getRows($data);
		if($count<$per_page)
	    {
			//$subdiv=isset($_POST['Subdivision'])?$_POST['Subdivision']:"";
			//$euname="ELECTION URGENT";
			$office=$rowOff['officecd'];
			$office_dtl="OFFICE: (".$office."), ".$rowOff['office'].", ".$rowOff['address1'].", ".$rowOff['address2'];
			
			$office_dtl1=" P.O.-".$rowOff['postoffice'].", Subdiv-".$rowOff['subdivision'].", Block/Muni - ".$rowOff['blockmuni'].", P.S.-".$rowOff['policestation'].", Dist.-".$rowOff['district'].", PIN-".$rowOff['pin'];
			
			//$this->Ln();
			//$this->Cell(190,0,'',1,0,'L');
			$this->Ln();
			$this->SetFont('','B',7.3);
			$this->MultiCell(190,4,$office_dtl.$office_dtl1,'LTR','J');
			//$this->Ln(4);
			//$this->Cell(190,5,$office_dtl1,"LR",0,'L');
			//$this->Ln();
			
			$this->SetFillColor(255,255,255);
		//	$this->SetTextColor(0,0,0);
			$this->SetDrawColor(0,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			
			$head = array('PIN','Name','Designation','Posting Status');
			$w = array(25,60,77,28);
			//	$this->SetFont('Arial','',9);
			for($j=0;$j<count($head);$j++)
				$this->Cell($w[$j],7,$head[$j],1,0,'C',true);
				 
			$this->Ln();
		//	$this->Cell(10,5,$subdiv,0,0,'L');
		    
			$rsPersonnel=office_wise_list($office_cd);
			for($k=1;$k<=rowCount($rsPersonnel);$k++)
	        {
				$rowPersonnel=getRows($rsPersonnel);
				$this->SetFont('','',6);

				
					$this->Cell($w[0],6,$rowPersonnel['personcd'],'LR',0,'L',$fill);						
					$this->Cell($w[1],6,$rowPersonnel['officer_name'],'LR',0,'L',$fill);
					$this->Cell($w[2],6,$rowPersonnel['designation'],'LR',0,'L',$fill);
					$this->Cell($w[3],6,$rowPersonnel['poststatus'],'LR',0,'L',$fill);
					//count1++;
					
					$this->Ln();
					$this->Cell(array_sum($w),0,'',1,0,'L',$fill);
					$this->Ln();
					
			
				
			}
			 $this->Ln(10);
			 $this->SetFont('','B',9);
			 $this->Cell(50,5,"Head of the office signature  .................................",0,0,'L');
			$fill = !$fill;
		    $count++;
		}
		if($count==$per_page)
		{
			$per_page=$per_page+35;
			$this->AddPage();
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
	$data=$rsOff;
    $pdf->SetFont('Arial','',4);
    $pdf->AddPage();
	//$pdf->Image('284.jpeg',10, 20, 0, 0, '','http://localhost/birbhumelection/sig/');
	$pdf->FancyTable($header,$data);

$pdf->Output();
?>