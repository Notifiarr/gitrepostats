<?php

/*
----------------------------------
 ------  Created: 012724   ------
 ------  Austin Best	   ------
----------------------------------
*/

// This will NOT report uninitialized variables
error_reporting(E_ERROR | E_PARSE);

//-- DETERMINE LOCATION
if (file_exists('loader.php')) {
    define('RELATIVE_PATH', './');
} elseif (file_exists('../loader.php')) {
    define('RELATIVE_PATH', '../');
} elseif (file_exists('../../loader.php')) {
    define('RELATIVE_PATH', '../../');
}

//-- INCLUDE DEFINES
require RELATIVE_PATH . 'includes/constants.php';

//-- INCLUDE FUNCTIONS
$dir = RELATIVE_PATH . 'functions';
$handle = opendir($dir);
while ($file = readdir($handle)) {
    if ($file[0] != '.' && !is_dir($dir . '/' . $file)) {
        require $dir . '/' . $file;
    }
}
closedir($handle);

//-- INCLUDE CLASSES
$dir = RELATIVE_PATH . 'classes';
$handle = opendir($dir);
while ($file = readdir($handle)) {
    if ($file[0] != '.' && !is_dir($dir . '/' . $file)) {
        require $dir . '/' . $file;
    }
}
closedir($handle);

$repositories = getRepositoryList();
