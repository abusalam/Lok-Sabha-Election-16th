<?php
//include 'mysqliconn.php';
//include 'ppdata.php';
class reserve1o {

private $result;
private $msqli; 
private $sobj;
private $result1;
function __construct($dist,$sub,$phase) {

// select QUERY ON A assembly TABLE
    
	
 	$this->sobj= new mysqliconn();
    $this->msqli=$this->sobj->getconn();
	$this->result = $this->msqli->query("SELECT a.forassembly as fasm, a.forsubdivision as fsub , a.forpc as fpc, a.number_of_member as memb, a.no_or_pc as npc, sum(a.numb) as pnumb , a.poststat as pst, b.no_party as ptyrqd FROM reserve a, `assembly_party` b WHERE a.forassembly = b.assemblycd AND a.forsubdivision = b.subdivisioncd AND a.number_of_member = b.no_of_member and substr(a.forsubdivision,1,2)='$dist' and a.forsubdivision='$sub' group by a.forassembly ,a.poststat
") or die($this->msqli->error.__LINE__);

// GOING THROUGH THE DATA

$this->msqli->autocommit(FALSE);
//$sql  = "update pers set groupid=?,booked=?,forassembly=?,forpc=?, where personcd=? ";
if ($phase==1) 
{
$sql  = "update personnela set groupid=?,booked=?,forassembly=?,selected=1 where personcd=? ";
}
else
{
$sql  = "update personnela set groupid=?,booked=?,forassembly=? where personcd=? ";
}

//$sql  = "update pers set booked=?,groupid=?,forasm=?,forpc=? where ersoncd=? ";

//$stmt = $mysqli->prepare("insert into test(testid) values(?)");

$this->stmt = $this->msqli->prepare($sql);
 //echo "binding failed";
$this->stmt->bind_param('isss',$gpd,$bk,$fasm,$psd);

//$this->stmt->bind_param('issss',$gpd,$bk,$fasm,$fpc,$psd);

 

	if($this->result->num_rows > 0) {
		$i=0;
		$k=0;
		
		
		while($row = $this->result->fetch_assoc()) {
		  $fasm1=$row['fasm'];
		  $sub=$row['fsub'];
		  $fpc=$row['fpc'];
		  $membno=$row['memb'];
		  $n_o_p=$row['npc'];
		  $p_numb=$row['pnumb'];
		  $pst=$row['pst'];
		  $preqd=$row['ptyrqd'];
		  if (strcmp($n_o_p,'N')==0)
		  {
		    $totres=$p_numb;
		  }
		  else
		  {
		  	$totres=round($p_numb*$preqd/100,0);
		  }
	/*	  echo $pst;
		  echo ' ';
		  echo $sub;
		  echo ' ';
		  echo $fasm;
		  echo ' ';
		  */
		  
		  $this->result1 = $this->msqli->query("SELECT count(forassembly) as cnt  from personnela  WHERE forassembly = '$fasm1' and poststat='$pst' and forsubdivision='$sub' and booked='R'") or die($this->msqli->error.__LINE__);
		  
		  while($row = $this->result1->fetch_assoc()) {
		  
		    $totresdone=$row['cnt'];
		  
		  }
		  
		  //$totres=round(.8*$totres);
		  $ppall1=new ppdata($sub,$pst,$dist,$fasm1,'S',2); // pp for subdivision 
		 
		  $ppallr=new ppdatar($sub,$pst,$dist,$fasm1,'S',1); // pp for reserve
						
		  // echo $ppall1->countnumb();
		 // echo $ppallr->countnumb();
		  // exit;
		  $bk='R';
		  $x=0;
		  $stg=0;
		  $k=0;
		  $y=0;
		$totres=$totres- $totresdone;
		  //
		  while( $k<$totres) 
		  {
		        if ($x< $ppall1->countnumb())
				{
		  			$psd=$ppall1->getperscdpp($x);
					
					$this->result_max = $this->msqli->query("SELECT max(groupid) as cnt_g FROM personnela where substr(personnela.forsubdivision,1,2)='$dist' and personnela.forsubdivision='$sub' and personnela.forassembly='$fasm1' and personnela.poststat='$pst' and booked='R'") or die($this->msqli->error.__LINE__);
					  while($row_max = $this->result_max->fetch_assoc()) {
						   if($row_max['cnt_g']==null)
						   {
							   $gpd=$x+1;
						   }
						   else
						   {
							   $gpd=$row_max['cnt_g']+1;
						   }
					  }
					$fasm=$fasm1;
					$this->stmt->execute();
					$x=$x+1;
				}
				else
				{
				        // echo $x;
				        // echo " ";
						// echo $x=$x+1;
						// echo "  ";
					 $stg++;
					  while($y < $ppallr->countnumb())
					  {						  
						  if($stg>0)
						  {							  
							  $asm_f=$ppallr->getasmpp($y);
							  $psd_g=$ppallr->getperscdpp($y);
							  $gpd_r=$ppallr->getgrpidpp($y);
							 
							 $sql1="SELECT personcd FROM `personnela` where poststat= '$pst' and substr(forsubdivision,1,2)='$dist' and (assembly_off<> '$asm_f' and assembly_temp<> '$asm_f' and assembly_perm<> '$asm_f') and booked=' ' and selected=1 and forsubdivision='$sub' order by rand_numb Limit 1";			 
							 $this->result1 = $this->msqli->query($sql1);
							// echo $sql1;
							   if($this->result1->num_rows > 0) 
							   {
								  $gd=$gpd+1; 
								 $this->msqli->query("update personnela set forassembly='$fasm1',groupid='$gd' where personcd='$psd_g'") or die($this->msqli->error.__LINE__);
								  while($row1 = $this->result1->fetch_assoc()) 
								  {
									$psd1=$row1['personcd'];
								  }
								 
								$this->msqli->query("update personnela set groupid='$gpd_r',booked='R',forassembly='$asm_f' where personcd='$psd1'") or die($this->msqli->error.__LINE__);
								 $stg--;
							   }			  
							
							 
						  }
						  else
						  {
							  break;
						  }
						  $y++;
					  }
					  $x=$x+1;
				  }
							
				$k=$k+1;
					
		  }
				
				 /* $ppallb=new ppdatar($sub,$pst,$dist,$asm_f,'S',2);//pp blank	
				  if($ppallb->countnumb()>0)
				  {
					  $z=0;
					  $psd1=$ppallb->getperscdpp($z); 
					  $this->msqli->query("update personnela set groupid='0',booked='R',forassembly='$asm_f' where personcd='$psd1'") or die($this->msqli->error.__LINE__);
					 $stg--;
				  }*/
					// $psd1=$ppallb->getperscdpp($y); 
					 
					//  exit;
					  
				 // }
				
		
					  
		  $this->msqli->commit();	  
		  		
		}
	
	}
	
	else {
		//echo 'NO  RESULTS';	
	} 
$this->stmt->close();
$this->msqli->close();
		
}
}
?>