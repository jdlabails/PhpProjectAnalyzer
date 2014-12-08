
<?php require_once "assets/php/inc.php"; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Php Project Analyser : historique</title>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="assets/js/jquery-2.1.0.min.js" type="text/javascript"></script>
        <script src="assets/js/tooltip.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/js/highcharts.js" type="text/javascript"></script>
        <script src="assets/js/histo.js" type="text/javascript"></script>
        <link href="assets/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
        <link href="assets/css/pa.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row"><?php include('tpl/header.tpl.php'); ?></div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-info" style="margin: 9% 11%;">
                        <div class="panel-heading">
                            Période
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="dateDu" class="col-sm-2 control-label">Du</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control datePicker" id="dateDu" placeholder="Date de début">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dateAu" class="col-sm-2 control-label">Au</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control datePicker" id="dateAu" placeholder="Date de fin">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-default">Voir</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="successAnalysis" style="width:100%; height:400px;"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div id="quantite" style="width:100%; height:400px;"></div>
                </div>
                <div class="col-md-6">
                    <div id="successFail" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>
    </body>

    <script>
        <?=$projectAnalyser->getTabJS4HistoGraph();?>
    </script>

</html>
