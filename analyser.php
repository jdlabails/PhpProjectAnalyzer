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

// on lance l'analyse
$sm = new scriptManager();
$res = $sm->lancerAnalyse();
die($res);
