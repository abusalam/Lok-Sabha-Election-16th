<?php
//include 'mysqliconn.php';

class randno {

private $result;
private $msqli;
private $sobj;
function __construct($subdiv) {

// select QUERY ON A assembly TABLE
    
	
 	$this->sobj= new mysqliconn();
    $this->msqli=$this->sobj->getconn();
	$this->result = $this->msqli->query("SELECT * FROM `personnela` where forsubdivision='$subdiv' ") or die($this->msqli->error.__LINE__);

// GOING THROUGH THE DATA

$this->msqli->autocommit(FALSE);
$sql  = "update personnela set rand_numb=? where personcd=? ";
//$sql  = "update pers set booked=?,groupid=?,forasm=?,forpc=? where personcd=? ";

//$stmt = $mysqli->prepare("insert into test(testid) values(?)");

$this->stmt = $this->msqli->prepare($sql);
 //echo "binding failed";

$this->stmt->bind_param('is',$rnd,$psd);



	if($this->result->num_rows > 0) {
		$i=0;
		$k=0;
		            
		while($row = $this->result->fetch_assoc()) {
		  $psd=$row['personcd'];
		  $rnd=rand();
		//  $rnd=rand()*1000000;
		 // echo $rnd;
		 // echo ' ';
		  $this->stmt->execute();		
		
		}
		
		
		$this->msqli->commit();

	}
	
	else {
		echo 'NO RESULTS';	
	}


		
}
}
