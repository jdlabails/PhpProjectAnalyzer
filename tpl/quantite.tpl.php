<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Quantité</h3>
        <div style=" font-size: 75%;color: #777;">
            Contenu du dossier src uniquement
        </div>
    </div>
    <div class="panel-body">
        <ul class="list-group">
            <?php if ($projectAnalyser->isEnable('count')) { ?>
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
            <?php } ?>

            <?php if ($projectAnalyser->isEnable('loc')) { ?>
            <li class="list-group-item">
                <span class="badge alert-info">
                    <?=$projectAnalyser->extractFromLoc('namespaces')?>
                </span>
                Namespaces
            </li>
            <li class="list-group-item">
                <span class="badge alert-info">
                    <?=$projectAnalyser->extractFromLoc('classes')?>
                </span>
                Classes
            </li>
            <li class="list-group-item">
                <span class="badge alert-info">
                    <?=$projectAnalyser->extractFromLoc('methods')?>
                </span>
                Méthodes
            </li>
            <li class="list-group-item">
                <span class="badge alert-info">
                    <?=$projectAnalyser->extractFromLoc('loc');?>
                </span>
                Lignes de code
            </li>
            <?php } ?>
        </ul>
    </div>
</div>