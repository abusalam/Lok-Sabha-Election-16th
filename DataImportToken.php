<?php
/**
 * Maintains a List of Tokens in order of their generation for the Job of Importing Data
 *
 * Required Schema:
 * CREATE TABLE IF NOT EXISTS `WBLAE2016_OfficeStatus` (
 * `TokenID` int(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
 * `OfficeID` char(8) NOT NULL,
 * `Status` varchar(50) NOT NULL,
 * `GeneratedOn` timestamp on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 * `Pending` boolean DEFAULT 1
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 */
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set('Asia/Kolkata');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Generate Token - Import Data</title>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body style="padding: 20px;">
<div id="remove" class="hidden">
    <?php
    include('header/header.php');
    ?>
</div>
<div class="container-fluid">
    <img alt="Emblem of India" src="images/Emblem_of_India.png"
         class="img-responsive pull-left hidden-print" style="padding: 10px;">

    <div class="pull-left hidden-print">
        <h1 style="margin-top: 15px;margin-bottom: 0;">Generate Tokens
            <small> for Data Import and Monitoring</small>
        </h1>
        <span class="lead">West Bengal Legislative Assembly Election 2016</span>
    </div>

    <div style="clear: both;height: 20px;"></div>
    <div class="modal fade bs-example-modal-lg" id="dlgToken" tabindex="-1" role="dialog"
         aria-labelledby="generateTokenLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="generateTokenLabel">Generate Token</h4>
                </div>
                <div class="modal-body">
                    <p id="OfficeID">One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generate Token</button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default hidden-print">
        <div class="panel-heading">
            <h3 class="panel-title">Generate Token
                <small>to import PP2 data from Google Sheets to MySQL</small>
            </h3>
        </div>
        <div class="panel-body">
            <form class="form" action="DataImportToken.php" method="post" role="form">
                <?php
                $OfficeCode = filter_var($_POST['OfficeCode'], FILTER_VALIDATE_INT);
                if ($OfficeCode > 0) {

                    $Query = 'Select `Office` from `office` where `officecd`=\'' . $OfficeCode . '\''
                        . ' AND `usercode` = ' . $_SESSION['user_cd'];

                    $RsOffice = execSelect($Query);

                    if (rowCount($RsOffice) > 0) {
                        $Query = 'Update `WBLAE2016_OfficeStatus` Set `Pending` = 0 '
                            . 'Where `OfficeID`=\'' . $OfficeCode . '\' AND `Pending`=1';
                        $TokenCancelled = execUpdate($Query);
                        if ($TokenCancelled > 0) {
                            $NewTokenMsg = 'Your New Token for this office is again in queue.';
                            ?>
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Warning!</strong> All existing Tokens in queue for this office has been
                                cancelled.
                            </div>
                        <?php
                        }

                        $Query = "Insert into `WBLAE2016_OfficeStatus`(`OfficeID`,`Status`) "
                            . " Values ('$OfficeCode','Uploaded')";
                        $TokenGenerated = execInsert($Query);
                        if ($TokenGenerated > 0) {
                            if ($TokenCancelled == 0) {
                                $NewTokenMsg = 'Your Data Import Token for this office has been created successfully.';
                            }

                            ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Well done!</strong> <?php echo $NewTokenMsg; ?>
                            </div>
                        <?php
                        }
                        connection_close();
                    } else {
                        ?>
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Oh snap!</strong> we could not find the office.
                        </div>
                    <?php
                    }
                }

                ?>
                <div class="input-group">
                    <span class="input-group-addon">Office Code</span>
                    <input type="text" class="form-control" id="OfficeCode" name="OfficeCode" aria-label="Office Code"
                           placeholder="Enter the office code for which data uploading in Google Sheets has been complete"
                           autocomplete="off"/>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><!--data-toggle="modal"
                                data-target=".bs-example-modal-lg" -->Mark as Data Uploaded
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <div class="panel-footer">
            <span>It is recommended not to use this form very frequently as this will cancel your current token
                and assign a new token. Tokens are processed according to their timestamp.
            </span>

        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="badge pull-right">User: <?php print $_SESSION['user']; ?></span>

            <h3 class="panel-title">Status of Data Import for Offices from Google Sheets to MySQL</h3>
        </div>
        <div class="panel-body">
            <p>The details of offices are available Below</p>
        </div>
        <table class="table table-hover table-responsive">
            <thead>
            <tr>
                <th>#</th>
                <th>Office ID</th>
                <th>Office</th>
                <th>Date Time</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $Query = 'select min(`TokenID`) from `WBLAE2016_OfficeStatus` join `office` on(`OfficeID`=`officecd`)'
                .' where `Status`=\'Uploaded\' AND Pending=1';
            $RsQueue = execSelect($Query);
            $InQueueRow = getRows($RsQueue);
            $QueuePos = $InQueueRow[0];

            if($_SESSION['user_cat']=='Administrator'){
                $sql = 'select `officecd`, CONCAT(\'[\',`user_id`,\'] \',`office`,\', \',`address1`), `tot_staff`,'
                    . ' `Status`, `GeneratedOn`, `TokenID`'
                    . ' from `office` join `WBLAE2016_OfficeStatus` on (`OfficeID`=`officecd`)'
                    . ' join `user` on(`usercode`=`code`) Where `Pending`=1 and Status!=\'Imported\''
                    . ' order by `GeneratedOn`';
            } else {
                $sql = 'select `officecd`, CONCAT_WS(\', \',`office`,`address1`), `tot_staff`, `Status`,'
                    . ' `GeneratedOn`, `TokenID`'
                    . ' from `office` left join `WBLAE2016_OfficeStatus` on (`OfficeID`=`officecd` AND `Pending`>0)'
                    . ' where usercode=' . $_SESSION['user_cd'] . ' order by `GeneratedOn` desc';
            }

            $Offices = execSelect($sql);

            connection_close();
            $OfficeCount = rowCount($Offices);
            $LabelClass['Uploaded'] = 'label-warning';
            $LabelClass['Imported'] = 'label-success';
            $LabelClass['Problem'] = 'label-danger';

            $TotalPP = 0;

            for ($i = 0; $i < $OfficeCount; $i++):
                $Office = getRows($Offices);
                if (isset($LabelClass[$Office[3]])) {
                    $ShowLabel = $LabelClass[$Office[3]];
                    $Status = $Office[3];
                } else {
                    $ShowLabel = 'label-info';
                    $Status = 'Uploading';
                }
                $TotalPP += $Office[2];
                $Queue = $Office[5] - $QueuePos;
                if (($Queue < 0) || ($Status != 'Uploaded')) {
                    $Queue = '';
                    $TokenID = '';
                } else {
                    $Queue = '<span class="label label-success pull-right">Queue# ' . ($Queue+1) . '</span>';
                    $TokenID = '<span class="badge pull-right">Token #' . $Office[5] . '</span>';
                }
                $dateTime = new DateTime($Office[4], new DateTimeZone('GMT'));

                date_default_timezone_set('Asia/Kolkata');

                ?>
                <tr>
                    <td><?php echo $i + 1;?></td>
                    <td><?php echo $Office[0]?><span class="badge pull-right"><?php echo $Office[2]?></span></td>
                    <td><?php echo $Office[1].$Queue;?>
                        <span class="label <?php echo $ShowLabel; ?> pull-right">
                            <?php echo $Status;?>
                        </span>
                    </td>
                    <td><?php echo $TokenID.date("d-m-Y h:i:s A", $dateTime->format('U'))?></td>
                </tr>
            <?php endfor; ?>
            </tbody>
            <tfoot>
            <tr>
                <th colspan="2">
                    <span class="pull-right">Total Polling Personnel: <?php echo $TotalPP; ?></span>
                </th>
                <td></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#remove").remove();

        $('#dlgToken').on('show.bs.modal', function (e) {
            alert("Hi");
            if ($('#OfficeCode').length < 8) {
                return e.preventDefault(); // stops modal from being shown
            }
        });
    });
</script>
</body>
</html>