<?php
session_start();
extract($_GET);
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');
include_once('function/training_fun.php');
$offccd=isset($_GET["offccd"])?$_GET["offccd"]:"";
//$personid=$_GET["personid"];
$bank=isset($_GET["bank"])?$_GET["bank"]:"";
$dist=isset($_GET["dist"])?$_GET["dist"]:"";
//=================Get office details===========================
if($offccd != '')
{
	$rsOffc=fatch_offcDtl($offccd);
	$num_rows = rowCount($rsOffc);
	if($num_rows<1)
	{
		echo "";
	}
	else
	{
		$rowOffc=getRows($rsOffc);
		/*if($personid=="n")
		{
			$personcd;
			$subdiv_cd=$rowOffc['subdivisioncd'];
			$_SESSION['subdiv_cd']=$subdiv_cd;
			$rsmaxcode=fatch_personnel_maxcode($subdiv_cd);
			$rowmaxcode=getRows($rsmaxcode);
			if($rowmaxcode[0]==NULL)
				$personcd=$subdiv_cd."00001";
			else
				$personcd=$rowmaxcode[0]+1;
			echo "<input type='text' name='p_id' id='p_id' style='width:142px;' readonly='readonly' value=$personcd />";
		}		
		else*/
		{
			echo "<label class='text_small'><b>Office Name: </b>".$rowOffc['office']."<br/><b>Desig. of O/C: </b>".$rowOffc['officer_desg']."</label>";
		}	
	}
	$rsOffc=NULL;
	$rowOffc=NULL;
	unset($rsOffc,$rowOffc,$num_rows);
}
else
{
	$rsOffc=NULL;
	unset($rsOffc);
}
//==========================Get Brance Name======================================
if($bank != '')
{
	$rsBranch=fatch_branch($bank);
	$num_rows = rowCount($rsBranch);
	if($num_rows<1)
	{
		echo "<select name='branch' id='branch' style='width:108px;'></select>";
	}
	else
	{
		echo "<select name='branch' id='branch' style='width:108px;'>\n";
		echo "<option value=''>-Select Branch-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
		  $rowBranch=getRows($rsBranch);
		  echo "<option value='$rowBranch[0]'>$rowBranch[2]</option>\n";
		}
		echo "</select>\n";
	}
	$rsBranch=NULL;
	$rowBranch=NULL;
	unset($rsBranch,$rowBranch,$num_rows);
}
else
{
	$rsBranch=NULL;
	unset($rsBranch);
}



//=============== Fatch Block/Municipality & Police Station===================

$subdiv; $pol; $ofcid;
$subdiv=isset($_GET["subdiv"])?$_GET["subdiv"]:"";
$pol=isset($_GET["pol"])?$_GET["pol"]:"";
$ofcid=isset($_GET["ofcid"])?$_GET["ofcid"]:"";
if($subdiv != '')
{
	if($pol=='n')
	{
		$rspol=fatch_PoliceStation($subdiv);
		$num_rows = rowCount($rspol);
		if($num_rows<1)
		{
			echo "<select name='PoliceStation' id='PoliceStation' style='width:150px;'></select>";
		}
		else
		{
			echo "<select name='PoliceStation' id='PoliceStation' style='width:150px;'>\n";
			echo "<option value='0'>-Select Police Station-</option>\n";
			for($i=1;$i<=$num_rows;$i++)
			{
			  $rowpol=getRows($rspol);
			  echo "<option value='$rowpol[0]'>$rowpol[2]</option>\n";
			}
			echo "</select>\n";
		}
		$rspol=NULL;
		$rowpol=NULL;
		unset($rspol,$rowpol,$num_rows);
	}
	/*else if($ofcid=='n')
	{
		$rsofc=fatch_office_maxcode($subdiv);
		$num_rows = rowCount($rsofc);
		if($num_rows<1)
		{
			echo "<input type='text' name='OfficeID' id='OfficeID' style='width:142px;' readonly='readonly' />";
		}
		else
		{
			$ofccd;
			$rowofc=getRows($rsofc);
			if($rowofc['officecd']==NULL)
				if ($subdiv!="0000")
					$ofccd=$pol."0001";
				else
					$ofccd="";
			else
			{
				//$ofccd=$rowofc['officecd']+1;
			   	    $temp=$rowofc['officecd'];
					$inc = 10000+substr($temp,-4)+1;
					$ofccd=$pol.substr($inc,-4);
		      //   echo $ofccd;
				 
			}
				//exit();
			echo "<input type='text' name='OfficeID' id='OfficeID' style='width:142px;' value='$ofccd' readonly='readonly' />\n";
		}
		$rsofc=NULL;
		$rowofc=NULL;
		unset($rsofc,$rowofc,$num_rows);
	}*/
	else
	{
		$rsblock=fatch_block($subdiv);
		$num_rows = rowCount($rsblock);
		if($num_rows<1)
		{
			echo "<select name='Municipality' id='Municipality' style='width:150px;'></select>";
		}
		else
		{
			echo "<select name='Municipality' id='Municipality' style='width:150px;'>\n";		
			echo "<option value='0'>-Select Block/Municipality-</option>\n";
			for($i=1;$i<=$num_rows;$i++)
			{
			  $rowblock=getRows($rsblock);
			  echo "<option value='$rowblock[0]'>$rowblock[2]</option>\n";
			}
			echo "</select>\n";	
		}
		$rsblock=NULL;
		$rowblock=NULL;
		unset($rsblock,$rowblock,$num_rows);
	}
}
//=================Get Personal details (BLO update)===========================
$mobile=isset($_GET["mobile"])?$_GET["mobile"]:"";
if($mobile != '')
{
	$rsPersonal=fatch_Personaldtl_mobile($mobile);
	$num_rows = rowCount($rsPersonal);
	if($num_rows<1)
	{
		echo "";
	}
	else
	{
		$rowPersonal=getRows($rsPersonal);

		{
			echo "<label class='text_small'><b>Employee Name: </b>".$rowPersonal['officer_name']." <b>PIN: </b>".$rowPersonal['personcd']."<br/> <b>Name of Office: </b>".$rowPersonal[       'office']." <b>Desig. of O/C: </b>".$rowPersonal['off_desg']."<br/> <b>Present Address: </b>".$rowPersonal['present_addr1']." <b>; </b>".$rowPersonal['present_addr1']."<br/><b>Present Assembly: </b>".$rowPersonal['assembly_temp']." <b>Permanent Assembly: </b>".$rowPersonal['assembly_perm']." <b>Place of Posting: </b>".$rowPersonal['assembly_off']."</label>";
		}	
	}
	$rsPersonal=NULL;
	$rowPersonal=NULL;
	unset($rsPersonal,$rowPersonal,$num_rows);
}
else
{
	$rsPersonal=NULL;
	unset($rsPersonal);
}
//=================Get Personal details (Termination)===========================
$PersonalCd=isset($_GET["PersonalCd"])?$_GET["PersonalCd"]:"";
if($PersonalCd != '')
{
	$rsPersonal=fatch_Personaldtl($PersonalCd);
	$num_rows = rowCount($rsPersonal);
	if($num_rows<1)
	{
		echo "";
	}
	else
	{
		$rowPersonal=getRows($rsPersonal);

		{
			echo "<label class='text_small'><b>Employee Name: </b>".$rowPersonal['officer_name']."<br/> <b>Name of Office: </b>".$rowPersonal[       'office']." <b>Desig. of O/C: </b>".$rowPersonal['off_desg']."<br/> <b>Present Address: </b>".$rowPersonal['present_addr1']." <b>; </b>".$rowPersonal['present_addr1']."<br/><b>Present Assembly: </b>".$rowPersonal['assembly_temp']." <b>Permanent Assembly: </b>".$rowPersonal['assembly_perm']." <b>Place of Posting: </b>".$rowPersonal['assembly_off']."</label>";
		}	
	}
	$rsPersonal=NULL;
	$rowPersonal=NULL;
	unset($rsPersonal,$rowPersonal,$num_rows);
}
else
{
	$rsPersonal=NULL;
	unset($rsPersonal);
}
//===============================Data Transffer==================================
$subdiv_swp; 
$subdiv_swp=isset($_GET["subdiv_swp"])?$_GET["subdiv_swp"]:"";
$off=isset($_GET["off"])?$_GET["off"]:"";
if($subdiv_swp != '' && $off=='n')
{
	
		$rsoff=fatch_office_agsubdiv($subdiv_swp);
		$num_rows = rowCount($rsoff);
		if($num_rows<1)
		{
			echo "<select name='officename' id='officename' style='width:170px;'></select>";
		}
		else
		{
			echo "<select name='officename' id='officename' style='width:170px;' disabled='disabled'>\n";
			echo "<option value='0'>-Select Office Name-</option>\n";
			for($i=1;$i<=$num_rows;$i++)
			{
			  $rowoff=getRows($rsoff);
			  echo "<option value='$rowoff[0]'>$rowoff[1]</option>\n";
			}
			echo "</select>\n";
		}
		$rsoff=NULL;
		$rowoff=NULL;
		unset($rsoff,$rowoff,$num_rows);
}
else
{
	$rsoff=NULL;
	unset($rsoff);
}
$opn=isset($_GET['opn'])?$_GET['opn']:"";
if($opn=="poststat")
{
	$pc_swp=isset($_GET["pc_swp"])?$_GET["pc_swp"]:"";
	$sub_swp=isset($_GET["sub_swp"])?$_GET["sub_swp"]:"";
	$rs=fatch_post_stat_wise_dtl_available($sub_swp,$pc_swp);
	$num_rows=rowCount($rs);
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
if($opn=="prev_poststat")
{
	$forpc_swp=isset($_GET["forpc_swp"])?$_GET["forpc_swp"]:"";
	$forsub_swp=isset($_GET["forsub_swp"])?$_GET["forsub_swp"]:"";
	/******************To be Transffered****************/
	$rsTrReq=fetch_percentage_number($forsub_swp,'');
			$num_rows_TrReq=rowCount($rsTrReq);
			$p1_stat_count=0;
			$p2_stat_count=0;
			$p3_stat_count=0;
			$pr_stat_count=0;
			$pa_stat_count=0;
			$pb_stat_count=0;
			if($num_rows_TrReq>0)
			{
				for($i=0;$i<$num_rows_TrReq;$i++)
				{
					$row=getRows($rsTrReq);
					  $fasm=$row['fasm'];
					  $sub=$row['fsub'];
					  $fpc=$row['fpc'];
					  $membno=$row['memb'];
					  $n_o_p=$row['npc'];
					  $p_numb=$row['pnumb'];
					  $pst=$row['pst'];
					  $preqd=$row['ptyrqd'];
					  if(strcmp($n_o_p,'N')==0)
					  {
						$totres=$p_numb;
					  }
					  else
					  {
						$totres=round($p_numb*$preqd/100,0);
					  }
					  if($pst=='P1')
					      $p1_stat_count=$preqd+$p1_stat_count+$totres;
					  else if($pst=='P2')
						 $p2_stat_count=$preqd+$p2_stat_count+$totres;
					  else if($pst=='P3')
						 $p3_stat_count=$preqd+$p3_stat_count+$totres;
					  else if($pst=='PR')
						 $pr_stat_count=$preqd+$pr_stat_count+$totres;
					  else if($pst=='PA')
						 $pa_stat_count=$preqd+$pa_stat_count+$totres;
					  else if($pst=='PB')
						 $pb_stat_count=$preqd+$pb_stat_count+$totres;
						
					
				}
				echo "<b>Required ::</b> ";
				if($p1_stat_count !=0)
				 echo "P1: ".$p1_stat_count.";&nbsp;";
				if($p2_stat_count !=0)
				 echo "P2: ".$p2_stat_count.";&nbsp;";
				if($p3_stat_count !=0)
				 echo "P3: ".$p3_stat_count.";&nbsp;";
				
				if($pa_stat_count !=0)
				 echo "PA: ".$pa_stat_count.";&nbsp;";
				if($pb_stat_count !=0)
				 echo "PB: ".$pb_stat_count.";&nbsp;";
				 if($pr_stat_count !=0)
				 echo "PR: ".$pr_stat_count.";&nbsp;";
				// echo "PB: 2232";
			}
			else
			   echo ""; 
	/******************Transffered*********************/
	$rs=fatch_post_stat_wise_dtl_transffered($forsub_swp,$forpc_swp);
	$num_rows=rowCount($rs);
	echo "</br><b>Available ::</b> ";
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
if($opn=="forpc_swp")
{
	$subdiv=$_GET["subdiv_swp"];
	$rsPC=fatch_pc($subdiv);
	$num_rows=rowCount($rsPC);
	if($num_rows>0)
	{
		echo "<select name='forpc' id='forpc' style='width:170px;' onchange='javascript:return forpc_change(this.value);'>\n";
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
		echo "<select name='forpc' id='forpc' style='width:170px;'></select>";
	}
	$num_rows=0;			
	$rsPC=NULL;
	unset($rsPC,$rowPC,$num_rows);
}
//============================= Assembly Party ==============================
if($opn=='pc')
{
	$subdiv=$_GET["sub-div"];
	$rsPC=fatch_pc($subdiv);
	$num_rows=rowCount($rsPC);
	if($num_rows>0)
	{
		echo "<select name='pc' id='pc' style='width:200px;' onchange='javascript:return pc_change(this.value);'>\n";
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
		echo "<select name='pc' id='pc' style='width:200px;'></select>";
	}
	$num_rows=0;			
	$rsPC=NULL;
	unset($rsPC,$rowPC,$num_rows);
}
if($opn=='assembly')
{
	$sub_div=$_GET["sub_div"];
	$pc=$_GET["pc"];
	$rsAssembly=fatch_assembly_ag_pc($pc,$sub_div);
	$num_rows=rowCount($rsAssembly);
	if($num_rows>0)
	{
		echo "<select name='assembly' id='assembly' style='width:200px;'>\n";
		echo "<option value='0'>-Select Assembly-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowAssembly=getRows($rsAssembly);
			echo "<option value='$rowAssembly[0]'>$rowAssembly[1]</option>\n";
			$rowAssembly=NULL;
		}
		echo "</select>";
	}
	else
	{
		echo "<select name='assembly' id='assembly' style='width:200px;'></select>";
	}
	$num_rows=0;			
	$rsAssembly=NULL;
	unset($rsAssembly,$rowAssembly,$num_rows);
}
if($opn=='rowcreate')
{
	$row=$_GET['row'];
	echo "<td align='center'><select name='posting_status".$row."' id='posting_status".$row."' style='width:150px;'>
      						<option value='0'>-Select Posting Status-</option>\n";
                             	$rsP=fatch_postingstatus();
									$num_rows=rowCount($rsP);
									if($num_rows>0)
									{
										for($i=1;$i<=$num_rows;$i++)
										{
											$rowP=getRows($rsP);
											echo "<option value='$rowP[0]'>$rowP[1]</option>\n";
										}
									}
									$rsP=NULL;
									$num_rows=0;
									$rowP=NULL;
									unset($rsP,$rowP,$num_rows);
							
      	echo			"</select></td>\n
        <td align='center'><select name='per_num".$row."' id='per_num".$row."'>
        					<option value='N'>Number</option>
                            <option value='P'>Percentage</option>
                        </select></td>
        <td align='center'><input type='text' name='numb".$row."' id='numb".$row."' maxlength='3' onkeypress='javascript:return wholenumbersonly(event);' style='width:30px;' /></td>";
}
if($opn=='reserve')
{
	$assembly=$_GET["assemb"];
	$noofmember=$_GET["noofmember"];
	$rsReserve=fatch_reserve_ag_assembly($assembly,$noofmember);
	$num_rows=rowCount($rsReserve);
	//echo 
	if($num_rows>0)
	{
		echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
		echo "<tr height='30px'><th>Sl.</th>
            <th>Parliament Constituency</th>
            <th>Assembly</th>
			<th>Post Status</th>
			<th>Number</th>
            \n";
		//echo "<th>Delete</th>\n";
		echo "</tr>";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowReserve=getRows($rsReserve);
			$ass='"'.encode($rowReserve['forassembly']).'"';
			$no='"'.encode($rowReserve['number_of_member']).'"';
			$poststat='"'.encode($rowReserve['poststat']).'"';
			 echo "<tr><td align='center' width='4%'>$i.</td><td align='left' width='37%'>$rowReserve[pccd]-$rowReserve[pcname]</td>\n"
			 ."<td width='37%' align='left'>$rowReserve[forassembly]-$rowReserve[assemblyname]</td>\n"
			 ."<td width='11%' align='center'>$rowReserve[poststat]</td>\n"
			 ."<td width='11%' align='center'>$rowReserve[numb] $rowReserve[no_or_pc]</td></tr>\n";
			// echo "<td align='center' width='8%'><img src='images/edit.png' alt='' height='20px' onclick='javascript:edit_reserve($ass,$no,$poststat);' title='Click to edit' /></td></tr>\n";
			 //echo "<td align='center' width='8%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_reserve($ass,$no);' title='Click to delete' /></td></tr>\n";
			 $rowReserve=NULL;
		}
		unset($rsReserve,$rowReserve,$num_rows);
	}
	else
	{
		echo "No record found";
	}
}
if($opn=='assembly_paty')
{
	$sub_div=$_GET["sub_div"];
	$pc=$_GET["pc"];
	$rsAP=fatch_assembly_party_list($sub_div,$pc);
	$num_rows=rowCount($rsAP);
	if($num_rows>0)
	{
		echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
		echo "<tr height='30px'><th>Sl.</th>
			<th>Subdivision</th>
            <th>Parliament Constituency</th>
            <th>Assembly</th>
			<th>Number</th>
			<th>Party</th>
            <th>Delete</th>\n";
		//echo "<th>Delete</th>\n";
		echo "</tr>";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowAP=getRows($rsAP);
			$ass='"'.encode($rowAP['assemblycd']).'"';
			$no='"'.encode($rowAP['no_of_member']).'"';
			//$poststat='"'.encode($rowReserve['poststat']).'"';
			 echo "<tr><td align='right' width='3%'>$i.</td><td align='left' width='28%'>$rowAP[subdivision]</td>\n";
			 echo "<td width='20%' align='center'>$rowAP[pccd]-$rowAP[pcname]</td>\n";
			 echo "<td width='28%' align='left'>$rowAP[assemblycd]-$rowAP[assemblyname]</td>\n";
			 echo "<td width='10%' align='center'>$rowAP[no_of_member]</td>\n";
			 echo "<td width='10%' align='center'>$rowAP[no_party]</td>\n";
			 
			 echo "<td align='center' width='8%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_ass_party($ass,$no);' title='Click to delete' /></td>\n";
			 //echo "<td align='center' width='8%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_reserve($ass,$no);' title='Click to delete' /></td></tr>\n";
			 $rowAP=NULL;
		}
		unset($rsAP,$rowAP,$num_rows);
	}
	else
	{
		echo "No record found";
	}
}
if($opn=='del_ass')
{
	$ass=$_GET["ass"];
	$no=$_GET["no"];
	if(($ass!="" || $ass!=0) && ($no!="" || $no!=0))
	{
		$total=assembly_party_del_check(decode($ass),decode($no));
		if($total=="0")
		{
			$aa=delete_assembly_party_reserve(decode($ass),decode($no));
			//echo $aa;
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
	
	$sub_div=$_GET["sub_div"];
	$pc=$_GET["pc"];
	$rsAP=fatch_assembly_party_list($sub_div,$pc);
	$num_rows=rowCount($rsAP);
	if($num_rows>0)
	{
		echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
		echo "<tr height='30px'><th>Sl.</th>
			<th>Subdivision</th>
            <th>Parliament Constituency</th>
            <th>Assembly</th>
			<th>Number</th>
			<th>Party</th>
            <th>Delete</th>\n";
		//echo "<th>Delete</th>\n";
		echo "</tr>";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowAP=getRows($rsAP);
			$ass='"'.encode($rowAP['assemblycd']).'"';
			$no='"'.encode($rowAP['no_of_member']).'"';
			//$poststat='"'.encode($rowReserve['poststat']).'"';
			 echo "<tr><td align='right' width='3%'>$i.</td><td align='left' width='28%'>$rowAP[subdivision]</td>\n";
			 echo "<td width='20%' align='center'>$rowAP[pccd]-$rowAP[pcname]</td>\n";
			 echo "<td width='28%' align='left'>$rowAP[assemblycd]-$rowAP[assemblyname]</td>\n";
			 echo "<td width='10%' align='center'>$rowAP[no_of_member]</td>\n";
			 echo "<td width='10%' align='center'>$rowAP[no_party]</td>\n";
			 
			 echo "<td align='center' width='8%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_ass_party($ass,$no);' title='Click to delete' /></td>\n";
			 //echo "<td align='center' width='8%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_reserve($ass,$no);' title='Click to delete' /></td></tr>\n";
			 $rowAP=NULL;
		}
		unset($rsAP,$rowAP,$num_rows);
	}
	else
	{
		echo "No record found";
	}
}
if($opn=='assembly_ag_sub')
{
	$sub_div=$_GET["sub-div"];

	$rsAssembly=fatch_assembly_ag_subdiv($sub_div);
	$num_rows=rowCount($rsAssembly);
	if($num_rows>0)
	{
		echo "<select name='assembly' id='assembly' style='width:200px;'>\n";
		echo "<option value='0'>-Select Assembly-</option>\n";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowAssembly=getRows($rsAssembly);
			echo "<option value='$rowAssembly[0]'>$rowAssembly[2]</option>\n";
			$rowAssembly=NULL;
		}
		echo "</select>";
	}
	else
	{
		echo "<select name='assembly' id='assembly' style='width:200px;'></select>";
	}
	$num_rows=0;			
	$rsAssembly=NULL;
	unset($rowAssembly,$rsAssembly,$num_rows);
}
if($opn=='dcrc_result')
{
	include_once('function/master_fun.php');
	$sub_div=isset($_GET["sub_div"])?$_GET["sub_div"]:"";
	$assembly=isset($_GET["ass"])?$_GET["ass"]:"";
	$dist=isset($_GET["dist"])?$_GET["dist"]:"";
	
	$rsDCRC=fatch_dcrc_list($sub_div,$assembly,$dist);
	$num_rows=rowCount($rsDCRC);
	if($num_rows>0)
	{
		echo "<div class='scroller1'>";
		echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
		echo "<tr height='30px'><th>Sl.</th>
		
			<th>DCRC</th>
			<th>Assembly</th>
            <th>Member</th>
            <th>Party</th>
			<th>DC Venue & Address</th>
			<th>DC Date - Time</th>
			<th>RC Venue & Address</th>
            <th>Delete</th>\n";
		//echo "<th>Delete</th>\n";
		echo "</tr>";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowDCRC=getRows($rsDCRC);
			$dcrc_cd='"'.encode($rowDCRC['dcrcgrp']).'"';
			echo "<tr><td align='center' width='3%'>$i.</td><td align='center' width='6%'>$rowDCRC[dcrcgrp]</td><td align='center' width='5%'>$rowDCRC[assemblycd]</td>\n";
			echo "<td width='7%' align='center'>$rowDCRC[no_of_member]</td>\n";
			echo "<td width='5%' align='center'>$rowDCRC[partyindcrc]</td>\n";
			echo "<td width='29%' align='center'>".$rowDCRC['dc_venue'].", ".$rowDCRC['dc_addr']."</td>\n";
			echo "<td width='15%' align='center'>$rowDCRC[dc_date] - $rowDCRC[dc_time]</td>\n";
			echo "<td width='25%' align='center'>".$rowDCRC['rcvenue'].", ".$rowDCRC['rc_addr']."</td>\n";
			echo "<td align='center' width=5%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_dcrc($dcrc_cd);' title='Click to delete' /></td>\n";
			$rowDCRC=NULL;
		}
		echo "</table>\n";
		echo "</div>";
		$num_rows=0;			
		unset($rsDCRC,$num_rows,$rowDCRC);
	}
	else
	{
		echo "No record found";
	}	
}
if($opn=='del_dcrc')
{
	include_once('function/master_fun.php');
	$dcrc=$_GET["dcrc"];
	if(($dcrc!="" || $dcrc!=0))
	{
		$total=dcrc_del_check(decode($dcrc));
		if($total=="0")
		{
			$aa=delete_dcrc(decode($dcrc));
			//echo $aa;
			if($aa==1)
			{
				echo "<span class='alert-success'>Record deleted successfully</span><br />\n";
			}
		}
		else
		{
			echo "<span class='error'>Record already used in Polling Station</span><br />\n";
		}
	}
		
	$sub_div=$_GET["sub_div"];
	$assembly=$_GET["assembly"];
	
	$rsDCRC=fatch_dcrc_list($sub_div,$assembly);
	$num_rows=rowCount($rsDCRC);
	if($num_rows>0)
	{
		echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' id='table1'>\n";
		echo "<tr height='30px'><th>Sl.</th>
			<th>DCRC</th>
            <th>No of Member</th>
            <th>No of Party</th>
			<th>DC Venue</th>
			<th>DC Date - Time</th>
			<th>RC Venue</th>
            <th>Delete</th>\n";
		//echo "<th>Delete</th>\n";
		echo "</tr>";
		for($i=1;$i<=$num_rows;$i++)
		{
			$rowDCRC=getRows($rsDCRC);
			$dcrc_cd='"'.encode($rowDCRC['dcrcgrp']).'"';
			echo "<tr><td align='right' width='3%'>$i.</td><td align='left' width='10%'>$rowDCRC[dcrcgrp]</td>\n";
			echo "<td width='11%' align='center'>$rowDCRC[no_of_member]</td>\n";
			echo "<td width='10%' align='left'>$rowDCRC[partyindcrc]</td>\n";
			echo "<td width='25%' align='center'>$rowDCRC[dc_venue]</td>\n";
			echo "<td width='15%' align='center'>$rowDCRC[dc_date] - $rowDCRC[dc_time]</td>\n";
			echo "<td width='20%' align='center'>$rowDCRC[rcvenue]</td>\n";
			echo "<td align='center' width=6%'><img src='images/delete.png' alt='' height='20px' onclick='javascript:delete_dcrc($dcrc_cd);' title='Click to delete' /></td>\n";
			$rowDCRC=NULL;
		}
		echo "</table>\n";
		$num_rows=0;			
		unset($rsDCRC,$rowDCRC,$num_rows);
	}
	else
	{
		echo "No record found";
	}
}
?>