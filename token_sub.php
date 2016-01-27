<?php
//include 'mysqliconn.php';

class token_sub {

private $result;
private $msqli;
private $sobj;
function __construct($dist,$trgtype) {

// select QUERY ON A assembly TABLE
    $tkn=0;
	
 	$this->sobj= new mysqliconn();
    $this->msqli=$this->sobj->getconn();
	//$dist='18';
// GOING THROUGH THE DATA


$this->result2 = $this->msqli->query("SELECT subdivisioncd FROM `subdivision` where districtcd='$dist' ") or die($this->msqli->error.__LINE__);

$this->msqli->autocommit(FALSE);
$sql  = "update training_pp set token=? where per_code=? ";
//$sql  = "update pers set booked=?,groupid=?,forasm=?,forpc=? where personcd=? ";

//$stmt = $mysqli->prepare("insert into test(testid) values(?)");

$this->stmt = $this->msqli->prepare($sql);
 //echo "binding failed";

$this->stmt->bind_param('is',$tkn,$psd);



	if($this->result2->num_rows > 0) {
		$i=0;
		$k=0;
		 while ($row1=$this->result2->fetch_assoc()) {
		    $sub=$row1['subdivisioncd'];
			
			$this->result1 = $this->msqli->query("SELECT distinct poststat FROM `poststatorder`  ") or die($this->msqli->error.__LINE__);
			
			
			if($this->result1->num_rows > 0) {
		$i=0;
		$k=0;
		 while ($row2=$this->result1->fetch_assoc()) {
		    $pst=$row2['poststat'];
			
			$tkn=0;
			//echo $trgtype;
			
			$this->result = $this->msqli->query("SELECT * FROM `training_pp` where subdivision='$sub' and training_type='$trgtype' and post_stat='$pst' order by training_sch") or die($this->msqli->error.__LINE__);
     if($this->result->num_rows > 0) {
	// echo 'vvvvv ';
			       
		while($row = $this->result->fetch_assoc()) {
		  $psd=$row['per_code'];
		  $tkn=$tkn+1;
		//  $rnd=rand()*1000000;
		 // echo $rnd;
		  
		  $this->stmt->execute();		
		
		}
		
		
		$this->msqli->commit();
				
		}
		else
		{
		//3rd if
		}
	//	echo $sub;
	}
	
	}
	
	else {
		//echo '2nd if PP in table for this subdivision';	
	}
	$this->result1->close();
 }
 
 echo "Successfully Token Created";
 }
 else
 {
 
 } // 3rd if

		
}
}
?>
