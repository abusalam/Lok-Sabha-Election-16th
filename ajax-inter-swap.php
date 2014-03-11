<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');

$opn=isset($_GET['opn'])?$_GET['opn']:"";
if($opn=="pc_swp")
{
	$subdiv=$_GET["subdiv_swp"];
	$rsPC=fatch_pc($subdiv);
	$num_rows=rowCount($rsPC);
	if($num_rows>0)
	{
		echo "<select name='pc' id='pc' style='width:170px;' onchange='javascript:return pc_change(this.value);'>\n";
		echo "<option value='0'>-Select PC-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowPC=getRows($rsPC);
			echo "<option value='$rowPC[0]'>$rowPC[1]</option>\n";
			$rowPC=NULL;
		}
		echo "</select>";
	}
	else
	{
		echo "<select name='pc' id='pc' style='width:170px;'></select>";
	}
	$num_rows=0;			
	$rsPC=NULL;
	unset($rsPC,$rowPC,$num_rows);
}
if($opn=="poststat")
{
	$pc_swp=isset($_GET["pc_swp"])?$_GET["pc_swp"]:"";
	$sub_swp=isset($_GET["sub_swp"])?$_GET["sub_swp"]:"";
	$rs=fatch_post_stat_wise_dtl_unbooked($sub_swp,$pc_swp);
	$num_rows=rowCount($rs);
	echo "Unbooked &nbsp;: ";
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=getRows($rs);
		echo $row['poststat'].": ".$row['total']."; \n";
		$row=NULL;
	}
	$num_rows=0;			
	$rs=NULL;
	unset($rs,$row,$num_rows);
}