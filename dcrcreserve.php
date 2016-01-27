<?php
//include 'mysqliconn.php';
//include 'ppdata.php';
class dcrcreserve {

private $result;
private $msqli; 
private $sobj;
function __construct($dist,$sub) {

// select QUERY ON A assembly TABLE
    
	
 	$this->sobj= new mysqliconn();
    $this->msqli=$this->sobj->getconn();
	$this->result = $this->msqli->query("update personnela set dcrccd=NULL where forsubdivision='$sub' ") or die($this->msqli->error.__LINE__);

	//SELECT a.assemblycd,a.partyindcrc,a.number_of_member,a.dcrcgrp,b.poststat,b.no_or_pc,b.numb FROM `dcrc_party`a , reserve b WHERE a.assemblycd=b.forassembly and a.subdivisioncd=b.forsubdivision and a.number_of_member=b.number_of_member and a.forpc=b.forp and a.forsubdivision='$sub' and a.forpc='$pc'
	
	$this->result = $this->msqli->query("SELECT a.assemblycd as asmcd ,a.partyindcrc as partyno ,a.number_of_member as member ,a.dcrcgrp as dcgrp ,b.poststat as post,b.no_or_pc as noorpc,b.numb as numberresv,a.subdivisioncd as subdiv,a.forpc as pccd FROM `dcrc_party` a , reserve b WHERE a.assemblycd=b.forassembly and a.subdivisioncd=b.forsubdivision and a.number_of_member=b.number_of_member and  substr(a.subdivisioncd,1,2)='$dist' and a.subdivisioncd='$sub' ") or die($this->msqli->error.__LINE__);

//	$this->msqli->query("INSERT INTO grp_dcrc( forsubdivision,forassembly, forpc, groupid,member,dcrccd )   SELECT forsubdivision, forassembly, forpc, groupid ,count(*), '      ' FROM pers WHERE booked = 'P' GROUP BY forassembly, groupid "  );



//SELECT forassembly, groupid FROM pers WHERE booked =  'P' GROUP BY forassembly, groupid
// GOING THROUGH THE DATA

//INSERT INTO grp_dcrc( forsubdivision,forassembly, forpc, groupid )  SELECT forsubdivision, forassembly, forpc, groupid FROM pers WHERE booked = 'P' GROUP BY forassembly, groupid

$this->msqli->autocommit(FALSE);
$sql  = "update personnela set dcrccd=? where forassembly=? and groupid=? and poststat=?  and booked='R'";
//$sql  = "update pers set dcrc=? where personcd=? ";

//$sql  = "update pers set booked=?,groupid=?,forasm=?,forpc=? where personcd=? ";

//$stmt = $mysqli->prepare("insert into test(testid) values(?)");

$this->stmt = $this->msqli->prepare($sql);
 //echo "binding failed";
$this->stmt->bind_param('ssis',$dc,$fasm,$gpd,$post);

//$sql1="insert into dcrc_grp values( ?,?,?,?,?);  //forsubdivision,forassembly,forpc,groupid,dcrccd
//$this->stmt= $this->msqli->prepare($sql1);
//$this->stmt1->bind_param('sssis',$sub,$fasm,$fpc,$gpd,$dc);

 	

	if($this->result->num_rows > 0) {
		$i=0;
		$k=0;
		 // echo $this->result->num_rows ;   
		while($row = $this->result->fetch_assoc()) {
		  $fasm=$row['asmcd'];
		  $mem=$row['member'];
		  $pdcrc=$row['partyno'];
		  $sub=$row['subdiv'];
		  $fpc=$row['pccd'];
		  $dc=$row['dcgrp'];
		  $np=$row['noorpc'];
		  $numb=$row['numberresv'];
		  $post=$row['post'];
		  if (strcmp($np,'N')==0) 
		  {
		    $nors=$numb;
			$nors=$nors+10;
			}
		   else
		   {
		     $nors=round((($pdcrc*$numb/100)+1),0);
			 $nors=$nors+10;
		   }
		  
		//  echo $nors;
		
		  
		  $this->result1 = $this->msqli->query("select * from personnela where substr(forsubdivision,1,2)='$dist' and forsubdivision='$sub' and forassembly='$fasm' and booked='R' and poststat='$post' and (dcrccd='      ' or dcrccd is null) limit 0, $nors  ") or die($this->msqli->error.__LINE__);
/*echo '  ';
echo $this->result1->num_rows ;
echo ' ';
echo $fasm;
  echo '  ';
  echo $post;
  echo '   e    ';
  */
		  $k=0;
		  //
		  while($row1 = $this->result1->fetch_assoc() ) 
		  {		//echo $fpc."-".$fasm."-".$dc."<br/>\n";
	//	  echo  $this->result1->num_rows;
		     //  $dc=$row1['dcrccd'];
			   $gpd=$row1['groupid'];
			//   $memno=$row1['member'];
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