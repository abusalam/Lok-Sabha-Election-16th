<?PHP
//include 'pp.php';
//include 'mysqliconn.php';
//include 'postcount.php';
//required_once('assemblyparty.php');
//($perscd,$forasm,$forpc,$groupid,$officecd,$poststat,$booked,$asmt,$asmh,$asmo)

class ppdatar { 


private $ppdtl =array(); 
private $pppost =array();  

private $result;
private $msqli;
private $sobj;
function __construct($sub,$pst,$var,$asm,$stat,$phase) {

// select QUERY ON A assembly TABLE
	
 	$this->sobj= new mysqliconn();
    $this->msqli=$this->sobj->getconn();
//	$this->result = $this->msqli->query("SELECT * FROM `personnela` where poststat= '$pst' and substr(forsubdivision,1,2)='$var' and assembly_off<> '$asm' and assembly_temp<> '$asm' and assembly_perm<> '$asm' and booked=' ' and selected=1 and forpc='$fpc' order by rand_numb ") or die($this->msqli->error.__LINE__);
//echo ' $phase '. $phase .' ';
	if (strcmp($stat,'S')==0)
	{ 
	  
       if ($phase==1) {
	   $this->result = $this->msqli->query("SELECT forpc,personcd,officecd,poststat,booked,assembly_perm,assembly_temp,assembly_off,groupid,forassembly FROM `personnela` where poststat= '$pst' and substr(forsubdivision,1,2)='$var' and assembly_off<> '$asm' and assembly_temp<> '$asm' and assembly_perm<> '$asm' and forassembly<> '$asm' and booked='R' and selected=1 and forsubdivision='$sub' order by rand_numb ") or die($this->msqli->error.__LINE__);
		}
	   else
		{
			$sql="SELECT forpc,personcd,officecd,poststat,booked,assembly_perm,assembly_temp,assembly_off,groupid,forassembly FROM `personnela` where poststat= '$pst' and substr(forsubdivision,1,2)='$var' and assembly_off<> '$asm' and assembly_temp<> '$asm' and assembly_perm<> '$asm' and booked=' ' and selected=1 and forsubdivision='$sub' order by rand_numb Limit 1";
		$this->result = $this->msqli->query($sql) or die($this->msqli->error.__LINE__);
		echo $sql;
		
		}
	}
	
		
//echo $this->result->num_rows ;
// GOING THROUGH THE DATA
	if($this->result->num_rows > 0) {
		$i=0;
		$k=0;
		            
		while($row = $this->result->fetch_assoc()) {
			
			$forasm=$row['forassembly'];
			$forpc=$row['forpc'];
			$perscd=$row['personcd'];
			$groupid=$row['groupid'];
			$officecd=$row['officecd'];
			$poststat=$row['poststat'];
			$booked=$row['booked'];
			$asmh=$row['assembly_perm'];
			$asmt=$row['assembly_temp'];
			$asmo=$row['assembly_off'];
			
			
			$this->ppdtl[$i]=new pp ($perscd,$forasm,$forpc,$groupid,$officecd,$poststat,$booked,$asmt,$asmh,$asmo); 


			$i=$i+1;

			
		}

	}

	else {
	//    echo $fpc. ' vf '.$var . ' '.$asm;
	//	echo 'No data for' .$pst ;	
	}


// CLOSE CONNECTION
	mysqli_close($this->msqli);

}

public function countnumb() {

  return count($this->ppdtl);
}


public function getasmpp($j) {
     return  $this->ppdtl[$j]->getforasm();
}

public function getpcpp($j) {
     return  $this->ppdtl[$j]->getforpc();
}
public function getgrpidpp($j) {
     return  $this->ppdtl[$j]->getgroupid();
}
public function getofcdpp($j) {
     return  $this->ppdtl[$j]->getofficecd();
}
public function getpostpp($j) {
     return  $this->ppdtl[$j]->getpoststat();
}
public function getasmhpp($j) {
     return  $this->ppdtl[$j]->getasmh();
}
public function getasmtpp($j) {
     return  $this->ppdtl[$j]->getasmt();
}
public function getasmopp($j) {
     return  $this->ppdtl[$j]->getasmo();
}
public function getbookedpp($j) {
     return  $this->ppdtl[$j]->getbooked();
}
public function getperscdpp($j) {
       return $this->ppdtl[$j]->getperscd();
}
public function setbookedpp($j,$booked) {
      $this->ppdtl[$j]->setbooked($booked);
}
public function setofcdpp($j,$ofc) {
      $this->ppdtl[$j]->setbooked($ofc);
}
public function setgrpidpp($j,$grp) {
 $this->ppdtl[$j]->setgroupid($grp);

}
public function setforasm($j,$asm) {
 $this->ppdtl[$j]->setfasm($asm);

}
public function setforpc($j,$pc) {
 $this->ppdtl[$j]->setpc($pc);

}
public function setselected($j,$sel) {
 $this->ppdtl[$j]->setsel($sel);

}
}

?>