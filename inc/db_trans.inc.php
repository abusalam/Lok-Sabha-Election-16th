<?php
include_once('dbcon.inc.php');
function safe($value)
{
	try
  	{
		OpenDB();
		global $DBLink;
		$po=mysqli_real_escape_string($DBLink,$value);
		return $po;
	}
	catch(Exception $e)
	{
  		echo "Message: " .$e->getMessage();
  	}
} 
  function execSelect($sql)
  {
	try
  	{
	  OpenDB();
	  global $DBLink;
	  $ret;
	  $ret=mysqli_query($DBLink,$sql)
	   //or die(mysqli_errno($DBLink).":".mysqli_error($DBLink));
	   or die('<script>alert("Error '.mysqli_errno($DBLink).": ".mysqli_error($DBLink).'"); history.back();</script>');
	   mysqli_close($DBLink);
	   return $ret;
	  
	}
	catch(Exception $e)
	{
  		echo "Message: " .$e->getMessage();
  	}
  }

  function getRows($result)
  {
	try
  	{
		OpenDB();
		global $DBLink;
		$ret;
		$ret=mysqli_fetch_array($result);
		mysqli_close($DBLink);
		return $ret;
	}
	catch(Exception $e)
	{
  		echo "Message: " .$e->getMessage();
  	}
  }
  
  function getObject($result)
  {
	try
  	{
		OpenDB();
		global $DBLink;
		$ret;
		$ret=mysqli_fetch_object($result);
		mysqli_close($DBLink);
		return $ret;
	}
	catch(Exception $e)
	{
  		echo "Message: " .$e->getMessage();
  	}
  }
  
  function execInsert($sql)
  {
	try
  	{
		OpenDB();
		global $DBLink;
		$ret;
		$rows;
		$ret=mysqli_query($DBLink,$sql)
		 or die('<script>alert("Error '.mysqli_errno($DBLink).": ".mysqli_error($DBLink).'"); history.back();</script>');
		 
		 $rows=mysqli_affected_rows($DBLink);
		 mysqli_close($DBLink);
		 return $rows;
	}
	catch(Exception $e)
	{
  		echo "Message: " .$e->getMessage();
  	}
  }

  function execUpdate($sql)
  {
	try
  	{
		OpenDB();
		global $DBLink;
		$ret;
		$rows;
		$ret=mysqli_query($DBLink,$sql)
		 or die('<script>alert("Error '.mysqli_errno($DBLink).": ".mysqli_error($DBLink).'"); history.back();</script>');
		$rows=mysqli_affected_rows($DBLink);
		mysqli_close($DBLink);
		return $rows;
	}
	catch(Exception $e)
	{
  		echo "Message: " .$e->getMessage();
  	}
  }

  function rowCount($result)
  {
	try
  	{
		OpenDB();
		global $DBLink;
		$ret;
		$ret=mysqli_num_rows($result);
		//or die(mysql_error()."<br>Error SQL ==>>$sql");
		mysqli_close($DBLink);
		return $ret;
	}
	catch(Exception $e)
	{
  		echo "Message: " .$e->getMessage();
  	}
  }

   function execDelete($sql)
   {
	try
  	{
		OpenDB();
		global $DBLink;
		$ret;
		$rows;
		$ret=mysqli_query($DBLink,$sql)
		 or die('<script>alert("Error '.mysqli_errno($DBLink).": ".mysqli_error($DBLink).'"); history.back();</script>');
		$rows=mysqli_affected_rows($DBLink);
		
		mysqli_close($DBLink);
		
		return $rows;
	}
	catch(Exception $e)
	{
  		echo "Message: " .$e->getMessage();
  	}
  }
  function connection_close()
  {
	  OpenDB();
	  global $DBLink;
	  mysqli_close($DBLink);
  }
?>