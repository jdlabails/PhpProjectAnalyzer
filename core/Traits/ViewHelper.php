<?php

namespace JD\PhpProjectAnalyzer\Traits;

/**
 * Visualization Helper
 *
 * Only for projectAnalyzer class because $this has to be one of its object
 *
 * @author Jean-David Labails <jd.labails@gmail.com>
 */
trait ViewHelper
{
    /**
     * Return ok or ko according the analysis result
     *
     * @param string $summary
     *
     * @return string
     */
    public static function afficheSummary($summary)
    {
        switch ($summary) {
            case 'ok':
                $txt = '<span class="badge alert-success value">OK</span>';
                break;
            case 'ko':
                $txt = '<span class="badge alert-warning value">KO</span>';
                break;
            default:
                $txt = '<span class="badge alert-warning value">NC</span>';
                break;
        }

        return $txt;
    }

    /**
     * Adapt the phpunit report to html
     *
     * @param string $file path to the phpunit report
     *
     * @return string
     */
    static public function adaptPhpUnitReport($file)
    {
        $txt = file_get_contents($file);
        $txt = str_replace('[30;42m', '<span style="color:green">', $txt);
        $txt = str_replace('[37;41m', '<span style="color:red">', $txt);
        $txt = str_replace('[31;1m', '<span style="">', $txt);
        $txt = str_replace('[41;37m', '<span style="">', $txt);
        $txt = str_replace('[0m', '</span>', $txt);

        return $txt;
    }

    /**
     * Return a formated date
     *
     * @param int $dt
     *
     * @return string
     */
    public function getReadableDateTime($dt)
    {
        if ($this->parameters['lang'] == 'fr') {
            return date('d/m/Y à H:i', $dt);
        }

        return date('Y-m-d H:i', $dt);
    }

    /**
     * Translation
     *
     * @param string $label
     *
     * @return string
     */
    public function getLabel($label)
    {
        return key_exists($label, $this->labels) ? $this->labels[$label] : $label;
    }
}
