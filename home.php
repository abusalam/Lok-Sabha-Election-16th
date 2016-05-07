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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <?php include('header/header.php'); ?>
</head>
<?php
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
?>
<body>
  <div style="font-size:16px;padding: 0 20px 0 20px;">
    <ol class="list-group">
      <li class="list-group-item active"><strong>Version 2.5.3-1</strong></li>
      <li class="list-group-item">Installation and Update Instructions (<a href="Readme.txt">Readme.txt</a>)</li>
      <li class="list-group-item list-group-item-success"><strong>Before First Randomization</strong></li>
      <li class="list-group-item">Execute the following SQL: <code>ALTER TABLE `assembly_party` ADD `RandOrder` INT NOT NULL AFTER `rand_status`;</code></li>
      <li class="list-group-item">Open <code>assembly_party</code> Table and put serial number in the <code>RandOrder</code> field according to the order of availability(i.e. AC with minimum no of available counting personnel should have lowest serial number)</li>
      <li class="list-group-item list-group-item-warning"><strong>Before Printing First Appointment Letter</strong></li>
      <li class="list-group-item">Execute the following SQL: <code>ALTER TABLE `environment` ADD `counting_venue` VARCHAR(255) NOT NULL AFTER `apt2_date`, ADD `venue_address` VARCHAR(255) NOT NULL AFTER `counting_venue`;</code></li>
      <li class="list-group-item">Open <code>environment</code> Table and put Counting Venue and Venue Address in their respective fields</li>
      <li class="list-group-item list-group-item-warning">All the SQL Queries can be found in <a href="db/Counting.sql">Counting-SQL File</a>.</li>
    </ol>
  </div>
</body>
</html>