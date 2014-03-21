<?php
//include 'mysqliconn.php';
//include 'ppdata.php';
class dcrc {

private $result;
private $msqli; 
private $sobj;
function __construct($dist,$pc) {

// select QUERY ON A assembly TABreLE
    echo $dist.' nnn '.$pc;
	
 	$this->sobj= new mysqliconn();
    $this->msqli=$this->sobj->getconn();
	$this->msqli->query("delete from grp_dcrc where substr(forsubdivision,1,2)='$dist' and forpc='$pc'");
	
	$this->result = $this->msqli->query("select * from dcrc_party where substr(subdivisioncd,1,2)='$dist' and forpc='$pc' ") or die($this->msqli->error.__LINE__);
	
	$this->msqli->query("INSERT INTO grp_dcrc( forsubdivision,forassembly, forpc, groupid,member,dcrccd )   SELECT forsubdivision, forassembly, forpc, groupid ,count(*), '      ' FROM personnela WHERE booked = 'P' and substr(forsubdivision,1,2)='$dist' and forpc='$pc'  GROUP BY forassembly, groupid "  );



//SELECT forassembly, groupid FROM pers WHERE booked =  'P' GROUP BY forassembly, groupid
// GOING THROUGH THE DATA

//INSERT INTO grp_dcrc( forsubdivision,forassembly, forpc, groupid )  SELECT forsubdivision, forassembly, forpc, groupid FROM pers WHERE booked = 'P' GROUP BY forassembly, groupid

$this->msqli->autocommit(FALSE);
$sql  = "update grp_dcrc set dcrccd=? where forassembly=? and groupid=? and member=?";
//$sql  = "update pers set dcrc=? where personcd=? ";

//$sql  = "update pers set booked=?,groupid=?,forasm=?,forpc=? where personcd=? ";

//$stmt = $mysqli->prepare("insert into test(testid) values(?)");

$this->stmt = $this->msqli->prepare($sql);
 //echo "binding failed";
$this->stmt->bind_param('ssii',$dc,$fasm,$gpd,$mem);

//$sql1="insert into dcrc_grp values( ?,?,?,?,?);  //forsubdivision,forassembly,forpc,groupid,dcrccd
//$this->stmt= $this->msqli->prepare($sql1);
//$this->stmt1->bind_param('sssis',$sub,$fasm,$fpc,$gpd,$dc);

 

	if($this->result->num_rows > 0) {
		$i=0;
		$k=0;
		            
		while($row = $this->result->fetch_assoc()) {
		  $fasm=$row['assemblycd'];
		  $mem=$row['number_of_member'];
		  $pdcrc=$row['partyindcrc'];
		  $sub=$row['subdivisioncd'];
		  $fpc=$row['forpc'];
		  $dc=$row['dcrcgrp'];
		  
		  $this->result1 = $this->msqli->query("select * from grp_dcrc where substr(forsubdivision,1,2)='$dist' and forpc='$pc' and forassembly='$fasm' and member='$mem' and trim(dcrccd)=''  limit 0, $pdcrc  ") or die($this->msqli->error.__LINE__);
		  
//echo $this->result1->num_rows ;
	//	  echo ' ccc ';
		  $k=0;
		  //
		  while($row1 = $this->result1->fetch_assoc() ) 
		  {		
		     //  $dc=$row1['dcrccd'];
			   $gpd=$row1['groupid'];
			   $memno=$row1['member'];
		//	   echo $dc;
		//	   echo ' b ';
			   
			   $this->stmt->execute();
		  }
		  
		  $this->msqli->commit();
		  		
		}
	
	}
	
	else {
		echo 'NO RESULTS';	
	}


		
}
}
?>