<?php
require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/application_fun.php');
class PDF extends FPDF
{

function Header()
{
    // Logo
    //$this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Title',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

// Better table
function ImprovedTable($header, $data)
{
    // Column widths
    $w = array(20, 20, 10, 10);
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],2,$header[$i],1,0,'C');
    $this->Ln();
    // Data

	
  
		for($i=1;$i<=rowCount($data);$i++)
			{
		     $row=getRows($data);
             $this->Cell($w[0],3,$row['name'],'LR',0,R);
             $this->Cell($w[1],3,$row[1],'LR');
             //$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
             //$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
            $this->Ln();
   			 }
			
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}


}

     $pdf = new PDF('L','mm','A4');;
      // Column headings
      $header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)' );
   // Data loading
     
	$code=3;
	$data=fatch_beneficiary_id($code);
	//$data=$rs_fatch_beneficiary;
    $pdf->SetFont('Arial','',6);
    $pdf->AddPage();
	$pdf->ImprovedTable($header,$data);
	

$pdf->Output();
?>