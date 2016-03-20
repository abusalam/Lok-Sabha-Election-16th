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
$Query = 'SELECT `forsubdivision`,`forassembly`,`booked`,count(*) FROM `personnela` group by `forsubdivision`,`forassembly`,`booked`';
echo getHtmlTable($Query);

$Query = 'SELECT `forsubdivision`,booked,poststat,COUNT(*) AS `Rows` FROM `personnela` where selected=1 GROUP BY `forsubdivision`,booked,poststat';
echo getHtmlTable($Query);

$Query = 'SELECT forsubdivision,booked,left(personcd,1) as `DutyCount`, poststat,count(*) as `PP_Count` from personnela where selected=1 group by forsubdivision, poststat,booked, left(personcd,1) order by forsubdivision,booked,left(personcd,1),poststat';
echo getHtmlTable($Query);

$Query = 'SELECT subdivisioncd,sum(no_party) from assembly_party group by subdivisioncd';
echo getHtmlTable($Query);

//echo '<br style="clear:both;"/>';

$Query = 'select forsubdivision,sum(numb) from reserve group by forsubdivision';
echo getHtmlTable($Query);

$Query = 'SELECT `forsubdivision`,`booked`,count(*) FROM `personnela` group by `forsubdivision`,`booked`';
echo getHtmlTable($Query);

?>
</body>

</html>
