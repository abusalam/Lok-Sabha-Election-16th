<?php
session_start();
extract($_REQUEST);
require('fpdf.php');
$officename=isset($_REQUEST["office"])?$_REQUEST["office"]:"";
$subdivision=isset($_REQUEST["subdivision"])?$_REQUEST["subdivision"]:"";
//$officename=$_REQUEST['office'];
//$user=$_REQUEST['user'];
$frmdate=isset($_REQUEST["frmdate"])?$_REQUEST["frmdate"]:"";
$todate=isset($_REQUEST["todate"])?$_REQUEST["todate"]:"";

include_once('../inc/db_trans.inc.php');
/*$sql="Select personnel.officer_name As officer_name,
	  personnel.off_desg As designation,
	  personnel.personcd As personcd,
	  Date_Format(personnel.dateofbirth, _latin1'%d/%m/%Y') As dateofbirth,
	  personnel.gender As gender,
	  personnel.scale As scale,
	  personnel.basic_pay As basic_pay,
	  personnel.grade_pay As grade_pay,
	  qualification.qualification As qualification,
	  personnel.email As email,
	  personnel.resi_no As resi_no,
	  personnel.mob_no As mob_no,
	  language.language As language,
	  personnel.present_addr1 As present_addr1,
	  personnel.present_addr2 As present_addr2,
	  personnel.perm_addr1 As perm_addr1,
	  personnel.perm_addr2 As perm_addr2,
	  personnel.acno As acno,
	  personnel.epic As epic,                         
	  personnel.partno As partno,
	  personnel.slno As slno,
	 
	  personnel.bank_acc_no As bank_acc_no,
	  personnel.assembly_temp As assembly_temp,
	  personnel.assembly_perm As assembly_perm,
	  personnel.assembly_off As assembly_off,
	  
	  personnel.bank_cd As bank_cd,
	  bank.bank_name As bank_name,
	  
	  (Select branch.ifsc_code from branch where branch.branchcd = personnel.branchcd and branch.bank_cd = personnel.bank_cd)As ifsc_code,
	  (Select branch.branch_name from branch where branch.branchcd = personnel.branchcd and branch.bank_cd = personnel.bank_cd) As branch_name,
	  (Select branch.address from branch where branch.branchcd = personnel.branchcd and branch.bank_cd = personnel.bank_cd) As address,
	  
	  personnel.remarks As remarks,
	  personnel.officecd As officecd,
	  office.office As office,
	  office.address1 As address1,
	  office.address2 As address2,
	  office.postoffice As postoffice,
	  district.district As district,
	  office.pin As pin,
	  personnel.usercode As usercode,
	  personnel.posted_date As posted_date,
	  personnel.workingstatus As postat,
	  office.officer_desg As headofc,
	  poststat.poststatus As poststatus
	  
		From (((((personnel
	  Left Join bank On bank.bank_cd = personnel.bank_cd)
	  Join qualification On qualification.qualificationcd =
		personnel.qualificationcd)
	  Join language On language.languagecd = personnel.languagecd)
	  Join poststat On poststat.post_stat = personnel.poststat)	  
	  Join office On personnel.officecd = office.officecd)
	  Join district On office.districtcd = district.districtcd	  
	  Left Join termination On personnel.personcd = termination.personal_id ";
$sql.=" where personnel.personcd>0 And termination.personal_id Is Null ";

if($subdivision!='' && $subdivision!='0')
	$sql.="and personnel.subdivisioncd='$subdivision' ";	
if($frmdate!='' && $frmdate!=null)
	$sql.="and personnel.posted_date>='$frmdate' ";
if($todate!='' && $todate!=null)
	$sql.="and personnel.posted_date<='$todate' ";
if($officename!='' && $officename!='0')
	$sql.="and personnel.officecd='$officename' ";	
	
$sql.="order by personnel.subdivisioncd,personnel.officecd ASC";

//ini_set('max_execution_time', 900);
$rs=execSelect($sql);
$num_rows=rowCount($rs);*/
$sql1="Select 
	  personnel.officecd As officecd,
	  office.office As office
	  
		From (personnel	  
	  Join office On personnel.officecd = office.officecd)
	  Join district On office.districtcd = district.districtcd	  
	  Left Join termination On personnel.personcd = termination.personal_id ";
$sql1.=" where personnel.personcd>0 And termination.personal_id Is Null ";

if($subdivision!='' && $subdivision!='0')
	$sql1.="and personnel.subdivisioncd='$subdivision' ";	
if($frmdate!='' && $frmdate!=null)
	$sql1.="and personnel.posted_date>='$frmdate' ";
if($todate!='' && $todate!=null)
	$sql1.="and personnel.posted_date<='$todate' ";
if($officename!='' && $officename!='0')
	$sql1.="and personnel.officecd='$officename' ";
	$sql1.="group by personnel.officecd ";
	$sql1.="order by personnel.officecd ";
$rs=execSelect($sql1);

class PDF extends FPDF
{
	
function Header()
{
	/*$officename=isset($_REQUEST["office"])?$_REQUEST["office"]:"";
$subdivision=isset($_REQUEST["subdivision"])?$_REQUEST["subdivision"]:"";
//$officename=$_REQUEST['office'];
//$user=$_REQUEST['user'];
$frmdate=isset($_REQUEST["frmdate"])?$_REQUEST["frmdate"]:"";
$todate=isset($_REQUEST["todate"])?$_REQUEST["todate"]:"";
    $sql1="Select 
	  personnel.officecd As officecd,
	  office.office As office
	  
		From (personnel	  
	  Join office On personnel.officecd = office.officecd)
	  Join district On office.districtcd = district.districtcd	  
	  Left Join termination On personnel.personcd = termination.personal_id ";
$sql1.=" where personnel.personcd>0 And termination.personal_id Is Null ";

if($subdivision!='' && $subdivision!='0')
	$sql1.="and personnel.subdivisioncd='$subdivision' ";	
if($frmdate!='' && $frmdate!=null)
	$sql1.="and personnel.posted_date>='$frmdate' ";
if($todate!='' && $todate!=null)
	$sql1.="and personnel.posted_date<='$todate' ";
if($officename!='' && $officename!='0')
	$sql1.="and personnel.officecd='$officename' ";
$rs_header=execSelect($sql1);
$row_header=getRows($rs_header);
$ofcc=$row_header[1].",          Code :   (".$row_header[0].")";

	$this->SetFont('','B',11);
	$this->Cell(282,5,'Checklist (Polling Personnel)',0,0,'C');
	$this->Ln(8);
	
	$this->SetFont('','B',8.7);
	$this->Cell(282,8,$ofcc,'LTR',0,'C');
	$this->Ln();*/
	
}

// Page footer
function Footer()
{
	$this->Cell(282,0,'','T');

}



function FancyTable($header, $data)
{
    // Colors, line width and bold font
   
	$w = array(7,23,161,22,30,12,27);
 
    // Color and font restoration
    $this->SetFillColor(255,255,255);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.3);
    //$this->SetDisplayMode('fullwidth','default');
    // Data
    $fill = false;
	$count=0;
	$per_page=1;
	
    for($i=1;$i<=rowCount($data);$i++)
	{
		$row_header=getRows($data);
		$ofcc=$row_header[1].",          Code :   (".$row_header[0].")";

		$this->SetFont('','B',11);
		$this->Cell(282,5,'Checklist (Polling Personnel)',0,0,'C');
		$this->Ln(8);
		
		$this->SetFont('','B',8.7);
		$this->Cell(282,8,$ofcc,'LTR',0,'C');
		$this->Ln();
		
		
		$this->SetFont('Arial','',6.9);
	
		
		//$ofcc=$row[32].", "." "." "." "." Code :   (".$row[31].")";
		
		
		if($count<$per_page)
	    {
			$sql="Select personnel.officer_name As officer_name,
				  personnel.off_desg As designation,
				  personnel.personcd As personcd,
				  Date_Format(personnel.dateofbirth, _latin1'%d/%m/%Y') As dateofbirth,
				  personnel.gender As gender,
				  personnel.scale As scale,
				  personnel.basic_pay As basic_pay,
				  personnel.grade_pay As grade_pay,
				  qualification.qualification As qualification,
				  personnel.email As email,
				  personnel.resi_no As resi_no,
				  personnel.mob_no As mob_no,
				  language.language As language,
				  personnel.present_addr1 As present_addr1,
				  personnel.present_addr2 As present_addr2,
				  personnel.perm_addr1 As perm_addr1,
				  personnel.perm_addr2 As perm_addr2,
				  personnel.acno As acno,
				  personnel.epic As epic,                         
				  personnel.partno As partno,
				  personnel.slno As slno,
				 
				  personnel.bank_acc_no As bank_acc_no,
				  personnel.assembly_temp As assembly_temp,
				  personnel.assembly_perm As assembly_perm,
				  personnel.assembly_off As assembly_off,
				  
				  personnel.bank_cd As bank_cd,
				  bank.bank_name As bank_name,
				  
				  (Select branch.ifsc_code from branch where branch.branchcd = personnel.branchcd and branch.bank_cd = personnel.bank_cd)As ifsc_code,
				  (Select branch.branch_name from branch where branch.branchcd = personnel.branchcd and branch.bank_cd = personnel.bank_cd) As branch_name,
				  (Select branch.address from branch where branch.branchcd = personnel.branchcd and branch.bank_cd = personnel.bank_cd) As address,
				  
				  personnel.remarks As remarks,
				  personnel.officecd As officecd,
				  office.office As office,
				  office.address1 As address1,
				  office.address2 As address2,
				  office.postoffice As postoffice,
				  district.district As district,
				  office.pin As pin,
				  personnel.usercode As usercode,
				  personnel.posted_date As posted_date,
				  personnel.workingstatus As postat,
				  office.officer_desg As headofc,
				  poststat.poststatus As poststatus
				  
					From (((((personnel
				  Left Join bank On bank.bank_cd = personnel.bank_cd)
				  Join qualification On qualification.qualificationcd =
					personnel.qualificationcd)
				  Join language On language.languagecd = personnel.languagecd)
				  Join poststat On poststat.post_stat = personnel.poststat)	  
				  Join office On personnel.officecd = office.officecd)
				  Join district On office.districtcd = district.districtcd	  
				  Left Join termination On personnel.personcd = termination.personal_id ";
			$sql.=" where personnel.personcd>0 And termination.personal_id Is Null ";
			
			if($subdivision!='' && $subdivision!='0')
				$sql.="and personnel.subdivisioncd='$subdivision' ";	
			if($frmdate!='' && $frmdate!=null)
				$sql.="and personnel.posted_date>='$frmdate' ";
			if($todate!='' && $todate!=null)
				$sql.="and personnel.posted_date<='$todate' ";
			//if($officename!='' && $officename!='0')
				$sql.="and personnel.officecd='$row_header[0]' ";	
				
			$sql.="order by personnel.subdivisioncd,personnel.officecd ASC";
			
			//ini_set('max_execution_time', 900);
			$rs_data=execSelect($sql);
			$num_rows_data=rowCount($rs_data);
			for($k=1;$k<=$num_rows_data;$k++)
			{
				$row=getRows($rs_data);
				
				$desg=$row[0].",      ".$row[1].", "." "."    PIN :   (".$row[2].")";
				$padd=$row[13].", ".$row[14];
				$peradd=$row[15].", ".$row[16];
				$scale=$row[18].",        Part No :       ".$row[19].",         Sl No :       ".$row[20]."       Pay Scale :     ".$row[5].",       Basic Pay :        ".$row[6];
				$ass=$row[17].",        Assembly (Present Address) :        ".$row[22].",         Assembly (Permanent Address) :       ".$row[23]."       Assembly (Office) :      ".$row[24];
				$bank=$row[25].",   ".$row[26].",         Bank A/c :       ".$row[21];
				$branch=$row[27].",        Address :       ".$row[29];
			
				/*$this->Cell($w[0],6,$i,'LTR',0,'L',$fill);
				$this->Cell($w[1],6,"Office Name :",'LT',0,'L',$fill);
				$this->Cell($w[2],6,$ofcc,'T',0,'L',$fill);
				$this->Cell($w[3],6,'Dob :','T',0,'L',$fill);
				$this->Cell($w[4],6,$row[3],'T',0,'L',$fill);
				$this->Cell($w[5],6,'Gender :','T',0,'L',$fill);
				$this->Cell($w[6],6,$row[4],'TR',0,'L',$fill);
				$this->Ln(4);
				*/
				
				$this->Cell($w[0],6,$k,'LTR',0,'L',$fill);
				$this->Cell($w[1],6,'Name, Designation :','LT',0,'L',$fill);
				$this->Cell($w[2],6,$desg,'T',0,'L',$fill);
				$this->Cell($w[3],6,'Qualification :','T',0,'L',$fill);
				$this->Cell($w[4],6,$row[8],'T',0,'L',$fill);
				$this->Cell($w[5],6,'Email ID :','T',0,'L',$fill);
				$this->Cell($w[6],6,$row[9],'TR',0,'L',$fill);	
				$this->Ln(4);
				
				$this->Cell($w[0],6,'','LR',0,'L',$fill);
				$this->Cell($w[1],6,'Pre Address :','L',0,'L',$fill);
				$this->Cell($w[2],6,$padd,0,0,'L',$fill);
				$this->Cell($w[3],6,'Lang excpt Beng :',0,0,'L',$fill);
				$this->Cell($w[4],6,$row[12],0,0,'L',$fill);
				$this->Cell($w[5],6,'Phone :',0,0,'L',$fill);
				$this->Cell($w[6],6,$row[10],'R',0,'L',$fill);	
				$this->Ln(4);
				
				$this->Cell($w[0],6,'','LR',0,'L',$fill);
				$this->Cell($w[1],6,'Per Address :','L',0,'L',$fill);
				$this->Cell($w[2],6,$peradd,0,0,'L',$fill);
				$this->Cell($w[3],6,'',0,0,'L',$fill);
				$this->Cell($w[4],6,'',0,0,'L',$fill);
				$this->Cell($w[5],6,'',0,0,'L',$fill);
				$this->Cell($w[6],6,'','R',0,'L',$fill);	
				$this->Ln(4);
				
				$this->Cell($w[0],6,'','LR',0,'L',$fill);
				$this->Cell($w[1],6,'Epic No :','L',0,'L',$fill);
				$this->Cell($w[2],6,$scale,0,0,'L',$fill);
				$this->Cell($w[3],6,'Grade Pay :',0,0,'L',$fill);
				$this->Cell($w[4],6,$row[7],0,0,'L',$fill);
				$this->Cell($w[5],6,'Mobile :',0,0,'L',$fill);
				$this->Cell($w[6],6,$row[11],'R',0,'L',$fill);	
				$this->Ln(4);
				
				$this->Cell($w[0],6,'','LR',0,'L',$fill);
				$this->Cell($w[1],6,'Assembly (Voter) :','L',0,'L',$fill);
				$this->Cell($w[2],6,$ass,0,0,'L',$fill);
				$this->Cell($w[3],6,'Post Status :',0,0,'L',$fill);
				$this->Cell($w[4],6,$row[42],0,0,'L',$fill);
				$this->Cell($w[5],6,'Dob :',0,0,'L',$fill);
				$this->Cell($w[6],6,$row[3],'R',0,'L',$fill);	
				$this->Ln(4);
				
				$this->Cell($w[0],6,'','LR',0,'L',$fill);
				$this->Cell($w[1],6,'Bank :','L',0,'L',$fill);
				$this->Cell($w[2],6,$bank,0,0,'L',$fill);
				$this->Cell($w[3],6,'Branch :',0,0,'L',$fill);
				$this->Cell($w[4],6,$row[28],0,0,'L',$fill);
				$this->Cell($w[5],6,'Gender :',0,0,'L',$fill);
				$this->Cell($w[6],6,$row[4],'R',0,'L',$fill);	
				$this->Ln(4);
				
				$this->Cell($w[0],6,'','LR',0,'L',$fill);
				$this->Cell($w[1],6,'Branch IFS Code :','L',0,'L',$fill);
				$this->Cell($w[2],6,$branch,0,0,'L',$fill);
				$this->Cell($w[3],6,'Remarks :',0,0,'L',$fill);
				$this->Cell($w[4],6,$row[30],0,0,'L',$fill);
				$this->Cell($w[5],6,'',0,0,'L',$fill);
				$this->Cell($w[6],6,'','R',0,'L',$fill);	
				$this->Ln();
			
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
	//$this->Ln(10);
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
