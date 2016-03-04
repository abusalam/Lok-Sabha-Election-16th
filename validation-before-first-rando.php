<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Validation before first randomisation</title>
<?php
include('header/header.php');
include('function/validation_first.php');
?>
<?php
$pc_cd="0";
if(isset($_SESSION['subdiv_cd']) && $_SESSION['subdiv_cd']!=null)
	$subdiv_cd=sprintf("%04d",$_SESSION['subdiv_cd']);
?>
</head>
<?php
if(isset($_REQUEST['start']) && $_REQUEST['start']!=null)
	$start=$_REQUEST['start'];
else
	$start="";
if($start=="Start")
{
	$count=0;
	/***************Post status validation***********/
	if($count==0)
	{
		$rs_asm_memb=fetch_assembly_member();
		$num_rows=rowCount($rs_asm_memb);
		if($num_rows>0)
		{
			for($i=0;$i<$num_rows;$i++)
			{
			  $row_asm_memb=getRows($rs_asm_memb);
			  $rs_asmpostdata=define_post_status($row_asm_memb['no_of_member']);
			  $rs_postdata=check_post_status($row_asm_memb['no_of_member']);
			  /************comparing two array********/
			  $result=array_diff_assoc($rs_asmpostdata,$rs_postdata);
			  if(count($result)>0)
			  {
				 $count++;
				 $msg="<div class='alert-error'>Posting status order does not match</div>";
				 break;
			  }
			
			}
		}
	}
	/************************Assembly party and DCRC validate**************/
	
	/*$array_asmparty=fetch_array_asmparty();
	foreach($array_asmparty as $arprow) {
		$cnt=check_in_dcrcparty($arprow['ad'],$arprow['nm'],$arprow['np'],$arprow['sd']);
		if($cnt==0)
		{
			$count++;
			$msg="<div class='alert-error'>Data does not match between DCRC party and assembly master</div>";
			break;
		}
	}*/
	
	/*********************Assembly Party and reserve validate************/
	if($count==0)
	{
		$array_subdiv=fetch_subdivision($subdiv_cd);
		foreach($array_subdiv as $row_subdiv){
			$subdiv=$row_subdiv['sd'];
			$rsTrReq=fetch_percentage_number($subdiv,'');
				$num_rows_TrReq=rowCount($rsTrReq);
				$p1_no_count=0;
				$p1_re_count=0;
				$p2_no_count=0;
				$p2_re_count=0;
				$p3_no_count=0;
				$p3_re_count=0;
				$pr_no_count=0;
				$pr_re_count=0;
				$pa_no_count=0;
				$pa_re_count=0;
				$pb_no_count=0;
				$pb_re_count=0;
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
						 $totres=(strcmp($n_o_p,'N')==0)?$p_numb:round($p_numb*$preqd/100,0);
						 
						  if($pst=='P1')
						  {
							  $p1_no_count=$preqd+$p1_no_count;
							  $p1_re_count=$preqd+$p1_re_count+$totres;
						  }
						  else if($pst=='P2')
						  {
							 $p2_no_count=$preqd+$p2_no_count;
							 $p2_re_count=$preqd+$p2_re_count+$totres;
						  }
						  else if($pst=='P3')
						  {
							  $p3_no_count=$preqd+$p3_no_count;
							 $p3_re_count=$preqd+$p3_re_count+$totres;
						  }
						  else if($pst=='PR')
						  {
							  $pr_no_count=$preqd+$pr_no_count;
							 $pr_re_count=$preqd+$pr_re_count+$totres;
						  }
						  else if($pst=='PA')
						  {
							  $pa_no_count=$preqd+$pa_no_count;
							 $pa_re_count=$preqd+$pa_re_count+$totres;
						  }
						  else if($pst=='PB')
						  {
							  $pb_no_count=$preqd+$pb_no_count;
							 $pb_re_count=$preqd+$pb_re_count+$totres;	
						  }
						
					}
					
					//echo $p1_no_count;
					//echo  $p1_re_count;
					//echo $subdiv;
					
					$p1cnt=getPostno("P1",$subdiv);
					$p2cnt=getPostno("P2",$subdiv);
					$p3cnt=getPostno("P3",$subdiv);
					$prcnt=getPostno("PR",$subdiv);
					$pacnt=getPostno("PA",$subdiv);
					$pbcnt=getPostno("PB",$subdiv);
				//	echo $p1cnt;
					$p1_diff=$p1_re_count-$p1cnt;
					$p2_diff=$p2_re_count-$p2cnt;
					$p3_diff=$p3_re_count-$p3cnt;
					$pa_diff=$pa_re_count-$pacnt;
					$pr_diff=$pr_re_count-$prcnt;
					$pb_diff=$pb_re_count-$pbcnt;
					
					switch(1)
					{
						case ($p1_no_count>$p1cnt):
						  $count++;
						  $msg="<div class='alert-error'>".$p1_diff." Party required for P1</div>";
						  break;
						case ($p1_re_count>$p1cnt):
						  $count++;
						  $msg="<div class='alert-error'>".$p1_diff." Party required for P1</div>";
						  break;
						case ($p2_no_count>$p2cnt):
						  $count++;
						  $msg="<div class='alert-error'>".$p2_diff." Party required for P2</div>";
						  break;
						case ($p2_re_count>$p2cnt):
						  $count++;
						  $msg="<div class='alert-error'>".$p2_diff." Party required for P2</div>";
						  break;
						 case ($p3_no_count>$p3cnt):
						  $count++;
						  $msg="<div class='alert-error'>".$p3_diff." Party required for P3</div>";
						  break;
						case ($p3_re_count>$p3cnt):
						  $count++;
						  $msg="<div class='alert-error'>".$p3_diff." Party required for P3</div>";
						  break;
						case ($pr_no_count>$prcnt):
						  $count++;
						  $msg="<div class='alert-error'>".$pr_diff." Party required for PR</div>";
						  break;
						case ($pr_re_count>$prcnt):
						  $count++;
						  $msg="<div class='alert-error'>".$pr_diff." Party required for PR</div>";
						  break;
						case ($pa_no_count>$pacnt):
						  $count++;
						  $msg="<div class='alert-error'>".$pa_diff." Party required for PA</div>";
						  break;
						case ($pa_re_count>$pacnt):
						  $count++;
						  $msg="<div class='alert-error'>".$pa_diff." Party required for PA</div>";
						  break;
						case ($pb_no_count>$pbcnt):
						  $count++;
						  $msg="<div class='alert-error'>".$pb_diff." Party required for PB</div>";
						  break;
						case ($pb_re_count>$pbcnt):
						  $count++;
						  $msg="<div class='alert-error'>".$pb_diff." Party required for PB</div>";
						  break;
						default:
						 break;
						  
					}
				}
				
		}
		/****************END OF FOREACH LOOP************************/
	}
	/*********************Personnela validation*************************/
	if($count==0)
	{
	   $rs_Per=fatch_personnelavalidation();
	   $num_rows_per = rowCount($rs_Per);
	   if($num_rows_per>0)
		{
			//redirect("ajax/office_excel.php");
			$count++;
			$msg="<div class='alert-error'>Personnel Record(s) invalid</div>";
			$errorfile="<a href='ajax/personnela_validation_error.php'>View File</a>";
		}
	}
	//exit();
	/************comparing two array********/
	//$result1=array_intersect($array_asmparty,$array_dcrcparty);
	//echo count($result1);
		
	//exit();
	//echo count($result1);
	
	/*************************show success message*****************/
	if($count==0)
	{
		 $msg="<div class='alert-success'>Successfully validate</div>";
	}
} 
?>
<body>
<div width="100%" align="center">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="center"><table width="1000px" class="table_blue">
	<tr><td align="center"><div width="50%" class="h2"><?php print isset($environment)?$environment:""; ?></div></td></tr>
<tr><td align="center"><?php print $district; ?> DISTRICT</td></tr>
<tr><td align="center"><?php echo $subdiv_name; ?> SUBDIVISION</td></tr>
<tr>
  <td align="center">VALIDATION BEFORE FIRST RANDOMISATION</td></tr>
<tr><td align="center"><form method="post" name="form1" id="form1">
<table width="50%" class="form" cellpadding="0">
	<tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
    <tr><td height="18px" colspan="3" align="center"><?php print isset($msg)?$msg:""; ?>&nbsp;&nbsp;&nbsp; <?php print isset($errorfile)?$errorfile:""; ?><span id="msg" class="error"></span></td></tr>
	<tr>
      <td align="center" colspan="3"><div id="populate_result">&nbsp;</div></td></tr>
    <tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<input type="hidden" id="hid_subdiv" value="<?php print $subdiv_cd; ?>" />
    <input type="hidden" name="hid_rand" value="<?php echo rand(0,500); ?>" />
	<!--<tr><td align="center" colspan="2">Password: &nbsp;&nbsp;&nbsp;<input type="password" id="txt1" name="txt1" /></td></tr>-->
    <tr><td align="center" colspan="3"><img src="images/blank.gif" alt="" height="1px" /></td></tr>
	<tr>
	  <td align="center"></td>
      <td align="center"><input type="submit" name="start" id="start" value="Start" class="button"  style="height:50px; width:100px;" /></td>
      <td align="center"></td></tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr><td colspan="3" align="center"><img src="images/blank.gif" alt="" height="5px" /></td></tr>
</table></form>
</td></tr></table>
</td></tr>
</table>
</div>
<div id="fakecontainer" style="display:none;"><div id="loading">Please wait...</div></div> 
</body>

</html>

<script language="javascript" type="text/javascript">
(function (d) {
  d.getElementById('form1').onsubmit = function () {
	  d.getElementById('form1').style.display= 'none';
      d.getElementById('fakecontainer').style.display = 'block';
  };
}(document));
</script>