<div class="panel panel-primary">
    <div class="panel-heading"><h3>Lanceur</h3></div>
    <div class="panel-body">
        <div id="formLanceur" style="display: <?=$analyseEnCours?'none':'block'?>" >
            <form action="index.php" onsubmit="return lancerAnalyse();">
                <?php if ($projectAnalyser->isEnable('docs')) { ?>
                <div class="checkbox">
                    <label>
                      <input type="checkbox" name="genDoc" id="genDoc" value="1"> Générer la doc
                    </label>
                </div>
                <?php } ?>

                <div class="checkbox">
                    <label>
                      <input type="checkbox" name="genCC" id="genCC" value="1"> Générer le code coverage
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Lancer l'analyse</button>
                <div id="resAnalyse" style="float: right"></div>
            </form>
        </div>
        <div id="refreshLanceur" style="text-align:center;display: <?=$analyseEnCours?'block':'none'?>">
            <div style="float:left;margin: 10% 0;width: 155px;">
                Analyse en cours. Veuillez patienter...
            </div>
            <img src="assets/img/loading.gif" style="width:100px;float: right;margin:10px 24px" >
        </div>
        <div id="rechargePage" style="text-align:center;display: none">
            Analyse terminée, rafraichissez la page.
            <br><br>
            <button onclick="javascript:location.reload();" class="btn btn-success">Rafraichir la page</button>
        </div>
    </div>
</div>