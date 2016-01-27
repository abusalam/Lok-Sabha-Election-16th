<?php
if(!isset($_SESSION))
{
	session_start();
}
?>
<?php

require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/application_fun.php');
$bmcode=$_SESSION['block_Mu'];
$fcode=$_SESSION['FinYer'];


$rs_fatch_beneficiary=fatch_beneficiary_Recomande_BDO_Report($bmcode,$fcode);

class PDF extends FPDF
{

function Header()

{
	
	$bMname="Submission Of proposal for Gitanjali Beneficiaries-15-16      Block: ".$_SESSION['block_name'];
    // Logo
    //$this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(120);
    // Title
   $this->Cell(30,10,$bMname,0,0,'C');
    
   
    // Line break
     $this->Ln();
	
	
	 $this->SetFillColor(253,236,236);
    $this->SetTextColor(10,10,10);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
	   $header = array('Sl.No','Name of Beneficiaries', 'EPIC No', 'Father/Husband Name','Village','GP','Income(Y)','Catagory','Land Details','Bank name','Branch Name','Account No','IFS Code' );
	  $w = array(6, 32, 15, 25, 25, 19, 10, 10, 55, 25, 30 ,17, 17);
		$this->SetFont('Arial','',4);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		 
    $this->Ln();
	
	 //$this->Cell(30,10,$bMname,0,0,'C');
	  
}

// Page footer
function Footer()
{
    $this->Cell(array_sum($w),0,'','T');
	// Position at 1.5 cm from bottom
	$this->Ln(5);
    $this->SetY(-14);
	$bMname1=$_SESSION['block_name']."Panchayat Samity                              ".$_SESSION['block_name']." Development Block                                                               ".$_SESSION['sdname']." Sub-Divisional officer";                                                                
    // Arial italic 8
    $this->SetFont('Arial','B',10);
    // Page number
	 $this->Cell(array_sum($w),0,'Sabhapati                                            Block Development officer                                                                  Sub-Divisional officer','LR',0,'C');
	$this->Ln(5);
$this->Cell(0,0,$bMname1,'LR',0,'C');
}



function FancyTable($header, $data)
{
    // Colors, line width and bold font
    /*$this->SetFillColor(253,236,236);
    $this->SetTextColor(10,10,10);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');*/
	
    // Header
    $w = array(6, 32, 15, 25, 25, 19, 10, 10, 55, 25, 30 ,17, 17);
   /* for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);*/
  //  $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    
    // Data
    $fill = false;
    for($i=1;$i<=rowCount($data);$i++)
		{
		$this->SetFont('Arial','',5);
		$row=getRows($data);
		$land_details="JL No:".$row['MouzaNo']."   MouzaName:".$row['MouzaName']."  Plot/Dag No:".$row['plotno']."  Area :".$row['area'];
        $this->Cell($w[0],6,$i,'LR',0,'L',$fill);
		$this->SetFont('Arial','',6);
        $this->Cell($w[1],6,$row['name'],'LR',0,'L',$fill);
			$this->SetFont('Arial','',5);
		$this->Cell($w[2],6,$row['epiccardno'],'LR',0,'L',$fill);
		$this->Cell($w[3],6,$row['fhname'],'LR',0,'L',$fill);
		$this->Cell($w[4],6,$row['Village'],'LR',0,'L',$fill);
		$this->Cell($w[5],6,$row['GPName'],'LR',0,'L',$fill);
		$this->Cell($w[6],6,$row['income'],'LR',0,'L',$fill);
		$this->Cell($w[7],6,$row['cat'],'LR',0,'L',$fill);
		
		$this->Cell($w[8],6,$land_details,'LR',0,'L',$fill);
	
		$this->Cell($w[9],6,$row['bank'],'LR',0,'L',$fill);
		$this->Cell($w[10],6,$row['branch'],'LR',0,'L',$fill);
        $this->Cell($w[11],6,$row['AccountNo'],'LR',0,'L',$fill);
		$this->Cell($w[12],6,$row['IFCCode'],'LR',0,'L',$fill);
        $this->Ln();
        $fill = !$fill;
		 
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}

     $pdf = new PDF('L','mm','A4');;
      // Column headings
      $header = array('Sl.No','Name of Beneficiaries', 'EPIC No', 'Father/Husband Name','Village','GP','Income(Y)','Catagory','Land Details','Bank name','Branch Name','Account No','IFS Code' );
   // Data loading
 
	$data=$rs_fatch_beneficiary;
    $pdf->SetFont('Arial','',4);
    $pdf->AddPage();
	$pdf->FancyTable($header,$data);
	

$pdf->Output();
?>