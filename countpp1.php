<?php
//include 'mysqliconn.php';

class countpp {

private $result;
private $msqli;
private $sobj;
function __construct($fpc) {

// select QUERY ON A assembly TABLE
    
	
 	$this->sobj= new mysqliconn();
    $this->msqli=$this->sobj->getconn();
	$this->result = $this->msqli->query("SELECT no_of_member,no_party   FROM `assembly_party` where pccd='$fpc' ") or die($this->msqli->error.__LINE__);

// GOING THROUGH THE DATA
  $totreq=0;
	if($this->result->num_rows > 0) {
		while($row = $this->result->fetch_assoc()) {

			 $totreq=$totreq+$row['no_of_member']*$row['no_party'];
				
		}
	}
	
	else {
		print 'Assembly requirement not filled  ';
	}

$this->result = $this->msqli->query("SELECT *   FROM `personnela` where forpc='$fpc' and (booked='P' or booked='R' ) ") or die($this->msqli->error.__LINE__);

// GOING THROUGH THE DATA
$prp=0;
$p1p=0;
$p2p=0;
$p3p=0;
$p4p=0;
$p5p=0;

$prr=0;
$p1r=0;
$p2r=0;
$p3r=0;
$p4r=0;
$p5r=0;



	if($this->result->num_rows > 0) {
		while($row = $this->result->fetch_assoc()) {

			 $pst=$row['poststat']	;
			 $bk=$row['booked']	;
			 if ((strcmp($pst,'PR')==0) and (strcmp($bk,'P')==0) ){
			 
			 	$prp=$prp+1;
			 }
			 if ((strcmp($pst,'PR')==0) and (strcmp($bk,'R')==0) ){
			 
			 	$prr=$prr+1;
			 }
			  if ((strcmp($pst,'P1')==0) and (strcmp($bk,'P')==0) ){
			 
			 	$p1p=$p1p+1;
			 }
			 if ((strcmp($pst,'P1')==0) and (strcmp($bk,'R')==0) ){
			 
			 	$p1r=$p1r+1;
			 }
			  if ((strcmp($pst,'P2')==0) and (strcmp($bk,'P')==0) ){
			 
			 	$p2p=$p2p+1;
			 }
			 if ((strcmp($pst,'P2')==0) and (strcmp($bk,'R')==0) ){
			 
			 	$p2r=$p2r+1;
			 }
			  if ((strcmp($pst,'P3')==0) and (strcmp($bk,'P')==0) ){
			 
			 	$p3p=$p3p+1;
			 }
			 if ((strcmp($pst,'P3')==0) and (strcmp($bk,'R')==0) ){
			 
			 	$p3r=$p3r+1;
			 }
			 if ((strcmp($pst,'PA')==0) and (strcmp($bk,'P')==0) ){
			 
			 	$p4p=$p4p+1;
			 }
			 if ((strcmp($pst,'PA')==0) and (strcmp($bk,'R')==0) ){
			 
			 	$p4r=$p4r+1;
			 }
			 if ((strcmp($pst,'PB')==0) and (strcmp($bk,'P')==0) ){
			 
			 	$p5p=$p5p+1;
			 }
			 if ((strcmp($pst,'PB')==0) and (strcmp($bk,'R')==0) ){
			 
			 	$p5r=$p5r+1;
			 }
		}
	}
	
	else {
		print 'Predsiding Officer  : '. ' NA';
	}
	echo ' <br />';
		
       if (($totreq-($prp+$p1p+$p2p+$p3p+$p4p+$p5p))>0) {
	      		
		   print 'Total PP requirement : ' .$totreq;
		   print '.....Requirement not fulfilled ';
		   echo ' <br>';
		   echo ' <br>';
		}
		else
		{
			print 'Total PP requirement (excluding Reserve) : ' .$totreq;
			echo ' <br>';
		echo ' <br>';
		}
		print 'Booked Status :-> ';
		echo ' <br>';
		
		print 'PR in Party :-- '.$prp.' + '.$prr .' ::   ';
		print 'P1 in Party :-- '.$p1p.' + '.$p1r .' ::   ';
		print '<br />';
		print 'P2 in Party :-- '.$p2p.' + '.$p2r .' ::   '; 
		print 'P3 in Party :-- '.$p3p.' + '.$p3r .' ::   ';
		echo ' <br>';
		print 'P4 in Party :-- '.$p4p.' + '.$p4r .' ::   '; 
		//echo ' <br>';
		//print 'P5 in Party :-- '.$p5p.' + '.$p5r .' ::   ';
		/*print 'PR in reserve :-- '.$prr.'  ::   ';
		print 'P1 in reserve :-- '.$p1r.'  ::  ';
		print 'P2 in reserve :-- '.$p2r.'  ::  ';
		print 'P3 in reserve :-- '.$p3r.' ';
		*/
}
}
?>