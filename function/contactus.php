<?php
include_once('string_fun.php');
function fetch_userid($code)
{
	$sql="Select code, user_id  From user where code>0";
	if($code==1)
	   $sql.=" and code<>'$code'";
	else
	{
		if($code!='' && $code!='0')
			$sql.=" and code<>'$code'";
	}
	$sql.=" order by user_id";
	$rs=execSelect($sql);
	return $rs;
}
function fetch_max_query_cd()
{
	$sql="Select max(query_id) as cd From tbl_query";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['cd'];
	return $i;
}
function update_query_id($code,$id)
{
	$sql="update tbl_query set 
			query_id ='$id'";
	$sql.="where tbl_query.code='$code'";
	$i=execUpdate($sql);
	connection_close();
	return $i;
}
function save_contact($qid,$to,$subject,$query,$posted_date,$usercd)
{
	$sql="insert into tbl_query (query_id,user_to, subject, query, posted_date, usercode) values ('$qid','$to','$subject','$query','$posted_date', '$usercd')";
	$i=execInsert($sql);
	connection_close();
	return $i;
}
function fatch_contactList($usercode)
{
	$sql="Select tbl_query.code,tbl_query.usercode, tbl_query.subject, user.user_id, tbl_query.posted_date,tbl_query.query_id
			From tbl_query		   
		   Left join user ON tbl_query.usercode = user.code
		   where tbl_query.code>0";    	
		if($usercode!='0' && $usercode!='')
			$sql.=" and (tbl_query.usercode = '$usercode' OR tbl_query.user_to = '$usercode')";
	$sql.=" group by tbl_query.query_id";
	$sql.=" order by tbl_query.posted_date";
	//echo $sql;
	//exit();
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}

function fatch_contactList1($usercode,$p_num,$items)
{
	$sql="Select tbl_query.code,tbl_query.usercode, tbl_query.subject, tbl_query.query, user.user_id, tbl_query.posted_date,tbl_query.query_id
			From tbl_query		   
		   Left join user ON tbl_query.usercode = user.code
		   where tbl_query.code>0";
	if($usercode!='0' && $usercode!='')
			$sql.=" and (tbl_query.usercode = '$usercode' OR tbl_query.user_to = '$usercode')";
    $sql.=" group by tbl_query.query_id";
	$sql.=" order by max(tbl_query.posted_date)";
	$sql.=" DESC LIMIT $p_num , $items";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
/**************lutfar********************/
function fatch_contactList_reply($usercode)
{
	$sql="Select tbl_query.code,tbl_query.usercode, tbl_query.subject, user.user_id, tbl_query.posted_date,tbl_query.query_id
			From tbl_query		   
		   Left join user ON tbl_query.usercode = user.code
		   where tbl_query.code>0";    	
		if($usercode!='0' && $usercode!='')
			$sql.=" and (tbl_query.usercode = '$usercode' OR tbl_query.user_to = '$usercode')";
	$sql.=" group by tbl_query.query_id";
	$sql.=" order by tbl_query.posted_date";
	//echo $sql;
	//exit();
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}

function fatch_contactList1_reply($usercode,$p_num,$items)
{
	$sql="Select tbl_query.code,tbl_query.usercode, tbl_query.subject, tbl_query.query, user.user_id, tbl_query.posted_date,tbl_query.query_id
			From tbl_query		   
		   Left join user ON tbl_query.usercode = user.code
		   where tbl_query.code>0";
	if($usercode!='0' && $usercode!='')
			$sql.=" and (tbl_query.usercode = '$usercode' OR tbl_query.user_to = '$usercode')";
    $sql.=" group by tbl_query.query_id";
	$sql.=" order by max(tbl_query.posted_date)";
	$sql.=" DESC LIMIT $p_num , $items";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
/**************end lutfar ***************/
function check_contactcurrentdate($qcd,$usercode)
{
	$sql="Select max(posted_date) as cd From tbl_query where query_id='$qcd'";

	if($usercode!='0' && $usercode!='')
		$sql.=" and (tbl_query.usercode = '$usercode' OR tbl_query.user_to = '$usercode')";
			//echo $sql;
	$rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['cd'];
	return $i;
}
function fatch_sentList($usercode)
{
	$sql="Select tbl_query.code,tbl_query.usercode, tbl_query.subject, user.user_id, tbl_query.posted_date,tbl_query.query_id
			From tbl_query		   
		   Left join user ON tbl_query.usercode = user.code
		   where tbl_query.code>0";    
	if($usercode!='0' && $usercode!='')
		$sql.=" and tbl_query.usercode = '$usercode'";
	$sql.=" group by tbl_query.query_id";
	$sql.=" order by tbl_query.posted_date";
	
	//echo $sql;
	//exit();
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_sentList1($usercode,$p_num,$items)
{
	$sql="Select tbl_query.code,tbl_query.usercode, tbl_query.subject, user.user_id, tbl_query.posted_date,tbl_query.query_id
			From tbl_query		   
		   Left join user ON tbl_query.usercode = user.code
		   where tbl_query.code>0";    
	if($usercode!='0' && $usercode!='')
		$sql.=" and tbl_query.usercode = '$usercode'";
	$sql.=" group by tbl_query.query_id";
	$sql.=" order by tbl_query.posted_date";
	$sql.=" DESC LIMIT $p_num , $items";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function check_sentcurrentdate($qcd,$usercode)
{
	$sql="Select max(posted_date) as cd From tbl_query where query_id='$qcd'";
	if($usercode!='0' && $usercode!='')
		$sql.=" and tbl_query.usercode = '$usercode'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['cd'];
	return $i;
}
function count_rply($qcd)
{
	$sql="Select count(query_cd) as cd From tbl_reply where query_cd='$qcd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['cd'];
	return $i;
}
function queries_details($pcd)
{
	$sql="Select tbl_query.code,tbl_query.usercode, tbl_query.subject, user.user_id, tbl_query.posted_date,tbl_query.query
			From tbl_query		   
		   Left join user ON tbl_query.usercode = user.code";
  	$sql.=" where tbl_query.query_id='$pcd'"; 
	$sql.=" group by tbl_query.query_id";
    $sql.=" order by tbl_query.posted_date ASC";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function queries1_details($pcd)
{
	$sql="Select tbl_query.code,tbl_query.usercode, tbl_query.subject, user.user_id, tbl_query.posted_date,tbl_query.query
			From tbl_query		   
		   Left join user ON tbl_query.usercode = user.code";
  	$sql.=" where tbl_query.query_id='$pcd'"; 
	$sql.=" group by tbl_query.query_id";
    $sql.=" order by tbl_query.posted_date DESC";
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function fatch_Reply($pcd)
{
	$sql="Select tbl_reply.code,tbl_reply.usercode, tbl_reply.comment, user.user_id, tbl_reply.posted_date
			From tbl_reply		   
		   Left join user ON tbl_reply.usercode = user.code
		   where tbl_reply.code>0";    
	if($pcd!='0' && $pcd!='')
		$sql.=" and tbl_reply.query_cd = '$pcd'";
	$sql.=" order by tbl_reply.posted_date";
	//echo $sql;
	//exit();
	$rs=execSelect($sql);
	connection_close();
	return $rs;
}
function save_comment($pcd,$comment,$posted_date,$usercd)
{
	$sql="insert into  tbl_reply (query_cd, comment, posted_date, usercode) values ('$pcd','$comment','$posted_date', '$usercd')";
	$i=execInsert($sql);
	connection_close();
	return $i;
}
function check_comment($comment,$usercd)
{
	$sql="Select count(*) as cd From tbl_reply where query_cd='$usercd' and comment='$comment'";

	$rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['cd'];
	return $i;
}
?>