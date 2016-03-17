<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/appointment_fun.php');
extract($_GET);
$group_id='';
	//if(isset($_GET['assembly']) && $_GET['assembly']!=null)
$subdiv=isset($_GET["subdivision"])?decode($_GET["subdivision"]):"";
$forassembly=isset($_GET["assembly"])?decode($_GET["assembly"]):"";
	//	exit;
	
$forpc='';
//$rec_set_hdr=master_roll_second_app_hrd($forassembly,$forpc,$group_id);
$rec_set_hdr=master_roll_second_app_venue_wise_party($forassembly,$subdiv);
class PDF extends FPDF
{

function Header()
{
	//$this->SetFont('','B',10);
	//$this->Cell(275,5,'VENUE WISE (POLLING PERSONNEL)',0,0,'C');
	//$this->Ln();
//	$this->SetFont('','B',9);
	//$this->Cell(275,5,'ASSEMBLY ELECTION 2016',0,0,'C');
	//$this->Ln(7);
	//$this->Cell(275,0,"",1,0,'C');
	//$this->Ln(4);
    $forassembly=isset($_GET["assembly"])?decode($_GET["assembly"]):"";
	$rsAssembly=assembly_name_ag_code($forassembly);
	$rowAssembly=getRows($rsAssembly);
	$assem="ASSEMBLY : ".$rowAssembly['assemblycd']." - ".$rowAssembly['assemblyname'];
	$this->SetFont('','B',10);
	$this->Cell(275,4,$assem,0,0,'C');
	$this->Ln(6);
	//$this->Cell(275,0,'',1,0,'C');
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
		//$this->SetFont('Arial','',9);
		$rec_arr_hdr=getRows($data);
				
		if($count<$per_page)
	    {
			$forassembly=isset($_GET["assembly"])?decode($_GET["assembly"]):"";
			$date=new DateTime($rec_arr_hdr['training_date']);
			
			//$assem="ASSEMBLY : ".$rec_arr_hdr['assembly']." - ".$rec_arr_hdr['assembly_name'];
		  //  $venue=", VENUE : ".$rec_arr_hdr['training_venue'].", ".$rec_arr_hdr['venue_addr1'].", ".$rowTV['venue_addr2'];
		    $venue="VENUE : ".$rec_arr_hdr['training_venue'];
			$venue1= " on ".$date->format('d/m/Y')." from ".$rec_arr_hdr['training_time'];
		    $venue_cd=$rec_arr_hdr['venuecode'];
		
		
			
			$this->SetFont('','B',7.7);
			$this->Cell(275,5,$venue.$venue1,"LTR",0,'L');
			$this->Ln(5);
			//$this->Cell(275,5,$venue1,"LR",0,'L');
			//$this->Ln();
			
		    $rec_set_ven=master_roll_second_app_venue_wise_party_group($venue_cd,$forassembly);	
			$count1=0;
	        $per_page1=3;
			$num_rows_ven=rowCount($rec_set_ven);
	
			for($j=1;$j<=$num_rows_ven;$j++)
			{
				
				$rec_arr_hdr_g=getRows($rec_set_ven);
			    if($count1<$per_page1)
	            {
							$this->SetFont('','B',8);	
							$grp_id=$rec_arr_hdr_g['groupid'];
							$this->Cell(275,5,"Polling Party : ".$grp_id,'LTR',0,'C');
							$this->Ln();
							$this->SetFillColor(255,255,255);
						//	$this->SetTextColor(0,0,0);
							$this->SetDrawColor(0,0,0);
							$this->SetLineWidth(.3);
							$this->SetFont('','B');
							$w = array(25,250);
							
							
							$rec_set=master_roll_second_appointment_letter($grp_id,$rec_arr_hdr_g['assembly']);
							$num_rows=rowCount($rec_set);
							for($k=0;$k<$num_rows;$k++)
							{
								$this->SetFont('','',6);
								$rec_arr=getRows($rec_set);
								$p_dtl="NAME - ".$rec_arr['officer_name'].", DESG. - ".$rec_arr['off_desg'].", PIN - (".$rec_arr['personcd']."), OFFICE NAME - ".$rec_arr['office'];
								$p_dtl1="ADDRESS - ".$rec_arr['address1'].", ".$rec_arr['address2'];
								$p_dtl2=", P.O. - ".$rec_arr['postoffice'].", Subdiv.-".$rec_arr['subdivision'].", Dist.-".$rec_arr['district'].", PIN - ".$rec_arr['pin'].", OFFICE - ".$rec_arr['officecd'].")";
												
				
								$this->Cell($w[0],4.5,$rec_arr['poststat'],"LTR",0,'C',$fill);						
								$this->Cell($w[1],4.5,$p_dtl,"LTR",0,'L',$fill);
								$this->Ln(4);
								$this->Cell($w[0],4.3,"","LR",0,'L',$fill);						
								$this->Cell($w[1],4.3,$p_dtl1.$p_dtl2,"LR",0,'L',$fill);
								$this->Ln();
								$this->Cell(array_sum($w),0,'',1,0,'L',$fill);
								$this->Ln();
							}
					 $count1++;
				}
				if($count1==$per_page1)
				{
					$per_page1=$per_page1+3;
					if($count1!=$num_rows_ven)
					{		
					  $this->AddPage();
					}
				}
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

     $pdf = new PDF('L','mm','A4');
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