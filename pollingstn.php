<?php
//include 'mysqliconn.php';
include 'ppdata.php';
include 'assemblydata.php';
include 'groupdcrcdata.php';
include 'psdata.php';
include 'mysqliconn.php';
class pollingstn {


private $result;
private $msqli; 
private $sobj;
function __construct($dist,$sub,$asm) {

// select QUERY ON A assembly TABLE
    
	
 	$this->sobj= new mysqliconn();
    $this->msqli=$this->sobj->getconn();
	$this->msqli->autocommit(FALSE);
    $sql  = "update pollingstation set groupid=? where forassembly=? and member=? and psno=? and psfix=?";


 $stmt = $this->msqli->prepare($sql); //,groupid=?,forasm=?,forpc=? where personcd=? ");
$stmt->bind_param('isiis',$grpd,$assembly,$membno,$pollstn,$polfix );

	
$this->result = $this->msqli->query("select assemblycd,number_of_member,dcrcgrp from dcrc_party where substr(subdivisioncd,1,2)='$dist' and subdivisioncd='$sub' and assemblycd='$asm'") or die($this->msqli->error.__LINE__);

if($this->result->num_rows > 0) {
		$i=0;
		$k=0;
		            
		while($row = $this->result->fetch_assoc()) {
		
			$assembly=$row['assemblycd'];
			$membno=$row['number_of_member'];
			$dcrccode=$row['dcrcgrp'];
			
			
 	        $grpdc=new groupdcrcdata($assembly,$membno,$dcrccode);
	       
	        $psdt=new psdata($assembly,$membno,$dcrccode);
			 
		    
			 $j=0;
	 		while ($j<=$grpdc->countnumb()-1)
	 		{	if ($j<=$psdt->countnumb()-1)
		   		 {
		 			$pollstn=$psdt->getps($j);
					$polfix=$psdt->getpfx($j);
					//echo $pollstn;
					//echo $polfix;
					//exit;
				}
				else
				{	
					break;
				}
				
			//	echo $psdt->countnumb();
			//    exit;
	 			$grpd=$grpdc->getgroupid($j);
				$dcrc=$grpdc->getdc($j);
				$stmt->execute();
				$j=$j+1;
	 
	 
			 }
	 		$this->msqli->commit();			 
			 
	 }
		
}

else
{
	echo '<div class="alert-error">No Result </div>';

}

}
}
?>