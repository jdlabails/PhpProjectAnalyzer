<div class="panel panel-<?=$_testInfo['ok']?'success':'danger'?>">
    <div class="panel-heading">
        <h3>Qualité</h3>
        <div style=" font-size: 75%;color: #777;">
            Robustesse et maintenabilité
        </div>
    </div>
    <div class="panel-body">
        <ul class="list-group">

            <?php if ($projectAnalyser->isEnable('test', true)) { ?>
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
                        <?php if ($_testInfo['dateTimeCC'] != $_testInfo['date']) { ?>
                        <br>
                        <div style=" font-size: 75%;color: red;">
                            <?=$_testInfo['dateTimeCC']?>
                        </div>
                        <?php } ?>
                    </li>
                </ul>
            </li>
            <?php } ?>

            <?php if ($projectAnalyser->isEnable('md', true)) { ?>
            <li class="list-group-item">
                <?=$projectAnalyser->afficheSummary($_quality_info['MD']['summary']); ?>
                Mess Detector
            </li>
            <li class="list-group-item">
                <span class="badge alert-warning"><?=$_quality_info['cc10']?></span>
                Nb méthode avec CC* > 10
            </li>
            <li class="list-group-item">
                <span class="badge alert-success">
                    <?=number_format((float)$projectAnalyser->extractFromXmlReport('ccnByNom', '/LOC/phploc.xml'), 2, ',', ' ')?>
                </span>
                CC* / Nb Méthodes
            </li>
            <?php } ?>

            <?php if ($projectAnalyser->isEnable('cpd')) { ?>
            <li class="list-group-item">
                <?=$projectAnalyser->afficheSummary($_quality_info['CPD']['summary']); ?>
                Copy-Paste
            </li>
            <?php } ?>

            <?php if ($projectAnalyser->isEnable('cs', true)) { ?>
            <li class="list-group-item">
                <?=$projectAnalyser->afficheSummary($_quality_info['CS']['summary']); ?>
                Code Sniffer (<?=$projectAnalyser->getParam('cs', 'standard')?>)
            </li>
            <?php } ?>
        </ul>
        *CC : Complexité Cyclomatique
    </div>
</div>