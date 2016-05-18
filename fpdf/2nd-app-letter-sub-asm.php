<?php
session_start();
ob_start();
extract($_GET);
date_default_timezone_set('Asia/Calcutta');

require('fpdf.php');
include_once('../inc/db_trans.inc.php');
include_once('../function/training2_fun.php');

$sub = (isset($_GET['sub']) ? decode($_GET['sub']) : '0');
$assembly = (isset($_GET['assembly']) ? decode($_GET['assembly']) : '0');
$group_id = (isset($_GET['group_id']) ? decode($_GET['group_id']) : '0');
$env = isset($_SESSION['environment']) ? $_SESSION['environment'] : "";
$distnm_cap = isset($_SESSION['distnm_cap']) ? $_SESSION['distnm_cap'] : "";
$from = (isset($_GET['txtfrom']) ? decode($_GET['txtfrom']) : '0');
$to = (isset($_GET['txtto']) ? decode($_GET['txtto']) : '0');
$chksub = (isset($_GET['chksub']) ? decode($_GET['chksub']) : '0');
$chkasm = (isset($_GET['chkasm']) ? decode($_GET['chkasm']) : '0');
$mem_no = '';
if ($sub == '0' && $assembly = '0') {
  echo "Select Subdivision wise or Assembly wise";
  exit;
}

if ($sub != '') {
  /* if($from>$hid_rec || $to>$hid_rec)
  {
      echo "Please check record no";
      exit;
  }*/
  if ($from > $to || $from < 1 || $to < 1) {
    echo "Please check record no";
    exit;
  }
  if ((($to) - ($from)) > 2000) {
    echo "Records should not be greater than 2000";
    exit;
  }
}
if ($chksub == 'on') {
  $rsApp = second_appointment_letter_print_4_5_sub($sub, $assembly, $group_id, $mem_no, $from - 1, $to - $from + 1);
}
if ($chkasm == 'on') {
  $rsApp = second_appointment_letter_print_4_5_asm($sub, $assembly, $group_id, $mem_no, $from - 1, $to - $from + 1);
}

class PDF extends FPDF {

  function Header() {

  }

// Page footer
  function Footer() {

  }


  /**
   * @param $header
   * @param $data
   */
  function FancyTable($header, $data) {

    $fill = FALSE;
    $count = 0;
    $per_page = 1;
    $sql2 = "select * from environment";// Venue Address
    $rs2 = execSelect($sql2);
    $row4 = getRows($rs2);

    for ($i = 1; $i <= rowCount($data); $i++) {
      $this->SetFont('Arial', '', 9);
      $row = getRows($data);


      if ($count < $per_page) {
        $chksub = (isset($_GET['chksub']) ? decode($_GET['chksub']) : '0');

        $poll_date = $row['polldate'];
        $poll_time = $row['polltime'];
        $training_venue = $row['training_venue'];
        $venue_addr = $row['venue_addr1'] . ", " . $row['venue_addr2'];
        $training_date = $row['training_date'];
        $training_time = $row['training_time'];

        $dc = ($row['dc_venue'] != '' ? $row['dc_venue'] . ", " . $row['dc_address'] : "___________________________________");
        $dc_date = ($row['dc_date'] != '' ? $row['dc_date'] : "___________");
        $dc_time = ($row['dc_time'] != '' ? $row['dc_time'] : "___________");
        $rcvenue = ($row['rc_venue'] != '' ? $row['rc_venue'] : "_______________________________");

        $euname = "ELECTION URGENT";
        $euname1 = "APPOINTMENT OF MICRO OBSERVER";
        $euname2 = "GENERAL ELECTION TO WEST BENGAL LEGISLATIVE";
        $euname21 = "ORDER";
        $euname3 = ($chksub == 'on') ? $row['pers_off'] . "/" . $row['per_poststat'] : "";
        $euname22 = "Party No. " . $row['groupid'];
        $euname4 = "Order No: " . $_SESSION['apt2_orderno'];
        $euname5 = "Date: " . $_SESSION['apt2_date'];
        //$post = $row5['per_poststat'];
        $ass_code = $row['assembly'];
        $groupid = $row['groupid'];

        $sql = "select * from assembly where assemblycd=" . $ass_code . "";// RO Name & Deseignation
        $rs1 = execSelect($sql);
        $row3 = getRows($rs1);
        $ro_name = $row3['ro_name'];
        //$ro_desig=$row3['ro_desig'];
        $euname6 = "     Election to the Legislative Assembly " . $row['assembly_name'] . " Constituency. ";
        $euname7 = "     I  " . $ro_name . ", Observer, " . $row['assembly_name'] . " AC, appoint the persons whose names are specified below to act as Counting Supervisors/ Assistants and to attend " . $row4['counting_venue'] . ", " . $row4['venue_address'] . ", for the purpose of assisting me in the counting of votes at the said election.   ";
        $euname8 = "Station specified in corresponding entry in column(1) of the table provided below for " . $row['assembly'] . " - " . $row['assembly_name'] . " L.A. Constituency ";
        $euname78 = "";
        $euname81 = "I also authorise the Polling Officer of Sl. No.1 specified in column(4) of the table against that entry to perform the functions of the Presiding ";
        $euname82 = "Officer during the unavoidable absence, if any, of the Presiding Officer.";

        $euname9 = "The Poll will be taken on " . $poll_date . " during the hours " . $poll_time . ". The Presiding Officer should arrange to collect the Polling ";
        $euname10 = "materials from " . $dc . " on " . $dc_date . " at " . $dc_time . " ";
        $euname11 = "and after the Poll, these should be returned to receiving centre at " . $rcvenue;

        $euname12 = "Place: " . uppercase($_SESSION['dist_name']);
        $euname13 = "Date: " . date("d/m/Y");
        $euname14 = "" . wordcase($_SESSION['dist_name']);
        //$a= "Note: Only Presiding Officer & Addl. 2nd Polling Officer will attend VVPAT training at Nirmal Hriday Ashram High School on 29/03/2016 at ";


        $nb1 = "You are requested to attend the training at " . $training_venue . " , " . $venue_addr;
        $nb2 = "on " . $training_date . " from " . $training_time;
        $nb3 = " (__________________________)";

        $signature = "../images/ro/" . $row['assembly'] . ".jpg";
        //$signature="../images/ro/259.jpg";
        $roname = "Observer, " . $row['assembly'] . " - " . $row['assembly_name'] . " AC";

        $this->ln(20);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(37, 6, $euname, 1, 0, 'L');
        $this->Cell(130);
        $this->Cell(24, 6, $euname22, 1, 0, 'R');
        $this->ln(5);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(60);
        $this->Cell(70, 5, $euname1, 'B', 0, 'C');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(5);


        // Line break
        $this->Ln(10);

        //$this->Cell(90);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(15, 10, '', 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(38);
        //$this->Cell(92,4,$euname2,'B',0,'C');
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(8);
        /*$this->SetFont('Arial','B',10);
        $this->Cell(37,6,$euname22,1,0,'R');*/

        $this->Ln(10);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(15, 10, '', 0, 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(70);
        $this->Cell(15, 4, $euname21, 'B', 0, 'C');
        $this->SetFont('Arial', 'B', 8);
        //$this->Cell(4);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(33, 6, '', 0, 0, 'R');
        // Line break

        $this->Ln(20);

        $this->SetFont('Arial', '', 9);
        $this->Cell(15, 10, $euname4, 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(60);
        $this->Cell(47, 4, '', '', 0, 'C');
        $this->SetFont('Arial', '', 8);
        $this->Cell(33);
        $this->SetFont('Arial', '', 9);
        $this->Cell(33, 6, $euname5, 0, 0, 'R');

        $this->Ln(9);

        $this->Ln();
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(180, 4, $euname6, 0, 'C');


        // Line break
        $this->Ln(4);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(185, 4, $euname7, 0, 'J');

        // Line break
        $this->Ln(14);

        $mo_name = "1.   " . $row['mo_name'];
        $mo_desig = $row['mo_designation'];
        $mo_code = $row['mo_personcd'];
        $mo_office = $row['mo_officename'];
        $mo_ofc_address = "Office (" . $row['mo_officecd'] . ") : " . $row['mo_officename'] . ", " . $row['mo_officeaddress'];
        $mo_ofc_address1 = "P.O. - " . $row['mo_postoffice'] . ", Subdiv. - " . $row['mo_subdivision'] . ", " . $row['district'];
        $mo_ofc_cd = "OFFICE - (" . $row['mo_officecd'] . ")";
        $mo_post_stat = $row['mo_post_stat'];
        $mo_join = $mo_post_stat . " PIN - (" . $mo_code . ")";

        $this->Ln(4);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(50, 4, $mo_name . ", " . $mo_desig . " (Pin-" . $mo_code . ")", 0, 'L');
        $this->Ln(4);
        $this->SetFont('Arial', '', 9);
        $this->Cell(140, 4, "      " . $mo_ofc_address, 0, 0, 'L');


        // Line break
        $this->Ln(15);


        $this->SetFont('Arial', '', 9);
        //$this->Cell(80);
        $this->Cell(30, 10, $euname12, 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(120);
        $this->Cell(10, 10, "Signature", 0, 0, 'R');
        // Line break
        $this->Ln(8.3);

        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 1, $euname13, 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(110);
        //	$this->Cell(10,10,"yuyu",0,0,'R');
        $this->Cell(10, 10, $this->Image($signature, $this->GetX(), $this->GetY(), 30.78), 0, 0, 'R', FALSE);
        // Line break
        $this->Ln(7);

        $this->SetFont('Arial', '', 8);
        $this->Cell(165);
        $this->Cell(10, 10, $nb3, 0, 0, 'R');

        // Line break
        $this->Ln(4);
        $this->SetFont('Arial', '', 9);
        $this->Cell(170);
        $this->Cell(10, 10, $roname, 0, 0, 'R');

        // Line break
        $this->Ln(4);
        $this->SetFont('Arial', '', 9);
        $this->Cell(158);
        $this->Cell(10, 10, $euname14, 0, 0, 'R');

        $this->Ln();
        $this->SetFont('Arial', 'B', 8);

        $this->Ln(10);
        $this->Cell(190, 0, '', 1, 0, 'L', $fill);
        $this->ln();
        //$bmname=$row['block_muni_cd'];
        $bmname = ($chksub == 'on') ? "Block/Municipality: " . $row['block_muni_name'] : "";

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(190, 10, $bmname, 0, 0, 'C');


        $fill = !$fill;
        $count++;
      }
      if ($count == $per_page) {
        $per_page = $per_page + 1;
        if ($count != rowCount($data)) {
          $this->AddPage();
        }
      }
    }

  }
}

$pdf = new PDF('P', 'mm', 'A4');
$header = "";
$data = $rsApp;
$pdf->SetFont('Arial', '', 4);
$pdf->AddPage();
$pdf->FancyTable($header, $data);

$pdf->Output();
?>