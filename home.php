<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Home</title>
    <style type="text/css">
        ol {
            margin: 10px;
            padding: 0;
        }

        li {
            padding-bottom: 10px;
            list-style-position: inside;
        }
    </style>
</head>
<?php
include('header/header.php');
if (isset($_SESSION['hid_rand'])) {
    $_SESSION['hid_rand'] = '';
    unset($_SESSION['hid_rand']);
}
if (isset($_SESSION['hid_rand2'])) {
    $_SESSION['hid_rand2'] = '';
    unset($_SESSION['hid_rand2']);
}
if (isset($_SESSION['hid_rand3'])) {
    $_SESSION['hid_rand3'] = '';
    unset($_SESSION['hid_rand3']);
}
$sql = 'select `URL` from `user` where code=' . $_SESSION['user_cd'];
$rsUser = execSelect($sql);
connection_close();
$rowUser = getRows($rsUser);
?>
<body>
<div class="welcome-message" style="text-align: left;display: block; height: 15px;clear: both;">
    <span style="float: left;">User: <?php print $_SESSION['user']; ?></span>
    <span style="float: right;">Version WBLAE2016 1.9</span>
</div>
<div style="float:left;">
    <ol>
        <li><a href="//<?php echo $_SERVER['HTTP_HOST']; ?>/election/branch-master.php" target="_blank">Add New
                Branch</a></li>
        <li><a href="//<?php echo $_SERVER['HTTP_HOST']; ?>/election/office-details.php" target="_blank">Add New
                Office</a></li>
        <li><a href="//<?php echo $_SERVER['HTTP_HOST']; ?>/election/list-office-details.php" target="_blank">List of
                Offices</a></li>
        <li><a href="//<?php echo $_SERVER['HTTP_HOST']; ?>/election/add-personnel.php" target="_blank">Add New Polling
                Personnel</a></li>
        <li><a href="//<?php echo $_SERVER['HTTP_HOST']; ?>/election/list-personnel.php" target="_blank">List of Polling
                Personnel</a></li>
        <li><a href="<?php echo $rowUser[0]; ?>" target="_blank">Data in Google Drive</a></li>
    </ol>
</div>
<?php
if (file_exists(__DIR__ . '/inc/instructions.inc.php')) {
    require_once __DIR__ . '/inc/instructions.inc.php';
} else {
    require_once __DIR__ . '/inc/instructions.default.inc.php';
}
?>
</body>
</html>