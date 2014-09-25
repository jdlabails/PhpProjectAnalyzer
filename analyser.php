<?php

$fileJetonName=__DIR__.'/jetonAnalyse';

if (file_exists($fileJetonName)) {
    die('Analyse en cours');
}

if (isset($_REQUEST['statut']) && $_REQUEST['statut'] == 1) {
    die('ok');
}

$cmd = __DIR__.'/assets/sh/pa.sh';

$txt = 'Analyse ';

if (isset($_REQUEST['genDoc']) && $_REQUEST['genDoc'] == 1) {
    $cmd.=' -d ';
    $txt .= ' avec génération de doc ';
}

if (isset($_REQUEST['genCC']) && $_REQUEST['genCC'] == 1) {
    $cmd.=' -c ';
    $txt .= 'avec code coverage';
}

exec('nohup '.$cmd. ' > /dev/null  &');

echo $txt.' lancée';
