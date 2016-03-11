<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

date_default_timezone_set('Asia/Calcutta');
require_once('../inc/db_trans.inc.php');
OpenDB();

function getHtmlTable($Query) {
  global $DBLink;
  // receive a record set and print
  // it into an html table
  $out = '<div style="border: 2px dashed goldenrod; float: left; margin: 4px;padding: 4px;">';
  $out .= '<table rules="all" border="1">';
  $out .= '<caption>' . $Query . '</caption>';

  if ($result = mysqli_query($DBLink, $Query)) {

    while ($field = $result->fetch_field()) {
      $out .= "<th>" . $field->name . "</th>";
    }
    while ($linea = $result->fetch_assoc()) {
      $out .= "<tr>";
      foreach ($linea as $valor_col) {
        $out .= '<td>' . $valor_col . '</td>';
      }
      $out .= "</tr>";
    }
    /* free result set */
    $result->close();
  }
  $out .= '</table></div>';
  return $out;
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Checklist Summary Report</title>
</head>

<body>
<?php
/* Select queries return a resultset */
$Query = 'SELECT `booked`,`forsubdivision`,`forassembly`,count(*) FROM `personnela` group by `booked`,`forsubdivision`,`forassembly`';
echo getHtmlTable($Query);

$Query = 'SELECT `subdivisioncd`,`poststat`,`booked`,count(*) FROM `personnela` WHERE selected=1 group by `subdivisioncd`,`poststat`,`booked`';
echo getHtmlTable($Query);

$Query = 'SELECT `forsubdivision`,`poststat`,`booked`,count(*) FROM `personnela` group by `forsubdivision`,`poststat`,`booked`';
echo getHtmlTable($Query);

$Query = 'SELECT `subdivisioncd`,count(*) FROM `personnela` WHERE selected=1 group by `subdivisioncd`';
echo getHtmlTable($Query);

$Query = 'SELECT `training_booked`,`training_type`,`post_stat`,count(*) FROM `training_pp` group by `training_booked`,`training_type`,`post_stat`';
echo getHtmlTable($Query);

$Query = 'SELECT first_rand_table.forsubdivision,`block_muni_name`,count( distinct first_rand_table.personcd) as `Count` FROM `first_rand_table` join poststat on(poststat.poststatus=first_rand_table.poststatus) join poststatorder on(poststatorder.poststat=poststat.post_stat) group by first_rand_table.forsubdivision,`block_muni_name` order by first_rand_table.forsubdivision,block_muni';
echo getHtmlTable($Query);

//echo '<br style="clear:both;"/>';

$Query = 'select training_venue.venuename,training_schedule.training_dt,training_schedule.training_time,count(*) from training_pp join training_schedule on (training_pp.training_sch=training_schedule.schedule_code) join training_venue on(training_venue.venue_cd=training_schedule.training_venue) group by training_venue.venuename,training_schedule.training_dt,training_schedule.training_time';
echo getHtmlTable($Query);

$Query = 'select first_rand_table.venuename,first_rand_table.training_dt,first_rand_table.training_time,count(*) from first_rand_table GROUP by first_rand_table.venuename,first_rand_table.training_dt,first_rand_table.training_time';
echo getHtmlTable($Query);

?>
</body>

</html>
