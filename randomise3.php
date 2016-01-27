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
include 'pollingstn.php';
include 'randno3.php';
//$dist='18';
//$pc='41';
new randno3($dist,$sub);

new pollingstn($dist,$sub);

?>
