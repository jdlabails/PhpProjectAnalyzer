<div class="modal fade" aria-hidden="true" id="cmdManuelle_<?=$idAnalyse?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="panel-title"><?=$title?></h3>
                <small><?=$report['date']?></small>
            </div>
            <div class="modal-body">
                <div class="panel-heading">
                    <h3 class="panel-title">Voici la commande à lancer</h3>
                    <small>Copier la telle quelle dans un terminal</small>
                </div>
                <div class="panel-body">
                    <code><?=nl2br($report['cmdManuelle'])?></code>
                </div>              
            </div>
            <div class="modal-footer">
                <button  type="button" class="btn btn-warning" onclick="$('#cmdManuelle_<?=$idAnalyse?>').modal('hide');lancerUneAnalyse('<?=$idAnalyse?>')">Relancer</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
