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
                <td><?=$projectAnalyser->getLabel('score.note')?></td>
                <td>
                <?=$_note?> / 20
                <img
                    src="assets/img/question.png"
                    class="help"
                    data-toggle="popover"
                    data-trigger="focus"
                    data-placement="left"
                    tabindex="0"
                    style="margin-left: 20px"
                    title="<?=$projectAnalyser->getLabel('score.popTitle')?>"
                    data-content="
                    <?=$projectAnalyser->getLabel('score.popContent.begin')?>

                    <ul>
                    <li>Code Sniffer score</li>
                    <li>Tests status X code coverage</li>
                    <li><?=$projectAnalyser->getLabel('score.popContent.sizeProject')?></li>
                    </ul>
                    <?=$projectAnalyser->getLabel('score.popContent.fitWeighting')?>
                    <hr>
                    <?=$projectAnalyser->getLabel('score.popContent.currentSet')?>
                    <ul>
                        <li>
                            <?=$projectAnalyser->getLabel('score.popContent.csWeight')?> :
                            <?=$projectAnalyser->getScoreWeightParam('csWeight')?>
                        </li>
                        <li>
                            <?=$projectAnalyser->getLabel('score.popContent.testWeight')?> :
                            <?=$projectAnalyser->getScoreWeightParam('testWeight')?>
                        </li>
                        <li>
                            <?=$projectAnalyser->getLabel('score.popContent.sizeWeight')?> :
                            <?=$projectAnalyser->getScoreWeightParam('locWeight')?>
                        </li>
                        <li>
                            <?=$projectAnalyser->getLabel('score.popContent.scale')?> :
                            <?=$projectAnalyser->getParam('score', 'projectSize')?>
                        </li>
                    </ul>
                    ">
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>