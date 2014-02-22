<?php
session_start();
    // paging code
    // Query to count rows.
	extract($_GET);
include_once('inc\db_trans.inc.php');
include_once('function\add_fun.php');
$officeid=$_GET["officeid"];
$officename=$_GET["officename"];
$frmdt=$_GET["frmdt"];
$todt=$_GET["todt"];
$usercode=$_SESSION['user_cd'];

$rsOffice=fatch_OfficeList($officeid,$officename,$frmdt,$todt,$usercode);

    $items = 1; // number of items per page.
    $all = $_GET['a'];
     
    $num_rows = mysqli_num_rows($rsOffice);

    if($all == "all")
	{
    	$items = $num_rows;
    }
    $nrpage_amount = $num_rows/$items;
    $page_amount = ceil($num_rows/$items);
    $page_amount = $page_amount-1;
    $page = $_GET['p'];
	$section='paging';
    if($page < "1")
	{
    	$page = "0";
    }
    $p_num = $items*$page;
    //end paging code
    // Query that you would like to SHOW
    $rsOffice = fatch_OfficeList1($officeid,$officename,$frmdt,$todt,$usercode,$p_num ,$items);
    $num_rows1 = mysqli_num_rows($rsOffice);
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
	echo "<tr height='30px'><th>Sl.</th><th>Office ID</th>
            <th>Office Name</th>
            <th>Office Address</th>
            <th>Nature of Office</th>
            <th>Edit</th></tr>\n";
	for($i=1;$i<=$num_rows1;$i++)
	{
	  $rowOffice=getRows($rsOffice);
	  echo "<tr><td align='right' width='3%'>$i.</td><td align='center' width='10%'>$rowOffice[0]</td><td width='28%' align='left'>$rowOffice[1]</td>";
	  echo "<td width='40%' align='left'>$rowOffice[2],$rowOffice[3], PO-$rowOffice[4], Pin-$rowOffice[5]</td><td width='15%' align='left'>$rowOffice[6]</td>";
	  echo "<td align='center' width='4%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_office($rowOffice[0]);' /></td></tr>\n";
	}
	echo "</table>\n";
	
    function paging()
	{
		global $num_rows;
		global $page;
		global $page_amount;
		global $section;
		if($page_amount != "0")
		{
			echo "<div align='center' class='container'>";
			echo "<div class='pagination'>";
			if($page != "0")
			{
				$prev = $page-1;
				echo "<a href=\"$section.php?q=$section&p=$prev\" class='page'>Prev</a> ";
			}
			for ( $counter = 0; $counter <= $page_amount; $counter += 1)
			{
				if($page==$counter)
				{
					echo "<a class='page active'>";
					echo $counter+1;
					echo "</a> ";
				}
				else
				{
					echo "<a href=\"$section.php?q=$section&p=$counter\" class='page'>";
					echo $counter+1;
					echo "</a> ";
				}
			}
			if($page < $page_amount)
			{
				$next = $page+1;
				echo "<a href=\"$section.php?q=$section&p=$next\" class='page'>Next</a> ";
			}
			//echo "<a href=\"paging.php?q=$section&a=all\">View All</a> ";
			echo "</div>";
			echo "</div>";
		}
    }
    // call on Pagination with function
    paging();
?>