<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
//extract($_POST);
require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/training_fun.php');
$subdiv=(isset($_REQUEST['sub'])?decode($_REQUEST['sub']):'0');
	$t_venue=(isset($_REQUEST['t_venue'])?decode($_REQUEST['t_venue']):'0');
	$t_type=(isset($_REQUEST['txtto'])?decode($_REQUEST['t_type']):'0');
	$trn_sch=(isset($_REQUEST['trn_sch'])?decode($_REQUEST['trn_sch']):'0');
	$p_id=(isset($_REQUEST['p_id'])?decode($_REQUEST['p_id']):'0');
	
	$env=isset($_SESSION['environment'])?$_SESSION['environment']:"";
	$distnm_cap=isset($_SESSION['distnm_cap'])?$_SESSION['distnm_cap']:"";

	
	/*if($from>$hid_rec || $to>$hid_rec)
	{
		echo "Please check record no";
		exit;
	}*/
$rsApp=fatch_personnel_ag_sch_absent_print($trn_sch,$p_id);

//echo $subdiv;
class PDF extends FPDF
{

function Header()
{
	
}

// Page footer
function Footer()
{
	
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
	$signature="../images/deo/img.jpg";
    for($i=1;$i<=rowCount($data);$i++)
	{
		$this->SetFont('Arial','',9);
		$row=getRows($data);
		if($count<$per_page)
	    {
			$memo_no=(isset($_REQUEST['memo_no'])?decode($_REQUEST['memo_no']):'0');
	        $date=(isset($_REQUEST['date'])?decode($_REQUEST['date']):'0');
	
			$euname="Government of West Bengal";
			$euname1="Office of the District Election Officer & District Magistrate, ".wordcase($_SESSION['distnm_cap']);
			$euname2="Memo No: ".$memo_no;
			$euname3="( Polling Personnel Cell )";
			$euname4="Dated : ".date("d/m/Y",strtotime($date));
			
			$euname5="To";
			$euname6=$row['0']." (PIN :- ".$row['2'].") ,".$row['1'];
			$euname7=$row['ofc_address'].",".$row['district'].",".$row['pin'].", Mobile :- ".$row['mob_no'];	
			$euname8=$row['office'].",(Office Code :- ".$row['officecd'].")";	
			$euname9="Sub : Show Cause for not attending Election Duty";
			$euname10="       WHEREAS, it has been found that in spite of service of appointment letter for performing duty of ".$row['poststatus']." General Election to West Bengal Legistlative Assembly Election, 2016 under this office order no. ".$_SESSION['apt1_orderno']." dated ".$_SESSION['apt1_date'].", you have intentionally and deliberately kept yourself absent from attending the scheduled Training Programme leading to serious dislocation of the entire election process.";
			$euname11="       NOW, THEREFORE, you are directed to Show Cause as to why action as per provisions under Section 28A / 134 of the Representation of People Act, 1951 will not be taken against you.";
			$euname12="        Your written reply shall have to reach to this end within two days from the date of receipt of this letter.";
			$euname13="      You are further directed to attend the mop up training programme positively as per schedule attached, failing which appropriate penal measures will be taken against you without any further correspondence from this end.";
			
			$euname14="&                  ";
			$euname15="District Magistrate, ".wordcase($_SESSION['distnm_cap']);
			$nb1="Head of the office/DDO of ".$euname8." with a request to serve the same to the above mentioned employee.A consolidated reply should reach to this end, within two days from the date of receipt of this show cause notice.";
		
			
			$this->SetFont('Arial','',11);
			$this->Cell(190,10,$euname,0,0,'C');
			   
			// Line break
			$this->Ln(4);
			
			$this->SetFont('Arial','',11);
			$this->Cell(190,10,$euname1,0,0,'C');
			// Line break
			$this->Ln(4);
			
			$this->SetFont('Arial','',11);
			$this->Cell(190,10,$euname3,0,0,'C');
			// Line break
			$this->Ln(4);
			

			$this->Cell(15,10,$euname2,0,0,'L');
			$this->Cell(70);
			$this->Cell(40,8,"",0,0,'C');
	
			$this->Cell(50);
			$this->Cell(10,6,$euname4,0,0,'R');
			// Line break
			$this->Ln(18);
			
			$this->SetFont('Arial','',7.3);
			$this->Cell(15,4,$euname5,0,0,'L');
			$this->Ln(5);
			

			$this->Cell(190,4,$euname6,0,0,'L');
			$this->Ln(4);
			
		
			$this->Cell(190,4,$euname7,0,0,'L');
			$this->Ln(4);
			
		
			$this->Cell(190,4,$euname8,0,0,'L');
			$this->Ln(12);
			
			$this->SetFont('Arial','B',10);
			$this->Cell(55);
			$this->Cell(83,4,$euname9,'B',0,'C');
			$this->Ln(15);
			
			$this->SetFont('Arial','',10);
			$this->MultiCell(190,4,$euname10,0,'J');
			$this->Ln(4);
			
		
			$this->MultiCell(190,4,$euname11,0,'J');
			$this->Ln(4);
			

			$this->MultiCell(190,4,$euname12,0,'J');
			$this->Ln(4);
			
			$this->MultiCell(190,4,$euname13,0,'J');
			$this->Ln();
			
			$this->Ln(15);
			$this->SetFillColor(255,255,255);
		//	$this->SetTextColor(0,0,0);
			$this->SetDrawColor(0,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','');
			  
			/*$head = array('Date of Training','Training Venue','Time');
			$w = array(40,120,30);
			//	$this->SetFont('Arial','',9);
			for($j=0;$j<count($head);$j++)
				$this->Cell($w[$j],7,$head[$j],1,0,'C',true);
			$this->Ln();
			$this->SetFont('Arial','',7);
			$this->Cell($w[0],7,$row['training_dt'],'LTR',0,'C',$fill);						
			$this->Cell($w[1],7,$row['venuename'],'LTR',0,'C',$fill);
			$this->Cell($w[2],7,$row['training_time'],'LTR',0,'C',$fill);
		    $this->Ln();
			$this->Cell(array_sum($w),0,'',1,0,'L',$fill);
			$this->Ln();
			
			$this->Ln(14);*/
			
			$this->SetFont('Arial','',9);
			$this->Cell(30,1,'',0,0,'L');
			$this->SetFont('Arial','',10);			
			$this->Cell(127);
		//	$this->Cell(10,10,"yuyu",0,0,'R');
			$this->Cell(10, 10, $this->Image($signature, $this->GetX(), $this->GetY(), 30.78), 0, 0, 'R', false );
			// Line break
			$this->Ln(6);
			
			$this->SetFont('Arial','',9);
		
			$this->Cell(190,10,"District Election Officer",0,0,'R');
		
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',9);
	
			$this->Cell(190,10,$euname14,0,0,'R');
			
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',9);

			$this->Cell(190,10,$euname15,0,0,'R');
			
			$this->Ln(17);
			
			$this->Cell(15,10,$euname2,0,0,'L');
			$this->Cell(70);
			$this->Cell(40,8,"",0,0,'C');
	
			$this->Cell(50);
			$this->Cell(10,6,$euname4,0,0,'R');
			$this->Ln(6);
			
			$this->Cell(190,10,"Copy forwarded for information to : ",0,0,'L');
			$this->Ln();
	
			$this->SetFont('Arial','',9);
		
			$this->MultiCell(190,4,"1)   ".$nb1,0,'J');
			$this->Ln(4);
			
			$this->SetFont('Arial','',9);
			$this->Cell(30,1,'',0,0,'L');
			$this->SetFont('Arial','',10);			
			$this->Cell(127);
		//	$this->Cell(10,10,"yuyu",0,0,'R');
			$this->Cell(10, 10, $this->Image($signature, $this->GetX(), $this->GetY(), 30.78), 0, 0, 'R', false );
			// Line break
			$this->Ln(6);
			
			$this->SetFont('Arial','',9);
		
			$this->Cell(190,10,"District Election Officer",0,0,'R');
		
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',9);
	
			$this->Cell(190,10,$euname14,0,0,'R');
			
			// Line break
			$this->Ln(4);
			$this->SetFont('Arial','',9);

			$this->Cell(190,10,$euname15,0,0,'R');
			
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
   $header='';
	$data=$rsApp;
    $pdf->SetFont('Arial','',4);
    $pdf->AddPage();
	//$pdf->Image('284.jpeg',10, 20, 0, 0, '','http://localhost/birbhumelection/sig/');
	$pdf->FancyTable($header,$data);

$pdf->Output();
?>