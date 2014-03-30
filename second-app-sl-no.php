<?php
include_once('inc/db_trans.inc.php');
include_once('function/training2_fun.php');
$rec=0;
include_once('inc/commit_con.php');
//try {
mysqli_autocommit($link,FALSE);
$sql_empty_sl="update second_appt set slno=NULL";
execUpdate($sql_empty_sl);

$sql="update second_appt set slno=? where pers_off=? and pr_personcd=?";
$stmt = mysqli_prepare($link, $sql);
if($stmt!=false)
	mysqli_stmt_bind_param($stmt, 'iss', $slno,$pers_off,$pr_personcd);

$rsRec=fetch_second_apt();
$num_rows=rowCount($rsRec);
if($num_rows>0)
{
	for($i=0;$i<$num_rows;$i++)
	{
		$rowRec=getRows($rsRec);
		$pers_off=$rowRec['pers_off'];
		$pr_personcd=$rowRec['pr_personcd'];
		$slno=($i+1);
		mysqli_stmt_execute($stmt);
		$rec+=mysqli_stmt_affected_rows($stmt);
	}
}
if (!mysqli_commit($link)) {
print("Transaction commit failed\n");
exit();
}
else
{
	print "$rec Record(s) updated successfully\n";
}
mysqli_stmt_close($stmt);
mysqli_close($link);
//}
//catch(Exception $e)
//{
//	die("Error occured");//echo "error occured"; //$e->Message();
//}
?>