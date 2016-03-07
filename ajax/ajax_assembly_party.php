<?php
session_start();
extract($_GET);
include_once('../inc/db_trans.inc.php');
include_once('../function/assemblyparty_fun.php');
include_once('../function/pagination.php');
//include_once('../function/add_fun.php');

$search=isset($_GET["search"])?$_GET["search"]:"";
$assemb=isset($_GET["assemb"])?$_GET["assemb"]:"";
$ass=isset($_GET["ass"])?$_GET["ass"]:"";
$subdiv=isset($_GET["subdiv"])?$_GET["subdiv"]:"";
$no=isset($_GET["no"])?$_GET["no"]:"";
$opn=isset($_GET["opn"])?$_GET["opn"]:"";
$usercode=$_SESSION['user_cd'];
$sub=isset($_GET["sub"])?$_GET["sub"]:"";
//$subdiv_cd=$_SESSION['subdiv_cd'];

if($search=="search")
{
	$_SESSION['asm_p']=$assemb;
	$_SESSION['subdiv_p']=$subdiv;
}
else
{
	$assemb=isset($_SESSION['asm_p'])?$_SESSION['asm_p']:'';
	$subdiv=isset($_SESSION['subdiv_p'])?$_SESSION['subdiv_p']:'';
}
if($opn=='delcode')
{
	if(($ass!="" || $ass!=0) && ($no!="" || $no!=0))
	{
	    $total=assembly_party_del_check(decode($ass),decode($no));
		if($total=="0")
		{
			$aa=delete_assembly_party_reserve(decode($ass),decode($no));
			
			$asm_array=fetch_Assembly_party(decode($ass),decode($sub));
			//print_r($asm_array);
			//echo count($asm_array);
			if(count($asm_array)>0)
			{
				update_Assembly_slno(decode($ass),decode($sub));
					$idx = 0;
				foreach ($asm_array as $key => $value) {
					$sum_pp=$value['sl']+$value['np'];
					//echo $sum_pp." </br>";
					$idx = $key;
					//print_r ($asm_array[$idx +1])." </br>" ;
					//echo $asm_array[$idx +1]['no_m'];
					$next_sdcd=$asm_array[$idx +1]['sdcd'];
					$next_asmcd=$asm_array[$idx +1]['asmcd'];
					$next_no_m=$asm_array[$idx +1]['no_m'];
					update_next_party_sl($sum_pp,$next_sdcd,$next_asmcd,$next_no_m);
					
				}
			}
			if($aa==1)
			{
				echo "<span class='alert-success'>Record deleted successfully</span><br />\n";
			}
			
		}
		else
		{
			echo "<span class='error'>Record already used in DCRC</span><br />\n";
		}
	}
}
$rsPersonnel_dum = fatch_assembly_party_details($assemb,$subdiv);
$num_rows_dum = rowCount($rsPersonnel_dum);
//echo $num_rows_dum;
//exit;
$items = 50; // number of items per page.
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
$section='assembly-party-list';
if($page < "1")
{
	$page = "0";
}
$p_num = $items*$page;

$rsPersonnel = fatch_assembly_party_details1($assemb,$subdiv,$p_num,$items);
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
            <th>Assembly</th>
            <th>Number</th>
			<th>Party</th>
			<th>Delete</th>
            </tr>\n";
	//$count=0;		
	for($i=1;$i<=$num_rows;$i++)
	{
	  $rowAP=getRows($rsPersonnel);
	  $sub='"'.encode($rowAP['subdivisioncd']).'"';
	  $ass='"'.encode($rowAP['assemblycd']).'"';
	  $no='"'.encode($rowAP['no_of_member']).'"';
	  $count=$p_num+$i;
	  
	  echo "<tr height='25px'>";
	  echo "<td align='center' width='4%'><span class='show_tr arrow'  id='$i' style='cursor:pointer;'> </span></td>"; 
	  echo "<td align='center' width='4%'>$count.</td><td align='center' width='10%'>$rowAP[subdivision]</td><td width='44%' align='left'>$rowAP[assemblycd]-$rowAP[assemblyname]</td>";
	  echo "<td width='18%' align='center'>$rowAP[no_of_member]</td><td width='10%' align='center'>$rowAP[no_party]</td>";
	   echo "<td align='center' width='8%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_ass_party($sub,$ass,$no);' title='Click to delete' /></td>";
	  echo "</tr>";
	  
	   echo "<tr id='trc_$i' style='display:none;' class='tt' >";
	
	    echo "<td colspan='7' align='right' style='max-height: 300px; min-height:0px;overflow-y: scroll;' >";
	
	     echo "<table width='60%' cellpadding='0' cellspacing='0'  >";
		 echo "<tr height='30px'>
			    <th>Sl.</th>			  
				<th>Post Status</th>
			    <th>Number</th>
				</tr>";
				
		$rs_fatch_fees=fatch_reserve_ag_assembly_no($rowAP['subdivisioncd'],$rowAP['assemblycd'],$rowAP['no_of_member']);
		 $row_num=rowCount($rs_fatch_fees);
							 
		 if($row_num>0)
		 {
			for($j=1; $j<=$row_num; $j++)
			{										
				$rowReserve=getRows($rs_fatch_fees);
			//	$psno='"'.encode($row_fees['psno']).'"';
			//$ass='"'.encode($row_fees['forassembly']).'"';
				echo "<tr>";								
				echo "<td align='center' width='8%'> $j</td>";
				echo "<td align='center' width='46%'> $rowReserve[poststat]</td>";
				echo "<td align='center' width='46%'> $rowReserve[numb] $rowReserve[no_or_pc] </td>";	
				
				echo "</tr>";
			}
		 }
		echo "</table>";
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
			/*	$('#trc_'+ID).toggle();			
				$(this).toggleClass("up");*/
			    $('.tt').hide();
				$('.show_tr').removeClass("up");
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