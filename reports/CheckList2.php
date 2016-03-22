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

$Query = 'select training_venue,training_date,training_time,count(slno) as `PP_Count` from second_appt GROUP by training_venue,training_date,training_time';
echo getHtmlTable($Query);

$Query = 'select training_venue,training_date,training_time,count(slno) as `PP_Count` from second_rand_table_reserve GROUP by training_venue,training_date,training_time';
echo getHtmlTable($Query);

/**
 * @filename: currentgitbranch.php
 * @usage: Include this file after the '<body>' tag in your project
 * @author Kevin Ridgway
 */
$stringfromfile = file('../.git/HEAD', FILE_USE_INCLUDE_PATH);

$firstLine = $stringfromfile[0]; //get the string from the array

$explodedstring = explode("/", $firstLine, 3); //seperate out by the "/" in the string

$branchname = $explodedstring[2]; //get the one that is always the branch name

echo "<div style='clear: both; font-size: 14px; font-family: Helvetica; color: #30121d; background: #bcbf77; padding: 20px; text-align: center;'>Current branch: <span style='color:#fff; font-weight: bold;'>" . $branchname . "</span></div>"; //show it on the page
?>

</body>

</html>
