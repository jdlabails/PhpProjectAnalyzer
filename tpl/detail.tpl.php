<?php

$tabAvailableAnalysis = array(
    'test'  => 'PhpUnit : Tests fonctionnels et unitaires',
    'md'    => 'PhpMD : Mess Detector',
    'cpd'   => 'CPD : Copy-Paste Detector',
    'cs'    => 'CS : Code Sniffer',
    'loc'   => 'PhpLoc : Statistic',
    'docs'  => 'PhpDoc : Documentation'
);

foreach ($tabAvailableAnalysis as $idAnalyse => $title) {
    if ($projectAnalyser->isEnable($idAnalyse, true)) {
        $report = ($idAnalyse == 'test') ? $_testInfo : $_reportInfo[strtoupper($idAnalyse)];
        include('tpl/blockReportDetail.tpl.php');
    }
}


// cas particulier pour le depend
if ($projectAnalyser->isEnable('depend', true)) {

?>

<div class="col-xs-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">PhpDepend : Métriques d'analyse</h3>
            <small><?=$_reportInfo['DEPEND']['date']?></small>
        </div>
        <div class="panel-body">
            <pre class="pre-scrollable"><?=$_reportInfo['DEPEND']['report']?></pre>
            <code><?=$_reportInfo['DEPEND']['cmd']?></code>
            <!--<img src='DEPEND/jdepend.svg' width="90%">
            <img src='DEPEND/pyramid.svg' width="40%">

            <dl style="display: inline-table;text-align: right;width: 40%;">
                <dt>AHH</dt>
                <dd>
                    Average Hierarchy Height<br>
                    The average of the maximum lenght from a root class to ist deepest subclass subclass
                </dd>
                <dt>ANDC</dt>
                <dd>
                    Average Number of Derived Classes<br>
                    The average of direct subclasses of a class
                </dd>
                <dt>CALLS</dt>
                <dd>Number of Method or Function Calls</dd>
                <dt>CYCLO</dt>
                <dd>Cyclomatic Complexity Number</dd>
                <dt>Fanout</dt>
                <dd>Number of Fanout</dd>
                <dt>LOC</dt>
                <dd>Lines Of Code</dd>
                <dt>NOC</dt>
                <dd>Number of classes</dd>
                <dt>NOM</dt>
                <dd>Number of methods</dd>
                <dt>NOP</dt>
                <dd>Number of packages</dd>
            </dl>
            -->
        </div>
    </div>
</div>
<?php } ?>
