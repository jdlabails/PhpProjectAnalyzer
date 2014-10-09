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
        $this->_jetonAnalysePath    = $this->_dirRoot.'jetonAnalyse';
        $this->_paShPath            = $this->_dirRoot.'assets/sh/pa.sh';
        $this->_tplShDirPath        = $this->_dirRoot.'assets/sh/init';

        $this->_parameters          = Spyc::YAMLLoad($this->_paramPath);

        $this->_mustGenerate        = filemtime($this->_paShPath) < filemtime($this->_paramPath);
    }

    function lancerAnalyse()
    {
        if (file_exists($this->_jetonAnalysePath)) {
            return 'Analyse en cours';
        }

        if (filter_input(INPUT_GET, 'statut') == 1) {
            return 'ok';
        }

        // si on arrive là on doit lancer l'analyse selon la config
        if ($this->_mustGenerate) {
            $this->creerAnalyse();
        }

        // on vérifie qu'on peut executer le sh
        if(!is_executable($this->_paShPath)) {
            chmod($this->_paShPath, 0777);
            if(!is_executable($this->_paShPath)) {
                return 'pa.sh non executable';
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
        exec('nohup '.$cmd. ' > /dev/null  &');

        return $txt.' lancée ('.$cmd.')';
    }

    /**
     * On creer le pa.sh selon les param
     */
    function creerAnalyse()
    {
        $contentSh = '';

        $header = file_get_contents($this->_tplShDirPath.'/header.tpl.sh');
        $header = str_replace('%%%dir_src%%%', $this->_parameters['srcPath'], $header);
        $contentSh .= str_replace('%%%dir_pa%%%', $this->_parameters['paPath'], $header);

        if ($this->_parameters['count'] == 'true'){
            $contentSh .= file_get_contents($this->_tplShDirPath.'/count.tpl.sh');
        }

        if ($this->_parameters['cpd'] == 'true'){
            $contentSh .= file_get_contents($this->_tplShDirPath.'/cpd.tpl.sh');
        }

        if ($this->_parameters['cs']['enable'] == 'true'){
            $csContent = file_get_contents($this->_tplShDirPath.'/cs.tpl.sh');
            $std = 'PSR2';
            if (
                strpos($this->_parameters['cs']['standard'], 'PSR') !== null &&
                strlen($this->_parameters['cs']['standard']) < 8
                ) {
                $std = $this->_parameters['cs']['standard'];
            }

            $contentSh .= str_replace('%%%standard%%%', $std, $csContent);
        }

        if ($this->_parameters['depend'] == 'true'){
            $contentSh .= file_get_contents($this->_tplShDirPath.'/depend.tpl.sh');
        }

        if ($this->_parameters['loc'] == 'true'){
            $contentSh .= file_get_contents($this->_tplShDirPath.'/loc.tpl.sh');
        }

        if ($this->_parameters['md']['enable'] == 'true'){
            $mdContent = file_get_contents($this->_tplShDirPath.'/md.tpl.sh');
            $contentSh .= str_replace('%%%rule_set%%%', $this->getMDRuleSet(), $mdContent);
        }

        if ($this->_parameters['docs'] == 'true'){
            $contentSh .= file_get_contents($this->_tplShDirPath.'/docs.tpl.sh');
        }

        if (
            $this->_parameters['test']['enable'] == 'true' &&
            $this->_parameters['test']['lib'] == 'phpunit'
            ){
            $testContent = file_get_contents($this->_tplShDirPath.'/phpunit.tpl.sh');
            $contentSh .= str_replace('%%%testsuite%%%', $this->_parameters['test']['testsuite'], $testContent);
        }

        $contentSh .= file_get_contents($this->_tplShDirPath.'/footer.tpl.sh');

        //echo '<pre>'.$contentSh.'</pre>';

        file_put_contents($this->_paShPath, $contentSh);
    }

    private function  getMDRuleSet()
    {
        $availableRule = array('codeclean', 'codesize', 'controversial', 'design', 'naming', 'unusedcode');
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
