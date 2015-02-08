<div class="panel panel-info">
    <div class="panel-heading">
        <h3>            
            <span class="glyphicon glyphicon-link"></span>
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

        <?php if ($projectAnalyser->isEnable('histo', true)) { ?>
        <br>
        <a href="histo.php" target="_blank">
            <?=$projectAnalyser->getLabel('link.histo')?>
        </a>
        <?php } ?>

        <br>
        <a href="phpinfo.php" target="_blank">
            <?=$projectAnalyser->getLabel('link.phpinfo')?>
        </a>
        <hr>
        <a href="<?=$projectAnalyser->getParam('gitlabURL')?>" target="_blank">
            <?=$projectAnalyser->getLabel('link.gitLabAccess')?>
        </a>
        <br>
    </div>
</div>