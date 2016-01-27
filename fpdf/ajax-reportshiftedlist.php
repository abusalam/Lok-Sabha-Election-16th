<?php
session_start();
extract($_POST);
require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/add_fun.php');
include_once('../function/pagination.php');
//include_once('../inc/db_trans.inc.php');
//include_once('../function/application_fun.php');
$pacno=$_REQUEST["pacno"];
$partno=$_REQUEST["partno"];
$usercode=$_SESSION['user_cd'];
//echo $c_id =  decode($_GET['DeA']);
//$page=0;


$rs_fatch_beneficiary=fatch_reportShiftedList($pacno,$partno,$usercode);
//$num_rows = rowCount($rs_fatch_beneficiary);

class PDF extends FPDF
{

function Header()
{
	//$this->SetXY(10,10);
	$bMname2="CERTIFICATE TO BE FURNISHED BY EROS FOR DELETION OF ENTRIES IN CASE OF SHIFTED ELECTORS";
	$bMname="It is hereby certified that the following electors' claims for inclusion of their names have already been accepted and entered in the Electoral roll against their applications in Form 6  ";
	$bMname1="during the activity of SRER 2016.The concerened EROs may initiate necessary action to delete their names from the electoral roll from the ACs as they have been enroled elsewhere. ";
	//$acnumber = "AC NO : " .decode($_GET['XTr']);
//	$part = "PART NO: " .decode($_GET['DeA']);
    // Logo
    //$this->Image('logo.png',10,6,30);
    // Arial bold 15
	
    $this->SetFont('Arial','B',12);
    // Move to the right
    $this->Cell(120);
    // Title
    $this->Cell(30,10,$bMname2,0,0,'C');
	
    $this->Ln();
	//$this->Cell(90);
	//$this->SetFont('Arial','B',8);
	//$this->Cell(20,10,$pacno1,0,0,'C');
	
	$this->SetFont('Arial','B',9);
	$this->Cell(120);
    $this->Cell(30,10,$bMname,0,0,'C');
    $this->Ln(4);
    $this->SetFont('Arial','B',9);
    $this->Cell(120);
	$this->Cell(30,10,$bMname1,0,0,'C');
    
   
    // Line break
     $this->Ln();
	
	
	 $this->SetFillColor(253,236,236);
    $this->SetTextColor(10,10,10);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
	  
	   $header = array('Sl No','Name', 'Relationship Name', 'District','AC No.','AC Name','Part No','Serial No','Epic No');
	$w = array(10, 55, 55, 34, 13, 44, 15,15, 36);
		$this->SetFont('Arial','',9);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		 
    $this->Ln();
}

// Page footer
function Footer()
{
	//$this->SetY(-30);
	$pacno1=$_REQUEST["pacno"];
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

	$Sig ="(Signature of ERO)";
	$this->Cell(220);
	$this->Cell(30,5,$Sig,0,0,'C');
	$this->Ln(5);
	
	$TOTAL = $rowacp['assemblycd']." & ".$rowacp['assemblyname'];
	//$TOTAL =$pacno;
	$this->Cell(220);
	$this->Cell(30,5,$TOTAL,0,0,'C');
	
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
   
	$w = array(10, 55, 55, 34, 13, 44, 15,15, 36);
 
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    //$this->SetDisplayMode('fullwidth','default');
    // Data
    $fill = false;
	$count=0;
	$per_page=24;
    for($i=1;$i<=rowCount($data);$i++)
	{
		$this->SetFont('Arial','',9);
		$row=getRows($data);
		if($count<$per_page)
	    {
			$name=$row['1']." ".$row['2']." ".$row['3'];
			$rname=$row['4']." ".$row['5']." ".$row['6'];
			if($row['14']!=29)
			{
			  $state=$row['15'];
			  $acname="";
			}
			else
			{
			   $acname=$row['12'];
			   $state=$row['13'];	
			}
			   
			$this->Cell($w[0],6,$i,'LR',0,'L',$fill);
			$this->Cell($w[1],6,$name,'LR',0,'L',$fill);
			$this->Cell($w[2],6,$rname,'LR',0,'L',$fill);
			$this->Cell($w[3],6,$state,'LR',0,'L',$fill);
			$this->Cell($w[4],6,$row['8'],'LR',0,'L',$fill);
			$this->Cell($w[5],6,$acname,'LR',0,'L',$fill);
			$this->Cell($w[6],6,$row['9'],'LR',0,'L',$fill);
			$this->Cell($w[7],6,$row['10'],'LR',0,'L',$fill);
			$this->Cell($w[8],6,$row['11'],'LR',0,'L',$fill);
			$this->Ln();
			$fill = !$fill;
		    $count++;
		}
		if($count==$per_page)
		{
			$per_page=$per_page+24;
			$this->AddPage();
		} 
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
 }
}

     $pdf = new PDF('L','mm','A4');
      // Column headings
      $header = array('Sl No','Name', 'Relationship Name', 'District','AC No.','AC Name','Part No','Serial No','Epic No');
   // Data loading
 
	$data=$rs_fatch_beneficiary;
    $pdf->SetFont('Arial','',4);
    $pdf->AddPage();
	//$pdf->Image('284.jpeg',10, 20, 0, 0, '','http://localhost/birbhumelection/sig/');
	$pdf->FancyTable($header,$data);

$pdf->Output();
?>