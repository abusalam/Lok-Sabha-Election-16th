<title>cmp</title><?PHP
include 'groupdcrc.php';
//include 'mysqliconn.php';
//required_once('assemblyparty.php');

class groupdcrcdata { 


private $grpdcrc =array();   

private $result;
 private $msqli;
private $sobj;
function __construct($assembly,$membno,$dccd) {

// select QUERY ON A assembly TABLE
	
 	$this->sobj= new mysqliconn();
        $this->msqli=$this->sobj->getconn();
		$this->result = $this->msqli->query("SELECT * from grp_dcrc where forassembly='$assembly' and member='$membno' and dcrccd='$dccd' ") or die($this->msqli->error.__LINE__);
	
			

// GOING THROUGH THE DATA
	if($this->result->num_rows > 0) {
		$i=0;
		while($row = $this->result->fetch_assoc()) {

			$gpd= $row['groupid'];
			$dc=$row['dcrccd'];
			
			$this->grpdcrc[$i]=new groupdcrc($gpd,$dc);
$i=$i+1;
		}
	}
	else {
		echo 'NO ......RESULTS';	
	}


// CLOSE CONNECTION
	mysqli_close($this->msqli);

}
public function countnumb() {

  return count($this->grpdcrc);
}
public function getgroupid($j) {
     return  $this->grpdcrc[$j]->getgrpid();
}
public function getdc($j) {
     return  $this->grpdcrc[$j]->getdcrc();
}


}
?>