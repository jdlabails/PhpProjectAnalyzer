<?php

require_once __DIR__."/Spyc.php";

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

    function __construct()
    {
        $this->_dirRoot             = __DIR__.'/../../';
        $this->_paramPath           = $this->_dirRoot.'assets/param.yml';
        $this->_jetonAnalysePath    = $this->_dirRoot.'/jetons/jetonAnalyse';
        $this->_paShPath            = $this->_dirRoot.'assets/sh/pa.sh';
        $this->_tplShDirPath        = $this->_dirRoot.'assets/sh/init';

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

        // lancement unitaire
        if (filter_input(INPUT_POST, 'one') != '') {
            $this->_paShPath = $this->_dirRoot.'assets/sh/one/'.filter_input(INPUT_POST, 'one').'.sh';
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
        exec('nohup '.$cmd. ' > jetons/output.log 2> jetons/error.log &');

        return $txt.' lancée ('.$cmd.')';
    }

    /**
     * On creer le pa.sh selon les param
     */
    function creerAnalyses()
    {        
        $header = file_get_contents($this->_tplShDirPath.'/header.tpl.sh');
        $header = str_replace('%%%dir_src%%%', $this->_parameters['srcPath'], $header);
        $header = str_replace('%%%dir_pa%%%', $this->_parameters['paPath'], $header);

        $contentGlobalSh = $contentCSSh = $contentCbfSh = $header;
        
        if ($this->_parameters['count'] == 'true'){
            $contentGlobalSh .= file_get_contents($this->_tplShDirPath.'/count.tpl.sh');
        }

        if ($this->_parameters['cpd'] == 'true'){
            $contentGlobalSh .= file_get_contents($this->_tplShDirPath.'/cpd.tpl.sh');
        }

        if ($this->_parameters['cs']['enable'] == 'true'){
            $csContent = file_get_contents($this->_tplShDirPath.'/cs.tpl.sh');
            $cbfContent = file_get_contents($this->_tplShDirPath.'/cbf.tpl.sh');
            $std = 'PSR2';
            if (
                strpos($this->_parameters['cs']['standard'], 'PSR') !== null &&
                strlen($this->_parameters['cs']['standard']) < 8
                ) {
                $std = $this->_parameters['cs']['standard'];
            }

            $cbfContent = str_replace('%%%standard%%%', $std, $cbfContent);
            $csContent = str_replace('%%%standard%%%', $std, $csContent);
            $contentGlobalSh .= $csContent;
            
            $contentCSSh .= $csContent;
            $contentCSSh .= file_get_contents($this->_tplShDirPath.'/footer.tpl.sh');
            file_put_contents($this->_dirRoot.'assets/sh/one/cs.sh', $contentCSSh);
            
            $contentCbfSh .= $cbfContent;
            $contentCbfSh .= file_get_contents($this->_tplShDirPath.'/footer.tpl.sh');
            file_put_contents($this->_dirRoot.'assets/sh/one/cbf.sh', $contentCbfSh);
        }

        if ($this->_parameters['depend'] == 'true'){
            $contentGlobalSh .= file_get_contents($this->_tplShDirPath.'/depend.tpl.sh');
        }

        if ($this->_parameters['loc'] == 'true'){
            $contentGlobalSh .= file_get_contents($this->_tplShDirPath.'/loc.tpl.sh');
        }

        if ($this->_parameters['md']['enable'] == 'true'){
            $mdContent = file_get_contents($this->_tplShDirPath.'/md.tpl.sh');
            $contentGlobalSh .= str_replace('%%%rule_set%%%', $this->getMDRuleSet(), $mdContent);
        }

        if ($this->_parameters['docs'] == 'true'){
            $contentGlobalSh .= file_get_contents($this->_tplShDirPath.'/docs.tpl.sh');
        }

        if (
            $this->_parameters['test']['enable'] == 'true' &&
            $this->_parameters['test']['lib'] == 'phpunit'
            ){
            $testContent = file_get_contents($this->_tplShDirPath.'/phpunit.tpl.sh');
            $contentGlobalSh .= str_replace('%%%testsuite%%%', $this->_parameters['test']['testsuite'], $testContent);
        }

        $contentGlobalSh .= file_get_contents($this->_tplShDirPath.'/footer.tpl.sh');

        //echo '<pre>'.$contentGlobalSh.'</pre>';

        file_put_contents($this->_paShPath, $contentGlobalSh);
    }

    private function  getMDRuleSet()
    {
        $availableRule = array('cleancode', 'codesize', 'controversial', 'design', 'naming', 'unusedcode');
        $tabRule=[];

        foreach ($availableRule as $r) {
            if ($this->_parameters['md']['rules'][$r] == 'true')
            {
                $tabRule[]=$r;
            }
        }

        return implode(',', $tabRule);
    }
}
