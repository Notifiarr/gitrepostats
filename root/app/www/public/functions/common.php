<?php

/*
----------------------------------
 ------  Created: 012724   ------
 ------  Austin Best	   ------
----------------------------------
*/

function startup()
{
    if (!file_exists(SETTINGS_FILE)) {
        file_put_contents(SETTINGS_FILE, '{}');
    }

    createDirectoryTree(REPOSITORY_PATH);
}

function createDirectoryTree($tree)
{
    system('mkdir -p ' . $tree);
}

function getRepositoryList()
{
    $repositories = [];

    if (!is_dir(REPOSITORY_PATH)) {
        return $repositories;
    }

    $dir = opendir(REPOSITORY_PATH);
    while ($repository = readdir($dir)) {
        if ($repository[0] == '.' || !is_dir(REPOSITORY_PATH . $repository)) {
            continue;
        }

        if (!is_dir(REPOSITORY_PATH . $repository . '/.git')) {
            continue;
        }

        $repositories[] = REPOSITORY_PATH . $repository;
    }
    closedir($dir);

    sort($repositories);
    return $repositories;
}

function randomColor($existingColors)
{
    $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

    if (in_array($color, $existingColors)) {
        return randomColor($existingColors);
    } else {
        return $color;
    }
}

function byteConversion($bytes, $measurement = false, $dec = 2)
{
    if (!$bytes || $bytes <= 0) {
        return 0;
    }

    //-- SEND LARGEST ONE
    if (!$measurement) {
        $units  = ['B', 'KiB', 'MiB', 'GiB', 'TiB'];
        $bytes  = max($bytes, 0);
        $pow    = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow    = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $dec) . ' ' . $units[$pow];
    }

    switch ($measurement) {
        case 'KiB':
            return round($bytes / 1024, $dec);
        case 'MiB':
            return round($bytes / pow(1024, 2), $dec);
        case 'GiB':
            return round($bytes / pow(1024, 3), $dec);
        case 'TiB':
            return round($bytes / pow(1024, 4), $dec);
    }
}
