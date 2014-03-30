<?php
if(isset($_GET['pc_cd']) && $_GET['pc_cd']!=null)
{
	$pc=$_GET['pc_cd'];
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
//$dist='18';
//$pc='41';

new pollingstn($dist,$pc);

?>
