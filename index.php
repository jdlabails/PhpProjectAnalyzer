
<?php

ini_set('display_errors', 1);

require_once "assets/php/projectAnalyser.class.php";
require_once "assets/php/Spyc.php";

$analyseEnCours = file_exists(__DIR__.'/jetonAnalyse');

$_parameters        = Spyc::YAMLLoad('assets/param.yml');
$projectAnalyser    = new projectAnalyser($_parameters);
$_count             = $projectAnalyser->getCount();
$_derniereAnalyse   = $projectAnalyser->getAnalyseInfo();
$_quality_info      = $projectAnalyser->getQualityInfo();
$_testInfo          = $projectAnalyser->exploitTestReport();
$_reportInfo        = $projectAnalyser->getReportInfo();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Project Analyser</title>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="assets/js/jquery-2.1.0.min.js" type="text/javascript"></script>
        <script src="assets/js/pa.js" type="text/javascript"></script>
        <link href="assets/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
        <link href="assets/css/pa.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row"><?php include('tpl/header.tpl.php'); ?></div>

            <div class="row">
                <div class="col-md-4"><?php include('tpl/quantite.tpl.php'); ?></div>

                <div class="col-md-4"><?php include('tpl/qualite.tpl.php'); ?></div>

                <div class="col-md-4">
                    <?php include('tpl/lien.tpl.php'); ?>
                    <?php include('tpl/lanceur.tpl.php'); ?>
                    <?php include('tpl/btnDetail.tpl.php'); ?>
                </div>
            </div>

            <div class="row" id="detail" style="display: none">
                <?php include('tpl/detail.tpl.php'); ?>
            </div>
        </div>
    </body>

    <?php if($analyseEnCours) { ?>
        <script>
        $('document').ready(function () {
            refreshLanceur();
        });
        </script>
    <?php } ?>
</html>
