<?PHP
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
		$this->result = $this->msqli->query("SELECT psno,psfix from pollingstation where forassembly='$assembly' and member='$membno' and dcrccd='$dccd' order by rand_numb ") or die($this->msqli->error.__LINE__);
	
			

// GOING THROUGH THE DATA
	if($this->result->num_rows > 0) {
		
		//update Assembly Party
		$this->msqli->query("Update assembly_party set rand_status='Y' where assemblycd='$assembly' and no_of_member ='$membno'") or die($this->msqli->error.__LINE__);
		
		$i=0;
		while($row = $this->result->fetch_assoc()) {

			$psnumb= $row['psno'];
			$psfx= $row['psfix'];
			//echo $psnumb;
			//
			//echo $psfx;
			$this->psarr[$i]=new ps($psnumb,$psfx);
$i=$i+1;
		}
	}
	else {
		echo '<div class="alert-error">NO ..---RESULTS for ..'.$assembly.' in PS</div>';
		echo ' ';
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
public function getpfx($j) {
     return  $this->psarr[$j]->getpsfix();
}

}
?>