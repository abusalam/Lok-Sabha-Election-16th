<?php
 $DBLink;
 $DBName;
 function OpenDB()
  {
	  try
	  {
		   global $DBLink;
		   global $DBName;
		   $DBName="ppds";
		   $DBLink=mysqli_connect("127.0.0.1", "pp4ds", "ppds");

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
