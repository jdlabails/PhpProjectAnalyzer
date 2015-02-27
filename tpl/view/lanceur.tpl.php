<div class="panel panel-primary">
    <div class="panel-heading">
        <h3>            
            <span class="glyphicon glyphicon-cog"></span>
            <?=$projectAnalyser->getLabel('launcher.launcher')?>
        </h3>
        <div style=" font-size: 75%;color: white;">
            <?=$projectAnalyser->getLabel('launcher.baseline')?>
        </div>
    </div>
    <div class="panel-body">
        <div id="formLanceur" style="display: <?=$projectAnalyser->isAnalyzeInProgress()?'none':'block'?>" >
            <form action="index.php" onsubmit="return lancerAnalyse();">
                <?php if ($projectAnalyser->isEnable('docs')) { ?>
                <div class="checkbox">
                    <label>
                      <input type="checkbox" name="genDoc" id="genDoc" value="1">
                      <?=$projectAnalyser->getLabel('launcher.generateDoc')?>
                    </label>
                </div>
                <?php } ?>

                <div class="checkbox">
                    <label>
                      <input type="checkbox" name="genCC" id="genCC" value="1">
                      <?=$projectAnalyser->getLabel('launcher.generateCoverage')?>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">
                    <?=$projectAnalyser->getLabel('launcher.launch')?>
                </button>
                <div id="resAnalyse" style="float: right"></div>
            </form>
        </div>
        <div id="refreshLanceur" style="text-align:center;display: <?=$projectAnalyser->isAnalyzeInProgress()?'block':'none'?>">
            <div style="float:left;margin: 10% 0;width: 155px;">
                <?=$projectAnalyser->getLabel('launcher.analyzeInProgress')?>
            </div>
            <img src="assets/img/loading.gif" style="width:100px;float: right;margin:10px 24px" >
        </div>
        <div id="rechargePage" style="text-align:center;display: none">
            <?=$projectAnalyser->getLabel('launcher.analyzeFinished')?>
            <br><br>
            <button onclick="javascript:location.reload();" class="btn btn-success">
                <?=$projectAnalyser->getLabel('launcher.refresh')?>
            </button>
        </div>
    </div>
</div>