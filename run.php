<?php 
include 'mysqliconn.php';
include 'token.php';
include 'token_sub.php';
include 'token_phase.php';
$sub_div=isset($_GET['subdiv'])?$_GET['subdiv']:'';
$dist=isset($_GET['dist'])?$_GET['dist']:'';
$opn=isset($_GET['opn'])?$_GET['opn']:'';
if($opn=="sub")
{
	new token($sub_div,'01');
}
if($opn=="district")
{
	new token_sub($dist,'01');
}
if($opn=="phase")
{
	new token_phase($sub_div,'01');
}
?>