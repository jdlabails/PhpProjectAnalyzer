<div class="modal fade" aria-hidden="true" id="rapport_<?=$idAnalyse?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="panel-title"><?=$title?></h3>
                <small><?=$report['date']?></small>
            </div>
            <div class="modal-body">

            <div class="panel-body">
                <pre class="pre-scrollable"><?=$report['report']?></pre>
            </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" onclick="$('#rapport_<?=$idAnalyse?>').modal('hide');lancerUneAnalyse('<?=$idAnalyse?>')">Relancer</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
