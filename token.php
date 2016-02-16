<?php
//include 'mysqliconn.php';

class token {

private $result;
private $msqli;
private $sobj;
function __construct($subdiv,$trgtype) {

// select QUERY ON A assembly TABLE
    $tkn=0;
	
 	$this->sobj= new mysqliconn();
    $this->msqli=$this->sobj->getconn();
	
// GOING THROUGH THE DATA
$this->result1 = $this->msqli->query("SELECT distinct poststat FROM `poststatorder`  ") or die($this->msqli->error.__LINE__);


$this->msqli->autocommit(FALSE);
$sql  = "update training_pp set token=? where per_code=? ";
//$sql  = "update pers set booked=?,groupid=?,forasm=?,forpc=? where personcd=? ";

//$stmt = $mysqli->prepare("insert into test(testid) values(?)");

$this->stmt = $this->msqli->prepare($sql);
 //echo "binding failed";

$this->stmt->bind_param('is',$tkn,$psd);



	if($this->result1->num_rows > 0) {
		$i=0;
		$k=0;
		 while ($row1=$this->result1->fetch_assoc()) {
		    $pst=$row1['poststat'];
			$tkn=0;
			$this->result = $this->msqli->query("SELECT per_code FROM `training_pp` where for_subdivision='$subdiv' and training_type='$trgtype' order by post_stat,training_sch") or die($this->msqli->error.__LINE__);
     if($this->result->num_rows > 0) {
			       
		while($row = $this->result->fetch_assoc()) {
		  $psd=$row['per_code'];
		  $tkn=$tkn+1;
		//  $rnd=rand()*1000000;
		 // echo $rnd;
		 // echo ' ';
		  $this->stmt->execute();		
		
		}
		
		
		$this->msqli->commit();
		
		}
		else
		{
		//2nd if
		}
	}
	}
	
	else {
		//echo '1st if PP in table for this subdivision';	
	}


		
}
}
?>
