<?php
session_start();
extract($_REQUEST);
include_once('../inc/distwise_con.php');
//$frmdist=isset($_REQUEST["frmdist"])?$_REQUEST["frmdist"]:"";
$todist=isset($_REQUEST["todist"])?$_REQUEST["todist"]:"";
$opn=isset($_REQUEST["opn"])?$_REQUEST["opn"]:"";
$off=isset($_GET["off"])?$_GET["off"]:"";

if($opn=="district")
{
	if($todist !="0")
	{
				
		//mysql_select_db("darjeeling");
		if(!$tlink) { die('Could not connect database: ' . mysql_error()); }
		$result = mysql_query("SELECT subdivisioncd,subdivision FROM subdivision");
		echo "<select name='tosubdivision' id='tosubdivision' style='width:170px;' onchange='return to_subdiv_change(this.value);'>\n";
		echo "<option value='0'>-Select To Subdivision-</option>\n";
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
		<select name="tosubdivision" id="tosubdivision" style="width:170px;"  disabled="disabled" >
		  <option value="0">-Select To Subdivision-</option>                           
		 </select>
	<?Php
	}	
}
if($opn=="prev_poststat")
{
	$subdiv=isset($_REQUEST["subdiv"])?$_REQUEST["subdiv"]:"";
	if($todist !="0")
	{
		if(!$tlink) { die('Could not connect database: ' . mysql_error()); }
		$sql="Select personnela.poststat,
	  Count(personnela.personcd) As total
	From personnela";
	$sql.=" where 1";
	if($subdiv!='' && $subdiv!=0)
		$sql.=" and personnela.forsubdivision='$subdiv'";
	$sql.=" Group By personnela.poststat
	Order By personnela.poststat";
		$result = mysql_query($sql);
		echo "Transffered &nbsp;: ";
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
?>