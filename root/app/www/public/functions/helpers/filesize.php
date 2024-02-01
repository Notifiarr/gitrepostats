<?php

/*
----------------------------------
 ------  Created: 013124   ------
 ------  Austin Best	   ------
----------------------------------
*/

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
