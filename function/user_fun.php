<?php
function list_district()
{
	$sql="select districtcd,district from district";
	$rs=execSelect($sql);
	return $rs;
}
function list_menu()
{
	$sql="select menu_cd,menu from menu order by menu_cd";
	$rs=execSelect($sql);
	return $rs;
}
function list_submenu_ag_menu($menu)
{
	$sql="select submenu_cd,submenu from submenu where menu_cd='$menu' order by submenu_cd";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_user($userid)
{
	$sql="select count(*) as c_user from user where user_id='$userid'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$c_user=$row['c_user'];
	return $c_user;
}
function save_user($userid,$password,$category,$district,$subdiv,$parliament)
{
	$sql="insert into user (user_id,password,category,districtcd,subdivisioncd,parliamentcd) values ('$userid','$password','$category','$district','$subdiv','$parliament')";
	$i=execInsert($sql);
	return $i;
}
function get_user_cd_ag_username($username)
{
	$sql="select * from user where user_id='$username'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$user_cd=$row['code'];
	return $user_cd;
}
function save_user_permission($user_cd,$menu_cd,$submenu_cd)
{
	$sql="insert into user_permission (user_cd,menu_cd,submenu_cd) values ('$user_cd','$menu_cd','$submenu_cd')";
	$i=execInsert($sql);
	return $i;
}
function lisr_user_id()
{
	$sql="select count(*) as c_user from user where user_id='$userid'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$c_user=$row['c_user'];
	return $c_user;
}

?>