<?php

/**
 * Description of scriptBuilder
 *
 * @author jd
 */
trait scriptBuilder
{
    
    private $header = '';
    
    /**
     * On creer le pa.sh selon les param
     */
    function creerAnalyses()
    {        
        $contentGlobalSh = $contentCSSh = $contentCbfSh = $this->getHeader();
        
        foreach ($this->_parameters as $idAnalyse => $param) {
            if ($this->isEnable($idAnalyse) && file_exists($this->_tplShDirPath.'/'.$idAnalyse.'.tpl.sh')) {
                $contentSh = '';
                switch ($idAnalyse) {
                    case 'md':
                        $contentSh = file_get_contents($this->_tplShDirPath.'/md.tpl.sh');
                        $contentSh .= str_replace('%%%rule_set%%%', $this->getMDRuleSet(), $contentSh);
                        break;
                    case 'test':
                        if ($this->_parameters['test']['lib'] == 'phpunit'){
                            $testContent = file_get_contents($this->_tplShDirPath.'/phpunit.tpl.sh');
                            $contentSh = str_replace('%%%testsuite%%%', $this->_parameters['test']['testsuite'], $testContent);
                        }
                        break;
                    case 'cs':
                        $contentSh = file_get_contents($this->_tplShDirPath.'/cs.tpl.sh');
                        $cbfContent = file_get_contents($this->_tplShDirPath.'/cbf.tpl.sh');
                        $std = 'PSR2';
                        if (
                            strpos($this->_parameters['cs']['standard'], 'PSR') !== null &&
                            strlen($this->_parameters['cs']['standard']) < 8
                            ) {
                            $std = $this->_parameters['cs']['standard'];
                        }

                        $cbfContent = str_replace('%%%standard%%%', $std, $cbfContent);
                        $contentSh = str_replace('%%%standard%%%', $std, $contentSh);
                        
                        $contentCbfSh .= $cbfContent;
                        $contentCbfSh .= file_get_contents($this->_tplShDirPath.'/footer.tpl.sh');
                        file_put_contents($this->_dirRoot.'assets/sh/one/cbf.sh', $contentCbfSh);
                        break;
                    default:
                        $contentSh = file_get_contents($this->_tplShDirPath.'/'.$idAnalyse.'.tpl.sh');
                        break;
                }
                                
                $contentGlobalSh .= $contentSh;
                
                $content = $this->getHeader();
                $content .= $contentSh;
                $content .= file_get_contents($this->_tplShDirPath.'/footer.tpl.sh');
                
                file_put_contents($this->_dirRoot.'assets/sh/one/'.$idAnalyse.'.sh', $content);
            }
        }        

        $contentGlobalSh .= file_get_contents($this->_tplShDirPath.'/footer.tpl.sh');
        file_put_contents($this->_paShPath, $contentGlobalSh);
    }
    
    private function getHeader()
    {
        if ($this->header == '') {
            $this->header = file_get_contents($this->_tplShDirPath.'/header.tpl.sh');
            $this->header = str_replace('%%%dir_src%%%', $this->_parameters['srcPath'], $this->header);
            $this->header = str_replace('%%%dir_pa%%%', $this->_parameters['paPath'], $this->header);
        }
        
        return $this->header;
    }
    
    private function creerScriptAnalyse($idAnalyse)
    {
        
    }

}