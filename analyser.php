<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__.'/assets/php/scriptManager.class.php';

// on lance l'analyse
$sm = new scriptManager();
$res = $sm->lancerAnalyse();
die($res);
