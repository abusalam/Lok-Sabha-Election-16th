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
<title>Home</title><?php
include('header/header.php');
?>
</head>
<?php
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
?>
<body>
<h1>&nbsp;</h1>
<div align="center">
	<div class="welcome-message" align="center" style="width: 40%;">Version 1.7</div>
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