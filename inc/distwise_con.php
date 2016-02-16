<?php
if($frmdist!="")
{
  switch($frmdist)
  {
	  case ($frmdist=="Darjeeling"):
			  $link=mysql_connect("localhost","root","root");
			   mysql_select_db("darjeeling", $link);
			   $db="darjeeling";
			break;
	  case ($frmdist=="Bardhaman"):
			  $link=mysql_connect("localhost","pp4ds","ppds");
			   mysql_select_db("ppds", $link);
			   $db="ppds";
			break;
	  default:
		   echo "";
		break;
  }
}
if($todist!="")
{
  switch($todist)
  {
	  case ($todist=="Darjeeling"):
			  $tlink=mysql_connect("localhost","root","root");
			   mysql_select_db("darjeeling", $tlink);
			   $db1="darjeeling";
			break;
	  case ($todist=="Bardhaman"):
			  $tlink=mysql_connect("localhost","pp4ds","ppds");
			   mysql_select_db("ppds", $tlink);
			  $db1="ppds";
			break;
	  default:
		   echo "";
		break;
  }
}
?>