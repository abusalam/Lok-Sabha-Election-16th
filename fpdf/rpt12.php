<?php
session_start();
extract($_REQUEST);
require('fpdf.php');
$officename=isset($_REQUEST["office"])?$_REQUEST["office"]:"";
$subdivision=isset($_REQUEST["subdivision"])?$_REQUEST["subdivision"]:"";
$from=(isset($_REQUEST['txtfrom'])?$_REQUEST['txtfrom']:'0');
$to=(isset($_REQUEST['txtto'])?$_REQUEST['txtto']:'0');
$frmdate=isset($_REQUEST["frmdate"])?$_REQUEST["frmdate"]:"";
$todate=isset($_REQUEST["todate"])?$_REQUEST["todate"]:"";

	if($from>$to || $from<1 || $to<1)
	{
		echo "Please check record no";
		exit;
	}
	if((($to)-($from))>200)
	{
		echo "Records should not be greater than 200";
		exit;
	}
$lmt_frm=$from-1;
$lmt_to=$to-$from+1;
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
	$sql1.="order by personnel.officecd limit $lmt_frm,$lmt_to";
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
	//$this->Cell(282,5,'','');
}

// Page footer
function Footer()
{
	//$this->Cell(282,5,'','');

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
       if($count<$per_page)
	  {
		$this->SetFont('','B',10);
		$this->Cell(282,5,'Checklist (Polling Personnel)',0,0,'C');
		$this->Ln(8);
		
		$this->SetFont('','B',8.4);
		$this->Cell(282,8,$ofcc,'LTR',0,'C');
		$this->Ln();
		
		
		$this->SetFont('Arial','',6.2);
	
		
		//$ofcc=$row[32].", "." "." "." "." Code :   (".$row[31].")";
		$subdivision=isset($_REQUEST["subdivision"])?$_REQUEST["subdivision"]:"";
//$officename=$_REQUEST['office'];
//$user=$_REQUEST['user'];
$frmdate=isset($_REQUEST["frmdate"])?$_REQUEST["frmdate"]:"";
$todate=isset($_REQUEST["todate"])?$_REQUEST["todate"]:"";
		
		
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
				
			//$sql.="order by personnel.officecd,personnel.personcd ASC";
			
			//ini_set('max_execution_time', 900);
			$rs_data=execSelect($sql);
			$count1=0;
	        $per_page1=7;
			$num_rows_data=rowCount($rs_data);
			for($k=1;$k<=$num_rows_data;$k++)
			{
				
				$row=getRows($rs_data);
			    if($count1<$per_page1)
	            {
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
				
				$this->Cell($w[0],4,$k,'LTR',0,'L',$fill);
				$this->Cell($w[1],4,'Name, Designation :','LT',0,'L',$fill);
				$this->Cell($w[2],4,$desg,'T',0,'L',$fill);
				$this->Cell($w[3],4,'Qualification :','T',0,'L',$fill);
				$this->Cell($w[4],4,$row[8],'T',0,'L',$fill);
				$this->Cell($w[5],4,'Email ID :','T',0,'L',$fill);
				$this->Cell($w[6],4,$row[9],'TR',0,'L',$fill);	
				$this->Ln();
				
				$this->Cell($w[0],3,'','LR',0,'L',$fill);
				$this->Cell($w[1],3,'Pre Address :','L',0,'L',$fill);
				$this->Cell($w[2],3,$padd,0,0,'L',$fill);
				$this->Cell($w[3],3,'Lang excpt Beng :',0,0,'L',$fill);
				$this->Cell($w[4],3,$row[12],0,0,'L',$fill);
				$this->Cell($w[5],3,'Phone :',0,0,'L',$fill);
				$this->Cell($w[6],3,$row[10],'R',0,'L',$fill);	
				$this->Ln();
				
				$this->Cell($w[0],3,'','LR',0,'L',$fill);
				$this->Cell($w[1],3,'Per Address :','L',0,'L',$fill);
				$this->Cell($w[2],3,$peradd,0,0,'L',$fill);
				$this->Cell($w[3],3,'',0,0,'L',$fill);
				$this->Cell($w[4],3,'',0,0,'L',$fill);
				$this->Cell($w[5],3,'',0,0,'L',$fill);
				$this->Cell($w[6],3,'','R',0,'L',$fill);	
				$this->Ln();
				
				$this->Cell($w[0],3,'','LR',0,'L',$fill);
				$this->Cell($w[1],3,'Epic No :','L',0,'L',$fill);
				$this->Cell($w[2],3,$scale,0,0,'L',$fill);
				$this->Cell($w[3],3,'Grade Pay :',0,0,'L',$fill);
				$this->Cell($w[4],3,$row[7],0,0,'L',$fill);
				$this->Cell($w[5],3,'Mobile :',0,0,'L',$fill);
				$this->Cell($w[6],3,$row[11],'R',0,'L',$fill);	
				$this->Ln();
				
				$this->Cell($w[0],3,'','LR',0,'L',$fill);
				$this->Cell($w[1],3,'Assembly (Voter) :','L',0,'L',$fill);
				$this->Cell($w[2],3,$ass,0,0,'L',$fill);
				$this->Cell($w[3],3,'Post Status :',0,0,'L',$fill);
				$this->Cell($w[4],3,$row[42],0,0,'L',$fill);
				$this->Cell($w[5],3,'Dob :',0,0,'L',$fill);
				$this->Cell($w[6],3,$row[3],'R',0,'L',$fill);	
				$this->Ln();
				
				$this->Cell($w[0],3,'','LR',0,'L',$fill);
				$this->Cell($w[1],3,'Bank :','L',0,'L',$fill);
				$this->Cell($w[2],3,$bank,0,0,'L',$fill);
				$this->Cell($w[3],3,'Branch :',0,0,'L',$fill);
				$this->Cell($w[4],3,$row[28],0,0,'L',$fill);
				$this->Cell($w[5],3,'Gender :',0,0,'L',$fill);
				$this->Cell($w[6],3,$row[4],'R',0,'L',$fill);	
				$this->Ln();
				
				$this->Cell($w[0],3,'','LR',0,'L',$fill);
				$this->Cell($w[1],3,'Branch IFS Code :','L',0,'L',$fill);
				$this->Cell($w[2],3,$branch,0,0,'L',$fill);
				$this->Cell($w[3],3,'Remarks :',0,0,'L',$fill);
				$this->Cell($w[4],3,$row[30],0,0,'L',$fill);
				$this->Cell($w[5],3,'',0,0,'L',$fill);
				$this->Cell($w[6],3,'','R',0,'L',$fill);	
               
				    $this->Ln();
					$this->Cell(array_sum($w),0,'',1,0,'L',$fill);
					$this->Ln();
					 $count1++;
				}
				if($count1==$per_page1)
				{
					$per_page1=$per_page1+7;
					if($count1!=$num_rows_data)
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
