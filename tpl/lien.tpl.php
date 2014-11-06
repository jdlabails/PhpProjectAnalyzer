<div class="panel panel-info">
    <div class="panel-heading">
        <h3>
            <?=$projectAnalyser->getLabel('link.link')?>
        </h3>
        <div style=" font-size: 75%;color: #777;">
            <?=$projectAnalyser->getLabel('link.tools')?>
        </div>
    </div>
    <div class="panel-body" style="line-height: 30px">
        <a href="reports/TEST/phpUnitReport/dashboard.html" target="_blank">
            <?=$projectAnalyser->getLabel('link.coverageReport')?>
        </a>
        <br>
        <?php if ($projectAnalyser->isEnable('docs')) { ?>
        <a href="reports/DOCS/index.html" target="_blank">
            <?=$projectAnalyser->getLabel('link.phpDoc')?>
        </a>
        <?php } ?>
        <hr>
        <a href="<?=$projectAnalyser->getParam('gitlabURL')?>" target="_blank">
            <?=$projectAnalyser->getLabel('link.gitLabAccess')?>
        </a>
        <br>
    </div>
</div>