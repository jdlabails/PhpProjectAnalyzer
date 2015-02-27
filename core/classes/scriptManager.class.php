<?php

/**
 * scriptManager s'occupe de générer et de lancer le script d'analyse
 *
 * @author jd.labails
 */
class scriptManager
{
    private $_dirRoot;
    private $_parameters;
    private $_mustGenerate;
    private $_jetonAnalysePath;
    private $_paShPath;
    private $_paramPath;
    private $_tplShDirPath;
    private $_phpDirPath;

    use scriptBuilder, paramManager;

    function __construct()
    {
        $this->_dirRoot             = __DIR__.'/../../';
        $this->_paramPath           = $this->_dirRoot.'core/param.yml';
        $this->_jetonAnalysePath    = $this->_dirRoot.'generated/jetons/jetonAnalyse';
        $this->_paShPath            = $this->_dirRoot.'generated/sh/pa.sh';
        $this->_tplShDirPath        = $this->_dirRoot.'tpl/sh';
        $this->_phpDirPath          = $this->_dirRoot.'generated/php';

        $this->_parameters          = Spyc::YAMLLoad($this->_paramPath);

        $this->_mustGenerate        = !file_exists($this->_paShPath) || filemtime($this->_paShPath) < filemtime($this->_paramPath);
    }

    function lancerAnalyse()
    {
        // si une analyse est en cours on dégage
        if (file_exists($this->_jetonAnalysePath)) {
            return 'Analyse en cours';
        }

        // si on demande ou on en est et qu'on s'est pas encore fait degagé alors c fini
        if (filter_input(INPUT_GET, 'statut') == 1) {
            return 'ok';
        }

        // si on arrive là on doit lancer l'analyse selon la config
        if ($this->_mustGenerate) {
            $this->creerAnalyses();
        }

        // lancement unitaire : le sh à lancer n'est pas la meme
        if (filter_input(INPUT_POST, 'one') != '') {
            $this->_paShPath = $this->_dirRoot.'generated/sh/one/'.filter_input(INPUT_POST, 'one').'.sh';
        }

        // on vérifie qu'on peut executer le sh
        if(!is_executable($this->_paShPath)) {
            chmod($this->_paShPath, 0777);
            if(!is_executable($this->_paShPath)) {
                return basename($this->_paShPath).' non executable';
            }
        }

        // on init le text de feedback
        $txt = 'Analyse ';

        // on init la commande
        $cmd = $this->_paShPath;

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
