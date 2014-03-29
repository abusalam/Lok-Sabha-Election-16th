<?php 
extract($_GET);
include 'mysqliconn.php';
include 'assemblydata.php';
include 'grpdtldata.php';
include 'postorderdata.php';
include 'ppdata.php';
include 'randno.php';
include 'reserve.php';
include 'countpp.php';

if(isset($_GET['subdiv']) && $_GET['subdiv']!=null)
{
	$subdiv=$_GET['subdiv'];
//	echo $subdiv;
}
else
{
	echo "You are not a valid subdivision user";
	exit;
}

new randno($subdiv);

$asmparty=new assemblydata($subdiv,'S');  // Subdivisionwise

$i=0;

// prepare statement

$sobj= new mysqliconn();
 $msqli=$sobj->getconn();
 //Initialise PP data
$msqli->query("update personnela set booked=' ',groupid=0,forassembly='   ',selected=0 where forsubdivision='$subdiv'");

$msqli->autocommit(FALSE);
 
$sql  = "update personnela set booked='P',selected=1,groupid=?,forassembly=? where personcd=?  ";


 $stmt = $msqli->prepare($sql); //,groupid=?,forasm=?,forpc=? where personcd=? ");
$stmt->bind_param('iss',$grpd,$asmf,$psd);


//


while ($i<=$asmparty->countnumb()-1)

//read from assemblyparty table

{

	$partyreqd=$asmparty->getpartyreqdpty($i);

	$assembly=$asmparty->getasmpty($i); //Asembly for which party is being formed

	$membno=$asmparty->getmembers($i); //Total member in a party

	$pc=$asmparty->getpcpty($i); //PC for which party is being formed
	$sub=$asmparty->getsubpty($i);

	$postdt=new postorderdata($membno);
	
	$j=0;
	$grpdata=new grpdtldata($assembly); // Subdivisionwise..change for 2nd randomisation
	
	while ($j<=($postdt->countnumb())-1) //Loop for all poststatus
	{ 

		$memslno=$postdt->getmember($j); // member number in a party
		$post=$postdt->getpoststat($j); // post status of that  member
		
		$ppall=new ppdata($pc,$post,$sub,$assembly,'S',1); // pp for subdivision  ..forpc
		
		$cond=0;
		$x=0;
		$skippp=0;
		$k=0;
		while( $x<$ppall->countnumb()) 
		{
			$cond=0;
			$ofcd=$ppall->getofcdpp($x);
			$bk=$ppall->getbookedpp($x);
			if ($k<$grpdata->countnumb())
			{
				    $asmf=$grpdata->getasmdtl($k);
					$pcf=$grpdata->getpcdtl($k);
					$gid=$grpdata->getgrpiddtl($k);
					$of1=$grpdata->getof1dtl($k);
					$of2=$grpdata->getof2dtl($k);
					$of3=$grpdata->getof3dtl($k);
					$of4=$grpdata->getof4dtl($k);
					$of5=$grpdata->getof5dtl($k); 
					$of6=$grpdata->getof6dtl($k);
					
			}
			else
			{
					break;
			
			}
			if ($memslno==1)
			{
					$grpdata->setof1dtl($k,$ofcd);
				//	echo $grpdata->getof1dtl($k);
					$cond=1;
			
			}
			if ($memslno==2)
			{	
			   // if ((strcmp($bk,' ')==0)) {
				//	  echo strcmp($bk,'');
			     //   echo $ofcd.'    n '.$bk.'b '.$of1;
					
				//	}
					if ((strcmp($ofcd,$of1)<>0) and (strcmp($of2,' ')==0) and (strcmp($bk,'')==0))
					{  // echo '  2 sele    ';
						$grpdata->setof2dtl($k,$ofcd);
						/*echo $grpdata->getof1dtl($k);
						echo ' ';
						echo $grpdata->getof2dtl($k);
						echo '  ----      ';
						*/
						$cond=1;
					 }
			
			}
			if ($memslno==3)
			{	
					if ((strcmp($ofcd,$of1)<>0) and (strcmp($ofcd,$of2)<>0) and (strcmp($of3,' ')==0) and (strcmp($bk,'')==0))
					{
						$grpdata->setof3dtl($k,$ofcd);
						$cond=1;
					 }
			
			}
			if ($memslno==4)
			{	
					if ((strcmp($ofcd,$of1)<>0) and (strcmp($ofcd,$of2)<>0) and (strcmp($ofcd,$of3)<>0) and (strcmp($of4,' ')==0) and (strcmp($bk,'')==0))
					{  
					if ($k==0)
					{
				//	echo $k;
				//	echo ' ';
					}
					
						$grpdata->setof4dtl($k,$ofcd);
						$cond=1;
					 }
			
			}
			if ($memslno==5)
			{	
					if ((strcmp($ofcd,$of1)<>0) and (strcmp($ofcd,$of2)<>0) and (strcmp($ofcd,$of3)<>0) and (strcmp($ofcd,$of4)<>0) and (strcmp($of5,' ')==0) and (strcmp($bk,' ')==0))
					{
						$grpdata->setof5dtl($k,$ofcd);
						$cond=1;
					 }
			
			}
			if ($memslno==6)
			{	
					if ((strcmp($ofcd,$of1)<>0) and (strcmp($ofcd,$of2)<>0) and (strcmp($ofcd,$of3)<>0) and (strcmp($ofcd,$of4)<>0) and (strcmp($ofcd,$of5)<>0) and (strcmp($of6,' ')==0) and (strcmp($bk,' ')==0))
					{
						$grpdata->setof6dtl($k,$ofcd);
						$cond=1;
					 }
			}
			if ($memslno<1 or $memslno>6)
			{
				break;
			}
			if ($cond==1)
			 {
							
				$ppall->setbookedpp($x,'P');
				$ppall->setgrpidpp($x,$gid);
				$ppall->setforasm($x,$asmf);
			//	$ppall->setforpc($x,$pcf);
				$psd=$ppall->getperscdpp($x);
				$grpd=$ppall->getgrpidpp($x);
				$asmf=$ppall->getasmpp($x);
			//	$pcf=$ppall->getpcpp($x);
				$k=$k+1;

				$stmt->execute();
			}
			else
			{
				$skippp=$skippp+1;
						
			}
			
			
			if ($x< $ppall->countnumb()-1)
			{
				$x=$x+1;
			}
			else
			{
				if ($skippp< ($grpdata->countnumb()-$k  ))
				{
					$x=0;
								
				}
				else
				{
					echo ' Check Data ....Group is not be formed properly  ...';
					break;
				
				}
			}
			
			
			
		}
		$j=$j+1;
	}
	$msqli->commit();
	$i=$i+1;
}
$stmt->close();
$msqli->close();

    new reserve($subdiv,1);


	new countpp($subdiv);
//	new randno();

?>