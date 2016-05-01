<?php

namespace JD\PhpProjectAnalyzer\Classes;

use JD\PhpProjectAnalyzer\Traits;

/**
 * scriptManager s'occupe de générer et de lancer le script d'analyse
 *
 * @author Jean-David Labails <jd.labails@gmail.com>
 */
class ScriptManager
{
    use Traits\ScriptBuilder, Traits\ParamReader;

    private $dirRoot;
    private $parameters;
    private $jetonAnalysePath;
    private $paShPath;
    private $paramPath;
    private $tplShDirPath;
    private $phpDirPath;


    function __construct($parameters)
    {
        $this->dirRoot             = __DIR__.'/../../';
        $this->paramPath           = $this->dirRoot.'core/param.yml';
        $this->jetonAnalysePath    = $this->dirRoot.'generated/jetons/jetonAnalyse';
        $this->paShPath            = $this->dirRoot.'generated/sh/pa.sh';
        $this->shDirPath           = $this->dirRoot.'generated/sh';
        $this->tplShDirPath        = $this->dirRoot.'tpl/sh';
        $this->phpDirPath          = $this->dirRoot.'generated/php';

        $this->parameters          = $parameters;
    }

    function lancerAnalyse()
    {
        // si une analyse est en cours on dégage
        if (file_exists($this->jetonAnalysePath)) {
            return 'Analyse en cours';
        }

        // si on demande ou on en est et qu'on s'est pas encore fait degagé alors c fini
        if (filter_input(INPUT_GET, 'statut') == 1) {
            return 'ok';
        }

        // si on arrive là on doit lancer l'analyse selon la config
        $this->creerAnalyses();

        // lancement unitaire : le sh à lancer n'est pas la meme
        if (filter_input(INPUT_POST, 'one') != '') {
            $this->paShPath = $this->dirRoot.'generated/sh/one/'.filter_input(INPUT_POST, 'one').'.sh';
        }

        // on vérifie qu'on peut executer le sh
        if(!is_executable($this->paShPath)) {
            chmod($this->paShPath, 0777);
            if(!is_executable($this->paShPath)) {
                return basename($this->paShPath).' non executable';
            }
        }

        // on init le text de feedback
        $txt = 'Analyse ';

        // on init la commande
        $cmd = $this->paShPath;

        // on gere les options
        if (filter_input(INPUT_POST, 'genDoc') == 1) {
            $cmd.=' -d ';
            $txt .= ' avec génération de doc ';
        }

        if (filter_input(INPUT_POST, 'genCC') == 1) {
            $cmd.=' -c ';
            $txt .= 'avec code coverage';
        }

        // on lance l'analyse, c'est à dire le sh
        exec('nohup '.$cmd. ' > generated/jetons/output.log 2> generated/jetons/error.log &');

        return $txt.' lancée ('.$cmd.')';
    }
}
