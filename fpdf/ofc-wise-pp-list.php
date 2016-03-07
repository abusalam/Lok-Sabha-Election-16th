<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
extract($_POST);
require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/ofc_fun.php');
$subdiv=isset($_POST['Subdivision'])?$_POST['Subdivision']:"";
$office_cd=isset($_POST['office'])?$_POST['office']:"";
$from=(isset($_POST['txtfrom'])?$_POST['txtfrom']:'0');
$to=(isset($_POST['txtto'])?$_POST['txtto']:'0');

if($subdiv=="")
{ 
    echo "Please Select Subdivision.";
	exit;
}
if($subdiv !='')
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
		if((($to)-($from))>100)
		{
			echo "Office records should not be greater than 100";
			exit;
		}
	}
	
$rsOff=office_details_ag_forsub($subdiv,$from-1,$to-$from+1);
$num_rows_Off=rowCount($rsOff);


class PDF extends FPDF
{

function Header()
{
	  $this->SetFont('','B',9);
	$this->Cell(190,5,'GENERAL ELECTION TO WEST BENGAL LEGISLATIVE ASSEMBLY ELECTION, 2016',0,0,'C');
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

	$per_page=1;

	
    for($i=1;$i<=rowCount($data);$i++)
	{
		$this->SetFont('Arial','',9);
		$rowOff=getRows($data);
		if($count<$per_page)
	    {
			$subdiv=isset($_POST['Subdivision'])?$_POST['Subdivision']:"";
			$office=$rowOff['officecd'];
			$office_dtl="OFFICE: (".$office."), ".$rowOff['office'].", ".$rowOff['address1'].", ".$rowOff['address2'];
			
			$office_dtl1=" P.O.-".$rowOff['postoffice'].", Subdiv-".$rowOff['subdivision'].", Block/Muni - ".$rowOff['blockmuni'].", P.S.-".$rowOff['policestation'].", Dist.-".$rowOff['district'].", PIN-".$rowOff['pin'];
			
			//$this->Ln();
			//$this->Cell(190,0,'',1,0,'L');
			$this->Ln();
			$this->SetFont('','B',7.3);
			$this->MultiCell(190,4,$office_dtl.$office_dtl1,'LTR','J');
			
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
	
			$rsPersonnel=office_n_forsub_wise_list($office,$subdiv);
			for($k=1;$k<=rowCount($rsPersonnel);$k++)
	        {
				$rowPersonnel=getRows($rsPersonnel);
				$this->SetFont('','',6);

				
					$this->Cell($w[0],6,$rowPersonnel['personcd'],'LRT',0,'L',$fill);						
					$this->Cell($w[1],6,$rowPersonnel['officer_name'],'LRT',0,'L',$fill);
					$this->Cell($w[2],6,$rowPersonnel['designation'],'LRT',0,'L',$fill);
					$this->Cell($w[3],6,$rowPersonnel['poststatus'],'LRT',0,'L',$fill);
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
	$data=$rsOff;
    $pdf->SetFont('Arial','',4);
    $pdf->AddPage();
	$pdf->FancyTable($header,$data);

$pdf->Output();
?>