<?php

use \mageekguy\atoum;

$projectName = 'Projet Redis';
$ccPath = '/home/jd/html/PhpProjectAnalyzer/reports/TEST/cc';
$tmPath = '/home/jd/html/PhpProjectAnalyzer/reports/TEST/tm';

// HTML
$coverageHtmlField = new atoum\report\fields\runner\coverage\html($projectName, $ccPath);
$coverageHtmlField->setRootUrl('http://localhost/PhpProjectAnalyzer/reports/TEST');

// Treemap (not mandatory)
$coverageTreemapField = new atoum\report\fields\runner\coverage\treemap($projectName, $tmPath);
$coverageTreemapField
	->setTreemapUrl('http://localhost/PhpProjectAnalyzer/reports/TEST/treemap')
	->setHtmlReportBaseUrl($coverageHtmlField->getRootUrl())
;

$script
	->addDefaultReport()
		->addField($coverageHtmlField)
		->addField($coverageTreemapField)
;
