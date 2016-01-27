<?php
include_once('string_fun.php');
//===========District============
function fatch_district_master($dist_cd)
{
	$sql="Select Distinct district.districtcd,
	  district.district	From district where district.districtcd>0";
	if($dist_cd!='' && $dist_cd!='0')
		$sql.=" and districtcd='$dist_cd'";
	$sql.=" order by district";
	$rs=execSelect($sql);
	return $rs;
}
function duplicate_env($env_code,$district_cd)
{
	$sql="select count(*) as cnt from environment where dist_cd='$district_cd'";
	$rs=execSelect($sql);
	$row=getRows($rs);
	$i=$row['cnt'];
	return $i;
}
function save_env($district_cd,$distnm_sml,$distnm_cap,$envname,$apt1_orderno,$apt1_date,$apt2_orderno,$apt2_date)
{
	$sql="insert into environment (environment, dist_cd	, distnm_sml, distnm_cap, apt1_orderno, apt1_date, apt2_orderno, apt2_date) values ('$envname','$district_cd','$distnm_sml','$distnm_cap','$apt1_orderno','$apt1_date','$apt2_orderno','$apt2_date')";

	$i=execInsert($sql);
	return $i;
}
function update_adminstrator($district_cd)
{
	$sql="update user set districtcd='$district_cd' where category='Administrator'";
	$i=execUpdate($sql);
	return $i;
}
?>