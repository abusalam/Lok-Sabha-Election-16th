<?php
session_start();
extract($_REQUEST);
require('fpdf.php');

$user=$_REQUEST['user'];

$subdv=$_REQUEST['subdivision'];
$frmdate=$_REQUEST['frmdate'];
$todate=$_REQUEST['todate'];

date_default_timezone_set('Asia/Calcutta');
require_once('../inc/db_trans.inc.php');
$sql="Select office.officecd As officecd,
  office.office As office,
  office.address1 As address1,
  office.address2 As address2,
  office.postoffice As postoffice,
  district.district As district,
  policestation.policestation As policestation,
  office.pin As pin,
  govtcategory.govt_description As govt_description,
  institute.institute As institute,
  office.phone As phone,
  office.mobile As mobile,
  office.fax As fax,
  office.email As email,
  office.tot_staff As tot_staff,
  block_muni.blockmuni As blockmuni,
  office.blockormuni_cd As blockormuni_cd,
  office.usercode As usercode,
  office.posted_date As posted_date
From ((((block_muni
  Join office On block_muni.blockminicd = Convert(office.blockormuni_cd Using
    utf8))
  Join district On district.districtcd = office.districtcd)
  Join policestation On Convert(office.policestn_cd Using utf8) =
    policestation.policestationcd)
  Join govtcategory On govtcategory.govt = office.govt)
  Join institute On office.institutecd = institute.institutecd
  Join  subdivision On office.subdivisioncd = subdivision .subdivisioncd  ";
$sql.=" where office.officecd>0 ";
if($subdv!='' && $subdv!='0')
	$sql.="and office.subdivisioncd='$subdv' ";
if($frmdate!='' && $frmdate!=null)
	$sql.="and office.posted_date>='$frmdate' ";
if($todate!='' && $todate!=null)
	$sql.="and office.posted_date<='$todate' ";
 $sql.="order by office.office ASC"; 

$rs=execSelect($sql);

class PDF extends FPDF
{
	
function Header()
{
	$this->SetFont('','B',11);
	$this->Cell(282,5,'Checklist (office)',0,0,'C');
	$this->Ln(8);
}

function Footer()
{
	
	//$this->SetY(-20);
	
	//$this->Ln(0);
	 $this->Cell(282,0,'','T');
	//$this->Ln(15);
	
}



function FancyTable($header, $data)
{
	$w = array(10,22,40,27,183);
	$this->SetFillColor(255,255,255);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.3);
    $fill = false;
	$count=0;
	$per_page=13;
	
    for($i=1;$i<=rowCount($data);$i++)
	{
		$this->SetFont('Arial','',7.2);
		$row=getRows($data);
		$address=$row[1].", ".$row[2]." , ".$row[3]." , PO - ".$row[4];
		$institute=$row[9]." ,     Phone : "." "." ".$row[10].",      Mobile :  ".$row[11].",     Dist. -  ".$row[5].",    PIN - ".$row[7];
		$block=$row[15]." ,     (".$row[16].") ,      Fax :     ".$row[12]." ,      Email :   ".$row[13]." ,       Total Staff Strength :   ".$row[14];
		if($count<$per_page)
	    {
			
			$this->Cell($w[0],5,$i,'LTR',0,'C',$fill);
			$this->Cell($w[1],5,'Office Code :','LT',0,'L',$fill);
			$this->Cell($w[2],5,$row[0],'T',0,'L',$fill);
			$this->Cell($w[3],5,'Name and Address :','T',0,'L',$fill);
			$this->Cell($w[4],5,$address,'TR',0,'L',$fill);
	        $this->Ln(4);
					
			$this->Cell($w[0],5,"","LR",0,'C',$fill);
			$this->Cell($w[1],5,'Police Station :','L',0,'L',$fill);
			$this->Cell($w[2],5,$row[6],0,0,'L',$fill);
			$this->Cell($w[3],5,'Institute :',0,0,'L',$fill);
			$this->Cell($w[4],5,$institute,'R',0,'L',$fill);
	        $this->Ln(4);
			
			$this->Cell($w[0],5,"","LR",0,'C',$fill);
			$this->Cell($w[1],5,'Govt. Category :','L',0,'L',$fill);
			$this->Cell($w[2],5,$row[8],0,0,'L',$fill);
			$this->Cell($w[3],5,'Block/Municipality :',0,0,'L',$fill);
			$this->Cell($w[4],5,$block,'R',0,'L',$fill);
	        $this->Ln();
			
			
			$fill = !$fill;
		    $count++;
		}
		if($count==$per_page)
		{
			$per_page=$per_page+13;
			$this->AddPage();
		} 
    }


 }
}

   $pdf = new PDF('L','mm','A4');
    $header="";  
	$data=$rs;
    $pdf->SetFont('Arial','',4);
    $pdf->AddPage();
	
	$pdf->FancyTable($header,$data);

$pdf->Output();
?>
