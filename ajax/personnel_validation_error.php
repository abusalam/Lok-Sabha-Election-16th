<?php
session_start();
if(isset($_SESSION['subdiv_cd']))
	  $subdiv_cd=$_SESSION['subdiv_cd'];
    else
	  $subdiv_cd="0";
include_once('../inc/db_trans.inc.php');
include_once('../function/personnel_report_fun.php');

$filename = "dataerror.xls"; // File Name
// Download file
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$rsOffice=fatch_personnelvalidation($subdiv_cd);
$num_rows = rowCount($rsOffice);
if($num_rows<1)
{
	echo "No record found";
}
else
{
	 //$body = "Sl No"."\t"."Office ID"."\t"."Personnel ID"."\t"."Name"."\t"."Designation."."\t"."Date of Birth"."\t"."Gender"."\t"."Subdivision"."\t"."Post Status"."\t"."Present Assembly"."\t"."Place of Posting"."\t"."Permanent Assembly"."\t"."Voter of Assembly"."\t"."Qualification Cd"."\t \n ";
	  $display =  "<table  border = \"1\"  bgcolor = \"FFFFFF\" cellspacing= \"15\" cellpadding = \"7\">";
       echo $display;
       $body .= $display;
       
       
        $display  =  "<thead style =\" font-weight:bold; color:green; \"><tr> 
		   <td>Sl No </td>
		   <td>Office ID</td> 
		   <td>Personnel ID</td>
		   <td>Name</td> 
		   <td>Designation</td>
		   <td>Date of Birth</td> 
		   <td>Gender</td>
		   <td>Subdivision</td>
		   <td>Post Status</td>
		   <td>Present Assembly</td>
		   <td>Permanent Assembly</td>
		   <td>Place of Posting</td>
		   <td>Voter of Assembly</td>
		   <td>Qualification Cd</td>
		   <td>Bank</td>
		   <td>Branch</td>
		   <td>Bank A/C No</td>
		   <td>Mobile No</td>
		   </tr></thead>";
        echo $display;
       $body .= $display;
	//echo $body;
	for($i=1;$i<=$num_rows;$i++)
	{
		$result=getRows($rsOffice);
		  $ofc_length = strlen((string) $result['officecd']);
		  $persn_length = strlen((string) $result['personcd']);
		  $temp_length = strlen((string) $result['assembly_temp']);
		  $off_length = strlen((string) $result['assembly_off']);
		  $perm_length = strlen((string) $result['assembly_perm']);
		  $ac_length = strlen((string) $result['acno']);
		  $mob_length = strlen((string) $result['mob_no']);
		       $display = "<tr>";               
               $display .= "<td>$i</td>";
			   if($result['officecd'] == '' or $result['officecd'] == '0' or $ofc_length != 10)
                  $display .=  "<td bgcolor = \"FA5858\">" .$result['officecd']  .  "</td>";
			   else
			      $display .=  "<td>".$result['officecd']."</td>";
			   if($result['personcd'] == '' or $result['personcd'] == '0' or $persn_length != 11) 
                  $display .=  "<td bgcolor = \"FA5858\">" .$result['personcd']  .  "</td>";
			   else
			      $display .=  "<td>".$result['personcd']."</td>";
			   if($result['officer_name'] == '' or $result['officer_name'] == '0')
			       $display .=  "<td bgcolor = \"FA5858\">" .$result['officer_name']."</td>";
			   else
			       $display .=  "<td>" .$result['officer_name']."</td>";
			   if($result['off_desg'] == '' or $result['off_desg'] == '0')    
				   $display .=  "<td bgcolor = \"FA5858\">" .$result['off_desg']."</td>";
			   else
			       $display .=  "<td>" .$result['off_desg']."</td>";
			   if($result['dateofbirth'] == '' or $result['dateofbirth'] == '0000-00-00 00:00:00')
			       $display .=  "<td bgcolor = \"FA5858\">" .substr($result['dateofbirth'],0,10)  .  "</td>";
			   else			      
			       $display .=  "<td>" .substr($result['dateofbirth'],0,10)  .  "</td>";
			   if($result['gender'] == '' or $result['gender'] == '0')   
			       $display .=  "<td bgcolor = \"FA5858\">".$result['gender']."</td>";
			   else
			       $display .=  "<td>".$result['gender']."</td>";
			   if($result['subdivisioncd'] == '' or $result['subdivisioncd'] == '0')
			       $display .=  "<td bgcolor = \"FA5858\">" .$result['subdivisioncd']  .  "</td>";
			   else
			       $display .=  "<td >" .$result['subdivisioncd']  .  "</td>";
			   if($result['poststat'] == '' or $result['poststat'] == '0')   
			       $display .=  "<td bgcolor = \"FA5858\">" .$result['poststat']  .  "</td>";
			   else
			       $display .=  "<td>" .$result['poststat']  .  "</td>";
			   if($result['assembly_temp'] == '' or $result['assembly_temp'] == '0' or $temp_length != 3)
			       $display .=  "<td bgcolor = \"FA5858\">" .$result['assembly_temp']  .  "</td>";
			   else
			       $display .=  "<td>" .$result['assembly_temp']  .  "</td>";
			   
			   if($result['assembly_perm'] == '' or $result['assembly_perm'] == '0' or $perm_length != 3)
			        $display .=  "<td bgcolor = \"FA5858\">" .$result['assembly_perm']  .  "</td>";
			   else
			        $display .=  "<td>" .$result['assembly_perm']  .  "</td>";
					
			   if($result['assembly_off'] == '' or $result['assembly_off'] == '0' or $off_length != 3)
                   $display .=  "<td bgcolor = \"FA5858\">" .$result['assembly_off']  .  "</td>";
			   else
			       $display .=  "<td>" .$result['assembly_off']  .  "</td>";
				   
			   if($result['acno'] == '' or $result['acno'] == '0' or $ac_length != 3)
                    $display .=  "<td bgcolor = \"FA5858\">" .$result['acno']  .  "</td>";
			   else
				    $display .=  "<td>" .$result['acno']  .  "</td>";
			   if($result['qualificationcd'] == '' or $result['qualificationcd'] == '0')
                    $display .=  "<td bgcolor = \"FA5858\">" .$result['qualificationcd']  .   "</td>";
               else
			        $display .=  "<td>" .$result['qualificationcd']  .   "</td>";
			   if($result['bank_cd'] == '' or $result['bank_cd'] == '0')
                    $display .=  "<td bgcolor = \"FA5858\">" .$result['bank_cd']  .   "</td>";
               else
			        $display .=  "<td>" .$result['bank_cd']  .   "</td>";
			   if($result['branchcd'] == '' or $result['branchcd'] == '0')
                    $display .=  "<td bgcolor = \"FA5858\">" .$result['branchcd']  .   "</td>";
               else
			        $display .=  "<td>" .$result['branchcd']  .   "</td>";
					
			   if($result['bank_acc_no'] == '' or $result['bank_acc_no'] == '0')
                    $display .=  "<td bgcolor = \"FA5858\">" .$result['bank_acc_no']  .   "</td>";
               else
			        $display .=  "<td>" .$result['bank_acc_no']  .   "</td>";
					
			   if($mob_length != 10)
                    $display .=  "<td bgcolor = \"FA5858\">" .$result['mob_no']  .   "</td>";
               else
			        $display .=  "<td>" .$result['mob_no']  .   "</td>";
               $display .=  "</tr>";
	       echo $display;
               $body .= $display;
	   
			 /*  echo $i."\t";
			   echo $row['officecd']."\t";
			   echo $row['personcd']."\t";
			   echo $row['officer_name']."\t";
			   echo $row['off_desg']."\t";
			   echo $row['dateofbirth']."\t";
			   echo $row['gender']."\t";
			   echo $row['subdivisioncd']."\t";
			   echo $row['poststat']."\t";
			   echo $row['assembly_temp']."\t";
			   echo $row['assembly_off']."\t";
			   echo $row['assembly_perm']."\t";
			   echo $row['acno']."\t";
			   echo $row['qualificationcd']."\t \n";*/
	}
	 $display =  "</table>";
      echo $display;
      $body .= $display;
      $body = htmlspecialchars($body);
}
//ExportToExcel("export.xls");					
unset($rsOffice);
?>