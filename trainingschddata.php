<?PHP
include 'trainingschd.php';
//include 'mysqliconn.php';
//required_once('assemblyparty.php');

class trainingschddata { 


private $tschd =array();   

private $result;
 private $msqli;
private $sobj;

function __construct($typ,$sub,$chtyp) {

// select QUERY ON A assembly TABLE

 	$this->sobj= new mysqliconn();
    $this->msqli=$this->sobj->getconn();
	
	$this->result = $this->msqli->query("SELECT schedule_code as sh,training_type as tp,training_venue,post_status,no_pp,no_used,choice_type,choice_area  as cha FROM `training_schedule` where  `training_type`='$typ' and forsubdiv='$sub' and choice_type='$chtyp' and (no_pp-no_used)>0") or die($this->msqli->error.__LINE__);
//echo 'here';
//echo $typ;
//echo 'yes    bbbb    nn  ';
// GOING THROUGH THE DATA
//echo $this->result->num_rows;
//exit;
	if($this->result->num_rows > 0) {
	
		$i=0;
		$pst=' ';
	//	echo 'hi    bbbb    nn  ';
		while($row = $this->result->fetch_assoc()) {

			$schd= $row['sh'];
			$type=$row['tp'];
			$ven=$row['training_venue'];
			$pst=$row['post_status'];
			$np=$row['no_pp'];
			$nu=$row['no_used'];
			$chtp=$row['choice_type'];
			$charea=$row['cha'];
			
          
			
			
			$this->tschd[$i]=new trainingschd($schd,$type,$ven,$pst,$np,$nu,$chtp,$charea);
			$i=$i+1;
			
			
		}
	}
	else {
		//echo 'NO  ..RESULTS';	
	}


// CLOSE CONNECTION
	mysqli_close($this->msqli);

}

public function countnumb() {

  return count($this->tschd);
}
public function getschd($j) {
     
     return  $this->tschd[$j]->getschd();
}
public function gettype($j) {
     
     return  $this->tschd[$j]->gettype();
}
public function getven($j) {
     
     return  $this->tschd[$j]->getven();
}
public function getpst($j) {
     
     return  $this->tschd[$j]->getpst();
}
public function getnp($j) {
     
     return  $this->tschd[$j]->getnp();
}
public function getnu($j) {
     
     return  $this->tschd[$j]->getnu();
}
public function getchtp($j) {
     
     return  $this->tschd[$j]->getchtp();
}


public function getcharea($j) {
     return  $this->tschd[$j]->getcharea();
}
public function setnu($j,$nu) {
 $this->tschd[$j]->setnu($nu);

}





}
?>