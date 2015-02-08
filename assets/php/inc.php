<?php

ini_set('display_errors', 1);

require_once "assets/php/visualizer.trait.php";
require_once "assets/php/scoreManager.trait.php";
require_once "assets/php/histoManager.trait.php";
require_once "assets/php/paramManager.trait.php";

require_once "assets/php/projectAnalyser.class.php";
require_once "assets/php/analyze.class.php";
require_once "assets/php/Spyc.php";

$projectAnalyser    = new projectAnalyser();
$_quality_info      = $projectAnalyser->getQualityInfo();
$_testInfo          = $projectAnalyser->exploitTestReport();
$_reportInfo        = $projectAnalyser->getReportInfo();
$_note              = $projectAnalyser->getNote($_testInfo);

$a = new analyze();
$a = $projectAnalyser->getAnalyze();
