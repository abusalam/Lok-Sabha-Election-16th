<?php
session_start();
extract($_POST);
require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/office_report_fun.php');
include_once('../function/pagination.php');
//include_once('../inc/db_trans.inc.php');
//include_once('../function/application_fun.php');
$offccd=isset($_REQUEST["offccd"])?decode($_REQUEST["offccd"]):"";
$Subdivision=isset($_REQUEST["Subdivision"])?decode($_REQUEST["Subdivision"]):"";
$Statusofoffice=isset($_REQUEST["Statusofoffice"])?decode($_REQUEST["Statusofoffice"]):"";
//echo $c_id =  decode($_GET['DeA']);
//$page=0;


$rs_fatch_beneficiary=fatch_offcDtl($offccd,$Subdivision,$Statusofoffice);
//$num_rows = rowCount($rs_fatch_beneficiary);

class PDF extends FPDF
{

function Header()
{
	//$this->SetXY(10,10);
	/*$bMname2="CERTIFICATE TO BE FURNISHED BY EROS FOR DELETION OF ENTRIES IN CASE OF SHIFTED ELECTORS";
	$bMname="It is hereby certified that the following electors' claims for inclusion of their names have already been accepted and entered in the Electoral roll against their applications in Form 6  ";
	$bMname1="during the activity of SRER 2016.The concerened EROs may initiate necessary action to delete their names from the electoral roll from the ACs as they have been enroled elsewhere. ";*/
	//$acnumber = "AC NO : " .decode($_GET['XTr']);
//	$part = "PART NO: " .decode($_GET['DeA']);
    // Logo
    //$this->Image('logo.png',10,6,30);
    // Arial bold 15
	
   /* $this->SetFont('Arial','B',12);
    // Move to the right
    $this->Cell(120);
    // Title
    $this->Cell(30,10,$bMname2,0,0,'C');*/
	
    $this->Ln();
	//$this->Cell(90);
	//$this->SetFont('Arial','B',8);
	//$this->Cell(20,10,$pacno1,0,0,'C');
	
	/*$this->SetFont('Arial','B',9);
	$this->Cell(120);
    $this->Cell(30,10,$bMname,0,0,'C');
    $this->Ln(4);
    $this->SetFont('Arial','B',9);
    $this->Cell(120);
	$this->Cell(30,10,$bMname1,0,0,'C');
    */
   
    // Line break
     $this->Ln();
	
	
	 $this->SetFillColor(253,236,236);
    $this->SetTextColor(10,10,10);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
	  
	   $header = array('Sl No','Office ID', 'Office Name', 'Office Status','Male','Female','Total');
	$w = array(15, 34, 110, 58, 20, 20, 20);
		$this->SetFont('Arial','',9);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		 
    $this->Ln();
}

// Page footer
function Footer()
{
	
    $this->Cell(277,0,'','T');
	$this->Ln(15);
	
}



function FancyTable($header, $data)
{
    // Colors, line width and bold font
   
	$w = array(15, 34, 110, 58, 20, 20, 20);
 
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    //$this->SetDisplayMode('fullwidth','default');
    // Data
    $fill = false;
	$count=0;
	$per_page=28;
    for($i=1;$i<=rowCount($data);$i++)
	{
		$this->SetFont('Arial','',9);
		$row=getRows($data);
		if($count<$per_page)
	    {
			
			$this->Cell($w[0],6,$i,'LR',0,'L',$fill);
			$this->Cell($w[1],6,$row['0'],'LR',0,'L',$fill);
			$this->Cell($w[2],6,$row['1'],'LR',0,'L',$fill);
			$this->Cell($w[3],6,$row['2'],'LR',0,'L',$fill);
			$this->Cell($w[4],6,$row['3'],'LR',0,'L',$fill);
			$this->Cell($w[5],6,$row['4'],'LR',0,'L',$fill);
			$this->Cell($w[6],6,$row['5'],'LR',0,'L',$fill);
			
			$this->Ln();
			$fill = !$fill;
		    $count++;
		}
		if($count==$per_page)
		{
			$per_page=$per_page+28;
			$this->AddPage();
		} 
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
 }
}

     $pdf = new PDF('L','mm','A4');
      // Column headings
     $header = array('Sl No','Office ID', 'Office Name', 'Office Status','Male','Female','Total');
   // Data loading
 
	$data=$rs_fatch_beneficiary;
    $pdf->SetFont('Arial','',4);
    $pdf->AddPage();
	//$pdf->Image('284.jpeg',10, 20, 0, 0, '','http://localhost/birbhumelection/sig/');
	$pdf->FancyTable($header,$data);

$pdf->Output();
?>