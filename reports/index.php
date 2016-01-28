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
    $out .= "</table>";
    return $out;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reports</title>
</head>

<body>
<h3>List of Offices may needs to be separated into their respective offices</h3>
<?php
if ($result = mysqli_query($DBLink, "SELECT * FROM `MultipleOfficesInOneCode`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}
if ($result = mysqli_query($DBLink, "SELECT * FROM `BlockwiseNoBankACC`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}

if ($result = mysqli_query($DBLink, "SELECT * FROM `BlockwiseNoMobile`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}

if ($result = mysqli_query($DBLink, "SELECT * FROM `BlockwiseNoEPIC`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}

/* Select queries return a resultset */
if ($result = mysqli_query($DBLink, "SELECT * FROM `GovtCategoryGenderCount`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}
if ($result = mysqli_query($DBLink, "SELECT * FROM `PostStatusWiseMaleFemalePPCount`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}
if ($result = mysqli_query($DBLink, "SELECT * FROM `GenderWisePPCount`")) {
    echo getHtmlTable($result);
    /* free result set */
    $result->close();
}
?>
</body>

</html>