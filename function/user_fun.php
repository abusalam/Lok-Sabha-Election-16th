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
function update_user($user_cd,$password,$category,$district_cd,$subdiv,$parliament)
{
	$sql="update user set password='$password',category='$category',districtcd='$district_cd',subdivisioncd='$subdiv',parliamentcd='$parliament' where code='$user_cd'";
	$i=execUpdate($sql);
	return $i;
}
function delete_permission($username)
{
	$sql="delete from user_permission where user_cd='$username'";
	$i=execDelete($sql);
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

function fatch_UserList($dist,$userid,$category)
{
	$sql="Select user.code, user.user_id, user.category, user.creation_date, user.districtcd, district.district,
	  user.subdivisioncd, subdivision.subdivision, user.parliamentcd, pc.pcname
	From user
	  Left Join district On user.districtcd = district.districtcd
	  Left Join subdivision On user.subdivisioncd = subdivision.subdivisioncd
	  Left Join pc On user.parliamentcd = pc.pccd And user.subdivisioncd =
		pc.subdivisioncd where user.code>0";
	if($dist!='' && $dist!='0')
		$sql.=" and user.districtcd='$dist'";
	if($userid!='')
		$sql.=" and user.user_id like '$userid%'";
	if($category!='' && $category!='0')
		$sql.=" and user.category = '$category'";
	$sql.=" order by user.code";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_UserList1($dist,$userid,$category,$p_num,$items)
{
	$sql="Select user.code, user.user_id, user.category, user.creation_date, user.districtcd, district.district,
	  user.subdivisioncd, subdivision.subdivision, user.parliamentcd, pc.pcname
	From user
	  Left Join district On user.districtcd = district.districtcd
	  Left Join subdivision On user.subdivisioncd = subdivision.subdivisioncd
	  Left Join pc On user.parliamentcd = pc.pccd And user.subdivisioncd =
		pc.subdivisioncd where user.code>0";
	if($dist!='' && $dist!='0')
		$sql.=" and user.districtcd='$dist'";
	if($userid!='')
		$sql.=" and user.user_id like '$userid%'";
	if($category!='' && $category!='0')
		$sql.=" and user.category = '$category'";
	$sql.=" order by user.code";
	$sql.=" ASC LIMIT $p_num , $items";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_UserDtl($user_cd)
{
	$sql="Select user.code, user.user_id, user.category, user.creation_date, user.districtcd, user.subdivisioncd, user.parliamentcd
	From user  where user.code='$user_cd'";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
?>