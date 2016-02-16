<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

date_default_timezone_set('Asia/Calcutta');
require_once('../inc/db_trans.inc.php');
OpenDB();
global $DBLink;

function getHtmlTable($rs)
{
    // receive a record set and print
    // it into an html table
    $out = '<table rules="all" border="1">';
    while ($field = $rs->fetch_field()) $out .= "<th>" . $field->name . "</th>";
    while ($linea = $rs->fetch_assoc()) {
        $out .= "<tr>";
        foreach ($linea as $valor_col) $out .= '<td>' . $valor_col . '</td>';
        $out .= "</tr>";
    }
    $out .= "</table><br/><br/>";
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
if ($result = mysqli_query($DBLink, "SELECT * FROM `BlockWiseGenderWiseGovtCategoryPPCount`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}
if ($result = mysqli_query($DBLink, "SELECT * FROM `BlockWiseGenderWisePPStatusCount`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}
if ($result = mysqli_query($DBLink, "SELECT * FROM `BlockwiseZeroEntryCount`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}
if ($result = mysqli_query($DBLink, "SELECT * FROM `BlockWiseOfficeCount`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}
if ($result = mysqli_query($DBLink, "SELECT * FROM `BlockWisePersonnelCount`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}
if ($result = mysqli_query($DBLink, "SELECT * FROM `BlockWiseRemarksCount`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}
if ($result = mysqli_query($DBLink, "SELECT * FROM `RemarksCount`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}

?>
</body>

</html>