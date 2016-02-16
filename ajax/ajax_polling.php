<?php
session_start();
extract($_GET);
include_once('../inc/db_trans.inc.php');
include_once('../function/polling_fun.php');
include_once('../function/pagination.php');

$search=isset($_GET["search"])?$_GET["search"]:"";
$assemb=isset($_GET["assemb"])?$_GET["assemb"]:"";

$noofmember=isset($_GET["noofmember"])?$_GET["noofmember"]:"";
$dcrc=isset($_GET["dcrc"])?$_GET["dcrc"]:"";
$subdivcd=isset($_GET["subdivcd"])?$_GET["subdivcd"]:"0";
//$todt=isset($_GET["todt"])?$_GET["todt"]:"";
$usercode=$_SESSION['user_cd'];
//$subdiv_cd=$_SESSION['subdiv_cd'];

if($search=="search")
{
	$_SESSION['asm_p']=$assemb;
	$_SESSION['member_p']=$noofmember;
}
else
{
	$assemb=isset($_SESSION['asm_p'])?$_SESSION['asm_p']:'';
	$noofmember=isset($_SESSION['member_p'])?$_SESSION['member_p']:'';
}
$rsPersonnel_dum = fatch_PollingstationList($dcrc,$assemb,$noofmember,$subdivcd);
$num_rows_dum = rowCount($rsPersonnel_dum);
//echo $num_rows_dum;
//exit;
$items = 5; // number of items per page.
$all = isset($_GET['a'])?$_GET['a']:"";
if($all == "all")
{
	$items = $num_rows_dum;
}
$items=($items==0?1:$items);
$nrpage_amount = $num_rows_dum/$items;
$page_amount = ceil($num_rows_dum/$items);
$page_amount = $page_amount-1;

$page = isset($_GET['p'])? $_GET['p']:"";
$section='polling-station-list';
if($page < "1")
{
	$page = "0";
}
$p_num = $items*$page;

$rsPersonnel = fatch_PollingstationList1($dcrc,$assemb,$noofmember,$subdivcd,$p_num,$items);
$num_rows = rowCount($rsPersonnel);
if($num_rows<1)
{
	echo "No record found";
	//echo $officeid.",".$officename.",".$frmdt.",".$todt.",".$usercode;
}
else
{
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1' class='report'>\n";
	echo "<tr height='30px'><th></th><th>Sl.</th><th>Subdivision</th>
            <th>DC Venue</th>
            <th>Assembly</th>
            <th>Member</th>
            </tr>\n";
	//$count=0;		
	for($i=1;$i<=$num_rows;$i++)
	{
	  $rowPersonnel=getRows($rsPersonnel);
	  $p_cd='"'.encode($rowPersonnel[0]).'"';
	  $count=$p_num+$i;
	  
	  echo "<tr height='25px'>";
	  echo "<td align='center' width='4%'><span class='show_tr arrow'  id='$i' style='cursor:pointer;'> </span></td>"; 
	  echo "<td align='center' width='4%'>$count.</td><td align='center' width='10%'>$rowPersonnel[0]</td><td width='44%' align='left'>$rowPersonnel[1]</td>";
	  echo "<td width='28%' align='left'>$rowPersonnel[2]-$rowPersonnel[3]</td><td width='10%' align='center'>$rowPersonnel[4]</td>";
	  echo "</tr>";
	  
	   echo "<tr id='trc_$i' style='display:none;' class='tt' >";
	
	    echo "<td colspan='6' align='right'>";
		echo "<div style='max-height: 700px; min-height:0px;overflow-y: scroll;'>";
	  //  echo "<div class='headercontainer'>";
      //  echo "<div class='tablecontainer'>";
	     echo "<table width='100%' cellpadding='0' cellspacing='0' id='table1'>";
		 echo "<thead>";
		 echo "<tr  height='25px'>
			    <th>Sl.</th>			  
				<th>PS No</th>
				<th>PS Name</th>
				<th>Edit</th>
				<th>Delete</th>
				</tr>";
		 echo "</thead>";
		 
		 $rs_fatch_fees=fatch_sd_asm_member($rowPersonnel['sd_cd'],$rowPersonnel['asm_cd'],$rowPersonnel['dcrccd'],$rowPersonnel['member']);
		 $row_num=rowCount($rs_fatch_fees);
							 
		 if($row_num>0)
		 {
		   echo "<tbody>";
			for($j=1; $j<=$row_num; $j++)
			{										
				$row_fees=getRows($rs_fatch_fees);
				$code='"'.encode($row_fees['code']).'"';
				$ass='"'.encode($row_fees['forassembly']).'"';
				$psno='"'.encode($row_fees['psno']).'"';
				
				echo "<tr>";								
				echo "<td align='center' width='8%'> $j</td>";
				echo "<td align='center' width='20%'> $row_fees[psno]$row_fees[psfix] </td>";
				echo "<td align='center' width='46%'> $row_fees[psname] </td>";	
				echo "<td align='center' width='13%'> <img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_PS($psno,$ass,$code);' /></td>";	
				echo "<td align='center' width='13%'> <img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_PS($code);' /></td>";	
				echo "</tr>";
				
			}
			echo "</tbody>";
		 }
		echo "</table>";
	//   echo "</div>";
	//  echo "</div>";
		echo "</div>";
	   echo "</td>";
	  
	  echo "</tr>";
	   
	}
	echo "</table>\n";
	paging();
}
?>
<script type="text/javascript">  
$(document).ready(function(){
						   
		$('.show_tr').click(function(){
				var ID=$(this).attr('id');
				$('.tt').hide();
				$('.show_tr').removeClass("up");
			//	$(this).addClass("arrow");
				$('#trc_'+ID).toggle();				
				$(this).addClass("up");
		});
						 // alert("hi");
		//$("#trc_"+ID).hide();
		/* $("tr .show_tr").click(function(){
          var ID=$(this).attr('id');
		  $("#trc_"+ID).toggle();
	      //$("#one_input_"+ID).hide();
		  $(this).toggleClass("up");
		 });*/
		// $(".report tr:even").addClass("odd");
		/* $(".report tr:odd").addClass("odd");
            //$(".report tr:not(.odd)").hide();
            $(".report tr:first-child").show();
            
            $(".report tr.odd").click(function(){
											  // alert("hi");
                $(this).next("tr").toggle();
                $(this).find(".arrow").toggleClass("up");
            });*/
		
});
</script>
<style>
.report span.arrow { background: transparent url(images/tree-node.png) no-repeat scroll 0px 0px; width:13px; height:16px; display:block;}
.report span.up {  background: transparent url(images/tree-node-open.png) no-repeat scroll 0px 0px; width:13px; height:16px; display:block;}
</style>