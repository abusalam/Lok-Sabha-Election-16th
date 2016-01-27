<?php
session_start();
extract($_REQUEST);
include_once('../inc/distwise_con.php');
//include_once('../inc/todistwise_con.php');
$frmdist=isset($_REQUEST["frmdist"])?$_REQUEST["frmdist"]:"";
//$todist=isset($_REQUEST["todist"])?$_REQUEST["todist"]:"";
$opn=isset($_REQUEST["opn"])?$_REQUEST["opn"]:"";
$off=isset($_GET["off"])?$_GET["off"]:"";

if($opn=="district")
{
	if($frmdist !="0")
	{				
		//mysql_select_db("darjeeling");
		if(!$link) { die('Could not connect database: ' . mysql_error()); }
		$result = mysql_query("SELECT subdivisioncd,subdivision FROM subdivision");
		echo "<select name='Subdivision' id='Subdivision' style='width:170px;' onchange='return fatch_office_fromsubdiv(this.value);' disabled='disabled'>\n";
		echo "<option value='0'>-Select From Subdivision-</option>\n";
		while($row = mysql_fetch_array($result)) 
		{
		   echo "<option value='$row[subdivisioncd]'>$row[subdivision]</option>\n";	
		}
		echo "</select>";
		$row=NULL;
		unset($row,$result,$link);
	}
   else
	{?>
		<select name="Subdivision" id="Subdivision" style="width:170px;"  disabled="disabled" >
		  <option value="0">-Select From Subdivision-</option>                           
		 </select>
	<?Php
	}	
}
if($opn=="poststat")
{
	$subdiv=isset($_REQUEST["subdiv"])?$_REQUEST["subdiv"]:"";
	if($frmdist !="0")
	{
		if(!$link) { die('Could not connect database: ' . mysql_error()); }
		$sql="Select personnel.poststat,
	  Count(personnel.personcd) as total
	From personnel";
	$sql.=" where (personnel.f_cd Is Null Or personnel.f_cd = 0)";
	if($subdiv!='' && $subdiv!=0)
		$sql.=" and personnel.subdivisioncd='$subdiv'";
	$sql.=" Group By personnel.poststat
	Order By personnel.poststat";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) 
		{
		  echo $row['poststat'].": ".$row['total']."; \n";
		}
		$row=NULL;
		unset($row,$result,$link,$sql,$subdiv);
	}
	else
	  echo "";
}
if($off=="n")
{
	$subdiv=isset($_REQUEST["subdiv"])?$_REQUEST["subdiv"]:"";
	
	if($frmdist !="0")
	{
		
		//mysql_select_db("darjeeling");
		if(!$link) { die('Could not connect database: ' . mysql_error()); }
		$sql="select officecd,office from office where subdivisioncd='$subdiv'";
		$result = mysql_query($sql);
		echo "<select name='officename' id='officename' style='width:170px;' disabled='disabled'>\n";
		echo "<option value='0'>-Select Officename-</option>\n";
		while($row = mysql_fetch_array($result)) 
		{
		  echo "<option value='$row[officecd]'>$row[office]</option>\n";	
		}
		echo "</select>";
		$row=NULL;
		unset($row,$result,$link,$sql,$subdiv);
	}
   else
	{?>
		<select name="officename" id="officename" style="width:170px;"  disabled="disabled" >
		  <option value="0">-Select Officename-</option>                           
		 </select>
	<?Php
	}	
}
if($opn=="postwise")
{
	
	if($frmdist !="0")
	{
		
		//mysql_select_db("darjeeling");
		if(!$link) { die('Could not connect database: ' . mysql_error()); }
		$sql="select post_stat,poststatus from poststat order by poststatus asc";
		$result = mysql_query($sql);
		echo "<select name='posting_status' id='posting_status' style='width:170px;' disabled='disabled'>\n";
		echo "<option value='0'>-Select Post Status-</option>\n";
		while($row = mysql_fetch_array($result)) 
		{
		  echo "<option value='$row[post_stat]'>$row[poststatus]</option>\n";	
		}
		echo "</select>";
		$row=NULL;
		unset($row,$result,$link,$sql);
	}
   else
	{?>
		<select name="posting_status" id="posting_status" style="width:170px;"  disabled="disabled" >
		  <option value="0">-Select Post Status-</option>                           
		 </select>
	<?Php
	}	
}
?>