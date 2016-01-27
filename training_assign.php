<?php
include 'mysqliconn.php';
include 'trainingschddata.php';
include 'updateused.php';
class training_assign {
private $sobj;
private $msqli;

function __construct ($tp,$sub,$chop) 
{
$this->sobj= new mysqliconn();
 $this->msqli=$this->sobj->getconn();

 
 $this->msqli->autocommit(FALSE);
$sql  = "update training_pp set training_sch=?,training_booked='Y',training_attended='Y',training_showcause='N' where  training_type= $tp and per_code=? ";


 $stmt = $this->msqli->prepare($sql); //,groupid=?,forasm=?,forpc=? where personcd=? ");

$stmt->bind_param('ss',$schd,$pcd);
//


$trsc=new trainingschddata($tp,$sub,$chop);
    $j=0;
	
	//echo $trsc->countnumb();
	while ($j<=($trsc->countnumb())-1) //Loop for all poststatus
	{ 

		$schd=$trsc->getschd($j); // member number in a party
		$var=$trsc->getcharea($j); // post status of that  member
		$pst1=$trsc->getpst($j);
	   
	    $k=$trsc->getnp($j)-$trsc->getnu($j);
		$pcd=0;
		
		
		// training_pp recordwise update
		if ($chop=='S')
		{
		$this->result = $this->msqli->query("SELECT per_code FROM `training_pp` where subdivision='$var' and for_subdivision='$sub' and post_stat='$pst1' and training_type= '$tp' and (training_sch='  ' or training_sch is null) ") or die($this->msqli->error.__LINE__);
		}
		if ($chop=='D')
		{
		$this->result = $this->msqli->query("SELECT per_code FROM `training_pp` where for_subdivision='$sub' and post_stat='$pst1' and training_type= '$tp' and (training_sch='  ' or training_sch is null) ") or die($this->msqli->error.__LINE__);
		}
		if ($chop=='T')
		{
		$this->result = $this->msqli->query("SELECT per_code FROM `training_pp` where assembly_temp='$var' and subdivision='$sub' and post_stat='$pst1' and training_type= '$tp' and (training_sch='  ' or training_sch is null) ") or die($this->msqli->error.__LINE__);
		}
		if ($chop=='O')
		{
		$this->result = $this->msqli->query("SELECT per_code FROM `training_pp` where assembly_off='$var' and subdivision='$sub' and post_stat='$pst1' and training_type= '$tp' and (training_sch='  ' or training_sch is null) ") or die($this->msqli->error.__LINE__);
		}
		if ($chop=='P')
		{
		$this->result = $this->msqli->query("SELECT per_code FROM `training_pp` where assembly_perm='$var' and subdivision='$sub' and post_stat='$pst1' and training_type= '$tp' and (training_sch='  ' or training_sch is null) ") or die($this->msqli->error.__LINE__);
		}
		if($this->result->num_rows > 0) {
		
	
		while($row = $this->result->fetch_assoc() and $k>0) 
		
		{
		
		  $pcd=$row['per_code'];
		
		  $k=$k-1;
		 
		  $stmt->execute();
		}
		
		  
		}
			$this->msqli->commit();
			$j=$j+1;
		
		
		
		//training_pp end
		
		$result = $this->msqli->query("SELECT count(*) as totsch FROM `training_pp` where training_sch='$schd' ") or die($tmsqli->error.__LINE__);
		if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		  $tsc=$row['totsch'];
		  new updateused($schd,$tsc);
		 }
		}
		   
		}
			
		$stmt->close();
		
	
	    
		
		
		
		
		$this->msqli->close();
		
	}
	
	
			
		

	



}


?>
