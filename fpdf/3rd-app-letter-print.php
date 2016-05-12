<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/appointment_fun.php');
extract($_GET);
//$group_id='';
	if(isset($_GET['assembly']) && $_GET['assembly']!=null)
		$forassembly=decode($_GET['assembly']);
	else
		exit;
	
	$forpc='';
$rec_set_hdr=third_app_print($forassembly);

class PDF extends FPDF
{

function Header()
{
	//$this->SetFont('','B',11);
//	$this->Cell(275,5,'MASTER ROLL (POLLING PERSONNEL)',0,0,'C');
	//$this->Ln(6);
//	$this->SetFont('','B',9);
	//$this->Cell(275,5,'ASSEMBLY ELECTION 2016',0,0,'C');
	//$this->Ln(7);
	//$this->Cell(275,0,"",1,0,'C');
	//$this->Ln(4);
	if(isset($_GET['assembly']) && $_GET['assembly']!=null)
		$forassembly=decode($_GET['assembly']);
	else
		exit;
	$rsAssembly=assembly_name_ag_code($forassembly);
	$rowAssembly=getRows($rsAssembly);
	$assem="ASSEMBLY : ".$rowAssembly['assemblycd']." - ".$rowAssembly['assemblyname'];
	$this->SetFont('','B',9);
	$this->Cell(190,4,$assem,0,0,'C');
	$this->Ln(8);
	//$this->Cell(275,0,'',1,0,'C');
	$fill = false;
	$this->SetFillColor(255,255,255);
	//	$this->SetTextColor(0,0,0);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
	$head = array('Party No','Table');
	$w = array(30,160);
	$this->SetFont('Arial','B',9);
	for($j=0;$j<count($head);$j++)
		$this->Cell($w[$j],7,$head[$j],1,0,'C',true);
	$this->Ln();

}

// Page footer
function Footer()
{	
}



function FancyTable($header, $data)
{
    $fill = false;
	$count=0;

	$per_page=30;
    $this->SetFillColor(255,255,255);
		//	$this->SetTextColor(0,0,0);
			$this->SetDrawColor(0,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			$w = array(30,160);

	
    for($i=1;$i<=rowCount($data);$i++)
	{
		$this->SetFont('Arial','',9);
		$rowOff=getRows($data);
		if($count<$per_page)
	    {
			
			$this->SetFont('Arial','',7);
			$this->Cell($w[0],6,$rowOff['groupid'],'LRT',0,'C',$fill);						
			//$this->Cell($w[1],6,$rowOff['psno']."".$rowOff['psfix'],'LRT',0,'C',$fill);
			$this->Cell($w[1],6,$rowOff['psname'],'LRT',0,'L',$fill);
			//count1++;
			
			$this->Ln();
			$this->Cell(array_sum($w),0,'',1,0,'L',$fill);
			$this->Ln();
					
	
			$fill = !$fill;
		    $count++;
		}
		if($count==$per_page)
		{
			$per_page=$per_page+30;
			//$this->AddPage();
		} 
	}
 }
}

     $pdf = new PDF('P','mm','A4');
      // Column headings
   //   $header = array('Name of Polling Officer');
   // Data loading
    $header="";
	$data=$rec_set_hdr;
    $pdf->SetFont('Arial','',4);
    $pdf->AddPage();
	//$pdf->Image('284.jpeg',10, 20, 0, 0, '','http://localhost/birbhumelection/sig/');
	$pdf->FancyTable($header,$data);

$pdf->Output();
?>