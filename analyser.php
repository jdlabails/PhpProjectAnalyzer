<?php

require_once "core/inc.php";

// on lance l'analyse
$sm = new JD\PhpProjectAnalyzer\Classes\ScriptManager($parameters);
echo $sm->lancerAnalyse();

return 1;
