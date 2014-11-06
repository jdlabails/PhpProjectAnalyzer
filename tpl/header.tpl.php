<div class="col-md-8">
    <h1>
        Project Analyzer : <?=$projectAnalyser->getParam('title')?>
        <br>
        <small><?=$projectAnalyser->getParam('description')?></small>
    </h1>
</div>
<div class="col-md-4" style="margin-top:23px; font-size:20px">
    <div class="label-<?=$_testInfo['ok']?'success':'danger'?>" id="encartResultat">
        <table>
            <tr>
                <td><?=$projectAnalyser->getLabel('lastAnalyze')?></td>
                <td><?=$_derniereAnalyse['date']?></td>
            </tr>
            <tr>
                <td><?=$projectAnalyser->getLabel('duration')?></td>
                <td><?=$_derniereAnalyse['time']?></td>
            </tr>
            <?php if ($projectAnalyser->isScoreEnable()) { ?>
            <tr>
                <td><?=$projectAnalyser->getLabel('note')?></td>
                <td><?=$_note?> / 20</td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>