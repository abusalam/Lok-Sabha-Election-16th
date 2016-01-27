<?PHP
include 'postorder.php';
//include 'mysqliconn.php';
//required_once('assemblyparty.php');

class postorderdata { 


private $postorderd =array();   

private $result;
 private $msqli;
private $sobj;

function __construct($numb) {

// select QUERY ON A assembly TABLE
	
 	$this->sobj= new mysqliconn();
        $this->msqli=$this->sobj->getconn();
	$this->result = $this->msqli->query("SELECT * FROM `poststatorder` where  `memberparty`=$numb   order by membno,poststat") or die($this->msqli->error.__LINE__);

// GOING THROUGH THE DATA
	if($this->result->num_rows > 0) {
		$i=0;
		while($row = $this->result->fetch_assoc()) {

			$memb= $row['membno'];
			$post=$row['poststat'];
			

			$this->postorderd[$i]=new postorder($memb,$post);
			$i=$i+1;
		}
	}
	else {
		echo 'NO  .RESULTS';	
	}


// CLOSE CONNECTION
	mysqli_close($this->msqli);

}

public function countnumb() {

  return count($this->postorderd);
}
public function getmember($j) {
     
     return  $this->postorderd[$j]->getmember();
}

public function getpoststat($j) {
     return  $this->postorderd[$j]->getpoststat();
}






}
?>