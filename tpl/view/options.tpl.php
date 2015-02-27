<span class="dropdown optionsTool">
    <button class="btn btn-default dropdown-toggle optionsTool" type="button" id="dropdownMenu<?=$idAnalyse?>" data-toggle="dropdown" aria-expanded="true">
        <span class="glyphicon glyphicon-option-vertical"></span>
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu<?=$idAnalyse?>">
        <li role="presentation">
            <a role="menuitem" tabindex="-1" href="#" data-toggle="modal" data-target="#rapport_<?=$idAnalyse?>">
                <span class="glyphicon glyphicon-eye-open"></span><?=$projectAnalyser->getLabel('outil.detail')?>
            </a>
        </li>
        <li role="presentation">
            <a role="menuitem" tabindex="-1" href="#" onclick="lancerUneAnalyse('<?=$idAnalyse?>')">
                <span class="glyphicon glyphicon-repeat"></span> <?=$projectAnalyser->getLabel('outil.relancer')?>
            </a>
        </li>                        
        <li role="presentation">
            <a role="menuitem" tabindex="-1" href="#" data-toggle="modal" data-target="#cmd_<?=$idAnalyse?>">
                <span class="glyphicon glyphicon-info-sign"></span> <?=$projectAnalyser->getLabel('outil.cmd.lancee')?>
            </a>
        </li>
        <li role="presentation">
            <a role="menuitem" tabindex="-1" href="#" data-toggle="modal" data-target="#cmdManuelle_<?=$idAnalyse?>">
                <span class="glyphicon glyphicon-console" ></span><?=$projectAnalyser->getLabel('outil.cmd.manuelle')?>
            </a>
        </li>
        <?php if ($idAnalyse == 'cs') { ?>
        <li role="presentation">
            <a role="menuitem" tabindex="-1" href="#" data-toggle="modal" data-target="#cmdRep_cs">
                <span class="glyphicon glyphicon-wrench" ></span> Commande de réparation
            </a>
        </li>
        <?php } ?>
    </ul>
</span>