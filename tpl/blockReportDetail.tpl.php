<div class="col-xs-12 col-md-6">
    <div class="panel panel-<?=$report['ok']?'success':'warning'?>">
        <div class="panel-heading">
            <h3 class="panel-title"><?=$title?></h3>
            <small><?=$report['date']?></small>
        </div>
        <div class="panel-body">
            <pre class="pre-scrollable"><?=$report['report']?></pre>
            <code><?=$report['cmd']?></code>
        </div>
    </div>
</div>