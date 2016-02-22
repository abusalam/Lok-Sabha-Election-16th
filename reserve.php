<?php
//include 'mysqliconn.php';
//include 'ppdata.php';
class reserve {

private $result;
private $msqli; 
private $sobj;
function __construct($subd,$phase) {

// select QUERY ON A assembly TABLE
    
	
 	$this->sobj= new mysqliconn();
    $this->msqli=$this->sobj->getconn();
	$this->result = $this->msqli->query("SELECT a.forassembly as fasm, a.forsubdivision as fsub , a.forpc as fpc, a.number_of_member  as memb, a.no_or_pc as npc, a.numb as pnumb , a.poststat as pst, b.no_party as ptyrqd FROM reserve a,  `assembly_party` b WHERE a.forassembly = b.assemblycd AND a.forsubdivision = b.subdivisioncd AND a.number_of_member = b.no_of_member and a.forsubdivision like '$subd' ") or die($this->msqli->error.__LINE__);

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

//$sql  = "update pers set booked=?,groupid=?,forasm=?,forpc=? where personcd=? ";

//$stmt = $mysqli->prepare("insert into test(testid) values(?)");

$this->stmt = $this->msqli->prepare($sql);
 //echo "binding failed";
$this->stmt->bind_param('isss',$gpd,$bk,$fasm,$psd);

//$this->stmt->bind_param('issss',$gpd,$bk,$fasm,$fpc,$psd);

 

	if($this->result->num_rows > 0) {
		$i=0;
		$k=0;
		            
		while($row = $this->result->fetch_assoc()) {
		  $fasm=$row['fasm'];
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
		  
		  
		  $ppall1=new ppdata($fpc,$pst,$sub,$fasm,'S',$phase); // pp for subdivision 
		  $bk='R';
		  $x=0;
		  $k=0;
		  //
		//  echo $ppall1->countnumb();
		//  echo "</br>";
		  while( $k<$totres) 
		  {
		        if ($x< $ppall1->countnumb())
				{
		  			$psd=$ppall1->getperscdpp($x);
					$gpd=$x;
					$this->stmt->execute();
					$x=$x+1;
				}
				else
				{
					break;
				
				}				
				
				$k=$k+1;
					
		  }
		  
		  $this->msqli->commit();
		  		
		}
	
	}
	
	else {
		echo 'Problem in reserve Formation ';	
	}

$this->stmt->close();
$this->msqli->close();
		
}
}
?>