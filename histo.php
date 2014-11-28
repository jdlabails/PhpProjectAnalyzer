
<?php

ini_set('display_errors', 1);

require_once "assets/php/projectAnalyser.class.php";
require_once "assets/php/analyze.class.php";
require_once "assets/php/Spyc.php";

$projectAnalyser    = new projectAnalyser();
$_quality_info      = $projectAnalyser->getQualityInfo();
$_testInfo          = $projectAnalyser->exploitTestReport();
$_reportInfo        = $projectAnalyser->getReportInfo();
$_note              = $projectAnalyser->getNote($_quality_info, $_testInfo);

$a = new analyze();
$a = $projectAnalyser->getAnalyze();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Php Project Analyser : historique</title>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="assets/js/jquery-2.1.0.min.js" type="text/javascript"></script>
        <script src="assets/js/tooltip.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/js/highcharts.js" type="text/javascript"></script>
        <script src="assets/js/histo.js" type="text/javascript"></script>
        <link href="assets/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
        <link href="assets/css/pa.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row"><?php include('tpl/header.tpl.php'); ?></div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div id="successAnalysis" style="width:100%; height:400px;"></div>
                </div>
                <div class="col-md-6">
                    <div id="quantite" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>
    </body>

    <script>

            <?php
            $res = $projectAnalyser->getAnalyses();
            $dataLoc = 'dataLoc = [';
            $dataNote = 'dataNote = [';
            $dataCov = 'dataCov = [';
            foreach ($projectAnalyser->getAnalyses() as $a) {
                $dataLoc .= '['.$a->getDateTimeUTC().','.$a->getLoc().'],';
                $dataNote .= '['.$a->getDateTimeUTC().','.$a->getScore().'],';
                if ($a->getCov() != '/') {
                    $dataCov .= '['.$a->getDateTimeUTC().',"'.$a->getCov().'"],';
                }
            }
            echo $dataLoc . '];';
            echo $dataNote . '];';
            echo $dataCov . '];';
            ?>

    </script>

</html>