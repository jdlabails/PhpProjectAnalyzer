<?php

/**
 * Classe basique regroupant les fonctions utilisées dans l'index
 *
 * @author Jean-David Labails <jd.labails@gmail.com>
 */
class projectAnalyser
{
    private $_dirRoot;
    private $_parameters;
    private $_reportPath;
    private $_labels;

    private $oAnalyze;

    public function __construct()
    {
        $this->_dirRoot = __DIR__.'/../../';
        $this->_reportPath = $this->_dirRoot.'reports';

        $this->_parameters = Spyc::YAMLLoad($this->_dirRoot.'assets/param.yml');

        $availableLang = array('en', 'fr');
        $lang = $this->getParam('lang');
        $lang = in_array($lang, $availableLang) ? $lang : 'en';
        $this->_labels = Spyc::YAMLLoad('assets/translations/'.$lang.'.yml');

        $this->oAnalyze = new analyze();
        $this->oAnalyze
            ->setLangue($this->_parameters['lang'])
            ->setNbNamespace($this->extractFromLoc('namespaces'))
            ->setNbClasses($this->extractFromLoc('classes'))
            ->setNbMethod($this->extractFromLoc('methods'))
            ;

        $this->getCount();
        $this->getAnalyseInfo();
    }

    /**
     * Retourne l'objet analyse
     * @return analyze
     */
    public function getAnalyze()
    {
        if ($this->isEnableHisto()) {
            $this->historise();
        }
        return $this->oAnalyze;
    }

    /**
     * Retourne l'objet analyse
     * @return analyze
     */
    public function getAnalyses()
    {
        $res = array();
        $fileName = $this->_dirRoot.'reports/HISTORIQUE/'.date('ym').'.json';
        $string = file_get_contents($fileName);
        $tab = json_decode($string, true);

        foreach ($tab as $t) {
            $a = new analyze();
            $a->setFromArray($t);
            $res []=$a;
        }

        return $res;
    }

    public function isEnableHisto()
    {
        return $this->isEnable('histo', true);
    }

    public function historise()
    {
        $fileName = $this->_dirRoot.'reports/HISTORIQUE/'.date('ym').'.json';
        $stream = fopen($fileName, 'w+');

        $string = file_get_contents($fileName);

        $tab = json_decode($string, true);

        if ( $tab != null && !key_exists($this->oAnalyze->getDateTimeUTC(), $tab)) {
            $tab += array($this->oAnalyze->getDateTimeUTC() => $this->oAnalyze);
        } elseif ($tab == null) {
            $tab = array($this->oAnalyze->getDateTimeUTC() => $this->oAnalyze);
        }

        if (!empty($tab)) {
            if ($this->getParam('histo', 'jsonPretty') == 'true') {
                fwrite($stream, json_encode($tab, JSON_PRETTY_PRINT));
            } else {
                fwrite($stream, json_encode($tab));
            }
        }
    }

    /**
     * Gestion de la trad
     * @param string $label
     * @return string
     */
    public function getLabel($label)
    {
        return key_exists($label, $this->_labels) ? $this->_labels[$label] : $label;
    }

    /**
     * Vérifie si une analyse est en cours par présence du jeton
     * @return type
     */
    public function isAnalyzeInProgress()
    {
        return file_exists($this->_dirRoot.'jetons/jetonAnalyse');
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
        $txt = $this->getLabel('details.noReport').' :(';
        $vide = false;
        if (file_exists($file)) {

            $txt = file_get_contents($file);

            if (trim($txt) == '') {
                $vide = true;
                $txt = $this->getLabel('details.emptyReport').' :D';
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
            'nbDossier'     => $this->getCountFile('nbDossier.txt'),
            'nbFichier'     => $this->getCountFile('nbFichier.txt'),
            'nbPHP'         => $this->getCountFile('nbPHP.txt'),
            'nbTwig'        => $this->getCountFile('nbTwig.txt'),
            'nbBundle'      => $this->getCountFile('nbBundle.txt'),
        );

        $nbCSS = $this->getCountFile('nbCSS.txt');
        $nbLibCSS = $this->getCountFile('nbLibCSS.txt');
        $nbJS = $this->getCountFile('nbJS.txt');
        $nbLibJS = $this->getCountFile('nbLibJS.txt');

        $res['nbLibCSS']=$nbLibCSS;
        $res['nbCSS']=$nbCSS - $nbLibCSS;
        $res['nbLibJS']=$nbLibJS;
        $res['nbJS']=$nbJS - $nbLibJS;

        $this->oAnalyze
            ->setNbDir($res['nbDossier'])
            ->setNbBundles($res['nbBundle'])
            ->setNbFile($res['nbFichier'])
            ->setNbPhpFile($res['nbPHP'])
            ->setNbTwig($res['nbTwig'])
            ->setNbCSSFile($res['nbCSS'])
            ->setNbCSSLib($res['nbLibCSS'])
            ->setNbJSFile($res['nbJS'])
            ->setNbJSLib($res['nbLibJS'])
            ;

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
            return $this->getLabel('details.generatedOn').' '.$this->getReadableDateTime(filemtime($file));
        } else {
            return $this->getLabel('details.notGenerated');
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
        $csAnalyse = $this->analyseReport('CS');
        $this->oAnalyze->setCsSuccess($csAnalyse['CS']['summary']==='ok');

        return
            $csAnalyse +
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
            $res['date']=$this->getReadableDateTime(filemtime($testReportFile));

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

                    $res['ok'] = strpos($l, '[30;42mOK') !== false;

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
            $res['dateTimeCC']=$this->getReadableDateTime(filemtime($covReportFile));

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

        $this->oAnalyze
            ->setTuSuccess($res['ok'])
            ->setCov($res['coverage'])
            ;

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
        $file = $this->_dirRoot.'jetons/timeAnalyse';
        if (file_exists($file)) {
            $this->oAnalyze
                ->setDateTime(filemtime($file))
                ->setExecTime((int)file_get_contents($file))
            ;
        }
    }


    public function isScoreEnable()
    {
        return $this->getParam('score', 'enable') == 'true';
    }

    /**
     * 20/20 serait donné à un projet de 100kLoc tester à 100% avec CS ok
     * @param type $q_info
     * @param type $t_info
     * @todo les pondérations pourraient être en param.yml, notament celle sur loc
     * @return type
     */
    function getNote($q_info, $t_info)
    {
        if ( ! $this->isScoreEnable()) {
            return 0;
        }

        $loc    = $this->extractFromLoc('loc');
        $this->oAnalyze->setLoc((int)$loc);
        $cs     = (int)$q_info['CS']['summary'] == 'ok';
        $test   = (int)$t_info['ok'];
        $cc     = (int)str_replace('%', '', $t_info['ccLine']);

        $csWeight       = $this->getScoreWeightParam('csWeight');
        $testWeight     = $this->getScoreWeightParam('testWeight');
        $locWeight      = $this->getScoreWeightParam('locWeight');

        $projectSize    = $this->getParam('score', 'projectSize');
        $maxSize = 50000;
        switch ($projectSize) {
            case 'small' :
                $maxSize = 10000;
                break;
            default:
            case 'medium':
                $maxSize = 50000;
                break;
            case 'big':
                $maxSize = 100000;
                break;
        }

        $note = $cs*$csWeight + $test*$testWeight*($cc/100) + $loc*$locWeight/$maxSize;
        $divide = ($csWeight + $testWeight + $locWeight) / 20;

        $score = round(($note/$divide), 2);

        $this->oAnalyze->setScore($score);

        return $score;
    }

    function getScoreWeightParam($name)
    {
        $weight = $this->getParam('score', $name);
        if ( ! is_int($weight)) {
            return 100;
        }

        if ($weight < 0 || $weight > 100) {
            return 100;
        }

        return $weight;
    }

    /**
     * Retourne une date lisible formaté selon la langue
     * @param datetime $dt
     * @return string
     */
    function getReadableDateTime($dt)
    {
        if ($this->_parameters['lang'] == 'fr') {
            return date('d/m/y à H:i', $dt);
        } else {
            return date('Y-m-d H:i', $dt);
        }
    }
}