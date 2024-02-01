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
