<title>cmp</title><?PHP
include 'ps.php';
//include 'mysqliconn.php';
//required_once('assemblyparty.php');

class psdata { 


private $psarr =array();   

private $result;
 private $msqli;
private $sobj;
function __construct($assembly,$membno,$dccd) {

// select QUERY ON A assembly TABLE
	
 	$this->sobj= new mysqliconn();
        $this->msqli=$this->sobj->getconn();
		$this->result = $this->msqli->query("SELECT * from pollingstation where forassembly='$assembly' and member='$membno' and dcrccd='$dccd' ") or die($this->msqli->error.__LINE__);
	
			

// GOING THROUGH THE DATA
	if($this->result->num_rows > 0) {
		$i=0;
		while($row = $this->result->fetch_assoc()) {

			$psnumb= $row['psno'];
			
			$this->psarr[$i]=new ps($psnumb);
$i=$i+1;
		}
	}
	else {
		echo 'NO ..---RESULTS for ..'.$assembly;	
	}


// CLOSE CONNECTION
	mysqli_close($this->msqli);

}
public function countnumb() {

  return count($this->psarr);
}
public function getps($j) {
     return  $this->psarr[$j]->getpsno();
}


}
?>