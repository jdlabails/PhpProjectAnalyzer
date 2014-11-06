<div class="panel panel-<?=$_testInfo['ok']?'success':'danger'?>">
    <div class="panel-heading">
        <h3><?=$projectAnalyser->getLabel('quality.quality')?></h3>
        <div style=" font-size: 75%;color: #777;">
            <?=$projectAnalyser->getLabel('quality.baseline')?>
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

                <?=$projectAnalyser->getLabel('quality.testsTitle')?>

                <ul>
                    <li class="list-group-item">
                        <span class="badge alert-info"><?=$_testInfo['nbTest']?></span>
                        <?=$projectAnalyser->getLabel('quality.tests')?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge alert-info"><?=$_testInfo['nbAssertions']?></span>
                        <?=$projectAnalyser->getLabel('quality.assertions')?>
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
                        <?=$projectAnalyser->getLabel('quality.coverage')?>
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
                <?=$projectAnalyser->getLabel('quality.messDetector')?>
            </li>
            <li class="list-group-item">
                <span class="badge alert-warning"><?=$_quality_info['cc10']?></span>
                <?=$projectAnalyser->getLabel('quality.cc10')?>
            </li>
            <li class="list-group-item">
                <span class="badge alert-success">
                    <?=number_format((float)$projectAnalyser->extractFromXmlReport('ccnByNom', '/LOC/phploc.xml'), 2, ',', ' ')?>
                </span>
                <?=$projectAnalyser->getLabel('quality.ccMethod')?>
            </li>
            <?php } ?>

            <?php if ($projectAnalyser->isEnable('cpd')) { ?>
            <li class="list-group-item">
                <?=$projectAnalyser->afficheSummary($_quality_info['CPD']['summary']); ?>
                <?=$projectAnalyser->getLabel('quality.copyPaste')?>
            </li>
            <?php } ?>

            <?php if ($projectAnalyser->isEnable('cs', true)) { ?>
            <li class="list-group-item">
                <?=$projectAnalyser->afficheSummary($_quality_info['CS']['summary']); ?>
                <?=$projectAnalyser->getLabel('quality.codeSniffer')?>
                (<?=$projectAnalyser->getParam('cs', 'standard')?>)
            </li>
            <?php } ?>
        </ul>
        <?=$projectAnalyser->getLabel('quality.defineCC')?>

    </div>
</div>