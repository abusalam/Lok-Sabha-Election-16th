<?php
if(isset($_GET['subdiv_cd']) && $_GET['subdiv_cd']!=null)
{
	$sub=$_GET['subdiv_cd'];
	//echo $fpc;
}
else
{
	echo "You are not a valid PC user";
	exit;
}
if(isset($_GET['dist']) && $_GET['dist']!=null)
{
	$dist=$_GET['dist'];
	//echo $dist;
}
else
{
	echo "You are not a valid District user";
	exit;
}
$selected_chk=isset($_GET["selected_chk"])?$_GET["selected_chk"]:"";
//include 'mysqliconn.php';
include 'pollingstn.php';
include 'randno3.php';
//$dist='18';
//$pc='41';
new randno3($dist,$sub);


$tmp_code="";
$recipient_code=array();
for($i=0;$i<strlen($selected_chk);$i++)
{
	if($selected_chk[$i]==",")
	{
		array_push($recipient_code,$tmp_code);
		$tmp_code="";
		continue;
	}
	$tmp_code.=$selected_chk[$i];
	
}
if($tmp_code!="")
{
	array_push($recipient_code,$tmp_code);
}
//print_r($recipient_code);
//echo implode(',', $recipient_code);
//exit;
//update assembly party
/*$sobj= new mysqliconn();
$msqli=$sobj->getconn();
$msqli->query("update assembly_party set rand_status='N' where subdivisioncd='$sub'");
$msqli->query("update pollingstation set groupid=NULL where forsubdivision='$sub'");*/

foreach($recipient_code as $asm)
{
	//echo $asm;
	//update polling station
	new pollingstn($dist,$sub,$asm);	
 
}

?>
