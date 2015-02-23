<?php

$tabAvailableAnalysis = array(
    'test'      => 'Tests fonctionnels et unitaires',
    'md'        => 'PhpMD : Mess Detector',
    'cpd'       => 'CPD : Copy-Paste Detector',
    'cs'        => 'CS : Code Sniffer',
    'loc'       => 'PhpLoc : Statistic',
    'docs'      => 'PhpDoc : Documentation',
    'depend'    => 'PhpDepend : Métriques d\'analyse'
);

foreach ($tabAvailableAnalysis as $idAnalyse => $title) {
    if ($projectAnalyser->isEnable($idAnalyse, true)) {
        $report = ($idAnalyse == 'test') ? $_testInfo : $_reportInfo[strtoupper($idAnalyse)];
        include('tpl/blockReportDetail.tpl.php');        
        include('tpl/modal/rapport.tpl.php');
        include('tpl/modal/cmd.tpl.php');
        include('tpl/modal/cmdManuelle.tpl.php');
        if ($idAnalyse == 'cs') {
            include('tpl/modal/cmdRep.tpl.php');            
        }
    }
}
