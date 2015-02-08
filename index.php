
<?php require_once "assets/php/inc.php"; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Php Project Analyser</title>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="assets/js/jquery-2.1.0.min.js" type="text/javascript"></script>
        <script src="assets/js/tooltip.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/js/pa.js" type="text/javascript"></script>
        <link href="assets/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
        <link href="assets/css/pa.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row"><?php include('tpl/header.tpl.php'); ?></div>
            <br>
            <div class="row">
                <div class="col-md-4"><?php include('tpl/quantite.tpl.php'); ?></div>

                <div class="col-md-4"><?php include('tpl/qualite.tpl.php'); ?></div>

                <div class="col-md-2">                    
                    <?php 
                    include('tpl/lanceur.tpl.php'); 
                    include('tpl/btnDetail.tpl.php'); 
                    ?>
                </div>
                 <div class="col-md-2">                    
                    <?php include('tpl/lien.tpl.php');?>
                </div>
            </div>

            <div class="row">
                <?php include('tpl/detail.tpl.php'); ?>
            </div>
        </div>
    </body>

    <?php if($projectAnalyser->isAnalyzeInProgress()) { ?>
        <script>
        $('document').ready(function () {
            refreshLanceur();
        });
        </script>
    <?php } ?>
</html>
