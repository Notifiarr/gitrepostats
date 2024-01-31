<?php

/*
----------------------------------
 ------  Created: 012824   ------
 ------  Austin Best	   ------
----------------------------------
*/

if (file_exists('loader.php')) {
    define('ABSOLUTE_PATH', './');
}
if (file_exists('../loader.php')) {
    define('ABSOLUTE_PATH', '../');
}
if (file_exists('../../loader.php')) {
    define('ABSOLUTE_PATH', '../../');
}
require ABSOLUTE_PATH . 'loader.php';

$repository         = $_POST['repository'];
$git                = new Git($repository);
$repoSize           = $git->size();
$overview           = $git->log();
$branches           = $git->branches();
$contributors       = $git->contributors();
$totalFiles         = $git->totalFiles();
$totalCommits       = $git->totalCommits();
$totalLines         = $git->totalLines();
$branchHeads        = $git->branchHeads();
$linesOfCode        = 0;
$fileTypes          = [];

list($objects, $size) = explode(',', $repoSize['shell'][0]);
$repoObjects    = preg_replace("/[^0-9]/", '', $objects);
$repoSize       = trim($size);

foreach ($totalLines['shell'] as $file) {
    $fileParts = array_filter(explode(' ', $file));
    sort($fileParts, SORT_NUMERIC);    
    $linesOfCode += intval($fileParts[1]);

    if (str_contains($fileParts[0], '.') && $fileParts[0][0] != '.' && !is_dir(ABSOLUTE_PATH . $repository . '.' . $fileParts[0][0])) {
        $filePathParts  = explode('.', $fileParts[0]);
        $extension      = trim(end($filePathParts));

        if (!str_contains($extension, '/') && $extension) {
            $fileTypes[$extension]['files']++;
            $fileTypes[$extension]['lines'] += intval($fileParts[1]);
        }
    }
}
