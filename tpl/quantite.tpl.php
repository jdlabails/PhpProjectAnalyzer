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
                <span class="badge alert-info"><?=$a->getNbBundles()?></span>
                <?=$projectAnalyser->getLabel('quantity.bundles')?>
            </li>
            <li class="list-group-item">
                <span class="badge alert-info"><?=$a->getNbDir()?></span>
                <?=$projectAnalyser->getLabel('quantity.directories')?>
            </li>
            <li class="list-group-item">
                <span class="badge alert-info"><?=$a->getNbfile()?></span>
                <?=$projectAnalyser->getLabel('quantity.files')?>
                <ul>
                    <li class="list-group-item">
                        <span class="badge"><?=$a->getNbPhpFile()?></span>
                        <?=$projectAnalyser->getLabel('quantity.PHP')?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?=$a->getNbCSSFile()?></span>
                        <?=$projectAnalyser->getLabel('quantity.CSS')?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge alert-warning"><?=$a->getNbCSSLib()?></span>
                        <?=$projectAnalyser->getLabel('quantity.libCSS')?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?=$a->getNbJSFile()?></span>
                        <?=$projectAnalyser->getLabel('quantity.JS')?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge alert-warning"><?=$a->getNbJSLib()?></span>
                        <?=$projectAnalyser->getLabel('quantity.libJS')?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?=$a->getNbTwig()?></span>
                        <?=$projectAnalyser->getLabel('quantity.twig')?>
                    </li>
                </ul>
            </li>

            <?php } ?>

            <?php if ($projectAnalyser->isEnable('loc')) { ?>

            <li class="list-group-item">
                <span class="badge alert-info"><?=$a->getNbNamespace()?></span>
                <?=$projectAnalyser->getLabel('quantity.namespaces')?>
            </li>
            <li class="list-group-item">
                <span class="badge alert-info"><?=$a->getNbClasses()?></span>
                <?=$projectAnalyser->getLabel('quantity.classes')?>
            </li>
            <li class="list-group-item">
                <span class="badge alert-info"><?=$a->getNbMethod()?></span>
                <?=$projectAnalyser->getLabel('quantity.methods')?>
            </li>
            <li class="list-group-item">
                <span class="badge alert-info"><?=$a->getLoc()?></span>
                <?=$projectAnalyser->getLabel('quantity.codeLines')?>
            </li>

            <?php } ?>
            
        </ul>
    </div>
</div>