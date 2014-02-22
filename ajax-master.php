<?php
session_start();
extract($_GET);
include_once('inc\db_trans.inc.php');
include_once('function\master_fun.php');
$sub_cd=decode($_GET['sub_cd']);
$act=$_GET['act'];
$opn=$_GET['opn'];
//====================== District =========================
if($opn=='subdiv')
{
	echo "<select name='Subdivision' id='Subdivision' style='width:240px;'>\n";      						
	$dist=$_GET['dist'];
	$rsSubdiv=fatch_subdivision_master('',$dist);
	$num_rows=rowCount($rsSubdiv);
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Subdivision-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowSubDiv=getRows($rsSubdiv);
			echo "<option value='$rowSubDiv[subdivisioncd]'>$rowSubDiv[subdivision]</option>\n";
			unset($rowSubDiv);
		}
	}
	echo "</select>\n";
	unset($rsSubdiv,$num_rows);
}
//======================== Subdivision ==========================
if($sub_cd!='' && $act=='del')
{
	echo "<img src='images/loading.gif' alt='' />";
	$cnt=check_subdivision_delete($sub_cd);
	if($cnt==0)
	{
		$ret=delete_subdivision($sub_cd);
		if($ret==1){
			//echo "<script>location.replace('subdivision-master.php');</script>";
		?>		<script>window.opener.location.replace("subdivision-master.php"); window.close();</script> <?php
		}
	}
	else
	{
		echo "<script>window.opener.document.getElementById('msg').innerHTML='Subdivision details already used';  window.close();</script>";
	}
	unset($cnt,$ret);
}
//=================== Block/ Muni ======================
$blockminicd=decode($_GET['blockminicd']);
if($blockminicd!='' && $act=='del')
{
	echo "<img src='images/loading.gif' alt='' />";
	$cnt=check_block_muni_delete($blockminicd);
	if($cnt==0)
	{
		$ret=delete_block_muni($blockminicd);
		if($ret==1){
			//echo "<script>location.replace('subdivision-master.php');</script>";
		?>		<script>window.opener.location.replace("block-muni-master.php"); window.close();</script> <?php
		}
	}
	else
	{
		echo "<script>window.opener.document.getElementById('msg').innerHTML='Block/ Municipality details already used';  window.close();</script>";
	}
	unset($cnt,$ret);
}
//=================== BANK ======================
$bank_cd=decode($_GET['bank_cd']);
if($bank_cd!='' && $act=='del')
{
	echo "<img src='images/loading.gif' alt='' />";
	$cnt=check_bank_delete($bank_cd);
	if($cnt==0)
	{
		$ret=delete_bank($bank_cd);
		if($ret==1){
			//echo "<script>location.replace('subdivision-master.php');</script>";
		?>		<script>window.opener.location.replace("bank-master.php"); window.close();</script> <?php
		}
	}
	else
	{
		echo "<script>window.opener.document.getElementById('msg').innerHTML='Bank details already used';  window.close();</script>";
	}
	unset($cnt,$ret);
}
//=================== Branch ======================
$branch_cd=decode($_GET['branch_cd']);
if($branch_cd!='' && $act=='del')
{
	$bank=decode($_GET['bank']);
	echo "<img src='images/loading.gif' alt='' />";
	$cnt=check_branch_delete($branch_cd,$bank);
	if($cnt==0)
	{
		$ret=delete_branch($branch_cd,$bank);
		if($ret==1){
			//echo "<script>location.replace('subdivision-master.php');</script>";
		?>		<script>window.opener.location.replace("branch-master.php"); window.close();</script> <?php
		}
	}
	else
	{
		echo "<script>window.opener.document.getElementById('msg').innerHTML='Branch details already used';  window.close();</script>";
	}
	unset($cnt,$ret);
}
//===================================PC==========================================

$pc_cd=decode($_GET['pc_cd']);
if($pc_cd!='' && $act=='del')
{
	$subdiv=decode($_GET['subdiv']);
	echo "<img src='images/loading.gif' alt='' />";
	$cnt=check_parliament_delete($pc_cd,$subdiv);
	if($cnt==0)
	{
		$ret=delete_parliament($pc_cd,$subdiv);
		if($ret==1){
			//echo "<script>location.replace('subdivision-master.php');</script>";
		?>		<script>window.opener.location.replace("pcmaster.php"); window.close();</script> <?php
		}
	}
	else
	{
		echo "<script>window.opener.document.getElementById('msg').innerHTML='Parliament details already used';  window.close();</script>";
	}
	unset($cnt,$ret);
}

//=================================== ASSEMBLY =====================================
$ass_cd=decode($_GET['ass_cd']);
if($ass_cd!='' && $act=='del')
{
	echo "<img src='images/loading.gif' alt='' />";
	$cnt=check_assembly_delete($ass_cd);
	if($cnt==0)
	{
		$ret=delete_assembly($ass_cd);
		if($ret==1){
			//echo "<script>location.replace('subdivision-master.php');</script>";
		?>		<script>window.opener.location.replace("assembly_master.php"); window.close();</script> <?php
		}
	}
	else
	{
		echo "<script>window.opener.document.getElementById('msg').innerHTML='Assembly details already used';  window.close();</script>";
	}
	unset($cnt,$ret);
}
//======================= Polling Station ============================
if($opn=='assembly')
{
	include_once('function\add_fun.php');
	$sub_div=$_GET['sub_div'];
	echo "<select name='assembly' id='assembly' style='width:200px;' onchange='return assembly_change(this.value);'>\n";      						
//	$dist=$_GET['dist'];
	$rsAss=fatch_assembly($sub_div);
	$num_rows=rowCount($rsAss);
	if($num_rows>0)
	{
		echo "<option value='0'>-Select Assembly-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowAss=getRows($rsAss);
			echo "<option value='$rowAss[assemblycd]'>$rowAss[assemblyname]</option>\n";
			unset($rowAss);
		}
	}
	echo "</select>\n";
	unset($rsAss,$num_rows);
}
if($opn=='dcrc')
{
	$assembly=$_GET['assembly'];
	echo "<select name='dcrc' id='dcrc' style='width:200px;' onchange='return dcrc_change(this.value);'>\n";      						
	$rsDCRC=fatch_dcrc($assembly);
	$num_rows=rowCount($rsDCRC);
	if($num_rows>0)
	{
		echo "<option value='0'>-Select DCRC-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowDCRC=getRows($rsDCRC);
			echo "<option value='$rowDCRC[dcrcgrp]'>$rowDCRC[dcrcgrp]</option>\n";
			unset($rowDCRC);
		}
	}
	echo "</select>\n";
	unset($rsDCRC,$num_rows);
}
if($opn=='member')
{
	$assembly=$_GET['assembly'];
	$dcrc=$_GET['dcrc'];
	echo "<input type='text' name='member' id='member' style='width:192px;' maxlength='2' readonly='readonly'";   						
	$rsDCRC=fatch_dcrc_member($dcrc,$assembly);
	$num_rows=rowCount($rsDCRC);
	if($num_rows>0)
	{
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowDCRC=getRows($rsDCRC);
			echo " value='$rowDCRC[number_of_member]'";
			unset($rowDCRC);
		}
	}
	echo " />\n";
	unset($rsDCRC,$num_rows);
}
$psno=decode($_GET['psno']);
$assembly=decode($_GET['assembly']);
if($psno!='' && $assembly!='' && $act=='del')
{
	echo "<img src='images/loading.gif' alt='' />";
//	$cnt=check_assembly_delete($ass_cd);
//	if($cnt==0)
//	{
		$ret=delete_ps($psno,$assembly);
		if($ret==1){
			//echo "<script>location.replace('subdivision-master.php');";
		?>		<script>window.opener.location.replace("polling-station.php"); window.close();</script> <?php
		}
//	}
//	else
//	{
//		echo "<script>window.opener.document.getElementById('msg').innerHTML='Assembly details already used';  window.close();";
//	}
	unset($cnt,$ret);
}
//====================== DCRC Master =========================

?>