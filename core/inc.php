<?php

ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
//die($class);
    // project-specific namespace prefix
    $prefix = 'JD\\PhpProjectAnalyzer\\';

    // base directory for the namespace prefix
    $core_dir = __DIR__ . '/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $core_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        //die($file);
        require $file;
    }
});

// on charger les parametres
require 'lib/Spyc.php';


$parameters = spyc_load_file(__DIR__.'/param.yml');

// les libelles de l'appli
$availableLang = array('en', 'fr');
$lang = $parameters['lang'];
$lang = in_array($lang, $availableLang) ? $lang : 'en';
$labels = spyc_load_file(__DIR__.'/../translations/'.$lang.'.yml');
