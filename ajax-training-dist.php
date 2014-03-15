<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/training_fun.php');

$area=isset($_GET['area'])?$_GET['area']:"";
$dist=isset($_GET['dist'])?$_GET['dist']:"";
$opn=isset($_GET['opn'])?$_GET['opn']:"";
$venue=isset($_GET['venue'])?$_GET['venue']:"";
if($opn=='venuecap')
{	
	if($venue!='' || $venue!=NULL)
	{
		$v_Cap=0;
		$rsCap=venue_capacity($venue);
		$num_rows_cap=rowCount($rsCap);
		if($num_rows_cap>0)
		{
			$rowCap=getRows($rsCap);
			echo "Venue Capacity: ".$rowCap['maximumcapacity'];
			$v_Cap=$v_Cap+$rowCap['maximumcapacity'];
		}
		else
			echo "";
		
		echo "<input type='hidden' id='v_Cap' name='v_Cap' value='$v_Cap' />";
		unset($rowCap,$rsCap);
	}
}
if($opn=='areadtl')
{
	if($area!='' && $dist!='')
	{
		if($area=='Subdivision of PP')
		{
			echo "<td align='left'><span class='error'>*</span>Subdivision</td><td align='left'>\n";
			//echo "<select id='area' style='width:220px;'><option value='$subdivision'>".$_SESSION['subdiv_name']."</option></select>\n";
			echo "<select id='area' name='area' style='width:220px;'>\n";
			$rsSub=fatch_subdiv_from_personal_trainingpp_ag_dist($dist);
			$num_rows=rowCount($rsSub);
			if($num_rows>0)
			{
				for($i=1;$i<=$num_rows;$i++)
				{
					$rowSub=getRows($rsSub);
					echo "<option value='$rowSub[0]'>$rowSub[1]</option>\n";
					$rowSub=NULL;
				}
			}
			$rsSub=NULL;
			$num_rows=0;
			unset($rowSub,$rsSub,$num_rows);
			echo "</select></td>\n";
		}
	}
}
$post_stat=isset($_GET['post_stat'])?$_GET['post_stat']:"";
//$subdivision=$_GET['subdivision'];
$areapref=isset($_GET['areapref'])?$_GET['areapref']:"";
$tr_type=isset($_GET['tr_type'])?$_GET['tr_type']:"";
//$area=$_GET['area'];
if($opn=='membavl')
{
	if($areapref=='Subdivision of PP')
		$areapref='1';
	/*if($areapref=='Alloted Subdivision')
		$areapref='2';
	if($areapref=='Alloted PC')
		$areapref='3';
	if($areapref=='Assembly of Temporary Address')
		$areapref='4';
	if($areapref=='Assembly of Permanent Address')
		$areapref='5';
	if($areapref=='Assembly of Office Address')
		$areapref='6';*/
	if($post_stat!='' && $dist!='' && $areapref!='' && $area!='' && $tr_type!='')
	{
		$rsMembAvl=member_available_ag_dist($post_stat,$dist,$areapref,$area,$tr_type);
		$num_rows_MembAvl=rowCount($rsMembAvl);
		$rowMembAvl=getRows($rsMembAvl);
		if($num_rows_MembAvl>0)
		{		
			echo "Member Available: <span id='memb_avl'>".$rowMembAvl['memb_avl']."</span>";
		}
		else
			echo "";
		
		$rowMembAvl=NULL;
		$rsMembAvl=NULL;
		unset($rsMembAvl,$rowMembAvl,$num_rows_MembAvl);
	}
}
if($opn=='trnreq')
{
	if($dist!='' && $dist!=NULL)
	{
		$rsTr=fatch_training_type('');
		for($k=0;$k<=rowCount($rsTr);$k++)
		{
			$rowTr=getRows($rsTr);
			echo "<tr>";
			echo "<td align='left' width='30%'>".$rowTr['training_desc']."</td>\n";
			echo "<td align='left'>";
			$rsTrReq=training_required_ag_dist($dist,$rowTr['training_code']);
			$num_rows_TrReq=rowCount($rsTrReq);
			if($num_rows_TrReq>0)
			{
				
				for($i=0;$i<$num_rows_TrReq;$i++)
				{
					$rowTrReq=getRows($rsTrReq);
					echo $rowTrReq['post_stat'].": ".$rowTrReq['total'].";&nbsp;&nbsp;";
					$rowTrReq=NULL;
				}
			}
			else
				echo "";
			
			echo "</td>";
			echo "</tr>";
			unset($rsSelectedPP,$num_rows_TrReq);
			$rowTr=NULL;
		}
		unset($rsTr,$rowTr);
	}
}
if($opn=='trnalloted_dist')
{
	if($dist!='' && $dist!=NULL)
	{
		$rsTr=fatch_training_type('');
		for($k=0;$k<=rowCount($rsTr);$k++)
		{
			$rowTr=getRows($rsTr);
			echo "<tr>";
			echo "<td align='left' width='30%'>".$rowTr['training_desc']."</td>\n";
			echo "<td align='left'>";
			$rsTrReq=training_alloted_ag_dist($dist,$rowTr['training_code']);
			$num_rows_TrReq=rowCount($rsTrReq);
			if($num_rows_TrReq>0)
			{
				
				for($i=0;$i<$num_rows_TrReq;$i++)
				{
					$rowTrReq=getRows($rsTrReq);
					echo $rowTrReq['post_stat'].": ".$rowTrReq['total'].";&nbsp;&nbsp;";
					$rowTrReq=NULL;
				}
			}
			else
				echo "";
			
			echo "</td>";
			echo "</tr>";
			unset($rsSelectedPP,$num_rows_TrReq);
			$rowTr=NULL;
		}
		unset($rsTr,$rowTr);
	}
}
$training_venue=isset($_GET['training_venue'])?$_GET['training_venue']:"";
//$tr_type=isset($_GET['tr_type'])?$_GET['tr_type']:"";
$training_dt=isset($_GET['training_dt'])?$_GET['training_dt']:"";
$training_time=isset($_GET['training_time'])?$_GET['training_time']:"";
if($opn=='trnalloted')
{
	if($training_venue!='' && $tr_type!='')
	{
		$alloted=0;
		$rsTraining=training_alloted($training_venue,$tr_type,$training_dt,$training_time);
		$num_rows_Training=rowCount($rsTraining);
		if($num_rows_Training>0)
		{
			echo "<tr><td align='center' colspan='2'><b>For Selected Venue & Selected Training Type Training is scheduled</b></td></tr>";
			echo "<tr><td>&nbsp;</td><td align='left'>Date: ".$training_dt." &amp; Time: ".$training_time."</td>";
			echo "<tr><td>&nbsp;</td><td align='left'>";
			for($i=0;$i<$num_rows_Training;$i++)
			{
				$rowTraining=getRows($rsTraining);
				
				echo $rowTraining['post_stat'].": ".$rowTraining['total']."; ";
				$alloted=$alloted+$rowTraining['total'];
				$rowTraining=NULL;
			}
			echo "</td></tr>";
		}
		else
			echo "";
		
		echo "<input type='hidden' id='trn_alloted' name='trn_alloted' value='$alloted' />";
		unset($rowTraining,$rsTraining,$num_rows_Training);
	}
}
?>
