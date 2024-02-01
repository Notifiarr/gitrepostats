<?php

/*
----------------------------------
 ------  Created: 013124   ------
 ------  Austin Best	   ------
----------------------------------
*/

function array_sort_by_key(&$array, $field, $direction = 'asc')
{
    if (!is_array($array)) {
        return $array;
    }

    uasort($array, function ($a, $b) use ($field, $direction) {
        if ($direction == 'asc') {
            return $a[$field] <=> $b[$field];
        } else {
            return $b[$field] <=> $a[$field];
        }
    });
}
