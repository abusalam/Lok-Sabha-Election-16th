<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');
include_once('function/pagination.php');
$opn=$_GET["opn"];

if($opn=="subdiv")
{
	$dist=$_GET["dist"];
	$rsSubdiv=fatch_Subdivision($dist);
	$num_rows=rowCount($rsSubdiv);
	echo "<select name='subdiv' id='subdiv' style='width:200px;' onchange='return subdiv_change(this.value);'>";
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Subdivision-</option>";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowSubdiv=getRows($rsSubdiv);
			echo "<option value='$rowSubdiv[0]'>$rowSubdiv[2]</option>";
		}
	}
	echo "</select>";
	unset($rsSubdiv,$$num_rows,$rowSubdiv);
}
if($opn=="pc")
{
	$subdiv=$_GET["subdiv"];
	$rsPC=fatch_pc($subdiv);
	$num_rows=rowCount($rsPC);
	echo "<select name='parliament' id='parliament' style='width:200px;'>";
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Parliament-</option>";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowPC=getRows($rsPC);
			echo "<option value='$rowPC[0]'>$rowPC[1]</option>";
		}
	}
	echo "</select>";
	unset($rsPC,$$num_rows,$rowPC);
}
?>