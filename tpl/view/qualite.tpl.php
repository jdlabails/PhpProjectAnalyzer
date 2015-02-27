
<div class="panel panel-<?=$_testInfo['ok']?'success':'danger'?>">
    <div class="panel-heading">
        <h3>            
            <span class="glyphicon glyphicon-check"></span>
            <?=$projectAnalyser->getLabel('quality.quality')?>
        </h3>
        <div style=" font-size: 75%;color: #777;">
            <?=$projectAnalyser->getLabel('quality.baseline')?>
        </div>
    </div>
    <div class="panel-body">
        <ul class="list-group metrics">

            <?php if ($projectAnalyser->isEnable('test', true)) { ?>
            <li class="list-group-item">
                <label>
                    <?=$projectAnalyser->getLabel('quality.testsTitle')?>
                    <span class="badge outil">
                        <span onclick="$('#detailTest').toggle()" class="glyphicon glyphicon-search"></span>
                    </span>
                </label>                
                                
                <?php if ($_testInfo['ok'] === false) { ?>
                    <span class="badge alert-danger value">KO</span>
                <?php } else { ?>
                    <span class="badge alert-success value">OK</span>
                <?php } ?>
                    
                <?php $idAnalyse = 'test';include __DIR__.'/options.tpl.php'?>

                <ul id="detailTest" class="metricDetail">
                    <li class="list-group-item">                        
                        <label><?=$projectAnalyser->getLabel('quality.tests')?></label>
                        <span class="badge alert-info"><?=$_testInfo['nbTest']?></span>
                    </li>
                    <li class="list-group-item">
                        <label><?=$projectAnalyser->getLabel('quality.assertions')?></label>
                        <span class="badge alert-info"><?=$_testInfo['nbAssertions']?></span>
                    </li>
                    <li class="list-group-item">
                        <label><?=$projectAnalyser->getLabel('quality.coverage')?></label>
                        <span class="badge alert-success"><?=$_testInfo['ccLine']?></span>
                        <?php if ($_testInfo['dateTimeCC'] != $a->getReadableDateTime() ) { ?>
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
                <label><?=$projectAnalyser->getLabel('quality.messDetector')?></label>
                <?=$projectAnalyser->afficheSummary($_quality_info['MD']['summary']); ?>                
                <?php $idAnalyse = 'md';include __DIR__.'/options.tpl.php'?>
            </li>
            <li class="list-group-item">
                <label><?=$projectAnalyser->getLabel('quality.cc10')?></label>
                <span class="badge alert-warning"><?=$_quality_info['cc10']?></span>
                <span class="dropdown optionsTool">   </span>
            </li>
            <li class="list-group-item">
                <label><?=$projectAnalyser->getLabel('quality.ccMethod')?></label>
                <span class="badge alert-success value">
                    <?=number_format((float)$projectAnalyser->extractFromXmlReport('ccnByNom', '/LOC/phploc.xml'), 2, ',', ' ')?>
                </span>
                <span class="dropdown optionsTool">   </span>
            </li>            
            <?php } ?>

            <?php if ($projectAnalyser->isEnable('cpd')) { ?>
            <li class="list-group-item">
                <label><?=$projectAnalyser->getLabel('quality.copyPaste')?></label>
                <?=$projectAnalyser->afficheSummary($_quality_info['CPD']['summary']); ?>                              
                <?php $idAnalyse = 'cpd';include __DIR__.'/options.tpl.php'?>
            </li>                
            <?php } ?>

            <?php if ($projectAnalyser->isEnable('cs', true)) { ?>
            
            <li class="list-group-item">
                <label>
                    <?=$projectAnalyser->getLabel('quality.codeSniffer')?>
                    (<?=$projectAnalyser->getParam('cs', 'standard')?>)
                </label>     
                <?=$projectAnalyser->afficheSummary($_quality_info['CS']['summary']); ?>                                            
                <?php $idAnalyse = 'cs';include __DIR__.'/options.tpl.php'?>                
            </li>
            <?php } ?>
        </ul>
        <?=$projectAnalyser->getLabel('quality.defineCC')?>
    </div>
</div>