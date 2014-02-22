<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/form_12_fun.php');

$opn=$_GET['opn'];
if($opn=='office')
{
	$sub_div=$_GET['sub_div'];
	echo "<select id='office' name='office' style='width:240px;' onchange='return office_change(this.value);'>\n";
	$rsOfc=fatch_Office_ag_subdiv($sub_div);
	$num_rows=rowCount($rsOfc);
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Office-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowOfc=getRows($rsOfc);
			echo "<option value='$rowOfc[0]'>$rowOfc[1]</option>\n";
			$rowOfc=null;
		}
	}
	$rsOfc=null;
	$num_rows=0;
	echo "</select>";
}
if($opn=='personnel')
{
	$office=$_GET['office'];
	echo "<select id='personnel' name='personnel' style='width:240px;' onchange='return personnel_change(this.value);'>\n";
	$rsPer=fatch_personnel_ag_office($office);
	$num_rows=rowCount($rsPer);
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Personnel-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowPer=getRows($rsPer);
			echo "<option value='$rowPer[0]'>$rowPer[0]</option>\n";
			$rowPer=null;
		}
	}
	$rsPer=null;
	$num_rows=0;
	echo "</select>";
}
if($opn=='per_dtl')
{
	$personcd=$_GET['personcd'];
	$epic=$_GET['epic'];
	if($personcd!='' && $personcd!=null)
	{
		$rsPer=new_person_details($personcd);
		$rowPer=getRows($rsPer);
		if($personcd!='0')
		{
		if($rowPer['assemblyname']!='' && $rowPer['assemblyname']!=null)
			$assembly=$rowPer['acno']."-".$rowPer['assemblyname'];
		else
			$assembly=$rowPer['acno']."-"."Other";
		}
		else
			$assembly="";
		echo "\n<table border='0' width='100%'>\n";
		echo "<tr><td align='left' width='19%'><span class='error'>&nbsp;</span>Personnel Name:</td><td align='left' width='30%'>".$rowPer['officer_name']."</td><td align='left' width='8%'> Designation:</td><td align='left' width='21%'>".$rowPer['designation']."</td><td align='left' width='10%'> EPIC No:</td><td align='left' width='12%'>".$rowPer['epic']."</td></tr>\n";
		echo "<tr><td align='left'><span class='error'>&nbsp;</span>AC No:</td><td align='left'>".$assembly."</td><td align='left'> Part No:</td><td align='left'>".$rowPer['partno']."</td><td align='left'> Sl No:</td><td align='left'>".$rowPer['slno']."</td></tr>\n";
		echo "<input type='hidden' id='hid_pc' name='hid_pc' value='".$rowPer['pccd']."' />\n";
		echo "<input type='hidden' id='hid_per_cd' name='hid_per_cd' value='".$rowPer['personcd']."' />\n";
	}
	if($epic!='' && $epic!=null)
	{
		$rsPer=new_person_details_ag_epic($epic);
		$rowPer=getRows($rsPer);
		if($epic!='')
		{
		if($rowPer['assemblyname']!='' && $rowPer['assemblyname']!=null)
			$assembly=$rowPer['acno']."-".$rowPer['assemblyname'];
		else
			$assembly=$rowPer['acno']."-"."Other";
		}
		else
			$assembly="";
		echo "\n<table border='0' width='100%'>\n";
		echo "<tr><td align='left' width='19%'><span class='error'>&nbsp;</span>Personnel Name:</td><td align='left' width='30%'>".$rowPer['officer_name']."</td><td align='left' width='8%'> Designation:</td><td align='left' width='21%'>".$rowPer['designation']."</td><td align='left' width='10%'> EPIC No:</td><td align='left' width='12%'>".$rowPer['epic']."</td></tr>\n";
		echo "<tr><td align='left'><span class='error'>&nbsp;</span>AC No:</td><td align='left'>".$assembly."</td><td align='left'> Part No:</td><td align='left'>".$rowPer['partno']."</td><td align='left'> Sl No:</td><td align='left'>".$rowPer['slno']."</td></tr>\n";
		echo "<input type='hidden' id='hid_pc' name='hid_pc' value='".$rowPer['pccd']."' />\n";
		echo "<input type='hidden' id='hid_per_cd' name='hid_per_cd' value='".$rowPer['personcd']."' />\n";
	}
}
?>