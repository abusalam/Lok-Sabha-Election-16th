<!--<title>cmp</title>--><?PHP
include 'assemblyparty.php';
//include 'mysqliconn.php';
//required_once('assemblyparty.php');

class assemblydata1 { 


private $asmparty =array();   

private $result;
 private $msqli;
private $sobj;
function __construct($dist,$sub) {

// select QUERY ON A assembly TABLE
	
 	$this->sobj= new mysqliconn();
        $this->msqli=$this->sobj->getconn();
	//	if (strcmp($stat,'S'==0)) {
	        $this->result = $this->msqli->query("SELECT assemblycd,pccd,no_of_member,no_party,subdivisioncd FROM `assembly_party` where substr(subdivisioncd,1,2)='$dist' and subdivisioncd='$sub' order by RandOrder") or die($this->msqli->error.__LINE__);
	//		}

// GOING THROUGH THE DATA
	if($this->result->num_rows > 0) {
		$i=0;
		while($row = $this->result->fetch_assoc()) {

			$asm= $row['assemblycd'];
			$pc=$row['pccd'];
			$members=$row['no_of_member'];
			$partyreqd=$row['no_party'];
			$subdiv=$row['subdivisioncd'];

			$this->asmparty[$i]=new assemblyparty($asm,$pc,$members,$partyreqd,$subdiv);
$i=$i+1;
		}
	}
	else {
		echo 'NO ..Assembly RESULTS';	
	}


// CLOSE CONNECTION
	mysqli_close($this->msqli);

}
public function countnumb() {

  return count($this->asmparty);
}
public function getasmpty($j) {
     return  $this->asmparty[$j]->getassembly();
}

public function getpcpty($j) {
     return  $this->asmparty[$j]->getpc();
}
public function getmemberspty($j) {
     return  $this->asmparty[$j]->getmembers();
}
public function getpartyreqdpty($j) {
     return  $this->asmparty[$j]->getpartyreqd();
}
public function getmembers($j) {
     return  $this->asmparty[$j]->getmember();
}
public function getsubpty($j) {
     return  $this->asmparty[$j]->getsub();
}



}
?>