<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

date_default_timezone_set('Asia/Calcutta');
require_once('../inc/db_trans.inc.php');
OpenDB();

function getHtmlTable($Query, $QueryNumber) {
  global $DBLink;
  // receive a record set and print
  // it into an html table
  $out = '<div class="col-lg-3"><div class="panel panel-primary pull-left table-responsive">';
  $out .= '<div class="panel-heading"><strong>Query #' . $QueryNumber .'</strong></div>';
  $out .= '<div class="panel-body"><span>' . $Query . '</span></div>';
  $out .= '<table class="table table-striped table-hover">';

  if ($result = mysqli_query($DBLink, $Query)) {
    $out .= "<thead>";
    while ($field = $result->fetch_field()) {
      $out .= "<th>" . $field->name . "</th>";
    }
    $out .= "</thead>";
    $out .= "<tbody>";
    while ($linea = $result->fetch_assoc()) {
      $out .= "<tr>";
      foreach ($linea as $valor_col) {
        $out .= '<td>' . $valor_col . '</td>';
      }
      $out .= "</tr>";
    }
    $out .= "</tbody>";
    /* free result set */
    $result->close();
  }
  $out .= '</table></div></div>';
  return $out;
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Checklist Summary Report</title>
  <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
        crossorigin="anonymous">
</head>

<body style="padding-top: 20px;">
<?php
/* Select queries return a resultset */
$QueryNumber=1;
$Query = 'SELECT selected,block_muni.blockmuni, count(*) as `Count` FROM `personnela` join office on (personnela.officecd=office.officecd) join block_muni on (block_muni.blockminicd=office.blockormuni_cd) GROUP by selected,block_muni.blockmuni';
echo getHtmlTable($Query, $QueryNumber++);

$Query = 'SELECT forsubdivision,booked,left(personcd,1) as `DutyCount`, poststat,count(*) as `PP_Count` from personnela where selected=1 group by forsubdivision, poststat,booked, left(personcd,1) order by forsubdivision,booked,left(personcd,1),poststat';
echo getHtmlTable($Query, $QueryNumber++);

$Query = 'SELECT `forsubdivision`, `forassembly`,`member`, COUNT(*) AS `Rows`  FROM `grp_dcrc` GROUP BY `forsubdivision`, `forassembly`,`member` ORDER BY `forsubdivision`, `forassembly`,`member`';
echo getHtmlTable($Query, $QueryNumber++);

$Query = 'SELECT `forsubdivision`,`forassembly`,`booked`,count(*) FROM `personnela` group by `forsubdivision`,`forassembly`,`booked`';
echo getHtmlTable($Query, $QueryNumber++);

$Query = 'select forsubdivision,sum(numb) from reserve group by forsubdivision';
echo getHtmlTable($Query, $QueryNumber++);

$Query = 'SELECT `forsubdivision`,`booked`,count(*) FROM `personnela` group by `forsubdivision`,`booked`';
echo getHtmlTable($Query, $QueryNumber++);

$Query = 'SELECT `forsubdivision`,booked,poststat,COUNT(*) AS `Rows` FROM `personnela` where selected=1 GROUP BY `forsubdivision`,booked,poststat';
echo getHtmlTable($Query, $QueryNumber++);

$Query = 'SELECT forsubdivision, `forassembly`, member, COUNT(*) AS `Rows` FROM `pollingstation` GROUP BY forsubdivision,`forassembly`,member ORDER BY forsubdivision,`forassembly`,member';
echo getHtmlTable($Query, $QueryNumber++);

$Query = 'select training_venue,training_date,training_time,count(slno) as `PP_Count` from second_appt GROUP by training_venue,training_date,training_time';
echo getHtmlTable($Query, $QueryNumber++);

$Query = 'select training_venue,training_date,training_time,count(slno) as `PP_Count` from second_rand_table_reserve GROUP by training_venue,training_date,training_time';
echo getHtmlTable($Query, $QueryNumber++);

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
