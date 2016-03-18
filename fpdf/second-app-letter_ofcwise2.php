<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
extract($_POST);
require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/training2_fun.php');
$subdiv=isset($_POST['Subdivision'])?$_POST['Subdivision']:"";
$office_cd=isset($_POST['office'])?$_POST['office']:"";
$from=(isset($_POST['txtfrom'])?$_POST['txtfrom']:'0');
$to=(isset($_POST['txtto'])?$_POST['txtto']:'0');

if($subdiv=="0")
{ 
    echo "Please Select Subdivision.";
	exit;
}
if($subdiv !='0')
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
		if((($to)-($from))>900)
		{
			echo "Office records should not be greater than 900";
			exit;
		}
	}
$rsOff=office_details_ag_forsuboffice2($subdiv,$from-1,$to-$from+1);
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
			$office_dtl="OFFICE : (".$office."), ".$rowOff['office'].", ".$rowOff['address1'].", ".$rowOff['address2'];
			
			$office_dtl1="P.O.-".$rowOff['postoffice'].", Subdiv-".$rowOff['subdivision'].", P.S.-".$rowOff['policestation'].", Dist.-".$rowOff['district'].", PIN-".$rowOff['pin'];
			
			//$this->Ln();
			//$this->Cell(190,0,'',1,0,'L');
			$this->Ln();
			$this->SetFont('','B',7.7);
			$this->Cell(190,5,$office_dtl,"LTR",0,'L');
			$this->Ln(4);
			$this->Cell(190,5,$office_dtl1,"LR",0,'L');
			$this->Ln();
			
			$this->SetFillColor(255,255,255);
		//	$this->SetTextColor(0,0,0);
			$this->SetDrawColor(0,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			
			$head = array('SL#','PIN','Name','Designation','Posting Status','Mobile No');
			$w = array(7,18,58,65,24,18);
			//	$this->SetFont('Arial','',9);
			for($j=0;$j<count($head);$j++)
				$this->Cell($w[$j],7,$head[$j],1,0,'C',true);
				 
			$this->Ln();
	
			$rsPersonnel=second_appoint_letter_ofcwise2($office,$subdiv);
			for($k=1;$k<=rowCount($rsPersonnel);$k++)
	        {
				$rowPersonnel=getRows($rsPersonnel);
				$poststat=$rowPersonnel['per_poststat'];
				$this->SetFont('','',6);
                 switch($poststat)
				 {
					  case ($poststat=='PR'):
					     $pin=$rowPersonnel['pr_personcd'];
						 $name=$rowPersonnel['pr_name'];
						 $desg=$rowPersonnel['pr_designation'];
						 $post_stat=$rowPersonnel['pr_post_stat'];
						 $mobno=$rowPersonnel['pr_mobno'];
						  break;
					  case ($poststat=='P1'):
					     $pin=$rowPersonnel['p1_personcd'];
						 $name=$rowPersonnel['p1_name'];
						 $desg=$rowPersonnel['p1_designation'];
						 $post_stat=$rowPersonnel['p1_post_stat'];
						 $mobno=$rowPersonnel['p1_mobno'];
						  break;
					  case ($poststat=='P2'):
					     $pin=$rowPersonnel['p2_personcd'];
						 $name=$rowPersonnel['p2_name'];
						 $desg=$rowPersonnel['p2_designation'];
						 $post_stat=$rowPersonnel['p2_post_stat'];
						 $mobno=$rowPersonnel['p2_mobno'];
						  break;
					  case ($poststat=='P3'):
					     $pin=$rowPersonnel['p3_personcd'];
						 $name=$rowPersonnel['p3_name'];
						 $desg=$rowPersonnel['p3_designation'];
						 $post_stat=$rowPersonnel['p3_post_stat'];
						 $mobno=$rowPersonnel['p3_mobno'];
						  break;
					  case ($poststat=='PA'):
					     $pin=$rowPersonnel['pa_personcd'];
						 $name=$rowPersonnel['pa_name'];
						 $desg=$rowPersonnel['pa_designation'];
						 $post_stat=$rowPersonnel['pa_post_stat'];
						 $mobno=$rowPersonnel['pa_mobno'];
						  break;
					case ($poststat=='PB'):
					     $pin=$rowPersonnel['pb_personcd'];
						 $name=$rowPersonnel['pb_name'];
						 $desg=$rowPersonnel['pb_designation'];
						 $post_stat=$rowPersonnel['pb_post_stat'];
						 $mobno=$rowPersonnel['pb_mobno'];
						  break;
					  default:
					   echo "";
					  break;
				 }
				    $this->Cell($w[0],6,$k,'LRT',0,'C',$fill);
					$this->Cell($w[1],6,$pin,'LRT',0,'L',$fill);						
					$this->Cell($w[2],6,$name,'LRT',0,'L',$fill);
					$this->Cell($w[3],6,$desg,'LRT',0,'L',$fill);
					$this->Cell($w[4],6,$post_stat,'LRT',0,'L',$fill);
					$this->Cell($w[5],6,$mobno,'LRT',0,'L',$fill);
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
	//$pdf->Image('284.jpeg',10, 20, 0, 0, '','http://localhost/birbhumelection/sig/');
	$pdf->FancyTable($header,$data);

$pdf->Output();
?>