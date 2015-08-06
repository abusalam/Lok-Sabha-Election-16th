<?php
if (file_exists(__DIR__ . '/config.inc.php')) {
    require_once __DIR__ . '/config.inc.php';
} else {
    require_once __DIR__ . '/config.default.inc.php';
}
 $DBLink;
 $DBName;
 function OpenDB()
  {
	  try
	  {
		   global $DBLink;
		   global $DBName;
		   $DBName=MySQL_DB;
		   $DBLink=mysqli_connect(HOST_Name, MySQL_User, MySQL_Pass);

		   if(!$DBLink)
		   	die('<script>alert("Could Not Connect to DataBase Server'.mysqli_error($DBLink).'");</script>');
		   //die("<script>alert('Could Not Connect to DataBase Server'.mysqli_error($DBLink))");
		   mysqli_select_db($DBLink,$DBName)
		   /*or die(mysqli_errno($DBLink).":".mysqli_error($DBLink).". Failed to Open DataBase:$DBName");*/
		   or die('<script>alert("Error No:'.mysqli_errno($DBLink).":".mysqli_error($DBLink).". Failed to Open DataBase:".$DBName.'");location.href="signout.php";</script>');
	  }
	  catch(Exception $e)
	  {
		echo 'Message: ' .$e->getMessage();  
	  }
  }
?>
