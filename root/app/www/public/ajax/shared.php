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

$repository = $_POST['repository'];
$git        = new Git($repository);

if ($_POST['page'] != 'settings') {
    $repoObjects    = $git->size();
    $overview       = $git->log();
    $branches       = $git->branches();
    $contributors   = $git->contributors();
    $totalFiles     = $git->totalFiles();
    $totalCommits   = $git->totalCommits();
    $totalLines     = $git->totalLines();
    $branchHeads    = $git->branchHeads();
    $linesOfCode    = 0;
    $fileTypes      = [];

    foreach ($repoObjects['shell'] as $repoSizeObject) {
        if (str_contains($repoSizeObject, 'count') || str_contains($repoSizeObject, 'in-pack')) {
            $repoObjectCount += preg_replace("/[^0-9]/", '', $repoSizeObject);
        }
        if (str_contains($repoSizeObject, 'size') || str_contains($repoSizeObject, 'size-pack')) {
            $repoSizeTotal += preg_replace("/[^0-9]/", '', $repoSizeObject);
        }
    }
    $repoObjects    = number_format(intval($repoObjectCount));
    $repoSize       = byteConversion(intval($repoSizeTotal) * 1000);

    foreach ($totalLines['shell'] as $file) {
        $fileParts = array_filter(explode(' ', $file));
        sort($fileParts, SORT_NUMERIC);    
        $linesOfCode += intval($fileParts[1]);
    
        if (str_contains($fileParts[0], '.') && $fileParts[0][0] != '.' && !is_dir(ABSOLUTE_PATH . $repository . '.' . $fileParts[0][0])) {
            $filePathParts  = explode('.', $fileParts[0]);
            $extension      = trim(end($filePathParts));
    
            if (!in_array($extension, $ignoreCodePageExtensions) && !str_contains($extension, '/') && $extension) {
                $fileTypes[$extension]['files']++;
                $fileTypes[$extension]['lines'] += intval($fileParts[1]);
            }
        }
    }
}
