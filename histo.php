
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
                    <div class="panel panel-info" style="margin: 9% 11%;">
                        <div class="panel-heading">
                            Période
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="dateDu" class="col-sm-2 control-label">Du</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control datePicker" id="dateDu" placeholder="Date de début">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dateAu" class="col-sm-2 control-label">Au</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control datePicker" id="dateAu" placeholder="Date de fin">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-default">Voir</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="successAnalysis" style="width:100%; height:400px;"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div id="quantite" style="width:100%; height:400px;"></div>
                </div>
                <div class="col-md-6">
                    <div id="successFail" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>
    </body>

    <script>

            <?php
            $res = $projectAnalyser->getAnalyses();
            $dataLoc    = 'dataLoc = [';
            $dataFile   = 'dataFile = [';
            $dataPhp    = 'dataPhp = [';
            $dataJS     = 'dataJS = [';
            $dataCSS    = 'dataCSS = [';
            $dataClasse = 'dataClasse = [';
            $dataCs     = 'dataCs = [';
            $dataTu     = 'dataTu = [';
            $dataNote   = 'dataNote = [';
            $dataCov    = 'dataCov = [';
            $success = 0;
            foreach ($projectAnalyser->getAnalyses() as $i => $a) {
                $dataLoc .= '['.$a->getDateTimeUTC().','.$a->getLoc().'],';
                $dataFile .= '['.$a->getDateTimeUTC().','.$a->getNbFile().'],';
                $dataPhp .= '['.$a->getDateTimeUTC().','.$a->getNbPhpFile().'],';
                $dataJS .= '['.$a->getDateTimeUTC().','.$a->getNbJSFile().'],';
                $dataCSS .= '['.$a->getDateTimeUTC().','.$a->getNbCSSFile().'],';
                $dataClasse .= '['.$a->getDateTimeUTC().','.$a->getNbClasses().'],';
                $dataCs .= '['.$a->getDateTimeUTC().','.$a->getCsSuccess().'],';
                $dataTu .= '['.$a->getDateTimeUTC().','.$a->getTuSuccess().'],';
                $dataNote .= '['.$a->getDateTimeUTC().','.$a->getScore().'],';
                if ($a->getCov() != '/') {
                    $dataCov .= '['.$a->getDateTimeUTC().',"'.$a->getCov().'"],';
                }

                $success += $a->getTuSuccess();
            }
            $successPart = 100 * $success / $i;

            echo 'successPart = '.$successPart.';';

            echo $dataLoc . '];';
            echo $dataFile . '];';
            echo $dataPhp . '];';
            echo $dataJS . '];';
            echo $dataCSS . '];';
            echo $dataClasse . '];';
            echo $dataCs . '];';
            echo $dataTu . '];';
            echo $dataNote . '];';
            echo $dataCov . '];';
            ?>

    </script>

</html>
