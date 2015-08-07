<?php
if(!isset($_SESSION))
{
	session_start();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
    <style type="text/css">
        li{
            padding: 5px;
        }
    </style>
</head>
<?php
include('header/header.php');
if(isset($_SESSION['hid_rand']))
{
	$_SESSION['hid_rand']='';
	unset($_SESSION['hid_rand']);
}
if(isset($_SESSION['hid_rand2']))
{
	$_SESSION['hid_rand2']='';
	unset($_SESSION['hid_rand2']);
}
if(isset($_SESSION['hid_rand3']))
{
	$_SESSION['hid_rand3']='';
	unset($_SESSION['hid_rand3']);
}
$sql='select `URL` from `user` where code='.$_SESSION['user_cd'];
$rsUser=execSelect($sql);
connection_close();
$rowUser=getRows($rsUser);
?>
<body>
<div style="float:left; padding: 20px;">
    <ol>
        <li><a href="//<?php echo $_SERVER['HTTP_HOST'];?>/election/branch-master.php" target="_blank">Add New Branch</a></li>
        <li><a href="//<?php echo $_SERVER['HTTP_HOST'];?>/election/office-details.php" target="_blank">Add New Office</a></li>
        <li><a href="//<?php echo $_SERVER['HTTP_HOST'];?>/election/list-office-details.php" target="_blank">List of Offices</a></li>
        <li><a href="//<?php echo $_SERVER['HTTP_HOST'];?>/election/add-personnel.php" target="_blank">Add New Polling Personnel</a></li>
        <li><a href="//<?php echo $_SERVER['HTTP_HOST'];?>/election/list-personnel.php" target="_blank">List of Polling Personnel</a></li>
        <li><a href="<?php echo $rowUser[0];?>" target="_blank">Data in Google Drive</a></li>
    </ol>
</div>
<div align="center">
    <div class="welcome-message" style="text-align: left;">
        <span class="form">User: <?php print $_SESSION['user']; ?></span>
    </div>
	<div class="welcome-message" align="center" style="width: 40%;">Version WBLAE2016 1.9</div>
    <div class="welcome-message" align="left" style="width: 40%;">Recomended Browser for Proper Functionality & View:
    <ul style="font-size:85%">
    	<li>Internet Explorer 9 or above</li>
        <li>Mozilla Firefox 25 or above</li>
        <li>Google Chrome 30 or above</li>
    </ul></div>
    <div class="welcome-message" align="left" style="width: 40%;">Recomended Screen Resolution for Proper View: 
    <ul style="font-size:85%">
    	<li>1024 x 768</li>
        <li>1280 x 720</li>
        <li>1280 x 768</li>
        <li>1360 x 768</li>
        <li>1366 x 768</li>
    </ul></div>
</div>
</body>
</html>