
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
                    
                <span class="dropdown optionsTool">
                    <button class="btn btn-default dropdown-toggle optionsTool" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <span class="glyphicon glyphicon-option-vertical"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#" data-toggle="modal" data-target="#rapport_test">
                                <span class="glyphicon glyphicon-eye-open"></span><?=$projectAnalyser->getLabel('outil.detail')?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-repeat"></span> <?=$projectAnalyser->getLabel('outil.relancer')?>
                            </a>
                        </li>                        
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#"  data-toggle="modal" data-target="#cmd_test">
                                <span class="glyphicon glyphicon-info-sign"></span> <?=$projectAnalyser->getLabel('outil.cmd.lancee')?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-console" ></span><?=$projectAnalyser->getLabel('outil.cmd.manuelle')?>
                            </a>
                        </li>
                    </ul>
                </span>

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
                <span class="dropdown optionsTool">
                    <button class="btn btn-default dropdown-toggle optionsTool" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <span class="glyphicon glyphicon-option-vertical"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-fullscreen"></span>Voir rapport
                            </a>
                        </li>                        
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-edit"></span> Commande lancée
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-repeat"></span> Relancer
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-hand-up"></span> Commande de lancement manuelle
                            </a>
                        </li>
                    </ul>
                </span>
            </li>
            <li class="list-group-item">
                <label><?=$projectAnalyser->getLabel('quality.cc10')?></label>
                <span class="badge alert-warning"><?=$_quality_info['cc10']?></span>
                <span class="dropdown optionsTool">
                    <button class="btn btn-default dropdown-toggle optionsTool" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <span class="glyphicon glyphicon-option-vertical"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-fullscreen" ></span>Voir rapport
                            </a>
                        </li>                        
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-edit" ></span> Commande lancée
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-repeat" ></span> Relancer
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-hand-up" ></span> Commande de lancement manuelle
                            </a>
                        </li>
                    </ul>
                </span>
            </li>
            <li class="list-group-item">
                <label><?=$projectAnalyser->getLabel('quality.ccMethod')?></label>
                <span class="badge alert-success value">
                    <?=number_format((float)$projectAnalyser->extractFromXmlReport('ccnByNom', '/LOC/phploc.xml'), 2, ',', ' ')?>
                </span>
                <span class="dropdown optionsTool" style="width:10%">
                    
                </span>
                
                
            </li>
            
            <?php } ?>

            <?php if ($projectAnalyser->isEnable('cpd')) { ?>
            <li class="list-group-item">
                <label><?=$projectAnalyser->getLabel('quality.copyPaste')?></label>
                <?=$projectAnalyser->afficheSummary($_quality_info['CPD']['summary']); ?>
                
                <span class="dropdown optionsTool">
                    <button class="btn btn-default dropdown-toggle optionsTool" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <span class="glyphicon glyphicon-option-vertical"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">
                            <span class="glyphicon glyphicon-fullscreen" ></span>Voir détail</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                    </ul>
                </span>
                
            </li>                
            <?php } ?>

            <?php if ($projectAnalyser->isEnable('cs', true)) { ?>
            
            <li class="list-group-item">
                <label>
                    <?=$projectAnalyser->getLabel('quality.codeSniffer')?>
                    (<?=$projectAnalyser->getParam('cs', 'standard')?>)
                </label>                
                
                <?=$projectAnalyser->afficheSummary($_quality_info['CS']['summary']); ?>
                
                <span class="dropdown optionsTool">
                    <button class="btn btn-default dropdown-toggle optionsTool" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <span class="glyphicon glyphicon-option-vertical"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-fullscreen" ></span>Voir détail
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-repeat" ></span> Relancer
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-wrench" ></span> Commande de réparation
                            </a>
                        </li>
                    </ul>
                </span>
            </li>
            <?php } ?>
        </ul>
        <?=$projectAnalyser->getLabel('quality.defineCC')?>

    </div>
</div>