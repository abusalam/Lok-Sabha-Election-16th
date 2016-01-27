<?PHP

class updateused { 


  

private $result;
 private $msqli;
private $sobj;

function __construct ($schd,$used) {

// select QUERY ON A assembly TABLE
	
	
 	$this->sobj= new mysqliconn();
        $this->msqli=$this->sobj->getconn();
		$this->msqli->query("update training_schedule set no_used=$used+no_used where schedule_code='$schd'");

    

// CLOSE CONNECTION
	mysqli_close($this->msqli);

}

}
?>