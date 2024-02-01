<?php

/*
----------------------------------
 ------  Created: 013124   ------
 ------  Austin Best	   ------
----------------------------------
*/

function str_contains_any(string $haystack, array $needles): bool
{
    return array_reduce($needles, fn($a, $n) => $a || str_contains($haystack, $n), false);
}
