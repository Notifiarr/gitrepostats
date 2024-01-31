<?php

/*
----------------------------------
 ------  Created: 012724   ------
 ------  Austin Best	   ------
----------------------------------
*/

// This will NOT report uninitialized variables
error_reporting(E_ERROR | E_PARSE);

if (!defined('ABSOLUTE_PATH')) {
    if (file_exists('loader.php')) {
        define('ABSOLUTE_PATH', './');
    }
    if (file_exists('../loader.php')) {
        define('ABSOLUTE_PATH', '../');
    }
    if (file_exists('../../loader.php')) {
        define('ABSOLUTE_PATH', '../../');
    }
}

//-- INCLUDE DEFINES
require ABSOLUTE_PATH . 'includes/constants.php';

//-- GRAB SETTINGS FILE DATA
$settings = json_decode(file_get_contents(SETTINGS_FILE), true);
if ($settings['global']['repositoryPath']) {
    if (substr($settings['global']['repositoryPath'], -1) != '/') {
        $settings['global']['repositoryPath'] .= '/';
    }
}
define('REPOSITORY_PATH', ($settings['global']['repositoryPath'] ? $settings['global']['repositoryPath'] : '/config/repositories/'));
$ignoreCodePageExtensions   = $settings['pages']['code']['ignoreExtension'] ? explode(',', str_replace(' ', '', $settings['pages']['code']['ignoreExtension'])) : $ignoreCodePageExtensions;
$ignoreDirectories          = $settings['global']['ignoreDirectories'] ? explode(',', str_replace(' ', '', $settings['global']['ignoreDirectories'])) : $ignoreDirectories;

//-- INCLUDE FUNCTIONS
$dir = ABSOLUTE_PATH . 'functions';
$handle = opendir($dir);
while ($file = readdir($handle)) {
    if ($file[0] != '.' && !is_dir($dir . '/' . $file)) {
        require $dir . '/' . $file;
    }
}
closedir($handle);

//-- INCLUDE CLASSES
$dir = ABSOLUTE_PATH . 'classes';
$handle = opendir($dir);
while ($file = readdir($handle)) {
    if ($file[0] != '.' && !is_dir($dir . '/' . $file)) {
        require $dir . '/' . $file;
    }
}
closedir($handle);

startup();
$repositories = getRepositoryList();
