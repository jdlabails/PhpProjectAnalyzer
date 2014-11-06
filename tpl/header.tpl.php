<div class="col-md-8">
    <h1>
        Project Analyzer : <?=$projectAnalyser->getParam('title')?>
        <br>
        <small><?=$projectAnalyser->getParam('description')?></small>
    </h1>
</div>
<div class="col-md-4" style="margin-top:23px; font-size:20px">
    <div class="label-<?=$_testInfo['ok']?'success':'danger'?>" id="encartResultat">
        <?=$projectAnalyser->getLabel('lastAnalyze')?> : <?=$_derniereAnalyse['date']?>
        <br>
        <?=$projectAnalyser->getLabel('duration')?> : <?=$_derniereAnalyse['time']?> <?=$projectAnalyser->getLabel('seconds')?>
    </div>
</div>