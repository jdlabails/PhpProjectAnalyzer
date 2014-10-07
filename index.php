
<?php

ini_set('display_errors', 1);

require_once "assets/php/projectAnalyser.class.php";
require_once "assets/php/Spyc.php";

$analyseEnCours = file_exists(__DIR__.'/jetonAnalyse');

$_parameters        = Spyc::YAMLLoad('param.yml');
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
            <div class="row">
                <div class="col-md-8">
                    <h1>
                        Project Analyser : <?=$projectAnalyser->getParam('title')?>
                        <br>
                        <small><?=$projectAnalyser->getParam('description')?></small>
                    </h1>
                </div>
                <div class="col-md-4" style="margin-top:23px; font-size:20px">
                    <div class="label-<?=$_testInfo['ok']?'success':'danger'?>" id="encartResultat">
                        Dernière analyse : <?=$_derniereAnalyse['date']?>
                        <br>
                        Durée : <?=$_derniereAnalyse['time']?> secondes
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Quantité</h3>
                            <div style=" font-size: 75%;color: #777;">
                                Contenu du dossier src uniquement
                            </div>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span class="badge alert-info"><?=$_count['nbBundle']?></span>
                                    Bundles
                                </li>
                                <li class="list-group-item">
                                    <span class="badge alert-info"><?=$_count['nbDossier']?></span>
                                    Dossiers
                                </li>
                                <li class="list-group-item">
                                    <span class="badge alert-info"><?=$_count['nbFichier']?></span>
                                    Fichiers
                                    <ul>
                                        <li class="list-group-item">
                                            <span class="badge"><?=$_count['nbPHP']?></span>
                                            PHP
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge"><?=$_count['nbCSS']?></span>
                                            CSS (hors lib)
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge alert-warning"><?=$_count['nbLibCSS']?></span>
                                            Lib CSS
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge"><?=$_count['nbJS']?></span>
                                            JS (hors lib)
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge alert-warning"><?=$_count['nbLibJS']?></span>
                                            Lib JS
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge"><?=$_count['nbTwig']?></span>
                                            TWIG
                                        </li>
                                    </ul>
                                </li>
                                <li class="list-group-item">
                                    <span class="badge alert-info">
                                        <?=$projectAnalyser->extractFromXmlReport('namespaces', '/LOC/phploc.xml')?>
                                    </span>
                                    Namespaces
                                </li>
                                <li class="list-group-item">
                                    <span class="badge alert-info">
                                        <?=$projectAnalyser->extractFromXmlReport('classes', '/LOC/phploc.xml')?>
                                    </span>
                                    Classes
                                </li>
                                <li class="list-group-item">
                                    <span class="badge alert-info">
                                        <?=$projectAnalyser->extractFromXmlReport('methods', '/LOC/phploc.xml')?>
                                    </span>
                                    Méthodes
                                </li>
                                <li class="list-group-item">
                                    <span class="badge alert-info">
                                        <?=$projectAnalyser->extractFromXmlReport('loc', '/LOC/phploc.xml');?>
                                    </span>
                                    Lignes de code
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-<?=$_testInfo['ok']?'success':'danger'?>">
                        <div class="panel-heading">
                            <h3>Qualité</h3>
                            <div style=" font-size: 75%;color: #777;">
                                Robustesse et maintenabilité
                            </div>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">

                                <li class="list-group-item">
                                    <?php if ($_testInfo['ok'] === false) { ?>
                                        <span class="badge alert-danger">KO !!!</span>
                                    <?php } else { ?>
                                        <span class="badge alert-success">OK</span>
                                    <?php } ?>
                                    Tests unitaires et fonctionnels
                                    <ul>
                                        <li class="list-group-item">
                                            <span class="badge alert-info"><?=$_testInfo['nbTest']?></span>
                                            Tests
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge alert-info"><?=$_testInfo['nbAssertions']?></span>
                                            Assertions
                                        </li>
                                        <!--
                                        <li class="list-group-item">
                                            <span class="badge"><?=$_testInfo['exeTime']?></span>
                                            Temps d'exec
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge"><?=$_testInfo['exeMem']?></span>
                                            Mémoire utilisée
                                        </li>
                                        -->
                                        <li class="list-group-item">
                                            <span class="badge alert-success"><?=$_testInfo['ccLine']?></span>
                                            Couverture
                                            <?php if ($_testInfo['dateTimeCC'] != $_testInfo['dateTimeTest']) { ?>
                                            <br>
                                            <div style=" font-size: 75%;color: red;">
                                                <?=$_testInfo['dateTimeCC']?>
                                            </div>
                                            <?php } ?>
                                        </li>
                                    </ul>
                                </li>

                                <li class="list-group-item">
                                    <span class="badge alert-warning"><?=$_quality_info['cc10']?></span>
                                    Nb méthode avec CC* > 10
                                </li>
                                <li class="list-group-item">
                                    <span class="badge alert-success">
                                        <?=number_format((float)$projectAnalyser->extractFromXmlReport('ccnByNom', '/LOC/phploc.xml'), 2, ',', ' ')?>
                                    </span>
                                    CC* / Nb Méthodes</li>
                                <li class="list-group-item">
                                    <?=$projectAnalyser->afficheSummary($_quality_info['CPD']['summary']); ?>
                                    Copy-Paste
                                </li>
                                <li class="list-group-item">
                                    <?=$projectAnalyser->afficheSummary($_quality_info['CS']['summary']); ?>
                                    Code Sniffer (PSR2)
                                </li>
                                <li class="list-group-item">
                                    <?=$projectAnalyser->afficheSummary($_quality_info['MD']['summary']); ?>
                                    Mess Detector
                                </li>
                            </ul>
                            *CC : Complexité Cyclomatique
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3>Liens</h3>
                            <div style=" font-size: 75%;color: #777;">
                                Outils associés ou générés
                            </div>
                        </div>
                        <div class="panel-body" style="line-height: 30px">
                            <a href="reports/TEST/phpUnitReport/dashboard.html" target="_blanc">Rapport de code coverage</a>
                            <br>
                            <a href="reports/DOCS/index.html" target="_blanc">Documentation générée</a>
                            <hr>
                            <a href="<?=$projectAnalyser->getParam('gitlabURL')?>" target="_blank">Accès GitLab</a>
                            <br>
                        </div>
                    </div>

                    <div class="panel panel-primary">
                        <div class="panel-heading"><h3>Lanceur</h3></div>
                        <div class="panel-body">
                            <div id="formLanceur" style="display: <?=$analyseEnCours?'none':'block'?>" >
                                <form action="index.php" onsubmit="return lancerAnalyse();">
                                    <div class="checkbox">
                                        <label>
                                          <input type="checkbox" name="genDoc" id="genDoc" value="1"> Générer la doc
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                          <input type="checkbox" name="genCC" id="genCC" value="1"> Générer le code coverage
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Lancer l'analyse</button>
                                    <div id="resAnalyse" style="float: right"></div>
                                </form>
                            </div>
                            <div id="refreshLanceur" style="text-align:center;display: <?=$analyseEnCours?'block':'none'?>">
                                <div style="float:left;margin: 10% 0;width: 155px;">
                                    Analyse en cours. Veuillez patienter...
                                </div>
                                <img src="assets/img/loading.gif" style="width:100px;float: right;margin:10px 24px" >
                                <!--
                                <button onclick="refreshLanceur()" class="btn btn-primary">Rafraichir le statut</button>
                                -->
                            </div>
                            <div id="rechargePage" style="text-align:center;display: none">
                                Analyse terminée, rafraichissez la page.
                                <br><br>
                                <button onclick="javascript:location.reload();" class="btn btn-success">Rafraichir la page</button>
                            </div>
                        </div>
                    </div>

                    <div class="well well-sm"
                         onclick="$('#detail').toggle()"
                         style="background-color: white">
                        <h3 class="text-center">Voir les détails</h3>
                    </div>

                </div>
            </div>

            <div class="row" id="detail" style="display: none">

                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-<?=$_testInfo['ok']?'success':'danger'?>">
                        <div class="panel-heading">
                            <h3 class="panel-title">PhpUnit : Tests fonctionnels et unitaires</h3>
                            <small><?=$_testInfo['dateTimeTest']?></small>
                        </div>
                        <div class="panel-body">
                            <pre class="pre-scrollable"><?=$_testInfo['report']?></pre>
                            <code><?=$_testInfo['cmd']?></code>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-<?=$_reportInfo['MD']['ok']?'success':'warning'?>">
                        <div class="panel-heading">
                            <h3 class="panel-title">PhpMD : Mess Detector</h3>
                            <small><?=$_reportInfo['MD']['date']?></small>
                        </div>
                        <div class="panel-body">
                            <pre class="pre-scrollable"><?=$_reportInfo['MD']['report']?></pre>
                            <code><?=$_reportInfo['MD']['cmd']?></code>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-<?=$_reportInfo['CPD']['ok']?'success':'warning'?>">
                        <div class="panel-heading">
                            <h3 class="panel-title">CPD : Copy-Paste Detector</h3>
                            <small><?=$_reportInfo['CPD']['date']?></small>
                        </div>
                        <div class="panel-body">
                            <pre class="pre-scrollable"><?=$_reportInfo['CPD']['report']?></pre>
                            <code><?=$_reportInfo['CPD']['cmd']?></code>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-<?=$_reportInfo['CS']['ok']?'success':'warning'?>">
                        <div class="panel-heading">
                            <h3 class="panel-title">CS : Code Sniffer</h3>
                            <small><?=$_reportInfo['CS']['date']?></small>
                        </div>
                        <div class="panel-body">
                            <pre class="pre-scrollable"><?=$_reportInfo['CS']['report']?></pre>
                            <code><?=$_reportInfo['CS']['cmd']?></code>
                        </div>
                    </div>
                </div>

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

                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">PhpLoc : Statistic</h3>
                            <small><?=$_reportInfo['LOC']['date']?></small>
                        </div>
                        <div class="panel-body">
                            <pre class="pre-scrollable"><?=$_reportInfo['LOC']['report']?></pre>
                            <code><?=$_reportInfo['LOC']['cmd']?></code>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">PhpDoc : Documentation</h3>
                            <small><?=$_reportInfo['DOCS']['date']?></small>
                        </div>
                        <div class="panel-body">
                            <pre class="pre-scrollable"><?=$_reportInfo['DOCS']['report']?></pre>
                            <code><?=$_reportInfo['DOCS']['cmd']?></code>
                        </div>
                    </div>
                </div>
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
