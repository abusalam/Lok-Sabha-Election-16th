<?php
session_start();
extract($_GET);
include_once('..\inc\db_trans.inc.php');
include_once('..\function\report_fun.php');
$opn=$_GET['opn'];
if($opn=='office')
{
	$subdiv=$_GET['sub_div'];
	$pc=$_GET['pc'];
	$rsOffice=get_office_ag_pc_subdiv($subdiv,$pc);
	$num_rows = rowCount($rsOffice);
	if($num_rows<1)
	{
		echo "No office available";
	}
	else
	{
		for($i=1;$i<=$num_rows;$i++)
		{
		  $rowOffice=getRows($rsOffice);
		  $off_cd='"'.$rowOffice['officecd'].'"';
		  $forpc='"'.$pc.'"';
		  echo "<label id='lblOffice_$rowOffice[officecd]' name='lblOffice_$rowOffice[officecd]' onclick='return person_details($off_cd,$forpc)' class='child-node'>$i) $rowOffice[officecd] - $rowOffice[office]</label>\n";
		  echo "<div id='person_details_$rowOffice[officecd]' class='emp_details'></div>\n";
		  $rowOffice=NULL;
		}
	}	
	unset($rowBranch,$num_rows);
}
if($opn=='person')
{
	$office=$_GET['office'];
	$forpc=$_GET['forpc'];
	$rsPerson=get_person_ag_office($office,$forpc);
	$num_rows = rowCount($rsPerson);
	if($num_rows<1)
	{
		echo "No person available";
	}
	else
	{
		echo "\n<table width='100%' cellpadding='1' cellspacing='0' border='0' class='table1'>\n";
		echo "<tr>\n";
		echo "<th align='center' width='2%'>Sl.</th><th align='center' width='8%'>Personnel ID</th><th align='left' width='15%'>Personnel Name</th>";
		echo "<th align='left' width='12%'>Designation</th><th align='center' width='9%'>Assembly Office</th><th align='center' width='11%'>Assembly Permanent</th>";
		echo "<th align='center' width='9%'>Assembly Temp</th><th align='center' width='10%'>EPIC No</th><th align='center' width='6%'>AC No</th>";
		echo "<th align='center' width='6%'>Part No</th><th align='center' width='6%'>Sl. No</th><th align='center' width='7%'>Post Status</th>\n";
		echo "</tr>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
		  $rowPerson=getRows($rsPerson);
		  $person_cd='"'.$rowPerson['personcd'].'"';
		  $p_code=$rowPerson['personcd'];
		  $p_name=$rowPerson['officer_name'];
		  $p_desg=$rowPerson['off_desg'];
		  $p_ass_off=$rowPerson['assembly_off'];$p_ass_per=$rowPerson['assembly_perm'];
		  $p_ass_tmp=$rowPerson['assembly_temp'];
		  $p_epic=$rowPerson['epic'];
		  $p_acno=$rowPerson['acno'];
		  $p_partno=$rowPerson['partno'];$p_slno=$rowPerson['slno'];
		  $p_poststat=$rowPerson['poststat'];
		  echo "<tr>\n";
		  echo "<td align='left'>$i.</td><td align='left'>$p_code</td><td align='left'>$p_name</td><td align='left'>$p_desg</td><td align='center'>$p_ass_off</td>";
		  echo "<td align='center'>$p_ass_per</td><td align='center'>$p_ass_tmp</td><td align='center'>$p_epic</td><td align='center'>$p_acno</td>";
		  echo "<td align='center'>$p_partno</td><td align='center'>$p_slno</td><td align='center'>$p_poststat</td>\n";
		  echo "</tr>\n";
		  $rowPerson=NULL;
		}
		echo "\n</table>\n";
	}	
	unset($rsPerson,$num_rows);
	echo "<div>&nbsp;</div>";
}
?>