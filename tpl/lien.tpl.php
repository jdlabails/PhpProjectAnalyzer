<div class="panel panel-info">
    <div class="panel-heading">
        <h3>Liens</h3>
        <div style=" font-size: 75%;color: #777;">
            Outils associés ou générés
        </div>
    </div>
    <div class="panel-body" style="line-height: 30px">
        <a href="reports/TEST/phpUnitReport/dashboard.html" target="_blank">Rapport de code coverage</a>
        <br>
        <?php if ($projectAnalyser->isEnable('docs')) { ?>
        <a href="reports/DOCS/index.html" target="_blank">Documentation générée</a>
        <?php } ?>
        <hr>
        <a href="<?=$projectAnalyser->getParam('gitlabURL')?>" target="_blank">Accès GitLab</a>
        <br>
    </div>
</div>