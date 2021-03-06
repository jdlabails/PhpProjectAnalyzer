<?php

/**
 * Description of scriptBuilder
 *
 * @author jd
 */
trait scriptBuilder
{
    private $header         = '';

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
                        if ($param['lib'] == 'phpunit'){
                            $contentSh = file_get_contents($this->_tplShDirPath.'/testPhpUnit.tpl.sh');
                            $contentSh = str_replace('%%%testsuite%%%', $param['phpunitTestSuite'], $contentSh);
                        }
                        if ($param['lib'] == 'atoum'){
                            $contentSh = file_get_contents($this->_tplShDirPath.'/testAtoum.tpl.sh');
                            $contentSh = str_replace('%%%pathAtoum%%%', $param['atoumPath'], $contentSh);
                            $contentSh = str_replace('%%%dirTestAtoum%%%', $param['atoumTestDir'], $contentSh);
                            // modif atoum.cc.php
                            $contentAtoumCC = file_get_contents($this->_phpDirPath.'/atoum.cc.tpl.php');
                            $contentAtoumCC = str_replace('%%%projectName%%%', $param['title'], $contentAtoumCC);
                            $contentAtoumCC = str_replace('%%%ppaPath%%%', $this->_dirRoot, $contentAtoumCC);
                            
                            file_put_contents($this->_dirRoot.'assets/php/atoum.cc.php', $contentAtoumCC);
                        }
                        break;
                    case 'cs':
                        $contentSh = file_get_contents($this->_tplShDirPath.'/cs.tpl.sh');
                        $cbfContent = file_get_contents($this->_tplShDirPath.'/cbf.tpl.sh');
                        $std = 'PSR2';
                        if (
                            strpos($param['standard'], 'PSR') !== null &&
                            strlen($param['standard']) < 8
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

    private function getHeader()
    {
        if ($this->header == '') {
            $this->header = file_get_contents($this->_tplShDirPath.'/header.tpl.sh');
            $this->header = str_replace('%%%dir_src%%%', $this->_parameters['srcPath'], $this->header);
            $this->header = str_replace('%%%dir_pa%%%', __DIR__.'/../../', $this->header);
        }

        return $this->header;
    }

    private function creerScriptAnalyse($idAnalyse)
    {

    }

}