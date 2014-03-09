<?php
include_once("session.php");
if(strpos($_SERVER['REQUEST_URI'],'header.php')==true)
{
	echo "Invalid request";
	exit;
}
//echo isset($_SESSION['alogin'])?$_SESSION['alogin']:'false'; exit;
if(isset($_SESSION['alogin'])==false)
{
	echo "<script>alert('Session Expired.');</script>";
	echo "<script type='text/javascript'>\n";
	echo "window.location.href = 'login.php?redirect=$_SERVER[REQUEST_URI]';\n";
	echo "</script>";
	exit();
}
date_default_timezone_set('Asia/Calcutta');
?>
<!--<link href="css/style.css" rel="stylesheet" />
<link href="css/stylemenu.css" rel="stylesheet" />
<div id="coolMenu">
<ul id="coolMenu">
	<li><a href="#">Menu 1</a></li>
	<li><a href="#">Menu 2</a></li>
	<li><a href="#">Menu 3</a></li>
	<li><a href="#">Menu 4</a></li>
	<li><a href="#">Menu 5</a></li>
</ul>
</div>-->
<div align="center" ><table cellpadding="0" cellspacing="0" style="background-image:url(images/bbg.gif); background-repeat:repeat-y; background-size:100% 150px;" width="100%"><tr><!--<td><img src="/election/images/sj.png" alt="" height="100px" /></td>--><td colspan="2" align="center"><img src="/election/images/pge.png" alt="" height="150px" /></td></tr></table></div>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/number.js"></script>
<script language="javascript" src="js/dateValidation.js"></script>
<script type="text/javascript" src="resource/stmenu.js"></script>

<link href="css/cal/css/examples-offline.css" rel="stylesheet">
<link href="css/cal/css/kendo.common.min.css" rel="stylesheet">
<link href="css/cal/css/kendo.default.min.css" rel="stylesheet">
<script src="css/cal/js/jquery.min.js"></script>
<script src="css/cal/js/kendo.web.min.js"></script>

<a href="http://www.dhtml-menu-builder.com"  style="display:none;visibility:hidden;">Drop Down Menu</a>
<script type="text/javascript" language="javascript">
stm_bm(["menu4fd9",970,"","blank.gif",0,"","",1,0,0,0,1000,1,0,0,"","100%",0,0,1,1,"default","hand","",1,25],this);
stm_bp("p0",[0,4,0,0,3,4,0,0,100,"",-2,"",-2,90,0,0,"#000000","#38557D","",3,0,0,"#000000"]);
stm_ai("p0i0",[0,"Home","","",-1,-1,0,"home.php","_self","","","","",0,0,0,"","",0,0,0,1,1,"#38557D",0,"#B0B0C1",0,"","",3,3,0,0,"#FFFFF7","#FFFFF7","#FFFFFF","#000000","bold 8pt 'Arial','Verdana'","bold 8pt 'Arial','Verdana'",0,0,"","","","",0,0,0],80,25);
<?php
include_once('inc/db_trans.inc.php');
include_once('function/add_fun.php');
$dist_cd; $subdiv_cd;
if(isset($_SESSION['dist_cd']))
	$dist_cd=$_SESSION['dist_cd'];
else
	$dist_cd="0";
if(isset($_SESSION['subdiv_cd']))
	$subdiv_cd=$_SESSION['subdiv_cd'];
else
	$subdiv_cd="0";
if(isset($_SESSION['pc_cd']))
	$pc_cd=sprintf("%02d",$_SESSION['pc_cd']);
else
	$pc_cd="0";
$district=uppercase(district_name($dist_cd));
$_SESSION['dist_name']=$district;
$subdiv_name=uppercase(Subdivision_ag_subdivcd($subdiv_cd));
$_SESSION['subdiv_name']=$subdiv_name;
$pc_name=uppercase(pc_name($pc_cd));
$_SESSION['pc_name']=$pc_name;
$user_cd=$_SESSION['user_cd'];
$sql="SELECT distinct menu.menu_cd, menu.menu, menu.link
	  FROM user_permission LEFT OUTER JOIN
           menu ON user_permission.menu_cd = menu.menu_cd
	  WHERE user_permission.user_cd='$user_cd'";
	  
$rs=execSelect($sql);
if(rowCount($rs)<1)
	echo "";
else
{
	$row_count=rowCount($rs);
	for($i=1; $i<=$row_count; $i++)
	{		
		$row=getRows($rs);
		//if($i==2 || $i==3 || $i==4 || $i==5 || $i==6 || $i==7 || $i==8) continue;
		echo "stm_aix('p0i1','p0i0',[0,'$row[1]','','',-1,-1,0,'$row[2]','_self','','','','',0,0,0,'','',0,0,0,1,1,'#38557D',0,'#B0B0C1',0,'','',3,3,0,0,'#FFFFF7','#FFFFF7','#FFFFFF','#000000','bold 8pt Arial,Verdana','bold 8pt Arial,Verdana',0,0,'','','','',0,0,0],80,25);\n";
		
		$sql_sub="SELECT submenu.submenu_cd, submenu.submenu, submenu.link
		 		  FROM  user_permission LEFT OUTER JOIN
                      	submenu ON user_permission.submenu_cd = submenu.submenu_cd
				  WHERE	user_permission.user_cd='$user_cd' and user_permission.menu_cd='$row[0]'";

		$rs_sub=execSelect($sql_sub);
		$rs_sub_tmp=execSelect($sql_sub);
		$row_count_sub=rowCount($rs_sub);
		if($row_count_sub>=1)
		{
			$m=0; $n=0;
			for($k=1; $k<=$row_count_sub; $k++)
			{
				$row_tmp=getRows($rs_sub_tmp);
				if($row_tmp[1]!="")
				{				
					$n++;
				}
			}
			if($n>=1)
				echo "stm_bp('p1',[1,4,0,0,1,3,6,7,100,'',-2,'',-2,100,2,3,'#999999','#FFFFFF','',3,1,1,'#ACA899']);\n";
			for($j=1; $j<=$row_count_sub; $j++)
			{
				$row_sub=getRows($rs_sub);
				if($row_sub[1]!="")
				{				
				echo "stm_aix('p1i0','p0i0',[0,'$row_sub[1]          ','','',-1,-1,0,'$row_sub[2]','_self','','','','',6,0,0,'','',0,0,
				0,0,1, '#FFFFFF',0,'#003399',0,'','',3,3,0,0,'#FFFFF7','#000000','#000000','#FFFFFF','8pt Tahoma,Arial','8pt Tahoma,Arial']);\n";	
				$m++;
				}			
			}
			if($m>=1)
			echo "stm_ep();\n";
		}
	}
}
?>
/*stm_aix("p0i1","p0i0",[0,"User Management"],100,25);
stm_bp("p1",[1,4,0,0,1,3,6,7,100,"",-2,"",-2,100,2,3,"#999999","#FFFFFF","",3,1,1,"#ACA899"]);
stm_aix("p1i0","p0i0",[0,"New","","",-1,-1,0,"#","_self","","","","",6,0,0,"resource/arrow_r.gif","resource/arrow_w.gif",7,7,0,0,1,"#FFFFFF",0,"#003399",0,"","",3,3,0,0,"#FFFFF7","#000000","#000000","#FFFFFF","8pt 'Tahoma','Arial'","8pt 'Tahoma','Arial'"]);
stm_bpx("p2","p1",[1,2,-2,-3,2,3,0,0]);
stm_aix("p2i0","p1i0",[0,"Windows","","",-1,-1,0,"#","_self","","","","",0,0,0,"","",0,0]);
stm_ai("p2i1",[6,1,"#ACA899","",0,0,0]);
stm_aix("p2i2","p2i0",[0,"Message"]);
stm_aix("p2i3","p2i0",[0,"Contact"]);
stm_ep();
stm_aix("p1i1","p2i0",[0,"Open","","",-1,-1,0,"#","_self","","","","",6]);
stm_aix("p1i2","p1i1",[0,"Edit with Microsoft Word"]);
stm_aix("p1i3","p1i1",[0,"Save"]);
stm_aix("p1i4","p2i1",[]);
stm_aix("p1i5","p1i1",[0,"Page Setup..."]);
stm_aix("p1i6","p1i1",[0,"Print..."]);
stm_aix("p1i8","p1i1",[0,"Properties"]);
stm_aix("p1i9","p1i1",[0,"Work offline"]);
stm_aix("p1i10","p1i1",[0,"Close"]);
stm_ep();*/
stm_aix("p0i5","p0i0",[0,"Signout","","",-1,-1,0,"signout.php","_self"],80,25);
stm_ep();
stm_em();
</script>

&nbsp;<span class="form">Hi, <?php print $_SESSION['user']; ?></span>
<?php
$user_cat=isset($_SESSION['user_cat'])?$_SESSION['user_cat']:'';
$sql_env="select * from environment where dist_cd='$dist_cd'";
$rs_env=execSelect($sql_env);
if(rowCount($rs_env)>0)
{
	$row_env=getRows($rs_env);
	$environment=uppercase($row_env['environment']);
	$_SESSION['environment']=$environment;
	$apt1_orderno=$row_env['apt1_orderno'];
	$_SESSION['apt1_orderno']=$apt1_orderno;
	$apt1_date = new DateTime($row_env['apt1_date']);
	$_SESSION['apt1_date']=$apt1_date->format('d/m/Y');
	$apt2_orderno=$row_env['apt2_orderno'];
	$_SESSION['apt2_orderno']=$apt2_orderno;
	$apt2_date = new DateTime($row_env['apt2_date']);
	$_SESSION['apt2_date']=$apt2_date->format('d/m/Y');
	$signature=$row_env['signature'];
	$_SESSION['signature']=$signature;
}
else if($user_cat!="Administrator")
{
	echo "\n<br />";
	echo "<span class='error'>Please set Environment Table</span>";
	exit;
}
?>