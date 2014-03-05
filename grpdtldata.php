<?PHP
include 'groupdtl.php';
//include 'mysqliconn.php';
//required_once('assemblyparty.php');

class grpdtldata { 


private $grpdtl =array();   

private $result;
 private $msqli;
private $sobj;
function __construct($asm) {

// select QUERY ON A assembly TABLE
	
 	$this->sobj= new mysqliconn();
        $this->msqli=$this->sobj->getconn();
	$this->result = $this->msqli->query("SELECT * FROM assembly_party where assemblycd='$asm' ") or die($this->msqli->error.__LINE__);

// GOING THROUGH THE DATA
	if($this->result->num_rows > 0) {
		$i=0;
		while($row = $this->result->fetch_assoc()) {

			$asm= $row['assemblycd'];
			$pc=$row['pccd'];
			$members=$row['no_of_member'];
			$partyreqd=$row['no_party'];
			for($j=0;$j<=$partyreqd-1;$j++)
			{
			  $this->grpdtl[$i]=new groupdtl($asm,$pc,$j+1,' ',' ',' ',' ',' ',' ',' ');

			$i=$i+1;
			}


			
		}
	}
	else {
		echo ' Problem in assembly table entry ';	
	}


// CLOSE CONNECTION
	mysqli_close($this->msqli);

}
public function countnumb() {

  return count($this->grpdtl);
}

public function getasmdtl($j) {
     return  $this->grpdtl[$j]->getforasm();
}

public function getpcdtl($j) {
     return  $this->grpdtl[$j]->getforpc();
}
public function getgrpiddtl($j) {
     return  $this->grpdtl[$j]->getgroupid();
}
public function getof1dtl($j) {
     return  $this->grpdtl[$j]->getoffice1();
}
public function getof2dtl($j) {
     return  $this->grpdtl[$j]->getoffice2();
}
public function getof3dtl($j) {
     return  $this->grpdtl[$j]->getoffice3();
}
public function getof4dtl($j) {
     return  $this->grpdtl[$j]->getoffice4();
}
public function getof5dtl($j) {
     return  $this->grpdtl[$j]->getoffice5();
}
public function getof6dtl($j) {
     return  $this->grpdtl[$j]->getoffice6();
}
public function setof1dtl($j,$off) {
      $this->grpdtl[$j]->setoffice1($off);
}
public function setof2dtl($j,$off) {
      $this->grpdtl[$j]->setoffice2($off);
}
public function setof3dtl($j,$off) {
      $this->grpdtl[$j]->setoffice3($off);
}
public function setof4dtl($j,$off) {
      $this->grpdtl[$j]->setoffice4($off);
}
public function setof5dtl($j,$off) {
      $this->grpdtl[$j]->setoffice5($off);
}
public function setof6dtl($j,$off) {
      $this->grpdtl[$j]->setoffice6($off);
}
}
?>