<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bulk Query</title>
<!--<link rel="stylesheet" href="../css/style.css" />-->
<style type="text/css">
body{font:12px "lucida grande", tahoma, verdana, arial, sans-serif; margin: 5px 5px 5px 10px;}
#parent li { list-style-image:url(../images/right2.gif);}
.parent-node{color:#069;}
.child-node{color:#090; }
.parent-node:hover{color:#09F; cursor:pointer;}
.child-node:hover{color:#0C0; cursor:pointer;}
.office_details{padding:3px 10px;}
.emp_details{padding-left:10px;}
table{font-size:11px; border:1px solid;border-collapse:collapse;}
table td,th{border:1px solid; padding:0 3px 0 3px;}
</style>
<script>
function office_details(str,str1,num)
{
	if(document.getElementById("office_details"+num).innerHTML!="")
	{
		document.getElementById("office_details"+num).innerHTML="";
		document.getElementById("item_"+num).style.listStyleImage="url(../images/right2.gif)";
	}
	else
	{
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("office_details"+num).innerHTML=xmlhttp.responseText;
		document.getElementById("item_"+num).style.listStyleImage="url(../images/drop2.gif)";
		}
	  }
	xmlhttp.open("GET","ajax-bulk-report.php?sub_div="+str+"&pc="+str1+"&opn=office",true);
	xmlhttp.send();
	}
}
function person_details(str,str1)
{
	if(document.getElementById("person_details_"+str).innerHTML!="")
	{
		document.getElementById("person_details_"+str).innerHTML="";
	}
	else
	{
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("person_details_"+str).innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","ajax-bulk-report.php?office="+str+"&forpc="+str1+"&opn=person",true);
	xmlhttp.send();
	}
}
</script>
</head>
<?php
include_once('..\inc\db_trans.inc.php');
include_once('..\function\add_fun.php');
if(isset($_REQUEST['Subdivision']) && $_REQUEST['Subdivision']!=null)
{
	$subdiv=$_REQUEST['Subdivision'];
}
else
{
	$subdiv="0";
}
$subdivision=Subdivision_ag_subdivcd($subdiv);
?>
<body>
<div>
<div align="center"><h3>Total Details</h3></div>
<?php print $subdivision; ?> Subdivision
<ul id="parent">
<?php
$rsPC=fatch_pc($subdiv);
$num_rows=rowCount($rsPC);
if($num_rows>0)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$rowPC=getRows($rsPC);
		$pccd=$rowPC[0];
		$pcname=$rowPC[1];
?>
<li id="item_<?php print $i; ?>">
<label class="parent-node" id="lblPC<?php print $i; ?>" name="lblPC<?php print $i; ?>" onclick="return office_details('<?php print $subdiv; ?>','<?php print $pccd; ?>','<?php print $i; ?>');"><?php print $i.") ".$pcname; ?></label>&nbsp;&nbsp;-&nbsp;&nbsp;
<?php	
		{
			//$pc_swp=$_GET["pc_swp"];
			//$sub_swp=$_GET["sub_swp"];
			$rs=fatch_post_stat_wise_dtl_transffered($subdiv,$pccd);
			//$num_rows=;
			for($j=1;$j<=rowCount($rs);$j++)
			{
				$row=getRows($rs);
				echo $row['poststat'].": ".$row['total']."; \n";
				$row=NULL;
			}
			unset($rs);
		}
		//echo "<br />\n";
?>
<div class="office_details" id="office_details<?php print $i; ?>"></div></li>
<?php
		$rowPC=NULL;
	}
}
$num_rows=0;			
$rsPC=NULL;
?>
</ul>
</div>
</body>
</html>