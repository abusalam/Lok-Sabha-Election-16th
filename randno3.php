<?php
//include 'mysqliconn.php';

class randno3 {

private $result;
private $msqli;
private $sobj;
function __construct($dist,$sub) {

// select QUERY ON A assembly TABLE
    
	
 	$this->sobj= new mysqliconn();
    $this->msqli=$this->sobj->getconn();
	$this->result = $this->msqli->query("update `pollingstation`  set rand_numb=RAND()*10000 where substr(forsubdivision,1,2)='$dist' and forsubdivision='$sub'") or die($this->msqli->error.__LINE__);

// GOING THROUGH THE DATA

/*$this->msqli->autocommit(FALSE);

$sql  = "update `pollingstation`  set rand_numb=? where forassembly=? and psno=?";
//$sql  = "update pers set booked=?,groupid=?,forasm=?,forpc=? where personcd=? ";

//$stmt = $mysqli->prepare("insert into test(testid) values(?)");

$this->stmt = $this->msqli->prepare($sql);
 //echo "binding failed";

$this->stmt->bind_param('isi',$rnd,$fasm,$ps);



	if($this->result->num_rows > 0) {
		$i=0;
		$k=0;
		            
		while($row = $this->result->fetch_assoc()) {
		  $ps=$row['psno'];     
          $fasm=$row['forassembly'];
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
	}*/


  }
}
