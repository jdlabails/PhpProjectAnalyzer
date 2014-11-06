<div class="panel panel-default">
    <div class="panel-heading">
        <h3><?=$projectAnalyser->getLabel('quantity.quantity')?></h3>
        <div style=" font-size: 75%;color: #777;">
            <?=$projectAnalyser->getLabel('quantity.srcContent')?>
        </div>
    </div>
    <div class="panel-body">
        <ul class="list-group">
            <?php if ($projectAnalyser->isEnable('count')) { ?>
            <li class="list-group-item">
                <span class="badge alert-info"><?=$_count['nbBundle']?></span>
                <?=$projectAnalyser->getLabel('quantity.bundles')?>
            </li>
            <li class="list-group-item">
                <span class="badge alert-info"><?=$_count['nbDossier']?></span>
                <?=$projectAnalyser->getLabel('quantity.directories')?>
            </li>
            <li class="list-group-item">
                <span class="badge alert-info"><?=$_count['nbFichier']?></span>
                <?=$projectAnalyser->getLabel('quantity.files')?>
                <ul>
                    <li class="list-group-item">
                        <span class="badge"><?=$_count['nbPHP']?></span>
                        <?=$projectAnalyser->getLabel('quantity.PHP')?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?=$_count['nbCSS']?></span>
                        <?=$projectAnalyser->getLabel('quantity.CSS')?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge alert-warning"><?=$_count['nbLibCSS']?></span>
                        <?=$projectAnalyser->getLabel('quantity.libCSS')?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?=$_count['nbJS']?></span>
                        <?=$projectAnalyser->getLabel('quantity.JS')?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge alert-warning"><?=$_count['nbLibJS']?></span>
                        <?=$projectAnalyser->getLabel('quantity.libJS')?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?=$_count['nbTwig']?></span>
                        <?=$projectAnalyser->getLabel('quantity.twig')?>
                    </li>
                </ul>
            </li>
            <?php } ?>

            <?php if ($projectAnalyser->isEnable('loc')) { ?>
            <li class="list-group-item">
                <span class="badge alert-info">
                    <?=$projectAnalyser->extractFromLoc('namespaces')?>
                </span>
                <?=$projectAnalyser->getLabel('quantity.namespaces')?>
            </li>
            <li class="list-group-item">
                <span class="badge alert-info">
                    <?=$projectAnalyser->extractFromLoc('classes')?>
                </span>
                <?=$projectAnalyser->getLabel('quantity.classes')?>
            </li>
            <li class="list-group-item">
                <span class="badge alert-info">
                    <?=$projectAnalyser->extractFromLoc('methods')?>
                </span>
                <?=$projectAnalyser->getLabel('quantity.methods')?>
            </li>
            <li class="list-group-item">
                <span class="badge alert-info">
                    <?=$projectAnalyser->extractFromLoc('loc');?>
                </span>
                <?=$projectAnalyser->getLabel('quantity.codeLines')?>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>