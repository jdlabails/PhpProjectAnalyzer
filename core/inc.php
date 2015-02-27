<?php

ini_set('display_errors', 1);

foreach (glob('core/lib/*') as $filePath) {
    require_once $filePath;
}

foreach (glob('core/traits/*') as $filePath) {
    require_once $filePath;
}

foreach (glob('core/classes/*') as $filePath) {
    require_once $filePath;
}

/*
require_once "assets/php/visualizer.trait.php";
require_once "assets/php/scoreManager.trait.php";
require_once "assets/php/histoManager.trait.php";
require_once "assets/php/paramManager.trait.php";

require_once "assets/php/projectAnalyser.class.php";
require_once "assets/php/analyze.class.php";
require_once "assets/php/Spyc.php";
*/

$projectAnalyser    = new projectAnalyser();
$_quality_info      = $projectAnalyser->getQualityInfo();
$_testInfo          = $projectAnalyser->exploitTestReport();
$_reportInfo        = $projectAnalyser->getReportInfo();
$_note              = $projectAnalyser->getNote($_testInfo);

$a = new analyze();
$a = $projectAnalyser->getAnalyze();
