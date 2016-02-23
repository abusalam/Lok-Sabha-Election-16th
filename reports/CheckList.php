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

$Query = 'SELECT `training_booked`,`training_type`,`post_stat`,count(*) FROM `training_pp` group by `training_booked`,`training_type`,`post_stat`';
echo getHtmlTable($Query);

$Query = 'SELECT `subdivisioncd`,`poststat`,`booked`,count(*) FROM `personnela` WHERE selected=1 group by `subdivisioncd`,`poststat`,`booked`';
echo getHtmlTable($Query);

$Query = 'SELECT `poststat`,`booked`,count(*) FROM `personnela` group by `poststat`,`booked`';
echo getHtmlTable($Query);

?>
</body>

</html>