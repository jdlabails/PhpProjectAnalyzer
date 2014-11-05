<?php

/**
 * Classe basique regroupant les fonctions utilisées dans l'index
 *
 * @author Jean-David Labails <jd.labails@gmail.com>
 */
class projectAnalyser
{
    private $_parameters;
    private $_reportPath;

    public function __construct($_parameters)
    {
        $this->_parameters = $_parameters;
        $this->_reportPath = __DIR__.'/../../reports';
    }

    /**
     * Va chercher les param du fichier yml
     * @param string $name cle du param
     * @return string value du param
     */
    function getParam($name, $attr = '')
    {
        if (isset($this->_parameters[$name])) {
            if ($attr != '' && isset($this->_parameters[$name][$attr])) {
                return $this->_parameters[$name][$attr];
            }

            return $this->_parameters[$name];
        }

        return '';
    }

    /**
     * Renvoi vrai si la param est à true dans le yml
     * @param type $paramName
     * @return boolean
     */
    function isEnable($paramName, $explicit = false)
    {
        if ($explicit) {
            return $this->getParam($paramName, 'enable') === true;
        }
        return $this->getParam($paramName) === true;
    }

    function extractFromLoc($param)
    {
        return $this->extractFromXmlReport($param, '/LOC/phploc.xml');
    }

    /**
     * Recupere le contenu du rapport
     * @param string $file chemin du fichier
     * @return array($txt, $vide) contenu du rapport et boolean si vide ou pas
     */
    function getReport($file)
    {
        $txt = 'Aucun report généré :(';
        $vide = false;
        if (file_exists($file)) {

            $txt = file_get_contents($file);

            if (trim($txt) == '') {
                $vide = true;
                $txt = 'Rapport vide :D';
            } else {
                $txt .= '<br>';
            }
        }

        return array($txt, $vide);
    }

    /**
     * Recupere le contenu d'un count file
     * @param type $file
     * @return type
     */
    function getCountFile($file)
    {
        $path = $this->_reportPath.'/COUNT/'.$file;
        if (file_exists($path)) {
            $txt = file_get_contents($path);
        } else {
            $txt = '';
        }

        return trim($txt);
    }

    /**
     * Retourn une tableau associatif avec les comptage de fichiers
     * @return type
     */
    function getCount()
    {
        $res = array(
            'nbDossier' => $this->getCountFile('nbDossier.txt'),
            'nbFichier' => $this->getCountFile('nbFichier.txt'),
            'nbPHP' => $this->getCountFile('nbPHP.txt'),
            'nbTwig' => $this->getCountFile('nbTwig.txt'),
            'nbBundle' => $this->getCountFile('nbBundle.txt'),
        );

        $nbCSS = $this->getCountFile('nbCSS.txt');
        $nbLibCSS = $this->getCountFile('nbLibCSS.txt');
        $nbJS = $this->getCountFile('nbJS.txt');
        $nbLibJS = $this->getCountFile('nbLibJS.txt');

        $res['nbLibCSS']=$nbLibCSS;
        $res['nbCSS']=$nbCSS - $nbLibCSS;
        $res['nbLibJS']=$nbLibJS;
        $res['nbJS']=$nbJS - $nbLibJS;

        return $res;
    }

    /**
     * Renvoi la date de derniere modif du fichier
     * @param type $file
     * @return string
     */
    function getDateGeneration($file)
    {
        if (file_exists($file)) {
            return 'Généré le '.date('d/m/y à H:i', filemtime($file));
        } else {
            return 'Non généré';
        }
    }

    /**
     * Adapte le rapport phpunit pour mettre en vert le res
     * @param type $file
     * @return type
     */
    function adaptPhpUnitReport($file)
    {
        $txt = '<br>'.file_get_contents($file);
        $txt = str_replace('[30;42m', '<span style="color:green">', $txt);
        $txt = str_replace('[37;41m', '<span style="color:red">', $txt);
        $txt = str_replace('[31;1m', '<span style="">', $txt);
        $txt = str_replace('[41;37m', '<span style="">', $txt);
        $txt = str_replace('[0m', '</span>', $txt);
        return $txt;
    }

    /**
     * Extrait une info d'un xml et la renvoi
     * @param string $cle balise xml recherchee
     * @param string $reportFilePath chemin à l'intéreur du dossier report
     * @return string
     */
    function extractFromXmlReport($cle, $reportFilePath)
    {
        $file = $this->_reportPath.$reportFilePath;
        if (file_exists($file)) {
            $xml = simplexml_load_file($file);
            return $xml->$cle;
        } else {
            return '';
        }
    }

    function getQualityInfo()
    {
        return
            $this->analyseReport('CS') +
            $this->analyseReport('MD') +
            $this->analyseReport('CPD', false, '0.00% duplicated lines')
        ;
    }

    function analyseReport($prefix, $goodIfEmpty = true, $goodIfContains = '')
    {
        $res = array();
        $txt = '';
        $report = $this->_reportPath.'/'.$prefix.'/report.txt';
        if (file_exists($report)) {
            $txt = trim(file_get_contents($report));
        }

        $res[$prefix]=array('report'=>$txt, 'summary'=>'ko');

        if (($goodIfEmpty && $txt == '') || (!empty($goodIfContains) && strpos($txt, $goodIfContains) !== false) ) {
            $res[$prefix]['summary']='ok';
        }

        if ($prefix == 'MD') {
            $res['cc10']=substr_count($txt, 'has a Cyclomatic Complexity of');
        }

        return $res;
    }

    function afficheRapport($content)
    {
        switch ($content) {
            case '' :
                $txt = 'Rapport vide :D';
                break;
            case 'none':
                $txt = 'Aucun report généré :(';
                break;
            default :
                $txt = $content;
                break;
        }

        return $txt;
    }

    function afficheSummary ($summary)
    {
        switch ($summary) {
            case 'ok' :
                $txt = '<span class="badge alert-success">OK</span>';
                break;
            case 'ko':
                $txt = '<span class="badge alert-warning">KO</span>';
                break;
            default :
                $txt = '<span class="badge alert-warning">NC</span>';
                break;
        }

        return $txt;
    }

    function exploitTestReport()
    {
        $res = array(
            'ok'            => false,
            'nbTest'        => '/',
            'nbAssertions'  => '/',
            'date'  => '/',
            'exeTime'       => '/',
            'exeMem'        => '/',
            'dateTimeCC'    => '/',
            'coverage'      => '/',
            'ccClasse'      => '/',
            'ccMethod'      => '/',
            'ccLine'        => '/',
            'report'        => '',

        );

        $testReportFile = $this->_reportPath.'/TEST/report.txt';
        if (file_exists($testReportFile)) {
            $res['report'] = $this->adaptPhpUnitReport($testReportFile);
            $res['date']=date('d/m/y à H:i', filemtime($testReportFile));

            $lines = file($testReportFile);
            foreach ($lines as $l) {
                // si on est sur la ligne des metrique d'execution du test
                // Time: 6.8 minutes, Memory: 141.00Mb
                if (strpos($l, 'Time') !== false && strpos($l, 'Memory') !== false) {
                    list($t, $m) = explode(',', $l);
                    list($_, $res['exeTime']) = explode(':', $t);
                    list($_, $res['exeMem']) = explode(':', $m);
                }

                // [30;42mOK (40 tests, 123 assertions)[0m
                if (stripos($l, 'test') !== false && stripos($l, 'assertion') !== false) {

                    $res['ok'] = strpos($l, '[30;42mOK');

                    if ($res['ok']) {
                        list($t, $a) = explode(',', $l);

                        list($_, $nb) = explode('(', $t);
                        $res['nbTest'] = str_ireplace('tests', '', $nb);

                        list($nb, $_) = explode(')', $a);
                        $res['nbAssertions'] = str_ireplace('assertions', '', $nb);
                    } else {
                        list($t, $a, $_) = explode(',', $l);

                        list($_, $res['nbTest']) = explode(':', $t);

                        list($_,  $res['nbAssertions']) = explode(':', $a);
                    }
                }
            }
        }

        $covReportFile = $this->_reportPath.'/TEST/coverage.txt';
        if (file_exists($covReportFile)) {
            $res['dateTimeCC']=date('d/m/y à H:i', filemtime($covReportFile));

            $lines = file($covReportFile);
            foreach ($lines as $k=>$v) {
                if (strpos($v, 'Summary:') !== false) {
                    list($_, $res['ccClasse']) = explode(':', $lines[$k+1]);
                    list($_, $res['ccMethod']) = explode(':', $lines[$k+2]);
                    list($_, $res['ccLine']) = explode(':', $lines[$k+3]);
                    list($res['ccLine'], $_) = explode('(', $res['ccLine']);

                    break;
                }
            }
        }

        $cmdFile = $this->_reportPath.'/TEST/cmd.txt';
        if (file_exists($cmdFile)) {
            $res['cmd']=  file_get_contents($cmdFile);
        }

        return $res;
    }

    function getReportInfo()
    {
        $tabReports = array('MD', 'CS', 'CPD', 'DEPEND', 'LOC', 'DOCS');

        foreach ($tabReports as $report) {
            list($reportTxt, $vide) = $this->getReport($this->_reportPath.'/'.$report.'/report.txt');
            $res[$report] = array(
                'date'      => $this->getDateGeneration($this->_reportPath.'/'.$report.'/report.txt'),
                'report'    => $reportTxt,
                'ok'        => $vide
            );

            if ($report == 'CPD') {
                $res[$report]['ok'] = strpos($reportTxt, '0.00% duplicated lines') !== false;
            }

            $cmdFile = $this->_reportPath.'/'.$report.'/cmd.txt';
            $res[$report]['cmd']='';
            if (file_exists($cmdFile)) {
                $res[$report]['cmd']=  file_get_contents($cmdFile);
            }
        }

        return $res;
    }

    function getAnalyseInfo()
    {
        $file = __DIR__.'/../../jetons/timeAnalyse';
        $res = array('date'=>'/', 'time'=>'/', 'mem'=>'/');
        if (file_exists($file)) {
            $res ['date']=date('d/m/y à H:i', filemtime($file));
            $res['time']=  file_get_contents($file);
        }

        return $res;
    }
}