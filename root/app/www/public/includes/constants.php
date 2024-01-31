<?php

/*
----------------------------------
 ------  Created: 012724   ------
 ------  Austin Best	   ------
----------------------------------
*/

define('APP_DATA_PATH', '/config/');
define('SETTINGS_FILE', APP_DATA_PATH . 'settings.json');

$ignoreCodePageExtensions   = ['txt', 'json', 'yml', 'tgz', 'zip', 'sql'];
$ignoreDirectories          = ['assets', 'vendor', 'libraries', 'node_modules'];
