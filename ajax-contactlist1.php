<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include('function/contactus.php');
$opn=isset($_POST["opn"])?$_POST["opn"]:"";
$page_url=isset($_POST["page"])?$_POST["page"]:"";
$usercd=$_SESSION['user_cd'];
if($opn=="contactdetails")
{
	    //$status=fetch_query_status($usercd);
        $rsPersonnel_dum=fatch_contactList_reply($usercd);
        $num_rows_dum = rowCount($rsPersonnel_dum);
        
        $items = 100; // number of items per page.
        $all = $_GET['a'];
        if($all == "all")
        {
            $items = $num_rows_dum;
        }
        $items=($items==0?1:$items);
        $nrpage_amount = $num_rows_dum/$items;
        $page_amount = ceil($num_rows_dum/$items);
        $page_amount = $page_amount-1;
        $page = $_GET['p'];
        $section='contactus';
        if($page < "1")
        {
            $page = "0";
        }
        $p_num = $items*$page;
        
        $rsPersonnel = fatch_contactList1_reply($usercd,$p_num ,$items);
        $num_rows = rowCount($rsPersonnel);
        if($num_rows<1)
        {
            echo "No record found";
            //echo $officeid.",".$officename.",".$frmdt.",".$todt.",".$usercode;
        }
        else
        {
            echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' style='border: 1px solid #39F' class='TableGenerator'>\n";
          echo "<tr  style='background-color:fff'><th align='right' width='3%'>SL#</th><th align='center' width='10%'>From</th><th width='62%' align='left'>Mesage</th><th align='center' width='8%'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;View</th><th width='12%' align='left'>Date & Time </th><th align='center' width='5%'>Reply#</th><tr/>";
            for($i=1;$i<=$num_rows;$i++)
            {
              $rowPersonnel=getRows($rsPersonnel);
              $p_cd='"'.encode($rowPersonnel['query_id']).'"';
			  
			  $check_date=check_contactcurrentdate($rowPersonnel['query_id'],$usercd);
			  
			  $fdate=strtotime($check_date);
			  $dat = date('Y-m-d', $fdate);
              $tme = date('g:i A',$fdate);
			  $month=date("m",strtotime($dat));
			  $date=date("d",strtotime($dat));
	         // $frm_year=date("Y",strtotime($frmDate));
			  $month_name = date("F", mktime(0, 0, 0, $month, 10));
			  $fm=substr($month_name,0,3);
			  
			 // $sub=substr($rowPersonnel['subject'],0,50);
			 $sub=substr($rowPersonnel['query'],0,200);
			  $count_reply=count_rply($rowPersonnel['query_id']);
			  if($count_reply > 0){
              echo "<tr><td align='right' width='3%'>$i.</td>";
			  echo "<td align='left' width='10%'>";
			  if($rowPersonnel['usercode']==$usercd)
			    echo "&nbsp;"."me";
			  else
			    echo "&nbsp;".$rowPersonnel['user_id'];
			  echo "</td>";
              echo "<td width='62%' align='left'>";
			  echo $sub;
			  echo "</td>";
            
          
               echo "<td align='center' width='8%'><img src='images/view.png' alt=''  title='View Reply' height='20px' onclick='javascript:reply_person($p_cd);' style='cursor: pointer;'/></td>";
			  echo "<td width='12%' align='left'>";
			     echo $fm." ".$date."&nbsp;&nbsp;&nbsp;&nbsp; ".$tme;
			  echo "</td>";
			  echo "<td align='center' width='5%'><span style='color: white;width: 6px;height: 3px; background-color: red; padding: 2px;'>$count_reply</span></td>";
			  }
            }
            echo "</table>\n";
         //   paging();
        }
}

?>
