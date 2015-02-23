<?php

use \mageekguy\atoum;

$projectName = '%%%projectName%%%';
$ccPath = '%%%ppaPath%%%/reports/TEST/cc';
$tmPath = '%%%ppaPath%%%/reports/TEST/tm';

// HTML
$coverageHtmlField = new atoum\report\fields\runner\coverage\html($projectName, $ccPath);
//$coverageHtmlField->setRootUrl('http://localhost/PhpProjectAnalyzer/reports/TEST');

// Treemap (not mandatory)
$coverageTreemapField = new atoum\report\fields\runner\coverage\treemap($projectName, $tmPath);
$coverageTreemapField
	//->setTreemapUrl('http://localhost/PhpProjectAnalyzer/reports/TEST/treemap')
	->setHtmlReportBaseUrl($coverageHtmlField->getRootUrl())
;

$script
	->addDefaultReport()
		->addField($coverageHtmlField)
		->addField($coverageTreemapField)
;
